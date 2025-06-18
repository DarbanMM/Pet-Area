<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\VisitController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini Anda dapat mendaftarkan rute web untuk aplikasi Anda.
| Rute-rute ini dimuat oleh RouteServiceProvider dan semuanya akan
| ditetapkan ke grup middleware "web". Buat sesuatu yang hebat!
|
*/

// Rute Halaman Utama (Welcome Page)
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
// Halaman login harus bisa diakses oleh siapa saja (guest)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('guest'); // Memberi nama unik untuk post
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth'); // Hanya user terautentikasi bisa logout

// Rute yang memerlukan autentikasi (untuk Dokter dan Admin)
Route::middleware(['auth'])->group(function () {

    // Rute umum setelah login. Ini berfungsi sebagai pengarah ke dashboard spesifik role.
    // User tidak seharusnya benar-benar mendarat di /home, tapi akan langsung diarahkan.
    Route::get('/home', function() {
        $user = Auth::user();
        if ($user->role === 'dokter') {
            return redirect()->route('dashboard.dokter');
        } elseif ($user->role === 'admin') {
            return redirect()->route('dashboard.admin');
        }
        // Fallback jika role tidak dikenali (harusnya tidak terjadi)
        Auth::logout(); // Logout jika role tidak valid
        return redirect()->route('login')->withErrors('Role Anda tidak dikenali. Silakan login kembali.');
    })->name('home');

    // Rute Shared untuk melihat detail (pasien dan rekam medis)
    // Rute ini bisa diakses oleh Admin atau Dokter, asalkan sudah login
    // Gate di controller/view akan menangani detail otorisasi tampilan/aksi
    Route::get('/pasien/{patient}', [PatientController::class, 'show'])->name('patients.show');
    Route::get('/rekam-medis/{medicalRecord}', [MedicalRecordController::class, 'show'])->name('medical_records.show');


    // GROUP RUTE UNTUK DOKTER (OWNER)
    // Hanya user dengan role 'dokter' yang bisa mengakses rute di grup ini.
    Route::middleware('can:access-dokter-area')->group(function () {
        Route::get('/dashboard-dokter', function () {
            return view('dashboard-dokter');
        })->name('dashboard.dokter');

        // Dokter: Data Pasien (Hanya Melihat)
        Route::get('/dokter/pasien', [PatientController::class, 'indexDoctor'])->name('dokter.patients.index');

        // Dokter: Manajemen Rekam Medis (CRUD)
        Route::get('/dokter/rekam-medis', [MedicalRecordController::class, 'indexDoctor'])->name('dokter.medical_records.index');
        Route::get('/dokter/rekam-medis/create', [MedicalRecordController::class, 'create'])->name('dokter.medical_records.create');
        Route::post('/dokter/rekam-medis', [MedicalRecordController::class, 'store'])->name('dokter.medical_records.store');
        Route::get('/dokter/rekam-medis/{medicalRecord}/edit', [MedicalRecordController::class, 'edit'])->name('dokter.medical_records.edit');
        Route::put('/dokter/rekam-medis/{medicalRecord}', [MedicalRecordController::class, 'update'])->name('dokter.medical_records.update');
        Route::delete('/dokter/rekam-medis/{medicalRecord}', [MedicalRecordController::class, 'destroy'])->name('dokter.medical_records.destroy');


        // Dokter: Manajemen Staf (CRUD Admin)
        Route::get('/dokter/staff', [StaffController::class, 'index'])->name('dokter.staff.index');
        Route::get('/dokter/staff/create', [StaffController::class, 'create'])->name('dokter.staff.create');
        Route::post('/dokter/staff', [StaffController::class, 'store'])->name('dokter.staff.store');
        Route::get('/dokter/staff/{staff}/edit', [StaffController::class, 'edit'])->name('dokter.staff.edit');
        Route::put('/dokter/staff/{staff}', [StaffController::class, 'update'])->name('dokter.staff.update');
        Route::delete('/dokter/staff/{staff}', [StaffController::class, 'destroy'])->name('dokter.staff.destroy');

        // Dokter: Ganti Password
        Route::get('/dokter/ganti-password', [ChangePasswordController::class, 'showChangePasswordForm'])->name('dokter.change_password');
        Route::put('/dokter/ganti-password', [ChangePasswordController::class, 'changePassword']);
    });

    // GROUP RUTE UNTUK ADMIN
    // Hanya user dengan role 'admin' yang bisa mengakses rute di grup ini.
    Route::middleware('can:access-admin-area')->group(function () {
        Route::get('/dashboard-admin', [AdminDashboardController::class, 'index'])->name('dashboard.admin');

        // Admin: Manajemen Pasien (CRUD)
        Route::get('/admin/pasien', [PatientController::class, 'indexAdmin'])->name('admin.patients.index');
        Route::get('/admin/pasien/create', [PatientController::class, 'create'])->name('admin.patients.create');
        Route::post('/admin/pasien', [PatientController::class, 'store'])->name('admin.patients.store');
        Route::get('/admin/pasien/{patient}/edit', [PatientController::class, 'edit'])->name('admin.patients.edit');
        Route::put('/admin/pasien/{patient}', [PatientController::class, 'update'])->name('admin.patients.update');
        Route::delete('/admin/pasien/{patient}', [PatientController::class, 'destroy'])->name('admin.patients.destroy');

        // Admin: Lihat Rekam Medis (Daftar Rekam Medis)
        Route::get('/admin/rekam-medis', [MedicalRecordController::class, 'indexAdmin'])->name('admin.medical_records.index');

        // Admin: Manajemen Data Transaksi (CRUD & Cetak Nota)
        Route::get('/admin/transaksi', [TransactionController::class, 'index'])->name('admin.transactions.index');
        Route::get('/admin/transaksi/create', [TransactionController::class, 'create'])->name('admin.transactions.create');
        Route::post('/admin/transaksi', [TransactionController::class, 'store'])->name('admin.transactions.store');
        Route::get('/admin/transaksi/{transaction}', [TransactionController::class, 'show'])->name('admin.transactions.show');
        Route::get('/admin/transaksi/{transaction}/edit', [TransactionController::class, 'edit'])->name('admin.transactions.edit');
        Route::put('/admin/transaksi/{transaction}', [TransactionController::class, 'update'])->name('admin.transactions.update');
        Route::delete('/admin/transaksi/{transaction}', [TransactionController::class, 'destroy'])->name('admin.transactions.destroy');
        Route::get('/admin/transaksi/{transaction}/print', [TransactionController::class, 'printNota'])->name('admin.transactions.print_nota');

        // Admin: Manajemen Data Kunjungan (CRUD & Integrasi Rekam Medis)
        Route::get('/admin/kunjungan', [VisitController::class, 'index'])->name('admin.visits.index');
        Route::get('/admin/kunjungan/create', [VisitController::class, 'create'])->name('admin.visits.create');
        Route::post('/admin/kunjungan', [VisitController::class, 'store'])->name('admin.visits.store');
        Route::get('/admin/kunjungan/{visit}', [VisitController::class, 'show'])->name('admin.visits.show');
        Route::get('/admin/kunjungan/{visit}/edit', [VisitController::class, 'edit'])->name('admin.visits.edit');
        Route::put('/admin/kunjungan/{visit}', [VisitController::class, 'update'])->name('admin.visits.update');
        Route::delete('/admin/kunjungan/{visit}', [VisitController::class, 'destroy'])->name('admin.visits.destroy');

        // Admin: Edit Profil (placeholder)
        Route::get('/admin/profil', function() { return "Halaman Edit Profil Admin"; })->name('admin.profile.edit');
    });
});