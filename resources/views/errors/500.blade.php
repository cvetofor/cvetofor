@extends(config('is_new_desing') ? 'newdesing.app' : 'layouts.app')

@section('content')
    @if(config('is_new_desing'))
        @include('newdesing.errors.500')
    @else
    <div class="heading">
        <div class="container">
            <div class="heading__row">
                <div class="title-page">
                    <h1 class="h1">Произошла ошибка!</h1>
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
                            <p>Мы уже знаем о ней, попробуйте повторите попытку позже</p>
                        </div><a class="button button--green return-to-mainpage-button" href="/">На главную</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection
