@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-calendar-week mr-2"></i>
            Персональный планировщик
        </h3>
        <div class="card-tools">
            <span class="badge badge-info">GPT Prompt</span>
        </div>
    </div>

    <div class="card-body">
        <p><strong>Описание:</strong></p>

        <div class="callout callout-info">
            <p>
                Ты — мой персональный планировщик.<br>
                На основе задач:<br>
                <code>{tasks}</code>
            </p>

            <p class="mt-3">
                Составь план на неделю:
            </p>

            <ul>
                <li>что делать в первую очередь</li>
                <li>что можно делегировать</li>
                <li>что можно отложить</li>
            </ul>
        </div>
    </div>

    <div class="card-footer text-muted">
        Используется для недельного планирования и приоритизации задач
    </div>
</div>

@stop