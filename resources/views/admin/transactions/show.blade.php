@extends('layouts.admin_app')

@section('title', 'Detail Transaksi - Admin')
@section('header_title', 'Detail Transaksi')

@section('content')
    <h2 class="text-3xl font-semibold text-gray-800 mb-6">Detail Transaksi Pembayaran #{{ $transaction->id }}</h2>

    <div class="bg-white rounded-lg shadow-md p-6 max-w-xl mx-auto">
        <div class="mb-4">
            <p class="text-gray-600"><strong>Tanggal Transaksi:</strong> {{ \Carbon\Carbon::parse($transaction->transaction_date)->translatedFormat('d F Y') }}</p>
        </div>
        <div class="mb-4">
            <p class="text-gray-600"><strong>Deskripsi:</strong> {{ $transaction->description }}</p>
        </div>
        <div class="mb-4">
            <p class="text-gray-600"><strong>Jumlah:</strong> Rp {{ number_format($transaction->amount, 0, ',', '.') }}</p>
        </div>
        <div class="mb-4">
            <p class="text-gray-600"><strong>Metode Pembayaran:</strong> {{ $transaction->payment_method ?? '-' }}</p>
        </div>
        <div class="mb-4">
            <p class="text-gray-600"><strong>Status:</strong> <span class="font-bold @if($transaction->status == 'completed') text-green-600 @elseif($transaction->status == 'pending') text-yellow-600 @else text-red-600 @endif">{{ ucfirst($transaction->status) }}</span></p>
        </div>
        <div class="mb-4">
            <p class="text-gray-600"><strong>Pasien Terkait:</strong> {{ $transaction->patient->name ?? '-' }} (Pemilik: {{ $transaction->patient->owner_name ?? '-' }})</p>
        </div>
        <div class="mb-6">
            <p class="text-gray-600"><strong>Dicatat oleh Admin:</strong> {{ $transaction->admin->name ?? 'N/A' }}</p>
        </div>

        <div class="flex items-center justify-between mt-6">
            <a href="{{ route('admin.transactions.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-md transition duration-150">Kembali</a>
            <div class="space-x-2">
                <a href="{{ route('admin.transactions.edit', $transaction->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-md transition duration-150">Edit</a>
                <a href="{{ route('admin.transactions.print_nota', $transaction->id) }}" target="_blank" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-md transition duration-150">Cetak Nota</a>
            </div>
        </div>
    </div>
@endsection