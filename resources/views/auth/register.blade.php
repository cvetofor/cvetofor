@extends('layouts.app')


@section('content')
    <div class="heading heading--small-banner">
        <div class="container">
            <div class="heading__row" style="background-image: url(/dist/img/image-content/heading-small-pic.jpg);">
                <div class="breadcrumbs"><span class="breadcrumbs__item"><a href="/"><span>Главная</span></a></span><span
                        class="breadcrumbs__item"><span>Регистрация</span></span>
                </div>
                <div class="title-page">
                    <h1 class="h1">Регистрация</h1>
                </div>
            </div>
        </div>
        <div class="page">
            <div class="section error404">
                <div class="container">
                    <div class="error404__content">
                        <div class="error404__text-wrap">
                            <div class="error404__text">
                            </div><a class="button button--green return-to-mainpage-button" href="/">На главную</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            modal.show("registration");
        })
    </script>
@endpush
