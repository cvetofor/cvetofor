@inject('citiesService', \App\Services\CitiesService::class)
@php
    session()->forget('order_delivery_radius_km');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {!! SEO::generate() !!}
    <meta name="description" content="Свежие букеты от 1490 ₽ с доставкой по Улан-Удэ за 2 часа. Фото букета перед отправкой, гарантия свежести, удобная оплата.">
    <link type="image/png" href="/dist/favicon/favicon-32x32.png" rel="icon" sizes="32x32" />
    <link type="image/png" href="/dist/favicon/favicon-16x16.png" rel="icon" sizes="16x16" />
    <link type="image/svg+xml" href="/dist/favicon.svg" rel="shortcut icon" />
    <link href="/dist/favicon/site.webmanifest" rel="manifest" />
    <link href="/dist/favicon/safari-pinned-tab.svg" rel="mask-icon" color="#81B3D3" />
    <link rel="canonical" href="https://xn--b1ag1aakjpl.xn--p1ai/" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-title" content="Template" />
    <meta name="application-name" content="Template" />
    <meta name="msapplication-TileColor" content="#81B3D3" />
    <meta name="theme-color" content="#ffffff" />
    <meta name="description" content="Доставка цветов в Улан-Удэ заказать букет недорого по цене магазина Цветофор">


    <meta property="og:type" content="website">
    <meta property="og:title" content="Цветофор.рф">
    <meta property="og:description"
          content="Доставка цветов в Улан-Удэ заказать букет недорого по цене магазина Цветофор">
    <meta property="og:url" content="https://xn--b1ag1aakjpl.xn--p1ai/">
    <meta property="og:locale" content="ru_RU">
    <meta property="og:image" content="/dist/img/image/logo.svg">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="/template/assets/icons/logo-mark.svg" type="image/svg+xml">
    <link rel="preload" as="image" href="/template/assets/img/hero-bg.jpg">
    <link rel="preload" as="font" type="font/woff2" href="/template/assets/fonts/hn-400.woff2" crossorigin>
    <link rel="preload" as="font" type="font/woff2" href="/template/assets/fonts/hn-500.woff2" crossorigin>

    <!-- Подключается сборка из css/build: там вместо var(--token) стоят
         конкретные пиксели и цвета, чтобы вёрстку можно было сверять
         с макетом напрямую. Исходники с токенами — в css/, сборка
         обновляется командой python tools/build_css.py -->
    <link rel="stylesheet" href="/template/css/build/fonts.css?v=20260918">
    <link rel="stylesheet" href="/template/css/build/reset.css?v=20260918">
    <link rel="stylesheet" href="/template/css/build/style.css?v=20260918">
   @yield('css')



    <script src="https://pay.yandex.ru/sdk/v1/pay.js"   async></script>


    {!! TwillAppSettings::get('help-page.help.js') !!}
</head>

<body>
<a class="skip-link" href="#main">Перейти к основному содержимому</a>

<!-- ====================================================== Header ==== -->
<header class="header">
    <div class="container header__inner">

        <a class="icon-btn burger" href="#menu" aria-label="Открыть меню">
            <span class="burger__bars" aria-hidden="true"></span>
        </a>
        @if (request()->is('/'))

                <img class="logo__mark" src="/template/assets/icons/logo-mark.svg" alt="" width="56" height="56">
                <img class="logo__word" src="/template/assets/icons/logo-word.svg" alt="Цветофор" width="95" height="16">


        @else
            <a class="logo" href="/" aria-label="Цветофор — на главную">
                <img class="logo__mark" src="/template/assets/icons/logo-mark.svg" alt="" width="56" height="56">
                <img class="logo__word" src="/template/assets/icons/logo-word.svg" alt="Цветофор" width="95" height="16">
            </a>

        @endif



        <a class="city" href="#city-picker">
            <img class="city__icon" src="/template/assets/icons/pin.svg" alt="" width="15" height="20">
            <span class="city__name">{{ $citiesService::getCity()->city }}</span>
            <span class="visually-hidden">— выбрать другой город</span>
        </a>

        <nav class="nav" aria-label="Основная навигация">
            <ul class="nav__list">
                <li><a class="nav__link" href="/catalog">Каталог</a></li>
                <li><a class="nav__link" href="/payments">Доставка и оплата</a></li>
                <li><a class="nav__link" href="/about">О нас</a></li>
                <li><a class="nav__link" href="/contacts">Контакты</a></li>
            </ul>
        </nav>

        <a class="header__phone" href="tel:+78007009375">
            <img src="/template/assets/icons/phone.svg" alt="" width="19" height="19">
            <span>8 (800) 700-93-75</span>
        </a>

        <div class="header__actions">
            <a class="icon-btn header__search" href="/search" aria-label="Поиск по каталогу">
                <img src="/template/assets/icons/search.svg" alt="" width="28" height="28">
            </a>
            <a class="icon-btn" href="/account" aria-label="Личный кабинет">
                <img src="/template/assets/icons/user.svg" alt="" width="26" height="26">
            </a>
            <a class="icon-btn header__cart" href="/cart" aria-label="Корзина, {{ \Cart::getTotalQuantity() }}">
                <img src="/template/assets/icons/cart.svg" alt="" width="32" height="32">
                <span class="icon-btn__counter" aria-hidden="true">{{ \Cart::getTotalQuantity() }}</span>
            </a>
        </div>

    </div>
