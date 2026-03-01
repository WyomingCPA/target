@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 class="mb-4">✅ Завершённые задачи</h1>
@stop

@section('content')
<div class="container">

    @forelse($tasks as $task)
        @php
            $totalSubtasks = $task->subtasks->count();
            $doneSubtasks = $task->subtasks->where('status', 'completed')->count();
            $progress = $totalSubtasks ? round($doneSubtasks / $totalSubtasks * 100) : 100;
        @endphp

        <div class="card mb-3 {{ $task->status == 'completed' ? 'border-success' : '' }}">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">{{ $task->title }}</h4>
            </div>
            <div class="card-body">
                <p><strong>Завершена:</strong> {{ $task->completed_at ? $task->completed_at->format('d.m.Y H:i') : '-' }}</p>
            </div>
        </div>
    @empty
        <p class="text-muted">Пока нет завершённых задач</p>
    @endforelse

    {{ $tasks->links() }}

</div>
@stop