{{-- resources/views/admin/dashboard.blade.php --}}

@extends('layouts.app')

@section('title', 'Dashboard')
@section('topbar-title', 'Dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/template/css/style.css') }}">
@endpush

@section('content')

    {{-- ============================================================ --}}
    {{-- WELCOME BANNER                                               --}}
    {{-- ============================================================ --}}
    <div class="welcome-banner">
        <div class="welcome-text" style="position:relative;z-index:1;">
            <h2>Selamat datang, {{ auth()->user()->name }}!</h2>
            <p>Portfolio aktif, siap dilihat dan diubah kapanpun dimanapun</p>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- STAT CARDS                                                   --}}
    {{-- ============================================================ --}}
    <div class="row g-3 mb-4">

        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon blue"><i class="bi bi-folder2-open"></i></div>
                <div>
                    <div class="stat-label">Total Projects</div>
                    <div class="stat-value">{{ $totalProjects }}</div>
                    <div class="stat-sub"><span class="up"><i class="bi bi-star-fill"></i> {{ $featuredProjects }}
                            featured</span></div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon green"><i class="bi bi-lightning-charge-fill"></i></div>
                <div>
                    <div class="stat-label">Total Skills</div>
                    <div class="stat-value">{{ $totalSkills }}</div>
                    <div class="stat-sub"><span class="text-muted">{{ $totalSkillCategories }} kategori</span></div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon amber"><i class="bi bi-briefcase-fill"></i></div>
                <div>
                    <div class="stat-label">Pengalaman</div>
                    <div class="stat-value">{{ $totalExperiences }}</div>
                    <div class="stat-sub">
                        @if ($activeExperience)
                            <span class="up"><i class="bi bi-circle-fill" style="font-size:.5rem;"></i> Aktif
                                bekerja</span>
                        @else
                            <span class="text-muted">Tidak ada yang aktif</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon red"><i class="bi bi-person-circle"></i></div>
                <div>
                    <div class="stat-label">Profil</div>
                    <div class="stat-value" style="font-size:1.1rem;margin-top:2px;">Lengkap</div>
                    <div class="stat-sub"><span class="up"><i class="bi bi-check-circle-fill"></i> Siap tampil</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ============================================================ --}}
    {{-- PROJECTS + SKILLS GRID                                       --}}
    {{-- ============================================================ --}}
    <div class="row g-3 mb-3">

        {{-- Recent Projects --}}
        <div class="col-lg-7">
            <div class="admin-card h-100">
                <div class="admin-card-header">
                    <h6 class="admin-card-title"><i class="bi bi-folder2 me-2 text-primary"></i>Project Terbaru</h6>
                </div>
                @forelse($recentProjects as $project)
                    <div class="d-flex align-items-start gap-3 py-3 {{ !$loop->last ? 'border-bottom' : '' }}"
                        style="border-color:#f1f5f9;">
                        <div class="project-thumb flex-shrink-0">
                            <i class="bi bi-folder2"></i>
                        </div>
                        <div class="flex-grow-1" style="min-width:0;">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <div class="project-title">{{ $project->title }}</div>
                                @if ($project->is_featured)
                                    <span class="badge-admin amber" style="font-size:.62rem;">⭐ Featured</span>
                                @endif
                            </div>
                            <div class="project-meta">{{ $project->description }}</div>
                            @if ($project->technologies)
                                <div class="mt-1 d-flex gap-1 flex-wrap">
                                    @foreach (explode(',', $project->technologies) as $tech)
                                        <span class="tech-tag">{{ trim($tech) }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-folder-x" style="font-size:2rem;"></i>
                        <p class="mt-2 mb-0">Belum ada project</p>
                    </div>
                @endforelse

            </div>
        </div>

        {{-- Top Skills + Experience --}}
        <div class="col-lg-5">
            <div class="admin-card h-100">

                {{-- Top Skills --}}
                <div class="admin-card-header">
                    <h6 class="admin-card-title"><i class="bi bi-lightning-charge me-2 text-primary"></i>Top Skills</h6>
                </div>

                @forelse($topSkills as $skill)
                    <div class="skill-row">
                        <div class="skill-name">{{ $skill->name }}</div>
                        <div class="skill-bar">
                            <div class="skill-fill" style="width:{{ $skill->level }}%"></div>
                        </div>
                        <div class="skill-pct">{{ $skill->level }}%</div>
                    </div>
                @empty
                    <p class="text-muted text-center py-3">Belum ada skill</p>
                @endforelse

                {{-- Pengalaman Kerja --}}
                <div class="mt-4 pt-3 border-top">
                    <h6 class="admin-card-title mb-3">
                        <i class="bi bi-briefcase me-2 text-primary"></i>Pengalaman Kerja
                    </h6>

                    @forelse($experiences as $exp)
                        <div class="d-flex gap-2 align-items-start mb-3">
                            <div class="exp-dot mt-1 flex-shrink-0"
                                style="background:{{ $exp->end_date === null ? '#2563eb' : '#94a3b8' }};">
                            </div>
                            <div class="flex-grow-1" style="min-width:0;">
                                <div class="exp-position">{{ $exp->position }}</div>
                                <div class="exp-company">
                                    {{ $exp->company }} &middot;
                                    {{ \Carbon\Carbon::parse($exp->start_date)->format('Y') }} –
                                    {{ $exp->end_date ? \Carbon\Carbon::parse($exp->end_date)->format('Y') : 'Sekarang' }}
                                </div>
                            </div>
                            @if ($exp->end_date === null)
                                <span class="badge-admin green ms-auto flex-shrink-0" style="font-size:.62rem;">Aktif</span>
                            @endif
                        </div>
                    @empty
                        <p class="text-muted text-center py-3">Belum ada pengalaman</p>
                    @endforelse
                </div>

            </div>
        </div>

    </div>
@endsection
