@formField('input', [
'name' => 'fio',
'label' => 'ФИО',
'maxlength' => 300,
'required' => true,
])

@formField('input', [
'name' => 'legal_address',
'label' => 'Юридический адрес',
'maxlength' => 300,
])

@formField('input', [
'name' => 'postal_address',
'label' => 'Почтовый адрес',
'maxlength' => 1000,
])

@formField('input', [
'name' => 'inn',
'label' => 'ИНН',
'maxlength' => 50,
])

@formField('input', [
'name' => 'ogrn',
'label' => 'ОГРНИП',
'maxlength' => 50,
])

@formField('input', [
'name' => 'bank_fullname',
'label' => 'Название банка полностью',
'maxlength' => 1000,
])

@formField('input', [
'name' => 'payment_account',
'label' => 'Расчетный счёт',
'maxlength' => 300,
])

@formField('input', [
'name' => 'correspondent_account',
'label' => 'Корреспондентский счёт',
'maxlength' => 300,
])

@formField('input', [
'name' => 'bik',
'label' => 'БИК',
'maxlength' => 300,
])