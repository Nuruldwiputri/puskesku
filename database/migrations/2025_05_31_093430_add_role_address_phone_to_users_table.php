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
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom role
            $table->enum('role', ['admin', 'pasien'])->default('pasien')->after('password');
            // Menambahkan kolom address dan phone_number (nullable karena mungkin tidak semua mengisi saat daftar)
            $table->text('address')->nullable()->after('role');
            $table->string('phone_number')->nullable()->after('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menghapus kolom jika migrasi di-rollback
            $table->dropColumn(['role', 'address', 'phone_number']);
        });
    }
};