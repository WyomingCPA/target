<?php

namespace App\Http\Controllers\goal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Goal;

class GoalController extends Controller
{
    public function index(Request $request)
    {
        $models = Goal::paginate(20);
        return view('goal.index', ['goals' => $models,]);
    }
    public function create(Request $request)
    {
        return view('goal.create', []);
    }
    public function store(Request $request)
    {
        $title       = $request->input('title');
        $description = $request->input('description');
        $priority    = $request->input('priority');
        $status      = $request->input('status');

        $model = new Goal();
        $model->title       = $title;
        $model->description = $description;
        $model->priority    = $priority;
        $model->status      = $status;
        $model->save();

        return back()->with('success', 'Создано!');
    }
    public function edit(Request $request, $id)
    {
        $goal = Goal::findOrFail($id);
        return view('goal.edit', [
            'goal' => $goal,
        ]);
    }
    public function update(Request $request, $id)
    {
        $name        = $request->input('title');
        $description = $request->input('description');
        $priority    = $request->input('priority');
        $status      = $request->input('status');

        $goal = Goal::findOrFail($id);

        $goal->title       = $name;
        $goal->description = $description;
        $goal->priority    = $priority;
        $goal->status      = $status;

        $goal->save();

        return redirect()->route('goal.main')
            ->with('success', 'Цель обновлена');
    }

    public function delete($id)
    {
        Goal::findOrFail($id)->delete();
        return back()->with('success', 'Удалено');
    }
}
