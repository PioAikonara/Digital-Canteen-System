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

        /* ── Sidebar Base ── */
        .sa-sidebar {
            background: #0d1117;
            border-right: 1px solid rgba(255,255,255,.05);
            box-shadow: 4px 0 32px rgba(0,0,0,.4);
        }

        /* ── Nav Links ── */
        .sa-nav-link {
            display: flex; align-items: center; gap: 11px;
            padding: 9px 14px; border-radius: 10px;
            font-size: 13px; font-weight: 500;
            color: rgba(255,255,255,.4);
            text-decoration: none;
            transition: background .18s, color .18s, transform .18s;
            position: relative; overflow: hidden;
        }
        .sa-nav-link:hover {
            background: rgba(255,255,255,.06);
            color: rgba(255,255,255,.85);
            transform: translateX(3px);
        }
        .sa-nav-link.active {
            background: rgba(251,191,36,.1);
            color: #fbbf24;
            font-weight: 600;
        }
        .sa-nav-link.active::before {
            content: '';
            position: absolute; left: 0; top: 20%; bottom: 20%;
            width: 3px; border-radius: 0 3px 3px 0;
            background: linear-gradient(180deg, #f59e0b, #fbbf24);
            box-shadow: 0 0 8px rgba(251,191,36,.5);
        }
        .sa-nav-link.active iconify-icon { color: #fbbf24; }
        .sa-nav-link iconify-icon { flex-shrink: 0; transition: color .18s; }

        /* ── Section Labels ── */
        .sa-section {
            display: flex; align-items: center; gap: 8px;
            font-size: 9.5px; font-weight: 700; text-transform: uppercase;
            letter-spacing: .12em; color: rgba(255,255,255,.18);
            padding: 0 14px; margin: 22px 0 6px;
        }
        .sa-section::after {
            content: ''; flex: 1; height: 1px;
            background: rgba(255,255,255,.06);
        }

        /* ── Logout button ── */
        .sa-logout {
            display: flex; align-items: center; gap: 11px;
            width: 100%; padding: 9px 14px; border-radius: 10px;
            font-size: 13px; font-weight: 500; color: rgba(248,113,113,.6);
            border: none; cursor: pointer; background: transparent;
            transition: background .18s, color .18s;
            font-family: 'Inter', sans-serif;
        }
        .sa-logout:hover {
            background: rgba(248,113,113,.1);
            color: #f87171;
        }
        .sa-logout:hover iconify-icon { color: #f87171; }
    </style>
    {{ $head ?? '' }}
</head>
<body>
<div style="display:flex;min-height:100vh;">

    {{-- ── SIDEBAR ── --}}
    <aside class="sa-sidebar" style="width:248px;flex-shrink:0;position:fixed;inset-y:0;left:0;z-index:50;display:flex;flex-direction:column;overflow-y:auto;">

        {{-- ── Brand ── --}}
        <div style="padding:22px 16px 16px;">
            <div style="display:flex;align-items:center;gap:12px;">
                <div style="width:40px;height:40px;background:linear-gradient(135deg,#f59e0b 0%,#b45309 100%);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 12px rgba(245,158,11,.35);">
                    <iconify-icon icon="solar:crown-bold" style="font-size:20px;color:#fff;"></iconify-icon>
                </div>
                <div>
                    <div style="font-size:14px;font-weight:800;color:#fff;line-height:1.2;letter-spacing:-.01em;">Super Admin</div>
                    <div style="font-size:10px;font-weight:500;color:rgba(255,255,255,.3);margin-top:1px;">Digital Canteen System</div>
                </div>
            </div>
        </div>

        {{-- Divider --}}
        <div style="height:1px;background:linear-gradient(90deg,transparent,rgba(255,255,255,.07),transparent);margin:0 16px 4px;"></div>

        {{-- ── Nav ── --}}
        <nav style="flex:1;padding:4px 10px 10px;">

            <div class="sa-section">Overview</div>
            <a href="{{ route('superadmin.dashboard') }}"
               class="sa-nav-link {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">
                <iconify-icon icon="solar:home-2-bold" style="font-size:18px;"></iconify-icon>
                Dashboard
            </a>
            <a href="{{ route('superadmin.orders.index') }}"
               class="sa-nav-link {{ request()->routeIs('superadmin.orders.*') ? 'active' : '' }}">
                <iconify-icon icon="solar:bag-5-bold" style="font-size:18px;"></iconify-icon>
                Monitor Pesanan
            </a>

            <div class="sa-section">Manajemen</div>
            <a href="{{ route('superadmin.users.index') }}"
               class="sa-nav-link {{ request()->routeIs('superadmin.users.*') ? 'active' : '' }}">
                <iconify-icon icon="solar:users-group-rounded-bold" style="font-size:18px;"></iconify-icon>
                Kelola Siswa
            </a>
            <a href="{{ route('superadmin.admins.index') }}"
               class="sa-nav-link {{ request()->routeIs('superadmin.admins.*') ? 'active' : '' }}">
                <iconify-icon icon="solar:shop-bold" style="font-size:18px;"></iconify-icon>
                Petugas Kantin
            </a>
            <a href="{{ route('superadmin.categories.index') }}"
               class="sa-nav-link {{ request()->routeIs('superadmin.categories.*') ? 'active' : '' }}">
                <iconify-icon icon="solar:tag-bold" style="font-size:18px;"></iconify-icon>
                Kategori Menu
            </a>

            <div class="sa-section">Keuangan</div>
            <a href="{{ route('superadmin.topup.index') }}"
               class="sa-nav-link {{ request()->routeIs('superadmin.topup.*') ? 'active' : '' }}">
                <iconify-icon icon="solar:wallet-money-bold" style="font-size:18px;"></iconify-icon>
                Top Up Saldo
            </a>
            <a href="{{ route('superadmin.reports.index') }}"
               class="sa-nav-link {{ request()->routeIs('superadmin.reports.*') ? 'active' : '' }}">
                <iconify-icon icon="solar:chart-2-bold" style="font-size:18px;"></iconify-icon>
                Laporan Transaksi
            </a>
        </nav>

        {{-- ── User Profile & Logout ── --}}
        <div style="padding:10px 10px 14px;border-top:1px solid rgba(255,255,255,.05);">
            {{-- User card --}}
            <div style="display:flex;align-items:center;gap:10px;padding:10px 14px;border-radius:12px;background:rgba(255,255,255,.04);margin-bottom:6px;">
                {{-- Avatar initials --}}
                <div style="width:34px;height:34px;border-radius:10px;background:linear-gradient(135deg,#f59e0b,#b45309);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:13px;font-weight:800;color:#fff;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div style="min-width:0;flex:1;">
                    <div style="font-size:12px;font-weight:700;color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ Auth::user()->name }}
                    </div>
                    <div style="font-size:10px;font-weight:500;color:rgba(251,191,36,.6);margin-top:1px;">Super Admin</div>
                </div>
                <iconify-icon icon="solar:shield-check-bold" style="font-size:15px;color:rgba(251,191,36,.4);flex-shrink:0;"></iconify-icon>
            </div>

            {{-- Logout --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sa-logout">
                    <iconify-icon icon="solar:logout-2-bold" style="font-size:17px;color:rgba(248,113,113,.6);"></iconify-icon>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- ── MAIN ── --}}
    <div style="flex:1;margin-left:248px;display:flex;flex-direction:column;min-height:100vh;">

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
