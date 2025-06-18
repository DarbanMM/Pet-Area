@extends('layouts.admin_app') {{-- Menggunakan layout master admin --}}

@section('title', 'Dashboard Admin') {{-- Judul halaman --}}

@section('content')
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Dashboard Admin</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Card: Total Pasien --}}
        <div class="bg-white rounded-lg shadow-md p-6 flex items-center space-x-4 border-l-4 border-purple-500">
            <div class="flex-shrink-0 bg-purple-100 p-3 rounded-full">
                <span class="material-icons text-purple-600 text-3xl">pets</span> {{-- Icon pets untuk pasien --}}
            </div>
            <div>
                <p class="text-gray-500 text-sm">Total Pasien</p>
                <h3 class="text-3xl font-bold text-purple-700">{{ $totalPatients }}</h3> {{-- Data Dinamis --}}
            </div>
        </div>

        {{-- Card: Pendapatan Per Bulan --}}
        <div class="bg-white rounded-lg shadow-md p-6 flex items-center space-x-4 border-l-4 border-green-500">
            <div class="flex-shrink-0 bg-green-100 p-3 rounded-full">
                <span class="material-icons text-green-600 text-3xl">payments</span> {{-- Icon pembayaran --}}
            </div>
            <div>
                <p class="text-gray-500 text-sm">Pendapatan Per Bulan</p>
                <h3 class="text-3xl font-bold text-green-700">{{ $formattedMonthlyRevenue }}</h3> {{-- Data Dinamis --}}
            </div>
        </div>

        {{-- Anda bisa menambahkan card atau konten lain di sini --}}
    </div>
@endsection