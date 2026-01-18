@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $task->title }}</h3>

        <div class="card-tools">
            <a href="{{ route('task.edit', $task->id) }}"
                class="btn btn-sm btn-warning">
                <i class="fas fa-edit"></i>
            </a>
        </div>
    </div>
    <hr>

    <div class="card-body">

        <p>{{ $task->description }}</p>

        <hr>
        @if($total > 0)
        <div class="mb-3">
            <small class="text-muted">
                Выполнено {{ $done }} из {{ $total }}
            </small>

            <div class="progress">
                <div class="progress-bar
            {{ $progress == 100 ? 'bg-success' : 'bg-info' }}"
                    role="progressbar"
                    style="width: {{ $progress }}%">
                    {{ $progress }}%
                </div>
            </div>
        </div>
        @endif
        <h5>Подзадачи</h5>

        <form method="POST" action="{{ route('task.store-parent') }}">
            @csrf

            <input type="hidden" name="parent_id" value="{{ $task->id }}">

            <div class="input-group mb-3">
                <input type="text"
                    name="title"
                    class="form-control"
                    placeholder="Новая подзадача"
                    required>

                <div class="input-group-append">
                    <button class="btn btn-outline-primary">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
        </form>
        @foreach($task->subtasks as $subtask)
        <div class="d-flex align-items-center justify-content-between mb-2">

            {{-- Toggle --}}
            <form method="POST"
                action="{{ route('task.toggle', $subtask->id) }}">
                @csrf
                <input type="checkbox"
                    onchange="this.form.submit()"
                    {{ $subtask->status === 'done' ? 'checked' : '' }}>
            </form>

            {{-- Title --}}
            <span class="flex-grow-1 ml-2
        {{ $subtask->status === 'done' ? 'text-muted text-decoration-line-through' : '' }}">
                {{ $subtask->title }}
            </span>

            {{-- Actions --}}
            <div class="btn-group btn-group-sm ml-2">

                {{-- Edit --}}
                <a href="{{ route('subtask.edit', $subtask->id) }}"
                    class="btn btn-warning"
                    title="Редактировать">
                    <i class="fas fa-edit"></i>
                </a>
                <form method="POST"
                    action="{{ route('subtask.copy', $subtask->id) }}"
                    style="display:inline">
                    @csrf
                    <button class="btn btn-sm btn-outline-secondary"
                        title="Копировать подзадачу">
                        <i class="fas fa-copy"></i>
                    </button>
                </form>
                <form method="POST"
                    action="{{ route('subtask.promote', $subtask->id) }}"
                    onsubmit="return confirm('Преобразовать в задачу?')">
                    @csrf
                    <button class="btn btn-sm btn-outline-primary" title="Преобразовать в задачу">
                        <i class="fas fa-level-up-alt"></i>
                    </button>
                </form>
                {{-- Delete --}}
                <form method="POST"
                    action="{{ route('task.delete', $subtask->id) }}"
                    onsubmit="return confirm('Удалить подзадачу?')">
                    @csrf
                    <button class="btn btn-danger" title="Удалить">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>

            </div>
        </div>
        @endforeach

    </div>
</div>
@stop