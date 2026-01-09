@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-lightbulb mr-2"></i>
            Идеи
        </h3>

        <div class="card-tools">
            <a href="{{ route('idea.create') }}"
                class="btn btn-primary btn-sm">
                + Добавить идею
            </a>
        </div>
    </div>

    <div class="card-body p-0">

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Идея</th>
                    <th>Источник</th>
                    <th>Статус</th>
                    <th style="width:140px">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($ideas as $idea)
                <tr>
                    <td>{{ $idea->id }}</td>

                    <td>
                        <strong>{{ $idea->title }}</strong><br>
                        <small class="text-muted">
                            {{ Str::limit($idea->description, 60) }}
                        </small>
                    </td>

                    <td>
                        <span class="badge badge-info">
                            {{ $idea->source ?? '—' }}
                        </span>
                    </td>

                    <td>
                        @if($idea->converted)
                        <span class="badge badge-success">Converted</span>
                        @else
                        <span class="badge badge-secondary">New</span>
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('idea.edit', $idea->id) }}"
                            class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@stop