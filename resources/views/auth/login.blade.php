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
<body class="bg-[#F3F4F6] min-h-screen flex items-center justify-center p-6 relative overflow-hidden">
    <!-- Background Gradient Bubbles -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-gray-900/5 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-gray-900/5 rounded-full blur-3xl"></div>

    <div class="w-full max-w-[440px] bg-white rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.08)] border border-gray-100 p-10 relative z-10 backdrop-blur-md">
        <!-- Branding / Header -->
        <div class="text-center mb-8">
            <span class="text-2xl font-extrabold text-gray-900 tracking-tighter italic block mb-2">MONEYTRACK.</span>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Sign in to your account</p>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-emerald-50 text-emerald-700 px-5 py-3 rounded-2xl border border-emerald-100 flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-xs font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Username or Email Field -->
            <div>
                <label for="login" class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Username / Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <input type="text" name="login" id="login" value="{{ old('login') }}" 
                        class="block w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-medium text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-900 transition-all @error('login') border-red-300 ring-2 ring-red-500/5 @enderror" 
                        placeholder="sifen or sifen@example.com" required autofocus>
                </div>
                @error('login')
                    <p class="mt-2 text-xs font-bold text-red-600 tracking-tight">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Field -->
            <div>
                <div class="flex justify-between items-center mb-2">
                    <label for="password" class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest">Password</label>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <input type="password" name="password" id="password" 
                        class="block w-full pl-11 pr-12 py-3.5 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-medium text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-900 transition-all @error('login') border-red-300 ring-2 ring-red-500/5 @enderror" 
                        placeholder="••••••••" required>
                    <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-900 transition-colors focus:outline-none">
                        <svg id="eye-open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <svg id="eye-closed" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input id="remember" name="remember" type="checkbox" 
                    class="h-4 w-4 rounded border-gray-300 text-gray-900 focus:ring-gray-900/10 focus:ring-2 accent-gray-900">
                <label for="remember" class="ml-2.5 block text-xs font-bold text-gray-500 uppercase tracking-wider select-none">
                    Remember me
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                class="w-full bg-gray-900 hover:bg-gray-800 text-white font-bold text-sm tracking-tight py-4 rounded-2xl shadow-[0_10px_30px_rgba(0,0,0,0.15)] hover:shadow-[0_15px_30px_rgba(0,0,0,0.25)] transition-all duration-300 active:scale-[0.98]">
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
