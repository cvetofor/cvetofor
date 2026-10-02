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
    <link rel="stylesheet" href="/template/css/build/fonts.css?v={{time()}}">
    <link rel="stylesheet" href="/template/css/build/reset.css?v={{time()}}">
    <link rel="stylesheet" href="/template/css/build/style.css?v={{time()}}">
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
        {{-- Главная: тот же блок логотипа, но без ссылки «на саму себя».
             Обёртка .logo — не только ссылка, а элемент сетки шапки:
             без неё картинки становятся отдельными ячейками грида
             .header__inner и расползаются по колонкам. --}}
        @if (request()->is('/'))
            <span class="logo">
                <img class="logo__mark" src="/template/assets/icons/logo-mark.svg" alt="" width="56" height="56">
                <img class="logo__word" src="/template/assets/icons/logo-word.svg" alt="Цветофор" width="95" height="16">
            </span>
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

        <a class="header__phone" href="tel:{{TwillAppSettings::get('public.public.phone')}}">
            <img src="/template/assets/icons/phone.svg" alt="" width="19" height="19">
            <span>{{TwillAppSettings::get('public.public.phone')}}</span>
        </a>

        <form class="field-wrap header__search-form" action="/search" method="get" role="search">
            <label class="visually-hidden" for="header-q">Поиск по каталогу</label>
            <input class="field-wrap__input" id="header-q" name="q" type="search" placeholder="Найти товар" autocomplete="off">
            <button class="header__search-submit" type="submit" aria-label="Найти">
                <img src="/template/assets/icons/search-ink.svg" alt="" width="28" height="28">
            </button>
        </form>

        <div class="header__actions">
            <a class="icon-btn header__search" href="/search" aria-label="Поиск по каталогу">
                <img class="header__search-lens" src="/template/assets/icons/search.svg" alt="" width="28" height="28">
                <img class="header__search-cross" src="/template/assets/icons/cross.svg" alt="" width="28" height="28">
            </a>
            @guest
                <a class="icon-btn" href="#login" aria-label="Войти в личный кабинет">
                    <img src="/template/assets/icons/user.svg" alt="" width="26" height="26">
                </a>
            @else
                <a class="icon-btn" href="{{ route('profile.index') }}" aria-label="Личный кабинет">
                    <img src="/template/assets/icons/user.svg" alt="" width="26" height="26">
                </a>
            @endguest
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
                    data-dismiss=".app-strip" data-dismiss-storage="app-strip-dismissed"
                    aria-label="Скрыть предложение">
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
                <a href="/" aria-label="Цветофор — на главную">
                    <img class="footer__logo" src="/template/assets/icons/footer-logo.svg" alt="Цветофор" width="168" height="60">
                </a>
                <p class="footer__tagline">Доставка свежих цветов по Улан-Удэ и Бурятии</p>
            </div>

            {{-- Меню футера — из Twill-настройки public.public.footer_menu
                 ($_menuFooter), как в старом дизайне; «Каталог» — прямая
                 ссылка на страницу каталога, как в шапке --}}
            <nav class="footer__col" aria-labelledby="f-menu">
                <h2 class="footer__title" id="f-menu">Меню</h2>
                <ul class="footer__list">
                    <li><a class="footer__link" href="/catalog">Каталог</a></li>
                    @if (isset($_menuFooter))
                        @foreach ($_menuFooter as $item)
                            <li>
                                <a class="footer__link" target="{{ $item['content']['target'] ?: '_self' }}"
                                   href="{{ $item['content']['href'] }}">{{ $item['content']['title'] }}</a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </nav>

            <section class="footer__col" aria-labelledby="f-contacts">
                <h2 class="footer__title" id="f-contacts">Контакты</h2>
                <address class="footer__contacts">
                    <p class="contact">
                        <img src="/template/assets/icons/c-phone.svg" alt="Телефон" width="20" height="20">
                        <a class="footer__link"
                           href="tel:{{ str_replace([' ', '(', ')', '-'], ['', '', '', ''], TwillAppSettings::get('public.public.phone')) }}">{{ TwillAppSettings::get('public.public.phone') }}</a>
                    </p>
                    <p class="contact">
                        <img src="/template/assets/icons/c-mail.svg" alt="Почта" width="22" height="20">
                        <a class="footer__link" href="mailto:info@cvetofor.ru">info@cvetofor.ru</a>
                    </p>
                    <p class="contact">
                        <img src="/template/assets/icons/c-pin.svg" alt="Адрес" width="20" height="20">
                        <span class="footer__muted">{{ TwillAppSettings::get('public.public.address') }}</span>
                    </p>
                    <p class="contact">
                        <img src="/template/assets/icons/c-clock.svg" alt="Часы работы" width="20" height="20">
                        <span class="footer__muted">Ежедневно с 08:00 до 22:00</span>
                    </p>
                </address>
            </section>

        </div>

        <div class="footer__bottom">
            <p class="footer__copy"><small>© {{ date('Y') }} Цветофор. Все права защищены</small></p>
            {{-- Правовые ссылки — из Twill-настройки public.public.footer_menu_second
                 ($_menuFooterSecond), как в старом дизайне --}}
            @if (isset($_menuFooterSecond))
                @foreach ($_menuFooterSecond as $item)
                    <p><a class="footer__link" target="{{ $item['content']['target'] ?: '_self' }}"
                          href="{{ $item['content']['href'] }}">{{ $item['content']['title'] }}</a></p>
                @endforeach
            @endif
        </div>

    </div>
