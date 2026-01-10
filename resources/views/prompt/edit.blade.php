@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@section('content')
<div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-edit mr-2"></i> Редактирование промта
        </h3>
    </div>

    <form method="POST" action="{{ route('prompt.update', $prompt->id) }}">
        @csrf
        <div class="card-body">

            <div class="form-group">
                <label>Название</label>
                <input type="text"
                    name="title"
                    class="form-control"
                    value="{{ $prompt->title }}">
            </div>

            <div class="form-group">
                <label>Категория</label>
                <input type="text"
                    name="category"
                    class="form-control"
                    value="{{ $prompt->category }}">
            </div>

            <div class="form-group">
                <label>Промт</label>
                <textarea name="content"
                    rows="6"
                    class="form-control">{{ $prompt->content }}</textarea>
            </div>

        </div>

        <div class="card-footer">
            <button class="btn btn-warning">Сохранить</button>
            <a href="{{ route('prompt.main') }}" class="btn btn-secondary ml-2">
                Назад
            </a>
        </div>

    </form>
</div>

@stop