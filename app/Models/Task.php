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
    ];

    protected $casts = [
        'due_date' => 'date',
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
}
