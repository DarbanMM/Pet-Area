@extends('layouts.admin_app')

@section('title', 'Tambah Pasien Baru - Admin')

@section('content')
    <h2 class="text-3xl font-semibold text-gray-800 mb-6">Tambah Pasien Baru</h2>

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

    <form action="{{ route('admin.patients.store') }}" method="POST" class="bg-white rounded-lg shadow-md p-6 max-w-2xl mx-auto">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Informasi Hewan --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Informasi Hewan</h3>
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Hewan <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="species" class="block text-gray-700 text-sm font-bold mb-2">Jenis Hewan <span class="text-red-500">*</span></label>
                    <input type="text" id="species" name="species" value="{{ old('species') }}" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="breed" class="block text-gray-700 text-sm font-bold mb-2">Ras Hewan</label>
                    <input type="text" id="breed" name="breed" value="{{ old('breed') }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="date_of_birth" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Lahir</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="gender" class="block text-gray-700 text-sm font-bold mb-2">Jenis Kelamin</label>
                    <select id="gender" name="gender" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">Pilih</option>
                        <option value="Jantan" {{ old('gender') == 'Jantan' ? 'selected' : '' }}>Jantan</option>
                        <option value="Betina" {{ old('gender') == 'Betina' ? 'selected' : '' }}>Betina</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="weight" class="block text-gray-700 text-sm font-bold mb-2">Berat (kg)</label>
                    <input type="number" step="0.01" id="weight" name="weight" value="{{ old('weight') }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="medical_history" class="block text-gray-700 text-sm font-bold mb-2">Riwayat Medis Umum</label>
                    <textarea id="medical_history" name="medical_history" rows="3"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('medical_history') }}</textarea>
                </div>
            </div>

            {{-- Informasi Pemilik --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Informasi Pemilik</h3>
                <div class="mb-4">
                    <label for="owner_name" class="block text-gray-700 text-sm font-bold mb-2">Nama Pemilik <span class="text-red-500">*</span></label>
                    <input type="text" id="owner_name" name="owner_name" value="{{ old('owner_name') }}" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="owner_phone" class="block text-gray-700 text-sm font-bold mb-2">No. HP Pemilik</label>
                    <input type="text" id="owner_phone" name="owner_phone" value="{{ old('owner_phone') }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="owner_address" class="block text-gray-700 text-sm font-bold mb-2">Alamat Pemilik</label>
                    <textarea id="owner_address" name="owner_address" rows="3"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('owner_address') }}</textarea>
                </div>
                <div class="mb-4">
                    <label for="owner_email" class="block text-gray-700 text-sm font-bold mb-2">Email Pemilik</label>
                    <input type="email" id="owner_email" name="owner_email" value="{{ old('owner_email') }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between mt-6">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:shadow-outline transition duration-150">
                Simpan Pasien
            </button>
            <a href="{{ route('admin.patients.index') }}" class="text-gray-600 hover:text-gray-800 font-medium">Batal</a>
        </div>
    </form>
@endsection