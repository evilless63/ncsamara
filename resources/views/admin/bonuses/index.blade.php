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
                                <th scope="col">Минимальная сумма</th>
                                <th scope="col">Максимальаня сумма</th>
                                <th scope="col">Коэффициэнт бонуса</th>
                                <th scope="col">Редактировать</th>
                                <th scope="col">Удалить бонус</th>
                            </tr>
                            </thead>
                            @forelse ($bonuses as $bonus)


                                <tbody>
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $bonus->min_sum }}</td>
                                    <td>{{ $bonus->max_sum }}</td>
                                    <td>{{ $bonus->koef }}</a></td>
                                    <td><a href="{{ route('admin.bonuses.edit', $bonus->id) }}">Редактировать</a></td>
                                    <td>
                                        <form action="{{ route('admin.bonuses.destroy', $bonus->id) }}"
                                              method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger">Удалить бонус</button>
                                        </form>
                                    </td>
                                </tr>
                                </tbody>
                            @empty
                                <p>Нет созданных бонусов</p>
                            @endforelse
                        </table>
                    </div>
                </div>

@endsection
