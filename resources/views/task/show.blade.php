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
        <form method="POST"
            action="{{ route('task.toggle', $subtask->id) }}"
            style="display:inline">
            @csrf
            <div class="form-check">
                <input class="form-check-input"
                    type="checkbox"
                    onchange="this.form.submit()"
                    {{ $subtask->status === 'done' ? 'checked' : '' }}>

                <label class="form-check-label">
                    {{ $subtask->title }}
                </label>
            </div>
        </form>
        @endforeach

    </div>
</div>
@stop