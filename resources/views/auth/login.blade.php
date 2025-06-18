<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Klinik Hewan</title>
    @vite('resources/css/app.css')
    <style>
        .top-wave-bg {
            background-color: #DDA0DD; /* A shade of purple close to the image */
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 50%; /* Adjust as needed */
            clip-path: ellipse(100% 55% at 50% 0%); /* Creates the wave effect */
            z-index: 0; /* Send to back */
        }
        /* Toggle Switch Styling */
        .toggle-switch {
            position: relative;
            display: inline-flex;
            align-items: center;
            width: 160px; /* Width of the entire toggle */
            height: 40px;
            background-color: theme('colors.gray.300'); /* Light gray background */
            border-radius: 20px;
            cursor: pointer; /* Cursor on entire toggle area */
            overflow: hidden;
            font-size: 0.875rem; /* text-sm */
            font-weight: bold;
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.1); /* Subtle inner shadow */
            transition: background-color 0.3s ease-in-out;
        }

        .toggle-switch-label {
            position: relative; /* Labels are always on top */
            width: 50%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2; /* Ensure labels are always on top of handle */
            transition: color 0.3s ease-in-out;
            /* Default inactive color set by JS, but if not set by JS, will fallback to a default */
        }

        .toggle-switch-handle {
            position: absolute;
            width: 50%;
            height: 100%;
            top: 0;
            left: 0; /* Default position for Dokter */
            background-color: theme('colors.purple.500'); /* The primary purple handle */
            border-radius: 20px;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            z-index: 1; /* Handle is below labels */
        }
        /* No specific color rules here, all handled by JS now for clarity */
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen relative overflow-hidden">
    {{-- Background wave shape --}}
    <div class="top-wave-bg"></div>

    <div class="relative z-10 bg-white p-8 rounded-lg shadow-xl w-full max-w-sm">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-2">Login</h1>
        <p class="text-center text-gray-600 mb-6">Please login to dashboard</p>

        <form action="{{ route('login') }}" method="POST">
            @csrf

            {{-- Role Toggle --}}
            <div class="flex justify-center mb-6">
                <div id="roleToggle" class="toggle-switch" data-role="dokter"> {{-- data-role default ke dokter --}}
                    <span class="toggle-switch-label dokter-label">DOKTER</span>
                    <span class="toggle-switch-label admin-label">ADMIN</span>
                    <div class="toggle-switch-handle" id="toggleHandle"></div>
                </div>
                <input type="hidden" name="role_type" id="roleType" value="dokter">
            </div>


            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 text-sm animate-pulse" role="alert">
                    <strong class="font-bold">Oops!</strong>
                    <span class="block sm:inline mt-1">Ada beberapa masalah dengan input Anda.</span>
                </div>
            @endif

            <div class="mb-4">
                <label for="login_field" id="loginFieldLabel" class="block text-gray-700 text-sm font-semibold mb-2">Email Dokter</label>
                <input type="text" id="login_field" name="login_field"
                       class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-purple-300 focus:border-transparent transition duration-200 @error('login_field') border-red-500 @enderror"
                       value="{{ old('login_field') }}" required autofocus placeholder="Enter your email">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">Password</label>
                <div class="relative">
                    <input type="password" id="password" name="password"
                           class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-purple-300 focus:border-transparent transition duration-200 @error('password') border-red-500 @enderror"
                           required placeholder="Enter your password">
                    <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 cursor-pointer" onclick="togglePasswordVisibility()">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path id="eye-open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path id="eye-closed" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </span>
                </div>
            </div>

            <div class="flex items-center justify-between mb-6 text-sm">
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="form-checkbox h-4 w-4 text-purple-600 transition duration-150 ease-in-out border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-gray-900">Remember me</label>
                </div>
                <a href="#" class="font-semibold text-purple-600 hover:text-purple-800 transition duration-150">Forgot password?</a>
            </div>

            <div class="flex items-center justify-center">
                <button type="submit"
                        class="w-full bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition ease-in-out duration-150 transform hover:scale-105">
                    Login
                </button>
            </div>
        </form>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeOpen.style.display = 'none';
                eyeClosed.style.display = 'block';
            } else {
                passwordField.type = 'password';
                eyeOpen.style.display = 'block';
                eyeClosed.style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', (event) => {
            document.getElementById('eye-closed').style.display = 'none';

            const roleToggle = document.getElementById('roleToggle');
            const roleTypeInput = document.getElementById('roleType');
            const loginFieldLabel = document.getElementById('loginFieldLabel');
            const loginField = document.getElementById('login_field');
            const dokterLabel = document.querySelector('.dokter-label');
            const adminLabel = document.querySelector('.admin-label');
            const toggleHandle = document.getElementById('toggleHandle');

            // Function to update visual state
            function updateToggleVisuals(currentRole) {
                roleToggle.setAttribute('data-role', currentRole); // Update data-role attribute

                if (currentRole === 'dokter') {
                    loginFieldLabel.textContent = 'Email Dokter';
                    loginField.placeholder = 'Enter your email';
                    dokterLabel.style.color = 'black'; // Teks Dokter aktif: Putih (di atas handle ungu)
                    adminLabel.style.color = 'pink'; // Teks Admin tidak aktif: Hijau terang (di atas background abu-abu terang)
                    toggleHandle.style.left = '0%';
                } else { // admin
                    roleToggle.setAttribute('data-role', 'admin');
                    loginFieldLabel.textContent = 'Username Admin';
                    loginField.placeholder = 'Enter your username';
                    dokterLabel.style.color = 'pink'; // Teks Dokter tidak aktif: Hijau terang
                    adminLabel.style.color = 'black'; // Teks Admin aktif: Putih
                    toggleHandle.style.left = '50%';
                }
                loginField.value = ''; // Always clear field on role switch
                loginField.focus();
            }

            // Initial state from hidden input or default 'dokter'
            const initialRole = roleTypeInput.value || 'dokter';
            updateToggleVisuals(initialRole);

            // Retain old input value if exists (after validation error)
            if ("{{ old('login_field') }}") {
                loginField.value = "{{ old('login_field') }}";
            }

            // Attach click event listener directly to the toggle container
            roleToggle.addEventListener('click', function() {
                const currentRole = roleTypeInput.value;
                const newRole = (currentRole === 'dokter') ? 'admin' : 'dokter';
                roleTypeInput.value = newRole; // Update hidden input value

                updateToggleVisuals(newRole); // Update visuals based on new role
            });
        });

        // The global toggleRole function is no longer needed if event listener is attached via JS
        // But leaving it as a placeholder or removing it if not referenced elsewhere.
        // function toggleRole() { /* ... */ }
    </script>
</body>
</html>