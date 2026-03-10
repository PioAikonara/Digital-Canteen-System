<x-superadmin-layout>
    <x-slot name="title">Kategori Menu — Super Admin</x-slot>

    <style>
        .sa-card { background:#fff;border:1.5px solid #e2e8f0;border-radius:18px;overflow:hidden; }
        .sa-label { font-size:12px;font-weight:700;color:#374151;margin-bottom:5px;display:block; }
        .sa-input { width:100%;padding:9px 13px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;color:#334155;outline:none;background:#f8fafc;box-sizing:border-box;font-family:inherit;transition:border-color .15s; }
        .sa-input:focus { border-color:#7c3aed;background:#fff; }
        .sa-btn-pri { display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:linear-gradient(135deg,#1e1b4b,#7c3aed);color:#fff;border-radius:10px;font-size:12px;font-weight:700;border:none;cursor:pointer;transition:opacity .15s; }
        .sa-btn-pri:hover { opacity:.88; }
        .sa-error { font-size:11px;color:#dc2626;margin-top:3px; }
        .cat-row { display:flex;align-items:center;gap:12px;padding:12px 16px;border-bottom:1px solid #f1f5f9; }
        .cat-row:last-child { border-bottom:none; }
        .cat-row:hover { background:#fafbff; }
        /* Modal */
        .modal-overlay { position:fixed;inset:0;background:rgba(15,23,42,.6);z-index:1000;display:none;align-items:center;justify-content:center; }
        .modal-overlay.open { display:flex; }
        .modal-box { background:#fff;border-radius:18px;padding:24px;width:380px;max-width:95vw; }
    </style>

    <div style="margin-bottom:22px;">
        <h1 style="font-size:20px;font-weight:900;color:#0f172a;margin:0 0 3px;">Kategori Menu</h1>
        <p style="font-size:13px;color:#64748b;margin:0;">Kelola kategori untuk menu kantin</p>
    </div>

    @if(session('success'))
    <div style="margin-bottom:16px;display:flex;align-items:center;gap:10px;padding:12px 16px;background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:13px;color:#166534;font-size:13px;font-weight:600;">
        <iconify-icon icon="solar:check-circle-bold" style="font-size:18px;"></iconify-icon>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div style="margin-bottom:16px;display:flex;align-items:center;gap:10px;padding:12px 16px;background:#fef2f2;border:1.5px solid #fecaca;border-radius:13px;color:#dc2626;font-size:13px;font-weight:600;">
        <iconify-icon icon="solar:close-circle-bold" style="font-size:18px;"></iconify-icon>
        {{ session('error') }}
    </div>
    @endif

    <div style="display:grid;grid-template-columns:360px 1fr;gap:20px;align-items:start;">

        {{-- TAMBAH KATEGORI --}}
        <div class="sa-card" style="padding:22px;">
            <div style="font-size:14px;font-weight:800;color:#1e293b;margin-bottom:18px;display:flex;align-items:center;gap:8px;">
                <iconify-icon icon="solar:add-circle-bold" style="font-size:18px;color:#7c3aed;"></iconify-icon>
                Tambah Kategori
            </div>
            <form method="POST" action="{{ route('superadmin.categories.store') }}">
                @csrf
                <div style="display:grid;gap:12px;">
                    <div>
                        <label class="sa-label">Nama Kategori <span style="color:#dc2626;">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" class="sa-input" placeholder="cth. Makanan Berat" required>
                        @error('name')<p class="sa-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="sa-label">Icon <span style="color:#94a3b8;font-weight:500;">(Iconify name, opsional)</span></label>
                        <input type="text" name="icon" value="{{ old('icon','solar:bowl-spoon-bold') }}" class="sa-input" placeholder="solar:bowl-spoon-bold">
                        @error('icon')<p class="sa-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="sa-label">Warna Aksen <span style="color:#94a3b8;font-weight:500;">(hex, opsional)</span></label>
                        <div style="display:flex;gap:8px;align-items:center;">
                            <input type="color" name="color" value="{{ old('color','#7c3aed') }}" style="width:42px;height:38px;border:1.5px solid #e2e8f0;border-radius:9px;cursor:pointer;padding:3px;background:#f8fafc;">
                            <input type="text" name="color_text" value="{{ old('color','#7c3aed') }}" class="sa-input" style="flex:1;" placeholder="#7c3aed"
                                   onchange="this.previousElementSibling.value=this.value" id="colorText">
                        </div>
                        @error('color')<p class="sa-error">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div style="margin-top:18px;">
                    <button type="submit" class="sa-btn-pri" style="width:100%;justify-content:center;">
                        <iconify-icon icon="solar:add-circle-bold" style="font-size:14px;"></iconify-icon> Tambah Kategori
                    </button>
                </div>
            </form>
        </div>

        {{-- DAFTAR KATEGORI --}}
        <div class="sa-card">
            <div style="padding:12px 16px;border-bottom:1.5px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
                <div style="font-size:13px;font-weight:800;color:#1e293b;">Daftar Kategori</div>
                <span style="font-size:12px;font-weight:700;color:#64748b;">{{ count($categories) }} kategori</span>
            </div>
            <div>
                @forelse($categories as $cat)
                <div class="cat-row">
                    <div style="width:40px;height:40px;border-radius:11px;background:{{ $cat->color ? $cat->color.'1a' : '#ede9fe' }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <iconify-icon icon="{{ $cat->icon ?: 'solar:bowl-spoon-bold' }}" style="font-size:20px;color:{{ $cat->color ?: '#7c3aed' }};"></iconify-icon>
                    </div>
                    <div style="flex:1;">
                        <div style="font-size:13px;font-weight:700;color:#1e293b;">{{ $cat->name }}</div>
                        <div style="font-size:11px;color:#94a3b8;margin-top:1px;">{{ $cat->menu_count }} menu</div>
                    </div>
                    <div style="display:inline-flex;gap:6px;">
                        <button type="button" onclick="openEditModal({{ $cat->id }}, '{{ addslashes($cat->name) }}', '{{ addslashes($cat->icon) }}', '{{ $cat->color }}')"
                                style="display:inline-flex;align-items:center;gap:4px;padding:5px 10px;background:#ede9fe;color:#7c3aed;border:none;border-radius:8px;font-size:11px;font-weight:700;cursor:pointer;">
                            <iconify-icon icon="solar:pen-bold" style="font-size:12px;"></iconify-icon> Edit
                        </button>
                        <form method="POST" action="{{ route('superadmin.categories.destroy', $cat) }}"
                              onsubmit="return confirm('Hapus kategori {{ $cat->name }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" style="display:inline-flex;align-items:center;gap:4px;padding:5px 10px;background:#fef2f2;color:#dc2626;border:none;border-radius:8px;font-size:11px;font-weight:700;cursor:pointer;">
                                <iconify-icon icon="solar:trash-bin-trash-bold" style="font-size:12px;"></iconify-icon> Hapus
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div style="text-align:center;color:#94a3b8;padding:36px;font-size:13px;">
                    Belum ada kategori — tambahkan lewat form di kiri
                </div>
                @endforelse
            </div>
        </div>

    </div>

    {{-- EDIT MODAL --}}
    <div class="modal-overlay" id="editModal">
        <div class="modal-box">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;">
                <div style="font-size:15px;font-weight:800;color:#1e293b;">Edit Kategori</div>
                <button onclick="closeEditModal()" style="background:none;border:none;cursor:pointer;color:#64748b;">
                    <iconify-icon icon="solar:close-circle-bold" style="font-size:20px;"></iconify-icon>
                </button>
            </div>
            <form method="POST" id="editForm" action="">
                @csrf @method('PUT')
                <div style="display:grid;gap:12px;">
                    <div>
                        <label class="sa-label">Nama Kategori <span style="color:#dc2626;">*</span></label>
                        <input type="text" name="name" id="editName" class="sa-input" required>
                    </div>
                    <div>
                        <label class="sa-label">Icon</label>
                        <input type="text" name="icon" id="editIcon" class="sa-input">
                    </div>
                    <div>
                        <label class="sa-label">Warna Aksen</label>
                        <div style="display:flex;gap:8px;align-items:center;">
                            <input type="color" id="editColorPicker" value="#7c3aed" style="width:42px;height:38px;border:1.5px solid #e2e8f0;border-radius:9px;cursor:pointer;padding:3px;background:#f8fafc;" oninput="document.getElementById('editColorText').value=this.value;document.getElementById('editColorHidden').value=this.value;">
                            <input type="text" id="editColorText" class="sa-input" style="flex:1;" oninput="document.getElementById('editColorPicker').value=this.value;document.getElementById('editColorHidden').value=this.value;">
                            <input type="hidden" name="color" id="editColorHidden">
                        </div>
                    </div>
                </div>
                <div style="margin-top:18px;display:flex;gap:10px;">
                    <button type="submit" class="sa-btn-pri">
                        <iconify-icon icon="solar:check-circle-bold" style="font-size:14px;"></iconify-icon> Simpan
                    </button>
                    <button type="button" onclick="closeEditModal()" style="padding:9px 18px;background:#f1f5f9;color:#64748b;border:none;border-radius:10px;font-size:12px;font-weight:700;cursor:pointer;">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function openEditModal(id, name, icon, color){
        document.getElementById('editForm').action = `/superadmin/categories/${id}`;
        document.getElementById('editName').value = name;
        document.getElementById('editIcon').value = icon;
        const c = color || '#7c3aed';
        document.getElementById('editColorPicker').value = c;
        document.getElementById('editColorText').value = c;
        document.getElementById('editColorHidden').value = c;
        document.getElementById('editModal').classList.add('open');
    }
    function closeEditModal(){ document.getElementById('editModal').classList.remove('open'); }
    document.getElementById('editModal').addEventListener('click',function(e){ if(e.target===this) closeEditModal(); });
    document.querySelector('input[type=color]')?.addEventListener('input',function(){ document.getElementById('colorText').value=this.value; });
    </script>

</x-superadmin-layout>