</footer>

<!-- ================================================== Оверлеи ==== -->
<!-- Открываются скриптом: клик по ссылке href="#id" перехватывает app.js
     и ставит модалке класс is-open — хеш в URL не пишется, после
     перезагрузки страницы модалки не открываются. Скрипт добавляет
     закрытие по Esc, по клику мимо панели и возврат фокуса. -->

<div class="overlay" id="menu">
    <nav class="overlay__panel drawer" aria-label="Меню">
        <div class="drawer__top">
            <a class="logo" href="/" aria-label="Цветофор — на главную">
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

@guest
    <!-- Окна авторизации. Состав перенесён из старого дизайна
         (components/modals.blade.php): вход — телефон + пароль,
         регистрация — только телефон (пароль приходит СМС-кой),
         восстановление — телефон. Открываются скриптом из шапки,
         переключаются между собой обычными ссылками. Авторизованному
         эти окна не нужны, поэтому и не рендерятся -->

    <div class="overlay overlay--center" id="login">
        <div class="overlay__panel city-modal auth-modal">
            <div class="city-modal__head">
                <h2 class="city-modal__title" id="login-title">Вход</h2>
                <a class="overlay__close" href="#main" aria-label="Закрыть окно входа">
                    <span class="cross" aria-hidden="true"></span>
                </a>
            </div>

            <!-- Роут входа на бэкенде только GET — как и в старом дизайне,
                 форма отправляется GET и без JS. Скрипт перехватывает
                 сабмит, чтобы ошибки показать в открытом окне -->
            <form class="auth-modal__form" action="{{ route('profile.authenticate') }}" method="get">
                <div class="field-wrap">
                    <label class="visually-hidden" for="auth-login-phone">Телефон</label>
                    <input class="field-wrap__input js-phone" id="auth-login-phone" name="phone"
                           type="tel" placeholder="+7 (___) ___ __-__" autocomplete="tel" required>
                </div>
                <div class="field-wrap">
                    <label class="visually-hidden" for="auth-login-password">Пароль</label>
                    <input class="field-wrap__input" id="auth-login-password" name="password"
                           type="password" placeholder="·············"
                           autocomplete="current-password" required>
                </div>
                <a class="auth-modal__forgot" href="#password-recovery">Забыли пароль?</a>
                <div class="check">
                    <input class="check__input" id="auth-remember" name="remember" type="checkbox"
                           {{ old('remember') ? 'checked' : '' }}>
                    <label class="check__label" for="auth-remember">Запомнить</label>
                </div>
                <button class="btn btn--primary auth-modal__submit" type="submit">Войти</button>
                <a class="btn btn--outline auth-modal__alt" href="#registration">Зарегистрироваться</a>
                <p class="auth-modal__policy">Нажимая на кнопку, вы соглашаетесь на
                    <a href="/policy">обработку персональных данных</a>
                </p>
            </form>
        </div>
    </div>

    <!-- Пароль не вводится: сервер генерирует его и присылает СМС-кой,
         после регистрации пользователь уже залогинен -->
    <div class="overlay overlay--center" id="registration">
        <div class="overlay__panel city-modal auth-modal">
            <div class="city-modal__head">
                <h2 class="city-modal__title" id="registration-title">Регистрация</h2>
                <a class="overlay__close" href="#main" aria-label="Закрыть окно регистрации">
                    <span class="cross" aria-hidden="true"></span>
                </a>
            </div>

            <form class="auth-modal__form" action="{{ route('register') }}" method="post">
                @csrf
                <div class="field-wrap">
                    <label class="visually-hidden" for="auth-register-phone">Телефон</label>
                    <input class="field-wrap__input js-phone" id="auth-register-phone" name="phone"
                           type="tel" placeholder="+7 (___) ___ __-__" autocomplete="tel"
                           value="{{ old('phone') }}" required>
                </div>
                <button class="btn btn--primary auth-modal__submit" type="submit">Зарегистрироваться</button>
                <div class="check">
                    <input class="check__input" id="auth-exclusive" name="concent_exclusive_email"
                           type="checkbox">
                    <label class="check__label" for="auth-exclusive">Получать эксклюзивные предложения и акции</label>
                </div>
                <p class="auth-modal__note" data-auth-result hidden></p>
                <p class="auth-modal__policy">Нажимая на кнопку, вы соглашаетесь на
                    <a href="/policy">обработку персональных данных</a>
                </p>
                <a class="auth-modal__link" href="#login">Войти по номеру телефона</a>
            </form>
        </div>
    </div>

    <!-- Сервер всегда отвечает успехом: новый пароль уходит СМС-кой -->
    <div class="overlay overlay--center" id="password-recovery">
        <div class="overlay__panel city-modal auth-modal">
            <div class="city-modal__head">
                <h2 class="city-modal__title" id="password-recovery-title">Восстановление пароля</h2>
                <a class="overlay__close" href="#main" aria-label="Закрыть окно восстановления пароля">
                    <span class="cross" aria-hidden="true"></span>
                </a>
            </div>

            <form class="auth-modal__form" action="{{ route('profile.resetPassword') }}" method="post">
                @csrf
                <div class="field-wrap">
                    <label class="visually-hidden" for="auth-recovery-phone">Телефон</label>
                    <input class="field-wrap__input js-phone" id="auth-recovery-phone" name="phone"
                           type="tel" placeholder="+7 (___) ___ __-__" autocomplete="tel"
                           value="{{ old('phone') }}" required>
                </div>
                <button class="btn btn--primary auth-modal__submit" type="submit">Отправить</button>
                <p class="auth-modal__note" data-auth-result hidden></p>
                <p class="auth-modal__policy">Нажимая на кнопку, вы соглашаетесь на
                    <a href="/policy">обработку персональных данных</a>
                </p>
                <a class="auth-modal__link" href="#login">Войти по номеру телефона</a>
            </form>
        </div>
    </div>
