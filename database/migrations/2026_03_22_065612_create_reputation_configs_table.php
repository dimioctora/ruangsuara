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
        Schema::create('reputation_configs', function (Blueprint $table) {
            $table->id();
            $table->string('action_slug')->unique();
            $table->string('action_name');
            $table->integer('xp_reward')->default(0);
            $table->float('trust_bonus')->default(0);
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reputation_configs');
    }
};
