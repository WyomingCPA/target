<?php

namespace App\Services;

use App\Models\User;
use App\Models\Task;
use App\Models\CoinTransaction;
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
     * Проверка баланса
     */
    public function hasEnough(User $user, int $amount): bool
    {
        return $user->coins >= $amount;
    }
}
