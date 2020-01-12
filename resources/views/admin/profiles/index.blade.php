@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Анкеты</div>

                    <div class="card-body">
                        @forelse ($profiles as $profile)
                            <li>
                                {{ $profile->name }}
                                Обновлено {{ $profile->updated_at }}
                            </li>
                        @empty
                            <p>Нет созданных анкет</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
