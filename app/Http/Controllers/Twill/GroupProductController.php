<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;
use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Listings\Columns\Image;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\Filters\BasicFilter;
use A17\Twill\Services\Listings\Filters\BelongsToFilter;
use A17\Twill\Services\Listings\Filters\QuickFilter;
use A17\Twill\Services\Listings\Filters\QuickFilters;
use A17\Twill\Services\Listings\Filters\TableFilters;
use A17\Twill\Services\Listings\TableColumns;
use App\Models\GroupProduct;
use App\Models\Market;
use App\Models\ProductPrice;
use App\Models\Remain;
use App\Services\CatalogService;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use stdClass;

class GroupProductController extends BaseModuleController {
    protected $moduleName = 'groupProducts';




    // Метод для массового действия


    protected function setUpController(): void {
        $this->labels['listing.filter.all-items'] = __('Все');
        $this->labels['listing.filter.draft'] = __('Нет в наличии');

        $this->setTitleColumnKey('title');

        // так и должно быть. Поиск проходит в репозитории
        $this->setSearchColumns([]);
        $this->modelTitle = 'Букет';

        $this->disableEditor();
        $this->setPermalinkBase('catalog');
        // $this->enableEditInModal();
        $this->disableSortable();

       // $this->disableBulkDelete();
     //  $this->disableBulkEdit();
      /*  $this->disableBulkForceDelete();*/
       // $this->enableBulkFeature();
        //$this->enableFeature();
        $this->indexOptions['beforeTable'] = view('twill.admin.bulkActions')->render();

    }

    protected $indexOptions = [];

    protected $showOnlyParentItemsInBrowsers = false;

    protected $nestedItemsDepth = 4;

    public function publish(): JsonResponse {
        try {
            $data = $this->validate($this->request, [
                'id' => 'integer|required',
                'active' => 'bool|required',
            ]);

            if (
                $this->repository->updateBasic($data['id'], [
                    'published' => ! $data['active'],
                ])
            ) {
                activity()->performedOn(
                    $this->repository->getById($data['id'])
                )->log(
                    ($this->request->get('active') ? 'un' : '') . 'published'
                );

                $this->fireEvent();

                if ($data['active']) {
                    return $this->respondWithSuccess(
                        twillTrans('Букета нет в наличии', ['modelTitle' => $this->modelTitle])
                    );
                }

                return $this->respondWithSuccess(
                    twillTrans('Букет в наличии', ['modelTitle' => $this->modelTitle])
                );
            }
        } catch (\Exception $e) {
            \Log::channel('marketplace')->error($e);
        }

        return $this->respondWithError(
            twillTrans('twill::lang.listing.publish.error', ['modelTitle' => $this->modelTitle])
        );
    }

    public function edit(TwillModelContract|int $id): mixed {
        [$item, $id] = $this->itemAndIdFromRequest($id);
        abort_unless(auth()->user()->can('view', $item), 403);

        return parent::edit($id);
    }

    private function itemAndIdFromRequest(TwillModelContract|int $id): array {
        if ($id instanceof TwillModelContract) {
            $item = $id;
            $id = $item->id;
        } else {
            $parameter = Str::singular(Str::afterLast($this->moduleName, '.'));
            $id = (int) $this->request->route()->parameter($parameter, $id);
            $item = $this->repository->getById($id, $this->formWith, $this->formWithCount);
        }

        return [
            $item,
            $id,
        ];
    }

    public function update(int|TwillModelContract $id, ?int $submoduleId = null): JsonResponse {
        if (! \request('browsers.group_categories.0')) {
            return $this->respondWithError(
                __('Категория - обязательное поле')
            );
        }

        return parent::update($id, $submoduleId);
    }

