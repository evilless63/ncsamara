@extends('layouts.app')

@section('assetcarousel')

<link rel="stylesheet" href="{{asset('js/owl/assets/owl.carousel.min.css')}}">
<link rel="stylesheet" href="{{asset('js/owl/assets/owl.theme.default.min.css')}}">
<link rel="stylesheet" href="{{asset('/css/carousel-custom.css')}}">
@endsection

@section('google_api_autocomplete')

<script>
    let map;
    let markerUse;
    let markersArray = [];

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {
                lat: 53.224834,
                lng: 50.190315
            },
            zoom: 15
        });

        let latLng = new google.maps.LatLng({{ $profile->address_x ? $profile->address_x : '1' }}, {{ $profile->address_y ? $profile->address_y : '1' }});
        addMarker(latLng);
        

        map.addListener('click', function(e) {
            console.log(e);
            addMarker(e.latLng);
        });
    }

    // define function to add marker at given lat & lng
    function addMarker(latLng) {

        for (var i = 0; i < markersArray.length; i++) {
            markersArray[i].setMap(null);
        }
        markersArray.length = 0;

        let marker = new google.maps.Marker({
            map: map,
            position: latLng,
            draggable: true,
            title: 'Я здесь !'
        });

        document.getElementById("address_x").value = latLng.lat();
        document.getElementById("address_y").value = latLng.lng();

        markersArray.push(marker);
    }
</script>

<script async defer type="text/javascript"
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD2zWS_b-EUkyWjg4cqA_TN-l-lch8-LXo&libraries=places&callback=initMap">
</script>



@endsection

@section('content')

