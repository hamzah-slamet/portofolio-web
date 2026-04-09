{{-- resources/views/admin/partials/topbar.blade.php --}}
@use('Illuminate\Support\Facades\Storage')

<header class="admin-topbar" id="adminTopbar">
    <button class="topbar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
        <i class="bi bi-list"></i>
    </button>
    <div class="topbar-page-title">
        @yield('topbar-title', 'Dashboard')
    </div>

    <div class="topbar-right">
        <a onclick="openPortfolio()" class="topbar-view-btn" style="cursor:pointer;">
            <i class="bi bi-eye"></i>
            <span>Lihat Portfolio</span>
        </a>
        {{-- Notification --}}
        <button class="topbar-icon-btn" title="Notifikasi">
            <i class="bi bi-bell-fill"></i>
            <span class="topbar-notif-dot"></span>
        </button>

        {{-- Avatar Dropdown --}}
        <div class="dropdown">
           <div class="topbar-avatar" data-bs-toggle="dropdown" aria-expanded="false">
                @if(auth()->user()->foto_profil)
                    <img src="{{ Storage::url(auth()->user()->foto_profil) }}" class="user-image rounded-circle shadow" width="30">
                @else
                    <div class="user-image rounded-circle shadow"
                        style="width:30px; height:30px; background:#2563eb;
                                display:flex; align-items:center; justify-content:center;
                                font-size:.75rem; font-weight:800; color:white;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif
            </div>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2"
                style="border-radius:12px; min-width:200px; padding:8px; font-size:.875rem; border: 1px solid #e9eef8 !important;">
                <li>
                    <div class="px-3 py-2 border-bottom mb-1">
                        <div class="fw-700 text-dark" style="font-weight:700;">{{ auth()->user()->name }}</div>
                        <div class="text-muted" style="font-size:.75rem;">{{ auth()->user()->email }}</div>
                    </div>
                </li>
                <li>
                    <div class="px-3 py-2 border-bottom mb-1">
                        <div class="fw-700 text-dark">{{ auth()->user()->role ?? 'User' }}</div>
                    </div>
                </li>
                {{-- <li>
                    <hr class="dropdown-divider my-1">
                </li> --}}
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="dropdown-item rounded-2 d-flex align-items-center gap-2 py-2 text-danger">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>
