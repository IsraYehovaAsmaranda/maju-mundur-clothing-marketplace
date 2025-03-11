<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function transactions(): HasMany {
        return $this->hasMany(Transaction::class, 'product_id', 'id');
    }
}
