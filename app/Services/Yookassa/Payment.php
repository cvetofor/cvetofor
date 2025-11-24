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

            // Фильтруем только товары (исключаем доставку и открытку)
            $productItems = array_filter($items, function ($item) {
                return $item['description'] !== 'Доставка' && $item['description'] !== 'Открытка';
            });

            $itemCount = count($productItems);
            if ($itemCount > 0) {
                $pointsPerItem = floor(($points / $itemCount) * 100) / 100; // округление вниз до копеек
                $pointsSum = 0;
                $productIndexes = array_keys($productItems);

                foreach ($productIndexes as $idx => $itemIndex) {
                    // Для последнего товара вычитаем остаток, чтобы сумма совпала
                    if ($idx === count($productIndexes) - 1) {
                        $itemPoints = round($points - $pointsSum, 2);
                    } else {
                        $itemPoints = $pointsPerItem;
                        $pointsSum += $itemPoints;
                    }

                    $oldValue = (float)$items[$itemIndex]['amount']['value'];
                    $newValue = max(0, round($oldValue - $itemPoints, 2));
                    $items[$itemIndex]['amount']['value'] = number_format($newValue, 2, '.', '');
                }

                // Корректировка последнего товара для точного совпадения суммы
                $itemsSum = array_sum(array_map(function ($i) {
                    return (float)$i['amount']['value'] * $i['quantity'];
                }, $items));

                $amountValue = (float)number_format($order->total_price, 2, '.', '');
                $diff = round($amountValue - $itemsSum, 2);

                if (abs($diff) > 0) {
                    $lastProductIndex = end($productIndexes);
                    $newLastValue = (float)$items[$lastProductIndex]['amount']['value'] + $diff;
                    $items[$lastProductIndex]['amount']['value'] = number_format(
                        max(0, $newLastValue),
                        2,
                        '.',
                        ''
                    );
                }
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

        curl_close($ch);
        if (isset(json_decode($res, true)['confirmation']['confirmation_url'])) {
            return json_decode($res, true)['confirmation']['confirmation_url'];
        } else {
            \Log::channel('marketplace')->info('Ошибка кассы', ['orderId_link' =>$res]);
            return null;
        }
    }
}
