@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-bullseye mr-2"></i>
            Создание цели
        </h3>
    </div>

    <form method="POST" action="{{ route('goal.store') }}">
        @csrf

        <div class="card-body">

            <!-- Название -->
            <div class="form-group">
                <label for="title">Название цели</label>
                <input
                    type="text"
                    name="title"
                    id="title"
                    class="form-control"
                    placeholder="Например: Запустить SaaS"
                    required>
            </div>

            <!-- Описание -->
            <div class="form-group">
                <label for="description">Описание</label>
                <textarea
                    name="description"
                    id="description"
                    class="form-control"
                    rows="4"
                    placeholder="Опиши, зачем эта цель и какой результат считаешь успехом"></textarea>
            </div>

            <!-- Приоритет -->
            <div class="form-group">
                <label for="priority">Приоритет</label>
                <select name="priority" id="priority" class="form-control">
                    <option value="1">🔥 Высокий</option>
                    <option value="2">⚡ Средний</option>
                    <option value="3" selected>🧘 Низкий</option>
                </select>
            </div>

            <!-- Статус -->
            <div class="form-group">
                <label for="status">Статус</label>
                <select name="status" id="status" class="form-control">
                    <option value="active" selected>Активная</option>
                    <option value="frozen">На паузе</option>
                    <option value="done">Завершена</option>
                </select>
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-1"></i>
                Сохранить цель
            </button>

            <a href="{{ route('goal.main') }}" class="btn btn-secondary ml-2">
                Отмена
            </a>
        </div>

    </form>
</div>

@stop