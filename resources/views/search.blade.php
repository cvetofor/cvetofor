@extends('layouts.app')

@section('content')
    @if ($result->count() === 0)
        <div class="heading heading--big-banner" style="background-image: url(/dist/img/image-content/heading-big-pic.jpg);">
            <div class="container">
                <div class="heading__row">
                    <div class="breadcrumbs">
                        <span class="breadcrumbs__item">
                            <a href="/">
                                <span>Главная</span>
                            </a>
                        </span>
                        <span class="breadcrumbs__item">
                            <span>Поиск</span>
                        </span>
                    </div>
                    <div class="title-page">
                        <h1 class="h1">По вашему запросу “{{ $search }}” ничего не найдено</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="page">
            <div class="section product-filters">
                <div class="container">
                </div>
            </div>
            <div class="section">
                <div class="container">
                    <div class="products__wrap">
                        <a class="button button--green return-to-mainpage-button" href="/">Вернуться на главную</a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="heading heading--big-banner" style="background-image: url(/dist/img/image-content/heading-big-pic.jpg);">
            <div class="container">
                <div class="heading__row">
                    <div class="breadcrumbs">
                        <span class="breadcrumbs__item">
                            <a href="/">
                                <span>Главная</span>
                            </a>
                        </span>
                        <span class="breadcrumbs__item">
                            @if (request()->input('q'))
                                <span>Поиск</span>
                            @elseif(request()->input('product'))
                                <span>{{ request()->input('product') }}</span>
                            @endif


                        </span>
                    </div>
                    <div class="title-page">
                        @if ($seoH1)
                            <h1 class="h1">{{ $seoH1 }} </h1>
                        @else
                            @if (request()->input('q'))
                                <h1 class="h1">По вашему запросу “{{ $search }}”
                                    {{ \App\Services\Helpers::num2word($result->total(), ['найдена', 'найдено', 'найдено']) }} {{ $result->total() }}
                                    {{ \App\Services\Helpers::num2word($result->total(), ['позиция', 'позиций', 'позиций']) }}</h1>
                            @elseif(request()->input('product'))
                                <h1 class="h1">{{ $search }} </h1>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="page">
            @include('components.filter')
            <div class="section">
                <div class="container">
                    @include('components.category', ['paginator' => $result, 'category_id' => 'search'])
                </div>
            </div>

            <div class="section">
                <div class="container">
                    <div class="text-page category_description">
                        <p>{!! $seoText !!}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
