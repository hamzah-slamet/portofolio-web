<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — Hamzah Portfolio</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --blue-primary: #2563eb;
            --blue-dark:    #1e40af;
            --blue-light:   #eff6ff;
            --text-dark:    #1e293b;
            --text-mid:     #475569;
            --text-light:   #94a3b8;
            --white:        #ffffff;
            --bg:           #f0f5ff;
            --card-shadow:  0 20px 60px rgba(37, 99, 235, 0.12);
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
            color: var(--blue-primary); font-size: 1.2rem;
            opacity: .25; animation: twinkle 4s ease-in-out infinite;
        }
        .sparkle:nth-child(1) { top:10%; left:6%;  animation-delay:0s; }
        .sparkle:nth-child(2) { top:18%; right:10%; animation-delay:1.2s; font-size:1.8rem; }
        .sparkle:nth-child(3) { bottom:22%; right:7%; animation-delay:2s; }
        .sparkle:nth-child(4) { bottom:12%; left:12%; animation-delay:.7s; font-size:1.5rem; }
        @keyframes twinkle { 0%,100%{opacity:.15;transform:scale(1)} 50%{opacity:.4;transform:scale(1.3)} }

        /* ---- Wrapper ---- */
        .register-wrapper {
            position: relative; z-index: 1;
            display: flex;
            width: 940px; max-width: 96vw;
            border-radius: 28px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            animation: cardIn .6s cubic-bezier(.22,1,.36,1);
        }
        @keyframes cardIn { from{opacity:0;transform:translateY(28px)} to{opacity:1;transform:translateY(0)} }

        /* ---- Left panel ---- */
        .left-panel {
            flex: 1;
            background: linear-gradient(145deg, var(--blue-primary) 0%, #1d4ed8 60%, #1e40af 100%);
            padding: 52px 44px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .left-panel::before {
            content: '';
            position: absolute; top: -60px; right: -60px;
            width: 260px; height: 260px; border-radius: 50%;
            background: rgba(255,255,255,.08);
        }
        .left-panel::after {
            content: '';
            position: absolute; bottom: -70px; left: -40px;
            width: 220px; height: 220px; border-radius: 50%;
            background: rgba(255,255,255,.06);
        }

        .brand {
            font-size: 1.5rem; font-weight: 800; letter-spacing: -.5px;
            display: flex; align-items: center; gap: 10px;
        }
        .brand-dot {
            width: 10px; height: 10px; border-radius: 50%;
            background: rgba(255,255,255,.8); display: inline-block;
        }

        .left-content { position: relative; z-index: 1; }
        .left-content h2 { font-size: 1.9rem; font-weight: 800; line-height: 1.2; margin-bottom: 12px; }
        .left-content p  { font-size: .9rem; opacity: .8; line-height: 1.7; margin-bottom: 28px; }

        .pill-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,.15); backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,.2);
            padding: 5px 14px; border-radius: 99px;
            font-size: .78rem; font-weight: 500; margin-bottom: 20px;
        }

        /* Steps indicator */
        .steps { display: flex; flex-direction: column; gap: 14px; }
        .step-item {
            display: flex; align-items: flex-start; gap: 14px;
        }
        .step-num {
            width: 28px; height: 28px; border-radius: 50%; flex-shrink: 0;
            background: rgba(255,255,255,.2); border: 1.5px solid rgba(255,255,255,.4);
            display: flex; align-items: center; justify-content: center;
            font-size: .75rem; font-weight: 700;
        }
        .step-num.active {
            background: white; color: var(--blue-primary);
        }
        .step-text .st { font-size: .85rem; font-weight: 600; }
        .step-text .sd { font-size: .75rem; opacity: .65; margin-top: 1px; }

        /* ---- Right panel ---- */
        .right-panel {
            width: 460px;
            background: var(--white);
            padding: 48px 44px;
            display: flex; flex-direction: column; justify-content: center;
        }

        .reg-header { margin-bottom: 28px; }
        .reg-header h1 { font-size: 1.6rem; font-weight: 800; color: var(--text-dark); margin-bottom: 5px; }
        .reg-header p  { color: var(--text-light); font-size: .85rem; }

        /* Two-column row */
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

        .field-group { margin-bottom: 16px; }
        .field-group label {
            display: block; font-size: .79rem; font-weight: 600;
            color: var(--text-mid); margin-bottom: 7px; letter-spacing: .3px;
        }

        .input-wrap { position: relative; }
        .input-wrap .ico {
            position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
            color: var(--text-light); font-size: .95rem; pointer-events: none;
            transition: color .2s;
        }
        .input-wrap:focus-within .ico { color: var(--blue-primary); }

        .input-wrap input {
            width: 100%; padding: 11px 13px 11px 38px;
            border: 1.5px solid #e2e8f0; border-radius: 12px;
            font-family: inherit; font-size: .88rem; color: var(--text-dark);
            background: var(--blue-light);
            outline: none; transition: border-color .2s, box-shadow .2s, background .2s;
        }
        .input-wrap input:focus {
            border-color: var(--blue-primary);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(37,99,235,.1);
        }
        .input-wrap input::placeholder { color: var(--text-light); }

        .toggle-pw {
            position: absolute; right: 13px; top: 50%; transform: translateY(-50%);
            cursor: pointer; color: var(--text-light); font-size: .95rem;
            pointer-events: all; transition: color .2s; z-index: 2;
        }
        .toggle-pw:hover { color: var(--blue-primary); }

        /* Password strength */
        .pw-strength { margin-top: 7px; }
        .pw-bars { display: flex; gap: 4px; margin-bottom: 4px; }
        .pw-bar { flex: 1; height: 4px; border-radius: 99px; background: #e2e8f0; transition: background .3s; }
        .pw-bar.weak   { background: #ef4444; }
        .pw-bar.medium { background: #f59e0b; }
        .pw-bar.strong { background: #22c55e; }
        .pw-label { font-size: .72rem; color: var(--text-light); }

        .error-msg { color: #ef4444; font-size: .75rem; margin-top: 4px; }

        /* Submit */
        .btn-register {
            width: 100%; padding: 12px;
            background: linear-gradient(135deg, var(--blue-primary), #1d4ed8);
            color: white; border: none; border-radius: 12px;
            font-family: inherit; font-size: .92rem; font-weight: 700;
            cursor: pointer; letter-spacing: .3px; margin-top: 4px;
            transition: transform .15s, box-shadow .2s;
            box-shadow: 0 6px 24px rgba(37,99,235,.3);
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-register:hover { transform: translateY(-2px); box-shadow: 0 10px 32px rgba(37,99,235,.4); }
        .btn-register:active { transform: translateY(0); }

        .login-link {
            display: flex; align-items: center; justify-content: center;
            gap: 5px; margin-top: 18px;
            font-size: .82rem; color: var(--text-light);
        }
        .login-link a { color: var(--blue-primary); font-weight: 600; text-decoration: none; }
        .login-link a:hover { opacity: .75; }

        @media(max-width: 740px) {
            .left-panel { display: none; }
            .right-panel { width: 100%; padding: 36px 28px; }
            .form-row { grid-template-columns: 1fr; }
            .register-wrapper { border-radius: 20px; }
        }
    </style>
</head>
<body>

    <div class="sparkle"><i class="bi bi-stars"></i></div>
    <div class="sparkle"><i class="bi bi-plus-lg"></i></div>
    <div class="sparkle"><i class="bi bi-stars"></i></div>
    <div class="sparkle"><i class="bi bi-plus-lg"></i></div>

    <div class="register-wrapper">

        {{-- Left panel --}}
        <div class="left-panel">
            <div class="left-content">
                <div class="pill-badge">
                    <i class="bi bi-person-plus-fill"></i> Buat Akun Baru
                </div>
                <h2>Mulai Kelola<br>Portfolio</h2>
                <p>Daftar dan mulai tampilkan projects, skills, serta pengalaman kerja secara dinamis.</p>

                <div class="steps">
                    <div class="step-item">
                        <div class="step-num active">1</div>
                        <div class="step-text">
                            <div class="st">Isi Data Akun</div>
                            <div class="sd">Nama, email & password</div>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-num">2</div>
                        <div class="step-text">
                            <div class="st">Lengkapi Profil</div>
                            <div class="sd">Bio, foto & sosial media</div>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-num">3</div>
                        <div class="step-text">
                            <div class="st">Tambah Konten</div>
                            <div class="sd">Projects, skills & experience</div>
                        </div>
                    </div>
                </div>
            </div>

            <div style="font-size:.72rem;opacity:.45;position:relative;z-index:1;">© {{ date('Y') }} Portfolio</div>
        </div>

        {{-- Right panel --}}
        <div class="right-panel">
            <div class="reg-header">
                <h1>Buat Akun ✨</h1>
                <p>Lengkapi form berikut untuk mendaftar</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Name --}}
                <div class="field-group">
                    <label for="name">Nama Lengkap</label>
                    <div class="input-wrap">
                        <input
                            id="name" type="text" name="name"
                            value="{{ old('name') }}"
                            placeholder="John Doe"
                            required autofocus autocomplete="name"
                        >
                        <i class="ico bi bi-person"></i>
                    </div>
                    @error('name')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="field-group">
                    <label for="email">Alamat Email</label>
                    <div class="input-wrap">
                        <input
                            id="email" type="email" name="email"
                            value="{{ old('email') }}"
                            placeholder="nama@email.com"
                            required autocomplete="username"
                        >
                        <i class="ico bi bi-envelope"></i>
                    </div>
                    @error('email')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password & Confirm --}}
                <div class="form-row">
                    <div class="field-group" style="margin-bottom:0;">
                        <label for="password">Password</label>
                        <div class="input-wrap">
                            <input
                                id="password" type="password" name="password"
                                placeholder="Min. 8 karakter"
                                required autocomplete="new-password"
                                oninput="checkStrength(this.value)"
                            >
                            <i class="ico bi bi-lock"></i>
                            <span class="toggle-pw" onclick="togglePw('password','eye1')">
                                <i class="bi bi-eye-slash" id="eye1"></i>
                            </span>
                        </div>
                        <div class="pw-strength">
                            <div class="pw-bars">
                                <div class="pw-bar" id="bar1"></div>
                                <div class="pw-bar" id="bar2"></div>
                                <div class="pw-bar" id="bar3"></div>
                            </div>
                            <div class="pw-label" id="pw-label">Masukkan password</div>
                        </div>
                        @error('password')
                            <div class="error-msg">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field-group" style="margin-bottom:0;">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <div class="input-wrap">
                            <input
                                id="password_confirmation" type="password"
                                name="password_confirmation"
                                placeholder="Ulangi password"
                                required autocomplete="new-password"
                            >
                            <i class="ico bi bi-lock-fill"></i>
                            <span class="toggle-pw" onclick="togglePw('password_confirmation','eye2')">
                                <i class="bi bi-eye-slash" id="eye2"></i>
                            </span>
                        </div>
                        @error('password_confirmation')
                            <div class="error-msg">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div style="margin-top: 24px;">
                    <button type="submit" class="btn-register">
                        <i class="bi bi-person-check-fill"></i>
                        Daftar Sekarang
                    </button>
                </div>
            </form>

            <div class="login-link">
                Sudah punya akun?
                <a href="{{ route('login') }}">Masuk di sini</a>
            </div>
        </div>

    </div>

    <script>
        function togglePw(inputId, iconId) {
            const input = document.getElementById(inputId);
            const ico   = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                ico.className = 'bi bi-eye';
            } else {
                input.type = 'password';
                ico.className = 'bi bi-eye-slash';
            }
        }

        function checkStrength(val) {
            const bars  = [document.getElementById('bar1'), document.getElementById('bar2'), document.getElementById('bar3')];
            const label = document.getElementById('pw-label');
            bars.forEach(b => b.className = 'pw-bar');

            if (!val) { label.textContent = 'Masukkan password'; return; }

            let score = 0;
            if (val.length >= 8)                    score++;
            if (/[A-Z]/.test(val) && /[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val))           score++;

            const levels = [
                { cls: 'weak',   text: 'Lemah',   color: '#ef4444' },
                { cls: 'medium', text: 'Sedang',  color: '#f59e0b' },
                { cls: 'strong', text: 'Kuat',    color: '#22c55e' },
            ];
            const lvl = levels[score > 0 ? score - 1 : 0];
            for (let i = 0; i < score; i++) bars[i].classList.add(lvl.cls);
            label.textContent = lvl.text;
            label.style.color = lvl.color;
        }
    </script>
</body>
</html>
