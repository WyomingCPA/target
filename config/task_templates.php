<?php

return [

    'laravel_project' => [
        'label' => 'Laravel проект',
        'tasks' => [
            [
                'title' => 'Инициализация проекта',
                'priority' => 1,
            ],
            [
                'title' => 'Настройка .env и окружения',
                'priority' => 1,
            ],
            [
                'title' => 'Проектирование БД',
                'priority' => 2,
            ],
            [
                'title' => 'Реализация CRUD сущностей',
                'priority' => 2,
            ],
            [
                'title' => 'Тестирование',
                'priority' => 3,
            ],
            [
                'title' => 'Деплой проекта',
                'priority' => 3,
            ],
        ],
    ],

    'telegram_bot' => [
        'label' => 'Telegram бот',
        'tasks' => [
            [
                'title' => 'Создать бота через BotFather',
                'priority' => 1,
            ],
            [
                'title' => 'Настроить webhook / polling',
                'priority' => 1,
            ],
            [
                'title' => 'Реализовать команды',
                'priority' => 2,
            ],
            [
                'title' => 'Логирование и ошибки',
                'priority' => 2,
            ],
            [
                'title' => 'Деплой бота',
                'priority' => 3,
            ],
        ],
    ],

];