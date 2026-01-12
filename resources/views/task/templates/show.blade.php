@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">🧩 Декомпозиция задачи</h3>
    </div>

    <form method="POST" action="{{ route('task.decompose') }}">
        @csrf

        <div class="card-body">

            <div class="mb-3">
                <label class="form-label">Основная задача</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Шаблон</label>
                <select name="template" class="form-control">
                    @foreach(config('task_decomposition') as $key => $tpl)
                    <option value="{{ $key }}">{{ $tpl['label'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <select name="project_id" class="form-control">
                    <option value="">Без проекта</option>
                    @foreach($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->title }}</option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="card-footer text-end">
            <button class="btn btn-primary">
                ⚙️ Создать задачу и подзадачи
            </button>
        </div>

    </form>
</div>
@stop