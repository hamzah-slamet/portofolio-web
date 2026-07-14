{{-- ==================== EXPERIENCE SECTION ==================== --}}
<section id="experience" class="services section light-background">

    <div class="container section-title" data-aos="fade-up">
        <h2>Pengalaman</h2>
        <p>Perjalanan karier dan pengalaman kerja saya</p>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                @forelse($experiences as $exp)
                    <div class="d-flex gap-3 mb-4 p-3 rounded-4"
                         style="background:#fff; border:1px solid rgba(0,0,0,.06);"
                         data-aos="fade-up">
                        <div class="flex-shrink-0">
                            <div class="d-flex align-items-center justify-content-center rounded-3"
                                 style="width:48px; height:48px; background:rgba(65,84,241,.1); color:#4154f1;">
                                <i class="bi bi-briefcase-fill fs-5"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between flex-wrap">
                                <h5 class="mb-1 fw-bold">{{ $exp->position }}</h5>
                                <span class="text-muted small">
                                    {{ optional($exp->start_date)->format('M Y') }}
                                    —
                                    {{ $exp->is_current ? 'Sekarang' : optional($exp->end_date)->format('M Y') }}
                                </span>
                            </div>
                            <p class="mb-2 text-primary fw-semibold">
                                {{ $exp->company }}@if($exp->location) · {{ $exp->location }}@endif
                            </p>
                            @if($exp->description)
                                <p class="mb-2 text-muted">{{ $exp->description }}</p>
                            @endif
                            @if(!empty($exp->skills) && is_array($exp->skills))
                                <div>
                                    @foreach($exp->skills as $s)
                                        <span class="badge bg-primary-subtle text-primary me-1">{{ $s }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-briefcase fs-1 text-muted"></i>
                        <p class="text-muted mt-3">Belum ada pengalaman yang ditambahkan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</section>
{{-- ==================== END EXPERIENCE SECTION ==================== --}}
