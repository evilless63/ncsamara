@extends('layouts.app')

@section('google_api_autocomplete')
    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD2zWS_b-EUkyWjg4cqA_TN-l-lch8-LXo&libraries=places"></script>

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
                    <div class="card-header">Создание салона</div>

                    <div class="card-body">
                        <form action="{{ route('user.salons.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="salonName">Наименование:</label>
                                <input name="name" type="text" id="salonName"
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Укажите название" value="{{ old('name') }}">
                            </div>
                            <div class="form-group">
                                <label for="salonPhone">Телефон (Только ЦИФРЫ - 11 цифр номера телефона):</label>
                                <input name="phone" type="text" id="salonPhone"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       placeholder="Укажите телефон" value="{{ old('phone') }}">
                            </div>
                            <div class="form-group">
                                <label for="salonAddress">Адрес:</label>
                                <input name="address" type="text" id="salonAddress"
                                       class="form-control @error('address') is-invalid @enderror"
                                       placeholder="Укажите адрес салона" value="{{ old('address') }}">
                                {{--                                <input type="hidden" name="address_x" value="{{ old('address_x') }}
                                ">--}}
                                {{--                                <input type="hidden" name="address_y" value="{{ old('address_y') }}">--}}
                                <input type="hidden" name="address_x" value="1">
                                <input type="hidden" name="address_y" value="1">
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="salonIsPublished" name="is_published"
                                       value="1">
                                <label class="form-check-label" for="salonIsPublished">
                                    Опубликовать на сайте
                                </label>
                            </div>

                            <div class="form-group">
                                <label for="image">Изображение (формат 3 на 2 максимум 1000 на 500 пикселей)</label>
                                <br>
                                <input type="file" autocomplete="OFF" name="image" id="image" placeholder=""
                                       class="form-control input-sm" required />
                            </div>

                            <button type="submit" class="btn btn-primary">Создать салон</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
