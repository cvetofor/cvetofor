@php
$legal = \TwillAppSettings::getGroupDataForSectionAndName('legal', 'legal')->content;
@endphp

<div class="section">
    <div class="container">
        <div class="contacts__bottom">
            <div class="box__wrap">
                <h2>Реквизиты</h2>
                <div class="box">
                    <div class="contacts__requisites">
                        <span
                            class="contacts__requisites-title">{{ $legal['recipient'] ?? '' }}</span>
                        <div class="contacts__requisites-items__wrap">
                            <div class="contacts__requisites-item">
                                <span
                                    class="contacts__requisites-item__title">Юридический
                                    адрес:</span>
                                <span
                                    class="contacts__requisites-item__text">{{ $legal['address'] ?? '' }}</span>
                            </div>
                            <div class="contacts__requisites-item">
                                <span
                                    class="contacts__requisites-item__title">ИНН:</span>
                                <span
                                    class="contacts__requisites-item__text">{{ $legal['inn'] ?? '' }}</span>
                            </div>
                            <div class="contacts__requisites-item">
                                <span
                                    class="contacts__requisites-item__title">ОГРНИП:</span>
                                <span
                                    class="contacts__requisites-item__text">{{ $legal['ogrn'] ?? '' }}</span>
                            </div>
                            <div class="contacts__requisites-item">
                                <span
                                    class="contacts__requisites-item__title">Телефон:</span>
                                <span
                                    class="contacts__requisites-item__text">{{ $legal['phone'] ?? '' }}</span>
                            </div>
                            <div class="contacts__requisites-item">
                                <span
                                    class="contacts__requisites-item__title">Email:</span>
                                <span
                                    class="contacts__requisites-item__text">{{ $legal['email'] ?? '' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box__wrap">
                <h2>Связаться с нами</h2>
                <div class="contact-us"
                    data-form-wrapper="contact-us"
                    data-form="contact-us">
                    <div class="box box--border-radius-20">
                        <form class="form invalid"
                            data-validate-form=""
                            data-form-body=""
                            method="POST"
                            action="{{ route('form') }}">
                            @csrf
                            <div class="fields">
                                <div class="inputholder form__inputholder">
                                    <label class="inputholder__label"
                                        data-default-label="data-default-label">ФИО*</label>
                                    <input class="inputholder__input"
                                        name="fio"
                                        data-required=""
                                        type="text"
                                        placeholder="Иванов Иван Иванович" />
                                </div>
                                <div class="inputholder form__inputholder">
                                    <label class="inputholder__label"
                                        data-default-label="data-default-label">Телефон*</label>
                                    <input class="inputholder__input"
                                        name="phone"
                                        data-required=""
                                        data-mask-tel=""
                                        data-text-error="phone"
                                        type="tel"
                                        placeholder="+7 (000) 000-0000" />
                                </div>
                                <div class="inputholder form__inputholder">
                                    <label class="inputholder__label"
                                        data-default-label="data-default-label">E-mail</label>
                                    <input class="inputholder__input"
                                        name="email"
                                        data-email=""
                                        data-text-error="email"
                                        type="email"
                                        placeholder="email@email.ru" />
                                </div>
                                <div class="inputholder form__inputholder">
                                    <label class="inputholder__label"
                                        data-default-label="data-default-label">Комментарий*</label>
                                    <textarea class="inputholder__textarea"
                                        name="comment"
                                        data-required=""
                                        data-text-error="comment"
                                        placeholder="Текст комментария"></textarea>
                                </div>
                            </div>
                            <div class="form__buttonholder">
                                <div class="buttonholder"
                                    data-form-trigger="">
                                    <button
                                        class="form__button button button--green submit-button"
                                        data-form-button=""
                                        disabled="">
                                        <span>Отправить</span>
                                    </button>
                                </div>
                                <span class="form__policy policy">Нажимая
                                    на кнопку, вы соглашаетесь на <a
                                        class="policy__link"
                                        href="/policy">обработку персональных
                                        данных</a>
                                </span>
                            </div>
                        </form>
                        <div class="form__thanks"
                            data-form-thanks="data-form-thanks">
                            <div class="form__thanks-image__wrap">
                                <img class="form__thanks-image"
                                    src="/dist/img/image/emoji-happy.svg"
                                    alt="" />
                            </div>
                            <span class="form__thanks-title">Спасибо!</span>
                            <div class="form__thanks-text">
                                <p>Мы свяжемся с вами в ближайшее время!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>