@extends('adminlte::page')

@section('title', 'Мои покупки')

@section('content_header')
    <h1>Мои покупки</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

        <table class="table table-bordered table-hover">

            <thead>
                <tr>
                    <th>Товар</th>
                    <th>Цена</th>
                    <th>Дата покупки</th>
                    <th>Статус</th>
                    <th>Действие</th>
                </tr>
            </thead>

            <tbody>

            @forelse($purchases as $purchase)

                <tr>

                    <td>
                        {{ $purchase->shopItem->title }}
                    </td>

                    <td>
                        {{ $purchase->shopItem->price }} 🪙
                    </td>

                    <td>
                        {{ $purchase->created_at->format('d.m.Y H:i') }}
                    </td>

                    <td>

                        @if($purchase->used)

                            <span class="badge badge-success">
                                Использовано
                            </span>

                        @else

                            <span class="badge badge-warning">
                                Ожидает
                            </span>

                        @endif

                    </td>

                    <td>

                        @if(!$purchase->used)

                            <form
                                action="{{ route('shop.use', $purchase) }}"
                                method="POST">

                                @csrf

                                <button class="btn btn-success btn-sm">
                                    Использовать
                                </button>

                            </form>

                        @else

                            <span class="text-muted">
                                —
                            </span>

                        @endif

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="5" class="text-center">
                        Покупок пока нет
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>
</div>

@stop