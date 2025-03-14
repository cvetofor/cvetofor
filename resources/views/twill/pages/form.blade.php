@extends('twill::layouts.form', [
    'additionalFieldsets' => [['fieldset' => 'metadata', 'label' => 'SEO']],
])

@section('contentFields')
    @formField('medias', [
        'name' => 'cover',
        'label' => 'Баннер',
        'max' => 1,
        // 'fieldNote' => 'Minimum image width: 1500px',
    ])

    <x-twill::wysiwyg name="description" label="Описание" note="Под банером" :edit-source="true" />

    @formField('block_editor', [
        'blocks' => ['youtube', 'wyswyg', 'image', 'title', 'quote', 'cooperation', 'market_current_city_adresses', 'requisites'],
    ])
@stop

@section('fieldsets')
    @metadataFields
@stop
