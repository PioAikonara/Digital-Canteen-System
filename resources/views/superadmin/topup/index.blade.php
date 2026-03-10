<x-superadmin-layout>
    <x-slot name="title">Top Up Saldo — Super Admin</x-slot>

    <style>
        .sa-card { background:#fff;border:1.5px solid #e2e8f0;border-radius:18px;overflow:hidden; }
        .sa-label { font-size:12px;font-weight:700;color:#374151;margin-bottom:5px;display:block; }
        .sa-input { width:100%;padding:9px 13px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;color:#334155;outline:none;background:#f8fafc;box-sizing:border-box;font-family:inherit;transition:border-color .15s; }
        .sa-input:focus { border-color:#f59e0b;background:#fff; }
        .sa-table th { font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;padding:11px 14px;border-bottom:1.5px solid #f1f5f9;background:#f8fafc; }
        .sa-table td { font-size:13px;color:#334155;padding:12px 14px;border-bottom:1px solid #f1f5f9;vertical-align:middle; }
        .sa-table tr:last-child td { border-bottom:none; }
        .sa-table tr:hover td { background:#fafbff; }
        .sa-btn-pri { display:inline-flex;align-items:center;gap:6px;padding:9px 20px;background:linear-gradient(135deg,#d97706,#f59e0b);color:#fff;border-radius:10px;font-size:13px;font-weight:800;border:none;cursor:pointer;transition:opacity .15s; }
        .sa-btn-pri:hover { opacity:.88; }
        .sa-error { font-size:11px;color:#dc2626;margin-top:3px; }
        .quick-btn { padding:5px 10px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:11px;font-weight:700;cursor:pointer;background:#f8fafc;color:#334155;transition:all .15s; }
        .quick-btn:hover { border-color:#f59e0b;color:#d97706;background:#fffbeb; }
    </style>

    <div style="margin-bottom:22px;">
        <h1 style="font-size:20px;font-weight:900;color:#0f172a;margin:0 0 3px;">Top Up Saldo</h1>
        <p style="font-size:13px;color:#64748b;margin:0;">Tambah saldo untuk akun siswa</p>
    </div>

    @if(session('success'))
    <div style="margin-bottom:16px;display:flex;align-items:center;gap:10px;padding:12px 16px;background:#fffbeb;border:1.5px solid #fde68a;border-radius:13px;color:#92400e;font-size:13px;font-weight:600;">
        <iconify-icon icon="solar:check-circle-bold" style="font-size:18px;color:#f59e0b;"></iconify-icon>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div style="margin-bottom:16px;display:flex;align-items:center;gap:10px;padding:12px 16px;background:#fef2f2;border:1.5px solid #fecaca;border-radius:13px;color:#dc2626;font-size:13px;font-weight:600;">
        <iconify-icon icon="solar:close-circle-bold" style="font-size:18px;"></iconify-icon>
        {{ session('error') }}
    </div>
    @endif

    <div style="display:grid;grid-template-columns:380px 1fr;gap:20px;align-items:start;">

        {{-- FORM TOPUP --}}
        <div class="sa-card" style="padding:22px;">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
                <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#fef3c7,#fde68a);display:flex;align-items:center;justify-content:center;">
                    <iconify-icon icon="solar:wallet-money-bold" style="font-size:18px;color:#d97706;"></iconify-icon>
                </div>
                <div style="font-size:14px;font-weight:800;color:#1e293b;">Form Top Up</div>
            </div>

            <form method="POST" action="{{ route('superadmin.topup.store') }}" id="topupForm">
                @csrf
                <div style="display:grid;gap:14px;">
                    <div>
                        <label class="sa-label">Pilih Siswa <span style="color:#dc2626;">*</span></label>
                        <select name="user_id" class="sa-input" required id="userSelect" onchange="updateBalance(this)">
                            <option value="">-- Pilih siswa --</option>
                            @foreach($users as $u)
                            <option value="{{ $u->id }}" data-balance="{{ $u->balance }}" {{ old('user_id') == $u->id ? 'selected' : '' }}>
                                {{ $u->name }} — Rp {{ number_format($u->balance, 0, ',', '.') }}
                            </option>
                            @endforeach
                        </select>
                        @error('user_id')<p class="sa-error">{{ $message }}</p>@enderror
                    </div>

                    <div id="balanceInfo" style="display:none;padding:10px 12px;background:#f0fdf4;border-radius:10px;border:1.5px solid #bbf7d0;">
                        <span style="font-size:11px;color:#64748b;font-weight:600;">Saldo saat ini:</span>
                        <span id="currentBalance" style="font-size:13px;font-weight:800;color:#16a34a;margin-left:6px;"></span>
                    </div>

                    <div>
                        <label class="sa-label">Jumlah Top Up <span style="color:#dc2626;">*</span></label>
                        <div style="position:relative;">
                            <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);font-size:13px;color:#64748b;font-weight:700;">Rp</span>
                            <input type="number" name="amount" id="amountInput" value="{{ old('amount') }}" class="sa-input" style="padding-left:36px;" placeholder="0" min="1000" max="10000000" required>
                        </div>
                        @error('amount')<p class="sa-error">{{ $message }}</p>@enderror
                        <div style="display:flex;gap:6px;margin-top:8px;flex-wrap:wrap;">
                            @foreach([5000,10000,20000,50000,100000] as $nominal)
                            <button type="button" class="quick-btn" onclick="setAmount({{ $nominal }})">
                                {{ number_format($nominal, 0, ',', '.') }}
                            </button>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="sa-label">Catatan <span style="color:#94a3b8;font-weight:500;">(opsional)</span></label>
                        <textarea name="notes" class="sa-input" style="height:64px;resize:none;" placeholder="Keterangan top up…">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <div style="margin-top:18px;">
                    <button type="submit" class="sa-btn-pri" style="width:100%;justify-content:center;">
                        <iconify-icon icon="solar:wallet-money-bold" style="font-size:15px;"></iconify-icon>
                        Proses Top Up
                    </button>
                </div>
            </form>
        </div>

        {{-- HISTORY --}}
        <div class="sa-card">
            <div style="padding:12px 16px;border-bottom:1.5px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
                <div style="font-size:13px;font-weight:800;color:#1e293b;">Riwayat Top Up</div>
                <form method="GET" action="{{ route('superadmin.topup.index') }}" style="display:flex;gap:6px;">
                    <div style="position:relative;">
                        <iconify-icon icon="solar:magnifer-bold" style="position:absolute;left:9px;top:50%;transform:translateY(-50%);font-size:13px;color:#94a3b8;pointer-events:none;"></iconify-icon>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama…" class="sa-input" style="padding-left:28px;width:180px;height:34px;font-size:12px;">
                    </div>
                    <button type="submit" style="display:inline-flex;align-items:center;padding:0 12px;background:linear-gradient(135deg,#d97706,#f59e0b);color:#fff;border:none;border-radius:10px;font-size:12px;font-weight:700;cursor:pointer;height:34px;">Cari</button>
                    @if($search)<a href="{{ route('superadmin.topup.index') }}" style="display:inline-flex;align-items:center;padding:0 10px;background:#f1f5f9;color:#64748b;border-radius:10px;font-size:12px;font-weight:700;text-decoration:none;height:34px;">Reset</a>@endif
                </form>
            </div>
            <table class="sa-table" style="width:100%;border-collapse:collapse;">
                <thead><tr>
                    <th>Siswa</th>
                    <th style="text-align:right;">Jumlah</th>
                    <th>Diproses oleh</th>
                    <th>Catatan</th>
                    <th>Tanggal</th>
                </tr></thead>
                <tbody>
                @forelse($topUps as $topUp)
                <tr>
                    <td>
                        <div style="font-weight:700;color:#1e293b;font-size:12px;">{{ $topUp->user->name ?? '-' }}</div>
                        <div style="font-size:11px;color:#94a3b8;">{{ $topUp->user->email ?? '' }}</div>
                    </td>
                    <td style="text-align:right;font-weight:800;color:#d97706;">+ Rp {{ number_format($topUp->amount, 0, ',', '.') }}</td>
                    <td style="font-size:11px;color:#64748b;">{{ $topUp->processedBy->name ?? 'Sistem' }}</td>
                    <td style="font-size:11px;color:#64748b;max-width:140px;">{{ $topUp->notes ?: '-' }}</td>
                    <td style="font-size:11px;color:#94a3b8;">{{ $topUp->created_at->format('d M Y H:i') }}</td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center;color:#94a3b8;padding:36px;font-size:13px;">Belum ada riwayat top up</td></tr>
                @endforelse
                </tbody>
            </table>
            @if($topUps->hasPages())
            <div style="padding:12px 16px;border-top:1.5px solid #f1f5f9;">{{ $topUps->links() }}</div>
            @endif
        </div>

    </div>

    <script>
    function setAmount(val){ document.getElementById('amountInput').value = val; }
    function updateBalance(sel){
        const opt = sel.options[sel.selectedIndex];
        const balInfo = document.getElementById('balanceInfo');
        if(opt.value){
            const bal = parseInt(opt.dataset.balance)||0;
            document.getElementById('currentBalance').textContent = 'Rp ' + bal.toLocaleString('id-ID');
            balInfo.style.display='block';
        } else { balInfo.style.display='none'; }
    }
    // init on load (for old input)
    window.addEventListener('DOMContentLoaded',()=>{ const s=document.getElementById('userSelect'); if(s.value) updateBalance(s); });
    </script>

</x-superadmin-layout>
