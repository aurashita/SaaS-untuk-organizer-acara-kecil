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
        Schema::create('events', function (Blueprint $table) {
    $table->id();
    $table->foreignId('organizer_id')->constrained('organizers')->onDelete('cascade'); // TODO: ganti ke 'organizers' nanti
    $table->string('name');
    $table->dateTime('date');
    $table->string('location');
    $table->text('description')->nullable();
    $table->integer('quota');
    $table->decimal('price', 10, 2)->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
