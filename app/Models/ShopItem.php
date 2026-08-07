<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopItem extends Model
{
    protected $fillable = [
        'title',
        'description',
        'price',
        'repeatable',
    ];
    public function purchases()
    {
        return $this->hasMany(ShopPurchase::class);
    }
}
