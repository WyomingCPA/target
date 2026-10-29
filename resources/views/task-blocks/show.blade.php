@extends('adminlte::page')

@section('title', $taskBlock->title)

@section('content_header')
<h1>{{ $taskBlock->title }}</h1>
@stop

@section('content')

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Настройки блока</h3>
    </div>

    <form method="POST"
        action="{{ route('task-blocks.update', $taskBlock) }}">
        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="form-group">
                <label>Название</label>
                <input type="text" name="title"
                    class="form-control"
                    value="{{ old('title', $taskBlock->title) }}"
                    required>
            </div>

            <div class="form-group">
                <label>Описание</label>
                <textarea name="description"
                    class="form-control"
                    rows="2">{{ old('description', $taskBlock->description) }}</textarea>
            </div>
        </div>

        <div class="card-footer">
            <button class="btn btn-primary btn-sm">
                Сохранить
            </button>
        </div>
    </form>
</div>

<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Добавить существующие задачи</h3>
    </div>

    <form method="POST"
        action="{{ route('task-blocks.tasks.attach', $taskBlock) }}">
        @csrf

        <div class="card-body">
            @if($availableTasks->isEmpty())
            <p class="text-muted mb-0">
                Все существующие задачи уже добавлены в этот блок.
            </p>
            @else
            <div class="form-group">
                <label>Выбери задачи (можно несколько)</label>

                <select name="task_ids[]"
                    class="form-control"
                    multiple
                    size="8"
                    required>
                    @foreach($availableTasks as $task)
                    <option value="{{ $task->id }}">
                        {{ $task->parent?->title ?? 'Без родительской задачи' }}
                        → {{ $task->title }}
                    </option>
                    @endforeach
                </select>

                <small class="form-text text-muted">
                    Удерживай Ctrl (Windows) или Cmd (Mac),
                    чтобы выбрать несколько задач.
                </small>
            </div>

            <button class="btn btn-success">
                Добавить в блок
            </button>
            @endif
        </div>
    </form>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Задачи блока</h3>
    </div>

    <div class="card-body p-0">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Задача</th>
                    <th>Проект</th>
                    <th>Статус</th>
                    <th style="width: 100px">Действия</th>
                </tr>
            </thead>

            <tbody>
                @forelse($taskBlock->tasks as $task)
                <tr>
                    <td>
                        {{ $task->title }}
                        <small class="text-muted">
                            #{{ $task->parent?->title ?? 'Без родительской задачи' }}
                        </small>
                    </td>

                    <td>
                        {{ $task->project?->title ?? 'Без проекта' }}
                    </td>

                    <td>
                        @if($task->status === 'done')
                        <span class="badge badge-success">
                            Выполнено
                        </span>
                        @else
                        <span class="badge badge-secondary">
                            {{ $task->status }}
                        </span>
                        @endif
                    </td>

                    <td>
                        <form method="POST"
                            action="{{ route(
                                      'task-blocks.tasks.detach',
                                      [$taskBlock, $task]
                                  ) }}"
                            onsubmit="return confirm('Убрать задачу из блока?')">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-outline-danger btn-sm"
                                title="Убрать из блока">
                                <i class="fas fa-unlink"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">
                        В блоке пока нет задач.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<form method="POST"
    action="{{ route('task-blocks.destroy', $taskBlock) }}"
    onsubmit="return confirm('Удалить блок? Сами задачи сохранятся.')">
    @csrf
    @method('DELETE')

    <button class="btn btn-outline-danger">
        Удалить блок
    </button>

    <a href="{{ route('task-blocks.index') }}"
        class="btn btn-default">
        К списку блоков
    </a>
</form>

@stop