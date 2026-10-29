<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TaskBlock extends Model
{
    protected $fillable = [
        'title',
        'description',
    ];

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
