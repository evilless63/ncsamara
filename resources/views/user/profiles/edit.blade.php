@extends('layouts.app')

@section('google_api_autocomplete')
<script type="text/javascript"
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD2zWS_b-EUkyWjg4cqA_TN-l-lch8-LXo&libraries=places"></script>

<script>
    function initialize() {
            var input = document.getElementById('profileAddress');
            new google.maps.places.Autocomplete(input);
        }

        google.maps.event.addDomListener(window, 'load', initialize);
</script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex">
                    <span>Редактирование анкеты @if($profile->verified) (Подтверждена) @endif</span>
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
                    <form action="{{ route('user.profiles.update', $profile->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="form-group">
                            <label for="profileName">Имя:</label>
                            <input name="name" type="text" id="profileName"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Укажите имя в анкете" value="{{ $profile->name }}">
                        </div>
                        <div class="form-group">
                            <label for="profilePhone">Телефон (Только ЦИФРЫ - 11 цифр номера телефона, номер должен
                                начинаться с 8) :</label>
                            <input name="phone" type="text" id="profilePhone"
                                class="form-control @error('phone') is-invalid @enderror"
                                placeholder="Укажите телефон в анкете" value="{{ $profile->phone }}">
                        </div>
                        <div class="form-group">
                            <label for="profileAddress">Адрес:</label>
                            <input name="address" type="text" id="profileAddress"
                                class="form-control @error('address') is-invalid @enderror"
                                placeholder="Укажите адрес анкеты" value="{{ $profile->address }}">
                            {{--                                <input type="hidden" name="address_x" value="{{ old('address_x') }}
                            ">--}}
                            {{--                                <input type="hidden" name="address_y" value="{{ old('address_y') }}">--}}
                            <input type="hidden" name="address_x" value="1">
                            <input type="hidden" name="address_y" value="1">
                            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                        </div>
                        <div class="form-group">
                            <label for="profileAbout">О себе (минимум 50 символов):</label>
                            <textarea name="about" class="form-control @error('about') is-invalid @enderror"
                                id="profileAbout" rows="3">
                                    {!! $profile->name !!}
                                </textarea>
                        </div>

                        <div class="form-group">
                            <label for="profileWorkingHours">Время работы:</label>
                            <input name="working_hours" type="text" id="profileWorkingHours"
                                class="form-control @error('working_hours') is-invalid @enderror"
                                placeholder="Укажите время работы" value="{{$profile->name}}">
                        </div>

                        <div class="form-group">
                            <label for="profileBoobs">Размер груди (1-10):</label>
                            <input name="boobs" type="number" id="profileBoobs"
                                class="form-control @error('boobs') is-invalid @enderror" placeholder=""
                                value="{{$profile->boobs }}">
                        </div>

                        <div class="form-group">
                            <label for="profileAge">Возраст (18-65):</label>
                            <input name="age" type="number" id="profileAge"
                                class="form-control @error('age') is-invalid @enderror" placeholder=""
                                value="{{ $profile->age }}">
                        </div>

                        <div class="form-group">
                            <label for="profileWeight">Вес (40-100):</label>
                            <input name="weight" type="number" id="profileWeight"
                                class="form-control @error('weight') is-invalid @enderror" placeholder=""
                                value="{{ $profile->weight }}">
                        </div>

                        <div class="form-group">
                            <label for="profileHeight">Рост (150-195):</label>
                            <input name="height" type="number" id="profileHeight"
                                class="form-control @error('height') is-invalid @enderror" placeholder=""
                                value="{{ $profile->height }}">
                        </div>

                        <div class="form-group">
                            <label for="profileOneHour">Цена за 1 час (1000-50000):</label>
                            <input name="one_hour" type="number" id="profileOneHour"
                                class="form-control @error('one_hour') is-invalid @enderror" placeholder=""
                                value="{{ $profile->one_hour }}">
                        </div>

                        <div class="form-group">
                            <label for="profileTwoHour">Цена за 2 часа (1000-100000):</label>
                            <input name="two_hour" type="number" id="profileTwoHour"
                                class="form-control @error('two_hour') is-invalid @enderror" placeholder=""
                                value="{{ $profile->two_hour }}">
                        </div>

                        <div class="form-group">
                            <label for="profileAllNight">Цена за всю ночь (1000-1000000):</label>
                            <input name="all_night" type="number" id="profileAllNight"
                                class="form-control @error('all_night') is-invalid @enderror" placeholder=""
                                value="{{ $profile->all_night }}">
                        </div>

                        <div class="form-check">
                            <input type="hidden" name="check_out" value="0">
                            <input class="form-check-input" type="checkbox" id="profileCheckOut" name="check_out"
                                value="1" {{$profile->check_out ? 'checked' : ''}}>
                            <label class="form-check-label" for="profileCheckOut">
                                Есть выезд
                            </label>
                        </div>

                        <div class="form-check">
                            <input type="hidden" name="apartments" value="0">
                            <input class="form-check-input" type="checkbox" id="profileApartaments" name="apartments"
                                value="1" {{$profile->apartments ? 'checked' : ''}}>
                            <label class="form-check-label" for="profileApartaments">
                                Есть апартаменты
                            </label>
                        </div>

                        @foreach($services as $service)

                        <h6>{{$service->name}}</h6>

                        @foreach($service->childrenRecursive as $service)
                        <div class="form-check ml-2">
                            <input class="form-check-input" type="checkbox" id="profileService" name="services[]"
                                value="{{$service->id}}"
                                {{$profile->services->find($service->id) <> null ? 'checked' : ''}}>
                            <label class="form-check-label" for="profileApartaments">
                                {{$service->name}}
                            </label>
                        </div>
                        @endforeach
                        @endforeach

                        <div class="form-group">
                            <label for="profileAppearance">Внешность</label>
                            <select class="form-control" name="appearance" id="profileAppearance">
                                @foreach($appearances as $appearance)
                                <option
                                    value="{{$appearance->id}} {{$profile->appearances->find($appearance->id) <> null ? 'selected' : ''}}">
                                    {{ $appearance->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="profileAppearance">Цвет волос</label>
                            <select class="form-control" name="hair" id="profileHair">
                                @foreach($hairs as $hair)
                                <option
                                    value="{{$hair->id}} {{$profile->hairs->find($hair->id) <> null ? 'selected' : ''}}">
                                    {{ $hair->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <h5 class="font-weight-light text-center text-lg-left mt-4 mb-0">Thumbnail Gallery</h5>

                        <hr class="mt-2 mb-5">

                        <div class="row text-center text-lg-left">
                            @foreach($profile->images as $image)
                            <div class="col-lg-3 col-md-4 col-6">
                                <a href="#" class="d-block mb-4 h-100">
                                    <img class="img-fluid img-thumbnail delpath"
                                        delpath="{{'/images/profiles/images/created/' . $image->name }}"
                                        src="{{ '/images/profiles/images/created/' . $image->name }}" alt="">
                                </a>
                            </div>
                            @endforeach
                        </div>

                        <div class="form-group">
                            <label for="">Images <span class="required">*</span></label>
                            <br>
                            <input type="hidden" autocomplete="OFF" name="item_images" id="item_images" placeholder=""
                                class="form-control input-sm" required />
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                data-target="#myModal"> <i class="fa fa-image"></i> Upload Images</button>
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
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                data: {file: rmvFile},
                success: function(response){
                }
            });
        }

</script>
@endsection