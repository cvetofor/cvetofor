<?php

namespace App\Gateway;

use App\Models\Order;
use App\Models\Payment;
use App\Services\Sberbank\Payment as SberbankPayment;
use Unetway\LaravelRobokassa\Robokassa;
use Illuminate\Support\Collection;

class PaymentGateway {
    public function __construct() {
    }

    public function resolve(Order $order) {
        if (
            in_array($order->payment->code, [
                Payment::ACCOUNT,
                Payment::CASH,
            ])
        ) {
            return route('order.show', ['order' => $order->uuid]);
        }

        if ($order->payment->code == Payment::ROBOKASSA) {
            \Log::channel('marketplace')->info('Создание платежной ссылки через робокассу', ['orderId' => $order->id]);
            $payment = new \App\Services\Robokassa\Payment(
                config('robokassa.login'),
                config('robokassa.password1'),
                config('robokassa.password2'),
                config('robokassa.is_test')
            );

            $ch = $order->childs;
            $deliveryPrice = 0.0;
            foreach ($ch as $child) {
                $deliveryPrice += $child->delivery->price;
            }

            $items = [
                'items' => array_values(Collection::make($order['cart'])->map(function ($cartItem) {
                    $conditionals = \array_sum(array_values($cartItem['conditions']));
                    return [
                        'name'           => $cartItem['name'],
                        'quantity'       => $cartItem['quantity'],
                        'sum'            => $cartItem['quantity'] * ($cartItem['price'] - $conditionals),
                        'payment_method' => 'full_payment',
                        'payment_object' => 'commodity',
                        'tax'            => 'none',
                    ];
                })->toArray()),
            ];

            if ($deliveryPrice > 0) {
                $items['items'][] = [
                    'name'           => 'Доставка',
                    'quantity'       => 1,
                    'sum'            => $deliveryPrice,
                    'payment_method' => 'full_payment',
                    'payment_object' => 'commodity',
                    'tax'            => 'none',
                ];
            }

            $payment
                ->setInvoiceId($order->id)
                ->setDescription('Заказа с сайта ' . config('app.name') . ' № ' . $order->num_order)
                ->setSum($order->total_price)
                ->setReceipt($items);

            $link = $payment->getPaymentUrl();
            $order->update(['payment_link' => $link]);
            // redirect to payment url
            return $link;
        }

        if ($order->payment->code == Payment::YOOKASSA) {
            \Log::channel('marketplace')->info('Создание платежной ссылки через yookassa', ['orderId' => $order->id]);

            $payment = new \App\Services\Yookassa\Payment(
                config('yookassa.shopId'),
                config('yookassa.apiKey'),
            );

            $link = $payment->getPaymentUrl($order);
            $order->update(['payment_link' => $link]);
            // redirect to payment url
            return $link;
        }
    }
}
