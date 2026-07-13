{{-- resources/views/content/experiences/form.blade.php --}}
{{-- Dipakai untuk Create DAN Edit --}}
@extends('layouts.app')

@section('title', $isEdit ? 'Edit Experience' : 'Tambah Experience')
@section('topbar-title', 'Experience')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/content/experience/experiences-style.css') }}">
<style>
/* ── Form specific styles ─────────────────────────────────── */
.form-label-admin {
    font-size: .78rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 6px;
    display: block;
}
.form-control-admin,
.form-select-admin {
    width: 100%;
    padding: 9px 14px;
    border: 1.5px solid var(--card-border);
    border-radius: 10px;
    background: var(--bg-primary);
    color: var(--text-primary);
    font-size: .85rem;
    transition: border-color .2s, box-shadow .2s;
    outline: none;
}
.form-control-admin:focus,
.form-select-admin:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37,99,235,.1);
}
textarea.form-control-admin {
    resize: vertical;
    min-height: 130px;
}
.form-hint {
    font-size: .72rem;
    color: var(--text-muted);
    margin-top: 4px;
}
.is-invalid-admin {
    border-color: #ef4444 !important;
}
.invalid-feedback-admin {
    font-size: .72rem;
    color: #ef4444;
    margin-top: 4px;
}

/* Skills tag input */
.skills-wrapper {
    border: 1.5px solid var(--card-border);
    border-radius: 10px;
    padding: 8px 10px;
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    cursor: text;
    transition: border-color .2s, box-shadow .2s;
    background: var(--bg-primary);
    min-height: 44px;
    align-items: center;
}
.skills-wrapper:focus-within {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37,99,235,.1);
}
.skill-tag {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #eff6ff;
    color: #2563eb;
    border-radius: 6px;
    padding: 3px 10px;
    font-size: .78rem;
    font-weight: 600;
}
.skill-tag button {
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
    color: #93c5fd;
    line-height: 1;
    font-size: .9rem;
}
.skill-tag button:hover { color: #2563eb; }
.skills-input {
    border: none;
    outline: none;
    background: transparent;
    color: var(--text-primary);
    font-size: .85rem;
    min-width: 120px;
    flex: 1;
}
.section-divider {
    font-size: .72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--text-muted);
    margin: 24px 0 16px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.section-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: var(--card-border);
}
</style>
@endpush

@section('page-header')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('experiences.index') }}"
               style="width:36px; height:36px; border-radius:10px; background:var(--bg-secondary);
                      border:1.5px solid var(--card-border); display:grid; place-items:center;
                      color:var(--text-secondary); text-decoration:none;">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h4 class="mb-1" style="font-size:1.25rem; font-weight:800; color:var(--text-primary);">
                    {{ $isEdit ? 'Edit Experience' : 'Tambah Experience' }}
                </h4>
                <p class="text-muted mb-0" style="font-size:.78rem;">
                    {{ $isEdit ? 'Perbarui data pengalaman kerja' : 'Tambah pengalaman kerja baru' }}
                </p>
            </div>
        </div>
    </div>
@endsection

@section('content')

