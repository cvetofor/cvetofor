<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
        * {
            font-family: firefly, DejaVu Sans, sans-serif;
            font-size: 14px;
            line-height: 14px;
        }

        table {
            margin: 0 0 15px 0;
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }

        table th {
            padding: 5px;
            font-weight: bold;
        }

        table td {
            padding: 5px;
        }

        .header {
            margin: 0 0 0 0;
            padding: 0 0 15px 0;
            font-size: 12px;
            line-height: 12px;
            text-align: center;
        }

        h1 {
            margin: 0 0 10px 0;
            padding: 10px 0;
            border-bottom: 2px solid #000;
            font-weight: bold;
            font-size: 20px;
        }

        /* Реквизиты банка */
        .details td {
            padding: 3px 2px;
            border: 1px solid #000000;
            font-size: 12px;
            line-height: 12px;
            vertical-align: top;
        }

        /* Поставщик/Покупатель */
        .contract th {
            padding: 3px 0;
            vertical-align: top;
            text-align: left;
            font-size: 13px;
            line-height: 15px;
        }

        .contract td {
            padding: 3px 0;
        }

        /* Наименование товара, работ, услуг */
        .list thead,
        .list tbody {
            border: 2px solid #000;
        }

        .list thead th {
            padding: 4px 0;
            border: 1px solid #000;
            vertical-align: middle;
            text-align: center;
        }

        .list tbody td {
            padding: 0 2px;
            border: 1px solid #000;
            vertical-align: middle;
            font-size: 11px;
            line-height: 13px;
        }

        .list tfoot th {
            padding: 3px 2px;
            border: none;
            text-align: right;
        }

        /* Сумма */
        .total {
            margin: 0 0 20px 0;
            padding: 0 0 10px 0;
            border-bottom: 2px solid #000;
        }

        .total p {
            margin: 0;
            padding: 0;
        }

        /* Руководитель, бухгалтер */
        .sign {
            position: relative;
        }

        .sign table {
            width: 60%;
        }

        .sign th {
            padding: 40px 0 0 0;
            text-align: left;
        }

        .sign td {
            padding: 40px 0 0 0;
            border-bottom: 1px solid #000;
            text-align: right;
            font-size: 12px;
        }

        .sign-1 {
            position: absolute;
            left: 149px;
            top: -44px;
        }

        .sign-2 {
            position: absolute;
            left: 149px;
            top: 0;
        }

        .printing {
            position: absolute;
            left: 271px;
            top: -15px;
        }
    </style>
</head>

<body>
    <p class="header"> Внимание! Оплата данного счета означает согласие с условиями поставки товара. Уведомление об оплате обязательно, в противном случае не
        гарантируется наличие товара на складе. Товар отпускается по факту прихода денег на р/с Поставщика, самовывозом, при наличии доверенности и паспорта.
    </p>
    <table class="details">
        <tbody>
            <tr>
                <td colspan="2" style="border-bottom: none;">{{ $legal['bank'] }}</td>
                <td>БИК</td>
                <td style="border-bottom: none;">{{ $legal['bik'] }}</td>
            </tr>
            <tr>
                <td colspan="2" style="border-top: none; font-size: 10px;">Банк получателя</td>
                <td>Сч. №</td>
                <td style="border-top: none;">{{ $legal['recipient_account_ks'] }}</td>
            </tr>
            <tr>
                <td width="25%">ИНН {{ $legal['inn'] }}</td>
                <td width="10%" rowspan="3">Сч. №</td>
                <td width="35%" rowspan="3">{{ $legal['recipient_account'] }}</td>
            </tr>
            <tr>
                <td colspan="2" style="border-bottom: none;">{{ $legal['recipient'] }}</td>
            </tr>
            <tr>
                <td colspan="2" style="border-top: none; font-size: 10px;">Получатель</td>
            </tr>
        </tbody>
    </table>
    <h1>Счет на оплату № {{ $order->id }} от {{ $order->created_at->format('d') }} {{ $month }} {{ $order->created_at->format('Y') }} г.</h1>
    <table class="contract">
        <tbody>
            <tr>
                <td width="15%">Поставщик:</td>
                <th width="85%">{{ $legal['recipient'] }}, ИНН {{ $legal['inn'] }}, КПП {{ $legal['kpp'] }}, {{ $legal['address'] }}</th>
            </tr>
            <tr>
                <td>Покупатель:</td>
                <th>{{ $order->legalAccount->recipient }}, ИНН {{ $order->legalAccount->inn }}, КПП {{ $order->legalAccount->kpp }}, {{ $order->legalAccount->address }} </th>
            </tr>
        </tbody>
    </table>
    <table class="list">
        <thead>
            <tr>
                <th width="5%">№</th>
                <th width="54%">Наименование товара, работ, услуг</th>
                <th width="8%">Коли-<br>чество</th>
                <th width="14%">Цена</th>
                <th width="14%">Сумма</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order['cart'] as $cartItem)
            @php
            # учитываем возможную скидку на товар
            $conditionals = \array_sum(array_values($cartItem['conditions']));
            @endphp
            <tr>
                <td align="center">{{ $loop->index + 1 }}</td>
                <td align="left">{{ $cartItem['name'] }}</td>
                <td align="right">{{ $cartItem['quantity'] }}</td>
                <td align="right">{{ ($cartItem['price'] - $conditionals) }}</td>
                <td align="right">{{ $cartItem['quantity'] * ($cartItem['price'] - $conditionals) }}</td>
            </tr>
            @endforeach
            <tr>
                <td align="center"></td>
                <td align="left">Доставка</td>
                <td align="right"></td>
                <td align="right"></td>
                <td align="right">{{ number_format((float)$deliveryPrice, 2, ',', ' ') }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4">Итого:</th>
                <th>{{ number_format(($order->total_price), 2, ',', ' ') }}</th>
            </tr>
            <tr>
                <th colspan="4">В том числе НДС:</th>
                <th>{{ number_format(($order->total_price) / 100 * 20, 2, ',', ' ') }}</th>
            </tr>
            <tr>
                <th colspan="4">Всего к оплате:</th>
                <th>{{ number_format(($order->total_price), 2, ',', ' ') }}</th>
            </tr>
        </tfoot>
    </table>
    <div class="total">
        <p>Всего наименований {{ count($order['cart']) }}, на сумму {{ number_format((float)($order->total_price), 2, ',', ' ') }} руб.</p>
        <p>
            <strong>{{ \App\Services\Helpers::strPrice(($order->total_price)) }}</strong>
        </p>
    </div>
    <div class="sign">
        @if(isset($medias[0]))
        <img class="sign-1" src="{!! ImageService::getRawUrl($medias[0]->uuid) !!}">
        @endif
        @if(isset($medias[1]))
        <img class="sign-2" src="{!! ImageService::getRawUrl($medias[1]->uuid) !!}">
        @endif
        @if(isset($medias[2]))
        <img class="printing" src="{!! ImageService::getRawUrl($medias[2]->uuid) !!}">
        @endif

        <table>
            <tbody>
                <tr>
                    <th width="30%">Руководитель</th>
                    <td width="70%">{{ $legal['director_text'] }}</td>
                </tr>
                <tr>
                    <th>Бухгалтер</th>
                    <td>{{ $legal['accountant_text'] }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>