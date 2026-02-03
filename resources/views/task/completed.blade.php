@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@section('content')
<div class="container">

    <h1 class="mb-4">✅ Завершённые задачи</h1>

    @forelse($tasks as $task)
    <div class="card mb-2 opacity-75">
        <div class="card-body d-flex justify-content-between align-items-center">

            <div>
                <strong>{{ $task->title }}</strong>

                @if($task->project)
                <div class="text-muted small">
                    Проект: {{ $task->project->title }}
                </div>
                @endif

                @if($task->completed_at)
                <div class="text-muted small">
                    Завершено: {{ $task->completed_at->format('d.m.Y H:i') }}
                </div>
                @endif
            </div>

            <span class="badge bg-success">Done</span>
            <a href="{{ route('task.edit', $task->id) }}"
                class="btn btn-sm btn-secondary">
                <i class="fas fa-pen"></i>
            </a>
        </div>
    </div>
    @empty
    <p class="text-muted">Пока нет завершённых задач</p>
    @endforelse

    {{ $tasks->links() }}

</div>

@stop