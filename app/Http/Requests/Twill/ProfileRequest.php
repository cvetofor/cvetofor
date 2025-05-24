<?php

namespace App\Http\Requests\Twill;

use A17\Twill\Http\Requests\Admin\Request;

class ProfileRequest extends Request
{
    public function rulesForCreate()
    {
        return [];
    }

    public function rulesForUpdate()
    {
        if (request()->has('phone')) {
            request()['phone'] = str_replace(['(', ')', '-', ' '], ['', '', '', ''], request()['phone']);
        }

        return [
            'phone' => 'min:12|required_if:email',
            'email' => 'required_if:phone',
        ];
    }

    public function messages()
    {
        return [
            'phone.required_if' => 'Телефон обязателен если не указан Email',
            'email.required_if' => 'Email обязателен если не указан Телефон',
            'email.unique' => 'Email не должен повторяться',
            'phone.unique' => 'Телефон не должен повторяться',
        ];
    }
}
