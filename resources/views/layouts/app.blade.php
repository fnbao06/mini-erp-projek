<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - MoneyTrack</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite('resources/css/app.css')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">
    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 flex-shrink-0 hidden md:flex flex-col">
            <div class="h-20 flex items-center px-8 border-b border-gray-200">
                <span class="text-lg font-bold text-gray-900 tracking-tight">MONEYTRACK.</span>
            </div>

            <nav class="flex-1 px-4 space-y-1 mt-6">
                @php
                    $menus = [
                        [
                            'route' => 'dashboard',
                            'label' => 'Dashboard',
                            'icon' =>
                                'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z',
                        ],
                        [
                            'route' => 'transactions',
                            'label' => 'Transactions',
                            'icon' =>
                                'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01',
                        ],
                        [
                            'route' => 'categories',
                            'label' => 'Categories',
                            'icon' =>
                                'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z',
                        ],
                        [
                            'route' => 'assets',
                            'label' => 'Assets',
                            'icon' =>
                                'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',
                        ],
                        [
                            'route' => 'reports',
                            'label' => 'Reports',
                            'icon' =>
                                'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
                        ],
                    ];
                @endphp

                @foreach ($menus as $menu)
                    <a href="{{ route($menu['route']) }}"
                        class="flex items-center px-4 py-2.5 rounded-lg text-sm transition-colors {{ request()->routeIs($menu['route']) ? 'bg-gray-100 text-gray-900 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs($menu['route']) ? 'text-gray-900' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="{{ $menu['icon'] }}"></path>
                        </svg>
                        <span>{{ $menu['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="p-4 border-t border-gray-200">
                <form action="{{ route('logout') }}" method="POST" id="logout-form" class="hidden">
                    @csrf
                </form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="flex items-center px-4 py-2.5 text-sm text-gray-600 hover:bg-red-50 hover:text-red-600 rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    <span>Log Out</span>
                </a>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col overflow-hidden">
            <header class="h-20 bg-white border-b border-gray-200 flex items-center justify-between px-8 flex-shrink-0">
                <h1 class="text-lg font-bold text-gray-900 tracking-tight">@yield('header')</h1>
                <div class="flex items-center space-x-3">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-bold text-gray-900">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-gray-400 font-medium mt-0.5">Web Developer</p>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-gray-100 border border-gray-200 flex items-center justify-center text-gray-700 font-bold text-xs">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-8">
                <!-- Toast Notification -->
                @if (session('success') || session('error') || $errors->any())
                    <div id="toast-container" class="fixed top-6 right-6 z-[100] transition-opacity duration-300">
                        <div class="bg-white border border-gray-200 text-gray-900 px-5 py-4 rounded-xl shadow-lg flex items-center gap-3.5 min-w-[320px]">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ session('success') ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }}">
                                @if (session('success'))
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-bold">
                                    @if (session('success'))
                                        {{ session('success') }}
                                    @elseif(session('error'))
                                        {{ session('error') }}
                                    @else
                                        {{ collect($errors->all())->first() }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
                @yield('content')
            </div>
        </main>
    </div>
</body>

<script>
    // AUTO-CLOSE TOAST & AUTO-OPEN MODAL ON ERROR
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Logika Auto-Open Modal berdasarkan jenis Error
        @if (($errors->any() || session('error')) && old('cat_name'))
            @if (old('active_id'))
                // Jika sedang edit, panggil fungsi editCategory dengan ID dari session
                editCategory({{ old('active_id') }});
            @else
                // Jika tidak ada ID edit, berarti error saat tambah baru
                openModalCreate();
            @endif
        @endif

        // 2. Hilangkan Toast otomatis setelah 4 detik
        const toast = document.getElementById('toast-container');
        if (toast) {
            setTimeout(() => {
                toast.classList.add('translate-y-[-20px]', 'opacity-0');
                setTimeout(() => toast.remove(), 500);
            }, 4000);
        }
    });
</script>

</html>
