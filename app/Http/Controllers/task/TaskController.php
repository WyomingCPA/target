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
        $tasks = Task::with('project')
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
}
