@extends('layouts.site')

@section('content')
    <!-- КАРУСЕЛЬ BEGIN -->
    <div class="container">
        <div class="row">
            <div id="nc-carouselSalons" class="carousel slide carousel-fade nc-carousel mt-3" data-ride="carousel">
                <div class="carousel-inner">
                    @foreach($rates->where('for_salons', 1) as $rate)
                        @foreach($rate->salons->where('is_published', 1)->where('is_approved', 1) as $salon)
                            @if($salon->image_prem)
                            <div class="carousel-item @if($loop->first) active @endif">
                                    <img src="{{ asset('/images/salons/created/' . $salon->image_prem) }}"  class="d-block w-100"> 
                            </div>
                            @endif
                        @endforeach
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#nc-carouselSalons" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#nc-carouselSalons" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
    <!-- КАРУСЕЛЬ END -->

    <!-- ОСНОВНАЯ ЧАСТЬ BEGIN -->

    <div class="container mt-3" style="min-height: 900px;">
        <div class="row justify-content-between">
            <div class="col-md-3 col-sm-12 nc-col-filter">
                <div class="nc-filter navbar-expand-lg navbar-expand-lg-nc">
                    <div class="d-flex justify-content-between">
                        <span>
                            Выбрать параметры
                        </span>
                        <span>
                            <button class="navbar-toggler d-xl-none d-lg-none d-md-none" type="button" data-toggle="collapse"
                                    data-target="#navbarFilterContent" aria-controls="navbarFilterContent"
                                    aria-expanded="false" aria-label="Toggle navigation" style="padding: 0;">
                                    <img src="images/filter/settings.png">
                            </button> 
                        </span>
                    </div>
                    <div class="collapse navbar-collapse-nc" id="navbarFilterContent">
                    <ul class="mt-3 nc-actions navbar-expand-lg navbar-expand-lg-nc">
                        <div class="d-flex justify-content-between">
                                <li><a href="#" id="services">Выбрать услуги</a></li>
                                <button class="navbar-toggler d-xl-none d-lg-none d-md-none" type="button" data-toggle="collapse"
                                    data-target="#navbarServicesContent" aria-controls="navbarServicesContent"
                                    aria-expanded="false" aria-label="Toggle navigation" style="padding: 0;">
                                    <img src="images/filter/settings.png">
                            </button>
                        </div>
                        <ul class="collapse" id="navbarServicesContent" style="padding:0px">

                            @foreach($services->where('is_category','1') as $service)
                                
                                    <div class="nc-service-column">
                                        <h5 class="h5">{{$service->name}}</h5>
                                        <ul class="list-group list-group-flush">

                                            @foreach($service->childrenRecursive as $serviceChild)
                                                <li class="list-group-item">
                                                    <!-- Default checked -->
                                                    <div class="custom-control custom-checkbox">
                                                        <input value="{{$serviceChild->id}}" type="checkbox" name="services[]" class="custom-control-input" id="check{{$serviceChild->id}}"
                                                        @if(app('request')->has('districts'))
                                                            @if(app('request')->services->find($serviceChild->id))
                                                                'checked'
                                                            @endif
                                                        @endif>
                                                        <span class="checkmark"></span>
                                                        <label class="custom-control-label" for="check{{$serviceChild->id}}">{{$serviceChild->name}}
                                                            </label>
                                                    </div>
                                                </li>
                                            @endforeach

                                        </ul>
                                    </div>
                                

                            @endforeach

                        </ul>
                    </ul>
                    <div class="nc-filter-sliders mt-2">
                        <div class="nc-slider-box">
                            <h6 class="h6">Возраст</h6>
                            <input id="nc-age" type="text" class="nc-slider" value="" />
                        </div>
                        <div class="d-flex justify-content-between nc-values">
                            <p>{{ $filtersDefaultCollection['age_min'] }}</p>
                            <p>{{ $filtersDefaultCollection['age_max'] }}</p>
                        </div>
                    </div>
                    <div class="nc-filter-sliders mt-2">
                        <div class="nc-slider-box">
                            <h6 class="h6">Рост</h6>
                            <input id="nc-height" type="text" class="nc-slider" value="" />
                        </div>
                        <div class="d-flex justify-content-between nc-values">
                            <p>{{ $filtersDefaultCollection['height_min'] }}</p>
                            <p>{{ $filtersDefaultCollection['height_max'] }}</p>
                        </div>
                    </div>

                    <div class="nc-filter-sliders mt-2">
                        <div class="nc-slider-box">
                            <h6 class="h6">Грудь</h6>
                            <input id="nc-boobs" type="text" class="nc-slider" value="" />
                        </div>
                        <div class="d-flex justify-content-between nc-values">
                            <p>{{ $filtersDefaultCollection['boobs_min'] }}</p>
                            <p>{{ $filtersDefaultCollection['boobs_max'] }}</p>
                        </div>
                    </div>

                    <div class="nc-prices mb-4">
                        <h6 class="h6 mb-2">Цена за 1 час (от {{$filtersDefaultCollection['one_hour_min'] }} до {{$filtersDefaultCollection['one_hour_max']}})</h6>
                        <div class="form-row">
                            <div class="col">
                                <input type="text" class="form-control" placeholder="от" name="one_hour_min"
                                    {{ app('request')->has('one_hour_min') == true ? app('request')->one_hour_min : $filtersDefaultCollection['one_hour_min']  }}>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="до" name="one_hour_max"
                                    {{ app('request')->has('one_hour_max') == true ? app('request')->one_hour_max : $filtersDefaultCollection['one_hour_max']  }}>
                            </div>
                        </div>
                    </div>

                    <div class="nc-prices mb-4">
                        <h6 class="h6 mb-2">Цена за 2 часа (от {{$filtersDefaultCollection['two_hour_min']}} до {{$filtersDefaultCollection['two_hour_max']}})</h6>
                        <div class="form-row">
                            <div class="col">
                                <input type="text" class="form-control" placeholder="от" name="two_hour_min"
                                    {{ app('request')->has('two_hour_min') == true ? app('request')->two_hour_min : $filtersDefaultCollection['two_hour_min']  }}>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="до" name="two_hour_max"
                                    {{ app('request')->has('two_hour_max') == true ? app('request')->two_hour_max : $filtersDefaultCollection['two_hour_max']  }}>
                            </div>
                        </div>
                    </div>

                    <div class="nc-prices mb-4">
                        <h6 class="h6 mb-2">Цена за ночь (от {{$filtersDefaultCollection['all_night_min']}} до {{$filtersDefaultCollection['all_night_max']}})</h6>
                        <div class="form-row">
                            <div class="col">
                                <input type="text" class="form-control" placeholder="от" name="all_night_min"
                                    {{ app('request')->has('all_night_min') == true ? app('request')->all_night_min : $filtersDefaultCollection['all_night_min']  }}>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="до" name="all_night_max"
                                    {{ app('request')->has('all_night_max') == true ? app('request')->all_night_max : $filtersDefaultCollection['all_night_max']  }}>
                            </div>
                        </div>
                    </div>


                    <div class="panel-group nc-collapse" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h6 class="panel-title h6">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
                                       href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Внешность
                                    </a>
                                </h6>

                            </div>
                            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel"
                                 aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <ul class="list-group list-group-flush">
                                        @foreach($appearances as $appearance)
                                        <li class="list-group-item">
                                            <!-- Default checked -->
                                            <div class="custom-control custom-checkbox ">
                                                <input type="checkbox" class="custom-control-input" id="checkAppearance{{$loop->iteration}}" value="{{$appearance->id}}" name="appearances[]"
                                                    @if(app('request')->has('appearances'))
                                                        @if(app('request')->appearances->find($appearance->id))
                                                            'checked'
                                                        @endif
                                                    @endif>
                                                <span class="checkmark"></span>
                                                <label class="custom-control-label" for="checkAppearance{{$loop->iteration}}">{{ $appearance->name }}</label>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingTwo">
                                <h6 class="panel-title h6">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
                                       href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Цвет волос
                                    </a>
                                </h6>

                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel"
                                 aria-labelledby="headingTwo">
                                <div class="panel-body">
                                    <ul class="list-group list-group-flush">
                                        @foreach($hairs as $hair)
                                        <li class="list-group-item">
                                            <!-- Default checked -->
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checkHair{{ $hair->name }}" value="{{$hair->id}}" name="hairs[]"
                                                @if(app('request')->has('hairs'))
                                                    @if(app('request')->hairs->find($hair->id))
                                                        'checked'
                                                    @endif
                                                @endif>
                                                <span class="checkmark"></span>
                                                <label class="custom-control-label" for="checkHair{{ $hair->name }}">{{ $hair->name }}</label>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingTwo">
                                <h6 class="panel-title h6">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
                                       href="#collapseDistrict" aria-expanded="false" aria-controls="collapseTwo">
                                        Указать район
                                    </a>
                                </h6>

                            </div>
                            <div id="collapseDistrict" class="panel-collapse collapse" role="tabpanel"
                                 aria-labelledby="headingTwo">
                                <div class="panel-body">
                                    <ul class="list-group list-group-flush">
                                        @foreach($districts as $district)
                                            <li class="list-group-item">
                                                <!-- Default checked -->
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="checkHair{{ $district->name }}" value="{{$district->id}}" name="districts[]"
                                                    @if(app('request')->has('districts'))
                                                        @if(app('request')->districts->find($district->id))
                                                            'checked'
                                                        @endif
                                                    @endif>
                                                    <span class="checkmark"></span>
                                                    <label class="custom-control-label" for="checkHair{{ $district->name }}">{{ $district->name }}</label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingThree">
                                <h6 class="panel-title h6">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
                                       href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Дополнительно
                                    </a>
                                </h6>

                            </div>
                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel"
                                 aria-labelledby="headingThree">
                                <div class="panel-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <!-- Default checked -->
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checkVerified"
                                                       value="1" name="verified" id="checkVerified" {{ app('request')->input('verified') == 1 ? 'checked' : '' }}>
                                                <span class="checkmark"></span>
                                                <label class="custom-control-label" for="checkVerified">Только
                                                    проверенные</label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <!-- Default checked -->
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input"
                                                       value="1" name="apartments" id="checkApartments" {{ app('request')->input('apartments') == 1 ? 'checked' : '' }}>
                                                <span class="checkmark"></span>
                                                <label class="custom-control-label" for="checkApartments">Апартаменты</label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <!-- Default checked -->
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checkCheckout" value="1" name="check_out"
                                                       {{ app('request')->input('check_out') == 1 ? 'checked' : '' }}
                                                       >
                                                <span class="checkmark"></span>
                                                <label class="custom-control-label" for="checkCheckout">Выезд</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="nc-filter-buttons mt-3 mb-5">
                        <a class="btn btn-outline-dark btn-block" id="load_filter" style="background: #ae8f82;">Применить фильтр</a>
                        <a class="btn btn-outline-dark btn-block" id="fresh_filter" style="background: #d92a30;">Сбросить фильтр</a>
                    </div>

                    <div class="nc-filter-buttons mt-3 mb-1">
                        <a class="btn btn-outline-dark btn-block" data-min-price="0" data-max-price="2999" id="budget">Бюджетные</a>
                        <a class="btn btn-outline-dark btn-block" data-min-price="3000" data-max-price="99999999" id="elite">Элитные</a>
                        <a class="btn btn-outline-dark btn-block" data-min-age="18" data-max-age="25" id="young">Молодые</a>
                        <a class="btn btn-outline-dark btn-block" id="verified">Проверенные</a>
                        <a class="btn btn-outline-dark btn-block" id="new_profiles" >Новые</a>
                    </div>
                </div>        
                </div>

                {{ csrf_field() }}
            </div>

            <div class="col-md-9 nc-col position-relative">
                <div id="services-desk" class="nc-service-desk">
                    <div class="row">

                        <div class="col-md-12  nc-col">
                            <h3 class="h3 header">Услуги</h3>

                        </div>

                        <div class="col-md-12 col-sm-12 nc-col">
                            <div class="d-flex justify-content-between nc-services-wrapper pb-4">

                                @foreach($services->where('is_category','1') as $service)
                                    <div class="panel-body col-md-4">
                                        <div class="nc-service-column">
                                            <h5 class="h5">{{$service->name}}</h5>
                                            <ul class="list-group list-group-flush">

                                                @foreach($service->childrenRecursive as $serviceChild)
                                                    <li class="list-group-item">
                                                        <!-- Default checked -->
                                                        <div class="custom-control custom-checkbox">
                                                            <input value="{{$serviceChild->id}}" type="checkbox" name="services[]" class="custom-control-input" id="checkn{{$serviceChild->id}}"
                                                            @if(app('request')->has('districts'))
                                                                @if(app('request')->services->find($serviceChild->id))
                                                                    'checked'
                                                                @endif
                                                            @endif>
                                                            <span class="checkmark"></span>
                                                            <label class="custom-control-label" for="checkn{{$serviceChild->id}}">{{$serviceChild->name}}
                                                                </label>
                                                        </div>
                                                    </li>
                                                @endforeach

                                            </ul>
                                        </div>
                                    </div>

                                @if($loop->iteration % 3 == 0 && $loop->last)
                                    </div>
                                    <div class="d-flex justify-content-between nc-services-wrapper pb-4">
                                @elseif($loop->iteration % 3 == 0)
                                    </div>
                                    <div class="d-flex justify-content-between nc-services-wrapper">
                                @endif

                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>

                <div id="post_data" class="post_data"></div>

            </div>
        </div>
    </div>
    <!-- ОСНОВНАЯ ЧАСТЬ END -->

    <script>
        /* КАРУСЕЛЬ  BEGIN*/
        $('#nc-carouselSalons').carousel({
            interval : 2500
        })
        /* КАРУСЕЛЬ  END*/

        // СЛАЙДЕРЫ ФИЛЬТРА

        $("#nc-age").slider({
            id: "nc-age",
            min: {{ app('request')->has('age_min') == true ? app('request')->age_min : $filtersDefaultCollection['age_min'] }},
            max: {{ app('request')->has('age_max') == true ? app('request')->age_max : $filtersDefaultCollection['age_max']}},
            step: 1,
            value: [{{ $filtersDefaultCollection['age_min'] }}, {{$filtersDefaultCollection['age_max']}}],

            tooltip:'show',

            tooltip_split: true,
        });

        $("#nc-height").slider({
            id: "nc-height",
            min: {{ app('request')->has('height_min') == true ? app('request')->height_min : $filtersDefaultCollection['height_min'] }},
            max: {{ app('request')->has('height_max') == true ? app('request')->height_max : $filtersDefaultCollection['height_max'] }},
            step: 1,
            value: [{{ $filtersDefaultCollection['height_min'] }}, {{ $filtersDefaultCollection['height_max'] }}],

            tooltip:'show',

            tooltip_split: true,
        });

        $("#nc-boobs").slider({
            id: "nc-boobs",
            min: {{ app('request')->has('boobs_min') == true ? app('request')->boobs_min : $filtersDefaultCollection['boobs_min'] }},
            max: {{ app('request')->has('boobs_max') == true ? app('request')->boobs_max : $filtersDefaultCollection['boobs_max'] }},
            step: 1,
            value: [{{ $filtersDefaultCollection['boobs_min'] }}, {{ $filtersDefaultCollection['boobs_max'] }}],

            tooltip:'show',

            tooltip_split: true,
        });

        //ОТКРЫТИЕ ЗАКРЫТИЕ УСЛУГ
        if(window.screen.width > 992) {
            $('#services-desk').css('margin-bottom','15px');
        $('#services').click(function(){
            $('#services-desk').toggle();
        });
        }
        
    </script>

    <script>
        document.getElementById('load_filter').addEventListener('click', function (clicked) {
        return function () {
            if (!clicked) {
                var last = this.innerHTML;
                this.innerHTML = 'Фильтр применен';
                clicked = true;
                setTimeout(function () {
                    this.innerHTML = last;
                    clicked = false;
                }.bind(this), 4000);
            }
        };
        }(false), this);

        document.getElementById('fresh_filter').addEventListener('click', function (clicked) {
        return function () {
            if (!clicked) {
                var last = this.innerHTML;
                this.innerHTML = 'Фильтр сброшен';
                clicked = true;
                setTimeout(function () {
                    this.innerHTML = last;
                    clicked = false;
                }.bind(this), 4000);
            }
        };
        }(false), this);

        $(document).ready(function(){

            var _token = $('input[name="_token"]').val();
            var data = {};
            load_data('', _token, null, data);

            function load_data(id="", _token, obj=null, data) {

                arrIds = []
                $('.profile_wrapper').each(function(){
                    arrIds.push($(this).attr('profile_id')); 
                });

                if(id == "") {
                    id = 0;
                }

                data.id = id

                if(id !== 0) {
                    data.ids = arrIds
                    console.log(arrIds);
                }
                
                data._token = _token

                if(obj !== null) {
                    for (var i in obj) {
                        data[i] = obj[i]
                    }
                }

                console.log(data);

                $.ajax({
                    url:"{{ route('loadmore.load_data') }}",
                    method:"POST",
                    data:data,
                    success:function(data)
                    {
                        $('.load_more_button').remove();
                        $('#post_data').append(data);
                    }
                })
            }

            $(document).on('click', '#fresh_filter', function(){
                data = {}
                var _token = $('input[name="_token"]').val();
                $('#load_more_button').html('<b>Загружаю...</b>');
                $('#post_data').empty();
                load_data('', _token, null, data);
            });

            $(document).on('click', '#load_more_button', function(){
                var id = $(this).data('id');
                $('#load_more_button').html('<b>Загружаю...</b>');
                load_data(id, _token, null, data);
            });

            $(document).on('click', '#load_filter', function(){
                $('#load_more_button').html('<b>Загружаю...</b>');
                $('#post_data').empty();

                obj = {}

                obj.one_hour_min = $( "input[name=one_hour_min]" ).val();
                obj.one_hour_max = $( "input[name=one_hour_max]" ).val();
                obj.two_hour_min = $( "input[name=two_hour_min]" ).val();
                obj.two_hour_max = $( "input[name=two_hour_max]" ).val();
                obj.all_night_min = $( "input[name=all_night_min]" ).val();
                obj.all_night_max = $( "input[name=all_night_max]" ).val();
                obj.age_min = $('input[id=nc-age]').val().split(',')[0];
                obj.age_max = $('input[id=nc-age]').val().split(',')[1];
                obj.height_min = $('input[id=nc-height]').val().split(',')[0];
                obj.height_max = $('input[id=nc-height]').val().split(',')[1];
                obj.boobs_min = $('input[id=nc-boobs]').val().split(',')[0];
                obj.boobs_max = $('input[id=nc-boobs]').val().split(',')[1];
                obj.services = $('input[name="services[]"]:checked').map(function(){return $(this).val();}).get();
                obj.appearances = $('input[name="appearances[]"]:checked').map(function(){return $(this).val();}).get();
                obj.hairs = $('input[name="hairs[]"]:checked').map(function(){return $(this).val();}).get();
                obj.districts = $('input[name="districts[]"]:checked').map(function(){return $(this).val();}).get();
                obj.apartments = $('input[name="apartments[]"]:checked').map(function(){return $(this).val();}).get();
                obj.check_out = $( "input[type=checkbox][name=check_out]:checked" ).val();
                obj.verified = $( "input[type=checkbox][name=verified]:checked" ).val();


                console.log(obj);

                console.log(obj);
                load_data('', _token, obj, data);
            });

            $(document).on('click', '#budget', function(){
                $('#load_more_button').html('<b>Загружаю...</b>');
                $('#post_data').empty();
                data = {}
                obj = {}
                obj.one_hour_min = $('#budget').attr('data-min-price');
                obj.one_hour_max = $('#budget').attr('data-max-price');

                var _token = $('input[name="_token"]').val();
                load_data('', _token, obj, data);
            });

            $(document).on('click', '#elite', function(){
                $('#load_more_button').html('<b>Загружаю...</b>');
                $('#post_data').empty();
                data={}
                obj = {}
                obj.one_hour_min = $('#elite').attr('data-min-price');
                obj.one_hour_max = $('#elite').attr('data-max-price');

                var _token = $('input[name="_token"]').val();
                load_data('', _token, obj, data);
            });

            $(document).on('click', '#young', function(){
                $('#load_more_button').html('<b>Загружаю...</b>');
                $('#post_data').empty();
                data={}
                obj = {}
                obj.age_min = $('#young').attr('data-min-age');
                obj.age_max = $('#young').attr('data-max-age');

                var _token = $('input[name="_token"]').val();
                load_data('', _token, obj, data);
            });

            $(document).on('click', '#verified', function(){
                $('#load_more_button').html('<b>Загружаю...</b>');
                $('#post_data').empty();
                data={}
                obj = {}
                obj.verified = 1;
                var _token = $('input[name="_token"]').val();
                load_data('', _token, obj, data);
            });

            $(document).on('click', '#new_profiles', function(){
                $('#load_more_button').html('<b>Загружаю...</b>');
                $('#post_data').empty();
                data={}
                obj = {}
                obj.new_profiles = 1;
                var _token = $('input[name="_token"]').val();
                load_data('', _token, obj, data);
            });

        });
    </script>
@endsection
