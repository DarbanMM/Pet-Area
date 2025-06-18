<aside class="w-64 bg-gray-800 text-white flex flex-col p-4 custom-scrollbar">
    <div class="flex items-center mb-8 px-2 py-4">
        <span class="material-icons text-blue-400 text-3xl mr-3">pets</span>
        <h2 class="text-2xl font-bold">Klinik Hewan</h2>
    </div>

    <nav class="flex-1 space-y-2">
        <h3 class="text-xs uppercase text-gray-400 px-2 pt-4 pb-2">Menu Utama</h3>
        <ul class="space-y-1">
            <li class="sidebar-nav-item">
                <a href="{{ route('dashboard.admin') }}" class="flex items-center px-4 py-2 hover:bg-gray-700 rounded-md transition duration-150">
                    <span class="material-icons text-xl mr-3">dashboard</span>
                    Dashboard
                </a>
            </li>
        </ul>

        <h3 class="text-xs uppercase text-gray-400 px-2 pt-4 pb-2">Manajemen Pasien</h3>
        <ul class="space-y-1">
            <li class="sidebar-nav-item">
                <a href="{{ route('admin.patients.index') }}" class="flex items-center px-4 py-2 hover:bg-gray-700 rounded-md transition duration-150">
                    <span class="material-icons text-xl mr-3">folder_shared</span>
                    Pasien
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="{{ route('admin.medical_records.index') }}" class="flex items-center px-4 py-2 hover:bg-gray-700 rounded-md transition duration-150">
                    <span class="material-icons text-xl mr-3">article</span>
                    Rekam Medis
                </a>
            </li>
            {{-- Tambahkan link Kunjungan --}}
            <li class="sidebar-nav-item">
                <a href="{{ route('admin.visits.index') }}" class="flex items-center px-4 py-2 hover:bg-gray-700 rounded-md transition duration-150">
                    <span class="material-icons text-xl mr-3">history</span>
                    Riwayat Kunjungan
                </a>
            </li>
        </ul>

        <h3 class="text-xs uppercase text-gray-400 px-2 pt-4 pb-2">Lihat Staff</h3>
        <ul class="space-y-1">
            <li class="sidebar-nav-item">
                <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-700 rounded-md transition duration-150">
                    <span class="material-icons text-xl mr-3">person_pin</span>
                    Dokter
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-700 rounded-md transition duration-150">
                    <span class="material-icons text-xl mr-3">people</span>
                    Staff
                </a>
            </li>
        </ul>

        <h3 class="text-xs uppercase text-gray-400 px-2 pt-4 pb-2">Pembayaran</h3>
        <ul class="space-y-1">
            <li class="sidebar-nav-item">
                <a href="{{ route('admin.transactions.index') }}" class="flex items-center px-4 py-2 hover:bg-gray-700 rounded-md transition duration-150">
                    <span class="material-icons text-xl mr-3">receipt_long</span>
                    Transaksi Pembayaran
                </a>
            </li>
        </ul>
    </nav>
</aside>