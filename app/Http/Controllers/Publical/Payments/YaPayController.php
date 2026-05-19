<?php

namespace App\Http\Controllers\Publical\Payments;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\UDS\Bonus;
use Illuminate\Http\Request;

class YaPayController extends Controller
{
    public function callback(Request $request)
    {
        $jwt = file_get_contents('php://input'); // или $request->getContent()

        info($request->url());
        info($request->ip());
        info($jwt);
        info($request->all());

        list($header, $payload, $signature) = explode('.', $jwt);


// Декодируем payload (base64url)
        $payloadJson = base64_decode(strtr($payload, '-_', '+/'));
        $data = json_decode($payloadJson, true);
info($data);

// Логируем
        \Log::channel('marketplace')->info('Webhook payload: ' . json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        if (!isset($data['order'])) {
            return;
        }
        if (!isset($data['order']['paymentStatus'])) {
            return;
        }
        if (!isset($data['order']['orderId'])) {
            return;
        }

        $order_ids = explode("_", $data['order']['orderId']);
        if (count($order_ids) != 3) {
            return;
        }
        $orderId = $order_ids[1];
        if ($data['order']['paymentStatus'] != 'CAPTURED') {

            return '';
        }


        $order = Order::where('id', ($orderId+1))->first();
        \Log::channel('marketplace')->info('ORDER DATA: ', [$order]);
        if (!$order) {
            return;
        }

        \Log::channel('marketplace')->info('Оплата прошла успешно по заказу №: ' . $order['num_order']);
        $uds = new Bonus($order->market_id);
        if (isset($order->uds_points, $order->uds_code) && $order->uds_points > 0 && $order->uds_code > 0) {
            $res = $uds->createOperation($order->uds_code, $order->total_price);
        } else if ($order->uds_code > 0 && $order->uds_points == 0) {
            $res = $uds->reward($order->uds_code, $order->total_price);
        }

        $order->payment_status_id = 2;
        $order->save();


        /* if (isset($order) && $json['event'] == 'payment.succeeded') {

         } elseif (isset($order) && $json['event'] == 'refund.succeeded') {
             \Log::channel('marketplace')->info('Возврат прошел успешно по заказу №: ' . $order['num_order']);

             $order->payment_status_id = 3;
             $order->save();
         }*/
    }

    public function redirect(Request $request)
    {
        $orderId = $request['orderId']+1;

        $order = Order::where('id', $orderId )->first();

        if (!isset($order->payment_status_id) || $order->payment_status_id == 1) {
            \Log::channel('marketplace')->error('Ошибка или отказ от оплаты orderId= ' . $orderId);

            return view('order.fail');
        } elseif ($order->payment_status_id == 2) {
            return redirect()->to('https://xn--b1ag1aakjpl.xn--p1ai/order/' . $order->uuid);
        }
    }
}
