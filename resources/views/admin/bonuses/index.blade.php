@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Бонусы</div>

                    <div class="card-body">
                        <a href="{{ route('admin.bonuses.create')  }}" type="button" class="btn btn-primary">Создать новый бонус</a>

                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Минимальная сумма</th>
                                <th scope="col">Максимальаня сумма</th>
                                <th scope="col">Коэффициэнт бонуса</th>
                                <th scope="col">Удалить бонус</th>
                            </tr>
                            </thead>
                            @forelse ($bonuses as $bonus)


                                <tbody>
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $bonus->min_sum }}</td>
                                    <td>{{ $bonus->max_sum }}</td>
                                    <td><a
                                            href="
                                            {{ route('admin.bonuses.edit', $bonus->id) }}
                                                ">{{ $bonus->koef }} >>></a>
                                    </td>
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
            </div>
        </div>
    </div>
@endsection
