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
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ asset('/images/profiles/images/created' . $profile->main_image )}}" alt="{{$profile->name}}">
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-8 d-flex justify-content-between">
                            <h4>{{$profile->name}}</h4>
                            <a href="{{ route('user.profiles.edit', $profile->id)}}" class="btn btn-success" style="padding: 0px 7.5px; display:block">
                                <i class="fa fa-pencil" aria-hidden="true"></i>Анкета
                            </a>
                        </div>
                        
                        <div class="col-md-4 d-flex justify-content-between align-items-baseline">
                            @if($profile->verified)
                                <a class="nc-point" href="#"><img src=" {{asset('images/approved.png')}}" alt="Подтверждена"></a>
                            @endif
                            @if($profile->apartments)
                                <a class="nc-point" href = "#" ><img src ="{{asset('images/apartments.png')}}" alt = "Апартаменты" ></a >
                            @endif
                            @if($profile->check_out)
                                <a class="nc-point" href = "#" ><img src ="{{asset('images/car.png')}}" alt = "Выезд" ></a >
                            @endif
                            <form action="{{route('user.profiles.destroy', $profile->id)}}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" style="padding: 0px 7.5px;">
                                    <i class="fa fa-times" aria-hidden="true"></i> Удалить
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="row justify-content-between">
                       
                       
                    </div>
                    <p><strong>Тариф: {{$profile->rates()->first() ? $profile->rates()->first()->name : 'не назначен' }}</strong></p>
                    <p>
                        <strong>
                            Телефон: <input type="text" value="{{$profile->phone}}" id="profilePhone{{$loop->iteration}}">
                            {{-- TODO роут для динамической смены телефона --}}
                            <span class="btn btn-success" style="padding: 0px 7.5px;">
                                (изменить)
                            </span>
                        </strong>
                    </p>
            
                    <div class="row justify-content-between">
                        <div class="col-md-7">
                            @if($profile->is_published == 0)
                            <form action="{{ route('user.profilepublish', $profile->id) }}" method="POST">
                                @csrf
                                @method('patch')
                                <button class="btn btn-success" style="padding: 0px 7.5px;" type="submit" style="padding: 0px 7.5px;">Возобновить показ
                                    анкеты</button>
                            </form>
                            @elseif($profile->allowed == 0)
                            <p><strong>Ваша анкета на модерации, дождитесь ее окончания.</strong></p>
                            @else
                            <form action="{{ route('user.profileunpublish', $profile->id) }}" method="POST">
                                @csrf
                                @method('patch')
                                <button class="btn btn-danger" style="padding: 0px 7.5px;" type="submit" style="padding: 0px 7.5px;">Остановить показ
                                    анкеты</button>
                            </form>
                            @endif
                        </div>
            
                        <div class="col-md-6">
                            <p>
                                <strong>
                                    Сменить тариф
                                </strong>
                                <div class="d-flex justify-content-start">
                                    <select class="form-control" style="width:100%" name="rate" id="profileRate{{$loop->iteration}}">
                                        {{-- TODO роут для смены тарифа динамически --}}
                                        <option></option>
                                        @foreach($rates as $rate)
                                        <option value="{{$rate->id}}"
                                            {{$profile->rates->count() > 0 && $profile->rates->first()->id == $rate->id ? 'selected' : ''}}>
                                            {{ $rate->name }} {{ $rate->cost }} руб./сутки
                                        </option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-success" style="padding: 0px 7.5px;" type="submit" style="padding: 0px 7.5px;" id="ProfileRateButton{{$loop->iteration}}" >Изменить тариф</button>
                                </div>
                                
                            </p>
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
                <div class="col-md-4">
                    <img src="{{ asset('/images/profiles/images/created' . $profile->main_image )}}" alt="{{$profile->name}}">
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-8 d-flex justify-content-between">
                            <h4>{{$profile->name}}</h4>
                            <a href="{{ route('user.profiles.edit', $profile->id)}}" class="btn btn-success" style="padding: 0px 7.5px; display:block">
                                <i class="fa fa-pencil" aria-hidden="true"></i>Анкета
                            </a>
                        </div>
                        
                        <div class="col-md-4 d-flex justify-content-between align-items-baseline">
                            @if($profile->verified)
                                <a class="nc-point" href="#"><img src=" {{asset('images/approved.png')}}" alt="Подтверждена"></a>
                            @endif
                            @if($profile->apartments)
                                <a class="nc-point" href = "#" ><img src ="{{asset('images/apartments.png')}}" alt = "Апартаменты" ></a >
                            @endif
                            @if($profile->check_out)
                                <a class="nc-point" href = "#" ><img src ="{{asset('images/car.png')}}" alt = "Выезд" ></a >
                            @endif
                            <form action="{{route('user.profiles.destroy', $profile->id)}}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" style="padding: 0px 7.5px;">
                                    <i class="fa fa-times" aria-hidden="true"></i> Удалить
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="row justify-content-between">
                       
                       
                    </div>
                    <p><strong>Тариф: {{$profile->rates()->first() ? $profile->rates()->first()->name : 'не назначен' }}</strong></p>
                    <p>
                        <strong>
                            Телефон: <input type="text" value="{{$profile->phone}}" id="profilePhone{{$loop->iteration}}">
                            {{-- TODO роут для динамической смены телефона --}}
                            <span class="btn btn-success" style="padding: 0px 7.5px;">
                                (изменить)
                            </span>
                        </strong>
                    </p>
            
                    <div class="row justify-content-between">
                        <div class="col-md-7">
                            @if($profile->is_published == 0)
                            <form action="{{ route('user.profilepublish', $profile->id) }}" method="POST">
                                @csrf
                                @method('patch')
                                <button class="btn btn-success" style="padding: 0px 7.5px;" type="submit" style="padding: 0px 7.5px;">Возобновить показ
                                    анкеты</button>
                            </form>
                            @elseif($profile->allowed == 0)
                            <p><strong>Ваша анкета на модерации, дождитесь ее окончания.</strong></p>
                            @else
                            <form action="{{ route('user.profileunpublish', $profile->id) }}" method="POST">
                                @csrf
                                @method('patch')
                                <button class="btn btn-danger" style="padding: 0px 7.5px;" type="submit" style="padding: 0px 7.5px;">Остановить показ
                                    анкеты</button>
                            </form>
                            @endif
                        </div>
            
                        <div class="col-md-6">
                            <p>
                                <strong>
                                    Сменить тариф
                                </strong>
                                <div class="d-flex justify-content-start">
                                    <select class="form-control" style="width:100%" name="rate" id="profileRate{{$loop->iteration}}">
                                        {{-- TODO роут для смены тарифа динамически --}}
                                        <option></option>
                                        @foreach($rates as $rate)
                                        <option value="{{$rate->id}}"
                                            {{$profile->rates->count() > 0 && $profile->rates->first()->id == $rate->id ? 'selected' : ''}}>
                                            {{ $rate->name }} {{ $rate->cost }} руб./сутки
                                        </option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-success" style="padding: 0px 7.5px;" type="submit" style="padding: 0px 7.5px;" id="ProfileRateButton{{$loop->iteration}}" >Изменить тариф</button>
                                </div>
                                
                            </p>
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
                <div class="col-md-4">
                    <img src="{{ asset('/images/profiles/images/created' . $profile->main_image )}}" alt="{{$profile->name}}">
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-8 d-flex justify-content-between">
                            <h4>{{$profile->name}}</h4>
                            <a href="{{ route('user.profiles.edit', $profile->id)}}" class="btn btn-success" style="padding: 0px 7.5px; display:block">
                                <i class="fa fa-pencil" aria-hidden="true"></i>Анкета
                            </a>
                        </div>
                        
                        <div class="col-md-4 d-flex justify-content-between align-items-baseline">
                            @if($profile->verified)
                                <a class="nc-point" href="#"><img src=" {{asset('images/approved.png')}}" alt="Подтверждена"></a>
                            @endif
                            @if($profile->apartments)
                                <a class="nc-point" href = "#" ><img src ="{{asset('images/apartments.png')}}" alt = "Апартаменты" ></a >
                            @endif
                            @if($profile->check_out)
                                <a class="nc-point" href = "#" ><img src ="{{asset('images/car.png')}}" alt = "Выезд" ></a >
                            @endif
                            <form action="{{route('user.profiles.destroy', $profile->id)}}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" style="padding: 0px 7.5px;">
                                    <i class="fa fa-times" aria-hidden="true"></i> Удалить
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="row justify-content-between">
                       
                       
                    </div>
                    <p><strong>Тариф: {{$profile->rates()->first() ? $profile->rates()->first()->name : 'не назначен' }}</strong></p>
                    <p>
                        <strong>
                            Телефон: <input type="text" value="{{$profile->phone}}" id="profilePhone{{$loop->iteration}}">
                            {{-- TODO роут для динамической смены телефона --}}
                            <span class="btn btn-success" style="padding: 0px 7.5px;">
                                (изменить)
                            </span>
                        </strong>
                    </p>
            
                    <div class="row justify-content-between">
                        <div class="col-md-7">
                            @if($profile->is_published == 0)
                            <form action="{{ route('user.profilepublish', $profile->id) }}" method="POST">
                                @csrf
                                @method('patch')
                                <button class="btn btn-success" style="padding: 0px 7.5px;" type="submit" style="padding: 0px 7.5px;">Возобновить показ
                                    анкеты</button>
                            </form>
                            @elseif($profile->allowed == 0)
                            <p><strong>Ваша анкета на модерации, дождитесь ее окончания.</strong></p>
                            @else
                            <form action="{{ route('user.profileunpublish', $profile->id) }}" method="POST">
                                @csrf
                                @method('patch')
                                <button class="btn btn-danger" style="padding: 0px 7.5px;" type="submit" style="padding: 0px 7.5px;">Остановить показ
                                    анкеты</button>
                            </form>
                            @endif
                        </div>
            
                        <div class="col-md-6">
                            <p>
                                <strong>
                                    Сменить тариф
                                </strong>
                                <div class="d-flex justify-content-start">
                                    <select class="form-control" style="width:100%" name="rate" id="profileRate{{$loop->iteration}}">
                                        {{-- TODO роут для смены тарифа динамически --}}
                                        <option></option>
                                        @foreach($rates as $rate)
                                        <option value="{{$rate->id}}"
                                            {{$profile->rates->count() > 0 && $profile->rates->first()->id == $rate->id ? 'selected' : ''}}>
                                            {{ $rate->name }} {{ $rate->cost }} руб./сутки
                                        </option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-success" style="padding: 0px 7.5px;" type="submit" style="padding: 0px 7.5px;" id="ProfileRateButton{{$loop->iteration}}" >Изменить тариф</button>
                                </div>
                                
                            </p>
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