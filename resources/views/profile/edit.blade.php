<x-customer-layout>
    <x-slot name="title">Profil Saya — DCS</x-slot>

    <div class="mb-6">
        <h1 class="text-2xl font-semibold tracking-tight text-[#2D336B]">Profil Saya</h1>
        <p class="text-slate-500 text-sm mt-1">Kelola informasi akun dan keamananmu.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left: Avatar Card --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-slate-100 p-6 flex flex-col items-center text-center gap-4">
                <img src="{{ Auth::user()->getAvatarUrl() }}" alt="Avatar"
                    class="w-24 h-24 rounded-full object-cover border-4 border-slate-100 shadow-sm">
                <div>
                    <p class="text-base font-semibold text-[#2D336B]">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-400 mt-0.5">{{ Auth::user()->email }}</p>
                    <span class="inline-block mt-2 px-3 py-0.5 text-[10px] font-medium bg-violet-50 text-violet-600 border border-violet-200 rounded-full uppercase tracking-wider">
                        {{ Auth::user()->role }}
                    </span>
                </div>
                {{-- Photo Upload Form --}}
                @if (session('status') === 'photo-updated')
                    <div class="w-full px-3 py-2 bg-emerald-50 text-emerald-700 text-xs rounded-xl text-center">
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
            <div class="bg-white rounded-2xl border border-slate-100 p-6">
                <h2 class="text-sm font-semibold text-[#2D336B] mb-1">Informasi Profil</h2>
                <p class="text-xs text-slate-400 mb-5">Perbarui nama dan alamat email akun Anda.</p>

                <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

                <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
                    @csrf
                    @method('patch')

                    <div>
                        <label for="name" class="block text-[10px] uppercase tracking-wider text-slate-400 font-medium mb-1.5">Nama</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-[#7886C7] focus:ring-1 focus:ring-[#7886C7]">
                        @error('name')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-[10px] uppercase tracking-wider text-slate-400 font-medium mb-1.5">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-[#7886C7] focus:ring-1 focus:ring-[#7886C7]">
                        @error('email')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <p class="text-xs text-amber-600 mt-1.5">
                                Email belum diverifikasi.
                                <button form="send-verification" class="underline hover:text-amber-700">Kirim ulang verifikasi.</button>
                            </p>
                            @if (session('status') === 'verification-link-sent')
                                <p class="text-xs text-emerald-600 mt-1">Link verifikasi telah dikirim.</p>
                            @endif
                        @endif
                    </div>

                    <div class="flex items-center gap-3 pt-1">
                        <button type="submit"
                            class="px-6 py-2.5 bg-[#2D336B] text-white text-xs font-medium rounded-full hover:bg-[#7886C7] transition-colors">
                            Simpan Perubahan
                        </button>
                        @if (session('status') === 'profile-updated')
                            <span x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)"
                                class="text-xs text-emerald-600">Tersimpan!</span>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Update Password --}}
            <div class="bg-white rounded-2xl border border-slate-100 p-6">
                <h2 class="text-sm font-semibold text-[#2D336B] mb-1">Ubah Password</h2>
                <p class="text-xs text-slate-400 mb-5">Gunakan password yang panjang dan acak agar akun lebih aman.</p>

                <form method="post" action="{{ route('password.update') }}" class="space-y-4">
                    @csrf
                    @method('put')

                    <div>
                        <label for="current_password" class="block text-[10px] uppercase tracking-wider text-slate-400 font-medium mb-1.5">Password Saat Ini</label>
                        <input id="current_password" name="current_password" type="password" autocomplete="current-password"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-[#7886C7] focus:ring-1 focus:ring-[#7886C7]">
                        @if($errors->updatePassword->get('current_password'))
                            <p class="text-xs text-red-500 mt-1">{{ $errors->updatePassword->first('current_password') }}</p>
                        @endif
                    </div>

                    <div>
                        <label for="new_password" class="block text-[10px] uppercase tracking-wider text-slate-400 font-medium mb-1.5">Password Baru</label>
                        <input id="new_password" name="password" type="password" autocomplete="new-password"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-[#7886C7] focus:ring-1 focus:ring-[#7886C7]">
                        @if($errors->updatePassword->get('password'))
                            <p class="text-xs text-red-500 mt-1">{{ $errors->updatePassword->first('password') }}</p>
                        @endif
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-[10px] uppercase tracking-wider text-slate-400 font-medium mb-1.5">Konfirmasi Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-[#7886C7] focus:ring-1 focus:ring-[#7886C7]">
                        @if($errors->updatePassword->get('password_confirmation'))
                            <p class="text-xs text-red-500 mt-1">{{ $errors->updatePassword->first('password_confirmation') }}</p>
                        @endif
                    </div>

                    <div class="flex items-center gap-3 pt-1">
                        <button type="submit"
                            class="px-6 py-2.5 bg-[#2D336B] text-white text-xs font-medium rounded-full hover:bg-[#7886C7] transition-colors">
                            Simpan Password
                        </button>
                        @if (session('status') === 'password-updated')
                            <span x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)"
                                class="text-xs text-emerald-600">Password diperbarui!</span>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Delete Account --}}
            <div class="bg-white rounded-2xl border border-red-100 p-6" x-data="{ deleteOpen: false }">
                <h2 class="text-sm font-semibold text-red-600 mb-1">Hapus Akun</h2>
                <p class="text-xs text-slate-400 mb-5">Setelah akun dihapus, semua data akan hilang secara permanen.</p>

                <button @click="deleteOpen = true"
                    class="px-6 py-2.5 bg-red-50 text-red-600 border border-red-200 text-xs font-medium rounded-full hover:bg-red-100 transition-colors">
                    Hapus Akun Saya
                </button>

                {{-- Confirm Modal --}}
                <div x-show="deleteOpen" x-cloak
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm"
                    @click.self="deleteOpen = false">
                    <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-sm mx-4" @click.stop>
                        <h3 class="text-base font-semibold text-red-600 mb-1">Hapus Akun?</h3>
                        <p class="text-xs text-slate-400 mb-5">Tindakan ini tidak dapat dibatalkan. Masukkan password untuk konfirmasi.</p>
                        <form method="post" action="{{ route('profile.destroy') }}" class="space-y-4">
                            @csrf
                            @method('delete')
                            <div>
                                <label class="block text-[10px] uppercase tracking-wider text-slate-400 font-medium mb-1.5">Password</label>
                                <input name="password" type="password" placeholder="Password Anda"
                                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:outline-none focus:border-red-400">
                                @if($errors->userDeletion->get('password'))
                                    <p class="text-xs text-red-500 mt-1">{{ $errors->userDeletion->first('password') }}</p>
                                @endif
                            </div>
                            <div class="flex gap-2">
                                <button type="button" @click="deleteOpen = false"
                                    class="flex-1 px-4 py-2.5 text-xs font-medium border border-slate-200 text-slate-600 rounded-full hover:bg-slate-50 transition-colors">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="flex-1 px-4 py-2.5 text-xs font-medium bg-red-600 text-white rounded-full hover:bg-red-700 transition-colors">
                                    Ya, Hapus
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

</x-customer-layout>
