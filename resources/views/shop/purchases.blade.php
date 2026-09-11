@extends('adminlte::page')

@section('title', 'Мои покупки')

@section('content_header')
<h1>Мои покупки</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

        <table class="table table-bordered table-hover">

            <thead>
                <tr>
                    <th>Товар</th>
                    <th>Цена</th>
                    <th>Дата покупки</th>
                    <th>Статус</th>
                    <th>Заметка</th>
                    <th>Действие</th>
                </tr>
            </thead>

            <tbody>

                @forelse($purchases as $purchase)

                <tr>

                    <td>
                        {{ $purchase->shopItem->title }}
                    </td>

                    <td>
                        {{ $purchase->shopItem->price }} 🪙
                    </td>

                    <td>
                        {{ $purchase->created_at->format('d.m.Y H:i') }}
                    </td>

                    <td>

                        @if($purchase->used)

                        <span class="badge badge-success">
                            Использовано
                        </span>

                        @else

                        <span class="badge badge-warning">
                            Ожидает
                        </span>

                        @endif

                    </td>
                    <td>@if($purchase->notes)
                        <div class="text-muted">
                            {{ $purchase->notes }}
                        </div>
                        @endif

                    </td>
                    <td>

                        @if(!$purchase->used)

                        <form
                            action="{{ route('shop.use', $purchase) }}"
                            method="POST">

                            @csrf

                            <button class="btn btn-success btn-sm">
                                Использовать
                            </button>

                        </form>

                        @else

                        <span class="text-muted">
                            —
                        </span>

                        @endif

                    </td>
                    <td> <button type="button"
                            class="btn btn-sm btn-outline-secondary"
                            data-toggle="modal"
                            data-target="#editNote{{ $purchase->id }}">
                            ✏️ Редактировать заметку
                        </button>
                        {{-- Модальное окно --}}
                        <div class="modal fade"
                            id="editNote{{ $purchase->id }}"
                            tabindex="-1"
                            role="dialog">

                            <div class="modal-dialog" role="document">

                                <div class="modal-content">

                                    <form action="{{ route('shop.purchase.notes.update', $purchase) }}"
                                        method="POST">

                                        @csrf
                                        @method('PATCH')

                                        <div class="modal-header">

                                            <h5 class="modal-title">
                                                Заметка: {{ $purchase->shopItem->title }}
                                            </h5>

                                            <button type="button"
                                                class="close"
                                                data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>

                                        </div>

                                        <div class="modal-body">

                                            <textarea
                                                name="notes"
                                                class="form-control"
                                                rows="5"
                                                placeholder="Введите заметку...">{{ $purchase->notes }}</textarea>

                                        </div>

                                        <div class="modal-footer">

                                            <button type="button"
                                                class="btn btn-secondary"
                                                data-dismiss="modal">
                                                Отмена
                                            </button>

                                            <button type="submit"
                                                class="btn btn-primary">
                                                <i class="fas fa-save"></i>
                                                Сохранить
                                            </button>

                                        </div>

                                    </form>

                                </div>

                            </div>

                        </div>
                    </td>
                </tr>

                @empty

                <tr>
                    <td colspan="5" class="text-center">
                        Покупок пока нет
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>
</div>

@stop