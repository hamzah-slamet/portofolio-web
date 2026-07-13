@extends('layouts.app')

@section('title', 'Projects')
@section('topbar-title', 'Projects')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/content/project/projects-style.css') }}">
@endpush

@section('page-header')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
    <div>
        <h4 class="mb-1" style="font-size:1.25rem; font-weight:800; color:var(--text-primary);">Projects</h4>
        <p class="text-muted mb-0" style="font-size:.78rem;">Kelola semua project portfolio</p>
    </div>
    <button class="btn-admin-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
        <i class="bi bi-plus-lg"></i> Tambah Project
    </button>
</div>
@endsection

@section('content')

{{-- Stats bar --}}
<div class="admin-card mb-4">
    <div class="d-flex align-items-center gap-4 flex-wrap">
        <div class="pstat">
            <div class="pstat-num">{{ $stats['total'] }}</div>
            <div class="pstat-lbl">Total Project</div>
        </div>
        <div class="pstat-divider" style="height:40px;"></div>
        <div class="pstat">
            <div class="pstat-num" style="color:#f59e0b;">{{ $stats['featured'] }}</div>
            <div class="pstat-lbl">Featured</div>
        </div>
        <div class="pstat-divider" style="height:40px;"></div>
        <div class="pstat">
            <div class="pstat-num" style="color:#22c55e;">{{ $stats['online'] }}</div>
            <div class="pstat-lbl">Live / Online</div>
        </div>
        <div class="pstat-divider" style="height:40px;"></div>
        <div class="pstat">
            <div class="pstat-num" style="color:var(--blue);">{{ $stats['open_source'] }}</div>
            <div class="pstat-lbl">Open Source</div>
        </div>
        <div class="ms-auto">
            <form method="GET" action="{{ route('projects.index') }}">
                @if(request('filter')) <input type="hidden" name="filter" value="{{ request('filter') }}"> @endif
                @if(request('tech'))   <input type="hidden" name="tech"   value="{{ request('tech') }}">   @endif
                <div class="search-wrap">
                    <i class="bi bi-search"></i>
                    <input type="text" name="q" placeholder="Cari project..." value="{{ request('q') }}">
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Filter --}}
<div class="filter-bar">
    <a href="{{ route('projects.index') }}"
       class="filter-btn {{ !request('filter') && !request('tech') ? 'active' : '' }}">
        Semua ({{ $stats['total'] }})
    </a>
    <a href="{{ route('projects.index', ['filter' => 'featured']) }}"
       class="filter-btn {{ request('filter') === 'featured' ? 'active' : '' }}">
        <i class="bi bi-pin-angle-fill me-1"></i> Featured
    </a>
    @foreach($techTags as $tag)
    <a href="{{ route('projects.index', ['tech' => $tag]) }}"
       class="filter-btn {{ request('tech') === $tag ? 'active' : '' }}">
        {{ $tag }}
    </a>
    @endforeach
</div>

{{-- Grid --}}
@if($projects->isEmpty())
<div class="admin-card text-center py-5">
    <div style="font-size:3.5rem; opacity:.25; margin-bottom:1rem;"><i class="bi bi-folder2-open"></i></div>
    <h6 style="font-weight:700; color:var(--text-primary); margin-bottom:.4rem;">
        @if(request('q')) Tidak ada hasil untuk "{{ request('q') }}"
        @elseif(request('filter') || request('tech')) Tidak ada project dengan filter ini
        @else Belum ada project
        @endif
    </h6>
    <p class="text-muted mb-4" style="font-size:.82rem;">
        @if(request('q') || request('filter') || request('tech')) Coba hapus filter atau kata kunci pencarian.
        @else Mulai tambahkan project portfolio kamu.
        @endif
    </p>
    @if(request('q') || request('filter') || request('tech'))
        <a href="{{ route('projects.index') }}" class="btn-admin-secondary" style="font-size:.82rem;">
            <i class="bi bi-x-circle me-1"></i> Reset Filter
        </a>
    @else
        <button class="btn-admin-primary" style="font-size:.82rem;"
                data-bs-toggle="modal" data-bs-target="#modalAdd">
            <i class="bi bi-plus-lg me-1"></i> Tambah Project Pertama
        </button>
    @endif
