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
                                <h1 class="banner__item-title">{!! $item->content['title'] !!}
                                    @if ($item->content['view_city'])
                                    <br>в {{ $citiesService::getCity()->parent_case }}

                                    @endif
                                </h1>
                                <div class="banner__item-text">
                                    {!! $item->content['description'] !!}
                                </div>
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

@if (isset($mainPageTagsModel) && $mainPageTagsModel)
@foreach ($mainPageTagsModel as $tagModel)
@foreach ($tagModel->prices as $paginator)
@if ($paginator->items())
<div class="section">
    <div class="container">
        <h2>
            <a class=""
                href="{{ route('catalog.tags', ['tag' => $tagModel->tag->slug]) }}">{{ $tagModel->tag->name }}</a>
        </h2>
        @include('components.category', [
        'paginator' => $paginator,
        'category_id' => $tagModel->tag->slug,
        ])
    </div>
</div>
@endif
@endforeach
@endforeach
@endif

@if ($prices)
@foreach ($prices as $paginator)
@if ($paginator->items())
<div class="section">
    <div class="container">
        <h2>
            <a class=""
                href="{{ route('catalog.category', ['slug' => $paginator->items()[0]->groupProduct->category->nestedSlug]) }}">{{ $paginator->items()[0]->groupProduct->category->title }}</a>
        </h2>
        @include('components.category', [
        'paginator' => $paginator,
        ])
    </div>
</div>
@endif
@endforeach
@endif

<div class="section">
    <div class="container">
        <div class="text-page category_description">

            <h3><strong>Купить цветы в {{$city}} можно недорого с доставкой на дом&nbsp;</strong></h3>
            <p>В поисках идеального подарка для любимых и близких? Магазин "Цветофор" предлагает широкий ассортимент свежих цветов для любого события. С нашей помощью вы можете легко заказать и купить букеты, не выходя из дома, благодаря удобному онлайн-сервису и оперативной доставке прямо на ваш адрес в {{$city}}.</p><br>
            <h3><strong>Почему стоит выбрать нас?</strong></h3>
            <ul>
                <li>Широкий ассортимент. В нашем каталоге вы найдете букеты на любой вкус: от классических роз до экзотических орхидей.</li>
                <li>Доступные цены. Мы предлагаем конкурентоспособные цены и регулярные акции, чтобы вы могли купить цветы недорого.</li>
                <li>Онлайн-заказ. Заказать доставку цветов в {{$city}} можно прямо на нашем сайте, заполнив простую форму.</li>
                <li>Быстрая доставка. Наша служба доставки гарантирует, что ваш букет будет доставлен точно в срок, свежим и красивым, прямо на указанный адрес.</li>
            </ul><br>
            <h3><strong>Как заказать?</strong></h3>
            <ul>
                <li>1. Выберите букет на сайте.</li>
                <li>2. Укажите адрес доставки и предпочтительную дату.</li>
                <li>3. Оплатите заказ удобным для вас способом.</li>
                <li>4. Получите подтверждение заказа и ожидайте доставки в указанный срок.</li>
            </ul><br>
            <h3><strong>Букеты на любой случай</strong></h3>
            <p>Независимо от того, ищете ли вы букет к празднику, дню рождения, свадьбе или просто хотите сделать приятный сюрприз, "Цветофор" предлагает идеальные варианты для каждого события. Наши опытные флористы соберут для вас букет, который выразит ваши чувства лучше любых слов.</p><br>
            <h3><strong>Сделайте заказ прямо сейчас!</strong></h3>
            <p>Не откладывайте на потом &ndash; сделайте заказ на нашем сайте уже сегодня и порадуйте своих близких в {{$city}} красивым букетом. Магазин "Цветофор" &ndash; ваш надежный помощник в мире цветов!</p>
        </div>
    </div>
</div>
@endsection