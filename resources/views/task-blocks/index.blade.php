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
                + Создать блок
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
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                {{ $block->title }}
                            </h3>
                        </div>

                        <div class="card-body">
                            <p>
                                {{ $block->description ?: 'Без описания' }}
                            </p>

                            <h4>
                                {{ $done }} / {{ $total }}
                                <small class="text-muted">
                                    выполнено
                                </small>
                            </h4>

                            <div class="progress progress-sm">
                                <div class="progress-bar bg-success"
                                     style="width: {{ $progress }}%">
                                </div>
                            </div>

                            <p class="text-muted mt-2">
                                Прогресс: {{ $progress }}%
                            </p>

                            <a href="{{ route('task-blocks.show', $block) }}"
                               class="btn btn-outline-primary btn-sm">
                                Открыть блок
                            </a>
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