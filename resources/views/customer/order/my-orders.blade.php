<x-customer-layout>
    <x-slot name="title">Pesanan Saya — DCS</x-slot>

    <style>
        .mo-header {
            background: linear-gradient(135deg, #2D336B 0%, #7886C7 100%);
            border-radius: 22px;
            padding: 28px 32px;
            color: #fff;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
        }
        .mo-header::before {
            content: '';
            position: absolute;
            top: -40px; right: -40px;
            width: 180px; height: 180px;
            border-radius: 50%;
            background: rgba(255,255,255,.07);
        }
        .mo-header::after {
            content: '';
            position: absolute;
            bottom: -60px; right: 60px;
            width: 140px; height: 140px;
            border-radius: 50%;
            background: rgba(255,255,255,.05);
        }
        .mo-filter-pill {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 7px 16px; border-radius: 100px;
            font-size: 12px; font-weight: 700; cursor: pointer;
            border: 1.5px solid #E4E8F4; background: #fff;
            color: #7a82a8; transition: all .15s; text-decoration: none;
        }
        .mo-filter-pill.active, .mo-filter-pill:hover {
            background: #2D336B; border-color: #2D336B; color: #fff;
        }
        .order-card {
            background: #fff;
            border: 1.5px solid #E4E8F4;
            border-radius: 20px;
            overflow: hidden;
            transition: box-shadow .2s, border-color .2s;
            margin-bottom: 14px;
        }
        .order-card:hover {
            box-shadow: 0 6px 28px rgba(45,51,107,.09);
            border-color: #A9B5EB;
        }
        .status-bar {
            height: 4px; width: 100%;
        }
        .status-step {
            display: flex; align-items: center; gap: 0;
            flex: 1;
        }
        .step-dot {
            width: 22px; height: 22px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 10px; font-weight: 800; flex-shrink: 0;
            border: 2px solid currentColor;
            transition: all .2s;
        }
        .step-line {
            flex: 1; height: 2px; background: #E4E8F4;
        }
        .step-line.done { background: #15803d; }
        .step-line.active { background: linear-gradient(90deg, #15803d, #E4E8F4); }
    </style>

    {{-- Header --}}
    <div class="mo-header">
        <div style="position:relative;z-index:1;display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:14px;">
            <div>
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;">
                    <div style="width:36px;height:36px;background:rgba(255,255,255,.18);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <iconify-icon icon="solar:bag-5-bold" style="font-size:20px;color:#fff;"></iconify-icon>
                    </div>
                    <h1 style="font-size:22px;font-weight:900;color:#fff;margin:0;letter-spacing:-.4px;">Pesanan Saya</h1>
                </div>
                <p style="font-size:13px;color:rgba(255,255,255,.75);margin:0;">
                    Pesanan aktif — menunggu, diproses, atau siap diambil
                </p>
            </div>
            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                <a href="{{ route('customer.history') }}"
                   style="display:inline-flex;align-items:center;gap:7px;padding:9px 18px;background:rgba(255,255,255,.15);border:1.5px solid rgba(255,255,255,.3);border-radius:100px;color:#fff;font-size:12px;font-weight:700;text-decoration:none;backdrop-filter:blur(4px);transition:background .15s;"
                   onmouseover="this.style.background='rgba(255,255,255,.25)'" onmouseout="this.style.background='rgba(255,255,255,.15)'">
                    <iconify-icon icon="solar:history-bold" style="font-size:14px;"></iconify-icon>
                    Riwayat
                </a>
                <a href="{{ route('customer.orders.index') }}"
                   style="display:inline-flex;align-items:center;gap:7px;padding:9px 18px;background:#fff;border:1.5px solid #fff;border-radius:100px;color:#2D336B;font-size:12px;font-weight:800;text-decoration:none;transition:opacity .15s;"
                   onmouseover="this.style.opacity='.9'" onmouseout="this.style.opacity='1'">
                    <iconify-icon icon="solar:add-circle-bold" style="font-size:14px;"></iconify-icon>
                    Pesan Menu
                </a>
            </div>
        </div>
    </div>

    {{-- Session Alert --}}
    @if(session('success'))
        <div style="margin-bottom:18px;display:flex;align-items:center;gap:12px;padding:14px 18px;background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:16px;color:#15803d;font-size:13px;font-weight:600;">
            <iconify-icon icon="solar:check-circle-bold" style="font-size:20px;flex-shrink:0;"></iconify-icon>
            {{ session('success') }}
        </div>
    @endif

    {{-- Filter Bar --}}
    <div style="background:#fff;border:1.5px solid #E4E8F4;border-radius:18px;padding:14px 18px;margin-bottom:22px;display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
        <span style="font-size:11px;font-weight:700;color:#7a82a8;text-transform:uppercase;letter-spacing:.06em;margin-right:4px;">Waktu:</span>
        <a href="{{ route('customer.myOrders') }}" class="mo-filter-pill {{ !request('pickup_time') ? 'active' : '' }}">
            <iconify-icon icon="solar:calendar-bold" style="font-size:12px;"></iconify-icon>
            Semua
        </a>
        <a href="{{ route('customer.myOrders', ['pickup_time' => 'istirahat_1']) }}" class="mo-filter-pill {{ request('pickup_time') == 'istirahat_1' ? 'active' : '' }}">
            Istirahat 1
        </a>
        <a href="{{ route('customer.myOrders', ['pickup_time' => 'istirahat_2']) }}" class="mo-filter-pill {{ request('pickup_time') == 'istirahat_2' ? 'active' : '' }}">
            Istirahat 2
        </a>
        <span style="flex:1;"></span>
        <span style="font-size:12px;font-weight:700;color:#2D336B;">
            {{ $orders->total() ?? $orders->count() }} pesanan
        </span>
    </div>

    {{-- Orders --}}
    @forelse($orders as $order)
    @php
        $isPending   = $order->status === 'pending';
        $isPreparing = $order->status === 'preparing';
        $isReady     = $order->status === 'ready';

        $statusBar   = $isPending ? '#f59e0b' : ($isPreparing ? '#3b82f6' : ($isReady ? '#10b981' : '#94a3b8'));
        $statusBg    = $isPending ? '#fffbeb' : ($isPreparing ? '#eff6ff' : ($isReady ? '#f0fdf4' : '#f8fafc'));
        $statusColor = $isPending ? '#92400e' : ($isPreparing ? '#1e40af' : ($isReady ? '#065f46' : '#475569'));
        $statusBorder= $isPending ? '#fde68a' : ($isPreparing ? '#bfdbfe' : ($isReady ? '#a7f3d0' : '#e2e8f0'));
        $statusIcon  = $isPending ? 'solar:clock-circle-bold' : ($isPreparing ? 'solar:fire-bold' : ($isReady ? 'solar:check-circle-bold' : 'solar:question-circle-bold'));

        // Steps: 1=pending, 2=preparing, 3=ready
        $step = $isPending ? 1 : ($isPreparing ? 2 : ($isReady ? 3 : 1));
    @endphp
    <div class="order-card">
        {{-- Status bar top --}}
        <div class="status-bar" style="background: {{ $statusBar }};"></div>

        <div style="padding:18px 20px 20px;">
            {{-- Header --}}
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:10px;margin-bottom:16px;flex-wrap:wrap;">
                <div style="display:flex;align-items:center;gap:10px;">
                    {{-- Menu photo --}}
                    @if($order->menu->photo)
                        <img src="{{ asset('storage/'.$order->menu->photo) }}" alt="{{ $order->menu->name }}"
                             style="width:52px;height:52px;border-radius:13px;object-fit:cover;border:1.5px solid #E4E8F4;flex-shrink:0;">
                    @else
                        <div style="width:52px;height:52px;border-radius:13px;background:#F4F6FB;border:1.5px solid #E4E8F4;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <iconify-icon icon="solar:dish-bold" style="font-size:22px;color:#A9B5EB;"></iconify-icon>
                        </div>
                    @endif
                    <div>
                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:3px;">
                            <span style="font-size:11px;font-weight:800;color:#7886C7;">Pesanan #{{ $order->id }}</span>
                            <span style="font-size:10px;color:#7a82a8;">·</span>
                            <span style="font-size:10px;color:#7a82a8;">{{ $order->created_at->diffForHumans() }}</span>
                        </div>
                        <h3 style="font-size:15px;font-weight:900;color:#1a1d2e;margin:0;line-height:1.2;">{{ $order->menu->name }}</h3>
                        <div style="display:flex;align-items:center;gap:5px;margin-top:3px;">
                            <iconify-icon icon="solar:shop-bold" style="font-size:11px;color:#A9B5EB;"></iconify-icon>
                            <span style="font-size:11px;font-weight:600;color:#7886C7;">{{ $order->menu->admin->name ?? 'Kantin' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Status badge + pickup time --}}
                <div style="display:flex;flex-direction:column;align-items:flex-end;gap:5px;">
                    <span style="display:inline-flex;align-items:center;gap:5px;padding:5px 12px;background:{{ $statusBg }};border:1.5px solid {{ $statusBorder }};border-radius:100px;font-size:11px;font-weight:800;color:{{ $statusColor }};">
                        <iconify-icon icon="{{ $statusIcon }}" style="font-size:12px;"></iconify-icon>
                        {{ $order->status_label }}
                    </span>
                    <span style="display:inline-flex;align-items:center;gap:5px;padding:4px 11px;background:#F4F6FB;border:1.5px solid #E4E8F4;border-radius:100px;font-size:10px;font-weight:700;color:#7886C7;">
                        <iconify-icon icon="solar:clock-circle-bold" style="font-size:11px;"></iconify-icon>
                        {{ $order->pickup_time_label }}
                    </span>
                </div>
            </div>

            {{-- Progress steps --}}
            <div style="background:#F4F6FB;border:1.5px solid #E4E8F4;border-radius:14px;padding:12px 16px;margin-bottom:14px;">
                <div style="display:flex;align-items:center;gap:0;">
                    {{-- Step 1: Menunggu --}}
                    <div style="display:flex;flex-direction:column;align-items:center;gap:4px;flex-shrink:0;">
                        <div style="width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;background:{{ $step >= 1 ? '#f59e0b' : '#E4E8F4' }};color:{{ $step >= 1 ? '#fff' : '#A9B5EB' }};">
                            <iconify-icon icon="{{ $step >= 1 ? 'solar:check-circle-bold' : 'solar:clock-circle-bold' }}" style="font-size:14px;"></iconify-icon>
                        </div>
                        <span style="font-size:9px;font-weight:700;color:{{ $step >= 1 ? '#92400e' : '#A9B5EB' }};white-space:nowrap;">Menunggu</span>
                    </div>
                    <div style="flex:1;height:2px;background:{{ $step >= 2 ? '#3b82f6' : '#E4E8F4' }};margin-bottom:14px;transition:background .3s;"></div>
                    {{-- Step 2: Diproses --}}
                    <div style="display:flex;flex-direction:column;align-items:center;gap:4px;flex-shrink:0;">
                        <div style="width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;background:{{ $step >= 2 ? '#3b82f6' : '#E4E8F4' }};color:{{ $step >= 2 ? '#fff' : '#A9B5EB' }};">
                            <iconify-icon icon="{{ $step >= 2 ? 'solar:fire-bold' : 'solar:fire-linear' }}" style="font-size:14px;"></iconify-icon>
                        </div>
                        <span style="font-size:9px;font-weight:700;color:{{ $step >= 2 ? '#1e40af' : '#A9B5EB' }};white-space:nowrap;">Diproses</span>
                    </div>
                    <div style="flex:1;height:2px;background:{{ $step >= 3 ? '#10b981' : '#E4E8F4' }};margin-bottom:14px;transition:background .3s;"></div>
                    {{-- Step 3: Siap --}}
                    <div style="display:flex;flex-direction:column;align-items:center;gap:4px;flex-shrink:0;">
                        <div style="width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;background:{{ $step >= 3 ? '#10b981' : '#E4E8F4' }};color:{{ $step >= 3 ? '#fff' : '#A9B5EB' }};">
                            <iconify-icon icon="{{ $step >= 3 ? 'solar:bag-check-bold' : 'solar:bag-5-linear' }}" style="font-size:14px;"></iconify-icon>
                        </div>
                        <span style="font-size:9px;font-weight:700;color:{{ $step >= 3 ? '#065f46' : '#A9B5EB' }};white-space:nowrap;">Siap Diambil</span>
                    </div>
                </div>
            </div>

            {{-- Info row --}}
            <div style="display:grid;grid-template-columns:1fr auto;gap:12px;align-items:center;">
                <div style="background:#F4F6FB;border:1.5px solid #E4E8F4;border-radius:13px;padding:10px 14px;">
                    <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#A9B5EB;margin-bottom:3px;">Rincian Pesanan</div>
                    <div style="font-size:13px;font-weight:800;color:#1a1d2e;">{{ $order->menu->name }}</div>
                    <div style="font-size:11px;color:#7a82a8;margin-top:1px;">
                        {{ $order->quantity }} × Rp {{ number_format($order->menu->price, 0, ',', '.') }}
                    </div>
                </div>
                <div style="background:linear-gradient(135deg,#2D336B,#7886C7);border-radius:13px;padding:10px 18px;text-align:center;min-width:100px;">
                    <div style="font-size:9px;font-weight:700;color:rgba(255,255,255,.65);text-transform:uppercase;letter-spacing:.06em;margin-bottom:3px;">Total</div>
                    <div style="font-size:16px;font-weight:900;color:#fff;white-space:nowrap;">
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </div>
                </div>
            </div>

            {{-- Notes --}}
            @if($order->notes)
            <div style="margin-top:12px;display:flex;align-items:flex-start;gap:9px;padding:10px 14px;background:#F4F6FB;border:1.5px solid #E4E8F4;border-radius:13px;">
                <iconify-icon icon="solar:notes-bold" style="font-size:15px;color:#7886C7;flex-shrink:0;margin-top:1px;"></iconify-icon>
                <span style="font-size:12px;color:#7a82a8;font-style:italic;">{{ $order->notes }}</span>
            </div>
            @endif
        </div>
    </div>
    @empty
    {{-- Empty State --}}
    <div style="background:#fff;border:1.5px solid #E4E8F4;border-radius:24px;padding:60px 24px;text-align:center;">
        <div style="width:72px;height:72px;border-radius:20px;background:linear-gradient(135deg,#F4F6FB,#E4E8F4);display:flex;align-items:center;justify-content:center;margin:0 auto 18px;">
            <iconify-icon icon="solar:bag-5-bold" style="font-size:34px;color:#A9B5EB;"></iconify-icon>
        </div>
        <h3 style="font-size:17px;font-weight:900;color:#2D336B;margin:0 0 7px;">Belum ada pesanan aktif</h3>
        <p style="font-size:13px;color:#7a82a8;margin:0 0 22px;max-width:300px;margin-left:auto;margin-right:auto;line-height:1.6;">
            Semua pesananmu sudah selesai, atau kamu belum memesan apapun.
        </p>
        <a href="{{ route('customer.orders.index') }}"
           style="display:inline-flex;align-items:center;gap:8px;padding:11px 24px;background:linear-gradient(135deg,#2D336B,#7886C7);color:#fff;border-radius:100px;font-size:13px;font-weight:800;text-decoration:none;transition:opacity .15s;"
           onmouseover="this.style.opacity='.88'" onmouseout="this.style.opacity='1'">
            <iconify-icon icon="solar:add-circle-bold" style="font-size:16px;"></iconify-icon>
            Pesan Sekarang
        </a>
    </div>
    @endforelse

    @if($orders->hasPages())
        <div style="margin-top:16px;">{{ $orders->links() }}</div>
    @endif

</x-customer-layout>
