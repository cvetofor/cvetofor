@twillRepeaterTitle('Время самомовывоза')
@twillRepeaterTrigger('Добавить время')
@twillRepeaterGroup('app')
@twillRepeaterTitleField('address', ['hidePrefix' => true])
@twillRepeaterValidationRules(
[
'time_start' => 'required',
'time_end' => 'required',
]
)

@formField('input', [
'name' => 'time_start',
'label' => 'Начало периода',
'maxlength' => 5,
'placeholder' => 'HH:MM',
'mask' => '99:99',
'required' => true,
])

@formField('input', [
'name' => 'time_en',
'label' => 'Конец периода',
'maxlength' => 5,
'placeholder' => 'HH:MM',
'mask' => '99:99',
'required' => true,
])
