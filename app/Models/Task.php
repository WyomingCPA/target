<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'project_id',
        'parent_id',
        'title',
        'description',
        'type',
        'status',
        'priority',
        'due_date',
        'completed_at'
    ];

    protected $casts = [
        'due_date' => 'date',
        'completed_at' => 'datetime',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Подзадачи
    public function subtasks()
    {
        return $this->hasMany(Task::class, 'parent_id');
    }

    // Родительская задача
    public function parent()
    {
        return $this->belongsTo(Task::class, 'parent_id');
    }
    public function scopeCompleted($query)
    {
        return $query
            ->where('status', 'done')
            ->whereNull('parent_id'); // ⛔ не подзадачи
    }
}
