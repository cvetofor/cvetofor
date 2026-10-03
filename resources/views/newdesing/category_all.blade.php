@extends('newdesing.app')
@inject('citiesService', \App\Services\CitiesService::class)
@inject('catalogService', App\Services\CatalogService::class)
@php
    // Разделы страницы — те же источники, что у разделов каталога в шторке
    // меню (app.blade.php) и старой модалки «Каталог». «По цене»
    // ($menuPrices), «По цветам» ($menuFlovers) и «Повод / кому»
    // ($groupProductTags) — глобальные шары AppServiceProvider
    $menuCategories = $catalogService->getPublishedCategories();
    $menuAdditionalCategories = \App\Models\Category::published()
        ->where('is_additional_product', 1)
        ->where('is_visible_catalog', 1)
        ->get();
@endphp

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
                    <a class="btn btn--hero-outline" href="#quick-order">
                        <img src="/template/assets/icons/hero-fast.svg" alt="" width="18" height="22">
                        Быстрый заказ
                    </a>
                </div>
            </div>
        </section>

        {{-- Все разделы каталога на одной странице — как в шторке меню и
             старой десктопной модалке «Каталог»: порядок и ссылки те же,
             различается только подача («По цветам» — плитки, остальное —
             текстовые ссылки колонками). Разметка инлайн: страница одна,
             переиспользования нет. Пустые разделы не показываем —
             заголовок без списка выглядел бы сломанным --}}
        @if (count($menuPrices))
            <section class="section container">
                <div class="section__head">
                    <h2 class="section__title">По цене</h2>
                </div>
                <ul class="cat-links">
                    @foreach ($menuPrices as $menuPrice)
                        @if ($menuPrice->price_start == 0)
                            <li>
                                <a class="cat-links__link"
                                   href="{{ route('catalog.index') }}?price[to]={{ $menuPrice->price_end }}">до {{ $menuPrice->price_end }}</a>
                            </li>
                        @elseif ($menuPrice->price_end == 0)
                            <li>
                                <a class="cat-links__link"
                                   href="{{ route('catalog.index') }}?price[from]={{ $menuPrice->price_start }}">от {{ $menuPrice->price_start }}</a>
                            </li>
                        @else
                            <li>
                                <a class="cat-links__link"
                                   href="{{ route('catalog.index') }}?price[from]={{ $menuPrice->price_start }}&price[to]={{ $menuPrice->price_end }}">{{ $menuPrice->price_start }} — {{ $menuPrice->price_end }}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </section>
        @endif

        {{-- Плитки цветов — общий партиал с главной; $title переопределяет
             заголовок, чтобы не конфликтовать с секцией «По категориям» --}}
        @include('newdesing.parts.short_cats', ['not_short' => 1, 'title' => 'По цветам'])

        <section class="section container">
            <div class="section__head">
                <h2 class="section__title">По категориям</h2>
            </div>
            <ul class="cat-links">
                <li>
                    <a class="cat-links__link" href="{{ route('catalog.index') }}">{{ __('Все букеты') }}</a>
                </li>
                @foreach ($menuCategories as $category)
                    <li>
                        <a class="cat-links__link"
                           href="{{ route('catalog.category', ['slug' => $category->nestedSlug]) }}">{{ $category->title }}</a>
                    </li>
                @endforeach
            </ul>
        </section>

        @if ($groupProductTags)
            <section class="section container">
                <div class="section__head">
                    <h2 class="section__title">Повод / кому</h2>
                </div>
                <ul class="cat-links">
                    @foreach ($groupProductTags as $tag)
                        <li>
                            <a class="cat-links__link"
                               href="{{ route('catalog.tags', ['tag' => $tag['slug']]) }}">{{ $tag['name'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif

        @if (count($menuAdditionalCategories))
            <section class="section container">
                <div class="section__head">
                    <h2 class="section__title">Дополнительные товары</h2>
                </div>
                <ul class="cat-links">
                    @foreach ($menuAdditionalCategories as $category)
                        @php
                            $categorySlug = \App\Models\Slugs\CategorySlug::where('category_id', $category->id)
                                ->where('locale', 'ru')
                                ->where('active', true)
                                ->first();
                        @endphp
                        <li>
                            @if ($categorySlug)
                                <a class="cat-links__link"
                                   href="{{ route('catalog.additional', ['slug' => $categorySlug->slug]) }}">{{ $category->title }}</a>
                            @else
                                <span class="cat-links__link">{{ $category->title }}</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif

    </main>
@endsection
