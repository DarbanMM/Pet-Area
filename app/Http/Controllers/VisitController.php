<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Patient; // Diperlukan untuk memilih pasien
use App\Models\MedicalRecord; // Diperlukan untuk integrasi dengan rekam medis
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate; // Untuk Gates
use Illuminate\Support\Facades\Auth; // Untuk admin yang mencatat kunjungan
use Carbon\Carbon; // Diperlukan untuk perbandingan tanggal yang akurat di show()

class VisitController extends Controller
{
    // ADMIN: Menampilkan daftar semua kunjungan
    // Ini adalah metode yang akan dipanggil oleh rute 'admin.visits.index'
    public function index() // <--- NAMA FUNGSI INI SUDAH BENAR SEBAGAI 'index'
    {
        Gate::authorize('manage-visits'); // Gate untuk memastikan hanya admin yang bisa mengelola kunjungan

        $visits = Visit::with(['patient', 'admin']) // Load relasi patient dan admin untuk ditampilkan
                       ->orderByDesc('visit_date') // Urutkan berdasarkan tanggal kunjungan terbaru
                       ->paginate(10); // Tampilkan 10 kunjungan per halaman

        return view('admin.visits.index', compact('visits'));
    }

    // ADMIN: Menampilkan form untuk menambah kunjungan baru
    public function create()
    {
        Gate::authorize('manage-visits');
        $patients = Patient::orderBy('name')->get(); // Ambil semua pasien untuk dropdown
        return view('admin.visits.create', compact('patients'));
    }

    // ADMIN: Menyimpan kunjungan baru ke database
    public function store(Request $request)
    {
        Gate::authorize('manage-visits');

        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'visit_date' => 'required|date',
            'purpose' => 'nullable|string|max:255',
            'status' => 'required|in:pending,completed,canceled', // Pilihan status kunjungan
            'notes' => 'nullable|string',
        ]);

        Visit::create([
            'patient_id' => $request->patient_id,
            'admin_id' => Auth::id(), // Admin yang login otomatis menjadi pencatat
            'visit_date' => $request->visit_date,
            'purpose' => $request->purpose,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.visits.index')->with('success', 'Data kunjungan berhasil ditambahkan!');
    }

    // ADMIN: Menampilkan detail kunjungan dan integrasi dengan rekam medis
    public function show(Visit $visit)
    {
        Gate::authorize('manage-visits'); // Admin melihat detail kunjungan
        $visit->load('patient', 'admin'); // Load relasi patient dan admin

        // Mencari rekam medis terkait dengan pasien dan tanggal kunjungan yang SAMA PERSIS
        // Gunakan whereDate() untuk membandingkan hanya bagian tanggal
        $relatedMedicalRecord = MedicalRecord::where('patient_id', $visit->patient_id)
                                             ->whereDate('visit_date', $visit->visit_date)
                                             ->first(); // Mengambil satu rekam medis pertama yang cocok

        return view('admin.visits.show', compact('visit', 'relatedMedicalRecord'));
    }

    // ADMIN: Menampilkan form untuk mengedit kunjungan
    public function edit(Visit $visit)
    {
        Gate::authorize('manage-visits');
        $patients = Patient::orderBy('name')->get();
        return view('admin.visits.edit', compact('visit', 'patients'));
    }

    // ADMIN: Memperbarui data kunjungan di database
    public function update(Request $request, Visit $visit)
    {
        Gate::authorize('manage-visits');

        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'visit_date' => 'required|date',
            'purpose' => 'nullable|string|max:255',
            'status' => 'required|in:pending,completed,canceled',
            'notes' => 'nullable|string',
        ]);

        $visit->update($request->all());

        return redirect()->route('admin.visits.index')->with('success', 'Data kunjungan berhasil diperbarui!');
    }

    // ADMIN: Menghapus kunjungan dari database
    public function destroy(Visit $visit)
    {
        Gate::authorize('manage-visits');
        $visit->delete();
        return redirect()->route('admin.visits.index')->with('success', 'Data kunjungan berhasil dihapus!');
    }
}