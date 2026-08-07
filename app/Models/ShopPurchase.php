<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopPurchase extends Model
{
    protected $fillable = [
        'user_id',
        'shop_item_id',
        'used',
    ];
    public function shopItem()
    {
        return $this->belongsTo(ShopItem::class);
    }
}
