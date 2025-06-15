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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign Key ke users
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade'); // Foreign Key ke doctors
            $table->foreignId('schedule_id')->constrained('schedules')->onDelete('cascade'); // Foreign Key ke schedules
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->integer('queue_number')->nullable(); // BARIS YANG BENAR    
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed', 'canceled'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();

            // Agar tidak ada janji temu yang sama persis
            $table->unique(['user_id', 'doctor_id', 'appointment_date', 'appointment_time'], 'unique_user_appointment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};