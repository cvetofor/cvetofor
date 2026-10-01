@extends('newdesing.app')
@inject('citiesService', \App\Services\CitiesService::class)

@section('css')
    {{-- Стили страницы: крошки внутри баннера (в page-product.css они только у
         страницы товара) и модификатор hero--cover. Общий style.css не трогаем --}}
    <link rel="stylesheet" href="/template/css/build/page-additional-category.css?v={{time()}}">
@endsection

@section('content')
    <main id="main">

        <!-- ====================================================== Hero ==== -->
        {{-- Баннер категории: обложка занимает весь баннер (модификатор
             hero--cover, стили — в page-additional-category.css). Без обложки —
             стандартная заглушка hero-bg.jpg и обычная композиция hero. Цветочный
             текст hero из category.blade.php не переносим — на странице
             ваз/сладостей он лгал бы --}}
        @php
            $heroCover = $category->image('cover');
        @endphp
        <section class="hero container {{ $heroCover ? 'hero--cover' : '' }}">
            <img class="hero__bg" src="{{ $heroCover ?: '/template/assets/img/hero-bg.jpg' }}" alt="" width="1110" height="460">
            <img class="hero__blob" src="/template/assets/icons/hero-ellipse.svg" alt="" aria-hidden="true"
                 width="637" height="610">

            <div class="hero__content">
                {{-- Крошки остаются в баннере (над заголовком) — вид как на странице
                     товара, стили в page-additional-category.css. Категории доп-товаров
                     живут под /categories/{slug}: nestedSlug крошек здесь пуст у всех,
                     кроме собранного вручную пути --}}
                <nav class="breadcrumbs" aria-label="Хлебные крошки">
                    <ol class="breadcrumbs__list">
                        <li><a class="breadcrumbs__link" href="/">Главная</a></li>
                        @foreach ($breadcrumbs as $bread)
                            @if (!$loop->last)
                                <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a
                                        class="breadcrumbs__link" href="{{ $bread->nestedSlug ? '/' . $bread->nestedSlug : '/catalog' }}"
                                        itemprop="item" itemprop="name">{{ $bread->title }}</a></li>
                            @endif
                        @endforeach
                        <li><span aria-current="page">{{ $category->title }}</span></li>
                    </ol>
                </nav>

                <h1 class="hero__title">{{ $category->title }}</h1>

                <div class="hero__actions">
                    <a class="btn btn--hero" href="/catalog">
                        <img src="/template/assets/icons/hero-catalog.svg" alt="" width="22" height="22">
                        Каталог букетов
                    </a>
                    <a class="btn btn--hero-outline" href="#quick-order">
                        <img src="/template/assets/icons/hero-fast.svg" alt="" width="18" height="22">
                        Быстрый заказ
                    </a>
                </div>
            </div>
        </section>

        <!-- =================================================== Filters ==== -->
        {{-- Фильтр общий с category. У additionalCategory нет ajax-ветки, поэтому
             списку ниже сознательно НЕ дан id="products": блок №7 app.js не
             находит цель и не перехватывает форму — она уходит нативным GET,
             а priceFilter()/orderByPrice()/order.title читают параметры сами.
             Селект сортировки #sort работает редиректом (общий обработчик) --}}
        @include('newdesing.parts.filter')

        <!-- ================================================== Products ==== -->
        <section class="section container" aria-label="Товары категории">
            <ul class="products" data-category-items="category_{{ $category->id }}">
                @php
                    // Дешёвая опубликованная цена товара на рынке города — тот же
                    // запрос, что делал старый additional_prod_item
                    $activeMarket = $citiesService->getCity()->markets()->published()->first();
                @endphp
                @foreach ($products as $product)
                    @php
                        $price = $product->prices()->published()
                            ->where('market_id', $activeMarket->id)
                            ->where('price', '<>', null)
                            ->where('price', '<>', 0)
                            ->orderBy('quantity_from', 'ASC')
                            ->orderBy('price', 'ASC')
                            ->first();
                    @endphp
                    @if ($price)
                        @include('newdesing.parts.product_cart_catalog', ['price' => $price, 'typeproduct' => 'product', 'cat_id' => $category->id])
                    @endif
                @endforeach
            </ul>
        </section>

        {{-- Описание категории: старая .text-page.category_description в новом
             дизайне оформляется блоком .seo-text (как на главной) --}}
        @if ($category->description)
            <section class="section container">
                <div class="seo-text">{!! $category->description !!}</div>
            </section>
        @endif
    </main>
@endsection
