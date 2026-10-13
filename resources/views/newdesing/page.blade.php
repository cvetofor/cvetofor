@extends('newdesing.app')
@inject('citiesService', \App\Services\CitiesService::class)

@php
    // Первая картинка страницы идёт фоном баннера: медиа-поле cover, а если
    // не заполнено — первый блок-картинка (тогда сам блок не рендерится:
    // image.blade.php получает bannerBlockId через второй аргумент
    // renderBlocks и пропускает себя)
    $bannerImage = $item->image('cover', 'flexible');
    $bannerAlt = '';
    $bannerBlockId = null;

    if (! $bannerImage) {
        $first = $item->blocks
            ->where('editor_name', 'default')
            ->where('parent_id', null)
            ->first();

        if ($first && $first->type === 'image') {
            $bannerImage = $first->image('image', 'desktop');
            $bannerAlt = $first->imageAltText('image');
            $bannerBlockId = $first->id;
        }
    }
@endphp

@section('css')<link rel="stylesheet" href="/template/css/build/page-static.css?v=2">@endsection

@section('content')

    <main id="main">

        <!-- =================================================== Баннер ==== -->
        {{-- С картинкой — как «О нас»/«Оплата»: фото фоном, белый текст поверх
             градиента. Без картинки — цветная подложка, как у 404 --}}
        <section class="page-banner page-static {{ $bannerImage ? 'page-banner--overlay page-static--photo' : '' }} container"
                 aria-labelledby="page-title">
            @if ($bannerImage)
                <img class="page-banner__photo" src="{{ $bannerImage }}" alt="{{ $bannerAlt }}">
            @endif

            <div class="page-banner__body">
                <nav class="page-banner__crumbs" aria-label="Хлебные крошки" itemscope itemtype="http://schema.org/BreadcrumbList">
                    <span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                        <a class="page-banner__crumb" href="/" itemprop="item"><span itemprop="name">Главная</span></a>
                        <meta itemprop="position" content="1">
                    </span>
                    @foreach ($breadcrumbs as $i => $crumb)
                        <span aria-hidden="true"> / </span>
                        @if ($loop->last)
                            <span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                                <span itemprop="name" aria-current="page">{{ $crumb->title }}</span>
                                <meta itemprop="position" content="{{ $i + 2 }}">
                            </span>
                        @else
                            <span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                                <a class="page-banner__crumb" href="/{{ $crumb->nestedSlug }}" itemprop="item"><span itemprop="name">{{ $crumb->title }}</span></a>
                                <meta itemprop="position" content="{{ $i + 2 }}">
                            </span>
                        @endif
                    @endforeach
                </nav>

                <h1 class="page-banner__title" id="page-title">{{ $item->title }}</h1>

                @if ($item->description)
                    <div class="page-static__lead">{!! $item->description !!}</div>
                @endif
            </div>
        </section>

        {{-- Блоки Twill: четыре частых типа рендерятся представлениями нового
             дизайна (newdesing/blocks/*), остальные — дефолтными view старого
             дизайна (cooperation / market_current_city_adresses специфичны
             для «Контактов» со своим шаблоном, products пуст) --}}
        {!! $item->renderBlocks([
            'wyswyg' => 'newdesing.blocks.wyswyg',
            'image' => 'newdesing.blocks.image',
            'youtube' => 'newdesing.blocks.youtube',
            'requisites' => 'newdesing.blocks.requisites',
        ], ['bannerBlockId' => $bannerBlockId]) !!}

    </main>
@endsection
