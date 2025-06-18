{{-- Ini adalah baris pertama dan HARUS menjadi satu-satunya yang menentukan layout master.
     Blade akan memilih antara layouts.admin_app atau layouts.dokter_app berdasarkan role.
     SEMUA TAG HTML DASAR (<html>, <head>, <body>) TIDAK BOLEH ADA DI SINI. --}}
@if(Auth::user()->role === 'admin')
    @extends('layouts.admin_app')
    @section('title', 'Detail Rekam Medis - Admin')
    @section('header_title', 'Detail Rekam Medis')
@else {{-- Asumsi ini adalah peran 'dokter' --}}
    @extends('layouts.dokter_app')
    @section('title', 'Detail Rekam Medis - Dokter')
    @section('header_title', 'Detail Rekam Medis')
@endif

{{-- SEMUA KONTEN HALAMAN INI HARUS BERADA DI DALAM @section('content') DAN @endsection --}}
@section('content')
    <div class="container mx-auto mt-8 p-6 bg-white rounded-lg shadow-md max-w-3xl">
        <h2 class="text-3xl font-semibold text-gray-800 mb-6">Detail Rekam Medis</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h3 class="text-xl font-semibold text-gray-700 mb-3 border-b pb-2">Informasi Umum</h3>
                <p class="mb-2 text-gray-700"><strong>Tanggal Kunjungan:</strong> {{ \Carbon\Carbon::parse($medicalRecord->visit_date)->translatedFormat('d F Y') }}</p>
                <p class="mb-2 text-gray-700"><strong>Dokter:</strong> {{ $medicalRecord->doctor->name ?? 'N/A' }}</p>
                <p class="mb-2 text-gray-700"><strong>Nama Pasien:</strong> <a href="{{ route('patients.show', $medicalRecord->patient->id) }}" class="text-blue-600 hover:underline">{{ $medicalRecord->patient->name ?? 'N/A' }}</a></p>
                <p class="mb-2 text-gray-700"><strong>Jenis Hewan:</strong> {{ $medicalRecord->patient->species ?? 'N/A' }}</p>
            </div>
            <div>
                <h3 class="text-xl font-semibold text-gray-700 mb-3 border-b pb-2">Gejala & Diagnosis</h3>
                <p class="mb-2 text-gray-700"><strong>Gejala:</strong> {{ $medicalRecord->symptoms ?? '-' }}</p>
                <p class="mb-2 text-gray-700"><strong>Diagnosis:</strong> {{ $medicalRecord->diagnosis ?? '-' }}</p>
            </div>
        </div>

        <div class="mb-6">
            <h3 class="text-xl font-semibold text-gray-700 mb-3 border-b pb-2">Tindakan & Resep</h3>
            <p class="mb-2 text-gray-700"><strong>Tindakan/Perawatan:</strong> {{ $medicalRecord->treatment ?? '-' }}</p>
            <p class="mb-2 text-gray-700"><strong>Resep:</strong> {{ $medicalRecord->prescription ?? '-' }}</p>
        </div>

        <div class="mb-6">
            <h3 class="text-xl font-semibold text-gray-700 mb-3 border-b pb-2">Catatan Tambahan</h3>
            <p class="mb-2 text-gray-700">{{ $medicalRecord->notes ?? '-' }}</p>
        </div>

        <div class="flex justify-between mt-8">
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.medical_records.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-md transition duration-150">Kembali ke Daftar Rekam Medis</a>
            @else {{-- Dokter --}}
                <a href="{{ route('dokter.medical_records.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-md transition duration-150">Kembali ke Daftar Rekam Medis</a>
                @can('manage-medical-records')
                    <div class="space-x-2">
                        <a href="{{ route('dokter.medical_records.edit', $medicalRecord->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-md transition duration-150">Edit</a>
                        <form action="{{ route('dokter.medical_records.destroy', $medicalRecord->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus rekam medis ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-700 text-white font-bold py-2 px-4 rounded-md transition duration-150">Hapus</button>
                        </form>
                    </div>
                @endcan
            @endif
        </div>
    @endsection