<?php

namespace App\Http\Controllers\coins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CoinTransaction;
use App\Models\User;

class CoinController extends Controller
{
public function addCoins()
{
    $user = User::first(); // если пользователь один

    $amount = config('coins.fixed_amount', 100);

    // Начисляем coins
    $user->increment('coins', $amount);

    // Регистрируем транзакцию
    CoinTransaction::create([
        'user_id' => $user->id,
        'amount' => $amount,
        'type' => 'deposit',
        'description' => "Пополнение на фиксированную сумму {$amount} coins(1000 руб)",
    ]);

    return back()->with('success', "{$amount} coins начислено!");
}
}
