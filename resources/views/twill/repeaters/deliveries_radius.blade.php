@twillRepeaterTitle('Радиус доставки')
@twillRepeaterTrigger('Добавить радиус')
@twillRepeaterGroup('app')
@twillRepeaterTitleField('address', ['hidePrefix' => true])

@twillRepeaterValidationRules([
    'radius' => 'required|numeric|max:5000',
    'price' => 'required|numeric|max:100000',
])


<x-twill::input type="number" name="radius" label="Радиус" min="1" note="Км" :maxlength=5000/>
<x-twill::input type="number" name="price" label="Стоимость" min="0" :maxlength=100000/>
<x-twill::input type="number" name="free_delivery_at" label="Бесплатаня доставка ОТ" min="0" :maxlength=100000/>

<x-twill::checkbox
    name="holidays"
    label="Радиус используется в праздничные дни"
/>
