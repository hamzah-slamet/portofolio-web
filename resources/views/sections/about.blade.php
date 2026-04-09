{{-- ==================== ABOUT SECTION ==================== --}}
<section id="about" class="about section">

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4 align-items-center justify-content-between">

            {{-- Left: About Content --}}
            <div class="col-xl-5" data-aos="fade-up" data-aos-delay="200">
                <span class="about-meta">MORE ABOUT ME</span>
                <h2 class="about-title">Passionate Developer & Problem Solver</h2>
                <p class="about-description">
                    I'm a full-stack web developer with a strong focus on building clean, scalable, and user-friendly
                    web applications. I specialize in Laravel, Vue.js, and modern frontend technologies.
                </p>

                <div class="row feature-list-wrapper">
                    <div class="col-md-6">
                        <ul class="feature-list">
                            <li><i class="bi bi-check-circle-fill"></i> Laravel & PHP Expert</li>
                            <li><i class="bi bi-check-circle-fill"></i> Vue.js & React</li>
                            <li><i class="bi bi-check-circle-fill"></i> RESTful API Design</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="feature-list">
                            <li><i class="bi bi-check-circle-fill"></i> MySQL & PostgreSQL</li>
                            <li><i class="bi bi-check-circle-fill"></i> UI/UX Principles</li>
                            <li><i class="bi bi-check-circle-fill"></i> Agile & Git Workflow</li>
                        </ul>
                    </div>
                </div>

                <div class="info-wrapper">
                    <div class="row gy-4">
                        <div class="col-lg-5">
                            <div class="profile d-flex align-items-center gap-3">
                                <img src="{{ asset('assets/Home/img/avatar-1.webp') }}" alt="Profile Photo" class="profile-image">
                                <div>
                                    <h4 class="profile-name">Hamzah</h4>
                                    <p class="profile-position">Web Developer</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="contact-info d-flex align-items-center gap-2">
                                <i class="bi bi-envelope-fill"></i>
                                <div>
                                    <p class="contact-label">Send me an email</p>
                                    <p class="contact-number">hamzah@example.com</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right: About Image --}}
            <div class="col-xl-6" data-aos="fade-up" data-aos-delay="300">
                <div class="image-wrapper">
                    <div class="images position-relative" data-aos="zoom-out" data-aos-delay="400">
                        <img src="{{ asset('assets/Home/img/about-2.webp') }}" alt="Working" class="img-fluid main-image rounded-4">
                        <img src="{{ asset('assets/Home/img/about-5.webp') }}" alt="Collaboration" class="img-fluid small-image rounded-4">
                    </div>
                    <div class="experience-badge floating">
                        <h3>2+ <span>Years</span></h3>
                        <p>Of experience in web development</p>
                    </div>
                </div>
            </div>

        </div>

    </div>

</section>
{{-- ==================== END ABOUT SECTION ==================== --}}
