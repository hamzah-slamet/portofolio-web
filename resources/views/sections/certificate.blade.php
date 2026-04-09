{{-- ==================== CERTIFICATE SECTION ==================== --}}
<section id="certificate" class="features section">

    <div class="container section-title" data-aos="fade-up">
        <h2>Certificates</h2>
        <p>Professional certifications and achievements that validate my skills and expertise</p>
    </div>

    <div class="container">

        <div class="d-flex justify-content-center">
            <ul class="nav nav-tabs" data-aos="fade-up" data-aos-delay="100">
                <li class="nav-item">
                    <a class="nav-link active show" data-bs-toggle="tab" data-bs-target="#cert-tab-1">
                        <h4>Web Dev</h4>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#cert-tab-2">
                        <h4>Design</h4>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#cert-tab-3">
                        <h4>Cloud</h4>
                    </a>
                </li>
            </ul>
        </div>

        <div class="tab-content" data-aos="fade-up" data-aos-delay="200">

            {{-- Tab 1: Web Development --}}
            <div class="tab-pane fade active show" id="cert-tab-1">
                <div class="row">
                    <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0 d-flex flex-column justify-content-center">
                        <h3>Web Development Certifications</h3>
                        <p class="fst-italic">
                            Certified in modern web development technologies and frameworks,
                            demonstrating expertise in building production-ready applications.
                        </p>
                        <ul>
                            <li><i class="bi bi-check2-all"></i> <span>Laravel Certified Developer — Passed with distinction</span></li>
                            <li><i class="bi bi-check2-all"></i> <span>PHP 8.x Professional — Zend Certified Engineer</span></li>
                            <li><i class="bi bi-check2-all"></i> <span>JavaScript ES6+ Certification — Full-Stack JavaScript Mastery</span></li>
                        </ul>
                    </div>
                    <div class="col-lg-6 order-1 order-lg-2 text-center">
                        <img src="{{ asset('assets/Home/img/features-illustration-1.webp') }}" alt="Web Dev Certificate" class="img-fluid">
                    </div>
                </div>
            </div>

            {{-- Tab 2: Design --}}
            <div class="tab-pane fade" id="cert-tab-2">
                <div class="row">
                    <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0 d-flex flex-column justify-content-center">
                        <h3>UI/UX Design Certifications</h3>
                        <p class="fst-italic">
                            Trained in user-centered design principles and modern design tools
                            to create intuitive and visually compelling interfaces.
                        </p>
                        <ul>
                            <li><i class="bi bi-check2-all"></i> <span>Google UX Design Certificate — Coursera</span></li>
                            <li><i class="bi bi-check2-all"></i> <span>Figma Advanced Design — UI/UX Specialization</span></li>
                            <li><i class="bi bi-check2-all"></i> <span>Responsive Web Design — freeCodeCamp</span></li>
                        </ul>
                    </div>
                    <div class="col-lg-6 order-1 order-lg-2 text-center">
                        <img src="{{ asset('assets/Home/img/features-illustration-2.webp') }}" alt="Design Certificate" class="img-fluid">
                    </div>
                </div>
            </div>

            {{-- Tab 3: Cloud --}}
            <div class="tab-pane fade" id="cert-tab-3">
                <div class="row">
                    <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0 d-flex flex-column justify-content-center">
                        <h3>Cloud & DevOps Certifications</h3>
                        <ul>
                            <li><i class="bi bi-check2-all"></i> <span>AWS Cloud Practitioner — Amazon Web Services</span></li>
                            <li><i class="bi bi-check2-all"></i> <span>Docker & Kubernetes — Container Orchestration</span></li>
                            <li><i class="bi bi-check2-all"></i> <span>Linux Administration — Red Hat Certified</span></li>
                        </ul>
                        <p class="fst-italic">
                            Experienced in deploying and managing applications on cloud infrastructure
                            with CI/CD pipelines and containerized environments.
                        </p>
                    </div>
                    <div class="col-lg-6 order-1 order-lg-2 text-center">
                        <img src="{{ asset('assets/Home/img/features-illustration-3.webp') }}" alt="Cloud Certificate" class="img-fluid">
                    </div>
                </div>
            </div>

        </div>

    </div>

</section>
{{-- ==================== END CERTIFICATE SECTION ==================== --}}
