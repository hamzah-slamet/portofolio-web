{{-- resources/views/profile/edit.blade.php --}}

@extends('layouts.app')

@section('title', 'Edit Profil')
@section('topbar-title', 'Edit Profil')

@push('styles')
<style>
    /* ── Ikon monokrom seragam ───────────────────────────── */
    .pf-hd-ico {
        width: 34px; height: 34px; border-radius: 9px; flex-shrink: 0;
        display: inline-flex; align-items: center; justify-content: center;
        background: var(--blue-light, #eff6ff); color: var(--text-secondary, #475569);
        font-size: 1rem;
    }
    .pf-back {
        width: 34px; height: 34px; border-radius: 10px;
        border: 1px solid var(--card-border); background: var(--card-bg);
        display: flex; align-items: center; justify-content: center;
        color: var(--text-muted); text-decoration: none; transition: color .2s;
    }
    .pf-back:hover { color: var(--text-primary); }

    /* ── Kartu foto (sidebar kiri) ───────────────────────── */
    .pf-photo-card { text-align: center; position: sticky; top: 84px; }
    .pf-photo-img, .pf-photo-ph {
        width: 130px; height: 130px; border-radius: 24px; object-fit: cover;
        margin: 0 auto 16px; border: 1px solid var(--card-border);
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 8px 24px rgba(37,99,235,.12);
    }
    .pf-photo-ph { background: var(--blue-light, #eff6ff); color: var(--text-secondary); font-size: 3rem; font-weight: 800; }
    .pf-hint { font-size: .72rem; color: var(--text-muted); margin-top: 10px; }
    .pf-err  { font-size: .72rem; color: #dc2626; margin-top: 5px; }
    .pf-req  { color: #dc2626; }
</style>
@endpush

@section('page-header')
    <div class="d-flex align-items-center gap-3 flex-wrap">
        <a href="{{ route('profile.show') }}" class="pf-back"><i class="bi bi-arrow-left"></i></a>
        <div>
            <h4 class="mb-1" style="font-size:1.25rem; font-weight:800; color:var(--text-primary);">Edit Profil</h4>
            <p class="text-muted mb-0" style="font-size:.78rem;">Perbarui informasi akun Anda</p>
        </div>
    </div>
@endsection

@section('content')

<form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-4">

        {{-- ════════ KIRI: FOTO PROFIL ════════ --}}
        <div class="col-lg-4">
            <div class="admin-card pf-photo-card">
                @if($user->foto_profil)
                    <img id="foto-preview" src="{{ Storage::url($user->foto_profil) }}" alt="Preview" class="pf-photo-img">
                @else
                    <div id="foto-placeholder" class="pf-photo-ph">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                    <img id="foto-preview" src="#" alt="Preview" class="pf-photo-img" style="display:none;">
                @endif

                <label for="foto_profil" class="btn-admin-secondary w-100 justify-content-center" style="cursor:pointer;">
                    <i class="bi bi-upload"></i> Pilih Foto
                </label>
                <input type="file" id="foto_profil" name="foto_profil"
                       accept="image/jpg,image/jpeg,image/png,image/webp"
                       style="display:none;" onchange="previewFoto(event)">
                <div class="pf-hint">Format: JPG, PNG, WebP. Maks 2MB.</div>
                @error('foto_profil')<div class="pf-err">{{ $message }}</div>@enderror
            </div>
        </div>

        {{-- ════════ KANAN: FORM ════════ --}}
        <div class="col-lg-8">

            {{-- Akun --}}
            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <h6 class="admin-card-title d-flex align-items-center gap-2">
                        <span class="pf-hd-ico"><i class="bi bi-person-gear"></i></span> Akun
                    </h6>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="user_id" class="admin-form-label">User ID</label>
                        <input type="text" id="user_id" name="user_id" value="{{ old('user_id', $user->user_id) }}"
                               class="admin-form-control" placeholder="Contoh: USR-001">
                        @error('user_id')<div class="pf-err">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="name" class="admin-form-label">Nama Lengkap <span class="pf-req">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                               class="admin-form-control" placeholder="Nama lengkap Anda">
                        @error('name')<div class="pf-err">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="admin-form-label">Email <span class="pf-req">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                               class="admin-form-control" placeholder="email@contoh.com">
                        @error('email')<div class="pf-err">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="role" class="admin-form-label">Role</label>
                        <select id="role" name="role" class="admin-form-control">
                            <option value="user"   {{ old('role', $user->role) == 'user'   ? 'selected' : '' }}>User</option>
                            <option value="admin"  {{ old('role', $user->role) == 'admin'  ? 'selected' : '' }}>Admin</option>
                            <option value="editor" {{ old('role', $user->role) == 'editor' ? 'selected' : '' }}>Editor</option>
                        </select>
                        @error('role')<div class="pf-err">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="umur" class="admin-form-label">Umur</label>
                        <input type="number" id="umur" name="umur" min="1" max="120" value="{{ old('umur', $user->umur) }}"
                               class="admin-form-control" placeholder="Contoh: 25">
                        @error('umur')<div class="pf-err">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="status_akun" class="admin-form-label">Status Akun</label>
                        <select id="status_akun" name="status_akun" class="admin-form-control">
                            <option value="aktif"    {{ old('status_akun', $user->status_akun) == 'aktif'    ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ old('status_akun', $user->status_akun) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        @error('status_akun')<div class="pf-err">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            {{-- Data Pribadi --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <h6 class="admin-card-title d-flex align-items-center gap-2">
                        <span class="pf-hd-ico"><i class="bi bi-person-vcard"></i></span> Data Pribadi
                    </h6>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="tempat_lahir" class="admin-form-label">Tempat Lahir</label>
                        <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $user->tempat_lahir) }}"
                               class="admin-form-control" placeholder="Contoh: Bogor">
                        @error('tempat_lahir')<div class="pf-err">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="tanggal_lahir" class="admin-form-label">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                               value="{{ old('tanggal_lahir', $user->tanggal_lahir?->format('Y-m-d')) }}" class="admin-form-control">
                        @error('tanggal_lahir')<div class="pf-err">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="jenis_kelamin" class="admin-form-label">Jenis Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" class="admin-form-control">
                            <option value="">— Pilih —</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')<div class="pf-err">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="status_pernikahan" class="admin-form-label">Status Pernikahan</label>
                        <select id="status_pernikahan" name="status_pernikahan" class="admin-form-control">
                            <option value="">— Pilih —</option>
                            <option value="Belum Menikah" {{ old('status_pernikahan', $user->status_pernikahan) == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                            <option value="Menikah"       {{ old('status_pernikahan', $user->status_pernikahan) == 'Menikah'       ? 'selected' : '' }}>Menikah</option>
                            <option value="Cerai"         {{ old('status_pernikahan', $user->status_pernikahan) == 'Cerai'         ? 'selected' : '' }}>Cerai</option>
                        </select>
                        @error('status_pernikahan')<div class="pf-err">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="agama" class="admin-form-label">Agama</label>
                        <select id="agama" name="agama" class="admin-form-control">
                            <option value="">— Pilih —</option>
                            @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $ag)
                                <option value="{{ $ag }}" {{ old('agama', $user->agama) == $ag ? 'selected' : '' }}>{{ $ag }}</option>
                            @endforeach
                        </select>
                        @error('agama')<div class="pf-err">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="kewarganegaraan" class="admin-form-label">Kewarganegaraan</label>
                        <input type="text" id="kewarganegaraan" name="kewarganegaraan" value="{{ old('kewarganegaraan', $user->kewarganegaraan) }}"
                               class="admin-form-control" placeholder="Indonesia">
                        @error('kewarganegaraan')<div class="pf-err">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label for="alamat" class="admin-form-label">Alamat</label>
                        <textarea id="alamat" name="alamat" rows="3" class="admin-form-control"
                                  placeholder="Masukkan alamat lengkap Anda">{{ old('alamat', $user->alamat) }}</textarea>
                        @error('alamat')<div class="pf-err">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label for="tentang" class="admin-form-label">
                            Tentang Saya
                            <span class="text-muted" style="font-weight:500;">— tampil di section About halaman depan</span>
                        </label>
                        <textarea id="tentang" name="tentang" rows="4" class="admin-form-control"
                                  placeholder="Ceritakan sedikit tentang diri Anda, pengalaman, dan keahlian...">{{ old('tentang', $user->tentang) }}</textarea>
                        @error('tentang')<div class="pf-err">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ════════ TOMBOL ════════ --}}
    <div class="d-flex align-items-center justify-content-end gap-2 mt-4 mb-5">
        <a href="{{ route('profile.show') }}" class="btn-admin-secondary"><i class="bi bi-x-lg"></i> Batal</a>
        <button type="submit" class="btn-admin-primary"><i class="bi bi-check-lg"></i> Simpan Perubahan</button>
    </div>

</form>

@endsection

@push('scripts')
<script>
    function previewFoto(event) {
        const file = event.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('foto-preview');
            const placeholder = document.getElementById('foto-placeholder');
            preview.src = e.target.result;
            preview.style.display = 'block';
            if (placeholder) placeholder.style.display = 'none';
        };
        reader.readAsDataURL(file);
    }
</script>
@endpush
