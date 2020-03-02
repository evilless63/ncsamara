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
            @foreach($profiles->where('allowed', '1')->where('is_published', '1') as $profile)
            <div class="row">
                <div class="col-md-2">
                    <img class="img-fluid" style="max-width:52%"
                        src="{{ asset('/images/profiles/images/created/' . $profile->main_image )}}"
                        alt="{{$profile->name}}">
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-8 d-flex justify-content-between">
                            <h5 style="line-height: 1.5;margin: 0;margin-right: 1rem;">{{$profile->name}}</h5>
                            <a href="{{ route('user.profiles.edit', $profile->id)}}"
                                style="padding: 2px 0.5px; display:block; color: #6c030e;">
                                <i class="fas fa-pencil-alt"></i> Редактировать анкету
                            </a>
                        </div>

                        <div class="col d-flex justify-content-end align-items-baseline">
                            @if($profile->verified)
                            <a class="nc-point" href="#"><img style="width: 65%;"
                                    src=" {{asset('images/approved.png')}}" alt="Подтверждена"></a>
                            @endif
                            @if($profile->apartments)
                            <a class="nc-point" href="#"><img style="width: 65%;"
                                    src="{{asset('images/apartments.png')}}" alt="Апартаменты"></a>
                            @endif
                            @if($profile->check_out)
                            <a class="nc-point" href="#"><img style="width: 65%;" src="{{asset('images/car.png')}}"
                                    alt="Выезд"></a>
                            @endif
                        </div>
                        <div class="col">
                            <form action="{{route('user.profiles.destroy', $profile->id)}}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" style="padding: 0px 7.5px;">
                                    <i class="fa fa-times" aria-hidden="true"></i> Удалить
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-md-12">
                            <div class="row form-group d-flex justify-content-between align-items-center">
                                <div class="col-2" for="profileName">Телефон:</div>
                                {{-- TODO роут для динамической смены телефона --}}

                                <input type="text" class="profilePhone form-control col-5" value="{{$profile->phone}}"
                                    id="profilePhone{{$loop->iteration}}" >
                                <div class="changePhoneNumber btn btn-success col-4"
                                    style="padding: 0px 7.5px; cursor:pointer">
                                    (изменить)
                                </div>
                            </div>

                            <div class="row form-group d-flex justify-content-between align-items-center">
                                <div for="profileName" class="col-2">Тариф:</div>

                                <select class="profileRate form-control form-inline col-5" profile-id="{{$profile->id}}" name="rate"
                                    id="profileRate{{$loop->iteration}}">
                                    {{-- TODO роут для смены тарифа динамически --}}
                                    <option></option>
                                    @foreach($rates as $rate)
                                    <option value="{{$rate->id}}"
                                        {{$profile->rates->count() > 0 && $profile->rates->first()->id == $rate->id ? 'selected' : ''}}>
                                        {{ $rate->name }} {{ $rate->cost }} руб./сутки
                                    </option>
                                    @endforeach
                                </select>
                                <button class="ProfileRateButton btn btn-success col-4" style="padding: 0px 7.5px;" type="submit"
                                    style="padding: 0px 7.5px;" id="ProfileRateButton{{$loop->iteration}}">Изменить
                                    тариф</button>

                            </div>

                            <div>
                                @if($profile->is_published == 0 && $profile->allowed)
                                <form action="{{ route('user.profilepublish', $profile->id) }}" method="POST">
                                    @csrf
                                    @method('patch')
                                    <button class="btn btn-success" style="padding: 0px 7.5px;" type="submit"
                                        style="padding: 0px 7.5px;">Возобновить показ
                                        анкеты</button>
                                </form>
                                @elseif($profile->allowed == 0)
                                <p><strong>Ваша анкета на модерации, дождитесь ее окончания.</strong></p>
                                @elseif($profile->is_published == 1 && $profile->allowed)
                                <form action="{{ route('user.profileunpublish', $profile->id) }}" method="POST">
                                    @csrf
                                    @method('patch')
                                    <button class="btn btn-danger" style="padding: 0px 7.5px;" type="submit"
                                        style="padding: 0px 7.5px;">Остановить показ
                                        анкеты</button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <hr class="mt-3">
            @endforeach
        </div>

        <button class="btn btn-primary btn-block mt-2 admin-profile-choose" type="button" data-toggle="collapse"
            data-target="#not_published">
            Отключенные анкеты ({{ $profiles->where('allowed', '1')->where('is_published', '0')->count() }} шт.)
        </button>
        <div class="collapse" id="not_published">
            @foreach($profiles->where('allowed', '1')->where('is_published', '0') as $profile)
            <div class="row">
                <div class="col-md-2">
                    <img class="img-fluid" style="max-width:52%"
                        src="{{ asset('/images/profiles/images/created/' . $profile->main_image )}}"
                        alt="{{$profile->name}}">
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-8 d-flex justify-content-between">
                            <h5 style="line-height: 1.5;margin: 0;margin-right: 1rem;">{{$profile->name}}</h5>
                            <a href="{{ route('user.profiles.edit', $profile->id)}}"
                                style="padding: 2px 0.5px; display:block; color: #6c030e;">
                                <i class="fas fa-pencil-alt"></i> Редактировать анкету
                            </a>
                        </div>

                        <div class="col d-flex justify-content-end align-items-baseline">
                            @if($profile->verified)
                            <a class="nc-point" href="#"><img style="width: 65%;"
                                    src=" {{asset('images/approved.png')}}" alt="Подтверждена"></a>
                            @endif
                            @if($profile->apartments)
                            <a class="nc-point" href="#"><img style="width: 65%;"
                                    src="{{asset('images/apartments.png')}}" alt="Апартаменты"></a>
                            @endif
                            @if($profile->check_out)
                            <a class="nc-point" href="#"><img style="width: 65%;" src="{{asset('images/car.png')}}"
                                    alt="Выезд"></a>
                            @endif
                        </div>
                        <div class="col">
                            <form action="{{route('user.profiles.destroy', $profile->id)}}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" style="padding: 0px 7.5px;">
                                    <i class="fa fa-times" aria-hidden="true"></i> Удалить
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-md-12">
                            <div class="row form-group d-flex justify-content-between align-items-center">
                                <div class="col-2" for="profileName">Телефон:</div>
                                {{-- TODO роут для динамической смены телефона --}}

                                <input type="text" class="profilePhone form-control col-5" value="{{$profile->phone}}"
                                    id="profilePhone{{$loop->iteration}}" >
                                <div class="changePhoneNumber btn btn-success col-4"
                                    style="padding: 0px 7.5px; cursor:pointer">
                                    (изменить)
                                </div>
                            </div>

                            <div class="row form-group d-flex justify-content-between align-items-center">
                                <div for="profileName" class="col-2">Тариф:</div>

                                <select profile-id="{{$profile->id}}" class="profileRate form-control form-inline col-5" name="rate"
                                    id="profileRate{{$loop->iteration}}">
                                    {{-- TODO роут для смены тарифа динамически --}}
                                    <option></option>
                                    @foreach($rates as $rate)
                                    <option value="{{$rate->id}}"
                                        {{$profile->rates->count() > 0 && $profile->rates->first()->id == $rate->id ? 'selected' : ''}}>
                                        {{ $rate->name }} {{ $rate->cost }} руб./сутки
                                    </option>
                                    @endforeach
                                </select>
                                <button class="ProfileRateButton btn btn-success col-4" style="padding: 0px 7.5px;" type="submit"
                                    style="padding: 0px 7.5px;" id="ProfileRateButton{{$loop->iteration}}">Изменить
                                    тариф</button>

                            </div>

                            <div>
                                @if($profile->is_published == 0 && $profile->allowed)
                                <form action="{{ route('user.profilepublish', $profile->id) }}" method="POST">
                                    @csrf
                                    @method('patch')
                                    <button class="btn btn-success" style="padding: 0px 7.5px;" type="submit"
                                        style="padding: 0px 7.5px;">Возобновить показ
                                        анкеты</button>
                                </form>
                                @elseif($profile->allowed == 0)
                                <p><strong>Ваша анкета на модерации, дождитесь ее окончания.</strong></p>
                                @elseif($profile->is_published == 1 && $profile->allowed)
                                <form action="{{ route('user.profileunpublish', $profile->id) }}" method="POST">
                                    @csrf
                                    @method('patch')
                                    <button class="btn btn-danger" style="padding: 0px 7.5px;" type="submit"
                                        style="padding: 0px 7.5px;">Остановить показ
                                        анкеты</button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <hr class="mt-3">
            @endforeach
        </div>

        <button class="btn btn-primary btn-block mt-2 admin-profile-choose" type="button" data-toggle="collapse"
            data-target="#on_moderate">
            Анкеты на проверке ({{ $profiles->where('allowed', '0')->count() }} шт.)
        </button>
        <div class="collapse" id="on_moderate">
            @foreach($profiles->where('allowed', '0') as $profile)
            <div class="row">
                <div class="col-md-2">
                    <img class="img-fluid" style="max-width:52%"
                        src="{{ asset('/images/profiles/images/created/' . $profile->main_image )}}"
                        alt="{{$profile->name}}">
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-8 d-flex justify-content-between">
                            <h5 style="line-height: 1.5;margin: 0;margin-right: 1rem;">{{$profile->name}}</h5>
                            <a href="{{ route('user.profiles.edit', $profile->id)}}"
                                style="padding: 2px 0.5px; display:block; color: #6c030e;">
                                <i class="fas fa-pencil-alt"></i> Редактировать анкету
                            </a>
                        </div>

                        <div class="col d-flex justify-content-end align-items-baseline">
                            @if($profile->verified)
                            <a class="nc-point" href="#"><img style="width: 65%;"
                                    src=" {{asset('images/approved.png')}}" alt="Подтверждена"></a>
                            @endif
                            @if($profile->apartments)
                            <a class="nc-point" href="#"><img style="width: 65%;"
                                    src="{{asset('images/apartments.png')}}" alt="Апартаменты"></a>
                            @endif
                            @if($profile->check_out)
                            <a class="nc-point" href="#"><img style="width: 65%;" src="{{asset('images/car.png')}}"
                                    alt="Выезд"></a>
                            @endif
                        </div>
                        <div class="col">
                            <form action="{{route('user.profiles.destroy', $profile->id)}}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" style="padding: 0px 7.5px;">
                                    <i class="fa fa-times" aria-hidden="true"></i> Удалить
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-md-12">
                            <div class="row form-group d-flex justify-content-between align-items-center">
                                <div class="col-2" for="profileName">Телефон:</div>
                                {{-- TODO роут для динамической смены телефона --}}

                                <input type="text" class="profilePhone form-control col-5" value="{{$profile->phone}}"
                                    id="profilePhone{{$loop->iteration}}" >
                                <div class="changePhoneNumber btn btn-success col-4"
                                    style="padding: 0px 7.5px; cursor:pointer">
                                    (изменить)
                                </div>
                            </div>

                            <div class="row form-group d-flex justify-content-between align-items-center">
                                <div for="profileName" class="col-2">Тариф:</div>

                                <select profile-id="{{$profile->id}}" class="profileRate form-control form-inline col-5" name="rate"
                                    id="profileRate{{$loop->iteration}}">
                                    {{-- TODO роут для смены тарифа динамически --}}
                                    <option></option>
                                    @foreach($rates as $rate)
                                    <option value="{{$rate->id}}"
                                        {{$profile->rates->count() > 0 && $profile->rates->first()->id == $rate->id ? 'selected' : ''}}>
                                        {{ $rate->name }} {{ $rate->cost }} руб./сутки
                                    </option>
                                    @endforeach
                                </select>
                                <button class="ProfileRateButton btn btn-success col-4" style="padding: 0px 7.5px;" type="submit"
                                    style="padding: 0px 7.5px;" id="ProfileRateButton{{$loop->iteration}}">Изменить
                                    тариф</button>

                            </div>

                            <div>
                                @if($profile->is_published == 0 && $profile->allowed)
                                <form action="{{ route('user.profilepublish', $profile->id) }}" method="POST">
                                    @csrf
                                    @method('patch')
                                    <button class="btn btn-success" style="padding: 0px 7.5px;" type="submit"
                                        style="padding: 0px 7.5px;">Возобновить показ
                                        анкеты</button>
                                </form>
                                @elseif($profile->allowed == 0)
                                <p><strong>Ваша анкета на модерации, дождитесь ее окончания.</strong></p>
                                @elseif($profile->is_published == 1 && $profile->allowed)
                                <form action="{{ route('user.profileunpublish', $profile->id) }}" method="POST">
                                    @csrf
                                    @method('patch')
                                    <button class="btn btn-danger" style="padding: 0px 7.5px;" type="submit"
                                        style="padding: 0px 7.5px;">Остановить показ
                                        анкеты</button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <hr class="mt-3">
            @endforeach
        </div>
    </div>

</div>

@endsection

@section('script')

@endsection