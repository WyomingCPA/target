@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@section('content')
<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-edit mr-2"></i>
            Редактирование цели
        </h3>
    </div>

    <form method="POST" action="{{ route('goal.update', $goal->id) }}">
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
                    value="{{ old('title', $goal->title) }}"
                    required>
            </div>

            <!-- Описание -->
            <div class="form-group">
                <label for="description">Описание</label>
                <textarea
                    name="description"
                    id="description"
                    class="form-control"
                    rows="4">{{ old('description', $goal->description) }}</textarea>
            </div>

            <!-- Приоритет -->
            <div class="form-group">
                <label for="priority">Приоритет</label>
                <select name="priority" id="priority" class="form-control">
                    <option value="1" {{ $goal->priority == 1 ? 'selected' : '' }}>🔥 Высокий</option>
                    <option value="2" {{ $goal->priority == 2 ? 'selected' : '' }}>⚡ Средний</option>
                    <option value="3" {{ $goal->priority == 3 ? 'selected' : '' }}>🧘 Низкий</option>
                </select>
            </div>

            <!-- Статус -->
            <div class="form-group">
                <label for="status">Статус</label>
                <select name="status" id="status" class="form-control">
                    <option value="active" {{ $goal->status == 'active' ? 'selected' : '' }}>Активная</option>
                    <option value="frozen" {{ $goal->status == 'frozen' ? 'selected' : '' }}>На паузе</option>
                    <option value="done" {{ $goal->status == 'done' ? 'selected' : '' }}>Завершена</option>
                </select>
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save mr-1"></i>
                Обновить цель
            </button>

            <a href="{{ route('goal.main') }}" class="btn btn-secondary ml-2">
                Отмена
            </a>
        </div>

    </form>
</div>

@stop