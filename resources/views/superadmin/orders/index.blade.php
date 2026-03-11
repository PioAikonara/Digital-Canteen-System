<x-superadmin-layout>
    <x-slot name="title">Monitor Pesanan — Super Admin</x-slot>

    <style>
        .sa-card { background:#fff;border:1.5px solid #e2e8f0;border-radius:18px;overflow:hidden; }
        .sa-table th { font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;padding:11px 14px;border-bottom:1.5px solid #f1f5f9;background:#f8fafc; }
        .sa-table td { font-size:13px;color:#334155;padding:11px 14px;border-bottom:1px solid #f1f5f9;vertical-align:middle; }
        .sa-table tr:last-child td { border-bottom:none; }
        .sa-table tr:hover td { background:#fafbff; }
        .sa-input { padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:12px;color:#334155;outline:none;background:#f8fafc;font-family:inherit;transition:border-color .15s; }
        .sa-input:focus { border-color:#7c3aed;background:#fff; }
        .tab-pill { display:inline-flex;align-items:center;gap:5px;padding:6px 14px;border-radius:20px;font-size:12px;font-weight:700;text-decoration:none;border:1.5px solid #e2e8f0;color:#64748b;background:#f8fafc;transition:all .15s;white-space:nowrap; }
        .tab-pill.active { color:#fff;border-color:transparent; }
        .tab-pill .cnt { display:inline-flex;align-items:center;justify-content:center;min-width:18px;height:18px;border-radius:9px;font-size:10px;font-weight:800;padding:0 4px; }
        .status-badge { display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:6px;font-size:10px;font-weight:700; }
    </style>

    <div style="margin-bottom:20px;">
        <h1 style="font-size:20px;font-weight:900;color:#0f172a;margin:0 0 3px;">Monitor Pesanan</h1>
        <p style="font-size:13px;color:#64748b;margin:0;">Pantau semua pesanan dari seluruh kantin</p>
    </div>

    {{-- STATUS TABS --}}
    @php
    $tabDefs = [
        ''           => ['label'=>'Semua',      'color'=>'#6d28d9','bg'=>'linear-gradient(135deg,#1e1b4b,#7c3aed)'],
        'pending'    => ['label'=>'Menunggu',   'color'=>'#d97706','bg'=>'linear-gradient(135deg,#d97706,#f59e0b)'],
        'processing' => ['label'=>'Diproses',   'color'=>'#2563eb','bg'=>'linear-gradient(135deg,#1d4ed8,#3b82f6)'],
        'ready'      => ['label'=>'Siap Ambil', 'color'=>'#7c3aed','bg'=>'linear-gradient(135deg,#6d28d9,#a78bfa)'],
        'completed'  => ['label'=>'Selesai',    'color'=>'#16a34a','bg'=>'linear-gradient(135deg,#15803d,#22c55e)'],
        'cancelled'  => ['label'=>'Dibatal',    'color'=>'#dc2626','bg'=>'linear-gradient(135deg,#b91c1c,#ef4444)'],
    ];
    @endphp
    <div style="display:flex;flex-wrap:wrap;gap:7px;margin-bottom:16px;">
        @foreach($tabDefs as $key => $def)
        @php $cnt = $counts[$key] ?? 0; @endphp
        <a href="{{ route('superadmin.orders.index', array_merge(request()->except('status'), ['status'=>$key])) }}"
           class="tab-pill {{ $currentStatus===$key ? 'active' : '' }}"
           style="{{ $currentStatus===$key ? 'background:'.$def['bg'].';' : '' }}">
            {{ $def['label'] }}
            @if($cnt > 0)
            <span class="cnt" style="{{ $currentStatus===$key ? 'background:rgba(255,255,255,.25);color:#fff;' : 'background:'.$def['color'].'22;color:'.$def['color'].';' }}">{{ $cnt }}</span>
            @endif
        </a>
        @endforeach
    </div>

    {{-- FILTER BAR --}}
    <div class="sa-card" style="padding:12px 16px;margin-bottom:16px;">
        <form method="GET" action="{{ route('superadmin.orders.index') }}" style="display:flex;flex-wrap:wrap;gap:10px;align-items:center;">
            <input type="hidden" name="status" value="{{ $currentStatus }}">
            <div style="position:relative;flex:1;min-width:200px;max-width:300px;">
                <iconify-icon icon="solar:magnifer-bold" style="position:absolute;left:10px;top:50%;transform:translateY(-50%);font-size:13px;color:#94a3b8;pointer-events:none;"></iconify-icon>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama siswa / menu…" class="sa-input" style="padding-left:30px;width:100%;box-sizing:border-box;">
            </div>
            <select name="kantin_id" class="sa-input">
                <option value="">Semua Kantin</option>
                @foreach($kantins as $k)
                <option value="{{ $k->id }}" {{ $kantinId==$k->id ? 'selected' : '' }}>{{ $k->name }}</option>
                @endforeach
            </select>
            <input type="date" name="date" value="{{ $date }}" class="sa-input">
            <button type="submit" style="display:inline-flex;align-items:center;gap:5px;padding:8px 14px;background:linear-gradient(135deg,#1e1b4b,#7c3aed);color:#fff;border:none;border-radius:10px;font-size:12px;font-weight:700;cursor:pointer;">
                <iconify-icon icon="solar:filter-bold" style="font-size:12px;"></iconify-icon> Filter
            </button>
            <a href="{{ route('superadmin.orders.index') }}" style="display:inline-flex;align-items:center;padding:8px 12px;background:#f1f5f9;color:#64748b;border-radius:10px;font-size:12px;font-weight:700;text-decoration:none;">Reset</a>
        </form>
    </div>

    {{-- TABLE --}}
    <div class="sa-card">
        <div style="padding:12px 16px;border-bottom:1.5px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
            <div style="font-size:13px;font-weight:800;color:#1e293b;">Daftar Pesanan</div>
            <span style="font-size:12px;font-weight:700;color:#64748b;">{{ $orders->total() }} pesanan</span>
        </div>
        <table class="sa-table" style="width:100%;border-collapse:collapse;">
            <thead><tr>
                <th>#</th>
                <th>Siswa</th>
                <th>Menu</th>
                <th>Kantin</th>
                <th style="text-align:right;">Total</th>
                <th>Waktu Ambil</th>
                <th>Status</th>
                <th>Waktu Pesan</th>
            </tr></thead>
            <tbody>
            @php
            $statusStyle = [
                'pending'    => ['Menunggu',   '#f59e0b','#fffbeb'],
                'processing' => ['Diproses',   '#2563eb','#eff6ff'],
                'ready'      => ['Siap Ambil', '#7c3aed','#ede9fe'],
                'completed'  => ['Selesai',    '#16a34a','#f0fdf4'],
                'cancelled'  => ['Dibatalkan', '#dc2626','#fef2f2'],
            ];
            @endphp
            @forelse($orders as $order)
            @php $ss = $statusStyle[$order->status] ?? [$order->status,'#64748b','#f1f5f9']; @endphp
            <tr>
                <td style="font-size:11px;color:#94a3b8;font-weight:700;">{{ $order->id }}</td>
                <td>
                    <div style="font-weight:700;font-size:12px;color:#1e293b;">{{ $order->user->name ?? '-' }}</div>
                    <div style="font-size:10px;color:#94a3b8;">{{ $order->user->email ?? '' }}</div>
                </td>
                <td>
                    <div style="font-size:12px;font-weight:600;">{{ $order->menu->name ?? '-' }}</div>
                    @if($order->notes)
                    <div style="font-size:10px;color:#64748b;margin-top:1px;">{{ Str::limit($order->notes, 40) }}</div>
                    @endif
                </td>
                <td style="font-size:12px;color:#64748b;">{{ $order->menu->admin->name ?? '-' }}</td>
                <td style="text-align:right;font-weight:800;color:#16a34a;font-size:12px;">Rp {{ number_format($order->total_price,0,',','.') }}</td>
                <td style="font-size:11px;color:#64748b;">{{ $order->pickup_time_label ?? '-' }}</td>
                <td>
                    <span class="status-badge" style="background:{{ $ss[2] }};color:{{ $ss[1] }};">
                        <span style="width:5px;height:5px;border-radius:50%;background:{{ $ss[1] }};display:inline-block;"></span>
                        {{ $ss[0] }}
                    </span>
                </td>
                <td style="font-size:11px;color:#94a3b8;">{{ $order->created_at->format('d M, H:i') }}</td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;color:#94a3b8;padding:36px;font-size:13px;">Tidak ada pesanan ditemukan</td></tr>
            @endforelse
            </tbody>
        </table>
        @if($orders->hasPages())
        <div style="padding:12px 16px;border-top:1.5px solid #f1f5f9;">{{ $orders->appends(request()->except('page'))->links() }}</div>
        @endif
    </div>

</x-superadmin-layout>
