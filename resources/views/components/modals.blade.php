@inject('citiesService', \App\Services\CitiesService::class)
@inject('catalogService', App\Services\CatalogService::class)

@php
$categories = $catalogService->getPublishedCategories();
$additionalCategories = \App\Models\Category::published()
                                                ->where('is_additional_product', 1)
                                                ->where('is_visible_catalog', 1)
                                                ->get();
# Получаем старые значения платежных реквизитов
$oldOrderAccount = auth('web')->check()
? auth('web')
->user()
->orders()
->whereHas('payment', fn($e) => $e->where('code', \App\Models\Payment::ACCOUNT))
->first()
: null;

$oldLegalAccount = null;
if ($oldOrderAccount) {
$oldLegalAccount = $oldOrderAccount->legalAccount;
}

@endphp

<div class="overlay" data-overlay="" id="overlay">

</div>



<div class="modal" data-modal="rate-checkout" data-form-wrapper="rate-checkout" data-form="rate-checkout">
    <div class="modal__container">
        <form class="form invalid" data-validate-form="" data-form-body="">
            <div class="modal__heading">
                <div class="modal__title">
                    <span>Нам очень важно ваше мнение!</span>
                </div>
                <div class="modal__close" data-modal-close="">

                </div>
            </div>
            <div class="modal__text">
                <p>Оцените удобство оформления заказа</p>
            </div>
            <div class="form__buttonholder" data-form-trigger="">
                <button class="button button--red button--full-width like-button">
                    <svg class="button__icon">
                        <use href="#icon-dislike">

                        </use>
                    </svg>
                </button>
                <button class="button button--green button--full-width dislike-button">
                    <svg class="button__icon">
                        <use href="#icon-like">

                        </use>
                    </svg>
                </button>
            </div>
        </form>
        <div class="modal__thanks" data-form-thanks="">
            <div class="modal__heading">
                <div class="modal__title">
                    <span>Спасибо за вашу оценку!</span>
                </div>
                <div class="modal__close" data-modal-close="">

                </div>
            </div>
            <div class="modal__text">
                <p>Для нас очень важно ваше мнение - это помогает в развитии сервиса.</p>
            </div>
            <a class="button button--green button--full-width return-to-mainpage-button" href="/">На главную</a>
        </div>
    </div>
</div>


