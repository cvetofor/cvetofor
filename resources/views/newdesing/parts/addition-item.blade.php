@php
    $image = $price->product->image('preview');
@endphp
<li>
    <article class="addon">
                <span class="addon__media">
                  <img src="{{ $image }}" alt="{{ $price->product->title }}" width="107" height="80" loading="lazy">
                </span>
        <h3 class="addon__title"><span class="addon__link">{{ $price->product->title }}</span></h3>
        <p class="addon__price">@money($price->public_price) ₽</p>

        @if (!\Cart::get(md5($price->id)))
            <div class="addon__form">
                <button class="addon__add" type="button"
                        data-cart-additional-item-add="data-cart-additional-item-add"
                        data-id="{{ $price->id }}"
                        aria-label="Добавить «{{ $price->product->title }}» к заказу">
                    <img src="/template/assets/icons/plus-large.svg" alt="" width="19" height="19">
                </button>
            </div>
        @endif
    </article>
</li>