</div>
@else
<div class="row g-4">
    @foreach($projects as $project)
    <div class="col-md-6 col-xl-4">
        <div class="project-card">

            <div class="project-card-thumb"
                 style="{{ $project->thumbnail_url
                     ? 'background:url('.$project->thumbnail_url.') center/cover no-repeat;'
                     : 'background:linear-gradient(135deg,#dbeafe,#bfdbfe);' }}">
                @if(!$project->thumbnail_url)
                    <i class="bi bi-code-slash" style="font-size:3.5rem;color:#2563eb;opacity:.7;"></i>
                @endif
                @if($project->is_featured)
                    <div class="featured-ribbon">
                        <i class="bi bi-pin-angle-fill" style="font-size:.6rem;"></i> Featured
                    </div>
                @endif
            </div>

            <div class="project-card-body">
                <div class="d-flex align-items-start justify-content-between gap-2 mb-1">
                    <div class="project-card-title">{{ $project->title }}</div>
                    <span class="badge bg-{{ $project->status_color }}" style="font-size:.65rem;white-space:nowrap;">
                        {{ ucfirst($project->status) }}
                    </span>
                </div>
                <div class="project-card-desc">{{ Str::limit($project->description, 110) }}</div>
                <div>
                    @forelse($project->tech_stack ?? [] as $tech)
                        <span class="tech-tag">{{ $tech }}</span>
                    @empty
                        <span class="text-muted" style="font-size:.75rem;">Tidak ada tech stack</span>
                    @endforelse
                </div>
            </div>

            <div class="project-card-footer">
                <button class="btn-admin-edit btn-edit-project"
                        data-id="{{ $project->id }}"
                        data-title="{{ $project->title }}"
                        data-slug="{{ $project->slug }}"
                        data-description="{{ $project->description }}"
                        data-tech="{{ json_encode($project->tech_stack ?? []) }}"
                        data-github="{{ $project->github_url }}"
                        data-live="{{ $project->live_url }}"
                        data-status="{{ $project->status }}"
                        data-featured="{{ $project->is_featured ? '1' : '0' }}"
                        data-sort="{{ $project->sort_order }}"
                        data-thumb="{{ $project->thumbnail_url }}"
                        data-bs-toggle="modal" data-bs-target="#modalEdit">
                    <i class="bi bi-pencil-fill"></i> Edit
                </button>

                @if($project->github_url)
                <a href="{{ $project->github_url }}" target="_blank"
                   class="btn-admin-secondary" style="padding:7px 12px;font-size:.8rem;">
                    <i class="bi bi-github"></i> GitHub
                </a>
                @endif

                @if($project->live_url)
                <a href="{{ $project->live_url }}" target="_blank"
                   class="btn-admin-primary ms-auto" style="padding:7px 12px;font-size:.8rem;box-shadow:none;">
                    <i class="bi bi-box-arrow-up-right"></i> Live
                </a>
                @else
                <span class="badge-admin gray ms-auto">Offline</span>
                @endif

                {{-- Tombol Delete — trigger modal custom --}}
                <button type="button"
                        title="Hapus"
                        class="ms-1"
                        data-title="{{ $project->title }}"
                        data-action="{{ route('projects.destroy', $project) }}"
                        onclick="openDeleteModal(this)"
                        style="padding:7px 10px;font-size:.8rem;border-radius:8px;border:1.5px solid #fecaca;background:#fff1f2;color:#ef4444;cursor:pointer;transition:all .2s;"
                        onmouseover="this.style.background='#ef4444';this.style.color='#fff'"
                        onmouseout="this.style.background='#fff1f2';this.style.color='#ef4444'">
                    <i class="bi bi-trash3-fill"></i>
                </button>

            </div>

        </div>
    </div>
    @endforeach
</div>

