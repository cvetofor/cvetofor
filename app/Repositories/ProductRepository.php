<?php

namespace App\Repositories;

use A17\Twill\Models\Behaviors\HasRelated;
use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Models\RelatedItem;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\Category;
use App\Models\GroupProduct;
use App\Models\Product;
use App\Models\Remain;
use Arr;
use Gate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use function getLikeOperator;
use function json_decode;

class ProductRepository extends ModuleRepository {
    use HandleMedias, HandleSlugs, HasRelated;
    //  use HandleRevisions;

    protected $relatedBrowsers = [
        'colors' => [
            'moduleName' => 'color',
            'relation' => 'colors',
        ],
    ];

    public function __construct(Product $model) {
        $this->model = $model;
    }

    public function filter($query, array $scopes = []): Builder {

        if (request()?->route()->parameters() && isset(request()?->route()->parameters()['category'])) {
            $category_id = request()?->route()->parameters()['category'];
            $categoris = Category::where('id', $category_id)->orWhere('parent_id', $category_id);
            $query = $query->whereIn('category_id', $categoris->pluck('id')->toArray());
        }

        if (! auth()->user()->can('is_owner') || (json_decode(request()->get('filter') ?? '{}')->status ?? false) !== 'trash') {
            $query = $query->where(function ($q) {
                return $q->where('parent_id', null)->orWhere('parent_id', 0);
            });
        } else {
            $query = $query->where(function ($q) {
                return $q->where('parent_id', '!=', null);
            });
        }

        if (! Gate::allows('is_owner')) {
            $query = $query->where(function ($q) {
                return $q->where('is_market_public', '=', true)->orWhere('market_id', auth()->user()->getMarketId() ?? false);
            });
        }

        $query->orderBy('title');

        // $query = $query->where('market_id', '=', auth()->guard('twill_users')->user()->getMarketId());

        return parent::filter($query, $scopes);
    }

    public function beforeSave(TwillModelContract $object, array $fields): void {
        // abort_if($object->parent_id !== null, 403);

        if (! auth()->user()->can('is_owner') && in_array($object->market_id, auth()->user()->getMarketIds()) && $object->verefied_at !== null) {
            $fields['verified_at'] = null;
        }

        parent::beforeSave($object, $fields);
    }

    public function afterSave(TwillModelContract $model, array $fields): void {
        parent::afterSave($model, $fields);

        // Сохраняем или обновляем цену в ProductPrice
        if (isset($fields['price'])) {
            $marketId = auth()->guard('twill_users')->user()->getMarketId();
            $priceObj = $model->prices()->where('market_id', $marketId)->where('quantity_from', 1)->first();
            if (!$priceObj) {
                $priceObj = $model->prices()->create([
                    'market_id' => $marketId,
                    'quantity_from' => 1,
                    'price' => $fields['price'],
                    'published' => true,
                ]);
            } else {
                $priceObj->price = $fields['price'];
                $priceObj->save();
            }
        }

        // Создаем либо удаляем товары зависимые от цвета
        if ($model->parent_id == null) {
            $model->load('skus');
            $colors = $model->getRelated('colors');

            if ($model->skus->count() == 0) {
                foreach ($colors as $color) {
                    $skuProduct = $this->create([
                        'parent_id' => $model->id,
                        'category_id' => $model->category_id,
                        'title' => $model->title . ' / ' . $color->title,
                        'published' => true,
                        'is_market_public' => true,
                        'verified_at' => now(),
                    ]);

                    RelatedItem::create([
                        'subject_id' => $skuProduct->getKey(),
                        'subject_type' => $skuProduct->getMorphClass(),
                        'related_id' => $color->id,
                        'related_type' => $color::class,
                        'browser_name' => 'colors',
                        'position' => $color->id + 1,
                    ]);
                }
            }
            // Обновить старые и добавить новые
            else {
                $skus = $model->skus;
                $exists = [];
                foreach ($skus as $sku) {
                    $color = $sku->getRelated('colors')->first();

                    if ($color) {
                        if (in_array($color->id, $colors->pluck('id')->toArray())) {
                            $sku->update([
                                'title' => $model->title . ' / ' . $color->title,
                                'category_id' => $model->category_id,
                            ]);
                            $exists[] = $color->id;
                        } else {
                            $sku->delete();
                        }
                    }
                }

                foreach ($colors as $color) {

                    if (in_array($color->id, $exists)) {
                        continue;
                    }

                    $skuProduct = $this->create([
                        'parent_id' => $model->id,
                        'category_id' => $model->category_id,
                        'title' => $model->title . ' / ' . $color->title,
                        'published' => true,
                        'is_market_public' => true,
                        'verified_at' => now(),
                    ]);
                    RelatedItem::create([
                        'subject_id' => $skuProduct->getKey(),
                        'subject_type' => $skuProduct->getMorphClass(),
                        'related_id' => $color->id,
                        'related_type' => $color::class,
                        'browser_name' => 'colors',
                        'position' => $color->id + 1,
                    ]);
                }
            }
        }
    }

