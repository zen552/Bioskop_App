<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel users dan schedules
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('schedule_id')->constrained()->onDelete('cascade');
            
            $table->string('seat_number'); // Contoh: 'A1', 'H10'
            $table->string('status')->default('sold'); // 'pending' atau 'sold'
            $table->timestamps();

            // Proteksi double-booking di tingkat database agar kursi yang sama 
            // di jadwal yang sama tidak bisa terisi dua kali
            $table->unique(['schedule_id', 'seat_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};