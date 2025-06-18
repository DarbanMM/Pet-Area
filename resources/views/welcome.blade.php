<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin Klinik Hewan')</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        .sidebar-nav-item.active { background-color: rgba(255, 255, 255, 0.2); border-radius: 0.375rem; }
        .custom-scrollbar::-webkit-scrollbar { width: 8px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #2a3038; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #555; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #777; }
    </style>
</head>
<body class="flex min-h-screen bg-gray-100">
    @include('layouts._sidebar_admin')
    <div class="flex-1 flex flex-col overflow-hidden">
        @include('layouts._topbar_admin')
        <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 bg-pink-50">
            @yield('content')
        </main>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            document.querySelectorAll('.sidebar-nav-item a').forEach(link => {
                const linkPath = link.getAttribute('href').replace(/\/$/, '');
                const currentPathClean = currentPath.replace(/\/$/, '');
                if (linkPath === currentPathClean || (linkPath !== '/' && currentPathClean.startsWith(linkPath + '/'))) {
                    link.closest('.sidebar-nav-item').classList.add('active');
                }
            });
            function updateTime() {
                const now = new Date();
                const optionsDate = { day: '2-digit', month: 'short', year: 'numeric' };
                const optionsTime = { hour: '2-digit', minute: '2-digit', hour12: false };
                const formattedDate = now.toLocaleDateString('id-ID', optionsDate).replace('.', '');
                const formattedTime = now.toLocaleTimeString('id-ID', optionsTime);
                document.getElementById('current-date-time').textContent = `${formattedDate} | ${formattedTime}`;
            }
            setInterval(updateTime, 1000);
            updateTime();
        });
    </script>
</body>
</html>