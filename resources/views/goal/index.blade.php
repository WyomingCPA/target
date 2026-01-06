@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Цели</h3>
        <div class="mb-3">
            <a href="{{ route('goal.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-pen"></i> Добавить
            </a>
        </div>
    </div>

    <div class="card-body p-0">
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Приоритет</th>
                    <th>Статус</th>
                    <th>Прогресс</th>
                    <th style="width:160px">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($goals as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->title }}</td>
                    <td>
                        @if($item->priority == 1)
                        <span class="badge badge-danger">High</span>
                        @elseif($item->priority == 2)
                        <span class="badge badge-warning">Medium</span>
                        @else
                        <span class="badge badge-secondary">Low</span>
                        @endif
                    </td>
                    <td>
                        @if($item->status == 'active')
                        <span class="badge badge-success">Active</span>
                        @elseif($item->status == 'frozen')
                        <span class="badge badge-info">Frozen</span>
                        else
                        <span class="badge badge-primary">Done</span>
                        @endif
                    </td>

                    <td>
                        <div class="progress progress-xs">
                            <div class="progress-bar bg-success" style="width: {{ $goal->progress ?? 0 }}%"></div>
                        </div>
                    </td>
                    <td>
                        {{-- Кнопка "Удалить" --}}
                        <form action="{{ route('goal.delete', $item->id) }}"
                            method="POST"
                            style="display:inline-block">
                            @csrf
                            <button type="submit"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Удалить?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        <a href="{{ route('goal.edit', $item->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-pen"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Нет данных</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{-- Пагинация --}}
    <div class="card-footer">
        {{ $goals->links() }}
    </div>
</div>

@stop