<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;
use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Listings\Columns\Image;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\Filters\QuickFilter;
use A17\Twill\Services\Listings\Filters\QuickFilters;
use A17\Twill\Services\Listings\TableColumns;
use App\Http\Resources\ColorResource;
use App\Jobs\ChangeAccessibilityOnGroupProducts;
use App\Jobs\RecalculateFlowersJob;
use App\Models\Market;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\Remain;
use App\Models\Revisions\ProductPriceRevision;
use App\Repositories\ProductPriceRepository;
use App\Repositories\ProductRepository;
use App\Services\Market\ExcelPriceExport;
use App\Services\ProductCopyService;
use Illuminate\Contracts\View\View as IlluminateView;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends BaseModuleController
{
    protected $moduleName = 'products';

    public function publish(): JsonResponse
    {
        // $data['id'] - Product->id
        try {
            $data = $this->validate($this->request, [
                'id' => 'integer|required',
                'active' => 'bool|required',
            ]);

            $item = $this->repository->getById($data['id']);


            if (
                $this->repository->updateBasic($data['id'], [
                    'published' => !$data['active'],
                ])
            ) {
                activity()->performedOn(
                    $item
                )->log(
                    ($this->request->get('active') ? 'un' : '') . 'published'
                );

                $this->fireEvent();


                Product::flushQueryCache();

                ProductRepository::changeAccessibilityOnGroupProducts(Product::where('id', $data['id'])->first(), auth()->user()->getMarketId());

                if ($data['active']) {
                    return $this->respondWithSuccess(
                        twillTrans('Товара нет в наличии', ['modelTitle' => $this->modelTitle])
                    );
                }

                return $this->respondWithSuccess(
                    twillTrans('Товар в наличии', ['modelTitle' => $this->modelTitle])
                );
            }
        } catch (\Exception $e) {
            \Log::channel('marketplace')->error($e);
        }

        return $this->respondWithError(
            twillTrans('twill::lang.listing.publish.error', ['modelTitle' => $this->modelTitle])
        );
    }

    /**
     * История изменений
     *
     * @return void
     */
    public function history(Product $product)
    {



        $product->load('prices');
        $product->load('skus');
        $prices = $product->prices()->currentMarketProductPrice()->orderBy('quantity_from', 'asc')->get();



        $tabs = $prices->map(function ($e) {
            return ['name' => 'quantity_' . (int)$e->quantity_from, 'label' => 'от ' . $e->quantity_from . ' шт'];
        });

        return view('site.productPriceHistory')
            ->with('prices', $prices)
            ->with('product', $product)
            ->with('tabs', $tabs)
            ->with('skus', $product->skus);
    }

    public function copy(Product $product)
    {


        $markets = Market::query()
            ->get()
            ->filter(fn ($market) => $market->isActive());

        if (request()->method() === 'POST') {
            $result = app(ProductCopyService::class)->copyProductsToMarkets(
                request('ids'),
                request('market_ids'),  $this->getRepository()
            );

            return view('site.productCopyResult', compact('result'));
        }


        return view('site.productCopy', compact('product', 'markets'));
    }


    /**
     * Изменить стоимость
     *
     * @return void
     */
    public function changePrice()
    {
       // abort_unless(\Gate::allows('edit-module', 'products'), 403);

        $data = $this->validate($this->request, [
            'id' => 'integer|required',
            'price' => 'numeric|nullable',
        ]);

        $price = ProductPrice::where('id', $data['id'])->first();

        //abort_unless(\Gate::allows('edit', $price), 403);

        $repository = new ProductPriceRepository(new ProductPrice);
        $repository->update($data['id'], ['price' => $data['price']]);
    }

    /**
     * This method can be used to enable/disable defaults. See setUpController in the docs for available options.
     */
    protected function setUpController(): void
    {
        $this->modelTitle = 'Товар';
        $this->labels['listing.filter.all-items'] = __('Все');
        $this->labels['listing.filter.draft'] = __('Нет в наличии');
        $this->setSearchColumns(['title', 'id']);
        $this->setTitleColumnKey('title');
        $this->enableSkipCreateModal();
        $this->enableReorder();
        $this->disablePermalink();
    }

    protected function createRemainsIfNotExist()
    {
        if ($marketId = auth('twill_users')->user()->getMarketId()) {

            $products = Product::dontCache()->whereDoesntHave('remains', function ($q) use ($marketId) {
                return $q->where('market_id', $marketId);
            })->get();

            $inserts = [];
            foreach ($products as $product) {
                $inserts[] = [
                    'product_id' => $product->id,
                    'created_at' => \now(),
                    'market_id' => $marketId,
                    'published' => false,
                ];
            }
            Remain::insert($inserts);
            Remain::flushQueryCache();
        }
    }

    protected function createPricesIfNotExist()
    {
        if ($marketId = auth('twill_users')->user()->getMarketId()) {

            $products = Product::dontCache()->whereDoesntHave('prices', function ($q) use ($marketId) {
                return $q->where('market_id', $marketId);
            })->get();

            $inserts = [];
            $market = \App\Models\Market::find($marketId);
            foreach ($products as $product) {
                foreach ([1, 9, 15, 25, 51] as $count) {

                    $marketName = $market?->name ?? '';
                    $regionName = $market?->city?->province?->geoname_name ?? '';
                    $cityName = $market?->city?->city ?? '';
                    $sku = \App\Services\CatalogService::generateSku(
                        \Str::slug(mb_strtolower($marketName), true),
                        $regionName,
                        \Str::slug($cityName, true),
                        $marketId,
                        $product->id
                    );
                    $sku .= '-' . $count.'-'.$product->id; // <-- делаем уникальным для каждой quantity_from

                    $inserts[] = [
                        'product_id' => $product->id,
                        'created_at' => \now(),
                        'market_id' => $marketId,
                        'published' => true,
                        'quantity_from' => $count,
                        'sku' => $sku,
                    ];
                }
            }

            ProductPrice::insert($inserts);
        }
    }

    public function list()
    {


        $this->createRemainsIfNotExist();
        $this->createPricesIfNotExist();

        return $this->index();
    }

    /**
     * @return IlluminateView|JsonResponse
     */
    public function index(?int $parentModuleId = null): mixed
    {
        $this->createRemainsIfNotExist();
        $this->createPricesIfNotExist();

        return parent::index($parentModuleId);
    }

    public function update(int|TwillModelContract $id, ?int $submoduleId = null): JsonResponse
    {


        return parent::update($id, $submoduleId);
    }

    public function edit(TwillModelContract|int $id): mixed
    {

        return parent::edit($id);
    }

    /**
     * Быстрый фильтр на панели
     */
    public function quickFilters(): QuickFilters
    {
        $scope = ($this->submodule ? [
            $this->getParentModuleForeignKey() => $this->submoduleParentId,
        ] : []);

        $filter = [];
        $filter[] = QuickFilter::make()
            ->label('В наличии')
            ->queryString('inStock')
            ->amount(fn() => $this->repository->filter($this->repository->getBaseModel())->inStock()->count())
            ->scope('inStock');

        $filter[] = QuickFilter::make()
            ->label($this->getTransLabel('listing.filter.draft'))
            ->queryString('draft')
            ->scope('draft')
            ->amount(fn() => $this->repository->filter($this->repository->getBaseModel())->draft()->count())
            ->onlyEnableWhen($this->getIndexOption('publish'));

        $filter[] = QuickFilter::make()
            ->label($this->getTransLabel('listing.filter.all-items'))
            ->queryString('all');


        if (auth()->user()->can('is_owner')) {

            $filter[] = QuickFilter::make()
                ->label(twillTrans('twill::lang.listing.filter.trash'))
                ->queryString('trash')
                ->scope('onlyTrashed')
                ->onlyEnableWhen(auth()->user()->can('is_owner'))
                ->amount(fn() => $this->repository->filter($this->repository->getBaseModel())->onlyTrashed()->count());
        }

        return QuickFilters::make(
            $filter
        );
    }

    /**
     * Дополнительные поля в списке
     */
    protected function getIndexTableColumns(): TableColumns
    {
        $table = parent::getIndexTableColumns();

        // У флориста не показывается статус публикации и количество элементов = 1
        $table->get($table->count() == 1 ? 0 : 1)->title('Название')->sortable(false);

        $after = $table->splice(1);

        $after->push(
            Text::make()->field('colors')->title(__('Цвет'))->renderHtml(true)->customRender(
                function ($model) {
                    $skus = $model->skus;

                    if ($skus->count() > 0) {
                        return view('twill.customrender.colors', ['skus' => $skus])->render();
                    }

                    return '';
                }
            )
        );

        $table->prepend(
            Image::make()->field('preview')->title(__('Изображение'))->rounded()->optional()
        );

        $after->push(
            Text::make()->field('prices_0')->title(__('От 1 шт / ₽ '))->renderHtml(true)->customRender(
                function ($model) {
                    $_prices = ProductPrice::where(['quantity_from' => 1])->whereMarketIdAndProductId(auth()->user()->getMarketId(), $model->id)->first();

                    return $_prices ? view('twill.customrender.prices', ['price' => $_prices])->render() : '';
                }
            )->optional()
        );

        $after->push(
            Text::make()->field('prices1')->title(__('От 9 шт / ₽ '))->renderHtml(true)->customRender(function ($model) {
                $_prices = $model->prices()->where(['quantity_from' => 9])->whereMarketIdAndProductId(auth()->user()->getMarketId(), $model->id)->first();

                return $_prices ? view('twill.customrender.prices', ['price' => $_prices])->render() : '';
            })->optional()
        );

        $after->push(
            Text::make()->field('prices2')->title(__('От 15 шт / ₽ '))->renderHtml(true)->customRender(function ($model) {
                $_prices = $model->prices()->where(['quantity_from' => 15])->whereMarketIdAndProductId(auth()->user()->getMarketId(), $model->id)->first();

                return $_prices ? view('twill.customrender.prices', ['price' => $_prices])->render() : '';
            })->optional()
        );

        $after->push(
            Text::make()->field('prices3')->title(__('От 25 шт / ₽ '))->renderHtml(true)->customRender(function ($model) {
                $_prices = $model->prices()->where(['quantity_from' => 25])->whereMarketIdAndProductId(auth()->user()->getMarketId(), $model->id)->first();

                return $_prices ? view('twill.customrender.prices', ['price' => $_prices])->render() : '';
            })->optional()
        );

        $after->push(
            Text::make()->field('prices4')->title(__('От 51 шт / ₽ '))->renderHtml(true)->customRender(function ($model) {
                $_prices = $model->prices()->where(['quantity_from' => 51])->whereMarketIdAndProductId(auth()->user()->getMarketId(), $model->id)->first();

                return $_prices ? view('twill.customrender.prices', ['price' => $_prices])->render() : '';
            })->optional()
        );

        if (auth()->user()->can('edit-module', 'products')) {
            $after->push(
                Text::make()->field('history')->title(__('История изменений'))->renderHtml(true)->customRender(function ($model) {
                    $link = route('twill.history.product.price', ['product' => $model->id]);

                    return '<a href="' . $link . '" target="_blank">Открыть</a>';
                })->optional()
            );
        }

        if ( auth()->user()->market_id==1) {
            $after->push(
                Text::make()->field('copy')->title(__('Копировать'))->renderHtml(true)->customRender(function ($model) {
                    $link = route('twill.copy.product', ['product' => $model->id]);

                    return '<a href="' . $link . '" target="_blank">Копировать</a>';
                })->optional()
            );
        }

        return $table->merge($after);
    }

    public function getBrowserData($prependScope = []): array
    {
        $data = parent::getBrowserData($prependScope);

        $repository = $this->getRepository();
        foreach ($data['data'] as $key => $productArr) {
            $product = $repository->getById($productArr['id']);

            // Исключим из поиска


            $data['data'][$key]['prices'] = ColorResource::collection($product->prices()->currentMarketProductPrice()->get());
            if (!$product->published) {
                $data['data'][$key]['name'] .= '  (Нет в наличии)';
            }
        }
        $data['data'] = array_values($data['data']);

        return $data;
    }

    protected function getIndexData(array $prependScope = []): array
    {
        $data = parent::getIndexData($prependScope);

        foreach ($data['tableData'] as $i => $item) {
            if (
                !auth()
                    ->user()
                    ->can('update', $product = Product::where('id', $item['id'])->first())
            ) {
                $data['tableData'][$i]['title'] = $product->title ?? '';
                $data['tableData'][$i]['edit'] = false;
            }
        }

        return $data;
    }

    public function additionalTableActions()
    {
        if (auth()->user()->can('edit-module', 'products')) {
            return [
                'exportAction' => [
                    // Action name.
                    'name' => 'Выгрузить прайс',
                    // Button action title.
                    'variant' => 'primary',
                    // Button style variant. Available variants; primary, secondary, action, editor, validate, aslink, aslink-grey, warning, ghost, outline, tertiary
                    'size' => 'small',
                    // Button size. Available sizes; small
                    'link' => \URL::signedRoute('twill.products.export', ['market_id' => auth()->user()->getMarketId()]),
                    // Button action link.
                    'target' => '_blank',
                    // Leave it blank for self.
                    'type' => 'a',
                    // Leave it blank for "button".
                ],
                'Available' => [
                    // Action name.
                    'name' => 'Загрузить прайс',
                    // Button action title.
                    'variant' => 'action',
                    // Button style variant. Available variants; primary, secondary, action, editor, validate, aslink, aslink-grey, warning, ghost, outline, tertiary
                    'size' => 'small',
                    // Button size. Available sizes; small
                    'link' => '#import',
                    // Button action link.
                    'target' => '',
                    // Leave it blank for self.
                    'type' => 'a',
                    // Leave it blank for "button".
                ],

            ];
        }

        return [];
    }

    public function export(ExcelPriceExport $csvExport, Request $request)
    {
        abort_unless(auth()->user()->can('edit-module', 'products'), 403);

        \DebugBar::disable();
        if (!$request->hasValidSignature()) {
            abort(401);
        }

        $csvExport->build(auth()->user()->getMarketId());

        return $csvExport->send();
    }

    public function import(Request $request)
    {
        $file = $request->validate(['import' => 'file|mimes:xls,xlsx']);

        abort_unless(auth()->user()->can('edit-module', 'products'), 403);

        $productIds = [];

        \DB::transaction(function () use ($file, &$productIds) {

            $excel = \avadim\FastExcelReader\Excel::open($file['import']);
            $falseRemainsId = [];
            $trueRemainsId = [];

            foreach ($excel->readRows() as $i => $row) {

                if ($i <= 1) {
                    continue;
                }

                @[$productId, $availability, $title, $q1, $q9, $q15, $q25, $q51] = array_values($row);

                $remainId = Remain::where('product_id', $productId)->where('market_id', auth()->user()->getMarketId())->first()?->id;

                if (!$remainId) {
                    $this->createRemainsIfNotExist();
                    $this->createPricesIfNotExist();
                }

                if ($productId && $productId > 0) {
                    $productIds[] = $productId;
                }

                foreach ([1, 9, 15, 25, 51] as $q) {

                    if (${'q' . $q}) {

                        $updateData = [
                            'price' => ${'q' . $q},
                        ];

                        $query = ProductPrice::where('product_id', $productId)
                            ->where('market_id', auth()->user()->getMarketId())
                            ->where('quantity_from', $q)
                            ->where('group_product_id', null)
                            ->whereHas('product', function ($q) {
                                return $q
                                    ->where(
                                        function ($q) {
                                            return $q->where('parent_id', 0)->orWhere('parent_id', null);
                                        }
                                    )
                                    ->where(
                                        function ($q) {
                                            return $q->Where('market_id', auth()->user()->getMarketId());
                                        }
                                    );
                            });
                        $query->update($updateData);

                        ProductPriceRevision::insert([
                            'product_price_id' => $query->first()->id,
                            'user_id' => auth()->user()->id,
                            'payload' => json_encode($updateData),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }

                if ($availability) {
                    if (mb_strtoupper($availability) === 'Y') {
                        $trueRemainsId[] = $remainId;
                    } else {
                        $falseRemainsId[] = $remainId;
                    }
                }
            }

            Remain::whereIn('id', $trueRemainsId)
                ->where('group_product_id', null)
                ->where('market_id', auth()->user()->getMarketId())
                ->where('group_product_id', null)
                ->whereHas('product', function ($q) {
                    return $q
                        ->where(
                            function ($q) {
                                return $q->where('parent_id', 0)->orWhere('parent_id', null);
                            }
                        )
                        ->where(
                            function ($q) {
                                return $q->Where('market_id', auth()->user()->getMarketId());
                            }
                        );
                })
                ->update([
                    'published' => true,
                ]);

            Remain::whereIn('id', $falseRemainsId)
                ->where('group_product_id', null)
                ->where('market_id', auth()->user()->getMarketId())
                ->where('group_product_id', null)
                ->whereHas('product', function ($q) {
                    return $q
                        ->where(
                            function ($q) {
                                return $q->where('parent_id', 0)->orWhere('parent_id', null);
                            }
                        )
                        ->where(
                            'market_id', auth()->user()->getMarketId()
                        );
                })
                ->update([
                    'published' => false,
                ]);
        }, 3);

        $productIdChunks = array_chunk($productIds, 100);
        foreach ($productIdChunks as $chunk) {
            RecalculateFlowersJob::dispatch($chunk, auth()->user()->getMarketId());
        }

        Remain::flushQueryCache();
    }
}
