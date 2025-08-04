@extends('layouts.app')
@inject('citiesService', \App\Services\CitiesService::class)
@php
    $cart_has_limited_categories = false;
    $cart_has_limited_tags = false;
    $maxStartDate = null;
    $minEndDate = null;
@endphp

@section('content')
    <div class="heading">
        <div class="container">
            <div class="heading__row">
                <div class="breadcrumbs">
                <span class="breadcrumbs__item">
                    <a href="/">
                        <span>Главная</span>
                    </a>
                </span>
                    <span class="breadcrumbs__item">
                    <span>Оформление заказа</span>
                </span>
                </div>
                <div class="title-page">
                    <h1 class="h1">Оформление заказа</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="page">
        <div class="main-cols__wrap">
            <div class="container">
                <div class="main-col">
                    <div class="order-checkout" data-form-wrapper="order-checkout" data-form="order-checkout">
                        <form class="form invalid" data-validate-form="" data-form-body="" method="POST" action="{{ route('order.create') }}" autocomplete="off">
                            <div class="section order-checkout__main">
                                <div class="box">
                                    <div class="order-checkout__heading">
                                        <div class="toggle-buttons__wrap" data-toggle-fields="address">
                                            <div class="toggle-button active" data-show-fields="data-show-fields" data-know-address="true">Я знаю адрес</div>
                                            <div class="toggle-button" data-hide-fields="data-hide-fields" data-dont-know-address="true" data-modal-open="delivery-no-address">Я не знаю адрес</div>
                                        </div>
                                        <div class="order-checkout__infotext hidden" data-fields-info="data-fields-info">
                                            <p>Курьер предварительно свяжется с получателем чтобы узнать адрес доставки</p>
                                        </div>
                                    </div>
                                    <div class="fields fields--gap-20-30" data-fields="address">
                                        <div class="inputholder inputholder--width-three-quarters form__inputholder">
                                            <label class="inputholder__label" data-default-label="data-default-label"><span class="required-label"> Адрес (город, улица, № дома) </span></label>
                                            <input class="inputholder__input" type="text" name="address"

                                                   @auth
                                                       @if(isset(optional(auth()->user()->orders()->first())->address['address'] ))
                                                           placeholder="{{ optional(auth()->user()->orders()->first())->address['address'] }}"
                                                   @else
                                                       placeholder="{{ $citiesService::getCity()->province->name ?? '' }} {{ $citiesService::getCity()->province->type ?? '' }}, {{ $citiesService::getCity()->city ?? '' }}, Улица, № Дома"
                                                   @endif
                                                   @else
                                                       placeholder="{{ $citiesService::getCity()->province->name ?? '' }} {{ $citiesService::getCity()->province->type ?? '' }}, {{ $citiesService::getCity()->city ?? '' }}, Улица, № Дома"
                                                   @endauth

                                                   data-default-address="{{ $citiesService::getCity()->province->name ?? '' }} {{ $citiesService::getCity()->province->type ?? '' }}, {{ $citiesService::getCity()->city ?? '' }}"
                                                   data-required="" data-text-error="address" id="delivery-address" data-delivery-address="data-delivery-address" />
                                            <div class="suggest-dropdown" data-suggest-dropdown="data-suggest-dropdown">

                                            </div>
                                        </div>
                                        <div class="inputholder inputholder--width-quarter form__inputholder">
                                            <label class="inputholder__label" data-default-label="data-default-label">Номер квартиры</label>
                                            <input class="inputholder__input" name="apartament_number" type="text" data-mask-number="4" inputmode="text" placeholder="89">
                                        </div>
                                    </div>
                                    <script src="//api-maps.yandex.ru/2.1/?{{ config('app.yandex_api') }}&lang=ru_RU"></script>
                                    <div class="fields fields--gap-20-30">
                                        <div class="inputholder inputholder--width-three-quarters form__inputholder">
                                            <label class="inputholder__label" data-default-label="data-default-label"> <span class="required-label">ФИО получателя</span></label>
                                            <input class="inputholder__input" name="person_receiving_name" type="text" placeholder="ФИО" data-required=""
                                                   id="person-receiving-name"
                                                   @auth
                                                       value="{{ optional(auth()->user()->orders()->first())->person_receiving_name }}"
                                                @endauth />
                                        </div>
                                        <div class="inputholder inputholder--width-quarter form__inputholder">
                                            <label class="inputholder__label" data-default-label="data-default-label"> <span class="required-label">Телефон</span></label>
                                            <input class="inputholder__input" name="person_receiving_phone" type="tel" placeholder="+7 (___) ___ __-__"
                                                   data-required="" data-mask-tel="" data-text-error="phone"
                                                   id="person-receiving-phone"
                                                   @auth
                                                       value="{{ optional(auth()->user()->orders()->first())->person_receiving_phone }}"
                                                   @endauth id="phone4" />
                                        </div>
                                        <div class="date-time-row">
                                            <div class="inputholder form__inputholder" id="date-holder" style="flex: 0 0 220px;">
                                                <label class="inputholder__label" data-default-label="data-default-label"><span class="required-label">Дата</span></label>
                                                <input class="inputholder__input" name="delivery_date" type="text" data-datepicker="data-datepicker" data-required=""
                                                       data-text-error="date" />
                                            </div>
                                            <div class="inputholder form__inputholder" style="flex: 1 1 0;">
                                                <label class="inputholder__label" data-default-label="data-default-label"><span class="required-label">Время доставки</span></label>
                                                <div class="select" data-select="" data-close-on-select="true">
                                                    <div class="select__active" data-select-btn="" data-select-default="" data-name="delivery_time">
                                                    <span class="select__text">
                                                        <span data-select-changing="">
                                                        </span>
                                                    </span>
                                                    </div>
                                                    <div class="select__drop" data-select-list="">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="fields fields--checkbox">
                                        @if(TwillAppSettings::get('public.public.photo_is_visible') ?? false)
                                            <span class="checkbox">
                                        <input type="checkbox" name="is_photo_needle" id="photoreport"
                                               @auth
                                                   @if(optional(auth()->user()->orders()->first())->is_photo_needle)
                                                       checked="checked"
                                        @endif
                                            @endauth
                                        />
                                        <label class="checkbox__title" for="photoreport">Фотоотчет</label>
                                        <div class="tippy-toggler" data-tippy="data-tippy" data-tippy-placement="top-start"
                                             data-tippy-content="{{ TwillAppSettings::get('public.public.order_photo_desc') }}"
                                             data-tippy-trigger="">
                                            <svg>
                                                <use href="#icon-tooltip">

                                                </use>
                                            </svg>
                                        </div>
                                    </span>
                                        @endif
                                        @if(TwillAppSettings::get('public.public.anon_is_visible') ?? false)
                                            <span class="checkbox">
                                        <input type="checkbox" name="is_anon" id="anonymity"
                                               @auth
                                                   @if(optional(auth()->user()->orders()->first())->is_anon)
                                                       checked="checked"
                                        @endif
                                            @endauth
                                        />
                                        <label class="checkbox__title" for="anonymity">Доставить анонимно</label>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="fields">
                                    <span class="checkbox">
                                        <input type="checkbox" name="postcard" id="postcard" data-price="{{ $postcard_price }}" data-toggle-postcard="data-toggle-postcard" />
                                        <label class="checkbox__title" for="postcard">Открытка с текстом</label>
                                        <div class="tippy-toggler" data-tippy="data-tippy" data-tippy-placement="top-start"
                                             data-tippy-content="{{ TwillAppSettings::get('public.public.order_postcart_text_desc') }}"
                                             data-tippy-trigger="">
                                            <svg>
                                                <use href="#icon-tooltip">

                                                </use>
                                            </svg>
                                        </div>
                                    </span>
                                        <div class="inputholder form__inputholder">
                                            <label class="inputholder__label" data-default-label="data-default-label">Текст для открытки</label>
                                            <textarea name="postcard_text" class="inputholder__textarea inputholder__textarea--readonly" maxlength="140" placeholder="Введите текст" data-required=""
                                                      data-text-error="postcard" readonly="readonly" data-no-validate="data-no-validate" data-postcard="data-postcard"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="section">
                                <h2>Контакты заказчика</h2>
                                <div class="box">
                                    <div class="fields fields--gap-20-30 fields--margin-bottom-40">
                                        <div class="inputholder form__inputholder">
                                            <label class="inputholder__label" data-default-label="data-default-label">Комментарий к заказу</label>
                                            <textarea class="inputholder__textarea" name="comment" placeholder="Текст комментария" maxlength="200"></textarea>
                                        </div>
                                    </div>
                                    <div class="fields fields--checkbox">
                                    <span class="checkbox">
                                        <input type="checkbox" id="same-person-checkbox" />
                                        <label class="checkbox__title" for="same-person-checkbox">Заказчик и получатель одно лицо</label>
                                    </span>
                                    </div>
                                    <div class="fields fields--gap-20-30">
                                        <div class="inputholder form__inputholder">
                                            <label class="inputholder__label" data-default-label="data-default-label"><span class="required-label"> ФИО заказчика</span></label>
                                            <input
                                                id="customer-name"
                                                name="fio"
                                                @auth value="{{ auth()->user()->last_name }} {{ auth()->user()->name }} {{ auth()->user()->second_name }}" @endauth
                                                class="inputholder__input" type="text" placeholder="ФИО" data-required="" />
                                        </div>
                                        <div class="inputholder inputholder--width-half form__inputholder">
                                            <label class="inputholder__label" data-default-label="data-default-label">Email</label>
                                            <input name="email2" @auth value="{{ auth()->user()->email }}" @endauth class="inputholder__input" type="email"
                                                   placeholder="email@email.ru" data-email="" />
                                        </div>
                                        <div class="inputholder inputholder--width-half form__inputholder">
                                            <label class="inputholder__label" data-default-label="data-default-label"><span class="required-label">Телефон заказчика</span></label>
                                            <input id="customer-phone" name="phone" @auth value="{{ auth()->user()->phone }}" @endauth class="inputholder__input" type="tel"
                                                   placeholder="+7 (___) ___ __-__" data-required="" data-mask-tel="" data-text-error="phone" id="phone" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Копия side-col для мобильной версии -->
                            <div class="side-col-mobile" style="display: none;">
                                <div class="section" data-sticky-element="130" data-sticky-unset="1198">
                                    <div class="box box--no-margin">
                                        <div class="cart__summary">
                                            <div class="cart__summary-heading">
                                                <span class="cart__summary-title">Ваш заказ</span>
                                                <span class="cart__summary-count">Позиций: {{ $cart->count() }} шт</span>
                                            </div>
                                            <div class="cart__summary-items__wrap">
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

                                                    <div class="cart__summary-item">
                                                        <span>{{ $item->name }} @if ($item->quantity > 1) {{ $item->quantity }} @endif</span>
                                                        <span>@money($item->getPriceSumWithConditions()) р.</span>
                                                    </div>

                                                    @if ($isCategoryLimited || $isTagLimited)
                                                        <div class="cart__delivery-limited-info">
                                                            Этот букет доступен для доставки только с {{ $limitStartDate }} по {{ $limitEndDate }}.
                                                        </div>
                                                    @endif
                                                @endforeach
                                                @if ($totalDeliveryPrice)
                                                    <div class="cart__summary-item">
                                                        <span>Доставка</span>
                                                        <span data-delivery-price="true">@money($totalDeliveryPrice) р.</span>
                                                    </div>
                                                @else
                                                    <div class="cart__summary-item">
                                                        <span>Доставка</span>
                                                        <span data-delivery-price="true">0 р.</span>
                                                    </div>
                                                @endif

                                                @if (\Cart::getSubTotalWithoutConditions() !== \Cart::getTotal())
                                                    <div class="cart__summary-item"><span>Скидка</span><span class="negative">-
                                                    {{ abs(\Cart::getSubTotalWithoutConditions() - \Cart::getTotal()) }} р.</span></div>
                                                @endif

                                            </div>
                                            <div class="cart__summary-bottom"> 
                                                @if(!(session('uds_points_used') && session('uds_old_total') && session('uds_new_total')))
                                                    <div class="cart__summary-heading"> 
                                                        <div class="uds-promo-label-wrap">
                                                            <label class="inputholder__label" data-default-label="data-default-label">Введите код из UDS</label>
                                                            <div class="tippy-toggler" data-tippy="data-tippy" data-tippy-placement="top-start" data-tippy-content='Ваш код скидки пишется под вашим QR-кодом, набор из 6 цифр.<br><br>Получите 500 рублей на первую покупку, переходите по ссылке <a href="https://opt03.uds.app/c" target="_blank" rel="noopener" style="color:#ca4592">opt03.uds.app/c</a>' data-tippy-allowHTML="true" data-tippy-trigger="">
                                                                <svg>
                                                                    <use href="#icon-tooltip">
                                                                    </use>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <input class="inputholder__input" name="uds_promo" type="text" data-mask-number="6" inputmode="numberic" placeholder="123456">
                                                        <div class="buttonholder" data-form-trigger="">
                                                            <button type="submit" class="form__button button button--green submit-button" data-form-button="" style="width: 100%;">
                                                            <span>Проверить баллы</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if(session('uds_points_used') && session('uds_old_total') && session('uds_new_total'))
                                                    <span class="cart__summary-total" data-total="{{ session('uds_new_total') }}">
                                                        <button type="button" class="button button--purple uds-reset-bonuses" style="margin-bottom:10px;display:block;width:100%;">Отменить списание бонусов</button>
                                                        <span>Итого: <span style="text-decoration:line-through;color:#888;">@money(session('uds_old_total')) р.</span> &rarr; <span style="color:#71be38;font-weight:bold;">@money(session('uds_new_total')) р.</span></span>
                                                    </span>
                                                @else
                                                    <span class="cart__summary-total" data-total="{{ (\Cart::getTotal() + $totalDeliveryPrice) }}">Итого: @money(\Cart::getTotal() + $totalDeliveryPrice) р.</span>
                                                @endif
                                                @if (\Cart::getSubTotalWithoutConditions() !== \Cart::getTotal())
                                                    <span class="cart__summary-no-discount">Без скидки: @money(\Cart::getSubTotalWithoutConditions() + $totalDeliveryPrice) р.</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                            <div class="section">
                                <h2>Способ оплаты</h2>
                                <div class="box">
                                    <div class="payment__items-wrap">
                                        @foreach ($payments as $payment)
                                            <label class="payment__item">
                                                <input type="radio" @if($payment->code === 'account') data-account="true" @endif name="payment_id" @if($loop->first) checked="checked" @endif value="{{ $payment->id }}" />
                                                <div class="payment__item-image__wrap">
                                                    <img class="payment__item-image" src="{{ $payment->image('logo') }}" alt="" />
                                                </div>
                                                <span class="payment__item-title">{{ $payment->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="section">
                                <div class="form__buttonholder">
                                    <div class="buttonholder" data-form-trigger="">
                                        <button type="submit" class="form__button button button--green submit-button" disabled="" data-form-button="">
                                        <span>Оплатить
                                            заказ</span>
                                        </button>
                                    </div>
                                    <span class="form__policy policy">Я принимаю и соглашаюсь на обработку <a class="policy__link" href="/policy">персональных
                                        данных</a>.<br /> Соглашаюсь, что цветы - уникальный товар, который может отличаться по
                                    форме, размеру и оттенку от товара на выбранном фото.</span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="side-col" data-sticky="data-sticky">
                    <div class="section" data-sticky-element="130" data-sticky-unset="1198">
                        <div class="box box--no-margin">
                            <div class="cart__summary">
                                <div class="cart__summary-heading">
                                    <span class="cart__summary-title">Ваш заказ</span>
                                    <span class="cart__summary-count">Позиций: {{ $cart->count() }} шт</span>
                                </div>
                                <div class="cart__summary-items__wrap">
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

                                        <div class="cart__summary-item">
                                            <span>{{ $item->name }} @if ($item->quantity > 1) {{ $item->quantity }} @endif</span>
                                            <span>@money($item->getPriceSumWithConditions()) р.</span>
                                        </div>

                                        @if ($isCategoryLimited || $isTagLimited)
                                            <div class="cart__delivery-limited-info">
                                                Этот букет доступен для доставки только с {{ $limitStartDate }} по {{ $limitEndDate }}.
                                            </div>
                                        @endif
                                    @endforeach
                                    @if ($totalDeliveryPrice)
                                        <div class="cart__summary-item">
                                            <span>Доставка</span>
                                            <span data-delivery-price="true">@money($totalDeliveryPrice) р.</span>
                                        </div>
                                    @else
                                        <div class="cart__summary-item">
                                            <span>Доставка</span>
                                            <span data-delivery-price="true">0 р.</span>
                                        </div>
                                    @endif

                                    @if (\Cart::getSubTotalWithoutConditions() !== \Cart::getTotal())
                                        <div class="cart__summary-item"><span>Скидка</span><span class="negative">-
                                        {{ abs(\Cart::getSubTotalWithoutConditions() - \Cart::getTotal()) }} р.</span></div>
                                    @endif

                                </div>
                                <div class="cart__summary-bottom"> 
                                    @if(!(session('uds_points_used') && session('uds_old_total') && session('uds_new_total')))
                                        <div class="cart__summary-heading"> 
                                            <div class="uds-promo-label-wrap">
                                                <label class="inputholder__label" data-default-label="data-default-label">Введите код из UDS</label>
                                                <div class="tippy-toggler" data-tippy="data-tippy" data-tippy-placement="top-start" data-tippy-content='Ваш код скидки пишется под вашим QR-кодом, набор из 6 цифр.<br><br>Получите 500 рублей на первую покупку, переходите по ссылке <a href="https://opt03.uds.app/c" target="_blank" rel="noopener" style="color:#ca4592">opt03.uds.app/c</a>' data-tippy-allowHTML="true" data-tippy-trigger="">
                                                    <svg>
                                                        <use href="#icon-tooltip">
                                                        </use>
                                                    </svg>
                                                </div>
                                            </div>
                                            <input class="inputholder__input" name="uds_promo" type="text" data-mask-number="6" inputmode="numberic" placeholder="123456">
                                            <div class="buttonholder" data-form-trigger="">
                                                <button type="submit" class="form__button button button--green submit-button" data-form-button="" style="width: 100%;">
                                                <span>Проверить баллы</span>
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                    @if(session('uds_points_used') && session('uds_old_total') && session('uds_new_total'))
                                        <span class="cart__summary-total" data-total="{{ session('uds_new_total') }}">
                                            <button type="button" class="button button--purple uds-reset-bonuses" style="margin-bottom:10px;display:block;width:100%;">Отменить списание бонусов</button>
                                            <span>Итого: <span style="text-decoration:line-through;color:#888;">@money(session('uds_old_total')) р.</span> &rarr; <span style="color:#71be38;font-weight:bold;">@money(session('uds_new_total')) р.</span></span>
                                        </span>
                                    @else
                                        <span class="cart__summary-total" data-total="{{ (\Cart::getTotal() + $totalDeliveryPrice) }}">Итого: @money(\Cart::getTotal() + $totalDeliveryPrice) р.</span>
                                    @endif
                                    @if (\Cart::getSubTotalWithoutConditions() !== \Cart::getTotal())
                                        <span class="cart__summary-no-discount">Без скидки: @money(\Cart::getSubTotalWithoutConditions() + $totalDeliveryPrice) р.</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
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
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#phone').inputmask("+7 (999) 999 99-99");
        });

        $(document).ready(function() {
            $('#phone4').inputmask("+7 (999) 999 99-99");
        });
    </script>
