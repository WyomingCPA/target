<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Task;
class TaskController extends Controller
{
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
}
