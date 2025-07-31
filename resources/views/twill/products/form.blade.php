@extends('twill::layouts.form')

@php
    $disabled = isset($item->id ) ? ! auth()
        ->user()
        ->can('update', $item) : false;

    $sku = optional($item->prices()->where('market_id', auth()->guard('twill_users')->user()->getMarketId())->where('quantity_from', 1)->first())->sku;    
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

    <x-twill::input :disabled="$disabled" name="description" label="Описание" :maxlength="999" type="textarea" />
@stop

@section('sideFieldsets')
    <a17-fieldset title="Артикул: {{ $sku }}" id="sku">
        <x-twill::input :disabled="$disabled" name="price" label="Цена" type="number" step="0.01" :value="old('price', $item->price)" />
    </a17-fieldset>
    @parent


    <a17-fieldset title="Категория" id="seo">
        <x-twill::browser module-name="categories" name="categories" label="Категория" :max="1"
            :disabled="$disabled" />
    </a17-fieldset>
@endsection
