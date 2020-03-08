<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('/fonts/stylesheet.css')}}" type="text/css" charset="utf-8">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.6.2/css/bootstrap-slider.min.css">
    <link rel="stylesheet" href="{{asset('/css/custom.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />


    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.6.2/bootstrap-slider.min.js"></script>

    @yield('assetcarousel')
    <script src="{{asset('/js/custom.js')}}"></script>

    <title>Hello, world!</title>
</head>

<body @yield('profileBody')>
    <!-- ШАПКА BEGIN -->
    <div class="container-fluid navbar-background sticky-top">
        <div class="container">
            <div class="row">
                <nav class="navbar navbar-expand-lg navbar-light nc-navbar col ">
                    <div class="d-flex flex-column">
                        <a class="navbar-brand nc-navbar-brand" href="{{route('index')}}">
                            <div class="d-flex align-items-center">
                                <img class="img-fluid align-self-center" src="{{asset('images/logo.png')}}" alt="">
                                <div class="align-self-center ml-1 d-flex flex-column nc-logo-text">
                                    <span>Night</span>
                                    <span>Cherry</span>
                                </div>
                            </div>
                        </a>
                        <p class="nc-top-info">
                            Информация представлена<br> для лиц строго 18+
                        </p>
                    </div>

                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('index')}}">Индивидуалки</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('salons')}}">Салоны</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('onmap')}}">На карте</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('user.profiles.create')}}">Добавить анкету</a>
                            </li>
                        </ul>

                        <div class="form-inline my-2 my-lg-0">
                            @if (Route::has('login'))
                            <div class="top-right links d-flex">
                                @auth
                                
                                
                                
                                    <a id="navbarDropdown" class="btn mr-sm-3" href="#" role="button" data-toggle="dropdown">
                                    <img src="{{asset('images/user.png')}}" class="mr-2" alt="">
                                    {{Auth::user()->name}}</a>

                                    <div class="dropdown-menu dropdown-menu-right dropdown-nc-samara" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('user') }}">
                                            Личный кабинет</a>

                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                                document.getElementById('logout-form').submit();">
                                        Выйти
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                        </form>

                                       
                                    </div>

                                    
                                

                                @else
                                <a class="btn mr-sm-3" href="{{ route('login') }}">
                                    <img src="{{asset('images/user.png')}}" class="mr-2" alt="">
                                    Вход</a>

                                @if (Route::has('register'))
                                <button class="btn btn-outline-light my-2 my-sm-0 nc-reg-button"><a
                                        href="{{ route('register') }}">Регистрация</a></button>
                                @endif
                                @endauth
                            </div>
                            @endif
                        </form>
                    </div>
                </nav>
            </div>
        </div>

    </div>
    <!-- ШАПКА END -->

    @yield('content')
    @yield('scripts')
    <!-- ПОДВАЛ BEGIN -->
    <div class="container-fluid nc-footer">
        <div class="container">
            <div class="row nc-bg-image">
                <div class="col-md-5 col-sm-12 nc-footer-col-left">
                    <div class="align-self-center ml-1 d-flex flex-column nc-logo-text">
                        <span>Night</span>
                        <span>Cherry</span>
                    </div>
                    <p>
                        Для всех, кто желает хорошо отдохнуть и незабываемо провести свой
                        досуг в компании прелестных девушек по вызову, предлагается
                        огромный арсенал анкет местных путан! Лучшие проститутки Москвы
                        способны не только вас удовлетворить, а и удивить своими умениями и
                        талантами. Здесь вы найдете всю необходимую информацию
                        относительно каждой шлюхи Москвы высшего класса. Каждый
                        мужчина сможет подобрать ту самую проститутку, которая сделает
                        его интимную жизнь ярче и насыщеннее.
                    </p>
                    <p>
                        Администрация не несет ответственности
                        за размещенную пользователями информацию.
                    </p>
                    <p>
                        Email: info@ns-samara.com
                        2019-2020 Copyright by ns-samara.com
                    </p>
                    <a href="{{ route('archived') }}">Архив</a>
                </div>
            </div>
        </div>
    </div>
    <!-- ПОДВАЛ END -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    @yield('google_api_autocomplete')

</body>

</html>