<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Doctor; // Import Model Doctor

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat beberapa dokter dummy
        Doctor::factory()->count(5)->create(); // Membuat 5 dokter dummy menggunakan factory
    }
}