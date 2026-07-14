<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

        <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto me-xl-0">
            <h1 class="sitename">Hamzah</h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                @php $items = $menuItems ?? collect(); @endphp
                @forelse($items as $i => $item)
                    <li>
                        <a href="{{ $item->url }}"
                           @if(\Illuminate\Support\Str::startsWith($item->url, 'http')) target="_blank" rel="noopener" @endif
                           >{{ $item->label }}</a>
                    </li>
                @empty
                    {{-- Fallback jika belum ada menu di database --}}
                    <li><a href="#hero" class="active">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#projects">Project</a></li>
                    <li><a href="#contact">Contact</a></li>
                @endforelse
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <div class="d-flex align-items-center gap-2">
            {{-- Toggle bahasa ID / EN --}}
            <button type="button" id="langToggle" class="lang-toggle notranslate" translate="no"
                    title="Ganti bahasa / Change language">
                <i class="bi bi-translate"></i>
                <span id="langToggleLabel">EN</span>
            </button>
            @guest
                <a class="btn-getstarted" href="{{ route('login') }}">Masuk</a>
            @endguest
        </div>

    </div>
</header>
