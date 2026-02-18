<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Smoke extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'smoked_at',
        'penalty',
    ];

    protected $casts = [
        'smoked_at' => 'datetime',
        'penalty' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('smoked_at', today());
    }

    public function scopeForUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function minutesSince(): int
    {
        return $this->smoked_at->diffInMinutes(now());
    }

    public static function lastForUser(int $userId): ?self
    {
        return static::where('user_id', $userId)
            ->latest('smoked_at')
            ->first();
    }
}