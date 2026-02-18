<?php

namespace App\Http\Controllers\smoke;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CoinService;

use App\Models\Smoke;
use App\Models\User;

class SmokeController extends Controller
{
    public function index()
    {
        $smokes = Smoke::latest('smoked_at')->paginate(20);

        $lastSmoke = Smoke::latest('smoked_at')->first();

        $timeSinceLast = $lastSmoke
            ? $lastSmoke->smoked_at->diffInMinutes(now())
            : null;

        $todaySmokes = Smoke::whereDate('smoked_at', today())->get();
        $todayCount = $todaySmokes->count();
        $todayPenalty = $todaySmokes->sum('penalty');

        $allSmokes = Smoke::orderBy('smoked_at')->get();

        // Средний интервал
        $intervals = [];
        for ($i = 1; $i < $allSmokes->count(); $i++) {
            $intervals[] = $allSmokes[$i - 1]
                ->smoked_at
                ->diffInMinutes($allSmokes[$i]->smoked_at);
        }

        $averageInterval = count($intervals)
            ? round(array_sum($intervals) / count($intervals))
            : null;

        $maxInterval = count($intervals)
            ? max($intervals)
            : null;

        return view('smokes.index', compact(
            'smokes',
            'timeSinceLast',
            'todayCount',
            'todayPenalty',
            'averageInterval',
            'maxInterval'
        ));
    }
    public function store(CoinService $coinService)
    {
        $user = User::first(); // если пользователь один

        $coinService->registerSmoke($user);

        return back()->with('success', 'Сигарета зарегистрирована 🚬');
    }
}
