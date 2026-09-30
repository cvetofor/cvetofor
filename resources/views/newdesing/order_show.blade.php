@extends('newdesing.app')
@inject('citiesService', \App\Services\CitiesService::class)
@inject('marketService', \App\Services\MarketService::class)
@section('css')  <link rel="stylesheet" href="/template/css/build/page-success.css?v=20260918">@endsection
@section('content')
    <main id="main">

        <section class="success container" aria-labelledby="success-title">
            <!-- Номер заказа выделен цветом — это единственное, что человек
                 выписывает с этой страницы -->
            <p class="success__order">Заказ <span class="success__num">№{{$order->num_order}}</span> сформирован и направлен на почту</p>

            <div class="success__panel">
                <div class="success__art" aria-hidden="true">
          <span class="success__badge">
            <img src="/template/assets/icons/success-check.svg" alt="" width="100" height="100">
          </span>
                    <img class="success__decor" src="/template/assets/icons/sparkle-md.svg" alt=""
                         width="17" height="17"
                         style="--x: 16.19%; --y: 22.54%; --size: 17px; --turn: 0deg">
                    <img class="success__decor" src="/template/assets/icons/sparkle-lg.svg" alt=""
                         width="24" height="24"
                         style="--x: 94.29%; --y: 62.43%; --size: 24px; --turn: 0deg">
                    <img class="success__decor" src="/template/assets/icons/sparkle-sm.svg" alt=""
                         width="11" height="11"
                         style="--x: 75.00%; --y: 81.50%; --size: 11px; --turn: 0deg">
                    <img class="success__decor" src="/template/assets/icons/sparkle-sm.svg" alt=""
                         width="11" height="11"
                         style="--x: 26.90%; --y: 0.00%; --size: 11px; --turn: 0deg">
                    <img class="success__decor" src="/template/assets/icons/sparkle-sm.svg" alt=""
                         width="11" height="11"
                         style="--x: 0.00%; --y: 64.74%; --size: 11px; --turn: 0deg">
                    <img class="success__decor" src="/template/assets/icons/sparkle-sm.svg" alt=""
                         width="11" height="11"
                         style="--x: 82.62%; --y: 35.26%; --size: 11px; --turn: 0deg">
                    <img class="success__decor" src="/template/assets/icons/leaf-1.svg" alt=""
                         width="25" height="25"
                         style="--x: 18.33%; --y: 54.91%; --size: 25px; --turn: -94.66deg">
                    <img class="success__decor" src="/template/assets/icons/leaf-2.svg" alt=""
                         width="18" height="18"
                         style="--x: 94.29%; --y: 10.40%; --size: 18px; --turn: -6.92deg">
                    <img class="success__decor" src="/template/assets/icons/leaf-3.svg" alt=""
                         width="13" height="13"
                         style="--x: 79.05%; --y: 64.74%; --size: 13px; --turn: 8.91deg">
                    <img class="success__decor" src="/template/assets/icons/leaf-4.svg" alt=""
                         width="13" height="13"
                         style="--x: 5.71%; --y: 84.39%; --size: 13px; --turn: -137.51deg">
                </div>

                <h1 class="success__title" id="success-title">Ваш заказ оплачен</h1>
                <p class="success__note">
                    Перейдите в <a class="success__link" href="/account">личный кабинет</a>
                    для подробной информации
                </p>
            </div>
        </section>
    </main>

@endsection
