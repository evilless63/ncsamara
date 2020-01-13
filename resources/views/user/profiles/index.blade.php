@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Анкеты</div>

                <div class="card-body">
                    <a href="{{ route('user.profiles.create')  }}" type="button" class="btn btn-primary">Создать новую
                        анкету</a>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Имя</th>
                                <th scope="col">Телефон</th>
                                <th scope="col">Баланс</th>
                                <th scope="col">Редактировать</th>
                                <th scope="col">Опубликована</th>
                                <th scope="col">Подтверждена</th>
                            </tr>
                        </thead>
                        @forelse ($profiles as $profile)


                        <tbody>
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $profile->name }}</td>
                                <td>{{ $profile->phone }}</td>
                                <td>{{ $profile->profile_balance }}</td>
                                <td><a href="{{route('user.profiles.edit', $profile->id)}}">>>>></a></td>
                                <td>
                                    @if($profile->is_published)
                                    Да
                                    @else
                                    Нет
                                    @endif
                                </td>
                                <td>
                                    @if($profile->verified)
                                    Да
                                    @else
                                    Нет
                                    @endif
                                </td>
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