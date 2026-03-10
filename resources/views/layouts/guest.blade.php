<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Digital Canteen') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex">

            <!-- Left Panel - Branding -->
            <div class="hidden lg:flex lg:w-1/2 relative bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700 text-white flex-col justify-between p-12 overflow-hidden">
                <!-- Background blobs -->
                <div class="absolute top-0 left-0 w-72 h-72 bg-white/10 rounded-full blur-3xl -mt-20 -ml-20"></div>
                <div class="absolute bottom-0 right-0 w-72 h-72 bg-purple-500/20 rounded-full blur-3xl -mb-20 -mr-20"></div>

                <!-- Logo -->
                <a href="/" class="relative flex items-center gap-3 z-10">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center border border-white/30">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold">Digital <span class="text-yellow-300">Canteen</span></span>
                </a>

                <!-- Center Content -->
                <div class="relative z-10">
                    <div class="inline-block px-4 py-1 bg-white/20 text-sm font-semibold rounded-full border border-white/30 mb-6">
                         Kantin Digital Sekolah Modern
                    </div>
                    <h2 class="text-4xl font-extrabold leading-tight mb-4">
                        Pesan Makanan <br><span class="text-yellow-300">Lebih Mudah & Cepat</span>
                    </h2>
                    <p class="text-blue-100 text-lg leading-relaxed max-w-sm">
                        Tidak perlu antri lama. Pesan menu favoritmu dari mana saja, langsung dari genggamanmu.
                    </p>

                    <div class="mt-10 grid grid-cols-1 gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-blue-100 text-sm">Pemesanan cepat tanpa antri</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-blue-100 text-sm">Pantau status pesanan real-time</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-blue-100 text-sm">Kelola menu & pesanan dengan mudah</span>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <p class="relative z-10 text-blue-200 text-sm">© {{ date('Y') }} Digital Canteen. All rights reserved.</p>
            </div>

            <!-- Right Panel - Form -->
            <div class="w-full lg:w-1/2 flex flex-col justify-center items-center px-6 py-12 bg-gray-50">
                <!-- Mobile Logo -->
                <div class="lg:hidden mb-8 flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold text-gray-800">Digital <span class="text-blue-600">Canteen</span></span>
                </div>

                <div class="w-full max-w-md">
                    {{ $slot }}
                </div>
            </div>

        </div>
    </body>
</html>
