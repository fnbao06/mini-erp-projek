<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')MoneyTrack</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-slate-50 font-sans text-gray-900 antialiased">
    <div class="flex h-screen overflow-hidden">

        <aside
            class="w-64 bg-gradient-to-b from-blue-600 to-blue-800 text-white shrink-0 hidden md:flex flex-col shadow-xl z-20">
            <div class="p-6 flex items-center gap-3">
                <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-5 h-5 text-blue-600">
                        <path d="M12 7.5a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" />
                        <path fill-rule="evenodd"
                            d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v9.75c0 1.036-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 14.625v-9.75ZM8.25 9.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM18.75 9a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V9.75a.75.75 0 0 0-.75-.75h-.008ZM4.5 9.75A.75.75 0 0 1 5.25 9h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H5.25a.75.75 0 0 1-.75-.75V9.75Z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <span class="text-2xl font-bold tracking-tight">MoneyTrack</span>
            </div>

            <nav class="flex-1 px-4 py-4 space-y-1.5">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 py-2.5 px-4 rounded-xl transition-all duration-200 group {{ request()->routeIs('dashboard') ? 'bg-white text-blue-700 shadow-sm font-semibold' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor"
                        class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-blue-200 group-hover:text-white' }}">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('transactions') }}"
                    class="flex items-center gap-3 py-2.5 px-4 rounded-xl transition-all duration-200 group {{ request()->routeIs('transactions') ? 'bg-white text-blue-700 shadow-sm font-semibold' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor"
                        class="w-5 h-5 {{ request()->routeIs('transactions') ? 'text-blue-600' : 'text-blue-200 group-hover:text-white' }}">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                    </svg>
                    Transaction
                </a>

                <a href="{{ route('categories') }}"
                    class="flex items-center gap-3 py-2.5 px-4 rounded-xl transition-all duration-200 group {{ request()->routeIs('categories') ? 'bg-white text-blue-700 shadow-sm font-semibold' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor"
                        class="w-5 h-5 {{ request()->routeIs('categories') ? 'text-blue-600' : 'text-blue-200 group-hover:text-white' }}">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                    </svg>
                    Category
                </a>
            </nav>
        </aside>

        <main class="flex-1 overflow-y-auto bg-slate-50 relative">

            <header
                class="sticky top-0 z-10 flex justify-between items-center bg-white/80 backdrop-blur-md border-b border-gray-200 px-8 py-5">
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">
                    @yield('header')
                </h1>

                <button
                    class="flex items-center gap-3 hover:bg-gray-50 p-1.5 rounded-xl transition-colors duration-200">
                    <div class="text-right hidden sm:block">
                        <span class="block text-sm font-semibold text-gray-900 leading-tight">Halo, Sifen</span>
                        {{-- <span class="block text-xs text-gray-500">Administrator</span> --}}
                    </div>
                    <div
                        class="w-10 h-10 rounded-full bg-blue-100 border border-blue-200 flex items-center justify-center text-blue-700 font-bold shadow-sm">
                        S
                    </div>
                    {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg> --}}
                </button>
            </header>

            <div class="p-8">
                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>
