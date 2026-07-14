@php
    $fUser   = $user   ?? null;
    $fConfig = $config  ?? null;
    $fSkills = $skills  ?? collect();
    $siteName = $fUser->name ?? 'Portfolio';
@endphp
<footer id="footer" class="footer">

    <div class="container footer-top">
        <div class="row gy-4">

            <div class="col-lg-4 col-md-6 footer-about">
                <a href="{{ url('/') }}" class="logo d-flex align-items-center">
                    <span class="sitename">{{ $siteName }}</span>
                </a>
                <div class="footer-contact pt-3">
                    @if($fConfig?->contact_location)
                        <p>{{ $fConfig->contact_location }}</p>
                    @endif
                    @if($fConfig?->contact_phone)
                        <p class="mt-3"><strong>Telepon:</strong> <span>{{ $fConfig->contact_phone }}</span></p>
                    @endif
                    <p><strong>Email:</strong> <span>{{ $fConfig->contact_email ?? $fUser->email ?? '-' }}</span></p>
                </div>
                <div class="social-links d-flex mt-4">
                    <a href="#"><i class="bi bi-twitter-x"></i></a>
                    <a href="#"><i class="bi bi-github"></i></a>
                    <a href="#"><i class="bi bi-instagram"></i></a>
                    <a href="#"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Tautan</h4>
                <ul>
                    <li><a href="#hero">Beranda</a></li>
                    <li><a href="#about">Tentang</a></li>
                    <li><a href="#projects">Proyek</a></li>
                    <li><a href="#certificate">Sertifikat</a></li>
                    <li><a href="#contact">Kontak</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Keahlian</h4>
                <ul>
                    @forelse($fSkills->take(5) as $sk)
                        <li><a href="#skills">{{ $sk->name }}</a></li>
                    @empty
                        <li><a href="#skills">Lihat keahlian</a></li>
                    @endforelse
                </ul>
            </div>

            <div class="col-lg-4 col-md-6 footer-links">
                <h4>Tentang Saya</h4>
                <p class="text-muted small">
                    {{ \Illuminate\Support\Str::limit($fUser->tentang ?? 'Pengembang yang membangun aplikasi web modern dengan kode bersih dan pengalaman pengguna yang baik.', 160) }}
                </p>
            </div>

        </div>
    </div>

    <div class="container copyright text-center mt-4">
        <p>© <span>{{ date('Y') }}</span> <strong class="px-1 sitename">{{ $siteName }}</strong> <span>Hak Cipta Dilindungi</span></p>
    </div>

</footer>
