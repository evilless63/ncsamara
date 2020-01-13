@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Тарифы</div>

                <div class="card-body">
                    <a href="{{ route('admin.rates.create')  }}" type="button" class="btn btn-primary">Создать новый
                        тариф</a>

                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Наименование</th>
                                <th scope="col">Сумма к списанию</th>
                            </tr>
                        </thead>
                        @forelse ($rates as $rate)


                        <tbody>
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $rate->name }}</td>
                                <td>{{ $rate->cost }}</td>
                            </tr>
                        </tbody>
                        @empty
                        <p>Нет созданных анкет</p>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection