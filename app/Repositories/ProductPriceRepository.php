<?php

namespace App\Repositories;

use App\Models\Product;
use A17\Twill\Models\Block;
use App\Models\GroupProduct;
use App\Models\ProductPrice;
use A17\Twill\Repositories\ModuleRepository;
use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Repositories\Behaviors\HandleRevisions;

class ProductPriceRepository extends ModuleRepository
{
    use HandleRevisions;

    public function __construct(ProductPrice $model)
    {
        $this->model = $model;
    }


    public function afterSave(TwillModelContract $model, array $fields): void
    {
        self::recalculate($model);


        parent::afterSave($model, $fields);
    }

    /**
     * Пересчитать стоимость товаров
     */
    public static function recalculate(ProductPrice|Product $model, $marketId = null)
    {
        $product = is_a($model, ProductPrice::class) ? $model->product : $model;
        $marketId = $marketId ?: auth('twill_users')->user()->getMarketId();



        if ($product && $model->published && $marketId) {

            # Обновим все цветы, у которых есть данный продукт

            $groupProductsId = Block::where('type', 'products')->where('content->browsers->products->0', $product->id)->get()->pluck('blockable_id');

            $groupProducts = GroupProduct::whereIn('id', $groupProductsId)->get();

            foreach ($groupProducts as $groupProduct) {

                $priceObj = $groupProduct->priceObj()->whereMarketId($marketId)->first();

                if ($priceObj && !$priceObj->is_custom_price) {

                    $total = 0.0;
                    $blocks = $groupProduct->blocks()->where('type', 'products')->get();

                    $blocks = $blocks->transform(function ($block) {
                        return [
                            'count'   => \Arr::get($block->content, 'count'),
                            'product' => \Arr::get($block->content, 'browsers.products.0'),
                        ];
                    })->filter()->toArray();

                    foreach ($blocks as $k => $block) {
                        $blocPrice = ProductPrice::published()
                            ->where('market_id', $marketId)
                            ->where('product_id', $block['product'])
                            ->where('price', '<>', null)
                            ->where('price', '<>', 0)
                            ->get()->sortByDesc(function ($l, $r) {
                                return $l->quantity_from;
                            })->filter(function ($e) use ($block) {
                            return $block['count'] >= $e->quantity_from;
                        })->first();


                        if (!$blocPrice) {
                            $total = false;
                            break;
                        }

                        $total += ($blocPrice->price * $block['count']);
                    }

                    if ($total !== false) {
                        $priceObj->price = $total;
                        $priceObj->save();
                    }
                }
            }
        }
    }
}
