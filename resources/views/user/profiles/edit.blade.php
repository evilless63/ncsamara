@extends('layouts.app')

@section('google_api_autocomplete')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD2zWS_b-EUkyWjg4cqA_TN-l-lch8-LXo&libraries=places"></script>

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
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Редактирование анкеты</div>

                    <div class="card-body">
                        <form action="{{ route('user.profiles.update', $profile->id) }}" method="POST">
                            @csrf
                            @method('patch')
                            <div class="form-group">
                                <label for="profileName">Имя:</label>
                                <input name="name" type="text" id="profileName" class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Укажите имя в анкете" value="{{ $profile->name }}">
                            </div>
                            <div class="form-group">
                                <label for="profilePhone">Телефон (Только ЦИФРЫ - 11 цифр номера телефона, номер должен начинаться с 8) :</label>
                                <input name="phone" type="text" id="profilePhone" class="form-control @error('phone') is-invalid @enderror"
                                       placeholder="Укажите телефон в анкете" value="{{ $profile->phone }}">
                            </div>
                            <div class="form-group">
                                <label for="profileAddress">Адрес:</label>
                                <input name="address" type="text" id="profileAddress" class="form-control @error('address') is-invalid @enderror"
                                       placeholder="Укажите адрес анкеты" value="{{ $profile->name }}">
{{--                                <input type="hidden" name="address_x" value="{{ old('address_x') }} ">--}}
{{--                                <input type="hidden" name="address_y" value="{{ old('address_y') }}">--}}
                                <input type="hidden" name="address_x" value="1">
                                <input type="hidden" name="address_y" value="1">
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                            </div>
                            <div class="form-group">
                                <label for="profileAbout">О себе (минимум 50 символов):</label>
                                <textarea name="about" class="form-control @error('about') is-invalid @enderror" id="profileAbout" rows="3">
                                    {!! $profile->name !!}
                                </textarea>
                            </div>

                            <div class="form-group">
                                <label for="profileWorkingHours">Время работы:</label>
                                <input name="working_hours" type="text" id="profileWorkingHours" class="form-control @error('working_hours') is-invalid @enderror"
                                       placeholder="Укажите время работы" value="{{$profile->name}}">
                            </div>

                            <div class="form-group">
                                <label for="profileBoobs">Размер груди (1-10):</label>
                                <input name="boobs" type="number" id="profileBoobs" class="form-control @error('boobs') is-invalid @enderror"
                                       placeholder="" value="{{$profile->boobs }}">
                            </div>

                            <div class="form-group">
                                <label for="profileAge">Возраст (18-65):</label>
                                <input name="age" type="number" id="profileAge" class="form-control @error('age') is-invalid @enderror"
                                       placeholder="" value="{{ $profile->age }}">
                            </div>

                            <div class="form-group">
                                <label for="profileWeight">Вес (40-100):</label>
                                <input name="weight" type="number" id="profileWeight" class="form-control @error('weight') is-invalid @enderror"
                                       placeholder="" value="{{ $profile->weight }}">
                            </div>

                            <div class="form-group">
                                <label for="profileHeight">Рост (150-195):</label>
                                <input name="height" type="number" id="profileHeight" class="form-control @error('height') is-invalid @enderror"
                                       placeholder="" value="{{ $profile->height }}">
                            </div>

                            <div class="form-group">
                                <label for="profileOneHour">Цена за 1 час (1000-50000):</label>
                                <input name="one_hour" type="number" id="profileOneHour" class="form-control @error('one_hour') is-invalid @enderror"
                                       placeholder="" value="{{ $profile->one_hour }}">
                            </div>

                            <div class="form-group">
                                <label for="profileTwoHour">Цена за 2 часа (1000-100000):</label>
                                <input name="two_hour" type="number" id="profileTwoHour" class="form-control @error('two_hour') is-invalid @enderror"
                                       placeholder="" value="{{ $profile->two_hour }}">
                            </div>

                            <div class="form-group">
                                <label for="profileAllNight">Цена за всю ночь (1000-1000000):</label>
                                <input name="all_night" type="number" id="profileAllNight" class="form-control @error('all_night') is-invalid @enderror"
                                       placeholder="" value="{{ $profile->all_night }}">
                            </div>

                            <div class="form-check">
                                <input type="hidden" name="check_out" value="0">
                                <input class="form-check-input" type="checkbox" id="profileCheckOut"
                                       name="check_out" value="1" {{$profile->check_out ? 'checked' : ''}} >
                                <label class="form-check-label" for="profileCheckOut">
                                    Есть выезд
                                </label>
                            </div>

                            <div class="form-check">
                                <input type="hidden" name="apartments" value="0">
                                <input class="form-check-input" type="checkbox" id="profileApartaments"
                                       name="apartments" value="1" {{$profile->apartments ? 'checked' : ''}}>
                                <label class="form-check-label" for="profileApartaments">
                                    Есть апартаменты
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary">Обновить анкету</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
