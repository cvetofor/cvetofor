@twillBlockTitle('Сотрудник')
@twillRepeaterTitleField('name', ['hidePrefix' => true])

@twillBlockIcon('add')
@twillBlockValidationRules([
    'last_name' => 'nullable|max:30',
    'second_name' => 'nullable|max:30',
    'phone' => 'nullable|max:18',
    'name' => 'required|max:30',
    'email' => 'required|email|max:50',
    'role' => 'required|in:manager,courier,florist',
])

@php
    $options = [
        [
            'value' => 'manager',
            'label' => 'Менеджер',
        ],

        [
            'value' => 'florist',
            'label' => 'Флорист',
        ],

        [
            'value' => 'courier',
            'label' => 'Курьер',
        ],
    ];
@endphp


<x-twill::input name="last_name" label="Фамилия" min="2" :maxlength=30/>
<x-twill::input required name="name" label="Имя" min="2" :maxlength=30/>
<x-twill::input name="second_name" label="Отчество" min="2" :maxlength=30/>

<x-twill::input required type="email" name="email" label="E-mail" :maxlength=50/>

<x-twill::input name="phone" label="Телефон" min="2" mask="+7 (999) 999 99 99" :maxlength=18/>

<x-twill::radios name="role" label="Роль" default="manager" :inline="true" :options="$options" />