{{-- Готовые --}}
<div class="modal" data-modal="invoice-payment" data-form-wrapper="invoice-payment" data-form="invoice-payment">
    <div class="modal__heading">
        <div class="modal__title">
            <span>Оплата с помощью счёта</span>
        </div>
        <div class="modal__close" data-modal-close="">

        </div>
    </div>
    <div class="modal__container">
        <form class="form invalid" data-validate-form="" data-form-body="">
            <div class="fields">
                <div class="inputholder form__inputholder">
                    <label class="inputholder__label" data-default-label="data-default-label">Наименование
                        компании</label>
                    <input class="inputholder__input" type="text" name="recipient"
                        placeholder="ИП Иванов Иван Иванович" data-required=""
                        value="{{ optional($oldLegalAccount)->title }}" />
                </div>
                <div class="inputholder form__inputholder">
                    <label class="inputholder__label" data-default-label="data-default-label">Юридический адрес</label>
                    <input class="inputholder__input" type="text" name="address" placeholder="Юридический адрес"
                        data-required="" value="{{ optional($oldLegalAccount)->address }}" />
                </div>
                <div class="inputholder inputholder--width-half form__inputholder">
                    <label class="inputholder__label" data-default-label="data-default-label">Расчётный счёт</label>
                    <input class="inputholder__input" type="text" name="recipient_account"
                        placeholder="40178100000000000000" data-length="20" data-required="" data-mask-number="20"
                        data-text-error="beneficiaryAccount"
                        value="{{ optional($oldLegalAccount)->recipient_account }}" />
                </div>
                <div class="inputholder inputholder--width-half form__inputholder">
                    <label class="inputholder__label" data-default-label="data-default-label">БИК</label>
                    <input class="inputholder__input" type="text" name="bik" placeholder="000000000"
                        data-length="9" data-required="" data-mask-number="9" data-text-error="bik"
                        value="{{ optional($oldLegalAccount)->bik }}" />
                </div>
                <div class="inputholder form__inputholder">
                    <label class="inputholder__label" data-default-label="data-default-label">Наименование банка</label>
                    <input class="inputholder__input" type="text" name="bank" placeholder="Банк ВТБ (ПАО)"
                        data-required="" value="{{ optional($oldLegalAccount)->bank }}" />
                </div>
                <div class="inputholder form__inputholder">
                    <label class="inputholder__label" data-default-label="data-default-label">Корреспондентский
                        счет</label>
                    <input class="inputholder__input" type="text" name="correspondent_account"
                        placeholder="30101000000000000000" data-length="20" data-required="" data-mask-number="20"
                        data-text-error="correspondentAccount"
                        value="{{ optional($oldLegalAccount)->correspondent_account }}" />
                </div>
                <div class="inputholder inputholder--width-half form__inputholder">
                    <label class="inputholder__label" data-default-label="data-default-label">ИНН</label>
                    <input class="inputholder__input" type="text" name="inn" placeholder="0000000000"
                        data-length="10" data-required="" data-mask-number="10" data-text-error="inn" />
                </div>
            </div>
            <div class="form__buttonholder">
                <div class="button button--purple button--full-width" data-modal-close="">
                    <span>Отменить</span>
                </div>
                <div class="buttonholder" data-form-trigger="">
                    <button class="form__button button button--green button--full-width pay-button"
                        onclick="Order(); return false;" disabled="" data-form-button="">
                        <span>Выставить счёт</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal" data-modal="leave-review" data-form-wrapper="leave-review" data-form="leave-review">
    <div class="modal__container">
        <form class="form invalid" method="POST" action="{{ route('profile.review') }}" data-validate-form=""
            data-form-body="">
            <input type="hidden" name="order_id">
            <div class="modal__heading">
                <div class="modal__title">
                    <span>Отзыв о заказе</span>
                </div>
                <div class="modal__close" data-modal-close="">

                </div>
            </div>
            <div class="fields">
                <div class="inputholder form__inputholder">
                    <textarea class="inputholder__textarea" data-required="" data-text-error="review" name="description">

                    </textarea>
                </div>
            </div>
            <div class="form__buttonholder">
                <div class="buttonholder" data-form-trigger="">
                    <button class="form__button button button--green submit-button" disabled=""
                        data-form-button="">
                        <span>Отправить</span>
                    </button>
                </div>
                <span class="form__policy policy">Нажимая на кнопку, вы соглашаетесь на <a class="policy__link"
                        href="/policy">обработку персональных
                        данных</a>
                </span>
            </div>
        </form>
        <div class="modal__thanks" data-form-thanks="">
            <div class="modal__heading">
                <div class="modal__title">
                    <span>Спасибо за ваш отзыв!</span>
                </div>
                <div class="modal__close" data-modal-close="">

                </div>
            </div>
            <div class="modal__text">
                <p>Для нас очень важно ваше мнение - это помогает в развитии сервиса.</p>
            </div>
            <div class="button button--green button--full-width close-button" onclick="modal.close('leave-review')">
                Закрыть</div>
        </div>
    </div>
</div>
<div class="modal" data-modal="delivery-area">
    <div class="modal__heading">
        <div class="modal__title">
            <span>Адрес находится вне зоны доставки</span>
        </div>
        <div class="modal__close" data-modal-close="">

        </div>
    </div>
    <div class="modal__container">
        <div class="modal__text">
            <p>Продавец 1 не осуществляет доставку по выбранному адресу. Попробуйте выбрать другой адрес.</p>
        </div>
        <div class="buttons__wrap">
            <a class="button button--purple button--full-width return-to-cart-button"
                href="{{ route('cart.index') }}">Вернуться в корзину</a>
            <button class="button button--green button--full-width change-address-button" data-modal-close="">Изменить
                адрес</button>
        </div>
    </div>
