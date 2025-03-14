@extends('twill::layouts.form', [
    'additionalFieldsets' => [['fieldset' => 'metadata', 'label' => 'SEO']],
])

@section('contentFields')

    <x-twill::input name="description" label="Описание" :maxlength="999" type="textarea" :required="true" />


    @formField('medias', [
        'name' => 'cover',
        'label' => 'Баннер',
        'max' => 1,
        // 'fieldNote' => 'Minimum image width: 1500px',
    ])

    @formField('checkbox', [
    'name' => 'is_category_limited',
    'label' => 'Ограничить доступность по датам',
    'default' => false
    ])


    @formField('date_picker', [
    'type' => 'date',
    'name' => 'limit_start_date',
    'label' => 'Дата начала ограничения',
    ])

    @formField('date_picker', [
    'type' => 'date',
    'name' => 'limit_end_date',
    'label' => 'Дата окончания ограничения',

    ])
@stop

@section('fieldsets')
    @metadataFields
@stop
