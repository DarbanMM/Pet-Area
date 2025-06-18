@extends('layouts.admin_app')

@section('title', 'Edit Transaksi - Admin')
@section('header_title', 'Edit Transaksi')

@section('content')
    <h2 class="text-3xl font-semibold text-gray-800 mb-6">Edit Transaksi Pembayaran #{{ $transaction->id }}</h2>

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

    <form action="{{ route('admin.transactions.update', $transaction->id) }}" method="POST" class="bg-white rounded-lg shadow-md p-6 max-w-xl mx-auto">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="transaction_date" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Transaksi <span class="text-red-500">*</span></label>
            <input type="date" id="transaction_date" name="transaction_date" value="{{ old('transaction_date', $transaction->transaction_date) }}" required
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label for="patient_id" class="block text-gray-700 text-sm font-bold mb-2">Pasien (Opsional)</label>
            <select id="patient_id" name="patient_id"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="">-- Tidak Terkait Pasien --</option>
                @foreach ($patients as $patient)
                    <option value="{{ $patient->id }}" {{ (old('patient_id', $transaction->patient_id) == $patient->id) ? 'selected' : '' }}>
                        {{ $patient->name }} (Pemilik: {{ $patient->owner_name }})
                    </option>
                @endforeach
            </select>
            <p class="text-xs text-gray-500 mt-1">Pilih pasien jika transaksi ini terkait dengan layanan medis spesifik.</p>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi Layanan/Produk <span class="text-red-500">*</span></label>
            <textarea id="description" name="description" rows="3" required
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('description', $transaction->description) }}</textarea>
        </div>
        <div class="mb-4">
            <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">Jumlah (Rp) <span class="text-red-500">*</span></label>
            <input type="number" step="0.01" id="amount" name="amount" value="{{ old('amount', $transaction->amount) }}" required
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label for="payment_method" class="block text-gray-700 text-sm font-bold mb-2">Metode Pembayaran</label>
            <input type="text" id="payment_method" name="payment_method" value="{{ old('payment_method', $transaction->payment_method) }}"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-6">
            <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status Transaksi <span class="text-red-500">*</span></label>
            <select id="status" name="status" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="completed" {{ (old('status', $transaction->status) == 'completed') ? 'selected' : '' }}>Selesai (Completed)</option>
                <option value="pending" {{ (old('status', $transaction->status) == 'pending') ? 'selected' : '' }}>Tertunda (Pending)</option>
                <option value="canceled" {{ (old('status', $transaction->status) == 'canceled') ? 'selected' : '' }}>Dibatalkan (Canceled)</option>
            </select>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:shadow-outline transition duration-150">
                Update Transaksi
            </button>
            <a href="{{ route('admin.transactions.index') }}" class="text-gray-600 hover:text-gray-800 font-medium">Batal</a>
        </div>
    </form>
@endsection