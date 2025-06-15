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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade'); // Foreign Key ke doctors
            $table->enum('day_of_week', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']);
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('max_appointments')->default(0); // Batas maksimal janji temu
            $table->timestamps();

            // Menambahkan unique constraint agar satu dokter tidak memiliki jadwal duplikat di hari yang sama
            $table->unique(['doctor_id', 'day_of_week', 'start_time', 'end_time'], 'unique_doctor_schedule');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};