@extends('twill::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'last_name',
        'label' => 'Фамилия',
        'maxlength' => 100,
    ])
    @formField('input', [
        'name' => 'name',
        'label' => 'Имя',
        'maxlength' => 100,
    ])
    @formField('input', [
        'name' => 'second_name',
        'label' => 'Отчество',
        'maxlength' => 100,
    ])
    @formField('input', [
        'type' => 'email',
        'name' => 'email',
        'label' => 'Email',
    ])
    @formField('input', [
        'name' => 'phone',
        'label' => 'Телефон',
        'maxlength' => 100,
        'mask' => '+7 (999) 999 99 99',
    ])
    @formField('checkbox', [
        'name' => 'concent_exclusive_email',
        'label' => 'Согласие на получение рассылки',
    ])
    @formField('input', [
        'type' => 'password',
        'name' => 'password',
        'label' => 'Пароль',
        'maxlength' => 100,
    ])

    <x-twill::browser name="orders"
        module-name="orders"
        label="Заказы"/>
@stop
