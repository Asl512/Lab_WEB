<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Вход</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="css/aut.css" rel="stylesheet">
      
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}">Главная</a>
                        <a href="{{ route('logout') }}">Выход</a>
                    @else
                        <a href="{{ route('login') }}">Войти</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Зарегестрироваться</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Склад<br>промышленного предприятия
                </div>

            </div>
        </div>
    </body>
</html>
