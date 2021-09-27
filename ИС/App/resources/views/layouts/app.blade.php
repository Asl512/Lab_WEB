<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @guest
        <title>Авторизация</title>
    @else
        <title>{{ $header }}</title>
    @endif

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
            @guest
                <a class="navbar-brand" href="#">
                    Авторизация
                </a>
            @else
                <a class="navbar-brand" href="#">
                    {{ $header }}
                </a>
            @endif
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Войти') }}</a>
                                </li>
                            @endif
                            
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Зарегестрироваться') }}</a>
                                </li>
                            @endif
                        @else
                            @if(Auth::user()->status != 3)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/home') }}">Главная</a>
                                </li>
                            @endif
                            @if(Auth::user()->status == 0)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('myorder') }}">Мои записи</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('order') }}">Корзина</a>
                                </li>
                            @elseif(Auth::user()->status == 1)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('product') }}">Добавить товар</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('staff') }}">Сотрудники</a>
                                </li>
                            @elseif(Auth::user()->status == 2)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('mysuppli') }}">Мои поставки</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('suppli') }}">Сделать поставку</a>
                                </li>
                            @elseif(Auth::user()->status == 3)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('reports') }}">Отчеты</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('everyorder') }}">Все заказы</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('myorderstaff') }}">Взятые заказы</a>
                            </li>
                            <li class="nav-item">
                                    <a class="nav-link" href="{{ url('product') }}">Добавить товар</a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}">Выход</a>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
