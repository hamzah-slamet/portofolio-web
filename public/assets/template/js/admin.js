/* =============================================================
   ADMIN GLOBAL JS — Portfolio Admin Panel
   ============================================================= */

(function () {
    'use strict';

    /* ---- Sidebar Toggle ---- */
    const body          = document.body;
    const toggleBtns    = document.querySelectorAll('.topbar-toggle, .sidebar-toggle-mobile');
    const overlay       = document.getElementById('sidebarOverlay');

    // Desktop: collapse/expand
    function isMobile() { return window.innerWidth < 992; }

    toggleBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            if (isMobile()) {
                body.classList.toggle('sidebar-open');
            } else {
                body.classList.toggle('sidebar-collapsed');
            }
        });
    });

    if (overlay) {
        overlay.addEventListener('click', () => {
            body.classList.remove('sidebar-open');
        });
    }

    /* ---- Active nav item from URL ---- */
    const navItems = document.querySelectorAll('.sidebar-nav-item');
    const current  = window.location.pathname;

    navItems.forEach(item => {
        const href = item.getAttribute('href');
        if (href && current.startsWith(href) && href !== '/') {
            item.classList.add('active');
        }
    });

    /* ---- Auto-dismiss flash alerts after 5s ---- */
    document.querySelectorAll('.alert-flash').forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity .4s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 400);
        }, 5000);
    });

    /* ---- Confirm delete ---- */
    document.querySelectorAll('[data-confirm]').forEach(btn => {
        btn.addEventListener('click', function (e) {
            const msg = this.dataset.confirm || 'Yakin ingin menghapus data ini?';
            if (!confirm(msg)) e.preventDefault();
        });
    });

})();
