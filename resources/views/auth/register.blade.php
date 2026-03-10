<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .bg-soft-gradient {
            background: radial-gradient(circle at top right, #7886C715, transparent),
                        radial-gradient(circle at bottom left, #2D336B10, transparent);
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
    </style>
</head>
<body class="bg-slate-50 bg-soft-gradient min-h-screen flex items-center justify-center p-4 md:p-8">
    <div class="max-w-5xl w-full bg-white rounded-3xl shadow-xl shadow-slate-200/50 overflow-hidden flex flex-col md:flex-row min-h-[700px]">
        
        <!-- Illustration Side (Desktop) -->
        <div class="hidden md:flex md:w-5/12 bg-[#2D336B] p-12 flex-col justify-between relative overflow-hidden">
            <!-- Abstract Shapes -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-[#7886C7] opacity-20 rounded-full -mr-20 -mt-20"></div>
            <div class="absolute bottom-1/4 -right-10 w-32 h-32 bg-[#7886C7] opacity-10 rounded-full"></div>
            
            <div class="relative z-10">
                <div class="text-white text-2xl font-semibold tracking-tighter mb-2">DCS</div>
                <h2 class="text-white text-3xl font-semibold tracking-tight leading-tight mt-12">
                    Gabung dengan <br> komunitas kantin <br> digital kami.
                </h2>
                <p class="text-[#7886C7] text-base font-normal mt-4 max-w-xs">
                    Mulai pengalaman jajan yang lebih modern, tanpa antri, dan tercatat dengan rapi.
                </p>
            </div>

            <div class="relative z-10 space-y-4">
                <div class="flex items-center gap-4 bg-white/5 p-4 rounded-2xl backdrop-blur-sm border border-white/10">
                    <div class="w-10 h-10 bg-[#7886C7] rounded-xl flex items-center justify-center text-white text-xl">
                        <iconify-icon icon="solar:wallet-money-linear" stroke-width="1.5"></iconify-icon>
                    </div>
                    <div>
                        <div class="text-white text-xs font-medium">Top-up Mudah</div>
                        <div class="text-[#7886C7] text-[10px]">Saldo otomatis terupdate</div>
                    </div>
                </div>
                <div class="flex items-center gap-4 bg-white/5 p-4 rounded-2xl backdrop-blur-sm border border-white/10">
                    <div class="w-10 h-10 bg-[#7886C7] rounded-xl flex items-center justify-center text-white text-xl">
                        <iconify-icon icon="solar:history-linear" stroke-width="1.5"></iconify-icon>
                    </div>
                    <div>
                        <div class="text-white text-xs font-medium">Riwayat Transaksi</div>
                        <div class="text-[#7886C7] text-[10px]">Pantau pengeluaran harianmu</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Side -->
        <div class="w-full md:w-7/12 p-8 md:p-12 lg:p-16 flex flex-col justify-center overflow-y-auto custom-scrollbar">
            <div class="mb-8">
                <div class="md:hidden text-[#2D336B] text-xl font-semibold tracking-tighter mb-6">DCS</div>
                <h1 class="text-[#2D336B] text-2xl font-semibold tracking-tight">Buat Akun Baru</h1>
                <p class="text-slate-500 text-sm mt-2">Daftar untuk mulai memesan makanan favoritmu dengan mudah dan cepat</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="grid grid-cols-1 md:grid-cols-2 gap-x-5 gap-y-4">
                @csrf

                <!-- Role Selector -->
                <div class="md:col-span-2 mb-1">
                    <label class="text-xs font-medium text-slate-700 ml-1 block mb-2">Daftar sebagai</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="role" value="customer" class="sr-only peer" {{ old('role', 'customer') === 'customer' ? 'checked' : '' }}>
                            <div class="flex items-center gap-3 px-4 py-3 rounded-xl border-2 border-slate-200 bg-slate-50
                                        peer-checked:border-[#2D336B] peer-checked:bg-[#2D336B]/5 transition-all">
                                <div class="w-8 h-8 rounded-lg bg-slate-200 peer-checked:bg-[#2D336B]/10 flex items-center justify-center flex-shrink-0">
                                    <iconify-icon icon="solar:user-linear" stroke-width="1.5" style="font-size:1.1rem;color:#2D336B"></iconify-icon>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-slate-700">Siswa</div>
                                    <div class="text-[10px] text-slate-400">Pesan menu kantin</div>
                                </div>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="role" value="admin" class="sr-only peer" {{ old('role') === 'admin' ? 'checked' : '' }}>
                            <div class="flex items-center gap-3 px-4 py-3 rounded-xl border-2 border-slate-200 bg-slate-50
                                        peer-checked:border-[#2D336B] peer-checked:bg-[#2D336B]/5 transition-all">
                                <div class="w-8 h-8 rounded-lg bg-slate-200 flex items-center justify-center flex-shrink-0">
                                    <iconify-icon icon="solar:shop-linear" stroke-width="1.5" style="font-size:1.1rem;color:#2D336B"></iconify-icon>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-slate-700">Admin Kantin</div>
                                    <div class="text-[10px] text-slate-400">Kelola menu & pesanan</div>
                                </div>
                            </div>
                        </label>
                    </div>
                    @error('role')<p class="text-xs text-red-500 ml-1 mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="space-y-1.5 md:col-span-2">
                    <label for="name" class="text-xs font-medium text-slate-700 ml-1">Nama Lengkap</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#2D336B] transition-colors">
                            <iconify-icon icon="solar:user-linear" stroke-width="1.5" style="font-size: 1.25rem;"></iconify-icon>
                        </div>
                        <input id="name" type="text" name="name" value="{{ old('name') }}"
                               placeholder="Nama lengkap sesuai kartu siswa" required autofocus autocomplete="name"
                               class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none transition-all duration-300 focus:border-[#2D336B] focus:ring-4 focus:ring-[#2D336B]/5 placeholder:text-slate-400 @error('name') border-red-400 @enderror">
                    </div>
                    @error('name')<p class="text-xs text-red-500 ml-1">{{ $message }}</p>@enderror
                </div>

                <!-- Email -->
                <div class="space-y-1.5 md:col-span-1">
                    <label for="email" class="text-xs font-medium text-slate-700 ml-1">Email Sekolah</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#2D336B] transition-colors">
                            <iconify-icon icon="solar:letter-linear" stroke-width="1.5" style="font-size: 1.25rem;"></iconify-icon>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               placeholder="nama@sekolah.sch.id" required autocomplete="username"
                               class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none transition-all duration-300 focus:border-[#2D336B] focus:ring-4 focus:ring-[#2D336B]/5 placeholder:text-slate-400 @error('email') border-red-400 @enderror">
                    </div>
                    @error('email')<p class="text-xs text-red-500 ml-1">{{ $message }}</p>@enderror
                </div>


                <!-- Password -->
                <div class="space-y-1.5 md:col-span-1">
                    <label for="password" class="text-xs font-medium text-slate-700 ml-1">Kata Sandi</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#2D336B] transition-colors">
                            <iconify-icon icon="solar:lock-password-linear" stroke-width="1.5" style="font-size: 1.25rem;"></iconify-icon>
                        </div>
                        <input id="password" type="password" name="password"
                               placeholder="Minimal 8 karakter" required autocomplete="new-password"
                               class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none transition-all duration-300 focus:border-[#2D336B] focus:ring-4 focus:ring-[#2D336B]/5 placeholder:text-slate-400 @error('password') border-red-400 @enderror">
                    </div>
                    @error('password')<p class="text-xs text-red-500 ml-1">{{ $message }}</p>@enderror
                </div>

                <!-- Confirm Password -->
                <div class="space-y-1.5 md:col-span-1">
                    <label for="password_confirmation" class="text-xs font-medium text-slate-700 ml-1">Konfirmasi Sandi</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#2D336B] transition-colors">
                            <iconify-icon icon="solar:shield-check-linear" stroke-width="1.5" style="font-size: 1.25rem;"></iconify-icon>
                        </div>
                        <input id="password_confirmation" type="password" name="password_confirmation"
                               placeholder="Ulangi password" required autocomplete="new-password"
                               class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none transition-all duration-300 focus:border-[#2D336B] focus:ring-4 focus:ring-[#2D336B]/5 placeholder:text-slate-400 @error('password_confirmation') border-red-400 @enderror">
                    </div>
                    @error('password_confirmation')<p class="text-xs text-red-500 ml-1">{{ $message }}</p>@enderror
                </div>

                <!-- Submit Button -->
                <div class="md:col-span-2 pt-4">
                    <button type="submit"
                            class="w-full bg-[#2D336B] hover:bg-[#3d458d] text-white font-medium py-3 rounded-xl transition-all duration-300 transform active:scale-[0.98] shadow-lg shadow-[#2D336B]/20 flex items-center justify-center gap-2">
                        <span>Daftar Sekarang</span>
                        <iconify-icon icon="solar:user-plus-linear" stroke-width="2" style="font-size: 1.15rem;"></iconify-icon>
                    </button>
                </div>
            </form>

            <!-- Footer -->
            <div class="mt-8 text-center">
                <p class="text-sm text-slate-500">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-[#2D336B] font-medium hover:underline decoration-2 underline-offset-4">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Footer Copyright -->
    <div class="fixed bottom-6 text-slate-400 text-xs tracking-wide hidden lg:block">
        &copy; 2024 Digital Canteen System. All rights reserved.
    </div>
</body>
</html>