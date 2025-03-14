<?php

namespace App\Services;

use App\Models\Color;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Services\CompositeProducts;
use Illuminate\Support\Facades\Log;

class PriceService {
    function calc(ProductPrice $price, $compositions = [], $priceAttribute = 'public_price'): CalcResponse {
        # Цикл по товарам, который выбрал пользователь в букете
        # Цикл по указанным блокам в букете
        $blocks = $price->groupProduct?->blocks()->where('type', 'products')->get();

        $totalCounts = [];
        $count = [];
        if ($blocks) {
            $i = 0;
            foreach ($blocks as $_block) {
                $ids = $_block->content['browsers']['products'];
                foreach ($ids as $id) {
                    if (isset($compositions["product[$id][$i]"]['count'])) {
                        $count[$id] = $compositions["product[$id][$i]"]['count'];
                        $i++;
                    }
                    $totalCounts[$id] = ($totalCounts[$id] ?? 0) + $_block->content['count'];
                }
            }
        }


        if ($blocks) {
            $blocks = $blocks->transform(function ($block) use ($totalCounts, $count) {
                $product = Product::find(\Arr::get($block->content, 'browsers.products.0'));

                if (
                    $product &&
                    isset($product->category) &&
                    $product->category->is_visible
                ) {
                    return [
                        'count'       => $count[\Arr::get($block->content, 'browsers.products.0')] ?? \Arr::get($block->content, 'count'),
                        'product'     => \Arr::get($block->content, 'browsers.products.0'),
                        'color'       => \Arr::get($block->content, 'browsers.color.0'),
                        'rgb' => \Arr::get($block->content, 'browsers.color.0') 
                            ? optional(Color::find(\Arr::get($block->content, 'browsers.color.0')))->data['rgb'] ?? ''
                            : '',
                        'title'       => $product->title,
                        'hiddenCount' => $totalCounts[\Arr::get($block->content, 'browsers.products.0')],
                    ];
                }
                return null;
            })->filter()->toArray();
        }



        $condition = null;
        $conditionPrice = 0.0;
        if ($compositions) {

            $total = (new CompositeProducts)->unvisiblePrice($price, $priceAttribute);

            // Пройденные индексы, чтобы если были повторяющиеся элементы с одинаковым ID, он не брал количество не того элемента
            $visited = [];

            foreach ($compositions as $key => $composition) {
                $this->__findProduct($composition, $price, $key, $blocks, $conditionPrice, $total, $visited, $priceAttribute);
            }

            if ($conditionPrice !== 0) {
                $condition = new \Darryldecode\Cart\CartCondition(
                    array(
                        'name'   => 'Скидка',
                        'type'   => 'coupon',
                        'target' => 'total',
                        // this condition will be applied to cart's subtotal when getSubTotal() is called.
                        'value'  => -round($conditionPrice),
                    )
                );
            }

            return new CalcResponse(
                $total,
                $total - round($conditionPrice),
                $condition,
                $blocks
            );
        }
        return new CalcResponse(
            $price->{$priceAttribute},
            $price->{$priceAttribute} - round($conditionPrice),
            $condition,
            $blocks
        );
    }

    /**
     *
     * @param mixed $composition
     * @param mixed $price
     * @param mixed $key
     * @param mixed $blocks
     * @param mixed $conditionPrice
     * @param mixed $total
     * @param mixed $visited
     * @param mixed $priceAttribute
     * @return void
     */
    private function __findProduct($composition, $price, $key, &$blocks, &$conditionPrice, &$total, &$visited, $priceAttribute) {
        $userCount = (int) $composition['count'];
        $userColor = $composition['color'];
        $hiddenCount = $composition['hiddenCount'];


        $userPriceId = $composition['id'] ?? ProductPrice::published()
            ->where('market_id', $price->market_id)
            ->where('product_id', $composition['product'])
            ->where('price', '<>', null)
            ->where('price', '<>', 0)
            ->get()
            ->sortByDesc(
                function ($l, $r) {
                    return $l->quantity_from;
                }
            )
            ->filter(
                function ($e) use ($composition, $hiddenCount) {
                    return $hiddenCount >= $e->quantity_from;
                }
            )
            ->first()->id ?? false;

        $userPrice = ProductPrice::find($userPriceId);

        $userProductId = $composition['product'] ?? explode('.', str_replace(['[', ']', '..'], ['.', '.', '.'], $key))[1];
        if ($blocks) {
            foreach ($blocks as $k => $block) {

                if (
                    $userColor == $block['color'] &&
                    $userProductId == $block['product'] &&
                    $userCount >= $block['count'] &&
                    !in_array($k, $visited)
                ) {
                    $visited[] = $k;

                    $blocPrice = ProductPrice::published()
                        ->where('market_id', $price->market_id)
                        ->where('product_id', $block['product'])
                        ->where('price', '<>', null)
                        ->where('price', '<>', 0)
                        ->get()
                        ->sortByDesc(
                            function ($l, $r) {
                                return $l->quantity_from;
                            }
                        )
                        ->filter(
                            function ($e) use ($block, $hiddenCount) {
                                # берем старую цену
                                return $hiddenCount >= $e->quantity_from;
                            }
                        )->first();



                    if ($blocPrice->id !== $userPrice->id && $userCount != $block['count']) {
                        $conditionPrice += ($blocPrice->{$priceAttribute} * $userCount) - ($userPrice->{$priceAttribute} * $userCount);
                    }

                    # Считаем по старой цене, чтобы потом положить разницу в Скидку
                    $total += ($blocPrice->{$priceAttribute} * $userCount);
                    $blocks[$k]['count'] = $userCount;
                    break;
                }
            }
        }

        unset($userCount, $userColor);
    }
}


class CalcResponse {
    public $condition;
    public $total = 0.0;

    public $totalWithContitions = 0.0;

    public $blocks = [];

    public function __construct($total, $totalWithContitions, ?\Darryldecode\Cart\CartCondition $condition, $blocks) {
        $this->condition = $condition;
        $this->total = round($total);
        $this->totalWithContitions = round($totalWithContitions);
        $this->blocks = $blocks;
    }
}
