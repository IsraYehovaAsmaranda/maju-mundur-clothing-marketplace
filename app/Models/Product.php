<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        "merchant_id",
        "name",
        "description",
        "price",
        "stock",
    ];

    public function merchant(): BelongsTo {
        return $this->belongsTo(User::class, 'merchant_id', 'id');
    }
}
