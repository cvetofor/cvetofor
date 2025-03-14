<table>
    <tr>
        <td><b>Название магазина</b></td>
        <td>{{ $item->name }}</td>
    </tr>
    <tr>
        <td><b>Владелец магазина</b></td>
        <td>{{ $item->user_id }}</td>
    </tr>
    <tr>
        <td><b>Город</b></td>
        <td>{{ $item->city_id }}</td>
    </tr>
    <tr>
        <td><b>Адрес</b></td>
        <td>{{ $item->address }}</td>
    </tr>
    <tr>
        <td><b>Телефон</b></td>
        <td>{{ $item->phone }}</td>
    </tr>
    <tr>
        <td><b>E-mail</b></td>
        <td>{{ $item->email }}</td>
    </tr>
    <tr>
        <td><b>Сумма предоплаты</b></td>
        <td>{{ $item->order_prepaid }}</td>
    </tr>
    <tr>
        <td><b>Время доставки</b></td>
        <td>{{ $item->delivery_time_order_interval }}</td>
    </tr>
    <tr>
        <td><b>Интервал доставки</b></td>
        <td>{{ $item->delivery_min_time }}</td>
    </tr>
    <tr>
        <td><b>Стоимость ночной доставки</b></td>
        <td>{{ $item->delivery_night_price }}</td>
    </tr>
    <tr>
        <td><b>Процент увеличения стоимости товаров в праздничные дни</b></td>
        <td>{{ $item->holidays_percent }}</td>
    </tr>
    <tr>
        <td><b>Стоимость открытки</b></td>
        <td>{{ $item->postcard_price }}</td>
    </tr>
</table>
