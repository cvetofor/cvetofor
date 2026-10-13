@extends('newdesing.app')
@inject('catalogService', App\Services\CatalogService::class)
@php
    // «Смотрите также»: соседние доп-товары той же категории. У доп-товара нет
    // groupProduct, поэтому вместо findPricesByCategoriesId (как у букетов в
    // product.blade.php) — ветка для дополнительных товаров
    $seealso = $catalogService->findAdditPricesByCategoriesId([$category->id], 10);
@endphp
@section('css')
    {{-- Swiper — локальная копия (css/vendor), нужна только этой странице.
         Подключаем до страничных стилей, чтобы кастомизация лайтбокса
         из page-product.css перебивала дефолтные стили слайдера --}}
    <link rel="stylesheet" href="/template/css/vendor/swiper-bundle.min.css?v={{time()}}">
    <link rel="stylesheet" href="/template/css/build/page-product.css?v={{time()}}">
@endsection
@section('content')

    <main id="main">

        <!-- ================================================ Breadcrumbs ==== -->
        <nav class="breadcrumbs container" aria-label="Хлебные крошки">
            <ol class="breadcrumbs__list" itemscope itemtype="http://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <a class="breadcrumbs__link" href="/" itemprop="item">
                        <span itemprop="name">Главная</span>
                    </a>
                    <meta itemprop="position" content="1">
                </li>
                @foreach ($breadcrumbs as $i => $bread)
                    @if (!$loop->last)
                        {{-- Категории доп-товаров живут под /categories/{slug}, а не /catalog:
                             nestedSlug крошки уже содержит «categories/…», «Каталог» — пуст --}}
                        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                            <a class="breadcrumbs__link"
                               href="{{ $bread->nestedSlug ? '/' . $bread->nestedSlug : '/catalog' }}" itemprop="item">
                                <span itemprop="name">{{ $bread->title }}</span>
                            </a>
                            <meta itemprop="position" content="{{ $i + 2 }}">
                        </li>
                    @endif
                @endforeach
                <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <span itemprop="name" aria-current="page">{{ $product->title }}</span>
                    <meta itemprop="position" content="{{ count($breadcrumbs) + 1 }}">
                </li>
            </ol>
        </nav>

        <!-- =================================================== Product ==== -->
        <section class="product container" aria-labelledby="product-title">
            @php
                $images = \Cache::remember('images|' . $product->id, \now()->addMinutes(1), fn() => $product->images('preview'));
            @endphp
            @if (!isset($images[0]))
                @php
                    $images[] = '/dist/img/image-content/error404-pic.svg';
                @endphp
            @endif
            @php
                $slideCount = count($images);
            @endphp
            <!-- Без заголовка: h2 здесь шёл бы перед h1 страницы и ломал
                 порядок заголовков. Имя блока даёт aria-label. -->
            <div class="gallery" role="group" aria-label="Фотографии товара" data-gallery>
                <ul class="gallery__thumbs">
                    @foreach ($images as $key => $image)
                        <li class="gallery__thumb @if($loop->first) is-active @endif">
                            <a class="gallery__thumb-btn" href="{{ $image }}" data-gallery-item>
                                <img src="{{ $image }}" alt="{{ $product->title }}"
                                     width="154" height="154" loading="lazy">
                                <span class="visually-hidden">Показать фото {{ $loop->iteration }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>

                <div class="gallery__main">
                    @foreach ($images as $key => $image)
                        <img class="gallery__photo" data-gallery-main data-cart-photo @if(!$loop->first) hidden @endif
                             src="{{ $image }}"
                             alt="{{ $product->title }}"
                             width="618" height="664">
                    @endforeach
                    <!-- Ссылки на соседние снимки, а не кнопки: без JS клик
                         открывает фото, со скриптом — перелистывает галерею.
                         Один слайд — стрелок нет: листать нечего -->
                    @if ($slideCount > 1)
                        <a class="gallery__nav gallery__nav--prev" href="{{ $images[$slideCount - 1] }}"
                           data-gallery-step="-1" aria-label="Предыдущее фото">
                            <img src="/template/assets/icons/chevron-forward-ink.svg" alt="" width="13" height="20">
                        </a>
                        <a class="gallery__nav gallery__nav--next" href="{{ $images[1 % $slideCount] }}"
                           data-gallery-step="1" aria-label="Следующее фото">
                            <img src="/template/assets/icons/chevron-forward-ink.svg" alt="" width="13" height="20">
                        </a>
                    @endif
                    <!-- Не figcaption: это не подпись к фото, а обещание сервиса -->
                    <p class="gallery__note">
                        <img src="/template/assets/icons/adv-photo.svg" alt="" width="21" height="21">
                        Фото перед отправкой
                    </p>
                </div>
            </div>

            <div class="product__info">
                <div class="product__top">
                    @if ($priceModel->is_promo)
                        <p class="badge badge--hit badge--static">
                            <img src="/template/assets/icons/fire-minimalistic.svg" alt="" width="18" height="18">
                            Акция
                        </p>
                    @endif
                </div>
  {{111 }}
                <h1 class="product__title" id="product-title">{{ $product->title }}</h1>
                <p class="product__sku">Артикул: {{ $priceModel->sku }}</p>

                <p class="product__prices">
                    @if ($priceModel->price == null || $priceModel->price == 0 || $priceModel->published === false || !$canPutToCart)
                        <span class="product__price">Нет в наличии</span>
                    @else
                        <span class="product__price">@money(round($priceModel->public_price)) ₽</span>
                    @endif
                </p>

                <p class="product__delivery">
                    <img src="/template/assets/icons/truck.svg" alt="Доставка" width="24" height="18">
                    <span class="product__shipping">Доставка: от 0 ₽</span>
                    <span class="dot-sep" aria-hidden="true"></span>
                    <span class="delivery-term">Сегодня</span>
                </p>

                <div class="product__actions">
                    {{-- Контракт старого шаблона доп-товара: putAdditional по id цены
                         (блок №16 app.js — тост + счётчик, без перезагрузки страницы) --}}
                    <button class="btn btn--primary product__cta" type="button"
                            data-cart-additional-item-add-cat="data-cart-additional-item-add-cat"
                            data-id="{{ $priceModel->id }}">
                        <img src="/template/assets/icons/cart-white.svg" alt="" width="22" height="22">
                        В корзину
                    </button>
                    {{-- Быстрый заказ: открывает окно #quick-order из лейаута.
                         Товар уходит в заявку через data-атрибут (блок №31 app.js) --}}
                    <a class="btn btn--outline product__cta" href="#quick-order"
                       data-quick-order-product="{{ $product->title }} (арт. {{ $priceModel->sku }})">
                        <img src="/template/assets/icons/hero-fast.svg" alt="" width="18" height="22">
                        Купить в один клик
                    </a>
                </div>
            </div>
        </section>

        <!-- =============================================== Description ==== -->
        @if ($product->description)
            <section class="section container" aria-labelledby="descr-title">
                <div class="descr panel">
                    <h2 class="descr__tab" id="descr-title">Описание</h2>

                    <div class="descr__text">
                        <p>{!! $product->description !!}</p>
                    </div>
                </div>
            </section>
        @endif

        <!-- =============================================== See also ==== -->
        @if ($seealso)
            <section class="section container see-also" aria-labelledby="see-also-title">
                <div class="section__head">
                    <h2 class="section__title" id="see-also-title">Смотрите также</h2>

                    <div class="see-also__nav">
                        <button class="see-also__arrow" type="button" data-slider-prev
                                aria-label="Предыдущие товары">
                            <img src="/template/assets/icons/chevron-back.svg" alt="" width="24" height="24">
                        </button>
                        <button class="see-also__arrow" type="button" data-slider-next
                                aria-label="Следующие товары">
                            <img src="/template/assets/icons/chevron-forward.svg" alt="" width="24" height="24">
                        </button>
                    </div>
                </div>

                <ul class="products see-also__track" data-slider>
                    @foreach ($seealso as $paginator)
                        @foreach ($paginator->items() as $_price)
                            @if ($_price->sku !== $priceModel->sku)
                                @include('newdesing.parts.product_cart_catalog', ['price' => $_price, 'typeproduct' => 'product', 'cat_id' => 0])
                            @endif
                        @endforeach
                    @endforeach
                </ul>
            </section>
        @endif
    </main>

    {{-- Лайтбокс увеличенных фото: клик по большому фото галереи открывает
         полноэкранный слайдер (блок №32 в app.js). Слайды строит скрипт из
         миниатюр галереи — здесь только каркас, без JS оверлей не открывается.
         Открытие/закрытие — общий механизм оверлеев №3 (Esc, крестик #main);
         клик по тёмному фону закрывает блок №32 --}}
    <div class="overlay lightbox" id="photo-viewer">
        <div class="lightbox__panel">
            <a class="overlay__close lightbox__close" href="#main" aria-label="Закрыть просмотр фото">
                <span class="cross" aria-hidden="true"></span>
            </a>

            <div class="swiper lightbox__swiper">
                <div class="swiper-wrapper"></div>
                <div class="swiper-button-prev" aria-hidden="true"></div>
                <div class="swiper-button-next" aria-hidden="true"></div>
            </div>

            <p class="lightbox__counter swiper-pagination"></p>
        </div>
    </div>

    {{-- Локальная копия Swiper (без CDN и сборщиков). Оба скрипта defer и
         исполняются в порядке документа: этот — раньше app.js в конце body,
         так что блоку №32 глобал Swiper уже доступен --}}
    <script src="/template/js/vendor/swiper-bundle.min.js?v={{ time() }}" defer></script>

@endsection
