@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Мой баланс и оплата</div>

                    <div class="card-body">
                        <h6>Баланс на аккаунте: {{ Auth::user()->user_balance }} пойнтов</h6>
                        <hr>
                        <form action="{{ route('user.makepayment') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="userPayment">Пополнить на сумму:</label>
                                <input name="payment" type="number" id="userPayment"
                                       class="form-control @error('payment') is-invalid @enderror"
                                       placeholder="Укажите на какую сумму необходимо выполнить пополнение баланса" value="{{ old('payment') }}">

                                <button type="submit" class="btn btn-primary">Пополнить баланс</button>
                            </div>
                        </form>

                        <hr>
                        <form action="{{ route('user.promotionalpayment') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="userPromotionalPayment">Указать промокод:</label>
                                <input name="promotionalpayment" type="text" id="userPromotionalPayment"
                                       class="form-control @error('promotionalpayment') is-invalid @enderror"
                                       placeholder="Укажите промокод для пополнения баланса" value="">

                                <button type="submit" class="btn btn-primary">Использовать промокод</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
