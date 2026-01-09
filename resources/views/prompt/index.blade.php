@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-keyboard mr-2"></i>
            Промты
        </h3>

        <div class="card-tools">
            <a href="{{ route('prompt.create') }}" class="btn btn-primary btn-sm">
                + Добавить промт
            </a>
        </div>
    </div>

    <div class="card-body p-0">

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Категория</th>
                    <th>Текст</th>
                </tr>
            </thead>

            <tbody>
                @foreach($prompts as $prompt)
                <tr>
                    <td>{{ $prompt->id }}</td>
                    <td>{{ $prompt->title }}</td>
                    <td>{{ $prompt->category ?? '—' }}</td>
                    <td>{{ Str::limit($prompt->content, 100) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@stop