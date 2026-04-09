<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Hamzah Portfolio</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --blue-primary: #2563eb;
            --blue-light: #eff6ff;
            --blue-dark: #1e40af;
            --text-dark: #1e293b;
            --text-mid: #475569;
            --text-light: #94a3b8;
            --white: #ffffff;
            --bg: #f0f5ff;
            --card-shadow: 0 20px 60px rgba(37, 99, 235, 0.12);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: -120px; right: -120px;
            width: 480px; height: 480px;
            border-radius: 50%;
            background: radial-gradient(circle, #bfdbfe 0%, transparent 70%);
            z-index: 0;
            animation: float1 8s ease-in-out infinite;
        }

        body::after {
            content: '';
            position: fixed;
            bottom: -100px; left: -100px;
            width: 420px; height: 420px;
            border-radius: 50%;
            background: radial-gradient(circle, #dbeafe 0%, transparent 70%);
            z-index: 0;
            animation: float2 10s ease-in-out infinite;
        }

        @keyframes float1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-20px,20px)} }
        @keyframes float2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(20px,-20px)} }

        .sparkle {
            position: fixed; z-index: 0; pointer-events: none;
            color: var(--blue-primary); font-size: 1.2rem; opacity: .3;
            animation: twinkle 4s ease-in-out infinite;
        }
        .sparkle:nth-child(1) { top:12%; left:8%;    animation-delay:0s; }
        .sparkle:nth-child(2) { top:20%; right:12%;  animation-delay:1s;  font-size:1.8rem; }
        .sparkle:nth-child(3) { bottom:25%; right:8%; animation-delay:2s; }
        .sparkle:nth-child(4) { bottom:15%; left:15%; animation-delay:.5s; font-size:1.5rem; }

        @keyframes twinkle {
            0%,100%{ opacity:.2; transform:scale(1) }
            50%    { opacity:.5; transform:scale(1.3) }
        }

        .login-wrapper {
            position: relative; z-index: 1;
            display: flex;
            width: 900px; max-width: 96vw; min-height: 560px;
            border-radius: 28px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            animation: cardIn .6s cubic-bezier(.22,1,.36,1);
        }

        @keyframes cardIn {
            from { opacity:0; transform:translateY(28px) }
            to   { opacity:1; transform:translateY(0) }
        }

        /* Left panel */
        .left-panel {
            flex: 1;
            background: linear-gradient(145deg, var(--blue-primary) 0%, #1d4ed8 60%, #1e40af 100%);
            padding: 56px 48px;
            display: flex; flex-direction: column; justify-content: space-between;
            color: white; position: relative; overflow: hidden;
        }

        .left-panel::before {
            content: ''; position: absolute; top:-60px; right:-60px;
            width:280px; height:280px; border-radius:50%;
            background: rgba(255,255,255,.08);
        }

        .left-panel::after {
            content: ''; position: absolute; bottom:-80px; left:-40px;
            width:240px; height:240px; border-radius:50%;
            background: rgba(255,255,255,.06);
        }

        .left-content { position: relative; z-index: 1; }

        .left-content h2 {
            font-size: 2rem; font-weight: 800; line-height: 1.2; margin-bottom: 16px;
        }

        .left-content p { font-size: .95rem; opacity: .8; line-height: 1.7; margin-bottom: 32px; }

        .pill-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,.15); backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,.2);
            padding: 6px 14px; border-radius: 99px;
            font-size: .8rem; font-weight: 500; margin-bottom: 24px;
        }

        /* Right panel */
        .right-panel {
            width: 420px; background: var(--white);
            padding: 52px 44px;
            display: flex; flex-direction: column; justify-content: center;
        }

        .login-header { margin-bottom: 36px; }

        .login-header h1 {
            font-size: 1.75rem; font-weight: 800;
            color: var(--text-dark); margin-bottom: 6px;
        }

        .login-header p { color: var(--text-light); font-size: .9rem; }

        .field-group { margin-bottom: 20px; }

        .field-group label {
            display: block; font-size: .82rem; font-weight: 600;
            color: var(--text-mid); margin-bottom: 8px; letter-spacing: .3px;
        }

        .input-wrap { position: relative; }

        .input-wrap i.icon-left {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            color: var(--text-light); font-size: 1rem; pointer-events: none; transition: color .2s;
        }

        .input-wrap:focus-within i.icon-left { color: var(--blue-primary); }

        .input-wrap input {
            width: 100%; padding: 12px 42px 12px 40px;
            border: 1.5px solid #e2e8f0; border-radius: 12px;
            font-family: inherit; font-size: .92rem;
            color: var(--text-dark); background: var(--blue-light);
            outline: none; transition: border-color .2s, box-shadow .2s, background .2s;
        }

        .input-wrap input:focus {
            border-color: var(--blue-primary); background: #fff;
            box-shadow: 0 0 0 4px rgba(37,99,235,.1);
        }

        .input-wrap input::placeholder { color: var(--text-light); }

        .toggle-pw {
            position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
            cursor: pointer; color: var(--text-light); font-size: 1rem;
            pointer-events: all; transition: color .2s; z-index: 2; border: none; background: none; padding: 0;
        }

        .toggle-pw:hover { color: var(--blue-primary); }

        .error-msg { color: #ef4444; font-size: .78rem; margin-top: 5px; }

        .session-status {
            background: #dcfce7; border: 1px solid #86efac; color: #166534;
            padding: 10px 14px; border-radius: 10px; font-size: .85rem; margin-bottom: 20px;
        }

        .meta-row {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 28px; margin-top: 4px;
        }

        .remember-label {
            display: flex; align-items: center; gap: 8px;
            font-size: .83rem; color: var(--text-mid); cursor: pointer;
        }

        .remember-label input[type="checkbox"] {
            width: 16px; height: 16px; accent-color: var(--blue-primary); cursor: pointer;
        }

        .forgot-link {
            font-size: .83rem; color: var(--blue-primary); font-weight: 600;
            text-decoration: none; transition: opacity .2s;
        }

        .forgot-link:hover { opacity: .7; }

        .btn-login {
            width: 100%; padding: 13px;
            background: linear-gradient(135deg, var(--blue-primary), #1d4ed8);
            color: white; border: none; border-radius: 12px;
            font-family: inherit; font-size: .95rem; font-weight: 700;
            cursor: pointer; letter-spacing: .3px;
            transition: transform .15s, box-shadow .2s;
            box-shadow: 0 6px 24px rgba(37,99,235,.3);
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }

        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 10px 32px rgba(37,99,235,.4); }
        .btn-login:active { transform: translateY(0); }

        @media(max-width: 720px) {
            .left-panel  { display: none; }
            .right-panel { width: 100%; padding: 40px 28px; }
            .login-wrapper { border-radius: 20px; }
        }
    </style>
</head>

<body>

    {{-- ── Toast Bootstrap: akun nonaktif ── --}}
    @if ($errors->has('email') && str_contains($errors->first('email'), 'tidak aktif'))
        <div class="position-fixed top-0 start-50 translate-middle-x p-3" style="z-index:9999; margin-top:16px;">
            <div id="toastNonaktif" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-danger text-white">
                    <i class="bi bi-shield-x-fill me-2"></i>
                    <strong class="me-auto">Akun Nonaktif</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body" style="font-size:.85rem; color:#1e293b;">
                    {{ $errors->first('email') }}
                </div>
            </div>
        </div>
    @endif

    {{-- Sparkles --}}
    <div class="sparkle"><i class="bi bi-stars"></i></div>
    <div class="sparkle"><i class="bi bi-plus-lg"></i></div>
    <div class="sparkle"><i class="bi bi-stars"></i></div>
    <div class="sparkle"><i class="bi bi-plus-lg"></i></div>

    <div class="login-wrapper">

        {{-- Left panel --}}
        <div class="left-panel">
            <div class="left-content">
                <div class="pill-badge">
                    <i class="bi bi-gear-fill"></i> Admin Portal
                </div>
                <h2>Kelola Portofolio dengan Mudah dan Cepat</h2>
                <p>Login untuk mengelola projects, skills, dan konten portfolio secara langsung.</p>
            </div>
            <div style="font-size:.75rem; opacity:.5;">© {{ date('Y') }} Portfolio</div>
        </div>

        {{-- Right panel --}}
        <div class="right-panel">
            <div class="login-header">
                <h1>Selamat Datang</h1>
                <p>Masukkan kredensial untuk melanjutkan</p>
            </div>

            @if (session('status'))
                <div class="session-status">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="field-group">
                    <label for="email">Alamat Email</label>
                    <div class="input-wrap">
                        <input id="email" type="email" name="email"
                               value="{{ old('email') }}"
                               placeholder="email@contoh.com"
                               required autofocus autocomplete="username">
                        <i class="bi bi-envelope icon-left"></i>
                    </div>
                    {{-- Tampil hanya kalau bukan error nonaktif --}}
                    @if ($errors->has('email') && !str_contains($errors->first('email'), 'tidak aktif'))
                        <div class="error-msg">{{ $errors->first('email') }}</div>
                    @endif
                </div>

                {{-- Password --}}
                <div class="field-group">
                    <label for="password">Kata Sandi</label>
                    <div class="input-wrap">
                        <input id="password" type="password" name="password"
                               placeholder="kata sandi"
                               required autocomplete="current-password">
                        <i class="bi bi-lock icon-left"></i>
                        <button type="button" class="toggle-pw" onclick="togglePassword()">
                            <i class="bi bi-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Remember + Forgot --}}
                <div class="meta-row">
                    <label class="remember-label">
                        <input type="checkbox" name="remember" id="remember_me">
                        Ingat saya
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Lupa Kata Sandi?</a>
                    @endif
                </div>

                <button type="submit" class="btn-login">
                    <i class="bi bi-box-arrow-in-right"></i> Masuk
                </button>
            </form>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Tampilkan toast nonaktif
        const toastEl = document.getElementById('toastNonaktif');
        if (toastEl) {
            const toast = new bootstrap.Toast(toastEl, { delay: 6000 });
            toast.show();
        }

        // Toggle show/hide password
        function togglePassword() {
            const input = document.getElementById('password');
            const icon  = document.getElementById('toggleIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'bi bi-eye';
            }
        }
    </script>

</body>
</html>
