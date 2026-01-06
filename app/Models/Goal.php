<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $fillable = [
        'title',
        'description',
        'priority',
        'status',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
