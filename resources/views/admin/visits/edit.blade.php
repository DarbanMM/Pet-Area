@extends('layouts.admin_app')

@section('title', 'Edit Kunjungan - Admin')
@section('header_title', 'Edit Kunjungan')

@section('content')
    <h2 class="text-3xl font-semibold text-gray-800 mb-6">Edit Kunjungan #{{ $visit->id }}</h2>

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

    <form action="{{ route('admin.visits.update', $visit->id) }}" method="POST" class="bg-white rounded-lg shadow-md p-6 max-w-xl mx-auto">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="patient_id" class="block text-gray-700 text-sm font-bold mb-2">Pilih Pasien <span class="text-red-500">*</span></label>
            <select id="patient_id" name="patient_id" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="">-- Pilih Pasien --</option>
                @foreach ($patients as $patient)
                    <option value="{{ $patient->id }}" {{ (old('patient_id', $visit->patient_id) == $patient->id) ? 'selected' : '' }}>
                        {{ $patient->name }} (Pemilik: {{ $patient->owner_name }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="visit_date" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Kunjungan <span class="text-red-500">*</span></label>
            <input type="date" id="visit_date" name="visit_date" value="{{ old('visit_date', $visit->visit_date) }}" required
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label for="purpose" class="block text-gray-700 text-sm font-bold mb-2">Tujuan Kunjungan</label>
            <input type="text" id="purpose" name="purpose" value="{{ old('purpose', $visit->purpose) }}"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-6">
            <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status Kunjungan <span class="text-red-500">*</span></label>
            <select id="status" name="status" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="pending" {{ (old('status', $visit->status) == 'pending') ? 'selected' : '' }}>Tertunda (Pending)</option>
                <option value="completed" {{ (old('status', $visit->status) == 'completed') ? 'selected' : '' }}>Selesai (Completed)</option>
                <option value="canceled" {{ (old('status', $visit->status) == 'canceled') ? 'selected' : '' }}>Dibatalkan (Canceled)</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="notes" class="block text-gray-700 text-sm font-bold mb-2">Catatan Tambahan</label>
            <textarea id="notes" name="notes" rows="3"
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('notes', $visit->notes) }}</textarea>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:shadow-outline transition duration-150">
                Update Kunjungan
            </button>
            <a href="{{ route('admin.visits.index') }}" class="text-gray-600 hover:text-gray-800 font-medium">Batal</a>
        </div>
    </form>
@endsection