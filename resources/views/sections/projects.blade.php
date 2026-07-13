{{-- ==================== PROJECTS SECTION ==================== --}}
<section id="projects" class="services section light-background">

    <div class="container section-title" data-aos="fade-up">
        <h2>Projects</h2>
        <p>A selection of my recent work — from web apps to API systems and UI designs</p>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row g-4">

            @forelse($projects as $index => $project)

            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="{{ ($index % 4 + 1) * 100 }}">
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
                                View Project <i class="bi bi-arrow-right"></i>
                            </a>
                        @endif
                        @if($project->github_url)
                            <a href="{{ $project->github_url }}" class="read-more ms-3" target="_blank" rel="noopener noreferrer">
                                <i class="bi bi-github"></i> Code
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            @empty

            {{-- Fallback jika belum ada project --}}
            <div class="col-12 text-center py-5">
                <i class="bi bi-folder2-open fs-1 text-muted"></i>
                <p class="text-muted mt-3">No projects to display yet.</p>
            </div>

            @endforelse

        </div>

    </div>

</section>
{{-- ==================== END PROJECTS SECTION ==================== --}}
