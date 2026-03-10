<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Digital Canteen System' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        #mobile-menu-toggle:checked ~ #mobile-menu { display: flex; }
    </style>
    {{ $head ?? '' }}
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen">

    <div x-data="{ photoModalOpen: false, dropOpen: false }">

        {{-- ── Photo Upload Modal ─────────────────────────────────────────── --}}
        <div x-show="photoModalOpen" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm"
            @click.self="photoModalOpen = false">
            <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-sm mx-4" @click.stop>
                <h3 class="text-base font-semibold text-[#2D336B] mb-1">Ganti Foto Profil</h3>
                <p class="text-xs text-slate-400 mb-4">JPG, PNG, atau WEBP — maksimal 2MB</p>

                @if (session('status') === 'photo-updated')
                    <div class="mb-3 px-3 py-2 bg-emerald-50 text-emerald-700 text-xs rounded-lg">
                        Foto profil berhasil diperbarui.
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.photo') }}" enctype="multipart/form-data" class="flex flex-col gap-3">
                    @csrf
                    <label class="flex flex-col items-center justify-center gap-2 border-2 border-dashed border-slate-200 rounded-xl p-6 cursor-pointer hover:border-[#7886C7] transition-colors">
                        <iconify-icon icon="solar:camera-add-linear" width="28" class="text-slate-400"></iconify-icon>
                        <span class="text-xs text-slate-400">Klik untuk pilih foto</span>
                        <input type="file" name="profile_photo" accept="image/*" class="hidden" required>
                    </label>
                    @error('profile_photo')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                    <div class="flex gap-2">
                        <button type="button" @click="photoModalOpen = false"
                            class="flex-1 px-4 py-2 text-xs font-medium border border-slate-200 text-slate-600 rounded-full hover:bg-slate-50 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="flex-1 px-4 py-2 text-xs font-medium bg-[#2D336B] text-white rounded-full hover:bg-[#7886C7] transition-colors">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ── Navbar ──────────────────────────────────────────────────────── --}}
        <nav class="bg-[#2D336B] text-white sticky top-0 z-40 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 md:px-6">
                <div class="flex items-center justify-between h-14">

                    {{-- Logo --}}
                    <div class="flex items-center gap-2">
                        <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-2">
                            <span class="text-lg font-semibold tracking-tighter uppercase">DCS</span>
                            <span class="hidden sm:block text-xs font-light opacity-80 tracking-wide border-l border-white/20 pl-2">Digital Canteen System</span>
                        </a>
                    </div>

                    {{-- Desktop Nav --}}
                    <div class="hidden md:flex items-center gap-6">
                        <a href="{{ route('customer.dashboard') }}"
                            class="text-sm transition-colors {{ request()->routeIs('customer.dashboard') ? 'font-medium border-b-2 border-[#7886C7] text-white' : 'font-normal text-white/70 hover:text-white' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('customer.orders.index') }}"
                            class="text-sm transition-colors {{ request()->routeIs('customer.orders.index') ? 'font-medium border-b-2 border-[#7886C7] text-white' : 'font-normal text-white/70 hover:text-white' }}">
                            Menu
                        </a>
                        <a href="{{ route('customer.myOrders') }}"
                            class="text-sm transition-colors {{ request()->routeIs('customer.myOrders') ? 'font-medium border-b-2 border-[#7886C7] text-white' : 'font-normal text-white/70 hover:text-white' }}">
                            Pesanan Saya
                        </a>
                        <a href="{{ route('customer.history') }}"
                            class="text-sm transition-colors {{ request()->routeIs('customer.history') ? 'font-medium border-b-2 border-[#7886C7] text-white' : 'font-normal text-white/70 hover:text-white' }}">
                            Riwayat
                        </a>
                    </div>

                    {{-- Right Actions --}}
                    <div class="flex items-center gap-4">
                        {{-- Bell --}}
                        <button class="relative p-1 text-white/80 hover:text-white transition-colors">
                            <iconify-icon icon="solar:bell-linear" width="20"></iconify-icon>
                        </button>

                        {{-- Profile Dropdown --}}
                        <div class="relative flex items-center gap-3 pl-3 border-l border-white/10 cursor-pointer"
                            @click="dropOpen = !dropOpen" @click.away="dropOpen = false">
                            <div class="hidden sm:block text-right">
                                <div class="text-[10px] text-white/50 leading-none">Siswa</div>
                                <div class="text-xs font-medium">{{ Auth::user()->name }}</div>
                            </div>
                            <img src="{{ Auth::user()->getAvatarUrl() }}" alt="Avatar"
                                class="w-8 h-8 rounded-full bg-slate-200 border border-white/20 object-cover">

                            {{-- Dropdown --}}
                            <div x-show="dropOpen" x-cloak
                                class="absolute right-0 top-10 w-44 bg-white rounded-xl shadow-lg border border-slate-100 py-1 z-50 text-slate-700">
                                <button @click="dropOpen = false; photoModalOpen = true"
                                    class="w-full flex items-center gap-2 px-4 py-2 text-xs hover:bg-slate-50">
                                    <iconify-icon icon="solar:camera-linear" width="14"></iconify-icon>
                                    Ganti Foto
                                </button>
                                <a href="{{ route('profile.edit') }}"
                                    class="flex items-center gap-2 px-4 py-2 text-xs hover:bg-slate-50">
                                    <iconify-icon icon="solar:user-linear" width="14"></iconify-icon>
                                    Profil Saya
                                </a>
                                <div class="border-t border-slate-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center gap-2 px-4 py-2 text-xs text-red-500 hover:bg-red-50">
                                        <iconify-icon icon="solar:logout-2-linear" width="14"></iconify-icon>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Mobile Toggle --}}
                        <label for="mobile-menu-toggle" class="md:hidden flex items-center cursor-pointer">
                            <iconify-icon icon="solar:hamburger-menu-linear" width="24"></iconify-icon>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Mobile Menu --}}
            <input type="checkbox" id="mobile-menu-toggle" class="hidden">
            <div id="mobile-menu" class="hidden flex-col bg-[#2D336B] border-t border-white/10 md:hidden">
                <a href="{{ route('customer.dashboard') }}" class="px-6 py-3 text-sm border-b border-white/5 {{ request()->routeIs('customer.dashboard') ? 'bg-white/5' : '' }}">Dashboard</a>
                <a href="{{ route('customer.orders.index') }}" class="px-6 py-3 text-sm border-b border-white/5 {{ request()->routeIs('customer.orders.index') ? 'bg-white/5' : '' }}">Menu</a>
                <a href="{{ route('customer.myOrders') }}" class="px-6 py-3 text-sm border-b border-white/5 {{ request()->routeIs('customer.myOrders') ? 'bg-white/5' : '' }}">Pesanan Saya</a>
                <a href="{{ route('customer.history') }}" class="px-6 py-3 text-sm {{ request()->routeIs('customer.history') ? 'bg-white/5' : '' }}">Riwayat</a>
            </div>
        </nav>

        {{-- ── Main Content ─────────────────────────────────────────────────── --}}
        <main class="max-w-7xl mx-auto px-4 md:px-6 py-8">
            {{ $slot }}
        </main>

        {{-- ── Footer ───────────────────────────────────────────────────────── --}}
        <footer class="max-w-7xl mx-auto px-6 py-8 mt-4 border-t border-slate-200">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="text-[10px] text-slate-400 tracking-wide uppercase">
                    &copy; {{ date('Y') }} Digital Canteen System. v1.0.4
                </div>
                <div class="flex gap-6">
                    <a href="#" class="text-xs text-slate-400 hover:text-[#2D336B]">Bantuan</a>
                    <a href="#" class="text-xs text-slate-400 hover:text-[#2D336B]">Kebijakan Privasi</a>
                    <a href="#" class="text-xs text-slate-400 hover:text-[#2D336B]">Syarat &amp; Ketentuan</a>
                </div>
            </div>
        </footer>

    </div>{{-- end Alpine root --}}

</body>
</html>
