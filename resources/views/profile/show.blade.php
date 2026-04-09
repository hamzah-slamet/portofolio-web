{{-- resources/views/profile/show.blade.php --}}

@extends('layouts.app')

@section('title', 'Profil Saya')
@section('topbar-title', 'Profil Saya')

@push('styles')
<style>
    .profile-main-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .profile-avatar-wrap {
        padding: 22px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }

    .profile-avatar {
        width: 72px;
        height: 72px;
        border-radius: 14px;
        border: 2px solid var(--card-border);
        object-fit: cover;
        box-shadow: 0 2px 8px rgba(0,0,0,.08);
        flex-shrink: 0;
    }

    .profile-avatar-placeholder {
        width: 72px;
        height: 72px;
        border-radius: 14px;
        background: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        font-weight: 800;
        color: white;
        flex-shrink: 0;
    }

    .profile-name {
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--text-primary);
        line-height: 1.2;
    }

    .profile-email {
        font-size: .8rem;
        color: var(--text-muted);
        margin-top: 3px;
    }

    .profile-uid-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #eff6ff;
        color: #2563eb;
        font-size: .7rem;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 99px;
        border: 1px solid #bfdbfe;
        margin-right: 6px;
    }

    .profile-role-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #f0fdf4;
        color: #16a34a;
        font-size: .7rem;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 99px;
        border: 1px solid #bbf7d0;
    }

    /* Info grid */
    .profile-info-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        margin-bottom: 16px;
    }

    .profile-info-grid-2 {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        margin-bottom: 16px;
    }

    .profile-info-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 12px;
        padding: 14px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .profile-info-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .profile-info-lbl {
        font-size: .65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .9px;
        color: var(--text-muted);
    }

    .profile-info-val {
        font-size: .875rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-top: 2px;
    }

    .profile-section-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 16px;
        padding: 20px 22px;
        margin-bottom: 16px;
    }

    .profile-section-title {
        font-size: .72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--text-muted);
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .profile-section-body {
        font-size: .9rem;
        color: var(--text-secondary);
        line-height: 1.8;
    }

    .profile-detail-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0;
    }

    .profile-detail-row {
        display: flex;
        flex-direction: column;
        padding: 10px 0;
        border-bottom: 1px solid var(--card-border);
    }

    .profile-detail-row:nth-child(odd)  { padding-right: 24px; }
    .profile-detail-row:nth-child(even) { padding-left: 24px; border-left: 1px solid var(--card-border); }

    .profile-detail-lbl {
        font-size: .68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .8px;
        color: var(--text-muted);
        margin-bottom: 3px;
    }

    .profile-detail-val {
        font-size: .875rem;
        font-weight: 600;
        color: var(--text-primary);
    }

    @media (max-width: 991px) {
        .profile-info-grid, .profile-info-grid-2 { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 768px) {
        .profile-info-grid, .profile-info-grid-2 { grid-template-columns: repeat(2, 1fr); }
        .profile-avatar-wrap { flex-direction: column; align-items: flex-start; }
        .profile-detail-grid { grid-template-columns: 1fr; }
        .profile-detail-row:nth-child(even) { padding-left: 0; border-left: none; }
    }

    @media (max-width: 480px) {
        .profile-info-grid, .profile-info-grid-2 { grid-template-columns: 1fr; }
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
            <i class="bi bi-pencil-fill me-1"></i> Edit Profil
        </a>
    </div>
@endsection

@section('content')

    {{-- Card utama: avatar --}}
    <div class="profile-main-card">
        <div class="profile-avatar-wrap">
            <div class="d-flex align-items-center gap-3">
                @if($user->foto_profil)
                    <img src="{{ Storage::url($user->foto_profil) }}"
                         alt="{{ $user->name }}" class="profile-avatar">
                @else
                    <div class="profile-avatar-placeholder">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <div class="profile-name">{{ $user->name }}</div>
                    <div class="profile-email">{{ $user->email }}</div>
                    <div class="mt-2">
                        @if($user->user_id)
                            <span class="profile-uid-badge">
                                <i class="bi bi-person-badge" style="font-size:.75rem;"></i>
                                {{ $user->user_id }}
                            </span>
                        @endif
                        @if($user->role)
                            <span class="profile-role-badge">
                                <i class="bi bi-shield-fill" style="font-size:.7rem;"></i>
                                {{ ucfirst($user->role) }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div>
                <span class="badge-admin green">
                    <i class="bi bi-circle-fill" style="font-size:.4rem;"></i> Aktif
                </span>
            </div>
        </div>
    </div>

    {{-- Info row 1: Umur, TTL, Jenis Kelamin, Status --}}
    <div class="profile-info-grid">
        <div class="profile-info-card">
            <div class="profile-info-icon" style="background:#fffbeb; color:#d97706;">
                <i class="bi bi-calendar3"></i>
            </div>
            <div>
                <div class="profile-info-lbl">Umur</div>
                <div class="profile-info-val">{{ $user->umur ? $user->umur . ' tahun' : '—' }}</div>
            </div>
        </div>

        <div class="profile-info-card">
            <div class="profile-info-icon" style="background:#fdf4ff; color:#9333ea;">
                <i class="bi bi-geo-fill"></i>
            </div>
            <div>
                <div class="profile-info-lbl">Tempat, Tgl Lahir</div>
                <div class="profile-info-val" style="font-size:.78rem;">
                    @if($user->tempat_lahir || $user->tanggal_lahir)
                        {{ $user->tempat_lahir ?? '' }}{{ $user->tempat_lahir && $user->tanggal_lahir ? ', ' : '' }}{{ $user->tanggal_lahir ? $user->tanggal_lahir->format('d M Y') : '' }}
                    @else
                        —
                    @endif
                </div>
            </div>
        </div>

        <div class="profile-info-card">
            <div class="profile-info-icon" style="background:#eff6ff; color:#2563eb;">
                <i class="bi bi-gender-ambiguous"></i>
            </div>
            <div>
                <div class="profile-info-lbl">Jenis Kelamin</div>
                <div class="profile-info-val">{{ $user->jenis_kelamin ?? '—' }}</div>
            </div>
        </div>

        <div class="profile-info-card">
            <div class="profile-info-icon" style="background:#fff1f2; color:#e11d48;">
                <i class="bi bi-heart-fill"></i>
            </div>
            <div>
                <div class="profile-info-lbl">Status</div>
                <div class="profile-info-val">{{ $user->status_pernikahan ?? '—' }}</div>
            </div>
        </div>
    </div>

    {{-- Info row 2: Email, Agama, Kewarganegaraan, Status Akun --}}
    <div class="profile-info-grid-2">
        <div class="profile-info-card">
            <div class="profile-info-icon" style="background:#eff6ff; color:#2563eb;">
                <i class="bi bi-envelope-fill"></i>
            </div>
            <div style="min-width:0;">
                <div class="profile-info-lbl">Email</div>
                <div class="profile-info-val"
                     style="font-size:.78rem; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                    {{ $user->email }}
                </div>
            </div>
        </div>

        <div class="profile-info-card">
            <div class="profile-info-icon" style="background:#fefce8; color:#ca8a04;">
                <i class="bi bi-moon-stars-fill"></i>
            </div>
            <div>
                <div class="profile-info-lbl">Agama</div>
                <div class="profile-info-val">{{ $user->agama ?? '—' }}</div>
            </div>
        </div>

        <div class="profile-info-card">
            <div class="profile-info-icon" style="background:#f0fdf4; color:#16a34a;">
                <i class="bi bi-flag-fill"></i>
            </div>
            <div>
                <div class="profile-info-lbl">Kewarganegaraan</div>
                <div class="profile-info-val">{{ $user->kewarganegaraan ?? '—' }}</div>
            </div>
        </div>

        <div class="profile-info-card">
            <div class="profile-info-icon" style="background:#f0fdf4; color:#16a34a;">
                <i class="bi bi-shield-check-fill"></i>
            </div>
            <div>
                <div class="profile-info-lbl">Status Akun</div>
                @if(($user->status_akun ?? 'aktif') == 'aktif')
                    <div class="profile-info-val" style="color:#16a34a;">Aktif</div>
                @else
                    <div class="profile-info-val" style="color:#ef4444;">Nonaktif</div>
                @endif
            </div>
        </div>
    </div>

    {{-- Tentang --}}
    @if($user->tentang)
    <div class="profile-section-card">
        <div class="profile-section-title">
            <i class="bi bi-person-lines-fill text-primary"></i> Tentang Saya
        </div>
        <div class="profile-section-body">
            {{ $user->tentang }}
        </div>
    </div>
    @endif

    {{-- Alamat --}}
    <div class="profile-section-card">
        <div class="profile-section-title">
            <i class="bi bi-geo-alt-fill text-primary"></i> Alamat
        </div>
        <div class="profile-section-body">
            {{ $user->alamat ?? 'Alamat belum diisi.' }}
        </div>
    </div>

@endsection
