<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskBlock;
use Illuminate\Http\Request;

class TaskBlockController extends Controller
{
    public function index()
    {
        $blocks = TaskBlock::withCount([
            'tasks',
            'tasks as completed_tasks_count' => function ($query) {
                $query->where('status', 'done');
            },
        ])->orderBy('title')->get();

        return view('task-blocks.index', compact('blocks'));
    }

    public function create()
    {
        return view('task-blocks.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $block = TaskBlock::create($data);

        return redirect()
            ->route('task-blocks.show', $block)
            ->with('success', 'Блок создан!');
    }

    public function show(TaskBlock $taskBlock)
    {
        $taskBlock->load([
            'tasks' => fn($query) => $query
                ->with('project')
                ->whereNotNull('parent_id')
                ->where('status', '!=', 'done')
                ->orderByDesc('id'),
        ]);

        $availableTasks = Task::whereNotNull('parent_id')
            ->where('status', '!=', 'done')
            ->whereDoesntHave('taskBlocks', function ($query) use ($taskBlock) {
                $query->where('task_blocks.id', $taskBlock->id);
            })
            ->with('project')
            ->orderByDesc('id')
            ->get();

        return view('task-blocks.show', compact('taskBlock', 'availableTasks'));
    }

    public function update(Request $request, TaskBlock $taskBlock)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $taskBlock->update($data);

        return back()->with('success', 'Блок обновлён!');
    }

    public function destroy(TaskBlock $taskBlock)
    {
        $taskBlock->delete();

        return redirect()
            ->route('task-blocks.index')
            ->with('success', 'Блок удалён!');
    }

    public function attachTasks(
        Request $request,
        TaskBlock $taskBlock
    ) {
        $data = $request->validate([
            'task_ids' => ['required', 'array', 'min:1'],
            'task_ids.*' => ['required', 'integer', 'distinct', 'exists:tasks,id'],
        ]);

        $taskBlock->tasks()->syncWithoutDetaching(
            $data['task_ids']
        );

        return back()->with('success', 'Задачи добавлены в блок!');
    }

    public function detachTask(
        TaskBlock $taskBlock,
        Task $task
    ) {
        $taskBlock->tasks()->detach($task->id);

        return back()->with('success', 'Задача удалена из блока!');
    }
}
