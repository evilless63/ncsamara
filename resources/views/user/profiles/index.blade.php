@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Анкеты</div>

                    <div class="card-body">
                        <a href="{{ route('user.profiles.create')  }}" type="button" class="btn btn-primary">Создать новую анкету</a>
                        @forelse ($profiles as $profile)
                            <li>{{ $profile->name }}</li>
                        @empty
                            <p>Нет созданных анкет</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
