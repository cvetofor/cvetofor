@php
$contentFieldsetLabel = 'Информация о доставке';
@endphp

@extends('twill::layouts.form', [
'additionalFieldsets' => [['fieldset' => 'delivery', 'label' => 'Доставка'], ['fieldset' => 'info', 'label' => 'Информация о получателе'],
['fieldset' => 'map', 'label' => 'Карта']],
])

@section('contentFields')

<div class="wrapper">
    <div class="col col--double">
        <x-twill::checkbox name="is_photo_needle"
            label="Требуется фото"
            :disabled="true" />
    </div>
    <div class="col col--double">
        <x-twill::checkbox name="is_anon"
            label="Анонимный букет"
            :disabled="true" />
    </div>
</div>

<x-twill::input name="comment"
    type="textarea"
    label="Комментарий"
    rows="5"
    :disabled="true" />

@stop

@section('fieldsets')

<a17-fieldset id="products"
    title="Кому">
    <x-twill::input name="person_receiving_name"
        label="Имя"
        rows="5"
        :disabled="true" />
    <x-twill::input name="person_receiving_phone"
        label="Телефон"
        rows="5"
        :disabled="true" />

    <x-twill::input name="address.address"
        label="Адрес доставки"
        :disabled="true" />

    <x-twill::input name="address.apartament_number"
        label="Квартира"
        :disabled="true" />

    <x-twill::date-picker name="delivery_date"
        label="Необходимая дата доставки"
        :withTime="false"
        :disabled="true" />

    <x-twill::input name="delivery_time"
        label="Интервал"
        :disabled="true" />

</a17-fieldset>
@if (isset($item->order->address['coordinates']))
<a17-fieldset id="map"
    style="min-height: 700px"
    title="Карта">

    <div id="map"></div>

    <script src="//api-maps.yandex.ru/2.1/?{{ config('app.yandex_api') }}&lang=ru_RU">
    </script>
    <script>
        ymaps.ready(function() {
            var myMap = new ymaps.Map('map', {
                center: [{
                    {
                        $item - > order - > address['coordinates']
                    }
                }],
                zoom: 9,
                // Добавим панель маршрутизации.
                controls: ['routePanelControl']
            });

            var control = myMap.controls.get('routePanelControl');

            // Зададим состояние панели для построения машрутов.
            control.routePanel.state.set({
                // Тип маршрутизации.
                type: 'masstransit',
                // Выключим возможность задавать пункт отправления в поле ввода.
                fromEnabled: false,
                // Адрес или координаты пункта отправления.
                from: control.routePanel.geolocate('from'),
                // Включим возможность задавать пункт назначения в поле ввода.
                toEnabled: true,
                // Адрес или координаты пункта назначения.
                to: [{
                    {
                        $item - > order - > address['coordinates']
                    }
                }]
            });

            // Зададим опции панели для построения машрутов.
            control.routePanel.options.set({
                // Запрещаем показ кнопки, позволяющей менять местами начальную и конечную точки маршрута.
                allowSwitch: false,
                // Включим определение адреса по координатам клика.
                // Адрес будет автоматически подставляться в поле ввода на панели, а также в подпись метки маршрута.
                reverseGeocoding: true,
                // Зададим виды маршрутизации, которые будут доступны пользователям для выбора.
                types: {
                    masstransit: true,
                    pedestrian: true,
                    taxi: true
                }
            });

            // Создаем кнопку, с помощью которой пользователи смогут менять местами начальную и конечную точки маршрута.
            var switchPointsButton = new ymaps.control.Button({
                data: {
                    content: "Поменять местами",
                    title: "Поменять точки местами"
                },
                options: {
                    selectOnClick: false,
                    maxWidth: 160
                }
            });
            // Объявляем обработчик для кнопки.
            switchPointsButton.events.add('click', function() {
                // Меняет местами начальную и конечную точки маршрута.
                control.routePanel.switchPoints();
            });
            myMap.controls.add(switchPointsButton);
        });
    </script>
</a17-fieldset>
@endif
@endsection

@section('sideFieldsets')

<a17-fieldset id="statuses"
    title="Статусы">

    <x-twill::input name="total_price"
        label="Стоимость"
        :disabled="true" />

    <x-twill::browser name="order_deliveryStatus"
        module-name="deliveryStatuses"
        label="Статус доставки"
        :max="1" />

</a17-fieldset>
@endsection