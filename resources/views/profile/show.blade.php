{{-- resources/views/profile/show.blade.php --}}

@extends('layouts.app')

@section('title', 'Profil Saya')
@section('topbar-title', 'Profil Saya')

@push('styles')
<style>
    /* ── Kartu profil kiri ───────────────────────────────── */
    .pf-side-card { text-align: center; }
    .pf-avatar,
    .pf-avatar-ph {
        width: 112px; height: 112px; border-radius: 24px;
        object-fit: cover; margin: 0 auto 16px;
        box-shadow: 0 8px 24px rgba(37,99,235,.18);
        display: flex; align-items: center; justify-content: center;
    }
    .pf-avatar { border: 3px solid var(--card-bg); }
    .pf-avatar-ph {
        background: linear-gradient(135deg, var(--blue, #2563eb), var(--blue-hover, #1d4ed8));
        color: #fff; font-size: 2.6rem; font-weight: 800;
    }
    .pf-name { font-size: 1.2rem; font-weight: 800; color: var(--text-primary); line-height: 1.2; }
    .pf-email { font-size: .82rem; color: var(--text-muted); margin-top: 4px; word-break: break-all; }

    .pf-badges { display: flex; flex-wrap: wrap; gap: 6px; justify-content: center; margin-top: 14px; }
    .pf-badge {
        display: inline-flex; align-items: center; gap: 5px;
        font-size: .7rem; font-weight: 700; padding: 5px 11px;
        border-radius: 99px; border: 1px solid transparent;
    }
    .pf-badge.blue  { background: #eff6ff; color: #2563eb; border-color: #bfdbfe; }
    .pf-badge.green { background: #f0fdf4; color: #16a34a; border-color: #bbf7d0; }
    .pf-badge.red   { background: #fef2f2; color: #dc2626; border-color: #fecaca; }

    .pf-divider { height: 1px; background: var(--card-border); margin: 18px 0; }

    .pf-quick { display: flex; flex-direction: column; gap: 12px; text-align: left; }
    .pf-quick-item { display: flex; align-items: center; gap: 12px; }
    .pf-quick-ico {
        width: 36px; height: 36px; border-radius: 10px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center; font-size: .95rem;
        background: var(--blue-light, #eff6ff); color: var(--text-secondary, #475569);
    }
    .pf-quick-lbl { font-size: .65rem; font-weight: 700; text-transform: uppercase; letter-spacing: .8px; color: var(--text-muted); }
    .pf-quick-val { font-size: .85rem; font-weight: 700; color: var(--text-primary); word-break: break-word; }

    /* ── Grid data diri kanan ────────────────────────────── */
    .pf-info-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; }
    .pf-info-item {
        display: flex; align-items: center; gap: 12px;
        padding: 13px 15px; border: 1px solid var(--card-border);
        border-radius: 12px; background: var(--card-bg);
    }
    .pf-info-ico {
        width: 40px; height: 40px; border-radius: 11px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center; font-size: 1.05rem;
        background: var(--blue-light, #eff6ff); color: var(--text-secondary, #475569);
    }
    .pf-info-lbl { font-size: .65rem; font-weight: 700; text-transform: uppercase; letter-spacing: .8px; color: var(--text-muted); }
    .pf-info-val { font-size: .875rem; font-weight: 700; color: var(--text-primary); margin-top: 2px; }

    .pf-body-text { font-size: .9rem; color: var(--text-secondary); line-height: 1.85; }

    @media (max-width: 575px) {
        .pf-info-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('page-header')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h4 class="mb-1" style="font-size:1.25rem; font-weight:800; color:var(--text-primary);">Profil Saya</h4>
            <p class="text-muted mb-0" style="font-size:.78rem;">Informasi akun dan data diri</p>
        </div>
        <a href="{{ route('profile.edit') }}" class="btn-admin-primary">
            <i class="bi bi-pencil-square"></i> Edit Profil
        </a>
    </div>
@endsection

@section('content')
@php
    $isActive = ($user->status_akun ?? 'aktif') === 'aktif';
@endphp

<div class="row g-4">

    {{-- ════════ KIRI: Kartu Profil ════════ --}}
    <div class="col-lg-4">
        <div class="admin-card pf-side-card">
            @if($user->foto_profil)
                <img src="{{ Storage::url($user->foto_profil) }}" alt="{{ $user->name }}" class="pf-avatar">
            @else
                <div class="pf-avatar-ph">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
            @endif

            <div class="pf-name">{{ $user->name }}</div>
            <div class="pf-email"><i class="bi bi-envelope me-1"></i>{{ $user->email }}</div>

            <div class="pf-badges">
                @if($user->user_id)
                    <span class="pf-badge blue"><i class="bi bi-person-vcard"></i>{{ $user->user_id }}</span>
                @endif
                @if($user->role)
                    <span class="pf-badge green"><i class="bi bi-shield-lock"></i>{{ ucfirst($user->role) }}</span>
                @endif
                <span class="pf-badge {{ $isActive ? 'green' : 'red' }}">
                    <i class="bi {{ $isActive ? 'bi-check-circle' : 'bi-x-circle' }}"></i>{{ $isActive ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>

            <div class="pf-divider"></div>

            <div class="pf-quick">
                <div class="pf-quick-item">
                    <div class="pf-quick-ico"><i class="bi bi-calendar-heart"></i></div>
                    <div>
                        <div class="pf-quick-lbl">Umur</div>
                        <div class="pf-quick-val">{{ $user->umur ? $user->umur.' tahun' : '—' }}</div>
                    </div>
                </div>
                <div class="pf-quick-item">
                    <div class="pf-quick-ico"><i class="bi bi-gender-ambiguous"></i></div>
                    <div>
                        <div class="pf-quick-lbl">Jenis Kelamin</div>
                        <div class="pf-quick-val">{{ $user->jenis_kelamin ?? '—' }}</div>
                    </div>
                </div>
                <div class="pf-quick-item">
                    <div class="pf-quick-ico"><i class="bi bi-flag"></i></div>
                    <div>
                        <div class="pf-quick-lbl">Kewarganegaraan</div>
                        <div class="pf-quick-val">{{ $user->kewarganegaraan ?? '—' }}</div>
                    </div>
                </div>
            </div>

            <a href="{{ route('profile.edit') }}" class="btn-admin-primary w-100 justify-content-center mt-4">
                <i class="bi bi-pencil-square"></i> Edit Profil
            </a>
        </div>
    </div>

    {{-- ════════ KANAN: Detail Data ════════ --}}
    <div class="col-lg-8">

        {{-- Data Diri --}}
        <div class="admin-card mb-4">
            <div class="admin-card-header">
                <h6 class="admin-card-title"><i class="bi bi-person-lines-fill me-2 text-primary"></i>Data Diri</h6>
            </div>
            <div class="pf-info-grid">
                <div class="pf-info-item">
                    <div class="pf-info-ico"><i class="bi bi-geo-alt"></i></div>
                    <div>
                        <div class="pf-info-lbl">Tempat, Tgl Lahir</div>
                        <div class="pf-info-val" style="font-size:.8rem;">
                            @if($user->tempat_lahir || $user->tanggal_lahir)
                                {{ $user->tempat_lahir ?? '' }}{{ $user->tempat_lahir && $user->tanggal_lahir ? ', ' : '' }}{{ $user->tanggal_lahir ? $user->tanggal_lahir->format('d M Y') : '' }}
                            @else — @endif
                        </div>
                    </div>
                </div>
                <div class="pf-info-item">
                    <div class="pf-info-ico"><i class="bi bi-book"></i></div>
                    <div>
                        <div class="pf-info-lbl">Agama</div>
                        <div class="pf-info-val">{{ $user->agama ?? '—' }}</div>
                    </div>
                </div>
                <div class="pf-info-item">
                    <div class="pf-info-ico"><i class="bi bi-heart"></i></div>
                    <div>
                        <div class="pf-info-lbl">Status Pernikahan</div>
                        <div class="pf-info-val">{{ $user->status_pernikahan ?? '—' }}</div>
                    </div>
                </div>
                <div class="pf-info-item">
                    <div class="pf-info-ico"><i class="bi bi-envelope-at"></i></div>
                    <div style="min-width:0;">
                        <div class="pf-info-lbl">Email</div>
                        <div class="pf-info-val" style="font-size:.8rem; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $user->email }}</div>
                    </div>
                </div>
                <div class="pf-info-item">
                    <div class="pf-info-ico"><i class="bi bi-shield-check"></i></div>
                    <div>
                        <div class="pf-info-lbl">Status Akun</div>
                        <div class="pf-info-val">{{ $isActive ? 'Aktif' : 'Nonaktif' }}</div>
                    </div>
                </div>
                <div class="pf-info-item">
                    <div class="pf-info-ico"><i class="bi bi-person-badge"></i></div>
                    <div>
                        <div class="pf-info-lbl">Peran</div>
                        <div class="pf-info-val">{{ $user->role ? ucfirst($user->role) : '—' }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tentang --}}
        <div class="admin-card mb-4">
            <div class="admin-card-header">
                <h6 class="admin-card-title"><i class="bi bi-chat-quote me-2 text-primary"></i>Tentang Saya</h6>
            </div>
            <p class="pf-body-text mb-0">
                {{ $user->tentang ?: 'Belum ada deskripsi tentang diri.' }}
            </p>
        </div>

        {{-- Alamat --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h6 class="admin-card-title"><i class="bi bi-geo-alt-fill me-2 text-primary"></i>Alamat</h6>
            </div>
            <p class="pf-body-text mb-0">
                {{ $user->alamat ?: 'Alamat belum diisi.' }}
            </p>
        </div>

    </div>
</div>

@endsection
