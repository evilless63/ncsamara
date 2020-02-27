{{-- @extends('layouts.admin') --}}
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Личный кабинет</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    Добро пожаловать, {{ Auth::user()->name }}!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection