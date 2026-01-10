@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-brain mr-2"></i> Библиотека промтов
        </h3>

        <div class="card-tools">
            <a href="{{ route('prompt.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Добавить
            </a>
        </div>
    </div>

    <div class="card-body p-0">

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Название</th>
                    <th>Категория</th>
                    <th>Текст</th>
                    <th width="160">Действия</th>
                </tr>
            </thead>

            <tbody>
                @foreach($prompts as $prompt)
                <tr>
                    <td>{{ $prompt->id }}</td>

                    <td>
                        <strong>{{ $prompt->title }}</strong>
                    </td>

                    <td>
                        <span class="badge badge-info">
                            {{ $prompt->category ?? 'general' }}
                        </span>
                    </td>

                    <td>
                        <small class="text-muted">
                            {{ Str::limit($prompt->content, 80) }}
                        </small>
                    </td>

                    <td>
                        <!-- COPY -->
                        <button class="btn btn-outline-secondary btn-sm"
                            onclick="navigator.clipboard.writeText(`{{ $prompt->content }}`)">
                            <i class="fas fa-copy"></i>
                        </button>

                        <!-- EDIT -->
                        <a href="{{ route('prompt.edit', $prompt->id) }}"
                            class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>

                        <!-- DELETE -->
                        <form action="{{ route('prompt.delete', $prompt->id) }}"
                            method="POST"
                            style="display:inline-block"
                            onsubmit="return confirm('Удалить промт?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
@stop