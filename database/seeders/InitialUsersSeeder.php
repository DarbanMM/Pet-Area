<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class InitialUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User Dokter (Owner)
        User::firstOrCreate(
            ['email' => 'dokter@klinikhewan.com'],
            [
                'name' => 'Dr. Budi Santoso (Owner)',
                'username' => null, // Dokter login dengan email, username null
                'password' => Hash::make('password_dokter'), // Ganti dengan password kuat!
                'role' => 'dokter',
                'email_verified_at' => now(),
            ]
        );
        $this->command->info('User Dokter created or already exists.');

        // User Admin
        User::firstOrCreate(
            ['username' => 'admin_klinik'], // Admin login dengan username ini
            [
                'name' => 'Admin Utama',
                'email' => 'admin@klinikhewan.com', // Email bisa diisi, tapi login pakai username
                'password' => Hash::make('password_admin'), // Ganti dengan password kuat!
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
        $this->command->info('User Admin created or already exists.');
    }
}