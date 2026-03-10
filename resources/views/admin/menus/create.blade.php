<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Menu Baru') }}
        </h2>
    </x-slot>

    <style>
        :root {
            --primary:   #2D336B;
            --primary-light: #3a4285;
            --secondary: #7886C7;
            --accent:    #A9B5EB;
            --bg:        #F4F6FB;
            --border:    #E4E8F4;
            --text:      #1a1d2e;
            --muted:     #7a82a8;
        }
        .form-input {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 14px;
            color: var(--text);
            background: #fff;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
            font-family: 'Figtree', sans-serif;
        }
        .form-input:focus {
            border-color: var(--secondary);
            box-shadow: 0 0 0 3px rgba(120,134,199,.15);
        }
        .form-input.is-error { border-color: #ef4444; }
        .form-label {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 13px;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 7px;
        }
        .form-label iconify-icon { font-size: 15px; color: var(--secondary); }
        .section-card {
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 14px;
            padding: 24px;
            margin-bottom: 20px;
        }
        .section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            font-weight: 700;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: .8px;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid var(--bg);
        }
        .section-title iconify-icon { font-size: 17px; color: var(--secondary); }
        .badge-req {
            display: inline-flex;
            align-items: center;
            font-size: 10px;
            font-weight: 700;
            color: #ef4444;
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 100px;
            padding: 1px 7px;
            margin-left: 4px;
        }
        .cat-card {
            flex: 1;
            border: 2px solid var(--border);
            border-radius: 12px;
            padding: 14px 10px;
            text-align: center;
            cursor: pointer;
            transition: all .2s;
            background: #fff;
        }
        .cat-card:hover { border-color: var(--secondary); background: #f7f8fd; }
        .cat-card.selected { border-color: var(--primary); background: #eef0f9; }
        .cat-card iconify-icon { font-size: 28px; display: block; margin: 0 auto 6px; }
        .cat-card.selected iconify-icon { color: var(--primary); }
        .cat-card span { font-size: 13px; font-weight: 600; color: var(--text); }
        .upload-zone {
            border: 2px dashed var(--border);
            border-radius: 12px;
            padding: 30px 20px;
            text-align: center;
            cursor: pointer;
            transition: all .2s;
            background: var(--bg);
            position: relative;
        }
        .upload-zone:hover { border-color: var(--secondary); background: #f0f2fb; }
        .upload-zone.has-file { border-style: solid; border-color: var(--secondary); }
        .toggle-wrap {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--bg);
            border: 1.5px solid var(--border);
            border-radius: 12px;
            padding: 14px 18px;
        }
        .toggle-info { display: flex; align-items: center; gap: 10px; }
        .toggle-dot {
            width: 40px; height: 22px;
            background: #d1d5db;
            border-radius: 100px;
            position: relative;
            cursor: pointer;
            transition: background .2s;
            flex-shrink: 0;
        }
        .toggle-dot::after {
            content: '';
            width: 16px; height: 16px;
            background: #fff;
            border-radius: 50%;
            position: absolute;
            top: 3px; left: 3px;
            transition: left .2s;
            box-shadow: 0 1px 3px rgba(0,0,0,.2);
        }
        input[type="checkbox"].toggle-cb:checked + .toggle-dot { background: var(--primary); }
        input[type="checkbox"].toggle-cb:checked + .toggle-dot::after { left: 21px; }
        input[type="checkbox"].toggle-cb { display: none; }
        .field-hint { font-size: 12px; color: var(--muted); margin-top: 5px; }
        .error-msg { font-size: 12px; color: #ef4444; margin-top: 5px; display: flex; align-items: center; gap: 4px; }
        .price-wrapper { position: relative; }
        .price-prefix {
            position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
            font-size: 13px; font-weight: 700; color: var(--muted);
            pointer-events: none;
        }
        .price-wrapper .form-input { padding-left: 44px; }
    </style>

    <div style="background: var(--bg); min-height: 100vh; padding: 28px 24px;">

        <!-- Page Header -->
        <div style="max-width: 860px; margin: 0 auto 24px;">
            <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
                <div style="display:flex; align-items:center; gap:14px;">
                    <a href="{{ route('admin.menus.index') }}"
                       style="width:38px;height:38px;background:#fff;border:1.5px solid var(--border);border-radius:10px;display:flex;align-items:center;justify-content:center;color:var(--primary);text-decoration:none;transition:all .2s;"
                       onmouseover="this.style.background='var(--primary)';this.style.color='#fff'"
                       onmouseout="this.style.background='#fff';this.style.color='var(--primary)'">
                        <iconify-icon icon="solar:arrow-left-bold" style="font-size:16px;"></iconify-icon>
                    </a>
                    <div>
                        <h1 style="font-size:20px;font-weight:800;color:var(--primary);margin:0;line-height:1.2;">Tambah Menu Baru</h1>
                        <p style="font-size:13px;color:var(--muted);margin:3px 0 0;">Isi detail menu untuk ditampilkan ke pelanggan</p>
                    </div>
                </div>
                <div style="display:flex;align-items:center;gap:8px;background:#fff;border:1.5px solid var(--border);border-radius:10px;padding:8px 14px;">
                    <iconify-icon icon="solar:shop-bold" style="font-size:16px;color:var(--secondary);"></iconify-icon>
                    <span style="font-size:13px;font-weight:600;color:var(--primary);">{{ auth()->user()->name }}</span>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.menus.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="max-width:860px; margin:0 auto; display:grid; grid-template-columns:1fr 320px; gap:20px; align-items:start;">

            <!-- Left Column -->
            <div>

                <!-- Informasi Dasar -->
                <div class="section-card">
                    <div class="section-title">
                        <iconify-icon icon="solar:document-text-bold"></iconify-icon>
                        Informasi Dasar
                    </div>

                    <!-- Nama Menu -->
                    <div style="margin-bottom:18px;">
                        <label class="form-label" for="name">
                            <iconify-icon icon="solar:tag-bold"></iconify-icon>
                            Nama Menu <span class="badge-req">Wajib</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            placeholder="cth: Nasi Goreng Spesial"
                            class="form-input @error('name') is-error @enderror"
                            required>
                        @error('name')
                            <p class="error-msg"><iconify-icon icon="solar:danger-circle-bold"></iconify-icon>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kategori Visual Cards -->
                    <div style="margin-bottom:18px;">
                        <label class="form-label">
                            <iconify-icon icon="solar:widget-bold"></iconify-icon>
                            Kategori Menu <span class="badge-req">Wajib</span>
                        </label>
                        <input type="hidden" name="category" id="category_hidden" value="{{ old('category') }}" required>
                        <div style="display:flex; gap:12px;">
                            <div class="cat-card {{ old('category') === 'makanan' ? 'selected' : '' }}" onclick="selectCategory('makanan', this)">
                                <iconify-icon icon="solar:bowl-spoon-bold" style="color:{{ old('category') === 'makanan' ? 'var(--primary)' : 'var(--secondary)' }};"></iconify-icon>
                                <span>Makanan</span>
                            </div>
                            <div class="cat-card {{ old('category') === 'minuman' ? 'selected' : '' }}" onclick="selectCategory('minuman', this)">
                                <iconify-icon icon="solar:cup-hot-bold" style="color:{{ old('category') === 'minuman' ? 'var(--primary)' : 'var(--secondary)' }};"></iconify-icon>
                                <span>Minuman</span>
                            </div>
                        </div>
                        @error('category')
                            <p class="error-msg"><iconify-icon icon="solar:danger-circle-bold"></iconify-icon>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="form-label" for="description">
                            <iconify-icon icon="solar:notes-bold"></iconify-icon>
                            Deskripsi Menu
                            <span style="font-size:11px;font-weight:500;color:var(--muted);margin-left:4px;">(opsional)</span>
                        </label>
                        <textarea name="description" id="description" rows="4"
                            placeholder="Tambahkan deskripsi singkat tentang menu ini..."
                            class="form-input @error('description') is-error @enderror"
                            style="resize:vertical;">{{ old('description') }}</textarea>
                        <p class="field-hint">Deskripsi ditampilkan ke pelanggan sebagai informasi tambahan.</p>
                        @error('description')
                            <p class="error-msg"><iconify-icon icon="solar:danger-circle-bold"></iconify-icon>{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Harga & Stok -->
                <div class="section-card">
                    <div class="section-title">
                        <iconify-icon icon="solar:wallet-money-bold"></iconify-icon>
                        Harga & Stok
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                        <!-- Harga -->
                        <div>
                            <label class="form-label" for="price">
                                <iconify-icon icon="solar:tag-price-bold"></iconify-icon>
                                Harga <span class="badge-req">Wajib</span>
                            </label>
                            <div class="price-wrapper">
                                <span class="price-prefix">Rp</span>
                                <input type="number" name="price" id="price" value="{{ old('price') }}" min="0" step="1"
                                    placeholder="0"
                                    class="form-input @error('price') is-error @enderror"
                                    required>
                            </div>
                            @error('price')
                                <p class="error-msg"><iconify-icon icon="solar:danger-circle-bold"></iconify-icon>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Stok -->
                        <div>
                            <label class="form-label" for="stock">
                                <iconify-icon icon="solar:box-bold"></iconify-icon>
                                Stok Porsi <span class="badge-req">Wajib</span>
                            </label>
                            <div style="display:flex; align-items:center; gap:0;">
                                <button type="button" onclick="changeStock(-1)"
                                    style="width:40px;height:42px;background:var(--bg);border:1.5px solid var(--border);border-right:none;border-radius:10px 0 0 10px;font-size:18px;font-weight:700;color:var(--primary);cursor:pointer;flex-shrink:0;transition:background .15s;"
                                    onmouseover="this.style.background='#e4e7f3'" onmouseout="this.style.background='var(--bg)'">−</button>
                                <input type="number" name="stock" id="stock" value="{{ old('stock', 0) }}" min="0"
                                    class="form-input @error('stock') is-error @enderror"
                                    style="border-radius:0;text-align:center;flex:1;"
                                    required>
                                <button type="button" onclick="changeStock(1)"
                                    style="width:40px;height:42px;background:var(--bg);border:1.5px solid var(--border);border-left:none;border-radius:0 10px 10px 0;font-size:18px;font-weight:700;color:var(--primary);cursor:pointer;flex-shrink:0;transition:background .15s;"
                                    onmouseover="this.style.background='#e4e7f3'" onmouseout="this.style.background='var(--bg)'">+</button>
                            </div>
                            <p class="field-hint">Jumlah porsi yang tersedia untuk dijual.</p>
                            @error('stock')
                                <p class="error-msg"><iconify-icon icon="solar:danger-circle-bold"></iconify-icon>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column -->
            <div>

                <!-- Foto Menu -->
                <div class="section-card">
                    <div class="section-title">
                        <iconify-icon icon="solar:gallery-bold"></iconify-icon>
                        Foto Menu
                    </div>

                    <div class="upload-zone" id="uploadZone" onclick="document.getElementById('photo').click()">
                        <div id="uploadPlaceholder">
                            <iconify-icon icon="solar:cloud-upload-bold" style="font-size:36px;color:var(--secondary);display:block;margin:0 auto 10px;"></iconify-icon>
                            <p style="font-size:13px;font-weight:600;color:var(--primary);margin:0 0 4px;">Klik untuk unggah foto</p>
                            <p style="font-size:12px;color:var(--muted);margin:0;">PNG, JPG, WEBP maks. 2MB</p>
                        </div>
                        <div id="imagePreview" style="display:none;">
                            <img id="previewImg" src="" alt="Preview" style="width:100%;max-height:200px;object-fit:cover;border-radius:8px;display:block;">
                            <p style="font-size:12px;color:var(--muted);margin:8px 0 0;text-align:center;" id="fileName"></p>
                        </div>
                    </div>
                    <input type="file" name="photo" id="photo" accept="image/*" style="display:none;" onchange="previewImage(event)">
                    @error('photo')
                        <p class="error-msg" style="margin-top:8px;"><iconify-icon icon="solar:danger-circle-bold"></iconify-icon>{{ $message }}</p>
                    @enderror

                    <button type="button" id="removePhotoBtn" onclick="removePhoto()" style="display:none;width:100%;margin-top:10px;padding:8px;background:#fef2f2;border:1.5px solid #fecaca;border-radius:8px;font-size:12px;font-weight:600;color:#ef4444;cursor:pointer;transition:all .15s;">
                        <iconify-icon icon="solar:trash-bin-trash-bold" style="font-size:14px;vertical-align:-2px;"></iconify-icon>
                        Hapus Foto
                    </button>
                </div>

                <!-- Status & Aksi -->
                <div class="section-card">
                    <div class="section-title">
                        <iconify-icon icon="solar:settings-bold"></iconify-icon>
                        Pengaturan
                    </div>

                    <!-- Toggle Ketersediaan -->
                    <div class="toggle-wrap" style="margin-bottom:20px;">
                        <div class="toggle-info">
                            <iconify-icon icon="solar:check-circle-bold" style="font-size:22px;color:var(--secondary);"></iconify-icon>
                            <div>
                                <p style="font-size:13px;font-weight:600;color:var(--text);margin:0;">Menu Tersedia</p>
                                <p style="font-size:11px;color:var(--muted);margin:2px 0 0;">Tampilkan ke pelanggan</p>
                            </div>
                        </div>
                        <label style="display:flex;align-items:center;">
                            <input type="checkbox" name="is_available" value="1" class="toggle-cb" id="isAvailableToggle"
                                {{ old('is_available', true) ? 'checked' : '' }}>
                            <div class="toggle-dot"></div>
                        </label>
                    </div>

                    <!-- Summary Box -->
                    <div style="background:var(--bg);border:1.5px solid var(--border);border-radius:10px;padding:14px;">
                        <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:var(--muted);margin:0 0 10px;">Ringkasan</p>
                        <div style="display:flex;flex-direction:column;gap:8px;">
                            <div style="display:flex;justify-content:space-between;font-size:12px;">
                                <span style="color:var(--muted);">Nama</span>
                                <span style="font-weight:600;color:var(--text);text-align:right;max-width:140px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" id="summaryName">—</span>
                            </div>
                            <div style="display:flex;justify-content:space-between;font-size:12px;">
                                <span style="color:var(--muted);">Kategori</span>
                                <span style="font-weight:600;color:var(--text);" id="summaryCategory">—</span>
                            </div>
                            <div style="display:flex;justify-content:space-between;font-size:12px;">
                                <span style="color:var(--muted);">Harga</span>
                                <span style="font-weight:600;color:var(--primary);" id="summaryPrice">—</span>
                            </div>
                            <div style="display:flex;justify-content:space-between;font-size:12px;">
                                <span style="color:var(--muted);">Stok</span>
                                <span style="font-weight:600;color:var(--text);" id="summaryStock">—</span>
                            </div>
                        </div>
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                        style="margin-top:16px;width:100%;padding:13px;background:var(--primary);color:#fff;border:none;border-radius:10px;font-size:14px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:background .2s;"
                        onmouseover="this.style.background='var(--primary-light)'" onmouseout="this.style.background='var(--primary)'">
                        <iconify-icon icon="solar:diskette-bold" style="font-size:18px;"></iconify-icon>
                        Simpan Menu
                    </button>
                    <a href="{{ route('admin.menus.index') }}"
                        style="margin-top:10px;width:100%;padding:11px;background:#fff;color:var(--muted);border:1.5px solid var(--border);border-radius:10px;font-size:13px;font-weight:600;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;text-decoration:none;transition:all .2s;"
                        onmouseover="this.style.background='var(--bg)'" onmouseout="this.style.background='#fff'">
                        <iconify-icon icon="solar:close-circle-bold" style="font-size:16px;"></iconify-icon>
                        Batal
                    </a>
                </div>

            </div>
        </div>
        </form>
    </div>

    <script>
        // Category select
        function selectCategory(value, el) {
            document.querySelectorAll('.cat-card').forEach(c => {
                c.classList.remove('selected');
                c.querySelector('iconify-icon').style.color = 'var(--secondary)';
            });
            el.classList.add('selected');
            el.querySelector('iconify-icon').style.color = 'var(--primary)';
            document.getElementById('category_hidden').value = value;
            updateSummary();
        }

        // Stock stepper
        function changeStock(delta) {
            const inp = document.getElementById('stock');
            const val = Math.max(0, (parseInt(inp.value) || 0) + delta);
            inp.value = val;
            updateSummary();
        }

        // Image preview
        function previewImage(event) {
            const file = event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImg').src = e.target.result;
                document.getElementById('fileName').textContent = file.name;
                document.getElementById('uploadPlaceholder').style.display = 'none';
                document.getElementById('imagePreview').style.display = 'block';
                document.getElementById('uploadZone').classList.add('has-file');
                document.getElementById('removePhotoBtn').style.display = 'block';
            };
            reader.readAsDataURL(file);
        }

        function removePhoto() {
            document.getElementById('photo').value = '';
            document.getElementById('previewImg').src = '';
            document.getElementById('fileName').textContent = '';
            document.getElementById('uploadPlaceholder').style.display = 'block';
            document.getElementById('imagePreview').style.display = 'none';
            document.getElementById('uploadZone').classList.remove('has-file');
            document.getElementById('removePhotoBtn').style.display = 'none';
        }

        // Live summary
        function updateSummary() {
            const name  = document.getElementById('name').value.trim();
            const cat   = document.getElementById('category_hidden').value;
            const price = parseInt(document.getElementById('price').value) || 0;
            const stock = parseInt(document.getElementById('stock').value) || 0;

            document.getElementById('summaryName').textContent     = name  || '—';
            document.getElementById('summaryCategory').textContent = cat ? (cat.charAt(0).toUpperCase() + cat.slice(1)) : '—';
            document.getElementById('summaryPrice').textContent    = price ? 'Rp ' + price.toLocaleString('id-ID') : '—';
            document.getElementById('summaryStock').textContent    = stock + ' porsi';
        }

        document.getElementById('name').addEventListener('input', updateSummary);
        document.getElementById('price').addEventListener('input', updateSummary);
        document.getElementById('stock').addEventListener('input', updateSummary);

        // Init summary from old() values
        updateSummary();
    </script>
</x-admin-layout>
