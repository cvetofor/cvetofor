<?php

namespace App\Repositories;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleNesting;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\Behaviors\HandleTags;
use A17\Twill\Repositories\ModuleRepository;
use App\Http\Resources\ColorResource;
use App\Models\GroupProduct;
use App\Models\Product;
use CwsDigital\TwillMetadata\Repositories\Behaviours\HandleMetadata;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Log;

class GroupProductRepository extends ModuleRepository {
    use HandleBlocks;
    use HandleFiles;
    use HandleMedias;
    use HandleMetadata;
    use HandleRevisions;
    use HandleSlugs;
    use HandleTags;
    // use HandleNesting;

    public function __construct(GroupProduct $model) {
        $this->model = $model;
    }

    public function hasBehavior(string $behavior): bool {
        if ($behavior == 'revisions') {
            return false;
        }

        return parent::hasBehavior($behavior);
    }

    public function prepareProductTitle($fields) {
        $blocksFields = Arr::get($fields, 'blocksFields', null);
        $blocksBrowsers = Arr::get($fields, 'blocksBrowsers', null);

        foreach ($blocksBrowsers as $key => $blockBrowser) {
            $title = $blockBrowser[0]['name'];
            $fieldKey = str_replace('[products]', '', $key);

            $blocksFields[] = [
                'name' => $fieldKey . '[__title]',
                'value' => $title,
            ];

            $blocksFields[] = [
                'name' => $fieldKey . '[__is_category_avalible]',
                'value' => optional(Product::with('category')->find($blockBrowser[0]['id']))->category->is_visible ?? true,
            ];
        }

        $fields['blocksFields'] = $blocksFields;

        return $fields;
    }

