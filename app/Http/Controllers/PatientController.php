<?php
// app/Http/Controllers/PatientController.php
namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PatientController extends Controller
{
    public function indexAdmin()
    {
        // Gate::authorize('manage-patients'); // Route sudah diproteksi oleh gate di web.php
        $patients = Patient::orderBy('name')->paginate(10);
        return view('admin.patients.index', compact('patients'));
    }

    public function indexDoctor()
    {
        Gate::authorize('view-all-patients');
        $patients = Patient::orderBy('name')->paginate(10);
        return view('dokter.patients.index', compact('patients'));
    }

    public function create()
    {
        Gate::authorize('manage-patients');
        return view('admin.patients.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('manage-patients');
        $request->validate([
            'name' => 'required|string|max:255', 'species' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255', 'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|max:50', 'weight' => 'nullable|numeric|min:0',
            'medical_history' => 'nullable|string', 'owner_name' => 'required|string|max:255',
            'owner_phone' => 'nullable|string|max:20', 'owner_address' => 'nullable|string|max:255',
            'owner_email' => 'nullable|email|max:255',
        ]);
        Patient::create($request->all());
        return redirect()->route('admin.patients.index')->with('success', 'Data pasien berhasil ditambahkan!');
    }

    public function show(Patient $patient)
    {
        // Route sudah diproteksi untuk admin/dokter
        return view('shared.patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        Gate::authorize('manage-patients');
        return view('admin.patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        Gate::authorize('manage-patients');
        $request->validate([
            'name' => 'required|string|max:255', 'species' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255', 'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|max:50', 'weight' => 'nullable|numeric|min:0',
            'medical_history' => 'nullable|string', 'owner_name' => 'required|string|max:255',
            'owner_phone' => 'nullable|string|max:20', 'owner_address' => 'nullable|string|max:255',
            'owner_email' => 'nullable|email|max:255',
        ]);
        $patient->update($request->all());
        return redirect()->route('admin.patients.index')->with('success', 'Data pasien berhasil diperbarui!');
    }

    public function destroy(Patient $patient)
    {
        Gate::authorize('manage-patients');
        $patient->delete();
        return redirect()->route('admin.patients.index')->with('success', 'Data pasien berhasil dihapus!');
    }
}