@extends('adminlte::page')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simplemde/dist/simplemde.min.css">
@section('title', 'Dashboard')

@section('content_header')

@section('content')
<section class="content">

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-tasks mr-2"></i>
                Добавить задачу
            </h3>
        </div>

        <form method="POST" action="{{ route('task.store') }}">
            @csrf

            <div class="card-body">

                <!-- TITLE -->
                <div class="form-group">
                    <label>Название задачи</label>
                    <input type="text"
                        name="title"
                        class="form-control"
                        placeholder="Например: Настроить Grid-бот"
                        value="{{ old('title') }}"
                        required>
                </div>

                <!-- DESCRIPTION -->
                <div class="form-group">
                    <label>Описание</label>
                    <textarea id="editor" name="description"
                        class="form-control"
                        rows="4"
                        placeholder="Что именно нужно сделать">{{ old('description') }}</textarea>
                </div>

                <!-- PROJECT -->
                <div class="form-group">
                    <label>Проект</label>
                    <select name="project_id"
                        class="form-control">

                        <option value="">Inbox (без проекта)</option>

                        @foreach($projects as $project)
                        <option value="{{ $project->id }}"
                            {{ old('project_id') == $project->id ? 'selected' : '' }}>
                            {{ $project->title }}
                        </option>
                        @endforeach

                    </select>
                </div>

                <!-- STATUS -->
                <div class="form-group">
                    <label>Статус</label>

                    <select name="status" class="form-control">
                        <option value="todo" selected>To Do</option>
                        <option value="in_progress">In Progress</option>
                        <option value="done">Done</option>
                    </select>
                </div>

                <!-- PRIORITY -->
                <div class="form-group">
                    <label>Приоритет</label>

                    <select name="priority" class="form-control">
                        <option value="1">Low</option>
                        <option value="2" selected>Medium</option>
                        <option value="3">High</option>
                    </select>
                </div>

                <!-- DUE DATE -->
                <div class="form-group">
                    <label>Дедлайн</label>
                    <input type="date"
                        name="due_date"
                        class="form-control"
                        value="{{ old('due_date') }}">
                </div>

            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i>
                    Сохранить задачу
                </button>

                <a href="{{ route('task.main') }}"
                    class="btn btn-secondary ml-2">
                    Отмена
                </a>
            </div>

        </form>

    </div>

</section>

@stop

@push('js')
<script src="https://cdn.jsdelivr.net/npm/simplemde/dist/simplemde.min.js"></script>
<script>
    new SimpleMDE({
        element: document.getElementById("editor"),
        spellChecker: false,
        toolbar: ["bold", "italic", "heading", "|",
            "unordered-list", "ordered-list", "|",
            "link", "code", "preview"
        ]
    });
</script>
@endpush