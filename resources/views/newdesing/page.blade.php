@extends('newdesing.app')
@inject('citiesService', \App\Services\CitiesService::class)

@section('content')

    <main id="main">

        <!-- =================================================== Banner ==== -->
        <section class="page-banner page-banner--overlay container" aria-labelledby="page-title">
            <img class="page-banner__photo" src="/template/assets/img/about-banner.jpg" alt=""
                 width="908" height="495">

            <div class="page-banner__body">
                <nav class="page-banner__crumbs" aria-label="Хлебные крошки">
                    <a class="page-banner__crumb" href="index.html">Главная</a>
                    <span aria-hidden="true"> / </span>
                    <span aria-current="page">О нас</span>
                </nav>

                <h1 class="page-banner__title" id="page-title">О нас</h1>
                <p class="page-banner__lead">Добро пожаловать в «ЦВЕТОФОР»</p>
                <p class="page-banner__note">
                    Мы создаём букеты и композиции, которые говорят о чувствах лучше любых слов
                </p>
            </div>
        </section>

        <!-- ================================================ О компании ==== -->
        <!-- Обёртка только для отступов: своего заголовка у блока в макете нет,
             а придумывать его, чтобы спрятать в visually-hidden, незачем —
             карточки сами несут h2 -->
        <div class="section container">
            <div class="abouts">
                <section class="about-card" aria-labelledby="mission-title">
          <span class="about-card__icon">
            <img src="/template/assets/icons/target.svg" alt="" width="50" height="50">
          </span>
                    <h2 class="about-card__title" id="mission-title">Наша миссия</h2>
                    <p class="about-card__text">Мы считаем, что цветы — это язык,
                        который говорит о любви, уважении, радости и сострадании.</p>
                    <p class="about-card__text">Наша миссия — помочь вам передать эти
                        чувства и сделать каждый день особенным.</p>
                    <img class="about-card__decor about-card__decor--mission" src="/template/assets/img/about-mission.webp"
                         alt="" aria-hidden="true" width="216" height="186" loading="lazy">
                </section>

                <section class="about-card" aria-labelledby="values-title">
          <span class="about-card__icon">
            <img src="/template/assets/icons/diamond.svg" alt="" width="50" height="50">
          </span>
                    <h2 class="about-card__title" id="values-title">Наши ценности</h2>
                    <ul class="values">
                        <li class="values__item">
                            <img src="/template/assets/icons/heart-brand.svg" alt="" width="18" height="18">
                            Качество и свежесть
                        </li>
                        <li class="values__item">
                            <img src="/template/assets/icons/heart-brand.svg" alt="" width="18" height="18">
                            Индивидуальный подход
                        </li>
                        <li class="values__item">
                            <img src="/template/assets/icons/heart-brand.svg" alt="" width="18" height="18">
                            Честность и открытость
                        </li>
                        <li class="values__item">
                            <img src="/template/assets/icons/heart-brand.svg" alt="" width="18" height="18">
                            Любовь к своему делу
                        </li>
                    </ul>
                    <img class="about-card__decor about-card__decor--values" src="/template/assets/img/about-values.webp"
                         alt="" aria-hidden="true" width="321" height="233" loading="lazy">
                </section>

                <section class="about-card" aria-labelledby="team-title">
          <span class="about-card__icon">
            <img src="/template/assets/icons/team.svg" alt="" width="40" height="40">
          </span>
                    <h2 class="about-card__title" id="team-title">Наша команда</h2>
                    <p class="about-card__text">Это профессионалы, влюблённые в мир
                        цветов. Мы тщательно подбираем каждый букет, чтобы он радовал
                        наших клиентов.</p>
                    <span class="about-card__circle" aria-hidden="true"></span>
                    <img class="about-card__decor about-card__decor--team" src="/template/assets/img/about-team.webp"
                         alt="" aria-hidden="true" width="561" height="306" loading="lazy">
                </section>
            </div>

            <ul class="stats">
                <li class="stat">
          <span class="stat__icon stat__icon--tilt">
            <img src="/template/assets/icons/bouquet-of-flowers.svg" alt="" width="50" height="50">
          </span>
                    <p class="stat__val">12 000+</p>
                    <p class="stat__key">Доставленных букетов</p>
                </li>
                <li class="stat">
          <span class="stat__icon">
            <img src="/template/assets/icons/happy-face.svg" alt="" width="50" height="50">
          </span>
                    <p class="stat__val">7200+</p>
                    <p class="stat__key">Довольных клиентов</p>
                </li>
                <li class="stat">
          <span class="stat__icon">
            <img src="/template/assets/icons/flower.svg" alt="" width="50" height="50">
          </span>
                    <p class="stat__val">200+</p>
                    <p class="stat__key">Видов цветов</p>
                </li>
            </ul>
        </div>

        <!-- =================================================== Услуги ==== -->
        <section class="section container" aria-labelledby="services-title">
            <h2 class="section__title" id="services-title">Наши услуги</h2>

            <ul class="services">
                <li class="service">
                    <img class="service__marker" src="/template/assets/icons/heart-brand.svg" alt=""
                         width="18" height="18">
                    <div class="service__body">
                        <h3 class="service__title">Онлайн-заказ букетов и композиций.</h3>
                        <p class="service__text">Мы предлагаем огромный выбор букетов и композиций на любой случай. Вы легко можете выбрать и заказать цветы на нашем сайте.</p>
                    </div>
                </li>
                <li class="service">
                    <img class="service__marker" src="/template/assets/icons/heart-brand.svg" alt=""
                         width="18" height="18">
                    <div class="service__body">
                        <h3 class="service__title">Доставка цветов.</h3>
                        <p class="service__text">Мы доставляем цветы вовремя и бережно, чтобы вы могли наслаждаться красотой цветов сразу после получения.</p>
                    </div>
                </li>
                <li class="service">
                    <img class="service__marker" src="/template/assets/icons/heart-brand.svg" alt=""
                         width="18" height="18">
                    <div class="service__body">
                        <h3 class="service__title">Подписка на цветы.</h3>
                        <p class="service__text">Мы предлагаем подписку на регулярную доставку цветов, что позволит вам наслаждаться свежими цветами в течение всего года.</p>
                    </div>
                </li>
                <li class="service">
                    <img class="service__marker" src="/template/assets/icons/heart-brand.svg" alt=""
                         width="18" height="18">
                    <div class="service__body">
                        <h3 class="service__title">Цветочные аксессуары и подарки.</h3>
                        <p class="service__text">Помимо букетов, у нас есть широкий выбор цветочных аксессуаров и подарков, которые помогут удивить и порадовать близких.</p>
                    </div>
                </li>
                <li class="service">
                    <img class="service__marker" src="/template/assets/icons/heart-brand.svg" alt=""
                         width="18" height="18">
                    <div class="service__body">
                        <h3 class="service__title">Индивидуальный заказ.</h3>
                        <p class="service__text">Наши флористы готовы помочь вам создать уникальные композиции и букеты, учитывая ваши индивидуальные пожелания.</p>
                    </div>
                </li>
                <li class="service">
                    <img class="service__marker" src="/template/assets/icons/heart-brand.svg" alt=""
                         width="18" height="18">
                    <div class="service__body">
                        <h3 class="service__title">Специальные и корпоративные мероприятия.</h3>
                        <p class="service__text">Мы готовы предоставить вам цветы для особых мероприятий, свадеб, корпоративов и других важных моментов.</p>
                    </div>
                </li>
            </ul>
        </section>

        <!-- =================================================== Отзывы ==== -->
        <section class="section container" aria-labelledby="reviews-title">
            <div class="section__head">
                <h2 class="section__title" id="reviews-title">Отзывы клиентов</h2>
                <!-- Шеврон смотрит вправо (176:866 — 13x20), а не вниз -->
                <a class="more-link" href="/reviews">
                    Смотреть больше
                    <span class="chevron chevron--forward" aria-hidden="true"></span>
                </a>
            </div>

            <ul class="reviews">
                <li>
                    <figure class="review">
                        <figcaption class="review__head">
              <span class="review__who">
                <span class="review__avatar" aria-hidden="true">М</span>
                <span class="review__meta">
                  <span class="review__name">Мари</span>
                  <time class="review__date" datetime="2025-08-19">19 августа 2025</time>
                </span>
              </span>
                            <span class="rating">
                <span class="visually-hidden">Оценка: 5 из 5</span>
                <img src="/template/assets/icons/heart-rating.svg" alt="" width="10" height="10">
                <img src="/template/assets/icons/heart-rating.svg" alt="" width="10" height="10">
                <img src="/template/assets/icons/heart-rating.svg" alt="" width="10" height="10">
                <img src="/template/assets/icons/heart-rating.svg" alt="" width="10" height="10">
                <img src="/template/assets/icons/heart-rating.svg" alt="" width="10" height="10">
              </span>
                        </figcaption>
                        <blockquote class="review__text">Заказываю каждый год с другого города бабушке и маме букеты, цветы всегда свежие красивые 🌹 глаз не отвести)) упаковка стильная и необычная 👍 доставка всегда во время 👌 спасибо за подаренное хорошее настроение 🌸</blockquote>
                    </figure>
                </li>
                <li>
                    <figure class="review">
                        <figcaption class="review__head">
              <span class="review__who">
                <span class="review__avatar" aria-hidden="true">М</span>
                <span class="review__meta">
                  <span class="review__name">Мари</span>
                  <time class="review__date" datetime="2025-08-19">19 августа 2025</time>
                </span>
              </span>
                            <span class="rating">
                <span class="visually-hidden">Оценка: 5 из 5</span>
                <img src="/template/assets/icons/heart-rating.svg" alt="" width="10" height="10">
                <img src="/template/assets/icons/heart-rating.svg" alt="" width="10" height="10">
                <img src="/template/assets/icons/heart-rating.svg" alt="" width="10" height="10">
                <img src="/template/assets/icons/heart-rating.svg" alt="" width="10" height="10">
                <img src="/template/assets/icons/heart-rating.svg" alt="" width="10" height="10">
              </span>
                        </figcaption>
                        <blockquote class="review__text">Заказываю каждый год с другого города бабушке и маме букеты, цветы всегда свежие красивые 🌹 глаз не отвести)) упаковка стильная и необычная 👍 доставка всегда во время 👌 спасибо за подаренное хорошее настроение 🌸</blockquote>
                    </figure>
                </li>
                <li>
                    <figure class="review">
                        <figcaption class="review__head">
              <span class="review__who">
                <span class="review__avatar" aria-hidden="true">М</span>
                <span class="review__meta">
                  <span class="review__name">Мари</span>
                  <time class="review__date" datetime="2025-08-19">19 августа 2025</time>
                </span>
              </span>
                            <span class="rating">
                <span class="visually-hidden">Оценка: 5 из 5</span>
                <img src="/template/assets/icons/heart-rating.svg" alt="" width="10" height="10">
                <img src="/template/assets/icons/heart-rating.svg" alt="" width="10" height="10">
                <img src="/template/assets/icons/heart-rating.svg" alt="" width="10" height="10">
                <img src="/template/assets/icons/heart-rating.svg" alt="" width="10" height="10">
                <img src="/template/assets/icons/heart-rating.svg" alt="" width="10" height="10">
              </span>
                        </figcaption>
                        <blockquote class="review__text">Заказываю каждый год с другого города бабушке и маме букеты, цветы всегда свежие красивые 🌹 глаз не отвести)) упаковка стильная и необычная 👍 доставка всегда во время 👌 спасибо за подаренное хорошее настроение 🌸</blockquote>
                    </figure>
                </li>
            </ul>
        </section>
    </main>
@endsection
