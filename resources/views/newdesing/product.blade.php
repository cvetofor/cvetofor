@extends('newdesing.app')
@inject('compositeProducts', \App\Services\CompositeProducts::class)
@inject('catalogService', App\Services\CatalogService::class)
@php
    $compositions = $compositeProducts->get($price);

    if (optional($groupProduct->category)->id) {
        $seealso = $catalogService->findPricesByCategoriesId([$groupProduct->category->id], 10);
    } else {
        $seealso = false;
    }

    $couponCanBeApplied = false;
    foreach ($compositions as $j => $block) {
        foreach ($block as $i => $product) {
            if ($product->prices->count() > 1 && optional($product->couponFrom)->quantity_from) {
                $couponCanBeApplied = true;
            }
        }
    }

@endphp
@push('scripts')
    <script>
        // Преобразуем PHP-массив $compositions в JSON
        const compositions = @json($compositions);
        const price = @json($price)

        // Выводим в консоль браузера

    </script>
@endpush
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
                        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                            <a class="breadcrumbs__link" href="/catalog/{{ $bread->nestedSlug }}" itemprop="item">
                                <span itemprop="name">{{ $bread->title }}</span>
                            </a>
                            <meta itemprop="position" content="{{ $i + 2 }}">
                        </li>
                    @endif
                @endforeach
                <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <span itemprop="name" aria-current="page">{{ $groupProduct->title }}</span>
                    <meta itemprop="position" content="{{ count($breadcrumbs) + 1 }}">
                </li>
            </ol>
        </nav>

        <!-- =================================================== Product ==== -->
        <section class="product container" aria-labelledby="product-title">
            @if (isset($price->groupProduct->images('cover', 'mobile')[0]))
                @php
                    $images = $price->groupProduct->images('cover', 'mobile');
                @endphp
            @else
                @php
                    $images[] = '/dist/img/image-content/error404-pic.svg';
                @endphp
            @endif
            @php
                // Слайды галереи по порядку показа: видео (если есть) + фото.
                // При видео последний снимок не выводится — его занимает постер.
                $hasVideo = (bool) $price->groupProduct->file('preview');
                $photoSlides = $hasVideo ? array_slice($images, 0, -1) : $images;
                $slideUrls = $hasVideo
                    ? array_merge([$price->groupProduct->file('preview')], $photoSlides)
                    : $photoSlides;
                $slideCount = count($slideUrls);
            @endphp
            <!-- Без заголовка: h2 здесь шёл бы перед h1 страницы и ломал
                 порядок заголовков. Имя блока даёт aria-label. -->
            <div class="gallery" role="group" aria-label="Фотографии букета" data-gallery>
                <ul class="gallery__thumbs">
                    @if ($price->groupProduct->file('preview'))
                   <li class="gallery__thumb is-active">
                        <a class="gallery__thumb-btn" href="{{ $price->groupProduct->file('preview') }}" data-gallery-item
                           data-gallery-video aria-current="true">
                            <img src="{{ Arr::first($images) }}" alt="Видео: букет Luxury peony"
                                 width="154" height="154">
                            <span class="gallery__play" aria-hidden="true"><img src="/template/assets/icons/play.svg"
                                                                                alt="" width="52" height="52"></span>
                            <span class="visually-hidden">Показать видео</span>
                        </a>
                    </li>@endif
                    @foreach ($images as $key => $image)
                        @if (!$loop->last || !$price->groupProduct->file('preview'))
                    <li class="gallery__thumb @if($loop->first && !$hasVideo) is-active @endif" >
                        <a class="gallery__thumb-btn" href="{{$image}}"
                           data-gallery-item>
                            <img src="{{$image}}" alt="{{$price->title}}"
                                 width="154" height="154" loading="lazy">
                            <span class="visually-hidden">Показать фото {{ $loop->iteration }}</span>
                        </a>
                    </li>

                        @endif
                    @endforeach

                </ul>

                <div class="gallery__main">
                    <!-- Видео стоит первым и играет сразу — так просил дизайнер.
                         Звук выключен: с ним браузер автовоспроизведение запретит.
                         Нет видео у товара — нет и этого блока, фото займёт место. -->
                    @if ($price->groupProduct->file('preview')) <video class="gallery__video" data-gallery-player
                           poster="{{ Arr::first($images) }}" width="618" height="664"
                           controls autoplay muted playsinline preload="metadata">
                        <source src="{{ $price->groupProduct->file('preview') }}" type="video/mp4">
                        <a class="gallery__fallback" href="{{ $price->groupProduct->file('preview') }}">Скачать видео</a>
                    </video>
                    @endif
                    @foreach ($images as $key => $image)
                        @if (!$loop->last || !$price->groupProduct->file('preview'))
                    <img class="gallery__photo" data-gallery-main data-cart-photo @if(!$loop->first || $hasVideo) hidden @endif
                         src="{{$image}}"
                         alt="{{$price->title}}"
                         width="618" height="664">@endif
                    @endforeach
                    <!-- Ссылки на соседние снимки, а не кнопки: в макете (122:735)
                         стрелки видны всегда, поэтому прятать их до появления JS
                         нельзя. Без скрипта клик открывает фото, со скриптом —
                         перелистывает галерею. Соседи считаются с заворотом, как
                         в show() app.js. Один слайд — стрелок нет: листать нечего.
                         Стрелка — картинкой: маска на псевдоэлементе один раз
                         уже не нарисовалась. -->
                    @if ($slideCount > 1)
                    <a class="gallery__nav gallery__nav--prev" href="{{ $slideUrls[$slideCount - 1] }}"
                       data-gallery-step="-1" aria-label="Предыдущее фото">
                        <img src="/template/assets/icons/chevron-forward-ink.svg" alt="" width="13" height="20">
                    </a>
                    <a class="gallery__nav gallery__nav--next" href="{{ $slideUrls[1 % $slideCount] }}"
                       data-gallery-step="1" aria-label="Следующее фото">
                        <img src="/template/assets/icons/chevron-forward-ink.svg" alt="" width="13" height="20">
                    </a>
                    @endif
                    <!-- Не figcaption: это не подпись к фото, а обещание сервиса -->
                   {{-- <p class="gallery__note">
                        <img src="/template/assets/icons/adv-photo.svg" alt="" width="21" height="21">
                        Фото перед отправкой
                    </p>--}}
                </div>
            </div>

            <div class="product__info">
                <div class="product__top">
                    @if ($price->is_promo)
                        <p class="badge badge--hit badge--static">
                            <img src="/template/assets/icons/fire-minimalistic.svg" alt="" width="18" height="18">
                            Хит продаж
                        </p>
                    @endif
                    {{--<div class="product__tools">
                        <form class="product__fav" data-fav action="/favorites/toggle" method="post">
                            <input type="hidden" name="product" value="luxury-peony">
                            <button class="product__tool" type="submit" aria-pressed="false"
                                    aria-label="Добавить «Букет «Luxury peony»» в избранное">
                                <img src="/template/assets/icons/heart-brand-30.svg" alt="" width="30" height="30">
                            </button>
                        </form>
                        <button class="product__tool" type="button" aria-label="Поделиться">
                            <img src="/template/assets/icons/share-2.svg" alt="" width="30" height="30">
                        </button>
                    </div>--}}
                </div>

                <h1 class="product__title" id="product-title">{{ $groupProduct->title }}</h1>
                <p class="product__sku">Артикул: {{ $price->sku }}</p>

                <p class="product__prices">
                    @if ($price->price == null || $price->price == 0 || $price->published === false || !$canPutToCart)
                        <span class="product__price">Нет в наличии</span>
                    @else
                        <span class="product__price">@money(round($price->public_price)) ₽</span>

                        @if($price->old_price)
                            <s class="product__price-old"><span class="visually-hidden">Старая цена: </span>16 456 ₽</s>
                        @endif

                    @endif

                </p>

                <p class="product__delivery">
                    <img src="/template/assets/icons/truck.svg" alt="Доставка" width="24" height="18">
                    <span class="product__shipping">Доставка: от 0 ₽</span>
                    <span class="dot-sep" aria-hidden="true"></span>
                    <span class="delivery-term">Сегодня</span>
                </p>


