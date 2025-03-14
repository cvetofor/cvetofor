<?php

namespace App\Repositories;

use Arr;
use App\Models\Color;
use App\Models\Product;
use App\Models\Category;
use A17\Twill\Models\Block;
use App\Models\GroupProduct;
use A17\Twill\Models\RelatedItem;
use Illuminate\Database\Eloquent\Builder;
use A17\Twill\Models\Behaviors\HasRelated;
use A17\Twill\Repositories\ModuleRepository;
use Illuminate\Database\Eloquent\Collection;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleNesting;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleJsonRepeaters;
use App\Models\Remain;

class ProductRepository extends ModuleRepository
{
    use HandleSlugs, HandleMedias, HasRelated;
    //  use HandleRevisions;

    protected $relatedBrowsers = [
        'colors' => [
            'moduleName' => 'color',
            'relation'   => 'colors',
        ],
    ];

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function filter($query, array $scopes = []): Builder
    {

        if (request()?->route()->parameters() && isset(request()?->route()->parameters()['category'])) {
            $category_id = request()?->route()->parameters()['category'];
            $categoris = Category::where('id', $category_id)->orWhere('parent_id', $category_id);
            $query = $query->whereIn('category_id', $categoris->pluck('id')->toArray());
        }

        if (!auth()->user()->can('is_owner') || (\json_decode(request()->get('filter') ?? '{}')->status ?? false) !== 'trash') {
            $query = $query->where(function ($q) {
                return $q->where('parent_id', null)->orWhere('parent_id', 0);
            });
        } else {
            $query = $query->where(function ($q) {
                return $q->where('parent_id', '!=', null);
            });
        }


        if (!\Gate::allows('is_owner')) {
            $query = $query->where(function ($q) {
                return $q->where('is_market_public', '=', true)->orWhere('market_id', auth()->user()->getMarketId() ?? false);
            });
        }

        $query->orderBy('title');

        #$query = $query->where('market_id', '=', auth()->guard('twill_users')->user()->getMarketId());

        return parent::filter($query, $scopes);
    }


    public function beforeSave(TwillModelContract $object, array $fields): void
    {
        # abort_if($object->parent_id !== null, 403);

        if (!auth()->user()->can('is_owner') && in_array($object->market_id, auth()->user()->getMarketIds()) && $object->verefied_at !== null) {
            $fields['verified_at'] = null;
        }

        parent::beforeSave($object, $fields);
    }

    public function afterSave(TwillModelContract $model, array $fields): void
    {
        parent::afterSave($model, $fields);

        // Создаем либо удаляем товары зависимые от цвета
        if ($model->parent_id == null) {
            $model->load('skus');
            $colors = $model->getRelated('colors');

            if ($model->skus->count() == 0) {
                foreach ($colors as $color) {
                    $skuProduct = $this->create([
                        'parent_id'        => $model->id,
                        'category_id'      => $model->category_id,
                        'title'            => $model->title . ' / ' . $color->title,
                        'published'        => true,
                        'is_market_public' => true,
                        'verified_at'      => now(),
                    ]);

                    RelatedItem::create([
                        'subject_id'   => $skuProduct->getKey(),
                        'subject_type' => $skuProduct->getMorphClass(),
                        'related_id'   => $color->id,
                        'related_type' => $color::class,
                        'browser_name' => 'colors',
                        'position'     => $color->id + 1,
                    ]);
                }
            }
            # Обновить старые и добавить новые
            else {
                $skus = $model->skus;
                $exists = [];
                foreach ($skus as $sku) {
                    $color = $sku->getRelated('colors')->first();

                    if ($color) {
                        if (in_array($color->id, $colors->pluck('id')->toArray())) {
                            $sku->update([
                                'title'       => $model->title . ' / ' . $color->title,
                                'category_id' => $model->category_id,
                            ]);
                            $exists[] = $color->id;
                        } else {
                            $sku->delete();
                        }
                    }
                }

                foreach ($colors as $color) {

                    if (in_array($color->id, $exists))
                        continue;

                    $skuProduct = $this->create([
                        'parent_id'        => $model->id,
                        'category_id'      => $model->category_id,
                        'title'            => $model->title . ' / ' . $color->title,
                        'published'        => true,
                        'is_market_public' => true,
                        'verified_at'      => now(),
                    ]);
                    RelatedItem::create([
                        'subject_id'   => $skuProduct->getKey(),
                        'subject_type' => $skuProduct->getMorphClass(),
                        'related_id'   => $color->id,
                        'related_type' => $color::class,
                        'browser_name' => 'colors',
                        'position'     => $color->id + 1,
                    ]);
                }
            }
        }
    }

    /**
     * Отключить букеты, товары или цвета которых отсуствуют
     */
    public static function changeAccessibilityOnGroupProducts(Product $product, $marketId = null)
    {
        $marketId = $marketId ?  : auth('twill_users')->user()->getMarketId();

        $groupProducts = GroupProduct::whereHas('blocks', function ($q) use ($product) {
            if ($product->parent) {
                $q = $q->whereJsonContains('content->browsers->color', [$product->colors()->first()->id ?? false]);
            }
            return $q
                ->whereJsonContains('content->browsers->products', [$product->parent ? $product->parent->id : $product->id]);
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

            # Если обновляется главный товар, то букеты с неактивным цветом должны остаться неактивными
            $skus = $product->skus;
            foreach ($skus as $key => $sku) {
                self::changeAccessibilityOnGroupProducts($sku);
            }
        }




    }

    public function cmsSearch(string $search, array $fields = []): Collection
    {
        $query = $this->model;
        $query = $this->filter($query, []);
        $builder = $query;

        foreach ($fields as $field) {
            $builder->where($field, \getLikeOperator(), "%$search%");
        }

        return $builder->get();
    }

    public function prepareFieldsBeforeSave(TwillModelContract $object, $fields): array
    {

        $fields = parent::prepareFieldsBeforeSave($object, $fields);
        $id = Arr::get($fields, 'browsers.categories.0.id', null);

        Arr::set($fields, 'browsers.categories', null);

        if ($id) {
            $fields['category_id'] = $id;
        }

        return $fields;
    }

    public function getFormFields(TwillModelContract $object): array
    {
        $fields = parent::getFormFields($object);

        $fields = $this->getFormFieldsForRepeater($object, $fields, 'skus', 'Product', 'product-childrens');


        $category = $object->category;

        if ($category) {
            $fields['browsers']['categories'] = collect([
                [
                    'id'           => $category->id,
                    'name'         => $category->title,
                    'edit'         => moduleRoute($object->category->getTable(), '', 'edit', $category->id),
                    "endpointType" => Category::class,
                ],
            ])->toArray();
        }

        return $fields;
    }

    /**
     * @return array|<missing>
     */
    public function prepareFieldsBeforeCreate(array $fields): array
    {
        $fields = parent::prepareFieldsBeforeCreate($fields);
        $fields['market_id'] = auth()->guard('twill_users')->user()->getMarketId();

        return $fields;
    }
}
