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
                                <h2 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse"
                                    data-target="#collapseOne{{$loop->iteration}}" aria-expanded="true" aria-controls="collapseOne">
                                        {{ $user->name }}
                                    </button>
                                </h2>
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
                                                <th scope="col">Опубликована</th>
                                                <th scope="col">Подтверждена</th>
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
                    @endforeach



                </div>
            </div>
        </div>
    </div>
</div>
@endsection