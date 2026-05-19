@php
    $url = $price->link;
    $images = \Cache::remember('images|' . $price->sku, \now()->addMinutes(1), fn() => $price->groupProduct->images('cover', 'mobile'));
@endphp
<div class="product">
    <a class="product__image-wrap" href="{{ $url }}">
        @if (!isset($images[0]))
            @php
                $images[] = '/dist/img/image-content/error404-pic.svg';
            @endphp
        @endif

        <img class="product__image" src="{{ $images[0] }}" alt="" />

        @if ($price->is_promo)
            <span class="product__label">Акция</span>
        @endif

        @include('components.composition', ['price' => $price])
    </a>

    <a class="product__title" href="{{ $url }}">
        {{ $price->groupProduct->title }}
    </a>

    <div class="product__bottom">
        <div class="product__prices-wrap">
            <span class="product__price">
                @money(round($price->public_price)) р.
            </span>

            @if (optional($price->market)->delivery_price !== null)
                <div class="product__delivery-price">
                    <svg class="product__delivery-price__icon">
                        <use href="#icon-car"></use>
                    </svg>

                    <span class="product__delivery-price__title">
                        от 0р.
                    </span>
                </div>
            @endif
        </div>

        {{-- desktop корзина --}}
        <button class="add-product-to-cart-button desktop-cart-btn"
                data-put-cart-sku="{{ $price->sku }}">
            <img src="/dist/img/image/cart.png"
                 style="width: 25px !important;max-width: 25px">
        </button>
    </div>

    <div style="padding-top: 10px;height: 30px;text-align: center">
        <yandex-pay-badge
            merchant-id="b2835444-b5f8-4f8d-b4e1-31a5f7468bcc"
            type="bnpl"
            amount="{{$price->public_price}}"
            size="s"
            variant="simple"
            theme="light"
            align="center"
            color="grey"
        />
    </div>

    {{-- mobile кнопка --}}
    <button class="mobile-buy-btn add-product-to-cart-button"
            data-put-cart-sku="{{ $price->sku }}">
        Заказать
    </button>
</div>
