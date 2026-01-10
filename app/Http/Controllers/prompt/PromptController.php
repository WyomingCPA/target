<?php

namespace App\Http\Controllers\prompt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Prompt;

class PromptController extends Controller
{
    // Список промтов (главная страница)
    public function index()
    {
        $prompts = Prompt::orderByDesc('created_at')->get();

        return view('prompt.index', compact('prompts'));
    }

    // Форма создания
    public function create()
    {
        return view('prompt.create');
    }

    // Сохранение промта
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Prompt::create([
            'title'    => $request->input('title'),
            'content'  => $request->input('content'),
            'category' => $request->input('category'),
        ]);

        return redirect()->route('prompt.main')
            ->with('success', 'Промт добавлен');
    }

    public function update(Request $request, $id)
    {
        $prompt = Prompt::findOrFail($id);

        $prompt->update([
            'title'    => $request->input('title'),
            'content'  => $request->input('content'),
            'category' => $request->input('category'),
        ]);

        return redirect()->route('prompt.main');
    }

    public function edit($id)
    {
        $prompt = Prompt::findOrFail($id);
        return view('prompt.edit', compact('prompt'));
    }

    public function delete($id)
    {
        Prompt::findOrFail($id)->delete();

        return redirect()->route('prompt.main')
            ->with('success', 'Промт удалён');
    }
}
