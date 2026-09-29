@extends('newdesing.app')
@inject('citiesService', \App\Services\CitiesService::class)

@section('content')
    <main id="main">

        <!-- ====================================================== Hero ==== -->
        <section class="hero container">
            <img class="hero__bg" src="/template/assets/img/hero-bg.jpg" alt="" width="1110" height="460">
            <img class="hero__blob" src="/template/assets/icons/hero-ellipse.svg" alt="" aria-hidden="true"
                 width="637" height="610">

            <div class="hero__content">
                <h1 class="hero__title">Цветы с доставкой в Улан-Удэ</h1>
                <p class="hero__text">
                    Свежие букеты от 1490&nbsp;₽<br>
                    Доставка за 2 часа или в удобное время
                </p>
                <div class="hero__actions">
                    <a class="btn btn--hero" href="#categories">
                        <img src="/template/assets/icons/hero-catalog.svg" alt="" width="22" height="22">
                        Каталог букетов
                    </a>
                    <a class="btn btn--hero-outline" href="#order">
                        <img src="/template/assets/icons/hero-fast.svg" alt="" width="18" height="22">
                        Быстрый заказ
                    </a>
                </div>
            </div>
        </section>

        <!-- ================================================ Categories ==== -->
        @include('newdesing.parts.short_cats',['not_short'=>1])
        <!-- =================================================== Filters ==== -->







    </main>
@endsection
