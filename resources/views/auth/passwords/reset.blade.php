@extends('layouts.app')
@section('content')
<div class="heading heading--small-banner">
    <div class="page">
        <div class="main-cols__wrap">
            <div class="container">
                <div class="main-col">
                    <div class="personal">
                        <div class="section">
                            <div class="profile" data-form-wrapper="profile" data-form="profile">
                                <div class="box">
                                    <form class="form" data-validate-form="" data-form-body="" method="POST" action="{{ route('password.update') }}">
                                        @csrf
                                         <input type="hidden" name="token" value="{{ $token }}">
                                        <p>
                                            {{ __('Сбросить пароль') }}
                                        </p>
                                        <div class="fields fields--gap-20-30">

                                            <div class="inputholder inputholder--width-half form__inputholder">
                                                <label class="inputholder__label" data-default-label="data-default-label">E-mail*</label>
                                                <input class="inputholder__input" name="email" value="{{ $email ?? old('email') }}" type="text"
                                                    placeholder="E-mail*" data-required="" required autocomplete="email" autofocus/>
                                                @error('email')
                                                    <span class="error-text" style="display: block" data-error-text="">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="inputholder inputholder--width-half form__inputholder">
                                            </div>

                                            <div class="inputholder inputholder--width-half form__inputholder">
                                                <label class="inputholder__label" data-default-label="data-default-label">Пароль * </label>
                                                <input class="inputholder__input" name="password"  type="password"
                                                    placeholder="*******" data-required="" data-text-error="password" />
                                                @error('password')
                                                    <span class="error-text" style="display: block" data-error-text="">{{ 'Пароли не совпадают' }}</span>
                                                @enderror
                                            </div>
                                            <div class="inputholder inputholder--width-half form__inputholder">
                                            </div>
                                            <div class="inputholder inputholder--width-half form__inputholder">
                                                <label class="inputholder__label" data-default-label="data-default-label">Подтверждение пароля*</label>
                                                <input class="inputholder__input" name="password_confirmation" type="password"  placeholder="*******" data-required=""
                                                data-password-recovery="" data-text-error="passwordLength"/>
                                            </div>
                                        </div>


                                        <div class="form__buttonholder" data-form-trigger="">
                                            <button class="form__button button button--green submit-button" type="submit" data-form-button=""><span>Сбросить пароль</span></button>
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
