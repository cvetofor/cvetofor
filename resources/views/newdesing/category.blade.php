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


        <!-- =================================================== Filters ==== -->
         @include('newdesing.parts.filter')

        @if ($prices)
            @foreach ($prices as $paginator)
                @if ($paginator->items()&&isset( $paginator->items()[0]->groupProduct->category))
                    @include('newdesing.parts.catalog-product-block',['cat_url'=>route('catalog.category', ['slug' => $paginator->items()[0]->groupProduct->category->nestedSlug]),'cat_name'=>$paginator->items()[0]->groupProduct->category->title,'paginator'=>$paginator,'cat_id'=>$paginator->items()[0]->groupProduct->category_id,'typeproduct'=>'groupProduct'])
                    @if($loop->first)
                        <!-- ================================================ Advantages ==== -->
                        <section class="section container" id="delivery" aria-labelledby="adv-title">
                            <h2 class="visually-hidden" id="adv-title">Наши преимущества</h2>

                            <ul class="advantages panel">
                                <li class="advantage">
          <span class="advantage__icon">
            <img src="/template/assets/icons/adv-truck.svg" alt="" width="67" height="50">
          </span>
                                    <h3 class="advantage__title">Доставка сегодня</h3>
                                    <p class="advantage__text">При заказе до 18:00</p>
                                </li>
                                <li class="advantages__rule" aria-hidden="true"></li>
                                <li class="advantage advantage--wide">
          <span class="advantage__icon">
            <img src="/template/assets/icons/adv-photo.svg" alt="" width="57" height="57">
          </span>
                                    <h3 class="advantage__title">Фото перед отправкой</h3>
                                    <p class="advantage__text">Каждого букета</p>
                                </li>
                                <li class="advantages__rule" aria-hidden="true"></li>
                                <li class="advantage">
          <span class="advantage__icon">
            <img src="/template/assets/icons/adv-secure.svg" alt="" width="44" height="57">
          </span>
                                    <h3 class="advantage__title">Гарантия свежести</h3>
                                    <p class="advantage__text">Свежие цветы 24/7</p>
                                </li>
                                <li class="advantages__rule" aria-hidden="true"></li>
                                <li class="advantage">
          <span class="advantage__icon">
            <img src="/template/assets/icons/adv-card.svg" alt="" width="64" height="64">
          </span>
                                    <h3 class="advantage__title">Удобная оплата</h3>
                                    <p class="advantage__text">Онлайн и наличными</p>
                                </li>
                            </ul>
                        </section>
                    @endif

                @endif
            @endforeach
        @endif





    </main>
@endsection
