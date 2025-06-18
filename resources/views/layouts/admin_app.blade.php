<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin Klinik Hewan')</title>
    @vite('resources/css/app.css') {{-- Pastikan ini memuat Tailwind CSS Anda --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> {{-- Untuk Material Icons --}}
    <style>
        /* Custom styles for sidebar active state and scrollbar */
        .sidebar-nav-item.active {
            background-color: rgba(255, 255, 255, 0.2); /* Light transparent white */
            border-radius: 0.375rem; /* rounded-md */
        }
        /* Optional: Custom scrollbar for better aesthetics */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #2a3038; /* Darker than sidebar bg */
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #555; /* Gray thumb */
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #777; /* Lighter gray on hover */
        }
    </style>
</head>
<body class="flex min-h-screen bg-gray-100">

    {{-- Sidebar --}}
    @include('layouts._sidebar_admin')

    {{-- Main Content Area --}}
    <div class="flex-1 flex flex-col overflow-hidden">
        {{-- Topbar --}}
        @include('layouts._topbar_admin')

        {{-- Page Content --}}
        <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 bg-pink-50"> {{-- Warna background yang lebih muda --}}
            @yield('content')
        </main>
    </div>

    <script>
        // Script to set active class on sidebar items
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            document.querySelectorAll('.sidebar-nav-item a').forEach(link => {
                // Remove trailing slash for exact match on root paths
                const linkPath = link.getAttribute('href').replace(/\/$/, '');
                const currentPathClean = currentPath.replace(/\/$/, '');

                if (linkPath === currentPathClean || (linkPath !== '/' && currentPathClean.startsWith(linkPath + '/'))) {
                    link.closest('.sidebar-nav-item').classList.add('active');
                }
            });

             // Update time every second
            function updateTime() {
                const now = new Date();
                const optionsDate = { day: '2-digit', month: 'short', year: 'numeric' };
                const optionsTime = { hour: '2-digit', minute: '2-digit', hour12: false };
                const formattedDate = now.toLocaleDateString('id-ID', optionsDate).replace('.', ''); // 2 Mei 2025
                const formattedTime = now.toLocaleTimeString('id-ID', optionsTime); // 16.07
                document.getElementById('current-date-time').textContent = `${formattedDate} | ${formattedTime}`;
            }
            setInterval(updateTime, 1000);
            updateTime(); // Initial call
        });
    </script>
</body>
</html>