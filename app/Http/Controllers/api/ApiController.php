<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CoinService;

use App\Models\Smoke;
use App\Models\User;

class ApiController extends Controller
{
    public function storeSmoke(Request $request, CoinService $coinService)
    {
        $user = User::first(); // если пользователь один
        $coinService->registerSmoke($user);
        $lastSmoke = Smoke::latest('smoked_at')->first();

        return response()->json([
            'last_smoke' => $lastSmoke->created_at,
            'status' => true,
        ], 200);
    }
}
