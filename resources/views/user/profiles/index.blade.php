@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (!empty(session('success')))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
                

                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Имя</th>
                                <th scope="col">Телефон</th>
                                <th scope="col">Тариф</th>
                                <th scope="col">Редактировать</th>
                                <th scope="col">Опубликована</th>
                                <th scope="col">Подтверждена</th>
                                <th scope="col">Оплачена/Неоплачена</th>
                                <th scope="col">Разрешена к публикации</th>
                            </tr>
                        </thead>
                        @forelse ($profiles as $profile)


                        <tbody>
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td><img src="{{asset('/admin/icons/profileicon.png')}}"> {{ $profile->name }}</td>
                                <td><img src="{{asset('/admin/icons/phoneicon.png')}}"> {{ $profile->phone }}</td>
                                <td><img src="{{asset('/admin/icons/profilerate.png')}}"> {{ $profile->rates->first()->name }}</td>
                                <td><a class="btn btn-ncherry" href="{{route('user.profiles.edit', $profile->id)}}"><img src="{{asset('/admin/icons/profileedit.png')}}"> редактировать анкету</a></td>
                                <td>
                                    @if($profile->is_published == 0)
                                        <form action="{{ route('user.profilepublish', $profile->id) }}" method="POST">
                                            @csrf
                                            @method('patch')
                                            <button class="btn btn-success" style="padding: 0px 7.5px;" type="submit">Опубликовать</button>
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
                                    @if($profile->verified)
                                    Да
                                    @else
                                    Нет
                                    @endif
                                </td>
                                <td>
                                    @if($profile->is_archived)

                                        <form action="{{ route('user.activateprofile', $profile->id) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-success" style="padding: 0px 7.5px;" >Нет, оплатить</button>
                                        </form>
                                    @else
                                        Да, окончание через
                                        {{$profile->minutes_to_archive}}
                                        минут
                                    @endif
                                </td>
                                <td>
                                    @if($profile->allowed)
                                    Да
                                    @else
                                    Нет (На модерации)
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

@endsection