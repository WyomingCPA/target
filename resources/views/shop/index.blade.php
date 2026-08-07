@extends('adminlte::page')

@section('title', 'Магазин')

@section('content_header')
<h1>Магазин</h1>
@stop

@section('content')

<a href="{{ route('shop.create') }}" class="btn btn-primary mb-3">
    Добавить товар
</a>

<div class="card">
    <div class="card-body">

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Цена</th>
                    <th>Повторяемый</th>
                    <th>Действия</th>
                </tr>
            </thead>

            <tbody>

                @foreach($items as $item)

                <tr>

                    <td>{{ $item->id }}</td>

                    <td>{{ $item->title }}</td>

                    <td>{{ $item->price }} 🪙</td>

                    <td>
                        @if($item->repeatable)
                        Да
                        @else
                        Нет
                        @endif
                    </td>

                    <td>
                        <form
                            action="{{ route('shop.buy', $item) }}"
                            method="POST"
                            style="display:inline">

                            @csrf
                            <button
                                class="btn btn-sm btn-success"
                                onclick="return confirm('Купить?')">
                                Купить
                            </button>

                        </form>

                        <a href="{{ route('shop.edit', $item) }}"
                            class="btn btn-sm btn-warning">
                            Изменить
                        </a>

                        <form
                            action="{{ route('shop.delete', $item) }}"
                            method="POST"
                            style="display:inline">

                            @csrf
                            <button
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Удалить?')">
                                Удалить
                            </button>

                        </form>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>
</div>

@stop