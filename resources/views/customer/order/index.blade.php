<x-customer-layout>
    <x-slot name="title">Pesan Menu — DCS</x-slot>

    {{-- Hidden batch order form --}}
    <form id="batchOrderForm" action="{{ route('customer.orders.storeBatch') }}" method="POST" style="display:none;">
        @csrf
        <div id="batchFormItems"></div>
        <input type="hidden" name="pickup_time" id="batchPickupTime">
    </form>

    <style>
        .menu-filter-pill {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 18px; border-radius: 100px; font-size: 13px; font-weight: 700;
            border: 1.5px solid #E4E8F4; background: #fff; color: #7a82a8;
            cursor: pointer; text-decoration: none; transition: all .18s;
            white-space: nowrap;
        }
        .menu-filter-pill:hover { border-color: #A9B5EB; color: #2D336B; background: #F4F6FB; }
        .menu-filter-pill.active { background: #2D336B; color: #fff; border-color: #2D336B; }
        .menu-filter-pill.active-minum { background: #c2410c; color: #fff; border-color: #c2410c; }

        .kantin-select {
            padding: 8px 32px 8px 14px;
            border: 1.5px solid #E4E8F4; border-radius: 100px;
            font-size: 13px; font-weight: 700; color: #1a1d2e;
            background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24'%3E%3Cpath fill='%237a82a8' d='M7 10l5 5 5-5z'/%3E%3C/svg%3E") no-repeat right 12px center;
            appearance: none; outline: none; cursor: pointer;
            transition: border-color .18s, box-shadow .18s;
            font-family: inherit;
        }
        .kantin-select:focus { border-color: #7886C7; box-shadow: 0 0 0 3px rgba(120,134,199,.15); }

        .menu-card {
            background: #fff;
            border: 1.5px solid #E4E8F4;
            border-radius: 20px;
            overflow: hidden;
            display: flex; flex-direction: column;
            transition: box-shadow .25s, border-color .25s, transform .2s;
            position: relative;
        }
        .menu-card:hover {
            box-shadow: 0 12px 40px rgba(45,51,107,.13);
            border-color: #A9B5EB;
            transform: translateY(-3px);
        }
        .menu-card-img {
            width: 100%; height: 200px; overflow: hidden;
            position: relative; flex-shrink: 0;
        }
        .menu-card-img img {
            width: 100%; height: 100%; object-fit: cover; display: block;
            transition: transform .4s ease;
        }
        .menu-card:hover .menu-card-img img { transform: scale(1.05); }
        .menu-card-img-placeholder {
            width: 100%; height: 200px; background: linear-gradient(135deg,#F4F6FB 0%,#eef0f8 100%);
            display: flex; align-items: center; justify-content: center;
        }
        /* Gradient overlay bottom of image */
        .menu-card-img::after {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(to bottom, transparent 45%, rgba(26,29,46,.55) 100%);
            pointer-events: none;
        }
        .img-cat-badge {
            position: absolute; top: 12px; left: 12px; z-index: 2;
            font-size: 10px; font-weight: 800; letter-spacing: .5px;
            padding: 4px 12px; border-radius: 100px;
            backdrop-filter: blur(8px);
        }
        .img-price-badge {
            position: absolute; bottom: 12px; left: 12px; z-index: 2;
            font-size: 16px; font-weight: 900; color: #fff;
            text-shadow: 0 1px 4px rgba(0,0,0,.4);
            letter-spacing: -.3px;
        }
        .img-stock-badge {
            position: absolute; bottom: 12px; right: 12px; z-index: 2;
            font-size: 10px; font-weight: 700; padding: 3px 10px; border-radius: 100px;
        }
        .stock-ok   { background: rgba(34,197,94,.9);  color: #fff; }
        .stock-low  { background: rgba(245,158,11,.9); color: #fff; }
        .stock-out  { background: rgba(239,68,68,.9);  color: #fff; }
        .menu-card-body { padding: 16px 18px 14px; flex: 1; display: flex; flex-direction: column; gap: 7px; }
        .menu-card-name { font-size: 15px; font-weight: 800; color: #1a1d2e; line-height: 1.3; margin: 0; }
        .menu-card-desc { font-size: 12px; color: #7a82a8; margin: 0; line-height: 1.55;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .menu-card-kantin {
            display: inline-flex; align-items: center; gap: 5px;
            background: #F4F6FB; border: 1.5px solid #E4E8F4; border-radius: 100px;
            padding: 4px 10px; width: fit-content;
            font-size: 11px; font-weight: 700; color: #7886C7;
        }
        .menu-card-footer { padding: 0 18px 18px; }
        .btn-order {
            width: 100%; display: flex; align-items: center; justify-content: center; gap: 8px;
            padding: 12px; background: #2D336B; color: #fff; border: none; border-radius: 14px;
            font-size: 13px; font-weight: 800; cursor: pointer; letter-spacing: .2px;
            transition: background .2s, transform .15s, box-shadow .2s;
            font-family: inherit;
        }
        .btn-order:hover { background: #7886C7; box-shadow: 0 4px 16px rgba(120,134,199,.4); }
        .btn-order:active { transform: scale(.97); }
        .btn-order-disabled {
            width: 100%; padding: 12px; background: #F4F6FB; color: #b0b8d0;
            border: 1.5px solid #E4E8F4; border-radius: 14px;
            font-size: 13px; font-weight: 600; cursor: not-allowed; font-family: inherit;
        }
        /* Modal */
        .modal-input {
            width: 100%; border: 1.5px solid #E4E8F4; border-radius: 12px;
            background: #F4F6FB; padding: 10px 14px; font-size: 14px; font-weight: 600;
            color: #1a1d2e; outline: none; font-family: inherit;
            transition: border-color .18s, box-shadow .18s;
        }
        .modal-input:focus { border-color: #7886C7; box-shadow: 0 0 0 3px rgba(120,134,199,.15); background: #fff; }
        .modal-label { font-size: 11px; font-weight: 700; color: #7a82a8; text-transform: uppercase; letter-spacing: .6px; margin-bottom: 6px; display: block; }
    </style>

    {{-- Page Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:22px;">
        <div>
            <h1 style="font-size:22px;font-weight:900;color:#2D336B;margin:0;line-height:1.2;">Pesan Menu</h1>
            <p style="font-size:13px;color:#7a82a8;margin:4px 0 0;">Pilih menu favoritmu dan lakukan pemesanan.</p>
        </div>
        <a href="{{ route('customer.myOrders') }}"
           style="display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:#2D336B;color:#fff;border-radius:100px;font-size:13px;font-weight:700;text-decoration:none;transition:background .2s,box-shadow .2s;"
           onmouseover="this.style.background='#7886C7';this.style.boxShadow='0 4px 16px rgba(120,134,199,.4)'"
           onmouseout="this.style.background='#2D336B';this.style.boxShadow='none'">
            <iconify-icon icon="solar:bag-5-bold" style="font-size:16px;"></iconify-icon>
            Pesanan Saya
        </a>
    </div>

    {{-- Session Alerts --}}
    @if(session('success'))
    <div style="margin-bottom:18px;display:flex;align-items:center;gap:10px;padding:13px 16px;background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:14px;">
        <iconify-icon icon="solar:check-circle-bold" style="font-size:18px;color:#15803d;flex-shrink:0;"></iconify-icon>
        <span style="font-size:13px;font-weight:600;color:#15803d;">{{ session('success') }}</span>
    </div>
    @endif
    @if(session('error'))
    <div style="margin-bottom:18px;display:flex;align-items:center;gap:10px;padding:13px 16px;background:#fef2f2;border:1.5px solid #fecaca;border-radius:14px;">
        <iconify-icon icon="solar:danger-triangle-bold" style="font-size:18px;color:#b91c1c;flex-shrink:0;"></iconify-icon>
        <span style="font-size:13px;font-weight:600;color:#b91c1c;">{{ session('error') }}</span>
    </div>
    @endif

    {{-- Filter Bar --}}
    <div style="background:#fff;border:1.5px solid #E4E8F4;border-radius:18px;padding:16px 20px;margin-bottom:24px;">
        <form method="GET" action="{{ route('customer.orders.index') }}" id="filterForm">
            <div style="display:flex;align-items:center;flex-wrap:wrap;gap:10px;">
                {{-- Category pill tabs --}}
                <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                    <a href="{{ route('customer.orders.index', array_merge(request()->except('category'), ['kantin' => request('kantin')])) }}"
                       class="menu-filter-pill {{ !request('category') ? 'active' : '' }}">
                        <iconify-icon icon="solar:widget-bold" style="font-size:14px;"></iconify-icon>
                        Semua
                    </a>
                    <a href="{{ route('customer.orders.index', array_merge(request()->except('category'), ['category' => 'makanan', 'kantin' => request('kantin')])) }}"
                       class="menu-filter-pill {{ request('category') == 'makanan' ? 'active' : '' }}">
                        <iconify-icon icon="solar:bowl-spoon-bold" style="font-size:14px;"></iconify-icon>
                        Makanan
                    </a>
                    <a href="{{ route('customer.orders.index', array_merge(request()->except('category'), ['category' => 'minuman', 'kantin' => request('kantin')])) }}"
                       class="menu-filter-pill {{ request('category') == 'minuman' ? 'active-minum' : '' }}">
                        <iconify-icon icon="solar:cup-hot-bold" style="font-size:14px;"></iconify-icon>
                        Minuman
                    </a>
                </div>

                {{-- Divider --}}
                <div style="width:1.5px;height:28px;background:#E4E8F4;margin:0 4px;flex-shrink:0;"></div>

                {{-- Kantin select --}}
                @if($admins->count() > 0)
                <select name="kantin" onchange="this.form.submit()" class="kantin-select">
                    <option value="">Semua Kantin</option>
                    @foreach($admins as $i => $admin)
                        <option value="{{ $admin->id }}" {{ request('kantin') == $admin->id ? 'selected' : '' }}>
                            {{ $admin->name }}
                        </option>
                    @endforeach
                </select>
                <input type="hidden" name="category" value="{{ request('category') }}">
                @endif

                {{-- Reset --}}
                @if(request('category') || request('kantin'))
                <a href="{{ route('customer.orders.index') }}"
                   style="display:inline-flex;align-items:center;gap:5px;font-size:12px;font-weight:700;color:#7a82a8;text-decoration:none;padding:8px 14px;border:1.5px solid #E4E8F4;border-radius:100px;background:#F4F6FB;transition:all .15s;white-space:nowrap;"
                   onmouseover="this.style.color='#b91c1c';this.style.borderColor='#fecaca'" onmouseout="this.style.color='#7a82a8';this.style.borderColor='#E4E8F4'">
                    <iconify-icon icon="solar:close-circle-bold" style="font-size:13px;"></iconify-icon>
                    Reset
                </a>
                @endif

                {{-- Count pushed right --}}
                <div style="margin-left:auto;background:#F4F6FB;border:1.5px solid #E4E8F4;border-radius:100px;padding:6px 14px;display:flex;align-items:center;gap:6px;white-space:nowrap;">
                    <iconify-icon icon="solar:dish-bold" style="font-size:13px;color:#7886C7;"></iconify-icon>
                    <span style="font-size:12px;font-weight:700;color:#2D336B;">{{ $menus->count() }} menu</span>
                </div>
            </div>
        </form>
    </div>

    {{-- Two-column layout: menu + cart --}}
    <div style="display:flex;gap:22px;align-items:flex-start;">

        {{-- ── LEFT: Menu Grid ───────── --}}
        <div style="flex:1;min-width:0;">

    {{-- Menu Grid --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(230px,1fr));gap:18px;">
        @forelse($menus as $menu)
        @php
            $cat = strtolower($menu->category);
            $isMinum  = str_contains($cat, 'minum');
            $catIcon  = $isMinum ? 'solar:cup-hot-bold' : 'solar:bowl-spoon-bold';
            $catBg    = $isMinum ? 'rgba(255,237,213,.9)' : 'rgba(219,234,254,.9)';
            $catClr   = $isMinum ? '#9a3412' : '#1e40af';
            $stockOut = $menu->stock <= 0;
            $stockLow = $menu->stock > 0 && $menu->stock <= 5;
            $stockClass = $stockOut ? 'stock-out' : ($stockLow ? 'stock-low' : 'stock-ok');
            $stockLabel = $stockOut ? 'Habis' : ($stockLow ? 'Sisa '.$menu->stock : $menu->stock.' porsi');
        @endphp
        <div class="menu-card">

            {{-- Image area --}}
            @if($menu->photo)
            <div class="menu-card-img">
                <img src="{{ asset('storage/' . $menu->photo) }}" alt="{{ $menu->name }}">
                <span class="img-cat-badge" style="background:{{ $catBg }};color:{{ $catClr }};">
                    <iconify-icon icon="{{ $catIcon }}" style="font-size:10px;vertical-align:-1px;margin-right:3px;"></iconify-icon>{{ ucfirst($menu->category) }}
                </span>
                <span class="img-price-badge">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                <span class="img-stock-badge {{ $stockClass }}">{{ $stockLabel }}</span>
                @if($stockOut)
                <div style="position:absolute;inset:0;background:rgba(0,0,0,.5);display:flex;align-items:center;justify-content:center;z-index:3;">
                    <div style="background:rgba(255,255,255,.15);backdrop-filter:blur(6px);border:1.5px solid rgba(255,255,255,.3);border-radius:100px;padding:8px 22px;">
                        <span style="font-size:13px;font-weight:800;color:#fff;letter-spacing:.5px;">Stok Habis</span>
                    </div>
                </div>
                @endif
            </div>
            @else
            <div style="position:relative;">
                <div class="menu-card-img-placeholder">
                    <iconify-icon icon="solar:dish-bold" style="font-size:60px;color:#C5CBDF;"></iconify-icon>
                </div>
                <span class="img-cat-badge" style="background:{{ $catBg }};color:{{ $catClr }};">
                    <iconify-icon icon="{{ $catIcon }}" style="font-size:10px;vertical-align:-1px;margin-right:3px;"></iconify-icon>{{ ucfirst($menu->category) }}
                </span>
                <span style="position:absolute;bottom:12px;left:12px;font-size:16px;font-weight:900;color:#2D336B;">
                    Rp {{ number_format($menu->price, 0, ',', '.') }}
                </span>
                <span class="img-stock-badge {{ $stockClass }}" style="position:absolute;bottom:12px;right:12px;">{{ $stockLabel }}</span>
            </div>
            @endif

            {{-- Body --}}
            <div class="menu-card-body">
                <h3 class="menu-card-name">{{ $menu->name }}</h3>

                @if($menu->description)
                <p class="menu-card-desc">{{ $menu->description }}</p>
                @endif

                <div class="menu-card-kantin">
                    <iconify-icon icon="solar:shop-bold" style="font-size:12px;"></iconify-icon>
                    {{ $menu->admin->name ?? 'Kantin' }}
                </div>
            </div>

            {{-- Button --}}
            <div class="menu-card-footer">
                @if($menu->stock > 0)
                <button class="btn-order"
                    onclick="addToCart({{ $menu->id }}, '{{ addslashes($menu->name) }}', {{ $menu->price }}, {{ $menu->stock }}, '{{ $menu->photo ? asset('storage/'.$menu->photo) : '' }}', '{{ addslashes($menu->admin->name ?? 'Kantin') }}')">
                    <iconify-icon icon="solar:cart-plus-bold" style="font-size:17px;"></iconify-icon>
                    Tambah ke Keranjang
                </button>
                @else
                <button class="btn-order-disabled" disabled>Stok Habis</button>
                @endif
            </div>
        </div>
        @empty
        <div style="grid-column:1/-1;background:#fff;border:1.5px solid #E4E8F4;border-radius:20px;padding:72px 20px;text-align:center;">
            <div style="width:72px;height:72px;background:#F4F6FB;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                <iconify-icon icon="solar:dish-bold" style="font-size:36px;color:#A9B5EB;"></iconify-icon>
            </div>
            <p style="font-size:16px;font-weight:800;color:#2D336B;margin:0 0 6px;">Belum ada menu tersedia</p>
            <p style="font-size:13px;color:#7a82a8;margin:0;">Coba ubah filter atau periksa kembali nanti</p>
        </div>
        @endforelse
    </div>

        </div>{{-- end LEFT --}}

        {{-- ── RIGHT: Cart Panel ───────── --}}
        <div id="cartPanel" style="width:320px;flex-shrink:0;position:sticky;top:82px;background:#fff;border:1.5px solid #E4E8F4;border-radius:20px;overflow:hidden;box-shadow:0 4px 24px rgba(45,51,107,.07);">

            {{-- Cart header --}}
            <div style="padding:16px 20px;border-bottom:1.5px solid #E4E8F4;display:flex;align-items:center;justify-content:space-between;">
                <div style="display:flex;align-items:center;gap:8px;">
                    <iconify-icon icon="solar:cart-large-bold" style="font-size:18px;color:#2D336B;"></iconify-icon>
                    <span style="font-size:15px;font-weight:800;color:#2D336B;">Pesanan Saya</span>
                </div>
                <span id="cartCount" style="background:#2D336B;color:#fff;font-size:11px;font-weight:800;padding:2px 9px;border-radius:100px;display:none;">0</span>
            </div>

            {{-- Cart items scroll area --}}
            <div id="cartItems" style="max-height:340px;overflow-y:auto;padding:12px 14px;display:flex;flex-direction:column;gap:10px;">
                {{-- Empty state --}}
                <div id="cartEmpty" style="padding:32px 10px;text-align:center;">
                    <iconify-icon icon="solar:cart-bold" style="font-size:40px;color:#C5CBDF;display:block;margin:0 auto 10px;"></iconify-icon>
                    <p style="font-size:13px;font-weight:700;color:#7a82a8;margin:0 0 4px;">Keranjang kosong</p>
                    <p style="font-size:11px;color:#b0b8d0;margin:0;">Tambahkan menu untuk mulai pesan</p>
                </div>
            </div>

            {{-- Cart footer (hidden when empty) --}}
            <div id="cartFooter" style="display:none;border-top:1.5px solid #E4E8F4;">
                {{-- Pickup time --}}
                <div style="padding:14px 18px 0;">
                    <label style="font-size:10px;font-weight:700;color:#7a82a8;text-transform:uppercase;letter-spacing:.6px;display:block;margin-bottom:7px;">Waktu Pengambilan</label>
                    <select id="cartPickupTime" style="width:100%;padding:9px 14px;border:1.5px solid #E4E8F4;border-radius:12px;font-size:13px;font-weight:700;color:#1a1d2e;background:#F4F6FB;outline:none;cursor:pointer;font-family:inherit;appearance:none;background-image:url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2212%22 height=%2212%22 viewBox=%220 0 24 24%22%3E%3Cpath fill=%22%237a82a8%22 d=%22M7 10l5 5 5-5z%22/%3E%3C/svg%3E');background-repeat:no-repeat;background-position:right 12px center;padding-right:32px;">
                        <option value="istirahat_1">🕙  Istirahat 1 — 10:00–10:30</option>
                        <option value="istirahat_2">🕛  Istirahat 2 — 12:00–12:30</option>
                    </select>
                </div>

                {{-- Totals --}}
                <div style="padding:14px 18px;display:flex;flex-direction:column;gap:6px;">
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <span style="font-size:12px;color:#7a82a8;font-weight:500;">Subtotal</span>
                        <span style="font-size:13px;font-weight:700;color:#1a1d2e;" id="cartSubtotal">Rp 0</span>
                    </div>
                    <div style="height:1px;background:#F4F6FB;"></div>
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <span style="font-size:13px;font-weight:800;color:#2D336B;">Total</span>
                        <span style="font-size:17px;font-weight:900;color:#2D336B;" id="cartTotal">Rp 0</span>
                    </div>
                </div>

                {{-- Checkout button --}}
                <div style="padding:0 18px 18px;">
                    <button onclick="checkout()"
                        style="width:100%;padding:13px;background:#2D336B;color:#fff;border:none;border-radius:14px;font-size:14px;font-weight:800;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:background .2s,box-shadow .2s;font-family:inherit;letter-spacing:.2px;"
                        onmouseover="this.style.background='#7886C7';this.style.boxShadow='0 4px 16px rgba(120,134,199,.4)'"
                        onmouseout="this.style.background='#2D336B';this.style.boxShadow='none'">
                        <iconify-icon icon="solar:cart-check-bold" style="font-size:18px;"></iconify-icon>
                        Bayar Sekarang
                    </button>
                    <button onclick="clearCart()"
                        style="width:100%;margin-top:8px;padding:9px;background:transparent;color:#b91c1c;border:1.5px solid #fecaca;border-radius:12px;font-size:12px;font-weight:700;cursor:pointer;transition:all .15s;font-family:inherit;"
                        onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='transparent'">
                        Kosongkan Keranjang
                    </button>
                </div>
            </div>
        </div>

    </div>{{-- end flex row --}}

    <x-slot name="head">
        <script>
        // ─── Cart (localStorage) ────────────────────────────────────────────
        const CART_KEY = 'dcs_cart_v1';

        function loadCart() {
            try { return JSON.parse(localStorage.getItem(CART_KEY)) || []; }
            catch(e) { return []; }
        }
        function saveCart(cart) {
            localStorage.setItem(CART_KEY, JSON.stringify(cart));
        }
        function fmt(n) { return 'Rp ' + n.toLocaleString('id-ID'); }

        function addToCart(id, name, price, maxStock, photo, kantin) {
            let cart = loadCart();
            const existing = cart.find(i => i.id === id);
            if (existing) {
                if (existing.qty < maxStock) { existing.qty++; }
                else { alert('Stok maksimal ' + maxStock + ' porsi sudah tercapai.'); return; }
            } else {
                cart.push({ id, name, price, maxStock, photo, kantin, qty: 1, notes: '' });
            }
            saveCart(cart);
            renderCart();
            // Brief pulse on cart panel
            const panel = document.getElementById('cartPanel');
            panel.style.transition = 'box-shadow .15s';
            panel.style.boxShadow = '0 0 0 3px rgba(120,134,199,.4)';
            setTimeout(() => panel.style.boxShadow = '0 4px 24px rgba(45,51,107,.07)', 300);
        }

        function updateQty(id, delta) {
            let cart = loadCart();
            const item = cart.find(i => i.id === id);
            if (!item) return;
            item.qty += delta;
            if (item.qty <= 0) { cart = cart.filter(i => i.id !== id); }
            else if (item.qty > item.maxStock) { item.qty = item.maxStock; }
            saveCart(cart);
            renderCart();
        }

        function removeFromCart(id) {
            let cart = loadCart().filter(i => i.id !== id);
            saveCart(cart);
            renderCart();
        }

        function clearCart() {
            saveCart([]);
            renderCart();
        }

        function updateNotes(id, val) {
            let cart = loadCart();
            const item = cart.find(i => i.id === id);
            if (item) { item.notes = val; saveCart(cart); }
        }

        function renderCart() {
            const cart = loadCart();
            const itemsEl = document.getElementById('cartItems');
            const footerEl = document.getElementById('cartFooter');
            const emptyEl = document.getElementById('cartEmpty');
            const countEl = document.getElementById('cartCount');
            const subtotalEl = document.getElementById('cartSubtotal');
            const totalEl = document.getElementById('cartTotal');

            if (cart.length === 0) {
                emptyEl.style.display = 'block';
                footerEl.style.display = 'none';
                countEl.style.display = 'none';
                // Clear item rows
                Array.from(itemsEl.children).forEach(c => { if (c.id !== 'cartEmpty') c.remove(); });
                return;
            }

            emptyEl.style.display = 'none';
            footerEl.style.display = 'block';
            countEl.style.display = 'inline';

            // Total item count
            const totalItems = cart.reduce((s, i) => s + i.qty, 0);
            countEl.textContent = totalItems;

            // Build item rows
            // Remove old rows
            Array.from(itemsEl.querySelectorAll('.cart-row')).forEach(r => r.remove());

            cart.forEach(item => {
                const row = document.createElement('div');
                row.className = 'cart-row';
                row.style.cssText = 'background:#F4F6FB;border:1.5px solid #E4E8F4;border-radius:14px;padding:10px 12px;display:flex;flex-direction:column;gap:8px;';
                row.innerHTML = `
                    <div style="display:flex;align-items:flex-start;gap:10px;">
                        ${item.photo
                            ? `<img src="${item.photo}" style="width:42px;height:42px;border-radius:9px;object-fit:cover;flex-shrink:0;border:1.5px solid #E4E8F4;">`
                            : `<div style="width:42px;height:42px;border-radius:9px;background:#E4E8F4;display:flex;align-items:center;justify-content:center;flex-shrink:0;"><iconify-icon icon="solar:dish-bold" style="font-size:18px;color:#A9B5EB;"></iconify-icon></div>`
                        }
                        <div style="flex:1;min-width:0;">
                            <div style="font-size:13px;font-weight:800;color:#1a1d2e;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${item.name}</div>
                            <div style="font-size:11px;color:#7886C7;font-weight:600;">${item.kantin}</div>
                        </div>
                        <button onclick="removeFromCart(${item.id})" style="width:24px;height:24px;border:none;background:transparent;cursor:pointer;color:#b91c1c;padding:0;flex-shrink:0;display:flex;align-items:center;justify-content:center;border-radius:6px;transition:background .15s;" onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='transparent'">
                            <iconify-icon icon="solar:trash-bin-trash-bold" style="font-size:14px;"></iconify-icon>
                        </button>
                    </div>
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        <span style="font-size:14px;font-weight:800;color:#2D336B;">${fmt(item.price * item.qty)}</span>
                        <div style="display:flex;align-items:center;gap:0;border:1.5px solid #E4E8F4;border-radius:10px;overflow:hidden;background:#fff;">
                            <button onclick="updateQty(${item.id},-1)" style="width:30px;height:30px;border:none;background:transparent;font-size:16px;font-weight:700;color:#2D336B;cursor:pointer;transition:background .15s;" onmouseover="this.style.background='#F4F6FB'" onmouseout="this.style.background='transparent'">−</button>
                            <span style="min-width:28px;text-align:center;font-size:13px;font-weight:800;color:#1a1d2e;">${item.qty}</span>
                            <button onclick="updateQty(${item.id},1)" style="width:30px;height:30px;border:none;background:transparent;font-size:16px;font-weight:700;color:#2D336B;cursor:pointer;transition:background .15s;" onmouseover="this.style.background='#F4F6FB'" onmouseout="this.style.background='transparent'">+</button>
                        </div>
                    </div>
                    <input type="text" placeholder="Catatan (opsional)…" value="${item.notes || ''}"
                        oninput="updateNotes(${item.id}, this.value)"
                        style="width:100%;border:1.5px solid #E4E8F4;border-radius:9px;background:#fff;padding:6px 10px;font-size:11px;color:#7a82a8;outline:none;font-family:inherit;box-sizing:border-box;">
                `;
                itemsEl.appendChild(row);
            });

            // Totals
            const sub = cart.reduce((s, i) => s + i.price * i.qty, 0);
            subtotalEl.textContent = fmt(sub);
            totalEl.textContent = fmt(sub);
        }

        function checkout() {
            const cart = loadCart();
            if (cart.length === 0) { alert('Keranjang kosong!'); return; }

            const pickup = document.getElementById('cartPickupTime').value;
            const itemsEl = document.getElementById('batchFormItems');
            itemsEl.innerHTML = '';

            cart.forEach((item, idx) => {
                itemsEl.innerHTML +=
                    `<input type="hidden" name="items[${idx}][menu_id]" value="${item.id}">` +
                    `<input type="hidden" name="items[${idx}][quantity]" value="${item.qty}">` +
                    `<input type="hidden" name="items[${idx}][notes]" value="${item.notes || ''}">`;
            });

            document.getElementById('batchPickupTime').value = pickup;

            // Clear cart after submit
            saveCart([]);
            document.getElementById('batchOrderForm').submit();
        }

        document.addEventListener('DOMContentLoaded', renderCart);
        </script>
    </x-slot>

</x-customer-layout>
