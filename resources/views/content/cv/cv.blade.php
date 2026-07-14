{{-- resources/views/documents/cv.blade.php --}}

@extends('layouts.app')

@section('title', 'Daftar Riwayat Hidup')
@section('topbar-title', 'Daftar Riwayat Hidup')

@push('styles')
<style>
    /* Wrapper halaman */
    .cv-page-wrap {
        display: flex;
        gap: 24px;
        align-items: flex-start;
    }

    /* Panel kontrol kiri */
    .cv-controls {
        width: 220px;
        flex-shrink: 0;
        position: sticky;
        top: 84px;
    }

    .cv-control-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 14px;
        padding: 18px;
        margin-bottom: 14px;
    }

    .cv-control-title {
        font-size: .7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--text-muted);
        margin-bottom: 12px;
    }

    .cv-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        width: 100%;
        padding: 9px 14px;
        border-radius: 10px;
        font-size: .82rem;
        font-weight: 600;
        cursor: pointer;
        transition: all .2s;
        border: none;
        margin-bottom: 8px;
        text-decoration: none;
    }

    .cv-btn:last-child { margin-bottom: 0; }

    .cv-btn-primary {
        background: #2563eb;
        color: white;
    }
    .cv-btn-primary:hover { background: #1d4ed8; color: white; }

    .cv-btn-outline {
        background: none;
        border: 1px solid var(--card-border);
        color: var(--text-secondary);
    }
    .cv-btn-outline:hover { background: var(--body-bg); }

    /* Area preview */
    .cv-preview-area {
        flex: 1;
        min-width: 0;
    }

    /* Shadow & frame efek kertas */
    .cv-paper-frame {
        background: #e2e8f0;
        border-radius: 12px;
        padding: 32px 24px;
    }

    /* Dokumen CV itu sendiri — ukuran A4 */
    .cv-doc {
        background: #ffffff;
        width: 100%;
        max-width: 794px;
        margin: 0 auto;
        box-shadow: 0 8px 40px rgba(0,0,0,.18), 0 2px 8px rgba(0,0,0,.08);
        border-radius: 2px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #1e293b;
        overflow: hidden;
    }

    /* Header CV */
    .cv-header {
        background: #1e3a5f;
        padding: 36px 40px 28px;
        display: flex;
        align-items: center;
        gap: 28px;
    }

    .cv-photo {
        width: 90px;
        height: 90px;
        border-radius: 12px;
        object-fit: cover;
        border: 3px solid rgba(255,255,255,.3);
        flex-shrink: 0;
    }

    .cv-photo-placeholder {
        width: 90px;
        height: 90px;
        border-radius: 12px;
        background: rgba(255,255,255,.15);
        border: 3px solid rgba(255,255,255,.3);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        font-weight: 800;
        color: white;
        flex-shrink: 0;
    }

    .cv-header-info { flex: 1; }

    .cv-name {
        font-size: 1.75rem;
        font-weight: 800;
        color: #ffffff;
        line-height: 1.2;
        letter-spacing: -.3px;
    }

    .cv-title {
        font-size: .92rem;
        color: #93c5fd;
        font-weight: 600;
        margin-top: 4px;
    }

    .cv-contacts {
        display: flex;
        flex-wrap: wrap;
        gap: 6px 20px;
        margin-top: 14px;
    }

    .cv-contact-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: .75rem;
        color: rgba(255,255,255,.75);
    }

    .cv-contact-item i { color: #93c5fd; font-size: .82rem; }

    /* Body CV 2 kolom */
    .cv-body {
        display: grid;
        grid-template-columns: 1fr 2fr;
    }

    /* Kolom kiri */
    .cv-col-left {
        background: #f1f5f9;
        padding: 28px 24px;
        border-right: 1px solid #e2e8f0;
    }

    /* Kolom kanan */
    .cv-col-right {
        padding: 28px 32px;
    }

    /* Section */
    .cv-section {
        margin-bottom: 24px;
    }

    .cv-section:last-child { margin-bottom: 0; }

    .cv-section-title {
        font-size: .65rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #2563eb;
        margin-bottom: 12px;
        padding-bottom: 6px;
        border-bottom: 2px solid #bfdbfe;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Skill bar */
    .cv-skill-item {
        margin-bottom: 10px;
    }

    .cv-skill-name {
        display: flex;
        justify-content: space-between;
        font-size: .75rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: 4px;
    }

    .cv-skill-pct { color: #2563eb; }

    .cv-skill-bar {
        height: 5px;
        background: #e2e8f0;
        border-radius: 99px;
        overflow: hidden;
    }

    .cv-skill-fill {
        height: 100%;
        background: linear-gradient(90deg, #2563eb, #60a5fa);
        border-radius: 99px;
    }

    /* Info list kiri */
    .cv-info-item {
        display: flex;
        flex-direction: column;
        margin-bottom: 10px;
    }

    .cv-info-lbl {
        font-size: .65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .8px;
        color: #94a3b8;
        margin-bottom: 2px;
    }

    .cv-info-val {
        font-size: .78rem;
        font-weight: 600;
        color: #1e293b;
    }

    /* Bahasa */
    .cv-lang-item {
        margin-bottom: 8px;
    }

    .cv-lang-top {
        display: flex;
        justify-content: space-between;
        font-size: .75rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: 3px;
    }

    .cv-lang-dots {
        display: flex;
        gap: 4px;
    }

    .cv-lang-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #e2e8f0;
    }

    .cv-lang-dot.filled { background: #2563eb; }

    /* Experience & Education di kanan */
    .cv-entry {
        position: relative;
        padding-left: 18px;
        margin-bottom: 18px;
    }

    .cv-entry:last-child { margin-bottom: 0; }

    .cv-entry::before {
        content: '';
        position: absolute;
        left: 0;
        top: 6px;
        bottom: -18px;
        width: 2px;
        background: #e2e8f0;
    }

    .cv-entry:last-child::before { display: none; }

    .cv-entry-dot {
        position: absolute;
        left: -4px;
        top: 5px;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #2563eb;
        border: 2px solid white;
        box-shadow: 0 0 0 2px #2563eb;
    }

    .cv-entry-dot.gray {
        background: #cbd5e1;
        box-shadow: 0 0 0 2px #cbd5e1;
    }

    .cv-entry-title {
        font-size: .85rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.3;
    }

    .cv-entry-sub {
        font-size: .75rem;
        font-weight: 600;
        color: #2563eb;
        margin-top: 1px;
    }

    .cv-entry-period {
        font-size: .7rem;
        color: #94a3b8;
        margin-top: 2px;
    }

    .cv-entry-desc {
        font-size: .75rem;
        color: #475569;
        line-height: 1.7;
        margin-top: 6px;
    }

    /* Tags proyek */
    .cv-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
        margin-top: 6px;
    }

    .cv-tag {
        font-size: .65rem;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 4px;
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
    }

    /* Footer CV */
    .cv-footer {
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        padding: 12px 40px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .cv-footer-text {
        font-size: .68rem;
        color: #94a3b8;
    }

    /* Zoom controls */
    .zoom-wrap {
        display: flex;
        align-items: center;
        gap: 8px;
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 10px;
        padding: 6px 12px;
        margin-bottom: 14px;
    }

    .zoom-btn {
        width: 28px;
        height: 28px;
        border-radius: 7px;
        border: 1px solid var(--card-border);
        background: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: var(--text-secondary);
        font-size: .85rem;
        transition: background .15s;
    }
    .zoom-btn:hover { background: var(--body-bg); }

    .zoom-val {
        font-size: .78rem;
        font-weight: 700;
        color: var(--text-primary);
        min-width: 36px;
        text-align: center;
    }

    @media (max-width: 991px) {
        .cv-controls { display: none; }
        .cv-paper-frame { padding: 16px 8px; }
        .cv-body { grid-template-columns: 1fr; }
        .cv-col-left { border-right: none; border-bottom: 1px solid #e2e8f0; }
    }
</style>
@endpush

@section('page-header')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h4 class="mb-1" style="font-size:1.25rem; font-weight:800; color:var(--text-primary);">
                Daftar Riwayat Hidup
            </h4>
            <p class="text-muted mb-0" style="font-size:.78rem;">Preview dan unduh CV Anda</p>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn-admin-primary">
                <i class="bi bi-printer"></i> Print
            </button>
            <a href="{{ route('cv.download') }}" class="btn-admin-primary">
                <i class="bi bi-download"></i> Unduh PDF
            </a>
        </div>
    </div>
@endsection

@section('content')

<div class="cv-page-wrap">

    {{-- Panel kontrol kiri --}}
    <div class="cv-controls">

        {{-- Zoom --}}
        <div class="cv-control-card">
            <div class="cv-control-title">Tampilan</div>
            <div class="zoom-wrap" style="margin-bottom:0;">
                <button class="zoom-btn" onclick="zoomCV(-10)"><i class="bi bi-dash"></i></button>
                <span class="zoom-val" id="zoomVal">100%</span>
                <button class="zoom-btn" onclick="zoomCV(10)"><i class="bi bi-plus"></i></button>
            </div>
        </div>

    </div>

    {{-- Area preview --}}
    <div class="cv-preview-area">
        <div class="cv-paper-frame" id="cvPaperFrame">

            {{-- ═══════════════════════════════ DOKUMEN CV ═══════════════════════════════ --}}
            <div class="cv-doc" id="cvDoc">

                {{-- Header --}}
                <div class="cv-header">
                {{-- Foto profil --}}
                @if($user->foto_profil)
                    <img src="{{ Storage::url($user->foto_profil) }}"
                        class="cv-photo" alt="{{ $user->name }}">
                @else
                    <div class="cv-photo-placeholder">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif

                <div class="cv-header-info">
                    <div class="cv-name">{{ $user->name }}</div>
                    <div class="cv-title">{{ $config->profile_position ?? 'Web Developer' }}</div>
                    <div class="cv-contacts">
                        <div class="cv-contact-item">
                            <i class="bi bi-envelope-fill"></i> {{ $user->email }}
                        </div>
                        @if($user->umur)
                        <div class="cv-contact-item">
                            <i class="bi bi-cake2-fill"></i> {{ $user->umur }} tahun
                        </div>
                        @endif
                        @if($user->alamat)
                        <div class="cv-contact-item">
                            <i class="bi bi-geo-alt-fill"></i> {{ $user->alamat }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>

                {{-- Body 2 kolom --}}
                <div class="cv-body">

                    {{-- ── Kolom Kiri ── --}}
                    <div class="cv-col-left">

                        {{-- Info Pribadi --}}
                         <div class="cv-section">
                            <div class="cv-section-title">
                                <i class="bi bi-person-fill"></i> Info Pribadi
                            </div>
                            <div class="cv-info-item">
                                <span class="cv-info-lbl">Tempat, Tgl Lahir</span>
                                <span class="cv-info-val">
                                    @if($user->tempat_lahir || $user->tanggal_lahir)
                                        {{ $user->tempat_lahir ?? '' }}
                                        {{ $user->tempat_lahir && $user->tanggal_lahir ? ', ' : '' }}
                                        {{ $user->tanggal_lahir ? $user->tanggal_lahir->format('d F Y') : '' }}
                                    @else
                                        —
                                    @endif
                                </span>
                            </div>
                            <div class="cv-info-item">
                                <span class="cv-info-lbl">Jenis Kelamin</span>
                                <span class="cv-info-val">{{ $user->jenis_kelamin ?? '—' }}</span>
                            </div>
                            <div class="cv-info-item">
                                <span class="cv-info-lbl">Agama</span>
                                <span class="cv-info-val">{{ $user->agama ?? '—' }}</span>
                            </div>
                            <div class="cv-info-item">
                                <span class="cv-info-lbl">Status</span>
                                <span class="cv-info-val">{{ $user->status_pernikahan ?? '—' }}</span>
                            </div>
                            <div class="cv-info-item">
                                <span class="cv-info-lbl">Kewarganegaraan</span>
                                <span class="cv-info-val">{{ $user->kewarganegaraan ?? '—' }}</span>
                            </div>
                        </div>
                        {{-- Keahlian --}}
                        <div class="cv-section">
                            <div class="cv-section-title">
                                <i class="bi bi-lightning-fill"></i> Keahlian
                            </div>
                            @forelse($skills as $skill)
                                <div class="cv-skill-item">
                                    <div class="cv-skill-name">
                                        <span>{{ $skill->name }}</span>
                                        <span class="cv-skill-pct">{{ $skill->level }}%</span>
                                    </div>
                                    <div class="cv-skill-bar">
                                        <div class="cv-skill-fill" style="width:{{ min(100, (int) $skill->level) }}%;"></div>
                                    </div>
                                </div>
                            @empty
                                <p style="font-size:.72rem; color:#94a3b8;">Belum ada data keahlian.</p>
                            @endforelse
                        </div>

                        {{-- Bahasa --}}
                        <div class="cv-section">
                            <div class="cv-section-title">
                                <i class="bi bi-translate"></i> Bahasa
                            </div>
                            @php
                                $langs = [
                                    ['name' => 'Indonesia', 'level' => 'Native',      'dots' => 5],
                                    ['name' => 'Inggris',   'level' => 'Professional', 'dots' => 4],
                                ];
                            @endphp
                            @foreach($langs as $lang)
                                <div class="cv-lang-item">
                                    <div class="cv-lang-top">
                                        <span>{{ $lang['name'] }}</span>
                                        <span style="color:#94a3b8; font-size:.68rem;">{{ $lang['level'] }}</span>
                                    </div>
                                    <div class="cv-lang-dots">
                                        @for($i = 1; $i <= 5; $i++)
                                            <div class="cv-lang-dot {{ $i <= $lang['dots'] ? 'filled' : '' }}"></div>
                                        @endfor
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Minat --}}
                        <div class="cv-section">
                            <div class="cv-section-title">
                                <i class="bi bi-heart-fill"></i> Minat
                            </div>
                            <div style="display:flex; flex-wrap:wrap; gap:5px;">
                                @foreach(['Open Source', 'UI/UX', 'Cloud', 'DevOps', 'AI/ML'] as $interest)
                                    <span style="font-size:.68rem; font-weight:600; padding:3px 9px;
                                                 border-radius:99px; background:#e0f2fe; color:#0369a1;
                                                 border:1px solid #bae6fd;">
                                        {{ $interest }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                    </div>

                    {{-- ── Kolom Kanan ── --}}
                    <div class="cv-col-right">

                        {{-- Tentang --}}
                        <div class="cv-section">
                            <div class="cv-section-title">
                                <i class="bi bi-file-person-fill"></i> Tentang Saya
                            </div>
                            <p style="font-size:.78rem; color:#475569; line-height:1.8; margin:0;">
                                {{ $user->tentang ?: 'Belum ada deskripsi. Isi di menu Profil → Tentang Saya.' }}
                            </p>
                        </div>

                        {{-- Pengalaman Kerja --}}
                        <div class="cv-section">
                            <div class="cv-section-title">
                                <i class="bi bi-briefcase-fill"></i> Pengalaman Kerja
                            </div>

                            @forelse($experiences as $exp)
                                <div class="cv-entry">
                                    <div class="cv-entry-dot {{ $exp->is_current ? '' : 'gray' }}"></div>
                                    <div class="cv-entry-title">{{ $exp->position }}</div>
                                    <div class="cv-entry-sub">{{ $exp->company }}</div>
                                    <div class="cv-entry-period">
                                        {{ optional($exp->start_date)->format('M Y') }} –
                                        {{ $exp->is_current ? 'Sekarang' : optional($exp->end_date)->format('M Y') }}
                                        @if($exp->location) &nbsp;·&nbsp; {{ $exp->location }} @endif
                                    </div>
                                    @if($exp->description)
                                        <div class="cv-entry-desc">{{ $exp->description }}</div>
                                    @endif
                                    @if(!empty($exp->skills) && is_array($exp->skills))
                                        <div class="cv-tags">
                                            @foreach($exp->skills as $s)<span class="cv-tag">{{ $s }}</span>@endforeach
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <p style="font-size:.75rem; color:#94a3b8;">Belum ada data pengalaman.</p>
                            @endforelse
                        </div>

                        {{-- Pendidikan --}}
                        <div class="cv-section">
                            <div class="cv-section-title">
                                <i class="bi bi-mortarboard-fill"></i> Pendidikan
                            </div>

                            @forelse($educations as $edu)
                                <div class="cv-entry">
                                    <div class="cv-entry-dot {{ $edu->is_current ? '' : 'gray' }}"></div>
                                    <div class="cv-entry-title">{{ $edu->degree }}@if($edu->major) — {{ $edu->major }}@endif</div>
                                    <div class="cv-entry-sub">{{ $edu->institution }}</div>
                                    <div class="cv-entry-period">
                                        {{ optional($edu->start_date)->format('Y') }} –
                                        {{ $edu->is_current ? 'Sekarang' : optional($edu->end_date)->format('Y') }}
                                        @if($edu->gpa) &nbsp;·&nbsp; IPK {{ $edu->gpa }} @endif
                                    </div>
                                    @if($edu->description)
                                        <div class="cv-entry-desc">{{ $edu->description }}</div>
                                    @endif
                                </div>
                            @empty
                                <p style="font-size:.75rem; color:#94a3b8;">Belum ada data pendidikan.</p>
                            @endforelse
                        </div>

                        {{-- Proyek Unggulan --}}
                        <div class="cv-section">
                            <div class="cv-section-title">
                                <i class="bi bi-folder-fill"></i> Proyek Unggulan
                            </div>

                            @forelse($projects as $project)
                                <div style="margin-bottom:12px; padding:10px 14px;
                                            background:#f8fafc; border-radius:8px;
                                            border:1px solid #e2e8f0;">
                                    <div style="font-size:.8rem; font-weight:800; color:#0f172a;">
                                        {{ $project->title }}
                                    </div>
                                    <div style="font-size:.72rem; color:#64748b; margin-top:3px; line-height:1.6; text-align:justify;">
                                        {{ $project->description }}
                                    </div>
                                    @if(!empty($project->tech_stack) && is_array($project->tech_stack))
                                        <div class="cv-tags">
                                            @foreach($project->tech_stack as $tag)
                                                <span class="cv-tag">{{ $tag }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <p style="font-size:.75rem; color:#94a3b8;">Belum ada data proyek.</p>
                            @endforelse
                        </div>

                    </div>
                </div>

                {{-- Footer dokumen --}}
                <div class="cv-footer">
                    <span class="cv-footer-text">
                        Dibuat: {{ now()->format('d F Y') }}
                    </span>
                    <span class="cv-footer-text">
                        {{ $user->name }} &mdash; Daftar Riwayat Hidup
                    </span>
                    <span class="cv-footer-text">Hal. 1 / 1</span>
                </div>

            </div>
            {{-- ═══════════════════════════════ END DOKUMEN ════════════════════════════ --}}

        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
    let currentZoom = 100;

    function zoomCV(delta) {
        currentZoom = Math.min(150, Math.max(60, currentZoom + delta));
        document.getElementById('cvDoc').style.transform = `scale(${currentZoom / 100})`;
        document.getElementById('cvDoc').style.transformOrigin = 'top center';
        document.getElementById('zoomVal').textContent = currentZoom + '%';

        // Sesuaikan tinggi wrapper agar tidak overlap
        const doc = document.getElementById('cvDoc');
        const frame = document.getElementById('cvPaperFrame');
        const scaled = doc.offsetHeight * (currentZoom / 100);
        frame.style.minHeight = (scaled + 64) + 'px';
    }
</script>

<style>
    @media print {
        .cv-controls,
        .page-header-bar,
        .admin-sidebar,
        .admin-topbar,
        .admin-footer { display: none !important; }

        .admin-main { margin: 0 !important; padding: 0 !important; }
        .admin-content { padding: 0 !important; }
        .cv-paper-frame { background: white !important; padding: 0 !important; }
        .cv-doc { box-shadow: none !important; max-width: 100% !important; }
        body { background: white !important; }
    }
</style>
@endpush
