@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">История операций</h3>
    </div>

    <div class="card-body p-0">
        <div class="alert alert-info">
            <h4>
                Текущий баланс:
                <strong>{{ $balance }} coins</strong>
            </h4>
        </div>
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Тип</th>
                    <th>Сумма</th>
                    <th>Описание</th>
                    <th>Задача</th>
                    <th>Дата</th>
                </tr>
            </thead>

            <tbody>
                @forelse($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>

                    <td>
                        @if($transaction->type === 'earn')
                        <span class="badge badge-success">Начисление</span>
                        @elseif($transaction->type === 'spend')
                        <span class="badge badge-danger">Списание</span>
                        @elseif($transaction->type === 'penalty')
                        <span class="badge badge-warning">Штраф</span>
                        @endif
                    </td>

                    <td>
                        @if($transaction->amount > 0)
                        <span class="text-success font-weight-bold">
                            +{{ $transaction->amount }}
                        </span>
                        @else
                        <span class="text-danger font-weight-bold">
                            {{ $transaction->amount }}
                        </span>
                        @endif
                    </td>

                    <td>
                        {{ $transaction->description ?? '—' }}
                    </td>

                    <td>
                        @if($transaction->task)
                        <a href="{{ route('task.show', $transaction->task) }}">
                            #{{ $transaction->task->id }}
                        </a>
                        @else
                        —
                        @endif
                    </td>

                    <td>
                        {{ $transaction->created_at->format('d.m.Y H:i') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        Нет транзакций
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>

    @if($transactions->hasPages())
    <div class="card-footer clearfix">
        {{ $transactions->links() }}
    </div>
    @endif
</div>

@stop