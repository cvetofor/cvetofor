@extends('layouts.app')
 
@section('content')
<div class="heading heading--big-banner">
    <div class="container">
        <div class="heading__row">
            <div class="title-page">
                <h1 class="h1">{{ $product->title }}</h1>
            </div>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <div class="product-detail">
            <div class="product-detail__image-wrap">
                @php
                    $images = \Cache::remember('images|' . $product->id, \now()->addMinutes(1), fn() => $product->images('preview'));
                @endphp
                @if (!isset($images[0]))
                    @php
                        $images[] = '/dist/img/image-content/error404-pic.svg';
                    @endphp
                @endif
                <img class="product-detail__image" src="{{ $images[0] }}" alt="{{ $product->title }}" />
                @if ($price->is_promo)
                    <span class="product-detail__label">Акция</span>
                @endif
            </div>
            
            <div class="product-detail__info">
                <h2 class="product-detail__title">{{ $product->title }}</h2>
                
                @if($product->description)
                    <div class="product-detail__description">
                        {!! $product->description !!}
                    </div>
                @endif
                
                <div class="product-detail__prices">
                    <span class="product-detail__price">@money(round($price->public_price)) р.</span>
                    @if (optional($price->market)->delivery_price !== null)
                        <div class="product-detail__delivery-price">
                            <svg class="product-detail__delivery-price__icon">
                                <use href="#icon-car"></use>
                            </svg>
                            <span class="product-detail__delivery-price__title">от @money(($price->market)->delivery_product_price) р.</span>
                        </div>
                    @endif
                </div>
                
                @if($canPutToCart)
                    <button class="add-product-to-cart-button product-detail__add-button" data-put-cart-sku="{{ $price->sku }}">
                        <svg>
                            <use href="#icon-plus"></use>
                        </svg>
                        Добавить в корзину
                    </button>
                @else
                    <div class="product-detail__not-available">
                        Товар временно недоступен
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 