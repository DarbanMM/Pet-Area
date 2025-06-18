@extends('layouts.dokter_app')

@section('title', 'Edit Rekam Medis - Dokter')
@section('header_title', 'Edit Rekam Medis & Resep')

@section('content')
    <h2 class="text-3xl font-semibold text-gray-800 mb-6">Edit Rekam Medis untuk {{ $medicalRecord->patient->name ?? 'N/A' }}</h2>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <strong class="font-bold">Oops!</strong>
            <span class="block sm:inline">Ada beberapa masalah dengan input Anda.</span>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('dokter.medical_records.update', $medicalRecord->id) }}" method="POST" class="bg-white rounded-lg shadow-md p-6 max-w-2xl mx-auto">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <div class="mb-4">
                    <label for="patient_id" class="block text-gray-700 text-sm font-bold mb-2">Pilih Pasien <span class="text-red-500">*</span></label>
                    <select id="patient_id" name="patient_id" required disabled {{-- Pasien tidak bisa diubah setelah rekam medis dibuat --}}
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-gray-200 cursor-not-allowed">
                        <option value="">-- Pilih Pasien --</option>
                        @foreach ($patients as $patient)
                            <option value="{{ $patient->id }}" {{ (old('patient_id', $medicalRecord->patient_id) == $patient->id) ? 'selected' : '' }}>
                                {{ $patient->name }} (Pemilik: {{ $patient->owner_name }})
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="patient_id" value="{{ $medicalRecord->patient_id }}"> {{-- Kirim ID pasien meski disabled --}}
                </div>
                <div class="mb-4">
                    <label for="visit_date" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Kunjungan <span class="text-red-500">*</span></label>
                    <input type="date" id="visit_date" name="visit_date" value="{{ old('visit_date', $medicalRecord->visit_date) }}" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="symptoms" class="block text-gray-700 text-sm font-bold mb-2">Gejala</label>
                    <textarea id="symptoms" name="symptoms" rows="4"
                              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('symptoms', $medicalRecord->symptoms) }}</textarea>
                </div>
                <div class="mb-4">
                    <label for="diagnosis" class="block text-gray-700 text-sm font-bold mb-2">Diagnosis</label>
                    <textarea id="diagnosis" name="diagnosis" rows="4"
                              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('diagnosis', $medicalRecord->diagnosis) }}</textarea>
                </div>
            </div>
            <div>
                <div class="mb-4">
                    <label for="treatment" class="block text-gray-700 text-sm font-bold mb-2">Tindakan / Perawatan</label>
                    <textarea id="treatment" name="treatment" rows="4"
                              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('treatment', $medicalRecord->treatment) }}</textarea>
                </div>
                <div class="mb-4">
                    <label for="prescription" class="block text-gray-700 text-sm font-bold mb-2">Resep Obat</label>
                    <textarea id="prescription" name="prescription" rows="4" placeholder="Contoh: Amoxicillin 250mg, 2x sehari setelah makan"
                              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('prescription', $medicalRecord->prescription) }}</textarea>
                </div>
                <div class="mb-4">
                    <label for="notes" class="block text-gray-700 text-sm font-bold mb-2">Catatan Tambahan</label>
                    <textarea id="notes" name="notes" rows="3"
                              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('notes', $medicalRecord->notes) }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between mt-6">
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:shadow-outline transition duration-150">
                Update Rekam Medis
            </button>
            <a href="{{ route('dokter.medical_records.index') }}" class="text-gray-600 hover:text-gray-800 font-medium">Batal</a>
        </div>
    </form>
@endsection