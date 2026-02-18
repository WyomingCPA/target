<?php

namespace App\Services;

use App\Models\User;
use App\Models\Task;
use App\Models\CoinTransaction;
use Illuminate\Support\Facades\DB;
use Exception;

class CoinService
{
    /**
     * Начислить коины за выполненную задачу
     */
    public function rewardForTask(Task $task): void
    {
        if ($task->coins_awarded) {
            return;
        }

        DB::transaction(function () use ($task) {

            $user = User::firstWhere('email', 'WyomingCPA@yandex.ru');

            $amount = $task->reward_coins;

            $user->increment('coins', $amount);

            $task->update([
                'coins_awarded' => true,
                'completed_at' => now(),
            ]);

            CoinTransaction::create([
                'user_id' => $user->id,
                'task_id' => $task->id,
                'amount' => $amount,
                'type' => 'earn',
                'description' => 'Task reward',
            ]);
        });
    }

    /**
     * Списать коины
     */
    public function spend(User $user, int $amount, string $description = null): void
    {
        if ($user->coins < $amount) {
            throw new Exception('Недостаточно средств');
        }

        DB::transaction(function () use ($user, $amount, $description) {

            $user->decrement('coins', $amount);

            CoinTransaction::create([
                'user_id' => $user->id,
                'amount' => -$amount,
                'type' => 'spend',
                'description' => $description,
            ]);
        });
    }

    /**
     * Ручное начисление (бонусы, админ, награды)
     */
    public function add(User $user, int $amount, string $description = null): void
    {
        DB::transaction(function () use ($user, $amount, $description) {

            $user->increment('coins', $amount);

            CoinTransaction::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'type' => 'earn',
                'description' => $description,
            ]);
        });
    }

    /**
     * Проверка баланса
     */
    public function hasEnough(User $user, int $amount): bool
    {
        return $user->coins >= $amount;
    }
}