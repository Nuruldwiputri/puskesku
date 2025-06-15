<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Import Model User
use App\Models\Doctor; // Import Model Doctor
use App\Models\Appointment; // Import Model Appointment
use App\Models\Schedule; // Import Model Schedule
use App\Enums\AppointmentStatusEnum;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Untuk menampilkan ringkasan data di dashboard admin
        $totalPatients = User::where('role', 'pasien')->count();
        $totalDoctors = Doctor::count();
        $totalPendingAppointments = Appointment::where('status', 'pending')->count();
        $totalSchedules = Schedule::count();

        return view('admin.dashboard', compact('totalPatients', 'totalDoctors', 'totalPendingAppointments', 'totalSchedules'));
    }

    public function patients()
    {
        // Menampilkan daftar seluruh pasien (role 'pasien')
        $patients = User::where('role', 'pasien')->latest()->get(); // Mengambil data pasien terbaru
        return view('admin.patients.index', compact('patients'));
    }

    public function doctors()
    {
        // Menampilkan daftar seluruh dokter
        $doctors = Doctor::latest()->get();
        return view('admin.doctors.index', compact('doctors'));
    }

    public function appointments()
    {
        // Menampilkan daftar seluruh janji temu beserta user dan dokter yang terkait
        $appointments = Appointment::with(['user', 'doctor', 'schedule'])
                                ->orderBy('appointment_date', 'asc')
                                ->orderBy('appointment_time', 'asc')
                                ->get();
        
        return view('admin.appointments.index', compact('appointments'));
    }

    public function schedules()
    {
        // Menampilkan daftar seluruh jadwal dokter
        $schedules = Schedule::with('doctor')->latest()->get();
        return view('admin.schedules.index', compact('schedules'));
    }
    public function createDoctor()
    {
        return view('admin.doctors.create');
    }

    public function storeDoctor(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'email' => 'nullable|string|email|max:255|unique:doctors,email', // Email harus unik di tabel doctors
        ]);

        Doctor::create($request->all());

        return redirect()->route('admin.doctors')->with('success', 'Dokter berhasil ditambahkan!');
    }
    public function editDoctor(Doctor $doctor) // Menggunakan Route Model Binding
    {
        return view('admin.doctors.edit', compact('doctor'));
    }

    public function updateDoctor(Request $request, Doctor $doctor) // Menggunakan Route Model Binding
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            // Rule::unique('doctors', 'email')->ignore($doctor->id) memastikan email unik kecuali untuk dokter yang sedang diedit
            'email' => ['nullable', 'string', 'email', 'max:255', Rule::unique('doctors', 'email')->ignore($doctor->id)],
        ]);

        $doctor->update($request->all());

        return redirect()->route('admin.doctors')->with('success', 'Data dokter berhasil diperbarui!');
    }

    public function destroyDoctor(Doctor $doctor) // Menggunakan Route Model Binding
    {
        $doctor->delete();
        return redirect()->route('admin.doctors')->with('success', 'Dokter berhasil dihapus!');
    }
    public function createSchedule()
    {
        $doctors = Doctor::orderBy('name')->get(); // Ambil semua dokter untuk dropdown
        return view('admin.schedules.create', compact('doctors'));
    }

    public function storeSchedule(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'day_of_week' => ['required', 'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu'],
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'max_appointments' => 'required|integer|min:0',
        ]);

        // Validasi unik kombinasi dokter, hari, waktu
        // Kita punya unique(['doctor_id', 'day_of_week', 'start_time', 'end_time']) di migrasi
        // Jadi, kita bisa menggunakan validasi custom atau Rule::unique() jika ingin pesan error spesifik
        $existingSchedule = Schedule::where('doctor_id', $request->doctor_id)
                                    ->where('day_of_week', $request->day_of_week)
                                    ->where('start_time', $request->start_time)
                                    ->where('end_time', $request->end_time)
                                    ->first();
        if ($existingSchedule) {
            return back()->withErrors(['unique_schedule' => 'Jadwal untuk dokter ini pada hari dan waktu yang sama sudah ada.'])->withInput();
        }


        Schedule::create($request->all());

        return redirect()->route('admin.schedules')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function editSchedule(Schedule $schedule) // Menggunakan Route Model Binding
    {
        $doctors = Doctor::orderBy('name')->get();
        return view('admin.schedules.edit', compact('schedule', 'doctors'));
    }

    public function updateSchedule(Request $request, Schedule $schedule) // Menggunakan Route Model Binding
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'day_of_week' => ['required', 'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu'],
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'max_appointments' => 'required|integer|min:0',
        ]);

        // Validasi unik saat update, abaikan jadwal yang sedang diedit
        $existingSchedule = Schedule::where('doctor_id', $request->doctor_id)
                                    ->where('day_of_week', $request->day_of_week)
                                    ->where('start_time', $request->start_time)
                                    ->where('end_time', $request->end_time)
                                    ->where('id', '!=', $schedule->id) // Abaikan ID jadwal saat ini
                                    ->first();
        if ($existingSchedule) {
            return back()->withErrors(['unique_schedule' => 'Jadwal untuk dokter ini pada hari dan waktu yang sama sudah ada.'])->withInput();
        }

        $schedule->update($request->all());

        return redirect()->route('admin.schedules')->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function destroySchedule(Schedule $schedule) // Menggunakan Route Model Binding
    {
        try {
            $schedule->delete();
            return redirect()->route('admin.schedules')->with('success', 'Jadwal berhasil dihapus!');
        } catch (\Illuminate\Database\QueryException $e) {
            // Tangani kasus jika ada janji temu yang terhubung (foreign key constraint)
            if ($e->getCode() == 23000) { // Kode SQLSTATE untuk integrity constraint violation
                return back()->with('error', 'Tidak dapat menghapus jadwal ini karena ada janji temu yang terkait dengannya.');
            }
            throw $e; // Lempar exception lain jika bukan masalah foreign key
        }
    }
    public function updateAppointmentStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => ['required', Rule::enum(AppointmentStatusEnum::class)], // Validasi menggunakan Enum
        ]);

        $appointment->status = $request->status; // Update status
        $appointment->save();

        // Opsional: Generate queue_number jika status diubah ke 'approved' dan belum ada
        if ($appointment->status === AppointmentStatusEnum::Approved && is_null($appointment->queue_number)) {
            // Cari nomor antrean terakhir untuk dokter dan tanggal ini
            $lastQueue = Appointment::where('doctor_id', $appointment->doctor_id)
                                    ->where('appointment_date', $appointment->appointment_date)
                                    ->max('queue_number');
            $appointment->queue_number = ($lastQueue ?? 0) + 1;
            $appointment->save();
        }

        return redirect()->route('admin.appointments')->with('success', 'Status janji temu berhasil diperbarui!');
    }
}