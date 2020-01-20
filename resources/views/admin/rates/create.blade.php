@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Создание тарифа</div>

                    <div class="card-body">
                        <form action="{{ route('admin.rates.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="salonName">Наименование:</label>
                                <input name="name" type="text" id="salonName"
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Укажите имя в анкете" value="{{ old('name') }}">
                            </div>

                            <div class="form-group">
                                <label for="salonCost">Стоимость:</label>
                                <input name="cost" type="number" id="salonCost"
                                       class="form-control @error('cost') is-invalid @enderror"
                                       placeholder="Укажите стоимоть тарифа" value="{{ old('cost') }}">
                            </div>

                            <div class="form-group">
                                <label for="profileDescription">Описание тарифа (преимущества и так далее):</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                          id="profileDescription" rows="3">
                                    {!! old('description') !!}
                                </textarea>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="profileWork24Hours"
                                       name="for_salons" value="1">
                                <label class="form-check-label" for="profileWork24Hours">
                                    Использовать для салона
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="profileWork24Hours"
                                       name="salons_main" value="1">
                                <label class="form-check-label" for="profileWork24Hours">
                                    Для главной страницы (салон)
                                </label>
                            </div>

                            <div class="form-group">
                                <label for="image">Изображение</label>
                                <br>
                                <input type="file" autocomplete="OFF" name="image" id="image" placeholder=""
                                       class="form-control input-sm" />
                            </div>

                            <button type="submit" class="btn btn-primary">Создать тариф</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
