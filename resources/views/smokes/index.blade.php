@extends('adminlte::page')

@section('title', 'Выкуренные сигареты')

@section('content_header')
    <h1>🚬 Выкуренные сигареты</h1>
@stop

@section('content')

{{-- Статистика --}}
<div class="row mb-3">
    <div class="col-md-3">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $todayCount }}</h3>
                <p>Сегодня</p>
            </div>
            <div class="icon">
                <i class="fas fa-smoking"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $weekCount }}</h3>
                <p>За 7 дней</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3>{{ $totalCount }}</h3>
                <p>Всего</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-dark">
            <div class="inner">
                <h3>-{{ $totalPenalty }}</h3>
                <p>Списано coins</p>
            </div>
        </div>
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