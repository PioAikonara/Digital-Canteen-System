<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Super Admin — DCS' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; }
        [x-cloak] { display: none !important; }
        .sa-sidebar { background: linear-gradient(180deg, #0f172a 0%, #1e1b4b 100%); }
        .sa-nav-link { display: flex; align-items: center; gap: 10px; padding: 9px 12px; border-radius: 12px;
            font-size: 13px; font-weight: 600; color: rgba(255,255,255,.55);
            text-decoration: none; transition: all .15s; }
        .sa-nav-link:hover { background: rgba(255,255,255,.08); color: rgba(255,255,255,.9); }
        .sa-nav-link.active { background: linear-gradient(90deg,rgba(245,158,11,.2),rgba(245,158,11,.08));
            color: #fbbf24; border: 1px solid rgba(245,158,11,.25); }
        .sa-nav-link.active iconify-icon { color: #fbbf24; }
        .sa-section { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em;
            color: rgba(255,255,255,.25); padding: 0 12px; margin: 18px 0 6px; }
    </style>
    {{ $head ?? '' }}
</head>
<body>
<div style="display:flex;min-height:100vh;">

    {{-- ── SIDEBAR ── --}}
    <aside class="sa-sidebar" style="width:240px;flex-shrink:0;position:fixed;inset-y:0;left:0;z-index:50;display:flex;flex-direction:column;overflow-y:auto;">

        {{-- Logo --}}
        <div style="padding:20px 16px 18px;border-bottom:1px solid rgba(255,255,255,.07);">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:36px;height:36px;background:linear-gradient(135deg,#f59e0b,#d97706);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <iconify-icon icon="solar:crown-bold" style="font-size:18px;color:#fff;"></iconify-icon>
                </div>
                <div>
                    <div style="font-size:14px;font-weight:900;color:#fff;line-height:1.1;">Super Admin</div>
                    <div style="font-size:10px;color:rgba(255,255,255,.4);">Digital Canteen System</div>
                </div>
            </div>
        </div>

        {{-- Nav --}}
        <nav style="flex:1;padding:10px 10px;">
            <div class="sa-section">Overview</div>
            <a href="{{ route('superadmin.dashboard') }}"
               class="sa-nav-link {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">
                <iconify-icon icon="solar:home-2-bold" style="font-size:17px;"></iconify-icon>
                Dashboard
            </a>
            <a href="{{ route('superadmin.orders.index') }}"
               class="sa-nav-link {{ request()->routeIs('superadmin.orders.*') ? 'active' : '' }}">
                <iconify-icon icon="solar:bag-5-bold" style="font-size:17px;"></iconify-icon>
                Monitor Pesanan
            </a>

            <div class="sa-section">Manajemen</div>
            <a href="{{ route('superadmin.users.index') }}"
               class="sa-nav-link {{ request()->routeIs('superadmin.users.*') ? 'active' : '' }}">
                <iconify-icon icon="solar:users-group-rounded-bold" style="font-size:17px;"></iconify-icon>
                Kelola Siswa
            </a>
            <a href="{{ route('superadmin.admins.index') }}"
               class="sa-nav-link {{ request()->routeIs('superadmin.admins.*') ? 'active' : '' }}">
                <iconify-icon icon="solar:shop-bold" style="font-size:17px;"></iconify-icon>
                Petugas Kantin
            </a>
            <a href="{{ route('superadmin.categories.index') }}"
               class="sa-nav-link {{ request()->routeIs('superadmin.categories.*') ? 'active' : '' }}">
                <iconify-icon icon="solar:tag-bold" style="font-size:17px;"></iconify-icon>
                Kategori Menu
            </a>

            <div class="sa-section">Keuangan</div>
            <a href="{{ route('superadmin.topup.index') }}"
               class="sa-nav-link {{ request()->routeIs('superadmin.topup.*') ? 'active' : '' }}">
                <iconify-icon icon="solar:wallet-money-bold" style="font-size:17px;"></iconify-icon>
                Top Up Saldo
            </a>
            <a href="{{ route('superadmin.reports.index') }}"
               class="sa-nav-link {{ request()->routeIs('superadmin.reports.*') ? 'active' : '' }}">
                <iconify-icon icon="solar:chart-2-bold" style="font-size:17px;"></iconify-icon>
                Laporan Transaksi
            </a>
        </nav>

        {{-- Bottom --}}
        <div style="padding:10px;border-top:1px solid rgba(255,255,255,.07);">
            <div style="display:flex;align-items:center;gap:9px;padding:10px 12px;margin-bottom:4px;">
                <div style="width:30px;height:30px;border-radius:8px;background:rgba(245,158,11,.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <iconify-icon icon="solar:crown-bold" style="font-size:14px;color:#fbbf24;"></iconify-icon>
                </div>
                <div style="min-width:0;">
                    <div style="font-size:12px;font-weight:700;color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ Auth::user()->name }}
                    </div>
                    <div style="font-size:10px;color:rgba(255,255,255,.35);">Super Admin</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sa-nav-link" style="width:100%;border:none;cursor:pointer;background:transparent;color:rgba(255,80,80,.7);">
                    <iconify-icon icon="solar:logout-2-bold" style="font-size:17px;color:rgba(255,80,80,.7);"></iconify-icon>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- ── MAIN ── --}}
    <div style="flex:1;margin-left:240px;display:flex;flex-direction:column;min-height:100vh;">

        {{-- Topbar --}}
        <header style="background:#fff;border-bottom:1.5px solid #e2e8f0;padding:13px 28px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:40;">
            <div style="font-size:14px;font-weight:800;color:#1e1b4b;">
                {{ $title ?? 'Super Admin Panel' }}
            </div>
            <div style="display:flex;align-items:center;gap:12px;">
                <span style="font-size:11px;font-weight:600;color:#94a3b8;">
                    {{ now()->format('d M Y') }}
                </span>
                <div style="display:flex;align-items:center;gap:7px;padding:6px 12px;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:100px;">
                    <div style="width:20px;height:20px;border-radius:6px;background:linear-gradient(135deg,#f59e0b,#d97706);display:flex;align-items:center;justify-content:center;">
                        <iconify-icon icon="solar:crown-bold" style="font-size:11px;color:#fff;"></iconify-icon>
                    </div>
                    <span style="font-size:11px;font-weight:700;color:#1e1b4b;">{{ explode(' ', Auth::user()->name)[0] }}</span>
                </div>
            </div>
        </header>

        {{-- Content --}}
        <main style="flex:1;padding:28px;">
            {{ $slot }}
        </main>
    </div>
</div>
</body>
</html>