@endsection



@push('scripts')
    <script>
        $(document).ready(function() {
            const addressInput = $('#delivery-address');

            addressInput.on('focus', function() {
                const defaultAddress = $(this).data('default-address');

                if (!$(this).val()) {
                    $(this).val(defaultAddress);
                }
            });
        });

        document.addEventListener("DOMContentLoaded", function () {
            const samePersonCheckbox = document.getElementById("same-person-checkbox");
            const personReceivingName = document.getElementById("person-receiving-name");
            const personReceivingPhone = document.getElementById("person-receiving-phone");
            const customerName = document.getElementById("customer-name");
            const customerPhone = document.getElementById("customer-phone");



            samePersonCheckbox.addEventListener("change", function () {
                if (this.checked) {
                    customerName.value = personReceivingName.value ;
                    customerPhone.value = personReceivingPhone.value;
                }
            });


            personReceivingName.addEventListener("input", function () {
                if (samePersonCheckbox.checked) {
                    customerName.value = this.value;
                }
            });

            personReceivingPhone.addEventListener("input", function () {
                if (samePersonCheckbox.checked) {
                    customerPhone.value = this.value;
                }
            });
        });

        @if ($cart_has_limited_categories || $cart_has_limited_tags)

        @php
            $currentDate = \App\Services\CitiesService::DateTime();
        @endphp

        @if ($maxStartDate && $maxStartDate->gt($currentDate))
        window['cvetofor'].config.flatpickr.minDate = "{{ $maxStartDate->format('d-m-Y') }}";
        @else
        window['cvetofor'].config.flatpickr.minDate = "{{ $currentDate->format('d-m-Y') }}";
        @endif

        @if ($minEndDate)
        window['cvetofor'].config.flatpickr.maxDate = "{{ $minEndDate->format('d-m-Y') }}";
        @endif

    @else

            window['cvetofor'].config.flatpickr.minDate = "{{ \App\Services\CitiesService::DateTime()->format('d-m-Y') }}";

    @endif

        window['cvetofor'].config.flatpickr.minDateTimeStamp = new Date('{{ \App\Services\CitiesService::DateTime()->format('m / d / Y ') }}');
 window['cvetofor'].config.flatpickr.times = {!!json_encode($deliveryTimes['times']) !!};
        window['cvetofor'].config.flatpickr.todayTimes = {!!json_encode($deliveryTimes['todayTimes']) !!};

        // UDS AJAX check
        const udsInput = $('input[name="uds_promo"]');
        const udsButton = udsInput.closest('.cart__summary-heading').find('button[data-form-button]');
        // Добавим контейнер для вывода результата, если его нет
        if (!udsInput.next('.uds-check-result').length) {
            udsInput.after('<div class="uds-check-result" style="margin-top:8px;font-size:0.95em;"></div>');
        }
        const udsResult = udsInput.next('.uds-check-result');

        function renderUdsActions(points, promo) {
            const spendButton = points > 0 ? `<button type="button" class="button button--green uds-spend" data-promo="${promo}" data-points="${points}">Списать</button>` : '';
            const buttonClass = points > 0 ? '' : 'button--full-width';
            
            return `
                <div class="uds-action-buttons">
                    ${spendButton}
                    <button type="button" class="button button--purple ${buttonClass} uds-hoard" data-promo="${promo}" data-points="${points}">Копить</button>
                </div>
            `;
        }

        // Проверяем количество баллов
        udsButton.on('click', function(e) {
            e.preventDefault();
            udsResult.text('');
            const promo = udsInput.val().trim();
 
            udsButton.prop('disabled', true).text('Проверяем...');
            $.ajax({
                url: '/uds/check',
                method: 'POST',
                data: {
                    uds_promo: promo,
                    total: $('.cart__summary-total').attr('data-total'),
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(resp) {
                    if (resp.success) {
                        udsResult.html('<span style="color:#71be38;">Доступно баллов: ' + resp.points + '</span>' + renderUdsActions(resp.points, promo));
                    } else {
                        udsResult.html('<span style="color:red;">' + (resp.message || 'Ошибка проверки') + '</span>');
                    }
                },
                error: function() {
                    udsResult.html('<span style="color:red;">Ошибка соединения с сервером</span>');
                },
                complete: function() {
                    udsButton.prop('disabled', false).text('Проверить баллы');
                }
            });
        });

        // Обработчик для кнопки "Списать"
        udsResult.on('click', '.uds-spend', function() {
            const promo = $(this).data('promo');
            const points = $(this).data('points');
            const btn = $(this);
            // Получаем старую сумму из data-total
            const oldTotal = $('.cart__summary-total').data('total');
            btn.prop('disabled', true).text('Списываем...');
            $.ajax({
                url: '/uds/create',
                method: 'POST',
                data: {
                    uds_promo: promo,
                    points: points,
                    old_total: oldTotal,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(resp) {
                    if (resp.success) {
                        udsResult.html('<span style="color:#71be38;">' + (resp.message || 'Баллы списаны!') + '</span>');
                        // Мгновенно обновляем блок "Итого"
                        const totalBlock = $('.cart__summary-total');
                        if (totalBlock.length && resp.oldTotal !== undefined && resp.newTotal !== undefined) {
                            totalBlock.html('<button type="button" class="button button--purple uds-reset-bonuses" style="margin-bottom:10px;display:block;width:100%;">Отменить списание бонусов</button>' +
                                '<span>Итого: <span style="text-decoration:line-through;color:#888;">' +
                                new Intl.NumberFormat('ru-RU').format(resp.oldTotal) + ' р.</span> &rarr; <span style="color:#71be38;font-weight:bold;">' +
                                new Intl.NumberFormat('ru-RU').format(resp.newTotal) + ' р.</span></span>'
                            );
                            totalBlock.attr('data-total', resp.newTotal);
                        }
                        // Скрываем промо-блок
                        udsInput.closest('.cart__summary-heading').hide();
                    } else {
                        udsResult.html('<span style="color:red;">' + (resp.message || 'Ошибка списания') + '</span>');
                    }
                },
                error: function() {
                    udsResult.html('<span style="color:red;">Ошибка соединения с сервером</span>');
                }
            });
        });

        // Обработчик для кнопки "Копить"
        udsResult.on('click', '.uds-hoard', function() {
            const promo = $(this).data('promo');
            const btn = $(this);
            btn.prop('disabled', true).text('Отправляем...');
            $.ajax({
                url: '/uds/reward',
                method: 'POST',
                data: {
                    uds_promo: promo,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(resp) {
                    if (resp.success) {
                        udsResult.html('<span style="color:green;">' + (resp.message || 'Баллы будут накоплены!') + '</span>');
                    } else {
                        udsResult.html('<span style="color:red;">' + (resp.message || 'Ошибка накопления') + '</span>');
                    }
                },
                error: function() {
                    udsResult.html('<span style="color:red;">Ошибка соединения с сервером</span>');
                }
            });
        });

        // Кнопка отмены списания бонусов
        $(document).on('click', '.uds-reset-bonuses', function() {
            const btn = $(this);
            btn.prop('disabled', true).text('Отмена...');
            $.ajax({
                url: '/uds/reset',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(resp) {
                    // Возвращаем блок "Итого" к обычному виду без перезагрузки
                    const totalBlock = $('.cart__summary-total');
                    if (totalBlock.length && resp.total !== undefined) {
                        totalBlock.html('Итого: ' + new Intl.NumberFormat('ru-RU').format(resp.total) + ' р.');
                        totalBlock.attr('data-total', resp.total);
                    }
                    // Показываем промо-блок обратно (отрисовываем его заново)
                    if ($('.cart__summary-heading').length === 0) {
                        totalBlock.before('<div class="cart__summary-heading">\
                            <label class="inputholder__label" data-default-label="data-default-label">Введите код из UDS (в разработке)</label>\
                            <input class="inputholder__input" name="uds_promo" type="text" data-mask-number="6" inputmode="numberic" placeholder="123456">\
                            <div class="buttonholder" data-form-trigger="">\
                                <button type="submit" class="form__button button button--green submit-button" data-form-button="" style="width: 100%;">\
                                <span>Проверить баллы</span>\
                                </button>\
                            </div>\
                        </div>');
                    } else {
                        $('.cart__summary-heading').show();
                        $('.cart__summary-heading input[name=\'uds_promo\']').val('');
                        $('.uds-check-result').hide()
                    }
                    // Убираем кнопку отмены
                    btn.remove();
                },
                error: function() {
                    btn.prop('disabled', false).text('Отменить списание бонусов');
                    alert('Ошибка соединения с сервером');
                }
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        .cart__delivery-limited-info{
            font-size: 0.775rem;
        }
        .required-label::after {
            content: "(обязательно)";
            font-size: 0.8em;
            color: #999;
            margin-left: 5px;
            white-space: nowrap;
        }
        .cart__summary .buttonholder {
            width: 100%;
            padding: 0; /* если есть лишние отступы */
        }
        .cart__summary .buttonholder .button {
            width: 100%;
            display: block;
        }
        .uds-check-result {
            width: 100%;
            display: block;
            margin-top: 10px;
        }
        .uds-action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 10px;
            width: 100%;
        }
        .uds-action-buttons button {
            flex: 1 1 0;
            width: 100%;
            min-width: 0;
            box-sizing: border-box;
        }
       .uds-promo-label-wrap {
           display: flex;
           align-items: center;
           gap: 6px;
       }
               .uds-promo-label-wrap .inputholder__label,
        .uds-promo-label-wrap .tippy-toggler {
            margin: 0;
        }
        
        /* Фиксированная высота для элементов даты и времени */
        .date-time-row {
            display: flex;
            gap: 30px;
            align-items: flex-end;
        }
        
        .date-time-row .inputholder__input {
            min-height: 43.5px;
            box-sizing: border-box;
        }
        
        .date-time-row .select__active {
            min-height: 43.5px;
            display: flex;
            align-items: center;
            box-sizing: border-box;
        }
       
        /* Мобильная версия - переупорядочивание элементов */
        @media (max-width: 768px) {
            .date-time-row{
                flex-direction: column;
            }
            
            .date-time-row .inputholder {
                flex: none !important;
                width: 100% !important;
            }
 
            .main-cols__wrap .container {
                display: flex;
                flex-direction: column;
            }
            
            /* Скрываем оригинальный side-col на мобильных */
            .main-cols__wrap .side-col {
                display: none;
            }
            
            /* Показываем копию side-col для мобильных */
            .side-col-mobile {
                display: block !important;
                margin-top: 50px;
            }
        }
   </style>
@endpush