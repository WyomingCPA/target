<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CoinTransaction extends Model
{
    use HasFactory;
    public const TYPE_EARN = 'earn';
    public const TYPE_SPEND = 'spend';
    public const TYPE_PENALTY = 'penalty';
    protected $fillable = [
        'user_id',
        'task_id',
        'amount',
        'type',
        'description',
    ];

    protected $casts = [
        'amount' => 'integer',
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

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeEarn($query)
    {
        return $query->where('type', 'earn');
    }

    public function scopeSpend($query)
    {
        return $query->where('type', 'spend');
    }

    public function scopePenalty($query)
    {
        return $query->where('type', 'penalty');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isPositive(): bool
    {
        return $this->amount > 0;
    }

    public function isNegative(): bool
    {
        return $this->amount < 0;
    }
}
