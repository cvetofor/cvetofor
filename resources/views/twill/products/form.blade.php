@extends('twill::layouts.form')

@php
    $disabled = isset($item->id ) ? ! auth()
        ->user()
        ->can('update', $item) : false;
@endphp

@section('contentFields')

    <x-twill::medias name="preview" label="Изображение товара" :disabled="$disabled" />

    @can('is_owner')
        <x-twill::checkbox name="is_market_public" label="Доступно для всех магазинов" :disabled="$disabled" />

        <x-twill::date-picker name="verified_at" label="Проверено Администратором"
            note="Если оставить пустым, данный товар не будет виден никому" :disabled="$disabled" />
    @endcan



    <x-twill::browser module-name="colors" :sortable="false" name="colors" label="Цвет" :max="100"
        :disabled="$disabled" />

    {{--
<x-twill::repeater type="product" name="product-childrens" disabled /> --}}
@stop

@section('sideFieldsets')
    <a17-fieldset title="Категория" id="seo">
        <x-twill::browser module-name="categories" name="categories" label="Категория" :max="1"
            :disabled="$disabled" />
    </a17-fieldset>
@endsection
