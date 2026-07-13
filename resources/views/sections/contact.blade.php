{{-- ==================== CONTACT SECTION ==================== --}}
<section id="contact" class="contact section light-background">

    <div class="container section-title" data-aos="fade-up">
        <h2>Contact</h2>
        <p>Have a project in mind or want to collaborate? Let's talk!</p>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row g-4 g-lg-5">

            {{-- Contact Info --}}
            <div class="col-lg-5">
                <div class="info-box" data-aos="fade-up" data-aos-delay="200">
                    <h3>Contact Info</h3>
                    <p>Feel free to reach out anytime. I'm available for freelance work, collaboration, or just a friendly chat about technology.</p>

                    <div class="info-item" data-aos="fade-up" data-aos-delay="300">
                        <div class="icon-box"><i class="bi bi-geo-alt"></i></div>
                        <div class="content">
                            <h4>Location</h4>
                            <p>{{ $config->contact_location ?? 'Indonesia' }}</p>
                        </div>
                    </div>

                    <div class="info-item" data-aos="fade-up" data-aos-delay="400">
                        <div class="icon-box"><i class="bi bi-telephone"></i></div>
                        <div class="content">
                            <h4>Phone Number</h4>
                            <p>{{ $config->contact_phone ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="info-item" data-aos="fade-up" data-aos-delay="500">
                        <div class="icon-box"><i class="bi bi-envelope"></i></div>
                        <div class="content">
                            <h4>Email Address</h4>
                            <p>{{ $config->contact_email ?? $user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Contact Form --}}
            <div class="col-lg-7">
                <div class="contact-form" data-aos="fade-up" data-aos-delay="300">
                    <h3>Get In Touch</h3>
                    <p>Send me a message and I'll get back to you within 24 hours.</p>

                    <form method="POST">
                        <div class="row gy-4">

                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control
                                    placeholder="Your Name"  required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <input type="email" name="email" class="form-control
                                    placeholder="Your Email" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <input type="text" name="subject" class="form-control
                                    placeholder="Subject" required>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <textarea class="form-control
                                    name="message" rows="6" placeholder="Message" required></textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 text-center">
                                @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif
                                @if(session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif
                                <button type="submit" class="btn btn-primary px-5">Send Message</button>
                            </div>

                        </div>
                    </form>

                </div>
            </div>

        </div>

    </div>

</section>
{{-- ==================== END CONTACT SECTION ==================== --}}
