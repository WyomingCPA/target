<?php

namespace App\Http\Controllers\task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Task;

class CompletedTaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('status', 'done') // все завершённые
            ->with(['project', 'subtasks' => function ($q) {
                $q->orderBy('created_at', 'desc'); // подзадачи тоже выводим
            }])
            ->orderByDesc('completed_at')
            ->paginate(20); // пагинация

        return view('task.completed', compact('tasks'));
    }
}
