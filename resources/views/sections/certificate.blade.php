{{-- ==================== CERTIFICATE SECTION ==================== --}}
<section id="certificate" class="features section">

    <div class="container section-title" data-aos="fade-up">
        <h2>Certificates</h2>
        <p>Professional certifications and achievements that validate my skills and expertise</p>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row g-4">
            @forelse($certificates as $cert)
                <div class="col-md-6 col-lg-4" data-aos="fade-up">
                    <div class="h-100 p-4 rounded-4" style="background:#fff; border:1px solid rgba(0,0,0,.08); box-shadow:0 4px 20px rgba(0,0,0,.04);">
                        @if($cert->image)
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
            @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-patch-check fs-1 text-muted"></i>
                    <p class="text-muted mt-3">Belum ada sertifikat.</p>
                </div>
            @endforelse
        </div>
    </div>

</section>
{{-- ==================== END CERTIFICATE SECTION ==================== --}}
