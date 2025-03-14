@extends('layouts.app')
@inject('compositeProducts', \App\Services\CompositeProducts::class)
@inject('catalogService', App\Services\CatalogService::class)
@php
    $compositions = $compositeProducts->get($price);

    if (optional($groupProduct->category)->id) {
        $seealso = $catalogService->findPricesByCategoriesId([$groupProduct->category->id], 10);
    } else {
        $seealso = false;
    }

    $couponCanBeApplied = false;
    foreach ($compositions as $j => $block) {
        foreach ($block as $i => $product) {
            if ($product->prices->count() > 1 && optional($product->couponFrom)->quantity_from) {
                $couponCanBeApplied = true;
            }
        }
    }

@endphp
@push('scripts')
    <script>
        // Преобразуем PHP-массив $compositions в JSON
        const compositions = @json($compositions);
        const price = @json($price)

        // Выводим в консоль браузера
        console.log(price);
    </script>
@endpush

@section('content')
    <div class="heading">
        <div class="container">
            <div class="heading__row">
                @include('components.breadcrumbs', [
                    'prefix' => '/catalog',
                ])
                <div class="title-page">
                    <h1 class="h1">{{ $groupProduct->title }}</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="page">
        <div class="section">
            <div class="container">
                <div class="product-detail">
                    <div class="slider slider--product-detail">
                        @if ($price->is_promo)
                            <span class="product-detail__label">Акция</span>
                        @endif

                        <div class="swiper" data-swiper="product-detail">
                            <div class="swiper-wrapper">
                                @if (isset($price->groupProduct->images('cover', 'mobile')[0]))
                                    @php
                                        $images = $price->groupProduct->images('cover', 'mobile');
                                    @endphp
                                @else
                                    @php
                                        $images[] = '/dist/img/image-content/error404-pic.svg';
                                    @endphp
                                @endif

                                @foreach ($images as $key => $image)
                                    @if (!$loop->last || !$price->groupProduct->file('preview'))
                                        <a class="swiper-slide" data-fancybox="data-fancybox" href="{{ $image }}">
                                            <img class="product-detail__image" src="{{ $image }}" alt="" />
                                            <div class="zoom-button">
                                                <svg>
                                                    <use href="#icon-zoom">

                                                    </use>
                                                </svg>
                                            </div>
                                        </a>
                                    @endif
                                @endforeach

                                @if ($price->groupProduct->file('preview') && isset($images))
                                    <a class="swiper-slide swiper-slide--video" data-fancybox="data-fancybox"
                                        href="{{ $price->groupProduct->file('preview') }}">
                                        <img class="product-detail__image" src="{{ Arr::last($images) }}" alt="" />
                                        <button class="play-button">
                                            <svg>
                                                <use href="#icon-play">

                                                </use>
                                            </svg>
                                        </button>
                                    </a>
                                @endif
                            </div>
                            <button class="swiper-button-prev swiper-button-prev--white"
                                data-swiper="product-detail-button-prev">
                                <svg>
                                    <use href="#icon-arrow-slider">

                                    </use>
                                </svg>
                            </button>
                            <button class="swiper-button-next swiper-button-next--white"
                                data-swiper="product-detail-button-next">
                                <svg>
                                    <use href="#icon-arrow-slider">

                                    </use>
                                </svg>
                            </button>
                        </div>
                        <div class="swiper-pagination swiper-pagination--darkgrey" data-swiper="product-detail-pagination">

                        </div>
                    </div>
                    <div class="box box--no-margin box--padding-40 box--padding-mobile-30 box--border-radius-36">
                        <div class="product-detail__info">
                            <div class="product-detail__info-top">
                                <span class="product-detail__vendor-code">Артикул:
                                    {{ $price->sku }}</span>
                                @if ($price->price == null || $price->price == 0 || $price->published === false || !$canPutToCart)
                                    <span class="product-detail__price">Нет в наличии</span>
                                @else
                                    <span class="product-detail__price">@money(round($price->public_price))
                                        р.</span>
                                @endif
                                <div class="product-detail__delivery">
                                    @if (optional($price->market)->delivery_price !== null)
                                        <svg class="product-detail__delivery-icon">
                                            <use href="#icon-car">

                                            </use>
                                        </svg>

                                        <span class="product-detail__delivery-title">Доставка:</span>
                                        <span class="product-detail__delivery-value">@money($price->delivery_price)
                                            р.</span>
                                    @endif
                                </div>
                            </div>
                            @if ($groupProduct->isMono())
                                @include('product.mono')
                            @else
                                @include('product.normal')
                            @endif

                            @if ($couponCanBeApplied)
                                <div class="product-detail__discount-wrap">
                                    <div class="product-detail__discount">
                                        <svg class="product-detail__discount-icon">
                                            <use href="#icon-discount">

                                            </use>
                                        </svg>
                                        <span class="product-detail__discount-title">Доступна скидка</span>
                                    </div>
                                    <div class="product-detail__discount-condition">
                                        <span class="product-detail__discount-condition__title">Скидка
                                            дается при добавлении (на
                                            выбор):</span>
                                        <span class="product-detail__discount-condition__content">
                                            @foreach ($compositions as $j => $block)
                                                @foreach ($block as $i => $product)
                                                    @if ($product->prices->count() > 1 && optional($product->couponFrom)->quantity_from)
                                                        @if ($product->color && $groupProduct->isMono())
                                                            <span>
                                                                <div class="counter__color"
                                                                    style="width:13px; height:13px;background: {{ $product->color->data['rgb'] }};">
                                                                </div>
                                                            </span>
                                                        @else
                                                            <span>{{ $product->title }}</span>
                                                        @endif
                                                        <span>@money($product->couponFrom->quantity_from)
                                                            шт.,</span>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </span>
                                    </div>
                                </div>
                            @endif

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

        @if ($groupProduct->description)
            <div class="section">
                <div class="container">
                    <h2>Описание</h2>
                    <div class="content">
                        <p>{!! $groupProduct->description !!}</p>
                    </div>
                </div>
            </div>
        @endif

        @if ($seoText)
            <div class="section">
                <div class="container">
                    <div class="text-page category_description">
                        <p>{!! $seoText !!}</p>
                    </div>
                </div>
            </div>
        @endif

        @if ($seealso)
            <div class="section">
                <div class="container">
                    <h2>Смотрите также</h2>
                    <div class="slider slider--products">
                        <div class="swiper" data-swiper="products">
                            <div class="swiper-wrapper">
                                @foreach ($seealso as $paginator)
                                    @foreach ($paginator->items() as $_price)
                                        @if ($_price->sku !== $price->sku)
                                            <div class="swiper-slide">
                                                @include('components.product', ['price' => $_price])
                                            </div>
                                        @endif
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                        <button class="swiper-button-prev swiper-button-prev--black" data-swiper="products-button-prev">
                            <svg>
                                <use href="#icon-arrow-slider">

                                </use>
                            </svg>
                        </button>
                        <button class="swiper-button-next swiper-button-next--black" data-swiper="products-button-next">
                            <svg>
                                <use href="#icon-arrow-slider">

                                </use>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

{{-- Невидимая для пользователя стоимость других товаров, у которых категория is_visible=false --}}
@push('scripts')
    <script>
        const basePrice = {{ $compositeProducts->unvisiblePrice($price) }};
        const changedPrice = {{ $price->public_price }};
    </script>
@endpush
