<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Riwayat Pesanan</h2>
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
        .date-input {
            padding: 8px 12px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text);
            background: #fff;
            outline: none;
            cursor: pointer;
            transition: border-color .2s, box-shadow .2s;
            font-family: 'Figtree', sans-serif;
        }
        .date-input:focus { border-color: var(--secondary); box-shadow: 0 0 0 3px rgba(120,134,199,.15); }

        .order-card {
            background: #fff;
            border: 1.5px solid var(--border);
            border-left: 4px solid #22c55e;
            border-radius: 14px;
            padding: 20px;
            margin-bottom: 14px;
            transition: border-color .2s, box-shadow .2s;
        }
        .order-card:hover { box-shadow: 0 4px 20px rgba(45,51,107,.07); border-color: var(--secondary); border-left-color: #22c55e; }

        .order-badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 4px 12px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 700;
        }
        .badge-done   { background: #f0fdf4; color: #15803d; border: 1.5px solid #bbf7d0; }
        .badge-pickup { background: #f5f3ff; color: #6d28d9; border: 1.5px solid #ddd6fe; }

        .info-block {
            background: var(--bg);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 12px 16px;
            flex: 1;
        }
        .info-label {
            font-size: 10px; font-weight: 700;
            color: var(--muted); text-transform: uppercase; letter-spacing: .6px; margin-bottom: 4px;
        }
        .info-value { font-size: 14px; font-weight: 700; color: var(--text); }

        .action-delete {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 14px;
            background: #fef2f2; color: #b91c1c;
            border: 1.5px solid #fecaca;
            border-radius: 10px;
            font-size: 12px; font-weight: 600;
            cursor: pointer; transition: all .2s;
            white-space: nowrap;
        }
        .action-delete:hover { background: #b91c1c; color: #fff; border-color: #b91c1c; }
    </style>

    <div style="background: var(--bg); min-height: 100vh; padding: 28px 24px;">
        <div style="max-width: 960px; margin: 0 auto;">

            <!-- Page Header -->
            <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:20px;">
                <div>
                    <h1 style="font-size:20px;font-weight:800;color:var(--primary);margin:0;line-height:1.2;">Riwayat Pesanan</h1>
                    <p style="font-size:13px;color:var(--muted);margin:3px 0 0;">Semua pesanan yang telah selesai</p>
                </div>
                <a href="{{ route('admin.orders.index') }}"
                   style="display:inline-flex;align-items:center;gap:7px;padding:9px 16px;background:#fff;color:var(--primary);border:1.5px solid var(--border);border-radius:10px;font-size:13px;font-weight:600;text-decoration:none;transition:all .2s;"
                   onmouseover="this.style.background='var(--bg)'" onmouseout="this.style.background='#fff'">
                    <iconify-icon icon="solar:cart-large-bold" style="font-size:16px;"></iconify-icon>
                    Antrean Aktif
                </a>
            </div>

            @if(session('success'))
            <div style="background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:12px;padding:13px 16px;display:flex;align-items:center;gap:10px;margin-bottom:16px;">
                <iconify-icon icon="solar:check-circle-bold" style="font-size:18px;color:#15803d;flex-shrink:0;"></iconify-icon>
                <span style="font-size:13px;font-weight:600;color:#15803d;">{{ session('success') }}</span>
            </div>
            @endif

            <!-- Filter + Stats Bar -->
            <div style="background:#fff;border:1.5px solid var(--border);border-radius:14px;padding:16px 20px;margin-bottom:20px;">
                <form method="GET" action="{{ route('admin.orders.history') }}"
                      style="display:flex;align-items:center;flex-wrap:wrap;gap:14px;">

                    <!-- Tanggal -->
                    <div style="display:flex;flex-direction:column;gap:5px;">
                        <label style="font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.6px;">Tanggal</label>
                        <input type="date" name="date" value="{{ request('date') }}"
                               onchange="this.form.submit()"
                               class="date-input">
                    </div>

                    <!-- Waktu Pengambilan -->
                    <div style="display:flex;flex-direction:column;gap:5px;">
                        <label style="font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.6px;">Waktu Pengambilan</label>
                        <select name="pickup_time" onchange="this.form.submit()" class="filter-select">
                            <option value="">Semua Waktu</option>
                            <option value="istirahat_1" {{ request('pickup_time') == 'istirahat_1' ? 'selected' : '' }}>Istirahat 1</option>
                            <option value="istirahat_2" {{ request('pickup_time') == 'istirahat_2' ? 'selected' : '' }}>Istirahat 2</option>
                        </select>
                    </div>

                    @if(request('date') || request('pickup_time'))
                    <div style="display:flex;flex-direction:column;gap:5px;">
                        <label style="font-size:11px;font-weight:700;color:transparent;letter-spacing:.6px;">x</label>
                        <a href="{{ route('admin.orders.history') }}"
                           style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;background:var(--bg);color:var(--muted);border:1.5px solid var(--border);border-radius:10px;font-size:13px;font-weight:600;text-decoration:none;transition:all .15s;"
                           onmouseover="this.style.background='#e4e7f3'" onmouseout="this.style.background='var(--bg)'">
                            <iconify-icon icon="solar:restart-bold" style="font-size:14px;"></iconify-icon>
                            Reset
                        </a>
                    </div>
                    @endif

                    <!-- Stats pushed right -->
                    <div style="margin-left:auto;display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                        @if(request('date') || request('pickup_time'))
                        <div style="background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:10px;padding:7px 14px;display:flex;align-items:center;gap:7px;">
                            <iconify-icon icon="solar:wallet-money-bold" style="font-size:15px;color:#15803d;"></iconify-icon>
                            <div>
                                <div style="font-size:10px;font-weight:700;color:#15803d;text-transform:uppercase;letter-spacing:.5px;">Pendapatan Filter</div>
                                <div style="font-size:14px;font-weight:800;color:#15803d;">Rp {{ number_format($orders->sum('total_price'), 0, ',', '.') }}</div>
                            </div>
                        </div>
                        @endif
                        <div style="background:var(--bg);border:1.5px solid var(--border);border-radius:10px;padding:7px 14px;display:flex;align-items:center;gap:7px;">
                            <iconify-icon icon="solar:check-circle-bold" style="font-size:15px;color:var(--secondary);"></iconify-icon>
                            <div>
                                <div style="font-size:10px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.5px;">Selesai</div>
                                <div style="font-size:14px;font-weight:800;color:var(--primary);">{{ $orders->total() }} Pesanan</div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Orders list -->
            @forelse($orders as $order)
            <div class="order-card">
                <div style="display:flex;align-items:flex-start;gap:16px;flex-wrap:wrap;">

                    <!-- Left: info -->
                    <div style="flex:1;min-width:0;">

                        <!-- Top row -->
                        <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-bottom:14px;">
                            <div style="display:flex;align-items:center;gap:6px;">
                                <iconify-icon icon="solar:receipt-bold" style="font-size:16px;color:var(--secondary);"></iconify-icon>
                                <span style="font-size:17px;font-weight:800;color:var(--primary);">#{{ $order->id }}</span>
                            </div>
                            <span class="order-badge badge-done">
                                <iconify-icon icon="solar:check-circle-bold" style="font-size:12px;"></iconify-icon>
                                Selesai
                            </span>
                            <span class="order-badge badge-pickup">
                                <iconify-icon icon="solar:bell-bold" style="font-size:12px;"></iconify-icon>
                                {{ $order->pickup_time_label }}
                            </span>
                        </div>

                        <!-- Info blocks -->
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

                        <!-- Timestamps -->
                        <div style="display:flex;align-items:center;gap:16px;margin-top:12px;flex-wrap:wrap;">
                            <span style="font-size:11px;color:var(--muted);display:flex;align-items:center;gap:5px;">
                                <iconify-icon icon="solar:clock-square-bold" style="font-size:13px;"></iconify-icon>
                                Dipesan: {{ $order->created_at->format('d M Y, H:i') }}
                            </span>
                            <span style="font-size:11px;color:#15803d;display:flex;align-items:center;gap:5px;font-weight:600;">
                                <iconify-icon icon="solar:check-circle-bold" style="font-size:13px;"></iconify-icon>
                                Selesai: {{ $order->updated_at->format('d M Y, H:i') }}
                            </span>
                        </div>
                    </div>

                    <!-- Right: delete -->
                    <div style="flex-shrink:0;">
                        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST"
                              onsubmit="return confirm('Hapus riwayat pesanan #{{ $order->id }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-delete">
                                <iconify-icon icon="solar:trash-bin-trash-bold" style="font-size:14px;"></iconify-icon>
                                Hapus
                            </button>
                        </form>
                    </div>

                </div>
            </div>
            @empty
            <div style="background:#fff;border:1.5px solid var(--border);border-radius:14px;padding:64px 20px;text-align:center;">
                <iconify-icon icon="solar:history-bold" style="font-size:52px;color:var(--accent);display:block;margin:0 auto 14px;"></iconify-icon>
                <p style="font-size:16px;font-weight:800;color:var(--primary);margin:0 0 6px;">Belum ada riwayat pesanan</p>
                <p style="font-size:13px;color:var(--muted);margin:0;">Pesanan yang telah selesai akan muncul di sini</p>
            </div>
            @endforelse

            @if($orders->hasPages())
            <div style="margin-top:16px;display:flex;justify-content:flex-end;">
                {{ $orders->links() }}
            </div>
            @endif

        </div>
    </div>
</x-admin-layout>
