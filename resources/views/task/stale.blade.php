@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@section('content')
<div class="container-fluid">

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">🧊 Зависшие подзадачи (7+ дней)
                <span class="badge bg-danger ms-2">{{ $count }}</span>
            </h3>

        </div>

        <div class="card-body p-0">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Задача</th>
                        <th>Проект</th>
                        <th>Тип</th>
                        <th>Создана</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($tasks as $task)
                    <tr
                        @class([ 'table-warning'=> $task->created_at->between(now()->subDays(14), now()->subDays(30)),
                        'table-danger' => $task->created_at->lt(now()->subDays(30)),
                        ])
                        >
                        <td>
                            @if($task->parent_id)
                            {{-- Подзадача с чекбоксом --}}
                            <form method="POST"
                                action="{{ route('task.toggle', $task->id) }}"
                                class="d-inline">
                                @csrf

                                <div class="form-check">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        onchange="this.form.submit()"
                                        {{ $task->status === 'done' ? 'checked' : '' }}>

                                    <label class="form-check-label
                    {{ $task->status === 'done' ? 'text-muted text-decoration-line-through' : '' }}">
                                        {{ $task->title }}
                                    </label>
                                </div>
                            </form>
                            @else
                            {{-- Обычная задача --}}
                            <strong>{{ $task->title }}</strong>
                            @endif

                            @if($task->parent)
                            <div class="text-muted small">
                                Подзадача для:
                                <a href="{{ route('task.show', $task->parent->id) }}">
                                    {{ $task->parent->title }}
                                </a>
                            </div>
                            @endif
                        </td>

                        <td>
                            {{ $task->project->title ?? '—' }}
                        </td>

                        <td>
                            <span class="badge bg-{{ $task->parent_id ? 'info' : 'secondary' }}">
                                {{ $task->parent_id ? 'Подзадача' : 'Задача' }}
                            </span>
                        </td>

                        <td>
                            {{ $task->created_at->diffForHumans() }}
                        </td>

                        <td class="text-end">
                            <a href="{{ route('task.edit', $task->id) }}"
                                class="btn btn-sm btn-outline-warning">
                                ✏️
                            </a>
                            <a href="{{ route('task.show', $task->id) }}"
                                class="btn btn-sm btn-outline-primary">
                                👁
                            </a>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

</div>

@stop