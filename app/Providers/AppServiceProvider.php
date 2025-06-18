<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate; // Import Gate
use App\Models\User; // Penting: Import model User

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Define Gates here, ini akan berfungsi sama seperti di AuthServiceProvider
        // Gate untuk akses dashboard dan area spesifik role
        Gate::define('access-dokter-area', function (User $user) { // Gunakan type-hint User
            return $user->role === 'dokter';
        });

        Gate::define('access-admin-area', function (User $user) { // Gunakan type-hint User
            return $user->role === 'admin';
        });

        // Gates untuk fitur spesifik
        // Dokter (Owner)
        Gate::define('view-all-patients', function (User $user) {
            return $user->role === 'dokter' || $user->role === 'admin';
        });

        Gate::define('manage-medical-records', function (User $user) {
            return $user->role === 'dokter'; // Dokter bisa catat/update rekam medis dan resep
        });

        Gate::define('manage-staff', function (User $user) {
            return $user->role === 'dokter'; // Dokter yang mengatur admin
        });

        // Admin
        Gate::define('manage-patients', function (User $user) {
            return $user->role === 'admin'; // Admin yang mengelola data pasien (tambah, edit, hapus)
        });

        Gate::define('manage-visits', function (User $user) {
            return $user->role === 'admin'; // Admin yang mencatat kunjungan
        });

        Gate::define('manage-transactions', function (User $user) {
            return $user->role === 'admin'; // Admin yang mengelola transaksi
        });

        Gate::define('view-medical-records', function (User $user) {
            return $user->role === 'admin' || $user->role === 'dokter'; // Admin bisa melihat rekam medis
        });

        // Gate untuk profil admin (admin bisa edit profil sendiri)
        Gate::define('edit-admin-profile', function (User $user) {
            return $user->role === 'admin';
        });

        // Gate untuk ganti password dokter (dokter bisa ganti password sendiri)
        Gate::define('change-doctor-password', function (User $user) {
            return $user->role === 'dokter';
        });
    }
}