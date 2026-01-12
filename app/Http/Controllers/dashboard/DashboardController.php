<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Task;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard.index', []);
    }
    public function metric()
    {
        $totalTasks = Task::whereNull('parent_id')->count();

        $completedTasks = Task::completed()->count();

        $activeTasks = Task::whereNull('parent_id')
            ->whereIn('status', ['todo', 'in_progress'])
            ->count();

        $overdueTasks = Task::whereNull('parent_id')
            ->whereNotNull('due_date')
            ->where('due_date', '<', now())
            ->where('status', '!=', 'done')
            ->count();

        $progress = $totalTasks > 0
            ? round($completedTasks / $totalTasks * 100)
            : 0;

        return view('dashboard.metric', compact(
            'totalTasks',
            'completedTasks',
            'activeTasks',
            'overdueTasks',
            'progress'
        ));
    }
}
