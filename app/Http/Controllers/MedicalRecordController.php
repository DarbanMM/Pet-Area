<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Patient; // Perlu untuk form pilih pasien
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan dokter yang sedang login

class MedicalRecordController extends Controller
{
    // ADMIN: Menampilkan daftar semua rekam medis (Hanya Lihat)
    public function indexAdmin()
    {
        Gate::authorize('view-medical-records'); // Gate untuk admin melihat rekam medis
        $medicalRecords = MedicalRecord::with(['patient', 'doctor'])
                                       ->orderByDesc('visit_date')
                                       ->paginate(10);
        return view('admin.medical_records.index', compact('medicalRecords'));
    }

    // DOKTER: Menampilkan daftar rekam medis dengan tombol CRUD
    public function indexDoctor()
    {
        Gate::authorize('manage-medical-records'); // Gate untuk dokter mengelola rekam medis
        $medicalRecords = MedicalRecord::with(['patient', 'doctor'])
                                       ->orderByDesc('visit_date')
                                       ->paginate(10);
        return view('dokter.medical_records.index', compact('medicalRecords'));
    }

    // ADMIN & DOKTER: Menampilkan detail rekam medis tertentu (Shared View)
    public function show(MedicalRecord $medicalRecord)
    {
        // Gate sudah diatur di routes/web.php untuk melihat, jadi tidak perlu Gate::authorize di sini
        $medicalRecord->load('patient', 'doctor');
        return view('shared.medical_records.show', compact('medicalRecord'));
    }

    // DOKTER: Menampilkan form untuk menambah rekam medis baru
    public function create()
    {
        Gate::authorize('manage-medical-records'); // Hanya dokter yang bisa membuat
        $patients = Patient::orderBy('name')->get(); // Ambil semua pasien untuk dropdown
        return view('dokter.medical_records.create', compact('patients'));
    }

    // DOKTER: Menyimpan rekam medis baru ke database
    public function store(Request $request)
    {
        Gate::authorize('manage-medical-records');

        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'visit_date' => 'required|date',
            'symptoms' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'treatment' => 'nullable|string',
            'prescription' => 'nullable|string', // Untuk resep obat
            'notes' => 'nullable|string',
        ]);

        MedicalRecord::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => Auth::id(), // Dokter yang sedang login otomatis menjadi pencatat
            'visit_date' => $request->visit_date,
            'symptoms' => $request->symptoms,
            'diagnosis' => $request->diagnosis,
            'treatment' => $request->treatment,
            'prescription' => $request->prescription,
            'notes' => $request->notes,
        ]);

        return redirect()->route('dokter.medical_records.index')->with('success', 'Rekam medis berhasil ditambahkan!');
    }

    // DOKTER: Menampilkan form untuk mengedit rekam medis
    public function edit(MedicalRecord $medicalRecord)
    {
        Gate::authorize('manage-medical-records');
        // Opsional: Pastikan hanya dokter yang membuat RM ini yang bisa mengedit
        // if ($medicalRecord->doctor_id !== Auth::id()) {
        //     abort(403, 'Anda tidak diizinkan mengedit rekam medis ini.');
        // }
        $patients = Patient::orderBy('name')->get(); // Diperlukan untuk menampilkan nama pasien
        return view('dokter.medical_records.edit', compact('medicalRecord', 'patients'));
    }

    // DOKTER: Memperbarui data rekam medis di database
    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        Gate::authorize('manage-medical-records');
        // Opsional: Pastikan hanya dokter yang membuat RM ini yang bisa mengupdate
        // if ($medicalRecord->doctor_id !== Auth::id()) {
        //     abort(403, 'Anda tidak diizinkan memperbarui rekam medis ini.');
        // }

        $request->validate([
            'patient_id' => 'required|exists:patients,id', // Tidak diubah, tapi tetap divalidasi
            'visit_date' => 'required|date',
            'symptoms' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'treatment' => 'nullable|string',
            'prescription' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $medicalRecord->update($request->all());

        return redirect()->route('dokter.medical_records.index')->with('success', 'Rekam medis berhasil diperbarui!');
    }

    // DOKTER: Menghapus rekam medis dari database
    public function destroy(MedicalRecord $medicalRecord)
    {
        Gate::authorize('manage-medical-records');
        // Opsional: Pastikan hanya dokter yang membuat RM ini yang bisa menghapus
        // if ($medicalRecord->doctor_id !== Auth::id()) {
        //     abort(403, 'Anda tidak diizinkan menghapus rekam medis ini.');
        // }
        $medicalRecord->delete();

        return redirect()->route('dokter.medical_records.index')->with('success', 'Rekam medis berhasil dihapus!');
    }
}