<div class="row g-3">

    {{-- Judul --}}
    <div class="col-md-8">
        <div class="form-group-box">
            <label class="form-label">Judul <span class="text-danger">*</span></label>
            <input type="text" id="{{ $prefix }}_title" name="title"
                   class="form-control" placeholder="Contoh: E-Commerce App" required
                   value="{{ old('title', $project->title ?? '') }}">
        </div>
    </div>

    {{-- Status --}}
    <div class="col-md-4">
        <div class="form-group-box">
            <label class="form-label">Status</label>
            <select id="{{ $prefix }}_status" name="status" class="form-select">
                @foreach(['online' => 'Online', 'offline' => 'Offline', 'development' => 'Development'] as $val => $label)
                <option value="{{ $val }}"
                    {{ old('status', $project->status ?? 'development') === $val ? 'selected' : '' }}>
                    {{ $label }}
                </option>
                @endforeach
            </select>
        </div>
    </div>

</div>

{{-- Slug --}}
<div class="mt-3">
    <div class="form-group-box">
        <label class="form-label">Slug</label>
        <input type="text" id="{{ $prefix }}_slug" name="slug"
               class="form-control" placeholder="auto-generate dari judul"
               value="{{ old('slug', $project->slug ?? '') }}">
    </div>
</div>

{{-- Deskripsi --}}
<div class="mt-3">
    <div class="form-group-box">
        <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
        <textarea id="{{ $prefix }}_description" name="description" rows="3"
                  class="form-control" placeholder="Jelaskan fitur & tujuan project..." required>{{ old('description', $project->description ?? '') }}</textarea>
    </div>
</div>

{{-- Tech Stack --}}
<div class="mt-3">
    <label class="form-label">Tech Stack</label>
    <div class="tech-input-wrap" id="{{ $prefix }}_tech_wrap">
        <input type="text" id="{{ $prefix }}_tech_input" class="tech-bare-input"
               placeholder="Ketik lalu Enter…">
    </div>
    <div id="{{ $prefix }}_tech_hidden"></div>
    <small class="text-muted">Tekan Enter atau koma untuk menambah teknologi.</small>
</div>

{{-- Links --}}
<div class="form-section">Links</div>

<div class="row g-3">

    <div class="col-md-6">
        <div class="form-group-box">
            <label class="form-label"><i class="bi bi-github me-1"></i>GitHub URL</label>
            <input type="url" id="{{ $prefix }}_github_url" name="github_url"
                   class="form-control" placeholder="https://github.com/user/repo"
                   value="{{ old('github_url', $project->github_url ?? '') }}">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group-box">
            <label class="form-label"><i class="bi bi-box-arrow-up-right me-1"></i>Live URL</label>
            <input type="url" id="{{ $prefix }}_live_url" name="live_url"
                   class="form-control" placeholder="https://example.com"
                   value="{{ old('live_url', $project->live_url ?? '') }}">
        </div>
    </div>

</div>

{{-- Thumbnail & Pengaturan --}}
<div class="form-section">Thumbnail & Pengaturan</div>

<div class="row g-3">

    <div class="col-md-6">
        <div class="form-group-box">
            <label class="form-label">Thumbnail</label>
            <input type="file" id="{{ $prefix }}_thumbnail" name="thumbnail"
                   class="form-control" accept="image/*">
        </div>

        <div class="thumb-preview-box mt-2" id="{{ $prefix }}_thumb_preview">
            <i class="bi bi-image"></i>
        </div>
    </div>

    <div class="col-md-6">

        <div class="form-group-box mb-3">
            <label class="form-label">Urutan Tampil</label>
            <input type="number" id="{{ $prefix }}_sort_order" name="sort_order"
                   class="form-control" min="0"
                   value="{{ old('sort_order', $project->sort_order ?? 0) }}">
        </div>

        <div class="form-group-box">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="is_featured" value="1"
                       id="{{ $prefix }}_is_featured"
                       {{ old('is_featured', $project->is_featured ?? false) ? 'checked' : '' }}>
                <label class="form-check-label form-label mb-0" for="{{ $prefix }}_is_featured">
                    <i class="bi bi-pin-angle-fill me-1"></i> Tandai sebagai Featured
                </label>
            </div>
        </div>

    </div>

</div>
