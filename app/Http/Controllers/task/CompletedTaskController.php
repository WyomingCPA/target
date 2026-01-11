<?php

namespace App\Http\Controllers\task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Task;

class CompletedTaskController extends Controller
{
    public function index()
    {
        $tasks = Task::completed()
            ->with('project')
            ->orderByDesc('completed_at')
            ->paginate(20);

        return view('task.completed', compact('tasks'));
    }
}