    /**
     * The quick filters to apply to the listing table.
     */
    public function quickFilters(): QuickFilters {
        $scope = ($this->submodule ? [
            $this->getParentModuleForeignKey() => $this->submoduleParentId,
        ] : []);

        $filter = [
            QuickFilter::make()
                ->label(\Str::ucfirst(auth()->user()->market->name ?? 'Магазин'))
                ->queryString('currentMarket')
                ->amount(fn() => $this->repository->filter($this->repository->getBaseModel())->currentMarket()->count())
                ->scope('currentMarket'),

            QuickFilter::make()
                ->label('В наличии')
                ->queryString('published')
                ->amount(fn() => $this->repository->filter($this->repository->getBaseModel())->inStock()->count())
                ->scope('inStock'),

            QuickFilter::make()
                ->label($this->getTransLabel('listing.filter.draft'))
                ->queryString('draft')
                ->scope('draft')
                ->amount(fn() => $this->repository->filter($this->repository->getBaseModel())->draft()->count())
                ->onlyEnableWhen($this->getIndexOption('publish')),
        ];

        if (count(auth('twill_users')->user()->getMarketIds()) > 1) {
            $filter[] = QuickFilter::make()
                ->label('Всех магазинов')
                ->amount(fn() => $this->repository->filter($this->repository->getBaseModel())->allGroupPoruductBelongsMarket()->count())
                ->queryString('allGroupPoruductBelongsMarket')
                ->scope('allGroupPoruductBelongsMarket');
        }

        $filter[] = QuickFilter::make()
            ->label('Букеты сети')
            ->queryString('common')
            ->amount(fn() => $this->repository->filter($this->repository->getBaseModel())->common()->count())
            ->scope('common');

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

        return QuickFilters::make($filter);
    }

    public function filters(): TableFilters {
        return TableFilters::make([
            BelongsToFilter::make()->field('GroupProductCategory')->default('all')->label('Категории'),
            BasicFilter::make()
                ->queryString('tags')
                ->options(collect(app(GroupProduct::class)->allTags()->pluck('name', 'id')))
                ->apply(function (Builder $builder, string $value) {
                    $builder->whereHas('tags', fn($q) => $q->where('tag_id', $value));
                })->label('Тэги'),
        ]);
    }

    public function history(GroupProduct $groupProduct) {
        abort_if(
            ! \Gate::allows('edit-module', 'groupProducts') ||
                ! \Gate::allows('edit', $groupProduct->priceObj),
            403
        );
        $groupProduct->priceObj->load('revisions');

        return view('site.groupProductPriceHistory')
            ->with('groupProduct', $groupProduct)
            ->with('price', $groupProduct->priceObj()->currentMarketGroupProductPrice()->get())
            ->with('revisions', $groupProduct->priceObj()->currentMarketGroupProductPrice()->first()->revisions);
    }

    protected function getIndexTableColumns(): TableColumns {
        $table = parent::getIndexTableColumns();
        $table->get(1)->title('Название');

        $after = $table->splice(1);

        $table->prepend(
            Image::make()->field('cover')->title(__('Изображение'))->rounded()
        );

        $after->push(
            Text::make()->field('price')->title(__('Стоимость'))->renderHtml(true)->customRender(function ($model) {
                $gray = $model->currentMarketPriceObj->is_custom_price ?? false ? 'style="color:gray" title="Стоимость указана вручную"' : '';

                return '<span ' . $gray . '>₽ ' . round((float) $model->price) . '</span>';
            })
        );

        $after->push(
            Text::make()->field('public_price')->title(__('Стоимость на сайте'))->renderHtml(true)->customRender(function ($model) {
                $gray = $model->currentMarketPriceObj->is_custom_price ?? false ? 'style="color:gray" title="Стоимость указана вручную"' : '';

                return '<span ' . $gray . '>₽ ' . round((float) $model->public_price) . '</span>';
            })
        );

        $after->push(
            Text::make()->field('sku')->title(__('Артикул'))->renderHtml(true)->customRender(function ($model) {
                $sku = $model->priceObj()->whereMarketId(auth()->guard('twill_users')->user()->getMarketId())->first()->sku ?? '';

                return $sku;
            })
        );

        $after->push(
            Text::make()->field('history')->title(__('История изменений'))->renderHtml(true)->customRender(function ($model) {
                $model->load('priceObj');
                $link = route('twill.history.groupProduct.price', ['groupProduct' => $model->id]);

                return '<a href="' . $link . '" target="_blank">' . __('Открыть') . '</a>';
            })
        );

        return $table->merge($after);
    }

    // META SEO
    protected function formData($request) {
        $return = [
            'metadata_card_type_options' => config('metadata.card_type_options'),
            'metadata_og_type_options' => config('metadata.opengraph_type_options'),
        ];

        if ($request->route('groupProduct')) {
            $id = $request->route('groupProduct');
            $item = $this->repository->getById($id, $this->formWith, $this->formWithCount);

            try {
                $price = $item->priceObj->whereMarketId(auth('twill_users')->user()->getMarketId())->where('group_product_id', $id)->first();
            } catch (\Throwable $th) {
                $this->createRemainsIfNotExist();
                $this->createPricesIfNotExist();
                if (isset($item->priceObj)) {
                    $price = $item->priceObj->whereMarketId(auth('twill_users')->user()->getMarketId())->where('group_product_id', $id)->first();

                    if (! $price) {
                        $price = new stdClass;
                        $price->link = '';
                    }
                } else {
                    $price = new stdClass;
                    $price->link = '';
                }
            }

            $return['customPermalink'] = $price->link ?? '';
        }

        return $return;
    }

