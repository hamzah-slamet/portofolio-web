{{-- resources/views/content/skills/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Skills')
@section('topbar-title', 'Skills')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/content/skill/skills-style.css') }}">
@endpush

@section('page-header')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
    <div>
        <h4 class="mb-1" style="font-size:1.25rem; font-weight:800; color:var(--text-primary);">Skills</h4>
        <p class="text-muted mb-0" style="font-size:.78rem;">Kelola semua skill & teknologi</p>
    </div>
    <button class="btn-admin-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
        <i class="bi bi-plus-lg"></i> Tambah Skill
    </button>
</div>
@endsection

@section('content')
{{-- Stats --}}
<div class="skill-stats">
    <div class="skill-stat-card">
        <div class="skill-stat-icon" style="background:var(--blue-light);color:var(--blue);">
            <i class="bi bi-lightning-charge-fill"></i>
        </div>
        <div>
            <div class="skill-stat-num">{{ $stats['total'] }}</div>
            <div class="skill-stat-lbl">Total Skill</div>
        </div>
    </div>
    <div class="skill-stat-card">
        <div class="skill-stat-icon" style="background:#f0fdf4;color:#16a34a;">
            <i class="bi bi-grid-3x3-gap-fill"></i>
        </div>
        <div>
            <div class="skill-stat-num" style="color:#16a34a;">{{ $stats['categories'] }}</div>
            <div class="skill-stat-lbl">Kategori</div>
        </div>
    </div>
    <div class="skill-stat-card">
        <div class="skill-stat-icon" style="background:#fffbeb;color:#d97706;">
            <i class="bi bi-graph-up-arrow"></i>
        </div>
        <div>
            <div class="skill-stat-num" style="color:#d97706;">{{ $stats['highest'] }}%</div>
            <div class="skill-stat-lbl">Skill Tertinggi</div>
        </div>
    </div>
    <div class="skill-stat-card">
        <div class="skill-stat-icon" style="background:#fef2f2;color:#dc2626;">
            <i class="bi bi-bar-chart-fill"></i>
        </div>
        <div>
            <div class="skill-stat-num" style="color:#dc2626;">{{ $stats['average'] }}%</div>
            <div class="skill-stat-lbl">Rata-rata</div>
        </div>
    </div>
</div>

@if($skills->isEmpty())
{{-- ── Empty State ──────────────────────────────────────────────────────── --}}
<div class="empty-state">
    <i class="bi bi-lightning-charge empty-state-icon"></i>
    <div class="empty-state-title">Belum ada skill</div>
    <p class="empty-state-sub">Mulai tambahkan skill & teknologi yang kamu kuasai.</p>
    <button class="btn-admin-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
        <i class="bi bi-plus-lg me-1"></i> Tambah Skill Pertama
    </button>
</div>

@else
{{-- ── Main content ─────────────────────────────────────────────────────── --}}
<div class="row g-4">
<div class="col-lg-8">

@foreach($skillsByCategory as $category => $categorySkills)
<div class="cat-header">
    <span class="cat-title">{{ $category }}</span>
    <span class="cat-line"></span>
    <span class="cat-count">{{ $categorySkills->count() }} skill</span>
</div>

@foreach($categorySkills as $skill)
<div class="skill-row-card">
    <div class="skill-icon-box"
         style="background:{{ $skill->color_fill ?? '#eff6ff' }};color:{{ $skill->color ?? '#2563eb' }};">
        <i class="{{ $skill->icon ?? 'bi bi-lightning-charge' }}"></i>
    </div>
    <div style="min-width:110px;">
        <div class="skill-name">{{ $skill->name }}</div>
        <div class="skill-cat">{{ $skill->category }}</div>
    </div>
    <div class="skill-bar-wrap">
        <div class="skill-bar">
            <div class="skill-fill"
                 style="width:{{ $skill->level }}%;background:{{ $skill->color ?? '#2563eb' }};"></div>
        </div>
    </div>
    <div class="skill-pct" style="color:{{ $skill->color ?? '#2563eb' }};">{{ $skill->level }}%</div>

    {{-- Sertifikat badge --}}
    @if($skill->certificates && count($skill->certificates) > 0)
    <div class="flex-shrink-0">
        <span title="{{ implode("\n", $skill->certificates) }}"
              style="font-size:.7rem;font-weight:600;background:#f0fdf4;color:#16a34a;
                     border:1px solid #bbf7d0;border-radius:99px;padding:2px 8px;
                     cursor:default;white-space:nowrap;">
            <i class="bi bi-patch-check-fill"></i> {{ count($skill->certificates) }} sertifikat
        </span>
    </div>
    @endif

    <div class="d-flex gap-1 flex-shrink-0">
        <button class="btn-admin-edit btn-edit-skill"
                data-id="{{ $skill->id }}"
                data-name="{{ $skill->name }}"
                data-category="{{ $skill->category }}"
                data-level="{{ $skill->level }}"
                data-icon="{{ $skill->icon }}"
                data-color="{{ $skill->color }}"
                data-colorfill="{{ $skill->color_fill }}"
                data-certificates="{{ json_encode($skill->certificates ?? []) }}"
                data-bs-toggle="modal" data-bs-target="#modalEdit">
            <i class="bi bi-pencil-fill"></i>
        </button>

        {{-- Tombol Delete — trigger modal custom --}}
        <button type="button"
                class="cert-remove-btn"
                title="Hapus"
                data-name="{{ $skill->name }}"
                data-action="{{ route('skills.destroy', $skill) }}"
                onclick="openDeleteSkillModal(this)">
            <i class="bi bi-trash3"></i>
        </button>
    </div>
</div>
@endforeach
@endforeach

</div>{{-- col-lg-8 --}}

{{-- Right: Category Summary --}}
<div class="col-lg-4">
    <div class="admin-card" style="position:sticky;top:84px;">
        <div class="admin-card-header">
            <h6 class="admin-card-title">
                <i class="bi bi-pie-chart me-2 text-primary"></i>Ringkasan Kategori
            </h6>
        </div>
        @foreach($categoryStats as $cat)
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span style="font-size:.85rem;font-weight:600;color:var(--text-primary);">{{ $cat['name'] }}</span>
                <span style="font-size:.75rem;color:var(--text-muted);">
                    {{ $cat['count'] }} skill · avg {{ $cat['avg'] }}%
                </span>
            </div>
            <div class="skill-bar">
                <div class="skill-fill" style="width:{{ $cat['avg'] }}%;background:{{ $cat['color'] }};"></div>
            </div>
        </div>
        @endforeach
    </div>
</div>

</div>{{-- row --}}
@endif


{{-- ════════════════════════════════════════════════════════════════════════ --}}
{{-- MODAL ADD                                                               --}}
{{-- ════════════════════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <form action="{{ route('skills.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAddLabel">
                        <i class="bi bi-plus-circle-fill me-2" style="color:var(--blue);"></i>Tambah Skill
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @include('content.skills.form', ['skill' => null, 'prefix' => 'add'])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-admin-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-admin-primary">
                        <i class="bi bi-save2-fill me-1"></i> Simpan Skill
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
            <form id="formEdit" action="" method="POST">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">
                        <i class="bi bi-pencil-fill me-2" style="color:var(--blue);"></i>Edit Skill
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @include('content.skills.form', ['skill' => null, 'prefix' => 'edit'])
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
<form id="formDeleteSkill" action="" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>


{{-- ════════════════════════════════════════════════════════════════════════ --}}
{{-- MODAL DELETE                                                            --}}
{{-- ════════════════════════════════════════════════════════════════════════ --}}
<div class="modal-overlay" id="deleteSkillModal" onclick="closeOnOverlayDeleteSkill(event)">
    <div class="modal-box" style="max-width:400px;">
        <div class="modal-header" style="border-bottom:none; padding-bottom:0;">
            <div></div>
            <button class="modal-close" onclick="closeDeleteSkillModal()">
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
                Hapus Skill?
            </div>
            <div style="font-size:.85rem; color:var(--text-muted); line-height:1.6;">
                Anda akan menghapus skill<br>
                <strong id="delete-skill-name" style="color:var(--text-primary);"></strong>
            </div>
            <div style="margin-top:12px; padding:10px 14px; background:#fef2f2; border-radius:10px;
                        border:1px solid #fecaca; font-size:.78rem; color:#b91c1c; text-align:left;">
                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                Tindakan ini tidak dapat dibatalkan. Data skill akan dihapus permanen.
            </div>
        </div>
        <div class="modal-footer" style="justify-content:center; gap:10px; border-top:none;">
            <button type="button" class="btn-admin-secondary" onclick="closeDeleteSkillModal()">Batal</button>
            <button type="button" onclick="confirmDeleteSkill()"
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
// ── Edit modal populate ───────────────────────────────────────────────────────
document.querySelectorAll('.btn-edit-skill').forEach(btn => {
    btn.addEventListener('click', function () {
        const d = this.dataset;
        document.getElementById('formEdit').action = `/skills/${d.id}`;

        document.getElementById('edit_name').value     = d.name;
        document.getElementById('edit_category').value = d.category;
        document.getElementById('edit_level').value    = d.level;
        document.getElementById('edit_level_val').textContent = d.level + '%';
        document.getElementById('edit_icon').value     = d.icon || '';
        document.getElementById('edit_color').value    = d.color || '#2563eb';

        // color swatches
        setActiveSwatch('edit', d.color);

        // certificates
        const certs = JSON.parse(d.certificates || '[]');
        renderCertificates('edit', certs);
    });
});

// ── Level range display ───────────────────────────────────────────────────────
['add', 'edit'].forEach(prefix => {
    const range = document.getElementById(`${prefix}_level`);
    const val   = document.getElementById(`${prefix}_level_val`);
    if (range) {
        range.addEventListener('input', () => {
            val.textContent = range.value + '%';
        });
    }
});

// ── Color swatches ────────────────────────────────────────────────────────────
const SWATCHES = ['#ef4444','#f97316','#eab308','#22c55e','#14b8a6',
                  '#3b82f6','#6366f1','#8b5cf6','#ec4899','#64748b'];

function buildSwatches(prefix) {
    const wrap = document.getElementById(`${prefix}_swatches`);
    if (!wrap) return;
    wrap.innerHTML = '';
    SWATCHES.forEach(hex => {
        const el = document.createElement('div');
        el.className = 'color-swatch';
        el.style.background = hex;
        el.title = hex;
        el.addEventListener('click', () => {
            document.getElementById(`${prefix}_color`).value = hex;
            setActiveSwatch(prefix, hex);
        });
        wrap.appendChild(el);
    });
}

function setActiveSwatch(prefix, hex) {
    const wrap = document.getElementById(`${prefix}_swatches`);
    if (!wrap) return;
    wrap.querySelectorAll('.color-swatch').forEach(s => {
        s.classList.toggle('active', s.style.background === hex ||
            s.style.background === hexToRgb(hex));
    });
    document.getElementById(`${prefix}_color`).value = hex;
}

function hexToRgb(hex) {
    const r = parseInt(hex.slice(1,3),16);
    const g = parseInt(hex.slice(3,5),16);
    const b = parseInt(hex.slice(5,7),16);
    return `rgb(${r}, ${g}, ${b})`;
}

buildSwatches('add');
buildSwatches('edit');

// ── Certificate repeater ──────────────────────────────────────────────────────
function renderCertificates(prefix, certs = []) {
    const list = document.getElementById(`${prefix}_cert_list`);
    list.innerHTML = '';
    if (certs.length === 0) { addCertField(prefix, ''); return; }
    certs.forEach(url => addCertField(prefix, url));
}

function addCertField(prefix, value = '') {
    const list = document.getElementById(`${prefix}_cert_list`);
    const div  = document.createElement('div');
    div.className = 'cert-item';
    div.innerHTML = `
        <i class="bi bi-mortarboard-fill" style="color:#d97706;font-size:1rem;flex-shrink:0;"></i>
        <input type="url" name="certificates[]" class="form-control"
               placeholder="https://link-sertifikat.com" value="${escHtml(value)}">
        <button type="button" class="cert-remove-btn" onclick="removeCertField(this)">
            <i class="bi bi-trash3"></i>
        </button>`;
    list.appendChild(div);
}

function removeCertField(btn) {
    const list = btn.closest('#add_cert_list, #edit_cert_list');
    if (list.children.length <= 1) {
        list.querySelector('input').value = '';
        return;
    }
    btn.closest('.cert-item').remove();
}

function escHtml(str) {
    return (str || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

// init add modal
renderCertificates('add', []);

// reset add modal on close
document.getElementById('modalAdd').addEventListener('hidden.bs.modal', () => {
    document.getElementById('modalAdd').querySelector('form').reset();
    renderCertificates('add', []);
    document.getElementById('add_level_val').textContent = '50%';
    setActiveSwatch('add', '');
});

// ── Delete Modal ──────────────────────────────────────────────────────────────
function openDeleteSkillModal(btn) {
    document.getElementById('delete-skill-name').textContent = btn.dataset.name;
    document.getElementById('formDeleteSkill').action = btn.dataset.action;
    document.getElementById('deleteSkillModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeDeleteSkillModal() {
    document.getElementById('deleteSkillModal').classList.remove('active');
    document.body.style.overflow = '';
}

function closeOnOverlayDeleteSkill(e) {
    if (e.target === document.getElementById('deleteSkillModal')) closeDeleteSkillModal();
}

function confirmDeleteSkill() {
    document.getElementById('formDeleteSkill').submit();
}

// Tutup delete modal jika modal Bootstrap dibuka
document.getElementById('modalAdd').addEventListener('show.bs.modal', closeDeleteSkillModal);
document.getElementById('modalEdit').addEventListener('show.bs.modal', closeDeleteSkillModal);
</script>
@endpush
