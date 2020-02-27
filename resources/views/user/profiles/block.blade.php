@section('profile-block-info')
<div class="row">
    <div class="col-md-4">
        <img src="{{ asset('/images/profiles/images/created' . $profile->main_image )}}" alt="{{$profile->name}}">
    </div>
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-8">
                <h4>$profile->name</h4>
            </div>
            <div class="col-md-4 d-flex justify-content-between align-items-baseline">
                {{ $profile->verified ? '<a class="nc-point" href="#"><img src="images/approved.png" alt="Подтверждена"></a>' : '' }}
                {{ $profile->apartments ? '<a class="nc-point" href = "#" ><img src = "images/apartments.png" alt = "Апартаменты" ></a >' : ''}}
                {{ $profile->check_out ? '<a class="nc-point" href = "#" ><img src = "images/car.png" alt = "Выезд" ></a >' : ''}}
            </div>
        </div>
        <div class="row justify-content-between">
            <a href="{{ route('user.profile.edit', $profile->id)}}" class="btn btn-success">
                <i class="fa fa-pencil" aria-hidden="true"></i>Анкета
            </a>
            <form action="{{route('user.profile.delete'), $profile->id}}">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">
                    <i class="fa fa-times" aria-hidden="true"></i>Удалить
                </button>
            </form>
        </div>
        <p><strong>Тариф: {{$profile->rates()->first() ? $profile->rates()->first() : 'не назначен' }}</strong></p>
        <p>
            <strong>
                Телефон: <input type="text" value="{{$profile->phone}}" id="profilePhone">
                {{-- TODO роут для динамической смены телефона --}}
                <span class="btn btn-success">
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
                    <button class="btn btn-success" style="padding: 0px 7.5px;" type="submit">Возобновить показ
                        анкеты</button>
                </form>
                @elseif($profile->allowed == 0)
                <p><strong>Ваша анкета на модерации, дождитесь ее окончания.</strong></p>
                @else
                <form action="{{ route('user.profileunpublish', $profile->id) }}" method="POST">
                    @csrf
                    @method('patch')
                    <button class="btn btn-danger" style="padding: 0px 7.5px;" type="submit">Остановить показ
                        анкеты</button>
                </form>
                @endif
            </div>

            <div class="col-md-6">
                <p>
                    <strong>
                        Сменить тариф
                    </strong>
                    <select class="form-control" style="width:100%" name="rate" id="profileRate">
                        {{-- TODO роут для смены тарифа динамически --}}
                        <option></option>
                        @foreach($rates as $rate)
                        <option value="{{$rate->id}}"
                            {{$profile->rates->count() > 0 && $profile->rates->first()->id == $rate->id ? 'selected' : ''}}>
                            {{ $rate->name }} {{ $rate->cost }} руб./сутки
                        </option>
                        @endforeach
                    </select>
                </p>
            </div>
        </div>

    </div>
</div>
@endsection