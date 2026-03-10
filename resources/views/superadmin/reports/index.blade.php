<x-superadmin-layout>
    <x-slot name="title">Laporan Transaksi — Super Admin</x-slot>

    <style>
        .sa-card { background:#fff;border:1.5px solid #e2e8f0;border-radius:18px;overflow:hidden; }
        .sa-stat { background:#fff;border:1.5px solid #e2e8f0;border-radius:16px;padding:18px 22px; }
        .sa-table th { font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;padding:11px 14px;border-bottom:1.5px solid #f1f5f9;background:#f8fafc; }
        .sa-table td { font-size:13px;color:#334155;padding:11px 14px;border-bottom:1px solid #f1f5f9;vertical-align:middle; }
        .sa-table tr:last-child td { border-bottom:none; }
        .sa-table tr:hover td { background:#fafbff; }
        .sa-input { padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:12px;color:#334155;outline:none;background:#f8fafc;font-family:inherit;transition:border-color .15s; }
        .sa-input:focus { border-color:#7c3aed;background:#fff; }
        .period-btn { padding:7px 14px;border-radius:9px;font-size:12px;font-weight:700;border:1.5px solid #e2e8f0;cursor:pointer;text-decoration:none;color:#64748b;background:#f8fafc;transition:all .15s; }
        .period-btn.active { background:linear-gradient(135deg,#1e1b4b,#7c3aed);color:#fff;border-color:transparent; }
        .status-badge { display:inline-flex;align-items:center;gap:4px;padding:3px 8px;border-radius:6px;font-size:10px;font-weight:700; }
    </style>

    <div style="margin-bottom:22px;">
        <h1 style="font-size:20px;font-weight:900;color:#0f172a;margin:0 0 3px;">Laporan Transaksi</h1>
        <p style="font-size:13px;color:#64748b;margin:0;">Rekap transaksi harian, mingguan, dan bulanan</p>
    </div>

    {{-- FILTER --}}
    <div class="sa-card" style="padding:16px 20px;margin-bottom:20px;">
        <form method="GET" action="{{ route('superadmin.reports.index') }}" style="display:flex;flex-wrap:wrap;gap:12px;align-items:flex-end;">
            <div>
                <div style="font-size:11px;font-weight:700;color:#64748b;margin-bottom:5px;">Periode</div>
                <div style="display:flex;gap:6px;">
                    @foreach(['daily'=>'Harian','weekly'=>'Mingguan','monthly'=>'Bulanan'] as $key=>$label)
                    <a href="{{ route('superadmin.reports.index', array_merge(request()->except('period'), ['period'=>$key])) }}"
                       class="period-btn {{ $period===$key ? 'active' : '' }}">{{ $label }}</a>
                    @endforeach
                </div>
            </div>
            <div>
                <div style="font-size:11px;font-weight:700;color:#64748b;margin-bottom:5px;">Dari Tanggal</div>
                <input type="date" name="date_from" value="{{ $dateFrom }}" class="sa-input">
            </div>
            <div>
                <div style="font-size:11px;font-weight:700;color:#64748b;margin-bottom:5px;">Sampai Tanggal</div>
                <input type="date" name="date_to" value="{{ $dateTo }}" class="sa-input">
            </div>
            <div>
                <div style="font-size:11px;font-weight:700;color:#64748b;margin-bottom:5px;">Kantin</div>
                <select name="kantin_id" class="sa-input">
                    <option value="">Semua Kantin</option>
                    @foreach($kantins as $k)
                    <option value="{{ $k->id }}" {{ $kantinId==$k->id ? 'selected' : '' }}>{{ $k->name }}</option>
                    @endforeach
                </select>
            </div>
            <input type="hidden" name="period" value="{{ $period }}">
            <button type="submit" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:linear-gradient(135deg,#1e1b4b,#7c3aed);color:#fff;border-radius:10px;font-size:12px;font-weight:700;border:none;cursor:pointer;">
                <iconify-icon icon="solar:filter-bold" style="font-size:13px;"></iconify-icon> Terapkan
            </button>
        </form>
    </div>

    {{-- SUMMARY STATS --}}
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px;">
        @php
            $stats = [
                ['icon'=>'solar:bill-list-bold','label'=>'Total Transaksi','value'=> number_format($totalOrders),'color'=>'#6d28d9','bgIcon'=>'#ede9fe'],
                ['icon'=>'solar:check-circle-bold','label'=>'Selesai','value'=> number_format($completedOrders),'color'=>'#16a34a','bgIcon'=>'#f0fdf4'],
                ['icon'=>'solar:wallet-money-bold','label'=>'Total Pendapatan','value'=>'Rp '.number_format($totalRevenue,0,',','.'),'color'=>'#d97706','bgIcon'=>'#fffbeb'],
                ['icon'=>'solar:chart-bold','label'=>'Rata-rata/Hari','value'=>'Rp '.number_format($avgPerDay,0,',','.'),'color'=>'#2563eb','bgIcon'=>'#eff6ff'],
            ];
        @endphp
        @foreach($stats as $st)
        <div class="sa-stat">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
                <div style="width:32px;height:32px;border-radius:9px;background:{{ $st['bgIcon'] }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <iconify-icon icon="{{ $st['icon'] }}" style="font-size:16px;color:{{ $st['color'] }};"></iconify-icon>
                </div>
                <span style="font-size:11px;font-weight:600;color:#64748b;">{{ $st['label'] }}</span>
            </div>
            <div style="font-size:20px;font-weight:900;color:#1e293b;">{{ $st['value'] }}</div>
        </div>
        @endforeach
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">
        {{-- PER KANTIN --}}
        <div class="sa-card">
            <div style="padding:12px 16px;border-bottom:1.5px solid #f1f5f9;font-size:13px;font-weight:800;color:#1e293b;">Per Kantin</div>
            <table class="sa-table" style="width:100%;border-collapse:collapse;">
                <thead><tr>
                    <th>Kantin</th>
                    <th style="text-align:right;">Pesanan</th>
                    <th style="text-align:right;">Pendapatan</th>
                </tr></thead>
                <tbody>
                @forelse($byKantin as $item)
                <tr>
                    <td style="font-weight:600;">{{ $item['name'] }}</td>
                    <td style="text-align:right;font-weight:700;">{{ number_format($item['orders']) }}</td>
                    <td style="text-align:right;font-weight:800;color:#16a34a;">Rp {{ number_format($item['revenue'],0,',','.') }}</td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align:center;color:#94a3b8;padding:24px;font-size:13px;">Tidak ada data</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- STATUS BREAKDOWN --}}
        <div class="sa-card">
            <div style="padding:12px 16px;border-bottom:1.5px solid #f1f5f9;font-size:13px;font-weight:800;color:#1e293b;">Status Pesanan</div>
            <div style="padding:14px 16px;display:grid;gap:10px;">
                @php
                $statusMap = [
                    'pending'    => ['Menunggu','#f59e0b','#fffbeb'],
                    'processing' => ['Diproses','#2563eb','#eff6ff'],
                    'ready'      => ['Siap','#7c3aed','#ede9fe'],
                    'completed'  => ['Selesai','#16a34a','#f0fdf4'],
                    'cancelled'  => ['Dibatalkan','#dc2626','#fef2f2'],
                ];
                @endphp
                @foreach($statusBreakdown as $st => $cnt)
                @php $info = $statusMap[$st] ?? [$st,'#64748b','#f1f5f9']; @endphp
                <div style="display:flex;align-items:center;justify-content:space-between;padding:8px 12px;background:{{ $info[2] }};border-radius:10px;">
                    <span class="status-badge" style="color:{{ $info[1] }};">
                        <span style="width:6px;height:6px;border-radius:50%;background:{{ $info[1] }};display:inline-block;"></span>
                        {{ $info[0] }}
                    </span>
                    <span style="font-size:15px;font-weight:900;color:{{ $info[1] }};">{{ number_format($cnt) }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ORDERS TABLE --}}
    <div class="sa-card">
        <div style="padding:12px 16px;border-bottom:1.5px solid #f1f5f9;font-size:13px;font-weight:800;color:#1e293b;">
            Daftar Transaksi ({{ $orders->total() }})
        </div>
        <table class="sa-table" style="width:100%;border-collapse:collapse;">
            <thead><tr>
                <th>#</th>
                <th>Siswa</th>
                <th>Menu</th>
                <th>Kantin</th>
                <th style="text-align:right;">Total</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr></thead>
            <tbody>
            @forelse($orders as $order)
            @php
                $st = $statusMap[$order->status] ?? [$order->status,'#64748b','#f1f5f9'];
            @endphp
            <tr>
                <td style="font-size:11px;color:#94a3b8;">{{ $order->id }}</td>
                <td>
                    <div style="font-weight:700;font-size:12px;">{{ $order->user->name ?? '-' }}</div>
                </td>
                <td style="font-size:12px;">{{ $order->menu->name ?? '-' }}</td>
                <td style="font-size:12px;color:#64748b;">{{ $order->menu->admin->name ?? '-' }}</td>
                <td style="text-align:right;font-weight:800;color:#16a34a;font-size:12px;">Rp {{ number_format($order->total_price,0,',','.') }}</td>
                <td>
                    <span class="status-badge" style="background:{{ $st[2] }};color:{{ $st[1] }};">
                        <span style="width:5px;height:5px;border-radius:50%;background:{{ $st[1] }};display:inline-block;"></span>
                        {{ $st[0] }}
                    </span>
                </td>
                <td style="font-size:11px;color:#94a3b8;">{{ $order->created_at->format('d M Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;color:#94a3b8;padding:32px;font-size:13px;">Tidak ada transaksi pada periode ini</td></tr>
            @endforelse
            </tbody>
        </table>
        @if($orders->hasPages())
        <div style="padding:12px 16px;border-top:1.5px solid #f1f5f9;">{{ $orders->appends(request()->except('page'))->links() }}</div>
        @endif
    </div>

</x-superadmin-layout>
