<?php

namespace App\Services\Yookassa;

use App\Models\Delivery;

class Payment {
    private $fields = [];

    public function __construct($shopId, $apiKey) {
        $this->fields['shopId'] = $shopId;
        $this->fields['apiKey'] = $apiKey;
    }

    public function getPaymentUrl($order) {
        $headers = [
            'Idempotence-Key: ' . $order->id . time(),
            'Content-Type: application/json',
        ];

        foreach ($order->cart as $product) {
            $items[] = [
                'description' => $product['name'],
                'amount' => [
                    'value' => number_format($product['price'], 2, '.', ''),
                    'currency' => 'RUB',
                ],
                'vat_code' => $order->payment->vat,
                'quantity' => $product['quantity'],
            ];
        }

        $delivery = Delivery::where('order_id', $order->id + 1)->first();

        if (isset($delivery) && $delivery->price != 0) {
            array_push($items, [
                'description' => 'Доставка',
                'amount' => [
                    'value' => number_format($delivery->price, 2, '.', ''),
                    'currency' => 'RUB',
                ],
                'vat_code' => $order->payment->vat,
                'quantity' => 1,
            ]);
        }

        if (!empty($order->uds_points) && $order->uds_points > 0 && count($items) > 0) {
            $points = $order->uds_points;
            $itemCount = count($items);
            $pointsPerItem = floor(($points / $itemCount) * 100) / 100; // округление вниз до копеек
            $pointsSum = 0;
            foreach ($items as $i => $item) {
                // Для последнего item вычитаем остаток, чтобы сумма совпала
                if ($i === $itemCount - 1) {
                    $itemPoints = round($points - $pointsSum, 2);
                } else {
                    $itemPoints = $pointsPerItem;
                    $pointsSum += $itemPoints;
                }
                $oldValue = (float)$items[$i]['amount']['value'];
                $newValue = max(0, round($oldValue - $itemPoints, 2));
                $items[$i]['amount']['value'] = number_format($newValue, 2, '.', '');
            }
            // Корректировка последнего item для точного совпадения суммы
            $itemsSum = array_sum(array_map(function ($i) {
                return $i['amount']['value'] * $i['quantity'];
            }, $items));
            $amountValue = (float)number_format($order->total_price, 2, '.', '');
            $diff = round($amountValue - $itemsSum, 2);
            if (abs($diff) > 0) {
                $lastIdx = count($items) - 1;
                $items[$lastIdx]['amount']['value'] = number_format(
                    (float)$items[$lastIdx]['amount']['value'] + $diff,
                    2,
                    '.',
                    ''
                );
            }
        }

        $customerName = $order->email ?? $order->phone;

        $params = [
            'amount' => [
                'value' => number_format($order->total_price, 2, '.', ''),
                'currency' => 'RUB',
            ],
            'confirmation' => [
                'type' => 'redirect',
                'return_url' => route('payments.gateway.yookassa.return', ['orderId' => $order->id]),
            ],
            'receipt' => [
                'customer' => [
                    'email' => $order->email,
                    'phone' => preg_replace('/[^0-9]/', '', $order->phone),
                ],
                'items' => $items,
                'tax_system_code' => $order->payment->tax_system_code,
            ],
            'capture' => true,
            'description' => 'Оплата заказа #' . $order->num_order . ', для ' . $customerName,
            'metadata' => [
                'order_id' => $order->id,
            ],
        ];


        $data = json_encode($params, JSON_UNESCAPED_UNICODE);
        $ch = curl_init('https://api.yookassa.ru/v3/payments');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_USERPWD, $this->fields['shopId'] . ':' . $this->fields['apiKey']);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $res = curl_exec($ch);

        \Log::channel('marketplace')->info('YOOKASSA_PARAMS', [
            'amount' => $params['amount'],
            'items' => $items,
            'items_sum' => array_sum(array_map(function ($i) {
                return $i['amount']['value'] * $i['quantity'];
            }, $items)),
            'total_price' => $order->total_price,
            'json' => $params,
            'res' => $res,
            'uds' => $order->uds_points
        ]);

        curl_close($ch);
        if (isset(json_decode($res, true)['confirmation']['confirmation_url'])) {
            return json_decode($res, true)['confirmation']['confirmation_url'];
        } else {
            return null;
        }
    }
}
