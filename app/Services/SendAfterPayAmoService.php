<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Promocod;
use GuzzleHttp\Client;
class SendAfterPayAmoService
{
    public static function send(Order $order)
    {
        $amocrmLogger = logger()->channel('amocrm2');
        $amocrmLogger->debug('Начали обработку заказа', ['order_id' => $order->id]);
$datasend['address']=$order->address['address']??NULL;
$datasend['apartment_number']=$order->address['apartament_number']??NULL;
$datasend['recipient_name']=$order->person_receiving_name;
$datasend['recipient_phone_number']=$order->person_receiving_phone;
$datasend['delivery_date']=date('d.m.Y',strtotime($order->delivery_date));
$datasend['delivery_time']=$order->delivery_time;
$datasend['anonymous']=$order->is_anon?true:false;
$datasend['postcard_text']=$order->postcard_text?true:false;
$datasend['text']=$order->postcard_text;
$datasend['uds_code']=$order->uds_code;
$datasend['promocode']=Promocod::find($order->promocod_id)->code??NULL;
$datasend['customer_client']=$order->phone==$order->person_receiving_phone?true:false;
$datasend['customer_name']=$order->user->fullName??NULL;
$datasend['customer_email']=$order->email;
$datasend['customer_phone_number']=$order->phone;
$datasend['payment_method']=$order->payment->name??NULL;

try {
    $client = new Client();
    $response = $client->post('https://hooks.tglk.ru/in/xQ4qva87PBlMkWca9DCG8JnXJGKzNw', [
        'headers' => [
            'Content-Type' => 'application/json',

        ],
        'json' => $datasend
    ]);


    $result = json_decode($response->getBody()->getContents(), true);
    $amocrmLogger->debug('Отправили', ['order_id' => $order->id]);
}catch (\Exception $e){


    $amocrmLogger->debug('Ошибка обработку заказа', $datasend);
    $amocrmLogger->debug('Ошибка обработку заказа',json_encode($e));
}






    }
}
