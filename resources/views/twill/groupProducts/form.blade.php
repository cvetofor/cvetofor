@php
    $contentFieldsetLabel = 'Информация о букете';

    // Проверяем, может ли данный сотрудник изменять товар.
    if (isset($item->id) && !\Gate::allows('update', $item)) {
        $disabled = true;
    } else {
        $disabled = false;
    }
@endphp
@extends('twill::layouts.form', [
    'additionalFieldsets' => [['fieldset' => 'metadata', 'label' => 'SEO']],
])


@section('contentFields')

    <x-twill::medias :disabled="$disabled" name="cover" :with-add-info="true" note="Добавить" label="Изображение товара"
        :max="5" />

    <x-twill::input :disabled="$disabled" name="description" label="Описание" :maxlength="999" type="textarea"
        :required="true" />

    @formField('block_editor', [
        'blocks' => ['products'],
        'label' => 'Добавить товар',
        'disabled' => $disabled,
    ])

@stop

@section('sideFieldsets')
    <a17-fieldset title="Артикул: {{ $item->priceObj->sku }}" id="sku">
        <a17-calculated-price name="price" in-store="value"></a17-calculated-price>
    </a17-fieldset>
    <a17-fieldset title="Дополнительная информация" id="info">
        <x-twill::checkbox name="is_promo" label="Акционный товар" />
    </a17-fieldset>
@endsection

@section('fieldsets')

    @can('is_owner')
        <a17-fieldset title="Поделиться букетом" id="share">
            <x-twill::checkbox :disabled="$disabled" name="is_public" label="Публичный"
                note="Показывается всем магазинам 'Букеты сети'" />
        </a17-fieldset>
    @endcan




    <a17-fieldset title="Категория" id="seo">
        <x-twill::browser :disabled="$disabled" module-name="groupProductCategories" name="group_categories" :required="true"
            label="Категория" :max="1" />
        <x-twill::tags :disabled="$disabled" label="Повод" />
    </a17-fieldset>

    <a17-fieldset title="Видео" id="video">
        <x-twill::files :disabled="$disabled" name="preview" label="Файл" />
        <p>При добавлении видеофайла, последнее "Изображение товара" становится предпросмотром для видео</p>
    </a17-fieldset>
    {{-- @metadataFields --}}
@stop

@push('vuexStore')
    window['{{ config('twill.js_namespace') }}'].STORE.form.fields.push({

    name: 'price',

    value: '{!! $item->price !!}',

    })
@endpush

@if ($disabled)
    @push('extra_js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.vs__search').forEach(e => {
                    e.disabled = true;
                })
                document.querySelectorAll('.vs__deselect').forEach(e => {
                    e.disabled = true;
                    e.style = 'display:none;';
                })
                document.querySelectorAll('.icon.icon--edit').forEach(e => {
                    e.disabled = true;
                    e.style = 'display:none;';
                })
                document.querySelectorAll('.titleEditor__title-wrapper').forEach(e => {
                    e.disabled = true;
                })
                document.querySelectorAll('.input .browserField *').forEach(e => {
                    e.disabled = true;
                })
                document.querySelectorAll('.bucket__action.button.button--icon.button--close').forEach(e => {
                    e.disabled = true;
                    e.style = 'display:none;';
                })


                document.querySelectorAll('.button.button--small.button--action').forEach(e => {
                    e.disabled = true;
                    e.style = 'display:none;';
                })
                document.querySelectorAll('[name*="blocks"]').forEach(e => {
                    e.disabled = true;
                })
            })
        </script>
        <style>
            #vs1__listbox {
                display: none;
            }
        </style>
    @endpush
@endif
