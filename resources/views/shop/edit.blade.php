@extends('adminlte::page')

@section('title', 'Редактирование товара')

@section('content_header')
<h1>Редактирование товара</h1>
@stop

@section('content')

<div class="card">

    <div class="card-header">
        <h3 class="card-title">
            {{ $item->name }}
        </h3>
    </div>

    <form action="{{ route('shop.update', ['item' => $item->id]) }}" method="POST">

        @csrf
        <div class="card-body">

            <div class="form-group">
                <label>Название</label>

                <input
                    type="text"
                    name="title"
                    class="form-control"
                    value="{{ old('name', $item->title) }}"
                    required>
            </div>

            <div class="form-group">
                <label>Цена в коинах</label>

                <input
                    type="number"
                    name="price"
                    class="form-control"
                    value="{{ old('price', $item->price) }}"
                    min="0"
                    required>
            </div>

        </div>

        <div class="card-footer">

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                Обновить
            </button>

            <a href="{{ route('shop.main') }}"
                class="btn btn-secondary">
                Отмена
            </a>

        </div>

    </form>

</div>

@stop