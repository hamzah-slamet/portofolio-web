{{-- resources/views/content/skills/_form.blade.php --}}
{{-- $prefix : 'add' | 'edit'                      --}}
{{-- $skill  : App\Models\Skill|null               --}}

<div class="form-section">Informasi Skill</div>

<div class="row g-3">
    {{-- Name --}}
    <div class="col-md-8">
        <label class="form-label">Nama Skill <span class="text-danger">*</span></label>
        <input type="text" id="{{ $prefix }}_name" name="name"
               class="form-control" placeholder="Contoh: Laravel" required
               value="{{ old('name', $skill->name ?? '') }}">
    </div>

    {{-- Level --}}
    <div class="col-md-4">
        <label class="form-label d-flex justify-content-between">
            Level Kemampuan
            <span id="{{ $prefix }}_level_val"
                  style="font-weight:700;color:var(--blue);">
                {{ old('level', $skill->level ?? 50) }}%
            </span>
        </label>
        <input type="range" id="{{ $prefix }}_level" name="level"
               class="form-range" min="0" max="100" step="1"
               value="{{ old('level', $skill->level ?? 50) }}"
               style="accent-color:var(--blue);">
    </div>

    {{-- Category --}}
    <div class="col-md-6">
        <label class="form-label">Kategori <span class="text-danger">*</span></label>
        <input type="text" id="{{ $prefix }}_category" name="category"
               class="form-control" placeholder="Backend / Frontend / DevOps / Design"
               list="{{ $prefix }}_cat_list_opt" required
               value="{{ old('category', $skill->category ?? '') }}">
        <datalist id="{{ $prefix }}_cat_list_opt">
            <option value="Backend">
            <option value="Frontend">
            <option value="DevOps & Tools">
            <option value="Design">
            <option value="Mobile">
            <option value="Database">
        </datalist>
        <small class="text-muted">Pilih dari daftar atau ketik kategori baru.</small>
    </div>

    {{-- Icon --}}
    <div class="col-md-6">
        <label class="form-label">Bootstrap Icon Class</label>
        <div class="input-group">
            <span class="input-group-text" style="border-radius:10px 0 0 10px;border:1.5px solid var(--card-border);">
                <i id="{{ $prefix }}_icon_preview" class="{{ $skill->icon ?? 'bi bi-lightning-charge' }}"
                   style="font-size:1rem;"></i>
            </span>
            <input type="text" id="{{ $prefix }}_icon" name="icon"
                   class="form-control" placeholder="bi bi-lightning-charge"
                   style="border-radius:0 10px 10px 0;"
                   value="{{ old('icon', $skill->icon ?? '') }}">
        </div>
        <small class="text-muted">
            Cari di <a href="https://icons.getbootstrap.com" target="_blank" style="color:var(--blue);">icons.getbootstrap.com</a>
        </small>
    </div>
</div>

{{-- Color --}}
<div class="mt-3">
    <label class="form-label">Warna</label>
    <div class="d-flex align-items-center gap-3">
        <input type="color" id="{{ $prefix }}_color" name="color"
               value="{{ old('color', $skill->color ?? '#2563eb') }}"
               style="width:44px;height:38px;border-radius:8px;border:1.5px solid var(--card-border);padding:2px;cursor:pointer;">
        <div id="{{ $prefix }}_swatches" class="color-swatches"></div>
    </div>
    <small class="text-muted mt-1 d-block">Warna ini digunakan untuk icon, progress bar, dan persentase.</small>
</div>

