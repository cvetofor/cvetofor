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
                            <div class="profile" data-form-wrapper="profile" data-form="profile">
                                <div class="box">
                                    <form class="form invalid" data-validate-form="" data-form-body="" method="POST" action="{{ route('profile.update') }}">
                                        @csrf
                                        <div class="fields fields--gap-20-30">
                                            <div class="inputholder inputholder--width-half form__inputholder">
                                                <label class="inputholder__label" data-default-label="data-default-label">Фамилия*</label>
                                                <input class="inputholder__input" name="last_name" value="{{ auth()->user()->last_name }}" type="text"
                                                    placeholder="Фамилия*" data-required="" data-text-error="surname" />
                                                @error('last_name')
                                                    <span class="error-text" style="display: block" data-error-text="">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="inputholder inputholder--width-half form__inputholder">
                                                <label class="inputholder__label" data-default-label="data-default-label">Имя*</label>
                                                <input class="inputholder__input" type="text" name="name" value="{{ auth()->user()->name }}"
                                                    placeholder="Имя*" data-required="" data-text-error="name" />
                                                @error('name')
                                                    <span class="error-text" style="display: block" data-error-text="">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="inputholder inputholder--width-half form__inputholder">
                                                <label class="inputholder__label" data-default-label="data-default-label">Отчество</label>
                                                <input class="inputholder__input" name="second_name" value="{{ auth()->user()->second_name }}" type="text"
                                                    placeholder="Отчество" />
                                                @error('second_name')
                                                    <span class="error-text" style="display: block" data-error-text="">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="inputholder inputholder--width-half form__inputholder">
                                                <label class="inputholder__label" data-default-label="data-default-label">Телефон*</label>
                                                <input class="inputholder__input" name="phone" value="{{ auth()->user()->phone }}" type="tel"
                                                    placeholder="+7 (777) 000 00-00" data-required="" data-mask-tel="" data-text-error="phone" />
                                                @error('phone')
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
