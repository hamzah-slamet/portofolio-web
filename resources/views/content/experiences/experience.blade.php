{{-- resources/views/content/experiences/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Experience')
@section('topbar-title', 'Experience')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/content/experience/experiences-style.css') }}">
@endpush

@section('page-header')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h4 class="mb-1" style="font-size:1.25rem; font-weight:800; color:var(--text-primary);">Experience</h4>
            <p class="text-muted mb-0" style="font-size:.78rem;">Kelola riwayat pengalaman kerja</p>
        </div>
        <a href="{{ route('experiences.create') }}" class="btn-admin-primary">
            <i class="bi bi-plus-lg"></i> Tambah Experience
        </a>
    </div>
@endsection

@section('content')

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Stats --}}
    <div class="exp-stats">
        <div class="exp-stat-card">
            <div class="exp-stat-icon" style="background:#eff6ff; color:#2563eb;">
                <i class="bi bi-briefcase-fill"></i>
            </div>
            <div>
                <div class="exp-stat-num">{{ $total }}</div>
                <div class="exp-stat-lbl">Total Pengalaman</div>
            </div>
        </div>
        <div class="exp-stat-card">
            <div class="exp-stat-icon" style="background:#f0fdf4; color:#16a34a;">
                <i class="bi bi-circle-fill" style="font-size:.75rem;"></i>
            </div>
            <div>
                <div class="exp-stat-num" style="color:#16a34a;">{{ $activeCount }}</div>
                <div class="exp-stat-lbl">Aktif Sekarang</div>
            </div>
        </div>
        <div class="exp-stat-card">
            <div class="exp-stat-icon" style="background:#fffbeb; color:#d97706;">
                <i class="bi bi-clock-history"></i>
            </div>
            <div>
                <div class="exp-stat-num" style="color:#d97706;">{{ $totalDuration ?: '-' }}</div>
                <div class="exp-stat-lbl">Total Pengalaman</div>
            </div>
        </div>
    </div>

    @if($experiences->isEmpty())
        <div class="admin-card text-center py-5">
            <i class="bi bi-briefcase" style="font-size:3rem; color:var(--text-muted); opacity:.4;"></i>
            <p class="mt-3 text-muted">Belum ada experience. Tambahkan pengalaman kerja pertamamu!</p>
            <a href="{{ route('experiences.create') }}" class="btn-admin-primary mt-2">
                <i class="bi bi-plus-lg"></i> Tambah Experience
            </a>
        </div>
    @else

    <div class="row g-4">

        {{-- Timeline --}}
        <div class="col-lg-8">
            <div class="timeline">

                @foreach($experiences as $exp)
                <div class="timeline-item">
                    <div class="timeline-dot {{ $exp->is_current ? '' : 'inactive' }}"></div>
                    <div class="exp-card">

                        <div class="exp-card-top">
                            <div class="d-flex align-items-start gap-3">
                                <div class="exp-logo" style="{{ $exp->is_current ? 'background:#eff6ff; color:#2563eb;' : 'background:#f3f4f6; color:#6b7280;' }}">
                                    @switch($exp->company_type)
                                        @case('startup')
                                            <i class="bi bi-rocket-takeoff-fill"></i>
                                            @break
                                        @case('freelance')
                                            <i class="bi bi-person-workspace"></i>
                                            @break
                                        @default
                                            <i class="bi bi-building-fill"></i>
                                    @endswitch
                                </div>
                                <div>
                                    <div class="exp-position">{{ $exp->position }}</div>
                                    <div class="exp-company">
                                        <i class="bi bi-building me-1"></i>{{ $exp->company }}
                                    </div>
                                    <div class="exp-period">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        {{ $exp->period }} &nbsp;·&nbsp; {{ $exp->duration }}
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-2 flex-shrink-0">
                                @if($exp->is_current)
                                    <span class="badge-admin green">
                                        <i class="bi bi-circle-fill" style="font-size:.4rem;"></i> Aktif
                                    </span>
                                @else
                                    <span class="badge-admin gray">Selesai</span>
                                @endif

                                <a href="{{ route('experiences.edit', $exp) }}" class="btn-admin-edit">
                                    <i class="bi bi-pencil-fill"></i> Edit
                                </a>

                                {{-- Tombol Delete — trigger modal custom --}}
                                <button type="button"
                                        class="btn-admin-danger"
                                        data-position="{{ $exp->position }}"
                                        data-company="{{ $exp->company }}"
                                        data-action="{{ route('experiences.destroy', $exp) }}"
                                        onclick="openDeleteExpModal(this)">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </div>
                        </div>

                        @if($exp->description)
                        <div class="exp-desc-wrap">
                            <div class="exp-desc-label">Deskripsi</div>
                            <p class="exp-desc-text">{{ $exp->description }}</p>
                        </div>
                        @endif

                        <div class="exp-card-footer">
                            <div class="d-flex flex-wrap gap-1">
                                @foreach($exp->skills_list as $skill)
                                    <span class="exp-tag">{{ $skill }}</span>
                                @endforeach
                            </div>
                            @if($exp->location)
                            <span style="font-size:.72rem; color:var(--text-muted);">
                                <i class="bi bi-geo-alt me-1"></i>{{ $exp->location }}
                            </span>
                            @endif
                        </div>

                    </div>
                </div>
                @endforeach

            </div>{{-- end .timeline --}}
        </div>

        {{-- Right: Summary --}}
        <div class="col-lg-4">
            <div class="admin-card" style="position:sticky; top:84px;">

                <div class="admin-card-header">
                    <h6 class="admin-card-title">
                        <i class="bi bi-person-badge me-2 text-primary"></i>Ringkasan Karir
                    </h6>
                </div>

                <div class="summary-row">
                    <span class="summary-lbl">Total Pengalaman</span>
                    <span class="summary-val">{{ $total }} posisi</span>
                </div>
                <div class="summary-row">
                    <span class="summary-lbl">Durasi Total</span>
                    <span class="summary-val">{{ $totalDuration ?: '-' }}</span>
                </div>
                <div class="summary-row">
                    <span class="summary-lbl">Posisi Saat Ini</span>
                    <span class="summary-val" style="color:#2563eb;">
                        {{ $current?->position ?? '-' }}
                    </span>
                </div>
                <div class="summary-row">
                    <span class="summary-lbl">Perusahaan</span>
                    <span class="summary-val">{{ $current?->company ?? '-' }}</span>
                </div>
                <div class="summary-row">
                    <span class="summary-lbl">Mulai Karir</span>
                    <span class="summary-val">{{ $oldest?->start_date->translatedFormat('M Y') ?? '-' }}</span>
                </div>

                @if($experiences->count() > 1)
                <hr style="border-color:var(--card-border); margin:16px 0;">
                <div style="font-size:.72rem; font-weight:700; text-transform:uppercase;
                    letter-spacing:1px; color:var(--text-muted); margin-bottom:12px;">
                    Perkembangan Karir
                </div>

                @php
                    $allMonths = $experiences->map(fn($e) => $e->start_date->diffInMonths(
                        $e->is_current ? now() : ($e->end_date ?? now())
                    ));
                    $maxMonth  = $allMonths->max() ?: 1;
                    $colors    = ['#db2777','#16a34a','#2563eb','#d97706','#7c3aed'];
                    $sorted    = $experiences->sortBy('start_date')->values();
                @endphp

                @foreach($sorted as $i => $e)
                    @php
                        $months = $e->start_date->diffInMonths($e->is_current ? now() : ($e->end_date ?? now()));
                        $pct    = round(($months / $maxMonth) * 100);
                        $color  = $colors[$i % count($colors)];
                    @endphp
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span style="font-size:.78rem; font-weight:600; color:var(--text-primary);">
                                {{ Str::limit($e->position, 22) }}
                            </span>
                            <span style="font-size:.72rem; color:var(--text-muted);">
                                {{ $e->start_date->format('Y') }}{{ $e->is_current ? '+' : '' }}
                            </span>
                        </div>
                        <div style="height:6px; background:var(--blue-light); border-radius:99px; overflow:hidden;">
                            <div style="height:100%; width:{{ $pct }}%; background:{{ $color }}; border-radius:99px;"></div>
                        </div>
                    </div>
                @endforeach
                @endif

            </div>
        </div>

    </div>
    @endif


    {{-- ════════════════════════════════════════════════════════════════════════ --}}
    {{-- HIDDEN FORM DELETE                                                      --}}
    {{-- ════════════════════════════════════════════════════════════════════════ --}}
    <form id="formDeleteExp" action="" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>


    {{-- ════════════════════════════════════════════════════════════════════════ --}}
    {{-- MODAL DELETE                                                            --}}
    {{-- ════════════════════════════════════════════════════════════════════════ --}}
    <div class="modal-overlay" id="deleteExpModal" onclick="closeOnOverlayDeleteExp(event)">
        <div class="modal-box">
            {{-- Header --}}
            <div style="display:flex; align-items:center; justify-content:flex-end; padding:14px 16px 0;">
                <button type="button" class="modal-close" onclick="closeDeleteExpModal()">
                    <i class="bi bi-x-lg" style="font-size:.8rem;"></i>
                </button>
            </div>

            {{-- Body --}}
            <div style="text-align:center; padding:8px 28px 20px;">
                <div style="width:60px; height:60px; border-radius:16px; background:#fef2f2;
                            display:flex; align-items:center; justify-content:center;
                            margin:0 auto 16px; border:1px solid #fecaca;">
                    <i class="bi bi-trash3-fill" style="font-size:1.5rem; color:#ef4444;"></i>
                </div>
                <div style="font-size:1rem; font-weight:800; color:var(--text-primary); margin-bottom:6px;">
                    Hapus Experience?
                </div>
                <div style="font-size:.85rem; color:var(--text-muted); line-height:1.6; margin-bottom:12px;">
                    Anda akan menghapus pengalaman<br>
                    <strong id="delete-exp-position" style="color:var(--text-primary);"></strong>
                    <span style="font-size:.78rem; display:block; margin-top:2px;">
                        <i class="bi bi-building me-1"></i>
                        <span id="delete-exp-company"></span>
                    </span>
                </div>
                <div style="padding:10px 14px; background:#fef2f2; border-radius:10px;
                            border:1px solid #fecaca; font-size:.78rem; color:#b91c1c; text-align:left;">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i>
                    Tindakan ini tidak dapat dibatalkan. Data experience akan dihapus permanen.
                </div>
            </div>

            {{-- Footer --}}
            <div style="display:flex; align-items:center; justify-content:center;
                        gap:10px; padding:0 28px 24px;">
                <button type="button" class="btn-admin-secondary" onclick="closeDeleteExpModal()">
                    Batal
                </button>
                <button type="button" onclick="confirmDeleteExp()"
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
<script>
    function openDeleteExpModal(btn) {
        document.getElementById('delete-exp-position').textContent = btn.dataset.position;
        document.getElementById('delete-exp-company').textContent  = btn.dataset.company;
        document.getElementById('formDeleteExp').action            = btn.dataset.action;
        document.getElementById('deleteExpModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteExpModal() {
        document.getElementById('deleteExpModal').classList.remove('active');
        document.body.style.overflow = '';
    }

    function closeOnOverlayDeleteExp(e) {
        if (e.target === document.getElementById('deleteExpModal')) closeDeleteExpModal();
    }

    function confirmDeleteExp() {
        document.getElementById('formDeleteExp').submit();
    }
</script>
@endpush
