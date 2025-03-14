@extends('twill::layouts.form')

@section('contentFields')

    <x-twill::browser module-name="groupProducts" name="groupProducts" label="Букеты" :max="100" />
    <x-twill::browser module-name="groupProductCategories" name="groupProductCategories" label="Категории букетов"
        :max="100" />


@section('sideFieldsets')
    <a17-fieldset title="Промокод" id="">
        <x-twill::input name="code" label="Код" :required="true" />
        <x-twill::input type="number" name="quantity" label="Доступное количество" min=0 :required="true" />
    </a17-fieldset>
    <a17-fieldset title="Изменение" id="">
        <x-twill::input type="number" name="percent" prefix="%" max=100 min=0 label="В процентах" />
        <x-twill::input type="number" name="price" prefix="₽" max=100 min=0 label="В рублях" />
    </a17-fieldset>
@endsection
@stop
