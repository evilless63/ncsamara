{{-- @extends('layouts.admin') --}}
@extends('layouts.app')

@section('content')

        <div class="row justify-content-center">
            <div class="col-md-12">
                <h2>Редактирование промокода "{{$promotional->code}}"</h2>
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

                        <form action="{{ route('admin.promotionals.update', $promotional->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('patch')
                            <div class="form-group">
                                <label for="promotionalCode">Промокод:</label>
                                <input name="code" type="text" id="promotionalCode"
                                       class="form-control @error('code') is-invalid @enderror"
                                       placeholder="Укажите промокод" value="{{ $promotional->code }}">
                            </div>

                            <div class="form-group">
                                <label for="promotionaReplenishSumm">Пополняемая сумма:</label>
                                <input name="replenish_summ" type="number" id="promotionaReplenishSumm"
                                       class="form-control @error('replenish_summ') is-invalid @enderror"
                                       placeholder="Укажите промокод" value="{{ $promotional->replenish_summ }}">
                            </div>

                            <button type="submit" class="btn btn-primary">Изменить промокод</button>

                        </form>

                </div>
            </div>

@endsection
