<?php

namespace App\Http\Controllers\idea;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Goal;
use App\Models\Idea;
class IdeaController extends Controller
{
    public function index()
    {
        $ideas = Idea::orderByDesc('created_at')->get();

        return view('idea.index', compact('ideas'));
    }

    public function create()
    {
        return view('idea.create');
    }

    public function store(Request $request)
    {
        $title       = $request->input('title');
        $description = $request->input('description');
        $source      = $request->input('source');

        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $idea = new Idea();
        $idea->title       = $title;
        $idea->description = $description;
        $idea->source      = $source;
        $idea->converted   = false;
        $idea->save();

        return redirect()->route('idea.main')
            ->with('success', 'Идея добавлена');
    }

    public function edit($id)
    {
        $idea = Idea::findOrFail($id);

        return view('idea.edit', compact('idea'));
    }

    public function update(Request $request, $id)
    {
        $title       = $request->input('title');
        $description = $request->input('description');
        $source      = $request->input('source');
        $converted   = $request->boolean('converted');

        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $idea = Idea::findOrFail($id);

        $idea->title       = $title;
        $idea->description = $description;
        $idea->source      = $source;
        $idea->converted   = $converted;

        $idea->save();

        return redirect()->route('idea.main')
            ->with('success', 'Идея обновлена');
    }
}
