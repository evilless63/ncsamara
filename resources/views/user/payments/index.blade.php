@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <h2>Мой баланс и оплата</h2>

    <div>
        <h6>Баланс на аккаунте: {{ Auth::user()->user_balance }} пойнтов</h6>
        <hr>
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

        <div class="d-flex">
            <div class="col-3">
                <div class="page-account__sidebar-item sidebar-titled">
                    <div class="sidebar-titled__title">
                        <div class="text">Анкеты</div>
                    </div>
                    <div class="sidebar-titled__body">
                        <ul class="sidebar-titled__list">
                            <li>
                                <div class="name">Всего:</div>
                                <div class="value">1 шт.</div>
                            </li>
                            <li>
                                <div class="name">Активные:</div>
                                <div class="value">0 шт.</div>
                            </li>
                            <li>
                                <div class="name">Отключенные:</div>
                                <div class="value">1 шт.</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="page-account__sidebar-item sidebar-titled">
                    <div class="sidebar-titled__title">
                        <div class="icon">
                            <img src="/templates/Default/img/icon-sidebar-3.svg" alt="">
                        </div>
                        <div class="text">Просмотры</div>
                    </div>
                    <div class="sidebar-titled__body">
                        <ul class="sidebar-titled__list">
                            <li>
                                <div class="name">Сегодня:</div>
                                <div class="value">0</div>
                            </li>
                            <li>
                                <div class="name">Вчера:</div>
                                <div class="value">0</div>
                            </li>
                            <li>
                                <div class="name">За все время:</div>
                                <div class="value">0</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="page-account__sidebar-item sidebar-titled">
                    <div class="sidebar-titled__title">
                        <div class="icon">
                            <img src="/templates/Default/img/icon-sidebar-4.svg" alt="">
                        </div>
                        <div class="text">Расход</div>
                    </div>
                    <div class="sidebar-titled__body">
                        <ul class="sidebar-titled__list">
                            <li>
                                <div class="value">0 р./день</div>
                            </li>
                            <li>
                                <div class="value">0 р./неделя</div>
                            </li>
                            <li>
                                <div class="value">0 р./мес</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@section('bonuscheck')
<script type="text/javascript">

</script>
@endsection