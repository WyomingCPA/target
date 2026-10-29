@extends('adminlte::page')

@section('title', 'Новый блок')

@section('content_header')
    <h1>Создать блок развития</h1>
@stop

@section('content')
<div class="card card-primary">
    <form method="POST" action="{{ route('task-blocks.store') }}">
        @csrf

        <div class="card-body">
            <div class="form-group">
                <label for="title">Название блока</label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    class="form-control @error('title') is-invalid @enderror"
                    value="{{ old('title') }}"
                    placeholder="Например, Прокачка вождения"
                    required
                >
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Описание</label>
                <textarea
                    id="description"
                    name="description"
                    class="form-control"
                    rows="3"
                    placeholder="Чему хочу научиться?"
                >{{ old('description') }}</textarea>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                Создать блок
            </button>

            <a href="{{ route('task-blocks.index') }}"
               class="btn btn-default">
                Отмена
            </a>
        </div>
    </form>
</div>
@stop