{{-- ── Pagination ─────────────────────────────────────────────────────────── --}}
@if($projects->hasPages())
<nav class="d-flex flex-column align-items-center gap-2 mt-4">
    <div class="pg-wrap">

        {{-- Prev --}}
        @if($projects->onFirstPage())
            <span class="pg-btn disabled">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <path d="M8.5 10.5L5 7l3.5-3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Prev
            </span>
        @else
            <a href="{{ $projects->previousPageUrl() }}" class="pg-btn">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <path d="M8.5 10.5L5 7l3.5-3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Prev
            </a>
        @endif

        {{-- Page numbers --}}
        @foreach($projects->links()->elements as $element)
            @if(is_string($element))
                <span class="pg-ellipsis">···</span>
            @endif
            @if(is_array($element))
                @foreach($element as $page => $url)
                    @if($page == $projects->currentPage())
                        <span class="pg-btn active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="pg-btn">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if($projects->hasMorePages())
            <a href="{{ $projects->nextPageUrl() }}" class="pg-btn">
                Next
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <path d="M5.5 10.5L9 7 5.5 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        @else
            <span class="pg-btn disabled">
                Next
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <path d="M5.5 10.5L9 7 5.5 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>
        @endif

    </div>

    {{-- Info --}}
    <p class="pg-info mb-0">
        Menampilkan {{ $projects->firstItem() }}–{{ $projects->lastItem() }}
        dari {{ $projects->total() }} project
    </p>
</nav>
@endif
@endif


{{-- ════════════════════════════════════════════════════════════════════════ --}}
{{-- MODAL ADD                                                               --}}
{{-- ════════════════════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="modalAddLabel">
                        <i class="bi bi-plus-circle-fill me-2" style="color:var(--blue);"></i>Tambah Project
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    @include('content.projects._modal-form', ['project' => null, 'prefix' => 'add'])
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-admin-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-admin-primary">
                        <i class="bi bi-save2-fill me-1"></i> Simpan Project
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>


{{-- ════════════════════════════════════════════════════════════════════════ --}}
{{-- MODAL EDIT                                                              --}}
{{-- ════════════════════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <form id="formEdit" action="" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">
                        <i class="bi bi-pencil-fill me-2" style="color:var(--blue);"></i>Edit Project
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    @include('content.projects._modal-form', ['project' => null, 'prefix' => 'edit'])
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-admin-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-admin-primary">
                        <i class="bi bi-save2-fill me-1"></i> Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>


{{-- ════════════════════════════════════════════════════════════════════════ --}}
{{-- HIDDEN FORM DELETE                                                      --}}
{{-- ════════════════════════════════════════════════════════════════════════ --}}
<form id="formDeleteProject" action="" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>


{{-- ════════════════════════════════════════════════════════════════════════ --}}
{{-- MODAL DELETE                                                            --}}
{{-- ════════════════════════════════════════════════════════════════════════ --}}
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
            <div style="font-size:1rem; font-weight:800; color:var(--text-primary); margin-bottom:6px;">
                Hapus Project?
            </div>
            <div style="font-size:.85rem; color:var(--text-muted); line-height:1.6;">
                Anda akan menghapus project<br>
                <strong id="delete-project-title" style="color:var(--text-primary);"></strong>
            </div>
            <div style="margin-top:12px; padding:10px 14px; background:#fef2f2; border-radius:10px;
                        border:1px solid #fecaca; font-size:.78rem; color:#b91c1c; text-align:left;">
                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                Tindakan ini tidak dapat dibatalkan. Data project akan dihapus permanen.
            </div>
        </div>
        <div class="modal-footer" style="justify-content:center; gap:10px; border-top:none;">
            <button type="button" class="btn-admin-secondary" onclick="closeDeleteModal()">Batal</button>
            <button type="button" onclick="confirmDeleteProject()"
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
<script src="{{ asset('assets/content/project/project.js') }}"></script>
<script>
    function openDeleteModal(btn) {
        document.getElementById('delete-project-title').textContent = btn.dataset.title;
        document.getElementById('formDeleteProject').action = btn.dataset.action;
        document.getElementById('deleteModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.remove('active');
        document.body.style.overflow = '';
    }

    function closeOnOverlayDelete(e) {
        if (e.target === document.getElementById('deleteModal')) closeDeleteModal();
    }

    function confirmDeleteProject() {
        document.getElementById('formDeleteProject').submit();
    }

    // Tutup modal delete jika modal Bootstrap (Edit/Add) dibuka
    document.getElementById('modalAdd').addEventListener('show.bs.modal', closeDeleteModal);
    document.getElementById('modalEdit').addEventListener('show.bs.modal', closeDeleteModal);
</script>
@endpush
