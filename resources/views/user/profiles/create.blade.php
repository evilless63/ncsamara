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
    // Initialize and add the map
    //function initMap() {
        // The location of Uluru
        var first = {lat: 53.224834, lng: 50.190315};
        var second = {lat: 53.225946, lng: 50.201663};
        var third = {lat: 53.222105, lng: 50.201953};
        // The map, centered at Uluru
        var map = new google.maps.Map(
            document.getElementById('map'), {zoom: 15, center: first});
        // The marker, positioned at Uluru
        var image = 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png';

        google.maps.event.addListener(marker, 'click', function() {
            window.location.href = this.url;
        });
    //}
</script>


@endsection

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            
                <h2>Создание анкеты</h2>

                
                    <form action="{{ route('user.profiles.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @if(count($errors))
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <ul class="nav nav-pils nav-pills-userpanel">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#panel1">Основные
                                    данные</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#panel2">Услуги</a></li>
                            </li>
                        </ul>

                        <div class="tab-content mt-5">
                            <div id="panel1" class="tab-pane fadein active">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group form-inline d-flex justify-content-between">
                                            <label for="profileName">Имя:</label>
                                            <input name="name" type="text" id="profileName"
                                                class="form-control @error('name') is-invalid @enderror"
                                                placeholder="Укажите имя в анкете" value="{{ old('name') }}">
                                        </div>
                                        <div class="form-group form-inline d-flex justify-content-between">
                                            <label for="profilePhone">Телефон:</label>
                                            <input name="phone" type="text" id="profilePhone"
                                                class="form-control @error('phone') is-invalid @enderror"
                                                placeholder="c 8, 11 цифр номера" value="{{ old('phone') }}">
                                        </div>
        
                                        <div class="form-group form-inline d-flex justify-content-between">
                                            <label for="profileDistrict">Район города:</label>
                                            <select class="form-control" name="district" id="profileDistrict">
                                                @foreach($districts as $district)
                                                    <option value="{{$district->id}}">{{ $district->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group form-inline d-flex justify-content-between">
                                            <label for="profileWorkingHoursFrom">Время работы c: </label>
                                            <input name="working_hours_from" type="number" min="0" max="24" id="profileWorkingHoursFrom"
                                                class="form-control @error('working_hours_from') is-invalid @enderror"
                                                value="{{ old('working_hours_from') }}">
                                                <label for="profileWorkingHoursTo">до: </label>
                                                <input name="working_hours_to" type="number" min="0" max="24" id="profileWorkingHoursTo"
                                                       class="form-control @error('working_hours_to') is-invalid @enderror"
                                                       value="{{ old('working_hours_to') }}">
                                                <label for="">(в часах)</label>       
                                        </div>
        
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="profileWork24Hours"
                                                   name="working_24_hours" value="1">
                                            <label class="form-check-label" for="profileWork24Hours">
                                                Работаю 24 часа
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <textarea name="about"class="form-control @error('about') is-invalid @enderror"id="profileAbout" placeholder="О себе" rows="6">{!! old('about') !!}</textarea>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                
                                <div class="row mt-5">
                                    <div class="col-md-12 d-flex justify-content-between">
                                        <div class="form-group">
                                            <label for="profileBoobs">Размер груди (1-10):</label>
                                            <input name="boobs" type="number" id="profileBoobs"
                                                class="form-control @error('boobs') is-invalid @enderror" placeholder=""
                                                value="{{ old('boobs') }}">
                                        </div>
        
                                        <div class="form-group">
                                            <label for="profileAge">Возраст (18-65):</label>
                                            <input name="age" type="number" id="profileAge"
                                                class="form-control @error('age') is-invalid @enderror" placeholder=""
                                                value="{{ old('age') }}">
                                        </div>
        
                                        <div class="form-group">
                                            <label for="profileWeight">Вес (40-100):</label>
                                            <input name="weight" type="number" id="profileWeight"
                                                class="form-control @error('weight') is-invalid @enderror" placeholder=""
                                                value="{{ old('weight') }}">
                                        </div>
        
                                        <div class="form-group">
                                            <label for="profileHeight">Рост (150-195):</label>
                                            <input name="height" type="number" id="profileHeight"
                                                class="form-control @error('height') is-invalid @enderror" placeholder=""
                                                value="{{ old('height') }}">
                                        </div>

                                        <div class="form-check align-self-center">
                                           
                                            <input class="form-check-input mt-3" type="checkbox" id="profileCheckOut"
                                                name="check_out" value="1">
                                            <label class="form-check-label  mt-2" for="profileCheckOut">
                                                Я выезжаю к клиенту
                                            </label>
                                        </div>
        
                                        <div class="form-check align-self-center">
                                           
                                            <input class="form-check-input mt-3" type="checkbox" id="profileApartaments"
                                                name="apartments" value="1">
                                            <label class="form-check-label  mt-2" for="profileApartaments">
                                                У меня есть апартаменты
                                            </label>
                                        </div>
                                    </div>
                                </div>
                               
                                
                               
                                <div class="row">
                                    <div class="col-md-3 d-flex justify-content-between">
                                        <div class="form-group">
                                            <label for="profileAppearance">Внешность</label>
                                            <select class="form-control" name="appearance" id="profileAppearance">
                                                @foreach($appearances as $appearance)
                                                <option value="{{$appearance->id}}">{{ $appearance->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
        
                                        <div class="form-group">
                                            <label for="profileAppearance">Цвет волос</label>
                                            <select class="form-control" name="hair" id="profileHair">
                                                @foreach($hairs as $hair)
                                                <option value="{{$hair->id}}">{{ $hair->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="row mt-5">
                                    <div class="col-md-9 d-flex justify-content-between">
                                        <div class="form-group">
                                            <label for="profileEuroHour">Цена за 1 Еврочас (1000-50000):</label>
                                            <input name="euro_hour" type="number" id="profileEuroHour"
                                                   class="form-control @error('euro_hour') is-invalid @enderror" placeholder=""
                                                   value="{{ old('euro_hour') }}">
                                        </div>
        
                                        <div class="form-group">
                                            <label for="profileOneHour">Цена за 1 час (1000-50000):</label>
                                            <input name="one_hour" type="number" id="profileOneHour"
                                                class="form-control @error('one_hour') is-invalid @enderror" placeholder=""
                                                value="{{ old('one_hour') }}">
                                        </div>
        
                                        <div class="form-group">
                                            <label for="profileTwoHour">Цена за 2 часа (1000-100000):</label>
                                            <input name="two_hour" type="number" id="profileTwoHour"
                                                class="form-control @error('two_hour') is-invalid @enderror" placeholder=""
                                                value="{{ old('two_hour') }}">
                                        </div>
        
                                        <div class="form-group">
                                            <label for="profileAllNight">Цена за всю ночь (1000-1000000):</label>
                                            <input name="all_night" type="number" id="profileAllNight"
                                                class="form-control @error('all_night') is-invalid @enderror" placeholder=""
                                                value="{{ old('all_night') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <p>Основное изображение</p>
                                    <label class="label" data-toggle="tooltip" title="" data-original-title="Кликните для загрузки основного изображения анкеты">
                                    <img class="rounded" id="avatar" src="{{asset('/admin/icons/add_img.png')}}" alt="avatar">
                                    <input type="file" class="sr-only" id="input" name="image" accept="image/*">
                                    </label>
                                    {{-- <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                    </div>
                                    <div class="alert" role="alert"></div> --}}
                                    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalLabel">Выберите учаток изображения для загрузки</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Колесом мыши менять масштаб<br> для выбора участка загружаемого изображения, перетаскивайте активную зону</p>
                                            <div class="img-container">
                                            <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                                            <button type="button" class="btn btn-primary" id="crop">Загрузить</button>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                    <br>
                                    <input type="hidden" autocomplete="OFF" name="main_image" id="main_image"
                                           placeholder="" class="form-control input-sm" />
                                </div>

                                <div class="form-group">
                                    <input type="hidden" autocomplete="OFF" name="item_images" id="item_images"
                                        placeholder="" class="form-control input-sm" required />
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                        data-target="#myModal"> <i class="fa fa-image"></i> Загрузить дополнительные фотографии</button>
                                </div>


                                <button type="submit" class="btn btn-success">Создать анкету</button>
                                
                                
                            </div>

                            <div id="panel2" class="tab-pane fade">
                                @foreach($services as $service)

                                <h6>{{$service->name}}</h6>

                                @foreach($service->childrenRecursive as $service)
                                <div class="form-check ml-2">
                                    <input class="form-check-input" type="checkbox" id="profileService{{$service->id}}"
                                        name="services[]" value="{{$service->id}}">
                                    <label class="form-check-label" for="profileService{{$service->id}}">
                                        {{$service->name}}
                                    </label>
                                </div>
                                @endforeach
                                @endforeach

                                <button type="submit" class="btn btn-success">Создать анкету</button> 
                            </div>
                        </div>


                    </form>

    </div>
</div>

<!-- MODAL START -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Загрузка изображений</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
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
$(function(){
    uploader = new Dropzone(".dropzone",{
        url: "{{url('user/profiles/upload')}}",
        paramName : "file",
        uploadMultiple :false,
        acceptedFiles : "image/*",
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
</script>

@endsection
