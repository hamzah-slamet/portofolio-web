{{-- resources/views/content/educations/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Pendidikan')
@section('topbar-title', 'Pendidikan')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/content/experience/experiences-style.css') }}">
<style>
/* ── Education-specific overrides ───────────────────────── */
.edu-degree-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 3px 10px;
    border-radius: 6px;
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: .3px;
    background: #eff6ff;
    color: #2563eb;
    border: 1px solid #bfdbfe;
}
.edu-gpa-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 3px 9px;
    border-radius: 6px;
    font-size: .72rem;
    font-weight: 700;
}
.edu-gpa-green  { background:#f0fdf4; color:#16a34a; border:1px solid #bbf7d0; }
.edu-gpa-blue   { background:#eff6ff; color:#2563eb; border:1px solid #bfdbfe; }
.edu-gpa-yellow { background:#fffbeb; color:#d97706; border:1px solid #fde68a; }
.edu-gpa-gray   { background:#f3f4f6; color:#6b7280; border:1px solid #e5e7eb; }

.achievement-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #fefce8;
    color: #a16207;
    border: 1px solid #fde68a;
    border-radius: 6px;
    padding: 3px 9px;
    font-size: .72rem;
    font-weight: 600;
}
.achievement-pill i { font-size: .65rem; color: #eab308; }
</style>
@endpush

@section('page-header')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h4 class="mb-1" style="font-size:1.25rem; font-weight:800; color:var(--text-primary);">Pendidikan</h4>
            <p class="text-muted mb-0" style="font-size:.78rem;">Kelola riwayat pendidikan</p>
        </div>
        <a href="{{ route('educations.create') }}" class="btn-admin-primary">
            <i class="bi bi-plus-lg"></i> Tambah Pendidikan
        </a>
    </div>
@endsection

@section('content')

    {{-- Flash sukses ditangani global via toast di layout --}}

    {{-- Stats --}}
    <div class="exp-stats">
        <div class="exp-stat-card">
            <div class="exp-stat-icon" style="background:#eff6ff; color:#2563eb;">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <div>
                <div class="exp-stat-num">{{ $total }}</div>
                <div class="exp-stat-lbl">Total Pendidikan</div>
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
                <i class="bi bi-calendar3"></i>
            </div>
            <div>
                <div class="exp-stat-num" style="color:#d97706;">
                    {{ $latest?->end_date?->format('Y') ?? ($latest?->is_current ? now()->format('Y') : '-') }}
                </div>
                <div class="exp-stat-lbl">Lulus Terakhir</div>
            </div>
        </div>
    </div>

    @if($educations->isEmpty())
        <div class="admin-card text-center py-5">
            <i class="bi bi-mortarboard" style="font-size:3rem; color:var(--text-muted); opacity:.4;"></i>
            <p class="mt-3 text-muted">Belum ada data pendidikan. Tambahkan riwayat pendidikanmu!</p>
            <a href="{{ route('educations.create') }}" class="btn-admin-primary mt-2">
                <i class="bi bi-plus-lg"></i> Tambah Pendidikan
            </a>
        </div>
    @else

    <div class="row g-4">

        {{-- Timeline --}}
        <div class="col-lg-8">
            <div class="timeline">

                @foreach($educations as $edu)
                <div class="timeline-item">
                    <div class="timeline-dot {{ $edu->is_current ? '' : 'inactive' }}"></div>
                    <div class="exp-card">

                        <div class="exp-card-top">
                            <div class="d-flex align-items-start gap-3">

                                {{-- Logo icon --}}
                                @php
                                    $iconMap = [
                                        'university' => ['icon' => 'bi-building-fill',        'bg' => '#eff6ff', 'color' => '#2563eb'],
                                        'school'     => ['icon' => 'bi-house-fill',            'bg' => '#f0fdf4', 'color' => '#16a34a'],
                                        'bootcamp'   => ['icon' => 'bi-lightning-charge-fill', 'bg' => '#fff7ed', 'color' => '#ea580c'],
                                        'course'     => ['icon' => 'bi-play-circle-fill',      'bg' => '#fdf4ff', 'color' => '#9333ea'],
                                    ];
                                    $ico = $iconMap[$edu->institution_type] ?? $iconMap['university'];
                                @endphp
                                <div class="exp-logo" style="background:{{ $ico['bg'] }}; color:{{ $ico['color'] }};">
                                    <i class="bi {{ $ico['icon'] }}"></i>
                                </div>

                                <div>
                                    <div class="exp-position">{{ $edu->major }}</div>
                                    <div style="font-size:.8rem; font-weight:600; color:var(--text-secondary); margin-bottom:2px;">
                                        {{ $edu->degree }}
                                    </div>
                                    <div class="exp-company">
                                        <i class="bi bi-building me-1"></i>{{ $edu->institution }}
                                    </div>
                                    <div class="exp-period">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        {{ $edu->period }} &nbsp;·&nbsp; {{ $edu->duration }}
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-2 flex-shrink-0 flex-wrap justify-content-end">
                                {{-- GPA badge --}}
                                @if($edu->gpa)
                                    <span class="edu-gpa-badge edu-gpa-{{ $edu->gpa_color }}">
                                        <i class="bi bi-star-fill" style="font-size:.6rem;"></i>
                                        GPA {{ number_format($edu->gpa, 2) }}
                                    </span>
                                @endif

                                @if($edu->is_current)
                                    <span class="badge-admin green">
                                        <i class="bi bi-circle-fill" style="font-size:.4rem;"></i> Aktif
                                    </span>
                                @else
                                    <span class="badge-admin gray">Lulus</span>
                                @endif

                                <a href="{{ route('educations.edit', $edu) }}" class="btn-admin-edit">
                                    <i class="bi bi-pencil-fill"></i> Edit
                                </a>

                                <form action="{{ route('educations.destroy', $edu) }}" method="POST"
                                      onsubmit="return confirm('Hapus data pendidikan ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-admin-danger">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        @if($edu->description)
                        <div class="exp-desc-wrap">
                            <div class="exp-desc-label">Deskripsi</div>
                            <p class="exp-desc-text">{{ $edu->description }}</p>
                        </div>
                        @endif

                        {{-- Achievements + Location --}}
                        <div class="exp-card-footer">
                            <div class="d-flex flex-wrap gap-1">
                                @foreach($edu->achievements_list as $ach)
                                    <span class="achievement-pill">
                                        <i class="bi bi-trophy-fill"></i>{{ $ach }}
                                    </span>
                                @endforeach
                            </div>
                            @if($edu->location)
                            <span style="font-size:.72rem; color:var(--text-muted);">
                                <i class="bi bi-geo-alt me-1"></i>{{ $edu->location }}
                            </span>
                            @endif
                        </div>

                    </div>
                </div>
                @endforeach

            </div>
        </div>

        {{-- Right: Summary --}}
        <div class="col-lg-4">
            <div class="admin-card" style="position:sticky; top:84px;">

                <div class="admin-card-header">
                    <h6 class="admin-card-title">
                        <i class="bi bi-person-badge me-2 text-primary"></i>Ringkasan Pendidikan
                    </h6>
                </div>

                <div class="summary-row">
                    <span class="summary-lbl">Total Pendidikan</span>
                    <span class="summary-val">{{ $total }} jenjang</span>
                </div>
                <div class="summary-row">
                    <span class="summary-lbl">Durasi Total</span>
                    <span class="summary-val">{{ $totalDuration ?: '-' }}</span>
                </div>
                <div class="summary-row">
                    <span class="summary-lbl">Pendidikan Saat Ini</span>
                    <span class="summary-val" style="color:#2563eb;">
                        {{ $current ? $current->degree.' – '.$current->major : '-' }}
                    </span>
                </div>
                <div class="summary-row">
                    <span class="summary-lbl">Institusi</span>
                    <span class="summary-val">{{ $current?->institution ?? $latest?->institution ?? '-' }}</span>
                </div>
                <div class="summary-row">
                    <span class="summary-lbl">Mulai Pendidikan</span>
                    <span class="summary-val">{{ $oldest?->start_date->format('Y') ?? '-' }}</span>
                </div>

                @if($educations->count() > 1)
                <hr style="border-color:var(--card-border); margin:16px 0;">
                <div style="font-size:.72rem; font-weight:700; text-transform:uppercase;
                    letter-spacing:1px; color:var(--text-muted); margin-bottom:12px;">
                    Jenjang Pendidikan
                </div>

                @php
                    $colors = ['#db2777','#16a34a','#2563eb','#d97706','#7c3aed'];
                    $sorted = $educations->sortBy('start_date')->values();
                    $allMonths = $sorted->map(fn($e) => $e->start_date->diffInMonths(
                        $e->is_current ? now() : ($e->end_date ?? now())
                    ));
                    $maxMonth = $allMonths->max() ?: 1;
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
                                {{ Str::limit($e->degree, 24) }}
                            </span>
                            <span style="font-size:.72rem; color:var(--text-muted);">
                                {{ $e->start_date->format('Y') }}{{ $e->is_current ? '+' : ' – '.$e->graduation_year }}
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

@endsection
