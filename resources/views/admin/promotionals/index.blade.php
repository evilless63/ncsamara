{{-- @extends('layouts.admin') --}}
@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (!empty(session('success')))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
                    @if($promotionals->count())
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Сумма к пополнению</th>
                                <th scope="col">Код</th>
                                <th scope="col">Статус</th>
                                <th scope="col">Действия</th>
                            </tr>
                        </thead>
                        @forelse ($promotionals as $promotional)


                        <tbody>
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $promotional->replenish_summ }}</td>
                                <td><a
                                        href="
                                        @if (!$promotional->is_activated)
                                        {{ route('admin.promotionals.edit', $promotional->id) }}
                                        @endif
                                        ">{{ $promotional->code }}</a>
                                </td>
                                <td>
                                    @if($promotional->is_activated)
                                    <span style="color: red">уже активирован !</span>
                                    @else
                                    <span style="color: green">не активирован !</span>
                                    @endif
                                </td>
                                <td>
                                    @if($promotional->is_activated != 1)
                                    <form action="{{ route('admin.promotionals.destroy', $promotional->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger">Удалить промокод</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                        @empty
                        @endforelse
                        
                    </table>
                    @else
                        <p>Нет созданных промокодов</p>
                    @endif
                </div>

</div>
@endsection
