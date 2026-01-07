@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@section('content')
<div class="card card-primary">
  <div class="card-header">
    <h3 class="card-title">
      <i class="fas fa-folder mr-2"></i>
      Добавление проекта
    </h3>
  </div>

  <form method="POST" action="{{ route('project.store') }}">
    @csrf

    <div class="card-body">

      <!-- Название -->
      <div class="form-group">
        <label for="title">Название проекта</label>
        <input
          type="text"
          name="title"
          id="title"
          class="form-control"
          placeholder="Например: Grid-бот на Binance"
          value="{{ old('title') }}"
          required
        >
      </div>

      <!-- Описание -->
      <div class="form-group">
        <label for="description">Описание проекта</label>
        <textarea
          name="description"
          id="description"
          class="form-control"
          rows="4"
          placeholder="Что должен делать проект и какой результат ожидается"
        >{{ old('description') }}</textarea>
      </div>

      <!-- Привязка к цели -->
      <div class="form-group">
        <label for="goal_id">Цель</label>
        <select name="goal_id" id="goal_id" class="form-control">
          <option value="">Без цели</option>

          @foreach($goals as $item)
            <option value="{{ $item->id }}"
              {{ old('goal_id') == $item->id ? 'selected' : '' }}>
              {{ $item->title }}
            </option>
          @endforeach

        </select>
      </div>

      <!-- Tech stack -->
      <div class="form-group">
        <label for="tech_stack">Стек технологий</label>
        <input
          type="text"
          name="tech_stack[]"
          class="form-control"
          placeholder="laravel, redis, postgres"
        >
        <small class="form-text text-muted">
          Можно расширить мультиинпутом или тегами
        </small>
      </div>

      <!-- Статус -->
      <div class="form-group">
        <label for="status">Статус</label>
        <select name="status" id="status" class="form-control">
          <option value="active" selected>Активный</option>
          <option value="paused">На паузе</option>
          <option value="done">Завершён</option>
        </select>
      </div>

    </div>

    <div class="card-footer">
      <button type="submit" class="btn btn-primary">
        <i class="fas fa-save mr-1"></i>
        Сохранить проект
      </button>

      <a href="{{ route('project.main') }}" class="btn btn-secondary ml-2">
        Отмена
      </a>
    </div>

  </form>
</div>

@stop