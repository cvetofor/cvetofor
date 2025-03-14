@twillRepeaterTitle('Элемент меню')
@twillRepeaterTrigger('Добавить')
@twillRepeaterGroup('app')


@formField('input', [
    'name' => 'title',
    'label' => 'Заголовок',
    'required' => true,
])

@formField('input', [
    'name' => 'href',
    'label' => 'Ссылка',
    'required' => true,
])

@php
$selectOptions = [
    ['value' => '_self',            'label' => 'В текущей вкладке'],
    ['value' => '_blank',            'label' => 'В новой вкладке'],
];
@endphp <x-twill::select    name="target"    label="Вкладка"     :options="$selectOptions"/>
