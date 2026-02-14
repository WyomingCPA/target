@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-tasks mr-2"></i>
            Задачи
        </h3>

        <div class="card-tools">

            <div class="mb-3 text-right">
                <a href="{{ route('task.create') }}"
                    class="btn btn-primary btn-sm">
                    + Добавить задачу
                </a>
                <button class="btn btn-sm btn-outline-secondary"
                    onclick="collapseAll()">
                    ⬆️ Свернуть все
                </button>

                <button class="btn btn-sm btn-outline-primary"
                    onclick="expandAll()">
                    ⬇️ Развернуть все
                </button>
            </div>
        </div>
    </div>

    @foreach($tasks as $projectTitle => $projectTasks)
    @php
    $totalSubtasks = $projectStats[$projectTitle]['subtasks_total'] ?? 0;
    $doneSubtasks = $projectStats[$projectTitle]['subtasks_done'] ?? 0;
    $projectProgress = $totalSubtasks > 0
    ? round(($doneSubtasks / $totalSubtasks) * 100)
    : 0;
    $color = match(true) {
    $projectProgress == 100 => 'bg-success',
    $projectProgress >= 60 => 'bg-primary',
    $projectProgress >= 30 => 'bg-warning',
    default => 'bg-danger'
    };
    @endphp
    <div class="card card-outline card-primary">

        {{-- HEADER проекта --}}
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title w-100">
                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <i class="fas fa-folder mr-2"></i>
                        {{ $projectTitle }}

                        <span class="badge badge-secondary ml-2">
                            {{ $projectTasks->count() }} задач
                        </span>
                        <span class="badge badge-info ml-2">
                            {{ $totalSubtasks }} подзадач
                        </span>

                    </div>

                    @if($totalSubtasks > 0)
                    <div style="width:220px;">
                        <div class="progress progress-xs mb-1">
                            <div class="progress-bar {{ $color }}"
                                style="width: {{ $projectProgress }}%">
                            </div>
                        </div>
                        <small class="text-muted">
                            {{ $doneSubtasks }}/{{ $totalSubtasks }}
                            ({{ $projectProgress }}%)
                        </small>
                    </div>
                    @endif

                </div>
            </h3>

            <button class="btn btn-tool"
                data-toggle="collapse"
                data-target="#project-{{ Str::slug($projectTitle) }}">
                <i class="fas fa-chevron-down"></i>
            </button>
        </div>

        {{-- BODY --}}
        <div class="collapse project-collapse" id="project-{{ Str::slug($projectTitle) }}">

            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Задача</th>

                            <th>Статус</th>
                            <th>Приоритет</th>
                            <th>Подзадачи</th>
                            <th>Прогресс</th>
                            <th>Дедлайн</th>
                            <th style="width:160px">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($projectTasks as $task)
                        @php
                        $total = $task->subtasks_count;
                        $done = $task->done_subtasks_count;
                        $progress = $total > 0 ? round($done / $total * 100) : 0;

                        @endphp

                        <tr>
                            <td style="width:60px">{{ $task->id }}</td>

                            <td>
                                <strong>{{ $task->title }}</strong><br>
                                <small class="text-muted">
                                    {!! Str::limit(strip_tags(Str::markdown($task->description ?? '')), 50) !!}
                                </small>
                            </td>
                            <td>
                                <span class="badge badge-secondary">
                                    {{ $task->status }}
                                </span>
                            </td>
                            <td>
                                @if($task->priority == 1)
                                <span class="badge badge-danger">High</span>
                                @elseif($task->priority == 2)
                                <span class="badge badge-warning">Medium</span>
                                @else
                                <span class="badge badge-secondary">Low</span>
                                @endif
                            </td>
                            <td>
                                @if($task->subtasks_count > 0)
                                <span class="badge badge-info">
                                    {{ $task->subtasks_count }} подзадач
                                </span>
                                @else
                                <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td style="width:160px">
                                @if($total > 0)
                                <div class="progress progress-xs">
                                    <div class="progress-bar {{ $progress == 100 ? 'bg-success' : 'bg-info' }}"
                                        style="width: {{ $progress }}%">
                                    </div>
                                </div>
                                <small>{{ $done }}/{{ $total }} ({{ $progress }}%)</small>
                                @else
                                <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                {{ $task->due_date ?? '—' }}
                            </td>
                            <td style="width:140px">
                                <a href="{{ route('task.show', $task->id) }}"
                                    class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('task.edit', $task->id) }}"
                                    class="btn btn-sm btn-secondary">
                                    <i class="fas fa-pen"></i>
                                </a>
                                {{-- Кнопка "Удалить" --}}
                                <form action="{{ route('task.delete', $task->id) }}"
                                    method="POST"
                                    style="display:inline-block">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Удалить?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endforeach

</div>
</div>

@stop
@push('js')
<script>
    function collapseAll() {
        $('.project-collapse').collapse('hide');
    }

    function expandAll() {
        $('.project-collapse').collapse('show');
    }
</script>
@endpush