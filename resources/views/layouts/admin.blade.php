<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }} @yield('page')</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('/admin/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('/admin/dist/css/adminlte.min.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div id="app">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav nav-pills nav-sidebar d-flex justify-content-between align-items-center">
        <div class="nav-item">
            <a class="nav-link" href="{{ route('user.profiles.create') }}"><p><img class="nav-icon" src="{{asset('/admin/icons/users.png') }}" alt="Пользователи"> Создать анкету</p></a>
        </div>
        @if(Auth::user()->is_admin)
        <div class="nav-item">
            <a class="nav-link" href="{{ route('admin.rates.create') }}"><p><img class="nav-icon" src="{{asset('/admin/icons/users.png') }}" alt="Пользователи"> Создать тариф</p></a>
        </div>
        <div class="nav-item">
            <a class="nav-link" href="{{ route('admin.promotionals.create') }}"><p><img class="nav-icon" src="{{asset('/admin/icons/users.png') }}" alt="Пользователи"> Создать промокод</p></a>
        </div>

        <div class="nav-item">
            <p class="nav-link">
                <img src="{{asset('/admin/icons/userbalance.png')}}">
                Общий баланс: {{Auth::user()->user_balance}}
            </p>
        </div>
        <div class="nav-item">
            <p class="nav-link">
                <img src="{{asset('/admin/icons/ticketmessage.png')}}">
                Сообщения: {{Auth::user()->user_balance}}
            </p>    
        </div>
        <div class="nav-item">
            <p class="nav-link">
                <button data-toggle="modal" data-target="#payment" class="btn btn-success" style="padding: 0px 7.5px;"><img src="{{asset('/admin/icons/balanceup.png')}}"> Пополнить баланс</button>
            </p>     
        </div>
        @else
        <div class="nav-item">
            <a class="nav-link" href="{{ route('user.profiles.create') }}"><p><img class="nav-icon" src="{{asset('/admin/icons/users.png') }}" alt="Пользователи"> Создать анкету</p></a>
        </div>

        <div class="nav-item">
            <p class="nav-link">
                <img src="{{asset('/admin/icons/userbalance.png')}}">
                Общий баланс: {{Auth::user()->user_balance}}
            </p>
        </div>
        <div class="nav-item">
            <p class="nav-link">
                <img src="{{asset('/admin/icons/ticketmessage.png')}}">
                Сообщения: {{Auth::user()->user_balance}}
            </p>    
        </div>
        <div class="nav-item">
            <p class="nav-link">
                <button data-toggle="modal" data-target="#payment" class="btn btn-success" style="padding: 0px 7.5px;"><img src="{{asset('/admin/icons/balanceup.png')}}"> Пополнить баланс</button>
            </p>     
        </div>
        @endif
    </ul>


    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
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
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
      <img src="{{ asset('/admin/dist/img/logo.png') }}" alt="NC-Samara" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">NC-Samara</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          @if(Auth::user() == null)
          @else
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            @if(Auth::user()->is_admin)
            
                <li class="nav-item {{ Request::path() === 'admin/profiles' ? 'admin-li-active' : ''}}">
                    <a class="nav-link" href="{{ route('admin.adminprofiles') }}"><p><img class="nav-icon" src="{{asset('/admin/icons/users.png') }}" alt="Пользователи"> Пользователи</p></a>
                </li>

                <li class="nav-item {{ Request::path() === 'user/salons' ? 'admin-li-active' : ''}}">
                    <a class="nav-link" href="{{ route('user.salons.index') }}"><p><img src="{{asset('/admin/icons/salon.png') }}" alt="Мой салон"> Мой салон</p></a>
                </li>

                <li class="nav-item {{ Request::path() === 'admin/rates' ? 'admin-li-active' : ''}}">
                    <a class="nav-link" href="{{ route('admin.rates.index') }}"><p><img src="{{asset('/admin/icons/rates.png') }}" alt="Тарифы"> Тарифы</p></a>
                </li>

                <li class="nav-item {{ Request::path() === 'admin/promotionals' ? 'admin-li-active' : ''}}">
                    <a class="nav-link" href="{{ route('admin.promotionals.index') }}"><p><img src="{{asset('/admin/icons/promocodes.png') }}" alt="Промокоды"> Промокоды</p></a>
                </li>

                <li class="nav-item {{ Request::path() === 'admin/bonuses' ? 'admin-li-active' : ''}}">
                    <a class="nav-link" href="{{ route('admin.bonuses.index') }}"><p><img src="{{asset('/admin/icons/bonuses.png') }}" alt="Бонусы"> Бонусы</p></a>
                </li>

                <li class="nav-item {{ Request::path() === 'admin/tickets' ? 'admin-li-active' : ''}}"><a class="nav-link" href="{{ route('tickets.index') }}">
                    <p><img src="{{asset('/admin/icons/tickets.png') }}" alt="Техническая поддержка"> Техническая поддержка</p></a>
                </li>


            @else

                    <li class="nav-item {{ Request::path() === 'user/profiles' ? 'admin-li-active' : ''}}">
                        <a class="nav-link" href="{{ route('user.profiles.index') }}"><p><img class="nav-icon" src="{{asset('/admin/icons/users.png') }}" alt="Мои анкеты"> Мои анкеты</p></a>
                    </li>

                    <li class="nav-item {{ Request::path() === 'user/salons' ? 'admin-li-active' : ''}}">
                        <a class="nav-link" href="{{ route('user.salons.index') }}"><p><img src="{{asset('/admin/icons/salon.png') }}" alt="Мой салон"> Мой салон</p></a>
                    </li>

                    <li class="nav-item {{ Request::path() === 'user/tickets' ? 'admin-li-active' : ''}}">
                        <a class="nav-link" href="{{ route('tickets.index') }}"><p><img src="{{asset('/admin/icons/tickets.png') }}" alt="Техническая поддержка"> Техническая поддержка</p></a>
                    </li>
                
            @endif

                @if(Auth::user()->profiles()->count())
                    <hr>
                    <li class="nav-header">Информация о моих анкетах</li>
                    <li class="nav-item"><i class="nav-icon far fa-circle text-yellow"></i> <span style="color: #fff">Всего: {{ Auth::user()->profiles()->count()}}</span></li>
                    <li class="nav-item"><i class="nav-icon far fa-circle text-green"></i> <span style="color: #fff">Активно: {{ Auth::user()->profiles()->where('is_archived', 0)->count()}}</span></li>
                    <li class="nav-item"><i class="nav-icon far fa-circle text-red"></i> <span style="color: #fff">Не оплаченных: {{ Auth::user()->profiles()->where('is_archived', 1)->count()}}</span></li>
                @endif
            </ul>
          @endif

      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        @yield('content')
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->


    </div>

    <!-- Modal -->
    <div class="modal fade" id="payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Пополнить баланс</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <h6>Баланс на аккаунте: {{ Auth::user()->user_balance }} пойнтов</h6>
                <hr>
                <form action="{{ route('user.makepayment') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="userPayment">Пополнить на сумму:</label>
                        <div class="d-flex">
                            <input name="payment" type="number" step="0.1" id="userPayment"
                               class="form-control @error('payment') is-invalid @enderror"
                               placeholder="Укажите на какую сумму необходимо выполнить пополнение баланса" value="{{ old('payment') }}">
                               <button type="submit" class="btn btn-primary">Пополнить баланс</button>
                        </div>
                        
                        <div id="bonusinfo"></div>

                    </div>
                </form>

                <hr>
                <form action="{{ route('user.promotionalpayment') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="userPromotionalPayment">Указать промокод:</label>
                        <input name="promotionalpayment" type="text" id="userPromotionalPayment"
                               class="form-control @error('promotionalpayment') is-invalid @enderror"
                               placeholder="Укажите промокод для пополнения баланса" value="">

                        <button type="submit" class="btn btn-primary">Использовать промокод</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
        </div>
    </div>
<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{ asset('/admin/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/admin/dist/js/adminlte.js') }}"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="{{ asset('/admin/dist/js/demo.js') }}"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{ asset('/admin/plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
<script src="{{ asset('/admin/plugins/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('/admin/plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
<script src="{{ asset('/admin/plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('/admin/plugins/chart.js/Chart.min.js') }}"></script>

<!-- PAGE SCRIPTS -->
<script src="{{ asset('/admin/dist/js/pages/dashboard2.js') }}"></script>

<script type="text/javascript">

    $('#userPayment').on('input', function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var payment = $("input[name=payment]").val();

        $.ajax({
            type:'POST',
            url:'/user/plusbonusinfo',
            data:{payment:payment},
            success:function(data){
                $('#bonusinfo').text(data);
            }
        });
    })

    </script>
    @yield('script')
    @yield('bonuscheck')
    @yield('footer')
</body>
</html>