</header>

<aside class="app-strip">
    <div class="container app-strip__inner">
        <button class="app-strip__close" type="button" hidden
                data-dismiss=".app-strip" aria-label="Скрыть предложение">
            <span class="cross" aria-hidden="true"></span>
        </button>

        <img class="app-strip__icon" src="/template/assets/icons/logo-mark.svg" alt="" width="40" height="40">

        <p class="app-strip__text">
            <span class="app-strip__label">Установите приложение</span>
            <img class="app-strip__word" src="/template/assets/icons/logo-word.svg" alt="Цветофор" width="72" height="12">
        </p>

        <a class="btn btn--install" href="/app">Установить</a>
    </div>
</aside>
@yield('content')


<!-- ====================================================== Footer ==== -->
<footer class="footer" id="contacts">
    <div class="container">

        <div class="footer__top">

            <div class="footer__brand">
                <img class="footer__logo" src="/template/assets/icons/footer-logo.svg" alt="Цветофор" width="168" height="60">
                <p class="footer__tagline">Доставка свежих цветов по Улан-Удэ и Бурятии</p>
            </div>

            <nav class="footer__col" aria-labelledby="f-info">
                <h2 class="footer__title" id="f-info">Информация</h2>
                <ul class="footer__list">
                    <li><a class="footer__link" href="/payments">Оплата и доставка</a></li>
                    <li><a class="footer__link" href="/about">О нас</a></li>
                    <li><a class="footer__link" href="/reviews">Отзывы</a></li>
                    <li><a class="footer__link" href="/guarantee">Гарантия свежести</a></li>
                    <li><a class="footer__link" href="/contacts">Контакты</a></li>
                </ul>
            </nav>

            <nav class="footer__col" aria-labelledby="f-clients">
                <h2 class="footer__title" id="f-clients">Клиентам</h2>
                <ul class="footer__list">
                    <li><a class="footer__link" href="/b2b">Корпоративным клиентам</a></li>
                    <li><a class="footer__link" href="/partners">Партнёрская программа</a></li>
                    <li><a class="footer__link" href="/faq">Частые вопросы</a></li>
                    <li><a class="footer__link" href="/returns">Возврат и обмен</a></li>
                </ul>
            </nav>

            <section class="footer__col" aria-labelledby="f-contacts">
                <h2 class="footer__title" id="f-contacts">Контакты</h2>
                <address class="footer__contacts">
                    <p class="contact">
                        <img src="/template/assets/icons/c-phone.svg" alt="Телефон" width="20" height="20">
                        <a class="footer__link" href="tel:+78007009375">8 (800) 700-93-75</a>
                    </p>
                    <p class="contact">
                        <img src="/template/assets/icons/c-mail.svg" alt="Почта" width="22" height="20">
                        <a class="footer__link" href="mailto:info@cvetofor.ru">info@cvetofor.ru</a>
                    </p>
                    <p class="contact">
                        <img src="/template/assets/icons/c-pin.svg" alt="Адрес" width="20" height="20">
                        <span class="footer__muted">г. Улан-Удэ,<br>ул. Геологическая 11А</span>
                    </p>
                    <p class="contact">
                        <img src="/template/assets/icons/c-clock.svg" alt="Часы работы" width="20" height="20">
                        <span class="footer__muted">Ежедневно с 08:00 до 22:00</span>
                    </p>
                </address>
            </section>

        </div>

        <div class="footer__bottom">
            <p class="footer__copy"><small>© 2026 Цветофор. Все права защищены</small></p>
            <p><a class="footer__link" href="/terms">Правила ресурсов</a></p>
            <p><a class="footer__link" href="/privacy">Политика конфиденциальности</a></p>
        </div>

    </div>
</footer>

<!-- ================================================== Оверлеи ==== -->
<!-- Открываются по :target, то есть обычной ссылкой и без JS. Скрипт
     добавляет закрытие по Esc, по клику мимо панели и возврат фокуса. -->

