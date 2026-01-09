@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-lightbulb mr-2"></i>
            Добавить идею
        </h3>
    </div>

    <form method="POST" action="{{ route('idea.store') }}">
        @csrf

        <div class="card-body">

            <div class="form-group">
                <label>Название</label>
                <input type="text"
                    name="title"
                    class="form-control"
                    required>
            </div>

            <div class="form-group">
                <label>Описание</label>
                <textarea name="description"
                    class="form-control"
                    rows="4"></textarea>
            </div>

            <div class="form-group">
                <label>Источник</label>
                <select name="source" class="form-control">
                    <option value="">—</option>
                    <option value="telegram">Telegram</option>
                    <option value="chatgpt">ChatGPT</option>
                    <option value="мысль">Мысль</option>
                </select>
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('idea.main') }}" class="btn btn-secondary ml-2">Отмена</a>
        </div>

    </form>
</div>

@stop