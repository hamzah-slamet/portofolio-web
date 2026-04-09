<footer id="footer" class="footer">

    <div class="container footer-top">
        <div class="row gy-4">

            <div class="col-lg-4 col-md-6 footer-about">
                <a href="{{ url('/') }}" class="logo d-flex align-items-center">
                    <span class="sitename">Hamzah</span>
                </a>
                <div class="footer-contact pt-3">
                    <p>Jl. Contoh No. 108</p>
                    <p>Jakarta, Indonesia 12345</p>
                    <p class="mt-3"><strong>Phone:</strong> <span>+62 812 3456 7890</span></p>
                    <p><strong>Email:</strong> <span>hamzah@example.com</span></p>
                </div>
                <div class="social-links d-flex mt-4">
                    <a href="#"><i class="bi bi-twitter-x"></i></a>
                    <a href="#"><i class="bi bi-github"></i></a>
                    <a href="#"><i class="bi bi-instagram"></i></a>
                    <a href="#"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Useful Links</h4>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#projects">Projects</a></li>
                    <li><a href="#certificate">Certificate</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
                <h4>My Skills</h4>
                <ul>
                    <li><a href="#">Web Design</a></li>
                    <li><a href="#">Web Development</a></li>
                    <li><a href="#">Laravel / PHP</a></li>
                    <li><a href="#">JavaScript</a></li>
                    <li><a href="#">UI/UX Design</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-6 footer-links">
                <h4>About Me</h4>
                <p class="text-muted small">
                    Passionate developer building modern web applications with clean code and great user experiences.
                    Open to collaborations and freelance work.
                </p>
            </div>

        </div>
    </div>

    <div class="container copyright text-center mt-4">
        <p>© <span>{{ date('Y') }}</span> <strong class="px-1 sitename">Hamzah</strong> <span>All Rights Reserved</span></p>
    </div>

</footer>
