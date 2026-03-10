<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daftar Admin / Kantin</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto">

        @if(session('success'))
            <div class="mb-5 flex items-center gap-3 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-xl">
                ✅ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-5 flex items-center gap-3 px-4 py-3 bg-red-50 border border-red-200 text-red-600 text-sm rounded-xl">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <div>
                    <h3 class="font-semibold text-gray-800">Akun Admin Terdaftar</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Setiap admin mengelola satu lahan kantin</p>
                </div>
                <a href="{{ route('admin.users.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-[#2D336B] hover:bg-[#7886C7] text-white text-xs font-semibold rounded-xl transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Admin
                </a>
            </div>

            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs uppercase text-gray-400 tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-left">No. Kantin</th>
                        <th class="px-6 py-3 text-left">Nama</th>
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-left">Total Menu</th>
                        <th class="px-6 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($admins as $i => $admin)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-[#2D336B]/10 text-[#2D336B] font-bold text-xs">
                                    {{ $i + 1 }}
                                </span>
                                <span class="ml-2 text-gray-600 font-medium">Kantin {{ $i + 1 }}</span>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-800">
                                {{ $admin->name }}
                                @if($admin->id === auth()->id())
                                    <span class="ml-1 text-[10px] font-semibold bg-blue-100 text-blue-600 px-1.5 py-0.5 rounded-full">Anda</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-500">{{ $admin->email }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $admin->menus()->count() }} menu</td>
                            <td class="px-6 py-4">
                                @if($admin->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.destroy', $admin) }}"
                                        onsubmit="return confirm('Yakin hapus akun admin {{ addslashes($admin->name) }}? Seluruh menu kantin ini juga akan terlepas.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-xs text-red-500 hover:text-red-700 font-medium border border-red-200 hover:border-red-400 px-3 py-1 rounded-lg transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-gray-300">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400">Belum ada admin terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-admin-layout>
