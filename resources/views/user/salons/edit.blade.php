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

        <div class="row justify-content-center">
            <div class="col-md-12">
   
                    <h2>Редактирование салона</h2>

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
                                <label for="salonMinPrice">Минимальная стоимость услуг:</label>
                                <input name="min_price" type="number" id="salonMinPrice"
                                       class="form-control @error('min_price') is-invalid @enderror"
                                       placeholder="" value="{{ $salon->min_price }}">
                            </div>
                            <!-- <div class="form-group">
                                <label for="salonAddress">Адрес:</label>
                                <input name="address" type="text" id="salonAddress" class="form-control @error('address') is-invalid @enderror"
                                       placeholder="Укажите адрес салона" value="{{ $salon->address }}">
                                {{--                                <input type="hidden" name="address_x" value="{{ old('address_x') }} ">--}}
                                {{--                                <input type="hidden" name="address_y" value="{{ old('address_y') }}">--}}
                                <input type="hidden" name="address_x" value="1">
                                <input type="hidden" name="address_y" value="1">
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                            </div> -->

                            @if(Auth::user()->is_admin)
                            <div class="form-check">
                                <input type="hidden" name="is_published" value="0">
                                <input class="form-check-input" type="checkbox" id="salonIsPublished"
                                       name="is_published" value="1" {{$salon->is_published ? 'checked' : ''}}>
                                <label class="form-check-label" for="salonIsPublished">
                                    Опубликовать на сайте
                                </label>
                            </div>
                            @else
                                @if($salon->is_published)
                                    <p>Салон успешно опубликован на сайте</p>
                                @else
                                    <p>Салон не опубликован, необходимо обратиться в техподдержку для его публикации на сайте</p>
                                @endif
                            @endif

                            <h5 class="font-weight-light text-center text-lg-left mt-4 mb-0">Текущее изображение / назначить новое</h5>

                            <hr class="mt-2 mb-5">
                            <h5>Изображение</h5>
                            <div class="col-lg-3 col-md-4 col-6">
                                <a href="#" class="d-block mb-4 h-100">
                                    <img class="img-fluid img-thumbnail delpath" delpath="{{asset('/images/salons/created/' . $salon->image) }}" src="{{ asset('/images/salons/created/' . $salon->image) }}" alt="">
                                </a>
                            </div>

                            <div class="form-group">
                                <label for="image">Новое изображение</label>
                                <br>
                                <input type="hidden" name="image" value="{{ $salon->image }}">
                                <input type="file" autocomplete="OFF" name="image" id="image" placeholder=""
                                       class="form-control input-sm" />
                            </div>

                            <hr class="mt-2 mb-5">
                            <h5>Изображение для главной</h5>
                            <div class="col-lg-3 col-md-4 col-6">
                                <a href="#" class="d-block mb-4 h-100">
                                    <img class="img-fluid img-thumbnail delpath" delpath="{{asset('/images/salons/created/' . $salon->image_prem) }}" src="{{ asset('/images/salons/created/' . $salon->image_prem) }}" alt="">
                                </a>
                            </div>

                            <div class="form-group">
                                <label for="image">Новое изображение для главной</label>
                                <br>
                                <input type="hidden" name="image_prem" value="{{ $salon->image_prem }}">
                                <input type="file" autocomplete="OFF" name="image_prem" id="image" placeholder=""
                                       class="form-control input-sm" />
                            </div>

                            <h2>Тарифный план:
                                @if($salon->rates->count() == 0)
                                Не назначен
                                @else
                                {{$salon->rates->first()->name}}
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
                                            @if($salon->rates->count() > 0)
                                                {{$salon->rates->first()}}
                                            @endif">
                                <select class="form-control" name="rate" id="profileRate">
                                    <option></option>
                                    @foreach($rates as $rate)
                                    <option
                                        value="{{$rate->id}} {{$salon->rates->find($rate->id) <> null ? 'selected' : ''}}">
                                        {{ $rate->name }}</option>
                                    @endforeach
                                </select>
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

@endsection
