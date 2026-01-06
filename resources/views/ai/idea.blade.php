@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-lightbulb mr-2"></i>
            Генерация продуктовых идей
        </h3>
        <div class="card-tools">
            <span class="badge badge-warning">GPT Prompt</span>
        </div>
    </div>

    <div class="card-body">

        <p><strong>Роль:</strong> Продуктовый архитектор</p>

        <div class="callout callout-warning">
            <p>
                Ты — продуктовый архитектор.<br>
                На основе цели <code>"{goal}"</code> и текущих проектов
                <code>"{projects}"</code><br>
                предложи <strong>5 идей</strong>, которые можно реализовать за
                <strong>1–2 недели</strong>.
            </p>

            <p class="mt-3">Для каждой идеи укажи:</p>
            <ul>
                <li>ценность</li>
                <li>сложность</li>
                <li>потенциальную монетизацию</li>
            </ul>
        </div>

    </div>

    <div class="card-footer text-muted">
        Используется для быстрого поиска MVP-идей и приоритизации продуктовых решений
    </div>
</div>

@stop