@extends('adminlte::page')

@section('title', 'Блоки развития')

@section('content_header')
<h1>Блоки развития</h1>
@stop

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Мои направления</h3>

        <div class="card-tools">
            <a href="{{ route('task-blocks.create') }}"
                class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Создать блок
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="row">

            @forelse($blocks as $block)

            @php
            $total = $block->tasks_count;
            $done = $block->completed_tasks_count;

            $progress = $total > 0
            ? round($done / $total * 100)
            : 0;
            @endphp

            <div class="col-md-4">
                <div class="card card-outline {{ $block->is_closed ? 'card-secondary' : 'card-primary' }}">

                    <div class="card-header">
                        <h3 class="card-title">
                            {{ $block->title }}
                        </h3>

                        <div class="card-tools">
                            @if($block->is_closed)
                            <span class="badge badge-secondary">
                                <i class="fas fa-lock"></i> Закрыт
                            </span>
                            @else
                            <span class="badge badge-success">
                                <i class="fas fa-play"></i> Активный
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="card-body">

                        <p>
                            {{ $block->description ?: 'Без описания' }}
                        </p>

                        <div class="text-muted mb-2">
                            <small>
                                <i class="far fa-calendar-plus"></i>
                                Создан:
                                {{ $block->created_at->format('d.m.Y H:i') }}
                            </small>
                        </div>

                        @if($block->is_closed)
                        <div class="text-muted mb-3">
                            <small>
                                <i class="fas fa-lock"></i>
                                Закрыт:
                                {{ $block->closed_at?->format('d.m.Y H:i') ?? 'Дата не указана' }}
                            </small>
                        </div>
                        @endif

                        <hr>

                        <h4>
                            {{ $done }} / {{ $total }}
                            <small class="text-muted">
                                выполнено
                            </small>
                        </h4>

                        <div class="progress progress-sm">
                            <div class="progress-bar {{ $block->is_closed ? 'bg-secondary' : 'bg-success' }}"
                                style="width: {{ $progress }}%">
                            </div>
                        </div>

                        <p class="text-muted mt-2">
                            Прогресс: {{ $progress }}%
                        </p>

                        <a href="{{ route('task-blocks.show', $block) }}"
                            class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-folder-open"></i>
                            Открыть блок
                        </a>
                        @if($block->is_closed)
                        <form method="POST"
                            action="{{ route('task-blocks.reopen', $block) }}"
                            class="d-inline">
                            @csrf

                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fas fa-lock-open"></i>
                                Открыть
                            </button>
                        </form>
                        @else
                        <form method="POST"
                            action="{{ route('task-blocks.close', $block) }}"
                            class="d-inline"
                            onsubmit="return confirm('Закрыть этот блок?')">
                            @csrf

                            <button type="submit" class="btn btn-secondary btn-sm">
                                <i class="fas fa-lock"></i>
                                Закрыть
                            </button>
                        </form>
                        @endif

                    </div>
                </div>
            </div>

            @empty

            <div class="col-12">
                <p class="text-muted">
                    Блоков пока нет. Создай первое направление развития.
                </p>
            </div>

            @endforelse

        </div>
    </div>
</div>

@stop