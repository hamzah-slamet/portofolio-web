{{-- resources/views/profile/edit.blade.php --}}

@extends('layouts.app')

@section('title', 'Edit Profil')
@section('topbar-title', 'Edit Profil')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/profile/profile-style.css') }}">
@endpush

@section('page-header')
    <div class="d-flex align-items-center gap-3 flex-wrap">
        <a href="{{ route('profile.show') }}"
           style="width:34px; height:34px; border-radius:10px; border:1px solid var(--card-border);
                  background:var(--card-bg); display:flex; align-items:center; justify-content:center;
                  color:var(--text-muted); text-decoration:none; transition:color .2s;"
           onmouseover="this.style.color='var(--text-primary)'"
           onmouseout="this.style.color='var(--text-muted)'">
            <i class="bi bi-arrow-left"></i>
        </a>
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

        {{-- Foto Profil --}}
        <div class="form-card">
            <div class="form-card-header">
                <i class="bi bi-image text-primary"></i>
                <h6 class="form-card-title">Foto Profil</h6>
            </div>
            <div class="form-card-body">
                <div class="avatar-upload-wrap">
                    @if($user->foto_profil)
                        <img id="foto-preview" src="{{ Storage::url($user->foto_profil) }}"
                             alt="Preview" class="avatar-preview">
                    @else
                        <div id="foto-placeholder" class="avatar-placeholder-sm">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <img id="foto-preview" src="#" alt="Preview"
                             class="avatar-preview" style="display:none;">
                    @endif
                    <div>
                        <label for="foto_profil" class="btn-upload">
                            <i class="bi bi-upload"></i> Pilih Foto
                        </label>
                        <input type="file" id="foto_profil" name="foto_profil"
                               accept="image/jpg,image/jpeg,image/png,image/webp"
                               style="display:none;" onchange="previewFoto(event)">
                        <div class="form-hint mt-2">Format: JPG, PNG, WebP. Maks 2MB.</div>
                        @error('foto_profil')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Akun --}}
        <div class="form-card">
            <div class="form-card-header">
                <i class="bi bi-person-fill-gear text-primary"></i>
                <h6 class="form-card-title">Akun</h6>
            </div>
            <div class="form-card-body">
                <div class="form-grid-2">
                    <div class="form-group">
                        <label for="user_id" class="form-label-custom">User ID</label>
                        <input type="text" id="user_id" name="user_id"
                               value="{{ old('user_id', $user->user_id) }}"
                               class="form-control-custom @error('user_id') is-error @enderror"
                               placeholder="Contoh: USR-001">
                        @error('user_id')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="name" class="form-label-custom">
                            Nama Lengkap <span style="color:#ef4444;">*</span>
                        </label>
                        <input type="text" id="name" name="name"
                               value="{{ old('name', $user->name) }}"
                               class="form-control-custom @error('name') is-error @enderror"
                               placeholder="Nama lengkap Anda">
                        @error('name')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="form-grid-2">
                    <div class="form-group">
                        <label for="email" class="form-label-custom">
                            Email <span style="color:#ef4444;">*</span>
                        </label>
                        <input type="email" id="email" name="email"
                               value="{{ old('email', $user->email) }}"
                               class="form-control-custom @error('email') is-error @enderror"
                               placeholder="email@contoh.com">
                        @error('email')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="role" class="form-label-custom">Role</label>
                        <select id="role" name="role"
                                class="form-control-custom @error('role') is-error @enderror">
                            <option value="user"   {{ old('role', $user->role) == 'user'   ? 'selected' : '' }}>User</option>
                            <option value="admin"  {{ old('role', $user->role) == 'admin'  ? 'selected' : '' }}>Admin</option>
                            <option value="editor" {{ old('role', $user->role) == 'editor' ? 'selected' : '' }}>Editor</option>
                        </select>
                        @error('role')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="form-grid-2">
                    <div class="form-group">
                        <label for="umur" class="form-label-custom">Umur</label>
                        <div class="input-suffix-wrap">
                            <input type="number" id="umur" name="umur" min="1" max="120"
                                   value="{{ old('umur', $user->umur) }}"
                                   placeholder="Contoh: 25"
                                   class="form-control-custom has-suffix @error('umur') is-error @enderror">
                            <span class="input-suffix">tahun</span>
                        </div>
                        @error('umur')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="status_akun" class="form-label-custom">Status Akun</label>
                        <select id="status_akun" name="status_akun"
                                class="form-control-custom @error('status_akun') is-error @enderror">
                            <option value="aktif"    {{ old('status_akun', $user->status_akun) == 'aktif'    ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ old('status_akun', $user->status_akun) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        @error('status_akun')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Data Pribadi --}}
        <div class="form-card">
            <div class="form-card-header">
                <i class="bi bi-person text-primary"></i>
                <h6 class="form-card-title">Data Pribadi</h6>
            </div>
            <div class="form-card-body">

                <div class="form-grid-2">
                    <div class="form-group">
                        <label for="tempat_lahir" class="form-label-custom">Tempat Lahir</label>
                        <input type="text" id="tempat_lahir" name="tempat_lahir"
                               value="{{ old('tempat_lahir', $user->tempat_lahir) }}"
                               class="form-control-custom @error('tempat_lahir') is-error @enderror"
                               placeholder="Contoh: Bogor">
                        @error('tempat_lahir')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="tanggal_lahir" class="form-label-custom">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                               value="{{ old('tanggal_lahir', $user->tanggal_lahir?->format('Y-m-d')) }}"
                               class="form-control-custom @error('tanggal_lahir') is-error @enderror">
                        @error('tanggal_lahir')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label for="jenis_kelamin" class="form-label-custom">Jenis Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin"
                                class="form-control-custom @error('jenis_kelamin') is-error @enderror">
                            <option value="">— Pilih —</option>
                            <option value="Laki-laki"  {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Laki-laki'  ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan"  {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Perempuan'  ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="status_pernikahan" class="form-label-custom">Status Pernikahan</label>
                        <select id="status_pernikahan" name="status_pernikahan"
                                class="form-control-custom @error('status_pernikahan') is-error @enderror">
                            <option value="">— Pilih —</option>
                            <option value="Belum Menikah" {{ old('status_pernikahan', $user->status_pernikahan) == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                            <option value="Menikah"       {{ old('status_pernikahan', $user->status_pernikahan) == 'Menikah'       ? 'selected' : '' }}>Menikah</option>
                            <option value="Cerai"         {{ old('status_pernikahan', $user->status_pernikahan) == 'Cerai'         ? 'selected' : '' }}>Cerai</option>
                        </select>
                        @error('status_pernikahan')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label for="agama" class="form-label-custom">Agama</label>
                        <select id="agama" name="agama"
                                class="form-control-custom @error('agama') is-error @enderror">
                            <option value="">— Pilih —</option>
                            @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $ag)
                                <option value="{{ $ag }}" {{ old('agama', $user->agama) == $ag ? 'selected' : '' }}>
                                    {{ $ag }}
                                </option>
                            @endforeach
                        </select>
                        @error('agama')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="kewarganegaraan" class="form-label-custom">Kewarganegaraan</label>
                        <input type="text" id="kewarganegaraan" name="kewarganegaraan"
                               value="{{ old('kewarganegaraan', $user->kewarganegaraan) }}"
                               class="form-control-custom @error('kewarganegaraan') is-error @enderror"
                               placeholder="Indonesia">
                        @error('kewarganegaraan')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="alamat" class="form-label-custom">Alamat</label>
                    <textarea id="alamat" name="alamat" rows="3"
                              placeholder="Masukkan alamat lengkap Anda"
                              class="form-control-custom @error('alamat') is-error @enderror"
                              style="resize:none;">{{ old('alamat', $user->alamat) }}</textarea>
                    @error('alamat')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="tentang" class="form-label-custom">Tentang Saya</label>
                    <textarea id="tentang" name="tentang" rows="4"
                              placeholder="Ceritakan sedikit tentang diri Anda, pengalaman, dan keahlian..."
                              class="form-control-custom @error('tentang') is-error @enderror"
                              style="resize:none;">{{ old('tentang', $user->tentang) }}</textarea>
                    @error('tentang')<div class="form-error">{{ $message }}</div>@enderror
                </div>

            </div>
        </div>

        {{-- Tombol --}}
        <div class="d-flex align-items-center justify-content-end gap-2">
            <a href="{{ route('profile.show') }}"
               style="display:inline-flex; align-items:center; gap:6px;
                      padding:9px 20px; border-radius:10px; border:1px solid var(--card-border);
                      background:var(--card-bg); color:var(--text-secondary);
                      font-size:.85rem; font-weight:600; text-decoration:none; transition:background .2s;"
               onmouseover="this.style.background='var(--body-bg)'"
               onmouseout="this.style.background='var(--card-bg)'">
                <i class="bi bi-x-lg"></i> Batal
            </a>
            <button type="submit" class="btn-admin-primary">
                <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
            </button>
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
