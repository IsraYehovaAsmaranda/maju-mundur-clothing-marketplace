<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PointRewardRedeem extends Model
{
    protected $fillable = [
        "reward_id",
        "customer_id",
        "redeem_date",
        "cost"
    ];

    public function customer(): BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function reward(): BelongsTo{
        return $this->belongsTo(PointReward::class);
    }
}
