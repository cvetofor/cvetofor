@extends('layouts.app')

@section('content')
    <div class="heading">
        <div class="container">
            <div class="heading__row">
                @include('components.breadcrumbs', [ 
                    'breadcrumbs' => $breadcrumbs,
                ])
                <div class="title-page">
                    <h1 class="h1">{{ $product->title }}</h1>
                </div>
            </div>
        </div>
    </div>

    @php
        $activeMarket = \App\Services\CitiesService::getCity()->markets()->published()->first();
        $price = $product->prices()->published()
            ->where('market_id', $activeMarket->id)
            ->where('price', '<>', null)
            ->where('price', '<>', 0)
            ->orderBy('quantity_from', 'ASC')
            ->orderBy('price', 'ASC')
            ->first();
    @endphp
    
    <div class="page">
        <div class="section">
            <div class="container">
                <div class="product-detail">
                    <div class="slider slider--product-detail">
                        @if (isset($price->is_promo) && $price->is_promo)
                            <span class="product-detail__label">Акция</span>
                        @endif

                        <div class="swiper" data-swiper="product-detail">
                            <div class="swiper-wrapper">
                                @php
                                    $images = \Cache::remember('images|' . $product->id, \now()->addMinutes(1), fn() => $product->images('preview'));
                                @endphp
                                @if (!isset($images[0]))
                                    @php
                                        $images[] = '/dist/img/image-content/error404-pic.svg';
                                    @endphp
                                @endif

                                @foreach ($images as $key => $image)
                                    <a class="swiper-slide" data-fancybox="data-fancybox" href="{{ $image }}">
                                        <img class="product-detail__image" src="{{ $image }}" alt="{{ $product->title }}" />
                                        <div class="zoom-button">
                                            <svg>
                                                <use href="#icon-zoom"></use>
                                            </svg>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                            <button class="swiper-button-prev swiper-button-prev--white"
                                data-swiper="product-detail-button-prev">
                                <svg>
                                    <use href="#icon-arrow-slider"></use>
                                </svg>
                            </button>
                            <button class="swiper-button-next swiper-button-next--white"
                                data-swiper="product-detail-button-next">
                                <svg>
                                    <use href="#icon-arrow-slider"></use>
                                </svg>
                            </button>
                        </div>
                        <div class="swiper-pagination swiper-pagination--darkgrey" data-swiper="product-detail-pagination">
                        </div>
                    </div>
                    
                    <div class="box box--no-margin box--padding-40 box--padding-mobile-30 box--border-radius-36">
                        <div class="product-detail__info">
                            <div class="product-detail__info-top">
                                @if (!isset($price->sku) || $price->price == null || $price->price == 0 || $price->published === false || !$canPutToCart)
                                    <span class="product-detail__price">Нет в наличии</span>
                                @else
                                    <span class="product-detail__price">@money(round($price->public_price)) р.</span>
                                @endif
                                <div class="product-detail__delivery">
                                    @if (isset($price->sku) && optional($price->market)->delivery_price !== null)
                                        <svg class="product-detail__delivery-icon">
                                            <use href="#icon-car"></use>
                                        </svg>
                                        <span class="product-detail__delivery-title">Доставка:</span>
                                        <span class="product-detail__delivery-value">@money(($price->market)->delivery_product_price) р.</span>
                                    @endif
                                </div>
                            </div>
                            @if ($price->price == null || $price->price == 0 || $price->published === false || !$canPutToCart)
                                <button class="button button--green button--width-165 add-to-cart-button disabled">В
                                    корзину</button>
                            @else
                                <button class="button button--green button--width-165 add-to-cart-button"
                                    data-sku="{{ $price->sku }}">В
                                    корзину</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($product->description)
            <div class="section">
                <div class="container">
                    <h2>Описание</h2>
                    <div class="content">
                        <p>{!! $product->description !!}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Инициализация слайдера продукта
    const sliderProductDetail = new Swiper('[data-swiper="product-detail"]', {
        slidesPerView: 1,
        spaceBetween: 0,
        loop: true,
        watchOverflow: true,
        navigation: {
            nextEl: '[data-swiper="product-detail-button-next"]',
            prevEl: '[data-swiper="product-detail-button-prev"]',
        },
        pagination: {
            el: '[data-swiper="product-detail-pagination"]',
            type: "bullets",
            clickable: true,
        },
    });
});
</script>
@endpush 