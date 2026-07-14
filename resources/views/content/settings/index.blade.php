@extends('layouts.app')

@section('title', 'Pengaturan Portfolio')
@section('topbar-title', 'Pengaturan Portfolio')

@section('page-header')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
    <div>
        <h4 class="mb-1" style="font-size:1.25rem; font-weight:800; color:var(--text-primary);">Pengaturan Portfolio</h4>
        <p class="text-muted mb-0" style="font-size:.78rem;">Atur teks & data yang tampil di halaman depan portfolio</p>
    </div>
    <!-- <a href="{{ url('/') }}" target="_blank" class="btn-admin-secondary">
        <i class="bi bi-box-arrow-up-right"></i> Lihat Halaman Depan
    </a> -->
</div>
@endsection

@section('content')
@if($errors->any())
    <div class="admin-card mb-4" style="border-color:#fecaca; background:#fef2f2;">
        <ul class="mb-0" style="color:#b91c1c; font-size:.85rem; padding-left:18px;">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
@endif

<form action="{{ route('settings.update') }}" method="POST">
    @csrf
    @method('PUT')

    {{-- ============ STATUS PUBLISH ============ --}}
    <div class="admin-card mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h6 class="admin-card-title"><i class="bi bi-globe me-2 text-primary"></i>Status Publikasi</h6>
                <small class="text-muted">Jika non-aktif, halaman depan menampilkan 404.</small>
            </div>
            <div class="form-check form-switch fs-5">
                <input class="form-check-input" type="checkbox" name="is_published" value="1"
                       id="is_published" {{ $config->is_published ? 'checked' : '' }}>
                <label class="form-check-label" for="is_published" style="font-size:.9rem;">Published</label>
            </div>
        </div>
    </div>

    {{-- ============ HERO ============ --}}
    <div class="admin-card mb-4">
        <div class="admin-card-header">
            <h6 class="admin-card-title"><i class="bi bi-stars me-2 text-primary"></i>Bagian Hero (atas)</h6>
        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="admin-form-label">Teks Badge</label>
                <input type="text" name="hero_badge_text" class="admin-form-control"
                       value="{{ old('hero_badge_text', $config->hero_badge_text) }}">
            </div>
            <div class="col-md-6">
                <label class="admin-form-label">Judul Utama <small class="text-muted">(Enter = baris baru)</small></label>
                <textarea name="hero_title" class="admin-form-control" rows="3">{{ old('hero_title', $config->hero_title) }}</textarea>
            </div>
            <div class="col-12">
                <label class="admin-form-label">Sub-judul / Deskripsi</label>
                <textarea name="hero_subtitle" class="admin-form-control" rows="2">{{ old('hero_subtitle', $config->hero_subtitle) }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="admin-form-label">Teks Tombol Utama</label>
                <input type="text" name="hero_cta_primary" class="admin-form-control"
                       value="{{ old('hero_cta_primary', $config->hero_cta_primary) }}">
            </div>
            <div class="col-md-6">
                <label class="admin-form-label">Teks Tombol Kedua</label>
                <input type="text" name="hero_cta_secondary" class="admin-form-control"
                       value="{{ old('hero_cta_secondary', $config->hero_cta_secondary) }}">
            </div>
        </div>
    </div>

    {{-- ============ STATISTIK ============ --}}
    <div class="admin-card mb-4">
        <div class="admin-card-header">
            <h6 class="admin-card-title"><i class="bi bi-bar-chart me-2 text-primary"></i>Statistik (angka di hero)</h6>
        </div>
        <div class="row g-3">
            <div class="col-6 col-md-3">
                <label class="admin-form-label">Penghargaan</label>
                <input type="number" min="0" name="stat_awards" class="admin-form-control"
                       value="{{ old('stat_awards', $config->stat_awards) }}">
            </div>
            <div class="col-6 col-md-3">
                <label class="admin-form-label">Projek</label>
                <input type="number" min="0" name="stat_projects" class="admin-form-control"
                       value="{{ old('stat_projects', $config->stat_projects) }}">
            </div>
            <div class="col-6 col-md-3">
                <label class="admin-form-label">Tahun Pengalaman</label>
                <input type="number" min="0" name="stat_years" class="admin-form-control"
                       value="{{ old('stat_years', $config->stat_years) }}">
            </div>
            <div class="col-6 col-md-3">
                <label class="admin-form-label">Sertifikat</label>
                <input type="number" min="0" name="stat_certificates" class="admin-form-control"
                       value="{{ old('stat_certificates', $config->stat_certificates) }}">
            </div>
        </div>
    </div>

    {{-- ============ ABOUT ============ --}}
    <div class="admin-card mb-4">
        <div class="admin-card-header">
            <h6 class="admin-card-title"><i class="bi bi-person-badge me-2 text-primary"></i>Bagian About</h6>
        </div>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="admin-form-label">Label Kecil</label>
                <input type="text" name="about_meta" class="admin-form-control"
                       value="{{ old('about_meta', $config->about_meta) }}" placeholder="MORE ABOUT ME">
            </div>
            <div class="col-md-8">
                <label class="admin-form-label">Judul About</label>
                <input type="text" name="about_title" class="admin-form-control"
                       value="{{ old('about_title', $config->about_title) }}">
            </div>
            <div class="col-12">
                <label class="admin-form-label">
                    Deskripsi About
                    <span class="text-muted" style="font-weight:500;">— diambil dari <b>Tentang Saya</b> di Profil</span>
                </label>
                <textarea class="admin-form-control" rows="3" disabled
                          style="background:#f1f5f9; cursor:not-allowed;">{{ $user->tentang ?: 'Belum diisi.' }}</textarea>
                <small class="text-muted d-block mt-2">
                    <i class="bi bi-info-circle me-1"></i>Untuk mengubah deskripsi ini, edit di
                    <a href="{{ route('profile.edit') }}">Profil → Tentang Saya</a>.
                </small>
            </div>
            <div class="col-md-6">
                <label class="admin-form-label">Daftar Keahlian Singkat <small class="text-muted">(1 baris = 1 poin)</small></label>
                <textarea name="about_features" class="admin-form-control" rows="6"
                          placeholder="Laravel &amp; PHP Expert&#10;Vue.js &amp; React">{{ old('about_features', is_array($config->about_features) ? implode("\n", $config->about_features) : '') }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="admin-form-label">Posisi / Jabatan</label>
                <input type="text" name="profile_position" class="admin-form-control"
                       value="{{ old('profile_position', $config->profile_position) }}" placeholder="Web Developer">
                <small class="text-muted d-block mt-2">Nama & email diambil dari profil user: <b>{{ $user->name }}</b> ({{ $user->email }})</small>
            </div>
        </div>
    </div>

    {{-- ============ CONTACT ============ --}}
    <div class="admin-card mb-4">
        <div class="admin-card-header">
            <h6 class="admin-card-title"><i class="bi bi-telephone me-2 text-primary"></i>Bagian Kontak</h6>
        </div>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="admin-form-label">Lokasi</label>
                <input type="text" name="contact_location" class="admin-form-control"
                       value="{{ old('contact_location', $config->contact_location) }}" placeholder="Jakarta, Indonesia">
            </div>
            <div class="col-md-4">
                <label class="admin-form-label">No. Telepon</label>
                <input type="text" name="contact_phone" class="admin-form-control"
                       value="{{ old('contact_phone', $config->contact_phone) }}" placeholder="+62 812 3456 7890">
            </div>
            <div class="col-md-4">
                <label class="admin-form-label">Email Kontak</label>
                <input type="text" name="contact_email" class="admin-form-control"
                       value="{{ old('contact_email', $config->contact_email) }}" placeholder="email@example.com">
            </div>
        </div>
    </div>

    {{-- ============ VISIBILITAS SECTION (INFO) ============ --}}
    <div class="admin-card mb-4">
        <div class="admin-card-header">
            <h6 class="admin-card-title"><i class="bi bi-toggles me-2 text-primary"></i>Tampilkan / Sembunyikan Section</h6>
        </div>
        <div class="d-flex align-items-start gap-2" style="font-size:.85rem; color:var(--text-secondary);">
            <i class="bi bi-info-circle mt-1"></i>
            <div>
                Section di halaman depan sekarang mengikuti <b>Menu Navbar</b>. Sebuah section akan tampil
                jika ada menu <b>aktif</b> yang menuju ke anchor-nya (mis. <code>#about</code>, <code>#projects</code>).
                <div class="mt-2">
                    <a href="{{ route('menus.index') }}" class="btn-admin-secondary">
                        <i class="bi bi-menu-button-wide"></i> Kelola Menu Navbar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mb-4">
        <button type="submit" class="btn-admin-primary">
            <i class="bi bi-save"></i> Simpan Pengaturan
        </button>
    </div>
</form>

{{-- ============ ILUSTRASI HERO (MULTI-GAMBAR) — di luar form utama ============ --}}
<div class="admin-card mb-5">
        <div class="admin-card-header">
            <h6 class="admin-card-title"><i class="bi bi-images me-2 text-primary"></i>Ilustrasi Hero (atas)</h6>
        </div>
        <small class="text-muted d-block mb-3">
            Gambar ini tampil sebagai carousel di sisi kanan bagian Hero. Bisa lebih dari satu (jpg, png, webp, gif, svg).
        </small>

        {{-- Upload --}}
        <form action="{{ route('hero-images.store') }}" method="POST" enctype="multipart/form-data"
            class="row g-2 align-items-end mb-4">
            @csrf
            <div class="col-md-9">
                <label class="admin-form-label">Pilih Gambar <small class="text-muted">(bisa banyak sekaligus)</small></label>
                <input type="file" name="images[]" class="admin-form-control" multiple
                    accept="image/png,image/jpeg,image/webp,image/gif,image/svg+xml" required>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn-admin-primary w-100 justify-content-center">
                    <i class="bi bi-upload"></i> Unggah
                </button>
            </div>
        </form>

        {{-- Galeri --}}
        @if($heroImages->count())
            <div class="row g-3">
                @foreach($heroImages as $img)
                    <div class="col-6 col-md-3">
                        <div style="position:relative; border:1px solid var(--card-border,#e2e8f0); border-radius:12px; overflow:hidden; background:#f8fafc;">
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($img->image) }}" alt=""
                                style="width:100%; height:130px; object-fit:contain; padding:10px;">
                            <button type="button" title="Hapus"
                                    onclick="openHeroDelete('{{ route('hero-images.destroy', $img) }}')"
                                    style="position:absolute; top:6px; right:6px; border:none; width:30px; height:30px; border-radius:50%; background:#fff; color:#dc2626; box-shadow:0 2px 8px rgba(0,0,0,.15); cursor:pointer;">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center text-muted py-4" style="border:1px dashed var(--card-border,#e2e8f0); border-radius:12px;">
                <i class="bi bi-image fs-3"></i>
                <p class="mb-0 mt-2" style="font-size:.85rem;">Belum ada ilustrasi. Unggah gambar di atas.</p>
            </div>
        @endif
    </div>

{{-- ===== Modal konfirmasi hapus ilustrasi hero ===== --}}
<div class="modal fade" id="modalDeleteHeroImg" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border:none; border-radius:16px;">
            <div class="modal-body text-center p-4">
                <div class="mb-3" style="width:56px; height:56px; margin:0 auto; border-radius:50%; background:#fee2e2; display:flex; align-items:center; justify-content:center;">
                    <i class="bi bi-trash3" style="font-size:1.5rem; color:#dc2626;"></i>
                </div>
                <h6 class="mb-1" style="font-weight:700;">Hapus Ilustrasi?</h6>
                <p class="text-muted mb-4" style="font-size:.85rem; text-align:center;">Ilustrasi ini akan dihapus permanen dari hero.</p>
                <div class="d-flex gap-2 justify-content-center">
                    <button type="button" class="btn-admin-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="formDeleteHeroImg" method="POST" action="">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-admin-primary" style="background:#dc2626; border-color:#dc2626;">
                            <i class="bi bi-trash3"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openHeroDelete(action) {
        document.getElementById('formDeleteHeroImg').action = action;
        new bootstrap.Modal(document.getElementById('modalDeleteHeroImg')).show();
    }
</script>
@endpush
@endsection
