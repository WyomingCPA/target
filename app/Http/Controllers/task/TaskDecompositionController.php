<?php

namespace App\Http\Controllers\task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\TaskDecompositionGenerator;

use App\Models\Project;

class TaskDecompositionController extends Controller
{
    public function create()
    {
        $projects = Project::orderBy('title')->get();

        return view('task.templates.show', [
            'projects' => $projects,
        ]);
    }
    public function store(Request $request, TaskDecompositionGenerator $generator)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'template'    => 'required|string',
            'project_id'  => 'nullable|exists:projects,id',
        ]);

        $task = $generator->generate(
            $request->title,
            $request->template,
            $request->project_id
        );

        return redirect()->route('task.decompose.create', $task)->with('success', 'Задача и подзадачи созданы');
    }
}
