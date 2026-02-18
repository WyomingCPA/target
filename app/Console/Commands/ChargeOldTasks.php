<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CoinService;

use App\Models\User;

class ChargeOldTasks extends Command
{
    protected $signature = 'coins:charge-old-tasks {days=14} {penalty=1}';
    protected $description = 'Списание coins за старые незавершённые задачи';

    private CoinService $coinService;

    public function __construct(CoinService $coinService)
    {
        parent::__construct();
        $this->coinService = $coinService;
    }

    public function handle(): int
    {
        $days = (int) $this->argument('days');
        $penalty = (int) $this->argument('penalty');

        $this->info("Списание за задачи старше {$days} дней, штраф {$penalty} coins...");

        $user = User::first(); // один пользователь
        if (!$user) {
            $this->error('Пользователь не найден!');
            return 1;
        }

        try {
            $this->coinService->chargeOldTasks($user, $days, $penalty);
            $this->info('Штрафы начислены.');
        } catch (\Exception $e) {
            $this->error('Ошибка: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
