@twillRepeaterTitle('Аттрибуты')
@twillRepeaterTrigger('Добавить')
@twillRepeaterGroup('attributes')

<x-twill::checkbox name="is_variable" label="Сгенерировать торговые предложения" />

@formField('input', [
    'name' => 'label',
    'label' => 'Название',
    'required' => true,
])
