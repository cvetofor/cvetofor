@extends('twill::layouts.form')

@section('contentFields')

    @formField('input', [
        'name' => 'name',
        'label' => 'Имя',
        'maxlength' => 1000,
        'required' => true,
    ])
    @formField('input', [
        'name' => 'type',
        'label' => 'Тип',
        'maxlength' => 1000,
    ])
    @formField('input', [
        'name' => 'name_with_type',
        'label' => 'Имя с типом',
        'maxlength' => 1000,
    ])
    @formField('input', [
        'name' => 'federal_district',
        'label' => 'Федеральный район',
        'maxlength' => 1000,
    ])
    @formField('input', [
        'name' => 'kladr_id',
        'label' => 'Идентификатор КЛАДР',
        'maxlength' => 1000,
    ])
    @formField('input', [
        'name' => 'fias_id',
        'label' => 'Идентификатор ФИАС',
        'maxlength' => 1000,
    ])
    @formField('input', [
        'name' => 'okato',
        'label' => 'ОКАТО',
        'maxlength' => 1000,
    ])
    @formField('input', [
        'name' => 'oktmo',
        'label' => 'ОКТМО',
        'maxlength' => 1000,
    ])
    @formField('input', [
        'name' => 'tax_office',
        'label' => 'Налоговая служба',
        'maxlength' => 1000,
    ])
    @formField('input', [
        'name' => 'postal_code',
        'label' => 'Почтовый индекс',
        'maxlength' => 1000,
    ])
    @formField('input', [
        'name' => 'iso_code',
        'label' => 'ISO код',
        'maxlength' => 1000,
    ])
    @formField('input', [
        'name' => 'timezone',
        'label' => 'Часовой пояс',
        'maxlength' => 1000,
    ])
    @formField('input', [
        'name' => 'geoname_code',
        'label' => 'Код геоимени',
        'maxlength' => 1000,
    ])
    @formField('input', [
        'name' => 'geoname_id',
        'label' => 'Идентификатор геоимени',
        'maxlength' => 1000,
    ])
    @formField('input', [
        'name' => 'geoname_name',
        'label' => 'Геоназвания',
        'maxlength' => 1000,
    ])

    @formField('repeater', [
        'type' => 'city',
        'buttonAsLink' => false,
        'reorder' => false,
        'allowCreate' => false,
    ])
@stop
