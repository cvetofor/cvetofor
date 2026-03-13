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

                $pointsSum = 0;
                $productIndexes = array_keys($productItems);

                // 🔹 НОВОЕ: считаем общую сумму товаров С УЧЁТОМ quantity
                $totalProductsSum = 0;
                foreach ($productIndexes as $index) {
                    $totalProductsSum +=
                        (float)$items[$index]['amount']['value']
                        * $items[$index]['quantity'];
                }

                foreach ($productIndexes as $idx => $itemIndex) {

                    // 🔹 НОВОЕ: считаем сумму строки (цена × количество)
                    $rowSum =
                        (float)$items[$itemIndex]['amount']['value']
                        * $items[$itemIndex]['quantity'];

                    // Для последнего товара вычитаем остаток
                    if ($idx === count($productIndexes) - 1) {
                        $itemPoints = round($points - $pointsSum, 2);
                    } else {
                        // 🔹 ИЗМЕНЕНО: распределяем скидку пропорционально сумме строки
                        $itemPoints = floor(($rowSum / $totalProductsSum * $points) * 100) / 100;
                        $pointsSum += $itemPoints;
                    }

                    // 🔹 НОВОЕ: уменьшаем общую сумму строки
                    $newRowSum = max(0, round($rowSum - $itemPoints, 2));

                    // 🔹 НОВОЕ: пересчитываем цену ЗА ЕДИНИЦУ
                    $newUnitPrice = round(
                        $newRowSum / $items[$itemIndex]['quantity'],
                        2
                    );

                    $items[$itemIndex]['amount']['value'] = number_format(
                        $newUnitPrice,
                        2,
                        '.',
                        ''
                    );
                }

                // Корректировка последнего товара для точного совпадения суммы
                $itemsSum = array_sum(array_map(function ($i) {
                    return (float)$i['amount']['value'] * $i['quantity'];
                }, $items));

                $amountValue = (float)number_format($order->total_price, 2, '.', '');
                $diff = round($amountValue - $itemsSum, 2);

                // 🔹 ИЗМЕНЕНО: корректировка теперь учитывает quantity
                if (abs($diff) >= 0.01) {

                    $lastProductIndex = end($productIndexes);

                    $lastQuantity = $items[$lastProductIndex]['quantity'];
                    $lastUnitValue = (float)$items[$lastProductIndex]['amount']['value'];

                    $newLastUnitPrice = round(
                        (($lastUnitValue * $lastQuantity) + $diff) / $lastQuantity,
                        2
                    );

                    $items[$lastProductIndex]['amount']['value'] = number_format(
                        max(0, $newLastUnitPrice),
                        2,
                        '.',
                        ''
                    );
                }
            }
        }


        if (!empty($order->promocode_points) && $order->promocode_points > 0 && count($items) > 0) {

            $points = $order->promocode_points;

            // Фильтруем только товары (исключаем доставку и открытку)
            $productItems = array_filter($items, function ($item) {
                return $item['description'] !== 'Доставка' && $item['description'] !== 'Открытка';
            });

            $itemCount = count($productItems);

            if ($itemCount > 0) {

                $pointsSum = 0;
                $productIndexes = array_keys($productItems);

                // 🔹 НОВОЕ: считаем общую сумму товаров с учетом quantity
                $totalProductsSum = 0;
                foreach ($productIndexes as $index) {
                    $totalProductsSum +=
                        (float)$items[$index]['amount']['value']
                        * $items[$index]['quantity'];
                }

                foreach ($productIndexes as $idx => $itemIndex) {

                    // 🔹 НОВОЕ: сумма строки (цена × количество)
                    $rowSum =
                        (float)$items[$itemIndex]['amount']['value']
                        * $items[$itemIndex]['quantity'];

                    if ($idx === count($productIndexes) - 1) {
                        $itemPoints = round($points - $pointsSum, 2);
                    } else {
                        // 🔹 ИЗМЕНЕНО: распределяем пропорционально сумме строки
                        $itemPoints = floor(($rowSum / $totalProductsSum * $points) * 100) / 100;
                        $pointsSum += $itemPoints;
                    }

                    // 🔹 НОВОЕ: уменьшаем сумму строки
                    $newRowSum = max(0, round($rowSum - $itemPoints, 2));

                    // 🔹 НОВОЕ: пересчитываем цену за единицу
                    $newUnitPrice = round(
                        $newRowSum / $items[$itemIndex]['quantity'],
                        2
                    );

                    $items[$itemIndex]['amount']['value'] = number_format(
                        $newUnitPrice,
                        2,
                        '.',
                        ''
                    );
                }

                // Корректировка последнего товара для точного совпадения суммы
                $itemsSum = array_sum(array_map(function ($i) {
                    return (float)$i['amount']['value'] * $i['quantity'];
                }, $items));

                $amountValue = (float)number_format($order->total_price, 2, '.', '');
                $diff = round($amountValue - $itemsSum, 2);

                // 🔹 ИЗМЕНЕНО: корректировка учитывает quantity
                if (abs($diff) >= 0.01) {

                    $lastProductIndex = end($productIndexes);

                    $lastQuantity = $items[$lastProductIndex]['quantity'];
                    $lastUnitValue = (float)$items[$lastProductIndex]['amount']['value'];

                    $newLastUnitPrice = round(
                        (($lastUnitValue * $lastQuantity) + $diff) / $lastQuantity,
                        2
                    );

                    $items[$lastProductIndex]['amount']['value'] = number_format(
                        max(0, $newLastUnitPrice),
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
        /*if($order->id==14457){
            dd($res,$order);
        }*/
        if (isset(json_decode($res, true)['confirmation']['confirmation_url'])) {
            return json_decode($res, true)['confirmation']['confirmation_url'];

        } else {
            \Log::channel('marketplace')->info('Ошибка кассы данные', ['data' =>$data,'orderId' => $order->id]);
            \Log::channel('marketplace')->info('Ошибка кассы', ['orderId_link' =>$res]);
            return null;
        }
    }
}
