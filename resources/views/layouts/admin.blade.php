<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Digital Canteen') }} — Admin</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <style>
        body { font-family: 'Figtree', sans-serif; background: #f3f4f6; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">

<div class="flex min-h-screen">

    <!-- ── SIDEBAR ── -->
    <aside class="w-64 bg-gradient-to-b from-[#2D336B] to-[#1e2248] text-white flex flex-col fixed inset-y-0 left-0 z-50 shadow-2xl">

        <!-- Logo -->
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-6 py-5 border-b border-white/10">
            <div class="w-9 h-9 bg-white/15 rounded-xl flex items-center justify-center border border-white/20 flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <div>
                <span class="font-bold text-sm leading-none">Digital Canteen</span>
                <p class="text-xs text-white/50 mt-0.5">Admin Panel</p>
            </div>
        </a>

        <!-- Nav Links -->
        <nav class="flex-1 px-3 py-5 space-y-1 overflow-y-auto">

            <p class="text-[10px] font-semibold uppercase tracking-widest text-white/40 px-3 mb-3">Main</p>

            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                      {{ request()->routeIs('dashboard') ? 'bg-white/15 text-white shadow-sm' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <!-- Kelola Menu -->
            <a href="{{ route('admin.menus.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                      {{ request()->routeIs('admin.menus.*') ? 'bg-white/15 text-white shadow-sm' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                Kelola Menu
            </a>

            <!-- Pesanan Masuk -->
            <a href="{{ route('admin.orders.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                      {{ request()->routeIs('admin.orders.index') || request()->routeIs('admin.orders.updateStatus') ? 'bg-white/15 text-white shadow-sm' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
                Pesanan Masuk
            </a>

            <!-- Riwayat Pesanan -->
            <a href="{{ route('admin.orders.history') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                      {{ request()->routeIs('admin.orders.history') ? 'bg-white/15 text-white shadow-sm' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Riwayat Pesanan
            </a>

        </nav>

        <!-- Bottom: Profile & Logout -->
        <div class="px-3 py-4 border-t border-white/10 space-y-1">
            <a href="{{ route('profile.edit') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-white/70 hover:bg-white/10 hover:text-white transition-all
                      {{ request()->routeIs('profile.*') ? 'bg-white/15 text-white shadow-sm' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Profil Saya
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-red-300 hover:bg-red-500/20 hover:text-red-200 transition-all">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>

    </aside>

    <!-- ── MAIN CONTENT ── -->
    <div class="flex-1 ml-64 flex flex-col min-h-screen">

        <!-- Top Bar -->
        <header class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between sticky top-0 z-40 shadow-sm">
            @isset($header)
                <div>{{ $header }}</div>
            @else
                <h2 class="text-lg font-bold text-gray-800">Admin Panel</h2>
            @endisset
            <div class="flex items-center gap-4">
                @isset($headerExtra)
                    <div class="flex items-center gap-2">{{ $headerExtra }}</div>
                @endisset
                <div class="flex items-center gap-3 text-sm text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ now()->translatedFormat('l, d F Y') }}
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-8">
            {{ $slot }}
        </main>

    </div>

</div>

</body>
</html>