<div class="row g-4">
    <div class="col-lg-8">
        <div class="admin-card">

            <form action="{{ $isEdit ? route('experiences.update', $experience) : route('experiences.store') }}"
                  method="POST" id="expForm">
                @csrf
                @if($isEdit) @method('PUT') @endif

                {{-- ── Informasi Utama ────────────────────────────────── --}}
                <div class="section-divider"><span>Informasi Utama</span></div>

                <div class="row g-3">
                    {{-- Posisi --}}
                    <div class="col-md-6">
                        <label class="form-label-admin" for="position">
                            Jabatan / Posisi <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="position" name="position"
                               class="form-control-admin @error('position') is-invalid-admin @enderror"
                               value="{{ old('position', $experience?->position) }}"
                               placeholder="Full Stack Developer">
                        @error('position')
                            <div class="invalid-feedback-admin">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Perusahaan --}}
                    <div class="col-md-6">
                        <label class="form-label-admin" for="company">
                            Nama Perusahaan <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="company" name="company"
                               class="form-control-admin @error('company') is-invalid-admin @enderror"
                               value="{{ old('company', $experience?->company) }}"
                               placeholder="PT. Teknologi Nusantara">
                        @error('company')
                            <div class="invalid-feedback-admin">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tipe Perusahaan --}}
                    <div class="col-md-6">
                        <label class="form-label-admin" for="company_type">Tipe Perusahaan</label>
                        <select id="company_type" name="company_type" class="form-select-admin">
                            <option value="corporate"
                                {{ old('company_type', $experience?->company_type) === 'corporate' ? 'selected' : '' }}>
                                Korporat / Perusahaan
                            </option>
                            <option value="startup"
                                {{ old('company_type', $experience?->company_type) === 'startup' ? 'selected' : '' }}>
                                Startup
                            </option>
                            <option value="freelance"
                                {{ old('company_type', $experience?->company_type) === 'freelance' ? 'selected' : '' }}>
                                Freelance
                            </option>
                            <option value="ngo"
                                {{ old('company_type', $experience?->company_type) === 'ngo' ? 'selected' : '' }}>
                                NGO / Non-Profit
                            </option>
                        </select>
                    </div>

                    {{-- Lokasi --}}
                    <div class="col-md-6">
                        <label class="form-label-admin" for="location">Lokasi</label>
                        <input type="text" id="location" name="location"
                               class="form-control-admin @error('location') is-invalid-admin @enderror"
                               value="{{ old('location', $experience?->location) }}"
                               placeholder="Jakarta, Indonesia">
                        @error('location')
                            <div class="invalid-feedback-admin">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- ── Periode ─────────────────────────────────────────── --}}
                <div class="section-divider"><span>Periode Kerja</span></div>

                {{-- Toggle Is Current --}}
                <div class="mb-3 d-flex align-items-center gap-3">
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" role="switch"
                               id="is_current" name="is_current" value="1"
                               {{ old('is_current', $experience?->is_current) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_current"
                               style="font-size:.85rem; font-weight:600; color:var(--text-primary);">
                            Masih bekerja di sini
                        </label>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label-admin" for="start_date">
                            Tanggal Mulai <span class="text-danger">*</span>
                        </label>
                        <input type="date" id="start_date" name="start_date"
                               class="form-control-admin @error('start_date') is-invalid-admin @enderror"
                               value="{{ old('start_date', $experience?->start_date?->format('Y-m-d')) }}">
                        @error('start_date')
                            <div class="invalid-feedback-admin">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6" id="endDateWrapper">
                        <label class="form-label-admin" for="end_date">Tanggal Selesai</label>
                        <input type="date" id="end_date" name="end_date"
                               class="form-control-admin @error('end_date') is-invalid-admin @enderror"
                               value="{{ old('end_date', $experience?->end_date?->format('Y-m-d')) }}">
                        @error('end_date')
                            <div class="invalid-feedback-admin">{{ $message }}</div>
                        @enderror
                        <div class="form-hint">Kosongkan jika masih aktif</div>
                    </div>
                </div>

                {{-- ── Deskripsi ────────────────────────────────────────── --}}
                <div class="section-divider"><span>Detail</span></div>

                <div class="mb-3">
                    <label class="form-label-admin" for="description">Deskripsi Pekerjaan</label>
                    <textarea id="description" name="description"
                              class="form-control-admin @error('description') is-invalid-admin @enderror"
                              placeholder="Ceritakan tanggung jawab dan pencapaian Anda...">{{ old('description', $experience?->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback-admin">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Skills Tag Input --}}
                <div class="mb-3">
                    <label class="form-label-admin">Skills / Teknologi</label>
                    <div class="skills-wrapper" id="skillsWrapper">
                        <input type="text" class="skills-input" id="skillsInput"
                               placeholder="Ketik lalu Enter…">
                    </div>
                    {{-- Hidden field yang dikirim ke server --}}
                    <input type="hidden" name="skills" id="skillsHidden"
                           value="{{ old('skills', $experience ? implode(',', $experience->skills_list) : '') }}">
                    <div class="form-hint">Tekan <kbd>Enter</kbd> atau <kbd>,</kbd> untuk menambah skill</div>
                </div>

                {{-- ── Actions ──────────────────────────────────────────── --}}
                <div class="d-flex align-items-center gap-3 mt-4 pt-3"
                     style="border-top:1.5px solid var(--card-border);">
                    <button type="submit" class="btn-admin-primary">
                        <i class="bi {{ $isEdit ? 'bi-check-lg' : 'bi-plus-lg' }}"></i>
                        {{ $isEdit ? 'Simpan Perubahan' : 'Tambah Experience' }}
                    </button>
                    <a href="{{ route('experiences.index') }}"
                       style="font-size:.84rem; color:var(--text-muted); text-decoration:none;">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>

    {{-- Preview Card --}}
    <div class="col-lg-4">
        <div class="admin-card" style="position:sticky; top:84px;">
            <div class="admin-card-header">
                <h6 class="admin-card-title">
                    <i class="bi bi-eye me-2 text-primary"></i>Preview
                </h6>
            </div>

            <div class="exp-card" style="box-shadow:none; border:1.5px solid var(--card-border);">
                <div class="exp-card-top">
                    <div class="d-flex align-items-start gap-3">
                        <div class="exp-logo" id="prevLogo" style="background:#eff6ff; color:#2563eb;">
                            <i class="bi bi-building-fill" id="prevLogoIcon"></i>
                        </div>
                        <div>
                            <div class="exp-position" id="prevPosition">Posisi Anda</div>
                            <div class="exp-company">
                                <i class="bi bi-building me-1"></i>
                                <span id="prevCompany">Nama Perusahaan</span>
                            </div>
                            <div class="exp-period">
                                <i class="bi bi-calendar3 me-1"></i>
                                <span id="prevPeriod">— –</span>
                            </div>
                        </div>
                    </div>
                    <span class="badge-admin green" id="prevBadge" style="display:none;">
                        <i class="bi bi-circle-fill" style="font-size:.4rem;"></i> Aktif
                    </span>
                </div>
                <div class="exp-card-footer mt-3">
                    <div class="d-flex flex-wrap gap-1" id="prevSkills"></div>
                    <span style="font-size:.72rem; color:var(--text-muted);" id="prevLocation"></span>
                </div>
            </div>

            <p class="form-hint mt-3 text-center">Preview diperbarui otomatis saat Anda mengisi form</p>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Skills Tag Input ──────────────────────────────────────────────────────
    const wrapper     = document.getElementById('skillsWrapper');
    const input       = document.getElementById('skillsInput');
    const hiddenField = document.getElementById('skillsHidden');

    let skills = hiddenField.value
        ? hiddenField.value.split(',').map(s => s.trim()).filter(Boolean)
        : [];

    function renderTags() {
        wrapper.querySelectorAll('.skill-tag').forEach(t => t.remove());
        skills.forEach((sk, i) => {
            const tag = document.createElement('span');
            tag.className = 'skill-tag';
            tag.innerHTML = `${sk}<button type="button" data-i="${i}" aria-label="Hapus">&times;</button>`;
            wrapper.insertBefore(tag, input);
        });
        hiddenField.value = skills.join(',');
        updatePreview();
    }

    function addSkill(val) {
        const sk = val.trim().replace(/,$/, '');
        if (sk && !skills.includes(sk)) {
            skills.push(sk);
            renderTags();
        }
        input.value = '';
    }

    input.addEventListener('keydown', e => {
        if (['Enter', ','].includes(e.key)) {
            e.preventDefault();
            addSkill(input.value);
        } else if (e.key === 'Backspace' && !input.value && skills.length) {
            skills.pop();
            renderTags();
        }
    });

    wrapper.addEventListener('click', e => {
        if (e.target.dataset.i !== undefined) {
            skills.splice(+e.target.dataset.i, 1);
            renderTags();
        } else {
            input.focus();
        }
    });

    // ── Is Current Toggle ─────────────────────────────────────────────────────
    const isCurrent   = document.getElementById('is_current');
    const endWrapper  = document.getElementById('endDateWrapper');

    function toggleEndDate() {
        endWrapper.style.opacity   = isCurrent.checked ? '.4' : '1';
        endWrapper.style.pointerEvents = isCurrent.checked ? 'none' : 'auto';
        if (isCurrent.checked) document.getElementById('end_date').value = '';
        updatePreview();
    }
    isCurrent.addEventListener('change', toggleEndDate);
    toggleEndDate();

    // ── Live Preview ──────────────────────────────────────────────────────────
    const logoIconMap = {
        corporate: 'bi-building-fill',
        startup:   'bi-rocket-takeoff-fill',
        freelance: 'bi-person-workspace',
        ngo:       'bi-heart-fill',
    };

    function formatMonthYear(dateStr) {
        if (!dateStr) return null;
        const d = new Date(dateStr + 'T00:00:00');
        return d.toLocaleString('id-ID', { month: 'short', year: 'numeric' });
    }

    function updatePreview() {
        const pos     = document.getElementById('position').value || 'Posisi Anda';
        const company = document.getElementById('company').value  || 'Nama Perusahaan';
        const type    = document.getElementById('company_type').value;
        const loc     = document.getElementById('location').value;
        const start   = document.getElementById('start_date').value;
        const end     = document.getElementById('end_date').value;
        const active  = document.getElementById('is_current').checked;

        document.getElementById('prevPosition').textContent = pos;
        document.getElementById('prevCompany').textContent  = company;
        document.getElementById('prevLocation').innerHTML   = loc
            ? `<i class="bi bi-geo-alt me-1"></i>${loc}` : '';

        const startFmt = formatMonthYear(start) || '—';
        const endFmt   = active ? 'Sekarang' : (formatMonthYear(end) || '—');
        document.getElementById('prevPeriod').textContent = `${startFmt} – ${endFmt}`;

        const badge = document.getElementById('prevBadge');
        badge.style.display = active ? '' : 'none';

        const icon = document.getElementById('prevLogoIcon');
        icon.className = `bi ${logoIconMap[type] || 'bi-building-fill'}`;

        // Skills preview
        const container = document.getElementById('prevSkills');
        container.innerHTML = skills.map(s =>
            `<span class="exp-tag">${s}</span>`
        ).join('');
    }

    ['position','company','company_type','location','start_date','end_date']
        .forEach(id => document.getElementById(id)
            ?.addEventListener('input', updatePreview));
    document.getElementById('company_type')
        .addEventListener('change', updatePreview);

    renderTags(); // init dari data lama (edit mode)
    updatePreview();
});
</script>
@endpush
