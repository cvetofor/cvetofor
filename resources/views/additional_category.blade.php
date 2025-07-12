@extends('layouts.app')

@section('content')
<div class="heading heading--big-banner">
    <div class="container">
        <div class="heading__row">
            <div class="title-page">
                <h1 class="h1">{{ $category->title }}</h1>
            </div>
        </div>
    </div>
</div>

@include('components.filter')

<div class="section">
    <div class="container">
        <div class="products__wrap">
            @foreach ($products as $product)
                @php
                    $price = $product->prices()->published()->first();
                @endphp
                @if($price)
                    @php
                        $url = $price->link;
                        $images = \Cache::remember('images|' . $product->id, \now()->addMinutes(1), fn() => $product->images('preview'));
                    @endphp
                    <div class="product">
                        <a class="product__image-wrap" href="{{ $url ?: '#' }}">
                            @if (!isset($images[0]))
                                @php
                                    $images[] = '/dist/img/image-content/error404-pic.svg';
                                @endphp
                            @endif
                            <img class="product__image" src="{{ $images[0] }}" alt="" />
                            @if ($price->is_promo)
                                <span class="product__label">Акция</span>
                            @endif
                        </a>
                        <a class="product__title" href="{{ $url ?: '#' }}">{{ $product->title }}</a>
                        <div class="product__bottom">
                            <div class="product__prices-wrap">
                                <span class="product__price">@money(round($price->public_price)) р.</span>
                                @if (optional($price->market)->delivery_price !== null)
                                    <div class="product__delivery-price">
                                        <svg class="product__delivery-price__icon">
                                            <use href="#icon-car"></use>
                                        </svg>
                                        <span class="product__delivery-price__title">от @money(($price->market)->delivery_product_price) р.</span>
                                    </div>
                                @endif
                            </div>
                            <button class="add-product-to-cart-button" data-put-cart-sku="{{ $price->sku }}">
                                <svg>
                                    <use href="#icon-plus"></use>
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        {{-- <div class="mt-4">
            {{ $products->links() }}
        </div> --}}
    </div>
</div>
@endsection 