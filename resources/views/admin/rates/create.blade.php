{{-- @extends('layouts.admin') --}}
@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <h2>Создание тарифа для анкет</h2>
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

        <form action="{{ route('admin.rates.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="salonName">Наименование:</label>
                <input name="name" type="text" id="salonName" class="form-control @error('name') is-invalid @enderror"
                    placeholder="Укажите имя в анкете" value="{{ old('name') }}">
            </div>

            <div class="form-group">
                <label for="salonCost">Стоимость:</label>
                <input name="cost" type="number" id="salonCost" class="form-control @error('cost') is-invalid @enderror"
                    placeholder="Укажите стоимоть тарифа" value="{{ old('cost') }}">
            </div>

            <div class="form-group">
                <label for="profileDescription">Описание тарифа (преимущества и так далее):</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                    id="profileDescription" rows="3">{!! old('description') !!}
                                </textarea>
            </div>

            <button type="submit" class="btn btn-primary">Создать тариф</button>
        </form>

    </div>

</div>
@endsection