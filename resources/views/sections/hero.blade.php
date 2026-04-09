{{-- ==================== HERO SECTION ==================== --}}
<section id="hero" class="hero section">

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row align-items-center">

            {{-- Left: Hero Content --}}
            <div class="col-lg-6">
                <div class="hero-content" data-aos="fade-up" data-aos-delay="200">

                    <div class="company-badge mb-4">
                        <i class="bi bi-gear-fill me-2"></i>
                        Working for your success
                    </div>

                    <h1 class="mb-4">
                        Building Modern <br>
                        Web Applications <br>
                        <span class="accent-text">With Laravel</span>
                    </h1>

                    <p class="mb-4 mb-md-5">
                        Hi, I'm Hamzah — a passionate web developer crafting elegant,
                        high-performance web solutions using Laravel, Vue.js, and modern technologies.
                    </p>

                    <div class="hero-buttons">
                        <a href="#about" class="btn btn-primary me-0 me-sm-2 mx-1">Get Started</a>
                        <a href="#projects" class="btn btn-link mt-2 mt-sm-0">
                            <i class="bi bi-eye me-1"></i>
                            View Projects
                        </a>
                    </div>

                </div>
            </div>

            <div class="col-lg-6">
                <div class="hero-image" data-aos="zoom-out" data-aos-delay="300">
                    <img src="{{ asset('assets/Home/img/illustration-1.webp') }}" alt="Hero Illustration"
                        class="img-fluid">

                    <div class="customers-badge">
                        <div class="customer-avatars">
                            <img src="{{ asset('assets/Home/img/avatar-1.webp') }}" alt="User 1" class="avatar">
                            <img src="{{ asset('assets/Home/img/avatar-2.webp') }}" alt="User 2" class="avatar">
                            <img src="{{ asset('assets/Home/img/avatar-3.webp') }}" alt="User 3" class="avatar">
                            <img src="{{ asset('assets/Home/img/avatar-4.webp') }}" alt="User 4" class="avatar">
                            <span class="avatar more">5+</span>
                        </div>
                        <p class="mb-0 mt-2">Trusted by clients and collaborators worldwide</p>
                    </div>
                </div>
            </div>

        </div>

        {{-- Stats Row --}}
        <div class="row stats-row gy-4 mt-5" data-aos="fade-up" data-aos-delay="500">
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-icon"><i class="bi bi-trophy"></i></div>
                    <div class="stat-content">
                        <h4>3x Won Awards</h4>
                        <p class="mb-0">Competition winner</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-icon"><i class="bi bi-briefcase"></i></div>
                    <div class="stat-content">
                        <h4>20+ Projects</h4>
                        <p class="mb-0">Successfully delivered</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-icon"><i class="bi bi-graph-up"></i></div>
                    <div class="stat-content">
                        <h4>2+ Years</h4>
                        <p class="mb-0">Development experience</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-icon"><i class="bi bi-award"></i></div>
                    <div class="stat-content">
                        <h4>10+ Certificates</h4>
                        <p class="mb-0">Professional credentials</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

</section>
