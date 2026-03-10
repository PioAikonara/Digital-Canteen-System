<x-customer-layout>
    <x-slot name="title">Riwayat Pembelian — DCS</x-slot>

    <style>
        .rh-header {
            background: linear-gradient(135deg, #1a1d2e 0%, #2D336B 60%, #7886C7 100%);
            border-radius: 22px;
            padding: 28px 32px;
            color: #fff;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
        }
        .rh-header::before {
            content: '';
            position: absolute;
            top: -50px; right: -30px;
            width: 200px; height: 200px;
            border-radius: 50%;
            background: rgba(255,255,255,.05);
        }
        .rh-header::after {
            content: '';
            position: absolute;
            bottom: -70px; right: 80px;
            width: 160px; height: 160px;
            border-radius: 50%;
            background: rgba(169,181,235,.08);
        }
        .rh-pill {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 7px 16px; border-radius: 100px;
            font-size: 12px; font-weight: 700; cursor: pointer;
            border: 1.5px solid #E4E8F4; background: #fff;
            color: #7a82a8; transition: all .15s; text-decoration: none;
        }
        .rh-pill.active, .rh-pill:hover {
            background: #2D336B; border-color: #2D336B; color: #fff;
        }
        .rh-card {
            background: #fff;
            border: 1.5px solid #E4E8F4;
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 14px;
            transition: box-shadow .2s, border-color .2s;
        }
        .rh-card:hover {
            box-shadow: 0 6px 28px rgba(45,51,107,.09);
            border-color: #A9B5EB;
        }
    </style>

    {{-- Header --}}
    <div class="rh-header">
        <div style="position:relative;z-index:1;display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:14px;">
            <div>
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;">
                    <div style="width:36px;height:36px;background:rgba(255,255,255,.15);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <iconify-icon icon="solar:history-bold" style="font-size:20px;color:#fff;"></iconify-icon>
                    </div>
                    <h1 style="font-size:22px;font-weight:900;color:#fff;margin:0;letter-spacing:-.4px;">Riwayat Pembelian</h1>
                </div>
                <p style="font-size:13px;color:rgba(255,255,255,.7);margin:0;">
                    Semua pesanan yang sudah selesai dan berhasil diambil
                </p>
            </div>
            <a href="{{ route('customer.myOrders') }}"
               style="display:inline-flex;align-items:center;gap:7px;padding:9px 20px;background:#fff;border:1.5px solid #fff;border-radius:100px;color:#2D336B;font-size:12px;font-weight:800;text-decoration:none;transition:opacity .15s;align-self:flex-start;"
               onmouseover="this.style.opacity='.88'" onmouseout="this.style.opacity='1'">
                <iconify-icon icon="solar:bag-5-bold" style="font-size:14px;"></iconify-icon>
                Pesanan Aktif
            </a>
        </div>
    </div>

    {{-- Filter bar --}}
    <div style="background:#fff;border:1.5px solid #E4E8F4;border-radius:18px;padding:14px 18px;margin-bottom:22px;display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
        <span style="font-size:11px;font-weight:700;color:#7a82a8;text-transform:uppercase;letter-spacing:.06em;margin-right:4px;">Waktu:</span>
        <a href="{{ route('customer.history') }}" class="rh-pill {{ !request('pickup_time') ? 'active' : '' }}">
            <iconify-icon icon="solar:calendar-bold" style="font-size:12px;"></iconify-icon>
            Semua
        </a>
        <a href="{{ route('customer.history', ['pickup_time' => 'istirahat_1']) }}" class="rh-pill {{ request('pickup_time') == 'istirahat_1' ? 'active' : '' }}">
            Istirahat 1
        </a>
        <a href="{{ route('customer.history', ['pickup_time' => 'istirahat_2']) }}" class="rh-pill {{ request('pickup_time') == 'istirahat_2' ? 'active' : '' }}">
            Istirahat 2
        </a>
        <span style="flex:1;"></span>
        <span style="font-size:12px;font-weight:700;color:#2D336B;">
            {{ $orders->total() ?? $orders->count() }} transaksi
        </span>
    </div>

    {{-- History list --}}
    @forelse($orders as $order)
    <div class="rh-card">
        {{-- Green top stripe --}}
        <div style="height:4px;background:linear-gradient(90deg,#10b981,#34d399);"></div>

        <div style="padding:18px 20px 20px;">
            {{-- Header row --}}
            <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;margin-bottom:16px;">
                <div style="display:flex;align-items:center;gap:8px;">
                    <span style="font-size:11px;font-weight:800;color:#7886C7;">Pesanan #{{ $order->id }}</span>
                    <span style="font-size:10px;color:#A9B5EB;">·</span>
                    <span style="display:inline-flex;align-items:center;gap:4px;padding:3px 10px;background:#f0fdf4;border:1.5px solid #a7f3d0;border-radius:100px;font-size:10px;font-weight:800;color:#065f46;">
                        <iconify-icon icon="solar:check-circle-bold" style="font-size:11px;"></iconify-icon>
                        Selesai
                    </span>
                    <span style="display:inline-flex;align-items:center;gap:4px;padding:3px 10px;background:#F4F6FB;border:1.5px solid #E4E8F4;border-radius:100px;font-size:10px;font-weight:700;color:#7886C7;">
                        <iconify-icon icon="solar:clock-circle-bold" style="font-size:10px;"></iconify-icon>
                        {{ $order->pickup_time_label }}
                    </span>
                </div>
                <span style="font-size:11px;color:#A9B5EB;font-weight:600;">
                    {{ $order->created_at->format('d M Y, H:i') }}
                </span>
            </div>

            {{-- Content --}}
            <div style="display:grid;grid-template-columns:1fr auto;gap:14px;align-items:stretch;">
                {{-- Left: menu info --}}
                <div style="display:flex;align-items:center;gap:14px;background:#F4F6FB;border:1.5px solid #E4E8F4;border-radius:14px;padding:14px 16px;">
                    @if($order->menu->photo)
                        <img src="{{ asset('storage/'.$order->menu->photo) }}" alt="{{ $order->menu->name }}"
                             style="width:56px;height:56px;border-radius:13px;object-fit:cover;flex-shrink:0;border:1.5px solid #E4E8F4;">
                    @else
                        <div style="width:56px;height:56px;border-radius:13px;background:#fff;border:1.5px solid #E4E8F4;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <iconify-icon icon="solar:dish-bold" style="font-size:24px;color:#A9B5EB;"></iconify-icon>
                        </div>
                    @endif
                    <div style="min-width:0;">
                        <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#A9B5EB;margin-bottom:3px;">Menu</div>
                        <div style="font-size:15px;font-weight:900;color:#1a1d2e;line-height:1.2;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $order->menu->name }}</div>
                        <div style="display:flex;align-items:center;gap:5px;margin-top:4px;">
                            <iconify-icon icon="solar:shop-bold" style="font-size:11px;color:#7886C7;"></iconify-icon>
                            <span style="font-size:11px;font-weight:600;color:#7886C7;">{{ $order->menu->admin->name ?? 'Kantin' }}</span>
                        </div>
                        <div style="margin-top:5px;display:flex;align-items:center;gap:8px;">
                            <span style="font-size:11px;color:#7a82a8;">Rp {{ number_format($order->menu->price, 0, ',', '.') }} × {{ $order->quantity }} porsi</span>
                        </div>
                    </div>
                </div>

                {{-- Right: total --}}
                <div style="background:linear-gradient(135deg,#ecfdf5,#d1fae5);border:1.5px solid #a7f3d0;border-radius:14px;padding:14px 20px;display:flex;flex-direction:column;justify-content:center;align-items:center;min-width:110px;text-align:center;">
                    <div style="font-size:9px;font-weight:800;text-transform:uppercase;letter-spacing:.07em;color:#059669;margin-bottom:5px;">Total Dibayar</div>
                    <div style="font-size:18px;font-weight:900;color:#065f46;white-space:nowrap;">
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </div>
                    <div style="font-size:9px;color:#6ee7b7;font-weight:600;margin-top:3px;">{{ $order->quantity }} × Rp {{ number_format($order->menu->price, 0, ',', '.') }}</div>
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
    <div style="background:#fff;border:1.5px solid #E4E8F4;border-radius:24px;padding:60px 24px;text-align:center;">
        <div style="width:72px;height:72px;border-radius:20px;background:linear-gradient(135deg,#F4F6FB,#E4E8F4);display:flex;align-items:center;justify-content:center;margin:0 auto 18px;">
            <iconify-icon icon="solar:history-bold" style="font-size:34px;color:#A9B5EB;"></iconify-icon>
        </div>
        <h3 style="font-size:17px;font-weight:900;color:#2D336B;margin:0 0 7px;">Belum ada riwayat pembelian</h3>
        <p style="font-size:13px;color:#7a82a8;margin:0 0 22px;max-width:300px;margin-left:auto;margin-right:auto;line-height:1.6;">
            Riwayat akan muncul setelah pesananmu selesai dan berhasil diambil.
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
