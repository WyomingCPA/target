<?php

namespace App\Http\Controllers\project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Project;
use App\Models\Goal;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('goal')
            ->orderByDesc('status')
            ->get();

        return view('project.index', [
            'projects' => $projects,
        ]);
    }
    public function create(Request $request)
    {
        $goals = Goal::orderByDesc('priority')->get();

        return view('project.create', [
            'goals' => $goals,
        ]);
    }
public function update(Request $request, $id)
{
    // 1. input как ты любишь
    $name        = $request->input('title');
    $goal_id     = $request->input('goal_id');
    $status      = $request->input('status');
    $stack       = $request->input('tech_stack');
    $description = $request->input('description');

    // 2. validate
    $request->validate([
        'title'       => 'required|string|max:255',
        'goal_id'     => 'nullable|exists:goals,id',
        'status'      => 'required|string',
        'tech_stack'  => 'nullable|array',
        'description' => 'nullable|string',
    ]);

    // 3. save
    $project = Project::findOrFail($id);

    $project->title       = $name;
    $project->goal_id     = $goal_id ?: null;
    $project->status      = $status;
    $project->description = $description;

    $project->tech_stack  = json_encode(
        array_filter($stack ?: []),
        JSON_UNESCAPED_UNICODE
    );

    $project->save();

    return redirect()->route('project.main')
        ->with('success', 'Проект обновлён');
}
    public function edit($id)
    {
        $project = Project::findOrFail($id);

        $goals = Goal::orderByDesc('priority')->get();

        return view('project.edit', [
            'project' => $project,
            'goals'   => $goals,
        ]);
    }


    public function show(Request $request)
    {
        return view('project.show', []);
    }
    public function store(Request $request)
    {
        $name        = $request->input('title');
        $url_stack   = $request->input('tech_stack');
        $goal_id     = $request->input('goal_id');
        $status      = $request->input('status');

        $project = new Project();

        $project->title       = $name;
        $project->goal_id     = $goal_id ?: null;
        $project->tech_stack  = json_encode($url_stack);
        $project->status      = $status;
        $project->description = $request->input('description');

        $project->save();

        return redirect()->route('project.main')
            ->with('success', 'Проект добавлен');
    }
    public function delete($id)
    {
        Project::findOrFail($id)->delete();
        return back()->with('success', 'Удалено');
    }
}
