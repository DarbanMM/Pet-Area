<?php
// app/Http/Controllers/ChangePasswordController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Gate;
use App\Models\User; // <--- PASTIKAN BARIS INI ADA!

class ChangePasswordController extends Controller
{
    // Menampilkan form ganti password
    public function showChangePasswordForm()
    {
        Gate::authorize('change-doctor-password');
        return view('dokter.profile.change_password');
    }

    // Memproses permintaan ganti password
    public function changePassword(Request $request)
    {
        Gate::authorize('change-doctor-password');

        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user(); // Ini adalah instance dari App\Models\User

        // Verifikasi password lama
        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Password lama tidak cocok dengan catatan kami.'],
            ]);
        }

        // Update password baru
        $user->password = Hash::make($request->new_password);
        $user->save(); // <--- Baris ini sekarang akan dikenali karena User model diimpor

        // Logout user dari semua sesi lain (opsional, untuk keamanan)
        Auth::logoutOtherDevices($request->current_password);

        return redirect()->route('dokter.change_password')->with('success', 'Password Anda berhasil diubah!');
    }
}