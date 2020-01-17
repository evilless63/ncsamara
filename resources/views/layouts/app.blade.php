<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} @yield('page')</title>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}

</head>

<body>
    <div id="app">

        @if(Session::has('fail'))
        <div class="alert alert-danger">
            {{Session::get('fail')}}
        </div>
        @endif

        @if(Session::has('success'))
        <div class="alert alert-success">
            {{Session::get('success')}}
        </div>
        @endif

        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm sticky-top">
            <div class="container">
                <a class="navbar-brand" style="font-size: 1rem;" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @guest
                    @elseif(Auth::user()->is_admin)
                    <ul class="navbar-nav mr-auto" style="font-size: 0.9em;">

                            <li class="nav-item">
                                    <a class="nav-link" href="{{ route('user.profiles.index') }}">Мои анкеты</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('user.salons.index') }}">Мой салон</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('user.payments') }}">Мой баланс и оплата</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.adminprofiles') }}">Пользователи</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.rates.index') }}">Тарифы</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.promotionals.index') }}">Промокоды</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.bonuses.index') }}">Бонусы</a>
                                </li>

                                <li class="nav-item"><a class="nav-link" href="{{ route('tickets.index') }}">
                                        Техническая поддержка</a>
                                </li>

                    </ul>
                    @else
                    <ul class="navbar-nav mr-auto" style="font-size: 0.9em;">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.profiles.index') }}">Мои анкеты</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.salons.index') }}">Мой салон</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.payments') }}">Мой баланс и оплата</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tickets.index') }}">Техническая поддержка</a>
                        </li>
                    </ul>
                    @endguest
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Войти</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Регистрация</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    Выйти
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
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


    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>

    @yield('google_api_autocomplete')
    @yield('script')
    @yield('bonuscheck')
    @yield('footer')
</body>

</html>
