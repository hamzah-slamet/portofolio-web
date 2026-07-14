{{-- ==================== PROJECTS SECTION ==================== --}}
<section id="projects" class="services section light-background">

    <div class="container section-title" data-aos="fade-up">
        <h2>Proyek</h2>
        <p>Kumpulan karya terbaru saya — dari aplikasi web, sistem API, hingga desain UI</p>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        @if($projects->count())
        <div class="swiper portfolio-slider" id="projectsSlider">
            <div class="swiper-wrapper">
                @foreach($projects as $index => $project)
                <div class="swiper-slide">
                    <div class="service-card d-flex">
                        <div class="icon flex-shrink-0">
                            <i class="bi bi-code-slash"></i>
                        </div>
                        <div>
                            <h3>{{ $project->title }}</h3>
                            <p>{{ $project->description }}</p>

                            @if(!empty($project->tech_stack) && is_array($project->tech_stack))
                                <div class="mb-2">
                                    @foreach($project->tech_stack as $tech)
                                        <span class="badge bg-secondary-subtle text-secondary me-1">{{ $tech }}</span>
                                    @endforeach
                                </div>
                            @endif

                            @if($project->live_url)
                                <a href="{{ $project->live_url }}" class="read-more" target="_blank" rel="noopener noreferrer">
                                    Lihat Proyek <i class="bi bi-arrow-right"></i>
                                </a>
                            @endif
                            @if($project->github_url)
                                <a href="{{ $project->github_url }}" class="read-more ms-3" target="_blank" rel="noopener noreferrer">
                                    <i class="bi bi-github"></i> Kode
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
        @else
            {{-- Fallback jika belum ada project --}}
            <div class="row">
                <div class="col-12 text-center py-5">
                    <i class="bi bi-folder2-open fs-1 text-muted"></i>
                    <p class="text-muted mt-3">Belum ada proyek untuk ditampilkan.</p>
                </div>
            </div>
        @endif

    </div>

</section>
{{-- ==================== END PROJECTS SECTION ==================== --}}

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (document.getElementById('projectsSlider')) {
        new Swiper('#projectsSlider', {
            loop: false,
            spaceBetween: 24,
            grabCursor: true,
            autoplay: { delay: 4500, disableOnInteraction: false },
            pagination: { el: '#projectsSlider .swiper-pagination', clickable: true },
            navigation: {
                nextEl: '#projectsSlider .swiper-button-next',
                prevEl: '#projectsSlider .swiper-button-prev',
            },
            breakpoints: {
                0:    { slidesPerView: 1 },
                768:  { slidesPerView: 2 },
            },
        });
    }
});
</script>
@endpush
