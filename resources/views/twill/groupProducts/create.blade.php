@php
    // Проверяем, может ли данный сотрудник изменять товар.
    if (isset($item->id) && !\Gate::allows('update', $item)) {
        $disabled = true;
    } else {
        $disabled = false;
    }
@endphp

@if(! $disabled)
    @include('twill::partials.create')
    <x-twill::medias name="cover" :with-add-info="true" note="Добавить" label="Изображение товара" :max="3" :disabled="$disabled"/>
@else
    <x-twill::input
        :name="$titleFormKey"
        :label="$titleFormKey === 'title' ? twillTrans('twill::lang.modal.title-field') : ucfirst($titleFormKey)"
        :translated="$translateTitle ?? false"
        :required="true"
        :disabled="$disabled"
    />
@endif


