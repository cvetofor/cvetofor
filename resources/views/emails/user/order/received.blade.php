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

Благодарим вас за оплату!

Надеемся, букет вам понравится и вы будете довольны сервисом.

    {{-- Salutation --}}
    @if (!empty($salutation))
{{ $salutation }}
    @else
Хорошего вам дня!<br>{{ config('app.name') }}<br>
    @endif
</x-mail::message>
