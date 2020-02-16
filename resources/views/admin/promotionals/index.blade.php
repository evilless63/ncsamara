{{-- @extends('layouts.admin') --}}
@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
                    @if($promotionals->count())
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Сумма к пополнению</th>
                                <th scope="col">Код</th>
                                <th scope="col">#</th>
                            </tr>
                        </thead>
                        @forelse ($promotionals as $promotional)


                        <tbody>
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $promotional->replenish_summ }}</td>
                                <td><a
                                        href="
                                        @if (!$promotional->is_active)
                                        {{ route('admin.promotionals.edit', $promotional->id) }}
                                        @endif
                                        ">{{ $promotional->code }}</a>
                                </td>
                                <td>
                                    @if($promotional->is_active)
                                    <span style="color: red">уже активирован !</span>
                                    @else
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
