<?php

namespace App\Http\Requests\Twill;

use A17\Twill\Http\Requests\Admin\Request;

class PaymentDetailRequest extends Request
{
    public function rulesForCreate()
    {
        return [
            'fio' => 'required|max:300',
            'legal_address' => 'max:300',
            'postal_address' => 'max:1000',
            'inn' => 'max:50',
            'kpp' => 'max:50',
            'ogrn' => 'max:50',
            'bank_fullname' => 'max:1000',
            'payment_account' => 'max:300',
            'correspondent_account' => 'max:300',
            'bik' => 'max:300',
        ];
    }

    public function rulesForUpdate()
    {
        return [
            'fio' => 'required|max:300',
            'legal_address' => 'max:300',
            'postal_address' => 'max:1000',
            'inn' => 'max:50',
            'kpp' => 'max:50',
            'ogrn' => 'max:50',
            'bank_fullname' => 'max:1000',
            'payment_account' => 'max:300',
            'correspondent_account' => 'max:300',
            'bik' => 'max:300',
        ];
    }
}
