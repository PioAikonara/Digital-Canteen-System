<x-superadmin-layout>
    <x-slot name="title">Tambah Petugas Kantin — Super Admin</x-slot>

    <style>
        .sa-card { background:#fff;border:1.5px solid #e2e8f0;border-radius:18px;overflow:hidden; }
        .sa-label { font-size:12px;font-weight:700;color:#374151;margin-bottom:5px;display:block; }
        .sa-input { width:100%;padding:9px 13px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;color:#334155;outline:none;background:#f8fafc;box-sizing:border-box;font-family:inherit;transition:border-color .15s; }
        .sa-input:focus { border-color:#7c3aed;background:#fff; }
        .sa-btn { display:inline-flex;align-items:center;gap:6px;padding:9px 20px;border-radius:10px;font-size:13px;font-weight:700;cursor:pointer;border:none; }
        .sa-error { font-size:11px;color:#dc2626;margin-top:3px; }
    </style>

    <div style="display:flex;align-items:center;gap:12px;margin-bottom:22px;">
        <a href="{{ route('superadmin.admins.index') }}"
           style="display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;background:#f1f5f9;border-radius:10px;color:#64748b;text-decoration:none;">
            <iconify-icon icon="solar:arrow-left-bold" style="font-size:16px;"></iconify-icon>
        </a>
        <div>
            <h1 style="font-size:20px;font-weight:900;color:#0f172a;margin:0 0 2px;">Tambah Petugas Kantin</h1>
            <p style="font-size:12px;color:#64748b;margin:0;">Buat akun baru untuk petugas / admin kantin</p>
        </div>
    </div>

    <div style="max-width:560px;">
        <div class="sa-card" style="padding:24px;">
            <form method="POST" action="{{ route('superadmin.admins.store') }}">
                @csrf
                <div style="display:grid;gap:16px;">
                    <div>
                        <label class="sa-label">Nama Kantin / Petugas <span style="color:#dc2626;">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" class="sa-input" placeholder="cth. Kantin Bu Sari" required>
                        @error('name')<p class="sa-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="sa-label">Email <span style="color:#dc2626;">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" class="sa-input" placeholder="petugas@example.com" required>
                        @error('email')<p class="sa-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="sa-label">Password <span style="color:#dc2626;">*</span></label>
                        <input type="password" name="password" class="sa-input" placeholder="Min. 8 karakter" required>
                        @error('password')<p class="sa-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="sa-label">Konfirmasi Password <span style="color:#dc2626;">*</span></label>
                        <input type="password" name="password_confirmation" class="sa-input" placeholder="Ulangi password" required>
                    </div>
                </div>
                <div style="margin-top:22px;display:flex;gap:10px;">
                    <button type="submit" class="sa-btn" style="background:linear-gradient(135deg,#1e1b4b,#7c3aed);color:#fff;">
                        <iconify-icon icon="solar:add-circle-bold" style="font-size:14px;"></iconify-icon> Simpan
                    </button>
                    <a href="{{ route('superadmin.admins.index') }}" class="sa-btn" style="background:#f1f5f9;color:#64748b;text-decoration:none;">Batal</a>
                </div>
            </form>
        </div>
    </div>

</x-superadmin-layout>
