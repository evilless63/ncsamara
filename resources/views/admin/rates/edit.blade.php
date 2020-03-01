{{-- @extends('layouts.admin') --}}
@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-12">

        <h2>Редактирование тарифа "{{$rate->name}}" для анкет</h2>
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

        <form action="{{ route('admin.rates.update', $rate->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="form-group">
                <label for="salonName">Наименование:</label>
                <input name="name" type="text" id="salonName" class="form-control @error('name') is-invalid @enderror"
                    placeholder="Укажите имя в анкете" value="{{ $rate->name }}">
            </div>

            <div class="form-group">
                <label for="salonCost">Стоимость:</label>
                <input name="cost" type="text" id="salonCost" class="form-control @error('cost') is-invalid @enderror"
                    placeholder="Укажите стоимоть тарифа" value="{{ $rate->cost }}">
            </div>

            <div class="form-group">
                <label for="profileDescription">Описание тарифа (преимущества и так далее):</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                    id="profileDescription" rows="3">{!! $rate->description !!}
                                </textarea>
            </div>


            <button type="submit" class="btn btn-primary">Изменить тариф</button>
        </form>


    </div>
</div>
@endsection