@extends('layouts.app')

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

        let latLng = new google.maps.LatLng({{$profile->address_x}}, {{$profile->address_y}});
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

<script async defer type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD2zWS_b-EUkyWjg4cqA_TN-l-lch8-LXo&libraries=places&callback=initMap"></script>



@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex">
                    <span>Редактирование анкеты
                        @if($profile->verified)
                        (Подтверждена)
                        @else
                        (Не подтверждена)
                        @endif</span>
                    @if($profile->is_published == 0)
                    <form action="{{ route('user.profilepublish', $profile->id) }}" method="POST">
                        @csrf
                        @method('patch')
                        <button type="submit">Опубликовать</button>
                    </form>
                    @else
                    <form action="{{ route('user.profileunpublish', $profile->id) }}" method="POST">
                        @csrf
                        @method('patch')
                        <button type="submit">Снять с публикации</button>
                    </form>
                    @endif
                    @if(Auth::user()->is_admin)
                    @if($profile->verified == 0)
                    <form action="{{ route('admin.profileverify', $profile->id) }}" method="POST">
                        @csrf
                        @method('patch')
                        <button type="submit">Подтвердить</button>
                    </form>
                    @else
                    <form action="{{ route('admin.profileunverify', $profile->id) }}" method="POST">
                        @csrf
                        @method('patch')
                        <button type="submit">Снять подтверждение</button>
                    </form>
                    @endif
                    @endif
                </div>

                <div class="card-body">
                    <form action="{{ route('user.profiles.update', $profile->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        @if(count($errors))
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <ul class="nav nav-tabs">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#panel1">Основные
                                    данные</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#panel2">Услуги</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#panel3">Изображения</a>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#panel4">Настройки
                                    тарифа</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#panel5">Подтверждение
                                    анкеты</a>
                        </ul>

                        <div class="tab-content">
                            <div id="panel1" class="tab-pane fadein active">
                                <div class="form-group">
                                    <label for="profileName">Имя:</label>
                                    <input name="name" type="text" id="profileName" class="form-control @error('name') is-invalid @enderror" placeholder="Укажите имя в анкете" value="{{ $profile->name }}">
                                </div>
                                <div class="form-group">
                                    <label for="profilePhone">Телефон (Только ЦИФРЫ - 11 цифр номера телефона, номер
                                        должен
                                        начинаться с 8) :</label>
                                    <input name="phone" type="text" id="profilePhone" class="form-control @error('phone') is-invalid @enderror" placeholder="Укажите телефон в анкете" value="{{ $profile->phone }}">
                                </div>

                                <div class="form-group">
                                    <label for="profileDistrict">Район города</label>
                                    <select class="form-control" name="district" id="profileDistrict">
                                        @foreach($districts as $district)

                                        <option {{$profile->districts->first()->id == $district->id ? 'selected' : ''}} value="{{$district->id}}">
                                            {{ $district->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div id="map" style="width: 100%;
                                height: 600px;
                                background-color: grey;"></div>


                                <input type="hidden" name="address_x" id="address_x" value="{{ old('address_x') }}">
                                <input type="hidden" name="address_y" id="address_y" value="{{ old('address_y') }}">
                                <div class="deleteImage btn btn-danger" onclick="removeMarker(event)">Удалить с карты</div>
                                

                                <!-- <input type="hidden" name="address_x" value="1">
                                <input type="hidden" name="address_y" value="1"> -->
                                
                                <div class="form-group">
                                    <label for="profileAbout">О себе:</label>
                                    <textarea name="about" class="form-control @error('about') is-invalid @enderror" id="profileAbout" rows="3">{!! $profile->about !!}
                                                </textarea>
                                </div>

                                <div class="form-group">
                                    <label for="profileWorkingHoursFrom">Время работы c (часов):</label>
                                    <input name="working_hours_from" type="number" min="0" max="24" id="profileWorkingHoursFrom" class="form-control @error('working_hours_from') is-invalid @enderror" value="{{ $profile->working_hours_from }}">
                                </div>

                                <div class="form-group">
                                    <label for="profileWorkingHoursTo">Время работы до (часов):</label>
                                    <input name="working_hours_to" type="number" min="0" max="24" id="profileWorkingHoursTo" class="form-control @error('working_hours_to') is-invalid @enderror" value="{{ $profile->working_hours_to }}">
                                </div>

                                <div class="form-check">
                                    <input type="hidden" name="working_24_hours" value="0">
                                    <input class="form-check-input" type="checkbox" id="profileWork24Hours" name="working_24_hours" value="1" {{$profile->profileWork24Hours ? 'checked' : ''}}>
                                    <label class="form-check-label" for="profileWork24Hours">
                                        Работаю всегда (без перерыва и выходных)
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label for="profileBoobs">Размер груди (1-10):</label>
                                    <input name="boobs" type="number" id="profileBoobs" class="form-control @error('boobs') is-invalid @enderror" placeholder="" value="{{$profile->boobs }}">
                                </div>

                                <div class="form-group">
                                    <label for="profileAge">Возраст (18-65):</label>
                                    <input name="age" type="number" id="profileAge" class="form-control @error('age') is-invalid @enderror" placeholder="" value="{{ $profile->age }}">
                                </div>

                                <div class="form-group">
                                    <label for="profileWeight">Вес (40-100):</label>
                                    <input name="weight" type="number" id="profileWeight" class="form-control @error('weight') is-invalid @enderror" placeholder="" value="{{ $profile->weight }}">
                                </div>

                                <div class="form-group">
                                    <label for="profileHeight">Рост (150-195):</label>
                                    <input name="height" type="number" id="profileHeight" class="form-control @error('height') is-invalid @enderror" placeholder="" value="{{ $profile->height }}">
                                </div>

                                <div class="form-group">
                                    <label for="profileEuroHour">Цена за 1 Еврочас (1000-50000):</label>
                                    <input name="euro_hour" type="number" id="profileEuroHour" class="form-control @error('euro_hour') is-invalid @enderror" placeholder="" value="{{ $profile->euro_hour }}">
                                </div>

                                <div class="form-group">
                                    <label for="profileOneHour">Цена за 1 час (1000-50000):</label>
                                    <input name="one_hour" type="number" id="profileOneHour" class="form-control @error('one_hour') is-invalid @enderror" placeholder="" value="{{ $profile->one_hour }}">
                                </div>

                                <div class="form-group">
                                    <label for="profileTwoHour">Цена за 2 часа (1000-100000):</label>
                                    <input name="two_hour" type="number" id="profileTwoHour" class="form-control @error('two_hour') is-invalid @enderror" placeholder="" value="{{ $profile->two_hour }}">
                                </div>

                                <div class="form-group">
                                    <label for="profileAllNight">Цена за всю ночь (1000-1000000):</label>
                                    <input name="all_night" type="number" id="profileAllNight" class="form-control @error('all_night') is-invalid @enderror" placeholder="" value="{{ $profile->all_night }}">
                                </div>

                                <div class="form-check">
                                    <input type="hidden" name="check_out" value="0">
                                    <input class="form-check-input" type="checkbox" id="profileCheckOut" name="check_out" value="1" {{$profile->check_out ? 'checked' : ''}}>
                                    <label class="form-check-label" for="profileCheckOut">
                                        Есть выезд
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input type="hidden" name="apartments" value="0">
                                    <input class="form-check-input" type="checkbox" id="profileApartaments" name="apartments" value="1" {{$profile->apartments ? 'checked' : ''}}>
                                    <label class="form-check-label" for="profileApartaments">
                                        Есть апартаменты
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label for="profileAppearance">Внешность</label>
                                    <select class="form-control" name="appearance" id="profileAppearance">
                                        @foreach($appearances as $appearance)
                                        <option {{$profile->appearances->first()->id == $appearance->id ? 'selected' : ''}} value="{{$appearance->id}}">
                                            {{ $appearance->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="profileAppearance">Цвет волос</label>
                                    <select class="form-control" name="hair" id="profileHair">
                                        @foreach($hairs as $hair)
                                        <option {{$profile->hairs->first()->id == $hair->id ? 'selected' : ''}} value="{{$hair->id}}">
                                            {{ $hair->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div id="panel2" class="tab-pane fade">
                                @foreach($services as $service)

                                <h6>{{$service->name}}</h6>

                                @foreach($service->childrenRecursive as $service)
                                <div class="form-check ml-2">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input class="form-check-input" type="checkbox" id="profileService{{$service->id}}" name="services[]" value="{{$service->id}}" {{$profile->services->find($service->id) <> null ? 'checked' : ''}}>
                                            <label class="form-check-label" for="profileApartaments">
                                                {{$service->name}}
                                            </label>
                                        </div>
                                        <div class="col-md-8">
                                            @if(Auth::user()->id === $profile->user_id && $profile->services->find($service->id) <> null)

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <span>доп. цена: {{ $service->pivot <> null ? $service->pivot->price : 'не указана' }}</span>
                                                    </div>
                                                    <div class="col-md-8 d-flex justify-content-between servicePriceUpdate">
                                                        <input style="    width: 65%;" class="form-control" data-price="{{ $service->pivot <> null ? $service->pivot->price : '' }}" data-service-id="{{$service->id}}" data-profile-id="{{$profile->id}}" name="priceupdate" type="text" value="@if($profile->services->where('id', $service->id)->first()->pivot <> null) {{$profile->services->where('id', $service->id)->first()->pivot->price}}@endif">

                                                        <div class="btn btn-success btn-fab btn-fab-mini btn-round" data-toggle="tooltip" data-placement="top" title="Обновить цену услуги" onclick="updateServicePrice(event)">
                                                            Обновить цену
                                                            <p class="price_update_info"></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                @else
                                                <span>{{ $service->pivot<> null ? $service->pivot->price . 'р.' : ''}} </span>
                                                @endif
                                        </div>
                                    </div>



                                </div>
                                @endforeach
                                @endforeach
                            </div>
                            <div id="panel3" class="tab-pane fade">

                                <h3>Основное изображение</h3>

                                <h5>Текущее основное изображение</h5>
                                <div class="col-lg-3 col-md-4 col-6">
                                    <a href="#" class="d-block mb-4 h-100">
                                        <img class="img-fluid delpath" delpath="{{ asset('/images/profiles/main/created/' . $profile->main_image )}}" src="{{ asset('/images/profiles/main/created/' . $profile->main_image) }}" alt="">
                                    </a>
                                </div>

                                <div class="form-group">
                                    <label for="main_image">Новое основное изображение</label>
                                    <br>
                                    <input type="hidden" name="main_image" value="{{ $profile->main_image }}">
                                    <input type="file" autocomplete="OFF" name="main_image" id="main_image" placeholder="" class="form-control input-sm" />
                                </div>

                                <h5 class="font-weight-light text-center text-lg-left mt-4 mb-0">Галлерея загруженных
                                    изображений</h5>

                                <hr class="mt-2 mb-5">

                                <div class="row text-center text-lg-left mb-4">
                                    @foreach($profile->images as $image)
                                    <div class="col-lg-3 col-md-4 col-6 imageContainer mb-3">


                                        <img class="img-fluid img-thumbnail delpath" delpath="{{'/images/profiles/images/created/' . $image->name }}" src="{{ '/images/profiles/images/created/' . $image->name }}" alt="">

                                        <div class="deleteImage btn btn-danger" onclick="deleteImagesAttached(event)" imageId="{{$image->id}}">Удалить</div>
                                    </div>
                                    @endforeach
                                </div>

                                <div class="form-group">
                                    <label for="">Фотографии <span class="required">*</span></label>
                                    <br>
                                    <input type="hidden" autocomplete="OFF" name="item_images" id="item_images" placeholder="" class="form-control input-sm" required />
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"> <i class="fa fa-image"></i>Загрузить дополнительные фото</button>
                                </div>
                            </div>
                            <div id="panel4" class="tab-pane fade">
                                <h2>Тарифный план:
                                    @if($profile->rates->count() == 0)
                                    Не назначен
                                    @else
                                    {{$profile->rates->first()->name}}
                                    @endif
                                </h2>
                                <div class="form-group">
                                    <p>Внимание !!! Переключение тарифного плана произойдет не сразу, а при следующей
                                        попытки
                                        активации анкеты</p>
                                    <p>Переключение тарифного плана произойдет только в случае достаточного количества
                                        Пойнтов
                                        на балансе анкеты</p>
                                    <input type="hidden" name="rate" value="
                                                @if($profile->rates->count() > 0)
                                                    {{$profile->rates->first()}}
                                                @endif">
                                    <select class="form-control" name="rate" id="profileRate">
                                        <option></option>
                                        @foreach($rates as $rate)
                                        <option value="{{$rate->id}} {{$profile->rates->find($rate->id) <> null ? 'selected' : ''}}">
                                            {{ $rate->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div id="panel5" class="tab-pane fade">
                                <div class="form-group">
                                    <label for="verificate_image">Изображение для подтверждения</label>
                                    <br>
                                    <input type="hidden" name="verificate_image" value="{{ $profile->verificate_image }}">
                                    <input type="file" autocomplete="OFF" name="verificate_image" id="verificate_image" placeholder="" class="form-control input-sm" />
                                </div>

                                <h5 class="font-weight-light text-center text-lg-left mt-4 mb-0">Текущее изображение для
                                    подтверждения/ назначить новое</h5>

                                <hr class="mt-2 mb-5">
                                <div class="col-lg-3 col-md-4 col-6">
                                    <a href="#" class="d-block mb-4 h-100">
                                        <img class="img-fluid delpath" delpath="{{ asset('/images/profiles/verificate/' . $profile->verificate_image )}}" src="{{ asset('/images/profiles/verificate/' . $profile->verificate_image) }}" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Обновить анкету</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL START -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Upload Images</h4>
            </div>
            <div class="modal-body">
                <form action="" class="dropzone" method="post" enctype="multipart/form-data">
                    {!! csrf_field() !!}
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
    // fileList variable to store current files index and name
    var fileList = new Array;
    var i = 0;
    $(function() {
        uploader = new Dropzone(".dropzone", {
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
@endsection