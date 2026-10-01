@extends('newdesing.app')

@section('css')  <link rel="stylesheet" href="/template/css/build/page-success.css?v=20260930">@endsection

@section('content')
    <main id="main">

        <section class="success success--fail container" aria-labelledby="fail-title">
            <p class="success__order">Оплата не прошла</p>

            <div class="success__panel">
                <span class="success__badge" aria-hidden="true">
                    <img src="/template/assets/icons/fail-cross.svg" alt="" width="100" height="100">
                </span>

                <h1 class="success__title" id="fail-title">Ошибка оплаты</h1>
                <p class="success__note">
                    Платёж не удалось завершить. Попробуйте ещё раз оплатить заказ в
                    <a class="success__link" href="{{ route('profile.orders') }}">личном кабинете</a>
                </p>
            </div>
        </section>
    </main>

@endsection
