@extends('layouts.site')

@section('content')
    <!-- КАРУСЕЛЬ BEGIN -->
    <div class="container">
        <div class="row">
            <div id="nc-carouselSalons" class="carousel slide carousel-fade nc-carousel mt-3" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="images/carousel/carousel1.png" class="d-block w-100">
                    </div>
                    <div class="carousel-item">
                        <img src="images/carousel/carousel2.png" class="d-block w-100">
                    </div>
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

    <div class="container mt-3">
        <div class="row justify-content-between">
            <div class="col-md-3 col-sm-12 nc-col-filter">
                <div class="nc-filter">
                    <div class="d-flex justify-content-between">
                        <span>
                            Выбрать параметры
                        </span>
                        <span>
                            <img src="images/filter/settings.png" alt="">
                        </span>
                    </div>
                    <ul class="mt-3 nc-actions">
                        <li><a href="#" id="services">Выбрать услуги</a></li>
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

                    <div class="nc-filter-buttons mt-3 mb-1">
                        <a class="btn btn-outline-dark btn-block">Бюджетные</a>
                        <a class="btn btn-outline-dark btn-block">Элитные</a>
                        <a class="btn btn-outline-dark btn-block">Молодые</a>
                        <a class="btn btn-outline-dark btn-block">Проверенные</a>
                        <a class="btn btn-outline-dark btn-block">Новые</a>
                    </div>

                </div>
            </div>

            <div class="col-md-9 nc-col position-relative">
                <div id="services-desk" class="nc-service-desk">
                    <div class="row">

                        <div class="col-md-12  nc-col">
                            <h3 class="h3 header">Услуги</h3>

                        </div>

                        <div class="col-md-12 col-sm-12 nc-col">
                            <div class="d-flex justify-content-between nc-services-wrapper">

                                @foreach($services->where('is_category','1') as $service)
                                    <div class="panel-body col-md-4">
                                        <div class="nc-service-column">
                                            <h5 class="h5">{{$service->name}}</h5>
                                            <ul class="list-group list-group-flush">

                                                @foreach($service->childrenRecursive as $serviceChild)
                                                    <li class="list-group-item">
                                                        <!-- Default checked -->
                                                        <div class="custom-control custom-checkbox">
                                                            <input value="{{$serviceChild->id}}" type="checkbox" name="services[]" class="custom-control-input" id="check{{$serviceChild->id}}
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
                                    </div>

                                @if($loop->iteration % 3 == 0)
                                    </div>
                                    <div class="d-flex justify-content-between nc-services-wrapper">
                                @endif

                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>

                {{ csrf_field() }}
                <div id="post_data"></div>

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
        $('#services-desk').css('margin-bottom','15px');
        $('#services').click(function(){
            $('#services-desk').toggle();
        });
    </script>

    <script>
        $(document).ready(function(){

            var _token = $('input[name="_token"]').val();

            load_data('', _token);

            function load_data(id="", _token)
            {
                $.ajax({
                    url:"{{ route('loadmore.load_data') }}",
                    method:"POST",
                    data:{id:id, _token:_token},
                    success:function(data)
                    {
                        $('.load_more_button').remove();
                        $('#post_data').append(data);
                    }
                })
            }

            $(document).on('click', '#load_more_button', function(){
                var id = $(this).data('id');
                $('#load_more_button').html('<b>Загружаю...</b>');
                load_data(id, _token);
            });

        });
    </script>
@endsection