@endguest

<!-- Быстрый заказ: hero-кнопки (welcome/каталог/поиск) и «Купить в один
     клик» в карточке товара открывают окно ссылкой href="#quick-order"
     (общий механизм оверлеев). Отправка — блоком app.js на роут form
     (тот же, что у «Связаться с нами»): URL страницы и товар открывателя
     вшиваются в comment, успех переключает панель на «спасибо» -->
<div class="overlay overlay--center" id="quick-order">
    <div class="overlay__panel city-modal quick-order">
        <div class="city-modal__head">
            <h2 class="city-modal__title" id="quick-order-title">Быстрый заказ</h2>
            <a class="overlay__close" href="#main" aria-label="Закрыть окно быстрого заказа">
                <span class="cross" aria-hidden="true"></span>
            </a>
        </div>

        {{-- Тот же action и те же имена полей, что у «Связаться с нами»:
             comment (обязательный для роута) скрипт дописывает сам —
             URL страницы и товар открывателя --}}
        <form class="quick-order__form" data-quick-order-form
              action="{{ route('form') }}" method="post">
            @csrf
            <div class="quick-order__field">
                <label class="quick-order__label" for="quick-order-name">
                    Имя <span class="req" aria-hidden="true">*</span>
                </label>
                <div class="field-wrap">
                    <input class="field-wrap__input" id="quick-order-name" name="fio"
                           type="text" placeholder="Иван" autocomplete="name" required>
                </div>
            </div>
            <div class="quick-order__field">
                <label class="quick-order__label" for="quick-order-phone">
                    Телефон <span class="req" aria-hidden="true">*</span>
                </label>
                <div class="field-wrap">
                    <input class="field-wrap__input js-phone" id="quick-order-phone" name="phone"
                           type="tel" placeholder="+7 (000) 000-00-00" autocomplete="tel" required>
                </div>
            </div>
            <button class="btn btn--primary quick-order__submit" type="submit">Оформить заказ</button>
            <p class="quick-order__policy">Нажимая на кнопку, вы соглашаетесь на
                <a href="/policy">обработку персональных данных</a>
            </p>
        </form>

        {{-- Показывается скриптом вместо формы после успешной отправки.
             «Понятно» — ссылка #main: закрывается общим механизмом оверлеев --}}
        <div class="quick-order__success" data-quick-order-success hidden>
            <img src="/template/assets/icons/success-check.svg" alt="" width="80" height="80">
            <h3 class="quick-order__success-title">Спасибо!</h3>
            <p class="quick-order__success-text">Заявка отправлена. С вами скоро свяжется
                менеджер для уточнения заказа.</p>
            <a class="btn btn--primary quick-order__success-close" href="#main">Понятно</a>
        </div>
    </div>
</div>

<!-- Согласие на cookie — перенос баннера старого дизайна
     (spatie/laravel-cookie-consent). Приходит в разметке скрытой:
     показывает блок №33 app.js, если нет куки согласия (та же
     cookieConsent=1, что ставит пакет в старом дизайне, — согласие
     общее для обоих дизайнов на одном домене). «Ок» ставит куку
     на год и убирает плашку — больше не показывается -->
<aside class="cookie-bar" hidden>
    <p class="cookie-bar__text">
        Используя данный сайт, вы даете согласие на использование файлов cookie,
        помогающих нам сделать его удобнее для вас. <a href="/policy">Подробнее.</a>
    </p>
    <button class="btn btn--primary cookie-bar__ok" type="button">Ок</button>
</aside>

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
