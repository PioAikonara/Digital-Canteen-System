<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Antrean Pesanan</h2>
    </x-slot>

    <style>
        :root {
            --primary:       #2D336B;
            --primary-light: #3a4285;
            --secondary:     #7886C7;
            --accent:        #A9B5EB;
            --bg:            #F4F6FB;
            --border:        #E4E8F4;
            --text:          #1a1d2e;
            --muted:         #7a82a8;
        }

        .filter-select {
            padding: 8px 32px 8px 12px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text);
            background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24'%3E%3Cpath fill='%237a82a8' d='M7 10l5 5 5-5z'/%3E%3C/svg%3E") no-repeat right 10px center;
            appearance: none;
            outline: none;
            cursor: pointer;
            transition: border-color .2s, box-shadow .2s;
            font-family: 'Figtree', sans-serif;
        }
        .filter-select:focus { border-color: var(--secondary); box-shadow: 0 0 0 3px rgba(120,134,199,.15); }

        .order-card {
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 14px;
            padding: 20px;
            margin-bottom: 14px;
            transition: border-color .2s, box-shadow .2s;
        }
        .order-card:hover { border-color: var(--secondary); box-shadow: 0 4px 20px rgba(45,51,107,.07); }
        .order-card.status-pending  { border-left: 4px solid #f59e0b; }
        .order-card.status-preparing { border-left: 4px solid #3b82f6; }
        .order-card.status-ready    { border-left: 4px solid #22c55e; }

        .order-badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 4px 12px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 700;
        }
        .badge-pending   { background: #fffbeb; color: #b45309; border: 1.5px solid #fde68a; }
        .badge-preparing { background: #eff6ff; color: #1d4ed8; border: 1.5px solid #bfdbfe; }
        .badge-ready     { background: #f0fdf4; color: #15803d; border: 1.5px solid #bbf7d0; }
        .badge-pickup    { background: #f5f3ff; color: #6d28d9; border: 1.5px solid #ddd6fe; }

        .info-block {
            background: var(--bg);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 12px 16px;
            flex: 1;
        }
        .info-label {
            font-size: 10px;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .6px;
            margin-bottom: 4px;
        }
        .info-value {
            font-size: 14px;
            font-weight: 700;
            color: var(--text);
        }

        .action-primary {
            width: 100%;
            padding: 10px 14px;
            border: none;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: all .2s;
        }
        .action-delete {
            width: 100%;
            padding: 8px 14px;
            background: #fef2f2;
            color: #b91c1c;
            border: 1.5px solid #fecaca;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all .2s;
        }
        .action-delete:hover { background: #b91c1c; color: #fff; border-color: #b91c1c; }

        .stat-pill {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 6px 14px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 700;
        }
    </style>

    <div style="background: var(--bg); min-height: 100vh; padding: 28px 24px;">
        <div class="max-w-5xl mx-auto">
        <!-- Page Header -->
        <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:20px;">
            <div>
                <h1 style="font-size:20px;font-weight:800;color:var(--primary);margin:0;line-height:1.2;">Antrean Pesanan</h1>
                <p style="font-size:13px;color:var(--muted);margin:3px 0 0;">Kelola pesanan masuk secara real-time</p>
            </div>
            <a href="{{ route('admin.orders.history') }}"
               style="display:inline-flex;align-items:center;gap:7px;padding:9px 16px;background:#fff;color:var(--primary);border:1.5px solid var(--border);border-radius:10px;font-size:13px;font-weight:600;text-decoration:none;transition:all .2s;"
               onmouseover="this.style.background='var(--bg)'" onmouseout="this.style.background='#fff'">
                <iconify-icon icon="solar:history-bold" style="font-size:16px;"></iconify-icon>
                Riwayat Pesanan
            </a>
        </div>

        @if(session('success'))
        <div style="background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:12px;padding:13px 16px;display:flex;align-items:center;gap:10px;margin-bottom:16px;">
            <iconify-icon icon="solar:check-circle-bold" style="font-size:18px;color:#15803d;flex-shrink:0;"></iconify-icon>
            <span style="font-size:13px;font-weight:600;color:#15803d;">{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div style="background:#fef2f2;border:1.5px solid #fecaca;border-radius:12px;padding:13px 16px;display:flex;align-items:center;gap:10px;margin-bottom:16px;">
            <iconify-icon icon="solar:danger-circle-bold" style="font-size:18px;color:#b91c1c;flex-shrink:0;"></iconify-icon>
            <span style="font-size:13px;font-weight:600;color:#b91c1c;">{{ session('error') }}</span>
        </div>
        @endif

        <!-- Filter + Stats Bar -->
        <div style="background:#fff;border:1.5px solid var(--border);border-radius:14px;padding:16px 20px;margin-bottom:20px;">
            <form method="GET" action="{{ route('admin.orders.index') }}" id="filterForm"
                  style="display:flex;align-items:center;flex-wrap:wrap;gap:14px;">

                <!-- Waktu -->
                <div style="display:flex;flex-direction:column;gap:5px;">
                    <label style="font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.6px;">Waktu Pengambilan</label>
                    <select name="pickup_time" onchange="this.form.submit()" class="filter-select">
                        <option value="">Semua Waktu</option>
                        <option value="istirahat_1" {{ request('pickup_time') == 'istirahat_1' ? 'selected' : '' }}>Istirahat 1</option>
                        <option value="istirahat_2" {{ request('pickup_time') == 'istirahat_2' ? 'selected' : '' }}>Istirahat 2</option>
                    </select>
                </div>

                <!-- Status -->
                <div style="display:flex;flex-direction:column;gap:5px;">
                    <label style="font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.6px;">Status</label>
                    <select name="status" onchange="this.form.submit()" class="filter-select">
                        <option value="">Semua Status</option>
                        <option value="pending"   {{ request('status') == 'pending'   ? 'selected' : '' }}>Menunggu</option>
                        <option value="preparing" {{ request('status') == 'preparing' ? 'selected' : '' }}>Sedang Disiapkan</option>
                        <option value="ready"     {{ request('status') == 'ready'     ? 'selected' : '' }}>Siap Diambil</option>
                    </select>
                </div>

                @if(request('pickup_time') || request('status'))
                <div style="display:flex;flex-direction:column;gap:5px;">
                    <label style="font-size:11px;font-weight:700;color:transparent;letter-spacing:.6px;">x</label>
                    <a href="{{ route('admin.orders.index') }}"
                       style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;background:var(--bg);color:var(--muted);border:1.5px solid var(--border);border-radius:10px;font-size:13px;font-weight:600;text-decoration:none;transition:all .15s;"
                       onmouseover="this.style.background='#e4e7f3'" onmouseout="this.style.background='var(--bg)'">
                        <iconify-icon icon="solar:restart-bold" style="font-size:14px;"></iconify-icon>
                        Reset
                    </a>
                </div>
                @endif

                <!-- Stat pills pushed to right -->
                <div style="margin-left:auto;display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                    <span class="stat-pill" style="background:#fffbeb;color:#b45309;border:1.5px solid #fde68a;">
                        <iconify-icon icon="solar:clock-circle-bold" style="font-size:13px;"></iconify-icon>
                        {{ $pendingCount }} Menunggu
                    </span>
                    <span class="stat-pill" style="background:#eff6ff;color:#1d4ed8;border:1.5px solid #bfdbfe;">
                        <iconify-icon icon="solar:chef-hat-bold" style="font-size:13px;"></iconify-icon>
                        {{ $preparingCount }} Disiapkan
                    </span>
                    <span class="stat-pill" style="background:#f0fdf4;color:#15803d;border:1.5px solid #bbf7d0;">
                        <iconify-icon icon="solar:check-circle-bold" style="font-size:13px;"></iconify-icon>
                        {{ $readyCount }} Siap
                    </span>
                </div>
            </form>
        </div>

        <!-- Orders list -->
        @forelse($orders as $order)
        <div class="order-card status-{{ $order->status }}">
            <div style="display:flex;align-items:flex-start;gap:16px;flex-wrap:wrap;">

                <!-- Left: info -->
                <div style="flex:1;min-width:0;">

                    <!-- Top row: order number + badges -->
                    <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-bottom:14px;">
                        <div style="display:flex;align-items:center;gap:6px;">
                            <iconify-icon icon="solar:receipt-bold" style="font-size:16px;color:var(--secondary);"></iconify-icon>
                            <span style="font-size:17px;font-weight:800;color:var(--primary);">#{{ $order->id }}</span>
                        </div>

                        @if($order->status === 'pending')
                            <span class="order-badge badge-pending">
                                <iconify-icon icon="solar:clock-circle-bold" style="font-size:12px;"></iconify-icon>
                                {{ $order->status_label }}
                            </span>
                        @elseif($order->status === 'preparing')
                            <span class="order-badge badge-preparing">
                                <iconify-icon icon="solar:chef-hat-bold" style="font-size:12px;"></iconify-icon>
                                {{ $order->status_label }}
                            </span>
                        @elseif($order->status === 'ready')
                            <span class="order-badge badge-ready">
                                <iconify-icon icon="solar:check-circle-bold" style="font-size:12px;"></iconify-icon>
                                {{ $order->status_label }}
                            </span>
                        @endif

                        <span class="order-badge badge-pickup">
                            <iconify-icon icon="solar:bell-bold" style="font-size:12px;"></iconify-icon>
                            {{ $order->pickup_time_label }}
                        </span>

                        <span style="font-size:11px;color:var(--muted);display:flex;align-items:center;gap:4px;margin-left:auto;">
                            <iconify-icon icon="solar:clock-square-bold" style="font-size:13px;"></iconify-icon>
                            {{ $order->created_at->diffForHumans() }}
                        </span>
                    </div>

                    <!-- Info blocks row -->
                    <div style="display:flex;gap:10px;flex-wrap:wrap;">
                        <div class="info-block">
                            <div class="info-label">
                                <iconify-icon icon="solar:user-bold" style="font-size:11px;vertical-align:-1px;"></iconify-icon>
                                Customer
                            </div>
                            <div class="info-value">{{ $order->user->name }}</div>
                        </div>

                        <div class="info-block" style="flex:2;">
                            <div class="info-label">
                                <iconify-icon icon="solar:bowl-spoon-bold" style="font-size:11px;vertical-align:-1px;"></iconify-icon>
                                Menu
                            </div>
                            <div class="info-value">{{ $order->menu->name }}</div>
                            <div style="font-size:12px;color:var(--muted);margin-top:2px;">
                                {{ $order->quantity }}× @ Rp {{ number_format($order->menu->price, 0, ',', '.') }}
                            </div>
                        </div>

                        <div class="info-block">
                            <div class="info-label">
                                <iconify-icon icon="solar:wallet-money-bold" style="font-size:11px;vertical-align:-1px;"></iconify-icon>
                                Total
                            </div>
                            <div class="info-value" style="color:#15803d;font-size:16px;">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>

                    @if($order->notes)
                    <div style="margin-top:10px;background:#f5f3ff;border:1.5px solid #ddd6fe;border-radius:10px;padding:10px 14px;display:flex;align-items:flex-start;gap:8px;">
                        <iconify-icon icon="solar:chat-round-dots-bold" style="font-size:16px;color:#7c3aed;flex-shrink:0;margin-top:1px;"></iconify-icon>
                        <div>
                            <span style="font-size:11px;font-weight:700;color:#6d28d9;text-transform:uppercase;letter-spacing:.5px;">Catatan</span>
                            <p style="font-size:13px;color:var(--text);margin:2px 0 0;">{{ $order->notes }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Right: action buttons -->
                <div style="display:flex;flex-direction:column;gap:8px;min-width:160px;width:160px;">
                    @if($order->status === 'pending')
                        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                            @csrf
                            <button type="submit" name="status" value="preparing"
                                class="action-primary"
                                style="background:var(--primary);color:#fff;"
                                onmouseover="this.style.background='var(--primary-light)'" onmouseout="this.style.background='var(--primary)'">
                                <iconify-icon icon="solar:chef-hat-bold" style="font-size:16px;"></iconify-icon>
                                Mulai Siapkan
                            </button>
                        </form>
                    @elseif($order->status === 'preparing')
                        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                            @csrf
                            <button type="submit" name="status" value="ready"
                                class="action-primary"
                                style="background:#15803d;color:#fff;"
                                onmouseover="this.style.background='#166534'" onmouseout="this.style.background='#15803d'">
                                <iconify-icon icon="solar:check-circle-bold" style="font-size:16px;"></iconify-icon>
                                Siap Diambil
                            </button>
                        </form>
                    @elseif($order->status === 'ready')
                        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                            @csrf
                            <button type="submit" name="status" value="completed"
                                class="action-primary"
                                style="background:var(--secondary);color:#fff;"
                                onmouseover="this.style.background='var(--primary)'" onmouseout="this.style.background='var(--secondary)'">
                                <iconify-icon icon="solar:bag-check-bold" style="font-size:16px;"></iconify-icon>
                                Selesai
                            </button>
                        </form>
                    @else
                        <div style="background:var(--bg);border:1.5px solid var(--border);border-radius:10px;padding:10px;text-align:center;">
                            <iconify-icon icon="solar:check-circle-bold" style="font-size:20px;color:var(--muted);display:block;margin:0 auto 4px;"></iconify-icon>
                            <span style="font-size:11px;color:var(--muted);font-weight:600;">Selesai</span>
                        </div>
                    @endif

                    @if($order->status !== 'completed')
                        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST"
                              onsubmit="return confirm('Hapus pesanan #{{ $order->id }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-delete">
                                <iconify-icon icon="solar:trash-bin-trash-bold" style="font-size:14px;"></iconify-icon>
                                Hapus
                            </button>
                        </form>
                    @endif
                </div>

            </div>
        </div>
        @empty
        <div style="background:#fff;border:1.5px solid var(--border);border-radius:14px;padding:64px 20px;text-align:center;">
            <iconify-icon icon="solar:inbox-bold" style="font-size:52px;color:var(--accent);display:block;margin:0 auto 14px;"></iconify-icon>
            <p style="font-size:16px;font-weight:800;color:var(--primary);margin:0 0 6px;">Tidak ada pesanan saat ini</p>
            <p style="font-size:13px;color:var(--muted);margin:0;">Pesanan baru dari pelanggan akan muncul di sini</p>
        </div>
        @endforelse

        @if($orders->hasPages())
        <div style="margin-top:16px;display:flex;justify-content:flex-end;">
            {{ $orders->links() }}
        </div>
        @endif

        </div><!-- end max-w -->
    </div><!-- end outer -->
</x-admin-layout>