    public function getFormFields(TwillModelContract $object): array {
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

                    if (! $product->published) {
                        $fields['blocksBrowsers'][$key][0]['name'] .= '  (Нет в наличии)';
                    }

                    $fields['blocksBrowsers'][$key][0]['edit'] = moduleRoute($product->getTable(), '', 'index') . '?filter={"status":"all","search":"' . $product->title . '"}';
                }
            }
        }

        $category = $object->category;

        if ($category) {
            $fields['browsers']['group_categories'] = collect([
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

    public function filter($query, array $scopes = []): Builder {
        if (! \Gate::allows('is_owner')) {
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

    public function prepareFieldsBeforeSave(TwillModelContract $object, $fields): array {
        unset($fields['created_by_market_id']);

        // Проверяем, что у каждого продукта в букете выбран цвет
        if (isset($fields['blocks'])) {
            $hasProductWithoutColor = false;
            foreach ($fields['blocks'] as $block) {
                if ($block['type'] === 'a17-block-products') {
                    $product = Arr::get($block, 'browsers.products.0.id');
                    $color = Arr::get($block, 'browsers.color.0.id');

                    // Если есть продукт и выбран цвет, проверяем его наличие
                    if ($product && $color) {
                        // Получаем SKU продукта (конкретный цвет) и проверяем его публикацию
                        $skuProduct = Product::where('parent_id', $product)
                            ->whereExists(function ($query) use ($color) {
                                $query->select(\DB::raw(1))
                                    ->from('related')
                                    ->whereRaw('related.subject_id = products.id')
                                    ->where('related.subject_type', Product::class)
                                    ->where('related.related_id', $color)
                                    ->where('related.related_type', \App\Models\Color::class)
                                    ->where('related.browser_name', 'colors');
                            })
                            ->first();

                        // Если SKU не найден или не опубликован - отмечаем проблему
                        if (!$skuProduct || !$skuProduct->published) {
                            $hasProductWithoutColor = true;
                            break;
                        }
                    }
                }
            }

            // Если есть продукты без цвета, снимаем публикацию букета
            if ($hasProductWithoutColor) {
                $fields['published'] = false;

                // Добавляем уведомление для пользователя
                if (request()->expectsJson()) {
                    response()->json([
                        'message' => 'Букет не будет опубликован, так как у некоторых цветов отсутсвует цвет.',
                        'variant' => 'warning',
                    ], 200)->send();
                }
            }
        }

        if (! \Gate::allows('update', $object)) {

            // ЭТО ОБЯЗАТЕЛЬНО!
            \DB::rollback();

            \DB::transaction(function () use ($object, $fields) {
                try {
                    $r = new ProductPriceRepository($object->currentMarketPriceObj);
                    $r->update($object->currentMarketPriceObj->id, [
                        'is_promo' => $fields['is_promo'],
                        'price' => $fields['price'],
                        'is_custom_price' => $this->isCustomPrice($object, $fields),
                    ]);

                    $remain = $object->remains()->whereMarketIdAndGroupProductId(auth()->user()->getMarketId(), $object->id)->first();
                    $remainsRepository = new RemainRepository($remain);
                    $remainsRepository->update($remain->id, [
                        'published' => $fields['published'],
                    ]);
                } catch (\Throwable $th) {
                    response()->json([
                        'message' => 'Ошибка! Не удалось обновить',
                        'variant' => 'error',
                    ], 200)->send();
                    exit();
                }
                response()->json([
                    'message' => 'Успешно!',
                    'variant' => 'success',
                ], 200)->send();
            });

            exit();
        }

        // Очистить тэги, которые не создал админ
        if (isset($fields['tags']) && $fields['tags'] && ! \Gate::allows('is_owner')) {

            $tags = is_array($fields['tags']) ? $fields['tags'] : explode(',', $fields['tags']);
            $tags = array_filter($tags);

            $allowedTags = GroupProduct::allTags()->whereIn('name', $tags)->get();

            if (! empty($allowedTags)) {
                $allowedTags = $allowedTags->pluck('name')->toArray();

                foreach ($tags as $i => $tag) {
                    if (! in_array($tag, $allowedTags)) {
                        unset($tags[$i]);
                    }
                }
                $fields['tags'] = $tags;
            }
        }

        $fields = parent::prepareFieldsBeforeSave($object, $fields);
        $id = Arr::get($fields, 'browsers.group_categories.0.id', null);

        // Arr::set($fields, 'browsers.group_categories', null);

        $fields['category_id'] = $id;

        $fields['is_custom_price'] = $this->isCustomPrice($object, $fields);

        return $fields;
    }

    public function prepareFieldsBeforeCreate(array $fields): array {
        $fields['created_by_market_id'] = auth()->guard('twill_users')->user()->getMarketId();

        return parent::prepareFieldsBeforeCreate($fields);
    }

    public function afterSave(TwillModelContract $model, array $fields): void {
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

    public function isCustomPrice($object, $fields) {
        if (! isset($fields['price'])) {
            return false;
        }

        $proposedPrice = $fields['price'];

        $total = self::calcBlocksPrice($object, $fields);

        return (float) $proposedPrice !== (float) $total;
    }

    public static function calcBlocksPrice($object, $fields) {
        $total = 0.0;
        $blocks = Arr::get($fields, 'blocks', null);
        if ($blocks) {
            // Сначала группируем по product_id
            $products = [];
            foreach ($blocks as $block) {
                if ($block['type'] === 'a17-block-products') {
                    $productId = Arr::get($block, 'browsers.products.0.id');
                    $count = (int)Arr::get($block, 'content.count', 0);
                    $prices = array_filter(Arr::get($block, 'browsers.products.0.prices', []), function ($item) {
                        return isset($item['price']) && $item['price'] && !empty($item['price']) && is_numeric($item['price']);
                    });
                    if (!$productId || $count <= 0 || empty($prices)) {
                        continue;
                    }
                    if (!isset($products[$productId])) {
                        $products[$productId] = [
                            'count' => 0,
                            'prices' => $prices,
                        ];
                    }
                    $products[$productId]['count'] += $count;
                }
            }
            // Теперь считаем сумму по каждому продукту
            foreach ($products as $product) {
                $count = $product['count'];
                $prices = $product['prices'];
                // Сортируем цены по quantity_from ASC
                usort($prices, function ($l, $r) {
                    return $l['quantity_from'] <=> $r['quantity_from'];
                });
                // Находим подходящую цену
                $currentPrice = null;
                foreach ($prices as $price) {
                    if ($price['quantity_from'] <= $count) {
                        $currentPrice = $price['price'];
                    }
                }
                // Если не нашли цену, берем минимальную (или пропускаем)
                if ($currentPrice === null && count($prices) > 0) {
                    $currentPrice = $prices[0]['price'];
                }
                if ($currentPrice !== null) {
                    $total += $currentPrice * $count;
                }
            }
        }

        return $total;
    }
}
