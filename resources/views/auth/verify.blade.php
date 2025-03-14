@extends('layouts.app')

@section('content')
    <div class="heading">
        <div class="container">
            <div class="heading__row">
                <div class="breadcrumbs"><span class="breadcrumbs__item"><a href="/"><span>Главная</span></a></span><span class="breadcrumbs__item"><span>Личный
                            кабинет</span></span>
                </div>
                <div class="title-page">
                    <h1 class="h1">Подтверждение Email адреса</h1>
                </div>
            </div>
        </div>
        <div class="page">
            <div class="main-cols__wrap">
                <div class="container">
                    <div class="side-col">
                        <div class="side-col">
                            <div class="box box--padding-20">
                                <ul class="sidenav">
                                    <li class="sidenav__item">
                                        <a class="sidenav__link {{ request()->routeIs('verification.notice') ? 'active' : '' }}"
                                            href="{{ route('verification.notice') }}">
                                            <span class="sidenav__link-title">Подтверждение Email адреса</span>
                                        </a>
                                    </li>
                                    <li class="sidenav__item">
                                        <a class="sidenav__link {{ request()->routeIs('profile.orders') ? 'active' : '' }}" href="{{ route('profile.orders') }}">
                                            <span class="sidenav__link-title">История заказов</span>
                                        </a>
                                    </li>
                                    <li class="sidenav__item">
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="sidenav__link">
                                                <span class="sidenav__link-title">Выйти</span>
                                                <svg class="sidenav__link-icon">
                                                    <use href="#icon-logout">

                                                    </use>
                                                </svg>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="main-col">
                        <div class="personal">
                            <div class="section">
                                <div class="profile" data-form-wrapper="profile" data-form="profile">
                                    <div class="box">
                                        <form class="form" data-validate-form="" data-form-body="" method="POST" action="{{ route('verification.send') }}">
                                            <p>
                                                {{ __('Прежде чем продолжить, пожалуйста, проверьте свою электронную почту на наличие ссылки для подтверждения.') }}
                                            </p>
                                            <p>
                                                {{ __('Если вы не получили электронное письмо') }},
                                            </p>
                                            @if (session('message'))
                                                <div class="alert alert-success" style="color:green;" role="alert">
                                                    {{ __('На ваш адрес электронной почты была отправлена новая ссылка для подтверждения.') }}
                                                </div>
                                            @endif
                                            @csrf
                                            <div class="form__buttonholder" data-form-trigger="">
                                                <button class="form__button button button--green submit-button" data-form-button=""><span>Отправить код
                                                        подтверждения повторно</span></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
