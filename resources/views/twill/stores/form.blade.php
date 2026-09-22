@php
    $contentFieldsetLabel = 'Адрес';

@endphp
@extends('twill::layouts.form')

@section('contentFields')

    <x-twill::input name="name" label="Название/Адресс" required="required" :maxlength="100" />



    <x-twill::input name="address" label="Адрес" required="required" :maxlength="1000" />

    @formField('repeater', ['type' => 'address_times', 'max' => 10])














@stop
