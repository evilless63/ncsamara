@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Тарифы</div>

                    <div class="card-body">
                        <a href="{{ route('admin.rates.create')  }}" type="button" class="btn btn-primary">Создать новый тариф</a>
                        @forelse ($rates as $rate)
                            <li>
                                <a href="{{route('user.profiles.edit', $rate->id)}}">{{ $rate->name }}</a>
                                Обновлено {{ $rate->updated_at }}
                            </li>
                        @empty
                            <p>Нет созданных тарифов</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
