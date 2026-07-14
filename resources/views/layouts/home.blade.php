<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ config('app.name', 'Hamzah Portfolio') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/favicon.svg') }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400&family=Sora:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- AOS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Swiper -->
    <link href="{{ asset('assets/Home/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- GLightbox -->
    <link href="{{ asset('assets/Home/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">

    <!-- Main CSS -->
    <link href="{{ asset('assets/Home/css/main.css') }}" rel="stylesheet">

    <!-- Home Enhance (lapisan estetika) -->
    <link href="{{ asset('assets/template/css/home-enhance.css') }}" rel="stylesheet">

    <style>
        /* Teks deskripsi rata kiri-kanan (justify) agar rapi */
        .main section p { text-align: justify; }
        /* Subjudul section tetap center */
        .main .section-title p { text-align: center; }
        /* Hero rata kiri */
        .main #hero,
        .main #hero p { text-align: left; }

        /* ===== Slider (Swiper) seragam ===== */
        .portfolio-slider { padding: 10px 4px 56px; }
        .portfolio-slider .swiper-slide { height: auto; }
        .portfolio-slider .swiper-slide > * { height: 100%; }
        .portfolio-slider .swiper-pagination { bottom: 12px; }
        .portfolio-slider .swiper-pagination-bullet {
            background: var(--accent-color, #2563eb); opacity: .25;
            width: 9px; height: 9px; transition: opacity .2s, width .2s;
        }
        .portfolio-slider .swiper-pagination-bullet-active { opacity: 1; width: 24px; border-radius: 6px; }
        .portfolio-slider .swiper-button-prev,
        .portfolio-slider .swiper-button-next {
            width: 42px; height: 42px; border-radius: 50%;
            background: #fff; color: var(--accent-color, #2563eb);
            box-shadow: 0 6px 18px rgba(0,0,0,.10); border: 1px solid rgba(0,0,0,.06);
            top: 42%;
        }
        .portfolio-slider .swiper-button-prev:hover,
        .portfolio-slider .swiper-button-next:hover {
            background: var(--accent-color, #2563eb); color: #fff;
        }
        .portfolio-slider .swiper-button-prev::after,
        .portfolio-slider .swiper-button-next::after { font-size: 1.05rem; font-weight: 700; }
        .portfolio-slider .swiper-button-disabled { opacity: 0; pointer-events: none; }
        @media (max-width: 991px) {
            .portfolio-slider .swiper-button-prev,
            .portfolio-slider .swiper-button-next { display: none; }
        }

        /* ===== Toggle bahasa ID / EN ===== */
        .lang-toggle {
            display: inline-flex; align-items: center; gap: 6px;
            border: 1px solid color-mix(in srgb, var(--accent-color, #0d83fd), transparent 65%);
            background: color-mix(in srgb, var(--accent-color, #0d83fd), transparent 90%);
            color: color-mix(in srgb, var(--accent-color, #0d83fd), #0b1f3a 45%);
            font-size: 13px; font-weight: 700; letter-spacing: .3px;
            padding: 7px 14px; border-radius: 50px; cursor: pointer;
            transition: background .25s ease, transform .25s ease;
            line-height: 1;
        }
        .lang-toggle:hover { background: color-mix(in srgb, var(--accent-color, #0d83fd), transparent 80%); transform: translateY(-1px); }
        .lang-toggle i { font-size: 15px; }

        /* Sembunyikan banner & UI bawaan Google Translate */
        .goog-te-banner-frame.skiptranslate,
        .goog-te-gadget, iframe.skiptranslate,
        #goog-gt-tt, .goog-te-balloon-frame { display: none !important; }
        body { top: 0 !important; }
        .goog-text-highlight { background: none !important; box-shadow: none !important; }
        #google_translate_element { display: none !important; }
    </style>

    @stack('styles')
</head>

<body class="index-page">

    {{-- Header / Navbar --}}
    @include('components.header')

    <main class="main">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('components.footer')

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <!-- Swiper -->
    <script src="{{ asset('assets/Home/vendor/swiper/swiper-bundle.min.js') }}"></script>

    <!-- GLightbox -->
    <script src="{{ asset('assets/Home/vendor/glightbox/js/glightbox.min.js') }}"></script>

    <!-- PureCounter -->
    <script src="{{ asset('assets/Home/vendor/purecounter/purecounter_vanilla.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/Home/js/main.js') }}"></script>

    {{-- ===== Google Translate (mesin terjemah, default: Indonesia) ===== --}}
    <div id="google_translate_element"></div>
    <script>
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'id',
                includedLanguages: 'en,id',
                autoDisplay: false
            }, 'google_translate_element');
        }

        (function () {
            function getCookie(name) {
                var m = document.cookie.match('(?:^|; )' + name + '=([^;]*)');
                return m ? decodeURIComponent(m[1]) : '';
            }
            function delCookie(name) {
                var host = location.hostname;
                document.cookie = name + '=;path=/;expires=Thu, 01 Jan 1970 00:00:00 GMT';
                document.cookie = name + '=;path=/;domain=' + host + ';expires=Thu, 01 Jan 1970 00:00:00 GMT';
                document.cookie = name + '=;path=/;domain=.' + host + ';expires=Thu, 01 Jan 1970 00:00:00 GMT';
            }

            // Bahasa aktif dibaca dari cookie googtrans (default: id)
            var current = /\/en$/.test(getCookie('googtrans')) ? 'en' : 'id';

            document.addEventListener('DOMContentLoaded', function () {
                var btn   = document.getElementById('langToggle');
                var label = document.getElementById('langToggleLabel');
                if (!btn) return;

                // Label menampilkan bahasa TUJUAN (yang akan dituju bila diklik)
                label.textContent = (current === 'id') ? 'EN' : 'ID';

                btn.addEventListener('click', function () {
                    if (current === 'id') {
                        // ke Inggris
                        document.cookie = 'googtrans=/id/en;path=/';
                    } else {
                        // kembali ke Indonesia (hapus cookie translate)
                        delCookie('googtrans');
                    }
                    location.reload();
                });
            });
        })();
    </script>
    <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    @stack('scripts')
</body>

</html>
