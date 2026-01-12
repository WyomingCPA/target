<?php
return [

    'default' => [
        'label' => 'Универсальная задача',
        'main' => [
            'priority' => 2,
        ],
        'subtasks' => [
            ['title' => 'Понять требования', 'priority' => 1],
            ['title' => 'Разбить на этапы', 'priority' => 1],
            ['title' => 'Реализация', 'priority' => 2],
            ['title' => 'Проверка результата', 'priority' => 2],
            ['title' => 'Завершение', 'priority' => 3],
        ],
    ],

    'laravel_feature' => [
        'label' => 'Фича Laravel',
        'main' => [
            'priority' => 2,
        ],
        'subtasks' => [
            ['title' => 'Проектирование модели', 'priority' => 1],
            ['title' => 'Миграции', 'priority' => 1],
            ['title' => 'Контроллеры', 'priority' => 2],
            ['title' => 'Blade / UI', 'priority' => 2],
            ['title' => 'Тестирование', 'priority' => 3],
        ],
    ],

];