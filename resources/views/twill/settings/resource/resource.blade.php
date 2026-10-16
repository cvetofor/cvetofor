@twillBlockTitle('Настройки ресурса')
@twillBlockIcon('text')
@twillBlockGroup('app')



<x-twill::input name="comission" type="number" label="Комиссия ресурса за каждую покупку" prefix="%" max=100 min=0 />


<x-twill::input name="telegram_bot_api" label="Telegram Секретный ключ" max=300 min=0 />

@php
    $designOptions = [
        ['value' => 'dynamic', 'label' => 'Динамический'],
        ['value' => 'new', 'label' => 'Новый дизайн'],
        ['value' => 'old', 'label' => 'Старый дизайн'],
    ];
@endphp
<x-twill::select name="design" label="Дизайн сайта" :options="$designOptions" default="dynamic" />
