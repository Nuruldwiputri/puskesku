<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Appointment; // Import Model Appointment
use App\Models\User; // Import Model User
use App\Models\Doctor; // Import Model Doctor
use App\Models\Schedule; // Import Model Schedule
use App\Enums\AppointmentStatusEnum; // Import AppointmentStatusEnum
use Carbon\Carbon; // Untuk bekerja dengan tanggal dan waktu

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = User::where('role', 'pasien')->get();
        $doctors = Doctor::all();
        $schedules = Schedule::all();

        if ($patients->isEmpty() || $doctors->isEmpty() || $schedules->isEmpty()) {
            $this->command->info('Tidak cukup data untuk membuat janji temu. Pastikan UserSeeder, DoctorSeeder, dan ScheduleSeeder sudah dijalankan.');
            return;
        }

        $currentQueueNumber = 1;

        foreach ($patients as $patient) {
            // Buat 1-3 janji temu untuk setiap pasien
            for ($i = 0; $i < rand(1, 3); $i++) {
                $randomDoctor = $doctors->random();
                // Cari jadwal yang tersedia untuk dokter ini
                $availableSchedules = $schedules->where('doctor_id', $randomDoctor->id);

                if ($availableSchedules->isEmpty()) {
                    continue; // Lewati jika tidak ada jadwal untuk dokter ini
                }

                $randomSchedule = $availableSchedules->random();
                $appointmentDate = Carbon::now()->addDays(rand(1, 14))->startOfDay(); // Janji temu dalam 2 minggu ke depan
                $appointmentTime = Carbon::parse($randomSchedule->start_time)->addMinutes(rand(0, 3) * 15); // Waktu acak di awal jadwal

                // Pastikan kombinasi user, doctor, date, time adalah unik
                $existingAppointment = Appointment::where('user_id', $patient->id)
                                                ->where('doctor_id', $randomDoctor->id)
                                                ->where('appointment_date', $appointmentDate->toDateString())
                                                ->where('appointment_time', $appointmentTime->toTimeString())
                                                ->first();

                if ($existingAppointment) {
                    continue; // Lewati jika janji temu sudah ada
                }

                Appointment::create([
                    'user_id' => $patient->id,
                    'doctor_id' => $randomDoctor->id,
                    'schedule_id' => $randomSchedule->id,
                    'appointment_date' => $appointmentDate,
                    'appointment_time' => $appointmentTime,
                    'queue_number' => null, // Nomor antrean otomatis
                    'status' => AppointmentStatusEnum::cases()[rand(0, count(AppointmentStatusEnum::cases()) - 1)], // Status acak dari Enum
                    'notes' => fake()->sentence(3),
                ]);
            }
        }
    }
}