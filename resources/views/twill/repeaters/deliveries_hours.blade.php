@twillRepeaterTitle('Радиус доставки')
@twillRepeaterTrigger('Добавить радиус')
@twillRepeaterGroup('app')
@twillRepeaterTitleField('address', ['hidePrefix' => true])

@twillRepeaterValidationRules([
    'delivery_hours_from' => 'required',
    'delivery_hours_to' => 'required',
])

<x-twill::input mask="99:99" name="delivery_hours_from" label="Интервал от" note="01:00 - час"
    :maxlength="5" />

<x-twill::input mask="99:99" name="delivery_hours_to" label="Интервал до" note="01:00 - час"
    :maxlength="5" />
