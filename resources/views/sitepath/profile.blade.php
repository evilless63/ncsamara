@extends('layouts.site')

@section('profileBody')
    class="profileBody"
@endsection

@section('content')
    <div class="container profileContainer" style="background-color:rgba(0, 0, 0, 0.1);
        padding: 60px 60px 60px 30px !important;">
        <div class="row">
            <div class="col-md-7 col-sm-12">
                <div class="d-flex align-self-center justify-content-between">
                    <span class="name">
                        Камилла <span class="age">| 35 лет</span>
                    </span>

                    <span class="phone align-self-baseline mt-1">
                        +7996 749 88 17
                    </span>

                    <div class="nc-location d-flex">
                        <img class="img-fluid align-self-center" src="{{asset('/images/location.png')}}">
                        <div class="align-self-center ml-2 d-flex flex-column address">
                            <span> Кировский р-н / c 06:00 до 24:00</span>
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
                    <li class="tagsInfo font-italic">С апартаментами</li>
                    <li class="tagsInfo font-italic">Выезд</li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 col-sm-12">
                <img src="{{asset('/images/profile/1.png')}}" class="img-fluid">
            </div>
            <div class="col-md-4 col-sm-12">
                <img src="{{asset('/images/profile/2.png')}}" class="img-fluid">
            </div>
            <div class="col-md-4 col-sm-12">
                <img src="{{asset('/images/profile/3.png')}}" class="img-fluid">
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-4 col-sm-12">
                <h5 class="font-italic">Стоимость</h5>
                <div class="d-flex justify-content-between">
                    <div class="d-flex flex-column">
                        <span class="font-italic">За час</span>
                        <span class="font-italic mt-1 priceFont">5000</span>
                    </div>
                    <div class="d-flex flex-column">
                        <span class="font-italic">За 2 часа</span>
                        <span class="font-italic mt-1 priceFont">10000</span>
                    </div>
                    <div class="d-flex flex-column">
                        <span class="font-italic">За ночь</span>
                        <span class="font-italic mt-1 priceFont">40000</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 ml-5">
                <h5 class="font-italic">Описание</h5>
                <div class="d-flex flex-column">
                    <div class="row  d-flex justify-content-between align-items-end">
                        <div class="col-md-5 font-italic">Город</div>
                        <div class="col font-italic"><img class="img-fluid align-self-bottom"
                                                          src="{{asset('/images/line.png')}}"></div>
                        <div class="col ml-2 font-italic">Самара</div>
                    </div>
                    <div class="row  d-flex justify-content-between align-items-end">
                        <div class="col-md-5 font-italic">Район</div>
                        <div class="col font-italic"><img class="img-fluid align-self-bottom"
                                                          src="{{asset('/images/line.png')}}"></div>
                        <div class="col ml-2 font-italic">Кировский</div>
                    </div>
                    <div class="row d-flex justify-content-between align-items-end">
                        <div class="col-md-5 font-italic">Возраст</div>
                        <div class="col font-italic"><img class="img-fluid align-self-bottom"
                                                          src="{{asset('/images/line.png')}}"></div>
                        <div class="col ml-2 font-italic">25</div>
                    </div>
                    <div class="row d-flex justify-content-between align-items-end">
                        <div class="col-md-5 font-italic">Рост</div>
                        <div class="col font-italic"><img class="img-fluid align-self-bottom"
                                                          src="{{asset('/images/line.png')}}"></div>
                        <div class="col ml-2 font-italic">179</div>
                    </div>
                    <div class="row d-flex justify-content-between align-items-end">
                        <div class="col-md-5 font-italic">Вес</div>
                        <div class="col font-italic"><img class="img-fluid align-self-bottom"
                                                          src="{{asset('/images/line.png')}}"></div>
                        <div class="col ml-2 font-italic">59</div>
                    </div>
                    <div class="row d-flex justify-content-between align-items-end">
                        <div class="col-md-5 font-italic">Грудь</div>
                        <div class="col font-italic"><img class="img-fluid align-self-bottom"
                                                          src="{{asset('/images/line.png')}}"></div>
                        <div class="col ml-2 font-italic">3</div>
                    </div>
                    <div class="row d-flex justify-content-between align-items-end">
                        <div class="col-md-5 font-italic">Цвет волос</div>
                        <div class="col font-italic"><img class="img-fluid align-self-bottom"
                                                          src="{{asset('/images/line.png')}}"></div>
                        <div class="col ml-2 font-italic">Блондинка</div>
                    </div>
                    <div class="row d-flex justify-content-between align-items-end">
                        <div class="col-md-5 font-italic">Внешность</div>
                        <div class="col font-italic"><img class="img-fluid align-self-bottom"
                                                          src="{{asset('/images/line.png')}}"></div>
                        <div class="col ml-2 font-italic">Славянская</div>
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
                <div class="row">
                    <div class="col d-flex">
                        <div class="row flex-column">
                            <div class="col mt-3">
                                <h5 class="font-italic mb-2"><u>Секс:</u></h5>

                                <div class="d-flex flex-column">
                                    <span class="font-italic">Классика</span>
                                    <span class="font-italic">Анальный</span>
                                </div>

                            </div>
                            <div class="col mt-3">
                                <h5 class="font-italic mb-3"><u>Ласка:</u></h5>
                                <span class="font-italic">С резинкой</span>
                                <span class="font-italic">Без резинки</span>
                                <span class="font-italic">Глубокий</span>
                                <span class="font-italic">Кунилингус</span>
                                <span class="font-italic">Анилингус</span>
                            </div>
                            <div class="col mt-3">
                                <h5 class="font-italic mb-3"><u>Стриптиз:</u></h5>
                                <span class="font-italic">Не профи</span>
                            </div>
                        </div>

                    </div>
                    <div class="col d-flex flex-column">
                        <div class="row flex-column">
                            <div class="col mt-3">

                                <h5 class="font-italic mb-2"><u>Экстрим:</u></h5>

                                <div class="d-flex flex-column">
                                    <span class="font-italic">Игрушки</span>
                                    <span class="font-italic">Страпон</span>
                                </div>

                            </div>
                            <div class="col mt-3">
                                <h5 class="font-italic mb-3"><u>Фистинг:</u></h5>
                                <span class="font-italic">Анальный</span>
                                <span class="font-italic">Классический</span>
                            </div>
                            <div class="col mt-3">
                                <h5 class="font-italic mb-3"><u>Массаж:</u></h5>
                                <span class="font-italic"></span>Классический</span>
                                <span class="font-italic">Расслабляющий</span>
                                <span class="font-italic">Эротический</span>
                            </div>
                        </div>
                    </div>
                    <div class="col d-flex flex-column">
                        <div class="row flex-column">
                            <div class="col mt-3">
                                <h5 class="font-italic mb-2"><u>Финиш:</u></h5>

                                <div class="d-flex flex-column">
                                    <span class="font-italic">В рот</span>
                                    <span class="font-italic">На лицо</span>
                                    <span class="font-italic">На грудь</span>
                                </div>

                            </div>
                            <div class="col mt-3">
                                <h5 class="font-italic mb-3"><u>Дополнительно:</u></h5>
                                <span class="font-italic">Экскорт</span>
                                <span class="font-italic">Услуги семейной паре</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 d-flex flex-column">
                <div class="d-flex justify-content-between">
                    <h5 class="font-italic">Похожие анкеты</h5>
                    <div class="div d-flex justify-content-between">
                        <a href="" class="mr-2">
                            <img class="img-fluid align-self-bottom" src="{{asset('/images/analog_profiles_left.png')}}">
                        </a>
                        <a href="" class="ml-2">
                            <img class="img-fluid align-self-bottom" src="{{asset('/images/analog_profiles_right.png')}}">
                        </a>
                    </div>
                </div>

                <img src="{{asset('/images/profile/1.png')}}" class="img-fluid mt-3">


            </div>
        </div>
    </div>
@endsection
