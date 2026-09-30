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
        Schema::create('transactions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('event_registration_id')->constrained()->onDelete('cascade');
    $table->string('transaction_id')->nullable();
    $table->decimal('gross_amount', 10, 2)->nullable();
    $table->enum('payment_status', ['menunggu', 'lunas', 'kedaluwarsa', 'batal'])->default('menunggu');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
