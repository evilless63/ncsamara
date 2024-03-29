@extends('layouts.site')

@section('profileBody')
class="profileBody"
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
@endsection

@section('assetcarousel')

<link rel="stylesheet" href="{{asset('js/swiper/css/swiper.min.css')}}">
<link rel="stylesheet" href="{{asset('/css/carousel-custom.css')}}">
@endsection

@section('content')
<div class="container profileContainer" style="background-color:rgba(0, 0, 0, 0.1);
        padding: 60px 60px 60px 30px !important;">
    <div class="row">
        <div class="col-md-8 col-sm-12">
            <div class="d-flex align-self-center justify-content-between profile-info-top">
                <span class="name">
                    {{ $profile->name }} <span class="age">| {{ $profile->age }} лет</span>
                </span>

                <span class="phone align-self-baseline mt-1">
                    <a href="tel:{{ $phone }}" style="color:#fff">{{ $phone }}</a>
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

    <div class="row mt-3 mb-4">
        <div class="col-md-7 col-sm-12">
            <div class="nc-location d-flex">
                <img class="img-fluid align-self-center" src="{{asset('/images/info.png')}}">
                <div class="align-self-center ml-2 d-flex flex-column address">
                    <span class="font-italic"> Пожалуйста, начните разговор со слов:<br>
                        "Здравствуйте, звоню с сайта ns-samara.com" и я всё пойму...</span>
                </div>
            </div>
        </div>
        <div class="col-md-5 col-sm-12 d-flex justify-content-end sub-info">
            <ul class="align-self-center ml-2 d-flex flex-column">
                @if($profile->apartments)
                <li class="tagsInfo font-italic">С апартаментами</li>
                @endif

                @if($profile->check_out)
                <li class="tagsInfo font-italic">Выезд 
                    @if($profile->check_out_rooms)
                    Квартиры
                    @endif
                    @if($profile->check_out_hotels)
                    Гостиницы
                    @endif
                    @if($profile->check_out_saunas)
                    Сауны
                    @endif
                    @if($profile->check_out_offices)
                    Офисы
                    @endif
                </li>
                @endif
            </ul>
        </div>
    </div>
    <!-- Swiper -->

    <div class="row swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <a data-index="0" data-fancybox="gallery"
                    href="{{asset('/images/profiles/images/created/' . $profile->main_image)}}" style="display:block">
                    <div
                        style="height: 372px;
                        background-size: cover;
                        background-position: center;
                        background-image: url('{{asset('/images/profiles/images/created/' . $profile->main_image)}}');">
                    </div>
                </a>
            </div>




            @foreach($profile->images->where('verification_img', '0')->all() as $image)
            <div class="swiper-slide">
                <a data-index="{{$loop->index + 1}}" data-fancybox="gallery"
                    href="{{asset('/images/profiles/images/created/'. $image->name )}}" style="display:block">
                    <div style="height: 372px;
                        background-size: cover;
                        background-position: center;
                        background-image: url('{{asset('/images/profiles/images/created/'. $image->name )}}');"></div>

                </a>
            </div>
            @endforeach
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <!-- Add Arrows -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
    <div class="row owl-carousel" style="cursor:pointer">




    </div>

    <div class="row mt-4">
        <div class="col-md-12 col-sm-12">
            <h4 class="font-italic">О себе</h4>
            <p class="font-italic priceFont">
                {{ $profile->about }}
            </p>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4 col-sm-12">
            <h4 class="font-italic">Стоимость</h4>
            <div class="d-flex justify-content-between">
                @if($profile->euro_hour)
                <div class="d-flex flex-column">
                    <span class="font-italic">Евро час</span>
                    <span class="font-italic mt-1 priceFont">{{ $profile->euro_hour }}</span>
                </div>
                @endif
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
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <h4 class="font-italic h4-about">Описание</h4>
            <div class="d-flex flex-column">
                <div class="row  d-flex justify-content-between align-items-end font09">
                    <div class="col-4 font-italic">Город</div>
                    <div class="col-2 font-italic"><img class="img-fluid align-self-bottom"
                            src="{{asset('/images/line.png')}}"></div>
                    <div class="col-5 ml-2 font-italic">Самара</div>
                </div>
                <div class="row  d-flex justify-content-between align-items-end font09">
                    <div class="col-4 font-italic">Район</div>
                    <div class="col-2 font-italic"><img class="img-fluid align-self-bottom"
                            src="{{asset('/images/line.png')}}"></div>
                    <div class="col-5 ml-2 font-italic">{{ $profile->districts->first()->name }}</div>
                </div>
                <div class="row d-flex justify-content-between align-items-end font09">
                    <div class="col-4 font-italic">Возраст</div>
                    <div class="col-2 font-italic"><img class="img-fluid align-self-bottom"
                            src="{{asset('/images/line.png')}}"></div>
                    <div class="col-5 ml-2 font-italic">{{ $profile->age }}</div>
                </div>
                <div class="row d-flex justify-content-between align-items-end font09">
                    <div class="col-4 font-italic">Рост</div>
                    <div class="col-2 font-italic"><img class="img-fluid align-self-bottom"
                            src="{{asset('/images/line.png')}}"></div>
                    <div class="col-5 ml-2 font-italic">{{ $profile->height }}</div>
                </div>
                <div class="row d-flex justify-content-between align-items-end font09">
                    <div class="col-4 font-italic">Вес</div>
                    <div class="col-2 font-italic"><img class="img-fluid align-self-bottom"
                            src="{{asset('/images/line.png')}}"></div>
                    <div class="col-5 ml-2 font-italic">{{ $profile->weight }}</div>
                </div>
                <div class="row d-flex justify-content-between align-items-end font09">
                    <div class="col-4 font-italic">Грудь</div>
                    <div class="col-2 font-italic"><img class="img-fluid align-self-bottom"
                            src="{{asset('/images/line.png')}}"></div>
                    <div class="col-5 ml-2 font-italic">{{ $profile->boobs }}</div>
                </div>
                <div class="row d-flex justify-content-between align-items-end font09">
                    <div class="col-4 font-italic">Цвет волос</div>
                    <div class="col-2 font-italic"><img class="img-fluid align-self-bottom"
                            src="{{asset('/images/line.png')}}"></div>
                    <div class="col-5 ml-2 font-italic">{{ $profile->hairs->first()->name }}</div>
                </div>
                <div class="row d-flex justify-content-between align-items-end font09">
                    <div class="col-4 font-italic">Внешность</div>
                    <div class="col-2 font-italic"><img class="img-fluid align-self-bottom"
                            src="{{asset('/images/line.png')}}"></div>
                    <div class="col-5 ml-2 font-italic">{{ $profile->appearances->first()->name }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container profileContainer mb-3" style="background-color:rgba(255,255,255, 0.1);
    padding: 60px 60px 60px 30px !important;">
    <div class="row">
        <div class="col-md-8 col-sm-12">
            <h4 class="font-italic">Услуги</h4>
            <div class="row ">
                <div class="col">
                    @foreach($services as $service)
                    <div class="col d-flex">
                        <div class="row flex-column">
                            <div class="col mt-3">
                                <h5 class="font-italic mb-2" style="font-weight: 900; font-size: 1.3em"><u>{{ $service->name }}:</u></h5>

                                <div class="d-flex flex-column">
                                    @foreach($service->childrenRecursive as $serviceChild)
                                    @if($profile->services->where('id', $serviceChild->id)->first())
                                    <span
                                        class="font-italic">{{ $profile->services->where('id', $serviceChild->id)->first()->name }}
                                        @if($profile->services->where('id', $serviceChild->id)->first()->pivot->price <>
                                            null)
                                            {!! '<span class="service-price"> + ' . $profile->services->where('id', $serviceChild->id)->first()->pivot->price . 'руб. </span>'!!}
                                            @endif</span>
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
                    <h4 class="font-italic">Похожие анкеты</h4>

                    <div class="div d-flex justify-content-between">
                        <a class="mr-2" href="#nc-carouselSimilars" role="button" data-slide="prev">
                            <img class="img-fluid align-self-bottom"
                                src="{{asset('/images/analog_profiles_left.png')}}">
                        </a>
                        <a class="ml-2" href="#nc-carouselSimilars" role="button" data-slide="next">
                            <img class="img-fluid align-self-bottom"
                                src="{{asset('/images/analog_profiles_right.png')}}">
                        </a>
                    </div>
                </div>


                <div class="carousel-inner">
                    @foreach($similarProfiles as $similar)
                    <div class="carousel-item @if($loop->iteration == 1) active @endif">
                        <a href="{{route("getprofile", $similar->id)}}">
                            <img src="{{asset('/images/profiles/images/created/' . $similar->main_image)}}"
                                class="img-fluid mt-3" title="{{$similar->name}}">
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>

<script src="{{asset('js/swiper/js/swiper.min.js')}}"></script>
<script>
    $('#nc-carouselSimilars').carousel({
            interval : 2500
        });
</script>

<script>
    var productSwiper = new Swiper('.swiper-container', {
			slidesPerView: 4,
			speed: 500,
			loop: true,
			observer: true,
			observeParents: true,
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
			breakpoints: {
				320: {
					slidesPerView: 1
				},
				576: {
					slidesPerView: 2
				},
				768: {
					slidesPerView: 3
				},
				992: {
					slidesPerView: 4
				},
			  }
		});
</script>
@endsection