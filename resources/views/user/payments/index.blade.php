@extends('layouts.app')

@section('content')



<div class="row">
    <div class="col-md-12">
        <h2>Финансовая информация</h2>
        <h6>Баланс на аккаунте: {{ Auth::user()->user_balance }} пойнтов</h6>
    </div>

</div>
<div class="row">
    <div class="col-md-12">
        <form method="POST" action="https://merchant.webmoney.ru/lmi/payment_utf.asp" accept-charset="utf-8">
            <div class="form-group">
                <label for="userPayment">Пополнить на сумму:</label>
                <div class="d-flex">
                    <input type="text" name="LMI_PAYMENT_AMOUNT" value="" id="userPayment" class="form-control">
                    <button type="submit" class="btn btn-success"
                        style="padding: 0px 7.5px;margin-left: 1em;">Пополнить</button>
                </div>

                <input type="hidden" name="LMI_PAYMENT_DESC" value="платеж по счету">
                <input type="hidden" name="LMI_PAYMENT_NO" value="1234">
                <input type="hidden" name="LMI_PAYEE_PURSE" value="R905479213120">
                <input type="hidden" name="LMI_SIM_MODE" value="0">
                <input type="hidden" name="user" value="{{Auth::user()->id}}">

                <div id="bonusinfo"></div>
            </div>
        </form>

        <hr>
        <form action="{{ route('user.promotionalpayment') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="userPromotionalPayment">Активировать промокод:</label>
                <div class="d-flex">
                    <input name="promotionalpayment" type="text" id="userPromotionalPayment"
                        class="form-control @error('promotionalpayment') is-invalid @enderror"
                        placeholder="Укажите промокод для пополнения баланса" value="">
                    <button type="submit" class="btn btn-success"
                        style="padding: 0px 7.5px;margin-left: 1em;">Активировать</button>
                </div>

            </div>
        </form>
    </div>
</div>
<div class="row mt-5">
    <div class="col-md-4">
        <h4 class="text">Анкеты</h4>
        @if(Auth::user() !== null)

        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            @if(Auth::user()->profiles()->count())
            <li class="nav-item"><i class="nav-icon far fa-circle text-yellow"></i> <span>На модерации:
                    {{ Auth::user()->profiles()->where('allowed', 0)->count()}}</span></li>
            <li class="nav-item"><i class="nav-icon far fa-circle text-green"></i> <span>Активно:
                    {{ Auth::user()->profiles()->where('is_published', 1)->count()}}</span></li>
            <li class="nav-item"><i class="nav-icon far fa-circle text-red"></i> <span>Не
                    оплаченных: {{ Auth::user()->profiles()->where('is_published', 0)->count()}}</span></li>
            @else
            <p>Нет созданных анкет.</p>
            @endif
        </ul>
        @endif
    </div>
    <div class="col-md-4">
        <h4 class="text">Баннеры</h4>
        @if(Auth::user() !== null)

        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            @if(Auth::user()->salons()->count())
            <li class="nav-item"><i class="nav-icon far fa-circle text-yellow"></i> <span>На модерации:
                    {{ Auth::user()->salons()->where('allowed', 0)->count()}}</span></li>
            <li class="nav-item"><i class="nav-icon far fa-circle text-green"></i> <span>Активно:
                    {{ Auth::user()->salons()->where('is_published', 1)->count()}}</span></li>
            <li class="nav-item"><i class="nav-icon far fa-circle text-red"></i> <span>Не активно:
                    {{ Auth::user()->salons()->where('is_published', 0)->count()}}</span></li>
            @else
            <p>Нет созданных баннеров.</p>
            @endif
        </ul>
        @endif
    </div>
    <div class="col-md-4">
        <h4>Сумма списания @if(Auth::user()->is_admin) (все пользователи) @endif</h4>
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <li class="nav-item"><i class="nav-icon far fa-circle text-yellow"></i> <span>По баннерам:
                    {{$salon_summ}} руб./сутки</span></li>
            <li class="nav-item"><i class="nav-icon far fa-circle text-green"></i> <span>По анкетам:
                    {{$profile_summ}} руб./сутки</span></li>

        </ul>
    </div>
</div>

<div class="row mt-5">
    <div class="col-md-12">
        <h4 class="text">История платежей</h4>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Сумма оплаты</th>
                    <th scope="col">Дата платежа</th>
                </tr>
            </thead>
            @forelse ($statistics as $statistic)
            <tbody>
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{$statistic->payment}} руб.</td>
                    <td>{{$statistic->where_was}}</td>
                </tr>
            </tbody>
            @empty
            <p>Нет поступивших оплат</p>
            @endforelse
        </table>
    </div>
</div>



@endsection

@section('bonuscheck')
<script type="text/javascript">

</script>
@endsection