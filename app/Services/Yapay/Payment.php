<?php

namespace App\Services\Yapay;

use App\Models\Delivery;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class Payment
{
    private $fields = [];

    public function __construct($shopId, $apiKey)
    {
        $this->fields['shopId'] = 'b2835444-b5f8-4f8d-b4e1-31a5f7468bcc';
        $this->fields['apiKey'] = 'b2835444b5f84f8db4e131a5f7468bcc.L8aGO8LUmUz1UNmo4I1KacolJ6m3BwFd';

    }

    public function getPaymentUrl($order)
    {


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


        $delivery = Delivery::where('order_id', $order->id )->first();

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
            'description' => 'Оплата заказа #' . $order->num_order . ', для ' . $customerName . '. г.' . ($order->city->city ?? ''),
            'metadata' => [
                'order_id' => $order->id,
            ],
        ];

        $yandexItems = [];
        foreach ($items as $item) {
            $yandexItems[] = [
                'productId' => md5($item['description']), // уникальный ID товара
                'title' => $item['description'],          // название
                'quantity' => ['count' => $item['quantity']], // количество
                'total' => number_format($item['amount']['value'] * $item['quantity'], 2, '.', '') // сумма за все единицы
            ];
        };

// Сумма всего заказа для Яндекс Pay
        $yandexTotal = number_format($order->total_price, 2, '.', '');

        $orderId = $order->num_order.'_' .$order->id.'_'.time();
        ///------- Ниже яндекс касса
        $orderData = [
            'orderId' => $orderId,
            'billingPhone'=>preg_replace('/[^0-9]/', '', $order->phone),
            'fiscalContact'=>preg_replace('/[^0-9]/', '', $order->phone),
            'cart' => [
                'items' => $yandexItems,
                'total' => ['amount' => $yandexTotal]
            ],
            'currencyCode' => 'RUB',
            'availablePaymentMethods' => ['SPLIT'], // Сплит и карта
            'preferredPaymentMethod' => 'SPLIT', // Сплит и карта
            'purpose' =>'Оплата заказа #' . $order->num_order . ', для ' . $customerName . '. г.' . ($order->city->city ?? ''),
            'metadata' => "$order->id",
            'redirectUrls' => [
                'onSuccess' => route('payments.gateway.yapay.return', ['orderId' => $order->id, 'type' => 'success']),
                'onError' => route('payments.gateway.yapay.return', ['orderId' => $order->id, 'type' => 'error'])
            ]

        ];

        $client = new Client();

        try {
            $response = $client->post('https://pay.yandex.ru/api/merchant/v1/orders', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Api-Key ' . $this->fields['apiKey'],
                ],
                'json' => $orderData
            ]);


            $result = json_decode($response->getBody()->getContents(), true);

            return $result['data']['paymentUrl'] ?? null;


        } catch (\Exception $e) {

            \Log::channel('marketplace')->info('Ошибка кассы данные', ['data' => $orderData, 'orderId' => $order->id]);
            \Log::channel('marketplace')->info('Ошибка кассы', ['orderId_link' => $orderData]);
            return null;
        }


    }
}
