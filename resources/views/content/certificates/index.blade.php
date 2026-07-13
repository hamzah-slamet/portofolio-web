@extends('layouts.app')

@section('title', 'Sertifikat')
@section('topbar-title', 'Sertifikat')

@section('page-header')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
    <div>
        <h4 class="mb-1" style="font-size:1.25rem; font-weight:800; color:var(--text-primary);">Sertifikat</h4>
        <p class="text-muted mb-0" style="font-size:.78rem;">Kelola sertifikat yang tampil di halaman depan</p>
    </div>
    <a href="{{ url('/') }}" target="_blank" class="btn-admin-secondary">
        <i class="bi bi-box-arrow-up-right"></i> Lihat Halaman Depan
    </a>
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

{{-- ============ TAMBAH ============ --}}
<div class="admin-card mb-4">
    <div class="admin-card-header">
        <h6 class="admin-card-title"><i class="bi bi-plus-circle me-2 text-primary"></i>Tambah Sertifikat</h6>
    </div>
    <form action="{{ route('certificates.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-md-5">
                <label class="admin-form-label">Judul <span style="color:#dc2626;">*</span></label>
                <input type="text" name="title" class="admin-form-control" placeholder="Laravel Certified Developer" required>
            </div>
            <div class="col-md-4">
                <label class="admin-form-label">Penerbit <span style="color:#dc2626;">*</span></label>
                <input type="text" name="issuer" class="admin-form-control" placeholder="Zend / Coursera" required>
            </div>
            <div class="col-md-3">
                <label class="admin-form-label">Tahun <span style="color:#dc2626;">*</span></label>
                <input type="text" name="year" class="admin-form-control" placeholder="2024" required>
            </div>
            <div class="col-md-5">
                <label class="admin-form-label">Link (opsional)</label>
                <input type="url" name="url" class="admin-form-control" placeholder="https://...">
            </div>
            <div class="col-md-5">
                <label class="admin-form-label">Gambar (opsional)</label>
                <input type="file" name="image" class="admin-form-control" accept="image/*">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn-admin-primary w-100 justify-content-center">
                    <i class="bi bi-plus-lg"></i> Tambah
                </button>
            </div>
        </div>
    </form>
</div>

{{-- form hapus per baris --}}
@foreach($certificates as $c)
    <form id="del-cert-{{ $c->id }}" action="{{ route('certificates.destroy', $c) }}" method="POST"
          onsubmit="return confirm('Hapus sertifikat &quot;{{ $c->title }}&quot;?')">@csrf @method('DELETE')</form>
@endforeach

{{-- ============ DAFTAR ============ --}}
<div class="admin-card">
    <div class="admin-card-header">
        <h6 class="admin-card-title"><i class="bi bi-patch-check me-2 text-primary"></i>Daftar Sertifikat</h6>
    </div>

    @if($certificates->isEmpty())
        <div class="empty-state">
            <i class="bi bi-patch-check empty-state-icon"></i>
            <div class="empty-state-title">Belum ada sertifikat</div>
            <p class="empty-state-sub">Tambahkan sertifikat lewat form di atas.</p>
        </div>
    @else
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width:60px;">Gambar</th>
                    <th>Judul</th>
                    <th>Penerbit</th>
                    <th style="width:80px;">Tahun</th>
                    <th style="width:120px; text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($certificates as $c)
                <tr>
                    <td>
                        @if($c->image)
                            <img src="{{ Storage::url($c->image) }}" alt="" style="width:44px; height:44px; object-fit:cover; border-radius:8px;">
                        @else
                            <div style="width:44px; height:44px; border-radius:8px; background:var(--blue-light); display:flex; align-items:center; justify-content:center;">
                                <i class="bi bi-patch-check"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight:700;">{{ $c->title }}</div>
                        @if($c->url)<a href="{{ $c->url }}" target="_blank" style="font-size:.72rem;">Lihat kredensial</a>@endif
                    </td>
                    <td>{{ $c->issuer }}</td>
                    <td>{{ $c->year }}</td>
                    <td style="text-align:right;">
                        <button type="button" class="btn-admin-edit btn-edit-cert"
                                data-id="{{ $c->id }}" data-title="{{ $c->title }}"
                                data-issuer="{{ $c->issuer }}" data-year="{{ $c->year }}"
                                data-url="{{ $c->url }}" data-sort="{{ $c->sort_order }}"
                                data-bs-toggle="modal" data-bs-target="#modalEditCert">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                        <button type="submit" form="del-cert-{{ $c->id }}" class="btn-admin-danger" title="Hapus">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

{{-- ============ MODAL EDIT ============ --}}
<div class="modal fade" id="modalEditCert" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEditCert" action="" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil-fill me-2 text-primary"></i>Edit Sertifikat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="admin-form-label">Judul</label>
                            <input type="text" name="title" id="edit_cert_title" class="admin-form-control" required>
                        </div>
                        <div class="col-md-7">
                            <label class="admin-form-label">Penerbit</label>
                            <input type="text" name="issuer" id="edit_cert_issuer" class="admin-form-control" required>
                        </div>
                        <div class="col-md-5">
                            <label class="admin-form-label">Tahun</label>
                            <input type="text" name="year" id="edit_cert_year" class="admin-form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="admin-form-label">Link (opsional)</label>
                            <input type="url" name="url" id="edit_cert_url" class="admin-form-control">
                        </div>
                        <div class="col-12">
                            <label class="admin-form-label">Ganti Gambar (opsional)</label>
                            <input type="file" name="image" class="admin-form-control" accept="image/*">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-admin-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-admin-primary"><i class="bi bi-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.querySelectorAll('.btn-edit-cert').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const d = this.dataset;
            document.getElementById('formEditCert').action = '/certificates/' + d.id;
            document.getElementById('edit_cert_title').value  = d.title;
            document.getElementById('edit_cert_issuer').value = d.issuer;
            document.getElementById('edit_cert_year').value   = d.year;
            document.getElementById('edit_cert_url').value    = d.url || '';
        });
    });
</script>
@endpush
