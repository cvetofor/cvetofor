@extends('newdesing.app')
@inject('citiesService', \App\Services\CitiesService::class)
@inject('marketService', \App\Services\MarketService::class)
@section('css')<link rel="stylesheet" href="/template/css/build/page-contacts.css?v=20260918">@endsection
@section('content')

    <main id="main">

        <!-- =================================================== Banner ==== -->
        <section class="page-banner container" aria-labelledby="page-title">
            <img class="page-banner__photo" src="/template/assets/img/contacts-banner.webp" alt=""
                 width="601" height="460">
            <img class="page-banner__blob page-banner__blob--a" src="/template/assets/icons/banner-ellipse-1.svg"
                 alt="" aria-hidden="true" width="461" height="431">
            <img class="page-banner__blob page-banner__blob--b" src="/template/assets/icons/banner-ellipse-2.svg"
                 alt="" aria-hidden="true" width="461" height="431">

            <div class="page-banner__body">
                <nav class="page-banner__crumbs" aria-label="Хлебные крошки">
                    <a class="page-banner__crumb" href="/">Главная</a>
                    <span aria-hidden="true"> / </span>
                    <span aria-current="page">Контакты</span>
                </nav>

                <h1 class="page-banner__title" id="page-title">Контакты</h1>
                <p class="page-banner__note">
                    Мы всегда на связи и готовы помочь с выбором идеального букета
                </p>
            </div>
        </section>

        <!-- ============================================== Сотрудничество ==== -->
        <section class="section container" aria-labelledby="coop-title">
            <h2 class="section__title" id="coop-title">{{$array_data['title']??'о вопросам сотрудничества'}}</h2>

            <div class="cols">
                <div class="panel manager">
                    <img class="manager__photo" src="/template/assets/img/manager.webp" alt=""
                         width="100" height="100">
                    <div class="manager__text">
                        <p class="manager__name">{{$array_data['face_name']??''}}</p>
                        <p class="manager__phone"><a
                                href="tel:{{$array_data['face_name']??''}}">{{$array_data['single_phone']??''}}</a></p>
                    </div>

                    <!-- Должность вынесена из колонки с именем: в мобильном макете
                         (305:172) она идёт под фотографией во всю ширину -->
                    <p class="manager__role">{{$array_data['job_title']??''}}</p>
                </div>

                <div class="panel contacts-card">
                    <!-- Пары «подпись → значение» — это список определений, а не абзацы -->
                    <dl class="contacts-card__list">
                        <div class="contact-row">
                            <dt class="contact-row__key">
                <span class="contact-row__icon">
                  <img src="/template/assets/icons/mail.svg" alt="" width="30" height="30">
                </span>
                                E-mail
                            </dt>
                            <dd class="contact-row__val">
                                <a class="contact-row__link"
                                   href="mailto:Maks_berok@mail.ru">{{$array_data['email']??''}}</a>
                            </dd>
                        </div>
                        <div class="contact-row">
                            <dt class="contact-row__key">
                                <img class="contact-row__tile" src="/template/assets/icons/phone-tile.svg" alt=""
                                     width="50" height="50">
                                Единый номер
                            </dt>
                            <dd class="contact-row__val">
                                <a href="tel:{{$array_data['phone']??''}}">{{$array_data['phone']??''}}</a>
                            </dd>
                        </div>
                    </dl>

                    <div class="socials">
                        <p class="socials__key">Мы в соцсетях</p>
                        <ul class="socials__list">
                            <li>
                                <a class="social" href="{{$array_data['vk']??''}}" target="_blank" rel="noopener">
                                    <img src="/template/assets/icons/vk.svg" alt="ВКонтакте" width="50" height="50">
                                    <span class="visually-hidden"> (откроется в новой вкладке)</span>
                                </a>
                            </li>
                            <li>
                                <a class="social" href="{{$array_data['telegram']??''}}" target="_blank" rel="noopener">
                                    <img src="/template/assets/icons/telegram.svg" alt="Telegram" width="50"
                                         height="50">
                                    <span class="visually-hidden"> (откроется в новой вкладке)</span>
                                </a>
                            </li>
                            <li>
                                <a class="social" href="{{$array_data['whatsapp']??''}}" target="_blank" rel="noopener">
                                    <img src="/template/assets/icons/whatsapp.svg" alt="WhatsApp" width="50"
                                         height="50">
                                    <span class="visually-hidden"> (откроется в новой вкладке)</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- ==================================================== Адреса ==== -->
        <section class="section container" aria-labelledby="shops-title">
            <h2 class="section__title" id="shops-title">Адреса магазинов</h2>

            <!-- Порядок как в макете (64:7 слева, карта 64:6 справа): сначала
                 поиск и список адресов, карта — второй колонкой. Раньше было
                 наоборот, и это нашли на приёмке. -->
            <div class="panel shops">
                <div class="shops__list-wrap">
                    <div class="field-wrap shops__search">
                        <label class="visually-hidden" for="shop-search">Поиск по адресу</label>
                        <img class="field-wrap__icon" src="/template/assets/icons/search.svg" alt="" width="18"
                             height="18">
                        <input class="field-wrap__input" id="shop-search" name="shop-search" type="search"
                               placeholder="Введите адрес">
                    </div>

                    <ul class="shops__list">
                        @foreach ($marketService->getCurrentCityMarkets() as $market)
                            <li class="shop contacts__addresses-item @if ($loop->first) active @endif"
                                data-map-address="{{ $market->city->city }}, {{ $market->address }}"
                            >
                                <h3 class="shop__name">
                                    <img src="/template/assets/icons/pin.svg" alt="" width="15" height="20">
                                    {{ $market->city->city }},{{ $market->address }}
                                </h3>
                                @if($market->work_time)
                                    <p class="shop__hours">{{ $market->work_time }}</p>
                                @else
                                    <p class="shop__hours">{{ $market->workTimeLong()[0] ?? '' }}</p>
                                    <p class="shop__hours">{{ $market->workTimeLong()[1] ?? '' }}</p>
                                @endif

                            </li>
                        @endforeach
                            @if ($market->additional_addresses)
                                @foreach ($market->additional_addresses as $_address)
                                    @if ($_address && isset($_address['address']))
                                        <li class="shop contacts__addresses-item  "
                                            data-map-address="{{ $market->city->city }},  {{ $_address['address'] ?? '' }}"
                                        >
                                            <h3 class="shop__name">
                                                <img src="/template/assets/icons/pin.svg" alt="" width="15" height="20">
                                                {{ $market->city->city }}, {{ $_address['address'] ?? '' }}
                                            </h3>
                                            @if(isset($_address['work_time']) && $_address['work_time'])
                                                <p class="shop__hours">{{ $_address['work_time'] }}</p>
                                            @else
                                                <p class="shop__hours">{{ $market->workTimeLong()[0] ?? '' }}</p>
                                                <p class="shop__hours">{{ $market->workTimeLong()[1] ?? '' }}</p>
                                            @endif


                                        </li>




                                    @endif
                                @endforeach
                            @endif

                    </ul>
                </div>
                <div class="contacts__map map map--no-touch shops__map" data-map-overlay="">
                    <div class="map__holder" data-map="" data-map-icon="/dist/img/image/map-placemark.svg"
                         data-map-coords=""></div>
                </div>
                <script src="//api-maps.yandex.ru/2.1/?{{ config('app.yandex_api') }}&lang=ru_RU"></script>

            </div>
        </section>

        <!-- ======================================= Реквизиты и форма ==== -->
        <div class="section container cols cols--tops">
            <section aria-labelledby="req-title">
                <h2 class="section__title" id="req-title">Реквизиты компании</h2>
                @php
                    $legal = \TwillAppSettings::getGroupDataForSectionAndName('legal', 'legal')->content;
                @endphp
                <div class="panel requisites">
                    <p class="requisites__owner">{{ $legal['recipient'] ?? '' }}</p>
                    <dl class="requisites__list">
                        <div class="req-row">
                            <dt class="req-row__key">Юридический адрес:</dt>
                            <dd class="req-row__val">{{ $legal['address'] ?? '' }}</dd>
                        </div>
                        <div class="req-row">
                            <dt class="req-row__key">ИНН:</dt>
                            <dd class="req-row__val">{{ $legal['inn'] ?? '' }}</dd>
                        </div>
                        <div class="req-row">
                            <dt class="req-row__key">ОГРНИП:</dt>
                            <dd class="req-row__val">{{ $legal['ogrn'] ?? '' }}</dd>
                        </div>
                        <div class="req-row">
                            <dt class="req-row__key">Телефон:</dt>
                            <dd class="req-row__val"><a class="req-link" href="tel:{{ $legal['phone'] ?? '' }}">{{ $legal['phone'] ?? '' }}</a>
                            </dd>
                        </div>
                        <div class="req-row">
                            <dt class="req-row__key">Email:</dt>
                            <dd class="req-row__val"><a class="req-link" href="mailto:{{ $legal['email'] ?? '' }}">{{ $legal['email'] ?? '' }}</a>
                            </dd>
                        </div>
                    </dl>
                    <a class="btn btn--primary requisites__download" href="/docs/requisites.pdf" download>
                        <img src="/template/assets/icons/download-minimalistic.svg" alt="" width="24" height="24">
                        Скачать реквизиты
                    </a>
                </div>
            </section>

            <section aria-labelledby="form-title">
                <h2 class="section__title" id="form-title">Связаться с нами</h2>

                <form class="panel contact-form"  method="post"  data-form-wrapper="contact-us"
                      data-form="contact-us" data-validate-form=""
                      data-form-body=""
                      method="POST"
                      action="{{ route('form') }}">
                    @csrf
                    <div class="ffield">
                        <label class="ffield__label" for="c-name">ФИО <span class="req"
                                                                            aria-hidden="true">*</span></label>
                        <input class="ffield__input" id="c-name"  name="fio" type="text"
                               placeholder="Иванов Иван Иванович" autocomplete="name" required>
                    </div>
                    <div class="ffield">
                        <label class="ffield__label" for="c-phone">Телефон <span class="req" aria-hidden="true">*</span></label>
                        <input class="ffield__input" id="c-phone" name="phone" type="tel"
                               placeholder="+7 (000) 000-00-00" autocomplete="tel" required>
                    </div>
                    <div class="ffield">
                        <label class="ffield__label" for="c-email">Email</label>
                        <input class="ffield__input" id="c-email" name="email" type="email"
                               placeholder="email@gmail.com" autocomplete="email">
                    </div>

                    <div class="ffield">
                        <label class="ffield__label" for="c-message">Комментарий <span class="req"
                                                                                       aria-hidden="true">*</span></label>
                        <textarea class="ffield__input ffield__input--area" id="c-message" name="comment"
                                  rows="3" placeholder="Текст комментария" required></textarea>
                    </div>

                    <button class="btn btn--primary contact-form__submit" type="submit">
                        Отправить
                        <img src="/template/assets/icons/arrow-right-white.svg" alt="" width="24" height="24">
                    </button>
                </form>
            </section>
        </div>
    </main>
    <script src="/dist/js/common.js?v=01{{time()}}"></script>
@endsection
