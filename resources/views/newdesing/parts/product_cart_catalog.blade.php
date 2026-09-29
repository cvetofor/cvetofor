@php

    if($typeproduct=='product'){
        $images[] = $price->product->image('preview');
        $activeMarket = \App\Services\CitiesService::getCity()->markets()->published()->first();
    $price = $price->product->prices()->published()
        ->where('market_id', $activeMarket->id)
        ->where('price', '<>', null)
        ->where('price', '<>', 0)
        ->orderBy('quantity_from', 'ASC')
        ->orderBy('price', 'ASC')
        ->first();

    }else{
         $images = \Cache::remember('images|' . $price->sku, \now()->addMinutes(1), fn() => $price->$typeproduct->images('cover', 'mobile'));
    }

@endphp
@if (!isset($images[0]))
    @php
        $images[] = '/dist/img/image-content/error404-pic.svg';
    @endphp
@endif

<li data-category-items="category_{{ $cat_id}}">
    <article class="card"  @if($price->is_promo)  data-product="buket-vip"@endif >
        <div class="card__media">
            <img class="card__photo" src="{{ $images[0] }}"
                 alt="{{ $price->$typeproduct->title }}"
                 width="284" height="225" loading="lazy">
            @if($price->is_promo) <p class="badge badge--sale">−20%</p>@endif
            <form class="card__fav" data-fav action="/favorites/toggle" method="post">
                <input type="hidden" name="product" value="buket-vip">
                <button class="card__like" type="submit" aria-pressed="false"
                        aria-label="Добавить «{{ $price->$typeproduct->title }}» в избранное">
                    <img src="/template/assets/icons/heart.svg" alt="" width="19" height="19">
                </button>
            </form>
        </div>

        <div class="card__body">
            <h3 class="card__title" style="min-height: 48px"><a class="card__link" href="{{ $price->link }}"> {{ $price->$typeproduct->title }}</a></h3>

            <p class="card__prices">
                <span class="card__price">@money(round($price->public_price)) р.</span>
            </p>

            <p class="card__delivery">
                <img src="/template/assets/icons/truck.svg" alt="Доставка" width="24" height="18">
                <span class="card__shipping">от 0 ₽</span>
                <span class="dot-sep" aria-hidden="true"></span>
                <span class="delivery-term">Сегодня</span>
            </p>


                <button class="btn btn--primary card__buy add-product-to-cart-button desktop-cart-btn" type="button"
@if($typeproduct=='product')

    data-cart-additional-item-add="data-cart-additional-item-add" data-id="{{ $price->id }}"
@else
                            data-put-cart-sku="{{ $price->sku }}"
@endif
                       >В корзину</button>




            <p class="card__split">
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
            </p>
        </div>
    </article>
</li>
