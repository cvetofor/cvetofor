<?php

namespace App\Http\Controllers\Publical;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UDSController extends Controller {
    public function check(Request $request) {




        session()->forget(['promocode_used', 'promocod_id', 'promocod_used_amount', 'promocod__new_total', 'promocod__old_total','promocod__delivery']);
        if(session()->has('promocode_used')){
            return response()->json([
                'success' => false,
                'message' => 'Невозможно использовать промокод и UDS'
            ]);
        }
        $total = $request->input('total');
        if ($total < 1000) {
            return response()->json([
                'success' => false,
                'message' => 'Сумма заказа должна быть больше 1000 р.'
            ]);
        }

        // Получаем market_id через CitiesService
        $city = \App\Services\CitiesService::getCity();
        $market = $city->markets()->published()->first();
        $market_id = $market ? $market->id : null;

        $uds = new \App\Services\UDS\Bonus($market_id);
        $promo = $request->input('uds_promo');

        // Сохраняем промокод в сессию
        session(['uds_code' => $promo]);

        $calcOpearation = $uds->calcCashOperation($promo, $total);

        if (isset($calcOpearation->purchase)) {
            if(isset($calcOpearation->purchase->certificatePoints)&&$calcOpearation->purchase->certificatePoints>0){
                return response()->json([
                    'success' => true,
                    'points' => $calcOpearation->purchase->certificatePoints,
                ]);
            }
            if(isset($calcOpearation->purchase->points) ){
                return response()->json([
                    'success' => true,
                    'points' => $calcOpearation->purchase->points,
                ]);
            }


        } else {
            return response()->json([
                'success' => false,
                'message' => 'Промокод не найден.'
            ]);
        }
    }

    public function create(Request $request) {
        $points = (int) $request->input('points', 0);
        $oldTotal = (float) $request->input('old_total', 0);
        $newTotal = max(0, $oldTotal - $points);
        session([
            'uds_points_used' => true,
            'uds_points_amount' => $points,
            'uds_new_total' => $newTotal,
            'uds_old_total' => $oldTotal
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Баллы будут списаны после оплаты.',
            'oldTotal' => $oldTotal,
            'newTotal' => $newTotal,
            'points' => $points
        ]);
    }

    public function reset(Request $request) {
        // Сначала получаем старую сумму
        $oldTotal = session('uds_old_total');
        // Потом очищаем сессию
        session()->forget(['uds_points_used', 'uds_points_amount', 'uds_new_total', 'uds_old_total', 'uds_code']);
        if ($request->ajax()) {
            if ($oldTotal !== null) {
                return response()->json([
                    'success' => true,
                    'total' => $oldTotal
                ]);
            }
            // Вернуть актуальную сумму заказа и доставки
            $cartTotal = \Cart::getTotal();
            $cart = \Cart::getContent();
            $cartByMarket = $cart->sortBy('attributes.order')->groupBy('attributes.market_id');
            $totalDeliveryPrice = 0.0;
            foreach ($cartByMarket as $market) {
                $first = $market->first();
                if (!isset($first->associatedModel) || !isset($first->associatedModel->market)) {
                    continue;
                }
                $marketModel = $first->associatedModel->market;
                if ($marketModel) {
                    $totalDeliveryPrice += $marketModel->delivery_price ?? 0;
                }
            }
            $total = $cartTotal + $totalDeliveryPrice;
            return response()->json([
                'success' => true,
                'total' => $total
            ]);
        }
        // Если не AJAX — редиректим обратно на страницу заказа
        return redirect()->route('order.index');
    }

    public function reward(Request $request) {
        return response()->json([
            'success' => true,
            'message' => 'Бонусы будут начислены после оплаты.'
        ]);
    }
}
