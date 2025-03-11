<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('point_reward_redeems', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('reward_id')->references('id')->on('point_rewards');
            $table->foreignId('customer_id')->references('id')->on('users');
            $table->dateTime('redeem_date');
            $table->integer('cost');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('point_reward_redeems');
    }
};
