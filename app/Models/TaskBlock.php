<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TaskBlock extends Model
{
    protected $fillable = [
        'title',
        'description',
        'is_closed',
        'closed_at',
    ];
    protected function casts(): array
    {
        return [
            'is_closed' => 'boolean',
            'closed_at' => 'datetime',
        ];
    }
    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(
            Task::class,
            'task_block',
            'task_block_id',
            'task_id'
        )->withTimestamps();
    }
}
