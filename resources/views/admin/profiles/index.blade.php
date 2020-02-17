{{-- @extends('layouts.admin') --}}
@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">

            <button class="btn btn-primary btn-block mt-2 admin-profile-choose" type="button" data-toggle="collapse" data-target="#collapseAdminProfiles">
                Аккаунты администраторов
            </button>
            <div class="collapse" id="collapseAdminProfiles">    
                @foreach($users->where('is_admin', 1) as $user)
                    <div class="accordion" id="accordionExample">
                        <table class="table table-sm" style = "width: 100%;table-layout: fixed; margin-bottom: 0px !important;">
                            <tbody>
                            <tr class="align-items-center d-flex">
                                <td style="width: 100%; vertical-align: middle;
                                border-top: none;">

                                        <button class="btn btn-link" style="padding: 0px;" type="button" data-toggle="collapse"
                                                data-target="#collapseOne{{$loop->iteration}}1" aria-expanded="true" aria-controls="collapseOne">
                                            {{ $user->name }} Анкеты
                                        </button>

                                </td>
                                <td style="width: 100%; vertical-align: middle;
                                border-top: none;">
                                    <img src="{{asset('/admin/icons/userbalance.png')}}">   Общий баланс: {{ $user->user_balance }}
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
                            border-top: none; !important"><a class="nav-link" style="padding: 0px;" href="{{ route('tickets.index') }}"><img src="{{asset('/admin/icons/ticketmessage.png')}}"> Есть сообщения ({{$user->tickets->where('completed_at', '=', null )->count()}})</a></td>
                                @else
                                    <td style="width: 100%; vertical-align: middle;
                                    border-top: none; !important">Нет сообщений</td>
                                @endif
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div id="collapseOne{{$loop->iteration}}1" class="collapse"
                        data-parent="#accordionExample">
                        <div class="card-body">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Имя</th>
                                        <th scope="col">Телефон</th>
                                        <th scope="col">Тариф</th>
                                        <th scope="col">Редактировать</th>
                                        <th scope="col">Опубликована</th>
                                        <th scope="col">Активна</th>
                                        <th scope="col">Подтвержденна</th>
                                    </tr>
                                </thead>
                                @forelse ($user->profiles as $profile)
                                    <tbody>
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td><img src="{{asset('/admin/icons/profileicon.png')}}"> {{ $profile->name }}</td>
                                            <td><img src="{{asset('/admin/icons/phoneicon.png')}}"> {{ $profile->phone }}</td>
                                            <td><img src="{{asset('/admin/icons/profilerate.png')}}"> {{ $profile->rates->first()->name }}</td>
                                            <td><a class="btn btn-ncherry" href="{{route('user.profiles.edit', $profile->id)}}"><img src="{{asset('/admin/icons/profileedit.png')}}"> редактировать анкету</a></td>
                                            </td>
                                            <td>
                                                @if($profile->is_published == 0)
                                                    <form action="{{ route('user.profilepublish', $profile->id) }}" method="POST">
                                                        @csrf
                                                        @method('patch')
                                                        <button  class="btn btn-success" style="padding: 0px 7.5px;" type="submit">Опубликовать</button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('user.profileunpublish', $profile->id) }}" method="POST">
                                                        @csrf
                                                        @method('patch')
                                                        <button class="btn btn-danger" style="padding: 0px 7.5px;" type="submit">Снять с публикации</button>
                                                    </form>
                                                @endif
                                            </td>
                                            <td>
                                                @if($profile->is_archived == 0)
                                                    Активна
                                                @else
                                                    Неактивна
                                                @endif
                                            </td>
                                            <td>
                                                @if($profile->verified == 0)
                                                    <form action="{{ route('admin.profileverify', $profile->id) }}" method="POST">
                                                        @csrf
                                                        @method('patch')
                                                        <button class="btn btn-success" style="padding: 0px 7.5px;" type="submit">Подтвердить</button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('admin.profileunverify', $profile->id) }}" method="POST">
                                                        @csrf
                                                        @method('patch')
                                                        <button class="btn btn-danger" style="padding: 0px 7.5px;" type="submit">Снять подтверждение</button>
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
                @endforeach
            </div> 
            

            <button class="btn btn-primary btn-block mt-2 admin-profile-choose" type="button" data-toggle="collapse" data-target="#collapseUserProfiles">
                Аккаунты пользователей
            </button>
            <div class="collapse" id="collapseUserProfiles">    
                @foreach($users->where('is_admin', 0) as $user)
                    <div class="accordion" id="accordionExample">
                        <table class="table table-sm" style = "width: 100%;table-layout: fixed; margin-bottom: 0px !important;">
                            <tbody>
                            <tr class="align-items-center d-flex">
                                <td style="width: 100%; vertical-align: middle;
                                border-top: none;">

                                        <button class="btn btn-link" style="padding: 0px;" type="button" data-toggle="collapse"
                                                data-target="#collapseOne{{$loop->iteration}}2" aria-expanded="true" aria-controls="collapseOne">
                                            {{ $user->name }} Анкеты
                                        </button>

                                </td>
                                <td style="width: 100%; vertical-align: middle;
                                border-top: none;">
                                    <img src="{{asset('/admin/icons/userbalance.png')}}">   Общий баланс: {{ $user->user_balance }}
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
                            border-top: none; !important"><a class="nav-link" style="padding: 0px;" href="{{ route('tickets.index') }}"><img src="{{asset('/admin/icons/ticketmessage.png')}}"> Есть сообщения ({{$user->tickets->where('completed_at', '=', null )->count()}})</a></td>
                                @else
                                    <td style="width: 100%; vertical-align: middle;
                                    border-top: none; !important">Нет сообщений</td>
                                @endif
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div id="collapseOne{{$loop->iteration}}2" class="collapse"
                        data-parent="#accordionExample">
                        <div class="card-body">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Имя</th>
                                        <th scope="col">Телефон</th>
                                        <th scope="col">Тариф</th>
                                        <th scope="col">Редактировать</th>
                                        <th scope="col">Опубликована</th>
                                        <th scope="col">Активна</th>
                                        <th scope="col">Подтвержденна</th>
                                    </tr>
                                </thead>
                                @forelse ($user->profiles as $profile)
                                    <tbody>
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td><img src="{{asset('/admin/icons/profileicon.png')}}"> {{ $profile->name }}</td>
                                            <td><img src="{{asset('/admin/icons/phoneicon.png')}}"> {{ $profile->phone }}</td>
                                            <td><img src="{{asset('/admin/icons/profilerate.png')}}"> {{ $profile->rates->first()->name }}</td>
                                            <td><a class="btn btn-ncherry" href="{{route('user.profiles.edit', $profile->id)}}"><img src="{{asset('/admin/icons/profileedit.png')}}"> редактировать анкету</a></td>
                                            </td>
                                            <td>
                                                @if($profile->is_published == 0)
                                                    <form action="{{ route('user.profilepublish', $profile->id) }}" method="POST">
                                                        @csrf
                                                        @method('patch')
                                                        <button  class="btn btn-success" style="padding: 0px 7.5px;" type="submit">Опубликовать</button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('user.profileunpublish', $profile->id) }}" method="POST">
                                                        @csrf
                                                        @method('patch')
                                                        <button class="btn btn-danger" style="padding: 0px 7.5px;" type="submit">Снять с публикации</button>
                                                    </form>
                                                @endif
                                            </td>
                                            <td>
                                                @if($profile->is_archived == 0)
                                                    Активна
                                                @else
                                                    Неактивна
                                                @endif
                                            </td>
                                            <td>
                                                @if($profile->verified == 0)
                                                    <form action="{{ route('admin.profileverify', $profile->id) }}" method="POST">
                                                        @csrf
                                                        @method('patch')
                                                        <button class="btn btn-success" style="padding: 0px 7.5px;" type="submit">Подтвердить</button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('admin.profileunverify', $profile->id) }}" method="POST">
                                                        @csrf
                                                        @method('patch')
                                                        <button class="btn btn-danger" style="padding: 0px 7.5px;" type="submit">Снять подтверждение</button>
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
                @endforeach
            </div>        
        </div>
    </div>
@endsection
