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


@include('emails.user.order.table', ['deliveryPrice' =>$deliveryPrice ,'order' => $order])

***Ваш номер:***:{{  $order->phone }}

***Номер получателя:***:{{  $order->person_receiving_phone }}

***Кому:***: {{  $order->person_receiving_name }}

***Дата и время:***:{{ isset($order->address['address']) ? $order->address['address'] : 'Адрес не указан' }}, {{ (new \Carbon\Carbon($order->delivery_date))->format('d.m.Y') }}, {{ $order->delivery_time }}

@if($order->postcard_text)
***Текст открытки:***: {{ $order->postcard_text }}
@endif




А теперь я расскажу, что будет происходить дальше:

*   Мы бережно соберем ваш заказ, Вы можете не переживать на счет сохранности
*   В выбранное вами дату и время заказ будет у вас

Как видите, всё просто :)

    {{-- Salutation --}}
    @if (!empty($salutation))
{{ $salutation }}
    @else
Хорошего вам дня!<br>{{ config('app.name') }}<br>
    @endif
</x-mail::message>
