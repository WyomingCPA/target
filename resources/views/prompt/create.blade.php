@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-keyboard mr-2"></i>
            Добавить промт
        </h3>
    </div>

    <form method="POST" action="{{ route('prompt.store') }}">
        @csrf

        <div class="card-body">

            <div class="form-group">
                <label>Название промта</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Категория (опционально)</label>
                <input type="text" name="category" class="form-control">
            </div>

            <div class="form-group">
                <label>Текст промта</label>
                <textarea name="content" class="form-control" rows="5" required></textarea>
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('prompt.main') }}" class="btn btn-secondary ml-2">Отмена</a>
        </div>

    </form>
</div>

@stop