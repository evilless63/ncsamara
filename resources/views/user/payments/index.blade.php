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
                            <label for="userPayment">Пополнить на сумму (бонусы:

                                @foreach($bonuses as $bonus)
                                от {{$bonus->min_sum}} до {{$bonus->max_sum}} +{{$bonus->koef}}%,
                                @endforeach
                                :</label>
                            <input name="payment" type="number" step="0.1" id="userPayment"
                                class="form-control @error('payment') is-invalid @enderror"
                                placeholder="Укажите на какую сумму необходимо выполнить пополнение баланса"
                                value="{{ old('payment') }}">

                            <div id="bonusinfo"></div>

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
                                <th scope="col">Тариф</th>
                                <th scope="col">Редактировать</th>
                            </tr>
                        </thead>
                        @forelse ($profiles as $profile)


                        <tbody>
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $profile->name }}</td>
                                <td>{{ $profile->phone }}</td>
                                <td>
                                    {{ $profile->rates->first()->name }} (Спишется {{$profile->rates->first()->cost}} в
                                    сутки)
                                </td>
                                <td><a href="{{route('user.profiles.edit', $profile->id)}}">>>>></a></td>
                            </tr>
                        </tbody>
                        @empty
                        <p>Нет созданных анкет</p>
                        @endforelse
                    </table>

                    <h3>Настройки оплаты и активности салона</h3>
                    @if($salon->first() <> null && $salon->first()->rates()->count())
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Название</th>
                                    <th scope="col">Телефон</th>
                                    <th scope="col">Тариф</th>
                                    <th scope="col">Редактировать</th>
                                    <th scope="col">Оплачена/Неоплачена</th>
                                </tr>
                            </thead>




                            <tbody>
                                <tr>
                                    <td>{{ $salon->first()->name }}</td>
                                    <td>{{ $salon->first()->phone }}</td>
                                    <td>
                                        {{ $salon->first()->rates()->first()->name }} (Спишется
                                        {{$salon->first()->rates()->first()->cost}} в сутки)
                                    </td>
                                    <td><a href="{{ route('user.salons.index') }}">>>>></a></td>
                                    <td>
                                        @if(!$salon->first()->is_approved)

                                        <form action="{{ route('user.activatesalon', ['id' => $salon->first()->id]) }}"
                                            method="post">
                                            @csrf
                                            <button type="submit">Нет, активировать</button>
                                        </form>
                                        @else
                                        Да
                                        @endif
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                        @else
                        <p>Укажите тариф для салона</p>
                        @endif
                        <h3>История движений средств</h3>
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Движение</th>
                                    <th scope="col">Сумма</th>
                                    <th scope="col">Дата движения</th>
                                </tr>
                            </thead>
                            @forelse (auth()->user()->statistics as $statistic)


                            <tbody>
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>@if($statistic->payment < 0) Расход @else Приход @endif</td> <td>
                                            {{ $statistic->payment }}</td>
                                    <td>{{ $statistic->where_was }}</td>
                                </tr>
                            </tbody>
                            @empty
                            <p>Нет движений средств</p>
                            @endforelse
                        </table>

                        <h3>Информация об активированных анкетах</h3>
                        @foreach($rates as $rate)
                        <h5>{{ $rate->name }}</h5>
                        <p>Активированно
                            {{ $rate->profiles->where('is_published', '1')->where('user_id', Auth::user()->id)->count() }}
                            анкет</p>
                        @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('bonuscheck')
<script type="text/javascript">
    $('#userPayment').on('input', function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var payment = $("input[name=payment]").val();

        $.ajax({
            type:'POST',
            url:'/user/plusbonusinfo',
            data:{payment:payment},
            success:function(data){
                $('#bonusinfo').text(data);
            }
        });
    })

</script>
@endsection