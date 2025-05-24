<?php

namespace App\Services;

use App\Models\Color;
use App\Models\Product;
use stdClass;

class CompositeProducts
{
    public function get($price, $is_visible = true, $priceAttribute = 'public_price')
    {
        $blocks = $price->groupProduct?->blocks()->select('content')->where('type', 'products')->get();

        $totalCounts = [];
        if ($blocks) {
            foreach ($blocks as $_block) {
                $ids = $_block->content['browsers']['products'];
                foreach ($ids as $id) {
                    $totalCounts[$id] = ($totalCounts[$id] ?? 0) + $_block->content['count'];
                }
            }
        }

        $blocks = $blocks?->map(function ($block) use ($price, $is_visible, $priceAttribute, $totalCounts) {

            return Product::whereIn('id', $block->content['browsers']['products'])->whereHas('category', function ($q) use ($is_visible) {
                return $q->where('is_visible', $is_visible);
            })->get()->transform(function ($item) use ($block, $price, $priceAttribute, $totalCounts) {
                if (isset($block->content['browsers']['color']) && isset($block->content['browsers']['color'][0])) {
                    $item->color = Color::published()->where('id', $block->content['browsers']['color'][0])->first();
                } else {
                    $item->color = null;
                }
                $item->count = $block->content['count'];
                $item->hiddenCount = $totalCounts[$item->id];

                $item->prices = $item->prices()->where('market_id', $price->market_id)->where('price', '<>', null)->get()->sortByDesc(function ($l, $r) {
                    return $l->quantity_from;
                });

                $item->priceObj = optional($item->prices->filter(function ($e) use ($item) {
                    return $item->hiddenCount >= $e->quantity_from;
                })->first());

                $item->price = $item->priceObj->{$priceAttribute};

                $item->couponFrom = $item->prices->filter(function ($e) use ($item) {
                    return $item->priceObj->quantity_from < $e->quantity_from;
                })->last();

                $item->prices = $item->prices->transform(function ($item) use ($priceAttribute) {
                    $result = new stdClass;
                    $result->quantity_from = $item->quantity_from;
                    $result->price = $item->{$priceAttribute};
                    $result->id = $item->id;

                    return $result;
                });

                return $item;
            });
        });

        if ($blocks) {
            foreach ($blocks as $block) {
                $block->merge($block->values());
            }
        }

        return $blocks;
    }

    public function unvisiblePrice($price, $priceAttribute = 'public_price')
    {
        $blocks = $this->get($price, false, $priceAttribute);
        $total = 0.0;

        if ($blocks) {
            foreach ($blocks as $block) {
                foreach ($block as $product) {
                    $total += $product->price * $product->count;
                }
            }
        }

        return $total;
    }

    public function MonoFlowersData($blocks)
    {
        $name = '';
        $count = 0;

        foreach ($blocks as $block) {
            foreach ($block as $product) {
                $name = $product->title;
                $count += $product->count;
            }
        }

        return [$name, $count];
    }
}
