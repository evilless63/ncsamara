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
                    <th scope="col">Название</th>
                    <th scope="col">Телефон</th>
                    <th scope="col">Тариф</th>
                    <th scope="col">Редактировать</th>
                    <th scope="col">Опубликован</th>
                    <th scope="col">Разрешен к публикации</th>
                </tr>
            </thead>
            @forelse ($salons as $salon)
            <tbody>
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td><img src="{{asset('/admin/icons/profileicon.png')}}"> {{ $salon->name }}</td>
                    <td><img src="{{asset('/admin/icons/phoneicon.png')}}"> {{ $salon->phone }}</td>
                    <td><img src="{{asset('/admin/icons/profilerate.png')}}"> {{ $salon->rates->first() ? $salon->rates->first()->name : 'Не назначен'}}</td>
                    <td><a class="btn btn-ncherry" href="{{route('user.salons.edit', $salon->id)}}"><img
                                src="{{asset('/admin/icons/profileedit.png')}}"> редактировать баннер</a></td>
                    <td>
                        @if($salon->allowed == 0)  
                            Будет доступно после модерации
                        @else
                            @if($salon->is_published == 0)
                            <form action="{{ route('user.salonpublish', $salon->id) }}" method="POST">
                                @csrf
                                @method('patch')
                                <button class="btn btn-success" style="padding: 0px 7.5px;"
                                    type="submit">Опубликовать</button>
                            </form>
                            @else
                            <form action="{{ route('user.salonunpublish', $salon->id) }}" method="POST">
                                @csrf
                                @method('patch')
                                <button class="btn btn-danger" style="padding: 0px 7.5px;" type="submit">Снять с
                                    публикации</button>
                            </form>
                            @endif
                        @endif
                    </td>
                    <td>
                        @if($salon->allowed)
                        Да
                        @else
                        Нет (на модерации)
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

@endsection