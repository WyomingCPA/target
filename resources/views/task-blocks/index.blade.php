@extends('adminlte::page')

@section('title', 'Блоки развития')

@section('content_header')
<h1>Блоки развития</h1>
@stop

@section('content')

@php
$showClosed = request()->boolean('show_closed');
@endphp

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

        {{-- Переключение архива --}}
        <div class="mb-3">
            @if($showClosed)
            <a href="{{ route('task-blocks.index') }}"
                class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left"></i>
                Скрыть закрытые
            </a>
            <span class="text-muted ml-2">
                Архив выполненных блоков
            </span>
            @else
            <a href="{{ route('task-blocks.index', ['show_closed' => 1]) }}"
                class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-archive"></i>
                Показать закрытые
            </a>
            @endif
        </div>

        <div class="row">

            @forelse($blocks->where('is_closed', $showClosed) as $block)

            @php
            $total = $block->tasks_count;
            $done = $block->completed_tasks_count;

            $progress = $total > 0
            ? round($done / $total * 100)
            : 0;
            @endphp

            <div class="col-md-6">
                <div class="card card-outline {{ $block->is_closed ? 'card-secondary' : 'card-primary' }}">

                    <div class="card-header">
                        <h3 class="card-title">
                            {{ $block->title }}
                        </h3>
                        <div class="row text-center mt-3">

                            <div class="col-3">
                                <h4 class="text-success">
                                    {{ $block->completed_today_count }}
                                </h4>
                                <small>Сегодня</small>
                            </div>

                            <div class="col-3">
                                <h4 class="text-info">
                                    {{ $block->completed_week_count }}
                                </h4>
                                <small>Неделя</small>
                            </div>

                            <div class="col-3">
                                <h4 class="text-warning">
                                    {{ $block->completed_month_count }}
                                </h4>
                                <small>Месяц</small>
                            </div>

                            <div class="col-3">
                                <h4 class="text-primary">
                                    {{ $block->completed_tasks_count }}
                                </h4>
                                <small>Всего</small>
                            </div>

                        </div>
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
                            <small class="text-muted">выполнено</small>
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

                        <form method="POST"
                            action="{{ route('task-blocks.copy', $block) }}"
                            class="d-inline"
                            onsubmit="return confirm('Скопировать блок со всеми задачами?')">
                            @csrf

                            <button class="btn btn-sm btn-outline-secondary"
                                title="Копировать блок">
                                <i class="fas fa-copy"></i>
                            </button>
                        </form>

                    </div>
                </div>
            </div>

            @empty

            <div class="col-12">
                <p class="text-muted">
                    {{ $showClosed
                            ? 'Закрытых блоков пока нет.'
                            : 'Активных блоков пока нет. Создай первое направление развития.' }}
                </p>
            </div>

            @endforelse

        </div>
    </div>
</div>

@stop