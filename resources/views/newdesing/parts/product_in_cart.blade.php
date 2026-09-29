@php
    $images=[];
        if($associatedModel=='product'){
            if($product->associatedModel->$associatedModel->images('preview')){
              $images=$product->associatedModel->$associatedModel->images('preview');
            }
        }else{
            if(isset($product->associatedModel->$associatedModel->images('cover', 'mobile')[0])){
              $images = $product->associatedModel->$associatedModel->images(
                'cover',
                'mobile',
            );
            }

        }
if(!count($images)){
     $images[] =
            '/dist/img/image-content/error404-pic.svg';
}

@endphp


<li class="cart-item">
            <span class="cart-item__media">
              <img src="{{$images[0]}}"
                   alt="{{ $product->associatedModel->$associatedModel->title }}" width="124" height="124">
            </span>

    <div class="cart-item__info">
        <h3 class="cart-item__title">{{ $product->associatedModel->$associatedModel->title }}</h3>
        @if ($product->attributes->has('composition'))
            <ul class="cart-item__specs">
                @php
                    $compositions = $product->attributes->get(
                        'composition',
                    );
                @endphp

                @if ($product->associatedModel->$associatedModel->isMono())
                    @foreach ($compositions as $composition)
                        <li>
                            {{ $composition['title'] }}:


                            {{ $composition['count'] }} шт.
                        </li>

                    @endforeach
                @else
                    @foreach ($compositions as $composition)
                        <li>    {{ $composition['title'] }}:
                            {{ $composition['count'] }}
                            шт.
                        </li>

                    @endforeach
                @endif
            </ul>

        @endif


        <a class="cart-item__more" href="{{ $product->associatedModel->link }}">
            Подробнее<span
                class="visually-hidden"> о товаре: {{ $product->associatedModel->$associatedModel->title }}</span>
            <span class="chevron chevron--forward" aria-hidden="true"></span>
        </a>
    </div>

    <form class="qty" action="/cart/qty" method="post"
          aria-label="Количество: {{$product->associatedModel->$associatedModel->title }}">
        <input type="hidden" name="product" value="buket-aloe-serdce">
        <button class="qty__btn" type="button" name="step" value="-1"
                aria-label="Уменьшить количество"  @if ($product->quantity > 1) data-minus-cart-item @else data-remove-cart-item @endif="{{ $product->id }}">
            <img src="/template/assets/icons/minus-brand.svg" alt="" width="25"
                 height="25">
        </button>
        <label class="visually-hidden"
               for="qty-buket-aloe-serdce">Количество</label>
        <input class="qty__value" id="qty-buket-aloe-serdce" name="qty"
               type="number"
               value="{{ $product->quantity }}" min="1" max="99"
               inputmode="numeric">
        <button class="qty__btn" type="button" name="step" value="1" data-plus-cart-item="{{ $product->id }}"
                aria-label="Увеличить количество">
            <img src="/template/assets/icons/plus-brand.svg" alt="" width="25"
                 height="25">
        </button>
    </form>

    <p class="cart-item__price">@money($product->getPriceSumWithConditions())
        ₽</p>

    <form class="cart-item__form" action="/cart/remove" method="post">
        <input type="hidden" name="product" value="buket-aloe-serdce">
        <button class="cart-item__remove" type="button"  data-remove-cart-item="{{ $product->id }}"
                aria-label="Удалить «{{$product->associatedModel->$associatedModel->title }}">
            <img src="/template/assets/icons/trash.svg" alt="" width="25"
                 height="25">
        </button>
    </form>
</li>
