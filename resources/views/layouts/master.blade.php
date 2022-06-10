<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Интернет Магазин: @yield('title')</title>

    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/starter-template.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ route('index') }}">Интернет Магазин</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li @if (Route::currentRouteNamed('index')) class="active" @endif><a href="{{ route('index') }}">Все товары</a></li>
                    <li @if (Route::currentRouteNamed('categor*')) class="active" @endif><a href="{{ route('categories') }}">Категории</a>
                    </li>
                    <li @if (Route::currentRouteNamed('basket*')) class="active" @endif><a href="{{ route('basket') }}">В корзину</a></li>
                    <li><a href="{{ route('index') }}">Сбросить проект в начальное состояние</a></li>
                    <li><a href="http://internet-shop.tmweb.ru/locale/en">en</a></li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                            aria-expanded="false">₽<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="http://internet-shop.tmweb.ru/currency/RUB">₽</a></li>
                            <li><a href="http://internet-shop.tmweb.ru/currency/USD">$</a></li>
                            <li><a href="http://internet-shop.tmweb.ru/currency/EUR">€</a></li>
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

    <div class="container">
        <div class="starter-template">
            @if (session()->has('success'))
                <p class="alert alert-success">{{ session()->get('success') }}</p>
            @elseif (session()->has('error'))
                <p class="alert alert-danger">{{ session()->get('error') }}</p>
            @endif

            @if (session()->has('successAdd'))
                <p class="alert alert-success">{{ session()->get('successAdd') }}</p>
            @elseif (session()->has('successRemove'))
                <p class="alert alert-warning">{{ session()->get('successRemove') }}</p>
            @endif

            @yield('content')
        </div>
    </div>
</body>

</html>