<div class="row justify-content-center">
    <div class="col-md-12">
        {{-- TODO Разобраться с кнопками управления --}}
        <h2>Редактирование анкеты {{$profile->name}}
            @if($profile->verified)
            (Подтверждена)
            @else
            (Не подтверждена)
            @endif</h2>
        <div class="col-md-4 d-flex justify-content-between mt-3 mb-3">
            @if($profile->allowed)
                @if($profile->is_published == 0)
                <form action="{{ route('user.profilepublish', $profile->id) }}" method="POST">
                    @csrf
                    @method('patch')
                    <button class="btn btn-success" style="padding: 0px 7.5px;" type="submit">Опубликовать</button>
                </form>
                @else
                <form action="{{ route('user.profileunpublish', $profile->id) }}" method="POST">
                    @csrf
                    @method('patch')
                    <button class="btn btn-danger" style="padding: 0px 7.5px;" type="submit">Снять с публикации</button>
                </form>

            @if(Auth::user()->is_admin)
            <form action="{{ route('admin.profilemoderatedisallow', $profile->id) }}" method="POST">
                @csrf
                @method('patch')
                <button class="btn btn-success" style="padding: 0px 7.5px;" type="submit">Запретить публикацию</button>
            </form>
            @endif
            @endif
                @else
                @if(Auth::user()->is_admin)
                <form action="{{ route('admin.profilemoderateallow', $profile->id) }}" method="POST">
                    @csrf
                    @method('patch')
                    <button class="btn btn-danger" style="padding: 0px 7.5px;" type="submit">Разрешить публикацию</button>
                </form>
                @else
                Анкета на модерации администрации сайта
                @endif
            @endif

            @if(Auth::user()->is_admin)
            @if($profile->verified == 0)
            <form action="{{ route('admin.profileverify', $profile->id) }}" method="POST">
                @csrf
                @method('patch')
                <button class="btn btn-success" style="padding: 0px 7.5px;" type="submit">Подтвердить</button>
            </form>
            @else
            <form action="{{ route('admin.profileunverify', $profile->id) }}" method="POST">
                @csrf
                @method('patch')
                <button class="btn btn-danger" style="padding: 0px 7.5px;" type="submit">Снять подтверждение</button>
            </form>
            @endif
            @endif
        </div>


        <form action="{{ route('user.profiles.update', $profile->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('patch')

            @if(count($errors))
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                    <li>Не заполнено, или неправильно заполнено: {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if (!empty(session('success')))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <ul class="nav nav-pils nav-pills-userpanel">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#panel1">Основные
                        данные</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#panel2">Услуги</a></li>

            </ul>

            <div class="tab-content">
                <div id="panel1" class="tab-pane fadein active">
                    <div class="row">
                        <div class="col-md-7">

                            <h4 class="align-self-center mt-4 mb-4">Заполните все пункты анкеты</h4>
                            <h5>Поля, отмеченные "*" обязательны к заполнению</h5>
                            <div class="form-group d-flex justify-content-between">
                                <label for="profileName">Имя *:</label>
                                <input name="name" type="text" id="profileName"
                                    class="form-control col-8  @error('name') is-invalid @enderror"
                                    placeholder="Укажите имя в анкете" value="{{ $profile->name }}">
                            </div>

                            <div class="form-group  d-flex justify-content-between">
                                <label for="profileAge">Возраст *:</label>
                                <input name="age" type="number" id="profileAge"
                                    class="form-control col-8 @error('age') is-invalid @enderror" placeholder=""
                                    value="{{ $profile->age }}" placeholder="Лет (18-75)">
                            </div>

                            <div class="form-group d-flex justify-content-between">
                                <label for="profileHeight">Рост *:</label>
                                <input name="height" type="number" id="profileHeight"
                                    class="form-control col-8 @error('height') is-invalid @enderror" placeholder=""
                                    value="{{ $profile->height }}" placeholder="см. (130 -210)">
                            </div>

                            <div class="form-group d-flex justify-content-between">
                                <label for="profileWeight">Вес *:</label>
                                <input name="weight" type="number" id="profileWeight"
                                    class="form-control col-8 @error('weight') is-invalid @enderror" placeholder=""
                                    value="{{ $profile->weight }}" placeholder="кг. (40-200)">
                            </div>

                            <div class="form-group d-flex justify-content-between">
                                <label for="profileBoobs">Размер груди *:</label>
                                <input name="boobs" type="number" id="profileBoobs"
                                    class="form-control col-8 @error('boobs') is-invalid @enderror" placeholder=""
                                    value="{{ $profile->boobs }}" placeholder="(1-7)">
                            </div>

                            <div class="form-group d-flex justify-content-between">
                                <label for="profileAppearance">Цвет волос *</label>
                                <select class="form-control col-8" name="hair" id="profileHair">
                                    @foreach($hairs as $hair)
                                    <option {{$profile->hairs->first()->id == $hair->id ? 'selected' : ''}}
                                        value="{{$hair->id}}">
                                        {{ $hair->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group d-flex justify-content-between">
                                <label for="profileAppearance">Внешность *</label>
                                <select class="form-control col-8" name="appearance" id="profileAppearance">
                                    @foreach($appearances as $appearance)
                                    <option {{$profile->appearances->first()->id == $appearance->id ? 'selected' : ''}}
                                        value="{{$appearance->id}}">
                                        {{ $appearance->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- TODO - национальность (или внешность) уточнить, что и как должно быть --}}

                            <div class="form-group d-flex justify-content-between">
                                <label for="profilePhone">Телефон *:</label>
                                <input name="phone" type="text" id="profilePhone"
                                    class="profilePhone form-control col-8 @error('phone') is-invalid @enderror"
                                    placeholder="c 8, 11 цифр номера" value="{{ $profile->phone }}">
                                {{-- TODO - макет для телефона js --}}
                            </div>

                            <div class="form-group d-flex justify-content-between">
                                <label for="profileDistrict">Район города *:</label>
                                <select class="form-control col-8" name="district" id="profileDistrict">
                                    @foreach($districts as $district)

                                    <option {{$profile->districts->first()->id == $district->id ? 'selected' : ''}}
                                        value="{{$district->id}}">
                                        {{ $district->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group form-inline d-flex justify-content-between">
                                <label for="profileWorkingHoursFrom">Время работы c *: </label>

                                <input name="working_hours_from" type="number" min="0" max="24"
                                    id="profileWorkingHoursFrom"
                                    class="form-control @error('working_hours_from') is-invalid @enderror"
                                    value="{{ $profile->working_hours_from }}">

                                <label for="profileWorkingHoursTo">до *: </label>

                                <input name="working_hours_to" type="number" min="0" max="24" id="profileWorkingHoursTo"
                                    class="form-control @error('working_hours_to') is-invalid @enderror"
                                    value="{{ $profile->working_hours_to }}">

                                <div class="form-check">
                                    <input type="hidden" name="working_24_hours" value="0">
                                    <input class="form-check-input" onclick="initializeFromToWorkingHours(event)" type="checkbox" id="profileWork24Hours"
                                        name="working_24_hours" value="1"
                                        {{$profile->profileWork24Hours ? 'checked' : ''}}>
                                    <label class="form-check-label" for="profileWork24Hours">
                                        Работаю всегда (без перерыва и выходных) *
                                    </label>
                                </div>

                                {{-- TODO при установке галочки - от и до "затеняются", обязательно либо от до либо 24 часа --}}
                            </div>

                            <p>Расценки:</p>

                            <div class="row justify-content-center">
                                <div class="col-md-4">
                                    <div class="form-group form-inline d-flex justify-content-between">
                                        <label for="profileEuroHour">Еврочас:</label>
                                        <input name="euro_hour" type="number" id="profileEuroHour"
                                            class="form-control @error('euro_hour') is-invalid @enderror" placeholder=""
                                            value="{{ $profile->euro_hour }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-inline d-flex justify-content-between">
                                        <label for="profileOneHour">За час *:</label>
                                        <input name="one_hour" type="number" id="profileOneHour"
                                            class="form-control @error('one_hour') is-invalid @enderror" placeholder=""
                                            value="{{ $profile->one_hour }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-md-4">
                                    <div class="form-group form-inline d-flex justify-content-between">
                                        <label for="profileTwoHour">За два *:</label>
                                        <input name="two_hour" type="number" id="profileTwoHour"
                                            class="form-control @error('two_hour') is-invalid @enderror" placeholder=""
                                            value="{{ $profile->two_hour }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-inline d-flex justify-content-between">
                                        <label for="profileAllNight">За ночь *:</label>
                                        <input name="all_night" type="number" id="profileAllNight"
                                            class="form-control @error('all_night') is-invalid @enderror" placeholder=""
                                            value="{{ $profile->all_night }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-5 d-flex justify-content-between">
                                <label for="profileOneHour">О себе *:</label>
                                <textarea name="about" class="form-control col-10 @error('about') is-invalid @enderror"
                                    id="profileAbout" placeholder="О себе" rows="3">{!! $profile->about !!}</textarea>
                            </div>

                            <p>Территория:</p>

                            <div class="row justify-content-center">
                                <div class="col-md-3">
                                    <div class="form-check align-self-center">

                                        <input type="hidden" name="apartments" value="0">
                                        <input class="form-check-input mt-3" type="checkbox" id="profileApartaments"
                                            name="apartments" value="1" {{$profile->apartments ? 'checked' : ''}}>
                                        <label class="form-check-label  mt-2" for="profileApartaments">
                                            Апартаменты
                                        </label>
                                    </div>
                                    <div class="form-check align-self-center">

                                        <input type="hidden" name="check_out" value="0">
                                        <input class="form-check-input mt-3" type="checkbox" id="profileCheckOut"
                                            name="check_out" value="1" {{$profile->check_out ? 'checked' : ''}}>
                                        <label class="form-check-label  mt-2" for="profileCheckOut">
                                            Выезжаю
                                        </label>
                                        {{-- TODO прицепить связь выбора куда 
                                                    - Квартиры
                                                    - Гостиницы
                                                    - Сауны
                                                    - Офисы 
                                                    
                                                    Необязательный реквизит--}}
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-5">
                                <div class="col-md-8">
                                    <p>Вы можете отметить ваше местоположение на карте. В таком случае, всем
                                        пользователям
                                        сайта будет доступна эта информация</p>
                                </div>
                                <div class="col-md-4">
                                    <div class="deleteImage btn btn-danger" onclick="removeMarker(event)">Удалить с
                                        карты
                                    </div>
                                </div>
                                <div class="col-md-12">



                                    <div id="map" style="width: 100%;
                                        height: 450px;
                                        background-color: grey;"></div>


                                    <input type="hidden" name="address_x" id="address_x" value="{{ old('address_x') }}">
                                    <input type="hidden" name="address_y" id="address_y" value="{{ old('address_y') }}">
                                </div>
                            </div>

                            <hr>

                            <h4 class="align-self-center mt-4 mb-4">Добавление / редактирование фотографий</h4>

                            <div class="form-group">

                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="label" data-toggle="tooltip" title=""
                                            data-original-title="Кликните для загрузки основного изображения анкеты">
                                            <img class="rounded" id="avatar" src="{{asset('/admin/icons/add_img.png')}}"
                                                alt="avatar">
                                            <input type="file" class="sr-only" id="input" name="image" accept="image/*">
                                        </label>
                                    </div>
                                    <div class="col-md-8">
                                        <h5>Загрузка нового фото (для главной страницы сайта)</h5>
                                        - минимальное разрешение 400 px <br>
                                        - Допускаются к размещению только фотографии хорошего качества <br>
                                        - На фотографиях не должны быть водяные знаки, логотипы других сайтов <br>
                                        - На фотографиях не должны быть видны гениталии
                                    </div>
                                </div>


                                <div class="modal fade" id="modal" tabindex="-1" role="dialog"
                                    aria-labelledby="modalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalLabel">Выберите учаток изображения для
                                                    загрузки</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Колесом мыши менять масштаб<br> для выбора участка загружаемого
                                                    изображения, перетаскивайте активную зону</p>
                                                <div class="img-container">
                                                    <img id="image" src="">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Отмена</button>
                                                <button type="button" class="btn btn-primary"
                                                    id="crop">Загрузить</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <input type="hidden" autocomplete="OFF" name="main_image" id="main_image" placeholder=""
                                    class="form-control input-sm" value="{{$profile->main_image}}" />
                            </div>

                            <hr>

                            <h4 class="mt-4 mb-4">Загрузка фото (для страницы анкеты, минимум - 3 , максимум - 10)</h4>

                            <div class="row align-items-center">
                                <div class="col-md-10 owl-carousel owl-theme">
                                    <div class="col-md-12 imageContainer">
                                        <a data-index="0" data-fancybox="gallery1"
                                            href="{{asset('/images/profiles/images/created/' . $profile->main_image)}}"
                                            style="display:block">
                                            <img class="img-fluid delpath"
                                                delpath="{{ asset('/images/profiles/images/created/' . $profile->main_image )}}"
                                                src="{{ asset('/images/profiles/images/created/' . $profile->main_image) }}"
                                                alt="">
                                            <div class="deleteImage btn btn-danger">Главное фото</div>
                                        </a>
                                    </div>
                                    @foreach($profile->images->where('verification_img', '0')->all() as $image)
                                    <div class="col-md-12 imageContainer item">
                                        <a data-index="0" data-fancybox="gallery1"
                                            href="{{asset('/images/profiles/images/created/' . $image->name)}}"
                                            style="display:block">
                                            <img class="img-fluid delpath"
                                                delpath="{{'/images/profiles/images/created/' . $image->name }}"
                                                src="{{ '/images/profiles/images/created/' . $image->name }}" alt="">
                                            <div class="deleteImage btn btn-danger"
                                                onclick="deleteImagesAttached(event)" imageId="{{$image->id}}">Удалить
                                            </div>
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="hidden" autocomplete="OFF" name="item_images" id="item_images"
                                            placeholder="" class="form-control input-sm" required />
                                        <button type="button" class="btn btn-lg add-image-button" data-toggle="modal"
                                            data-target="#myModal"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <h4 class="mt-4 mb-4">Загрузка проверочных фото</h4>

                            <p>
                                - Для проверки фотографии и получения отметки "Проверено" загрузите проверочное
                                фото с листом бумаги с актуальной датой. Подтвержденные фнкеты посещают чаще и больше
                                звонков. <br>
                                - По проверочное фото должно быть хорошего качества, с читаемой датой на листе бумаги,
                                должно быть понятно, что на фотографиях
                                анкеты вы, добавляете несколько фотографий с лицом и фигурой.
                            </p>

                            <div class="row align-items-center">
                                <div class="col-md-10 owl-carousel owl-theme">
                                    @foreach($profile->images->where('verification_img', '1')->all() as $image)
                                    <div class="col-md-12 imageContainer item">
                                        <a data-index="0" data-fancybox="gallery2"
                                            href="{{asset('/images/profiles/images/created/' . $image->name)}}"
                                            style="display:block">
                                            <img class="img-fluid delpath"
                                                delpath="{{'/images/profiles/images/created/' . $image->name }}"
                                                src="{{ '/images/profiles/images/created/' . $image->name }}" alt="">
                                            <div class="deleteImage btn btn-danger"
                                                onclick="deleteImagesAttached(event)" imageId="{{$image->id}}">Удалить
                                            </div>
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="hidden" autocomplete="OFF" name="item_images_verification"
                                            id="item_images_verification" placeholder=""
                                            class="form-control input-sm" />
                                        <button type="button" class="btn btn-lg add-image-button" data-toggle="modal"
                                            data-target="#myModalItem_images_verification"><i
                                                class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>

                            <h4 class="mt-4 mb-4">Тарифный план *</h4>

                            <input type="hidden" name="rate" value="
                                                @if($profile->rates->count() > 0)
                                                    {{$profile->rates->first()}}
                                                @endif">
                            <select class="form-control" style="width:100%" name="rate" id="profileRate">
                                <option></option>
                                @foreach($rates as $rate)
                                <option value="{{$rate->id}}"
                                    {{$profile->rates->count() > 0 && $profile->rates->first()->id == $rate->id ? 'selected' : ''}}>
                                    {{ $rate->name }} {{ $rate->cost }} руб./сутки</option>
                                @endforeach
                            </select>

                            <p>Внимание !!! Переключение тарифного плана произойдет не сразу, а при следующей
                                попытки
                                оплаты анкеты<br>Переключение тарифного плана произойдет только в случае достаточного
                                количества
                                Пойнтов
                                на балансе анкеты</p>
                        </div>
                    </div>
                </div>
                <div id="panel2" class="tab-pane fade">
                    @foreach($services as $service)

                    <h6>{{$service->name}}</h6>

                    @foreach($service->childrenRecursive as $service)
                    <div class="form-check ml-2">
                        <div class="row profileServiceBlock mt-1" profile-id="{{$profile->id}}"
                            service-id="{{$service->id}}">
                            <div class="col-md-4">
                                <input class="form-check-input profileServiceCheckbox"
                                    onclick="initializePriseField(event)" type="checkbox"
                                    id="profileService{{$service->id}}" name="services[]" value="{{$service->id}}"
                                    {{$profile->services->find($service->id) <> null ? 'checked' : ''}}>
                                <label class="form-check-label" for="profileApartaments">
                                    {{$service->name}}
                                </label>
                            </div>
                            <div class="col-md-8 profileServicePrice">
                                @if(Auth::user()->id === $profile->user_id && $profile->services->find($service->id) <>
                                    null)

                                    <div class="row profileServicePriceRow">
                                        <div class="col-md-4 servicePriceUpdateInfo">
                                            <span>Доплата за услугу:</span>
                                        </div>
                                        <div class="col-md-8 d-flex justify-content-between servicePriceUpdate">
                                            <input style="    width: 65%;" class="form-control"
                                                data-price="{{ $service->pivot <> null ? $service->pivot->price : '' }}"
                                                data-service-id="{{$service->id}}" data-profile-id="{{$profile->id}}"
                                                name="priceupdate" type="text"
                                                value="@if($profile->services->where('id', $service->id)->first()->pivot->price) {{$profile->services->where('id', $service->id)->first()->pivot->price}}@endif">

                                            <div class="btn btn-success btn-fab btn-fab-mini btn-round price_update_info"
                                                style="padding:0rem .75rem" data-toggle="tooltip" data-placement="top"
                                                title="Обновить цену услуги" onclick="updateServicePrice(event)">

                                                @if($profile->services->where('id', $service->id)->first()->pivot->price)

                                                    Изменить/Удалить доплату
                                                    @else
                                                    Добавить доплату
                                                    @endif

                                            </div>
                                        </div>
                                    </div>

                                    @else
                                    <div class="row profileServicePriceRow">

                                        {!! $service->pivot<> null ? '<div class="col-md-4"><span>Доплата за услугу:' .
                                                    $service->pivot->price . 'р.</span></div>' : ''!!}



                                    </div>

                                    @endif
                            </div>
                        </div>



                    </div>
                    @endforeach
                    @endforeach
                </div>
            </div>



            <button type="submit" class="btn btn-success">Сохранить изменения в анкете</button>
        </form>
    </div>
</div>

<!-- MODAL START -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Загрузка новых изображений</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" class="dropzone" id="dropzone" method="post" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="dz-message" data-dz-message><span>Переместите сюда файлы для загрузки (или нажмите сюда
                            и выберите их)</span>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>

    </div>
</div>
<!-- MODAL END -->

<!-- MODAL VERIFICATION START -->
<div class="modal fade" id="myModalItem_images_verification" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Загрузка новых изображений</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" class="dropzone" id="dropzone-ver" method="post" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="dz-message" data-dz-message><span>Переместите сюда файлы для загрузки (или нажмите сюда
                            и выберите их)</span>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>

    </div>
</div>
<!-- MODAL END -->
@endsection

@section('script')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js"></script>


<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    Dropzone.autoDiscover = false;
    var acceptedFileTypes = "image/*"; //dropzone requires this param be a comma separated list
    // imageDataArray variable to set value in crud form
    var imageDataArray = new Array;
    var imageDataArrayVer = new Array;
    // fileList variable to store current files index and name
    var fileList = new Array;
    var fileListVer = new Array;
    var i = 0;
    $(function() {
        uploader = new Dropzone("#dropzone", {
            url: "{{url('user/profiles/upload')}}",
            paramName: "file",
            uploadMultiple: false,
            acceptedFiles: "image/*",
            addRemoveLinks: true,
            forceFallback: false,
            maxFilesize: 4, // Set the maximum file size to 256 MB
            parallelUploads: 100,
        }); //end drop zone
        uploader.on("success", function(file, response) {
            imageDataArray.push(response)
            fileList[i] = {
                "serverFileName": response,
                "fileName": file.name,
                "fileId": i
            };
            i += 1;
            $('#item_images').val(imageDataArray);
        });
        uploader.on("removedfile", function(file) {
            var rmvFile = "";
            for (var f = 0; f < fileList.length; f++) {
                if (fileList[f].fileName == file.name) {
                    // remove file from original array by database image name
                    imageDataArray.splice(imageDataArray.indexOf(fileList[f].serverFileName), 1);
                    $('#item_images').val(imageDataArray);
                    // get removed database file name
                    rmvFile = fileList[f].serverFileName;
                    // get request to remove the uploaded file from server
                    deleteAjaxFile(rmvFile);
                }
            }
        });
    });

    $(function() {
        uploaderVer = new Dropzone("#dropzone-ver", {
            url: "{{url('user/profiles/upload')}}",
            paramName: "file",
            uploadMultiple: false,
            acceptedFiles: "image/*",
            addRemoveLinks: true,
            forceFallback: false,
            maxFilesize: 4, // Set the maximum file size to 256 MB
            parallelUploads: 100,
        }); //end drop zone
        uploaderVer.on("success", function(file, response) {
            imageDataArrayVer.push(response)
            fileListVer[i] = {
                "serverFileName": response,
                "fileName": file.name,
                "fileId": i
            };
            i += 1;
            $('#item_images_verification').val(imageDataArrayVer);
        });
        uploaderVer.on("removedfile", function(file) {
            var rmvFile = "";
            for (var f = 0; f < fileListVer.length; f++) {
                if (fileListVer[f].fileName == file.name) {
                    // remove file from original array by database image name
                    imageDataArrayVer.splice(imageDataArrayVer.indexOf(fileListVer[f].serverFileName), 1);
                    $('#item_images_verification').val(imageDataArrayVer);
                    // get removed database file name
                    rmvFile = fileListVer[f].serverFileName;
                    // get request to remove the uploaded file from server
                    deleteAjaxFile(rmvFile);
                }
            }
        });
    });

    function deleteAjaxFile(rmvFile) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{url('user/profiles/delete')}}",
            type: "post",
            data: {
                file: rmvFile
            },
            success: function(response) {}
        });
    }
