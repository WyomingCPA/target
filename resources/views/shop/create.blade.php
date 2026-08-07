@extends('adminlte::page')

@section('title', 'Добавить товар')

@section('content_header')
    <h1>Добавить товар</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('shop.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Название</label>

                <input
                    type="text"
                    name="title"
                    class="form-control"
                    required>
            </div>

            <div class="form-group">
                <label>Цена (коинов)</label>

                <input
                    type="number"
                    name="price"
                    class="form-control"
                    required>
            </div>

            <div class="form-check mb-3">
                <input
                    class="form-check-input"
                    type="checkbox"
                    name="repeatable"
                    value="1"
                    id="repeatable">

                <label class="form-check-label" for="repeatable">
                    Можно покупать несколько раз
                </label>
            </div>

            <button class="btn btn-success">
                Сохранить
            </button>

        </form>

    </div>
</div>

@stop