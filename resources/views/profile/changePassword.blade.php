@extends('layouts.app')

@push('styles')
<meta name="robots" content="noindex">
@endpush

@section('content')
<div class="heading">
    <div class="container">
        <div class="heading__row">
            <div class="breadcrumbs"><span class="breadcrumbs__item"><a href="/"><span>Главная</span></a></span><span class="breadcrumbs__item"><span>Личный
                        кабинет</span></span>
            </div>
            <div class="title-page">
                <h1 class="h1">Личный кабинет</h1>
            </div>
        </div>
    </div>
</div>
<div class="page">
    <div class="main-cols__wrap">
        <div class="container">
            @include('profile.components.menu')
            <div class="main-col">
                <div class="personal">
                    <div class="section">
                        <div class="change-password" data-form-wrapper="change-password" data-form="change-password">
                            <div class="box">
                                <form class="form invalid" data-validate-form="" data-form-body="" method="POST" action="{{ route('profile.update') }}">
                                    @csrf
                                    <div class="fields fields--gap-20-30">
                                        <div class="inputholder form__inputholder">
                                            <label class="inputholder__label" data-default-label="data-default-label">Старый пароль*</label>
                                            <input class="inputholder__input inputholder__input--width-half" name="password" type="password"
                                                placeholder="·············" data-required="" data-text-error="password" />
                                            @if(session()->get('error'))
                                            <span class="error-text" style="display: block" data-error-text="">{{ session()->get('error') }}</span>
                                            @endif
                                            @if(session()->get('success'))
                                            <span style="display: block; color:green;" data-error-text="">{{ session()->get('success') }}</span>
                                            @endif
                                        </div>
                                        <div class="inputholder inputholder--width-half form__inputholder">
                                            <label class="inputholder__label" data-default-label="data-default-label">Новый пароль*</label>
                                            <input class="inputholder__input" type="password" placeholder="·············" name="new_password" data-required=""
                                                data-password-recovery="" data-text-error="passwordLength" />
                                            @error('new_password')
                                            <span class="error-text" style="display: block" data-error-text="">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="inputholder inputholder--width-half form__inputholder">
                                            <label class="inputholder__label" data-default-label="data-default-label">Повторите новый пароль*</label>
                                            <input class="inputholder__input" type="password" placeholder="·············" data-required=""
                                                name="new_password_confirmation" data-equal="data-password-recovery" data-text-error="passwordEqual" />
                                            @error('new_password_confirmation')
                                            <span class="error-text" style="display: block" data-error-text="">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form__buttonholder" data-form-trigger="">
                                        <button class="form__button button button--green submit-button" disabled="" data-form-button=""><span>Сохранить
                                                данные</span></button>
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
@endsection