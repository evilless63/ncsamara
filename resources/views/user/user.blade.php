@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-12">

        <h2>Личный кабинет</h2>

        @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
        @endif

        Добро пожаловать, {{ Auth::user()->name }}!

        @if(Auth::user()->is_admin)
        <button class="btn btn-primary btn-block mt-2 admin-profile-choose" type="button" data-toggle="collapse"
            data-target="#collapseUserProfiles">
            Анкеты пользователей на модерацию
        </button>
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
            @forelse ($profiles->where('allowed', '0') as $profile)
            <tbody>
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td><img src="{{asset('/admin/icons/profileicon.png')}}"> {{ $profile->name }}</td>
                    <td><img src="{{asset('/admin/icons/phoneicon.png')}}"> {{ $profile->phone }}</td>
                    <td><img src="{{asset('/admin/icons/profilerate.png')}}">
                        {{ $profile->rates->first()->name }}</td>
                    <td><a class="btn btn-ncherry" href="{{route('user.profiles.edit', $profile->id)}}"><img
                                src="{{asset('/admin/icons/profileedit.png')}}"> редактировать анкету</a>
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



        <button class="btn btn-primary btn-block mt-2 admin-profile-choose" type="button" data-toggle="collapse"
            data-target="#collapseUserSalons">
            Баннеры пользователей на модерацию
        </button>

        <table class="table table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Имя</th>
                    <th scope="col">Телефон</th>
                    <th scope="col">Тариф</th>
                    <th scope="col">Редактировать</th>
                    <th scope="col">Опубликован</th>
                    <th scope="col">Разрешить к публикации</th>
                </tr>
            </thead>
            @forelse ($salons->where('allowed', '0') as $salon)
            <tbody>
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td><img src="{{asset('/admin/icons/profileicon.png')}}"> {{ $salon->name }}</td>
                    <td><img src="{{asset('/admin/icons/phoneicon.png')}}"> {{ $salon->phone }}</td>
                    <td><img src="{{asset('/admin/icons/profilerate.png')}}">
                        {{ $salon->rates->first()->name }}</td>
                    <td><a class="btn btn-ncherry" href="{{route('user.profiles.edit', $salon->id)}}"><img
                                src="{{asset('/admin/icons/profileedit.png')}}"> редактировать баннер</a>
                    </td>
                    </td>
                    <td>
                        @if($salon->is_published == 0)
                        Опубликован
                        @else
                        Неопубликован
                        @endif
                    </td>
                    <td>
                        @if($salon->allowed == 0)
                        <form action="{{ route('admin.salonmoderateallow', $salon->id) }}" method="POST">
                            @csrf
                            @method('patch')
                            <button class="btn btn-success" style="padding: 0px 7.5px;" type="submit">Разрешить
                                публикацию</button>
                        </form>
                        @else
                        <form action="{{ route('admin.profilemoderatedisallow', $salon->id) }}" method="POST">
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

    @endif

</div>
</div>

@endsection