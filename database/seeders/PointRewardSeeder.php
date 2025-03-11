<?php

namespace Database\Seeders;

use App\Models\PointReward;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PointRewardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PointReward::create([
            "name" => "Reward A",
            "cost" => 20
        ]);
        PointReward::create([
            "name" => "Reward B",
            "cost" => 40
        ]);
    }
}
