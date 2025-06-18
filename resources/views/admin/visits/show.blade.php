@extends('layouts.admin_app')

@section('title', 'Detail Kunjungan - Admin')
@section('header_title', 'Detail Kunjungan')

@section('content')
    <h2 class="text-3xl font-semibold text-gray-800 mb-6">Detail Kunjungan Pasien #{{ $visit->id }}</h2>

    <div class="bg-white rounded-lg shadow-md p-6 max-w-2xl mx-auto">
        <div class="mb-4">
            <p class="text-gray-600"><strong>Tanggal Kunjungan:</strong> {{ \Carbon\Carbon::parse($visit->visit_date)->translatedFormat('d F Y') }}</p>
        </div>
        <div class="mb-4">
            <p class="text-gray-600"><strong>Pasien:</strong> {{ $visit->patient->name ?? 'N/A' }} (Pemilik: {{ $visit->patient->owner_name ?? 'N/A' }})</p>
            @if($visit->patient)
                <a href="{{ route('patients.show', $visit->patient->id) }}" class="text-blue-600 hover:underline text-sm">Lihat Detail Pasien</a>
            @endif
        </div>
        <div class="mb-4">
            <p class="text-gray-600"><strong>Tujuan Kunjungan:</strong> {{ $visit->purpose ?? '-' }}</p>
        </div>
        <div class="mb-4">
            <p class="text-gray-600"><strong>Status:</strong> <span class="font-bold @if($visit->status == 'completed') bg-green-100 text-green-800 @elseif($visit->status == 'pending') bg-yellow-100 text-yellow-800 @else bg-red-100 text-red-800 @endif">{{ ucfirst($visit->status) }}</span></p>
        </div>
        <div class="mb-4">
            <p class="text-gray-600"><strong>Catatan:</strong> {{ $visit->notes ?? '-' }}</p>
        </div>
        <div class="mb-6">
            <p class="text-gray-600"><strong>Dicatat oleh Admin:</strong> {{ $visit->admin->name ?? 'N/A' }}</p>
        </div>

        <div class="dashed-line my-6"></div>

        <h3 class="text-xl font-semibold text-gray-700 mb-4">Integrasi Rekam Medis</h3>
        @if ($relatedMedicalRecord) {{-- <--- PASTIKAN VARIABEL INI BENAR ($relatedMedicalRecord) --}}
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <p class="mb-2">Rekam Medis ditemukan untuk kunjungan ini:</p>
                <p class="mb-2 text-gray-700"><strong>Diagnosis:</strong> {{ Str::limit($relatedMedicalRecord->diagnosis, 100) ?? '-' }}</p>
                <p class="mb-2 text-gray-700"><strong>Dokter:</strong> {{ $relatedMedicalRecord->doctor->name ?? 'N/A' }}</p>
                <a href="{{ route('medical_records.show', $relatedMedicalRecord->id) }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md text-sm mt-3">
                    Lihat Detail Rekam Medis
                </a>
            </div>
        @else
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-sm text-yellow-800">
                <p>Tidak ditemukan rekam medis yang terkait dengan pasien ini pada tanggal kunjungan yang sama.</p>
                <p class="mt-2">Mungkin perlu dicatat oleh Dokter.</p>
            </div>
        @endif

        <div class="flex items-center justify-between mt-8">
            <a href="{{ route('admin.visits.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-md transition duration-150">Kembali</a>
            <div class="space-x-2">
                <a href="{{ route('admin.visits.edit', $visit->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-md transition duration-150">Edit</a>
                <form action="{{ route('admin.visits.destroy', $visit->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kunjungan ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-700 text-white font-bold py-2 px-4 rounded-md transition duration-150">Hapus</button>
                </form>
            </div>
        </div>
        <style>
            .dashed-line {
                border-top: 1px dashed #e0e0e0;
            }
        </style>
    @endsection
 