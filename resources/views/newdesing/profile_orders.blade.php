@extends('newdesing.app')

@section('css')
    <link rel="stylesheet" href="/template/css/build/page-profile.css?v=20260930">
@endsection

@section('content')

    <main id="main">

        <!-- ================================================== Шапка ==== -->
        <div class="container profile-head">
            <nav class="profile-head__crumbs" aria-label="Хлебные крошки">
                <a class="profile-head__crumb" href="/">Главная</a>
                <span aria-hidden="true"> / </span>
                <a class="profile-head__crumb" href="{{ route('profile.index') }}">Личный кабинет</a>
                <span aria-hidden="true"> / </span>
                <span aria-current="page">История заказов</span>
            </nav>
            <h1 class="profile-head__title">История заказов</h1>
        </div>

        <!-- ============================================== Список заказов ==== -->
        <div class="section container profile">
            @include('newdesing.parts.profile-menu')

            <div class="profile__content">
                @if ($orders->isEmpty())
                    <div class="panel profile-empty">
                        <img class="profile-empty__icon" src="/template/assets/icons/bouquet-of-flowers.svg"
                             alt="" width="80" height="80">
                        <p class="profile-empty__title">Здесь появятся ваши заказы</p>
                        <p class="profile-empty__note">
                            Вы ещё ничего не заказывали. Выберите букет — и он отобразится в этой истории
                        </p>
                        <a class="btn btn--primary profile-empty__link" href="/catalog">Перейти в каталог</a>
                    </div>
                @else
                    @foreach ($orders as $order)
                        @php
                            // Статусы и условия кнопки «Оплатить» — без изменений из
                            // старой profile/orders.blade.php: отменённым и оплаченным
                            // платить не предлагаем, только онлайн-платёжам
                            $isCanceled = $order->orderStatus?->code === \App\Models\OrderStatus::CANCELED_USER
                                || $order->orderStatus?->code === \App\Models\OrderStatus::CANCELED;
                            $isComplete = $order->orderStatus?->code === \App\Models\OrderStatus::COMPLETE;
                            $statusClass = $isCanceled ? 'canceled' : ($isComplete ? 'completed' : 'in-work');
                            $statusIcon = $isCanceled ? 'cross.svg' : ($isComplete ? 'checkmark.svg' : 'time.svg');
                            $canPay = $order?->paymentStatus?->code === \App\Models\PaymentStatus::AWAIT
                                && ! $isCanceled
                                && in_array($order?->payment?->code, [\App\Models\Payment::ROBOKASSA, \App\Models\Payment::YOOKASSA]);
                        @endphp

                        <article class="panel order-card">
                            <div class="order-card__head">
                                <h2 class="order-card__title">Заказ №{{ $order->id }} от {{ $order->created_at->format('d.m.Y') }}</h2>
                                <p class="order-card__status order-card__status--{{ $statusClass }}">
                                    <img src="/template/assets/icons/{{ $statusIcon }}" alt="" width="16" height="16">
                                    {{ $order->orderStatus?->title }}
                                </p>
                            </div>

                            {{-- Состав заказа из cart-атрибута (JSON): формула цены
                                 со скидкой как в старой вьюхе --}}
                            <ul class="order-card__items">
                                @foreach ($order->cart as $cartItem)
                                    @php
                                        $conditionals = \array_sum(array_values($cartItem['conditions']));
                                    @endphp
                                    <li class="order-card__item">
                                        <span>{{ $cartItem['quantity'] }} × {{ $cartItem['name'] }}</span>
                                        <span>@money(($cartItem['price'] - $conditionals) * $cartItem['quantity']) р.</span>
                                    </li>
                                @endforeach
                                <li class="order-card__item order-card__item--delivery">
                                    <span>Доставка</span>
                                    <span>@money($order->delivery->price ?? 0) р.</span>
                                </li>
                            </ul>

                            <div class="order-card__footer">
                                <dl class="order-card__info">
                                    <div class="order-card__row">
                                        <dt>Получатель:</dt>
                                        <dd>{{ $order->person_receiving_name }}</dd>
                                    </div>
                                    <div class="order-card__row order-card__row--sum">
                                        <dt>Итого:</dt>
                                        <dd>@money($order->total_price) р.</dd>
                                    </div>
                                </dl>

                                <div class="order-card__actions">
                                    @if ($canPay)
                                        <a class="btn btn--primary order-card__pay"
                                           href="{{ route('order.pay', ['order' => $order->uuid]) }}"
                                           target="_blank" rel="noopener">Оплатить</a>
                                    @endif

                                    {{-- Открывает оверлей #leave-review общим механизмом
                                         (блок №3), номер заказа и сохранённый отзыв
                                         подставляет блок в app.js --}}
                                    <a class="btn btn--outline order-card__review" href="#leave-review"
                                       data-review-order="{{ $order->id }}"
                                       data-review-text="{{ optional($order->review)->description }}">
                                        Отзыв
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach

                    {{-- Обычная ссылка на следующую страницу, как в старом дизайне:
                         сервер отдаёт полную страницу, AJAX-догрузка профиля
                         не переносилась --}}
                    @if ($orders->hasMorePages())
                        <a class="btn btn--outline profile__more" href="{{ $orders->nextPageUrl() }}">Показать ещё</a>
                    @endif
                @endif
            </div>
        </div>
    </main>

    <!-- ================================================ Отзыв к заказу ==== -->
    {{-- Состав из старой модалки components/modals.blade.php. Оверлей стоит
         в конце контента страницы после </main> — как #no-address и
         #delivery-summ в чекауте; инерт-логика его корректно исключает
         (см. §2 NEWDESIGN.md). Форма отправляется блоком app.js: роут
         profile.review отвечает JSON --}}
    <div class="overlay overlay--center" id="leave-review">
        <div class="overlay__panel city-modal review-modal">
            <div class="city-modal__head">
                <h2 class="city-modal__title" id="leave-review-title">Отзыв о заказе</h2>
                <a class="overlay__close" href="#main" aria-label="Закрыть окно отзыва">
                    <span class="cross" aria-hidden="true"></span>
                </a>
            </div>

            <form class="review-modal__form" data-review-form
                  action="{{ route('profile.review') }}" method="POST">
                @csrf
                {{-- Заполняется скриптом при открытии по data-review-order --}}
                <input type="hidden" name="order_id" value="">

                <div class="ffield">
                    <label class="ffield__label" for="review-description">
                        Ваш отзыв <span class="req" aria-hidden="true">*</span>
                    </label>
                    <textarea class="ffield__input ffield__input--area" id="review-description"
                              name="description" rows="4" maxlength="1000" required
                              placeholder="Расскажите, всё ли вам понравилось"></textarea>
                </div>

                <button class="btn btn--primary review-modal__submit" type="submit">Отправить</button>
                <p class="review-modal__policy">Нажимая на кнопку, вы соглашаетесь на
                    <a href="/policy">обработку персональных данных</a>
                </p>
            </form>
        </div>
    </div>
@endsection
