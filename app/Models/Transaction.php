<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    protected $fillable = [
        'customer_id',
        'transaction_date',
    ];
    public function details(): HasMany {
        return $this->hasMany(TransactionDetail::class);
    }
    public function customer(): BelongsTo {
        return $this->belongsTo(User::class, "customer_id", "id");
    }
}
