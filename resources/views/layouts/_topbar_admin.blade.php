<header class="bg-white p-4 shadow-sm flex items-center justify-between">
    <div class="relative flex items-center w-80">
        <span class="material-icons absolute left-3 text-gray-400">search</span>
        <input type="text" placeholder="Search" class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 w-full focus:outline-none focus:border-blue-500">
    </div>
    <div class="flex items-center space-x-6">
        <span id="current-date-time" class="text-gray-600 text-sm font-medium"></span> {{-- Akan diisi JS --}}
        <div class="flex items-center space-x-2 cursor-pointer">
            <img src="https://via.placeholder.com/40" alt="User Profile" class="w-10 h-10 rounded-full border-2 border-gray-300">
            <span class="font-medium text-gray-800">{{ Auth::user()->name }}</span>
        </div>
        <form action="{{ route('logout') }}" method="POST" class="inline-block">
            @csrf
            <button type="submit" class="material-icons text-gray-600 hover:text-red-500 transition duration-150">logout</button>
        </form>
    </div>
</header>