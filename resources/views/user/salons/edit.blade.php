@extends('layouts.app')

@section('google_api_autocomplete')
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
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

<div class="row justify-content-center">
    <div class="col-md-12">

        <h2>Редактирование баннера {{$salon->name}}</h2>
        {{-- TODO Разобраться с кнопками управления --}}
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

        <form action="{{ route('user.salons.update', $salon->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <h5>Поля, отмеченные "*" обязательны к заполнению</h5>
            <div class="form-group">
                <label for="salonName">Наименование *:</label>
                <input name="name" type="text" id="salonName" class="form-control @error('name') is-invalid @enderror"
                    placeholder="Укажите название" value="{{ $salon->name }}">
            </div>
            <div class="form-group">
                <label for="salonPhone">Телефон (Только ЦИФРЫ - 11 цифр номера телефона) *:</label>
                <input name="phone" type="text" id="profilePhone"
                    class="profilePhone form-control @error('phone') is-invalid @enderror" placeholder="Укажите телефон"
                    value="{{ $salon->phone }}">
            </div>
            <div class="form-group">
                <label for="salonMinPrice">Минимальная стоимость услуг *:</label>
                <input name="min_price" type="number" id="salonMinPrice"
                    class="form-control @error('min_price') is-invalid @enderror" placeholder=""
                    value="{{ $salon->min_price }}">
            </div>

            @if(Auth::user()->is_admin)
            <div class="form-check">
                <input type="hidden" name="is_published" value="0">
                <input class="form-check-input" type="checkbox" id="salonIsPublished" name="is_published" value="1"
                    {{$salon->is_published ? 'checked' : ''}}>
                <label class="form-check-label" for="salonIsPublished">
                    Опубликовать на сайте
                </label>
            </div>
            @else
            @if($salon->is_published)
            <p>Баннер успешно опубликован на сайте</p>
            @else
            <p>Баннер не опубликован, необходимо обратиться в техподдержку для его публикации на сайте</p>
            @endif
            @endif

            <h5 class="font-weight-light text-center text-lg-left mt-4 mb-0">Текущее изображение / назначить новое</h5>

            <hr class="mt-2 mb-5">

            <div class="row">
                <div class="col-md-4">
                    <h5>Текущее изображение баннера</h5>
                    <div class="col-lg-3 col-md-4 col-6">
                        <a data-index="0" data-fancybox="gallery1"
                        href="{{ asset('/images/salons/created/' . $salon->image) }}" style="display:block" class="d-block mb-4 h-100">
                            <img class="img-fluid img-thumbnail delpath"
                                delpath="{{asset('/images/salons/created/' . $salon->image) }}"
                                src="{{ asset('/images/salons/created/' . $salon->image) }}" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <p>Новое изображение<br>
                            Необходимо использовать изображение размером 1140 на 300 пикселей или кратный указанному размер.</p>
                        <label class="label" data-toggle="tooltip" title=""
                            data-original-title="Кликните для загрузки основного изображения баннера">
                            <img class="rounded" id="avatar_main" src="{{asset('/admin/icons/add_img.png')}}" alt="avatar">
                            <input type="file" class="sr-only" id="input_main" name="image" accept="image/*">
                        </label>

                        <div class="modal fade" id="modal_main" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel_main">Выберите учаток изображения для загрузки
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
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                                        <button type="button" class="btn btn-primary" id="crop_main">Загрузить</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
        
                        <input type="hidden" autocomplete="OFF" name="image" id="main_salon_image" placeholder=""
                            class="form-control input-sm" value="{{ $salon->image }}" />
                    </div>
                </div>
            </div>
            

            

            <hr class="mt-2 mb-5">

            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="form-group form-inline">
                        <label for="">Тарифный план *: </span></label>
                        <input type="hidden" name="salonrate" value="
                                                    @if($salon->salonrates->count() > 0)
                                                        {{$salon->salonrates->first()}}
                                                    @endif">
                        <select class="form-control" style="width:100%" name="salonrate" id="profileRate">
                            <option></option>

                            @foreach($salonrates as $rate)
                            @if($rate->id)
                            <option value="{{$rate->id}}"
                                {{$salon->salonrates->count() > 0 && $salon->salonrates->first()->id  == $rate->id ? 'selected' : ''}}>
                                {{ $rate->name }} {{$rate->cost}} руб. / сутки</option>
                            @endif
                            @endforeach
                        </select>

                        <p>Внимание !!! Переключение тарифного плана произойдет не сразу, а при следующей
                            попытки
                            оплаты салона<br>Переключение тарифного плана произойдет только в случае достаточного количества
                            Пойнтов
                            на балансе профиля пользователя</p>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Обновить информацию о салоне</button>
        </form>

        <label for="">Управление оплатой салона: </span></label>

        <form action="{{ route('user.salons.destroy', $salon->id) }}" method="POST">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger">Удалить салон</button>
        </form>

    </div>
</div>

@endsection