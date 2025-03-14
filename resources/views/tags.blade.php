@extends('layouts.app')
@inject('citiesService', \App\Services\CitiesService::class)

@section('content')
    <div class="section banner">
        <div class="slider slider--banner">
            <div class="swiper" data-swiper="banner">
                <div class="swiper-wrapper">
                    @if ($banner)
                        @foreach ($banner as $item)
                            @php
                                $image = $item->imageObject('image', 'desktop');
                            @endphp
                            @if (optional($image)->uuid)
                                <div class="swiper-slide">
                                    <div class="banner__item" style="background-image: url('{!! ImageService::getRawUrl($image->uuid) !!}')">
                                        <div class="container">
                                            <div class="banner__item-content">
                                                <span class="banner__item-title">{{ $tagModel->name }}
                                                    <br>В {{ $citiesService::getCity()->parent_case }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif

                </div>
                <div class="swiper-pagination swiper-pagination--lightgrey" data-swiper="banner-pagination">

                </div>
                <div class="swiper__navigation">
                    <div class="container">
                        <button class="swiper-button-prev swiper-button-prev--white" data-swiper="banner-button-prev">
                            <svg>
                                <use href="#icon-arrow-slider">

                                </use>
                            </svg>
                        </button>
                        <button class="swiper-button-next swiper-button-next--white" data-swiper="banner-button-next">
                            <svg>
                                <use href="#icon-arrow-slider">

                                </use>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.filter')

    @if ($prices)
        @foreach ($prices as $paginator)
            @if ($paginator->items())
                <div class="section">
                    <div class="container">
                        @include('components.category', ['paginator' => $paginator ,'category_id' => $tagModel->slug])
                    </div>
                </div>
            @endif
        @endforeach
    @endif

    <div class="section">
                <div class="container">
                    <div class="text-page category_description">
                        <p>{!! $seoText !!}</p>
                    </div>
                </div>
            </div>
            
@endsection
