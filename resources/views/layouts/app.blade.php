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

<body class="bg-[#F9FAFB] text-gray-900">
    <div class="flex h-screen overflow-hidden">

        <aside class="w-64 bg-gray-900 text-gray-300 flex-shrink-0 hidden md:flex flex-col">
            <div class="h-20 flex items-center px-8">
                <span class="text-xl font-extrabold text-white tracking-tighter italic">MONEYTRACK.</span>
            </div>

            <nav class="flex-1 px-4 space-y-1 mt-4">
                <p class="px-4 text-[10px] font-bold text-gray-500 uppercase tracking-[0.2em] mb-4">Main Menu</p>

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
                    ];
                @endphp

                @foreach ($menus as $menu)
                    <a href="{{ route($menu['route']) }}"
                        class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs($menu['route']) ? 'bg-white text-gray-900 shadow-lg' : 'hover:bg-gray-800 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="{{ $menu['icon'] }}"></path>
                        </svg>
                        <span class="text-sm font-semibold">{{ $menu['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="p-4 border-t border-gray-800">
                <a href="#"
                    class="flex items-center px-4 py-3 text-red-400 hover:bg-red-500/10 rounded-xl transition-all">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    <span class="text-sm font-bold">Log Out</span>
                </a>
            </div>
        </aside>

        <main class="flex-1 flex flex-col overflow-hidden">
            <header class="h-20 bg-white border-b border-gray-100 flex items-center justify-between px-8 flex-shrink-0">
                <h1 class="text-xl font-bold text-gray-900 tracking-tight uppercase">@yield('header')</h1>
                <div class="flex items-center space-x-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-bold text-gray-900 leading-none">Sifen</p>
                        <p class="text-[10px] text-gray-400 font-medium uppercase mt-1">Web Developer</p>
                    </div>
                    <div
                        class="w-10 h-10 rounded-full bg-gray-900 flex items-center justify-center text-white font-bold text-xs border border-gray-200 shadow-sm">
                        S</div>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-8">
                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>