<div class="overlay" id="menu">
    <nav class="overlay__panel drawer" aria-label="Меню">
        <div class="drawer__top">
            <a class="logo" href="index.html" aria-label="Цветофор — на главную">
                <img class="logo__mark" src="/template/assets/icons/logo-mark.svg" alt="" width="56" height="56">
                <img class="logo__word" src="/template/assets/icons/logo-word.svg" alt="Цветофор" width="95" height="16">
            </a>
            <a class="overlay__close" href="#main" aria-label="Закрыть меню">
                <span class="cross" aria-hidden="true"></span>
            </a>
        </div>

        <form class="field-wrap drawer__search" action="/search" method="get" role="search">
            <label class="visually-hidden" for="menu-q">Поиск по каталогу</label>
            <input class="field-wrap__input" id="menu-q" name="q" type="search" placeholder="Поиск">
            <button class="drawer__find" type="submit" aria-label="Найти">
                <img src="/template/assets/icons/search.svg" alt="" width="16" height="16">
            </button>
        </form>

        <ul class="menu">
            <li class="menu__item">
                <a class="menu__link" href="#city-picker">
                    Город
                    <span class="menu__value">{{ $citiesService::getCity()->city }}</span>
                    <span class="chevron" aria-hidden="true"></span>
                </a>
            </li>
            <li class="menu__item"><a class="menu__link" href="/catalog">Каталог</a></li>
            <li class="menu__item"><a class="menu__link" href="/payments">Доставка и оплата</a></li>
            <li class="menu__item"><a class="menu__link" href="/about">О нас</a></li>
            <li class="menu__item"><a class="menu__link" href="/contacts">Контакты</a></li>
        </ul>

        <div class="drawer__foot">
            <p class="drawer__row">
                <img src="/template/assets/icons/c-phone.svg" alt="" width="20" height="20">
                <a href="tel:{{ str_replace([' ', '(', ')', '-'], ['', '', '', ''], TwillAppSettings::get('public.public.phone')) }}">{{ TwillAppSettings::get('public.public.phone') }}</a>
            </p>
            <p class="drawer__row">
                <img src="/template/assets/icons/c-clock.svg" alt="" width="20" height="20">
                Ежедневно с 08:00 до 22:00
            </p>
        </div>
    </nav>
</div>

<div class="overlay overlay--center" id="city-picker">
    <div class="overlay__panel city-modal">
        <div class="city-modal__head">
            <h2 class="city-modal__title" id="city-title">Выбор города</h2>
            <a class="overlay__close" href="#main" aria-label="Закрыть выбор города">
                <span class="cross" aria-hidden="true"></span>
            </a>
        </div>

       {{--<form class="field-wrap city-modal__field" action="/city" method="get">
            <label class="visually-hidden" for="city-q">Введите ваш город</label>
            <input class="field-wrap__input" id="city-q" name="city" type="text"
                   placeholder="Введите ваш город*" required>
        </form>
--}}
        <ul class="city-list" aria-labelledby="city-title">
            <ul class="modal__cities-list" data-modal-cities-wrappet="">

                @foreach ($citiesService::getActiveCities() as $city)
                    <li class="city-list__link" data-city-id="{{ $city->id }}">{{ $city->city }}</li>
                @endforeach
            </ul>

        </ul>
    </div>
</div>

<!-- ============================================== Всплывашки ==== -->
<!-- Уведомления: на десктопе всплывают справа снизу, на мобильной —
     сверху. Живут на всех страницах, наполняются скриптом. -->
<div class="toasts" id="toasts" role="status" aria-live="polite"></div>

<template id="toast-template">
    <div class="toast">
        <img class="toast__photo" src="" alt="" width="74" height="74">
        <p class="toast__text">
            <span class="toast__title"></span>
            <span class="toast__note"></span>
        </p>
        <button class="toast__close" type="button" aria-label="Закрыть уведомление">
            <span class="cross" aria-hidden="true"></span>
        </button>
    </div>
</template>
<script>
    window['cvetofor'] = {};
    // global app configuration object
    window['cvetofor'].config = {
        flatpickr: {

        },
        routes: {
            cities: {
                set: (val) => "{{ route('v1.cities.set', ['city_id' => '??']) }}".replace('??', encodeURI(val)),
                filter: (val) => "{{ route('v1.cities.filter', ['name' => '??']) }}".replace('??', encodeURI(val)),
                all: (val) => "{{ route('v1.cities.all') }}".replace('??', encodeURI(val)),
            },
            search: {
                get: (val) => "{{ route('v1.search.get') }}",
            },
            cart: {
                put: (val) => "{{ route('v1.cart.put', ['price' => '??']) }}".replace('??', encodeURI(val)),
                putAdditional: (val) => "{{ route('v1.cart.putAdditional', ['id' => '??']) }}".replace('??',
                    encodeURI(val)),
                plus: (val) => "{{ route('v1.cart.plus', ['price' => '??']) }}".replace('??', encodeURI(val)),
                minus: (val) => "{{ route('v1.cart.minus', ['price' => '??']) }}".replace('??', encodeURI(val)),
                remove: (val) => "{{ route('v1.cart.remove', ['price' => '??']) }}".replace('??', encodeURI(val)),
                clear: (val) => "{{ route('v1.cart.clear') }}".replace('??', encodeURI(val)),
            },
            deliveryRadius: {
                post: () => "{{ route('v1.order.deliveryRadius') }}"
            }
        }
    };


</script>
<script src="/template/js/app.js?v={{time()}}" defer></script>

</body>
</html>
