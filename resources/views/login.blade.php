<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eKalinga — Admin Sign In</title>

    {{-- Tabler Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    {{-- Vite (Laravel asset bundler) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f6f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        /* ── Outer card ── */
        .login-card {
            display: flex;
            width: 100%;
            max-width: 820px;
            min-height: 500px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 32px rgba(0, 0, 0, 0.10);
        }

        /* ── Left brand panel ── */
        .brand-panel {
            flex: 1;
            background: linear-gradient(160deg, #0a3d2e 0%, #0f5c42 55%, #1a7a58 100%);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 40px 36px;
            position: relative;
            overflow: hidden;
        }

        .brand-panel::before {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.07);
        }

        .brand-panel::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -40px;
            width: 280px;
            height: 280px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Logo */
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
            z-index: 1;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.12);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-name {
            font-size: 22px;
            font-weight: 600;
            color: #fff;
            letter-spacing: -0.5px;
        }

        .logo-sub {
            font-size: 10px;
            color: rgba(255, 255, 255, 0.5);
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-top: 2px;
        }

        /* Tagline */
        .tagline {
            position: relative;
            z-index: 1;
            margin-top: 40px;
        }

        .tagline h2 {
            font-size: 19px;
            font-weight: 600;
            color: #fff;
            line-height: 1.4;
            margin-bottom: 10px;
        }

        .tagline p {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.65);
            line-height: 1.7;
        }

        /* Feature badges */
        .badges {
            display: flex;
            flex-direction: column;
            gap: 10px;
            position: relative;
            z-index: 1;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.09);
            border: 1px solid rgba(255, 255, 255, 0.13);
            border-radius: 20px;
            padding: 7px 14px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.75);
        }

        .badge i {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.5);
        }

        /* ── Right form panel ── */
        .form-panel {
            width: 340px;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 44px 36px;
        }

        .form-title {
            font-size: 20px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 4px;
        }

        .form-subtitle {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 28px;
        }

        /* Form groups */
        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 500;
            color: #4b5563;
            margin-bottom: 6px;
        }

        .input-wrapper {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 10px 38px 10px 12px;
            font-size: 14px;
            font-family: inherit;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #f9fafb;
            color: #111827;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-input:focus {
            border-color: #0f5c42;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(15, 92, 66, 0.10);
        }

        .form-input.is-invalid {
            border-color: #ef4444;
            background: #fff5f5;
        }

        .form-input.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.10);
        }

        .input-icon {
            position: absolute;
            right: 11px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            color: #9ca3af;
            pointer-events: none;
        }

        /* Toggle password icon — clickable */
        .toggle-password {
            pointer-events: all;
            cursor: pointer;
        }

        .toggle-password:hover {
            color: #0f5c42;
        }

        /* Validation errors */
        .invalid-feedback {
            font-size: 12px;
            color: #ef4444;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Remember me + forgot */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 12px;
            color: #6b7280;
            cursor: pointer;
        }

        .remember-label input[type="checkbox"] {
            accent-color: #0f5c42;
            width: 14px;
            height: 14px;
        }

        .forgot-link {
            font-size: 12px;
            color: #0f5c42;
            text-decoration: none;
            font-weight: 500;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        /* Submit button */
        .btn-submit {
            width: 100%;
            padding: 11px;
            font-size: 14px;
            font-family: inherit;
            font-weight: 600;
            border-radius: 8px;
            border: none;
            background: #0f5c42;
            color: #fff;
            cursor: pointer;
            letter-spacing: 0.2px;
            transition: background 0.2s, transform 0.1s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit:hover {
            background: #0a3d2e;
        }

        .btn-submit:active {
            transform: scale(0.99);
        }

        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Security note */
        .security-note {
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid #f0f0f0;
            display: flex;
            align-items: flex-start;
            gap: 9px;
        }

        .security-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #0f5c42;
            flex-shrink: 0;
            margin-top: 4px;
        }

        .security-text {
            font-size: 11px;
            color: #9ca3af;
            line-height: 1.6;
        }

        /* Session / general error */
        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 13px;
            color: #dc2626;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Responsive: stack on small screens */
        @media (max-width: 640px) {
            .login-card {
                flex-direction: column;
            }

            .brand-panel {
                padding: 28px 24px 24px;
            }

            .tagline {
                margin-top: 20px;
            }

            .badges {
                flex-direction: row;
                flex-wrap: wrap;
            }

            .form-panel {
                width: 100%;
                padding: 32px 24px;
            }
        }
    </style>
</head>
<body>

<div class="login-card">

    {{-- ── Left: Brand panel ── --}}
    <div class="brand-panel">

        {{-- Logo --}}
        <div class="logo">
            <div class="logo-icon">
                <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11 2C11 2 4 7 4 12.5C4 16.09 7.13 19 11 19C14.87 19 18 16.09 18 12.5C18 7 11 2 11 2Z"
                          fill="rgba(255,255,255,0.9)"/>
                    <circle cx="11" cy="12.5" r="2.8" fill="#0f5c42"/>
                </svg>
            </div>
            <div>
                <div class="logo-name">eKalinga</div>
                <div class="logo-sub">PLSP Center for Mental Health</div>
            </div>
        </div>

        {{-- Tagline --}}
        <div class="tagline">
            <h2>A safer space for student wellbeing records.</h2>
            <p>Paperless. Secure. Always accessible — replacing manual documentation with a centralized digital system.</p>
        </div>

        {{-- Feature badges --}}
        <div class="badges">
            <span class="badge"><i class="ti ti-lock"></i> Encrypted cloud storage</span>
            <span class="badge"><i class="ti ti-message-circle"></i> Confidential messaging</span>
            <span class="badge"><i class="ti ti-chart-bar"></i> Trend analytics</span>
        </div>

    </div>

    {{-- ── Right: Login form ── --}}
    <div class="form-panel">

        <p class="form-title">Admin sign in</p>
        <p class="form-subtitle">Access the eKalinga management portal</p>

        {{-- Session status (e.g. "Password reset link sent") --}}
        @if (session('status'))
            <div class="alert-error" style="background:#f0fdf4; border-color:#bbf7d0; color:#15803d;">
                <i class="ti ti-circle-check"></i>
                {{ session('status') }}
            </div>
        @endif

        {{-- General auth error (wrong credentials) --}}
        @if ($errors->any() && !$errors->has('email') && !$errors->has('password'))
            <div class="alert-error">
                <i class="ti ti-alert-circle"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf

            {{-- Email --}}
            <div class="form-group">
                <label for="email" class="form-label">Email address</label>
                <div class="input-wrapper">
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-input @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        placeholder="admin@plsp.edu.ph"
                        required
                        autofocus
                        autocomplete="email"
                    >
                    <i class="ti ti-mail input-icon"></i>
                </div>
                @error('email')
                    <div class="invalid-feedback">
                        <i class="ti ti-alert-circle" style="font-size:13px;"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="input-wrapper">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-input @error('password') is-invalid @enderror"
                        placeholder="••••••••"
                        required
                        autocomplete="current-password"
                    >
                    <i class="ti ti-eye input-icon toggle-password" id="togglePassword" title="Show password"></i>
                </div>
                @error('password')
                    <div class="invalid-feedback">
                        <i class="ti ti-alert-circle" style="font-size:13px;"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Remember me + Forgot password --}}
            <div class="form-options">
                <label class="remember-label">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    Remember me
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                @endif
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-submit" id="submitBtn">
                <i class="ti ti-login"></i>
                Sign in to eKalinga
            </button>

        </form>

        {{-- Security note --}}
        <div class="security-note">
            <div class="security-dot"></div>
            <p class="security-text">
                For authorized PLSP Center for Mental Health personnel only.
                All sessions are logged and encrypted.
            </p>
        </div>

    </div>
</div>

<script>
    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput  = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
        const isHidden = passwordInput.type === 'password';
        passwordInput.type = isHidden ? 'text' : 'password';
        this.classList.toggle('ti-eye',      !isHidden);
        this.classList.toggle('ti-eye-off',   isHidden);
    });

    // Disable submit button while form is submitting (prevent double-clicks)
    document.getElementById('loginForm').addEventListener('submit', function () {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="ti ti-loader-2" style="animation: spin 1s linear infinite;"></i> Signing in...';
    });
</script>

</body>
</html>