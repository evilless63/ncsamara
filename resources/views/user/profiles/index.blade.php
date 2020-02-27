@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-12">
        @if (!empty(session('success')))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <button class="btn btn-primary btn-block mt-2 admin-profile-choose" type="button" data-toggle="collapse"
            data-target="#is_published">
            Активные анкеты ({{ $profiles->where('allowed', '1')->where('is_published', '1')->count() }} шт.)
        </button>
        <div class="collapse" id="is_published">
            @foreach($profiles->where('is_published', '1') as $profile)
            @include('user.profiles.profile-block-info')
            @endforeach
        </div>

        <button class="btn btn-primary btn-block mt-2 admin-profile-choose" type="button" data-toggle="collapse"
            data-target="#not_published">
            Отключенные анкеты ({{ $profiles->where('allowed', '1')->where('is_published', '0')->count() }} шт.)
        </button>
        <div class="collapse" id="not_published">
            @foreach($profiles->where('allowed', '1')->where('is_published', '0') as $profile)
            @include('user.profiles.profile-block-info')
            @endforeach
        </div>

        <button class="btn btn-primary btn-block mt-2 admin-profile-choose" type="button" data-toggle="collapse"
            data-target="#on_moderate">
            Анкеты на проверке ({{ $profiles->where('on_moderate', '1')->count() }} шт.)
        </button>
        <div class="collapse" id="on_moderate">
            @foreach($profiles->where('on_moderate', '1') as $profile)
            @include('user.profiles.profile-block-info')
            @endforeach
        </div>
    </div>

</div>

@endsection