    /**
     * Отключить букеты, товары или цвета которых отсуствуют
     */
    public static function changeAccessibilityOnGroupProducts(Product $product, $marketId = null) {
        $marketId = $marketId ?: auth('twill_users')->user()->getMarketId();
        $groupProducts = GroupProduct::whereHas('blocks', function ($q) use ($product) {
            if ($product->parent) {
                // Если это SKU продукт (конкретный цвет), ищем букеты с этим цветом
                $colorId = $product->getRelated('colors')->first()->id ?? null;
                if ($colorId) {
                    $q->whereJsonContains('content->browsers->color', [$colorId]);
                }
            }

            return $q->whereJsonContains('content->browsers->products', [$product->parent ? $product->parent->id : $product->id]);
        })->pluck('id');

        if (
            $product->published == false ||
            $product->parent
        ) {
            Remain::where('market_id', $marketId)
                ->whereIn('group_product_id', $groupProducts->toArray())->update(
                    [
                        'published' => $product->published,
                    ]
                );
        } else {
            // Если обновляется главный товар, то букеты с неактивным цветом должны остаться неактивными
            $skus = $product->skus;
            foreach ($skus as $key => $sku) {
                self::changeAccessibilityOnGroupProducts($sku);
            }
        }


        \Log::channel('marketplace')->info('DEBUG', [$product]);


        // Если это SKU (цвет), то при активации/деактивации меняем статус всех связанных букетов
        if ($product->parent) {
            // Для каждого букета проверяем, что все цветки с нужным цветом доступны
            foreach ($groupProducts as $groupProductId) {
                $groupProduct = GroupProduct::find($groupProductId);
                // if (!$groupProduct) continue;

                $allAvailable = true;
                $blocks = $groupProduct->blocks()->where('type', 'products')->get();
                foreach ($blocks as $block) {
                    $blockContent = $block->content;
                    $blockProductId = \Arr::get($blockContent, 'browsers.products.0');
                    $blockColorId = \Arr::get($blockContent, 'browsers.color.0');

                    if ($product->parent->published == false) {
                        $allAvailable = false;
                        break;
                    }

                    if ($blockProductId && $blockColorId) {
                        // Получаем SKU продукта (конкретный цвет) и проверяем его публикацию
                        $skuProduct = Product::where('parent_id', $blockProductId)
                            ->whereExists(function ($query) use ($blockColorId) {
                                $query->select(\DB::raw(1))
                                    ->from('related')
                                    ->whereRaw('related.subject_id = products.id')
                                    ->where('related.subject_type', Product::class)
                                    ->where('related.related_id', $blockColorId)
                                    ->where('related.related_type', \App\Models\Color::class)
                                    ->where('related.browser_name', 'colors');
                            })
                            ->first();

                        // Если SKU не найден или не опубликован - отмечаем проблему
                        if (!$skuProduct || !$skuProduct->published) {
                            $allAvailable = false;
                            break;
                        }
                    }
                }

                // Если все цветки с нужным цветом доступны, включаем букет, иначе выключаем
                Remain::where('group_product_id', $groupProductId)
                    ->update(['published' => $allAvailable]);
            }
            return;
        }
    }

    public function cmsSearch(string $search, array $fields = [], ?callable $query = null): Collection {
        $builder = $this->filter($this->model, []);

        foreach ($fields as $field) {
            $builder->where($field, getLikeOperator(), "%$search%");
        }

        return $builder->get();
    }

    public function prepareFieldsBeforeSave(TwillModelContract $object, $fields): array {
        $fields = parent::prepareFieldsBeforeSave($object, $fields);
        $id = Arr::get($fields, 'browsers.categories.0.id', null);

        Arr::set($fields, 'browsers.categories', null);

        if ($id) {
            $fields['category_id'] = $id;
        }

        return $fields;
    }

    public function getFormFields(TwillModelContract $object): array {
        $fields = parent::getFormFields($object);

        $fields = $this->getFormFieldsForRepeater($object, $fields, 'skus', 'Product', 'product-childrens');

        $category = $object->category;

        if ($category) {
            $fields['browsers']['categories'] = collect([
                [
                    'id' => $category->id,
                    'name' => $category->title,
                    'edit' => moduleRoute($object->category->getTable(), '', 'edit', $category->id),
                    'endpointType' => Category::class,
                ],
            ])->toArray();
        }

        return $fields;
    }

    /**
     * @return array
     */
    public function prepareFieldsBeforeCreate(array $fields): array {
        $fields = parent::prepareFieldsBeforeCreate($fields);
        $fields['market_id'] = auth()->guard('twill_users')->user()->getMarketId();

        return $fields;
    }
}
