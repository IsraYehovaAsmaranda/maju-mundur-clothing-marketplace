<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionDetail extends Model
{
    protected $fillable = [
        'transaction_id',
        'product_id',
        'quantity',
        'sale_price',
    ];

    public function product(): BelongsTo {
        return $this->belongsTo(Product::class);
    }

    public function transaction(): BelongsTo {
        return $this->belongsTo(Transaction::class);
    }
}
