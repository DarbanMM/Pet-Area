<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Klinik Hewan - Dokter')</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        /* Custom scrollbar for a cleaner look */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #4a007a; /* Darker purple */
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #8e24aa; /* Medium purple */
            border-radius: 3px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #a348d6; /* Lighter purple on hover */
        }

        /* Modern active state for sidebar items */
        .sidebar-nav-item.active a {
            background-color: theme('colors.purple.700'); /* A slightly brighter purple for active */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1); /* subtle shadow */
            position: relative;
        }
        /* Optional: Indicator line for active state */
        .sidebar-nav-item.active a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px; /* Thickness of the indicator line */
            background-color: theme('colors.purple.300'); /* Bright accent color */
            border-radius: 0 4px 4px 0;
        }

        /* Hover effect for cards */
        .card-hover-effect {
            transition: all 0.3s ease-in-out;
        }
        .card-hover-effect:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="flex min-h-screen bg-gray-50 font-sans text-gray-800">

    {{-- Sidebar Dokter (Modern Purple Theme) --}}
    <aside class="w-64 bg-purple-900 text-white flex flex-col p-4 shadow-2xl custom-scrollbar transition-all duration-300 ease-in-out">
        <div class="flex items-center mb-8 px-2 py-4 border-b border-purple-800/50 pb-5">
            <span class="material-icons text-purple-300 text-3xl mr-3 transform rotate-6 hover:rotate-0 transition-transform duration-300">medical_services</span>
            <h2 class="text-2xl font-extrabold tracking-wide text-gray-50">Klinik Hewan</h2>
        </div>
        <nav class="flex-1 space-y-2">
            <h3 class="text-xs uppercase text-purple-200/70 px-2 pt-4 pb-2 font-semibold">Menu Dokter</h3>
            <ul class="space-y-1">
                <li class="sidebar-nav-item">
                    <a href="{{ route('dashboard.dokter') }}" class="flex items-center px-4 py-3 hover:bg-purple-800 rounded-md transition-all duration-200 ease-in-out text-lg">
                        <span class="material-icons text-xl mr-4 opacity-80">dashboard</span>
                        Dashboard
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="{{ route('dokter.patients.index') }}" class="flex items-center px-4 py-3 hover:bg-purple-800 rounded-md transition-all duration-200 ease-in-out text-lg">
                        <span class="material-icons text-xl mr-4 opacity-80">folder_open</span>
                        Data Pasien
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="{{ route('dokter.medical_records.index') }}" class="flex items-center px-4 py-3 hover:bg-purple-800 rounded-md transition-all duration-200 ease-in-out text-lg">
                        <span class="material-icons text-xl mr-4 opacity-80">notes</span>
                        Rekam Medis & Resep
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="{{ route('dokter.staff.index') }}" class="flex items-center px-4 py-3 hover:bg-purple-800 rounded-md transition-all duration-200 ease-in-out text-lg">
                        <span class="material-icons text-xl mr-4 opacity-80">group</span>
                        Manajemen Staf
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="{{ route('dokter.change_password') }}" class="flex items-center px-4 py-3 hover:bg-purple-800 rounded-md transition-all duration-200 ease-in-out text-lg">
                        <span class="material-icons text-xl mr-4 opacity-80">lock</span>
                        Ganti Password
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    {{-- Main Content Area --}}
    <div class="flex-1 flex flex-col overflow-hidden">
        {{-- Topbar Dokter (Modern & Clean) --}}
        <header class="bg-white p-5 shadow-sm flex items-center justify-between border-b border-gray-100">
            <h1 class="text-2xl font-bold text-gray-800">@yield('header_title')</h1>
            <div class="flex items-center space-x-6">
                <span class="text-gray-600 text-base font-medium">Hai, <span class="font-semibold">{{ Auth::user()->name }}</span></span>
                <div class="relative group">
                    <img src="https://via.placeholder.com/40/DDA0DD/FFFFFF?text=Dr" alt="User Profile" class="w-10 h-10 rounded-full border-2 border-purple-500 cursor-pointer shadow-md transition-all duration-200 group-hover:scale-105">
                    <div class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-xl py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 ease-in-out transform scale-95 group-hover:scale-100 origin-top-right">
                        <a href="{{ route('dokter.change_password') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Ganti Password</a>
                        <div class="border-t border-gray-100 my-1"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="flex-1 overflow-x-hidden overflow-y-auto p-8 bg-purple-50/20"> {{-- Sangat terang, hampir putih --}}
            @yield('content')
        </main>
    </div>

    <script>
        // Script to set active class on sidebar items
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            document.querySelectorAll('aside .sidebar-nav-item a').forEach(link => {
                const linkPath = link.getAttribute('href').replace(/\/$/, '');
                const currentPathClean = currentPath.replace(/\/$/, '');

                if (linkPath === currentPathClean || (linkPath !== '/' && currentPathClean.startsWith(linkPath + '/'))) {
                    link.closest('.sidebar-nav-item').classList.add('active');
                }
            });

            // Smooth scroll for internal links (if any)
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });
        });
    </script>
</body>
</html>