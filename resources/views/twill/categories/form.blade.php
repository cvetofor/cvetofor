@extends('twill::layouts.form')

@section('contentFields')
<x-twill::input name="description" label="Описание" :maxlength="999" type="textarea"
:required="true" />

<x-twill::medias name="cover" :with-add-info="true" note="Добавить" label="Баннер категории" :max="1" />

@stop

@section('sideFieldsets')
    <a17-fieldset title="Дополнительная информация" id="seo">
        <x-twill::checkbox name="is_visible" label="Видимая для покупателей категория"
            note="Если оставить поле не активным, количество товара нельзя будет изменять для покупателя и он не увидит категории товаров в карточке" />
        <x-twill::checkbox name="is_visible_menu" label="Показывать в меню"
            note="Категория товаров показывается в меню Каталог" />
        <x-twill::checkbox name="is_additional_product" label="Товар можно положить без букета в корзину"
            note="Товары этой категории будут показываться в 'Рекомендуем добавить'" />
        <x-twill::checkbox name="is_visible_catalog" label="Отображать в каталоге"
            note="Товары этой категории будут показываться в 'Каталоге'" />
    </a17-fieldset>
@endsection

@section('fieldsets')
    @metadataFields
@stop
