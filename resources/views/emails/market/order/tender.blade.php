<x-mail::message>
    <style>
        table * img{
            max-width: 150px;
            max-height: 150px;
        }
    </style>
    {{-- Greeting --}}
    @if (!empty($greeting))
{{ $greeting }}
    @else
        @if ($level === 'error')
@lang('Ууупс!')
        @else
@lang('Здравствуйте!')
        @endif
    @endif
    {{-- Intro Lines --}}
    @foreach ($introLines as $line)
{{ $line }}
    @endforeach

    {{-- Outro Lines --}}
    @foreach ($outroLines as $line)
{{ $line }}
    @endforeach


| № | Изображение | Наименование товара | Количество| Цена | Сумма|
|:---|:---:|:---:|:---:|:---:|---:|
        @foreach ($order['cart'] as $cartItem)
            @php
                #  учитываем возможную скидку на товар
                $conditionals = \array_sum(array_values($cartItem['conditions']));
                $price = \App\Models\ProductPrice::find(isset($cartItem['associatedModel']) ? $cartItem['associatedModel']['id'] : false);

                if ($price && $price->groupProduct && isset($price->groupProduct->images('cover')[0])) {
                    $image = $price->groupProduct->images('cover')[0];
                } elseif ($price && $price->product && isset($price->product->images('preview')[0])) {
                    $image = $price->product->images('preview')[0];
                }
                else {
                    $image = '#';
                }
            @endphp
|{{ $loop->index + 1 }}|![]({{ $image }})|{{ $cartItem['name'] }}|{{ $cartItem['quantity'] }}|{{ $cartItem['price'] - $conditionals }}|{{ $cartItem['quantity'] * ($cartItem['price'] - $conditionals) }}|
        @endforeach
||||||***Доставка:*** |
|||||| {{ number_format($deliveryPrice, 2, ',', ' ') }}|
||||||***Всего:*** |
|||||| {{ number_format($order->total_price, 2, ',', ' ') }}|

***Имя покупателя:***:{{  $order->user->last_name }} {{  $order->user->name }} {{  $order->user->second_name }}

***Номер покупателя:***:{{  $order->phone }}

***Номер получателя:***:{{  $order->person_receiving_phone }}

***Имя получателя:***: {{  $order->person_receiving_name }}

***Дата и время:***:{{ isset($order->address['address']) ? $order->address['address'] : 'Адрес не указан' }}, {{ (new \Carbon\Carbon($order->delivery_date))->format('d.m.Y') }}, {{ $order->delivery_time }}

@if($order->postcard_text)
***Текст открытки:***: {{ $order->postcard_text }}
@endif




Заказа доступен вам на странице
@component('mail::button', ['url' => route('twill.orders.index', ['filter' => '{"status":"tender"}'])])
Тендеры
@endcomponent
</x-mail::message>
