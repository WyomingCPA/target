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
    'add_tasks_habit' => [
        'label' => 'Добавлять задачи в сервис',
        'main' => [
            'priority' => 1, // ключевая цель — привычка
        ],
        'subtasks' => [
            ['title' => 'Просмотреть цели и идеи на день/неделю', 'priority' => 1],
            ['title' => 'Выбрать одну задачу для добавления', 'priority' => 1],
            ['title' => 'Добавить задачу в сервис с подзадачами', 'priority' => 1],
            ['title' => 'Проверить, что задача понятна и завершима', 'priority' => 2],
            ['title' => 'Отметить выполнение мета-задачи', 'priority' => 2],
        ],
    ],

];
