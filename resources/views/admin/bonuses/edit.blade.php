@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Изменение бонуса</div>

                    <div class="card-body">
                        <form action="{{ route('admin.bonuses.update', $bonus->id) }}" method="POST">
                            @csrf
                            @method('patch')
                            <div class="form-group">
                                <label for="bonusMin">Минимальная сумма к зачислению:</label>
                                <input name="min_sum" type="number" id="bonusMin"
                                       class="form-control @error('min_sum') is-invalid @enderror"
                                       placeholder="" value="{{ $bonus->min_sum }}">
                            </div>

                            <div class="form-group">
                                <label for="bonusMax">Максимальная сумма к зачислению:</label>
                                <input name="max_sum" type="number" id="bonusMax"
                                       class="form-control @error('max_sum') is-invalid @enderror"
                                       placeholder="" value="{{ $bonus->max_sum }}">
                            </div>

                            <div class="form-group">
                                <label for="bonusKoef">Коэффициэнт бонуса:</label>
                                <input name="koef" type="number" id="bonusKoef"
                                       class="form-control @error('koef') is-invalid @enderror"
                                       placeholder="" value="{{ $bonus->koef }}">
                            </div>

                            <button type="submit" class="btn btn-primary">Изменить бонус</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
