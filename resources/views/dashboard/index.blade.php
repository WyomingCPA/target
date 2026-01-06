@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@section('content')
<div class="card">
  <div class="card-header bg-primary">
    <h3 class="card-title">
      <i class="fas fa-sitemap mr-2"></i>
      Логическая структура задачника
    </h3>
  </div>

  <div class="card-body">

    <h5 class="mb-3">
      <i class="fas fa-layer-group mr-2 text-secondary"></i>
      Основные сущности
    </h5>

    <ul class="list-group">

      <li class="list-group-item">
        <h6>
          <i class="fas fa-bullseye text-danger mr-2"></i>
          Цель (Goal)
        </h6>
        <ul class="mb-0">
          <li>Например: <strong>Запустить SaaS</strong>, <strong>Освоить опционы</strong>, <strong>Создать Telegram-бота</strong></li>
          <li>Долгосрочная</li>
        </ul>
      </li>

      <li class="list-group-item">
        <h6>
          <i class="fas fa-folder text-warning mr-2"></i>
          Проект (Project)
        </h6>
        <ul class="mb-0">
          <li>Например: <strong>Grid-бот</strong>, <strong>Laravel маркетплейс</strong>, <strong>DeFi-дашборд</strong></li>
          <li>Привязан к цели</li>
        </ul>
      </li>

      <li class="list-group-item">
        <h6>
          <i class="fas fa-lightbulb text-success mr-2"></i>
          Идея (Idea)
        </h6>
        <ul class="mb-0">
          <li>Может быть сырой</li>
          <li>Может превратиться в проект или задачу</li>
        </ul>
      </li>

      <li class="list-group-item">
        <h6>
          <i class="fas fa-tasks text-info mr-2"></i>
          Задача (Task)
        </h6>
        <ul class="mb-0">
          <li>Конкретное действие</li>
          <li>Может быть привязано к проекту или просто в <strong>Inbox</strong></li>
        </ul>
      </li>

      <li class="list-group-item">
        <h6>
          <i class="fas fa-check-square text-secondary mr-2"></i>
          Подзадача (Subtask)
          <span class="badge badge-light ml-2">опционально</span>
        </h6>
      </li>

    </ul>

  </div>
</div>

@stop