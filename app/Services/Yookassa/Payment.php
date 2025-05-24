<?php

namespace App\Services\Yookassa;

use App\Models\Delivery;

class Payment
{
    private $fields = [];

    public function __construct($shopId, $apiKey)
    {
        $this->fields['shopId'] = $shopId;
        $this->fields['apiKey'] = $apiKey;
    }

    public function getPaymentUrl($order)
    {
        $headers = [
            'Idempotence-Key: '.$order->id.time(),
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
            'description' => 'Оплата заказа #'.$order->num_order.', для '.$customerName,
            'metadata' => [
                'order_id' => $order->id,
            ],
        ];

        $data = json_encode($params, JSON_UNESCAPED_UNICODE);
        $ch = curl_init('https://api.yookassa.ru/v3/payments');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_USERPWD, $this->fields['shopId'].':'.$this->fields['apiKey']);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $res = curl_exec($ch);
        curl_close($ch);
        if (isset(json_decode($res, true)['confirmation']['confirmation_url'])) {
            return json_decode($res, true)['confirmation']['confirmation_url'];
        } else {
            return null;
        }
    }
}
