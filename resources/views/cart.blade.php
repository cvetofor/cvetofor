@extends('layouts.app')

@section('content')
    @if (Cart::getContent()->count() == 0)
        <div class="heading">
            <div class="container">
                <div class="heading__row">
                    <div class="breadcrumbs">
                        <span class="breadcrumbs__item">
                            <a href="/">
                                <span>Главная</span>
                            </a>
                        </span>
                        <span class="breadcrumbs__item">
                            <span>Корзина</span>
                        </span>
                    </div>
                    <div class="title-page">
                        <h1 class="h1">Корзина</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="page">
            <div class="section">
                <div class="container">
                    <div class="box box--padding-40">
                        <div class="status-page">
                            <div class="status-page">
                                <svg class="status-page__icon">
                                    <use href="#icon-basket">

                                    </use>
                                </svg>
                                <span class="status-page__title">Ваша корзина пуста</span>
                                <div class="status-page__text">
                                    <p>Перейдите в <a class="link" href="{{ route('catalog.index') }}">каталог</a> для
                                        выбора товара</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="heading">
            <div class="container">
                <div class="heading__row">
                    <div class="breadcrumbs">
                        <span class="breadcrumbs__item">
                            <a href="/">
                                <span>Главная</span>
                            </a>
                        </span>
                        <span class="breadcrumbs__item">
                            <span>Корзина</span>
                        </span>
                    </div>
                    <div class="title-page">
                        <h1 class="h1">Корзина</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="page">
            <div class="main-cols__wrap">
                <div class="container">
                    <div class="main-col">
                        @foreach ($cartByMarket as $collection)
                            <div class="section">
                                <div class="cart__salesman @if (!$loop->first) section--margin-top-40 @endif">
                                    <span class="h3">{{ $collection->first()->associatedModel->market->name }}</span>
                                    <div class="box box--padding-32 box--padding-mobile-20">
                                        <div class="cart__items-wrap">
                                            @foreach ($collection as $product)
                                                @if (isset($product->associatedModel->groupProduct) && $product->associatedModel->groupProduct)
                                                    <div {{-- @if (isset($product['attributes']['hidden']) && $product['attributes']['hidden'] === true) cart__item--not-available @endif --}} class="cart__item  ">
                                                        <a class="cart__item-image__wrap"
                                                            href="{{ $product->associatedModel->link }}" target="_blank">

                                                            @if (isset($product->associatedModel->groupProduct->images('cover', 'mobile')[0]))
                                                                @php
                                                                    $images = $product->associatedModel->groupProduct->images(
                                                                        'cover',
                                                                        'mobile',
                                                                    );
                                                                @endphp
                                                            @else
                                                                @php
                                                                    $images[] =
                                                                        '/dist/img/image-content/error404-pic.svg';
                                                                @endphp
                                                            @endif
                                                            <img class="cart__item-image" src="{{ $images[0] }}"
                                                                alt="" />
                                                        </a>
                                                        <div class="cart__item-info">
                                                            <div class="cart__item-heading">
                                                                <a class="cart__item-title"
                                                                    href="{{ $product->associatedModel->link }}"
                                                                    target="_blank">{{ $product->associatedModel->groupProduct->title }}
                                                                </a>
                                                                <span style="color:gray">
                                                                    @if ($product->quantity > 1)
                                                                        x {{ $product->quantity }}
                                                                    @endif
                                                                </span>
                                                                @if ($product->associatedModel->groupProduct->isMono())
                                                                    <div class="cart__item-label">%</div>
                                                                @endif
                                                            </div>
                                                            <div class="cart__item-desc" style="display: flex">
                                                                <p>
                                                                    @if ($product->attributes->has('composition'))
                                                                        @php
                                                                            $compositions = $product->attributes->get(
                                                                                'composition',
                                                                            );
                                                                        @endphp

                                                                        @if ($product->associatedModel->groupProduct->isMono())
                                                                            @foreach ($compositions as $composition)
                                                                                @if ($composition['rgb'])
                                                                                    <div class="counter__color"
                                                                                        style="width:10px; height:10px; background:{{ $composition['rgb'] }};display: inline flow-root list-item;">
                                                                                    </div>
                                                                                @else
                                                                                    {{ $composition['title'] }}
                                                                                @endif
                                                                                <span
                                                                                    style="margin-left:5px; margin-right:5px;">
                                                                                    {{ $composition['count'] }} шт.</span>
                                                                                @if (!$loop->last)
                                                                                    ,
                                                                                @endif
                                                                            @endforeach
                                                                        @else
                                                                            @foreach ($compositions as $composition)
                                                                                {{ $composition['title'] }}
                                                                                {{ $composition['count'] }}
                                                                                шт.
                                                                                @if (!$loop->last)
                                                                                    ,
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                    @else
                                                                    @endif
                                                                </p>
                                                            </div>
                                                            <div class="cart__item-price__wrap">
                                                                <span class="cart__item-price">@money($product->getPriceSumWithConditions()) р.</span>
                                                                @if ($product->getPriceSumWithConditions() !== $product->getPriceSum())
                                                                    <span
                                                                        class="cart__item-price cart__item-price--old">@money($product->getPriceSum())
                                                                        р.</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <button class="remove-cart-item-button"
                                                            @if ($product->quantity > 1) data-minus-cart-item @else data-remove-cart-item @endif="{{ $product->id }}">
                                                            <svg>
                                                                <use href="#icon-bin">

                                                                </use>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                @endif
                                                @if (isset($product->associatedModel->product) && $product->associatedModel->product)
                                                    <div
                                                        class="cart__item @if (isset($product['attributes']['hidden']) && $product['attributes']['hidden'] === true) cart__item--not-available @endif ">
                                                        <a class="cart__item-image__wrap" href="#" target="_blank">

                                                            @if ($product->associatedModel->product->image('preview'))
                                                                @php
                                                                    $images = [
                                                                        $product->associatedModel->product->image(
                                                                            'preview',
                                                                        ),
                                                                    ];
                                                                @endphp
                                                            @else
                                                                @php
                                                                    $images = [
                                                                        '/dist/img/image-content/error404-pic.svg',
                                                                    ];
                                                                @endphp
                                                            @endif
                                                            <img class="cart__item-image" src="{{ $images[0] }}"
                                                                alt="" />
                                                        </a>
                                                        <div class="cart__item-info">
                                                            <div class="cart__item-heading">
                                                                <a class="cart__item-title" href="#"
                                                                    target="_blank">{{ $product->associatedModel->product->title }}
                                                                </a>
                                                                <span style="color:gray">
                                                                    @if ($product->quantity > 1)
                                                                        x {{ $product->quantity }}
                                                                    @endif
                                                                </span>
                                                            </div>
                                                            <div class="cart__item-price__wrap">
                                                                <span class="cart__item-price">@money($product->getPriceSumWithConditions()) р.</span>
                                                                @if ($product->getPriceSumWithConditions() !== $product->getPriceSum())
                                                                    <span
                                                                        class="cart__item-price cart__item-price--old">@money($product->getPriceSum())
                                                                        р.</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <button class="remove-cart-item-button"
                                                            @if ($product->quantity > 1) data-minus-cart-item @else data-remove-cart-item @endif="{{ $product->id }}">
                                                            <svg>
                                                                <use href="#icon-bin">

                                                                </use>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="cart__salesman-bottom">
                                            <div class="cart__delivery">
                                                <span class="cart__delivery-title">Доставка</span>
                                                <span class="cart__delivery-value">@money($collection->first()->associatedModel->market->delivery_price) р.</span>
                                            </div>
                                            @if (isset($recomendations[$collection->first()->associatedModel->market->id]))
                                                <div class="cart__recommend accordion" data-accordion="">
                                                    <div class="accordion__toggle active" data-accordion-toggle="">
                                                        <div class="accordion__title">
                                                            <span>Рекомендуем добавить</span>
                                                        </div>
                                                        <div class="accordion__btn">
                                                            <svg>
                                                                <use href="#icon-arrow-accordion">

                                                                </use>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div class="accordion__content" data-accordion-content=""
                                                        style="transition: height 300ms; height: 350px;overflow: auto !important;">
                                                        <div class="cart__additional-items__wrap">
                                                            @foreach ($collection as $product)
                                                                @if ($product->associatedModel->product)
                                                                    @include('components.addition-item', [
                                                                        'price' => $product->associatedModel,
                                                                    ])
                                                                @endif
                                                            @endforeach

                                                            @foreach ($recomendations[$collection->first()->associatedModel->market->id] as $key => $price)
                                                                @if (!\Cart::get(md5($price->id)))
                                                                    @include('components.addition-item', [
                                                                        'price' => $price,
                                                                    ])
                                                                @endif
                                                            @endforeach @foreach ($collection as $product)
                                                                @if ($product->associatedModel->product)
                                                                    @include('components.addition-item', [
                                                                        'price' => $product->associatedModel,
                                                                    ])
                                                                @endif
                                                            @endforeach

                                                            @foreach ($recomendations[$collection->first()->associatedModel->market->id] as $key => $price)
                                                                @if (!\Cart::get(md5($price->id)))
                                                                    @include('components.addition-item', [
                                                                        'price' => $price,
                                                                    ])
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="side-col" data-sticky="data-sticky">
                        <div class="section" data-sticky-element="130" data-sticky-unset="1198">
                            <div class="box box--no-margin">
                                <div class="cart__summary">
                                    <div class="cart__summary-heading">
                                        <span class="cart__summary-title">Ваш заказ</span>
                                        <span class="cart__summary-count">Позиций: {{ $cart->count() }} шт</span>
                                    </div>
                                    <div class="cart__summary-items__wrap">
                                        @foreach ($cart as $item)
                                            <div class="cart__summary-item">
                                                <span>{{ $item->name }} @if ($item->quantity > 1)
                                                        x {{ $item->quantity }}
                                                    @endif
                                                </span>
                                                <span>@money($item->getPriceSumWithConditions()) р.</span>
                                            </div>
                                        @endforeach
                                        @if ($totalDeliveryPrice)
                                            <div class="cart__summary-item">
                                                <span>Доставка</span>
                                                <span>@money($totalDeliveryPrice) р.</span>
                                            </div>
                                        @endif
                                        @if (\Cart::getSubTotalWithoutConditions() !== \Cart::getTotal())
                                            <div class="cart__summary-item"><span>Скидка</span><span class="negative">-
                                                    {{ abs(\Cart::getSubTotalWithoutConditions() - \Cart::getTotal()) }}
                                                    р.</span></div>
                                        @endif
                                    </div>
                                    <div class="cart__summary-bottom">
                                        <span class="cart__summary-total">Итого: @money(\Cart::getTotal() + $totalDeliveryPrice) р.</span>

                                        @if (\Cart::getSubTotalWithoutConditions() !== \Cart::getTotal())
                                            <span class="cart__summary-no-discount">Без скидки: @money(\Cart::getSubTotalWithoutConditions() + $totalDeliveryPrice)
                                                р.</span>
                                        @endif
                                    </div>
                                    @if ($canGoToNext)
                                        <a href="{{ route('order.index') }}"
                                            class="button button--green button--full-width go-to-checkout-button">Перейти к
                                            оформлению</a>
                                    @else
                                        <a href="{{ route('order.index') }}" disabled="disabled"
                                            class="button button--green button--full-width go-to-checkout-button">Перейти к
                                            оформлению</a>
                                    @endif


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    @if (!$canGoToNext)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                modal.show("notification-not-available");

            });
        </script>
    @endif
    <script>
        const content = document.querySelector('.accordion__content');
        const items = document.querySelectorAll('.cart__additional-item');

        if (content && items.length > 0) {
            let height = 0;

            // Берём высоту первых 3 элементов (или меньше)
            for (let i = 0; i < Math.min(3, items.length); i++) {
                height += items[i].offsetHeight ;
            }

            // Добавим небольшой запас под отступы
            height += 20;

            content.style.height = height + "px";
            content.style.maxHeight = height + "px";
            content.style.overflow = "auto";

        }
    </script>
@endpush
