<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ route('index') }}">{{ __('main.online_shop') }}</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li @if (Route::currentRouteNamed('index')) class="active" @endif><a href="{{ route('index') }}">Все товары</a></li>
                <li @if (Route::currentRouteNamed('categor*')) class="active" @endif><a href="{{ route('categories') }}">Категории</a>
                </li>
                <li @if (Route::currentRouteNamed('basket*')) class="active" @endif><a href="{{ route('basket') }}">В корзину</a></li>

                {{-- @can ('reset', auth()->user())
                    <li><a href="{{ route('reset') }}">Сбросить проект в начальное состояние</a></li>
                @endcan --}}

                <li><a href="{{ route('changeLocale', __('main.set_lang')) }}">{{ __('main.set_lang') }}</a></li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                        aria-expanded="false">
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">

                    </ul>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                @if (auth()->check())
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <input type="submit" class="btn btn-link navbar-btn navbar-link" value="Выйти">
                    </form>
                @else
                    <li><a href="{{ route('register') }}">Регистрация</a></li>
                    <li><a href="{{ route('login') }}">Войти</a></li>
                @endif
            </ul>

            @if (auth()->check())
                @if (auth()->user()->isAdmin())
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="{{ route('admin.order') }}">панель администратора</a></li>
                    </ul>
                @else
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="{{ route('person.order') }}">мои заказы</a></li>
                    </ul>
                @endif
            @endif
        </div>
    </div>
</nav>
