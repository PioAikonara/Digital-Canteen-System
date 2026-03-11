<x-customer-layout>
    <x-slot name="title">Dashboard — DCS</x-slot>

    {{-- Page Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-semibold tracking-tight text-[#2D336B]">
            Selamat datang, {{ explode(' ', Auth::user()->name)[0] }} 👋
        </h1>
        <p class="text-slate-500 text-sm mt-1">
            Hari ini kantin menyediakan {{ $menus->count() }} menu pilihan untukmu.
        </p>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="bg-white p-4 rounded-2xl border border-slate-100 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-[#2D336B]">
                <iconify-icon icon="solar:wallet-money-linear" width="22"></iconify-icon>
            </div>
            <div>
                <div class="text-[10px] uppercase tracking-wider text-slate-400 font-medium">Saldo E-Wallet</div>
                <div class="text-lg font-semibold text-[#2D336B]">Rp {{ number_format(Auth::user()->balance, 0, ',', '.') }}</div>
            </div>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-100 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-[#7886C7]">
                <iconify-icon icon="solar:cart-large-2-linear" width="22"></iconify-icon>
            </div>
            <div>
                <div class="text-[10px] uppercase tracking-wider text-slate-400 font-medium">Pesanan Aktif</div>
                <div class="text-lg font-semibold text-[#2D336B]">
                    {{ $activeOrders }} <span class="text-xs font-normal text-slate-400 ml-1">Pesanan</span>
                </div>
            </div>
        </div>
        <a href="{{ route('customer.orders.index') }}"
            class="bg-[#7886C7] p-4 rounded-2xl flex items-center justify-center text-white cursor-pointer hover:bg-[#6875b3] transition-colors">
            <div class="flex items-center gap-2">
                <iconify-icon icon="solar:add-circle-linear" width="20"></iconify-icon>
                <span class="text-sm font-medium">Pesan Sekarang</span>
            </div>
        </a>
    </div>

    {{-- Menu Cards --}}
    <div style="margin-bottom:8px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;">
            <div>
                <h2 style="font-size:17px;font-weight:800;color:#2D336B;margin:0;">Menu Tersedia</h2>
                <p style="font-size:12px;color:#7a82a8;margin:3px 0 0;">Pilih menu favoritmu hari ini</p>
            </div>
            <a href="{{ route('customer.orders.index') }}"
               style="display:inline-flex;align-items:center;gap:6px;font-size:12px;font-weight:600;color:#7886C7;text-decoration:none;padding:7px 14px;border:1.5px solid #E4E8F4;border-radius:10px;background:#fff;transition:all .15s;"
               onmouseover="this.style.background='#F4F6FB'" onmouseout="this.style.background='#fff'">
                Lihat Semua
                <iconify-icon icon="solar:arrow-right-bold" style="font-size:13px;"></iconify-icon>
            </a>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:16px;">
            @forelse($menus as $menu)
            @php
                $cat = strtolower($menu->category);
                $isMinum = str_contains($cat, 'minum');
                $catBg  = $isMinum ? '#fff7ed' : '#eff6ff';
                $catClr = $isMinum ? '#c2410c' : '#1d4ed8';
                $stockOut = $menu->stock <= 0;
                $stockLow = $menu->stock > 0 && $menu->stock <= 5;
                $stockClr    = $stockOut ? '#b91c1c' : ($stockLow ? '#b45309' : '#15803d');
                $stockBg     = $stockOut ? '#fef2f2' : ($stockLow ? '#fffbeb' : '#f0fdf4');
                $stockBorder = $stockOut ? '#fecaca' : ($stockLow ? '#fde68a' : '#bbf7d0');
            @endphp
            <div style="background:#fff;border:1.5px solid #E4E8F4;border-radius:18px;overflow:hidden;display:flex;flex-direction:column;transition:box-shadow .2s,border-color .2s;"
                 onmouseover="this.style.boxShadow='0 6px 24px rgba(45,51,107,.10)';this.style.borderColor='#A9B5EB';"
                 onmouseout="this.style.boxShadow='none';this.style.borderColor='#E4E8F4';">

                {{-- Photo --}}
                @if($menu->photo)
                    <div style="width:100%;height:160px;overflow:hidden;position:relative;background:#F4F6FB;">
                        <img src="{{ asset('storage/' . $menu->photo) }}" alt="{{ $menu->name }}"
                             style="width:100%;height:100%;object-fit:cover;display:block;">
                        <span style="position:absolute;top:10px;left:10px;background:{{ $catBg }};color:{{ $catClr }};font-size:10px;font-weight:700;padding:3px 10px;border-radius:100px;">
                            {{ ucfirst($menu->category) }}
                        </span>
                        @if($stockOut)
                        <div style="position:absolute;inset:0;background:rgba(0,0,0,.45);display:flex;align-items:center;justify-content:center;">
                            <span style="background:#fff;color:#b91c1c;font-size:11px;font-weight:800;padding:5px 16px;border-radius:100px;">Stok Habis</span>
                        </div>
                        @endif
                    </div>
                @else
                    <div style="width:100%;height:130px;background:#F4F6FB;display:flex;align-items:center;justify-content:center;position:relative;">
                        <iconify-icon icon="solar:dish-bold" style="font-size:44px;color:#A9B5EB;"></iconify-icon>
                        <span style="position:absolute;top:10px;left:10px;background:{{ $catBg }};color:{{ $catClr }};font-size:10px;font-weight:700;padding:3px 10px;border-radius:100px;">
                            {{ ucfirst($menu->category) }}
                        </span>
                        @if($stockOut)
                        <div style="position:absolute;inset:0;background:rgba(0,0,0,.35);display:flex;align-items:center;justify-content:center;">
                            <span style="background:#fff;color:#b91c1c;font-size:11px;font-weight:800;padding:5px 16px;border-radius:100px;">Stok Habis</span>
                        </div>
                        @endif
                    </div>
                @endif

                {{-- Body --}}
                <div style="padding:14px 16px;flex:1;display:flex;flex-direction:column;gap:6px;">
                    <h3 style="font-size:14px;font-weight:800;color:#1a1d2e;margin:0;line-height:1.3;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $menu->name }}</h3>

                    @if($menu->description)
                    <p style="font-size:11px;color:#7a82a8;margin:0;line-height:1.5;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                        {{ $menu->description }}
                    </p>
                    @endif

                    {{-- Kantin --}}
                    <div style="display:flex;align-items:center;gap:5px;">
                        <iconify-icon icon="solar:shop-bold" style="font-size:12px;color:#7886C7;flex-shrink:0;"></iconify-icon>
                        <span style="font-size:11px;font-weight:600;color:#7886C7;">{{ $menu->admin->name ?? 'Kantin' }}</span>
                    </div>

                    {{-- Price + Stock --}}
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-top:2px;">
                        <span style="font-size:16px;font-weight:800;color:#2D336B;">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                        <span style="font-size:10px;font-weight:600;background:{{ $stockBg }};color:{{ $stockClr }};border:1.5px solid {{ $stockBorder }};padding:2px 8px;border-radius:100px;">
                            @if($stockOut) Habis @elseif($stockLow) Sisa {{ $menu->stock }} @else {{ $menu->stock }} porsi @endif
                        </span>
                    </div>
                </div>

                {{-- Button --}}
                <div style="padding:0 16px 16px;">
                    @if($menu->stock > 0)
                        <a href="{{ route('customer.orders.index') }}"
                           style="display:flex;align-items:center;justify-content:center;gap:7px;padding:10px;background:#2D336B;color:#fff;border-radius:12px;font-size:12px;font-weight:700;text-decoration:none;transition:background .2s;"
                           onmouseover="this.style.background='#7886C7'" onmouseout="this.style.background='#2D336B'">
                            <iconify-icon icon="solar:cart-plus-bold" style="font-size:15px;"></iconify-icon>
                            Pesan
                        </a>
                    @else
                        <div style="padding:10px;background:#F4F6FB;color:#7a82a8;border:1.5px solid #E4E8F4;border-radius:12px;font-size:12px;font-weight:600;text-align:center;">
                            Stok Habis
                        </div>
                    @endif
                </div>
            </div>
            @empty
            <div style="grid-column:1/-1;background:#fff;border:1.5px solid #E4E8F4;border-radius:18px;padding:48px 20px;text-align:center;">
                <iconify-icon icon="solar:dish-bold" style="font-size:48px;color:#A9B5EB;display:block;margin:0 auto 12px;"></iconify-icon>
                <p style="font-size:14px;font-weight:800;color:#2D336B;margin:0 0 5px;">Belum ada menu tersedia</p>
                <p style="font-size:12px;color:#7a82a8;margin:0;">Silakan cek kembali nanti</p>
            </div>
            @endforelse
        </div>

        <div style="text-align:center;margin-top:18px;">
            <a href="{{ route('customer.orders.index') }}"
               style="display:inline-flex;align-items:center;gap:6px;font-size:12px;font-weight:600;color:#7a82a8;text-decoration:none;transition:color .15s;"
               onmouseover="this.style.color='#2D336B'" onmouseout="this.style.color='#7a82a8'">
                <span>Tampilkan lebih banyak</span>
                <iconify-icon icon="solar:alt-arrow-down-bold" style="font-size:13px;"></iconify-icon>
            </a>
        </div>
    </div>

</x-customer-layout>
