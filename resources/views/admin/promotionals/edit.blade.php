@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Редактирование промокода "{{$promotional->name}}"</div>

                    <div class="card-body">
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

                            <button type="submit" class="btn btn-primary">Создать промокод</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
