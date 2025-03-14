<div class="product-detail__composition" data-mono="true">
    <span class="product-detail__composition-title">Состав
        букета:</span>
    <div class="product-detail__composition-content">

        @foreach ($compositions as $j => $block)
            @foreach ($block as $i => $product)
                @if ($product && $product->color)
                    <div class="composition-item">
                        <div class="composition-item__color" style="background: {{ $product->color->data['rgb'] }};">
                        </div>
                        <span class="composition-item__title">{{ $product->color->title }}</span>
                        <span class="composition-item__quantity"
                            data-count="product[{{ $product->id }}][{{ $j }}]">{{ $product->count }}
                            шт.,</span>
                    </div>
                @elseif($product)
                    <li class="product-composition__list-item">
                        <span class="product-composition__item-title">{{ $product->title }}</span>
                        <span class="product-composition__item-quantity"
                            data-count="product[{{ $product->id }}][{{ $j }}]">{{ $product->count }}
                            шт.</span>
                    </li>
                @endif
            @endforeach
        @endforeach
    </div>
    @if (!$price->is_custom_price)
        @if ($canPutToCart)
            <button class="link-button change-composition-button" data-modal-open="change-composition-mono">
                <span class="link-button__title">Изменить
                    состав букета</span>
                <svg class="link-button__icon">
                    <use href="#icon-gear">

                    </use>
                </svg>
            </button>
        @else
            <button class="link-button change-composition-button disabled"
                data-modal-open="change-composition-mono"><span class="link-button__title">Изменить состав букета</span>
                <svg class="link-button__icon">
                    <use href="#icon-gear"></use>
                </svg>
            </button>
        @endif


        <div class="modal" data-modal="change-composition-mono">
            <div class="modal__heading">
                <div class="modal__title">
                    <span>Изменить состав</span>
                </div>
                <div class="modal__close" data-modal-close="">

                </div>
            </div>
            <div class="modal__container">
                <div class="fields">
                    @foreach ($compositions as $j => $block)
                        @foreach ($block as $i => $product)
                            @if ($product->color)
                                <div class="counter__wrap counter__wrap--composition">
                                    <div class="counter__color" style="background: {{ $product->color->data['rgb'] }};">
                                    </div>
                                    <span class="counter__title">{{ $product->color->title }}</span>
                                    <div class="counter" data-counter-box="">
                                        <span class="count count--minus" data-counter="minus">-</span>
                                        <input class="input" name="product[{{ $product->id }}][{{ $j }}]"
                                            data-price="{{ $product->price }}"
                                            data-prices="{{ $product->prices }}"
                                            data-color="{{ $product->color->id }}"
                                            data-counter-min="{{ $product->count }}" data-counter-max="1000"
                                            data-counter-input="input" value="{{ $product->count }}" />
                                        <span class="count count--plus" data-counter="plus">+</span>
                                    </div>
                                </div>
                            @else
                                <div class="counter__wrap counter__wrap--composition">
                                    <span class="counter__title">{{ $product->title }}</span>
                                    <div class="counter" data-counter-box="">
                                        <span class="count count--minus" data-counter="minus">-</span>
                                        <input class="input" name="product[{{ $product->id }}][{{ $j }}]"
                                            data-price="{{ $product->price }}"
                                            data-prices="{{ $product->prices }}"
                                            data-counter-min="{{ $product->count }}" data-counter-max="1000"
                                            data-counter-input="input" value="{{ $product->count }}" />
                                        <span class="count count--plus" data-counter="plus">+</span>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endforeach
                </div>
                <div class="modal__total">
                    <span class="modal__total-title">Итого</span>
                    <div class="modal__total-price__wrap">

                        @if ($couponCanBeApplied)
                            <span class="modal__total-price modal__total-price--old">@money($price->public_price)
                                р.</span>
                        @endif

                        <span class="modal__total-price modal__total-price--new">@money($price->public_price)
                            р.</span>
                    </div>
                </div>
                <div class="buttonholder">
                    {{-- <button class="button button--green button--full-width apply-button" disabled="disabled">Применить</button> --}}
                </div>
            </div>
        </div>
    @endif

</div>
