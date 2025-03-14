<?php

namespace App\Repositories;

use App\Repositories\ProductPriceRepository;
use Exception;
use App\Models\Product;
use Illuminate\Support\Arr;
use App\Models\GroupProduct;
use App\Http\Resources\ColorResource;
use App\Repositories\ProductRepository;
use A17\Twill\Repositories\ModuleRepository;
use A17\Twill\Repositories\Behaviors\HandleTags;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleNesting;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use Illuminate\Database\Eloquent\Builder;
use A17\Twill\Repositories\Behaviors\HandleTranslations;
use CwsDigital\TwillMetadata\Repositories\Behaviours\HandleMetadata;

class GroupProductRepository extends ModuleRepository
{
    use HandleBlocks;
    use HandleSlugs;
    use HandleMedias;
    use HandleFiles;
    use HandleTags;
    use HandleMetadata;
    use HandleRevisions;
    #use HandleNesting;

    public function __construct(GroupProduct $model)
    {
        $this->model = $model;
    }

    public function hasBehavior(string $behavior): bool
    {
        if ($behavior == 'revisions')
            return false;

        return parent::hasBehavior($behavior);
    }

    public function prepareProductTitle($fields)
    {
        $blocksFields = Arr::get($fields, 'blocksFields', null);
        $blocksBrowsers = Arr::get($fields, 'blocksBrowsers', null);

        foreach ($blocksBrowsers as $key => $blockBrowser) {
            $title = $blockBrowser[0]['name'];
            $fieldKey = str_replace('[products]', '', $key);

            $blocksFields[] = [
                'name'  => $fieldKey . '[__title]',
                'value' => $title,
            ];

            $blocksFields[] = [
                'name'  => $fieldKey . '[__is_category_avalible]',
                'value' => optional(Product::with('category')->find($blockBrowser[0]['id']))->category->is_visible ?? true,
            ];
        }

        $fields['blocksFields'] = $blocksFields;


        return $fields;
    }