</div>

<div class="modal" data-modal="city" id="modal__cities">
    <div class="modal__heading">
        <div class="modal__title">
            <span>Выбор города</span>
        </div>
        <div class="modal__close" data-modal-close="" id="modal__cities_close">

        </div>
    </div>
    <div class="modal__container">
        <form class="modal__city-search" data-modal-city-search="data-modal-city-search">
            <div class="inputholder form__inputholder">
                <input class="inputholder__input" type="text" placeholder="Введите ваш город*" data-required=""
                    data-modal-city-input="data-modal-city-input" />
                <button class="reset-btn" type="reset">
                    <svg>
                        <use href="#icon-cross">

                        </use>
                    </svg>
                </button>
            </div>
            <div class="modal__city-dropdown" data-modal-city-tip="data-modal-city-tip">
                <div class="modal__city-dropdown__content">

                </div>
            </div>
        </form>
        <ul class="modal__cities-list" data-modal-cities-wrappet="">
            @foreach ($citiesService::getActiveCities() as $city)
            <li class="modal__cities-list__item" data-city-id="{{ $city->id }}">{{ $city->city }}</li>
            @endforeach
        </ul>
    </div>
</div>

<div class="modal" data-modal="catalog">
    <div class="container">
        <div class="modal__heading">
            <div class="modal__title">
                <span>Каталог</span>
            </div>
            <div class="modal__close" data-modal-close="">

            </div>
        </div>
        <div class="modal__container">
            <div class="modal__category">
                <div class="modal__category-heading" data-category-open="data-category-open">
                    <div class="modal__category-title">По цене</div>
                    <svg class="arrow">
                        <use href="#icon-arrow-menu">

                        </use>
                    </svg>
                </div>
                <div class="modal__category-list__wrap" data-category="data-category">
                    <div class="modal__category-list__heading">
                        <div class="modal__category-return" data-category-close="data-category-close">
                            <div class="arrow-return">
                                <svg>
                                    <use href="#icon-arrow-return">

                                    </use>
                                </svg>
                            </div>
                            <span class="modal__category-return__title">По цене</span>
                        </div>
                        <div class="modal__category-close modal__close" data-modal-close="">

                        </div>
                    </div>
                    <ul class="modal__category-list">
                        @foreach($menuPrices as $menuPrice)
                            @if($menuPrice->price_start==0)
                                <li class="modal__category-list__item">
                                    <a class="modal__category-list__link"
                                       href="{{ route('catalog.index') }}?price[to]={{$menuPrice->price_end}}">до
                                        {{$menuPrice->price_end}}</a>
                                </li>

                            @elseif($menuPrice->price_end==0)

                                <li class="modal__category-list__item">
                                    <a class="modal__category-list__link"
                                       href="{{ route('catalog.index') }}?price[from]={{$menuPrice->price_start}}">от
                                        {{$menuPrice->price_start}}</a>
                                </li>
                                @else
                                <li class="modal__category-list__item">
                                    <a class="modal__category-list__link"
                                       href="{{ route('catalog.index') }}?price[from]={{$menuPrice->price_start}}&price[to]={{$menuPrice->price_end}}">{{$menuPrice->price_start}} —
                                        {{$menuPrice->price_end}}</a>
                                </li>
                            @endif
                        @endforeach

                    </ul>
                </div>
            </div>
            <div class="modal__category">
                <div class="modal__category-heading" data-category-open="data-category-open">
                    <div class="modal__category-title">По цветам</div>
                    <svg class="arrow">
                        <use href="#icon-arrow-menu">

                        </use>
                    </svg>
                </div>
                <div class="modal__category-list__wrap" data-category="data-category">
                    <div class="modal__category-list__heading">
                        <div class="modal__category-return" data-category-close="data-category-close">
                            <div class="arrow-return">
                                <svg>
                                    <use href="#icon-arrow-return">

                                    </use>
                                </svg>
                            </div>
                            <span class="modal__category-return__title">По цветам</span>
                        </div>
                        <div class="modal__category-close modal__close" data-modal-close="">

                        </div>
                    </div>
                    <ul class="modal__category-list">
                        @foreach ($menuFlovers as $menuItem)


                        <li class="modal__category-list__item">
                            <a class="modal__category-list__link"
                                href="{{ route('catalog.search') }}?product={{ urlencode($menuItem->title) }}">{{$menuItem->title }}</a>
                        </li>

                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="modal__category">
                <div class="modal__category-heading" data-category-open="data-category-open">
                    <div class="modal__category-title">По категориям</div>
                    <svg class="arrow">
                        <use href="#icon-arrow-menu">

                        </use>
                    </svg>
                </div>
                <div class="modal__category-list__wrap" data-category="data-category">
                    <div class="modal__category-list__heading">
                        <div class="modal__category-return" data-category-close="data-category-close">
                            <div class="arrow-return">
                                <svg>
                                    <use href="#icon-arrow-return">

                                    </use>
                                </svg>
                            </div>
                            <span class="modal__category-return__title">По категориям</span>
                        </div>
                        <div class="modal__category-close modal__close" data-modal-close="">

                        </div>
                    </div>
                    <ul class="modal__category-list">
                        <li class="modal__category-list__item">
                            <a class="modal__category-list__link"
                                href="{{ route('catalog.index') }}">{{ __('Все букеты') }}</a>
                        </li>
                        @foreach ($categories as $category)
                        <li class="modal__category-list__item">
                            <a class="modal__category-list__link"
                                href="{{ route('catalog.category', ['slug' => $category->nestedSlug]) }}">{{ $category->title }}</a>
                        </li>
                        @endforeach

                    </ul>
                </div>
            </div>
            @if ($groupProductTags)
            <div class="modal__category">
                <div class="modal__category-heading" data-category-open="data-category-open">
                    <div class="modal__category-title">Повод / кому</div>
                    <svg class="arrow">
                        <use href="#icon-arrow-menu">

                        </use>
                    </svg>
                </div>
                <div class="modal__category-list__wrap" data-category="data-category">
                    <div class="modal__category-list__heading">
                        <div class="modal__category-return" data-category-close="data-category-close">
                            <div class="arrow-return">
                                <svg>
                                    <use href="#icon-arrow-return">

                                    </use>
                                </svg>
                            </div>
                            <span class="modal__category-return__title">Повод / кому</span>
                        </div>
                        <div class="modal__category-close modal__close" data-modal-close="">

                        </div>
                    </div>
                    <ul class="modal__category-list">
                        @foreach ($groupProductTags as $tag)
                        <li class="modal__category-list__item">
                            <a class="modal__category-list__link"
                                href="{{ route('catalog.tags', ['tag' => $tag['slug']]) }}">{{ $tag['name'] }}</a>
                        </li>
                        @endforeach

                    </ul>
                </div>
            </div>
            @endif
            @if ($additionalCategories->count() > 0)
                <div class="modal__category">
                    <div class="modal__category-heading" data-category-open="data-category-open">
                        <div class="modal__category-title">Дополнительные товары</div>
                        <svg class="arrow">
                            <use href="#icon-arrow-menu">

                            </use>
                        </svg>
                    </div>
                    <div class="modal__category-list__wrap" data-category="data-category">
                        <div class="modal__category-list__heading">
                            <div class="modal__category-return" data-category-close="data-category-close">
                                <div class="arrow-return">
                                    <svg>
                                        <use href="#icon-arrow-return">

                                        </use>
                                    </svg>
                                </div>
                                <span class="modal__category-return__title">Дополнительные товары</span>
                            </div>
                            <div class="modal__category-close modal__close" data-modal-close="">

                            </div>
                        </div>
                        <ul class="modal__category-list">
                            @foreach ($additionalCategories as $category)
                            @php
                                $categorySlug = \App\Models\Slugs\CategorySlug::where('category_id', $category->id)
                                    ->where('locale', 'ru')
                                    ->where('active', true)
                                    ->first();
                            @endphp
                            <li class="modal__category-list__item">
                                @if ($categorySlug)
                                <a class="modal__category-list__link"
                                    href="{{ route('catalog.additional', ['slug' => $categorySlug->slug]) }}">{{ $category->title }}</a>
                                @else
                                <span class="modal__category-list__link">{{ $category->title }}</span>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>


