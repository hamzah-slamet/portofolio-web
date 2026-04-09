{{-- resources/views/admin/partials/sidebar.blade.php --}}

<aside class="admin-sidebar" id="adminSidebar">

    {{-- Brand --}}
    <div class="sidebar-brand">
        <div class="sidebar-brand-icon">
            <i class="bi bi-code-slash"></i>
        </div>
        <div class="sidebar-brand-text">
            Web Portofolio
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="sidebar-nav">

        {{-- Main --}}
        <div class="sidebar-section-label">Main</div>

        <a href="{{ route('dashboard') }}" class="sidebar-nav-item">
            <i class="bi bi-grid-1x2-fill"></i>
            Dashboard
        </a>

        {{-- Content (coming soon) --}}
        <div class="sidebar-section-label">Konten</div>

        <span class="sidebar-nav-item" style="cursor:pointer;"
            onclick="window.location='{{ route('projects.index') }}'">
           <i class="bi bi-folder-fill"></i>
            Projek
        </span>
        <span class="sidebar-nav-item" style="cursor:pointer;" onclick="window.location='{{ route('skills.index') }}'">
            <i class="bi bi-lightning-charge-fill"></i>
            Keahlian
        </span>

        <span class="sidebar-nav-item" style="cursor:pointer;" onclick="window.location='{{ route('educations.index') }}'">
            <i class="bi bi-mortarboard-fill"></i>
            Pendidikan
        </span>

        <span class="sidebar-nav-item" style="cursor:pointer;"
            onclick="window.location='{{ route('experiences.index') }}'">
            <i class="bi bi-briefcase-fill"></i>
            Pengalaman
        </span>



        <div class="sidebar-section-label">Dokumen</div>

        <span class="sidebar-nav-item" style="cursor:pointer;"
            onclick="window.location='{{ route('cv.index') }}'">
            <i class="bi bi-file-earmark-pdf-fill"></i>
            Daftar Riwayat Hidup
        </span>

        <div class="sidebar-section-label">Pengaturan</div>

        <span class="sidebar-nav-item" style="cursor:pointer;" onclick="window.location='{{ route('profile.show') }}'">
            <i class="bi bi-person-circle"></i>
            Profil Saya
        </span>

        @if (auth()->check() && strtolower(auth()->user()->role) === 'admin')
            <span class="sidebar-nav-item" style="cursor:pointer;" onclick="window.location='{{ route('users.index') }}'">
                <i class="bi bi-people-fill"></i>
                Manajemen User
            </span>
        @endif


    </nav>

    {{-- User card --}}
    <div class="sidebar-user">
        <div class="sidebar-user-avatar">
            @if (auth()->user()->foto_profil)
                <img src="{{ Storage::url(auth()->user()->foto_profil) }}" class="user-image rounded-circle shadow"
                    width="30">
            @else
                <div class="rounded-circle shadow d-flex align-items-center justify-content-center"
                    style="width:30px; height:30px; background:#2563eb; font-size:.72rem; font-weight:800; color:white; flex-shrink:0;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            @endif
        </div>
        <div>
            <div class="sidebar-user-name">{{ auth()->user()->name ?? 'Admin' }}</div>
            <div class="sidebar-user-role">{{ auth()->user()->role ?? 'User' }}</div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sidebar-user-logout" title="Logout">
                <i class="bi bi-box-arrow-right"></i>
            </button>
        </form>
    </div>

</aside>

{{-- Mobile overlay --}}
<div class="sidebar-overlay" id="sidebarOverlay"></div>
