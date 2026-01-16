<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
        //Добавленные за день
        $created = Task::whereDate('created_at', today())->count();
        //Выполненные за день
        $completed = Task::whereDate('completed_at', today())->count();
        $balance = $completed - $created;
        $completionRatio = $created > 0 ? round($completed / $created * 100)
            : 100;

        //Статистика за неделю

        $start = Carbon::now()->subDays(6)->startOfDay();
        $end   = Carbon::now()->endOfDay();

        $createdWeek = Task::whereBetween('created_at', [$start, $end])->count();
        $completedWeek = Task::whereBetween('completed_at', [$start, $end])->count();

        $balanceWeek = $completedWeek - $createdWeek;
        $completionRatioWeek = $createdWeek > 0 ? round($completedWeek / $createdWeek * 100) : 100;

        // ===== По дням =====
        $days = collect();

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);

            $days->push([
                'date'       => $date->format('d.m'),
                'created'    => Task::whereDate('created_at', $date)->count(),
                'completed'  => Task::whereDate('completed_at', $date)->count(),
            ]);
        }

        //График
        $labels = [];
        $createdData = [];
        $completedData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);

            $labels[] = $date->format('d.m');

            $createdData[] = Task::whereDate('created_at', $date)->count();
            $completedData[] = Task::whereDate('completed_at', $date)->count();
        }

        return view('dashboard.metric', compact(
            'totalTasks',
            'completedTasks',
            'activeTasks',
            'overdueTasks',
            'progress',
            'created',
            'completed',
            'balance',
            'completionRatio',
            'createdWeek',
            'completedWeek',
            'balanceWeek',
            'completionRatioWeek',
            'days',
            'labels',
            'createdData',
            'completedData',
        ));
    }
}
