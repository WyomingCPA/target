<?php

namespace App\Services;

use App\Models\Task;

class TaskDecompositionGenerator
{
    public function generate(
        string $title,
        string $templateKey = 'default',
        int $projectId = null
    ): Task {
        $templates = config('task_decomposition');

        if (! isset($templates[$templateKey])) {
            throw new \Exception('Шаблон не найден');
        }

        $template = $templates[$templateKey];

        // 1️⃣ Основная задача
        $parentTask = Task::create([
            'title'      => $title,
            'priority'   => $template['main']['priority'] ?? 2,
            'project_id' => $projectId,
            'status'     => 'todo',
        ]);

        // 2️⃣ Подзадачи
        foreach ($template['subtasks'] as $index => $sub) {
            Task::create([
                'title'      => $sub['title'],
                'priority'   => $sub['priority'] ?? 3,
                'project_id' => $projectId,
                'parent_id'  => $parentTask->id,
                'status'     => 'todo',
                'sort_order' => $index + 1,
            ]);
        }

        return $parentTask;
    }
}