{{-- @extends('layouts.admin') --}}
@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-12">

        @if (!empty(session('success')))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Наименование</th>
                    <th scope="col">Сумма к списанию</th>
                    <th scope="col">Публиковать на главной</th>
                    <th scope="col">Редактировать</th>
                </tr>
            </thead>
            @forelse ($salonrates as $rate)


            <tbody>
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $rate->name }}</td>
                    <td>{{ $rate->cost }}</td>
                    <td>{{ $rate->premium }}</td>
                    <td><a href="{{ route('admin.salonrates.edit', $rate->id) }}">Редактировать</a></td>
                </tr>
            </tbody>
            @empty
            <p>Нет созданных тарифов</p>
            @endforelse
        </table>

    </div>
</div>

@endsection