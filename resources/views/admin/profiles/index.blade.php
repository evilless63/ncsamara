@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Пользователи - анкеты</div>

                <div class="card-body">

                    @foreach($users as $user)
                    <div class="accordion" id="accordionExample">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <table class="table table-sm">
                                    <tbody>
                                    <tr>
                                        <th>
                                            <h2 class="mb-0">
                                                <button class="btn btn-link" type="button" data-toggle="collapse"
                                                        data-target="#collapseOne{{$loop->iteration}}" aria-expanded="true" aria-controls="collapseOne">
                                                    {{ $user->name }} Анкеты
                                                </button>
                                            </h2>
                                        </th>
                                        <td>
                                            Общий баланс: {{ $user->user_balance }}
                                        </td>
                                        <td>
                                            @if($user->is_banned == 0)
                                                <form action="{{ route('admin.userbanon', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('patch')
                                                    <button type="submit" class="btn btn-danger">Бан</button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.userbanoff', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('patch')
                                                    <button type="submit" class="btn btn-success">Разбан</button>
                                                </form>
                                            @endif
                                        </td>

                                        @if($user->tickets->where('completed_at', '=', null )->count() > 0)
                                            <td><a class="nav-link" href="{{ route('tickets.index') }}">Есть сообщения</a></td>
                                        @else
                                            <td>Нет сообщений</td>
                                        @endif
                                    </tr>
                                    </tbody>
                                </table>

                            </div>

                            <div id="collapseOne{{$loop->iteration}}" class="collapse" aria-labelledby="headingOne"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Имя</th>
                                                <th scope="col">Телефон</th>
                                                <th scope="col">Баланс</th>
                                                <th scope="col">Редактировать</th>
                                                <th scope="col">Публикация</th>
                                                <th scope="col">Подтверждение</th>
                                            </tr>
                                        </thead>
                                        @forelse ($user->profiles as $profile)


                                        <tbody>
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ $profile->name }}</td>
                                                <td>{{ $profile->phone }}</td>
                                                <td>{{ $profile->profile_balance }}</td>
                                                <td><a href="{{route('user.profiles.edit', $profile->id)}}">>>>></a>
                                                </td>
                                                <td>
                                                    @if($profile->is_published == 0)
                                                        <form action="{{ route('user.profilepublish', $profile->id) }}" method="POST">
                                                            @csrf
                                                            @method('patch')
                                                            <button type="submit">Опубликовать</button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('user.profileunpublish', $profile->id) }}" method="POST">
                                                            @csrf
                                                            @method('patch')
                                                            <button type="submit">Снять с публикации</button>
                                                        </form>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($profile->verified == 0)
                                                        <form action="{{ route('admin.profileverify', $profile->id) }}" method="POST">
                                                            @csrf
                                                            @method('patch')
                                                            <button type="submit">Подтвердить</button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('admin.profileunverify', $profile->id) }}" method="POST">
                                                            @csrf
                                                            @method('patch')
                                                            <button type="submit">Снять подтверждение</button>
                                                        </form>
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
                    @endforeach



                </div>
            </div>
        </div>
    </div>
</div>
@endsection