{{--         <button class="btn btn--primary card__buy add-product-to-cart-button desktop-cart-btn" type="button"

                        data-put-cart-sku="{{ $price->sku }}">В корзину</button>       /--}}
                <div class="product__actions">
                    <form class="product__form"   method="post">
                        <input type="hidden" name="product" value="luxury-peony">
                        <button class="btn btn--primary product__cta" type="button" data-put-cart-sku="{{ $price->sku }}">
                            <img src="/template/assets/icons/cart-white.svg" alt="" width="22" height="22" >
                            Добавить в корзину
                        </button>
                    </form>
                    {{-- Быстрый заказ: открывает окно #quick-order из лейаута.
                         Товар уходит в заявку через data-атрибут — роута
                         /order/quick на бэкенде нет, отправка идёт на form --}}
                    <a class="btn btn--outline product__cta" href="#quick-order"
                       data-quick-order-product="{{ $groupProduct->title }} (арт. {{ $price->sku }})">
                        <img src="/template/assets/icons/hero-fast.svg" alt="" width="18" height="22">
                        Купить в один клик
                    </a>
                </div>

                <div class="gift">
                    <img class="gift__icon" src="/template/assets/icons/gift.svg" alt="" width="42" height="42">
                    <span class="gift__text">
            <span class="gift__title">Особенный подарок</span>
            <span class="gift__note">Открытка с вашим текстом — бесплатно к заказу</span>
          </span>
                </div>

                @php
                    // Псевдослучайный счётчик «заказали N раз»: seed = id + дата,
                    // поэтому число одно на сутки для всех пользователей и меняется в полночь
                    $boughtDate = \App\Services\CitiesService::DateTime()->format('Y-m-d');
                    $boughtCount = 10 + (abs(crc32($groupProduct->id . '|' . $boughtDate)) % 41);
                    $boughtMod10 = $boughtCount % 10;
                    $boughtMod100 = $boughtCount % 100;
                    $boughtWord = (($boughtMod100 >= 11 && $boughtMod100 <= 14) || in_array($boughtMod10, [0, 1, 5, 6, 7, 8, 9]))
                        ? 'раз'
                        : 'раза';
                @endphp
                <p class="product__proof">
                    За последние 24 часа <span class="product__proof-accent">этот букет заказали</span>
                </p>
                <p class="proof-pill">
                    <img src="/template/assets/icons/proof-bouquet.svg" alt="" width="32" height="32">
                    <span class="proof-pill__count">{{ $boughtCount }} {{ $boughtWord }}</span>
                </p>
            </div>
        </section>

        <!-- =============================================== Description ==== -->
        <section class="section container" aria-labelledby="descr-title">
            <div class="descr panel">
                <h2 class="descr__tab" id="descr-title">Описание</h2>

                <div class="descr__text">
                    <p> {!! $groupProduct->description ??''!!}<br></p>
                    @if($seoText)
                        <p> {!! $seoText !!}<br></p>
                    @endif
                </div>

                {{-- <div class="descr__specs">
                     <div class="spec spec--parts">
                         <h3 class="spec__title">Состав букета</h3>
                         <dl class="spec__list">
                             <div class="spec__row">
                                 <dt>Пионы премиальные</dt>
                                 <dd class="spec__value">13 шт.</dd>
                             </div>
                             <div class="spec__row">
                                 <dt>Упаковка</dt>
                                 <dd class="spec__value">2 шт.</dd>
                             </div>
                             <div class="spec__row">
                                 <dt>Открытка</dt>
                                 <dd class="spec__value">Бесплатно</dd>
                             </div>
                         </dl>
                     </div>

                     <div class="spec spec--country">
                         <h3 class="spec__title">Страна производства</h3>
                         <p class="spec__plain">Голландия</p>
                     </div>--}}


                <div class="spec spec--size" style="margin-top: 15px">
                    <h3 class="spec__title">Состав букета</h3>
                    <dl class="spec__list" >
                        @if ($groupProduct->isMono())
                            @foreach ($compositions as $j => $block)
                                @foreach ($block as $i => $product)
                                    @if ($product && $product->color)

                                        <div class="spec__row">
                                            <dt> {{ $product->color->title }}
                                            </dt>
                                            <dd>{{ $product->count }} шт.</dd>
                                        </div>
                                    @elseif($product)
                                        <div class="spec__row">
                                            <dt> {{ $product->title }}
                                            </dt>
                                            <dd>{{ $product->count }} шт.</dd>
                                        </div>
                                    @endif
                                @endforeach
                            @endforeach
                        @else
                            @foreach ($compositions as $j => $block)
                                @foreach ($block as $i => $product)
                                    <div class="spec__row">
                                        <dt> {{ $product->title }}
                                        </dt>
                                        <dd>{{ $product->count }} шт.</dd>
                                    </div>

                                @endforeach
                            @endforeach
                        @endif

                    </dl>
                </div>
            </div>
            </div>
        </section>

        <!-- ================================================= Occasions ==== -->
        <section class="section container" aria-labelledby="occ-title">
            <h2 class="visually-hidden" id="occ-title">Подходящие поводы</h2>
            <ul class="occasions panel">
                <li class="occasion">
                    <span class="occasion__icon"><img src="/template/assets/icons/heart-occasion.svg" alt="" width="45"
                                                      height="40"></span>
                    <span class="occasion__name">Любимой девушке</span>
                </li>
                <li class="occasion">
                    <span class="occasion__icon"><img src="/template/assets/icons/cake.svg" alt="" width="40"
                                                      height="40"></span>
                    <span class="occasion__name">День рождения</span>
                </li>
                <li class="occasion">
                    <span class="occasion__icon"><img src="/template/assets/icons/ring-diamond.svg" alt="" width="30"
                                                      height="40"></span>
                    <span class="occasion__name">Предложение</span>
                </li>
                <li class="occasion">
                    <span class="occasion__icon"><img src="/template/assets/icons/medal-ribbon-star.svg" alt=""
                                                      width="30" height="40"></span>
                    <span class="occasion__name">Юбилей</span>
                </li>
            </ul>
        </section>

  {{--      <!-- ==================================================== Addons ==== -->
        <section class="section container" aria-labelledby="addons-title">
            <div class="section__head section__head--stacked">
                <h2 class="section__title" id="addons-title">Так же может понравиться</h2>
                <p class="section__sub">Подберите дополнение к букету</p>
            </div>

            <ul class="addons">
                <li>
                    <article class="addon">
              <span class="addon__media">
                <img src="/template/assets/img/addon-sweets.jpg" alt="" width="150" height="106" loading="lazy">
              </span>
                        <h3 class="addon__title"><a class="addon__link" href="/product/sweets">Сладкий подарок «Детские
                                мечты»</a></h3>
                        <p class="addon__price">4 428 ₽</p>
                        <form class="addon__form" data-cart-add action="/cart/add" method="post">
                            <input type="hidden" name="product" value="sweets">
                            <button class="addon__add" type="submit"
                                    aria-label="Добавить «Сладкий подарок «Детские мечты»» к заказу">
                                <img src="/template/assets/icons/plus-large.svg" alt="" width="19" height="19">
                            </button>
                        </form>
                    </article>
                </li>
                <li>
                    <article class="addon">
              <span class="addon__media">
                <img src="/template/assets/img/addon-vase.jpg" alt="" width="150" height="106" loading="lazy">
              </span>
                        <h3 class="addon__title"><a class="addon__link" href="/product/vase">Ваза «Градиент» (стекло)
                                D11,5×H19,5 см</a></h3>
                        <p class="addon__price">418 ₽</p>
                        <form class="addon__form" data-cart-add action="/cart/add" method="post">
                            <input type="hidden" name="product" value="vase">
                            <button class="addon__add" type="submit"
                                    aria-label="Добавить «Ваза «Градиент» (стекло) D11,5×H19,5 см» к заказу">
                                <img src="/template/assets/icons/plus-large.svg" alt="" width="19" height="19">
                            </button>
                        </form>
                    </article>
                </li>
                <li>
                    <article class="addon">
              <span class="addon__media">
                <img src="/template/assets/img/addon-candy.jpg" alt="" width="150" height="106" loading="lazy">
              </span>
                        <h3 class="addon__title"><a class="addon__link" href="/product/candy">Конфеты «Рафаэлло» 150
                                г</a></h3>
                        <p class="addon__price">790 ₽</p>
                        <form class="addon__form" data-cart-add action="/cart/add" method="post">
                            <input type="hidden" name="product" value="candy">
                            <button class="addon__add" type="submit"
                                    aria-label="Добавить «Конфеты «Рафаэлло» 150 г» к заказу">
                                <img src="/template/assets/icons/plus-large.svg" alt="" width="19" height="19">
                            </button>
                        </form>
                    </article>
                </li>
                <li>
                    <article class="addon">
              <span class="addon__media">
                <img src="/template/assets/img/addon-sweets.jpg" alt="" width="150" height="106" loading="lazy">
              </span>
                        <h3 class="addon__title"><a class="addon__link" href="/product/sweets">Сладкий подарок «Детские
                                мечты»</a></h3>
                        <p class="addon__price">4 428 ₽</p>
                        <form class="addon__form" data-cart-add action="/cart/add" method="post">
                            <input type="hidden" name="product" value="sweets">
                            <button class="addon__add" type="submit"
                                    aria-label="Добавить «Сладкий подарок «Детские мечты»» к заказу">
                                <img src="/template/assets/icons/plus-large.svg" alt="" Dwidth="19" height="19">
                            </button>
                        </form>
                    </article>
                </li>
                <li>
                    <article class="addon">
              <span class="addon__media">
                <img src="/template/assets/img/addon-vase.jpg" alt="" width="150" height="106" loading="lazy">
              </span>
                        <h3 class="addon__title"><a class="addon__link" href="/product/vase">Ваза «Градиент» (стекло)
                                D11,5×H19,5 см</a></h3>
                        <p class="addon__price">418 ₽</p>
                        <form class="addon__form" data-cart-add action="/cart/add" method="post">
                            <input type="hidden" name="product" value="vase">
                            <button class="addon__add" type="submit"
                                    aria-label="Добавить «Ваза «Градиент» (стекло) D11,5×H19,5 см» к заказу">
                                <img src="/template/assets/icons/plus-large.svg" alt="" width="19" height="19">
                            </button>
                        </form>
                    </article>
                </li>
                <li>
                    <article class="addon">
              <span class="addon__media">
                <img src="/template/assets/img/addon-candy.jpg" alt="" width="150" height="106" loading="lazy">
              </span>
                        <h3 class="addon__title"><a class="addon__link" href="/product/candy">Конфеты «Рафаэлло» 150
                                г</a></h3>
                        <p class="addon__price">790 ₽</p>
                        <form class="addon__form" data-cart-add action="/cart/add" method="post">
                            <input type="hidden" name="product" value="candy">
                            <button class="addon__add" type="submit"
                                    aria-label="Добавить «Конфеты «Рафаэлло» 150 г» к заказу">
                                <img src="/template/assets/icons/plus-large.svg" alt="" width="19" height="19">
                            </button>
                        </form>
                    </article>
                </li>
            </ul>
        </section>--}}
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
                        @if ($_price->sku !== $price->sku)
                           @include('newdesing.parts.product_cart_catalog', ['price' => $_price,'typeproduct'=>'groupProduct','cat_id'=>0])
                        @endif
                    @endforeach
                @endforeach


            </ul>
        </section>
        @endif
    </main>

    {{-- Микроразметка товара: JSON-LD Product, перенос из старого дизайна
         (product.blade.php). Лейаут newdesing не имеет @stack('scripts'),
         поэтому скрипт живёт прямо в контенте — JSON-LD валиден в body --}}
    @php
        try {
            $compositionText = [];

            foreach ($compositions as $block) {
                foreach ($block as $product) {
                    if (!$product) continue;

                    if (isset($product->color) && $product->color) {
                        $compositionText[] = $product->color->title . ' — ' . $product->count . ' шт.';
                    } else {
                        $compositionText[] = $product->title . ' — ' . $product->count . ' шт.';
                    }
                }
            }

            $isInStock = !(
                $price->price == null ||
                $price->price == 0 ||
                $price->published === false ||
                !$canPutToCart
            );

            $galleryImages = isset($groupProduct->images('cover', 'mobile')[0])
                ? $groupProduct->images('cover', 'mobile')
                : [url('/dist/img/image-content/error404-pic.svg')];

            $schema = [
                '@context' => 'https://schema.org/',
                '@type' => 'Product',
                'name' => $groupProduct->title,
                'image' => array_map(function ($image) {
                    return str_starts_with($image, 'http') ? $image : url($image);
                }, $galleryImages),
                'description' => 'Состав букета: ' . implode(', ', $compositionText),
                'sku' => $price->sku ?? $groupProduct->id,
                'brand' => [
                    '@type' => 'Brand',
                    'name' => 'Цветофор.рф',
                ],
                'offers' => [
                    '@type' => 'Offer',
                    'priceCurrency' => 'RUB',
                    'price' => number_format((float) ($price->price ?? 0), 2, '.', ''),
                    'availability' => 'https://schema.org/' . ($isInStock ? 'InStock' : 'OutOfStock'),
                    'url' => url()->current(),
                ],
            ];
        } catch (\Exception $r) {
            $schema = '';
        }
    @endphp
    <script type="application/ld+json">
        {!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>

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
