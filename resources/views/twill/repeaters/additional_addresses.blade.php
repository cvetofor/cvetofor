@twillRepeaterTitle('Дополнительные адреса')
@twillRepeaterTrigger('Добавить адрес')
@twillRepeaterGroup('app')
@twillRepeaterTitleField('address', ['hidePrefix' => true])
@twillRepeaterValidationRules(
    [
        'address' => 'required|max:100',
    ]
)



@formField('input', [
    'name' => 'address',
    'label' => 'Адрес',
    'maxlength' => 100,
    'required' => true,
])
