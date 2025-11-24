@inject('citiesService', \App\Services\CitiesService::class)
@php

session()->forget('order_delivery_radius_km');


@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="/dist/css/libs.css" rel="stylesheet" />
    <link href="/dist/css/style.css?v=1" rel="stylesheet" />
    {!! SEO::generate() !!}
    {{-- <link href="/dist/favicon/apple-touch-icon.png" rel="apple-touch-icon" sizes="180x180" /> --}}
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
    @include('metrics')
    @stack('styles')
    <script src="https://telegram.org/js/telegram-web-app.js?57"></script>
    <script type="text/javascript">
        ! function() {
            var t = document.createElement("script");
            t.type = "text/javascript", t.async = !0, t.src = 'https://vk.com/js/api/openapi.js?173', t.onload =
        function() {
                VK.Retargeting.Init("VK-RTRG-1916601-eEtWG"), VK.Retargeting.Hit()
            }, document.head.appendChild(t)
        }();
    </script><noscript><img src="https://vk.com/rtrg?p=VK-RTRG-1916601-eEtWG"
            style="position:fixed; left:-999px;" alt="" /></noscript>
    <!-- Top.Mail.Ru counter -->
    <script type="text/javascript">
        var _tmr = window._tmr || (window._tmr = []);
        _tmr.push({id: "3720857", type: "pageView", start: (new Date()).getTime()});
        (function (d, w, id) {
            if (d.getElementById(id)) return;
            var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true; ts.id = id;
            ts.src = "https://top-fwz1.mail.ru/js/code.js";
            var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
            if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
        })(document, window, "tmr-code");
    </script>
    <noscript><div><img src="https://top-fwz1.mail.ru/counter?id=3720857;js=na" style="position:absolute;left:-9999px;" alt="Top.Mail.Ru" /></div></noscript>
    <!-- /Top.Mail.Ru counter -->

</head>

