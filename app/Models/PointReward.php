<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PointReward extends Model
{
    protected $fillable = [
        "name",
        "cost"
    ];

    public function pointRewardRedeem():HasMany {
        return $this->hasMany(PointRewardRedeem::class);
    }
}
