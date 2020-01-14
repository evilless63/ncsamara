@extends('layouts.app')

@section('google_api_autocomplete')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD2zWS_b-EUkyWjg4cqA_TN-l-lch8-LXo&libraries=places"></script>

    <script>
        function initialize() {
            var input = document.getElementById('salonAddress');
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
                    <div class="card-header">Редактирование салона</div>

                    <div class="card-body">
                        <form action="{{ route('user.salons.update', $salon->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('patch')
                            <div class="form-group">
                                <label for="salonName">Наименование:</label>
                                <input name="name" type="text" id="salonName" class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Укажите название" value="{{ $salon->name }}">
                            </div>
                            <div class="form-group">
                                <label for="salonPhone">Телефон (Только ЦИФРЫ - 11 цифр номера телефона) :</label>
                                <input name="phone" type="text" id="salonPhone" class="form-control @error('phone') is-invalid @enderror"
                                       placeholder="Укажите телефон" value="{{ $salon->phone }}">
                            </div>
                            <div class="form-group">
                                <label for="salonAddress">Адрес:</label>
                                <input name="address" type="text" id="salonAddress" class="form-control @error('address') is-invalid @enderror"
                                       placeholder="Укажите адрес салона" value="{{ $salon->address }}">
                                {{--                                <input type="hidden" name="address_x" value="{{ old('address_x') }} ">--}}
                                {{--                                <input type="hidden" name="address_y" value="{{ old('address_y') }}">--}}
                                <input type="hidden" name="address_x" value="1">
                                <input type="hidden" name="address_y" value="1">
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                            </div>

                            <div class="form-check">
                                <input type="hidden" name="is_published" value="0">
                                <input class="form-check-input" type="checkbox" id="salonIsPublished"
                                       name="is_published" value="1" {{$salon->is_published ? 'checked' : ''}}>
                                <label class="form-check-label" for="salonIsPublished">
                                    Опубликовать на сайте
                                </label>
                            </div>

                            <h5 class="font-weight-light text-center text-lg-left mt-4 mb-0">Текущее изображение / назначить новое</h5>

                            <hr class="mt-2 mb-5">
                            <div class="col-lg-3 col-md-4 col-6">
                                <a href="#" class="d-block mb-4 h-100">
                                    <img class="img-fluid img-thumbnail delpath" delpath="{{asset('/images/salons/created/' . $salon->image) }}" src="{{ asset('/images/salons/created/' . $salon->image) }}" alt="">
                                </a>
                            </div>

                            <div class="form-group">
                                <label for="image">Новое изображение (формат 3 на 2 максимум 1000 на 500 пикселей)</label>
                                <br>
                                <input type="hidden" name="image" value="{{ $salon->image }}">
                                <input type="file" autocomplete="OFF" name="image" id="image" placeholder=""
                                       class="form-control input-sm" />
                            </div>


                            <button type="submit" class="btn btn-primary">Обновить информацию о салоне</button>
                        </form>

                        <form action="{{ route('user.salons.destroy', $salon->id) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">Удалить салон</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