<body>
    <header class="header" data-header="data-header">
        <div class="header__row">

            @if (request()->is('/'))
                <img src="/dist/img/image/logo.svg" alt="">
            @else
                <a class="logo" href="/"><img src="/dist/img/image/logo.svg" alt=""></a>
            @endif

            <div class="header__menu" data-header-menu="data-header-menu">
                <div class="header__menu-heading">
                    <a class="logo" href="/"><img src="/dist/img/image/logo.svg" alt="">
                    </a>

                    <div class="header__menu-close" data-close-header-menu="data-close-header-menu"></div>
                </div>
                <div class="header__menu-content">
                    <button class="header__city" data-modal-open="city" id="open-modal-city">
                        <svg class="header__city-icon">
                            <use href="#icon-placemark"></use>
                        </svg>
                        <span class="header__city-text">{{ $citiesService::getCity()->city }}</span>
                    </button>
                    <div class="burger"></div>
                    <nav class="nav header__nav">
                        <ul class="nav__list">

                            <li class="nav__item">
                                <a class="nav__link" data-modal-open="catalog" href="javascript:void(0);">Каталог
                                </a>
                            </li>

                            @if (isset($_menuHeader))
                                @foreach ($_menuHeader as $item)
                                    <li class="nav__item">
                                        <a class="nav__link" target="{{ $item['content']['target'] ?: '_self' }}"
                                            href="{{ $item['content']['href'] }}">{{ $item['content']['title'] }}
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </nav>
                    <a class="header__phone"
                        href="tel:{{ str_replace([' ', '(', ')', '-'], ['', '', '', ''], TwillAppSettings::get('public.public.phone')) }}">
                        {{ TwillAppSettings::get('public.public.phone') }}
                    </a>

                    <div class="header__controls-wrap header__controls-wrap--mobile">

                        <a class="header__control header__control--cart  {{ request()->routeIs('cart.index') ? 'active' : '' }}"
                            href="{{ route('cart.index') }}">
                            <span class="header__control-value">{{ \Cart::getTotalQuantity() }}</span>
                        </a>
                        @auth
                            <a class="header__control header__control--personal {{ request()->routeIs('profile.index') ? 'active' : '' }}"
                                href="{{ route('profile.index') }}">
                            </a>
                        @else
                            <a class="header__control header__control--personal {{ request()->routeIs('profile.index') ? 'active' : '' }}"
                                onclick='modal.show("login");' href="#">
                            </a>
                        @endauth

                    </div>
                </div>
            </div>
            <form class="header__search" action="{{ route('catalog.search') }}"
                data-header-search="data-header-search">
                <div class="inputholder form__inputholder">
                    <input class="inputholder__input" name="q"
                        data-header-search-input="data-header-search-input" type="text"
                        placeholder="Поиск по каталогу" />
                    <button class="reset-btn" type="reset">
                        <svg>
                            <use href="#icon-cross"></use>
                        </svg>
                    </button>
                    <div class="dropdown" data-header-search-tip="data-header-search-tip" style="width:100%;">
                        <ul class="dropdown__list">

                        </ul>
                    </div>
                </div>
            </form>
            <div class="header__controls-wrap header__controls-wrap--desktop">
                <button class="header__control header__control--search"
                    data-toggle-header-search="data-toggle-header-search"></button>
                <a class="header__control header__control--cart header__control--desktop active"
                    href="{{ route('cart.index') }}">
                    <span class="header__control-value">{{ \Cart::getTotalQuantity() }}</span>
                </a>
                @auth
                    <a class="header__control header__control--personal header__control--desktop"
                        href="{{ route('profile.index') }}">
                    </a>
                @else
                    <a class="header__control header__control--personal header__control--desktop"
                        onclick='modal.show("login");' href="#">
                    </a>
                @endauth


                <button class="header__control header__control--burger"
                    data-open-header-menu="data-open-header-menu"></button>
            </div>
        </div>
        <div class="header__mobcontrols-wrap">
            <a class="header__mobcontrol header__mobcontrol--mainpage" href="/">
                <span class="header__mobcontrol-icon"></span>
                <span class="header__mobcontrol-title">Главная</span>
            </a>

            <a class="header__mobcontrol header__mobcontrol--catalog" data-modal-open="catalog"
                href="javascript:void(0);">
                <span class="header__mobcontrol-icon"></span>
                <span class="header__mobcontrol-title">Каталог</span>
            </a>

            <a class="header__mobcontrol header__mobcontrol--cart active" href="{{ route('cart.index') }}">
                <span class="header__mobcontrol-icon"></span>
                <span
                    class="header__mobcontrol-value">{{ \Cart::getTotalQuantity() > 0 ? \Cart::getTotalQuantity() . '+' : '0' }}</span>
                <span class="header__mobcontrol-title">Корзина</span>
            </a>
            @auth
                <a class="header__mobcontrol header__mobcontrol--personal" href="{{ route('profile.index') }}">
                    <span class="header__mobcontrol-icon"></span>
                    <span class="header__mobcontrol-title">Профиль</span>
                </a>
            @else
                <a class="header__mobcontrol header__mobcontrol--personal" onclick='modal.show("login");' href="#">
                    <span class="header__mobcontrol-icon"></span>
                    <span class="header__mobcontrol-title">Профиль</span>
                </a>
            @endauth
        </div>
    </header>
    <main class="main">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer__top">
                <a class="logo" href="/">
                    <img src="/dist/img/image/logo.svg" alt="" />
                </a>

                <div class="social footer__social">
                    <a class="social__item" href="{{ TwillAppSettings::get('public.public.vk') }}" target="_blank">
                        <svg class="social__icon" width="18" height="15">
                            <use href="#icon-vk"></use>
                        </svg>
                    </a>

                    <a class="social__item" href="{{ TwillAppSettings::get('public.public.telegram') }}"
                        target="_blank">
                        <svg class="social__icon" width="10" height="18">
                            <use href="#icon-telegram"></use>
                        </svg>
                    </a>

                    <a class="social__item" href="{{ TwillAppSettings::get('public.public.whatsapp') }}"
                        target="_blank">
                        <svg class="social__icon" width="20" height="16">
                            <use href="#icon-whatsapp"></use>
                        </svg>
                    </a>
                </div>
                <a class="footer__phone"
                    href="tel:{{ str_replace([' ', '(', ')', '-'], ['', '', '', ''], TwillAppSettings::get('public.public.phone')) }}">{{ TwillAppSettings::get('public.public.phone') }}
                </a>

                <nav class="nav footer__nav">
                    <ul class="nav__list">
                        <li class="nav__item">
                            <a class="nav__link" data-modal-open="catalog" href="javascript:void(0);">Каталог
                            </a>
                        </li>
                        @if (isset($_menuFooter))
                            @foreach ($_menuFooter as $item)
                                <li class="nav__item">
                                    <a class="nav__link" target="{{ $item['content']['target'] ?: '_self' }}"
                                        href="{{ $item['content']['href'] }}">{{ $item['content']['title'] }}
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </nav>
            </div>
            <div class="footer__bottom">
                <div class="footer__info">
                    <span class="footer__copyright">©
                        Цветофор, {{ date('Y') }}</span>
                    <span class="footer__address"> {{ TwillAppSettings::get('public.public.address') }}</span>
                </div>
                <div class="footer__links-wrap">
                    @if (isset($_menuFooterSecond))
                        @foreach ($_menuFooterSecond as $item)
                            <a class="footer__link" target="{{ $item['content']['target'] ?: '_self' }}"
                                href="{{ $item['content']['href'] }}">{{ $item['content']['title'] }}
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </footer>

    @include('cookie-consent::index')
    @include('components.svg')
    @include('components.modals')
    @stack('html')
    @stack('modals')


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
    @stack('scripts')
    <script src="/dist/js/libs.js"></script>
    <script src="/dist/js/common.js"></script>
    <script src="/dist/js/scripts.js"></script>

    <script src="/dist/js/dev-temp.js?v=0.1"></script>
    <script src="/dist/js/backend-temp.js?v=0.7"></script>
    <script src="/dist/js/ya_commerce.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const urlHasCityParam = new URLSearchParams(window.location.search).has('city');
            const citySelected = sessionStorage.getItem('city_id');
            const path = window.location.pathname;
            // Показываем модалку на страницах /, /catalog... и /search..., если город не выбран
            if (
                !urlHasCityParam &&
                !citySelected &&
                (path === '/' || path.startsWith('/catalog') || path.startsWith('/search')) &&
                !sessionStorage.getItem('modalShown')
            ) {
                modal.show('city');
                sessionStorage.setItem('modalShown', 'true');
            }
        });

    </script>
    {{-- Если неудачаная авторизация, показать еще раз --}}
    @auth
    @else
        @error('email')
            @if ($message == 'validation.email' || $message == 'validation.unique')
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        modal.show("registration");
                    })
                </script>
            @elseif($message == 'auth.failed')
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        modal.show("login");
                    })
                </script>
            @endif
        @enderror
    @endauth

    @if($citiesService::getCity()->id === 98)
        {{-- Улан-Удэ --}}
        @include('components.social-widget', ['telegram' => 'https://t.me/cvetofor_03', 'vk' => 'https://vk.com/cvetofor03', 'whatsapp' => 'https://wa.me/79676202220'])
    @elseif($citiesService::getCity()->id === 96)
        {{-- Кяхта --}}
        @include('components.social-widget', ['telegram' => 'https://t.me/optkyakhta03', 'vk' => 'https://vk.com/cvetofor_kht', 'whatsapp' => 'https://wa.me/79676212220'])
    @elseif($citiesService::getCity()->id === 216)
        {{-- Ангарск --}}
        @include('components.social-widget', ['telegram' => 'https://t.me/Cvetofor_angarsk', 'vk' => 'https://vk.com/cvetofor_38', 'whatsapp' => 'https://wa.me/79643530005'])
    @endif
</body>

</html>