<div class="modal" data-modal="login" data-form-wrapper="login" data-form="login">
    <div class="modal__heading">
        <div class="modal__title">
            <span>Вход</span>
        </div>
        <div class="modal__close" data-modal-close="">

        </div>
    </div>
    <div class="modal__container">
        <form class="form invalid" data-validate-form="" data-form-body="" method="GET"
            action="{{ route('profile.authenticate') }}">
            @csrf
            <div class="fields">
                <div class="inputholder form__inputholder">
                    <label class="inputholder__label" data-default-label="data-default-label">Телефон</label>
                    <input class="inputholder__input" type="phone" placeholder="+7 (___) ___ __-__" name="phone" id="phone1" required data-required="" />
                </div>

                <div class="inputholder form__inputholder">
                    <label class="inputholder__label" data-default-label="data-default-label">Пароль</label>
                    <input class="inputholder__input" type="password" name="password" required
                        autocomplete="current-password" placeholder="·············" data-required=""
                        data-text-error="password" />
                    <div class="link-button forgot-password-button" data-modal-open="password-recovery">Забыли пароль?
                    </div>
                </div>
                <label class="checkbox">
                    <input type="checkbox" name="remember" autocomplete="email" autofocus
                        {{ old('remember') ? 'checked' : '' }}>
                    <span class="checkbox__title">Запомнить</span>
                </label>
            </div>
            <div class="form__buttonholder">
                <div class="buttonholder" data-form-trigger="">
                    <button class="form__button button button--green button--full-width" disabled=""
                        data-form-button="">
                        <span>Войти</span>
                    </button>
                </div>
                <div class="button button--purple button--full-width" data-modal-open="registration">
                    <span>Зарегистрироваться</span>
                </div>
            </div>
            <span class="form__policy policy">Нажимая на кнопку, вы соглашаетесь на <a class="policy__link"
                    href="/policy">обработку персональных
                    данных</a>
            </span>
        </form>
    </div>
