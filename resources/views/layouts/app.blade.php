<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Admin Portfolio</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('assets/template/css/admin.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body>

    {{-- Sidebar --}}
    @include('partials.sidebar')

    {{-- Main Wrapper --}}
    <div class="admin-main" id="adminMain">

        {{-- Topbar --}}
        @include('partials.topbar')

        {{-- Page Content --}}
        <main class="admin-content">

            {{-- Breadcrumb & Page Header --}}
            @hasSection('page-header')
                <div class="page-header-bar">
                    @yield('page-header')
                </div>
            @endif

            {{-- Flash Messages (Toast global) --}}
            <div class="app-toast-container">
                @if(session('success'))
                    <x-toast type="success" :message="session('success')" />
                @endif
                @if(session('error'))
                    <x-toast type="error" :message="session('error')" />
                @endif
            </div>

            @yield('content')
        </main>

        {{-- Footer --}}
        @include('partials.footer')

    </div>

    {{-- ── Portfolio Preview Drawer ─────────────────────────────── --}}
    <div id="portfolio-overlay"
         onclick="closePortfolio()"
         style="position:fixed; inset:0; background:rgba(0,0,0,.45);
                opacity:0; pointer-events:none;
                transition:opacity .35s ease; z-index:1099;">
    </div>

    <div id="portfolio-drawer"
         style="position:fixed; top:0; right:0; bottom:0;
                width:0; z-index:1100; overflow:hidden;
                transition:width .35s cubic-bezier(.4,0,.2,1);
                display:flex; flex-direction:column;
                background:var(--card-bg);
                box-shadow:-8px 0 40px rgba(0,0,0,.15);">

        {{-- Header drawer --}}
        <div style="padding:14px 20px; border-bottom:1px solid var(--card-border);
                    display:flex; align-items:center; justify-content:space-between;
                    flex-shrink:0; background:var(--card-bg); min-width:600px;">
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:10px; height:10px; border-radius:50%; background:#22c55e;
                            box-shadow:0 0 0 3px rgba(34,197,94,.2);"></div>
                <span style="font-size:.87rem; font-weight:700; color:var(--text-primary);">
                    Preview Portfolio
                </span>
            </div>
            <div style="display:flex; align-items:center; gap:8px;">
                {{-- Tombol reload --}}
                <button onclick="reloadPortfolio()"
                        title="Reload"
                        style="width:32px; height:32px; border-radius:8px;
                               border:1px solid var(--card-border); background:none;
                               display:flex; align-items:center; justify-content:center;
                               cursor:pointer; color:var(--text-muted); transition:background .15s;"
                        onmouseover="this.style.background='var(--body-bg)'"
                        onmouseout="this.style.background='none'">
                    <i class="bi bi-arrow-clockwise" style="font-size:.85rem;"></i>
                </button>
                {{-- Buka tab baru --}}
                <a href="{{ url('/') }}" target="_blank"
                   style="display:inline-flex; align-items:center; gap:5px;
                          padding:6px 12px; border-radius:8px;
                          border:1px solid var(--card-border); background:none;
                          color:var(--text-secondary); font-size:.78rem; font-weight:600;
                          text-decoration:none; transition:background .15s;"
                   onmouseover="this.style.background='var(--body-bg)'"
                   onmouseout="this.style.background='none'">
                    <i class="bi bi-box-arrow-up-right"></i> Buka Tab Baru
                </a>
                {{-- Tutup --}}
                <button onclick="closePortfolio()"
                        style="width:32px; height:32px; border-radius:8px;
                               border:1px solid var(--card-border); background:none;
                               display:flex; align-items:center; justify-content:center;
                               cursor:pointer; color:var(--text-muted); transition:background .15s;"
                        onmouseover="this.style.background='var(--body-bg)'"
                        onmouseout="this.style.background='none'">
                    <i class="bi bi-x-lg" style="font-size:.8rem;"></i>
                </button>
            </div>
        </div>

        {{-- Loading indicator --}}
        <div id="portfolio-loading"
             style="position:absolute; top:57px; left:0; right:0; bottom:0;
                    display:flex; flex-direction:column; align-items:center; justify-content:center;
                    gap:12px; background:var(--body-bg); z-index:1;">
            <div style="width:36px; height:36px; border:3px solid var(--card-border);
                        border-top-color:#2563eb; border-radius:50%;
                        animation:spin .7s linear infinite;"></div>
            <span style="font-size:.82rem; color:var(--text-muted);">Memuat portfolio...</span>
        </div>

        {{-- iframe --}}
        <iframe id="portfolio-iframe"
                src=""
                style="flex:1; border:none; width:100%; min-width:600px;"
                onload="document.getElementById('portfolio-loading').style.display='none'">
        </iframe>
    </div>
    {{-- ── End Portfolio Drawer ──────────────────────────────────── --}}

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Admin Global Script --}}
    <script src="{{ asset('assets/template/js/admin.js') }}"></script>

    @stack('scripts')

    <script>
        // ── Toast: lihat komponen resources/views/components/toast.blade.php ──

        // ── Portfolio Drawer ──────────────────────────────────────
        const PORTFOLIO_URL = '{{ url('/') }}';
        let portfolioLoaded = false;

        function openPortfolio() {
            const drawer  = document.getElementById('portfolio-drawer');
            const overlay = document.getElementById('portfolio-overlay');
            const iframe  = document.getElementById('portfolio-iframe');
            const loading = document.getElementById('portfolio-loading');

            // Load iframe hanya pertama kali
            if (!portfolioLoaded) {
                loading.style.display = 'flex';
                iframe.src = PORTFOLIO_URL;
                portfolioLoaded = true;
            }

            drawer.style.width           = '82vw';
            overlay.style.opacity        = '1';
            overlay.style.pointerEvents  = 'auto';
            document.body.style.overflow = 'hidden';
        }

        function closePortfolio() {
            const drawer  = document.getElementById('portfolio-drawer');
            const overlay = document.getElementById('portfolio-overlay');

            drawer.style.width           = '0';
            overlay.style.opacity        = '0';
            overlay.style.pointerEvents  = 'none';
            document.body.style.overflow = '';
        }

        function reloadPortfolio() {
            const iframe  = document.getElementById('portfolio-iframe');
            const loading = document.getElementById('portfolio-loading');
            loading.style.display = 'flex';
            iframe.src = PORTFOLIO_URL;
        }

        // Tutup dengan Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closePortfolio();
        });
    </script>

    <style>
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>

</body>
</html>
