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
                                <input name="payment" type="number" step="0.1" id="userPayment"
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

                        <h3>Настройки оплаты и активности анкет</h3>

                        <table class="table table-sm">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Имя</th>
                                <th scope="col">Телефон</th>
                                <th scope="col">Баланс</th>
                                <th scope="col">Пополнить баланс</th>
                                <th scope="col">Активность</th>
                                <th scope="col">Тариф</th>
                            </tr>
                            </thead>
                            @forelse ($profiles as $profile)


                                <tbody>
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $profile->name }}</td>
                                    <td>{{ $profile->phone }}</td>
                                    <td>{{ $profile->profile_balance }}</td>
                                    <td>
                                        <form action="">
                                            <input name="replenish_sum" type="text" id="replenishSum"
                                                   class="form-control @error('replenish_sum') is-invalid @enderror"
                                                   placeholder="Сумма пополнения" value="">

                                            <button type="submit" class="btn btn-primary">Использовать промокод</button>
                                        </form>
                                    </td>
                                    <td>
                                        @if($profile->is_published)
                                            Да
                                        @else
                                            Нет
                                        @endif
                                    </td>
                                    <td>1</td>
                                </tr>
                                </tbody>
                            @empty
                                <p>Нет созданных анкет</p>
                            @endforelse
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
