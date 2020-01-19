@extends('layouts.site')

@section('profileBody')
    class="profileBody"
@endsection

@section('content')
    <div class="container profileContainer" style="background-color:rgba(0, 0, 0, 0.1);
        padding: 60px 60px 60px 30px !important;">
        <div class="row">
            <div class="col-md-8 col-sm-12">
                <div class="d-flex align-self-center justify-content-between">
                    <span class="name">
                        {{ $profile->name }} <span class="age">| {{ $profile->age }} лет</span>
                    </span>

                    <span class="phone align-self-baseline mt-1">
                        {{ $phone }}
                    </span>

                    <div class="nc-location d-flex">
                        <img class="img-fluid align-self-center" src="{{asset('/images/location.png')}}">
                        <div class="align-self-center ml-2 d-flex flex-column address">

                            <span> {{ $profile->districts->first()->name }} /
                                @if($profile->working_24_hours)
                                    Круглосуточно
                                @elseif($profile->working_hours_from)
                                    c {{$profile->working_hours_from}}:00 до {{$profile->working_hours_to}}:00
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-7 col-sm-12">
                <div class="nc-location d-flex">
                    <img class="img-fluid align-self-center" src="{{asset('/images/info.png')}}">
                    <div class="align-self-center ml-2 d-flex flex-column address">
                        <span class="font-italic"> Пожалуйста, начните разговор со слов:<br>
                            "Здравствуйте, звоню с сайта ns-samara.com" и я всё пойму...</span>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-sm-12 d-flex justify-content-end">
                <ul class="align-self-center ml-2 d-flex flex-column">
                    @if($profile->apartments)
                    <li class="tagsInfo font-italic">С апартаментами</li>
                    @endif

                    @if($profile->check_out)
                    <li class="tagsInfo font-italic">Выезд</li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 col-sm-12">
                <img src="{{asset('/images/profiles/main/created/' . $profile->main_image)}}" class="img-fluid">
            </div>
            @foreach($profile->images as $image)
            <div class="col-md-4 col-sm-12">
                <img src="{{asset('/images/profiles/images/created/'. $image->name )}}" class="img-fluid">
            </div>
            @endforeach
        </div>

        <div class="row mt-4">
            <div class="col-md-12 col-sm-12">
                <h5 class="font-italic">О себе</h5>
                <p class="font-italic priceFont">
                    {{ $profile->about }}
                </p>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-4 col-sm-12">
                <h5 class="font-italic">Стоимость</h5>
                <div class="d-flex justify-content-between">
                    <div class="d-flex flex-column">
                        <span class="font-italic">За час</span>
                        <span class="font-italic mt-1 priceFont">{{ $profile->one_hour }}</span>
                    </div>
                    <div class="d-flex flex-column">
                        <span class="font-italic">За 2 часа</span>
                        <span class="font-italic mt-1 priceFont">{{ $profile->two_hour }}</span>
                    </div>
                    <div class="d-flex flex-column">
                        <span class="font-italic">За ночь</span>
                        <span class="font-italic mt-1 priceFont">{{ $profile->all_night }}</span>
                    </div>
                    @if($profile->euro_hour)
                    <div class="d-flex flex-column">
                        <span class="font-italic">Евро час</span>
                        <span class="font-italic mt-1 priceFont">{{ $profile->euro_hour }}</span>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-md-4 col-sm-12 ml-5">
                <h5 class="font-italic">Описание</h5>
                <div class="d-flex flex-column">
                    <div class="row  d-flex justify-content-between align-items-end">
                        <div class="col-md-5 font-italic">Город</div>
                        <div class="col font-italic"><img class="img-fluid align-self-bottom" src="{{asset('/images/line.png')}}"></div>
                        <div class="col ml-2 font-italic">Самара</div>
                    </div>
                    <div class="row  d-flex justify-content-between align-items-end">
                        <div class="col-md-5 font-italic">Район</div>
                        <div class="col font-italic"><img class="img-fluid align-self-bottom" src="{{asset('/images/line.png')}}"></div>
                        <div class="col ml-2 font-italic">{{ $profile->districts->first()->name }}</div>
                    </div>
                    <div class="row d-flex justify-content-between align-items-end">
                        <div class="col-md-5 font-italic">Возраст</div>
                        <div class="col font-italic"><img class="img-fluid align-self-bottom" src="{{asset('/images/line.png')}}"></div>
                        <div class="col ml-2 font-italic">{{ $profile->age }}</div>
                    </div>
                    <div class="row d-flex justify-content-between align-items-end">
                        <div class="col-md-5 font-italic">Рост</div>
                        <div class="col font-italic"><img class="img-fluid align-self-bottom" src="{{asset('/images/line.png')}}"></div>
                        <div class="col ml-2 font-italic">{{ $profile->height }}</div>
                    </div>
                    <div class="row d-flex justify-content-between align-items-end">
                        <div class="col-md-5 font-italic">Вес</div>
                        <div class="col font-italic"><img class="img-fluid align-self-bottom" src="{{asset('/images/line.png')}}"></div>
                        <div class="col ml-2 font-italic">{{ $profile->weight }}</div>
                    </div>
                    <div class="row d-flex justify-content-between align-items-end">
                        <div class="col-md-5 font-italic">Грудь</div>
                        <div class="col font-italic"><img class="img-fluid align-self-bottom" src="{{asset('/images/line.png')}}"></div>
                        <div class="col ml-2 font-italic">{{ $profile->boobs }}</div>
                    </div>
                    <div class="row d-flex justify-content-between align-items-end">
                        <div class="col-md-5 font-italic">Цвет волос</div>
                        <div class="col font-italic"><img class="img-fluid align-self-bottom" src="{{asset('/images/line.png')}}"></div>
                        <div class="col ml-2 font-italic">{{ $profile->hairs->first()->name }}</div>
                    </div>
                    <div class="row d-flex justify-content-between align-items-end">
                        <div class="col-md-5 font-italic">Внешность</div>
                        <div class="col font-italic"><img class="img-fluid align-self-bottom" src="{{asset('/images/line.png')}}"></div>
                        <div class="col ml-2 font-italic">{{ $profile->appearances->first()->name }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container profileContainer mb-3" style="background-color:rgba(255,255,255, 0.1);
    padding: 60px 60px 60px 30px !important;">
        <div class="row">
            <div class="col-md-8 col-sm-12">
                <h5 class="font-italic">Услуги</h5>
                <div class="row ">
                    <div class="col">
                    @foreach($services as $service)
                        <div class="col d-flex">
                            <div class="row flex-column">
                                <div class="col mt-3">
                                    <h5 class="font-italic mb-2"><u>{{ $service->name }}:</u></h5>

                                    <div class="d-flex flex-column">
                                        @foreach($service->childrenRecursive as $serviceChild)
                                            @if($profile->services->where('id', $serviceChild->id)->first())
                                                <span class="font-italic">{{ $profile->services->where('id', $serviceChild->id)->first()->name }} @if($profile->services->where('id', $serviceChild->id)->first()->pivot <> null) {{$profile->services->where('id', $serviceChild->id)->first()->pivot->price}} руб. @endif</span>
                                            @endif
                                        @endforeach
                                    </div>

                                </div>
                            </div>
                        </div>
                    @if($loop->iteration % 3 == 0 && !$loop->last)
                    </div>
                    <div class="col">
                        @elseif($loop->last)

                    @endif
                    @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 d-flex flex-column">
                <div id="nc-carouselSimilars" class="carousel slide carousel-fade nc-carousel mt-3" data-ride="carousel">

                <div class="d-flex justify-content-between">
                    <h5 class="font-italic">Похожие анкеты</h5>

                    <div class="div d-flex justify-content-between">
                        <a class="mr-2" href="#nc-carouselSimilars" role="button" data-slide="prev">
                            <img class="img-fluid align-self-bottom" src="{{asset('/images/analog_profiles_left.png')}}">
                        </a>
                        <a class="ml-2" href="#nc-carouselSimilars" role="button" data-slide="next">
                            <img class="img-fluid align-self-bottom" src="{{asset('/images/analog_profiles_right.png')}}">
                        </a>
                    </div>
                </div>


                    <div class="carousel-inner">
                        @foreach($similarProfiles as $similar)
                        <div class="carousel-item @if($loop->iteration == 1) active @endif">
                            <img src="{{asset('/images/profiles/main/created/' . $similar->main_image)}}" class="img-fluid mt-3">
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script >
        $('#nc-carouselSimilars').carousel({
            interval : 2500
        })
    </script>
@endsection
