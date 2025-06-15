<?php

namespace Database\Seeders;

use App\Models\User; // Pastikan ini sudah ada atau tambahkan
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Tambahkan ini

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat 1 user admin (jika belum ada)
        User::firstOrCreate(
            ['email' => 'admin@example.com'], // Kriteria unik
            [
                'name' => 'Admin Puskesmas',
                'password' => Hash::make('password'), // Password untuk admin
                'role' => 'admin', // Role admin
                'address' => 'Jl. Admin No. 1',
                'phone_number' => '081234567890',
            ]
        );

        // Buat 1 user pasien utama (jika belum ada)
        User::firstOrCreate(
            ['email' => 'pasien@example.com'], // Kriteria unik
            [
                'name' => 'Pasien Utama',
                'password' => Hash::make('password'), // Password untuk pasien
                'role' => 'pasien', // Role pasien
                'address' => 'Jl. Pasien No. 10',
                'phone_number' => '089876543210',
            ]
        );


        // Panggil seeder lain yang akan kita buat
        $this->call([
            DoctorSeeder::class,
            UserSeeder::class, // Untuk user pasien tambahan
            ScheduleSeeder::class,
            AppointmentSeeder::class,
        ]);
    }
}