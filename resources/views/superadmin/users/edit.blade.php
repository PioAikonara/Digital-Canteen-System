<x-superadmin-layout>
    <x-slot name="title">Edit Siswa — Super Admin</x-slot>

    <style>
        .form-card {
            background: #fff;
            border: 1px solid #e8edf5;
            border-radius: 20px;
            box-shadow: 0 4px 24px rgba(15,23,42,.06);
        }
        .field-group { display: flex; flex-direction: column; gap: 6px; }
        .field-label {
            font-size: 11.5px; font-weight: 700; color: #475569;
            text-transform: uppercase; letter-spacing: .07em;
            display: flex; align-items: center; gap: 6px;
        }
        .field-label span { font-size: 11px; font-weight: 500; color: #94a3b8; text-transform: none; letter-spacing: 0; }
        .field-input {
            width: 100%; padding: 11px 14px;
            border: 1.5px solid #e2e8f0; border-radius: 12px;
            font-size: 13.5px; color: #1e293b;
            outline: none; background: #f8fafc;
            font-family: 'Inter', sans-serif;
            transition: border-color .18s, background .18s, box-shadow .18s;
            box-sizing: border-box;
        }
        .field-input:focus {
            border-color: #7c3aed;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(124,58,237,.1);
        }
        .field-input.is-error { border-color: #f87171; background: #fff5f5; }
        .field-error { font-size: 11.5px; color: #ef4444; display: flex; align-items: center; gap: 4px; margin: 0; }
        .btn-primary {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 11px 24px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #fff; border-radius: 12px;
            font-size: 13.5px; font-weight: 700;
            border: none; cursor: pointer;
            box-shadow: 0 4px 14px rgba(124,58,237,.35);
            transition: box-shadow .18s, transform .15s;
            font-family: 'Inter', sans-serif;
        }
        .btn-primary:hover { box-shadow: 0 6px 20px rgba(124,58,237,.45); transform: translateY(-1px); }
        .btn-secondary {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 11px 20px;
            background: #f1f5f9; color: #64748b;
            border-radius: 12px; font-size: 13.5px; font-weight: 600;
            text-decoration: none; border: 1.5px solid #e2e8f0;
            transition: background .18s, color .18s;
        }
        .btn-secondary:hover { background: #e2e8f0; color: #334155; }
    </style>

    <div style="max-width: 600px; margin: 0 auto;">

        {{-- Header --}}
        <div style="margin-bottom: 24px;">
            <a href="{{ route('superadmin.users.index') }}"
               style="display:inline-flex;align-items:center;gap:5px;font-size:12px;font-weight:600;color:#7c3aed;text-decoration:none;margin-bottom:14px;opacity:.8;transition:opacity .15s;"
               onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=.8">
                <iconify-icon icon="solar:arrow-left-bold" style="font-size:13px;"></iconify-icon> Kembali
            </a>
            <div style="display:flex;align-items:center;gap:14px;">
                <div style="width:46px;height:46px;background:linear-gradient(135deg,#4f46e5,#7c3aed);border-radius:14px;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 12px rgba(124,58,237,.3);">
                    <iconify-icon icon="solar:pen-bold" style="font-size:22px;color:#fff;"></iconify-icon>
                </div>
                <div>
                    <h1 style="font-size:21px;font-weight:900;color:#0f172a;margin:0 0 3px;letter-spacing:-.02em;">Edit Akun Siswa</h1>
                    <p style="font-size:13px;color:#64748b;margin:0;">Perbarui data akun: <strong style="color:#1e293b;">{{ $user->name }}</strong></p>
                </div>
            </div>
        </div>

        {{-- Form Card --}}
        <div class="form-card" style="padding: 28px 28px 24px;">

            @if($errors->any())
            <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:12px;padding:12px 16px;margin-bottom:20px;display:flex;align-items:flex-start;gap:10px;">
                <iconify-icon icon="solar:danger-triangle-bold" style="font-size:18px;color:#ef4444;flex-shrink:0;margin-top:1px;"></iconify-icon>
                <div>
                    <div style="font-size:12px;font-weight:700;color:#dc2626;margin-bottom:4px;">Terdapat kesalahan:</div>
                    <ul style="margin:0;padding-left:16px;">
                        @foreach($errors->all() as $err)
                        <li style="font-size:12px;color:#ef4444;">{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <form method="POST" action="{{ route('superadmin.users.update', $user) }}" style="display:flex;flex-direction:column;gap:20px;">
                @csrf @method('PUT')

                {{-- Nama --}}
                <div class="field-group">
                    <label class="field-label">
                        <iconify-icon icon="solar:user-bold" style="font-size:13px;color:#7c3aed;"></iconify-icon>
                        Nama Lengkap
                    </label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                           class="field-input {{ $errors->has('name') ? 'is-error' : '' }}"
                           required placeholder="Nama siswa">
                    @error('name')
                    <p class="field-error"><iconify-icon icon="solar:close-circle-bold" style="font-size:13px;"></iconify-icon>{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="field-group">
                    <label class="field-label">
                        <iconify-icon icon="solar:letter-bold" style="font-size:13px;color:#7c3aed;"></iconify-icon>
                        Alamat Email
                    </label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                           class="field-input {{ $errors->has('email') ? 'is-error' : '' }}"
                           required placeholder="siswa@sekolah.id">
                    @error('email')
                    <p class="field-error"><iconify-icon icon="solar:close-circle-bold" style="font-size:13px;"></iconify-icon>{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password row --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                    <div class="field-group">
                        <label class="field-label">
                            <iconify-icon icon="solar:lock-password-bold" style="font-size:13px;color:#7c3aed;"></iconify-icon>
                            Password Baru
                            <span>(kosongkan jika tidak diubah)</span>
                        </label>
                        <input type="password" name="password"
                               class="field-input {{ $errors->has('password') ? 'is-error' : '' }}"
                               placeholder="Min. 8 karakter">
                        @error('password')
                        <p class="field-error"><iconify-icon icon="solar:close-circle-bold" style="font-size:13px;"></iconify-icon>{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="field-group">
                        <label class="field-label">
                            <iconify-icon icon="solar:lock-password-bold" style="font-size:13px;color:#7c3aed;"></iconify-icon>
                            Konfirmasi
                        </label>
                        <input type="password" name="password_confirmation"
                               class="field-input"
                               placeholder="Ulangi password baru">
                    </div>
                </div>

                {{-- Status aktif --}}
                <div>
                    <label class="field-label" style="margin-bottom:8px;">
                        <iconify-icon icon="solar:shield-check-bold" style="font-size:13px;color:#7c3aed;"></iconify-icon>
                        Status Akun
                    </label>
                    <label style="display:flex;align-items:center;gap:12px;padding:13px 16px;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:12px;cursor:pointer;transition:border-color .18s;"
                           onmouseover="this.style.borderColor='#c4b5fd'" onmouseout="this.style.borderColor='#e2e8f0'">
                        <input type="checkbox" name="is_active" id="is_active" value="1"
                               {{ old('is_active', $user->is_active ?? true) ? 'checked' : '' }}
                               style="width:17px;height:17px;accent-color:#7c3aed;cursor:pointer;flex-shrink:0;">
                        <div>
                            <div style="font-size:13px;font-weight:600;color:#1e293b;">Akun aktif</div>
                            <div style="font-size:11.5px;color:#94a3b8;">Siswa dapat login dan melakukan pemesanan</div>
                        </div>
                    </label>
                </div>

                {{-- Divider --}}
                <div style="height:1px;background:#f1f5f9;"></div>

                {{-- Actions --}}
                <div style="display:flex;gap:10px;align-items:center;">
                    <button type="submit" class="btn-primary">
                        <iconify-icon icon="solar:check-circle-bold" style="font-size:16px;"></iconify-icon>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('superadmin.users.index') }}" class="btn-secondary">
                        <iconify-icon icon="solar:close-circle-bold" style="font-size:15px;"></iconify-icon>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

</x-superadmin-layout>

