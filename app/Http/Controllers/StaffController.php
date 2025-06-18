<?php
// app/Http/Controllers/StaffController.php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    public function index()
    {
        Gate::authorize('manage-staff');
        $admins = User::where('role', 'admin')->orderBy('name')->paginate(10);
        return view('dokter.staff.index', compact('admins'));
    }

    public function create()
    {
        Gate::authorize('manage-staff');
        return view('dokter.staff.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('manage-staff');
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:8|confirmed',
        ]);
        User::create([
            'name' => $request->name, 'email' => $request->email,
            'username' => $request->username, 'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);
        return redirect()->route('dokter.staff.index')->with('success', 'Admin berhasil ditambahkan!');
    }

    public function edit(User $staff)
    {
        Gate::authorize('manage-staff');
        if ($staff->role !== 'admin') { abort(403, 'Anda tidak diizinkan mengedit user ini.'); }
        return view('dokter.staff.edit', compact('staff'));
    }

    public function update(Request $request, User $staff)
    {
        Gate::authorize('manage-staff');
        if ($staff->role !== 'admin') { abort(403, 'Anda tidak diizinkan mengedit user ini.'); }
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($staff->id)],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($staff->id)],
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        $staff->name = $request->name;
        $staff->email = $request->email;
        $staff->username = $request->username;
        if ($request->filled('password')) { $staff->password = Hash::make($request->password); }
        $staff->save();
        return redirect()->route('dokter.staff.index')->with('success', 'Data admin berhasil diperbarui!');
    }

    public function destroy(User $staff)
    {
        Gate::authorize('manage-staff');
        if ($staff->role !== 'admin' || $staff->id === Auth::id()) { abort(403, 'Anda tidak diizinkan menghapus user ini.'); }
        $staff->delete();
        return redirect()->route('dokter.staff.index')->with('success', 'Admin berhasil dihapus!');
    }
}