<?php

namespace App\Http\Controllers\Publical;

use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Fields\Select;
use App\Http\Controllers\Controller;
use App\Models\Market;
use App\Models\Order;
use App\Models\Promocod;
use App\Models\PromocodList;
use Illuminate\Http\Request;

class PromocodeController extends Controller
{
    public function getDelivery()
    {
        $cart = \Cart::getContent();
        $cartByMarket = $cart->sortBy('attributes.order')->groupBy('attributes.market_id');
        $totalDeliveryPrice = 0.0;


        $markets = [];
        foreach ($cartByMarket as $market) {
            $markets[] = Market::find($market->first()->associatedModel->market->id);

            $totalDeliveryPrice += end($markets)?->delivery_price ?? 0;

        }

        return $totalDeliveryPrice;
    }

    public function check(Request $request)
    {

        $totalDeliveryPrice = $this->getDelivery();
        if (session()->has('uds_points_used')) {
            return response()->json([
                'success' => false,
                'message' => 'Невозможно использовать промокод и UDS'
            ]);
        }

        $code = $request->get('promocode');

        $promolist=PromocodList::where('code',$code)->first();
        if(!$promolist){
            return response()->json([
                'success' => false,
                'message' => 'Промокод не найден'
            ]);
        }

        $promo = Promocod::where('id', $promolist->promocod_id)->first();
        if (!$promo) {


            return response()->json([
                'success' => false,
                'message' => 'Промокод не найден'
            ]);
        }


        if (date('Y-m-d',strtotime($promo->date_start)) > date('Y-m-d',strtotime('+5 hours')) || date('Y-m-d',strtotime($promo->date_end)) < date('Y-m-d',strtotime('+5 hours'))) {
            return response()->json([
                'success' => false,
                'message' => 'Промокод не найден по сроку'
            ]);
        }

        if ($promo->minimal_sum_cart > \Cart::getTotal()+$totalDeliveryPrice) {
            return response()->json([
                'success' => false,
                'message' => 'Сумма корзины должна быть больше чем ' . $promo->minimal_sum_cart
            ]);
        }
        $botName = session('bot_name') ?? request()->cookie('bot_name');
        if ($promo->platform == 'site' && $botName != '') {
            return response()->json([
                'success' => false,
                'message' => 'Промокод не доступен для применения на сайте '
            ]);
        }
        if ($promo->platform == 'telegram' && $botName == '') {
            return response()->json([
                'success' => false,
                'message' => 'Промокод не доступен для применения в телеграм '
            ]);
        }

        if (in_array($promo->type_sale, [2, 3, 4]) && $totalDeliveryPrice == 0) {

            return response()->json([
                'success' => false,
                'message' => 'Невозможно применить промокод, доставка бесплатная '
            ]);

        }


        $countPromoOrderTotal = Order::where('promocod_id', $promo->id)->whereNull('parent_id')->count();
        if ($promo->total_limit <= $countPromoOrderTotal) {
            return response()->json([
                'success' => false,
                'message' => 'Промокод не доступен по количетву использований '
            ]);
        }

        $totalSumm = \Cart::getTotal();
        $totalSummForPromocode = $totalSumm;
        //categories tags
        if (count($promo->CategoryIds) > 0 || count($promo->TagIds) > 0) {
            $totalSummForPromocode = 0;
            $cart = \Cart::getContent();
            $array_group_products = [];
            foreach ($cart as $item) {

                if (count($promo->CategoryIds) > 0 && count($promo->TagIds) > 0 && in_array($item->associatedModel->category_id, $promo->CategoryIds) && array_intersect($item->associatedModel->tags, $promo->TagIds)) {

                    $totalSummForPromocode = +$item->price * $item->quantity;
                }
                if (count($promo->CategoryIds) > 0 && count($promo->TagIds) == 0 && in_array($item->associatedModel->category_id, $promo->CategoryIds)) {
                    $totalSummForPromocode = +$item->price * $item->quantity;

                }
                if (count($promo->CategoryIds) == 0 && count($promo->TagIds) > 0 && array_intersect($item->associatedModel->tags, $promo->TagIds)) {
                    $totalSummForPromocode = +$item->price * $item->quantity;

                }


            }

            if ($totalSummForPromocode == 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Промокод не доступен по категориям и поводам '
                ]);
            }

            if ($promo->minimal_sum_cart > $totalSummForPromocode) {
                return response()->json([
                    'success' => false,
                    'message' => 'Сумма корзины должна быть больше чем ' . $promo->minimal_sum_cart
                ]);
            }
        }

        $points = 0;
        $oldTotal = $totalDeliveryPrice + $totalSumm;
        $newTotal = $oldTotal;
        if (in_array($promo->type_sale, [2, 3, 4])) {
            if ($promo->type_sale == 2) {
                $points = $totalDeliveryPrice;
                $totalDeliveryPrice = 0;
            }
            if ($promo->type_sale == 3) {
                $totalDeliveryPriceSale = $totalDeliveryPrice - ($totalDeliveryPrice * ($promo->sale / 100));
                $points = $totalDeliveryPriceSale;
                $totalDeliveryPrice = round($totalDeliveryPriceSale);

            }
            if ($promo->type_sale == 4) {

                $points = $promo->sale > $totalDeliveryPrice ? $totalDeliveryPrice : $promo->sale;
                $totalDeliveryPrice = $promo->sale > $totalDeliveryPrice ? 0 : $totalDeliveryPrice - $promo->sale;

            }
            $newTotal = $newTotal - $points;

        }
        if (in_array($promo->type_sale, [0, 1])) {

            if ($promo->type_sale == 1) {

                $points = $this->getCheckMaxSale($promo, $totalSummForPromocode * ($promo->sale / 100), $totalSumm);


            }
            if ($promo->type_sale == 0) {


                $points = $this->getCheckMaxSale($promo, $promo->sale > $totalSummForPromocode ? $totalSummForPromocode : $promo->sale, $totalSumm);

            }
            $newTotal = $newTotal - $points ;//+ $totalDeliveryPrice;

        }


        session([
            'promocode_used' => true,
            'promocod_id' => $promo->id,
            'promocod_used_amount' => $points,
            'promocod__new_total' => round($newTotal),
            'promocod__old_total' => $oldTotal,
            'promocod__delivery' => $totalDeliveryPrice,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Промокод применен',
            'oldTotal' => $oldTotal,
            'newTotal' => round($newTotal),
            'points' => $points,
            'delivery' => $totalDeliveryPrice
        ]);

    }

    public function getCheckMaxSale($promo, $points, $oldTotal)
    {
        if ($promo->sum_max_sale < 1) {
            return $points;
        }

        if ($promo->type_max_sale == 0 && $points > $promo->sum_max_sale) {

            return $promo->sum_max_sale;

        }
        if ($promo->type_max_sale == 1 && $points > $promo->sum_max_sale) {


            $maxDiscount = $oldTotal * $promo->sum_max_sale / 100;
            if ($points > $maxDiscount) {
                $points = $maxDiscount;
            }

        }


        return $points;
    }


}
