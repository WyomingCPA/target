<?php

namespace App\Http\Controllers\task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\TaskTemplateGenerator;

use App\Models\Project;
class TaskGeneratorController extends Controller
{
    public function index()
    {
        $templates = config('task_templates');
        $projects  = Project::all();

        return view('task.templates.generator-project', compact('templates', 'projects'));
    }
    public function store(Request $request, TaskTemplateGenerator $generator)
    {
        $request->validate([
            'template'   => 'required|string',
            'project_id' => 'nullable|exists:projects,id',
        ]);

        $generator->generate(
            $request->template,
            $request->project_id
        );

        return redirect()->back()->with('success', 'Задачи сгенерированы');
    }
}
