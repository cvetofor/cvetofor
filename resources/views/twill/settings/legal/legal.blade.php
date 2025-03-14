@twillBlockTitle('Данные для формирования счёта на оплату')
@twillBlockIcon('text')
@twillBlockGroup('app')



<x-twill::input name="recipient" label="Получатель" />
<x-twill::input name="recipient_account" label="Счет получателя p/c" />
<x-twill::input name="recipient_account_ks" label="Счет получателя к/c" />
<x-twill::input name="bik" label="БИК" />
<x-twill::input name="bank" label="Наименование банка" />
<x-twill::input name="correspondent_account" label="Корреспондентский счет" />
<x-twill::input name="inn" label="ИНН" />
<x-twill::input name="ogrn" label="ОГРНИП" />
<x-twill::input name="address" label="Адрес" />
<x-twill::input name="phone" label="Номер телефона" />
<x-twill::input name="email" label="Email" />
<x-twill::input name="director_text" label="Директор Фамилия И.О" />
<x-twill::input name="accountant_text" label="Бухгалтер Фамилия И.О" />

<x-twill::medias
    name="director"
    label="Образец подписи директора"
    note="Прозрачный фон"
    :max="1" />
<x-twill::medias
    name="accountant"
    label="Образец подписи бухгалтера"
    note="Прозрачный фон"
    :max="1" />
<x-twill::medias
    name="stamp"
    label="Штамп"
    note="Прозрачный фон"
    :max="1" />