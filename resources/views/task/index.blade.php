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
            <a href="{{ route('task.create') }}"
                class="btn btn-primary btn-sm">
                + Добавить задачу
            </a>
        </div>
    </div>

    <div class="card-body p-0">

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Задача</th>
                    <th>Проект</th>
                    <th>Статус</th>
                    <th>Приоритет</th>
                    <th>Подзадачи</th>
                    <th>Прогресс</th>
                    <th>Дедлайн</th>
                    <th style="width:160px">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($tasks as $task)
                @php
                $total = $task->subtasks_count;
                $done = $task->done_subtasks_count;
                $progress = $total > 0 ? round($done / $total * 100) : 0;
                @endphp

                <tr>

                    <td>{{ $task->id }}</td>

                    <td>
                        <strong>{{ $task->title }}</strong><br>
                        <small class="text-muted">
                            {!! Str::limit(strip_tags(Str::markdown($task->description ?? '')),50) !!}
                        </small>
                    </td>

                    <td>
                        @if($task->project)
                        <span class="badge badge-info">
                            {{ $task->project->title }}
                        </span>
                        @else
                        <span class="text-muted">Inbox</span>
                        @endif
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
                    <td>
                        @if($total > 0)
                        <div class="progress progress-xs">
                            <div class="progress-bar
        {{ $progress == 100 ? 'bg-success' : 'bg-info' }}"
                                style="width: {{ $progress }}%">
                            </div>
                        </div>
                        <small class="text-muted">
                            {{ $done }} / {{ $total }} ({{ $progress }}%)
                        </small>
                        @else
                        <small class="text-muted">—</small>
                        @endif
                    </td>
                    <td>
                        {{ $task->due_date ?? '—' }}
                    </td>

                    <td>
                        <a href="{{ route('task.show', $task->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('task.edit', $task->id) }}" class="btn btn-sm btn-primary">
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

@stop