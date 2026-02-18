<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Services\CoinService;


class ChargeInterest extends Command
{
    protected $signature = 'coins:charge-interest';
    protected $description = 'Начисляет проценты на минусовой баланс пользователя';

    private CoinService $coinService;

    public function __construct(CoinService $coinService)
    {
        parent::__construct();
        $this->coinService = $coinService;
    }

    public function handle(): int
    {
        $this->info('Начисление процентов на минусовой баланс...');

        $user = User::first(); // если один пользователь
        if (!$user) {
            $this->error('Пользователь не найден!');
            return 1;
        }

        try {
            $this->coinService->chargeInterest($user);
            $this->info('Проценты успешно начислены.');
        } catch (\Exception $e) {
            $this->error('Ошибка: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
