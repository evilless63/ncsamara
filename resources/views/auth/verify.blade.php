@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Подтверждение email</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            Письмо с ссылкой на подтверждение было отправлено на ваш email, указанный при регистрации.
                        </div>
                    @endif

                    Пожалуйста, проверьте вашу почту,
                    если вы все еще не получили письмо с ссылкой на подтверждение,
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">Нажмите здесь, чтобы отправить новое</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
