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
        Schema::table('suaras', function (Blueprint $table) {
            $table->integer('supporter_count')->default(0);
            $table->integer('opponent_count')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('suaras', function (Blueprint $table) {
            $table->dropColumn(['supporter_count', 'opponent_count']);
        });
    }
};
