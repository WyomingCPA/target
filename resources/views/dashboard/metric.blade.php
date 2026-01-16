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
<div class="row">

    {{-- Добавлено --}}
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box bg-info">
            <span class="info-box-icon">
                <i class="fas fa-plus"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Добавлено</span>
                <span class="info-box-number">{{ $created }}</span>
            </div>
        </div>
    </div>

    {{-- Выполнено --}}
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box bg-success">
            <span class="info-box-icon">
                <i class="fas fa-check"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Выполнено</span>
                <span class="info-box-number">{{ $completed }}</span>
            </div>
        </div>
    </div>

    {{-- Баланс --}}
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box {{ $balance >= 0 ? 'bg-success' : 'bg-danger' }}">
            <span class="info-box-icon">
                <i class="fas fa-balance-scale"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Баланс</span>
                <span class="info-box-number">
                    {{ $balance >= 0 ? '+' : '' }}{{ $balance }}
                </span>
            </div>
        </div>
    </div>

    {{-- Completion ratio --}}
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box bg-warning">
            <span class="info-box-icon">
                <i class="fas fa-percentage"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Completion</span>
                <span class="info-box-number">{{ $completionRatio }}%</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Прогресс дня</h3>
                </div>

                <div class="card-body">
                    <div class="progress">
                        <div class="progress-bar bg-success"
                            style="width: {{ min(100, $completionRatio) }}%">
                            {{ $completionRatio }}%
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Прогресс дня</h3>
                </div>

                <div class="card-body">
                    @if($completionRatio < 50)
                        <div class="alert alert-danger">
                        ⚠️ Перегруз. Сегодня добавлено больше, чем выполнено.
                </div>
                @elseif($completionRatio < 80)
                    <div class="alert alert-warning">
                    ⚠️ Нормально, но можно лучше.
            </div>
            @else
            <div class="alert alert-success">
                ✅ Отличный день.
            </div>
            @endif
        </div>

    </div>
</div>
</div>

</div>
<div class="row mt-4">

    <div class="col-12">
        <h4>📅 За неделю</h4>
    </div>

    {{-- Добавлено --}}
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box bg-info">
            <span class="info-box-icon">
                <i class="fas fa-plus"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Добавлено</span>
                <span class="info-box-number">{{ $createdWeek }}</span>
            </div>
        </div>
    </div>

    {{-- Выполнено --}}
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box bg-success">
            <span class="info-box-icon">
                <i class="fas fa-check"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Выполнено</span>
                <span class="info-box-number">{{ $completedWeek }}</span>
            </div>
        </div>
    </div>

    {{-- Баланс --}}
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box {{ $balanceWeek >= 0 ? 'bg-success' : 'bg-danger' }}">
            <span class="info-box-icon">
                <i class="fas fa-balance-scale"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Баланс</span>
                <span class="info-box-number">
                    {{ $balanceWeek >= 0 ? '+' : '' }}{{ $balanceWeek }}
                </span>
            </div>
        </div>
    </div>

    {{-- Completion --}}
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box bg-warning">
            <span class="info-box-icon">
                <i class="fas fa-percentage"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Completion</span>
                <span class="info-box-number">{{ $completionRatioWeek }}%</span>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Прогресс недели</h3>
        </div>

        <div class="card-body">
            <div class="progress">
                <div class="progress-bar bg-success"
                    style="width: {{ min(100, $completionRatioWeek) }}%">
                    {{ $completionRatioWeek }}%
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Разбивка по дням</h3>
        </div>

        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>День</th>
                        <th>➕ Добавлено</th>
                        <th>✅ Выполнено</th>
                        <th>⚖️ Баланс</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($days as $day)
                    <tr>
                        <td>{{ $day['date'] }}</td>
                        <td>{{ $day['created'] }}</td>
                        <td>{{ $day['completed'] }}</td>
                        <td>
                            {{ $day['completed'] - $day['created'] }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Прогресс недели</h3>
            </div>

            <div class="card-body">
                @if($completionRatioWeek < 50)
                    <div class="alert alert-danger">
                    ⚠️ Перегруз. За неделю добавлено больше, чем выполнено.
            </div>
            @elseif($completionRatioWeek < 80)
                <div class="alert alert-warning">
                ⚠️ Нормально, но можно лучше.
        </div>
        @else
        <div class="alert alert-success">
            ✅ Отличный день.
        </div>
        @endif
    </div>
</div>
<div class="card mt-4">
    <div class="card-header">
        <h3 class="card-title">📈 Поток задач (7 дней)</h3>
    </div>

    <div class="card-body">
        <canvas id="tasksFlowChart" height="120"></canvas>

    </div>
</div>
@stop
@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const canvas = document.getElementById('tasksFlowChart');
        if (!canvas) {
            console.error('Canvas not found');
            return;
        }

        new Chart(canvas, {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [{
                        label: 'Добавлено',
                        data: @json($createdData),
                        borderWidth: 2,
                        tension: 0.3
                    },
                    {
                        label: 'Выполнено',
                        data: @json($completedData),
                        borderWidth: 2,
                        tension: 0.3
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

    });
</script>
@endpush
