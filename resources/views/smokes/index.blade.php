@extends('adminlte::page')

@section('title', 'Выкуренные сигареты')

@section('content_header')
    <h1>🚬 Выкуренные сигареты</h1>
@stop

@section('content')

<div class="row mb-4">

    {{-- С момента последней --}}
    <div class="col-md-3">
        <div class="small-box bg-success">
            <div class="inner">
                <h4>
                    {{ $timeSinceLast !== null ? $timeSinceLast . ' мин' : '—' }}
                </h4>
                <p>С последней сигареты</p>
            </div>
        </div>
    </div>

    {{-- Сегодня --}}
    <div class="col-md-3">
        <div class="small-box bg-danger">
            <div class="inner">
                <h4>{{ $todayCount }}</h4>
                <p>Сегодня выкурено</p>
            </div>
        </div>
    </div>

    {{-- Средний интервал --}}
    <div class="col-md-3">
        <div class="small-box bg-warning">
            <div class="inner">
                <h4>
                    {{ $averageInterval ? $averageInterval.' мин' : '—' }}
                </h4>
                <p>Средний интервал</p>
            </div>
        </div>
    </div>

    {{-- Лучший результат --}}
    <div class="col-md-3">
        <div class="small-box bg-info">
            <div class="inner">
                <h4>
                    {{ $maxInterval ? $maxInterval.' мин' : '—' }}
                </h4>
                <p>Макс. перерыв</p>
            </div>
        </div>
    </div>
</div>
<div class="card card-outline card-info mb-4">
    <div class="card-header">
        <h3 class="card-title">ℹ️ Правила списания</h3>
    </div>

    <div class="card-body">
        <p class="mb-3">
            Штраф зависит от времени с предыдущей сигареты:
        </p>

        <ul class="mb-3">
            <li><strong>&lt; 30 минут</strong> — <span class="text-danger">-6 coins</span></li>
            <li><strong>&lt; 60 минут</strong> — <span class="text-danger">-4 coins</span></li>
            <li><strong>&lt; 180 минут</strong> — <span class="text-warning">-2 coins</span></li>
            <li><strong>&ge; 180 минут</strong> — <span class="text-success">-1 coin</span></li>
        </ul>

        <small class="text-muted">
            Чем больше интервал — тем меньше штраф.
        </small>
    </div>
</div>

{{-- Кнопка --}}
<div class="mb-3">
    <form method="POST" action="{{ route('smokes.store') }}">
        @csrf
        <button class="btn btn-danger">
            🚬 Выкурил сигарету
        </button>
    </form>
</div>

{{-- Таблица --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">История</h3>
    </div>

    <div class="card-body p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Дата</th>
                    <th>Штраф</th>
                    <th>Интервал с предыдущей</th>
                </tr>
            </thead>

            <tbody>
                @forelse($smokes as $smoke)
                    <tr>
                        <td>{{ $smoke->id }}</td>

                        <td>
                            {{ $smoke->smoked_at->format('d.m.Y H:i') }}
                        </td>

                        <td>
                            <span class="text-danger font-weight-bold">
                                -{{ $smoke->penalty }}
                            </span>
                        </td>

                        <td>
                            @php
                                $previous = \App\Models\Smoke::where('smoked_at', '<', $smoke->smoked_at)
                                    ->latest('smoked_at')
                                    ->first();
                            @endphp

                            @if($previous)
                                {{ $previous->smoked_at->diffForHumans($smoke->smoked_at, true) }}
                            @else
                                —
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            Нет записей
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($smokes->hasPages())
        <div class="card-footer clearfix">
            {{ $smokes->links() }}
        </div>
    @endif
</div>

@stop