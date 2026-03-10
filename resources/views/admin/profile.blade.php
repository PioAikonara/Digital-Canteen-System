<x-admin-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-semibold tracking-tight text-[#2D336B]">Profil Saya</h1>
        <p class="text-slate-500 text-sm mt-1">Kelola informasi akun dan keamananmu.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left: Avatar Card --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex flex-col items-center text-center gap-4">
                <img src="{{ Auth::user()->getAvatarUrl() }}" alt="Avatar"
                    class="w-24 h-24 rounded-full object-cover border-4 border-slate-100 shadow-sm">
                <div>
                    <p class="text-base font-semibold text-slate-800">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-400 mt-0.5">{{ Auth::user()->email }}</p>
                    <span class="inline-block mt-2 px-3 py-0.5 text-[10px] font-medium bg-[#2D336B]/10 text-[#2D336B] border border-[#2D336B]/20 rounded-full uppercase tracking-wider">
                        Admin
                    </span>
                </div>
                {{-- Photo Upload Form --}}
                @if (session('status') === 'photo-updated')
                    <div class="w-full px-3 py-2 bg-emerald-50 text-emerald-600 text-xs rounded-xl text-center border border-emerald-200">
                        Foto berhasil diperbarui!
                    </div>
                @endif
                <form method="POST" action="{{ route('profile.photo') }}" enctype="multipart/form-data" class="w-full">
                    @csrf
                    <label class="flex flex-col items-center gap-2 w-full border-2 border-dashed border-slate-200 rounded-xl p-4 cursor-pointer hover:border-[#7886C7] transition-colors">
                        <iconify-icon icon="solar:camera-add-linear" width="22" class="text-slate-400"></iconify-icon>
                        <span class="text-xs text-slate-400">Ganti foto profil</span>
                        <input type="file" name="profile_photo" accept="image/*" class="hidden" onchange="this.form.submit()">
                    </label>
                    @error('profile_photo')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </form>
            </div>
        </div>

        {{-- Right: Forms --}}
        <div class="lg:col-span-2 flex flex-col gap-5">

            {{-- Update Profile Info --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <h2 class="text-sm font-semibold text-slate-800 mb-1">Informasi Profil</h2>
                <p class="text-xs text-slate-400 mb-5">Perbarui nama dan alamat email akun Anda.</p>

                <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

                <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
                    @csrf
                    @method('patch')

                    <div>
                        <label for="name" class="block text-[10px] uppercase tracking-wider text-slate-400 font-medium mb-1.5">Nama</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-[#7886C7] focus:ring-2 focus:ring-[#7886C7]/20 transition">
                        @error('name')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-[10px] uppercase tracking-wider text-slate-400 font-medium mb-1.5">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-[#7886C7] focus:ring-2 focus:ring-[#7886C7]/20 transition">
                        @error('email')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-3 pt-1">
                        <button type="submit"
                            class="px-6 py-2.5 bg-[#2D336B] hover:bg-[#7886C7] text-white text-xs font-semibold rounded-xl transition-colors">
                            Simpan Perubahan
                        </button>
                        @if (session('status') === 'profile-updated')
                            <span x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)"
                                class="text-xs text-emerald-500">Tersimpan!</span>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Update Password --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <h2 class="text-sm font-semibold text-slate-800 mb-1">Ubah Password</h2>
                <p class="text-xs text-slate-400 mb-5">Gunakan password yang panjang dan acak agar akun lebih aman.</p>

                <form method="post" action="{{ route('password.update') }}" class="space-y-4">
                    @csrf
                    @method('put')

                    <div>
                        <label for="current_password" class="block text-[10px] uppercase tracking-wider text-slate-400 font-medium mb-1.5">Password Saat Ini</label>
                        <input id="current_password" name="current_password" type="password" autocomplete="current-password"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-[#7886C7] focus:ring-2 focus:ring-[#7886C7]/20 transition">
                        @if($errors->updatePassword->get('current_password'))
                            <p class="text-xs text-red-500 mt-1">{{ $errors->updatePassword->first('current_password') }}</p>
                        @endif
                    </div>

                    <div>
                        <label for="new_password" class="block text-[10px] uppercase tracking-wider text-slate-400 font-medium mb-1.5">Password Baru</label>
                        <input id="new_password" name="password" type="password" autocomplete="new-password"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-[#7886C7] focus:ring-2 focus:ring-[#7886C7]/20 transition">
                        @if($errors->updatePassword->get('password'))
                            <p class="text-xs text-red-500 mt-1">{{ $errors->updatePassword->first('password') }}</p>
                        @endif
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-[10px] uppercase tracking-wider text-slate-400 font-medium mb-1.5">Konfirmasi Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-[#7886C7] focus:ring-2 focus:ring-[#7886C7]/20 transition">
                        @if($errors->updatePassword->get('password_confirmation'))
                            <p class="text-xs text-red-500 mt-1">{{ $errors->updatePassword->first('password_confirmation') }}</p>
                        @endif
                    </div>

                    <div class="flex items-center gap-3 pt-1">
                        <button type="submit"
                            class="px-6 py-2.5 bg-[#2D336B] hover:bg-[#7886C7] text-white text-xs font-semibold rounded-xl transition-colors">
                            Simpan Password
                        </button>
                        @if (session('status') === 'password-updated')
                            <span x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)"
                                class="text-xs text-emerald-500">Password diperbarui!</span>
                        @endif
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-admin-layout>
