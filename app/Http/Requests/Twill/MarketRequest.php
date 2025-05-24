<?php

namespace App\Http\Requests\Twill;

use A17\Twill\Http\Requests\Admin\Request;

class MarketRequest extends Request
{
    public function rulesForCreate()
    {
        return [
            // 'address' => 'required',
            // 'phone' => 'required',
            // 'email' => 'required',
            'name' => 'required|min:5|max:300',
        ];
    }

    public function rulesForUpdate()
    {
        return [
            'address' => 'required|max:1000',
            'phone' => 'required|max:100',
            'browsers.city' => 'required',
            'name' => 'required|min:5|max:300',
            'postcard_price' => 'max:10',
            'repeaters.additional_addresses.*.address' => 'max:100',
            'repeaters.deliveries_radius.*.radius' => 'required|numeric|min:0|max:5000',
            'repeaters.deliveries_radius.*.price' => 'required|numeric|min:0|max:100000',
            'price_i_dont_know_address' => 'required|numeric|min:0|max:100000',
        ];
    }

    public function messages()
    {
        return [
            'repeaters.additional_addresses.*.address' => 'Дополнительный адрес',
            'address' => 'Адрес',
            'phone' => 'Телефон',
            'email' => 'E-mail',
            'browsers.city' => 'Город',
            'name' => 'Название',
            'postcard_price' => 'Стоимость открытки',
        ];
    }
}
