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

        <div class="markdown-body">
            {!! \Illuminate\Support\Str::markdown($task->description ?? '') !!}
        </div>

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
        @foreach($task->subtasks->where('status', '!=', 'done') as $subtask)
        <div class="d-flex align-items-center justify-content-between mb-2{{ $subtask->created_at->lt(now()->subDays(14)) ? 'bg-light border-left border-danger pl-2' : '' }}">

            {{-- Toggle --}}
            <form method="POST" action="{{ route('task.toggle', $subtask->id) }}">
                @csrf
                <input type="checkbox"
                    onchange="this.form.submit()"
                    {{ $subtask->status === 'done' ? 'checked' : '' }}>
            </form>

            {{-- Title + meta --}}
            <div class="flex-grow-1 ml-2">

                <div class="{{ $subtask->status === 'done' ? 'text-muted text-decoration-line-through' : '' }}">
                    {{ $subtask->title }}
                </div>

                {{-- Meta --}}
                <div class="text-muted small">
                    @php
                    $isOld = $subtask->created_at->lt(now()->subDays(3));
                    $isOpen = $subtask->status !== 'done';
                    @endphp

                    @if($isOld && $isOpen)
                    <span class="badge bg-danger ml-1">
                        {{ $subtask->created_at->diffInDays() }} дн
                    </span>
                    @endif
                    <span title="{{ $subtask->created_at }}">
                        ({{ $subtask->created_at->format('d.m.Y H:i') }})
                    </span>
                </div>
            </div>

            {{-- Actions --}}
            <div class="btn-group btn-group-sm ml-2">
                <a href="{{ route('subtask.edit', $subtask->id) }}"
                    class="btn btn-warning" title="Редактировать">
                    <i class="fas fa-edit"></i>
                </a>

                <form method="POST" action="{{ route('subtask.copy', $subtask->id) }}">
                    @csrf
                    <button class="btn btn-outline-secondary" title="Копировать">
                        <i class="fas fa-copy"></i>
                    </button>
                </form>

                <form method="POST"
                    action="{{ route('subtask.promote', $subtask->id) }}"
                    onsubmit="return confirm('Преобразовать в задачу?')">
                    @csrf
                    <button class="btn btn-outline-primary" title="Преобразовать в задачу">
                        <i class="fas fa-level-up-alt"></i>
                    </button>
                </form>

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
        <button class="btn btn-sm btn-outline-secondary mb-2"
            onclick="document.getElementById('done-subtasks').classList.toggle('d-none')">
            Показать выполненные
        </button>
        {{-- Выполненные --}}
        <div id="done-subtasks" class="d-none mt-2">
            <hr>
            <small class="text-muted">Выполненные</small>

            @foreach($task->subtasks->where('status','done') as $subtask)
            <div class="d-flex align-items-center justify-content-between mb-2{{ $subtask->created_at->lt(now()->subDays(14)) ? 'bg-light border-left border-danger pl-2' : '' }}">

                {{-- Toggle --}}
                <form method="POST" action="{{ route('task.toggle', $subtask->id) }}">
                    @csrf
                    <input type="checkbox"
                        onchange="this.form.submit()"
                        {{ $subtask->status === 'done' ? 'checked' : '' }}>
                </form>

                {{-- Title + meta --}}
                <div class="flex-grow-1 ml-2">

                    <div class="{{ $subtask->status === 'done' ? 'text-muted text-decoration-line-through' : '' }}">
                        {{ $subtask->title }}
                    </div>

                    {{-- Meta --}}
                    <div class="text-muted small">
                        @php
                        $isOld = $subtask->created_at->lt(now()->subDays(3));
                        $isOpen = $subtask->status !== 'done';
                        @endphp

                        @if($isOld && $isOpen)
                        <span class="badge bg-danger ml-1">
                            {{ $subtask->created_at->diffInDays() }} дн
                        </span>
                        @endif
                        <span title="{{ $subtask->created_at }}">
                            ({{ $subtask->created_at->format('d.m.Y H:i') }})
                        </span>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="btn-group btn-group-sm ml-2">
                    <a href="{{ route('subtask.edit', $subtask->id) }}"
                        class="btn btn-warning" title="Редактировать">
                        <i class="fas fa-edit"></i>
                    </a>

                    <form method="POST" action="{{ route('subtask.copy', $subtask->id) }}">
                        @csrf
                        <button class="btn btn-outline-secondary" title="Копировать">
                            <i class="fas fa-copy"></i>
                        </button>
                    </form>

                    <form method="POST"
                        action="{{ route('subtask.promote', $subtask->id) }}"
                        onsubmit="return confirm('Преобразовать в задачу?')">
                        @csrf
                        <button class="btn btn-outline-primary" title="Преобразовать в задачу">
                            <i class="fas fa-level-up-alt"></i>
                        </button>
                    </form>

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
</div>
@stop