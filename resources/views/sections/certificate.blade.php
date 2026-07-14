{{-- ==================== CERTIFICATE SECTION ==================== --}}
<section id="certificate" class="features section">

    <div class="container section-title" data-aos="fade-up">
        <h2>Sertifikat</h2>
        <p>Sertifikasi dan pencapaian profesional yang memvalidasi keahlian saya</p>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        @if($certificates->count())
        <div class="swiper portfolio-slider" id="certificatesSlider">
            <div class="swiper-wrapper">
                @foreach($certificates as $cert)
                <div class="swiper-slide">
                    <div class="h-100 p-4 rounded-4" style="background:#fff; border:1px solid rgba(0,0,0,.08); box-shadow:0 4px 20px rgba(0,0,0,.04);">
                        @php $isPdf = $cert->image && \Illuminate\Support\Str::endsWith(strtolower($cert->image), '.pdf'); @endphp
                        @if($cert->image && $isPdf)
                            <a href="{{ \Illuminate\Support\Facades\Storage::url($cert->image) }}" target="_blank" rel="noopener"
                               class="d-flex flex-column align-items-center justify-content-center rounded-3 mb-3 text-decoration-none"
                               style="width:100%; height:160px; background:#fef2f2; color:#dc2626;">
                                <i class="bi bi-file-earmark-pdf" style="font-size:2.4rem;"></i>
                                <span class="mt-2" style="font-size:.85rem; font-weight:600;">Lihat PDF</span>
                            </a>
                        @elseif($cert->image)
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($cert->image) }}"
                                 alt="{{ $cert->title }}" class="img-fluid rounded-3 mb-3" style="width:100%; height:160px; object-fit:cover;">
                        @else
                            <div class="d-flex align-items-center justify-content-center rounded-3 mb-3"
                                 style="width:100%; height:120px; background:#eff6ff; color:#2563eb;">
                                <i class="bi bi-patch-check-fill" style="font-size:2.4rem;"></i>
                            </div>
                        @endif
                        <h5 class="mb-1" style="font-weight:700;">{{ $cert->title }}</h5>
                        <p class="mb-2 text-muted" style="font-size:.9rem;">
                            {{ $cert->issuer }} @if($cert->year) · {{ $cert->year }} @endif
                        </p>
                        @if($cert->url)
                            <a href="{{ $cert->url }}" target="_blank" rel="noopener" class="read-more">
                                Lihat kredensial <i class="bi bi-arrow-right"></i>
                            </a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
        @else
            <div class="row">
                <div class="col-12 text-center py-5">
                    <i class="bi bi-patch-check fs-1 text-muted"></i>
                    <p class="text-muted mt-3">Belum ada sertifikat.</p>
                </div>
            </div>
        @endif

    </div>

</section>
{{-- ==================== END CERTIFICATE SECTION ==================== --}}

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (document.getElementById('certificatesSlider')) {
        new Swiper('#certificatesSlider', {
            loop: false,
            spaceBetween: 24,
            grabCursor: true,
            autoplay: { delay: 4000, disableOnInteraction: false },
            pagination: { el: '#certificatesSlider .swiper-pagination', clickable: true },
            navigation: {
                nextEl: '#certificatesSlider .swiper-button-next',
                prevEl: '#certificatesSlider .swiper-button-prev',
            },
            breakpoints: {
                0:    { slidesPerView: 1 },
                768:  { slidesPerView: 2 },
                992:  { slidesPerView: 3 },
            },
        });
    }
});
</script>
@endpush
