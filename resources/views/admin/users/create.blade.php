<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Akun Admin Baru</h2>
    </x-slot>

    <div class="max-w-lg mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

            <p class="text-sm text-gray-500 mb-6">Buat akun admin baru. Setiap admin mengelola satu lahan kantin secara terpisah.</p>

            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">
                        Nama Admin <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="w-full rounded-xl border @error('name') border-red-400 @else border-gray-200 @enderror bg-gray-50 text-sm text-gray-800 px-4 py-2.5 focus:outline-none focus:border-[#7886C7] focus:ring-2 focus:ring-[#7886C7]/20 transition"
                        placeholder="Contoh: Admin Kantin 2">
                    @error('name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full rounded-xl border @error('email') border-red-400 @else border-gray-200 @enderror bg-gray-50 text-sm text-gray-800 px-4 py-2.5 focus:outline-none focus:border-[#7886C7] focus:ring-2 focus:ring-[#7886C7]/20 transition"
                        placeholder="admin2@kantin.com">
                    @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password" required
                        class="w-full rounded-xl border @error('password') border-red-400 @else border-gray-200 @enderror bg-gray-50 text-sm text-gray-800 px-4 py-2.5 focus:outline-none focus:border-[#7886C7] focus:ring-2 focus:ring-[#7886C7]/20 transition"
                        placeholder="Min. 8 karakter">
                    @error('password')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">
                        Konfirmasi Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password_confirmation" required
                        class="w-full rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 px-4 py-2.5 focus:outline-none focus:border-[#7886C7] focus:ring-2 focus:ring-[#7886C7]/20 transition"
                        placeholder="Ulangi password">
                </div>

                <div class="flex items-center justify-between gap-3 pt-2">
                    <a href="{{ route('admin.users.index') }}"
                        class="px-5 py-2.5 text-sm font-medium text-gray-500 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                        ← Kembali
                    </a>
                    <button type="submit"
                        class="px-6 py-2.5 bg-[#2D336B] hover:bg-[#7886C7] text-white text-sm font-semibold rounded-xl transition-colors">
                        Buat Akun Admin
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
