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
                <span aria-current="page">Личный кабинет</span>
            </nav>
            <h1 class="profile-head__title">Личный кабинет</h1>
        </div>

        <!-- ========================================== Данные профиля ==== -->
        <div class="section container profile">
            @include('newdesing.parts.profile-menu')

            <div class="profile__content">
                @php
                    $user = auth()->user();
                    // Маска телефона форматирует только ввод (блок №12), значение
                    // из БД лежит без скобок — приводим его к виду поля при выводе
                    $phone = old('phone', $user->phone);
                    if ($phone && preg_match('/^\+7(\d{3})(\d{3})(\d{2})(\d{2})$/', $phone, $matches)) {
                        $phone = "+7 ({$matches[1]}) {$matches[2]}-{$matches[3]}-{$matches[4]}";
                    }
                @endphp

                {{-- Нативная отправка: ProfileController@update отвечает
                     редиректом back() c флеш-сессией, а не JSON, поэтому
                     AJAX-контракт [data-form] здесь не подходит. Ошибки
                     валидации приходят серверной разметкой — тем же DOM,
                     который строит Cvetofor.setFieldError (см. app.js) --}}
                <form class="panel profile-form" method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    <h2 class="profile-form__title">Персональные данные</h2>

                    <div class="ffield @error('last_name') is-error @enderror">
                        <label class="ffield__label" for="p-last-name">Фамилия <span class="req" aria-hidden="true">*</span></label>
                        <input class="ffield__input" id="p-last-name" name="last_name" type="text"
                               placeholder="Иванов" autocomplete="family-name"
                               value="{{ old('last_name', $user->last_name) }}"
                               @error('last_name') aria-invalid="true" aria-describedby="p-last-name-error" @enderror required>
                    </div>
                    @error('last_name')
                        <p class="field-error" id="p-last-name-error">
                            <img src="/template/assets/icons/field-error.svg" alt="" width="20" height="20"> {{ $message }}
                        </p>
                    @enderror

                    <div class="ffield @error('name') is-error @enderror">
                        <label class="ffield__label" for="p-name">Имя <span class="req" aria-hidden="true">*</span></label>
                        <input class="ffield__input" id="p-name" name="name" type="text"
                               placeholder="Иван" autocomplete="given-name"
                               value="{{ old('name', $user->name) }}"
                               @error('name') aria-invalid="true" aria-describedby="p-name-error" @enderror required>
                    </div>
                    @error('name')
                        <p class="field-error" id="p-name-error">
                            <img src="/template/assets/icons/field-error.svg" alt="" width="20" height="20"> {{ $message }}
                        </p>
                    @enderror

                    <div class="ffield @error('second_name') is-error @enderror">
                        <label class="ffield__label" for="p-second-name">Отчество</label>
                        <input class="ffield__input" id="p-second-name" name="second_name" type="text"
                               placeholder="Иванович" autocomplete="additional-name"
                               value="{{ old('second_name', $user->second_name) }}"
                               @error('second_name') aria-invalid="true" aria-describedby="p-second-name-error" @enderror>
                    </div>
                    @error('second_name')
                        <p class="field-error" id="p-second-name-error">
                            <img src="/template/assets/icons/field-error.svg" alt="" width="20" height="20"> {{ $message }}
                        </p>
                    @enderror

                    <div class="ffield @error('phone') is-error @enderror">
                        <label class="ffield__label" for="p-phone">Телефон <span class="req" aria-hidden="true">*</span></label>
                        <input class="ffield__input js-phone" id="p-phone" name="phone" type="tel"
                               placeholder="+7 (000) 000-00-00" autocomplete="tel"
                               value="{{ $phone }}"
                               @error('phone') aria-invalid="true" aria-describedby="p-phone-error" @enderror required>
                    </div>
                    @error('phone')
                        <p class="field-error" id="p-phone-error">
                            <img src="/template/assets/icons/field-error.svg" alt="" width="20" height="20"> {{ $message }}
                        </p>
                    @enderror

                    <div class="profile-form__actions">
                        <button class="btn btn--primary profile-form__save" type="submit">Сохранить</button>

                        {{-- Удаление — не сабмит формы данных: кнопка type="button",
                             клик обрабатывает блок в app.js (confirm → POST → главная) --}}
                        <button class="btn btn--outline profile-form__delete" type="button"
                                data-delete-profile="{{ route('profile.deleteProfile') }}">
                            <img src="/template/assets/icons/trash.svg" alt="" width="24" height="24">
                            Удалить профиль
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
