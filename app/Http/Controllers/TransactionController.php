<?php
// app/Http/Controllers/TransactionController.php
namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Patient; // Diperlukan untuk memilih pasien yang terkait
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth; // Untuk admin yang mencatat transaksi
use Carbon\Carbon; // Untuk formatting tanggal

class TransactionController extends Controller
{
    // ADMIN: Menampilkan daftar semua transaksi
    public function index()
    {
        Gate::authorize('manage-transactions'); // Pastikan Gate ini berfungsi

        $transactions = Transaction::with(['patient', 'admin'])
                                   ->orderByDesc('transaction_date')
                                   ->paginate(10); // Menampilkan 10 transaksi per halaman

        return view('admin.transactions.index', compact('transactions'));
    }

    // ADMIN: Menampilkan form untuk menambah transaksi baru
    public function create()
    {
        Gate::authorize('manage-transactions');
        $patients = Patient::orderBy('name')->get(); // Ambil semua pasien untuk dropdown
        return view('admin.transactions.create', compact('patients'));
    }

    // ADMIN: Menyimpan transaksi baru ke database
    public function store(Request $request)
    {
        Gate::authorize('manage-transactions');

        $request->validate([
            'patient_id' => 'nullable|exists:patients,id', // Pasien bisa null (misal: transaksi umum)
            'transaction_date' => 'required|date',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'nullable|string|max:50',
            'status' => 'required|in:completed,pending,canceled', // Pilihan status transaksi
        ]);

        Transaction::create([
            'patient_id' => $request->patient_id,
            'admin_id' => Auth::id(), // Admin yang login otomatis menjadi pencatat
            'transaction_date' => $request->transaction_date,
            'description' => $request->description,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.transactions.index')->with('success', 'Transaksi berhasil ditambahkan!');
    }

    // ADMIN: Menampilkan detail transaksi
    public function show(Transaction $transaction)
    {
        // Tidak perlu Gate::authorize di sini jika rute sudah dilindungi
        $transaction->load('patient', 'admin'); // Load relasi patient dan admin yang mencatat
        return view('admin.transactions.show', compact('transaction')); // View detail transaksi
    }

    // ADMIN: Menampilkan form untuk mengedit transaksi
    public function edit(Transaction $transaction)
    {
        Gate::authorize('manage-transactions');
        $patients = Patient::orderBy('name')->get();
        return view('admin.transactions.edit', compact('transaction', 'patients'));
    }

    // ADMIN: Memperbarui data transaksi di database
    public function update(Request $request, Transaction $transaction)
    {
        Gate::authorize('manage-transactions');

        $request->validate([
            'patient_id' => 'nullable|exists:patients,id',
            'transaction_date' => 'required|date',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'nullable|string|max:50',
            'status' => 'required|in:completed,pending,canceled',
        ]);

        $transaction->update($request->all());

        return redirect()->route('admin.transactions.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    // ADMIN: Menghapus transaksi dari database
    public function destroy(Transaction $transaction)
    {
        Gate::authorize('manage-transactions');
        $transaction->delete();
        return redirect()->route('admin.transactions.index')->with('success', 'Transaksi berhasil dihapus!');
    }

    // ADMIN: Menampilkan tampilan nota untuk dicetak
    public function printNota(Transaction $transaction)
    {
        Gate::authorize('manage-transactions'); // Hanya admin yang bisa mencetak nota

        $transaction->load('patient', 'admin'); // Pastikan relasi diload

        // View ini akan sangat minimalis, tanpa layout/header/sidebar, hanya isi nota
        // Pastikan nama file ini adalah nota_print.blade.php
        return view('admin.transactions.nota_print', compact('transaction'));
    }
}