</div>

<div class="modal" data-modal="registration" data-ajax="true" data-form-wrapper="registration"
    data-form="registration">
    <div class="modal__heading">
        <div class="modal__title">
            <span>Регистрация</span>
        </div>
        <div class="modal__close" data-modal-close="">

        </div>
    </div>
    <div class="modal__container">
        <form class="form invalid" data-validate-form="" data-form-body="" method="POST"
            action="{{ route('register') }}">
            @csrf
            <div class="fields">
                <div class="inputholder form__inputholder">
                    <label class="inputholder__label" data-default-label="data-default-label">Телефон</label>
                    <input class="inputholder__input" value="{{ old('phone') }}" name="phone" type="tel" id="phone2" placeholder="+7 (___) ___ __-__" data-required="" data-mask-tel=""
                        data-text-error="phone" />
                </div>
            </div>
            <div class="form__buttonholder" data-form-trigger="">
                <button class="form__button button button--green button--full-width get-code-button" disabled=""
                    data-form-button="">
                    <span>Зарегистрироваться</span>
                </button>
            </div>
            <label class="checkbox">
                <input type="checkbox" name="concent_exclusive_email" />
                <span class="checkbox__title">Получать эксклюзивные предложения и акции</span>
            </label>
            <span class="form__policy policy">Нажимая на кнопку, вы соглашаетесь на <a class="policy__link"
                    href="/policy">обработку персональных
                    данных</a>
            </span>
            <div class="link-button link-button--center login-button" data-modal-open="login">Войти по номеру
                телефона</div>
        </form>
    </div>
</div>

