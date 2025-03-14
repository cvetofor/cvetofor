@formField('input', [
    'name' => 'name',
    'label' => 'Название',
    'maxlength' => 100,
    'required' => true,
])
@formField('select', [
    'name' => 'code',
    'label' => 'Тип оплаты',
    'min' => 1,
    'max' => 1,
    'placeholder' => '',
    'required' => true,
    'options' => [
        [
            'value' => 'cash',
            'label' => 'Наличный расчёт',
        ],
        [
            'value' => 'yookassa',
            'label' => 'ЮKassa',
        ],
        [
            'value' => 'robokassa',
            'label' => 'Robokassa',
        ],
        [
            'value' => 'account',
            'label' => 'Оплата по счёту',
        ],
    ],
])
@formField('select', [
    'name' => 'vat',
    'label' => 'Ставка НДС',
    'min' => 1,
    'max' => 1,
    'placeholder' => '',
    'required' => true,
    'default' => '1',
    'options' => [
        [
            'value' => '1',
            'label' => 'Без НДС',
        ],
        [
            'value' => '2',
            'label' => 'НДС по ставке 0%',
        ],
        [
            'value' => '3',
            'label' => 'НДС по ставке 10%',
        ],
        [
            'value' => '4',
            'label' => 'НДС по ставке 20%',
        ],
        [
            'value' => '5',
            'label' => 'НДС по расчетной ставке 10/110',
        ],
        [
            'value' => '6',
            'label' => 'НДС по расчетной ставке 20/120',
        ],
        [
            'value' => '7',
            'label' => 'НДС по ставке 5%',
        ],
        [
            'value' => '8',
            'label' => 'НДС по ставке 7%',
        ],
        [
            'value' => '9',
            'label' => 'НДС по расчетной ставке 5/105',
        ],
        [
            'value' => '10',
            'label' => 'НДС по расчетной ставке 7/107',
        ],
    ],
])

@formField('select', [
    'name' => 'tax_system_code',
    'label' => 'Система налогообложения',
    'min' => 1,
    'max' => 1,
    'placeholder' => '',
    'required' => true,
    'default' => '1',
    'options' => [
        [
            'value' => '1',
            'label' => 'Общая система налогообложения',
        ],
        [
            'value' => '2',
            'label' => 'Упрощенная (УСН, доходы)',
        ],
        [
            'value' => '3',
            'label' => 'Упрощенная (УСН, доходы минус расходы)',
        ],
        [
            'value' => '4',
            'label' => 'Единый налог на вмененный доход (ЕНВД)',
        ],
        [
            'value' => '5',
            'label' => 'Единый сельскохозяйственный налог (ЕСН)',
        ],
        [
            'value' => '6',
            'label' => 'Патентная система налогообложения',
        ],
    ],
])
