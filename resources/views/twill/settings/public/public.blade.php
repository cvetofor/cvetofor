@twillBlockTitle('Публичная часть')
@twillBlockIcon('text')
@twillBlockGroup('app')

@php
$tabs = [
    ['name' => 'item_1', 'label' => 'Информация'],
    ['name' => 'item_2', 'label' => 'Верхнее меню'],
    ['name' => 'item_3', 'label' => 'Нижнее меню'],
    ['name' => 'item_4', 'label' => 'Нижнее меню 2й уровень'],
    ['name' => 'item_5', 'label' => 'Страница заказа'],
    ['name' => 'item_6', 'label' => 'Элементы меню "По цветам"'],
];
@endphp

<a17-custom-tabs :tabs="{{ json_encode($tabs) }}">
    <div class="custom-tab custom-tab--item_1">
        <x-twill::input name="phone" label="Телефон" :required="true" />
        <x-twill::input name="address" label="Адрес" :required="true" />

        <x-twill::input name="vk" label="Ссылка ВК" />

        <x-twill::input name="whatsapp" label="Ссылка whatsapp" />

        <x-twill::input name="telegram" label="Ссылка telegram" />
    </div>
    <div class="custom-tab custom-tab--item_2">
        <x-twill::repeater label="Верхнее меню" name="header_menu" type="menu" />
    </div>
    <div class="custom-tab custom-tab--item_3">
        <x-twill::repeater name="footer_menu" type="menu" />
    </div>
    <div class="custom-tab custom-tab--item_4">
        <x-twill::repeater name="footer_menu_second" type="menu" />
    </div>
    <div class="custom-tab custom-tab--item_5">
        <x-twill::checkbox name="photo_is_visible" label="Фотоотчёт вкл" />
        <x-twill::checkbox name="anon_is_visible" label="Анонимность вкл" />

        <x-twill::input name="order_photo_desc" label="Фотоотчёт описание" />
        <x-twill::input name="order_postcart_text_desc" label="Открытка с текстом описание" />
    </div>
    <div class="custom-tab custom-tab--item_6">
        <x-twill::repeater name="flowers_menu" type="arr" />
    </div>
</a17-custom-tabs>
