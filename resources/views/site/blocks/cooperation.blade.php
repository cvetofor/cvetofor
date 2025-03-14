<div class="section">
    <div class="container">
        <div class="contacts__main">
            <div class="box__wrap">
                <h2>{{ $block->input('title') }}</h2>
                <div class="box">
                    <div class="contacts__cooperation">
                        <div class="contacts__cooperation-image__wrap">
                            <img class="contacts__cooperation-image"
                                src="{!! $block->image('image', 'desktop') !!}"
                                alt="{{ $block->imageAltText('image') }}" />
                        </div>
                        <div class="contacts__cooperation-content">
                            <span
                                class="contacts__cooperation-position">{{ $block->input('job_title') }}</span>
                            <span
                                class="contacts__cooperation-name">{{ $block->input('face_name') }}</span>
                            <a class="contacts__cooperation-phone"
                                href="tel:@to_phone($block->input('phone'))">{{ $block->input('phone') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box__wrap">
                <div class="box">
                    <div class="contacts__wrap">
                        @if ($block->input('email'))
                            <div class="contacts__item">
                                <span class="contacts__item-title">E-mail</span>
                                <div class="contacts__item-content">
                                    <a class="contacts__email"
                                        href="mailto:email@email.ru">{{ $block->input('email') }}</a>
                                </div>
                            </div>
                        @endif
                        @if ($block->input('single_phone'))
                            <div class="contacts__item">
                                <span class="contacts__item-title">Единый
                                    номер</span>
                                <div class="contacts__item-content">
                                    <a class="contacts__phone"
                                        href="tel:@to_phone($block->input('single_phone'))">{{ $block->input('single_phone') }}</a>
                                </div>
                            </div>
                        @endif
                        <div class="contacts__item">
                            <span class="contacts__item-title">Мы в
                                соцсетях</span>
                            <div class="contacts__item-content">
                                <div class="social contacts__social">
                                    <a class="social__item"
                                        href="{{ $block->input('vk') }}"
                                        target="_blank">
                                        <svg class="social__icon"
                                            width="34"
                                            height="34">
                                            <use href="#icon-vk">

                                            </use>
                                        </svg>
                                    </a>
                                    <a class="social__item"
                                        href="{{ $block->input('telegram') }}"
                                        target="_blank">
                                        <svg class="social__icon"
                                            width="34"
                                            height="34">
                                            <use href="#icon-telegram">

                                            </use>
                                        </svg>
                                    </a>
                                    <a class="social__item"
                                        href="{{ $block->input('whatsapp') }}"
                                        target="_blank">
                                        <svg class="social__icon"
                                            width="34"
                                            height="34">
                                            <use href="#icon-whatsapp">

                                            </use>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
