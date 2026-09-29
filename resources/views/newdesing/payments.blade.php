@extends('newdesing.app')
@inject('citiesService', \App\Services\CitiesService::class)

@section('css')<link rel="stylesheet" href="/template/css/build/page-payment.css?v=20260918">@endsection
@section('content')

    <main id="main">

        <!-- =================================================== Banner ==== -->
        <section class="page-banner page-banner--overlay container" aria-labelledby="page-title">
            <img class="page-banner__photo" src="/template/assets/img/pay-banner.jpg" alt=""
                 width="629" height="360">
            <span class="page-banner__glow" aria-hidden="true"></span>

            <div class="page-banner__body">
                <nav class="page-banner__crumbs" aria-label="Хлебные крошки">
                    <a class="page-banner__crumb" href="index.html">Главная</a>
                    <span aria-hidden="true"> / </span>
                    <span aria-current="page">Оплата и доставка</span>
                </nav>

                <h1 class="page-banner__title" id="page-title">Способы оплаты</h1>
                <p class="page-banner__note">
                    Выберите удобный для вас способ оплаты. Безопасно, быстро и без комиссий.
                </p>
            </div>
        </section>

        <!-- ================================================== Способы ==== -->
        <!-- Обёртка только для отступов: заголовка у блока в макете нет,
             карточки несут h2 сами -->
        <div class="section container">
            <div class="methods">
                <section class="method" aria-labelledby="method-1">
          <span class="method__icon">
            <img src="/template/assets/icons/adv-card.svg" alt="" width="50" height="50">
          </span>
                    <h2 class="method__title" id="method-1">Банковской картой на сайте</h2>
                    <p class="method__text">Visa, Mastercard, МИР и другие банковские карты. Оплата происходит через защищённый платёжный шлюз.</p>
                </section>

                <section class="method" aria-labelledby="method-2">
          <span class="method__icon method__icon--full">
            <img src="/template/assets/icons/sbp-mark.svg" alt="" width="80" height="80">
          </span>
                    <h2 class="method__title" id="method-2">СБП — быстрый платёж</h2>
                    <p class="method__text">Оплата через Систему Быстрых Платежей по QR-коду или в мобильном приложении вашего банка.</p>
                </section>

                <section class="method" aria-labelledby="method-3">
          <span class="method__icon">
            <img src="/template/assets/icons/wallet-money.svg" alt="" width="46" height="44">
          </span>
                    <h2 class="method__title" id="method-3">Наличными или картой курьеру</h2>
                    <p class="method__text">Оплата наличными или картой при получении заказа курьеру. Доступно для заказов по Улан-Удэ.</p>
                </section>

                <section class="method" aria-labelledby="method-4">
          <span class="method__icon">
            <img src="/template/assets/icons/bank.svg" alt="" width="45" height="45">
          </span>
                    <h2 class="method__title" id="method-4">Безналичный расчёт для юр. лиц</h2>
                    <p class="method__text">Выставим счёт на оплату для организаций и ИП. Работаем с НДС и без НДС.</p>
                </section>
            </div>

            <dl class="features">
                <div class="feature">
                    <dt class="feature__key">
            <span class="feature__icon">
              <img src="/template/assets/icons/adv-secure.svg" alt="" width="52" height="67">
            </span>
                        Безопасность
                    </dt>
                    <dd class="feature__val">Все платежи защищены и соответствуют стандартам безопасности PCI DSS</dd>
                </div>
                <div class="feature">
                    <dt class="feature__key">
            <span class="feature__icon">
              <img src="/template/assets/icons/app-sale.svg" alt="" width="46" height="46">
            </span>
                        Без комиссий
                    </dt>
                    <dd class="feature__val">Мы не берём дополнительных комиссий за оплату любым способом.</dd>
                </div>
                <div class="feature">
                    <dt class="feature__key">
            <span class="feature__icon">
              <img src="/template/assets/icons/clock.svg" alt="" width="40" height="40">
            </span>
                        Быстрое подтверждение
                    </dt>
                    <dd class="feature__val">Оплата за заказ моментально подтверждается.</dd>
                </div>
                <div class="feature">
                    <dt class="feature__key">
            <span class="feature__icon">
              <img src="/template/assets/icons/support.svg" alt="" width="80" height="80">
            </span>
                        Поддержка
                    </dt>
                    <dd class="feature__val">Если у вас возникли вопросы по оплате — мы всегда на связи.</dd>
                </div>
            </dl>
        </div>

        <!-- ============================================== Важно знать ==== -->
        <section class="section container" aria-labelledby="faq-title">
            <h2 class="section__title" id="faq-title">Важно знать</h2>

            <ul class="faq">
                <li class="faq__item">
                    <details class="faq__row" id="faq-payment-time">
                        <summary class="faq__link">
                            Когда списывается оплата?
                            <span class="chevron" aria-hidden="true"></span>
                        </summary>
                        <p class="faq__answer">Сразу после подтверждения платежа — оно приходит за несколько секунд. При оплате курьеру деньги списываются при получении заказа.</p>
                    </details>
                </li>
                <li class="faq__item">
                    <details class="faq__row" id="faq-payment-cancel">
                        <summary class="faq__link">
                            Можно ли отменить заказ после оплаты?
                            <span class="chevron" aria-hidden="true"></span>
                        </summary>
                        <p class="faq__answer">Да, пока букет не передан курьеру. Позвоните нам — вернём полную сумму тем же способом, каким вы платили.</p>
                    </details>
                </li>
                <li class="faq__item">
                    <details class="faq__row" id="faq-payment-receipt">
                        <summary class="faq__link">
                            Электронный чек
                            <span class="chevron" aria-hidden="true"></span>
                        </summary>
                        <p class="faq__answer">Чек приходит на почту сразу после оплаты. Если его нет, проверьте папку «Спам» или запросите его у нас.</p>
                    </details>
                </li>
            </ul>
        </section>

        <!-- ================================================== Помощь ==== -->
        <section class="section container" aria-labelledby="help-title">
            <!-- Фото идёт последним: в мобильном макете оно под текстом,
                 на десктопе сетка ставит его в первую колонку -->
            <div class="help">
                <h2 class="help__title" id="help-title">Нужна помощь с оплатой?</h2>
                <p class="help__text">
                    Мы с радостью ответим на ваши вопросы и поможем оформить заказ.
                </p>
                <div class="help__actions">
                    <a class="btn btn--primary help__cta" href="contacts.html">Связаться с нами</a>
                    <p class="help__note">или позвоните по телефону</p>
                    <p class="help__phone"><a href="tel:+78007009375">8 (800) 700-93-75</a></p>
                </div>
                <img class="help__photo" src="/template/assets/img/pay-help.webp" alt=""
                     width="344" height="233" loading="lazy">
            </div>
        </section>
    </main>

@endsection
