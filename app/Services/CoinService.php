<?php

namespace App\Services;

use App\Models\User;
use App\Models\Task;
use App\Models\CoinTransaction;
use App\Models\Smoke;
use Illuminate\Support\Facades\DB;
use Exception;

class CoinService
{
    // допустимый минус
    private int $creditLimit = 500; // допустимо уходить в -500 coins
    private float $dailyInterestPercent = 10.0; // 10% в день на минус




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
    /**
     * Универсальное списание coins с допустимым минусом
     */
    public function spend(
        User $user,
        int $amount,
        string $description = null,
        ?Task $task = null
    ): void {
        if ($amount <= 0) {
            throw new Exception('Amount must be positive');
        }

        DB::transaction(function () use ($user, $amount, $description, $task) {

            $user->refresh();

            $newBalance = $user->coins - $amount;

            if ($newBalance < -$this->creditLimit) {
                throw new Exception('Превышен лимит кредита');
            }

            $user->decrement('coins', $amount);

            CoinTransaction::create([
                'user_id' => $user->id,
                'task_id' => $task?->id,
                'amount' => -$amount,
                'type' => CoinTransaction::TYPE_SPEND,
                'description' => $description,
            ]);
        });
    }

    /**
     * Начисление процентов на минусовой баланс
     * Запускать раз в день через Cron
     */
    public function chargeInterest(User $user): void
    {
        DB::transaction(function () use ($user) {
            $user->refresh();

            if ($user->coins < 0) {
                $interest = ceil(abs($user->coins) * ($this->dailyInterestPercent / 100));

                $user->decrement('coins', $interest);

                CoinTransaction::create([
                    'user_id' => $user->id,
                    'amount' => -$interest,
                    'type' => CoinTransaction::TYPE_PENALTY,
                    'description' => 'Начисление процента на минусовый баланс',
                ]);
            }
        });
    }

    /**
     * Начисление coins
     */
    public function earn(User $user, int $amount, string $description = null, ?Task $task = null): void
    {
        if ($amount <= 0) {
            throw new Exception('Amount must be positive');
        }

        DB::transaction(function () use ($user, $amount, $description, $task) {

            $user->increment('coins', $amount);

            CoinTransaction::create([
                'user_id' => $user->id,
                'task_id' => $task?->id,
                'amount' => $amount,
                'type' => CoinTransaction::TYPE_EARN,
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
     * Списание за старые незавершённые задачи
     * @param User $user
     * @param int $days Старше скольких дней считать старой
     * @param int $penalty Сколько списывать за задачу
     */
    public function chargeOldTasks(User $user, int $days = 14, int $penalty = 1): void
    {
        $thresholdDate = now()->subDays($days);

        $tasks = Task::whereNotNull('parent_id')
            ->where('created_at', '<', now()->subDays($days))
            ->whereIn('status', ['todo', 'in_progress'])
            ->with(['parent', 'project'])
            ->orderBy('created_at')
            ->get();

        foreach ($tasks as $task) {
            DB::transaction(function () use ($user, $task, $penalty) {
                // Можно не менять статус задачи, просто штрафуем
                $user->decrement('coins', $penalty);

                CoinTransaction::create([
                    'user_id' => $user->id,
                    'task_id' => $task->id,
                    'amount' => -$penalty,
                    'type' => CoinTransaction::TYPE_PENALTY,
                    'description' => 'Списание за старую незавершённую задачу',
                ]);
            });
        }
    }

    /**
     * "Продлить" задачу за coins
     * @param User $user
     * @param Task $task
     * @param int $cost Стоимость продления
     */
    public function refreshTask(User $user, Task $task, int $cost = 2): void
    {
        DB::transaction(function () use ($user, $task, $cost) {

            //if ($user->coins < $cost) {
            //    throw new \Exception('Недостаточно coins для продления задачи');
            //}

            // Списываем деньги
            $user->decrement('coins', $cost);

            // Обновляем created_at на текущий момент
            $task->update([
                'created_at' => now(),
            ]);

            // Записываем транзакцию
            CoinTransaction::create([
                'user_id' => $user->id,
                'task_id' => $task->id,
                'amount' => -$cost,
                'type' => CoinTransaction::TYPE_SPEND,
                'description' => 'Продление задачи (обновление времени создания)',
            ]);
        });
    }

    public function registerSmoke(User $user): void
    {
        DB::transaction(function () use ($user) {

            $lastSmoke = Smoke::where('user_id', $user->id)
                ->latest('smoked_at')
                ->first();

            $now = now();
            $penalty = 1; // базовый штраф

            if ($lastSmoke) {
                $minutes = $lastSmoke->smoked_at->diffInMinutes($now);

                if ($minutes < 30) {
                    $penalty = 6;
                } elseif ($minutes < 60) {
                    $penalty = 4;
                } elseif ($minutes < 180) {
                    $penalty = 2;
                }
            }

            // списываем coins (может уходить в минус)
            $user->decrement('coins', $penalty);

            // создаём запись
            Smoke::create([
                'user_id' => $user->id,
                'smoked_at' => $now,
                'penalty' => $penalty,
            ]);

            // записываем транзакцию
            CoinTransaction::create([
                'user_id' => $user->id,
                'amount' => -$penalty,
                'type' => CoinTransaction::TYPE_PENALTY,
                'description' => "Сигарета (−{$penalty})",
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
