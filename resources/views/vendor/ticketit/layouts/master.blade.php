@extends('layouts.app')

@section('content')
    @include('ticketit::shared.header')

    <div class="container mt-4">
        <div class="">
            <div class="">
                @include('ticketit::shared.nav')
            </div>
        </div>
        @if(View::hasSection('ticketit_content'))
            <div class="">
                <h5 class=" d-flex justify-content-between align-items-baseline flex-wrap">
                    @if(View::hasSection('page_title'))
                        <span>@yield('page_title')</span>
                    @else
                        <span>@yield('page')</span>
                    @endif

                    @yield('ticketit_header')
                </h5>
                <div class=" @yield('ticketit_content_parent_class')">
                    @yield('ticketit_content')
                </div>
            </div>
        @endif
        @yield('ticketit_extra_content')
    </div>
@stop
