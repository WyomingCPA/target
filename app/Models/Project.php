<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'goal_id',
        'title',
        'description',
        'tech_stack',
        'status',
    ];

    protected $casts = [
        'tech_stack' => 'array',
    ];

    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
