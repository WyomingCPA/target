<?php

namespace App\Http\Controllers\coins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CoinTransaction;
use App\Models\User;

class CoinController extends Controller
{
    public function addCoins(Request $request)
    {
        $user = User::first(); // если пользователь один

        $amount_count = $request->input('amount');

        $amount = config('coins.fixed_amount', $amount_count);

        // Начисляем coins
        $user->increment('coins', $amount);

        // Регистрируем транзакцию
        CoinTransaction::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'type' => 'earn',
            'description' => "Пополнение на сумму {$amount} coins",
        ]);

        return back()->with('success', "{$amount} coins начислено!");
    }
}
