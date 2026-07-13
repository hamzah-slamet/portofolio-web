{{-- resources/views/content/educations/form.blade.php --}}
@extends('layouts.app')

@section('title', $isEdit ? 'Edit Pendidikan' : 'Tambah Pendidikan')
@section('topbar-title', 'Pendidikan')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/content/experience/experiences-style.css') }}">
<style>
/* ── Form styles (sama dengan experience, + tambahan) ────── */
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
.is-invalid-admin { border-color: #ef4444 !important; }
.invalid-feedback-admin {
    font-size: .72rem;
    color: #ef4444;
    margin-top: 4px;
}

/* GPA input wrapper */
.gpa-wrapper {
    position: relative;
}
.gpa-wrapper .gpa-suffix {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    font-size: .78rem;
    color: var(--text-muted);
    font-weight: 600;
    pointer-events: none;
}
.gpa-wrapper input { padding-right: 48px; }

/* GPA meter */
.gpa-meter-wrap {
    margin-top: 8px;
}
.gpa-meter-track {
    height: 6px;
    background: var(--blue-light);
    border-radius: 99px;
    overflow: hidden;
}
.gpa-meter-fill {
    height: 100%;
    border-radius: 99px;
    transition: width .3s, background .3s;
}
.gpa-meter-label {
    font-size: .7rem;
    color: var(--text-muted);
    margin-top: 4px;
}

/* Tag input (achievements) */
.tags-wrapper {
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
.tags-wrapper:focus-within {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37,99,235,.1);
}
.ach-tag {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #fefce8;
    color: #a16207;
    border: 1px solid #fde68a;
    border-radius: 6px;
    padding: 3px 10px;
    font-size: .78rem;
    font-weight: 600;
}
.ach-tag button {
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
    color: #fbbf24;
    line-height: 1;
    font-size: .9rem;
}
.ach-tag button:hover { color: #a16207; }
.tags-input {
    border: none;
    outline: none;
    background: transparent;
    color: var(--text-primary);
    font-size: .85rem;
    min-width: 140px;
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

/* Preview overrides */
.prev-degree-lbl {
    font-size: .78rem;
    font-weight: 600;
    color: var(--text-secondary);
    margin-bottom: 2px;
}
.prev-gpa-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 3px 9px;
    border-radius: 6px;
    font-size: .72rem;
    font-weight: 700;
}
</style>
@endpush

@section('page-header')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('educations.index') }}"
               style="width:36px; height:36px; border-radius:10px; background:var(--bg-secondary);
                      border:1.5px solid var(--card-border); display:grid; place-items:center;
                      color:var(--text-secondary); text-decoration:none;">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h4 class="mb-1" style="font-size:1.25rem; font-weight:800; color:var(--text-primary);">
                    {{ $isEdit ? 'Edit Pendidikan' : 'Tambah Pendidikan' }}
                </h4>
                <p class="text-muted mb-0" style="font-size:.78rem;">
                    {{ $isEdit ? 'Perbarui data riwayat pendidikan' : 'Tambah riwayat pendidikan baru' }}
                </p>
            </div>
        </div>
    </div>
@endsection

@section('content')

