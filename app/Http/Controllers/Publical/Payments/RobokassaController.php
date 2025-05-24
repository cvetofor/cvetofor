<?php

namespace App\Http\Controllers\Publical\Payments;

use App\Events\OrderPaymentReceived;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Robokassa\Payment;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class RobokassaController extends Controller
{
    public function success(Request $request)
    {
        $payment = new Payment(
            config('robokassa.login'),
            config('robokassa.password1'),
            config('robokassa.password2'),
            config('robokassa.is_test')
        );
        $order = Order::where('id', $request['InvId'])->first();

        $ch = $order->childs;
        $deliveryPrice = 0.0;
        foreach ($ch as $child) {
            $deliveryPrice += $child->delivery->price;
        }

        $items = [
            'items' => array_values(Collection::make($order['cart'])->map(function ($cartItem) {
                $conditionals = \array_sum(array_values($cartItem['conditions']));

                return [
                    'name' => $cartItem['name'],
                    'quantity' => $cartItem['quantity'],
                    'sum' => $cartItem['quantity'] * ($cartItem['price'] - $conditionals),
                    'payment_method' => 'full_payment',
                    'payment_object' => 'commodity',
                    'tax' => 'none',
                ];
            })->toArray()),
        ];

        if ($deliveryPrice > 0) {
            $items['items'][] = [
                'name' => 'Доставка',
                'quantity' => 1,
                'sum' => $deliveryPrice,
                'payment_method' => 'full_payment',
                'payment_object' => 'commodity',
                'tax' => 'none',
            ];
        }

        $payment->setReceipt($items);

        try {
            return \DB::transaction(function () use ($payment, $request, $order) {
                if ($payment->validateSuccess($request->toArray()) || $payment->validateResult($request->toArray())) {

                    if ((float) $payment->getSum() == (float) $order->total_price) {
                        \Log::channel('marketplace')->info('Оплата прошла успешно (ROBOKASSA) №: '.$payment->getInvoiceId());

                        $paid_id = \App\Models\PaymentStatus::whereCode(\App\Models\PaymentStatus::PAID)->first()->id;

                        $order->update([
                            'payment_status_id' => $paid_id,
                        ]);
                        $order->save();

                        foreach ($order->childs as $_order) {
                            $_order->update([
                                'payment_status_id' => $paid_id,
                            ]);
                            $_order->save();
                        }

                        event(new OrderPaymentReceived($order));

                        SEOTools::setTitle('Заказ №'.$order->id);
                        SEOTools::metatags()->setRobots('noindex, nofollow');

                        return view('order.show', compact('order'));
                    } else {
                        \Log::channel('marketplace')->error('Суммы различаются '.$payment->getSum().'!= '.$order->total_price.' №: '.$payment->getInvoiceId());
                    }
                } else {
                    \Log::channel('marketplace')->error('Ошибка оплаты №: '.$payment->getInvoiceId());
                }

                return view('order.fail');
            }, 5);
        } catch (\Throwable $th) {
            \Log::channel('marketplace')->critical('Ошибка Сохранения оплаты'.$th->getMessage(), $request->toArray());

            return view('order.fail');
        }

        return view('order.fail');
    }

    public function fail(Request $request)
    {
        // \Log::channel('marketplace')->error('Ошибка оплаты request fail №: ' . $request->get('InvId'));
        return view('order.fail');
    }
}
