@extends('layouts.site')

@section('content')
    <div class="container mt-3" style="min-height: 900px;">
        
        <div class="row">
        @foreach($salons as $salon)
            <div class="col-md-6 col-sm-12 mt-3 salonWrapper">
                <p class="salonName">{{ $salon->name }} @if($salon->min_price <> null) | от {{$salon->min_price}} руб @endif</p>
                <img src="{{asset('/images/salons/created/2.png')}}" class="img-fluid">
                <p class="salonPhone">{{ $salon->phone }}</p>
            </div>
        
            @if($loop->iteration % 2 == 0)
            </div>
            <div class="row">
            @endif
        @endforeach
        </div>
    </div>
@endsection
