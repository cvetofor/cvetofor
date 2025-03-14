@twillBlockTitle('Страница помощи')

@formField('input', [
    'label' => 'Телефон',
    'name' => 'help_phone',
])
@formField('input', [
    'label' => 'Режим работы',
    'name' => 'help_work_time',
])
@formField('input', [
    'type' => 'email',
    'label' => 'E-mail',
    'name' => 'help_email',
])
@formField('input', [
    'type' => 'url',
    'label' => 'Ссылка на договор оферты',
    'name' => 'help_offert-link',
])
@formField('wysiwyg', [
    'label' => 'Как это работает',
    'name' => 'help_how_it-works',
])
@formField('wysiwyg', [
    'label' => 'Наши реквизиты',
    'name' => 'help_our_details',
])
@formField('wysiwyg', [
    'label' => 'Претензии и возвраты',
    'name' => 'help_claims_returns',
])
@formField('wysiwyg', [
    'label' => 'Дополнительная информация',
    'name' => 'help_add_info',
])
