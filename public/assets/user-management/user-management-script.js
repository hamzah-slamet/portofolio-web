
// ─── Hitung Umur dari Tanggal Lahir ──────────────
function hitungUmur(tglLahir) {
    if (!tglLahir) return null;
    const lahir = new Date(tglLahir);
    const today = new Date();
    let umur = today.getFullYear() - lahir.getFullYear();
    const bulan = today.getMonth() - lahir.getMonth();
    if (bulan < 0 || (bulan === 0 && today.getDate() < lahir.getDate())) {
        umur--;
    }
    return umur >= 0 ? umur : null;
}

function hitungUmurAdd(val) {
    const umur = hitungUmur(val);
    const input = document.getElementById('add-umur');
    input.value = umur !== null ? umur : '';
}

function hitungUmurEdit(val) {
    const umur = hitungUmur(val);
    const input = document.getElementById('modal-umur');
    input.value = umur !== null ? umur : '';
}

// ─── Error Modal ──────────────────────────────────
function showModalError(alertId, listId, fields) {
    const msgs = fields.flatMap(f => LARAVEL_ERRORS[f] ?? []);
    if (!msgs.length) return;
    const list = document.getElementById(listId);
    list.innerHTML = '<strong style="display:block;margin-bottom:4px;">Terjadi Kesalahan:</strong>'
        + msgs.map(m => `<div>• ${m}</div>`).join('');
    document.getElementById(alertId).classList.add('show');
}

function hideModalError(alertId, listId) {
    const alert = document.getElementById(alertId);
    const list = document.getElementById(listId);
    if (alert) alert.classList.remove('show');
    if (list) list.innerHTML = '';
}

// ─── Auto-open saat ada error validasi ───────────
document.addEventListener('DOMContentLoaded', function () {
    if (FORM_TYPE === 'add' && Object.keys(LARAVEL_ERRORS).length) {
        document.getElementById('addModal').classList.add('show');
        document.body.style.overflow = 'hidden';
        showModalError('add-error-alert', 'add-error-list', ['name', 'email', 'user_id', 'password']);
        document.querySelector('#addModal .modal-box').scrollTop = 0;
    }

    if (FORM_TYPE === 'edit' && OLD_USER_ID && Object.keys(LARAVEL_ERRORS).length) {
        openEditModal(OLD_USER_ID);
        showModalError('edit-error-alert', 'edit-error-list', ['name', 'email', 'user_id']);
        document.querySelector('#editModal .modal-box').scrollTop = 0;
    }
});

// ─── Search ──────────────────────────────────────
document.getElementById('searchInput').addEventListener('input', function () {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#userTable tbody tr[data-search]').forEach(row => {
        row.style.display = row.dataset.search.includes(q) ? '' : 'none';
    });
});

