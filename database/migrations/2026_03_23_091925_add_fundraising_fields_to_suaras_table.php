<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('suaras', function (Blueprint $table) {
            $table->boolean('is_fundraising')->default(false);
            $table->bigInteger('fund_target')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('suaras', function (Blueprint $table) {
            $table->dropColumn(['is_fundraising', 'fund_target']);
        });
    }
};
