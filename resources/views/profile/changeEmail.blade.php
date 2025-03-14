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
                            <div class="change-email" data-form-wrapper="change-email" data-form="change-email">

                                <div class="box">
                                    <form class="form invalid" data-validate-form="" data-form-body="" method="POST"
                                        action="{{ route('profile.changeEmailRequest') }}">
                                        @csrf
                                        <div class="fields fields--gap-20-30">
                                            <div class="inputholder inputholder--width-half form__inputholder">
                                                <label class="inputholder__label" data-default-label="data-default-label">Email*</label>
                                                <input class="inputholder__input" name="email" type="email" value="{{ auth()->user()->email }}" data-required=""
                                                    data-email="" data-text-error="email" />
                                                @error('email')
                                                    <span class="error-text" style="display: block" data-error-text="">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form__buttonholder">
                                            <div class="buttonholder" data-form-trigger="">
                                                <button class="form__button button button--green submit-button" disabled="" data-form-button=""><span>Сохранить
                                                        данные</span></button>
                                            </div><span class="form__info">При сохранении данных, на новый адрес будет отправлено письмо для подтверждения.
                                                Изменение вступит в силу только после подтверждения.</span>
                                        </div>
                                    </form>
                                     @if (session()->get('success'))
                                        <div class="notification notification--info" data-notification="confirm-personal-changes">
                                            <div class="notification__content">
                                                <svg class="notification__icon">
                                                    <use href="#icon-exclamation-mark"></use>
                                                </svg><span class="notification__text">Отправили код подтверждения на вашу почту</span>
                                            </div>
                                            {{-- <div class="notification-button" data-modal-open="personal-confirm-changes"><span class="button__title">Подтвердить</span>
                                                <svg class="button__icon">
                                                    <svg class="notification__icon">
                                                        <use href="#icon-check"></use>
                                                    </svg>
                                                </svg>
                                            </div> --}}
                                        </div>
                                     @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
