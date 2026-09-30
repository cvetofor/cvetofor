{{-- Фрагмент ошибки 500 в новом дизайне. Не расширяет лейаут сам:
     подключается диспетчером resources/views/errors/500.blade.php,
     который выбирает родителя (@extends с динамическим родителем) и
     отдаёт этот фрагмент в @yield('content') лейаута newdesing.app.
     Стили — в общем style.css, блок .page-error --}}

<main id="main">

    <!-- =================================================== Баннер ==== -->
    <section class="page-banner page-error container" aria-labelledby="error-title">
        <div class="page-banner__body">
            <nav class="page-banner__crumbs" aria-label="Хлебные крошки">
                <a class="page-banner__crumb" href="/">Главная</a>
                <span aria-hidden="true"> / </span>
                <span aria-current="page">Ошибка 500</span>
            </nav>

            <h1 class="page-banner__title" id="error-title">Произошла ошибка!</h1>
            <p class="page-error__note">
                Мы уже знаем о ней, попробуйте повторить попытку позже.
            </p>

            <div class="page-error__actions">
                <a class="btn btn--hero page-error__btn" href="{{ url()->current() }}">Обновить страницу</a>
                <a class="btn btn--hero-outline page-error__btn" href="/">На главную</a>
            </div>
        </div>
    </section>

</main>
