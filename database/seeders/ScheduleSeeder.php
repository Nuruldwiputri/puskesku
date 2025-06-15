<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Doctor; // Import Model Doctor
use App\Models\Schedule; // Import Model Schedule

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = Doctor::all();
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat']; // Hari kerja

        foreach ($doctors as $doctor) {
            foreach ($days as $day) {
                // Setiap dokter punya jadwal di hari kerja
                Schedule::factory()->create([
                    'doctor_id' => $doctor->id,
                    'day_of_week' => $day,
                    'start_time' => '08:00:00', // Contoh jam
                    'end_time' => '12:00:00',
                    'max_appointments' => 10, // Batas 10 janji per jadwal
                ]);
                // Tambahkan jadwal sore untuk beberapa dokter
                if (rand(0, 1)) { // Acak untuk menambahkan jadwal sore
                     Schedule::factory()->create([
                        'doctor_id' => $doctor->id,
                        'day_of_week' => $day,
                        'start_time' => '14:00:00',
                        'end_time' => '17:00:00',
                        'max_appointments' => 8,
                    ]);
                }
            }
        }
    }
}