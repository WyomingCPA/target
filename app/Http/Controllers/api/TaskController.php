<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Task;
use App\Services\CoinService;

class TaskController extends Controller
{
public function index()
{
    $tasks = Task::with([
        'project',
        'subtasks' => function ($q) {
            $q->where('status', '!=', 'done')
              ->orderBy('created_at', 'desc');
        }
    ])
    ->withCount([
        'subtasks',
        'subtasks as done_subtasks_count' => function ($q) {
            $q->where('status', 'done');
        }
    ])
    ->where('status', '!=', 'done')
    ->whereNull('parent_id')
    ->orderBy('status')
    ->orderByDesc('priority')
    ->get()
    ->groupBy(function ($task) {
        return $task->project->title ?? 'Inbox';
    });

    // 📊 статистика по проектам
    $projectStats = $tasks->map(function ($projectTasks) {
        return [
            'subtasks_total' => $projectTasks->sum('subtasks_count'),
            'subtasks_done'  => $projectTasks->sum('done_subtasks_count'),
        ];
    });

    // 🔥 нормализуем вывод (очень важно для бота)
    $tasksFormatted = $tasks->map(function ($projectTasks) {
        return $projectTasks->map(function ($task) {

            return [
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'status' => $task->status,

                'subtasks_count' => $task->subtasks_count,
                'done_subtasks_count' => $task->done_subtasks_count,

                // 👇 вот главное
                'subtasks' => $task->subtasks->map(function ($subtask) {
                    return [
                        'id' => $subtask->id,
                        'title' => $subtask->title,
                        'status' => $subtask->status,
                    ];
                }),
            ];
        });
    });

    return response()->json([
        'tasks' => $tasksFormatted,
        'projectStats' => $projectStats,
        'status' => true,
    ], 200);
}


    public function stale()
    {
        $tasks = Task::whereNotNull('parent_id')
            ->where('created_at', '<', now()->subDays(7))
            ->whereIn('status', ['todo', 'in_progress'])
            ->with(['parent', 'project'])
            ->orderBy('created_at')
            ->limit(5)
            ->get();
        $count = $tasks->count();

        return response()->json([
            'tasks' => $tasks,
            'status' => true,
        ], 200);
    }
    public function toggleStatus(Task $task, CoinService $coinService)
    {
        $task->status = $task->status === 'done' ? 'todo' : 'done';
        if ($task->status === 'done') {
            $coinService->rewardForTask($task);
        } else {
            $task->completed_at = null;
        }

        return response()->json([
            'status' => true,
        ], 200);
    }
}
