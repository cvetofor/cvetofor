@extends('twill::layouts.form')

@section('contentFields')
    <x-twill::browser module-name="regions" name="province" label="Регион" :max="1" />


    @formField('input', [
        'name' => 'city',
        'label' => 'Город',
        'maxlength' => 1000,
    ])
    @formField('input', [
        'name' => 'address',
        'label' => 'Адрес',
        'maxlength' => 1000,
    ])
    @formField('input', [
        'name' => 'postal_code',
        'label' => 'Почтовый индекс',
        'maxlength' => 1000,
    ])
    @formField('input', [
        'name' => 'country',
        'label' => 'Страна',
        'maxlength' => 1000,
    ])
    @formField('input', [
        'name' => 'federal_district',
        'label' => 'Федеральный район',
        'maxlength' => 1000,
    ])
    @formField('input', [
        'name' => 'region_type',
        'label' => 'Тип региона',
        'maxlength' => 1000,
    ])
    @formField('input', [
        'name' => 'region',
        'label' => 'Область',
        'maxlength' => 1000,
    ])
    @formField('input', [
        'name' => 'area_type',
        'label' => 'Тип области',
        'maxlength' => 1000,
    ])
    @formField('input', [
        'name' => 'area',
        'label' => 'Область',
        'maxlength' => 1000,
    ])
    @formField('input', [
        'name' => 'city_type',
        'label' => 'Тип города',
        'maxlength' => 1000,
    ])
    @formField('input', [
        'name' => 'settlement_type',
        'label' => 'Тип поселения',
        'maxlength' => 1000,
    ])
    @formField('input', [
        'name' => 'settlement',
        'label' => 'Урегулирование',
        'maxlength' => 1000,
    ])
    @formField('input', [
        'name' => 'kladr_id',
        'label' => 'Идентификатор кладра',
        'maxlength' => 1000,
    ])
    @formField('input', [
        'name' => 'fias_id',
        'label' => 'Идентификатор фиас',
        'maxlength' => 1000,
    ])
    @formField('input', [
        'name' => 'fias_level',
        'label' => 'Уровень ФИАС',
        'maxlength' => 1000,
    ])
    @formField('input', [
        'name' => 'capital_marker',
        'label' => 'Маркер капитала',
        'maxlength' => 1000,
    ])
    @formField('input', [
        'name' => 'okato',
        'label' => 'Окато',
        'maxlength' => 1000,
    ])
    @formField('input', [
        'name' => 'oktmo',
        'label' => 'Октмо',
        'maxlength' => 1000,
    ])
    @formField('input', [
        'name' => 'tax_office',
        'label' => 'Налоговая служба',
        'maxlength' => 1000,
    ])
    @formField('input', [
        'name' => 'timezone',
        'label' => 'Часовой пояс',
        'maxlength' => 1000,
    ])
    @formField('input', [
        'name' => 'geo_lat',
        'type' => 'number',
        'label' => 'Географическая широта',
        'maxlength' => 1000,
    ])
    @formField('input', [
        'name' => 'geo_lon',
        'type' => 'number',
        'label' => 'Географическая долгота',
        'maxlength' => 1000,
    ])
    @formField('input', [
        'name' => 'population',
        'label' => 'Население',
        'maxlength' => 1000,
    ])
    @formField('input', [
        'name' => 'foundation_year',
        'label' => 'Год основания',
        'maxlength' => 1000,
    ])
@stop
