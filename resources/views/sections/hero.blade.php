{{-- ==================== HERO SECTION ==================== --}}
@php
    // Pecah judul jadi baris; baris terakhir diberi warna aksen
    $heroLines = collect(preg_split('/\r\n|\r|\n/', (string) $config->hero_title))
        ->map(fn ($l) => trim($l))->filter()->values();
@endphp
<section id="hero" class="hero section">

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row justify-content-center text-center">

            {{-- Hero Content (full, tanpa gambar ilustrasi) --}}
            <div class="col-lg-9">
                <div class="hero-content" data-aos="fade-up" data-aos-delay="200">

                    @if($config->hero_badge_text)
                    <div class="company-badge mb-4">
                        <i class="bi bi-gear-fill me-2"></i>
                        {{ $config->hero_badge_text }}
                    </div>
                    @endif

                    <h1 class="mb-4">
                        @foreach($heroLines as $i => $line)
                            @if($loop->last && $heroLines->count() > 1)
                                <span class="accent-text">{{ $line }}</span>
                            @else
                                {{ $line }} <br>
                            @endif
                        @endforeach
                    </h1>

                    <p class="mb-4 mb-md-5 mx-auto" style="max-width:640px;">
                        {{ $config->hero_subtitle }}
                    </p>

                    <div class="hero-buttons">
                        @if($config->hero_cta_primary)
                            <a href="#about" class="btn btn-primary me-0 me-sm-2 mx-1">{{ $config->hero_cta_primary }}</a>
                        @endif
                        @if($config->hero_cta_secondary)
                            <a href="#projects" class="btn btn-link mt-2 mt-sm-0">
                                <i class="bi bi-eye me-1"></i>
                                {{ $config->hero_cta_secondary }}
                            </a>
                        @endif
                    </div>

                </div>
            </div>

        </div>

        {{-- Stats Row --}}
        <div class="row stats-row gy-4 mt-5" data-aos="fade-up" data-aos-delay="500">
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-icon"><i class="bi bi-trophy"></i></div>
                    <div class="stat-content">
                        <h4>{{ $config->stat_awards ?? 0 }}x Won Awards</h4>
                        <p class="mb-0">Competition winner</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-icon"><i class="bi bi-briefcase"></i></div>
                    <div class="stat-content">
                        <h4>{{ $config->stat_projects ?? 0 }}+ Projects</h4>
                        <p class="mb-0">Successfully delivered</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-icon"><i class="bi bi-graph-up"></i></div>
                    <div class="stat-content">
                        <h4>{{ $config->stat_years ?? 0 }}+ Years</h4>
                        <p class="mb-0">Development experience</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-icon"><i class="bi bi-award"></i></div>
                    <div class="stat-content">
                        <h4>{{ $config->stat_certificates ?? 0 }}+ Certificates</h4>
                        <p class="mb-0">Professional credentials</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

</section>