    public function getFormFields(TwillModelContract $object): array
    {
        $fields = parent::getFormFields($object);


        if (isset($fields['blocksBrowsers']) && is_array($fields['blocksBrowsers'])) {
            $fields = $this->prepareProductTitle($fields);
        }

        if (isset($fields['blocksBrowsers'])) {

            $repository = app(ProductRepository::class);

            foreach ($fields['blocksBrowsers'] as $key => $b) {

                $block = $b[0];

                if ($block['endpointType'] == Product::class) {
                    $product = $repository->getById($block['id']);
                    $fields['blocksBrowsers'][$key][0]['prices'] = ColorResource::collection($product->prices()->currentMarketProductPrice()->get());

                    if (!$product->published) {
                        $fields['blocksBrowsers'][$key][0]['name'] .= "  (Нет в наличии)";
                    }

                    $fields['blocksBrowsers'][$key][0]['edit'] = moduleRoute($product->getTable(), '', 'index') . '?filter={"status":"all","search":"' . $product->title . '"}';
                }
            }
        }

        $category = $object->category;

        if ($category) {
            $fields['browsers']['group_categories'] = collect([
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


    public function filter($query, array $scopes = []): Builder
    {
        if (!\Gate::allows('is_owner')) {
            $query = $query->where(
                function ($q) {
                    return $q
                        ->where('is_public', true)
                        ->orWhere('created_by_market_id', auth()->guard('twill_users')->user()->getMarketId());
                }
            );
        }

        $query = $query->search();

        return parent::filter($query, $scopes);
    }


    public function prepareFieldsBeforeSave(TwillModelContract $object, $fields): array
    {
        unset($fields['created_by_market_id']);

        if (!\Gate::allows('update', $object)) {

            // ЭТО ОБЯЗАТЕЛЬНО!
            \DB::rollback();

            \DB::transaction(function () use ($object, $fields) {
                try {

                    $r = new ProductPriceRepository($object->currentMarketPriceObj);
                    $r->update($object->currentMarketPriceObj->id, [
                        'is_promo'        => $fields['is_promo'],
                        'price'           => $fields['price'],
                        'is_custom_price' => $this->isCustomPrice($object, $fields),
                    ]);

                    $remain = $object->remains()->whereMarketIdAndGroupProductId(auth()->user()->getMarketId(), $object->id)->first();
                    $remainsRepository = new RemainRepository($remain);
                    $remainsRepository->update($remain->id, [
                        'published' => $fields['published'],
                    ]);

                } catch (\Throwable $th) {
                    response()->json([
                        'message' => "Ошибка! Не удалось обновить",
                        'variant' => "error",
                    ], 200)->send();
                    exit();
                }
                response()->json([
                    'message' => "Успешно!",
                    'variant' => "success",
                ], 200)->send();
            });

            exit();
        }

        // Очистить тэги, которые не создал админ
        if (isset($fields['tags']) && $fields['tags'] && !\Gate::allows('is_owner')) {

            $tags = is_array($fields['tags']) ? $fields['tags'] : explode(',', $fields['tags']);
            $tags = array_filter($tags);

            $allowedTags = GroupProduct::allTags()->whereIn('name', $tags)->get();


            if (!empty($allowedTags)) {
                $allowedTags = $allowedTags->pluck('name')->toArray();

                foreach ($tags as $i => $tag) {
                    if (!in_array($tag, $allowedTags)) {
                        unset($tags[$i]);
                    }
                }
                $fields['tags'] = $tags;
            }
        }


        $fields = parent::prepareFieldsBeforeSave($object, $fields);
        $id = Arr::get($fields, 'browsers.group_categories.0.id', null);

        # Arr::set($fields, 'browsers.group_categories', null);

        $fields['category_id'] = $id;


        $fields['is_custom_price'] = $this->isCustomPrice($object, $fields);

        return $fields;
    }

    public function prepareFieldsBeforeCreate(array $fields): array
    {
        $fields['created_by_market_id'] = auth()->guard('twill_users')->user()->getMarketId();

        return parent::prepareFieldsBeforeCreate($fields);
    }

    public function afterSave(TwillModelContract $model, array $fields): void
    {
        parent::afterSave($model, $fields);


        // отключить букет, если он перестал быть публичным у других магазинов
        if ($model->is_public == false) {
            \App\Models\Remain::where('group_product_id', $model->id)
                ->whereNotIn('market_id', [$model->created_by_market_id])
                ->update(
                    [
                        'published' => false,
                    ]
                );
        }

    }

    public function isCustomPrice($object, $fields)
    {
        if (!isset($fields['price'])) {
            return false;
        }

        $proposedPrice = $fields['price'];


        $total = self::calcBLocksPrice($object, $fields);



        return (float) $proposedPrice !== (float) $total;
    }

    public static function calcBLocksPrice($object, $fields)
    {
        $total = 0.0;
        $blocks = Arr::get($fields, 'blocks', null);
        if ($blocks) {
            foreach ($blocks as $block) {
                if ($block['type'] === 'a17-block-products') {

                    $count = Arr::get($block, 'content.count', null);
                    $prices = array_filter(Arr::get($block, 'browsers.products.0.prices', []), function ($item) {
                        return isset($item['price']) && $item['price'] && !empty($item['price']) && \is_numeric($item['price']);
                    });
                    usort($prices, function ($l, $r) {
                        return $l['quantity_from'] >= $r['quantity_from'];
                    });

                    if (isset(array_keys($prices)[0])) {

                        $_current = array_keys($prices)[0];

                        foreach ($prices as $key => $price) {
                            if ($price['quantity_from'] <= $count) {
                                $_current = $key;
                            }
                        }
                    } else {
                        return true;
                    }
                    $total += $prices[$_current]['price'] * $count;

                }
            }
        }
        return $total;
    }
}