    protected function form(?int $id, ?TwillModelContract $item = null): array {
        if ($id) {
            $item = $this->repository->getById($id, $this->formWith, $this->formWithCount);

            if ($item->category) {

                $this->permalinkBase .= '/' . $item->category->nestedSlug;
            }

            $this->permalinkBase = str_replace('//', '/', $this->permalinkBase);

            $this->permalinkBase = rtrim($this->permalinkBase, '/');
        }

        return parent::form($id, $item);
    }

    protected function createRemainsIfNotExist() {
        if ($marketId = auth('twill_users')->user()->getMarketId()) {
            if (
                Remain::dontCache()->whereMarketId($marketId)->where('product_id', '<>', null)->count() != GroupProduct::dontCache()->count()
            ) {

                $products = GroupProduct::dontCache()->whereDoesntHave('remains', function ($q) use ($marketId) {
                    return $q->whereMarketId($marketId);
                })->get();

                $inserts = [];
                foreach ($products as $product) {
                    $inserts[] = [
                        'group_product_id' => $product->id,
                        'market_id' => $marketId,
                        'published' => false,
                        'created_at' => \now(),
                        'updated_at' => \now(),
                    ];
                }
                Remain::insert($inserts);
                Remain::flushQueryCache();
            }
        }
    }

    protected function createPricesIfNotExist() {
        if ($marketId = auth('twill_users')->user()->getMarketId()) {

            if (
                ProductPrice::whereMarketId($marketId)
                ->where('product_id', '<>', null)->where('quantity_from', 1)->count() != GroupProduct::dontCache()->count()

            ) {
                $products = GroupProduct::dontCache()->whereDoesntHave('priceObj', function ($q) use ($marketId) {
                    return $q->whereMarketId($marketId);
                })->get();

                $inserts = [];
                $marketName = Market::where('id', $marketId)->first()->name ?? false;
                $regionName = Market::where('id', $marketId)->first()->city->province->geoname_name ?? false;
                $cityName = Market::where('id', $marketId)->first()->city->city ?? false;

                if (! $marketName || ! $regionName || ! $cityName) {
                    response()->view('errors.admin', [
                        'message' => 'Вы должны заполнить данные о магазине, прежде чем продолжить',
                        'link' => moduleRoute('markets', '', 'edit', $marketId),
                    ])->send();
                    exit();
                }

                foreach ($products as $product) {
                    $inserts[] = [
                        'group_product_id' => $product->id,
                        'market_id' => $marketId,
                        'published' => true,
                        'quantity_from' => 1,
                        'created_at' => \now(),
                        'updated_at' => \now(),

                        'sku' => CatalogService::generateSku(
                            \Str::slug(mb_strtolower($marketName), true),
                            $regionName,
                            \Str::slug($cityName, true),
                            $marketId,
                            $product->id
                        ),
                    ];
                }

                ProductPrice::insert($inserts);
            }
        }
    }

    protected function getIndexData(array $prependScope = []): array {
        $data = parent::getIndexData($prependScope);
        foreach ($data['tableData'] as $i => $item) {
            if (
                ! auth()
                    ->user()
                    ->can('update', GroupProduct::where('id', $item['id'])->first())
            ) {
                $data['tableData'][$i]['delete'] = false;
            }
        }


        return $data;
    }

    /**
     * @return IlluminateView|JsonResponse
     */
    public function index(?int $parentModuleId = null): mixed {
        $this->createRemainsIfNotExist();
        $this->createPricesIfNotExist();

        return parent::index($parentModuleId);
    }


    public function bulkPublish(): JsonResponse
    {

            $gets=GroupProduct::whereIN('id',explode(',',request('ids')))->get();
                foreach ($gets as $get) {
                    $get->published =request('publish');
                    $get->save();
                }

              //  ->update(['published' => request('publish')]);

                if ($this->request->get('publish')) {
                    return $this->respondWithSuccess(
                        twillTrans('twill::lang.listing.bulk-publish.published', ['modelTitle' => $this->modelTitle])
                    );
                } else {
                    return $this->respondWithSuccess(
                        twillTrans('twill::lang.listing.bulk-publish.unpublished', ['modelTitle' => $this->modelTitle])
                    );
                }

    }


}
