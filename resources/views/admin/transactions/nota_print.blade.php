<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Pembayaran - Klinik Hewan</title>
    @vite('resources/css/app.css') {{-- Pastikan Tailwind tetap dimuat untuk styling dasar --}}
    <style>
        @media print {
            body {
                -webkit-print-color-adjust: exact; /* Untuk memastikan warna background tercetak */
                print-color-adjust: exact;
                font-size: 10pt; /* Ukuran font lebih kecil untuk cetak */
            }
            .no-print {
                display: none !important;
            }
        }
        .nota-container {
            width: 80mm; /* Lebar umum untuk nota kasir */
            max-width: 300px; /* Lebar maksimal */
            margin: 0 auto;
            padding: 10mm;
            font-family: 'Consolas', 'Courier New', monospace; /* Font monospasi untuk kesan nota kasir */
            color: #000;
            background-color: #fff;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .border-bottom { border-bottom: 1px dashed #000; padding-bottom: 5px; margin-bottom: 5px; }
        .dashed-line { border-top: 1px dashed #000; margin-top: 10px; margin-bottom: 10px; }
    </style>
</head>
<body class="bg-gray-50 p-4">

    <div class="no-print text-center mb-4">
        <button onclick="window.print()" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md">Cetak Nota Ini</button>
        <a href="{{ route('admin.transactions.show', $transaction->id) }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-md ml-2">Kembali</a>
    </div>

    <div class="nota-container shadow-lg">
        <div class="text-center mb-4">
            <h1 class="text-lg font-bold">KLINIK HEWAN PET AREA</h1>
            <p class="text-sm">Jl. Contoh Alamat No. 123, Bantul</p>
            <p class="text-sm">Telp: 0812-3456-7890</p>
        </div>

        <div class="dashed-line"></div>

        <table class="w-full text-sm mb-2">
            <tr>
                <td class="w-1/2">Tanggal</td>
                <td class="w-1/2 text-right">{{ \Carbon\Carbon::parse($transaction->transaction_date)->translatedFormat('d-m-Y H:i') }}</td>
            </tr>
            <tr>
                <td>No. Transaksi</td>
                <td class="text-right">TRX-{{ $transaction->id }}-{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('Ymd') }}</td>
            </tr>
            <tr>
                <td>Admin</td>
                <td class="text-right">{{ $transaction->admin->name ?? 'N/A' }}</td>
            </tr>
            @if($transaction->patient)
            <tr>
                <td>Pasien</td>
                <td class="text-right">{{ $transaction->patient->name }}</td>
            </tr>
            <tr>
                <td>Pemilik</td>
                <td class="text-right">{{ $transaction->patient->owner_name }}</td>
            </tr>
            @endif
        </table>

        <div class="dashed-line"></div>

        <div class="mb-2">
            <p class="text-sm font-semibold">Deskripsi Layanan:</p>
            <p class="text-base break-words">{{ $transaction->description }}</p>
        </div>

        <div class="dashed-line"></div>

        <table class="w-full text-md font-bold mb-4">
            <tr>
                <td class="w-1/2">Total Pembayaran</td>
                <td class="w-1/2 text-right">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="dashed-line"></div>

        <div class="text-center text-xs mb-4">
            <p class="mb-1">Metode Pembayaran: {{ $transaction->payment_method ?? 'Tunai' }}</p>
            <p>Terima kasih atas kunjungan Anda!</p>
        </div>
    </div>

    <script>
        // Automatically print when the page loads, if it's the print version
        window.onload = function() {
            // Not automatically printing, user clicks button
        };
    </script>
</body>
</html>