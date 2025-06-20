@extends('layouts.app')

@section('content')
    <div class="heading">
        <div class="container">
            <div class="heading__row">
                <div class="breadcrumbs">
                    <span class="breadcrumbs__item">
                        <a href="/">
                            <span>Главная</span>
                        </a>
                    </span>
                    <span class="breadcrumbs__item">
                        <span>Заказ
                            оформлен</span>
                    </span>
                </div>
                <div class="title-page">
                    <h1 class="h1">Заказ №{{ $order->num_order }} @if ($order->paymentStatus->code == \App\Models\PaymentStatus::PAID)
                            оплачен
                        @else
                            оформлен
                        @endif!</h1>
                </div>
                <div class="text-page">
                    <p>Заказ №{{ $order->num_order }} сформирован и направлен на почту {{ $order->email }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="page">
        <div class="section">
            <div class="container">
                <div class="box box--padding-40">
                    <div class="status-page">
                        <div class="status-page">
                            <svg class="status-page__icon">
                                <use href="#icon-check-in-square">

                                </use>
                            </svg>
                            <span class="status-page__title">Ваш заказ
                                @if ($order->paymentStatus->code == \App\Models\PaymentStatus::PAID)
                                    оплачен
                                @else
                                    оформлен
                                @endif
                            </span>
                            <div class="status-page__text">
                                <p>Перейдите в <a class="link" href="{{ route('profile.orders') }}">личный кабинет</a> для
                                    подробной информации</p>
                            </div>
                            @if ($order->isPaymentByInvoce())
                                <a class="link-button download-account-button" download="download"
                                    href="{{ route('order.pdf', ['order' => $order->uuid]) }}" target="_blank">
                                    <span class="link-button__title" onclick="loader(this);">Скачать счет</span>
                                    <svg class="link-button__icon">
                                        <use href="#icon-download">

                                        </use>
                                    </svg>
                                </a>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="section">
            <div class="container">
                <div class="box box--padding-40">
                    <h2 class="status-page__title">Состав заказа</h2>
                    <table class="order-details-table">
                        <thead>
                            <tr>

                                <th>Название товара</th>
                                <th>Артикул</th>
                                <th>Количество</th>
                                <th>Цена за единицу</th>
                                <th>Скидка</th>
                                <th>Итоговая стоимость</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->cart as $index => $cartItem)
                                @php

                                    $conditionals = array_sum(array_values($cartItem['conditions'] ?? []));
                                    $unitPrice = $cartItem['price'] - $conditionals;
                                    $totalPrice = $unitPrice * $cartItem['quantity'];
                                    $price = \App\Models\ProductPrice::find(
                                        isset($cartItem['associatedModel'])
                                            ? $cartItem['associatedModel']['id']
                                            : false,
                                    );
                                    $sku = $price->sku ?? '-';
                                @endphp
                                <tr>

                                    <td>{{ $cartItem['name'] }}</td>
                                    <td>{{ $sku }}</td>
                                    <td>{{ $cartItem['quantity'] }}</td>
                                    <td>@money($cartItem['price']) р.</td>
                                    <td>@money($conditionals) р.</td>
                                    <td>@money($totalPrice) р.</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" style="text-align: right; font-weight: bold;">Итого:</td>
                                <td>@money($order->total_price) р.</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>
    </div>
@endsection


@push('styles')
    <style>
        .order-details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .order-details-table th,
        .order-details-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        .order-details-table th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        .order-details-table tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        .order-details-table tbody tr:nth-child(even) {
            background-color: #fff;
        }

        .order-details-table tfoot td {
            background-color: #f4f4f4;
            font-weight: bold;
        }
    </style>
@endpush
@push('scripts')
    <script>
        const loader = function(e) {
            e.innerText = 'Ожидайте загруки';
        }
    </script>
@endpush

@push('scripts')
    <script>
        ym(95560855, 'reachGoal', 'payment');
        /*

            @if ($order->paymentStatus->code == \App\Models\PaymentStatus::PAID)
                                @php
                                    $price = \App\Models\ProductPrice::find(isset($cartItem['associatedModel']) ? $cartItem['associatedModel']['id'] : false);
                                    $sku = $price->sku ?? '-';
                                    $category = $cartItem['attributes']['category'] ?? 'Не указано';
                                @endphp {
                                    "id": "{{ $sku }}", // SKU или ID товара
                                    "name": "{{ $cartItem['name'] }}", // Название товара
                                    "price": "{{ $cartItem['price'] }}", // Цена за единицу
                                    "quantity": "{{ $cartItem['quantity'] }}", // Количество
                                    "category": "{{ $category }}" // Категория
                                }
                                @if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        ]
                    }
                }
            });
        @endif

        */
    </script>
@endpush
