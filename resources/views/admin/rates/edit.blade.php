@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Редактирование тарифа "{{$rate->name}}"</div>

                    <div class="card-body">
                        <form action="{{ route('admin.rates.update', $rate->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('patch')
                            <div class="form-group">
                                <label for="salonName">Наименование:</label>
                                <input name="name" type="text" id="salonName"
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Укажите имя в анкете" value="{{ $rate->name }}">
                            </div>

                            <div class="form-group">
                                <label for="salonCost">Стоимость:</label>
                                <input name="cost" type="text" id="salonCost"
                                       class="form-control @error('cost') is-invalid @enderror"
                                       placeholder="Укажите стоимоть тарифа" value="{{ $rate->cost }}">
                            </div>

                            <div class="form-group">
                                <label for="profileDescription">Описание тарифа (преимущества и так далее):</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                          id="profileDescription" rows="3">
                                    {!! $rate->description !!}
                                </textarea>
                            </div>

                            <div class="form-group">
                                <label for="image">Изображение</label>
                                <br>
                                <input type="file" autocomplete="OFF" name="image" id="image" placeholder=""
                                       class="form-control input-sm" required />
                            </div>

                            <h5 class="font-weight-light text-center text-lg-left mt-4 mb-0">Текущее изображение / назначить новое</h5>

                            <hr class="mt-2 mb-5">
                            <div class="col-lg-3 col-md-4 col-6">
                                <a href="#" class="d-block mb-4 h-100">
                                    <img class="img-fluid img-thumbnail delpath" delpath="{{ asset('/images/rates/created/' . $rate->image )}}" src="{{ asset('/images/rates/created/' . $rate->image) }}" alt="">
                                </a>
                            </div>


                            <button type="submit" class="btn btn-primary">Изменить тариф</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
