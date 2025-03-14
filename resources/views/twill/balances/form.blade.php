@extends('twill::layouts.form')

@section('contentFields')


    @formField('input', [
        'name' => 'description',
        'label' => 'Описание',
        'maxlength' => 100,
    ])
    @formField('input', [
        'name' => 'total',
        'label' => 'Всего',
        'maxlength' => 100,
        'disabled' => true,
    ])

    @php

        $selectOptions = [
            [
                'value' => \App\Models\Balance::STATUS['APPROVED'],
                'label' => 'Подтверждено',
            ],
            [
                'value' => \App\Models\Balance::STATUS['WAIT_APPROVE'],
                'label' => 'Ожидает подтверждения',
            ],
        ];

    @endphp



    <x-twill::select name="status" label="Статус" :options="$selectOptions" />

    <x-twill::browser name="market" module-name="markets" label="Магазин" :max=1/>

    <x-twill::browser :disabled="true" name="orders" module-name="orders" label="Заказы" :max=1000/>



@stop