<div class="modal" data-modal="password-recovery" data-form-wrapper="password-recovery" data-form="password-recovery">
    <div class="modal__heading">
        <div class="modal__title">
            <span>Восстановление пароля</span>
        </div>
        <div class="modal__close" data-modal-close="">

        </div>
    </div>
    <div class="modal__container">
        <form class="form invalid" data-validate-form="" data-form-body="" method="GET" action="{{ route('profile.resetPassword') }}">
            @csrf
            <div class="fields">
                <div class="inputholder form__inputholder">
                    <label class="inputholder__label" data-default-label="data-default-label">Телефон</label>
                    <input class="inputholder__input" value="{{ old('phone') }}" name="phone" type="tel" id="phone3" placeholder="+7 (___) ___ __-__" data-required="" data-mask-tel=""
                        data-text-error="phone" />
                </div>
            </div>
            <div class="form__buttonholder" data-form-trigger="">
                <button class="form__button button button--green button--full-width submit-button" disabled=""
                    data-form-button="">
                    <span>Отправить</span>
                </button>
            </div>
            <span class="form__policy policy">Нажимая на кнопку, вы соглашаетесь на <a class="policy__link"
                    href="/policy">обработку персональных
                    данных</a>
            </span>
            <div class="link-button link-button--center login-button" data-modal-open="login">Войти по номеру телефона</div>
        </form>
    </div>
</div>

<div class="modal" data-modal="password-recovery-success" data-form-wrapper="password-recovery"
    data-form="password-recovery">
    <div class="modal__heading">
        <div class="modal__title">
            <span>Новый пароль отправлен вам в СМС.</span>
        </div>
        <div class="modal__close" data-modal-close="">

        </div>
    </div>
</div>


<div class="modal" data-modal="cart-region">
    <div class="modal__heading">
        <div class="modal__title">
            <span>В корзине есть товар другого региона</span>
        </div>
        <div class="modal__close" data-modal-close="">

        </div>
    </div>
    <div class="modal__container">
        <div class="modal__text">
            <p>Выбор товара из другого региона обнуляет корзину.</p>
        </div>
        <div class="buttons__wrap">
            <div class="button button--red button--full-width confirm-button" data-clear-cart="">Заменить корзину
            </div>
            <button class="button button--green button--full-width cancel-button" data-modal-close="">Отмена</button>
        </div>
    </div>
</div>

<div class="modal" data-modal="notification-added-to-cart">
    <div class="modal__container">
        <div class="modal__image-wrap">
            <img class="modal__image" src="/dist/img/image-content/product-pic.jpg" alt="" />
        </div>
        <div class="modal__content">
            <div class="modal__title">
                <span>Добавлено в корзину</span>
            </div>
            <div class="modal__text">
                <p>В корзину была добавлена 1 позиция</p>
            </div>
        </div>
    </div>
</div>

<div class="modal" data-modal="notification-not-available">
    <div class="modal__container">
        <div class="modal__heading">
            <div class="modal__title"><span>Товара нет в наличии</span></div>
            <div class="modal__close" data-modal-close=""></div>
        </div>
        <div class="modal__content">
            <div class="modal__text">
                <p>Один из товаров в вашей корзине закончился. Перед оформлением заказа удалите его из корзины</p>
            </div>
        </div>
    </div>
</div>

<div class="modal" data-modal="delivery-no-address">
    <div class="modal__heading">
        <div class="modal__title"><span>Внимание!</span></div>
        <div class="modal__close" data-modal-close=""></div>
    </div>
    <div class="modal__container">
        <div class="modal__text">
            <p>За заказ без адреса взимается фиксированная оплата, она будет включена в сумму заказа.</p>
            <p>Заказ может быть отменен, если адрес доставки будет за пределами зоны доставки.</p>
        </div>
        <div class="button button--green button--full-width close-button" data-modal-close="">Принимаю</div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
<script>
    $(document).ready(function() {
        $('#phone1').inputmask("+7 (999) 999 99-99");
    });

    $(document).ready(function() {
        $('#phone2').inputmask("+7 (999) 999 99-99");
    });

    $(document).ready(function() {
        $('#phone3').inputmask("+7 (999) 999 99-99");
    });
</script>
