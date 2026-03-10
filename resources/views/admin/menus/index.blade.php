<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Menu') }}
        </h2>
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

        .search-input {
            padding: 9px 14px 9px 38px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 13px;
            color: var(--text);
            background: #fff;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
            width: 260px;
            font-family: 'Figtree', sans-serif;
        }
        .search-input:focus { border-color: var(--secondary); box-shadow: 0 0 0 3px rgba(120,134,199,.15); }

        .menu-table { width: 100%; border-collapse: collapse; }
        .menu-table thead tr {
            background: var(--bg);
            border-bottom: 2px solid var(--border);
        }
        .menu-table thead th {
            padding: 11px 16px;
            text-align: left;
            font-size: 11px;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .7px;
            white-space: nowrap;
        }
        .menu-table tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background .15s;
        }
        .menu-table tbody tr:last-child { border-bottom: none; }
        .menu-table tbody tr:hover { background: #fafbff; }
        .menu-table tbody td { padding: 14px 16px; vertical-align: middle; }

        .badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 3px 10px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 700;
        }
        .badge-makanan { background: #fff3e0; color: #b45309; border: 1px solid #fed7aa; }
        .badge-minuman { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
        .badge-tersedia { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
        .badge-habis    { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }

        .stok-ok      { color: #15803d; font-weight: 700; }
        .stok-warn    { color: #b45309; font-weight: 700; }
        .stok-empty   { color: #b91c1c; font-weight: 700; }

        .action-btn {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all .15s;
            border: 1.5px solid transparent;
            cursor: pointer;
        }
        .action-edit {
            background: #eef0f9;
            color: var(--primary);
            border-color: var(--border);
        }
        .action-edit:hover { background: var(--primary); color: #fff; border-color: var(--primary); }
        .action-delete {
            background: #fef2f2;
            color: #b91c1c;
            border-color: #fecaca;
        }
        .action-delete:hover { background: #b91c1c; color: #fff; border-color: #b91c1c; }

        .photo-thumb {
            width: 54px; height: 54px;
            border-radius: 10px;
            object-fit: cover;
            border: 1.5px solid var(--border);
        }
        .photo-placeholder {
            width: 54px; height: 54px;
            border-radius: 10px;
            background: var(--bg);
            border: 1.5px solid var(--border);
            display: flex; align-items: center; justify-content: center;
        }

        /* stat chips */
        .stat-chip {
            display: flex; align-items: center; gap: 8px;
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 12px;
            padding: 12px 18px;
        }
        .stat-chip-icon {
            width: 36px; height: 36px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
    </style>

    <div style="background: var(--bg); min-height: 100vh; padding: 28px 24px;">

        <!-- Page Header -->
        <div style="max-width: 1100px; margin: 0 auto 20px;">
            <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
                <div>
                    <h1 style="font-size:20px;font-weight:800;color:var(--primary);margin:0;line-height:1.2;">Kelola Menu</h1>
                    <p style="font-size:13px;color:var(--muted);margin:3px 0 0;">Daftar semua menu kantin Anda</p>
                </div>
                <a href="{{ route('admin.menus.create') }}"
                   style="display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:var(--primary);color:#fff;border-radius:10px;font-size:13px;font-weight:700;text-decoration:none;transition:background .2s;"
                   onmouseover="this.style.background='var(--primary-light)'" onmouseout="this.style.background='var(--primary)'">
                    <iconify-icon icon="solar:add-circle-bold" style="font-size:18px;"></iconify-icon>
                    Tambah Menu
                </a>
            </div>
        </div>

        <!-- Stat chips -->
        <div style="max-width:1100px; margin:0 auto 20px; display:flex; gap:12px; flex-wrap:wrap;">
            @php
                $totalMenu    = $menus->total();
                $tersedia     = $menus->getCollection()->where('is_available', true)->count();
                $habis        = $menus->getCollection()->where('is_available', false)->count();
                $stokRendah   = $menus->getCollection()->where('stock', '<=', 5)->where('stock', '>', 0)->count();
            @endphp
            <div class="stat-chip">
                <div class="stat-chip-icon" style="background:#eef0f9;">
                    <iconify-icon icon="solar:book-bold" style="font-size:18px;color:var(--primary);"></iconify-icon>
                </div>
                <div>
                    <div style="font-size:18px;font-weight:800;color:var(--primary);line-height:1;">{{ $totalMenu }}</div>
                    <div style="font-size:11px;color:var(--muted);margin-top:1px;">Total Menu</div>
                </div>
            </div>
            <div class="stat-chip">
                <div class="stat-chip-icon" style="background:#f0fdf4;">
                    <iconify-icon icon="solar:check-circle-bold" style="font-size:18px;color:#15803d;"></iconify-icon>
                </div>
                <div>
                    <div style="font-size:18px;font-weight:800;color:#15803d;line-height:1;">{{ $tersedia }}</div>
                    <div style="font-size:11px;color:var(--muted);margin-top:1px;">Tersedia</div>
                </div>
            </div>
            <div class="stat-chip">
                <div class="stat-chip-icon" style="background:#fef2f2;">
                    <iconify-icon icon="solar:close-circle-bold" style="font-size:18px;color:#b91c1c;"></iconify-icon>
                </div>
                <div>
                    <div style="font-size:18px;font-weight:800;color:#b91c1c;line-height:1;">{{ $habis }}</div>
                    <div style="font-size:11px;color:var(--muted);margin-top:1px;">Habis</div>
                </div>
            </div>
            <div class="stat-chip">
                <div class="stat-chip-icon" style="background:#fffbeb;">
                    <iconify-icon icon="solar:danger-triangle-bold" style="font-size:18px;color:#b45309;"></iconify-icon>
                </div>
                <div>
                    <div style="font-size:18px;font-weight:800;color:#b45309;line-height:1;">{{ $stokRendah }}</div>
                    <div style="font-size:11px;color:var(--muted);margin-top:1px;">Stok Rendah</div>
                </div>
            </div>
        </div>

        <!-- Main card -->
        <div style="max-width:1100px; margin:0 auto; background:#fff; border:1.5px solid var(--border); border-radius:16px; overflow:hidden;">

            <!-- Toolbar -->
            <div style="padding:16px 20px; border-bottom:1.5px solid var(--border); display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
                <form method="GET" action="{{ route('admin.menus.index') }}" style="display:flex;align-items:center;gap:8px;flex:1;min-width:200px;">
                    <div style="position:relative;flex:1;max-width:300px;">
                        <iconify-icon icon="solar:magnifer-bold" style="position:absolute;left:11px;top:50%;transform:translateY(-50%);font-size:15px;color:var(--muted);pointer-events:none;"></iconify-icon>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Cari nama menu..."
                               class="search-input">
                    </div>
                    <button type="submit"
                        style="padding:9px 16px;background:var(--primary);color:#fff;border:none;border-radius:10px;font-size:13px;font-weight:600;cursor:pointer;transition:background .2s;"
                        onmouseover="this.style.background='var(--primary-light)'" onmouseout="this.style.background='var(--primary)'">
                        Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.menus.index') }}"
                           style="padding:9px 14px;background:var(--bg);color:var(--muted);border:1.5px solid var(--border);border-radius:10px;font-size:13px;font-weight:600;text-decoration:none;transition:all .15s;"
                           onmouseover="this.style.background='#e4e7f3'" onmouseout="this.style.background='var(--bg)'">
                            Reset
                        </a>
                    @endif
                </form>

                @if(request('search'))
                    <div style="font-size:12px;color:var(--muted);background:var(--bg);border:1.5px solid var(--border);border-radius:8px;padding:6px 12px;">
                        Hasil pencarian: <strong style="color:var(--primary);">"{{ request('search') }}"</strong>
                    </div>
                @endif
            </div>

            @if(session('success'))
            <div style="margin:16px 20px 0;background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:10px;padding:12px 16px;display:flex;align-items:center;gap:10px;">
                <iconify-icon icon="solar:check-circle-bold" style="font-size:18px;color:#15803d;flex-shrink:0;"></iconify-icon>
                <span style="font-size:13px;font-weight:600;color:#15803d;">{{ session('success') }}</span>
            </div>
            @endif

            <!-- Table -->
            <div style="overflow-x:auto;">
                <table class="menu-table">
                    <thead>
                        <tr>
                            <th style="width:72px;">Foto</th>
                            <th>Nama Menu</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th style="text-align:right; padding-right:20px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($menus as $menu)
                        <tr>
                            <!-- Foto -->
                            <td>
                                @if($menu->photo)
                                    <img src="{{ asset('storage/' . $menu->photo) }}" alt="{{ $menu->name }}" class="photo-thumb">
                                @else
                                    <div class="photo-placeholder">
                                        <iconify-icon icon="solar:gallery-bold" style="font-size:20px;color:var(--accent);"></iconify-icon>
                                    </div>
                                @endif
                            </td>

                            <!-- Nama -->
                            <td>
                                <div style="font-size:14px;font-weight:700;color:var(--text);">{{ $menu->name }}</div>
                                @if($menu->description)
                                    <div style="font-size:12px;color:var(--muted);margin-top:2px;">{{ Str::limit($menu->description, 55) }}</div>
                                @endif
                            </td>

                            <!-- Kategori -->
                            <td>
                                @if($menu->category === 'makanan')
                                    <span class="badge badge-makanan">
                                        <iconify-icon icon="solar:bowl-spoon-bold" style="font-size:12px;"></iconify-icon>
                                        Makanan
                                    </span>
                                @else
                                    <span class="badge badge-minuman">
                                        <iconify-icon icon="solar:cup-hot-bold" style="font-size:12px;"></iconify-icon>
                                        Minuman
                                    </span>
                                @endif
                            </td>

                            <!-- Harga -->
                            <td>
                                <div style="font-size:14px;font-weight:700;color:var(--primary);">
                                    Rp {{ number_format($menu->price, 0, ',', '.') }}
                                </div>
                            </td>

                            <!-- Stok -->
                            <td>
                                <div class="{{ $menu->stock <= 0 ? 'stok-empty' : ($menu->stock <= 5 ? 'stok-warn' : 'stok-ok') }}" style="font-size:14px;">
                                    {{ $menu->stock }} porsi
                                </div>
                                @if($menu->stock <= 0)
                                    <div style="font-size:11px;color:#b91c1c;margin-top:1px;">Stok habis</div>
                                @elseif($menu->stock <= 5)
                                    <div style="font-size:11px;color:#b45309;margin-top:1px;">Stok rendah</div>
                                @else
                                    <div style="font-size:11px;color:var(--muted);margin-top:1px;">Tersedia</div>
                                @endif
                            </td>

                            <!-- Status -->
                            <td>
                                @if($menu->is_available)
                                    <span class="badge badge-tersedia">
                                        <iconify-icon icon="solar:check-circle-bold" style="font-size:12px;"></iconify-icon>
                                        Tersedia
                                    </span>
                                @else
                                    <span class="badge badge-habis">
                                        <iconify-icon icon="solar:close-circle-bold" style="font-size:12px;"></iconify-icon>
                                        Habis
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td style="text-align:right;">
                                <div style="display:inline-flex;align-items:center;gap:8px;">
                                    <a href="{{ route('admin.menus.edit', $menu) }}" class="action-btn action-edit">
                                        <iconify-icon icon="solar:pen-bold" style="font-size:13px;"></iconify-icon>
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST" style="display:inline;"
                                          onsubmit="return confirmDelete('{{ $menu->name }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn action-delete">
                                            <iconify-icon icon="solar:trash-bin-trash-bold" style="font-size:13px;"></iconify-icon>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" style="padding:60px 20px;text-align:center;">
                                <iconify-icon icon="solar:bowl-spoon-bold" style="font-size:48px;color:var(--accent);display:block;margin:0 auto 12px;"></iconify-icon>
                                <p style="font-size:15px;font-weight:700;color:var(--primary);margin:0 0 4px;">Belum ada menu</p>
                                <p style="font-size:13px;color:var(--muted);margin:0 0 18px;">Mulai tambahkan menu pertama untuk kantinmu</p>
                                <a href="{{ route('admin.menus.create') }}"
                                   style="display:inline-flex;align-items:center;gap:7px;padding:10px 20px;background:var(--primary);color:#fff;border-radius:10px;font-size:13px;font-weight:700;text-decoration:none;">
                                    <iconify-icon icon="solar:add-circle-bold" style="font-size:16px;"></iconify-icon>
                                    Tambah Menu Pertama
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($menus->hasPages())
            <div style="padding:16px 20px;border-top:1.5px solid var(--border);display:flex;justify-content:flex-end;">
                {{ $menus->links() }}
            </div>
            @endif

        </div>
    </div>

    <!-- Delete confirmation modal -->
    <div id="deleteModal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.45);backdrop-filter:blur(3px);align-items:center;justify-content:center;">
        <div style="background:#fff;border-radius:16px;padding:28px;max-width:380px;width:90%;box-shadow:0 20px 60px rgba(0,0,0,.2);text-align:center;">
            <div style="width:56px;height:56px;background:#fef2f2;border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                <iconify-icon icon="solar:trash-bin-trash-bold" style="font-size:28px;color:#ef4444;"></iconify-icon>
            </div>
            <h3 style="font-size:16px;font-weight:800;color:var(--text);margin:0 0 8px;">Hapus Menu?</h3>
            <p style="font-size:13px;color:var(--muted);margin:0 0 20px;">Menu <strong id="deleteMenuName" style="color:var(--primary);"></strong> akan dihapus permanen dan tidak bisa dikembalikan.</p>
            <div style="display:flex;gap:10px;justify-content:center;">
                <button onclick="cancelDelete()"
                    style="flex:1;padding:10px;background:var(--bg);color:var(--muted);border:1.5px solid var(--border);border-radius:10px;font-size:13px;font-weight:600;cursor:pointer;">
                    Batal
                </button>
                <button id="confirmDeleteBtn"
                    style="flex:1;padding:10px;background:#ef4444;color:#fff;border:none;border-radius:10px;font-size:13px;font-weight:700;cursor:pointer;">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>

    <script>
        let pendingDeleteForm = null;

        function confirmDelete(menuName) {
            document.getElementById('deleteMenuName').textContent = menuName;
            document.getElementById('deleteModal').style.display = 'flex';
            // find the form from the calling button's parent
            return false;
        }

        // Override form submissions to go through modal
        document.querySelectorAll('form[onsubmit]').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                pendingDeleteForm = this;
                const nameEl = document.getElementById('deleteMenuName');
                // name already set by confirmDelete call via onsubmit attr returning false
            });
        });

        // Better: attach directly via data attribute
        document.querySelectorAll('.menu-table tbody form').forEach(form => {
            form.onsubmit = function(e) {
                e.preventDefault();
                pendingDeleteForm = this;
                const row = this.closest('tr');
                const name = row.querySelector('td:nth-child(2) div').textContent.trim();
                document.getElementById('deleteMenuName').textContent = name;
                document.getElementById('deleteModal').style.display = 'flex';
                return false;
            };
        });

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (pendingDeleteForm) {
                pendingDeleteForm.onsubmit = null;
                pendingDeleteForm.submit();
            }
        });

        function cancelDelete() {
            document.getElementById('deleteModal').style.display = 'none';
            pendingDeleteForm = null;
        }

        // Close modal on backdrop click
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) cancelDelete();
        });
    </script>

</x-admin-layout>
