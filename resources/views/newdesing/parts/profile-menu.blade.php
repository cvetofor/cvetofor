{{--
    Меню личного кабинета — общее для трёх страниц (/profile,
    /profile/orders, /profile/change/password). Состав из старого
    profile/components/menu.blade.php: «Сменить E-mail» не переносится
    (в старом меню пункт был закомментирован). Выход — POST-форма
    на роут logout (GET-выхода нет, Auth::routes()).
    На мобильной ширине — горизонтальная лента чипов над контентом,
    на десктопе — вертикальная панель (стили в page-profile.css).
--}}
<aside class="profile__aside">
    <nav class="profile-nav" aria-label="Меню личного кабинета">
        <ul class="profile-nav__list">
            <li>
                <a class="profile-nav__link @if (request()->routeIs('profile.index')) is-active @endif"
                   href="{{ route('profile.index') }}"@if (request()->routeIs('profile.index')) aria-current="page"@endif>
                    Персональные данные
                </a>
            </li>
            <li>
                <a class="profile-nav__link @if (request()->routeIs('profile.orders')) is-active @endif"
                   href="{{ route('profile.orders') }}"@if (request()->routeIs('profile.orders')) aria-current="page"@endif>
                    История заказов
                </a>
            </li>
            <li>
                <a class="profile-nav__link @if (request()->routeIs('profile.changePassword')) is-active @endif"
                   href="{{ route('profile.changePassword') }}"@if (request()->routeIs('profile.changePassword')) aria-current="page"@endif>
                    Сменить пароль
                </a>
            </li>
        </ul>
    </nav>

    <form class="profile-nav__exit" action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="profile-nav__link profile-nav__link--exit" type="submit">Выйти</button>
    </form>
</aside>