<div class="row g-4">
    <div class="col-lg-8">
        <div class="admin-card">

            <form action="{{ $isEdit ? route('educations.update', $education) : route('educations.store') }}"
                  method="POST" id="eduForm">
                @csrf
                @if($isEdit) @method('PUT') @endif

                {{-- ── Informasi Institusi ─────────────────────────────── --}}
                <div class="section-divider"><span>Informasi Institusi</span></div>

                <div class="row g-3">
                    {{-- Institusi --}}
                    <div class="col-md-8">
                        <label class="form-label-admin" for="institution">
                            Nama Institusi <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="institution" name="institution"
                               class="form-control-admin @error('institution') is-invalid-admin @enderror"
                               value="{{ old('institution', $education?->institution) }}"
                               placeholder="Universitas Indonesia">
                        @error('institution')
                            <div class="invalid-feedback-admin">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tipe Institusi --}}
                    <div class="col-md-4">
                        <label class="form-label-admin" for="institution_type">Tipe</label>
                        <select id="institution_type" name="institution_type" class="form-select-admin">
                            <option value="university" {{ old('institution_type', $education?->institution_type) === 'university' ? 'selected' : '' }}>Universitas</option>
                            <option value="school"     {{ old('institution_type', $education?->institution_type) === 'school'     ? 'selected' : '' }}>Sekolah</option>
                            <option value="bootcamp"   {{ old('institution_type', $education?->institution_type) === 'bootcamp'   ? 'selected' : '' }}>Bootcamp</option>
                            <option value="course"     {{ old('institution_type', $education?->institution_type) === 'course'     ? 'selected' : '' }}>Kursus / Online</option>
                        </select>
                    </div>

                    {{-- Jenjang --}}
                    <div class="col-md-6">
                        <label class="form-label-admin" for="degree">
                            Jenjang / Gelar <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="degree" name="degree"
                               class="form-control-admin @error('degree') is-invalid-admin @enderror"
                               value="{{ old('degree', $education?->degree) }}"
                               placeholder="S1, S2, SMA, Diploma, dll.">
                        @error('degree')
                            <div class="invalid-feedback-admin">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Jurusan --}}
                    <div class="col-md-6">
                        <label class="form-label-admin" for="major">
                            Jurusan / Program Studi <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="major" name="major"
                               class="form-control-admin @error('major') is-invalid-admin @enderror"
                               value="{{ old('major', $education?->major) }}"
                               placeholder="Teknik Informatika">
                        @error('major')
                            <div class="invalid-feedback-admin">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Lokasi --}}
                    <div class="col-md-6">
                        <label class="form-label-admin" for="location">Lokasi</label>
                        <input type="text" id="location" name="location"
                               class="form-control-admin @error('location') is-invalid-admin @enderror"
                               value="{{ old('location', $education?->location) }}"
                               placeholder="Depok, Jawa Barat">
                        @error('location')
                            <div class="invalid-feedback-admin">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- GPA --}}
                    <div class="col-md-6">
                        <label class="form-label-admin" for="gpa">IPK / GPA</label>
                        <div class="gpa-wrapper">
                            <input type="number" id="gpa" name="gpa"
                                   step="0.01" min="0" max="4"
                                   class="form-control-admin @error('gpa') is-invalid-admin @enderror"
                                   value="{{ old('gpa', $education?->gpa) }}"
                                   placeholder="3.85">
                            <span class="gpa-suffix">/ 4.00</span>
                        </div>
                        @error('gpa')
                            <div class="invalid-feedback-admin">{{ $message }}</div>
                        @enderror
                        <div class="gpa-meter-wrap">
                            <div class="gpa-meter-track">
                                <div class="gpa-meter-fill" id="gpaMeterFill" style="width:0%; background:#e5e7eb;"></div>
                            </div>
                            <div class="gpa-meter-label" id="gpaMeterLabel">Masukkan IPK</div>
                        </div>
                    </div>
                </div>

                {{-- ── Periode ─────────────────────────────────────────── --}}
                <div class="section-divider"><span>Periode</span></div>

                <div class="mb-3 d-flex align-items-center gap-3">
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" role="switch"
                               id="is_current" name="is_current" value="1"
                               {{ old('is_current', $education?->is_current) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_current"
                               style="font-size:.85rem; font-weight:600; color:var(--text-primary);">
                            Masih menempuh pendidikan di sini
                        </label>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label-admin" for="start_date">
                            Tahun Masuk <span class="text-danger">*</span>
                        </label>
                        <input type="date" id="start_date" name="start_date"
                               class="form-control-admin @error('start_date') is-invalid-admin @enderror"
                               value="{{ old('start_date', $education?->start_date?->format('Y-m-d')) }}">
                        @error('start_date')
                            <div class="invalid-feedback-admin">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6" id="endDateWrapper">
                        <label class="form-label-admin" for="end_date">Tahun Lulus</label>
                        <input type="date" id="end_date" name="end_date"
                               class="form-control-admin @error('end_date') is-invalid-admin @enderror"
                               value="{{ old('end_date', $education?->end_date?->format('Y-m-d')) }}">
                        @error('end_date')
                            <div class="invalid-feedback-admin">{{ $message }}</div>
                        @enderror
                        <div class="form-hint">Kosongkan jika masih aktif</div>
                    </div>
                </div>

                {{-- ── Detail ──────────────────────────────────────────── --}}
                <div class="section-divider"><span>Detail</span></div>

                <div class="mb-3">
                    <label class="form-label-admin" for="description">Deskripsi</label>
                    <textarea id="description" name="description"
                              class="form-control-admin @error('description') is-invalid-admin @enderror"
                              placeholder="Ceritakan fokus studi, kegiatan organisasi, atau hal menarik lainnya...">{{ old('description', $education?->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback-admin">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Achievements Tag Input --}}
                <div class="mb-3">
                    <label class="form-label-admin">Penghargaan / Prestasi</label>
                    <div class="tags-wrapper" id="achWrapper">
                        <input type="text" class="tags-input" id="achInput"
                               placeholder="Ketik lalu Enter…">
                    </div>
                    <input type="hidden" name="achievements" id="achHidden"
                           value="{{ old('achievements', $education ? implode(',', $education->achievements_list) : '') }}">
                    <div class="form-hint">
                        Contoh: Cumlaude, Beasiswa Bidikmisi, Juara 1 Hackathon — tekan <kbd>Enter</kbd> atau <kbd>,</kbd>
                    </div>
                </div>

                {{-- ── Actions ──────────────────────────────────────────── --}}
                <div class="d-flex align-items-center gap-3 mt-4 pt-3"
                     style="border-top:1.5px solid var(--card-border);">
                    <button type="submit" class="btn-admin-primary">
                        <i class="bi {{ $isEdit ? 'bi-check-lg' : 'bi-plus-lg' }}"></i>
                        {{ $isEdit ? 'Simpan Perubahan' : 'Tambah Pendidikan' }}
                    </button>
                    <a href="{{ route('educations.index') }}"
                       style="font-size:.84rem; color:var(--text-muted); text-decoration:none;">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>

    {{-- Live Preview --}}
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
                            <div class="exp-position" id="prevMajor">Jurusan / Program Studi</div>
                            <div class="prev-degree-lbl" id="prevDegree">Jenjang</div>
                            <div class="exp-company">
                                <i class="bi bi-building me-1"></i>
                                <span id="prevInstitution">Nama Institusi</span>
                            </div>
                            <div class="exp-period">
                                <i class="bi bi-calendar3 me-1"></i>
                                <span id="prevPeriod">— – —</span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-column align-items-end gap-1">
                        <span class="badge-admin green" id="prevBadge" style="display:none;">
                            <i class="bi bi-circle-fill" style="font-size:.4rem;"></i> Aktif
                        </span>
                        <span class="prev-gpa-badge" id="prevGpaBadge" style="display:none;"></span>
                    </div>
                </div>

                <div class="exp-card-footer mt-3">
                    <div class="d-flex flex-wrap gap-1" id="prevAchievements"></div>
                    <span style="font-size:.72rem; color:var(--text-muted);" id="prevLocation"></span>
                </div>
            </div>

            <p class="form-hint mt-3 text-center">Preview diperbarui otomatis</p>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── GPA Meter ─────────────────────────────────────────────────────────────
    const gpaInput = document.getElementById('gpa');
    const fill     = document.getElementById('gpaMeterFill');
    const lbl      = document.getElementById('gpaMeterLabel');

    const gpaColors = [
        { min: 3.75, color: '#16a34a', label: 'Sangat Memuaskan (Cumlaude)' },
        { min: 3.50, color: '#2563eb', label: 'Memuaskan' },
        { min: 3.00, color: '#d97706', label: 'Cukup Baik' },
        { min: 0,    color: '#9ca3af', label: 'Cukup' },
    ];

    function updateGpaMeter() {
        const val = parseFloat(gpaInput.value);
        if (!val || val < 0 || val > 4) {
            fill.style.width = '0%';
            fill.style.background = '#e5e7eb';
            lbl.textContent = 'Masukkan IPK';
            return;
        }
        const pct   = (val / 4) * 100;
        const entry = gpaColors.find(g => val >= g.min) || gpaColors.at(-1);
        fill.style.width      = pct + '%';
        fill.style.background = entry.color;
        lbl.textContent       = `${val.toFixed(2)} — ${entry.label}`;
        updatePreview();
    }
    gpaInput.addEventListener('input', updateGpaMeter);
    updateGpaMeter();

    // ── Achievements Tag Input ────────────────────────────────────────────────
    const achWrapper = document.getElementById('achWrapper');
    const achInput   = document.getElementById('achInput');
    const achHidden  = document.getElementById('achHidden');

    let achievements = achHidden.value
        ? achHidden.value.split(',').map(s => s.trim()).filter(Boolean)
        : [];

    function renderAchTags() {
        achWrapper.querySelectorAll('.ach-tag').forEach(t => t.remove());
        achievements.forEach((a, i) => {
            const tag = document.createElement('span');
            tag.className = 'ach-tag';
            tag.innerHTML = `<i class="bi bi-trophy-fill" style="font-size:.6rem;"></i>${a}<button type="button" data-i="${i}">&times;</button>`;
            achWrapper.insertBefore(tag, achInput);
        });
        achHidden.value = achievements.join(',');
        updatePreview();
    }

    function addAch(val) {
        const a = val.trim().replace(/,$/, '');
        if (a && !achievements.includes(a)) {
            achievements.push(a);
            renderAchTags();
        }
        achInput.value = '';
    }

    achInput.addEventListener('keydown', e => {
        if (['Enter', ','].includes(e.key)) {
            e.preventDefault();
            addAch(achInput.value);
        } else if (e.key === 'Backspace' && !achInput.value && achievements.length) {
            achievements.pop();
            renderAchTags();
        }
    });

    achWrapper.addEventListener('click', e => {
        if (e.target.dataset.i !== undefined) {
            achievements.splice(+e.target.dataset.i, 1);
            renderAchTags();
        } else {
            achInput.focus();
        }
    });

    // ── Is Current Toggle ─────────────────────────────────────────────────────
    const isCurrent  = document.getElementById('is_current');
    const endWrapper = document.getElementById('endDateWrapper');

    function toggleEndDate() {
        endWrapper.style.opacity       = isCurrent.checked ? '.4' : '1';
        endWrapper.style.pointerEvents = isCurrent.checked ? 'none' : 'auto';
        if (isCurrent.checked) document.getElementById('end_date').value = '';
        updatePreview();
    }
    isCurrent.addEventListener('change', toggleEndDate);
    toggleEndDate();

    // ── Live Preview ──────────────────────────────────────────────────────────
    const typeConfig = {
        university: { icon: 'bi-building-fill',        bg: '#eff6ff', color: '#2563eb' },
        school:     { icon: 'bi-house-fill',            bg: '#f0fdf4', color: '#16a34a' },
        bootcamp:   { icon: 'bi-lightning-charge-fill', bg: '#fff7ed', color: '#ea580c' },
        course:     { icon: 'bi-play-circle-fill',      bg: '#fdf4ff', color: '#9333ea' },
    };

    const gpaPreviewColors = [
        { min: 3.75, bg: '#f0fdf4', color: '#16a34a' },
        { min: 3.50, bg: '#eff6ff', color: '#2563eb' },
        { min: 3.00, bg: '#fffbeb', color: '#d97706' },
        { min: 0,    bg: '#f3f4f6', color: '#6b7280' },
    ];

    function formatYear(dateStr) {
        if (!dateStr) return null;
        return new Date(dateStr + 'T00:00:00').getFullYear();
    }

    function updatePreview() {
        const institution = document.getElementById('institution').value  || 'Nama Institusi';
        const degree      = document.getElementById('degree').value       || 'Jenjang';
        const major       = document.getElementById('major').value        || 'Jurusan / Program Studi';
        const type        = document.getElementById('institution_type').value;
        const loc         = document.getElementById('location').value;
        const start       = document.getElementById('start_date').value;
        const end         = document.getElementById('end_date').value;
        const active      = document.getElementById('is_current').checked;
        const gpa         = parseFloat(document.getElementById('gpa').value);

        document.getElementById('prevMajor').textContent       = major;
        document.getElementById('prevDegree').textContent      = degree;
        document.getElementById('prevInstitution').textContent = institution;
        document.getElementById('prevLocation').innerHTML      = loc
            ? `<i class="bi bi-geo-alt me-1"></i>${loc}` : '';

        const startY = formatYear(start) || '—';
        const endY   = active ? 'Sekarang' : (formatYear(end) || '—');
        document.getElementById('prevPeriod').textContent = `${startY} – ${endY}`;

        // Badge aktif
        document.getElementById('prevBadge').style.display = active ? '' : 'none';

        // Logo icon
        const cfg  = typeConfig[type] || typeConfig.university;
        const logo = document.getElementById('prevLogo');
        logo.style.background = cfg.bg;
        logo.style.color      = cfg.color;
        document.getElementById('prevLogoIcon').className = `bi ${cfg.icon}`;

        // GPA badge
        const gpaBadge = document.getElementById('prevGpaBadge');
        if (gpa && gpa > 0 && gpa <= 4) {
            const c = gpaPreviewColors.find(g => gpa >= g.min) || gpaPreviewColors.at(-1);
            gpaBadge.style.display    = '';
            gpaBadge.style.background = c.bg;
            gpaBadge.style.color      = c.color;
            gpaBadge.innerHTML = `<i class="bi bi-star-fill" style="font-size:.6rem;"></i> GPA ${gpa.toFixed(2)}`;
        } else {
            gpaBadge.style.display = 'none';
        }

        // Achievements
        document.getElementById('prevAchievements').innerHTML = achievements.map(a =>
            `<span class="achievement-pill"><i class="bi bi-trophy-fill"></i>${a}</span>`
        ).join('');
    }

    ['institution','degree','major','location','start_date','end_date']
        .forEach(id => document.getElementById(id)?.addEventListener('input', updatePreview));
    document.getElementById('institution_type').addEventListener('change', updatePreview);

    renderAchTags(); // init dari data lama (edit mode)
    updatePreview();
});
</script>
@endpush
