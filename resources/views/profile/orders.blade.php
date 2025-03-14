@extends('layouts.app')

@push('styles')
<meta name="robots" content="noindex">
@endpush

@section('content')
<div class="heading">
    <div class="container">
        <div class="heading__row">
            <div class="breadcrumbs"><span class="breadcrumbs__item"><a href="/"><span>Главная</span></a></span><span class="breadcrumbs__item"><span>Личный
                        кабинет</span></span>
            </div>
            <div class="title-page">
                <h1 class="h1">Личный кабинет</h1>
            </div>
        </div>
    </div>
</div>
<div class="page">
    <div class="main-cols__wrap">
        <div class="container">
            @include('profile.components.menu')
            <div class="main-col">
                <div class="personal">
                    <div class="section">
                        <div class="orders__wrap">
                            @foreach ($orders as $order)
                            @php
                            $childs = $order->childs;
                            @endphp
                            <div class="box">
                                <div class="order">
                                    <div class="order__heading accordion" data-accordion="">
                                        <div class="accordion__toggle" data-accordion-toggle="">
                                            <div class="accordion__title"><span>Заказ №{{ $order->id }} от
                                                    {{ $order->created_at->format('d.m.Y') }}</span></div>
                                            <div class="accordion__btn">
                                                <svg>
                                                    <use href="#icon-arrow-accordion"></use>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="accordion__content" data-accordion-content="">
                                            <div class="order__sellers-wrap">
                                                @foreach ($childs as $_order)
                                                <div class="order__seller">
                                                    <div class="order__seller-heading"><span class="order__seller-title">{{ optional($_order->market)->name ?? '...' }}</span>

                                                        @if(
                                                        $_order->orderStatus?->code == \App\Models\OrderStatus::CANCELED_USER ||
                                                        $_order->orderStatus?->code == \App\Models\OrderStatus::CANCELED)
                                                        @php
                                                        $class = 'canceled';
                                                        $icon = '#icon-cross';
                                                        @endphp
                                                        @elseif ($_order->orderStatus?->code == \App\Models\OrderStatus::COMPLETE)
                                                        @php
                                                        $class = 'completed';
                                                        $icon = '#icon-check';
                                                        @endphp
                                                        @else
                                                        @php
                                                        $class = 'in-work';
                                                        $icon = '#icon-rotate';
                                                        @endphp
                                                        @endif
                                                        <div class="order__seller-status order__seller-status--{{ $class }}"><span class="order__seller-status__title">{{ $_order->orderStatus?->title }}</span>
                                                            <svg class="order__seller-status__icon">
                                                                <use href="{{ $icon }}"></use>
                                                            </svg>
                                                        </div>


                                                    </div>
                                                    <div class="order__seller-list">
                                                        @foreach ($_order->cart as $cartItem)
                                                        @php
                                                        # учитываем возможную скидку на товар
                                                        $conditionals = \array_sum(array_values($cartItem['conditions']));
                                                        @endphp
                                                        <div class="order__seller-list__item"><span>{{ $cartItem['quantity'] }} x {{ $cartItem['name'] }}</span><span>@money(($cartItem['price'] - $conditionals) * $cartItem['quantity']) р.</span></div>
                                                        @endforeach
                                                        <div class="order__seller-list__item"><span>Доставка</span><span>@money($_order->delivery->price) р.</span></div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="order__bottom">
                                        <div class="order__info">
                                            <div class="order__info-item"><span class="order__info-item__title">Получатель:</span><span class="order__info-item__value">{{ $order->person_receiving_name }}</span></div>
                                            <div class="order__info-item"><span class="order__info-item__title">Сумма:</span><span class="order__info-item__value">@money($order->total_price) р.</span></div>
                                        </div>
                                        @php
                                        $isCanceled = $_order->orderStatus?->code == \App\Models\OrderStatus::CANCELED_USER ||
                                        $_order->orderStatus?->code == \App\Models\OrderStatus::CANCELED;
                                        @endphp
                                        @if($order?->paymentStatus?->code === \App\Models\PaymentStatus::AWAIT && ! $isCanceled)
                                        @if( in_array($order?->payment?->code , [\App\Models\Payment::ROBOKASSA, \App\Models\Payment::YOOKASSA ]))
                                        <a href="{{ route('order.pay',['order' => $order->uuid]) }}" class="link-button" target="_blank">Оплатить</a>
                                        @endif
                                        @endif
                                        <button class="link-button leave-review-button" data-modal-open="leave-review" onclick="review({{ $order->id }},'{{ optional($_order->review)->description }}')"><span class="link-button__title">Отзыв</span>
                                            <svg class="link-button__icon">
                                                <use href="#icon-edit"></use>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @if ($orders->hasMorePages())
                            <a class="button button--purple show-more-button" data-load-more="" href="{{ $orders->nextPageUrl() }}">Показать еще</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection