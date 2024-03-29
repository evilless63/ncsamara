<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <title>{{ config('app.name', 'Laravel') }} @yield('page')</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('/admin/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('/admin/dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/admin/dist/css/cropper.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div id="app" class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">

        @if(Auth::user() != null)
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>


        <li class="d-none d-md-block d-lg-block nav-item">
          <p class="nav-link">
            <i class="fas fa-dollar-sign"></i>
            <span class="d-none d-md-inline">баланс: </span> {{Auth::user()->user_balance}} <span class="d-none d-md-inline">пойнтов</span>
          </p>
        </li>
        
        <li class="nav-item d-none d-md-block d-lg-block nav-item">
          <p class="nav-link">
            <button data-toggle="modal" data-target="#payment" class="btn btn-success" style="padding: 0px 7.5px;">Пополнить баланс</button>
          </p>
        </li>

        <li class="d-block d-sm-none nav-item">
          <p class="nav-link">
            <i class="fas fa-dollar-sign"></i>
            <span data-toggle="modal" data-target="#payment">{{Auth::user()->user_balance}}, пополнить</span>
          </p>
        </li>

        <li class="nav-item">
          <p class="nav-link">
            <i class="far fa-comments"></i>
            <span class="d-none d-md-inline">Сообщения: </span>{!!Auth::user()->tickets->where('completed_at', '=', null )->count()
            ? '<a href="'.route('tickets.index').'">'.Auth::user()->tickets->where('completed_at', '=', null )->count() .'</a>'
            : '0'!!}
          </p>
        </li>
        

        @endif

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
        <li class="nav-item dropdown d-none d-md-block d-lg-block" style="color:#6c030e !important;font-size: 1.2em;line-height: 1.2em;">
          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false" v-pre>
            {{ Auth::user()->name }} <span class="caret"></span>
          </a>

          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
              Выйти
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
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
      <div class="d-flex">
        <a href="{{ url('/') }}" class="brand-link" style="position:relative">
          <img src="{{ asset('/admin/dist/img/logo.png') }}" alt="NC-Samara" class="brand-image img-circle elevation-3"
            style="opacity: .8">
          <span class="brand-text font-weight-light">NC-Samara</span>
        </a>
        <div class="d-block d-sm-none" data-widget="pushmenu" style="width: 90px;
        background: #6c030e;
        position: relative;">
          <i class="fa fa-times" aria-hidden="true" style=" color: rgb(255, 120, 120);
          padding: 10px 13px;
          border: 1px solid;
          top: 9px;
          left: 19px;
          position: absolute;
          border-radius: 78px;"></i>
        </div>
      </div>
      

      <!-- Sidebar -->
      <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">

          <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->

          @if(Auth::user() !== null)

          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            @guest

            @else
            <li class="nav-item has-treeview d-block d-sm-none">
              <a href="#" class="nav-link">
                <i class="far fa-user"></i>
                <p>
                  {{ Auth::user()->name }}
                  
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('logout') }}" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();" class="nav-link">
                    <i class="fas fa-sign-out-alt"></i>
                    <p>Выйти</p>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                    </form>
                  </a>
                </li>
              </ul>
            </li>
            @endguest

            <li class="nav-item {{ Request::path() === 'user' ? 'admin-li-active' : ''}}">

              <a class="nav-link" href="{{ route('user') }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Личный кабинет</p>
              </a>
            </li>

            <li class="nav-item {{ Request::path() === 'user/profiles' ? 'admin-li-active' : ''}}">
              <a class="nav-link" href="{{ route('user.profiles.index') }}">
                <i class="nav-icon fas fa-copy"></i>
                <p>Мои анкеты</p>
              </a>
            </li>

            <li class="nav-item {{ Request::path() === 'user/profile/create' ? 'admin-li-active' : ''}}">
              <a class="nav-link" href="{{ route('user.profiles.create') }}">
                <i class="nav-icon far fa-plus-square"></i>
                <p>Добавить
                  анкету</p>
              </a>
            </li>

            <li class="nav-item {{ Request::path() === 'user/salons' ? 'admin-li-active' : ''}}">
              <a class="nav-link" href="{{ route('user.salons.index') }}">
                <i class="nav-icon far fa-image"></i>
                <p>Мои баннеры</p>
              </a>
            </li>

            <li class="nav-item {{ Request::path() === 'user/salons/create' ? 'admin-li-active' : ''}}">
              <a class="nav-link" href="{{ route('user.salons.create') }}">
                <i class="nav-icon far fa-plus-square"></i>
                <p>Добавить баннер</p>
              </a>
            </li>

            <li class="nav-item {{ Request::path() === 'user/payments' ? 'admin-li-active' : ''}}">
              <a class="nav-link" href="{{ route('user.payments') }}">
                <i class="fas fa-comments-dollar"></i>
                <p>Мой баланс</p>
              </a>
            </li>

            <li class="nav-item {{ Request::path() === 'user/tickets' ? 'admin-li-active' : ''}}">
              <a class="nav-link" href="{{ route('tickets.index') }}">
                <i class="fas fa-info-circle"></i>
                <p>Техническая
                  поддержка</p>
              </a>
            </li>

            @if(Auth::user()->is_admin)
            <hr>
            <li class="nav-item {{ Request::path() === 'admin/profiles' ? 'admin-li-active' : ''}}">
              <a class="nav-link" href="{{ route('admin.adminprofiles') }}">
                <i class="fas fa-users"></i>
                <p>Пользователи
                </p>
              </a>
            </li>

            <li class="nav-item {{ Request::path() === 'admin/rates' ? 'admin-li-active' : ''}}">
              <a class="nav-link" href="{{ route('admin.rates.index') }}">
                <i class="far fa-file-alt"></i>
                <p>Тарифы для анкет</p>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{ route('admin.rates.create') }}">
                <i class="nav-icon far fa-plus-square"></i>
                <p>Создать тариф
                  для
                  анкеты</p>
              </a>
            </li>

            <li class="nav-item {{ Request::path() === 'admin/salonrates' ? 'admin-li-active' : ''}}">
              <a class="nav-link" href="{{ route('admin.salonrates.index') }}">
                <i class="far fa-file-alt"></i>
                <p>Тарифы для салонов</p>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{ route('admin.salonrates.create') }}">
                <i class="nav-icon far fa-plus-square"></i>
                <p>
                  Создать тариф для салона</p>
              </a>
            </li>

            <li class="nav-item {{ Request::path() === 'admin/promotionals' ? 'admin-li-active' : ''}}">
              <a class="nav-link" href="{{ route('admin.promotionals.index') }}">
                <i class="far fa-file-alt"></i>
                <p>Промокоды</p>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{ route('admin.promotionals.create') }}">
                <i class="nav-icon far fa-plus-square"></i>
                <p>Создать промокод
                </p>
              </a>
            </li>

            <li class="nav-item {{ Request::path() === 'admin/bonuses' ? 'admin-li-active' : ''}}">
              <a class="nav-link" href="{{ route('admin.bonuses.index') }}">
                <i class="far fa-file-alt"></i>
                <p>Бонусы</p>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{ route('admin.bonuses.create')  }}" type="button" class="btn btn-primary">
                <i class="nav-icon far fa-plus-square"></i>Создать бонус</a>
            </li>

            @endif


          </ul>
          @endif

        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="margin-top: 4.5rem !important;">

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          @yield('content')
        </div>
        <!--/. container-fluid -->
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
  @if(Auth::user() !== null)
  <div class="modal fade" id="payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
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
          {{-- <form action="{{ route('user.makepayment') }}" method="post">
          @csrf --}}
          <form method="POST" action="https://merchant.webmoney.ru/lmi/payment_utf.asp" accept-charset="utf-8">
            <div class="form-group">
              <label for="userPayment">Пополнить на сумму:</label>
              <div class="d-flex">
                <input type="text" name="LMI_PAYMENT_AMOUNT" value="" id="userPayment" class="form-control">
                {{-- <input type="text" name="LMI_PAYMENT_AMOUNT" value="" id="userPayment"> --}}
                {{-- <input name="payment" type="number" step="0.1" id="userPayment"
                         class="form-control @error('payment') is-invalid @enderror"
                         placeholder="Укажите на какую сумму необходимо выполнить пополнение баланса" value="{{ old('payment') }}">
                --}}
                <button type="submit" class="btn btn-success"
                  style="padding: 0px 7.5px;margin-left: 1em;">Пополнить</button>
              </div>

              <input type="hidden" name="LMI_PAYMENT_DESC" value="платеж по счету">
              <input type="hidden" name="LMI_PAYMENT_NO" value="1234">
              <input type="hidden" name="LMI_PAYEE_PURSE" value="R905479213120">
              <input type="hidden" name="LMI_SIM_MODE" value="0">
              <input type="hidden" name="user" value="{{Auth::user()->id}}">

              <div id="bonusinfo"></div>
            </div>
          </form>

          {{-- </form> --}}

          <hr>
          <form action="{{ route('user.promotionalpayment') }}" method="post">
            @csrf
            <div class="form-group">
              <label for="userPromotionalPayment">Активировать промокод:</label>
              <div class="d-flex">
                <input name="promotionalpayment" type="text" id="userPromotionalPayment"
                  class="form-control @error('promotionalpayment') is-invalid @enderror"
                  placeholder="Укажите промокод для пополнения баланса" value="">
                <button type="submit" class="btn btn-success"
                  style="padding: 0px 7.5px;margin-left: 1em;">Активировать</button>
              </div>



            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
        </div>
      </div>
    </div>
  </div>
  @endif
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
  <script src="{{ asset('/admin/dist/js/cropper.js') }}"></script>
  <!-- PAGE SCRIPTS -->
  {{-- <script src="{{ asset('/admin/dist/js/pages/dashboard2.js') }}"></script> --}}
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
  <script src="https://unpkg.com/imask"></script>

  @yield('assetcarousel')

  <script type="text/javascript">
    $('#userPayment').on('input', function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var payment = $("input[name=LMI_PAYMENT_AMOUNT]").val();

        $.ajax({
            type:'POST',
            url:'/user/plusbonusinfo',
            data:{payment:payment},
            success:function(data){
                $('#bonusinfo').text(data);
            }
        });
    })

    $('.profilePhone').each(function(){
      var phoneMask = IMask(
          $(this)[0], {
          mask: '+{7}(000)000-00-00'
        });
    });

    
        


    //главное изображение анкеты
    window.addEventListener('DOMContentLoaded', function () {
      var avatar = document.getElementById('avatar');
      var image = document.getElementById('image');
      var input = document.getElementById('input');
      var $progress = $('.progress');
      var $progressBar = $('.progress-bar');
      var $alert = $('.alert');
      var $modal = $('#modal');
      var cropper;

      $('[data-toggle="tooltip"]').tooltip();

      if(input == null)
        return

      input.addEventListener('change', function (e) {
        var files = e.target.files;
        var done = function (url) {
          input.value = '';
          image.src = url;
          $alert.hide();
          $modal.modal('show');
        };
        var reader;
        var file;
        var url;

        if (files && files.length > 0) {
          file = files[0];

          if (URL) {
            done(URL.createObjectURL(file));
          } else if (FileReader) {
            reader = new FileReader();
            reader.onload = function (e) {
              done(reader.result);
            };
            reader.readAsDataURL(file);
          }
        }
      });

      $modal.on('shown.bs.modal', function () {
        cropper = new Cropper(image, {
          aspectRatio: 275 / 390,
          viewMode: 2,
        });
      }).on('hidden.bs.modal', function () {
        cropper.destroy();
        cropper = null;
      });

      document.getElementById('crop').addEventListener('click', function () {
        var initialAvatarURL;
        var canvas;

        $modal.modal('hide');

        if (cropper) {
          canvas = cropper.getCroppedCanvas({
            width: 400,
            height: 400,
          });
          initialAvatarURL = avatar.src;
          avatar.src = canvas.toDataURL();
          $progress.show();
          $alert.removeClass('alert-success alert-warning');
          canvas.toBlob(function (blob) {
            var formData = new FormData();

            formData.append('file', blob, 'avatar.jpg');
            $.ajax("{{url('user/profiles/upload')}}", {
              method: 'POST',
              data: formData,
              headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
              processData: false,
              contentType: false,

              xhr: function () {
                var xhr = new XMLHttpRequest();

                xhr.upload.onprogress = function (e) {
                  var percent = '0';
                  var percentage = '0%';

                  if (e.lengthComputable) {
                    percent = Math.round((e.loaded / e.total) * 100);
                    percentage = percent + '%';
                    $progressBar.width(percentage).attr('aria-valuenow', percent).text(percentage);
                  }
                };

                return xhr;
              },

              success: function (file, response) {
                $alert.show().addClass('alert-success').text('Upload success');
                console.log(response);
                $('#main_image').val(file);
              },

              error: function () {
                avatar.src = initialAvatarURL;
                $alert.show().addClass('alert-warning').text('Upload error');
              },

              complete: function () {
                $progress.hide();
              },
            });
          });
        }
      });
    });
    //главное изображение анкеты

    //главное изображение салона
    window.addEventListener('DOMContentLoaded', function () {
      var avatar = document.getElementById('avatar_main');
      var image = document.getElementById('image');
      var input = document.getElementById('input_main');
      var $progress = $('.progress');
      var $progressBar = $('.progress-bar');
      var $alert = $('.alert');
      var $modal = $('#modal_main');
      var cropper;

      $('[data-toggle="tooltip"]').tooltip();

      if(input == null)
        return

      input.addEventListener('change', function (e) {
        var files = e.target.files;
        var done = function (url) {
          input.value = '';
          image.src = url;
          $alert.hide();
          $modal.modal('show');
        };
        var reader;
        var file;
        var url;

        if (files && files.length > 0) {
          file = files[0];

          if (URL) {
            done(URL.createObjectURL(file));
          } else if (FileReader) {
            reader = new FileReader();
            reader.onload = function (e) {
              done(reader.result);
            };
            reader.readAsDataURL(file);
          }
        }
      });

      $modal.on('shown.bs.modal', function () {
        cropper = new Cropper(image, {
          aspectRatio: 1140 / 320,
          viewMode: 2,
        });
      }).on('hidden.bs.modal', function () {
        cropper.destroy();
        cropper = null;
      });

      document.getElementById('crop_main').addEventListener('click', function () {
        var initialAvatarURL;
        var canvas;

        $modal.modal('hide');

        if (cropper) {
          canvas = cropper.getCroppedCanvas({
            width: 1140,
            height: 320,
          });
          initialAvatarURL = avatar.src;
          avatar.src = canvas.toDataURL();
          $progress.show();
          $alert.removeClass('alert-success alert-warning');
          canvas.toBlob(function (blob) {
            var formData = new FormData();

            formData.append('image', blob, 'salon.jpg');
            $.ajax("{{url('user/salons/uploadsalonimage')}}", {
              method: 'POST',
              data: formData,
              headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
              processData: false,
              contentType: false,

              xhr: function () {
                var xhr = new XMLHttpRequest();

                xhr.upload.onprogress = function (e) {
                  var percent = '0';
                  var percentage = '0%';

                  if (e.lengthComputable) {
                    percent = Math.round((e.loaded / e.total) * 100);
                    percentage = percent + '%';
                    $progressBar.width(percentage).attr('aria-valuenow', percent).text(percentage);
                  }
                };

                return xhr;
              },

              success: function (file, response) {
                $alert.show().addClass('alert-success').text('Upload success');
                console.log(response);
                $('#main_salon_image').val(file);
              },

              error: function () {
                avatar.src = initialAvatarURL;
                $alert.show().addClass('alert-warning').text('Upload error');
              },

              complete: function () {
                $progress.hide();
              },
            });
          });
        }
      });
    });

    $( ".changePhoneNumber" ).click( function(event){
          event.preventDefault();
          var number = $(event.target).parent().find('.profilePhone').val()
          var profile = $(event.target).parent().find('.profilePhone').attr('profile-id')
          $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            url: "{{route('user.profilechangephone')}}",
            type: "post",
            data: {
                phone: number,
                profile_id: profile,
            },
            success: function(response) {
              $(event.target).text('Телефон обновлен')
    
              setTimeout(function(){
                  $(event.target).text('Изменить телефон');
              }, 3000);
            }
          });
        });
    
        $( ".ProfileRateButton" ).click(function(event) {
          event.preventDefault();
          var number = $(event.target).parent().find('.profileRate').val()
          var profile = $(event.target).parent().find('.profileRate').attr('profile-id')
          $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            url: "{{route('user.profilechangerate')}}",
            type: "post",
            data: {
                rate_id: number,
                profile_id: profile,
            },
            success: function(response) {
              $(event.target).text('Тариф обновлен')
    
              setTimeout(function(){
                  $(event.target).text('Изменить тариф');
              }, 3000);
            }
          });
        });
  </script>

  @yield('google_api_autocomplete')
  @yield('script')
  @yield('bonuscheck')
  @yield('footer')
</body>


</html>