@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-12">
        @if (!empty(session('success')))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif



        <button class="btn btn-primary btn-block mt-2 admin-profile-choose" type="button" data-target="#">
            Аккаунты пользователей
        </button>

        @foreach($users->where('is_admin', 0) as $user)
        <div class="accordion" id="accordionExample">
            <table class="table table-sm" style="width: 100%;table-layout: fixed; margin-bottom: 0px !important;">
                <tbody>
                    <tr class="align-items-center d-flex">
                        <td style="width: 100%; vertical-align: middle;
                                border-top: none;">
                            {{ $user->name }}
                        </td>
                        <td style="width: 100%; vertical-align: middle;
                        border-top: none;">
                            <button class="btn btn-link" style="padding: 0px;" type="button" data-toggle="collapse"
                                data-target="#collapseOne{{$loop->iteration}}2" aria-expanded="true"
                                aria-controls="collapseOne">
                                Анкеты
                            </button>

                        </td>
                        <td style="width: 100%; vertical-align: middle;
                        border-top: none;">
                            <button class="btn btn-link" style="padding: 0px;" type="button" data-toggle="collapse"
                                data-target="#collapseTwo{{$loop->iteration}}2" aria-expanded="true"
                                aria-controls="collapseTwo">
                                Баннеры
                            </button>
                        </td>
                        <td style="width: 100%; vertical-align: middle;
                                border-top: none;">
                            <img src="{{asset('/admin/icons/userbalance.png')}}"> Общий баланс:
                            {{ $user->user_balance }}
                        </td>
                        <!--  <td>
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
                                </td> -->

                        @if($user->tickets->where('completed_at', '=', null )->count() > 0)
                        <td style="width: 100%; vertical-align: middle;
                            border-top: none; !important"><a class="nav-link" style="padding: 0px;"
                                href="{{ route('tickets.index') }}"><img
                                    src="{{asset('/admin/icons/ticketmessage.png')}}"> Есть сообщения
                                ({{$user->tickets->where('completed_at', '=', null )->count()}})</a></td>
                        @else
                        <td style="width: 100%; vertical-align: middle;
                                    border-top: none; !important">Нет сообщений</td>
                        @endif
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="collapseOne{{$loop->iteration}}2" class="collapse" data-parent="#accordionExample">
            <div class="">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Имя</th>
                            <th scope="col">Телефон</th>
                            <th scope="col">Тариф</th>
                            <th scope="col">Редактировать</th>
                            <th scope="col">Опубликована</th>
                            <th scope="col">Фото подтверждены</th>
                            <th scope="col">Разрешить к публикации</th>
                        </tr>
                    </thead>
                    @forelse ($user->profiles as $profile)
                    <tbody>
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td><img src="{{asset('/admin/icons/profileicon.png')}}"> {{ $profile->name }}</td>
                            <td><img src="{{asset('/admin/icons/phoneicon.png')}}"> {{ $profile->phone }}</td>
                            <td><img src="{{asset('/admin/icons/profilerate.png')}}">
                                {{ $profile->rates->first() ? $profile->rates->first()->name : 'Не назначен' }}</td>
                            <td><a class="btn btn-ncherry" href="{{route('user.profiles.edit', $profile->id)}}"><img
                                        src="{{asset('/admin/icons/profileedit.png')}}"> редактировать
                                    анкету</a>
                            </td>
                            </td>
                            <td>
                                @if($profile->is_published == 0)
                                Опубликована
                                @else
                                Неопубликована
                                @endif
                            </td>
                            <td>
                                @if($profile->verified == 0)
                                <form action="{{ route('admin.profileverify', $profile->id) }}" method="POST">
                                    @csrf
                                    @method('patch')
                                    <button class="btn btn-success" style="padding: 0px 7.5px;"
                                        type="submit">Подтвердить</button>
                                </form>
                                @else
                                <form action="{{ route('admin.profileunverify', $profile->id) }}" method="POST">
                                    @csrf
                                    @method('patch')
                                    <button class="btn btn-danger" style="padding: 0px 7.5px;" type="submit">Снять
                                        подтверждение</button>
                                </form>
                                @endif
                            </td>
                            <td>
                                @if($profile->allowed == 0)
                                <form action="{{ route('admin.profilemoderateallow', $profile->id) }}" method="POST">
                                    @csrf
                                    @method('patch')
                                    <button class="btn btn-success" style="padding: 0px 7.5px;" type="submit">Разрешить
                                        публикацию</button>
                                </form>
                                @else
                                <form action="{{ route('admin.profilemoderatedisallow', $profile->id) }}" method="POST">
                                    @csrf
                                    @method('patch')
                                    <button class="btn btn-danger" style="padding: 0px 7.5px;" type="submit">Запретить
                                        публикацию</button>
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
        <div id="collapseTwo{{$loop->iteration}}2" class="collapse" data-parent="#accordionExample">
            <div class="">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Наименование</th>
                            <th scope="col">Телефон</th>
                            <th scope="col">Тариф</th>
                            <th scope="col">Редактировать</th>
                            <th scope="col">Опубликована</th>
                            <th scope="col">Разрешить к публикации</th>
                        </tr>
                    </thead>
                    @forelse ($user->salons as $salon)
                    <tbody>
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td><img src="{{asset('/admin/icons/profileicon.png')}}"> {{ $salon->name }}</td>
                            <td><img src="{{asset('/admin/icons/phoneicon.png')}}"> {{ $salon->phone }}</td>
                            <td><img src="{{asset('/admin/icons/profilerate.png')}}">
                                {{ $salon->rates->first() ? $salon->rates->first()->name : 'Не назначен' }}</td>
                            <td><a class="btn btn-ncherry" href="{{route('user.salons.edit', $salon->id)}}"><img
                                        src="{{asset('/admin/icons/profileedit.png')}}"> редактировать
                                    баннер</a>
                            </td>
                            </td>
                            <td>
                                @if($profile->is_published == 0)
                                Опубликован
                                @else
                                Неопубликован
                                @endif
                            </td>
                            <td>
                                @if($profile->allowed == 0)
                                <form action="{{ route('admin.salonmoderateallow', $profile->id) }}" method="POST">
                                    @csrf
                                    @method('patch')
                                    <button class="btn btn-success" style="padding: 0px 7.5px;" type="submit">Разрешить
                                        публикацию</button>
                                </form>
                                @else
                                <form action="{{ route('admin.salonmoderatedisallow', $profile->id) }}" method="POST">
                                    @csrf
                                    @method('patch')
                                    <button class="btn btn-danger" style="padding: 0px 7.5px;" type="submit">Запретить
                                        публикацию</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                    @empty
                    <p>Нет созданных баннеров</p>
                    @endforelse
                </table>
            </div>
        </div>




        {{-- TODO Салоны --}}
        @endforeach

    </div>
</div>

@endsection