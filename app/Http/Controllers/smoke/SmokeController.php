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

        $todayCount = Smoke::whereDate('smoked_at', today())->count();
        $weekCount = Smoke::where('smoked_at', '>=', now()->subDays(7))->count();
        $totalCount = Smoke::count();
        $totalPenalty = Smoke::sum('penalty');

        return view('smokes.index', compact(
            'smokes',
            'todayCount',
            'weekCount',
            'totalCount',
            'totalPenalty'
        ));
    }
    public function store(CoinService $coinService)
    {
        $user = User::first(); // если пользователь один

        $coinService->registerSmoke($user);

        return back()->with('success', 'Сигарета зарегистрирована 🚬');
    }
}
