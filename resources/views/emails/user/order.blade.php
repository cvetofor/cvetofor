<x-mail::message>

    <style>
        body,
        table,
        tr,
        td {
            background-color: #f8f7f7 !important;
        }
    </style>
    {{-- Greeting --}}
    @if (!empty($greeting))
    # {{ $greeting }}
    @else
    @if ($level === 'error')
    # @lang('Ууупс!')
    @else
    # @lang('Здравствуйте!')
    @endif
    @endif

    {{-- Intro Lines --}}
    @foreach ($introLines as $line)
    {{ $line }}
    @endforeach

    {{-- Action Button --}}
    @isset($actionText)
    <?php
    $color = match ($level) {
        'success', 'error' => $level,
        default => 'primary',
    };
    ?>
    <x-mail::button :url="$actionUrl"
        :color="$color">
        {{ $actionText }}
    </x-mail::button>
    @endisset

    {{-- Outro Lines --}}
    @foreach ($outroLines as $line)
    {{ $line }}
    @endforeach

    @if ($order)
    <table class="list">
        <thead>
            <tr>
                <th width="5%">№</th>
                <th width="14%">Наименование товара</th>
                <th width="40%">Изображение</th>
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
            $price = \App\Models\ProductPrice::find($cartItem['associatedModel']['id']);

            if ($price->groupProduct && isset($price->groupProduct->images('cover')[0])) {
            $image = $price->groupProduct->images('cover')[0];
            } elseif ($price->product && isset($price->product->images('preview')[0])) {
            $image = $price->product->images('preview')[0];
            }
            @endphp
            <tr>
                <td align="center">{{ $loop->index + 1 }}</td>
                <td align="center"><img src="{{ $image }}" alt=""></td>
                <td align="left">{{ $cartItem['name'] }}</td>
                <td align="right">{{ $cartItem['quantity'] }}</td>
                <td align="right">
                    {{ $cartItem['price'] - $conditionals }}
                </td>
                <td align="right">
                    {{ $cartItem['quantity'] * ($cartItem['price'] - $conditionals) }}
                </td>
            </tr>
            @endforeach
            <tr>
                <td align="center"></td>
                <td align="left">Доставка</td>
                <td align="right"></td>
                <td align="right"></td>
                <td align="right">
                    {{ number_format((float) $deliveryPrice, 2, ',', ' ') }}
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4">Всего к оплате:</th>
                <th>{{ number_format($order->total_price, 2, ',', ' ') }}
                </th>
            </tr>
        </tfoot>
    </table>
    @endif

    {{-- Salutation --}}
    @if (!empty($salutation))
    {{ $salutation }}
    @else
    Хорошего вам дня!<br>{{ config('app.name') }}<br>
    @endif

    {{-- Subcopy --}}
    @isset($actionText)
    <x-slot:subcopy>
        @lang("Если у вас возникли проблемы с кнопкой \":actionText\", скопируйте и вставьте URL-адрес ниже\n" . 'в вашем веб-браузере:', [
        'actionText' => $actionText,
        ]) <span
            class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
    </x-slot:subcopy>
    @endisset
</x-mail::message>