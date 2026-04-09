{{-- resources/views/users/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Manajemen User')
@section('topbar-title', 'Manajemen User')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/user-management/user-management-style.css') }}">
@endpush

@section('page-header')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h4 class="mb-1" style="font-size:1.25rem; font-weight:800; color:var(--text-primary);">Manajemen User</h4>
            <p class="text-muted mb-0" style="font-size:.78rem;">Kelola semua akun pengguna</p>
        </div>
        <button type="button" class="btn-admin-primary" onclick="openAddModal()">
            <i class="bi bi-plus-lg"></i> Tambah User
        </button>
    </div>
@endsection

@section('content')

    {{-- Stats --}}
    <div class="user-stats">
        <div class="user-stat-card">
            <div class="user-stat-icon" style="background:#eff6ff; color:#2563eb;">
                <i class="bi bi-people-fill"></i>
            </div>
            <div>
                <div class="user-stat-num">{{ $users->total() }}</div>
                <div class="user-stat-lbl">Total User</div>
            </div>
        </div>
        <div class="user-stat-card">
            <div class="user-stat-icon" style="background:#f0fdf4; color:#16a34a;">
                <i class="bi bi-person-check-fill"></i>
            </div>
            <div>
                <div class="user-stat-num" style="color:#16a34a;">{{ $totalAktif }}</div>
                <div class="user-stat-lbl">Akun Aktif</div>
            </div>
        </div>
        <div class="user-stat-card">
            <div class="user-stat-icon" style="background:#fffbeb; color:#d97706;">
                <i class="bi bi-person-fill-exclamation"></i>
            </div>
            <div>
                <div class="user-stat-num" style="color:#d97706;">{{ $totalBelumLengkap }}</div>
                <div class="user-stat-lbl">Data Belum Lengkap</div>
            </div>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="table-card">
        <div class="table-card-header">
            <div class="table-card-title">
                <i class="bi bi-people text-primary"></i> Daftar User
            </div>
            <div class="search-wrap">
                <i class="bi bi-search"></i>
                <input type="text" class="search-input" id="searchInput" placeholder="Cari nama atau email...">
            </div>
        </div>
        <div style="overflow-x:auto;">
            <table class="admin-table" id="userTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>User ID</th>
                        <th>Umur</th>
                        <th>Alamat</th>
                        <th>Status</th>
                        <th>Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $i => $user)
                    <tr data-search="{{ strtolower($user->name . ' ' . $user->email) }}">
                        <td style="color:var(--text-muted); font-size:.78rem;">{{ $users->firstItem() + $i }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @if($user->foto_profil)
                                    <img src="{{ Storage::url($user->foto_profil) }}" class="user-avatar-sm" alt="{{ $user->name }}">
                                @else
                                    <div class="user-avatar-initial">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                @endif
                                <div>
                                    <div class="user-name">{{ $user->name }}</div>
                                    <div class="user-email">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($user->user_id)
                                <span style="font-size:.75rem; font-weight:700; background:#eff6ff; color:#2563eb; padding:3px 9px; border-radius:99px; border:1px solid #bfdbfe;">
                                    {{ $user->user_id }}
                                </span>
                            @else
                                <span style="color:var(--text-muted); font-size:.78rem;">—</span>
                            @endif
                        </td>
                        <td>{{ $user->umur ? $user->umur . ' thn' : '—' }}</td>
                        <td style="max-width:160px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                            {{ $user->alamat ?? '—' }}
                        </td>
                        <td>
                            @if(($user->status_akun ?? 'aktif') === 'aktif')
                                <span class="badge-admin green">
                                    <i class="bi bi-circle-fill" style="font-size:.4rem;"></i> Aktif
                                </span>
                            @else
                                <span class="badge-admin gray">Nonaktif</span>
                            @endif
                        </td>
                        <td style="font-size:.78rem; color:var(--text-muted);">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-1">
                                @if($user->id !== Auth::id())
                                    <button type="button" class="btn-admin-edit" onclick="openEditModal({{ $user->id }})">
                                        <i class="bi bi-pencil-fill"></i> Edit
                                    </button>
                                    <button type="button" class="btn-admin-danger"
                                            onclick="openDeleteModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->email }}')">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                @else
                                    <span style="font-size:.72rem; color:var(--text-muted); font-style:italic;">
                                        <i class="bi bi-person-fill me-1"></i>Anda
                                    </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4" style="color:var(--text-muted); font-size:.85rem;">
                            <i class="bi bi-people" style="font-size:2rem; display:block; margin-bottom:8px; opacity:.3;"></i>
                            Belum ada user
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($users->total() > 0)
        <div class="pagination-wrap">
            <div class="pagination-info">
                Menampilkan <strong>{{ $users->firstItem() }}</strong>–<strong>{{ $users->lastItem() }}</strong>
                dari <strong>{{ $users->total() }}</strong> user
            </div>

            @if($users->hasPages())
            <div class="pagination-links">
                @php
                    $cur  = $users->currentPage();
                    $last = $users->lastPage();
                @endphp

                {{-- First --}}
                @if($users->onFirstPage())
                    <span class="disabled prev-next">«</span>
                @else
                    <a href="{{ $users->url(1) }}" class="prev-next">«</a>
                @endif

                {{-- Prev --}}
                @if($users->onFirstPage())
                    <span class="disabled prev-next"><i class="bi bi-chevron-left"></i></span>
                @else
                    <a href="{{ $users->previousPageUrl() }}" class="prev-next"><i class="bi bi-chevron-left"></i></a>
                @endif

                {{-- Nomor halaman --}}
                @for($p = 1; $p <= $last; $p++)
                    @if($p === $cur)
                        <span class="active">{{ $p }}</span>
                    @elseif($p === 1 || $p === $last || abs($p - $cur) <= 1)
                        <a href="{{ $users->url($p) }}">{{ $p }}</a>
                    @elseif($p === 2 && $cur > 4)
                        <span class="ellipsis">…</span>
                    @elseif($p === $last - 1 && $cur < $last - 3)
                        <span class="ellipsis">…</span>
                    @endif
                @endfor

                {{-- Next --}}
                @if($users->hasMorePages())
                    <a href="{{ $users->nextPageUrl() }}" class="prev-next"><i class="bi bi-chevron-right"></i></a>
                @else
                    <span class="disabled prev-next"><i class="bi bi-chevron-right"></i></span>
                @endif

                {{-- Last --}}
                @if($users->hasMorePages())
                    <a href="{{ $users->url($last) }}" class="prev-next">»</a>
                @else
                    <span class="disabled prev-next">»</span>
                @endif
            </div>
            @endif
        </div>
        @endif
    </div>

    {{-- DATA USER untuk modal (JSON) --}}
    @php
        $usersJson = $users->map(fn($u) => [
            'id'                => $u->id,
            'name'              => $u->name,
            'email'             => $u->email,
            'user_id'           => $u->user_id,
            'umur'              => $u->umur,
            'alamat'            => $u->alamat,
            'tentang'           => $u->tentang,
            'foto_url'          => $u->foto_profil ? Storage::url($u->foto_profil) : null,
            'initial'           => strtoupper(substr($u->name, 0, 1)),
            'update_url'        => route('users.update', $u->id),
            'delete_url'        => route('users.destroy', $u->id),
            'role'              => $u->role,
            'status_akun'       => $u->status_akun ?? 'aktif',
            'tempat_lahir'      => $u->tempat_lahir,
            'tanggal_lahir'     => $u->tanggal_lahir?->format('Y-m-d'),
            'jenis_kelamin'     => $u->jenis_kelamin,
            'agama'             => $u->agama,
            'kewarganegaraan'   => $u->kewarganegaraan,
            'status_pernikahan' => $u->status_pernikahan,
        ]);
    @endphp
    <script>
        const USERS          = @json($usersJson);
        const LARAVEL_ERRORS = @json($errors->toArray());
        const FORM_TYPE      = "{{ old('form_type') }}";
        const OLD_USER_ID    = {{ old('edit_user_id', 0) }};
    </script>

    {{-- ════════════ MODAL ADD ════════════ --}}
    <div class="modal-overlay" id="addModal" onclick="closeOnOverlayAdd(event)">
        <div class="modal-box">
            <div class="modal-header">
                <div class="modal-title">
                    <i class="bi bi-person-plus-fill me-2 text-primary" style="font-size:.9rem;"></i>
                    Tambah User Baru
                </div>
                <button class="modal-close" onclick="closeAddModal()">
                    <i class="bi bi-x-lg" style="font-size:.8rem;"></i>
                </button>
            </div>

            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" id="addForm">
                @csrf
                <input type="hidden" name="form_type" value="add">

                <div class="modal-body">

                    {{-- Error Alert --}}
                    <div class="modal-error-alert" id="add-error-alert">
                        <i class="bi bi-exclamation-circle-fill" style="color:#ef4444; flex-shrink:0; margin-top:1px;"></i>
                        <div id="add-error-list" style="font-size:.8rem; color:#991b1b;"></div>
                    </div>

                    {{-- Avatar --}}
                    <div class="modal-avatar-wrap">
                        <img id="add-foto-preview" src="#" alt="Preview" class="modal-avatar-img" style="display:none;">
                        <div id="add-foto-initial" class="modal-avatar-initial" style="display:flex;">
                            <i class="bi bi-person" style="font-size:1.3rem;"></i>
                        </div>
                        <div>
                            <label for="add-foto-input" class="btn-upload-sm">
                                <i class="bi bi-upload"></i> Pilih Foto
                            </label>
                            <input type="file" id="add-foto-input" name="foto_profil"
                                   accept="image/jpg,image/jpeg,image/png,image/webp"
                                   style="display:none;" onchange="previewAddFoto(event)">
                            <div style="font-size:.7rem; color:var(--text-muted); margin-top:5px;">JPG, PNG, WebP. Maks 2MB. (Opsional)</div>
                        </div>
                    </div>

                    {{-- Baris 1: Nama, User ID, Role --}}
                    <div class="mform-row-3">
                        <div class="mform-group">
                            <label class="mform-label">Nama Lengkap <span style="color:#ef4444;">*</span></label>
                            <input type="text" name="name" class="mform-control" placeholder="Nama lengkap" value="{{ old('name') }}" required>
                        </div>
                        <div class="mform-group">
                            <label class="mform-label">User ID</label>
                            <input type="text" name="user_id" class="mform-control" placeholder="Contoh: USR-002" value="{{ old('user_id') }}">
                        </div>
                        <div class="mform-group">
                            <label class="mform-label">Role</label>
                            <select name="role" class="mform-control">
                                <option value="user"   {{ old('role') === 'user'   ? 'selected' : '' }}>User</option>
                                <option value="admin"  {{ old('role') === 'admin'  ? 'selected' : '' }}>Admin</option>
                                <option value="editor" {{ old('role') === 'editor' ? 'selected' : '' }}>Editor</option>
                            </select>
                        </div>
                    </div>

                    {{-- Baris 2: Email, Password, Konfirmasi --}}
                    <div class="mform-row-3">
                        <div class="mform-group">
                            <label class="mform-label">Email <span style="color:#ef4444;">*</span></label>
                            <input type="email" name="email" class="mform-control" placeholder="email@contoh.com" value="{{ old('email') }}" required>
                        </div>
                        <div class="mform-group">
                            <label class="mform-label">Password <span style="color:#ef4444;">*</span></label>
                            <input type="password" name="password" class="mform-control" placeholder="Min. 8 karakter" required>
                        </div>
                        <div class="mform-group">
                            <label class="mform-label">Konfirmasi Password <span style="color:#ef4444;">*</span></label>
                            <input type="password" name="password_confirmation" class="mform-control" placeholder="Ulangi password" required>
                        </div>
                    </div>

                    {{-- Baris 3: Tempat Lahir, Tanggal Lahir, Umur --}}
                    <div class="mform-row-3">
                        <div class="mform-group">
                            <label class="mform-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="mform-control" placeholder="Contoh: Bogor" value="{{ old('tempat_lahir') }}">
                        </div>
                        <div class="mform-group">
                            <label class="mform-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" id="add-tanggal-lahir" class="mform-control"
                                   value="{{ old('tanggal_lahir') }}" onchange="hitungUmurAdd(this.value)">
                        </div>
                        <div class="mform-group">
                            <label class="mform-label">
                                Umur
                                <span style="font-size:.68rem; color:var(--text-muted); font-weight:400; margin-left:4px;">(otomatis)</span>
                            </label>
                            <input type="number" name="umur" id="add-umur" class="mform-control"
                                   placeholder="— isi tgl lahir —" min="1" max="120"
                                   value="{{ old('umur') }}" readonly>
                        </div>
                    </div>

                    {{-- Baris 4: Jenis Kelamin, Status Pernikahan, Agama --}}
                    <div class="mform-row-3">
                        <div class="mform-group">
                            <label class="mform-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="mform-control">
                                <option value="">— Pilih —</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="mform-group">
                            <label class="mform-label">Status Pernikahan</label>
                            <select name="status_pernikahan" class="mform-control">
                                <option value="">— Pilih —</option>
                                <option value="Belum Menikah" {{ old('status_pernikahan') === 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                <option value="Menikah"       {{ old('status_pernikahan') === 'Menikah'       ? 'selected' : '' }}>Menikah</option>
                                <option value="Cerai"         {{ old('status_pernikahan') === 'Cerai'         ? 'selected' : '' }}>Cerai</option>
                            </select>
                        </div>
                        <div class="mform-group">
                            <label class="mform-label">Agama</label>
                            <select name="agama" class="mform-control">
                                <option value="">— Pilih —</option>
                                @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $ag)
                                    <option value="{{ $ag }}" {{ old('agama') === $ag ? 'selected' : '' }}>{{ $ag }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Baris 5: Kewarganegaraan, Status Akun --}}
                    <div class="mform-row">
                        <div class="mform-group">
                            <label class="mform-label">Kewarganegaraan</label>
                            <input type="text" name="kewarganegaraan" class="mform-control" placeholder="Indonesia" value="{{ old('kewarganegaraan', 'Indonesia') }}">
                        </div>
                        <div class="mform-group">
                            <label class="mform-label">Status Akun</label>
                            <select name="status_akun" class="mform-control">
                                <option value="aktif"    {{ old('status_akun', 'aktif') === 'aktif'    ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status_akun')           === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                    </div>

                    {{-- Baris 6: Alamat --}}
                    <div class="mform-group">
                        <label class="mform-label">Alamat</label>
                        <textarea name="alamat" rows="2" class="mform-control" placeholder="Alamat lengkap" style="resize:none;">{{ old('alamat') }}</textarea>
                    </div>

                    {{-- Baris 7: Tentang --}}
                    <div class="mform-group">
                        <label class="mform-label">Tentang</label>
                        <textarea name="tentang" rows="3" class="mform-control" placeholder="Deskripsi singkat tentang user..." style="resize:none;">{{ old('tentang') }}</textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeAddModal()">
                        <i class="bi bi-x-lg"></i> Batal
                    </button>
                    <button type="submit" class="btn-admin-primary">
                        <i class="bi bi-plus-lg me-1"></i> Tambah User
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ════════════ MODAL EDIT ════════════ --}}
    <div class="modal-overlay" id="editModal" onclick="closeOnOverlay(event)">
        <div class="modal-box">
            <div class="modal-header">
                <div class="modal-title">
                    <i class="bi bi-pencil-square me-2 text-primary" style="font-size:.9rem;"></i>
                    Edit User
                </div>
                <button class="modal-close" onclick="closeModal()">
                    <i class="bi bi-x-lg" style="font-size:.8rem;"></i>
                </button>
            </div>

            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="form_type" value="edit">

                <div class="modal-body">

                    {{-- Error Alert --}}
                    <div class="modal-error-alert" id="edit-error-alert">
                        <i class="bi bi-exclamation-circle-fill" style="color:#ef4444; flex-shrink:0; margin-top:1px;"></i>
                        <div id="edit-error-list" style="font-size:.8rem; color:#991b1b;"></div>
                    </div>

                    {{-- Avatar --}}
                    <div class="modal-avatar-wrap">
                        <img id="modal-foto-preview" src="#" alt="Preview" class="modal-avatar-img" style="display:none;">
                        <div id="modal-foto-initial" class="modal-avatar-initial">A</div>
                        <div>
                            <label for="modal-foto-input" class="btn-upload-sm">
                                <i class="bi bi-upload"></i> Ganti Foto
                            </label>
                            <input type="file" id="modal-foto-input" name="foto_profil"
                                   accept="image/jpg,image/jpeg,image/png,image/webp"
                                   style="display:none;" onchange="previewModalFoto(event)">
                            <div style="font-size:.7rem; color:var(--text-muted); margin-top:5px;">JPG, PNG, WebP. Maks 2MB.</div>
                        </div>
                    </div>

                    {{-- Baris 1: Nama, User ID, Role --}}
                    <div class="mform-row-3">
                        <div class="mform-group">
                            <label class="mform-label">Nama Lengkap <span style="color:#ef4444;">*</span></label>
                            <input type="text" name="name" id="modal-name" class="mform-control" placeholder="Nama lengkap" required>
                        </div>
                        <div class="mform-group">
                            <label class="mform-label">User ID</label>
                            <input type="text" name="user_id" id="modal-user-id" class="mform-control" placeholder="Contoh: USR-001">
                        </div>
                        <div class="mform-group">
                            <label class="mform-label">Role</label>
                            <select name="role" id="modal-role" class="mform-control">
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                                <option value="editor">Editor</option>
                            </select>
                        </div>
                    </div>

                    {{-- Baris 2: Email, Status Akun --}}
                    <div class="mform-row">
                        <div class="mform-group">
                            <label class="mform-label">Email <span style="color:#ef4444;">*</span></label>
                            <input type="email" name="email" id="modal-email" class="mform-control" placeholder="email@contoh.com" required>
                        </div>
                        <div class="mform-group">
                            <label class="mform-label">Status Akun</label>
                            <select name="status_akun" id="modal-status-akun" class="mform-control">
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>
                    </div>

                    {{-- Baris 3: Tempat Lahir, Tanggal Lahir, Umur --}}
                    <div class="mform-row-3">
                        <div class="mform-group">
                            <label class="mform-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" id="modal-tempat-lahir" class="mform-control" placeholder="Contoh: Bogor">
                        </div>
                        <div class="mform-group">
                            <label class="mform-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" id="modal-tanggal-lahir" class="mform-control"
                                   onchange="hitungUmurEdit(this.value)">
                        </div>
                        <div class="mform-group">
                            <label class="mform-label">
                                Umur
                                <span style="font-size:.68rem; color:var(--text-muted); font-weight:400; margin-left:4px;">(otomatis)</span>
                            </label>
                            <input type="number" name="umur" id="modal-umur" class="mform-control"
                                   placeholder="— isi tgl lahir —" min="1" max="120" readonly>
                        </div>
                    </div>

                    {{-- Baris 4: Jenis Kelamin, Status Pernikahan, Agama --}}
                    <div class="mform-row-3">
                        <div class="mform-group">
                            <label class="mform-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="modal-jenis-kelamin" class="mform-control">
                                <option value="">— Pilih —</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="mform-group">
                            <label class="mform-label">Status Pernikahan</label>
                            <select name="status_pernikahan" id="modal-status-pernikahan" class="mform-control">
                                <option value="">— Pilih —</option>
                                <option value="Belum Menikah">Belum Menikah</option>
                                <option value="Menikah">Menikah</option>
                                <option value="Cerai">Cerai</option>
                            </select>
                        </div>
                        <div class="mform-group">
                            <label class="mform-label">Agama</label>
                            <select name="agama" id="modal-agama" class="mform-control">
                                <option value="">— Pilih —</option>
                                <option value="Islam">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Buddha">Buddha</option>
                                <option value="Konghucu">Konghucu</option>
                            </select>
                        </div>
                    </div>

                    {{-- Baris 5: Kewarganegaraan --}}
                    <div class="mform-group">
                        <label class="mform-label">Kewarganegaraan</label>
                        <input type="text" name="kewarganegaraan" id="modal-kewarganegaraan" class="mform-control" placeholder="Indonesia">
                    </div>

                    {{-- Baris 6: Alamat --}}
                    <div class="mform-group">
                        <label class="mform-label">Alamat</label>
                        <textarea name="alamat" id="modal-alamat" rows="2" class="mform-control" placeholder="Alamat lengkap" style="resize:none;"></textarea>
                    </div>

                    {{-- Baris 7: Tentang --}}
                    <div class="mform-group">
                        <label class="mform-label">Tentang</label>
                        <textarea name="tentang" id="modal-tentang" rows="3" class="mform-control" placeholder="Deskripsi singkat tentang user..." style="resize:none;"></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeModal()">
                        <i class="bi bi-x-lg"></i> Batal
                    </button>
                    <button type="submit" class="btn-admin-primary">
                        <i class="bi bi-check-lg me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Form Delete --}}
    <form id="deleteForm" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>

    {{-- Modal Hapus --}}
    <div class="modal-overlay" id="deleteModal" onclick="closeOnOverlayDelete(event)">
        <div class="modal-box" style="max-width:400px;">
            <div class="modal-header" style="border-bottom:none; padding-bottom:0;">
                <div></div>
                <button class="modal-close" onclick="closeDeleteModal()">
                    <i class="bi bi-x-lg" style="font-size:.8rem;"></i>
                </button>
            </div>
            <div class="modal-body" style="text-align:center; padding-top:8px;">
                <div style="width:60px; height:60px; border-radius:16px; background:#fef2f2;
                            display:flex; align-items:center; justify-content:center;
                            margin:0 auto 16px; border:1px solid #fecaca;">
                    <i class="bi bi-trash3-fill" style="font-size:1.5rem; color:#ef4444;"></i>
                </div>
                <div style="font-size:1rem; font-weight:800; color:var(--text-primary); margin-bottom:6px;">Hapus User?</div>
                <div style="font-size:.85rem; color:var(--text-muted); line-height:1.6;">
                    Anda akan menghapus akun
                    <strong id="delete-user-name" style="color:var(--text-primary);"></strong><br>
                    <span id="delete-user-email" style="font-size:.78rem;"></span>
                </div>
                <div style="margin-top:12px; padding:10px 14px; background:#fef2f2; border-radius:10px;
                            border:1px solid #fecaca; font-size:.78rem; color:#b91c1c; text-align:left;">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i>
                    Tindakan ini tidak dapat dibatalkan. Semua data user akan dihapus permanen.
                </div>
            </div>
            <div class="modal-footer" style="justify-content:center; gap:10px;">
                <button type="button" class="btn-cancel" onclick="closeDeleteModal()">Batal</button>
                <button type="button" onclick="confirmDelete()"
                        style="display:inline-flex; align-items:center; gap:6px; padding:9px 20px;
                               border-radius:10px; border:none; background:#ef4444; color:white;
                               font-size:.85rem; font-weight:600; cursor:pointer; transition:opacity .2s;"
                        onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
                    <i class="bi bi-trash3-fill"></i> Ya, Hapus
                </button>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
   <script src="{{ asset('assets/user-management/user-management-script.js') }}"></script>
@endpush
