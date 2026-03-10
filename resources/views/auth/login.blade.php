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
    </style>
</head>
<body class="bg-slate-50 bg-soft-gradient min-h-screen flex items-center justify-center p-4">
    <div class="max-w-5xl w-full bg-white rounded-3xl shadow-xl shadow-slate-200/50 overflow-hidden flex flex-col md:flex-row min-h-[600px]">
        
        <!-- Illustration Side (Hidden on Mobile) -->
        <div class="hidden md:flex md:w-1/2 bg-[#2D336B] p-12 flex-col justify-between relative overflow-hidden">
            <!-- Decorative Shapes -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-[#7886C7] opacity-20 rounded-full -mr-20 -mt-20"></div>
            <div class="absolute bottom-0 left-0 w-40 h-40 bg-[#7886C7] opacity-10 rounded-full -ml-10 -mb-10"></div>
            
            <div class="relative z-10">
                <div class="text-white text-2xl font-semibold tracking-tighter mb-2">DCS</div>
                <h2 class="text-white text-3xl font-semibold tracking-tight leading-tight mt-12">
                    Nikmati kemudahan <br> pesan makanan di <br> kantin sekolah.
                </h2>
                <p class="text-[#7886C7] text-base font-normal mt-4 max-w-xs">
                    Sistem pembayaran digital yang aman dan cepat untuk seluruh civitas sekolah.
                </p>
            </div>

            <div class="relative z-10 flex items-center gap-4 bg-white/5 p-4 rounded-2xl backdrop-blur-sm border border-white/10">
                <div class="w-12 h-12 bg-[#7886C7] rounded-xl flex items-center justify-center text-white text-2xl">
                    <iconify-icon icon="solar:hamburger-food-linear" stroke-width="1.5"></iconify-icon>
                </div>
                <div>
                    <div class="text-white text-sm font-medium">Menu Hari Ini</div>
                    <div class="text-[#7886C7] text-xs">Ayam Geprek & Jus Jeruk</div>
                </div>
            </div>
        </div>

        <!-- Form Side -->
        <div class="w-full md:w-1/2 p-8 md:p-16 flex flex-col justify-center">
            <div class="mb-10">
                <div class="md:hidden text-[#2D336B] text-xl font-semibold tracking-tighter mb-6">Digital Canteen System</div>
                <h1 class="text-[#2D336B] text-2xl font-semibold tracking-tight">Selamat Datang</h1>
                <p class="text-slate-500 text-sm mt-2">Silakan masuk untuk memesan makanan favoritmu</p>
            </div>

            {{-- Session Status --}}
            @if (session('status'))
                <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email Input -->
                <div class="space-y-2">
                    <label for="email" class="text-xs font-medium text-slate-700 ml-1">Email Anda</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#2D336B] transition-colors">
                            <iconify-icon icon="solar:letter-linear" stroke-width="1.5" style="font-size: 1.25rem;"></iconify-icon>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               placeholder="nama@sekolah.sch.id" required autofocus autocomplete="username"
                               class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none transition-all duration-300 focus:border-[#2D336B] focus:ring-4 focus:ring-[#2D336B]/5 placeholder:text-slate-400 @error('email') border-red-400 @enderror">
                    </div>
                    @error('email')
                        <p class="text-xs text-red-500 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="space-y-2">
                    <div class="flex justify-between items-center ml-1">
                        <label for="password" class="text-xs font-medium text-slate-700">Kata Sandi</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs font-medium text-[#7886C7] hover:text-[#2D336B] transition-colors">Lupa Password?</a>
                        @endif
                    </div>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#2D336B] transition-colors">
                            <iconify-icon icon="solar:lock-password-linear" stroke-width="1.5" style="font-size: 1.25rem;"></iconify-icon>
                        </div>
                        <input id="password" type="password" name="password"
                               placeholder="••••••••" required autocomplete="current-password"
                               class="w-full pl-11 pr-11 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none transition-all duration-300 focus:border-[#2D336B] focus:ring-4 focus:ring-[#2D336B]/5 placeholder:text-slate-400 @error('password') border-red-400 @enderror">
                        <button type="button" onclick="const i=document.getElementById('password');i.type=i.type==='password'?'text':'password'"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600">
                            <iconify-icon icon="solar:eye-linear" stroke-width="1.5" style="font-size: 1.25rem;"></iconify-icon>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-xs text-red-500 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center gap-2 px-1">
                    <input type="checkbox" id="remember" name="remember"
                           class="w-4 h-4 rounded border-slate-300 text-[#2D336B] focus:ring-[#2D336B]/20">
                    <label for="remember" class="text-xs text-slate-500">Ingat perangkat ini</label>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full bg-[#2D336B] hover:bg-[#3d458d] text-white font-medium py-3.5 rounded-xl transition-all duration-300 transform active:scale-[0.98] shadow-lg shadow-[#2D336B]/20 flex items-center justify-center gap-2 mt-2">
                    <span>Masuk ke Akun</span>
                    <iconify-icon icon="solar:alt-arrow-right-linear" stroke-width="2" style="font-size: 1rem;"></iconify-icon>
                </button>
            </form>

            <!-- Footer -->
            <div class="mt-10 text-center">
                <p class="text-sm text-slate-500">
                    Belum punya akun?
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-[#2D336B] font-medium hover:underline decoration-2 underline-offset-4">Daftar di sini</a>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Footer Copyright -->
    <div class="fixed bottom-6 text-slate-400 text-xs tracking-wide">
        &copy; 2024 Digital Canteen System. All rights reserved.
    </div>
</body>
</html>