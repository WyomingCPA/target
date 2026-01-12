@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@section('content')
<div class="row">

    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalTasks }}</h3>
                <p>Всего задач</p>
            </div>
            <div class="icon">
                <i class="fas fa-tasks"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $completedTasks }}</h3>
                <p>Завершено</p>
            </div>
            <div class="icon">
                <i class="fas fa-check"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $activeTasks }}</h3>
                <p>В работе</p>
            </div>
            <div class="icon">
                <i class="fas fa-spinner"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $overdueTasks }}</h3>
                <p>Просрочено</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>

</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Общий прогресс</h3>
    </div>

    <div class="card-body">
        <div class="progress">
            <div class="progress-bar bg-success"
                style="width: {{ $progress }}%">
                {{ $progress }}%
            </div>
        </div>
    </div>
</div>
<div class="card mt-4">
    <div class="card-header">
        <h3 class="card-title">🔥 В работе</h3>
    </div>

    <div class="card-body p-0">
        <ul class="list-group list-group-flush">
            @foreach(
            \App\Models\Task::whereNull('parent_id')
            ->whereIn('status', ['todo','in_progress'])
            ->limit(5)->get()
            as $task
            )
            <li class="list-group-item d-flex justify-content-between">
                {{ $task->title }}
                <span class="badge bg-secondary">
                    {{ ucfirst($task->status) }}
                </span>
            </li>
            @endforeach
        </ul>
    </div>
</div>

@stop