@extends('layouts.app')

@section('content')
    <div class="heading">
        <div class="container">
            <div class="heading__row">
                <div class="breadcrumbs"><span class="breadcrumbs__item"><a href="/"><span>Главная</span></a></span><span
                        class="breadcrumbs__item"><span>Ошибка 404</span></span>
                </div>
                <div class="title-page">
                    <h1 class="h1">Страница не найдена</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="page">
        <div class="section error404">
            <div class="container">
                <div class="error404__content">
                    <div class="error404__text-wrap">
                        <div class="error404__text">
                            <p>К сожалению, мы не можем найти запрашиваемую страницу. Возможно, она была удалена, перемещена
                                или никогда не существовала.</p>
                        </div><a class="button button--green return-to-mainpage-button" href="/">На главную</a>
                    </div>
                    <div class="error404__image-wrap"><img class="error404__image"
                            src="/dist/img/image-content/error404-pic.svg" alt="" /></div>
                </div>
            </div>
        </div>
    </div>
@endsection
