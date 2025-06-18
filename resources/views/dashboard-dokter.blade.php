<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dokter - Klinik Hewan</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="bg-grey-100 font-sans antialiased flex min-h-screen">
    {{-- Ini akan jadi sidebar dokter --}}
    <aside class="w-64 bg-purple-300 text-white flex flex-col p-4 custom-scrollbar">
        <div class="flex items-center mb-8 px-2 py-4">
            <span class="material-icons text-blue-400 text-3xl mr-3">medical_services</span>
            <h2 class="text-2xl font-bold">Klinik Hewan</h2>
        </div>
        <nav class="flex-1 space-y-2">
            <h3 class="text-xs uppercase text-blue-600 px-2 pt-4 pb-2">Menu Dokter</h3>
            <ul class="space-y-1">
                <li class="sidebar-nav-item">
                    <a href="{{ route('dashboard.dokter') }}" class="flex items-center px-4 py-2 hover:bg-blue-700 rounded-md transition duration-150">
                        <span class="material-icons text-xl mr-3">dashboard</span>
                        Dashboard
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="{{ route('dokter.patients.index') }}" class="flex items-center px-4 py-2 hover:bg-blue-700 rounded-md transition duration-150">
                        <span class="material-icons text-xl mr-3">folder_open</span>
                        Data Pasien
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="{{ route('dokter.medical_records.index') }}" class="flex items-center px-4 py-2 hover:bg-blue-700 rounded-md transition duration-150">
                        <span class="material-icons text-xl mr-3">notes</span>
                        Rekam Medis & Resep
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="{{ route('dokter.staff.index') }}" class="flex items-center px-4 py-2 hover:bg-blue-700 rounded-md transition duration-150">
                        <span class="material-icons text-xl mr-3">group</span>
                        Manajemen Staf
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="{{ route('dokter.change_password') }}" class="flex items-center px-4 py-2 hover:bg-blue-700 rounded-md transition duration-150">
                        <span class="material-icons text-xl mr-3">lock</span>
                        Ganti Password
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    {{-- Main Content Area Dokter --}}
    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white p-4 shadow-sm flex items-center justify-between">
            <h1 class="text-xl font-bold text-gray-800">Dashboard Dokter</h1>
            <div class="flex items-center space-x-6">
                <span class="text-gray-600 text-sm font-medium">Selamat datang, <span class="font-semibold">{{ Auth::user()->name }}</span></span>
                <form action="{{ route('logout') }}" method="POST" class="inline-block">
                    @csrf
                    <button type="submit" class="material-icons text-gray-600 hover:text-red-500 transition duration-150">logout</button>
                </form>
            </div>
        </header>
        <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 bg-blue-50">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Area Dokter & Owner</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 shadow-sm">
                    <h3 class="text-xl font-semibold text-blue-800 mb-3">Data Pasien</h3>
                    <p class="text-gray-700 mb-4">Lihat informasi lengkap tentang semua pasien hewan.</p>
                    <a href="{{ route('dokter.patients.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">Lihat Pasien</a>
                </div>
                <div class="bg-green-50 border border-green-200 rounded-lg p-6 shadow-sm">
                    <h3 class="text-xl font-semibold text-green-800 mb-3">Rekam Medis & Resep</h3>
                    <p class="text-gray-700 mb-4">Catat riwayat kesehatan, diagnosis, tindakan, dan resep obat.</p>
                    <a href="{{ route('dokter.medical_records.index') }}" class="inline-flex items-center text-green-600 hover:text-green-800 font-medium">Kelola Rekam Medis</a>
                </div>
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-6 shadow-sm">
                    <h3 class="text-xl font-semibold text-purple-800 mb-3">Manajemen Staf</h3>
                    <p class="text-gray-700 mb-4">Kelola data admin yang membantu operasional klinik.</p>
                    <a href="{{ route('dokter.staff.index') }}" class="inline-flex items-center text-purple-600 hover:text-purple-800 font-medium">Atur Staf</a>
                </div>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 shadow-sm">
                    <h3 class="text-xl font-semibold text-yellow-800 mb-3">Ganti Password</h3>
                    <p class="text-gray-700 mb-4">Perbarui kata sandi akun Anda untuk keamanan.</p>
                    <a href="{{ route('dokter.change_password') }}" class="inline-flex items-center text-yellow-600 hover:text-yellow-800 font-medium">Ganti Password</a>
                </div>
            </div>
        </main>
    </div>
    <script>
        // Script untuk sidebar active state (jika mau)
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            document.querySelectorAll('aside .sidebar-nav-item a').forEach(link => {
                const linkPath = link.getAttribute('href').replace(/\/$/, '');
                const currentPathClean = currentPath.replace(/\/$/, '');
                if (linkPath === currentPathClean || (linkPath !== '/' && currentPathClean.startsWith(linkPath + '/'))) {
                    link.closest('.sidebar-nav-item').classList.add('active');
                }
            });
        });
    </script>
</body>
</html>