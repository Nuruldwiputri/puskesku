<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan user yang login
use App\Models\Doctor; // Import Model Doctor
use App\Models\Schedule; // Import Model Schedule
use App\Models\Appointment; // Import Model Appointment
use App\Enums\AppointmentStatusEnum;
use Carbon\Carbon; // Untuk bekerja dengan tanggal/waktu
use Illuminate\Validation\Rule;

class PatientController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        // Ambil janji temu mendatang pasien ini
        $upcomingAppointments = Appointment::where('user_id', $user->id)
                                        ->whereIn('status', [\App\Enums\AppointmentStatusEnum::Pending, \App\Enums\AppointmentStatusEnum::Approved])
                                        ->whereDate('appointment_date', '>=', Carbon::today())
                                        ->with(['doctor', 'schedule'])
                                        ->orderBy('appointment_date')
                                        ->orderBy('appointment_time')
                                        ->get();

        // Ambil riwayat janji temu pasien ini (yang sudah lewat atau selesai/batal)
        $pastAppointments = Appointment::where('user_id', $user->id)
                                    ->where(function($query) {
                                        $query->whereDate('appointment_date', '<', Carbon::today())
                                            ->orWhereIn('status', [\App\Enums\AppointmentStatusEnum::Completed, \App\Enums\AppointmentStatusEnum::Canceled, \App\Enums\AppointmentStatusEnum::Rejected]);
                                    })
                                    ->with(['doctor', 'schedule'])
                                    ->orderBy('appointment_date', 'desc')
                                    ->orderBy('appointment_time', 'desc')
                                    ->get();

        return view('pasien.dashboard', compact('user', 'upcomingAppointments', 'pastAppointments'));
    }

    public function schedules()
    {
        // Mengambil semua dokter beserta jadwalnya
        // Urutkan dokter berdasarkan nama
        $doctors = Doctor::with('schedules')->orderBy('name')->get();

        // Ambil jadwal hari ini untuk menyoroti
        $today = Carbon::now()->locale('id')->dayName; // Mengambil nama hari dalam bahasa Indonesia

        return view('pasien.schedules', compact('doctors', 'today'));
    }

    // Metode untuk membuat janji temu akan ditambahkan di langkah selanjutnya
    // Metode untuk melihat history dan cetak nomor antrean akan ditambahkan di langkah selanjutnya
    public function showAppointmentForm(Request $request)
    {
        $doctors = Doctor::orderBy('name')->get();
        $selectedDoctorId = $request->input('doctor_id'); // Ambil dari request jika ada
        $selectedDate = $request->input('appointment_date'); // Ambil dari request jika ada

        // Jika dokter dan tanggal sudah dipilih, ambil jadwal yang tersedia
        $availableSchedules = collect(); // Koleksi kosong default
        if ($selectedDoctorId && $selectedDate) {
            $dayOfWeek = Carbon::parse($selectedDate)->locale('id')->dayName; // Dapatkan nama hari dari tanggal
            $schedulesForSelectedDoctor = Schedule::where('doctor_id', $selectedDoctorId)
                                                  ->where('day_of_week', $dayOfWeek)
                                                  ->orderBy('start_time')
                                                  ->get();

            // Periksa ketersediaan berdasarkan max_appointments dan janji yang sudah ada
            foreach ($schedulesForSelectedDoctor as $schedule) {
                $bookedAppointmentsCount = Appointment::where('schedule_id', $schedule->id)
                                                      ->where('appointment_date', $selectedDate)
                                                      ->whereIn('status', [AppointmentStatusEnum::Pending, AppointmentStatusEnum::Approved]) // Hanya hitung yang masih aktif
                                                      ->count();

                if ($schedule->max_appointments === 0 || $bookedAppointmentsCount < $schedule->max_appointments) {
                    // Jadwal ini tersedia
                    $availableSchedules->push($schedule);
                }
            }
        }


        return view('pasien.create-appointment', compact('doctors', 'selectedDoctorId', 'selectedDate', 'availableSchedules'));
    }

    public function storeAppointment(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today', // Tanggal tidak boleh di masa lalu
            'schedule_id' => 'required|exists:schedules,id',
            'notes' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        $doctor = Doctor::findOrFail($request->doctor_id);
        $schedule = Schedule::findOrFail($request->schedule_id);

        // Validasi tambahan: Pastikan jadwal yang dipilih benar-benar milik dokter yang dipilih
        if ($schedule->doctor_id !== $doctor->id) {
            return back()->withErrors(['schedule_id' => 'Jadwal yang dipilih tidak sesuai dengan dokter.'])->withInput();
        }

        // Validasi tambahan: Pastikan jadwal tersedia untuk tanggal yang dipilih dan hari yang benar
        $dayOfWeekForSelectedDate = Carbon::parse($request->appointment_date)->locale('id')->dayName;
        if ($schedule->day_of_week !== $dayOfWeekForSelectedDate) {
             return back()->withErrors(['appointment_date' => 'Tanggal yang dipilih tidak sesuai dengan hari praktik dokter.'])->withInput();
        }

        // Validasi ketersediaan slot (race condition check)
        $bookedAppointmentsCount = Appointment::where('schedule_id', $schedule->id)
                                              ->where('appointment_date', $request->appointment_date)
                                              ->whereIn('status', [AppointmentStatusEnum::Pending, AppointmentStatusEnum::Approved])
                                              ->count();

        if ($schedule->max_appointments > 0 && $bookedAppointmentsCount >= $schedule->max_appointments) {
            return back()->with('error', 'Maaf, slot janji temu untuk jadwal ini pada tanggal tersebut sudah penuh. Silakan pilih jadwal lain.')->withInput();
        }

        // Pastikan pasien belum punya janji yang sama (user, dokter, tanggal, waktu)
        $existingAppointment = Appointment::where('user_id', $user->id)
                                          ->where('doctor_id', $doctor->id)
                                          ->where('appointment_date', $request->appointment_date)
                                          ->where('appointment_time', $schedule->start_time) // Menggunakan start_time dari jadwal
                                          ->whereIn('status', [AppointmentStatusEnum::Pending, AppointmentStatusEnum::Approved])
                                          ->first();

        if ($existingAppointment) {
            return back()->with('error', 'Anda sudah memiliki janji temu aktif dengan dokter ini pada tanggal dan waktu yang sama.')->withInput();
        }

        Appointment::create([
            'user_id' => $user->id,
            'doctor_id' => $doctor->id,
            'schedule_id' => $schedule->id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $schedule->start_time, // Ambil waktu mulai dari jadwal
            'queue_number' => null, // Nomor antrean akan diisi admin saat approve
            'status' => AppointmentStatusEnum::Pending, // Status awal selalu pending
            'notes' => $request->notes,
        ]);

        return redirect()->route('pasien.dashboard')->with('success', 'Janji temu berhasil dibuat! Mohon tunggu konfirmasi dari admin.');
    }
    public function history()
    {
        $user = Auth::user();
        // Ambil semua janji temu pasien ini, urutkan berdasarkan tanggal terbaru
        $appointments = Appointment::where('user_id', $user->id)
                                ->with(['doctor', 'schedule'])
                                ->orderBy('appointment_date', 'desc')
                                ->orderBy('appointment_time', 'desc')
                                ->get();

        return view('pasien.history', compact('appointments'));
    }

    public function printQueue(Appointment $appointment) // Menggunakan Route Model Binding
    {
        $user = Auth::user();

        // Pastikan janji temu adalah milik user yang login
        if ($appointment->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke janji temu ini.');
        }

        // Pastikan status janji temu sudah Approved dan memiliki nomor antrean
        if ($appointment->status !== AppointmentStatusEnum::Approved || is_null($appointment->queue_number)) {
            return back()->with('error', 'Nomor antrean belum tersedia atau janji temu belum disetujui.');
        }

        return view('pasien.print-queue', compact('appointment'));
    }
}