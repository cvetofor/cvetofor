<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendOrderReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $order_id ;
    protected string $payment_link;


    public function __construct($order_id)
    {
        
        $this->order_id = $order_id;
      
    }

  
    public function handle()
    {
        try {
            // Ищем текущий заказ
            $mainOrder = Order::find($this->order_id);
    
            if (!$mainOrder) {
                \Log::channel('marketplace')->log('info','Основной заказ не найден', ['order_id' => $this->order_id]);
                return;
            }
    
            \Log::channel('marketplace')->log('info','Обработка основного заказа начата', ['order_id' => $mainOrder->id]);
    
            // Ищем все связанные заказы
            $relatedOrders = Order::where('parent_id', $mainOrder->id)->get();
    
            // Проверяем, есть ли среди связанных заказов оплаченные
            $paidOrders = $relatedOrders->where('payment_status_id', 2);
    
            if ($paidOrders->isNotEmpty()) {
                \Log::channel('marketplace')->log('info','Заказ оплачен, SMS не требуется', [
                    'order_id' => $mainOrder->id,
                    'paid_orders_count' => $paidOrders->count(),
                ]);
                return;
            }
    
            // Проверяем, все ли заказы в статусе "оформлен"
            $allOrdersIssued = $relatedOrders->every(function ($order) {
                return $order->order_status_id == 1; // Статус "оформлен"
            });
    
            if ($allOrdersIssued) {
                $phone = $mainOrder->phone;
                $num_order = $mainOrder->num_order;
    
                \Log::channel('marketplace')->log('info','Отправка SMS о платеже', [
                    'phone' => $phone,
                    'num_order' => $num_order,
                ]);
    
                $payment_link = 'https://цветофор.рф/order/' . $num_order . '/payment';

    
                 $sms = new \App\Http\Controllers\Api\SMSController($phone, null, false, "");
                 $sms->sendPaymentCurlSMS($num_order, $payment_link);
    
                \Log::channel('marketplace')->log('info','SMS успешно отправлено');
            } else {
                \Log::channel('marketplace')->log('info','Не все заказы в статусе "оформлен", SMS не отправлено', [
                    'order_id' => $mainOrder->id,
                ]);
            }
        } catch (\Exception $e) {
            \Log::channel('marketplace')->error('Ошибка в обработке задания', [
                'message' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
            ]);
    
            throw $e; // повторный бросок исключения, чтобы Laravel пометил задание как failed
        }
    }
    
    
}




