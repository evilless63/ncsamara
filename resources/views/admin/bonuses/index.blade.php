@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Бонусы</div>

                    <div class="card-body">
                        <a href="{{ route('admin.bonuses.create')  }}" type="button" class="btn btn-primary">Создать новый бонус</a>
                        @forelse ($bonuses as $bonus)
                            <li>
                            <a href="{{ route('admin.bonuses.edit', $bonus->id) }}" >Минимум: {{ $bonus->min_sum }}, Максимум: {{ $bonus->max_sum }}, Коэффициэнт бонуса: {{ $bonus->koef }}</a>
                                Обновлено {{ $bonus->updated_at }}
                            
                               
                                    <form action="{{ route('admin.bonuses.destroy', $bonus->id) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger">Удалить тариф</button>  
                                    </form>
                             
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