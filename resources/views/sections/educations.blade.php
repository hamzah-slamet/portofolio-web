{{-- ==================== EDUCATION SECTION ==================== --}}
<section id="education" class="services section">

    <div class="container section-title" data-aos="fade-up">
        <h2>Education</h2>
        <p>My academic background and qualifications</p>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                @forelse($educations as $edu)
                    <div class="d-flex gap-3 mb-4 p-3 rounded-4"
                         style="background: var(--surface-color, #f6f7f9); border:1px solid rgba(0,0,0,.06);"
                         data-aos="fade-up">
                        <div class="flex-shrink-0">
                            <div class="d-flex align-items-center justify-content-center rounded-3"
                                 style="width:48px; height:48px; background:rgba(65,84,241,.1); color:#4154f1;">
                                <i class="bi bi-mortarboard-fill fs-5"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between flex-wrap">
                                <h5 class="mb-1 fw-bold">
                                    {{ $edu->degree }}@if($edu->major) — {{ $edu->major }}@endif
                                </h5>
                                <span class="text-muted small">
                                    {{ optional($edu->start_date)->format('Y') }}
                                    —
                                    {{ $edu->is_current ? 'Sekarang' : optional($edu->end_date)->format('Y') }}
                                </span>
                            </div>
                            <p class="mb-2 text-primary fw-semibold">
                                {{ $edu->institution }}@if($edu->location) · {{ $edu->location }}@endif
                            </p>
                            @if($edu->gpa)
                                <p class="mb-1 small"><b>GPA/IPK:</b> {{ $edu->gpa }}</p>
                            @endif
                            @if($edu->description)
                                <p class="mb-0 text-muted">{{ $edu->description }}</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-mortarboard fs-1 text-muted"></i>
                        <p class="text-muted mt-3">Belum ada pendidikan yang ditambahkan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</section>
{{-- ==================== END EDUCATION SECTION ==================== --}}
