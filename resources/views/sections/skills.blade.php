{{-- ==================== SKILLS SECTION ==================== --}}
<section id="skills" class="services section">

    <div class="container section-title" data-aos="fade-up">
        <h2>Keahlian</h2>
        <p>Teknologi dan alat yang saya kuasai</p>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row g-4">
            @forelse($skills as $skill)
                <div class="col-md-6 col-lg-4">
                    <div class="p-3 rounded-4 h-100" style="background: var(--surface-color, #f6f7f9); border:1px solid rgba(0,0,0,.05);">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi {{ $skill->icon ?? 'bi-stars' }} fs-5" style="color: {{ $skill->color ?? '#4154f1' }};"></i>
                            <span class="fw-bold">{{ $skill->name }}</span>
                            @if($skill->category)
                                <span class="badge bg-secondary-subtle text-secondary ms-auto">{{ $skill->category }}</span>
                            @endif
                        </div>
                        @if(!is_null($skill->level))
                        <div class="progress" style="height:8px;">
                            <div class="progress-bar" role="progressbar"
                                 style="width: {{ min(100, (int) $skill->level) }}%; background: {{ $skill->color_fill ?? $skill->color ?? '#4154f1' }};"
                                 aria-valuenow="{{ $skill->level }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-lightning-charge fs-1 text-muted"></i>
                    <p class="text-muted mt-3">Belum ada skill yang ditambahkan.</p>
                </div>
            @endforelse
        </div>
    </div>

</section>
{{-- ==================== END SKILLS SECTION ==================== --}}
