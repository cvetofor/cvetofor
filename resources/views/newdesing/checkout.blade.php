@extends('newdesing.app')
@inject('citiesService', \App\Services\CitiesService::class)
@php
    $cart_has_limited_categories = false;
    $cart_has_limited_tags = false;
    $maxStartDate = null;
    $minEndDate = null;
    /* Баллы UDS уже списаны (сессию ставит сервер при /uds/create):
       в этом состоянии поле ввода кода скрыто, итог — из сессии */
    $udsApplied = session('uds_points_used') && session('uds_old_total') && session('uds_new_total');
@endphp
@section('css')
    <link rel="stylesheet" href="template/css/build/page-checkout.css?v=20260929">
@endsection
@section('content')

    <main id="main">

        <!-- Стрелка «назад» есть только в мобильном макете (295:380),
             на десктопе заголовок стоит один — поэтому она там скрыта -->
        <div class="container page-head">
            <a class="page-head__back" href="cart.html" aria-label="Вернуться назад">
                <span class="chevron chevron--back" aria-hidden="true"></span>
            </a>
            <h1 class="page-title">Оформление заказа</h1>
        </div>

        <!-- ===================================================== Шаги ==== -->

        <div class="checkout container">

            <nav class="steps-wrap" aria-label="Шаги оформления">
                <div class="steps__progress">
                    <progress class="steps__bar" value="25" max="100"
                              aria-label="Прогресс оформления заказа">25&nbsp;%
                    </progress>
                    <span class="steps__percent" aria-hidden="true">25&nbsp;%</span>
                </div>
                <ol class="steps">
                    <li class="step is-current" aria-current="step">
                        <span class="step__num">1</span>
                        <span class="step__text">
              <span class="step__title">Данные</span>
              <span class="step__note">Получатель и доставка</span>
            </span>
                    </li>
                    <li class="steps__dots" aria-hidden="true"></li>
                    <li class="step">
                        <span class="step__num">2</span>
                        <span class="step__text">
              <span class="step__title">Доставка</span>
              <span class="step__note">Способ и адрес</span>
            </span>
                    </li>
                    <li class="steps__dots" aria-hidden="true"></li>
                    <li class="step">
                        <span class="step__num">3</span>
                        <span class="step__text">
              <span class="step__title">Оплата</span>
              <span class="step__note">Выбор способа</span>
            </span>
                    </li>
                    <li class="steps__dots" aria-hidden="true"></li>
                    <li class="step">
                        <span class="step__num">4</span>
                        <span class="step__text">
              <span class="step__title">Подтверждение</span>
              <span class="step__note">Проверка и заказ</span>
            </span>
                    </li>
                </ol>
            </nav>

            <!-- =========== Шаг 1 =========== -->
            <div class="checkout-step" data-step="1">
                <form class="checkout__form panel" id="checkout-step-1" action="/checkout/step-2" method="post">

                    <div class="fieldset">
                        <h2 class="fieldset__legend">Данные заказчика <span class="req" aria-hidden="true">*</span><span
                                class="visually-hidden"> — обязательные поля</span></h2>
                        <div class="fields">
                            <div class="field-group">
                                <div class="field-wrap">
                                    <label class="visually-hidden" for="customer-name">ФИО заказчика</label>
                                    <img class="field-wrap__icon" src="template/assets/icons/form-user.svg" alt=""
                                         width="18" height="18">
                                    <input class="field-wrap__input" id="customer-name" name="fio" type="text"
                                           placeholder="ФИО заказчика" autocomplete="name" required @auth
                                               value="{{ auth()->user()->last_name }} {{ auth()->user()->name }} {{ auth()->user()->second_name }}"
                                        @endauth >
                                </div>
                            </div>
                            <div class="field-group">
                                <div class="field-wrap">
                                    <label class="visually-hidden" for="customer-phone">Номер телефона заказчика</label>
                                    <img class="field-wrap__icon" src="template/assets/icons/form-call.svg" alt=""
                                         width="18" height="18">
                                    <input class="field-wrap__input js-phone" id="customer-phone" name="phone"
                                           type="tel"
                                           placeholder="Номер телефона заказчика" autocomplete="tel" required
                                           @auth value="{{ auth()->user()->phone }}" @endauth>
                                </div>
                            </div>
                        </div>

                        <div class="check">
                            <input class="check__input" id="same-person" name="same-person" type="checkbox">
                            <label class="check__label" for="same-person">Получатель и заказчик — одно лицо</label>
                        </div>
                    </div>

                    <div class="fieldset">
                        <div class="fieldset__head">
                            <h2 class="fieldset__legend">Адрес доставки <span class="req"
                                                                              aria-hidden="true">*</span><span
                                    class="visually-hidden"> — обязательные поля</span></h2>

                            <div class="segmented" role="group" aria-label="Знаете ли вы адрес доставки">
                                <button class="segmented__btn is-active" type="button" data-address-known
                                        aria-pressed="true">Я знаю адрес
                                </button>
                                <button class="segmented__btn" type="button" data-address-unknown aria-pressed="false">
                                    Не знаю адрес
                                </button>
                            </div>
                        </div>

                        <div class="fields" data-address-fields>
                            <div class="field-group">
                                <div class="field-wrap">
                                    <label class="visually-hidden" for="city">Город</label>
                                    <img class="field-wrap__icon" src="template/assets/icons/form-pin.svg" alt=""
                                         width="14" height="18">
                                    <!-- Город фиксирован: доставляем только по Улан-Удэ -->
                                    <input class="field-wrap__input" id="city" name="city" type="text"
                                           value="{{ $citiesService::getCity()->city }}" readonly tabindex="-1"
                                           aria-readonly="true" style="pointer-events:none">
                                </div>
                            </div>
                            <div class="field-group">
                                <div class="field-wrap">
                                    <label class="visually-hidden" for="address">Улица, № дома, квартира</label>
                                    <img class="field-wrap__icon" src="template/assets/icons/form-apartment.svg" alt=""
                                         width="18" height="18">
                                    <input class="field-wrap__input" id="address" name="address" type="text"
                                           placeholder="Улица, № дома, квартира" autocomplete="street-address" required
                                           data-delivery-address="data-delivery-address" data-suggest-city="#city">
                                    <div class="suggest-dropdown" data-suggest-dropdown="data-suggest-dropdown"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="fieldset">
                        <h2 class="fieldset__legend">Получатель <span class="req" aria-hidden="true">*</span><span
                                class="visually-hidden"> — обязательные поля</span></h2>
                        <div class="fields">
                            <div class="field-group">
                                <div class="field-wrap">
                                    <label class="visually-hidden" for="recipient-name">ФИО получателя</label>
                                    <img class="field-wrap__icon" src="template/assets/icons/form-user.svg" alt=""
                                         width="18" height="18">
                                    <input class="field-wrap__input" id="recipient-name" name="person_receiving_name"
                                           type="text"
                                           placeholder="ФИО получателя" required>
                                </div>
                            </div>
                            <div class="field-group">
                                <div class="field-wrap">
                                    <label class="visually-hidden" for="recipient-phone">Номер телефона
                                        получателя</label>
                                    <img class="field-wrap__icon" src="template/assets/icons/form-call.svg" alt=""
                                         width="18" height="18">
                                    <input class="field-wrap__input js-phone" id="recipient-phone"
                                           name="person_receiving_phone" type="tel"
                                           placeholder="Номер телефона получателя" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="fieldset">
                        <h2 class="fieldset__legend">Комментарий к заказу</h2>
                        <div class="note-wrap">
                            <label class="visually-hidden" for="comment">Комментарий к заказу</label>
                            <textarea class="note-wrap__input" id="comment" name="comment" rows="3" maxlength="200"
                                      placeholder="Пожелания, комментарии, указания для курьера…"></textarea>
                            <span class="note-wrap__counter" aria-hidden="true">0/200</span>
                        </div>
                    </div>

                    <ul class="switches">
                        <li class="switch-row">
                            <img class="switch-row__icon" src="template/assets/icons/postcard.svg" alt="" width="64"
                                 height="64">
                            <span class="switch-row__text">
              <span class="switch-row__title">Открытка с текстом</span>
              <span class="switch-row__note">Добавим открытку с вашим текстом</span>
            </span>
                            <span class="switch">
              <input class="switch__input" id="postcard" name="postcard" type="checkbox">
              <label class="switch__label" for="postcard">
                <span class="visually-hidden">Открытка с текстом</span>
              </label>
            </span>
                        </li>

                        <li class="switch-row">
            <span class="switch-row__icon switch-row__icon--tile">
              <img src="template/assets/icons/gift.svg" alt="" width="42" height="42">
            </span>
                            <span class="switch-row__text">
              <span class="switch-row__title">Доставить анонимно</span>
              <span class="switch-row__note">Получатель не узнает от кого букет</span>
            </span>
                            <span class="switch">
              <input class="switch__input" id="anon" name="is_anon" type="checkbox" >
              <label class="switch__label" for="anon">
                <span class="visually-hidden">Доставить анонимно</span>
              </label>
            </span>
                        </li>
                    </ul>

                    <div class="postcard-text" id="postcard-text-row" hidden>
                        <div class="note-wrap">
                            <label class="visually-hidden" for="postcard_text">Текст для открытки</label>
                            <textarea class="note-wrap__input" id="postcard_text" name="postcard_text" rows="3"
                                      maxlength="200"
                                      placeholder="Текст для открытки"></textarea>
                            <span class="note-wrap__counter" aria-hidden="true">0/200</span>
                        </div>
                    </div>

                </form>
            </div>

            <!-- =========== Шаг 2 =========== -->
            <div class="checkout-step" data-step="2" hidden>
                <form class="checkout__form panel" id="checkout-step-2" action="/checkout/step-3" method="post">

                    <!-- Способ доставки скрыт: пока выбор фиксированный — курьер.
                    <fieldset class="fieldset">
                      <legend class="fieldset__legend">Способ доставки</legend>

                      <ul class="ways">
                        <li>
                          <input class="way__input visually-hidden" id="way-courier" name="way"
                                 type="radio" value="way-courier" checked>
                          <label class="way" for="way-courier">
                            <img class="way__icon" src="template/assets/icons/delivery-truck.svg" alt="" width="52" height="52">
                            <span class="way__text">
                              <span class="way__title">Курьером</span>
                              <span class="way__note">Доставим букет по указанному адресу</span>
                            </span>
                            <span class="way__mark" aria-hidden="true"></span>
                          </label>
                        </li>
                        <li>
                          <input class="way__input visually-hidden" id="way-pickup" name="way"
                                 type="radio" value="way-pickup" data-reveal="#salons">
                          <label class="way" for="way-pickup">
                            <img class="way__icon" src="template/assets/icons/shop.svg" alt="" width="42" height="42">
                            <span class="way__text">
                              <span class="way__title">Самовывоз</span>
                              <span class="way__note">Заберите заказ в нашем цветочном салоне</span>
                            </span>
                            <span class="way__mark" aria-hidden="true"></span>
                          </label>
                        </li>
                      </ul>
                    </fieldset>
                    -->
                    <input type="hidden" name="way" value="Курьером">

                    <!-- ================================================== Салон ==== -->
                    <!-- Состояние из макета 69:54: появляется при выборе самовывоза.
                         Без JS приходит с сервера вместе с выбранным способом.
                         disabled обязателен: hidden поля из формы не исключает,
                         и при доставке курьером на сервер уходил выбранный салон. -->
                    <fieldset class="fieldset" id="salons" hidden disabled>
                        <legend class="fieldset__legend">Салон</legend>

                        <ul class="salons">
                            <li>
                                <input class="salon__input visually-hidden" id="salon-lenina" name="salon"
                                       type="radio" value="salon-lenina" checked>
                                <label class="salon" for="salon-lenina">
                <span class="salon__text">
                  <span class="salon__name">Цветофор на Ленина</span>
                  <span class="salon__addr">ул. Ленина, 45</span>
                  <span class="salon__hours">Открыто до 21:00</span>
                </span>
                                    <span class="salon__mark" aria-hidden="true"></span>
                                </label>
                            </li>
                            <li>
                                <input class="salon__input visually-hidden" id="salon-mira" name="salon"
                                       type="radio" value="salon-mira">
                                <label class="salon" for="salon-mira">
                <span class="salon__text">
                  <span class="salon__name">Цветофор на Мира</span>
                  <span class="salon__addr">пр. Мира, 23</span>
                  <span class="salon__hours">Открыто до 20:00</span>
                </span>
                                    <span class="salon__mark" aria-hidden="true"></span>
                                </label>
                            </li>
                            <li>
                                <input class="salon__input visually-hidden" id="salon-sovetskaya" name="salon"
                                       type="radio" value="salon-sovetskaya" disabled>
                                <label class="salon" for="salon-sovetskaya">
                <span class="salon__text">
                  <span class="salon__name">Цветофор на Советской</span>
                  <span class="salon__addr">пр. Мира, 23</span>
                  <span class="salon__hours salon__hours--closed">Временно закрыто</span>
                </span>
                                    <span class="salon__mark" aria-hidden="true"></span>
                                </label>
                            </li>
                        </ul>
                    </fieldset>

                    <fieldset class="fieldset">
                        <legend class="fieldset__legend">Дата и время доставки</legend>

                        @php
                            /* DateTime() возвращает чистый \DateTime — оборачиваем в Carbon
                               для русских названий дней и месяцев */
                            $deliveryToday = \Carbon\Carbon::instance(\App\Services\CitiesService::DateTime());
                            /* «Сегодня» показываем только если на сегодня есть интервалы */
                            $deliveryStart = !empty($deliveryTimes['todayTimes'])
                                ? $deliveryToday->copy()
                                : $deliveryToday->copy()->addDay();
                        @endphp
                        <ul class="daychips">
                            @for ($i = 0; $i < 4; $i++)
                                @php
                                    $chipDate = $deliveryStart->copy()->addDays($i);
                                    if ($chipDate->isSameDay($deliveryToday)) {
                                        $chipTitle = 'Сегодня';
                                    } elseif ($chipDate->isSameDay($deliveryToday->copy()->addDay())) {
                                        $chipTitle = 'Завтра';
                                    } else {
                                        $chipDayName = $chipDate->locale('ru')->dayName;
                                        $chipTitle = mb_strtoupper(mb_substr($chipDayName, 0, 1)) . mb_substr($chipDayName, 1);
                                    }
                                @endphp
                                <li>
                                    <input class="daychip__input visually-hidden" id="day-{{ $i + 1 }}" name="day"
                                           type="radio" value="{{ $chipDate->format('d.m.Y') }}" data-slots-source>
                                    <label class="daychip" for="day-{{ $i + 1 }}">
                                        <span class="daychip__title">{{ $chipTitle }}</span>
                                        <span class="daychip__date">{{ $chipDate->locale('ru')->translatedFormat('j F') }}</span>
                                        <span class="daychip__mark" aria-hidden="true"></span>
                                    </label>
                                </li>
                            @endfor
                        </ul>

                        <!-- Календарь-всплывашка. Сетку месяца рисует скрипт (app.js)
                             в .calendar__grid — своя реализация без библиотек.
                             Нативное поле остаётся носителем значения для формы
                             и обзора заказа, со скриптом оно прячется (.is-enhanced) -->
                        <details class="pick-date" data-calendar>
                            <summary class="pick-date__toggle">
                                <img src="template/assets/icons/calendar-lines.svg" alt="" width="20" height="20">
                                Выбрать дату
                                <span class="chevron" aria-hidden="true"></span>
                            </summary>

                            <div class="calendar">
                                <label class="calendar__label" for="date">Дата доставки</label>
                                <input class="calendar__native" id="date" name="delivery_date" type="text"
                                       readonly placeholder="д.м.гггг">
                                <div class="calendar__grid"></div>
                            </div>
                        </details>

                        <!-- Интервалы подставляет скрипт после выбора даты из
                             config.flatpickr.times/todayTimes/dates — тот же источник,
                             что в старом дизайне. До выбора даты времени нет -->
                        <ul class="slots" id="slots" data-list>
                            <li class="slots__empty">Выберите дату доставки</li>
                        </ul>

                        <!-- Показывается при попытке уйти на следующий шаг
                             без выбранной даты и времени -->
                        <p class="delivery-error" data-delivery-error hidden>Выберите дату и время доставки</p>

                        <!-- В макете (57:266) это не переключатель, а пояснение: розовая
                             плашка с часами, заголовком и текстом. Выбора здесь нет —
                             курьер связывается всегда, поэтому и тумблера быть не должно. -->
                        <p class="exact-time">
                            <img class="exact-time__icon" src="template/assets/icons/time.svg" alt="" width="48"
                                 height="48">
                            <span class="exact-time__text">
              <span class="exact-time__title">Точное время доставки</span>
              <span class="exact-time__note">Курьер заранее свяжется с получателем
                и согласует точное время в выбранном интервале</span>
            </span>
                        </p>
                    </fieldset>


                </form>
            </div>

            <!-- =========== Шаг 3 =========== -->
            <div class="checkout-step" data-step="3" hidden>
                <form class="checkout__form checkout__form--payment panel" id="checkout-step-3"
                      action="/checkout/step-4" method="post">

                    <fieldset class="fieldset">
                        <legend class="fieldset__legend">Способ оплаты</legend>

                        <ul class="pays">

                            @foreach ($payments as $payment)
                                <li>
                                    <input class="pay__input visually-hidden" id="pay-online{{$payment->id}}"
                                           type="radio" @if($payment->code === 'account') data-account="true"
                                           @endif name="payment_id" @if($loop->first) checked="checked"
                                           @endif value="{{ $payment->id }}">
                                    <label class="pay" for="pay-online{{$payment->id}}">
              <span class="pay__logos">
              <img class="pay__logo" src="{{ $payment->image('logo') }}" alt="МИР"
                    height="50">
             {{-- <img class="pay__logo" src="{{ $payment->image('logo') }}" alt="СБП"
                   width="74" height="39">--}}
              </span>
                                        <span class="pay__title">{{ $payment->name }}</span>
                                       {{-- <span class="pay__note">Банковские карты и СБП</span>--}}
                                        <span class="pay__mark" aria-hidden="true"></span>
                                    </label>
                                </li>

                            @endforeach


                        </ul>
                    </fieldset>

                    <!-- ============================================ Бонусы UDS ==== -->
                    <!-- Логика перенесена из старого дизайна (order.blade.php):
                         проверка кода и списание/копление баллов идут AJAX-ом
                         (app.js, блок «Промокод и бонусы UDS») на существующие
                         роуты /uds/check, /uds/create, /uds/reward, /uds/reset -->
                    <section class="bonus" aria-labelledby="bonus-title">
                        <h2 class="fieldset__legend" id="bonus-title">Бонусная программа</h2>

                        <!-- Ввод кода: скрывается после списания баллов или
                             применения промокода (совмещать их нельзя) -->
                        <div data-uds-entry @if($udsApplied) hidden @endif>
                            <!-- Подсказка из макета 42:873: раскрывается иконкой ⓘ.
                                 <details> вместо всплывающего окна — работает без JS
                                 и остаётся в потоке, не перекрывая поля. -->
                            <details class="hint">
                                <summary class="hint__toggle">
                                    Введите код из UDS
                                    <img class="hint__icon" src="template/assets/icons/info-circle.svg" alt=""
                                         width="20" height="20">
                                    <span class="visually-hidden">— где взять код</span>
                                </summary>
                                <!-- Одна плашка, а не две: в макете (234:1629) это один
                                     текстовый блок 230x112 внутри всплывашки 274x156 -->
                                <p class="hint__body">
                                    Ваш код скидки пишется под вашим QR-кодом, набор из 6 цифр.
                                    Получите 500 рублей на первую покупку, переходите по ссылке
                                    <a class="hint__link" href="https://opt03.uds.app/c"
                                       target="_blank" rel="noopener">opt03.uds.app/c<span
                                                class="visually-hidden"> (откроется в новой вкладке)</span></a>
                                </p>
                            </details>

                            <div class="paired">
                                <label class="visually-hidden" for="uds">Код из UDS</label>
                                <input class="paired__input" id="uds" name="uds_promo" type="text"
                                       inputmode="numeric" pattern="[0-9]*" placeholder="12345">
                                <button class="paired__btn" type="button" data-uds-check>Проверить баллы
                                </button>
                            </div>
                        </div>

                        <!-- Состояние из макета 234:1631: наполняет скрипт после ответа
                             /uds/check. При нулевых баллах кнопка «Списать» скрывается -->
                        <div class="bonus__result" id="bonus-result" hidden>
                            <p class="bonus__score">
                                <span class="bonus__label">Бонусных баллов</span>
                                <span class="bonus__value"><span data-uds-points></span>
                <img src="template/assets/icons/bonus.svg" alt="" width="22" height="22">
              </span>
                            </p>
                            <div class="bonus__actions">
                                <button class="btn btn--primary bonus__btn" type="button"
                                        data-uds-spend>Списать
                                </button>
                                <button class="btn btn--outline bonus__btn" type="button"
                                        data-uds-hoard>Копить
                                </button>
                            </div>
                        </div>

                        <!-- Баллы уже списаны (сессия uds_*): суммы до/после и отмена.
                             Это же состояние скрипт показывает после /uds/create -->
                        <div class="bonus__result" data-uds-applied @if(!$udsApplied) hidden @endif>
                            <p class="bonus__score">
                                <span class="bonus__label">Бонусных баллов к списанию</span>
                                <span class="bonus__value"><span
                                            data-uds-applied-points>{{ $udsApplied ? (int) session('uds_points_amount') : '' }}</span>
                <img src="template/assets/icons/bonus.svg" alt="" width="22" height="22">
              </span>
                            </p>
                            <p class="bonus__total" data-uds-applied-total @if(!$udsApplied) hidden @endif>
                                @if($udsApplied)
                                    Итого:
                                    <s class="bonus__total-old">{{ number_format(session('uds_old_total'), 0, '.', ' ') }} ₽</s>
                                    → <b class="bonus__total-new">{{ number_format(session('uds_new_total'), 0, '.', ' ') }} ₽</b>
                                @endif
                            </p>
                            <div class="bonus__actions">
                                <button class="btn btn--outline bonus__btn" type="button"
                                        data-uds-reset>Отменить списание бонусов
                                </button>
                            </div>
                        </div>

                        <!-- Сообщение о результате: успех зелёным, ошибка красным -->
                        <p class="bonus__result-note" data-uds-result hidden></p>
                    </section>

                    <!-- =============================================== Промокод ==== -->
                    <!-- Применение идёт AJAX-ом (app.js) на /promocode/check;
                         после успеха поле скрывается: промокод и UDS несовместимы -->
                    <section class="coupon" aria-labelledby="coupon-title">
                        <h2 class="fieldset__legend" id="coupon-title">Промокод</h2>
                        @if(!session('use_promocode'))
                        <p class="coupon__note">Введите промокод, если он у вас есть</p>

                        <div class="paired" data-promo-entry>
                            <label class="visually-hidden" for="promo">Промокод</label>
                            <input class="paired__input" id="promo" name="promocode" type="text"
                                   placeholder="Введите промокод">
                            <button class="paired__btn" type="button" data-promo-check>Применить</button>
                        </div>
                        @endif

                        <!-- Сообщение о результате: успех зелёным, ошибка красным -->
                        <p class="coupon__result" data-promo-result hidden></p>
                    </section>

                </form>
            </div>

            <!-- =========== Шаг 4 =========== -->
            <div class="checkout-step" data-step="4" hidden>
                <form class="checkout__form checkout__form--confirm panel" id="checkout-step-4" action="/checkout/done"
                      method="post">

                    <section class="review" aria-labelledby="r-customer">
                        <div class="review__head">
                            <h2 class="review__title" id="r-customer">Заказчик</h2>
                            <a class="review__edit" data-edit-step="1" href="#main">
                                <img src="template/assets/icons/edit-pencil-01.svg" alt="" width="17" height="17">
                                <span class="review__edit-text">Изменить</span>
                                <span class="visually-hidden">: заказчик</span>
                            </a>
                        </div>
                        <ul class="facts">
                            <li class="fact">
                                <img src="template/assets/icons/user.svg" alt="" width="18" height="18">
                                <span data-fill="customer-name">Фролов Сергей Викторович</span>
                            </li>
                            <li class="fact">
                                <img src="template/assets/icons/form-call.svg" alt="" width="18" height="18">
                                <span data-fill="customer-phone">+7 (914) 123-45-67</span>
                            </li>
                        </ul>
                    </section>

                    <section class="review" aria-labelledby="r-address">
                        <div class="review__head">
                            <h2 class="review__title" id="r-address">Адрес доставки</h2>
                            <a class="review__edit" data-edit-step="1" href="#main">
                                <img src="template/assets/icons/edit-pencil-01.svg" alt="" width="17" height="17">
                                <span class="review__edit-text">Изменить</span>
                                <span class="visually-hidden">: адрес доставки</span>
                            </a>
                        </div>
                        <ul class="facts">
                            <li class="fact">
                                <img src="template/assets/icons/form-pin.svg" alt="" width="14" height="18">
                                <span data-fill="address">г. Улан-Удэ, ул. Цветочная, д.10, кв. 25</span>
                            </li>
                        </ul>
                    </section>

                    <section class="review" aria-labelledby="r-shipping">
                        <div class="review__head">
                            <h2 class="review__title" id="r-shipping">Способ и время доставки</h2>
                            <a class="review__edit" data-edit-step="2" href="#main">
                                <img src="template/assets/icons/edit-pencil-01.svg" alt="" width="17" height="17">
                                <span class="review__edit-text">Изменить</span>
                                <span class="visually-hidden">: способ и время доставки</span>
                            </a>
                        </div>
                        <ul class="facts">
                            <li class="fact">
                                <img src="template/assets/icons/truck-ink.svg" alt="" width="24" height="18">
                                <span data-fill="way">Курьером</span>
                            </li>
                            <li class="fact">
                                <img src="template/assets/icons/calendar-lines.svg" alt="" width="18" height="18">
                                <span data-fill="date">30 июня, сегодня</span>
                            </li>
                            <li class="fact">
                                <img src="template/assets/icons/time.svg" alt="" width="18" height="18">
                                <span data-fill="slot">9:00 – 12:00</span>
                            </li>
                        </ul>
                    </section>

                    <section class="review" aria-labelledby="r-payment">
                        <div class="review__head">
                            <h2 class="review__title" id="r-payment">Способ оплаты</h2>
                            <a class="review__edit" data-edit-step="3" href="#main">
                                <img src="template/assets/icons/edit-pencil-01.svg" alt="" width="17" height="17">
                                <span class="review__edit-text">Изменить</span>
                                <span class="visually-hidden">: способ оплаты</span>
                            </a>
                        </div>
                        <div class="paycard">
            <span class="paycard__logos">
              <img src="template/assets/icons/mir-logo.svg" alt="МИР" width="85" height="23">
              <img src="template/assets/icons/sbp-logo.svg" alt="СБП" width="57" height="30">
            </span>
                            <span class="paycard__text">
              <span class="paycard__title" data-fill="payment">Онлайн оплата картой (Ю)</span>
              <span class="paycard__note" data-fill="payment-note">Банковские карты и СБП</span>
            </span>
                        </div>
                    </section>

                    <section class="review" aria-labelledby="r-extra">
                        <div class="review__head">
                            <h2 class="review__title" id="r-extra">Дополнительно</h2>
                            <a class="review__edit" data-edit-step="1" href="#main">
                                <img src="template/assets/icons/edit-pencil-01.svg" alt="" width="17" height="17">
                                <span class="review__edit-text">Изменить</span>
                                <span class="visually-hidden">: дополнительно</span>
                            </a>
                        </div>
                        <div class="extras">
                            <ul class="extras__list">
                                <li class="extra" data-extra="postcard">
                <span class="extra__icon">
                  <img src="template/assets/icons/postcard.svg" alt="" width="31" height="31">
                </span>
                                    <span data-fill="extra-postcard">Открытка с текстом</span>
                                </li>
                                <li class="extra" data-extra="anon">
                <span class="extra__icon">
                  <img src="template/assets/icons/gift.svg" alt="" width="31" height="31">
                </span>
                                    <span data-fill="extra-anon">Анонимная доставка</span>
                                </li>
                            </ul>

                            <figure class="extras__card" data-extra="postcard-text">
                                <figcaption class="extras__card-title">Текст открытки</figcaption>
                                <blockquote class="extras__card-text"><span data-fill="postcard-text">С днём рождения! Пусть каждый день приносит радость и вдохновение</span>
                                </blockquote>
                            </figure>
                        </div>
                    </section>

                    <section class="review" aria-labelledby="r-note">
                        <div class="review__head">
                            <h2 class="review__title" id="r-note">Примечания к заказу</h2>
                            <a class="review__edit" data-edit-step="1" href="#main">
                                <img src="template/assets/icons/edit-pencil-01.svg" alt="" width="17" height="17">
                                <span class="review__edit-text">Изменить</span>
                                <span class="visually-hidden">: примечания к заказу</span>
                            </a>
                        </div>
                        <p class="review__empty" data-fill="note">Примечаний нет</p>
                    </section>

                </form>
            </div>

            <aside class="checkout__aside" aria-label="Ваш заказ">

                <details class="panel summary" open>
                    <summary class="summary__head">
                        <span class="summary__title">Ваш заказ</span>
                        <span class="summary__count">Позиций: {{ $cart->count() }} шт</span>
                        <span class="chevron summary__toggle" aria-hidden="true"></span>
                    </summary>

                    <ul class="summary__list">
                        @foreach ($cart as $item)
                            @php
                                $isCategoryLimited = false;
                                $isTagLimited = false;

                                $product = $item->associatedModel->groupProduct;

                                if ($product) {
                                    // Проверяем категорию
                                    $category = $product->groupProductCategory;
                                    if ($category) {
                                        $category->refresh();
                                        $isCategoryLimited = $category->is_category_limited;
                                        if ($isCategoryLimited) {
                                            $cart_has_limited_categories = true;

                                            $categoryStartDate = \Carbon\Carbon::parse($category->limit_start_date);
                                            $categoryEndDate = \Carbon\Carbon::parse($category->limit_end_date);

                                            if (is_null($maxStartDate) || $categoryStartDate->gt($maxStartDate)) {
                                                $maxStartDate = $categoryStartDate;
                                            }
                                            if (is_null($minEndDate) || $categoryEndDate->lt($minEndDate)) {
                                                $minEndDate = $categoryEndDate;
                                            }
                                        }
                                    }

                                    // Проверяем теги
                                    foreach ($product->tags as $tag) {
                                        $tag->refresh();
                                        if ($tag->is_category_limited) {
                                            $cart_has_limited_tags = true;
                                            $isTagLimited = true;

                                            $tagStartDate = \Carbon\Carbon::parse($tag->limit_start_date);
                                            $tagEndDate = \Carbon\Carbon::parse($tag->limit_end_date);

                                            if (is_null($maxStartDate) || $tagStartDate->gt($maxStartDate)) {
                                                $maxStartDate = $tagStartDate;
                                            }
                                            if (is_null($minEndDate) || $tagEndDate->lt($minEndDate)) {
                                                $minEndDate = $tagEndDate;
                                            }
                                        }
                                    }

                                    // Форматируем даты
                                    $limitStartDate = $maxStartDate ? $maxStartDate->format('d.m.Y') : null;
                                    $limitEndDate = $minEndDate ? $minEndDate->format('d.m.Y') : null;
                                }
                            @endphp
                            <li class="sum-item">
              <span class="sum-item__media">
                <img src="template/assets/img/sum-peony.jpg" alt="" width="74" height="74" loading="lazy">
              </span>
                                <span class="sum-item__text">
                <span class="sum-item__title">{{ $item->name }}</span>
                <span class="sum-item__qty"> @if ($item->quantity > 1)
                        {{ $item->quantity }} шт.
                    @endif </span>
              </span>
                                <span class="sum-item__price">@money($item->getPriceSumWithConditions()) ₽</span>
                                @if ($isCategoryLimited || $isTagLimited)
                                    <div class="cart__delivery-limited-info">
                                        Этот букет доступен для доставки только с {{ $limitStartDate }}
                                        по {{ $limitEndDate }}.
                                    </div>
                                @endif
                            </li>

                        @endforeach


                    </ul>

                    <div class="totals summary__totals">
                        <p class="totals__row totals__row--plain">
                            <span class="totals__key">Доставка</span>
                            <span class="totals__val" data-delivery-price>{{ number_format($totalDeliveryPrice, 0, '.', ' ') }} ₽</span>
                        </p>

                        <hr class="totals__rule">

                        <p class="totals__sum">
                            <span class="totals__sum-key">Итого</span>
                            @php
                                /* При списанных бонусах UDS итог берётся из сессии,
                                   рядом — зачёркнутая сумма до списания */
                                $udsTotal = $udsApplied
                                    ? session('uds_new_total')
                                    : \Cart::getTotal() + $totalDeliveryPrice;
                            @endphp
                            <span class="totals__sum-val totals__sum-val--accent"
                                  data-total="{{ $udsTotal }}">
                                @if($udsApplied)<s
                                        class="totals__sum-old">{{ number_format(session('uds_old_total'), 0, '.', ' ') }} ₽</s> @endif{{ number_format($udsTotal, 0, '.', ' ') }} ₽</span>
                        </p>

                        <!-- Текущая стоимость доставки: с ней скрипт сравнивает ответ
                             /api/v1/order/deliveryRadius, чтобы показать всплывашку
                             только при реальном изменении цены -->
                        <input type="hidden" data-delivery-price-current value="{{ $totalDeliveryPrice }}">
                    </div>
                </details>

                <div class="guarantee">
                    <img class="guarantee__icon" src="template/assets/icons/adv-secure.svg" alt="" width="41"
                         height="53">
                    <p class="guarantee__text">
                        <span class="guarantee__title">Мы гарантируем свежесть цветов</span>
                        <span
                            class="guarantee__note">Если цветы завянут раньше — вернём деньги или заменим букет.</span>
                    </p>
                </div>
                <!-- Кнопка стоит в правой колонке под гарантией — так во всех четырёх
                           шагах макета (110:317, 110:32 и т.д.). Она вне формы, поэтому
                           связана с ней атрибутом form: без скрипта отправка работает. -->
                <button class="btn btn--primary checkout__submit" type="submit" data-submit-for="checkout-steps"
                        form="checkout-step-1">
                    <span class="checkout__submit-label">Далее</span>
                    <img src="template/assets/icons/arrow-right-white.svg" alt="" width="21" height="21">
                </button>
            </aside>
        </div>
    </main>

    <div class="overlay overlay--center" id="no-address">
        <div class="overlay__panel city-modal no-address-modal">
            <div class="city-modal__head">
                <h2 class="city-modal__title">Внимание</h2>
                <a class="overlay__close" href="#main" aria-label="Закрыть предупреждение">
                    <span class="cross" aria-hidden="true"></span>
                </a>
            </div>

            <div class="no-address-modal__text">
                <p>За заказ без адреса взимается фиксированная оплата, она будет включена в сумму заказа.</p>
                <p>Заказ может быть отменен, если адрес доставки будет за пределами зоны доставки.</p>
            </div>

            <button class="btn btn--primary no-address-modal__accept" type="button" data-accept-no-address>
                Принимаю
            </button>
        </div>
    </div>

    <!-- Интервалы доставки: тот же источник, что в старом дизайне
         (order.blade.php) — сервер вшивает их в страницу, скрипт время
         никуда не запрашивает. minDate = сегодня только если на сегодня
         есть интервалы, иначе завтра. Лейаут объявляет window['cvetofor']
         ниже по странице, поэтому данные вшиваем на DOMContentLoaded -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            window['cvetofor'].config.flatpickr.minDate = "{{ $deliveryStart->format('d.m.Y') }}";
            window['cvetofor'].config.flatpickr.minDateTimeStamp = new Date("{{ $deliveryToday->format('m/d/Y') }}");
            window['cvetofor'].config.flatpickr.times = @json($deliveryTimes['times']);
            window['cvetofor'].config.flatpickr.todayTimes = @json($deliveryTimes['todayTimes']);
            window['cvetofor'].config.flatpickr.dates = @json($deliveryTimes['dates']);
        });
    </script>

    <!-- Всплывашка изменения стоимости доставки (аналог delivery-show-summ
         старого дизайна). Оверлей — прямой ребёнок body: инерт-логика app.js
         исключает его из затемнения фона. Открывается хешем #delivery-summ -->
    <div class="overlay overlay--center" id="delivery-summ">
        <div class="overlay__panel">
            <a class="overlay__close" href="#main" aria-label="Закрыть">
                <span class="cross" aria-hidden="true"></span>
            </a>
            <h2 class="overlay__title">Внимание!</h2>
            <p class="overlay__text">Стоимость доставки —
                <span data-delivery-modal-price></span> ₽ — рассчитана по выбранному интервалу доставки.</p>
            <p class="overlay__text" data-delivery-modal-free hidden>При покупке от
                <span data-delivery-modal-free-sum></span> ₽ доставка по вашему адресу будет бесплатно.</p>
            <a class="btn btn--primary overlay__apply" href="#main">Понятно</a>
        </div>
    </div>

@endsection
