@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@section('content')
<div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-edit mr-2"></i>
            Редактирование идеи
        </h3>
    </div>

    <form method="POST" action="{{ route('idea.update', $idea->id) }}">
        @csrf

        <div class="card-body">

            <div class="form-group">
                <label>Название</label>
                <input type="text"
                    name="title"
                    class="form-control"
                    value="{{ old('title', $idea->title) }}"
                    required>
            </div>

            <div class="form-group">
                <label>Описание</label>
                <textarea name="description"
                    class="form-control"
                    rows="4">{{ old('description', $idea->description) }}</textarea>
            </div>

            <div class="form-group">
                <label>Источник</label>
                <select name="source" class="form-control">
                    <option value="">—</option>
                    <option value="telegram" {{ $idea->source == 'telegram' ? 'selected' : '' }}>Telegram</option>
                    <option value="chatgpt" {{ $idea->source == 'chatgpt' ? 'selected' : '' }}>ChatGPT</option>
                    <option value="мысль" {{ $idea->source == 'мысль' ? 'selected' : '' }}>Мысль</option>
                </select>
            </div>

            <div class="form-check">
                <input type="checkbox"
                    name="converted"
                    class="form-check-input"
                    value="1"
                    {{ $idea->converted ? 'checked' : '' }}>
                <label class="form-check-label">
                    Идея конвертирована
                </label>
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-warning">Сохранить</button>
            <a href="{{ route('idea.main') }}" class="btn btn-secondary ml-2">Отмена</a>
        </div>

    </form>
</div>

@stop