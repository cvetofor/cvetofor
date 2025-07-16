<?php

namespace App\Http\Controllers\Publical\Payments;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\UDS\Bonus;
use Illuminate\Http\Request;

class YookassaController extends Controller {
    public function callback(Request $request) {
        $json = $request->all();
        \Log::channel('marketplace')->info('ЮKassa http-уведомление: ', [$json]);

        if (isset($json['object']['metadata']['order_id'])) {
            $order = Order::where('id', $json['object']['metadata']['order_id'] + 1)->first();
            \Log::channel('marketplace')->info('ORDER DATA: ', [$order]);
        }

        if (isset($order) && $json['event'] == 'payment.succeeded') {
            \Log::channel('marketplace')->info('Оплата прошла успешно по заказу №: ' . $order['num_order']);
            $uds = new Bonus();
            if (isset($order->uds_points, $order->uds_code) && $order->uds_points > 0 && $order->uds_code > 0) {
                $res = $uds->createOperation($order->uds_code, $order->total_price + $order->uds_points);
            } else if ($order->uds_code > 0 && $order->uds_points == 0) {
                $res = $uds->reward($order->uds_code, $order->total_price);
            }

            $order->uds_code = 0;
            $order->uds_points = 0;
            $order->payment_status_id = 2;
            $order->save();
        } elseif (isset($order) && $json['event'] == 'refund.succeeded') {
            \Log::channel('marketplace')->info('Возврат прошел успешно по заказу №: ' . $order['num_order']);

            $order->payment_status_id = 3;
            $order->save();
        }
    }

    public function redirect(Request $request) {
        $orderId = $request['orderId'];

        $order = Order::where('id', $orderId + 1)->first();

        if (! isset($order->payment_status_id) || $order->payment_status_id == 1) {
            \Log::channel('marketplace')->error('Ошибка или отказ от оплаты orderId= ' . $orderId);

            return view('order.fail');
        } elseif ($order->payment_status_id == 2) {
            return redirect()->to('https://xn--b1ag1aakjpl.xn--p1ai/order/' . $order->uuid);
        }
    }
}