</script>
<script>
    function removeMarker(event) {
        document.getElementById("address_x").value = '1';
        document.getElementById("address_y").value = '1';  

        markersArray.forEach(function callback(marker, index, array) {
            marker.setMap(null)
        });
    }

    function initializeFromToWorkingHours(event) {
        if($(event.target).prop("checked")){
            $('#profileWorkingHoursFrom').val("")
            $('#profileWorkingHoursFrom').attr("disabled", true)
            $('#profileWorkingHoursTo').val("")
            $('#profileWorkingHoursTo').attr("disabled", true)
        } else {
            $('#profileWorkingHoursFrom').attr("disabled", false)
            $('#profileWorkingHoursTo').attr("disabled", false)
        }
    }

    function initializePriseField(event) {
        var service_id = $(event.target).parent().parent().attr('service-id')
        var profile_id = $(event.target).parent().parent().attr('profile-id')

        if($(event.target).prop("checked")) {
            $(event.target).parent().parent().find('.profileServicePriceRow').append(
            '<div class="col-md-4 servicePriceUpdateInfo">'+
                '<span>Доплата за услугу:</span></div>' +                           
            '<div class="col-md-8 d-flex justify-content-between servicePriceUpdate">' +
                '<input style="    width: 65%;" class="form-control" data-service-id="' + service_id + '" data-profile-id="' + profile_id + '" name="priceupdate" type="text" value="">' +

                '<div class="btn btn-success btn-fab btn-fab-mini btn-round price_update_info" style="padding:0rem .75rem" data-toggle="tooltip" data-placement="top" title="Обновить цену услуги" onclick="updateServicePrice(event)">' +
                    'Добавить доплату' +
                '</div>' +
            '</div>'
            ) 

            var price = $(event.target).parent('.servicePriceUpdate').find('input[name=priceupdate]').val()

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('user.service.attach')}}",
                type: "post",
                data: {
                    profile_id: profile_id,
                    service_id: service_id,
                    price: price
                },
                success: function(response) {

                }
            });

        } else {
            $(event.target).parent().parent().find('.servicePriceUpdate').remove()
            $(event.target).parent().parent().find('.servicePriceUpdateInfo').remove()

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('user.service.detach')}}",
                type: "post",
                data: {
                    profile_id: profile_id,
                    service_id: service_id,
                    price: price
                },
                success: function(response) {

                }
            });
        }
       
    }

    function updateServicePrice(event) {
        event.preventDefault();

        var price = $(event.target).parent('.servicePriceUpdate').find('input[name=priceupdate]').val()
        var service_id = $(event.target).parent('.servicePriceUpdate').find('input[name=priceupdate]').attr('data-service-id')
        var profile_id = $(event.target).parent('.servicePriceUpdate').find('input[name=priceupdate]').attr('data-profile-id')

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('user.service.pricechange')}}",
            type: "post",
            data: {
                profile_id: profile_id,
                service_id: service_id,
                price: price
            },
            success: function(response) {
                $(event.target).parent('.servicePriceUpdate').find('.price_update_info').text('Цена успешно обновлена')

                setTimeout(function(){
                    $(event.target).parent('.servicePriceUpdate').find('.price_update_info').text(!price ? 'Добавить доплату' : 'Изменить/Удалить доплату');
                }, 3000);
            }
        });

    }

    function deleteImagesAttached(event) {
        var imageId = $(event.target).attr('imageId');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('user.images.deleteimageattach')}}",
            type: "post",
            data: {
                image_id: imageId,
                profile_id: {{$profile->id}},
            },
            success: function(response) {
                $(event.target).parent('.imageContainer').remove()
            }
        });
    }
</script>

<script src="{{asset('js/owl/owl.carousel.min.js')}}"></script>
<script>
    $(document).ready(function(){
          $(".owl-carousel").owlCarousel({
               loop:true,
    responsiveClass:true,
    nav: true,
    responsive:{
        0:{
            items:1,
            nav:true
        },
        400:{
            items:2,
            nav:false
        },
        800:{
            items:5,
            nav:true,
            loop:false
        }
    }
          });
        });

</script>
@endsection