@inject('marketService', \App\Services\MarketService::class)

<div class="section">
    <div class="container">
        <h2>Адреса магазинов</h2>
        <div class="box">
            <div class="contacts__addresses">
                <div class="contacts__addresses-content">
                    <div class="contacts__addresses-search" data-map-search="data-map-search">
                        <div class="inputholder">
                            <input class="inputholder__input" type="text" placeholder="Введите адрес"
                                data-map-search-input="data-map-search-input" />
                            <button class="reset-btn" data-map-search-reset="data-map-search-reset"></button>
                        </div>
                    </div>
                    <div class="contacts__addresses-items__wrap">
                        @foreach ($marketService->getCurrentCityMarkets() as $market)
                            <div class="contacts__addresses-item @if ($loop->first) active @endif"
                                data-map-address="{{ $market->city->city }}, {{ $market->address }}">
                                <svg class="contacts__addresses-item__icon">
                                    <use href="#icon-placemark-empty"></use>
                                </svg>
                                <div class="contacts__addresses-item__content"><span
                                        class="contacts__addresses-item__title">{{ $market->city->city }},
                                        {{ $market->address }}</span>
                                    <div class="contacts__addresses-item__text">
                                        <span>{{ $market->workTimeLong()[0] ?? '' }}</span>
                                        <span>{{ $market->workTimeLong()[1] ?? '' }}</span>
                                        <span>{{ $market->pone }}</span>
                                    </div>
                                </div>
                            </div>

                            @if ($market->additional_addresses)
                                @foreach ($market->additional_addresses as $_address)
                                    @if ($_address && isset($_address['address']))
                                        <div class="contacts__addresses-item"
                                            data-map-address="{{ $market->city->city }}, {{ $_address['address'] ?? '' }}">
                                            <svg class="contacts__addresses-item__icon">
                                                <use href="#icon-placemark-empty"></use>
                                            </svg>
                                            <div class="contacts__addresses-item__content"><span
                                                    class="contacts__addresses-item__title">{{ $market->city->city }},
                                                    {{ $_address['address'] ?? '' }}</span>
                                                <div class="contacts__addresses-item__text">
                                                    <span>{{ $market->workTimeLong()[0] ?? '' }}</span>
                                                    <span>{{ $market->workTimeLong()[1] ?? '' }}</span>
                                                    <span>{{ $market->pone }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="contacts__map map map--no-touch" data-map-overlay="">
                    <div class="map__holder" data-map="" data-map-icon="/dist/img/image/map-placemark.svg"
                        data-map-coords=""></div>
                </div>
                <script src="//api-maps.yandex.ru/2.1/?{{ config('app.yandex_api') }}&lang=ru_RU"></script>
            </div>
        </div>
    </div>
</div>
