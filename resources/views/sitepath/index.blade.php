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
                        <li><a href="#">Указать район</a></li>
                        <li><a href="#">Дополнительно</a></li>
                    </ul>

                    <div class="nc-filter-sliders mt-2">
                        <div class="nc-slider-box">
                            <h6 class="h6">Возраст</h6>
                            <input id="nc-age" type="text" class="nc-slider" value="" />
                        </div>
                        <div class="d-flex justify-content-between nc-values">
                            <p>18</p>
                            <p>66</p>
                        </div>
                    </div>

                    <div class="nc-filter-sliders mt-2">
                        <div class="nc-slider-box">
                            <h6 class="h6">Рост</h6>
                            <input id="nc-height" type="text" class="nc-slider" value="" />
                        </div>
                        <div class="d-flex justify-content-between nc-values">
                            <p>150</p>
                            <p>200</p>
                        </div>
                    </div>

                    <div class="nc-filter-sliders mt-2">
                        <div class="nc-slider-box">
                            <h6 class="h6">Грудь</h6>
                            <input id="nc-boobs" type="text" class="nc-slider" value="" />
                        </div>
                        <div class="d-flex justify-content-between nc-values">
                            <p>1</p>
                            <p>10</p>
                        </div>
                    </div>

                    <div class="nc-prices mb-4">
                        <h6 class="h6 mb-2">Цена за 1 час</h6>
                        <form>
                            <div class="form-row">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="от">
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="до">
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="nc-prices mb-4">
                        <h6 class="h6 mb-2">Цена за 2 часа</h6>
                        <form>
                            <div class="form-row">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="от">
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="до">
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="nc-prices mb-4">
                        <h6 class="h6 mb-2">Цена за ночь</h6>
                        <form>
                            <div class="form-row">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="от">
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="до">
                                </div>
                            </div>
                        </form>
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
                                        <li class="list-group-item">
                                            <!-- Default checked -->
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="check1" checked>
                                                <span class="checkmark"></span>
                                                <label class="custom-control-label" for="check1">Славянская</label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <!-- Default checked -->
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="check2">
                                                <span class="checkmark"></span>
                                                <label class="custom-control-label" for="check2">Азиатская</label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <!-- Default checked -->
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="check3" checked>
                                                <span class="checkmark"></span>
                                                <label class="custom-control-label" for="check3">Африканская</label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <!-- Default checked -->
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="check4" checked>
                                                <span class="checkmark"></span>
                                                <label class="custom-control-label" for="check4">Кавказская</label>
                                            </div>
                                        </li>
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
                                        <li class="list-group-item">
                                            <!-- Default checked -->
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="check5" checked>
                                                <span class="checkmark"></span>
                                                <label class="custom-control-label" for="check5">Брюнетки</label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <!-- Default checked -->
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="check6">
                                                <span class="checkmark"></span>
                                                <label class="custom-control-label" for="check6">Блондинки</label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <!-- Default checked -->
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="check7" checked>
                                                <span class="checkmark"></span>
                                                <label class="custom-control-label" for="check7">Рыжие</label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <!-- Default checked -->
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="check8" checked>
                                                <span class="checkmark"></span>
                                                <label class="custom-control-label" for="check8">Шатенки</label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <!-- Default checked -->
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="check9" checked>
                                                <span class="checkmark"></span>
                                                <label class="custom-control-label" for="check9">Русые</label>
                                            </div>
                                        </li>
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
                                                       checked>
                                                <span class="checkmark"></span>
                                                <label class="custom-control-label" for="checkVerified">Только
                                                    проверенные</label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <!-- Default checked -->
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checkApartments">
                                                <span class="checkmark"></span>
                                                <label class="custom-control-label" for="checkApartments">Апартаменты</label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <!-- Default checked -->
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checkCheckout"
                                                       checked>
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
                                                            <input value="{{$serviceChild->id}}" type="checkbox" name="services[]" class="custom-control-input" id="check{{$serviceChild->id}}"
                                                                   >
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


                <div class="row">
                    @foreach($profiles as $profile)
                    <div class="col-md-4 col-sx-6 nc-col">
                        <div class="nc-card d-flex flex-column justify-content-between">
                            <div class="nc-card-top">
                                <div class="d-flex flex-column justify-content-between align-items-end">
                                    @if($profile->verified)
                                    <a class="nc-point" href="#">
                                        <img src="images/approved.png" alt="Подтверждена">
                                    </a>
                                    @endif

                                    @if($profile->apartments)
                                    <a class="nc-point" href="#">
                                        <img src="images/apartments.png" alt="Апартаменты">
                                    </a>
                                    @endif

                                    @if($profile->check_out)
                                    <a class="nc-point" href="#">
                                        <img src="images/car.png" alt="Выезд">
                                    </a>
                                    @endif
                                </div>
                            </div>
                            <div class="nc-card-bottom">
                                <h4 class="h4" style="    font-size: 1.1rem;"><a href="{{route('getprofile', $profile->id)}}">{{$profile->name}} <span>| {{$profile->age}} года</span></a> </h4>
                                <div class="d-flex justify-content-around">
                                    <p class="nc-price"><span>за час</span><br> {{$profile->one_hour}}</p>
                                    <p class="nc-price"><span>за 2 часа</span><br> {{$profile->two_hour}}</p>
                                    <p class="nc-price"><span>за ночь</span><br> {{$profile->all_night}}</p>
                                </div>
                                <div class="nc-location d-flex">
                                    <img class="img-fluid align-self-center" src="images/location.png">
                                    <div class="align-self-center ml-2 d-flex flex-column">
                                        <span>{{ $profile->phone }}</span>
                                        <span>{{ $profile->address }} / {{$profile->working_hours}}</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                        @if($loop->iteration % 3 == 0)
                </div>
                <div class="row mt-3">
                    @endif
                    @endforeach
                </div>

                <div class="row justify-content-center mt-3 mb-3">
                    <div class="col-md-4 col-sm-12 nc-col">
                        <button type="button" class="btn nc-btn-show-more btn-block" id="showMore">
                            <img src="images/show-more.png" class="mr-2" alt="">
                            Посмотреть еще (2567)
                            анкет</button>
                    </div>
                </div>
            </div>
        </div>


    </div>


    <!-- ОСНОВНАЯ ЧАСТЬ END -->
@endsection
