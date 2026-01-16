@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@section('content')

<div class="container-fluid">

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                {{ $isSubtask ? 'Редактирование подзадачи' : 'Редактирование задачи' }}
            </h3>
        </div>

        <form method="POST" action="{{ route('subtask.update', $task->id) }}">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Название</label>
                    <input type="text"
                        name="title"
                        class="form-control"
                        value="{{ old('title', $task->title) }}"
                        required>
                </div>
            </div>

            <div class="card-footer text-end">
                <button class="btn btn-primary">
                    <i class="fas fa-save"></i> Сохранить
                </button>
                <a href="{{ route('task.show', $task->parent_id) }}" class="btn btn-secondary">
                    Отмена
                </a>
            </div>
        </form>
    </div>

</div>
@stop