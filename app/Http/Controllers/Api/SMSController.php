<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class SMSController extends Controller
{
    private $phone;

    private $password;

    private $isNew;

    private $name;

    public function __construct($phone, $password, $isNew, $name)
    {
        $this->phone = $phone;
        $this->password = $password;
        $this->isNew = $isNew;
        $this->name = $name;
    }

    public function sendPaymentCurlSMS(string $order_numb, string $payment_linl)
    {
        $message = 'Ваш заказ №'.$order_numb.' на сайте цветофор.рф не оплачен. Чтобы мы взяли его в работу оплатите заказ по ссылке - '.$payment_linl;

        $params = [
            'login' => 'cvetuly',
            'psw' => 's7W9z0V4m6M7m2F2',
            'phones' => $this->phone,
            'mes' => $message,
            'fmt' => 3,
        ];
        $this->sendCurl('https://smsc.ru/sys/send.php?', $params);
    }

    public function sendSMS()
    {
        if ($this->isNew) {
            $message = 'Пароль для входа в ЛК на цветофор.рф - '.$this->password;
            $this->saveContact();
        } elseif ($this->isNew == false) {
            $message = 'Новый пароль для входа в ЛК на цветофор.рф - '.$this->password;
        }

        $params = [
            'login' => 'cvetuly',
            'psw' => 's7W9z0V4m6M7m2F2',
            'phones' => $this->phone,
            'mes' => $message,
            'fmt' => 3,
        ];

        $this->sendCurl('https://smsc.ru/sys/send.php?', $params);
    }

    private function saveContact()
    {
        $params = [
            'add' => 1,
            'login' => 'cvetuly',
            'psw' => 's7W9z0V4m6M7m2F2',
            'phone' => $this->phone,
            'name' => $this->name,
        ];

        $this->sendCurl('https://smsc.ru/sys/phones.php?', $params);
    }

    private function sendCurl($url, $params)
    {
        $ch = curl_init($url.http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }
}
