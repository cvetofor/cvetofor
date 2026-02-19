<?php

namespace App\Services\Defenders;

use App\Models\ProductPrice;
use App\Services\PriceService;

/**
 * Проверяет товары перед покупкой
 */
class ProductPriceDefender {
    protected $priceService;

    public function __construct(PriceService $priceService) {
        $this->priceService = $priceService;
    }

    public function checkRottenProducts(\Darryldecode\Cart\CartCollection $cart, &$canGoToNextStepOrder = true) {
        $this->removePostCard($cart);
        $canGoToNextStepOrder = true;
        foreach ($cart as $item) {
            $price = ProductPrice::where('id', $item->associatedModel->id ?? false)->first();

            if ($price) {
                if (
                    $this->isProductNotPublished($price) ||
                    (round($price->public_price * $item->quantity) !== round($item->getPriceSumWithConditions()) && $price->is_custom_price) ||
                    $item->getPriceSumWithConditions() == 0
                ) {
                    // $canGoToNextStepOrder = false;
                    \Cart::update(
                        $item->id,
                        [
                            'attributes' => array_merge(
                                $item['attributes']->toArray() ?? [],

                                [
                                    'hidden' => true,
                                ]
                            ),
                        ]
                    );
                } else {
                    \Cart::update(
                        $item->id,
                        [
                            'attributes' => array_merge(
                                $item['attributes']->toArray() ?? [],
                                [
                                    'hidden' => false,
                                ]
                            ),
                        ]
                    );
                }

                if ((float) $price->public_price !== (float) $item->getPriceSum() * $item->quantity) {
                    // Смотрим цену и чтобы композиция была одинаковой
                    if (! $price->is_custom_price) {
                        $calculated = $this->priceService->calc($price, $item['attributes']['composition']??[]);

                        if ((float) $calculated->total !== (float) $item->getPriceSum() * $item->quantity) {
                            \Cart::update(
                                $item->id,
                                [
                                    'price' => $calculated->total,
                                    'conditions' => $calculated->condition ?? null,
                                ]
                            );
                        }
                    }
                }
            }
        }

        return \Cart::getContent();
    }

    public function removePostCard($cart) {
        foreach ($cart as $item) {
            if ($item->name == 'Открытка') {
                \Cart::remove($item->id);
            }
        }
    }

    public function isProductNotPublished($price) {
        if ($price->published === false) {
            return true;
        }
        if (!$price->market || !$price->market->isActive()) {
            return true;
        }
        $remain = $price->remain->first();
        if (!$remain || $remain->published === false) {
            return true;
        }
        return false;
    }
}
