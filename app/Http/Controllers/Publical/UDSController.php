<?php

namespace App\Http\Controllers\Publical;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UDSController extends Controller {
    public function check(\Illuminate\Http\Request $request) {
        $promo = $request->input('uds_promo');
        // Здесь должна быть логика обращения к UDS API
        // Пока что просто пример:

        if ($promo === '111555') {
            return response()->json([
                'success' => true,
                'points' => 1
            ]);
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
        // Сохраняем в сессию
        session([
            'uds_points_used' => true,
            'uds_points_amount' => $points,
            'uds_new_total' => $newTotal,
            'uds_old_total' => $oldTotal
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Баллы списаны',
            'oldTotal' => $oldTotal,
            'newTotal' => $newTotal,
            'points' => $points
        ]);
    }

    public function reset(Request $request) {
        // Сначала получаем старую сумму
        $oldTotal = session('uds_old_total');
        // Потом очищаем сессию
        session()->forget(['uds_points_used', 'uds_points_amount', 'uds_new_total', 'uds_old_total']);
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
}
