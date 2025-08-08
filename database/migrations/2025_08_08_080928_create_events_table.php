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
            $table->string('name'); // Nama event
            $table->date('date'); // Tanggal event terlaksana
            $table->string('location'); // Lokasi event
            $table->boolean('is_paid')->default(false); // Apakah event berbayar
            $table->string('eo'); // Event organizer
            $table->string('ticket_link')->nullable(); // Link Instagram/web tiket (kalau berbayar)
            $table->string('poster'); // Nama file poster event
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
