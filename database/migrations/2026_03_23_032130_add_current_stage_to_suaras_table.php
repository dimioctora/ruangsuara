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
            $table->integer('current_stage')->default(1)->after('fund_target');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suaras', function (Blueprint $table) {
            $table->dropColumn('current_stage');
        });
    }
};
