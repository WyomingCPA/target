@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@section('content')
<section class="content">

    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-edit mr-2"></i>
                Редактирование проекта
            </h3>
        </div>

        <form method="POST" action="{{ route('project.update', $project->id) }}">
            @csrf
            @method('POST')

            <div class="card-body">

                <!-- TITLE -->
                <div class="form-group">
                    <label>Название</label>
                    <input type="text"
                        name="title"
                        class="form-control"
                        value="{{ old('title', $project->title) }}"
                        required>
                </div>

                <!-- DESCRIPTION -->
                <div class="form-group">
                    <label>Описание</label>

                    <textarea name="description"
                        class="form-control"
                        rows="4">{{ old('description', $project->description) }}</textarea>
                </div>

                <!-- GOAL -->
                <div class="form-group">
                    <label>Цель</label>

                    <select name="goal_id"
                        class="form-control">

                        <option value="">Без цели</option>

                        @foreach($goals as $item)

                        <option value="{{ $item->id }}"
                            {{ old('goal_id', $project->goal_id) == $item->id ? 'selected' : '' }}>
                            {{ $item->title }}
                        </option>

                        @endforeach

                    </select>
                </div>

                <!-- STATUS -->
                <div class="form-group">
                    <label>Статус</label>

                    <select name="status"
                        class="form-control">

                        <option value="active"
                            {{ old('status', $project->status) == 'active' ? 'selected' : '' }}>
                            Активный
                        </option>

                        <option value="paused"
                            {{ old('status', $project->status) == 'paused' ? 'selected' : '' }}>
                            На паузе
                        </option>

                        <option value="done"
                            {{ old('status', $project->status) == 'done' ? 'selected' : '' }}>
                            Завершён
                        </option>

                    </select>
                </div>

                <!-- STACK -->
                <div class="form-group">
                    <label>Стек технологий</label>

                    @php
                    $stack = old('tech_stack', $project->tech_stack ?? []);
                    if(is_string($stack)) {
                    $stack = json_decode($stack, true) ?: [];
                    }
                    @endphp

                    <input type="text"
                        name="tech_stack[]"
                        class="form-control"
                        value="{{ $stack[0] ?? '' }}"
                        placeholder="laravel">

                    <input type="text"
                        name="tech_stack[]"
                        class="form-control mt-2"
                        value="{{ $stack[1] ?? '' }}"
                        placeholder="redis">

                    <input type="text"
                        name="tech_stack[]"
                        class="form-control mt-2"
                        value="{{ $stack[2] ?? '' }}"
                        placeholder="postgres">

                    <small class="text-muted">Потом можно заменить на tags input</small>

                </div>


            </div>

            <div class="card-footer">

                <button type="submit"
                    class="btn btn-warning">
                    Сохранить изменения
                </button>

                <a href="{{ route('project.main') }}"
                    class="btn btn-secondary ml-2">
                    Отмена
                </a>

            </div>

        </form>

    </div>

</section>

@stop