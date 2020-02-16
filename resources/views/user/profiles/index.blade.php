@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            
                

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

@endsection