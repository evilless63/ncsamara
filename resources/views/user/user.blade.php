@extends('layouts.app')

@section('content')

        <div class="row justify-content-center">
            <div class="col-md-12">

                    <h2>Личный кабинет</h2>

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

@endsection


