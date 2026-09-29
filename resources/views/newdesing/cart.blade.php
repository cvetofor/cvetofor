@extends('newdesing.app')
@inject('citiesService', \App\Services\CitiesService::class)
@section('css')
    <link rel="stylesheet" href="/template/css/build/page-cart.css?v=2026091811">
@endsection
@section('content')

    @if (Cart::getContent()->count() == 0)
        <main id="main">

            <div class="container">
                <h1 class="page-title">Корзина</h1>
            </div>

            <section class="cart cart--empty container" aria-label="Корзина">
                <div class="box box--padding-40">
                    <div class="status-page">
                        <img class="status-page__icon" src="/template/assets/icons/cart.svg" alt="" width="64"
                             height="64">
                        <span class="status-page__title">Ваша корзина пуста</span>
                        <div class="status-page__text">
                            <p>Перейдите в <a class="link" href="/catalog">каталог</a> для выбора товара</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    @else
        <main id="main">

            <div class="container">
                <h1 class="page-title">Корзина</h1>
            </div>

            <section class="cart container" aria-label="Содержимое корзины">

                <div class="cart__main">
                    <div class="cart__items">
                        <h2 class="visually-hidden">Товары в корзине</h2>
                        @foreach ($cartByMarket as $collection)
                            <ul class="cart-list">
                                @foreach ($collection as $product)
                                    @if (isset($product->associatedModel->groupProduct) && $product->associatedModel->groupProduct)

                                        @include('newdesing.parts.product_in_cart',['associatedModel'=>'groupProduct'])
                                    @endif

                                    @if (isset($product->associatedModel->product) && $product->associatedModel->product)
                                        @include('newdesing.parts.product_in_cart',['associatedModel'=>'product'])
                                    @endif
                                @endforeach


                            </ul>
                        @endforeach
                    </div>

                    @if (isset($recomendations[$collection->first()->associatedModel->market->id]))
                    <section class="section panel cart__panel cart__recommend" aria-labelledby="rec-title">
                        <!-- В макете (103:29) у заголовка стоит шеврон вверх, а второго,
                             свёрнутого состояния не нарисовано — значит это переключатель.
                             details, а не кнопка со скриптом: сворачивается и без JS. -->
                        <details class="rec" open>
                            <summary class="section__head rec__head">
                                <h2 class="cart__subtitle" id="rec-title">Рекомендуем добавить</h2>
                                <span class="rec__chevron" aria-hidden="true"></span>
                            </summary>

                            <ul class="addons addons--compact">
                                @foreach ($collection as $product)
                                    @if ($product->associatedModel->product)
                                        @include('newdesing.parts.addition-item', [
                                            'price' => $product->associatedModel,
                                        ])
                                    @endif
                                @endforeach

                                @foreach ($recomendations[$collection->first()->associatedModel->market->id] as $key => $price)
                                    @if (!\Cart::get(md5($price->id)))
                                        @include('newdesing.parts.addition-item', [
                                            'price' => $price,
                                        ])
                                    @endif
                                @endforeach @foreach ($collection as $product)
                                    @if ($product->associatedModel->product)
                                        @include('newdesing.parts.addition-item', [
                                            'price' => $product->associatedModel,
                                        ])
                                    @endif
                                @endforeach

                                @foreach ($recomendations[$collection->first()->associatedModel->market->id] as $key => $price)
                                    @if (!\Cart::get(md5($price->id)))
                                        @include('newdesing.parts.addition-item', [
                                            'price' => $price,
                                        ])
                                    @endif
                                @endforeach


                            </ul>
                        </details>
                    </section>
                    @endif
                </div>

                <aside class="cart__aside" aria-label="Итоги заказа">

                    <div class="panel cart__panel summary-line">
          <span class="summary-line__icon">
            <img src="/template/assets/icons/delivery-truck.svg" alt="" width="27" height="27">
          </span>
                        <span class="summary-line__text">
            <span class="summary-line__title">Доставка</span>
           {{-- <span class="summary-line__note">При заказе до 18:00</span>--}}
          </span>
                        <span class="summary-line__price">от 0 ₽</span>
                    </div>

                    <div class="panel cart__panel totals totals--cart">
                        <p class="totals__head">
                            <span class="totals__title">Ваш заказ</span>
                            <span class="totals__count">Позиции: {{ $cart->count() }} шт</span>
                        </p>

                        <dl class="totals__list">
                            <div class="totals__row">
                                <dt class="totals__key">Товары{{-- ({{ $cart->count() }})--}}</dt>
                                <dd class="totals__val">@money(\Cart::getTotal() ) ₽</dd>
                            </div>
                            <div class="totals__row">
                                <dt class="totals__key">Доставка</dt>
                                <dd class="totals__val">от 0 ₽</dd>
                            </div>
                        </dl>

                        <hr class="totals__rule">

                        <p class="totals__sum">
                            <span class="totals__sum-key">Итого</span>
                            <span class="totals__sum-val">@money(\Cart::getTotal() ) ₽</span>
                        </p>

                        @if ($canGoToNext)
                        <a class="btn btn--primary totals__cta" href="{{ route('order.index') }}">Перейти к оформлению</a>
                        @endif
                    </div>

                    <div class="guarantee">
                        <img class="guarantee__icon" src="/template/assets/icons/adv-secure.svg" alt="" width="41"
                             height="53">
                        <p class="guarantee__text">
                            <span class="guarantee__title">Мы гарантируем свежесть цветов</span>
                            <span
                                class="guarantee__note">Если цветы завянут раньше — вернём деньги или заменим букет.</span>
                        </p>
                    </div>
                </aside>
            </section>
        </main>
    @endif
@endsection
