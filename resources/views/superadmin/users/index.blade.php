<x-superadmin-layout>
    <x-slot name="title">Kelola Siswa — Super Admin</x-slot>

    <style>
        .sa-card { background:#fff;border:1.5px solid #e2e8f0;border-radius:18px;overflow:hidden; }
        .sa-table th { font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;padding:11px 14px;border-bottom:1.5px solid #f1f5f9;background:#f8fafc; }
        .sa-table td { font-size:13px;color:#334155;padding:12px 14px;border-bottom:1px solid #f1f5f9;vertical-align:middle; }
        .sa-table tr:last-child td { border-bottom:none; }
        .sa-table tr:hover td { background:#fafbff; }
        .sa-btn-pri { display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:linear-gradient(135deg,#1e1b4b,#7c3aed);color:#fff;border-radius:10px;font-size:12px;font-weight:700;text-decoration:none;border:none;cursor:pointer;transition:opacity .15s; }
        .sa-btn-pri:hover { opacity:.88; }
        .sa-input { width:100%;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;color:#334155;outline:none;background:#f8fafc;font-family:inherit;transition:border-color .15s; }
        .sa-input:focus { border-color:#7c3aed;background:#fff; }
    </style>

    {{-- Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
        <div>
            <h1 style="font-size:20px;font-weight:900;color:#0f172a;margin:0 0 3px;">Kelola Siswa / Customer</h1>
            <p style="font-size:13px;color:#64748b;margin:0;">Manajemen akun siswa pengguna kantin</p>
        </div>
        <a href="{{ route('superadmin.users.create') }}" class="sa-btn-pri">
            <iconify-icon icon="solar:add-circle-bold" style="font-size:14px;"></iconify-icon>
            Tambah Siswa
        </a>
    </div>

    @if(session('success'))
    <div style="margin-bottom:16px;display:flex;align-items:center;gap:10px;padding:12px 16px;background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:13px;color:#166534;font-size:13px;font-weight:600;">
        <iconify-icon icon="solar:check-circle-bold" style="font-size:18px;"></iconify-icon>
        {{ session('success') }}
    </div>
    @endif

    <div class="sa-card">
        {{-- Search bar --}}
        <div style="padding:14px 18px;border-bottom:1.5px solid #f1f5f9;display:flex;align-items:center;gap:10px;">
            <form method="GET" action="{{ route('superadmin.users.index') }}" style="display:flex;gap:8px;flex:1;">
                <div style="position:relative;flex:1;max-width:320px;">
                    <iconify-icon icon="solar:magnifer-bold" style="position:absolute;left:10px;top:50%;transform:translateY(-50%);font-size:14px;color:#94a3b8;pointer-events:none;"></iconify-icon>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau email…" class="sa-input" style="padding-left:32px;">
                </div>
                <button type="submit" class="sa-btn-pri" style="padding:8px 14px;">Cari</button>
                @if($search)<a href="{{ route('superadmin.users.index') }}" class="sa-btn-pri" style="background:#f1f5f9;color:#64748b;">Reset</a>@endif
            </form>
            <span style="font-size:12px;font-weight:700;color:#64748b;">{{ $users->total() }} siswa</span>
        </div>

        <table class="sa-table" style="width:100%;border-collapse:collapse;">
            <thead><tr>
                <th>Nama</th>
                <th>Email</th>
                <th style="text-align:right;">Saldo</th>
                <th style="text-align:right;">Pesanan</th>
                <th>Status</th>
                <th>Bergabung</th>
                <th style="text-align:center;">Aksi</th>
            </tr></thead>
            <tbody>
            @forelse($users as $user)
            <tr>
                <td>
                    <div style="font-weight:700;color:#1e293b;">{{ $user->name }}</div>
                </td>
                <td style="color:#64748b;">{{ $user->email }}</td>
                <td style="text-align:right;font-weight:800;color:#16a34a;">Rp {{ number_format($user->balance, 0, ',', '.') }}</td>
                <td style="text-align:right;font-weight:700;">{{ $user->orders_count }}</td>
                <td>
                    @if($user->is_active ?? true)
                    <span style="display:inline-flex;align-items:center;gap:4px;padding:3px 10px;background:#dcfce7;border:1.5px solid #bbf7d0;border-radius:100px;font-size:10px;font-weight:700;color:#166534;">
                        <iconify-icon icon="solar:check-circle-bold" style="font-size:11px;"></iconify-icon> Aktif
                    </span>
                    @else
                    <span style="display:inline-flex;align-items:center;gap:4px;padding:3px 10px;background:#fef2f2;border:1.5px solid #fecaca;border-radius:100px;font-size:10px;font-weight:700;color:#dc2626;">
                        Nonaktif
                    </span>
                    @endif
                </td>
                <td style="font-size:11px;color:#94a3b8;">{{ $user->created_at->format('d M Y') }}</td>
                <td style="text-align:center;">
                    <div style="display:inline-flex;gap:6px;">
                        <a href="{{ route('superadmin.users.edit', $user) }}"
                           style="display:inline-flex;align-items:center;gap:4px;padding:5px 11px;background:#ede9fe;color:#7c3aed;border-radius:8px;font-size:11px;font-weight:700;text-decoration:none;">
                            <iconify-icon icon="solar:pen-bold" style="font-size:12px;"></iconify-icon> Edit
                        </a>
                        <form method="POST" action="{{ route('superadmin.users.destroy', $user) }}"
                              onsubmit="return confirm('Hapus akun {{ $user->name }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" style="display:inline-flex;align-items:center;gap:4px;padding:5px 11px;background:#fef2f2;color:#dc2626;border:none;border-radius:8px;font-size:11px;font-weight:700;cursor:pointer;">
                                <iconify-icon icon="solar:trash-bin-trash-bold" style="font-size:12px;"></iconify-icon> Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;color:#94a3b8;padding:36px;font-size:13px;">
                Tidak ada siswa ditemukan
            </td></tr>
            @endforelse
            </tbody>
        </table>

        @if($users->hasPages())
        <div style="padding:14px 18px;border-top:1.5px solid #f1f5f9;">{{ $users->links() }}</div>
        @endif
    </div>

</x-superadmin-layout>
