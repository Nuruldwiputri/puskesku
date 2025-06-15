<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AdminController; // Pastikan ini sudah ada
use App\Http\Controllers\Patient\PatientController;

Route::get('/', function () {
    return view('welcome');
});

// Rute untuk Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Rute dashboard admin (sudah benar)
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // --- TAMBAHKAN KEMBALI BARIS-BARIS INI ---
    Route::get('/admin/patients', [AdminController::class, 'patients'])->name('admin.patients');
    Route::get('/admin/doctors', [AdminController::class, 'doctors'])->name('admin.doctors');
    Route::get('/admin/appointments', [AdminController::class, 'appointments'])->name('admin.appointments');
    Route::get('/admin/schedules', [AdminController::class, 'schedules'])->name('admin.schedules');
    // --- AKHIR TAMBAHAN ---
    // Rute untuk mengelola Dokter
    Route::get('/admin/doctors/create', [AdminController::class, 'createDoctor'])->name('admin.doctors.create');
    Route::post('/admin/doctors', [AdminController::class, 'storeDoctor'])->name('admin.doctors.store');
    Route::get('/admin/doctors/{doctor}/edit', [AdminController::class, 'editDoctor'])->name('admin.doctors.edit'); // Rute Edit (GET)
    Route::patch('/admin/doctors/{doctor}', [AdminController::class, 'updateDoctor'])->name('admin.doctors.update'); // Rute Update (PATCH)
    Route::delete('/admin/doctors/{doctor}', [AdminController::class, 'destroyDoctor'])->name('admin.doctors.destroy'); // Rute Delete (DELETE)
    // Rute CRUD untuk Jadwal Dokter
    Route::get('/admin/schedules', [AdminController::class, 'schedules'])->name('admin.schedules'); // Pastikan ini ada
    Route::get('/admin/schedules/create', [AdminController::class, 'createSchedule'])->name('admin.schedules.create');
    Route::post('/admin/schedules', [AdminController::class, 'storeSchedule'])->name('admin.schedules.store');
    Route::get('/admin/schedules/{schedule}/edit', [AdminController::class, 'editSchedule'])->name('admin.schedules.edit');
    Route::patch('/admin/schedules/{schedule}', [AdminController::class, 'updateSchedule'])->name('admin.schedules.update');
    Route::delete('/admin/schedules/{schedule}', [AdminController::class, 'destroySchedule'])->name('admin.schedules.destroy');
    // Rute untuk mengelola Janji Temu
    Route::get('/admin/appointments', [AdminController::class, 'appointments'])->name('admin.appointments'); // Pastikan ini ada
    // Rute untuk update status janji temu
    Route::patch('/admin/appointments/{appointment}/status', [AdminController::class, 'updateAppointmentStatus'])->name('admin.appointments.updateStatus');
});

// Rute untuk Pasien
Route::middleware(['auth', 'role:pasien'])->group(function () {
    Route::get('/pasien/dashboard', [PatientController::class, 'dashboard'])->name('pasien.dashboard'); // MODIFIKASI INI
    Route::get('/pasien/schedules', [PatientController::class, 'schedules'])->name('pasien.schedules'); // TAMBAH INI
    // Rute untuk membuat janji temu
    Route::get('/pasien/appointments/create', [PatientController::class, 'showAppointmentForm'])->name('pasien.appointments.create');
    Route::post('/pasien/appointments', [PatientController::class, 'storeAppointment'])->name('pasien.appointments.store');
    // Rute untuk riwayat janji temu dan cetak antrean
    Route::get('/pasien/appointments/history', [PatientController::class, 'history'])->name('pasien.history'); // Riwayat
    Route::get('/pasien/appointments/{appointment}/print', [PatientController::class, 'printQueue'])->name('pasien.appointment.print'); // Cetak
    // Rute untuk Chatbot
    Route::get('/pasien/chatbot', function () { // Rute untuk menampilkan halaman chatbot
        return view('pasien.chatbot'); // Kita akan membuat view ini
    })->name('pasien.chatbot');

    Route::post('/pasien/chatbot/send', [App\Http\Controllers\ChatbotController::class, 'sendMessage'])->name('pasien.chatbot.send'); // Rute untuk mengirim pesan
});

// Rute Profile Breeze
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Opsional: Handle redirect untuk rute default seperti /home jika ada yang mengarah ke sana
// Atau jika ada link di Blade default Breeze yang mengarah ke /dashboard
Route::get('/dashboard', function () { // Menggantikan rute /dashboard default Breeze
    $user = Auth::user();
    if ($user) {
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'pasien') {
            return redirect()->route('pasien.dashboard');
        }
    }
    return redirect()->route('login');
})->name('dashboard'); // Beri nama 'dashboard' agar link default Breeze tetap berfungsi

// Jika Anda juga ingin menangani /home (meskipun Laravel 11/12 cenderung menggunakan /dashboard)
Route::get('/home', function () {
    $user = Auth::user();
    if ($user) {
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'pasien') {
            return redirect()->route('pasien.dashboard');
        }
    }
    return redirect()->route('login');
})->name('home');