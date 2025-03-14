<div class="side-col">
    <div class="box box--padding-20">
        <ul class="sidenav">
            <li class="sidenav__item">
                <a class="sidenav__link {{ request()->routeIs('profile.index') ? 'active' : '' }}" href="{{ route('profile.index') }}">
                    <span class="sidenav__link-title">Персональные данные</span>
                </a>
            </li>
            <li class="sidenav__item">
                <a class="sidenav__link {{ request()->routeIs('profile.orders') ? 'active' : '' }}" href="{{ route('profile.orders') }}">
                    <span class="sidenav__link-title">История заказов</span>
                </a>
            </li>
            <li class="sidenav__item">
                <a class="sidenav__link {{ request()->routeIs('profile.changePassword') ? 'active' : '' }}" href="{{ route('profile.changePassword') }}">
                    <span class="sidenav__link-title">Сменить пароль</span>
                </a>
            </li>
            <li class="sidenav__item">
                <a class="sidenav__link {{ request()->routeIs('profile.changeEmail') ? 'active' : '' }}" href="{{ route('profile.changeEmail') }}">
                    <span class="sidenav__link-title">Сменить E-mail</span>
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
