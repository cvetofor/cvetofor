<div class="cart__additional-item" data-cart-additional-item="data-cart-additional-item">
    <div class="cart__additional-item__image-wrap">
        @php
            $image = $price->product->image('preview');
        @endphp
        <img class="cart__additional-item__image" src="{{ $image }}" alt="{{ $price->product->title }}" />
    </div>
    <div class="cart__additional-item__info">
        <span class="cart__additional-item__title">{{ $price->product->title }}</span>
        <div class="cart__additional-item__content">

            <svg class="cart__additional-item__check @if (!\Cart::get(md5($price->id))) hidden @endif"
                data-cart-additional-item-check="data-cart-additional-item-check">
                <use href="#icon-check">

                </use>
            </svg>

            <button class="add-cart-additional-item-button @if (\Cart::get(md5($price->id))) hidden @endif"
                data-cart-additional-item-add="data-cart-additional-item-add" data-id="{{ $price->id }}">
                <svg>
                    <use href="#icon-plus-w-circle"></use>
                </svg>
            </button>



            <span class="cart__additional-item__price"> @money($price->public_price) р.</span>

            <button class="remove-cart-additional-item-button @if (!\Cart::get(md5($price->id))) hidden @endif"
                data-cart-additional-item-remove="data-cart-additional-item-remove" data-id="{{ md5($price->id) }}">
                <svg>
                    <use href="#icon-bin">

                    </use>
                </svg>
            </button>





        </div>
    </div>
</div>
