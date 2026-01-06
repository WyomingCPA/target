@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@section('content')
<div class="card card-outline card-success">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-project-diagram mr-2"></i>
            Декомпозиция задачи
        </h3>
        <div class="card-tools">
            <span class="badge badge-success">GPT Prompt</span>
        </div>
    </div>

    <div class="card-body">

        <p><strong>Роль:</strong> Senior Laravel-разработчик</p>

        <div class="callout callout-success">
            <p>
                Ты — senior Laravel-разработчик.<br>
                Разбей задачу <code>"{task}"</code> на подзадачи<br>
                в формате чек-листа, готового для <strong>Kanban</strong>.<br>
                Укажи порядок выполнения.
            </p>
        </div>

    </div>

    <div class="card-footer text-muted">
        Используется для автоматической декомпозиции задач и генерации подзадач
    </div>
</div>

@stop