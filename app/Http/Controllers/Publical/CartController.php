<?php

namespace App\Http\Controllers\Publical;

use App\Http\Controllers\Controller;
use App\Models\ProductPrice;
use App\Services\CatalogService;
use App\Services\Defenders\ProductPriceDefender;
use App\Services\PriceService;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;

class CartController extends Controller {
    public function index(ProductPriceDefender $productPriceDefender) {
        SEOTools::setTitle('Корзина');
        SEOTools::metatags()->setRobots('noindex, nofollow');

        $cart = $productPriceDefender->checkRottenProducts(\Cart::getContent(), $canGoToNext);

        $cartByMarket = $cart->sortBy('attributes.order')->groupBy('attributes.market_id');
        $recomendations = [];

        $totalDeliveryPrice = 0.0;

        foreach ($cartByMarket as $market) {
            $market = \App\Models\Market::where('id', $market->first()?->associatedModel?->market?->id)->first();
            $totalDeliveryPrice += $market?->delivery_price ?? 0;

            if ($market) {
                $recomendations[$market->id] = CatalogService::getRecomendations($market->id)->shuffle();
            }
        }

        return view('cart', compact('cart', 'cartByMarket', 'totalDeliveryPrice', 'recomendations', 'canGoToNext'));
    }

    public function putAdditional($id) {
        $items = \Cart::getContent();
        $price = ProductPrice::find($id);

        if (! $price->published || ! $price->price) {
            return response()->json([
                'message' => 'Нет в наличии',
            ], 404);
        }

        foreach ($items as $item) {
            if ($price->market->city_id !== $item->associatedModel->market->city_id) {
                return response()->json([
                    'message' => 'В корзине есть товары из другого региона',
                    'modal' => 'cart-region',
                    'city' => $item->associatedModel->market->city->city,
                ], 403);
            }
        }

        \Cart::add([
            'id' => md5($price->id),
            'name' => $price->product->title,
            'price' => $price->public_price,
            'quantity' => 1,
            'attributes' => [
                'market_id' => $price->market_id,
                'order' => $price->id,
                'recomendation' => true,
            ],
            'associatedModel' => $price,
        ]);

        return response()->json(['data' => $price->sku, 'count' => \Cart::getTotalQuantity()]);
    }

    public function put(ProductPrice $price, Request $request, ProductPriceDefender $productPriceDefender, PriceService $priceService) {
        $items = \Cart::getContent();

        if (! $price->published || ! $price->price || $productPriceDefender->isProductNotPublished($price)) {
            return response()->json([
                'message' => 'Нет в наличии',
            ], 404);
        }

        foreach ($items as $item) {
            if (isset($item->associatedModel) && $price->market->city_id !== $item->associatedModel->market->city_id) {
                return response()->json([
                    'message' => 'В корзине есть товары из другого региона',
                    'modal' => 'cart-region',
                    'city' => $item->associatedModel->market->city->city,
                ], 403);
            }
        }

        $calculated = $priceService->calc($price, $request->get('composition'));

        // У полностью одинаковых товаров будут одинаковый id и поменяется только quanity
        $id = md5(json_encode(['sku' => $price->sku, $calculated->blocks]));

        $totalPrice = is_numeric($request->price) ? $request->price : $calculated->total;


        $price->category_id=$price->groupProduct->category_id??NULL;
        $price->tags=$price->groupProduct->tags->pluck('id')->toArray()??[];

        \Cart::add([
            'id' => $id,
            'name' => $price->groupProduct->title ?? $price->product->title ?? 'Товар',
            'price' => $totalPrice,
            'quantity' => 1,
            'attributes' => [
                'market_id' => $price->market_id,
                'order' => $price->id,
                'composition' => $calculated->blocks,
            ],
            'associatedModel' => $price,
            'conditions' => $calculated->condition ?? null,
        ]);

        $cart = \Cart::getContent();
        $totalDeliveryPrice = 0.0;
        $cartByMarket = $cart->sortBy('attributes.order')->groupBy('attributes.market_id');
        foreach ($cartByMarket as $market) {
            $market = \App\Models\Market::where('id', $market->first()?->associatedModel?->market?->id)->first();
            $totalDeliveryPrice += $market?->delivery_price ?? 0;
        }

        return response()->json(['data' => $price->sku, 'count' => \Cart::getTotalQuantity()]);
    }

    public function clear() {
        \Cart::clearCartConditions();

        return response()->json(['status' => \Cart::clear(), 'count' => \Cart::getTotalQuantity()]);
    }

    public function plus($price) {
        \Cart::update($price, [
            'quantity' => 1,
        ]);

        return response()->json(['data' => $price, 'count' => \Cart::getTotalQuantity()]);
    }

    public function minus($price) {
        \Cart::update($price, [
            'quantity' => -1,
        ]);

        return response()->json(['data' => $price, 'count' => \Cart::getTotalQuantity()]);
    }

    public function remove($price) {
        \Cart::remove($price);

        return response()->json(['data' => $price, 'count' => \Cart::getTotalQuantity()]);
    }
}
