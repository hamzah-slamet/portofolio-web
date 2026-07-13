{{-- ==================== ABOUT SECTION ==================== --}}
@php
    $features = is_array($config->about_features) ? $config->about_features : [];
    $half = (int) ceil(count($features) / 2);
    $featLeft  = array_slice($features, 0, $half);
    $featRight = array_slice($features, $half);
    $hasPhoto  = (bool) $user->foto_profil;
    $photoUrl  = $hasPhoto ? \Illuminate\Support\Facades\Storage::url($user->foto_profil) : null;
    $initial   = strtoupper(mb_substr($user->name, 0, 1));
@endphp
<section id="about" class="about section">

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4 align-items-center justify-content-between">

            {{-- Left: About Content --}}
            <div class="col-xl-7" data-aos="fade-up" data-aos-delay="200">
                <span class="about-meta">{{ $config->about_meta ?? 'MORE ABOUT ME' }}</span>
                <h2 class="about-title">{{ $config->about_title ?? 'About Me' }}</h2>
                <p class="about-description">
                    {{ $user->tentang ?: 'Belum ada deskripsi. Isi di menu Profil → Tentang Saya.' }}
                </p>

                @if(count($features))
                <div class="row feature-list-wrapper">
                    <div class="col-md-6">
                        <ul class="feature-list">
                            @foreach($featLeft as $f)
                                <li><i class="bi bi-check-circle-fill"></i> {{ $f }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="feature-list">
                            @foreach($featRight as $f)
                                <li><i class="bi bi-check-circle-fill"></i> {{ $f }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <div class="info-wrapper">
                    <div class="row gy-4">
                        <div class="col-lg-6">
                            <div class="profile d-flex align-items-center gap-3">
                                @if($hasPhoto)
                                    <img src="{{ $photoUrl }}" alt="{{ $user->name }}" class="profile-image">
                                @else
                                    <div class="profile-image d-flex align-items-center justify-content-center"
                                         style="background:#2563eb; color:#fff; font-weight:800; font-size:1.4rem;">{{ $initial }}</div>
                                @endif
                                <div>
                                    <h4 class="profile-name">{{ $user->name }}</h4>
                                    <p class="profile-position">{{ $config->profile_position ?? 'Web Developer' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="contact-info d-flex align-items-center gap-2">
                                <i class="bi bi-envelope-fill"></i>
                                <div>
                                    <p class="contact-label">Send me an email</p>
                                    <p class="contact-number">{{ $config->contact_email ?? $user->email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right: Foto profil dinamis + badge pengalaman (tanpa ilustrasi statis) --}}
            <div class="col-xl-4" data-aos="fade-up" data-aos-delay="300">
                <div class="image-wrapper">
                    <div class="images position-relative" data-aos="zoom-out" data-aos-delay="400">
                        @if($hasPhoto)
                            <img src="{{ $photoUrl }}" alt="{{ $user->name }}" class="img-fluid main-image rounded-4">
                        @else
                            <div class="main-image rounded-4 d-flex align-items-center justify-content-center"
                                 style="aspect-ratio:1/1; background:linear-gradient(135deg,#2563eb,#1d4ed8); color:#fff; font-size:4rem; font-weight:800;">
                                {{ $initial }}
                            </div>
                        @endif
                    </div>
                    <div class="experience-badge floating">
                        <h3>{{ $config->stat_years ?? 0 }}+ <span>Years</span></h3>
                        <p>Of experience in web development</p>
                    </div>
                </div>
            </div>

        </div>

    </div>

</section>
{{-- ==================== END ABOUT SECTION ==================== --}}
