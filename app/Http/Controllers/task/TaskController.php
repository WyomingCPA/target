<?php

namespace App\Http\Controllers\task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Project;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('project')->withCount([
            'subtasks',
            'subtasks as done_subtasks_count' => function ($q) {
                $q->where('status', 'done');
            }
        ])->where('status', '!=', 'done')
            ->whereNull('parent_id')
            ->orderBy('status')
            ->orderByDesc('priority')
            ->get();

        return view('task.index', compact('tasks'));
    }

    public function create()
    {
        $projects = Project::orderBy('title')->get();

        return view('task.create', compact('projects'));
    }
    public function store(Request $request)
    {
        $title       = $request->input('title');
        $project_id  = $request->input('project_id');
        $status      = $request->input('status');
        $priority = (int) $request->input('priority');
        $description = $request->input('description');
        $due_date    = $request->input('due_date');

        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $task = new Task();

        $task->title       = $title;
        $task->project_id  = $project_id ?: null;
        $task->status      = $status;
        $task->priority    = $priority;
        $task->description = $description;
        $task->due_date    = $due_date;

        $task->save();

        return redirect()->route('task.main')
            ->with('success', 'Задача добавлена');
    }
    public function parentTaskStore(Request $request)
    {
        $parentTask = Task::findOrFail($request->input('parent_id'));

        $subtask = $parentTask->subtasks()->create([
            'title'    => $request->input('title'),
            'status'   => 'todo',
            'priority' => 3,
        ]);

        return back();
    }
    public function edit(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $projects = Project::orderBy('title')->get();

        return view('task.edit', [
            'task'     => $task,
            'projects' => $projects,
        ]);
    }
    public function update(Request $request, $id)
    {
        // input
        $title       = $request->input('title');
        $description = $request->input('description');
        $project_id  = $request->input('project_id');
        $status      = $request->input('status');
        $priority    = (int) $request->input('priority');
        $due_date    = $request->input('due_date');

        // validate
        $request->validate([
            'title'    => 'required|string|max:255',
            'status'   => 'required|string',
            'priority' => 'required|integer|min:1|max:3',
        ]);

        // save
        $task = Task::findOrFail($id);

        $task->title       = $title;
        $task->description = $description;
        $task->project_id  = $project_id ?: null;
        $task->status      = $status;
        $task->priority    = $priority;
        $task->due_date    = $due_date;

        $task->save();

        return redirect()->route('task.main')
            ->with('success', 'Задача обновлена');
    }
    public function delete($id)
    {
        Task::findOrFail($id)->delete();
        return back()->with('success', 'Удалено');
    }
    public function show(Request $request, $id)
    {
        $task = Task::with([
            'subtasks' => function ($q) {
                $q->orderBy('created_at');
            },
            'project'
        ])->findOrFail($id);

        $total = $task->subtasks->count();
        $done  = $task->subtasks->where('status', 'done')->count();

        $progress = $total > 0 ? round(($done / $total) * 100) : 0;

        return view('task.show', compact(
            'task',
            'progress',
            'done',
            'total'
        ));
    }
    public function toggleStatus(Task $task)
    {
        $task->status = $task->status === 'done' ? 'todo' : 'done';
        $task->save();

        return back();
    }
}
