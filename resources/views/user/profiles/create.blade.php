@extends('layouts.app')

@section('google_api_autocomplete')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD2zWS_b-EUkyWjg4cqA_TN-l-lch8-LXo&libraries=places"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Создание анкеты</div>

                    <div class="card-body">
                        <form action="{{ route('user.profiles.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="profileName">Имя:</label>
                                <input name="name" type="text" id="profileName" class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Укажите имя в анкете" value="{{ old('name') }}">
                            </div>
                            <div class="form-group">
                                <label for="profilePhone">Телефон (Только ЦИФРЫ - 11 цифр номера телефона, номер должен начинаться с 8) :</label>
                                <input name="phone" type="text" id="profilePhone" class="form-control @error('phone') is-invalid @enderror"
                                       placeholder="Укажите телефон в анкете" value="{{ old('phone') }}">
                            </div>
                            <div class="form-group">
                                <label for="profileAddress">Адрес:</label>
                                <input name="address" type="text" id="profileAddress" class="form-control @error('address') is-invalid @enderror"
                                       placeholder="Укажите адрес анкеты" value="{{ old('address') }}">
                                <input type="hidden" name="address_x" value="{{ old('address_x') }} ">
                                <input type="hidden" name="address_y" value="{{ old('address_y') }}">
                            </div>
                            <div class="form-group">
                                <label for="profileAbout">О себе (минимум 50 символов):</label>
                                <textarea name="about" class="form-control @error('about') is-invalid @enderror" id="profileAbout" rows="3">
                                    {!! old('about') !!}
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="profileWorkingHours">Время работы:</label>
                                <input name="working_hours" type="text" id="profileWorkingHours" class="form-control @error('working_hours') is-invalid @enderror"
                                       placeholder="Укажите время работы" value="{{ old('working_hours') }}">
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="profileCheckOut"
                                       name="check_out" value="1">
                                <label class="form-check-label" for="profileCheckOut">
                                    Есть выезд
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="profileApartaments"
                                       name="apartments" value="1">
                                <label class="form-check-label" for="profileApartaments">
                                    Есть апартаменты
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary">Создать анкету</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
