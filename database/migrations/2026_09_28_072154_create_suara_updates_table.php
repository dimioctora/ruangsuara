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
        Schema::create('suara_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('suara_id')->constrained('suaras')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('content');
            $table->unsignedTinyInteger('stage')->nullable()->default(3);
            $table->string('image')->nullable();
            $table->string('reference_link')->nullable();
            $table->boolean('is_official')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suara_updates');
    }
};
