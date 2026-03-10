<x-superadmin-layout>
    <x-slot name="title">Dashboard — Super Admin</x-slot>

    <style>
        .sa-stat { background:#fff;border:1.5px solid #e2e8f0;border-radius:18px;padding:20px 22px;display:flex;align-items:flex-start;gap:14px; }
        .sa-stat-icon { width:44px;height:44px;border-radius:13px;display:flex;align-items:center;justify-content:center;flex-shrink:0; }
        .sa-card { background:#fff;border:1.5px solid #e2e8f0;border-radius:18px;overflow:hidden; }
        .sa-table th { font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;padding:10px 14px;border-bottom:1.5px solid #f1f5f9;background:#f8fafc; }
        .sa-table td { font-size:12px;color:#334155;padding:10px 14px;border-bottom:1px solid #f1f5f9;vertical-align:middle; }
        .sa-table tr:last-child td { border-bottom:none; }
        .status-badge { display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:100px;font-size:10px;font-weight:700; }
    </style>

    {{-- Header --}}
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
        <div>
            <h1 style="font-size:22px;font-weight:900;color:#0f172a;margin:0 0 4px;">Dashboard Super Admin</h1>
            <p style="font-size:13px;color:#64748b;margin:0;">Pantau seluruh aktivitas sistem kantin — {{ now()->format('l, d M Y') }}</p>
        </div>
        <a href="{{ route('superadmin.orders.index') }}"
           style="display:inline-flex;align-items:center;gap:7px;padding:10px 20px;background:linear-gradient(135deg,#f59e0b,#d97706);color:#fff;border-radius:12px;font-size:12px;font-weight:800;text-decoration:none;">
            <iconify-icon icon="solar:bag-5-bold" style="font-size:14px;"></iconify-icon>
            Monitor Pesanan
        </a>
    </div>

    {{-- Stats Grid --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(210px,1fr));gap:14px;margin-bottom:24px;">
        <div class="sa-stat">
            <div class="sa-stat-icon" style="background:#fef3c7;">
                <iconify-icon icon="solar:users-group-rounded-bold" style="font-size:22px;color:#d97706;"></iconify-icon>
            </div>
            <div>
                <div style="font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin-bottom:3px;">Total Siswa</div>
                <div style="font-size:24px;font-weight:900;color:#0f172a;line-height:1;">{{ number_format($totalUsers) }}</div>
                <div style="font-size:11px;color:#94a3b8;margin-top:2px;">pengguna terdaftar</div>
            </div>
        </div>
        <div class="sa-stat">
            <div class="sa-stat-icon" style="background:#ede9fe;">
                <iconify-icon icon="solar:shop-bold" style="font-size:22px;color:#7c3aed;"></iconify-icon>
            </div>
            <div>
                <div style="font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin-bottom:3px;">Petugas Kantin</div>
                <div style="font-size:24px;font-weight:900;color:#0f172a;line-height:1;">{{ number_format($totalAdmins) }}</div>
                <div style="font-size:11px;color:#94a3b8;margin-top:2px;">kantin aktif</div>
            </div>
        </div>
        <div class="sa-stat">
            <div class="sa-stat-icon" style="background:#dbeafe;">
                <iconify-icon icon="solar:bag-5-bold" style="font-size:22px;color:#2563eb;"></iconify-icon>
            </div>
            <div>
                <div style="font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin-bottom:3px;">Total Pesanan</div>
                <div style="font-size:24px;font-weight:900;color:#0f172a;line-height:1;">{{ number_format($totalOrders) }}</div>
                <div style="font-size:11px;color:#f59e0b;margin-top:2px;font-weight:600;">{{ $pendingOrders }} menunggu</div>
            </div>
        </div>
        <div class="sa-stat">
            <div class="sa-stat-icon" style="background:#dcfce7;">
                <iconify-icon icon="solar:wallet-money-bold" style="font-size:22px;color:#16a34a;"></iconify-icon>
            </div>
            <div>
                <div style="font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin-bottom:3px;">Total Pendapatan</div>
                <div style="font-size:18px;font-weight:900;color:#0f172a;line-height:1;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                <div style="font-size:11px;color:#94a3b8;margin-top:2px;">Hari ini: Rp {{ number_format($todayRevenue, 0, ',', '.') }}</div>
            </div>
        </div>
        <div class="sa-stat">
            <div class="sa-stat-icon" style="background:#fce7f3;">
                <iconify-icon icon="solar:dish-bold" style="font-size:22px;color:#db2777;"></iconify-icon>
            </div>
            <div>
                <div style="font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin-bottom:3px;">Total Menu</div>
                <div style="font-size:24px;font-weight:900;color:#0f172a;line-height:1;">{{ number_format($totalMenus) }}</div>
                <div style="font-size:11px;color:#94a3b8;margin-top:2px;">dari semua kantin</div>
            </div>
        </div>
        <div class="sa-stat">
            <div class="sa-stat-icon" style="background:#e0f2fe;">
                <iconify-icon icon="solar:chart-2-bold" style="font-size:22px;color:#0284c7;"></iconify-icon>
            </div>
            <div>
                <div style="font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin-bottom:3px;">Pesanan Hari Ini</div>
                <div style="font-size:24px;font-weight:900;color:#0f172a;line-height:1;">{{ number_format($todayOrders) }}</div>
                <div style="font-size:11px;color:#94a3b8;margin-top:2px;">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    {{-- Two columns: Top Kantins + Recent Top-Ups --}}
    <div style="display:grid;grid-template-columns:1fr 360px;gap:18px;margin-bottom:18px;">

        {{-- Top Kantins --}}
        <div class="sa-card">
            <div style="padding:16px 18px;border-bottom:1.5px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
                <div style="font-size:14px;font-weight:800;color:#0f172a;">Performa Kantin</div>
                <a href="{{ route('superadmin.admins.index') }}" style="font-size:11px;font-weight:700;color:#7c3aed;text-decoration:none;">Lihat Semua</a>
            </div>
            <table class="sa-table" style="width:100%;border-collapse:collapse;">
                <thead><tr>
                    <th style="text-align:left;">Kantin</th>
                    <th style="text-align:right;">Pesanan</th>
                    <th style="text-align:right;">Pendapatan</th>
                </tr></thead>
                <tbody>
                @forelse($topKantins as $kantin)
                <tr>
                    <td>
                        <div style="font-weight:700;color:#1e293b;">{{ $kantin->name }}</div>
                        <div style="font-size:10px;color:#94a3b8;">{{ $kantin->menu_count }} menu</div>
                    </td>
                    <td style="text-align:right;font-weight:700;color:#0f172a;">{{ number_format($kantin->total_orders) }}</td>
                    <td style="text-align:right;font-weight:800;color:#16a34a;">Rp {{ number_format($kantin->total_revenue, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align:center;color:#94a3b8;padding:24px;">Belum ada data</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- Recent Top-Ups --}}
        <div class="sa-card">
            <div style="padding:16px 18px;border-bottom:1.5px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
                <div style="font-size:14px;font-weight:800;color:#0f172a;">Top Up Terbaru</div>
                <a href="{{ route('superadmin.topup.index') }}" style="font-size:11px;font-weight:700;color:#d97706;text-decoration:none;">Lihat Semua</a>
            </div>
            <div style="padding:8px 14px;">
                @forelse($recentTopUps as $tu)
                <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 4px;border-bottom:1px solid #f1f5f9;">
                    <div>
                        <div style="font-size:12px;font-weight:700;color:#1e293b;">{{ $tu->user->name ?? '-' }}</div>
                        <div style="font-size:10px;color:#94a3b8;">{{ $tu->created_at->diffForHumans() }}</div>
                    </div>
                    <span style="font-size:13px;font-weight:900;color:#16a34a;">+Rp {{ number_format($tu->amount, 0, ',', '.') }}</span>
                </div>
                @empty
                <div style="text-align:center;color:#94a3b8;padding:24px;font-size:12px;">Belum ada top up</div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Recent Orders --}}
    <div class="sa-card">
        <div style="padding:16px 18px;border-bottom:1.5px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
            <div style="font-size:14px;font-weight:800;color:#0f172a;">Pesanan Terbaru</div>
            <a href="{{ route('superadmin.orders.index') }}" style="font-size:11px;font-weight:700;color:#2563eb;text-decoration:none;">Lihat Semua</a>
        </div>
        <table class="sa-table" style="width:100%;border-collapse:collapse;">
            <thead><tr>
                <th style="text-align:left;">#</th>
                <th style="text-align:left;">Siswa</th>
                <th style="text-align:left;">Menu</th>
                <th style="text-align:left;">Kantin</th>
                <th style="text-align:left;">Status</th>
                <th style="text-align:right;">Total</th>
                <th style="text-align:right;">Waktu</th>
            </tr></thead>
            <tbody>
            @forelse($recentOrders as $order)
            @php
                $sbg = match($order->status) {
                    'pending'   => 'background:#fef3c7;color:#92400e;',
                    'preparing' => 'background:#dbeafe;color:#1e40af;',
                    'ready'     => 'background:#ecfdf5;color:#065f46;',
                    'completed' => 'background:#f0fdf4;color:#166534;',
                    default     => 'background:#f1f5f9;color:#475569;',
                };
            @endphp
            <tr>
                <td style="font-weight:800;color:#7c3aed;">#{{ $order->id }}</td>
                <td>{{ $order->user->name ?? '-' }}</td>
                <td>{{ $order->menu->name ?? '-' }}</td>
                <td style="color:#7c3aed;font-weight:600;">{{ $order->menu->admin->name ?? '-' }}</td>
                <td><span class="status-badge" style="{{ $sbg }}">{{ $order->status_label }}</span></td>
                <td style="text-align:right;font-weight:800;color:#0f172a;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                <td style="text-align:right;font-size:10px;color:#94a3b8;">{{ $order->created_at->diffForHumans() }}</td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;color:#94a3b8;padding:24px;">Belum ada pesanan</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

</x-superadmin-layout>
