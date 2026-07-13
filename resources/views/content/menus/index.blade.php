@extends('layouts.app')

@section('title', 'Menu Navbar')
@section('topbar-title', 'Menu Navbar')

@section('page-header')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
    <div>
        <h4 class="mb-1" style="font-size:1.25rem; font-weight:800; color:var(--text-primary);">Menu Navbar</h4>
        <p class="text-muted mb-0" style="font-size:.78rem;">Kelola menu yang tampil di navbar halaman depan</p>
    </div>
    <!-- <a href="{{ url('/') }}" target="_blank" class="btn-admin-secondary">
        <i class="bi bi-box-arrow-up-right"></i> Lihat Halaman Depan
    </a> -->
</div>
@endsection

@section('content')
@php
    $anchorSuggestions = ['#hero', '#about', '#skills', '#experience', '#education', '#certificate', '#projects', '#contact'];
@endphp

@if($errors->any())
    <div class="admin-card mb-4" style="border-color:#fecaca; background:#fef2f2;">
        <ul class="mb-0" style="color:#b91c1c; font-size:.85rem; padding-left:18px;">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
@endif

<datalist id="anchorList">
    @foreach($anchorSuggestions as $a)<option value="{{ $a }}">@endforeach
</datalist>

{{-- ============ FORM TAMBAH ============ --}}
<div class="admin-card mb-4">
    <div class="admin-card-header">
        <h6 class="admin-card-title"><i class="bi bi-plus-circle me-2 text-primary"></i>Tambah Menu Baru</h6>
    </div>
    <form action="{{ route('menus.store') }}" method="POST">
        @csrf
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="admin-form-label">Label</label>
                <input type="text" name="label" class="admin-form-control" placeholder="Home" required>
            </div>
            <div class="col-md-4">
                <label class="admin-form-label">Tujuan (URL / anchor)</label>
                <input type="text" name="url" class="admin-form-control" list="anchorList"
                       placeholder="#hero atau https://..." required>
            </div>
            <div class="col-md-2">
                <label class="admin-form-label">Urutan</label>
                <input type="number" name="sort_order" class="admin-form-control" min="0" placeholder="auto">
            </div>
            <div class="col-md-2">
                <label class="admin-form-label">Status</label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="add_active" checked>
                    <label class="form-check-label" for="add_active" style="font-size:.8rem;">Aktif</label>
                </div>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn-admin-primary w-100 justify-content-center"><i class="bi bi-plus-lg"></i></button>
            </div>
        </div>
    </form>
</div>

{{-- Satu form edit untuk semua baris + form hapus per baris (di luar tabel, via atribut form="") --}}
<form id="bulkEdit" action="{{ route('menus.bulk-update') }}" method="POST">@csrf @method('PUT')</form>
@foreach($menuItems as $item)
    <form id="del-{{ $item->id }}" action="{{ route('menus.destroy', $item) }}" method="POST"
          onsubmit="return confirm('Hapus menu &quot;{{ $item->label }}&quot;?')">@csrf @method('DELETE')</form>
@endforeach

{{-- ============ DAFTAR MENU ============ --}}
<div class="admin-card">
    <div class="admin-card-header">
        <h6 class="admin-card-title"><i class="bi bi-list-ul me-2 text-primary"></i>Daftar Menu</h6>
    </div>

    @if($menuItems->isEmpty())
        <div class="empty-state">
            <i class="bi bi-menu-button-wide empty-state-icon"></i>
            <div class="empty-state-title">Belum ada menu</div>
            <p class="empty-state-sub">Tambahkan menu navbar lewat form di atas.</p>
        </div>
    @else
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width:90px;">Urutan</th>
                    <th>Label</th>
                    <th>Tujuan</th>
                    <th style="width:80px;">Aktif</th>
                    <th style="width:70px; text-align:right;">Hapus</th>
                </tr>
            </thead>
            <tbody>
                @foreach($menuItems as $item)
                <tr>
                    <td>
                        <input type="number" form="bulkEdit" name="items[{{ $item->id }}][sort_order]"
                               class="admin-form-control" style="padding:7px 10px;" value="{{ $item->sort_order }}" min="0">
                    </td>
                    <td>
                        <input type="text" form="bulkEdit" name="items[{{ $item->id }}][label]"
                               class="admin-form-control" style="padding:7px 10px;" value="{{ $item->label }}" required>
                    </td>
                    <td>
                        <input type="text" form="bulkEdit" name="items[{{ $item->id }}][url]" list="anchorList"
                               class="admin-form-control" style="padding:7px 10px;" value="{{ $item->url }}" required>
                    </td>
                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" form="bulkEdit"
                                   name="items[{{ $item->id }}][is_active]" value="1" {{ $item->is_active ? 'checked' : '' }}>
                        </div>
                    </td>
                    <td style="text-align:right;">
                        <button type="submit" form="del-{{ $item->id }}" class="btn-admin-danger" title="Hapus">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end align-items-center gap-3 mt-3">
        <small class="text-muted">Ubah beberapa baris lalu klik simpan sekali.</small>
        <button type="submit" form="bulkEdit" class="btn-admin-primary">
            <i class="bi bi-save"></i> Simpan Perubahan
        </button>
    </div>
    @endif
</div>
@endsection
