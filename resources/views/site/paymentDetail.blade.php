<table>
    <tr>
        <td><b>ID пользователя</b></td>
        <td>{{ $item->user_id }}</td>
    </tr>
    <tr>
        <td><b>Подтвержденный аккаунт</b></td>
        <td>{{ $item->approved }}</td>
    </tr>
    <tr>
        <td><b>ФИО</b></td>
        <td>{{ $item->fio }}</td>
    </tr>
    <tr>
        <td><b>Юр. Адрес</b></td>
        <td>{{ $item->legal_address }}</td>
    </tr>
    <tr>
        <td><b>Адрес</b></td>
        <td>{{ $item->postal_address }}</td>
    </tr>
    <tr>
        <td><b>ИНН</b></td>
        <td>{{ $item->inn }}</td>
    </tr>
    <tr>
        <td><b>ОГРНИП</b></td>
        <td>{{ $item->ogrn }}</td>
    </tr>
    <tr>
        <td><b>Полное название банка</b></td>
        <td>{{ $item->bank_fullname }}</td>
    </tr>
    <tr>
        <td><b>Платежный аккаунт</b></td>
        <td>{{ $item->payment_account }}</td>
    </tr>
    <tr>
        <td><b>Корреспондентский счёт</b></td>
        <td>{{ $item->correspondent_account }}</td>
    </tr>
    <tr>
        <td><b>БИК</b></td>
        <td>{{ $item->bik }}</td>
    </tr>
</table>