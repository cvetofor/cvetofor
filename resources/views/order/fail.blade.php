@extends('layouts.app')

@section('content')
    <div class="heading">
        <div class="container">
            <div class="heading__row">
                <div class="breadcrumbs">
                    <span class="breadcrumbs__item">
                        <a href="/">
                            <span>Главная</span>
                        </a>
                    </span>
                    <span class="breadcrumbs__item">
                        <span>Ошибка оплаты</span>
                    </span>
                </div>
                <div class="title-page">
                    <h1 class="h1">Ошибка оплаты</h1>
                </div>
                <div class="text-page">
                </div>
            </div>
        </div>
    </div>
    <div class="page">
        <div class="section">
            <div class="container">
                <div class="box box--padding-40">
                    <div class="status-page">
                        <div class="status-page">
                            <svg class="status-page__icon">
                                <use href="#icon-check-in-square">

                                </use>
                            </svg>
                            <span class="status-page__title">Ошибка оплаты, попробуйте еще раз оплатить заказ в личном кабинете</span>
                            <div class="status-page__text">
                                <p>Перейдите в <a class="link" href="{{ route('profile.orders') }}">личный кабинет</a> для подробной информации</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
