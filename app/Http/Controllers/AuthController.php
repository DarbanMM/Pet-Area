<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi awal
        $request->validate([
            'login_field' => 'required|string',
            'password' => 'required|string',
            'role_type' => 'required|in:dokter,admin', // Validasi role yang dipilih
        ]);

        $loginField = $request->input('login_field');
        $password = $request->input('password');
        $roleType = $request->input('role_type'); // Ambil role yang dipilih user

        $credentials = [
            'password' => $password,
        ];

        // Sesuaikan kredensial berdasarkan role_type yang dipilih user
        if ($roleType === 'dokter') {
            $credentials['email'] = $loginField;
        } elseif ($roleType === 'admin') {
            $credentials['username'] = $loginField;
        } else {
            // Fallback jika role_type tidak valid (harusnya sudah dicegah oleh validasi 'in:dokter,admin')
            return back()->withErrors([
                'login_field' => 'Role yang dipilih tidak valid.',
            ])->onlyInput('login_field');
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Pastikan role yang login sesuai dengan yang diminta di form
            // Ini untuk double-check keamanan, meskipun redirectBasedOnRole akan menangani
            if (Auth::user()->role === $roleType) {
                return $this->redirectBasedOnRole(Auth::user());
            } else {
                // User berhasil login, tapi rolenya tidak sesuai yang diharapkan dari form.
                // Misal: user memilih "Admin", tapi yang login adalah Dokter.
                // Ini bisa jadi celah atau kebingungan. Logout dan beri pesan error.
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                 return back()->withErrors([
                    'login_field' => 'Role yang Anda pilih tidak cocok dengan akun ini. Silakan coba role lain.',
                ])->onlyInput('login_field');
            }
        }

        // Jika Auth::attempt gagal
        return back()->withErrors([
            'login_field' => 'Kombinasi ' . ($roleType === 'dokter' ? 'email' : 'username') . ' dan password tidak cocok.',
        ])->onlyInput('login_field');
    }

    // ... (metode logout dan redirectBasedOnRole tetap sama) ...
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    protected function redirectBasedOnRole($user)
    {
        if ($user->role === 'dokter') { return redirect()->intended('/dashboard-dokter'); }
        elseif ($user->role === 'admin') { return redirect()->intended('/dashboard-admin'); }
        return redirect()->intended('/home');
    }
}