<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MoneyTrack</title>
    @vite('resources/css/app.css')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-6 relative">

    <div class="w-full max-w-[400px] bg-white rounded-xl shadow-sm border border-gray-200 p-8 relative z-10">
        <!-- Branding / Header -->
        <div class="text-center mb-8">
            <span class="text-xl font-bold text-gray-900 tracking-tight block mb-1">MONEYTRACK.</span>
            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Sign in to your account</p>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-emerald-50 text-emerald-700 px-4 py-3 rounded-lg border border-emerald-100 flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-xs font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Username or Email Field -->
            <div class="space-y-1">
                <label for="login" class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Username / Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <input type="text" name="login" id="login" value="{{ old('login') }}" 
                        class="block w-full pl-9 pr-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm font-semibold text-gray-900 placeholder-gray-300 focus:bg-white focus:border-gray-900 focus:outline-none transition-colors @error('login') border-red-500 @enderror" 
                        placeholder="sifen or sifen@example.com" required autofocus>
                </div>
                @error('login')
                    <p class="text-[10px] font-semibold text-red-600 uppercase tracking-tight">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Field -->
            <div class="space-y-1">
                <label for="password" class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <input type="password" name="password" id="password" 
                        class="block w-full pl-9 pr-10 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm font-semibold text-gray-900 placeholder-gray-300 focus:bg-white focus:border-gray-900 focus:outline-none transition-colors @error('login') border-red-500 @enderror" 
                        placeholder="••••••••" required>
                    <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-900 transition-colors focus:outline-none">
                        <svg id="eye-open" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <svg id="eye-closed" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center pt-1">
                <input id="remember" name="remember" type="checkbox" 
                    class="h-4 w-4 rounded border-gray-300 text-gray-900 focus:ring-0 focus:outline-none accent-gray-900">
                <label for="remember" class="ml-2 block text-xs font-bold text-gray-400 uppercase tracking-wider select-none">
                    Remember me
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                class="w-full bg-gray-900 hover:bg-black text-white font-bold text-xs uppercase tracking-wider py-3 rounded-lg shadow-sm transition-colors mt-2">
                Sign In
            </button>
        </form>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }
    </script>
</body>
</html>
