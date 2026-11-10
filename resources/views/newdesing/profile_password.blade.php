@extends('newdesing.app')

@section('css')
    <link rel="stylesheet" href="/template/css/build/page-profile.css?v=20260930">
@endsection

@section('content')

    <main id="main">

        <!-- ================================================== Шапка ==== -->
        <div class="container profile-head">
            <nav class="profile-head__crumbs" aria-label="Хлебные крошки">
                <a class="profile-head__crumb" href="/">Главная</a>
                <span aria-hidden="true"> / </span>
                <a class="profile-head__crumb" href="{{ route('profile.index') }}">Личный кабинет</a>
                <span aria-hidden="true"> / </span>
                <span aria-current="page">Сменить пароль</span>
            </nav>
            <h1 class="profile-head__title">Сменить пароль</h1>
        </div>

        <!-- ============================================== Смена пароля ==== -->
        <div class="section container profile">
            @include('newdesing.parts.profile-menu')

            <div class="profile__content">
                {{-- Тот же эндпоинт, что у формы данных: ProfileController@update
                     различает смену пароля по наличию поля «password». Флеш-ответы
                     «Пароль измёнен»/«Пароли не совпадают» приходят сессией --}}
                <form class="panel profile-form" method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    <h2 class="profile-form__title">Новый пароль</h2>

                    @if (session('success'))
                        <p class="notice notice--ok" role="status">{{ session('success') }}</p>
                    @endif
                    @if (session('error'))
                        <p class="notice notice--error" role="alert">{{ session('error') }}</p>
                    @endif

                    <div class="ffield @error('password') is-error @enderror">
                        <label class="ffield__label" for="pw-old">Старый пароль <span class="req" aria-hidden="true">*</span></label>
                        <input class="ffield__input" id="pw-old" name="password" type="password"
                               placeholder="·············" autocomplete="current-password"
                               @error('password') aria-invalid="true" aria-describedby="pw-old-error" @enderror required>
                    </div>
                    @error('password')
                        <p class="field-error" id="pw-old-error">
                            <img src="/template/assets/icons/field-error.svg" alt="" width="20" height="20"> {{ $message }}
                        </p>
                    @enderror

                    <div class="ffield @error('new_password') is-error @enderror">
                        <label class="ffield__label" for="pw-new">Новый пароль <span class="req" aria-hidden="true">*</span></label>
                        <input class="ffield__input" id="pw-new" name="new_password" type="password"
                               placeholder="·············" autocomplete="new-password"
                               @error('new_password') aria-invalid="true" aria-describedby="pw-new-error" @enderror required>
                        <p class="ffield__hint">От 6 до 30 символов, не такой же, как старый</p>
                    </div>
                    @error('new_password')
                        <p class="field-error" id="pw-new-error">
                            <img src="/template/assets/icons/field-error.svg" alt="" width="20" height="20"> {{ $message }}
                        </p>
                    @enderror

                    <div class="ffield @error('new_password_confirmation') is-error @enderror">
                        <label class="ffield__label" for="pw-new-2">Повторите новый пароль <span class="req" aria-hidden="true">*</span></label>
                        <input class="ffield__input" id="pw-new-2" name="new_password_confirmation" type="password"
                               placeholder="·············" autocomplete="new-password"
                               @error('new_password_confirmation') aria-invalid="true" aria-describedby="pw-new-2-error" @enderror required>
                    </div>
                    @error('new_password_confirmation')
                        <p class="field-error" id="pw-new-2-error">
                            <img src="/template/assets/icons/field-error.svg" alt="" width="20" height="20"> {{ $message }}
                        </p>
                    @enderror

                    <button class="btn btn--primary profile-form__save" type="submit">Сохранить</button>
                </form>
            </div>
        </div>
    </main>
@endsection
