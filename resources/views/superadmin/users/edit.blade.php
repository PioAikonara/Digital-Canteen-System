<x-superadmin-layout>
    <x-slot name="title">Edit Siswa — Super Admin</x-slot>

    <style>
        .sa-card { background:#fff;border:1.5px solid #e2e8f0;border-radius:18px;overflow:hidden; }
        .sa-input { width:100%;padding:10px 13px;border:1.5px solid #e2e8f0;border-radius:11px;font-size:13px;color:#334155;outline:none;background:#f8fafc;font-family:inherit;transition:border-color .15s;box-sizing:border-box; }
        .sa-input:focus { border-color:#7c3aed;background:#fff; }
        .sa-label { font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.05em;margin-bottom:6px;display:block; }
        .sa-btn-pri { display:inline-flex;align-items:center;gap:6px;padding:10px 22px;background:linear-gradient(135deg,#1e1b4b,#7c3aed);color:#fff;border-radius:11px;font-size:13px;font-weight:700;text-decoration:none;border:none;cursor:pointer;transition:opacity .15s; }
        .sa-btn-pri:hover { opacity:.88; }
    </style>

    <div style="max-width:580px;">
        <div style="margin-bottom:22px;">
            <a href="{{ route('superadmin.users.index') }}"
               style="display:inline-flex;align-items:center;gap:6px;font-size:12px;font-weight:700;color:#7c3aed;text-decoration:none;margin-bottom:12px;">
                <iconify-icon icon="solar:arrow-left-bold" style="font-size:13px;"></iconify-icon> Kembali
            </a>
            <h1 style="font-size:20px;font-weight:900;color:#0f172a;margin:0 0 3px;">Edit Akun Siswa</h1>
            <p style="font-size:13px;color:#64748b;margin:0;">Perbarui data akun: <strong>{{ $user->name }}</strong></p>
        </div>

        <div class="sa-card" style="padding:24px;">
            <form method="POST" action="{{ route('superadmin.users.update', $user) }}" style="display:flex;flex-direction:column;gap:18px;">
                @csrf @method('PUT')
                <div>
                    <label class="sa-label">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="sa-input" required>
                    @error('name')<p style="font-size:11px;color:#dc2626;margin-top:4px;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="sa-label">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="sa-input" required>
                    @error('email')<p style="font-size:11px;color:#dc2626;margin-top:4px;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="sa-label">Password Baru <span style="font-weight:400;text-transform:none;font-size:10px;">(kosongkan jika tidak diubah)</span></label>
                    <input type="password" name="password" class="sa-input" placeholder="Minimal 8 karakter">
                    @error('password')<p style="font-size:11px;color:#dc2626;margin-top:4px;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="sa-label">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="sa-input">
                </div>
                <div style="display:flex;align-items:center;gap:10px;padding:12px 14px;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:12px;">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $user->is_active ?? true) ? 'checked' : '' }}
                           style="width:16px;height:16px;accent-color:#7c3aed;cursor:pointer;">
                    <label for="is_active" style="font-size:13px;font-weight:600;color:#334155;cursor:pointer;">Akun aktif</label>
                </div>
                <div style="display:flex;gap:10px;padding-top:4px;">
                    <button type="submit" class="sa-btn-pri">
                        <iconify-icon icon="solar:check-circle-bold" style="font-size:14px;"></iconify-icon>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('superadmin.users.index') }}"
                       style="display:inline-flex;align-items:center;padding:10px 20px;background:#f1f5f9;color:#64748b;border-radius:11px;font-size:13px;font-weight:700;text-decoration:none;">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

</x-superadmin-layout>
