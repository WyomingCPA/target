@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@section('content')
<div class="container-fluid">

  <div class="card">

    {{-- Header --}}
    <div class="card-header">
      <h3 class="card-title">
        ⚙️ Генератор задач
      </h3>
    </div>

    {{-- Body --}}
    <div class="card-body">

      <p class="text-muted mb-4">
        Выберите шаблон — система автоматически создаст задачи
      </p>

      <div class="row">
        @foreach($templates as $key => $template)
        <div class="col-md-4">
          <div class="card card-outline card-primary mb-4 h-100">
            <div class="card-body d-flex flex-column">

              <h5 class="card-title">
                {{ $template['label'] }}
              </h5>

              <p class="text-muted">
                {{ count($template['tasks']) }} задач
              </p>

              <ul class="small mb-3">
                @foreach(array_slice($template['tasks'], 0, 3) as $task)
                <li>{{ $task['title'] }}</li>
                @endforeach

                @if(count($template['tasks']) > 3)
                <li class="text-muted">…</li>
                @endif
              </ul>

              <form action="{{ route('task.generate') }}" method="POST" class="mt-auto">
                @csrf

                <input type="hidden" name="template" value="{{ $key }}">

                <div class="mb-2">
                  <select name="project_id" class="form-control">
                    <option value="">Без проекта</option>
                    @foreach($projects as $project)
                    <option value="{{ $project->id }}">
                      {{ $project->title }}
                    </option>
                    @endforeach
                  </select>
                </div>

                <button class="btn btn-primary btn-block">
                  ⚡ Сгенерировать
                </button>
              </form>

            </div>
          </div>
        </div>
        @endforeach
      </div>

    </div>

  </div>

</div>
@stop