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
        Schema::create('finance_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('suara_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['inbound', 'outbound']);
            $table->string('sector')->nullable(); // e.g. logistics, comms, medical
            $table->decimal('amount', 15, 2);
            $table->string('description');
            $table->string('status')->default('secured');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finance_transactions');
    }
};
