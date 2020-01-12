@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Промокоды</div>

                    <div class="card-body">
                        <a href="{{ route('admin.promotionals.create')  }}" type="button" class="btn btn-primary">Создать новый промокод</a>
                        @forelse ($promotionals as $promotional)
                            <li>
                            <a href="@if (!$promotional->is_active) route('user.promotionals.edit', $promotional->id) @endif" >{{ $promotionals->code }}, Сумма к пополнению: {{ $promotionals->replenish_summ }}</a>
                                Обновлено {{ $promotional->updated_at }}
                            
                                @if($promotional->is_active)
                                    <span style="color: red">уже активирован !</span>
                                @else
                                    <form action="{{ route('admin.promotionals.destroy') }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger">Удалить тариф</button>  
                                    </form>
                                @endif
                            </li>
                        @empty
                            <p>Нет созданных промокодов</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
