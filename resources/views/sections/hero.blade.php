{{-- ==================== HERO SECTION ==================== --}}
@php
    // Pecah judul jadi baris; baris terakhir diberi warna aksen
    $heroLines = collect(preg_split('/\r\n|\r|\n/', (string) $config->hero_title))
        ->map(fn ($l) => trim($l))->filter()->values();

    $heroImgs = $heroImages ?? collect();
    $hasHeroImgs = $heroImgs->count() > 0;
@endphp
<section id="hero" class="hero section">

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row align-items-center">

            {{-- Hero Content --}}
            <div class="{{ $hasHeroImgs ? 'col-lg-6' : 'col-lg-10' }}">
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

                    <p class="mb-4 mb-md-5" style="max-width:640px;">
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

            @if($hasHeroImgs)
            {{-- Ilustrasi Hero (carousel) --}}
            <div class="col-lg-6" data-aos="zoom-out" data-aos-delay="300">
                <div class="swiper hero-slider" id="heroSlider">
                    <div class="swiper-wrapper">
                        @foreach($heroImgs as $img)
                        <div class="swiper-slide">
                            <div class="hero-frame">
                                <div class="hero-frame-inner">
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($img->image) }}"
                                         alt="Ilustrasi" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @if($heroImgs->count() > 1)
                        <div class="swiper-pagination"></div>
                    @endif
                </div>
            </div>
            @endif

        </div>

        {{-- Stats Row (angka diambil dari data yang ada) --}}
        <div class="row stats-row gy-4 mt-5" data-aos="fade-up" data-aos-delay="500">
            <div class="col-lg-4 col-md-6">
                <div class="stat-item">
                    <div class="stat-icon"><i class="bi bi-briefcase"></i></div>
                    <div class="stat-content">
                        <h4>{{ $statProjects ?? 0 }}+ Proyek</h4>
                        <p class="mb-0">Berhasil diselesaikan</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="stat-item">
                    <div class="stat-icon"><i class="bi bi-graph-up"></i></div>
                    <div class="stat-content">
                        <h4>{{ $statYears ?? 0 }}+ Tahun</h4>
                        <p class="mb-0">Pengalaman pengembangan</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="stat-item">
                    <div class="stat-icon"><i class="bi bi-award"></i></div>
                    <div class="stat-content">
                        <h4>{{ $statCertificates ?? 0 }}+ Sertifikat</h4>
                        <p class="mb-0">Kredensial profesional</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

</section>

@if($hasHeroImgs)
@push('styles')
<style>
    .hero-slider { width: 100%; padding-bottom: 30px; }
    .hero-slider .swiper-slide {
        display: flex; align-items: center; justify-content: center;
    }
    .hero-slider .swiper-slide img {
        max-width: 100%; max-height: 420px; object-fit: contain;
        border-radius: 16px;
    }
    .hero-slider .swiper-pagination { bottom: 0; }
    .hero-slider .swiper-pagination-bullet {
        background: var(--accent-color, #2563eb); opacity: .3;
        width: 9px; height: 9px;
    }
    .hero-slider .swiper-pagination-bullet-active { opacity: 1; width: 24px; border-radius: 6px; }
</style>
@endpush
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (document.getElementById('heroSlider')) {
        new Swiper('#heroSlider', {
            loop: {{ $heroImgs->count() > 1 ? 'true' : 'false' }},
            effect: 'fade',
            fadeEffect: { crossFade: true },
            speed: 800,
            autoplay: { delay: 3500, disableOnInteraction: false },
            pagination: { el: '#heroSlider .swiper-pagination', clickable: true },
        });
    }

    // Efek 3D: bingkai memiringkan mengikuti kursor
    var MAX_TILT = 10; // derajat
    document.querySelectorAll('#heroSlider .hero-frame').forEach(function (frame) {
        var parent = frame.closest('.swiper-slide') || frame;

        parent.addEventListener('mousemove', function (e) {
            var r = frame.getBoundingClientRect();
            var px = (e.clientX - r.left) / r.width;   // 0..1
            var py = (e.clientY - r.top) / r.height;   // 0..1
            var rotY = (px - 0.5) * (MAX_TILT * 2);
            var rotX = (0.5 - py) * (MAX_TILT * 2);
            frame.style.transform =
                'rotateX(' + rotX.toFixed(2) + 'deg) rotateY(' + rotY.toFixed(2) + 'deg)';
        });

        parent.addEventListener('mouseleave', function () {
            frame.style.transform = 'rotateX(0deg) rotateY(0deg)';
        });
    });
});
</script>
@endpush
@endif