// ─── Modal Edit ──────────────────────────────────
function openEditModal(userId) {
    const u = USERS.find(x => x.id === userId);
    if (!u) return;

    document.getElementById('editForm').action = u.update_url;

    let hiddenId = document.getElementById('editForm').querySelector('input[name="edit_user_id"]');
    if (!hiddenId) {
        hiddenId = document.createElement('input');
        hiddenId.type = 'hidden';
        hiddenId.name = 'edit_user_id';
        document.getElementById('editForm').appendChild(hiddenId);
    }
    hiddenId.value = userId;

    document.getElementById('modal-name').value = u.name ?? '';
    document.getElementById('modal-email').value = u.email ?? '';
    document.getElementById('modal-user-id').value = u.user_id ?? '';
    document.getElementById('modal-alamat').value = u.alamat ?? '';
    document.getElementById('modal-tentang').value = u.tentang ?? '';
    document.getElementById('modal-role').value = u.role ?? 'user';
    document.getElementById('modal-status-akun').value = u.status_akun ?? 'aktif';
    document.getElementById('modal-tempat-lahir').value = u.tempat_lahir ?? '';
    document.getElementById('modal-tanggal-lahir').value = u.tanggal_lahir ?? '';
    document.getElementById('modal-jenis-kelamin').value = u.jenis_kelamin ?? '';
    document.getElementById('modal-agama').value = u.agama ?? '';
    document.getElementById('modal-kewarganegaraan').value = u.kewarganegaraan ?? '';
    document.getElementById('modal-status-pernikahan').value = u.status_pernikahan ?? '';

    // Hitung umur otomatis dari tanggal lahir
    hitungUmurEdit(u.tanggal_lahir ?? '');

    const preview = document.getElementById('modal-foto-preview');
    const initial = document.getElementById('modal-foto-initial');
    if (u.foto_url) {
        preview.src = u.foto_url;
        preview.style.display = 'block';
        initial.style.display = 'none';
    } else {
        preview.style.display = 'none';
        initial.style.display = 'flex';
        initial.textContent = u.initial;
    }

    document.getElementById('modal-foto-input').value = '';
    document.getElementById('editModal').classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('editModal').classList.remove('show');
    document.body.style.overflow = '';
    document.getElementById('editForm').reset();
    document.getElementById('modal-foto-preview').style.display = 'none';
    document.getElementById('modal-foto-initial').style.display = 'flex';
    document.getElementById('modal-foto-input').value = '';
    hideModalError('edit-error-alert', 'edit-error-list');
}

function closeOnOverlay(e) {
    if (e.target === document.getElementById('editModal')) closeModal();
}

function previewModalFoto(event) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('modal-foto-preview').src = e.target.result;
        document.getElementById('modal-foto-preview').style.display = 'block';
        document.getElementById('modal-foto-initial').style.display = 'none';
    };
    reader.readAsDataURL(file);
}

// ─── Modal Add ───────────────────────────────────
function openAddModal() {
    document.getElementById('addForm').reset();
    document.getElementById('add-foto-preview').style.display = 'none';
    document.getElementById('add-foto-initial').style.display = 'flex';
    document.getElementById('add-foto-input').value = '';
    document.getElementById('add-umur').value = '';
    hideModalError('add-error-alert', 'add-error-list');
    document.getElementById('addModal').classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeAddModal() {
    document.getElementById('addModal').classList.remove('show');
    document.body.style.overflow = '';
    document.getElementById('addForm').reset();
    document.getElementById('add-foto-preview').style.display = 'none';
    document.getElementById('add-foto-initial').style.display = 'flex';
    document.getElementById('add-foto-input').value = '';
    document.getElementById('add-umur').value = '';
    hideModalError('add-error-alert', 'add-error-list');
}

function closeOnOverlayAdd(e) {
    if (e.target === document.getElementById('addModal')) closeAddModal();
}

function previewAddFoto(event) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('add-foto-preview').src = e.target.result;
        document.getElementById('add-foto-preview').style.display = 'block';
        document.getElementById('add-foto-initial').style.display = 'none';
    };
    reader.readAsDataURL(file);
}

// ─── Modal Delete ─────────────────────────────────
let deleteUserId = null;

function openDeleteModal(userId, name, email) {
    deleteUserId = userId;
    document.getElementById('delete-user-name').textContent = name;
    document.getElementById('delete-user-email').textContent = email;
    document.getElementById('deleteModal').classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('show');
    document.body.style.overflow = '';
    deleteUserId = null;
}

function closeOnOverlayDelete(e) {
    if (e.target === document.getElementById('deleteModal')) closeDeleteModal();
}

function confirmDelete() {
    if (!deleteUserId) return;
    const u = USERS.find(x => x.id === deleteUserId);
    if (!u) return;
    document.getElementById('deleteForm').action = u.delete_url;
    document.getElementById('deleteForm').submit();
}

// ─── Escape ───────────────────────────────────────
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') { closeModal(); closeAddModal(); closeDeleteModal(); }
});
