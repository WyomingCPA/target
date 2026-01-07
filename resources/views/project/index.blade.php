@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@section('content')
<section class="content">

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-folder-open mr-2"></i>
                Проекты
            </h3>

            <div class="card-tools">
                <a href="{{ route('project.create') }}" class="btn btn-primary btn-sm">
                    + Добавить проект
                </a>
            </div>
        </div>

        <div class="card-body p-0">

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Цель</th>
                        <th>Статус</th>
                        <th>Стек</th>
                        <th>Прогресс</th>
                        <th style="width:180px">Action</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($projects as $project)

                    <tr>
                        <td>{{ $project->id }}</td>

                        <td>
                            <strong>{{ $project->title }}</strong><br>
                            <small class="text-muted">
                                {{ Str::limit($project->description, 60) }}
                            </small>
                        </td>

                        <!-- GOAL -->
                        <td>
                            @if($project->goal)
                            <span class="badge badge-info">
                                {{ $project->goal->title }}
                            </span>
                            @else
                            <span class="text-muted">Без цели</span>
                            @endif
                        </td>

                        <!-- STATUS -->
                        <td>
                            @if($project->status == 'active')
                            <span class="badge badge-success">Active</span>
                            @elseif($project->status == 'paused')
                            <span class="badge badge-warning">Paused</span>
                            @else
                            <span class="badge badge-primary">Done</span>
                            @endif
                        </td>

                        <!-- STACK -->
                        <td>
                            @php
                            $stack = json_decode($project->tech_stack, true);
                            @endphp

                            @if(is_array($stack))
                            @foreach($stack as $tech)
                            <span class="badge badge-secondary">{{ $tech }}</span>
                            @endforeach
                            @else
                            <span class="text-muted">—</span>
                            @endif
                        </td>

                        <!-- PROGRESS -->
                        <td>
                            {{ $project->progress ?? 0 }}%
                        </td>

                        <td>
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-success"
                                    style="width: {{ $project->progress ?? 0 }}%">
                                </div>
                            </div>
                        </td>

                        <!-- ACTION -->
                        <td>

                            <a href="{{ route('project.show', $project->id) }}"
                                class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="{{ route('project.edit', $project->id) }}"
                                class="btn btn-outline-warning btn-sm ml-1">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form method="POST"
                                action="{{ route('project.delete', $project->id) }}"
                                class="d-inline ml-1"
                                onsubmit="return confirm('Удалить проект?')">

                                @csrf
                                @method('POST')

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

</section>

@stop