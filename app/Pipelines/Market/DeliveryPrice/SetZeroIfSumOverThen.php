<?php

namespace App\Pipelines\Market\DeliveryPrice;

class SetZeroIfSumOverThen
{
    public function handle($data, \Closure $next)
    {

        [$price, $market] = $data;

        $last = $next([$price, $market]);

        $cartPrice = \Cache::driver('array')->rememberForever(
            'attributes.market_id'.$market->id.session_id(),
            function () use ($market) {
                $cart = \Cart::getContent();
                $items = $cart->where('attributes.market_id', '=', $market->id);

                $price = 0.0;

                foreach ($items as $key => $item) {
                    $price += $item->getPriceSumWithConditions();
                }

                return $price;
            }
        );
        if ($cartPrice >= $market->free_delivery_price_order) {
            return [0.0, $market];
        }

        return $last;
    }
}
