<?php 
namespace App\Services;

use App\Models\Task;

class TaskTemplateGenerator
{
    public function generate(string $templateKey, int $projectId = null)
    {
        $templates = config('task_templates');

        if (!isset($templates[$templateKey])) {
            throw new \Exception('Шаблон не найден');
        }

        foreach ($templates[$templateKey]['tasks'] as $index => $task) {
            Task::create([
                'title'      => $task['title'],
                'priority'   => $task['priority'] ?? 3,
                'project_id' => $projectId,
                'status'     => 'todo',
                'sort_order' => $index + 1,
            ]);
        }
    }
}