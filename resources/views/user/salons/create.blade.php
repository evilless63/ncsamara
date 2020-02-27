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

<div class="row justify-content-center">
    <div class="col-md-12">
        <h2>Создание баннера</h2>

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

        <form action="{{ route('user.salons.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="salonName">Наименование:</label>
                <input name="name" type="text" id="salonName" class="form-control @error('name') is-invalid @enderror"
                    placeholder="Укажите название" value="{{ old('name') }}">
            </div>
            <div class="form-group">
                <label for="salonPhone">Телефон (Только ЦИФРЫ - 11 цифр номера телефона):</label>
                <input name="phone" type="text" id="salonPhone"
                    class="form-control @error('phone') is-invalid @enderror" placeholder="Укажите телефон"
                    value="{{ old('phone') }}">
            </div>
            <div class="form-group">
                <label for="salonMinPrice">Минимальная стоимость услуг:</label>
                <input name="min_price" type="number" id="salonMinPrice"
                    class="form-control @error('min_price') is-invalid @enderror" placeholder=""
                    value="{{ old('min_price') }}">
            </div>

            <div class="form-group">
                <p>Изображение баннера<br>
                    Необходимо использовать изображение размером 1140 на 300 пикселей или кратный указанному размер.</p>
                <label class="label" data-toggle="tooltip" title=""
                    data-original-title="Кликните для загрузки изображения баннера">
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
                    class="form-control input-sm" />
            </div>

            <button type="submit" class="btn btn-primary">Создать баннер</button>
        </form>

    </div>
</div>
@endsection