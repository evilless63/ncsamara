@extends('layouts.app')

@section('assetcarousel')

<link rel="stylesheet" href="{{asset('js/owl/assets/owl.carousel.min.css')}}">
<link rel="stylesheet" href="{{asset('js/owl/assets/owl.theme.default.min.css')}}">
<link rel="stylesheet" href="{{asset('/css/carousel-custom.css')}}">
@endsection

@section('google_api_autocomplete')
<script type="text/javascript"
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD2zWS_b-EUkyWjg4cqA_TN-l-lch8-LXo&libraries=places"></script>

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
        
                let latLng = new google.maps.LatLng('1', '1');
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

        <h2>Создание анкеты</h2>

        <form action="{{ route('user.profiles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <h5>Поля, отмеченные "*" обязательны к заполнению</h5>
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

            <div class="row">
                <div class="col-md-7">

                    <h4 class="align-self-center mt-4 mb-4">Заполните все пункты анкеты</h4>

                    <div class="form-group d-flex justify-content-between">
                        <label for="profileName">Имя *:</label>
                        <input name="name" type="text" id="profileName"
                            class="form-control col-8 @error('name') is-invalid @enderror"
                            placeholder="Укажите имя в анкете" value="{{ old('name') }}">
                    </div>

                    <div class="form-group d-flex justify-content-between">
                        <label for="profileAge">Возраст (лет,18-75)*:</label>
                        <input name="age" type="number" id="profileAge"
                            class="form-control col-8 @error('age') is-invalid @enderror" placeholder=""
                            value="{{ old('age') }}" placeholder="Лет (18-75)">
                    </div>

                    <div class="form-group d-flex justify-content-between">
                        <label for="profileHeight">Рост (см,130-210)*:</label>
                        <input name="height" type="number" id="profileHeight"
                            class="form-control col-8 @error('height') is-invalid @enderror" placeholder=""
                            value="{{ old('height') }}" placeholder="см. (130 -210)">
                    </div>

                    <div class="form-group d-flex justify-content-between">
                        <label for="profileWeight">Вес (кг,40-200)*:</label>
                        <input name="weight" type="number" id="profileWeight"
                            class="form-control col-8 @error('weight') is-invalid @enderror" placeholder=""
                            value="{{ old('weight') }}" placeholder="кг. (40-200)">
                    </div>

                    <div class="form-group d-flex justify-content-between">
                        <label for="profileBoobs">Размер груди (1-7)*:</label>
                        <input name="boobs" type="number" id="profileBoobs"
                            class="form-control col-8 @error('boobs') is-invalid @enderror" placeholder=""
                            value="{{ old('boobs') }}" placeholder="(1-7)">
                    </div>

                    <div class="form-group d-flex justify-content-between">
                        <label for="profileAppearance">Цвет волос *</label>
                        <select class="form-control col-8" name="hair" id="profileHair">
                            @foreach($hairs as $hair)
                            <option value="{{$hair->id}}">{{ $hair->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group d-flex justify-content-between">
                        <label for="profileAppearance">Внешность *</label>
                        <select class="form-control col-8" name="appearance" id="profileAppearance">
                            @foreach($appearances as $appearance)
                            <option value="{{$appearance->id}}">{{ $appearance->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- TODO - национальность (или внешность) уточнить, что и как должно быть --}}

                    <div class="form-group d-flex justify-content-between">
                        <label for="profilePhone">Телефон *:</label>
                        <input name="phone" type="text" id="profilePhone"
                            class="profilePhone form-control col-8 @error('phone') is-invalid @enderror"
                            placeholder="c 8, 11 цифр номера" value="{{ old('phone') }}">
                        {{-- TODO - макет для телефона js --}}
                    </div>

                    <div class="form-group d-flex justify-content-between">
                        <label for="profileDistrict">Район города *:</label>
                        <select class="form-control col-8" name="district" id="profileDistrict">
                            @foreach($districts as $district)
                            <option value="{{$district->id}}">{{ $district->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group form-inline d-flex justify-content-between">
                        <label for="profileWorkingHoursFrom">Время работы c *: </label>

                        <input name="working_hours_from" type="number" min="0" max="24" id="profileWorkingHoursFrom"
                            class="form-control @error('working_hours_from') is-invalid @enderror"
                            value="{{ old('working_hours_from') }}">

                        <label for="profileWorkingHoursTo">до *: </label>

                        <input name="working_hours_to" type="number" min="0" max="24" id="profileWorkingHoursTo"
                            class="form-control @error('working_hours_to') is-invalid @enderror"
                            value="{{ old('working_hours_to') }}">

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="profileWork24Hours"
                                name="working_24_hours" value="1">
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
                                    value="{{ old('euro_hour') }}">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group form-inline d-flex justify-content-between">
                                <label for="profileOneHour">За час (руб, от 1000 до 50000)*:</label>
                                <input name="one_hour" type="number" id="profileOneHour"
                                    class="form-control @error('one_hour') is-invalid @enderror"
                                    placeholder="от 1000 до 50000" value="{{ old('one_hour') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <div class="form-group form-inline d-flex justify-content-between">
                                <label for="profileTwoHour">За два (руб, от 1000 до 100000)*:</label>
                                <input name="two_hour" type="number" id="profileTwoHour"
                                    class="form-control @error('two_hour') is-invalid @enderror"
                                    placeholder="от 1000 до 100000" value="{{ old('two_hour') }}">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group form-inline d-flex justify-content-between">
                                <label for="profileAllNight">За ночь (руб, от 1000 до 1000000)*:</label>
                                <input name="all_night" type="number" id="profileAllNight"
                                    class="form-control @error('all_night') is-invalid @enderror"
                                    placeholder="от 1000 до 1000000" value="{{ old('all_night') }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group d-flex justify-content-between">
                        <label for="profileOneHour">О себе *:</label>
                        <textarea name="about" class="form-control col-9 @error('about') is-invalid @enderror"
                            id="profileAbout" placeholder="О себе" rows="3">{!! old('about') !!}</textarea>
                    </div>

                    <p>Территория:</p>

                    <div class="row justify-content-center">
                        <div class="col-md-3">
                            <div class="form-check align-self-center">

                                <input class="form-check-input mt-3" type="checkbox" id="profileApartaments"
                                    name="apartments" value="1">
                                <label class="form-check-label  mt-2" for="profileApartaments">
                                    Апартаменты
                                </label>
                            </div>
                            <div class="form-check align-self-center">

                                <input onclick="showHideEtc(event)" class="form-check-input mt-3" type="checkbox"
                                    id="profileCheckOut" name="check_out" value="1">
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

                            <div class="form-check align-self-center ml-3" id="check_out_rooms">
                                <input class="form-check-input mt-3" type="checkbox" name="check_out_rooms" value="1">
                                <label class="form-check-label  mt-2" for="check_out_rooms">
                                    Квартиры
                                </label>
                            </div>
                            <div class="form-check align-self-center ml-3" id="check_out_hotels">
                                <input class="form-check-input mt-3" type="checkbox" name="check_out_hotels" value="1">
                                <label class="form-check-label  mt-2" for="check_out_hotels">
                                    Гостиницы
                                </label>
                            </div>
                            <div class="form-check align-self-center ml-3" id="check_out_saunas">
                                <input class="form-check-input mt-3" type="checkbox" name="check_out_saunas" value="1">
                                <label class="form-check-label  mt-2" for="check_out_saunas">
                                    Сауны
                                </label>
                            </div>
                            <div class="form-check align-self-center ml-3" id="check_out_offices">
                                <input class="form-check-input mt-3" type="checkbox" name="check_out_offices" value="1">
                                <label class="form-check-label  mt-2" for="check_out_offices">
                                    Офисы
                                </label>
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
                                <h5>Загрузка фото (для главной страницы сайта) *</h5>
                                - минимальное разрешение 400 px <br>
                                - Допускаются к размещению только фотографии хорошего качества <br>
                                - На фотографиях не должны быть водяные знаки, логотипы других сайтов <br>
                                - На фотографиях не должны быть видны гениталии
                            </div>
                        </div>


                        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel">Выберите учаток изображения для загрузки
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Колесом мыши менять масштаб<br> для выбора участка загружаемого изображения,
                                            перетаскивайте активную зону</p>
                                        <div class="img-container">
                                            <img id="image" src="">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Отмена</button>
                                        <button type="button" class="btn btn-primary" id="crop">Загрузить</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <input type="hidden" autocomplete="OFF" name="main_image" id="main_image" placeholder=""
                            class="form-control input-sm" />
                    </div>

                    <hr>

                    <h4 class="mt-4 mb-4">Загрузка фото (для страницы анкеты, минимум - 3 , максимум - 10) *</h4>

                    <div class="form-group">
                        <input type="hidden" autocomplete="OFF" name="item_images" id="item_images" placeholder=""
                            class="form-control input-sm" required />
                        <div class="dropzone" id="dropzone">
                            <div class="dz-message" data-dz-message><span>Переместите сюда файлы для загрузки (или
                                    нажмите сюда и выберите их)</span></div>
                        </div>
                    </div>

                    <hr>

                    <h4 class="mt-4 mb-4">Загрузка проверочных фото</h4>

                    <p>
                        - Для проверки фотографии и получения отметки "Проверено" загрузите проверочное
                        фото с листом бумаги с актуальной датой. Подтвержденные фнкеты посещают чаще и больше звонков.
                        <br>
                        - По проверочное фото должно быть хорошего качества, с читаемой датой на листе бумаги, должно
                        быть понятно, что на фотографиях
                        анкеты вы, добавляете несколько фотографий с лицом и фигурой.
                    </p>

                    <div class="form-group">
                        <input type="hidden" autocomplete="OFF" name="item_images_verification"
                            id="item_images_verification" placeholder="" class="form-control input-sm" />
                        <div class="dropzone" id="dropzone-ver">
                            <div class="dz-message" data-dz-message><span>Переместите сюда файлы для загрузки (или
                                    нажмите сюда и выберите их)</span></div>
                        </div>
                    </div>

                </div>
            </div>

            <button type="submit" class="btn btn-success align-self-center">Создать анкету и перейти к выбору
                услуг</button>
        </form>
    </div>
</div>
@endsection


@section('script')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js"></script>



<script>
    function removeMarker(event) {
        document.getElementById("address_x").value = '1';
        document.getElementById("address_y").value = '1';  

        markersArray.forEach(function callback(marker, index, array) {
            marker.setMap(null)
        });
    }

function showHideEtc(event){
    if($(event.target).prop("checked")){
        $('#check_out_rooms').show();
        $('#check_out_hotels').show();
        $('#check_out_saunas').show();
        $('#check_out_offices').show();
    } else {
        $('#check_out_rooms').find('input').val("")
        $('#check_out_hotels').find('input').val("")
        $('#check_out_offices').find('input').val("")
        $('#check_out_saunas').find('input').val("")
        $('#check_out_rooms').hide();
        $('#check_out_hotels').hide();
        $('#check_out_saunas').hide();
        $('#check_out_offices').hide();
    }
}

$(document).ready(function(){
    if($('#profileCheckOut').prop("checked")){
        $('#check_out_rooms').show();
        $('#check_out_hotels').show();
        $('#check_out_saunas').show();
        $('#check_out_offices').show();
    } else {
        $('#check_out_rooms').find('input').val("")
        $('#check_out_hotels').find('input').val("")
        $('#check_out_offices').find('input').val("")
        $('#check_out_saunas').find('input').val("")
        $('#check_out_rooms').hide();
        $('#check_out_hotels').hide();
        $('#check_out_saunas').hide();
        $('#check_out_offices').hide();
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
var iver = 0;
$(function(){
    uploader = new Dropzone("#dropzone",{
        url: "{{url('user/profiles/upload')}}",
        paramName : "file",
        uploadMultiple :false,
        acceptedFiles : "image/*",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        addRemoveLinks: true,
        forceFallback: false,
        maxFilesize: 4, // Set the maximum file size to 256 MB
        parallelUploads: 100,
    });//end drop zone
    uploader.on("success", function(file,response) {
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

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{url('user/profiles/delete')}}",
                    type: "post",
                    data: {file: rmvFile},
                    success: function(response){
                    }
                });

            }
        }

    });
});


// TODO Разобраться с фотками на проверку !
$(function(){
    uploaderVer = new Dropzone("#dropzone-ver",{
        url: "{{url('user/profiles/upload')}}",
        paramName : "file",
        uploadMultiple :false,
        acceptedFiles : "image/*",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        addRemoveLinks: true,
        forceFallback: false,
        maxFilesize: 4, // Set the maximum file size to 256 MB
        parallelUploads: 100,
    });//end drop zone
    uploaderVer.on("success", function(file,response) {
        imageDataArrayVer.push(response)
        fileListVer[iver] = {
            "serverFileName": response,
            "fileName": file.name,
            "fileId": iver
        };

        iver += 1;
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

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{url('user/profiles/delete')}}",
                    type: "post",
                    data: {file: rmvFile},
                    success: function(response){
                    }
                });

            }
        }

    });
});
</script>

@endsection