// ── Isi modal Edit saat tombol Edit diklik ───────────────────────────────────
document.querySelectorAll('.btn-edit-project').forEach(btn => {
    btn.addEventListener('click', function () {
        const d = this.dataset;

        document.getElementById('formEdit').action = `/projects/${d.id}`;

        document.getElementById('edit_title').value       = d.title;
        document.getElementById('edit_slug').value        = d.slug;
        document.getElementById('edit_description').value = d.description;
        document.getElementById('edit_github_url').value  = d.github || '';
        document.getElementById('edit_live_url').value    = d.live   || '';
        document.getElementById('edit_status').value      = d.status;
        document.getElementById('edit_sort_order').value  = d.sort;
        document.getElementById('edit_is_featured').checked = d.featured === '1';

        const box = document.getElementById('edit_thumb_preview');
        box.innerHTML = d.thumb
            ? `<img src="${d.thumb}" alt="thumbnail">`
            : `<i class="bi bi-image"></i>`;

        const tags = JSON.parse(d.tech || '[]');
        initTechInput('edit', tags);
    });
});

// ── Tech Stack pill builder ───────────────────────────────────────────────────
function initTechInput(prefix, initialTags = []) {
    const wrap      = document.getElementById(`${prefix}_tech_wrap`);
    const rawInput  = document.getElementById(`${prefix}_tech_input`);
    const container = document.getElementById(`${prefix}_tech_hidden`);
    let   tags      = [...initialTags];

    function render() {
        wrap.querySelectorAll('.tech-pill').forEach(el => el.remove());
        container.innerHTML = '';
        tags.forEach((tag, i) => {
            const pill = document.createElement('span');
            pill.className = 'tech-pill';
            pill.innerHTML = `${tag} <button type="button" onclick="removeTechTag('${prefix}',${i})">×</button>`;
            wrap.insertBefore(pill, rawInput);

            const hidden = document.createElement('input');
            hidden.type  = 'hidden';
            hidden.name  = 'tech_stack[]';
            hidden.value = tag;
            container.appendChild(hidden);
        });
    }

    window[`_techTags_${prefix}`]   = tags;
    window[`_techRender_${prefix}`] = render;

    rawInput.addEventListener('keydown', e => {
        if (e.key === 'Enter' || e.key === ',') {
            e.preventDefault();
            const val = rawInput.value.trim();
            if (val && !tags.includes(val)) { tags.push(val); render(); }
            rawInput.value = '';
        }
    });

    wrap.addEventListener('click', () => rawInput.focus());
    render();
}

function removeTechTag(prefix, index) {
    window[`_techTags_${prefix}`].splice(index, 1);
    window[`_techRender_${prefix}`]();
}

// ── Init Add modal tech input on page load ───────────────────────────────────
initTechInput('add', []);

// Reset Add modal saat ditutup
document.getElementById('modalAdd').addEventListener('hidden.bs.modal', () => {
    document.getElementById('modalAdd').querySelector('form').reset();
    document.getElementById('add_thumb_preview').innerHTML = '<i class="bi bi-image"></i>';
    initTechInput('add', []);
    document.getElementById('add_slug').removeAttribute('data-manual');
});

// ── Auto slug (Add) ──────────────────────────────────────────────────────────
document.getElementById('add_title').addEventListener('input', function () {
    const slugEl = document.getElementById('add_slug');
    if (!slugEl.dataset.manual) {
        slugEl.value = this.value.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '').trim().replace(/\s+/g, '-');
    }
});
document.getElementById('add_slug').addEventListener('input', function () {
    this.dataset.manual = '1';
});

// ── Thumbnail preview helper ─────────────────────────────────────────────────
function bindThumbPreview(inputId, previewId) {
    document.getElementById(inputId).addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById(previewId).innerHTML =
                `<img src="${e.target.result}" alt="preview">`;
        };
        reader.readAsDataURL(file);
    });
}
bindThumbPreview('add_thumbnail',  'add_thumb_preview');
bindThumbPreview('edit_thumbnail', 'edit_thumb_preview');
