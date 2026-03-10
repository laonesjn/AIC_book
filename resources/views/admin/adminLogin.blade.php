{{--
    resources/views/admin/adminLogin.blade.php

    SECURITY IMPLEMENTATION NOTES:
    ────────────────────────────────────────────────────────────────────────────
    1. CSRF: @csrf in form + X-CSRF-TOKEN header on AJAX — Laravel verifies both.
    2. XSS: ALL dynamic content uses textContent (never innerHTML). Server-side
       data passed to JS uses json_encode with JSON_HEX_TAG|JSON_HEX_AMP to
       neutralise any injection in session values.
    3. localStorage: NOT used for lockout enforcement. Lockout is entirely
       server-side. The UI only uses a display-only countdown driven by a
       relative offset (seconds remaining), never an absolute server timestamp.
    4. Input limits: maxlength on email (254) and password (128) to match
       server-side validation and prevent oversized submissions.
    5. Progressive enhancement: the form has method="POST" action="{{ route(...) }}"
       and @csrf so it works perfectly with JavaScript disabled.
    6. No secrets leaked: retry_until (absolute timestamp) is never sent to the
       frontend. Only retry_after_seconds (relative) is used. Password version,
       admin ID, and token details are never present in any response to the page.
    7. Autocomplete: email=email, password=current-password for password manager
       support without disabling security.
--}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    {{-- CSRF token for AJAX requests --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login — {{ config('app.name') }}</title>
    <style>
        *, *::before, *::after {
            margin: 0; padding: 0; box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            background: #f0f2f5;
        }
        .login-container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,.15);
            width: 100%;
            max-width: 420px;
            padding: 40px;
            animation: fadeIn .4s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }
        .login-header .icon-wrap {
            width: 60px; height: 60px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 16px;
            font-size: 26px; color: #fff;
        }
        .login-header h2 { color: #333; font-size: 22px; font-weight: 600; margin-bottom: 6px; }
        .login-header p  { color: #777; font-size: 14px; }

        /* Alerts */
        .alert {
            padding: 11px 14px;
            border-radius: 6px;
            margin-bottom: 18px;
            font-size: 14px;
            display: flex;
            align-items: flex-start;
            gap: 9px;
            animation: slideIn .25s ease;
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .alert-icon { flex-shrink: 0; margin-top: 1px; }
        .alert-content { flex: 1; line-height: 1.4; }
        .alert-error   { background: #fff0f0; color: #c0392b; border-left: 4px solid #c0392b; }
        .alert-success { background: #f0fff4; color: #27ae60; border-left: 4px solid #27ae60; }
        .alert-warning { background: #fffbf0; color: #e67e22; border-left: 4px solid #e67e22; }
        .alert-info    { background: #f0f8ff; color: #2980b9; border-left: 4px solid #2980b9; }

        /* Lockout */
        .lockout-box {
            background: #fff0f0;
            border: 1px solid #f5c6cb;
            border-radius: 8px;
            padding: 18px;
            text-align: center;
            margin-bottom: 18px;
            display: none;
        }
        .lockout-box.visible { display: block; animation: slideIn .25s ease; }
        .lockout-box .lock-icon  { font-size: 30px; margin-bottom: 8px; }
        .lockout-box .lock-title { color: #721c24; font-weight: 600; font-size: 15px; margin-bottom: 4px; }
        .lockout-box .countdown  {
            font-size: 28px; font-weight: 700; color: #c0392b;
            font-family: 'Courier New', monospace;
            margin: 10px 0;
        }
        .lockout-box .lock-sub { color: #721c24; font-size: 12px; }

        /* Attempts dots */
        .attempts-bar {
            background: #fffbf0;
            border-left: 4px solid #f39c12;
            padding: 10px 14px;
            border-radius: 6px;
            margin-bottom: 18px;
            font-size: 13px;
            color: #856404;
            display: none;
        }
        .attempts-bar.visible { display: block; animation: slideIn .25s ease; }
        .attempts-bar strong { display: block; margin-bottom: 6px; }
        .dots { display: flex; gap: 6px; margin-top: 4px; align-items: center; }
        .dot {
            width: 11px; height: 11px;
            border-radius: 50%;
            background: #28a745;
            transition: background .2s;
        }
        .dot.used { background: #dc3545; }
        .dots-label { font-size: 12px; margin-left: 6px; color: #856404; }

        /* Form */
        .form-group { margin-bottom: 22px; }
        label { display: block; margin-bottom: 7px; color: #555; font-weight: 500; font-size: 14px; }
        input[type="email"],
        input[type="password"] {
            width: 100%; padding: 12px 14px;
            border: 2px solid #e0e0e0;
            border-radius: 6px; font-size: 15px;
            transition: border-color .25s, box-shadow .25s;
            background: #fff;
        }
        input:focus {
            border-color: #667eea; outline: none;
            box-shadow: 0 0 0 3px rgba(102,126,234,.12);
        }
        input.input-error { border-color: #c0392b; }
        input:disabled { background: #f5f5f5; cursor: not-allowed; }

        /* Button */
        .btn-login {
            width: 100%; padding: 13px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff; border: none; border-radius: 6px;
            font-size: 16px; font-weight: 600; cursor: pointer;
            transition: transform .2s, box-shadow .2s, background .2s;
            position: relative; overflow: hidden;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            min-height: 48px;
        }
        .btn-login:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(102,126,234,.4);
        }
        .btn-login:active:not(:disabled) { transform: translateY(0); }
        .btn-login:disabled {
            background: #b0b0b0; cursor: not-allowed;
            transform: none; box-shadow: none;
        }
        /* Spinner */
        .spinner {
            display: none;
            width: 18px; height: 18px;
            border: 3px solid rgba(255,255,255,.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin .75s linear infinite;
            flex-shrink: 0;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        .btn-login.loading .spinner { display: block; }
        .btn-login.loading .btn-text { opacity: .75; }

        .security-footer {
            margin-top: 24px;
            padding-top: 16px;
            border-top: 1px solid #eee;
            text-align: center;
            color: #aaa;
            font-size: 11px;
        }
        @media (max-width: 480px) {
            .login-container { padding: 28px 18px; }
            .login-header h2 { font-size: 19px; }
        }
    </style>
</head>
<body>
<div class="login-container" role="main">
    <div class="login-header">
        <h2>Admin Portal</h2>
        <p>Enter your credentials to continue</p>
    </div>

    {{--
        SERVER-SIDE ALERTS (non-JS fallback)
        Uses {{ }} (escaped) — never {!! !!}
    --}}
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            <span class="alert-icon" aria-hidden="true">✓</span>
            <div class="alert-content">{{ session('success') }}</div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error" role="alert">
            <span class="alert-icon" aria-hidden="true">✕</span>
            <div class="alert-content">{{ session('error') }}</div>
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning" role="alert">
            <span class="alert-icon" aria-hidden="true">⚠</span>
            <div class="alert-content">{{ session('warning') }}</div>
        </div>
    @endif

    {{-- Lockout box (JS-driven, also shown for server-side lockout on page load) --}}
    <div class="lockout-box{{ session('locked') ? ' visible' : '' }}"
         id="lockoutBox"
         role="alert"
         aria-live="assertive">
        <div class="lock-icon" aria-hidden="true">🔒</div>
        <div class="lock-title">Account temporarily locked</div>
        <div class="countdown" id="countdown" aria-label="Time remaining">--:--</div>
        <div class="lock-sub">Too many failed attempts. Please wait.</div>
    </div>

    {{-- Attempts warning bar (JS-driven) --}}
    <div class="attempts-bar" id="attemptsBar" role="status" aria-live="polite">
        <strong>⚠ Warning: failed login attempt detected</strong>
        <div class="dots" id="attemptsDots" aria-label="Remaining attempts"></div>
    </div>

    {{--
        LOGIN FORM
        Progressive enhancement: works with JS disabled.
        action/method/CSRF handle the non-JS path.
    --}}
    <form
        action="{{ route('admin.login.post') }}"
        method="POST"
        id="loginForm"
        autocomplete="on"
        novalidate
    >
        @csrf

        <div class="form-group">
            <label for="email">Email Address</label>
            <input
                type="email"
                id="email"
                name="email"
                required
                maxlength="254"
                value="{{ old('email') }}"
                placeholder="admin@example.com"
                autocomplete="email"
                class="{{ $errors->has('email') ? 'input-error' : '' }}"
                aria-describedby="{{ $errors->has('email') ? 'email-error' : '' }}"
            />
            @error('email')
                <span id="email-error" class="alert alert-error" style="margin-top:6px;padding:6px 10px;" role="alert">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                required
                minlength="8"
                maxlength="128"
                placeholder="Enter your password"
                autocomplete="current-password"
            />
        </div>

        <button type="submit" class="btn-login" id="loginBtn">
            <div class="spinner" aria-hidden="true"></div>
            <span class="btn-text">Sign In</span>
        </button>
    </form>

    <div class="security-footer" aria-hidden="true">
        🔒 Secured connection · Admin access only
    </div>
</div>

{{--
    SECURITY: Pass ONLY the minimum required initial state to JS.
    ─────────────────────────────────────────────────────────────
    NEVER expose:
      - retry_until (absolute server timestamp — reveals server clock & rate limiter state)
      - password_version, admin ID, JWT details
      - raw email addresses

    ONLY expose:
      - retry_after_seconds: relative seconds remaining (0 if not locked)
      - remaining_attempts: how many attempts are left (capped, never raw server state)
      - locked: boolean

    json_encode with JSON_HEX_TAG|JSON_HEX_AMP prevents XSS via session value injection.
--}}
<script>
    window.__loginState = {!! json_encode([
        'retryAfterSeconds' => (int) (session('retry_after_seconds') ?? 0),
        'remainingAttempts' => (int) (session('remaining_attempts') ?? 5),
        'locked'            => (bool) (session('locked') ?? false),
    ], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!};
</script>

<script>
(function () {
    'use strict';

    // ─── Constants ───────────────────────────────────────────────────────────
    const MAX_ATTEMPTS = 5;
    const CSRF_TOKEN   = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    // ─── DOM refs ────────────────────────────────────────────────────────────
    const form         = document.getElementById('loginForm');
    const loginBtn     = document.getElementById('loginBtn');
    const emailInput   = document.getElementById('email');
    const passwordInput= document.getElementById('password');
    const lockoutBox   = document.getElementById('lockoutBox');
    const countdownEl  = document.getElementById('countdown');
    const attemptsBar  = document.getElementById('attemptsBar');
    const attemptsDots = document.getElementById('attemptsDots');

    // ─── State ───────────────────────────────────────────────────────────────
    // SECURITY: lockout is tracked as a RELATIVE offset (seconds from now),
    // not an absolute timestamp. This prevents revealing server internals and
    // avoids relying on client clock accuracy.
    let lockoutEndsAt   = 0;  // Date.now() value when lockout expires
    let remainingAttempts = MAX_ATTEMPTS;
    let countdownTimer  = null;

    // ─── Initialise from server-provided state ───────────────────────────────
    function init() {
        const s = window.__loginState || {};

        remainingAttempts = typeof s.remainingAttempts === 'number'
            ? Math.max(0, Math.min(MAX_ATTEMPTS, s.remainingAttempts))
            : MAX_ATTEMPTS;

        if (s.locked && s.retryAfterSeconds > 0) {
            // Convert relative seconds to an absolute local timestamp
            lockoutEndsAt = Date.now() + (s.retryAfterSeconds * 1000);
            showLockout();
        } else {
            renderAttempts();
        }
    }

    // ─── Lockout UI ──────────────────────────────────────────────────────────
    function showLockout() {
        lockoutBox.classList.add('visible');
        attemptsBar.classList.remove('visible');
        setFormDisabled(true);
        startCountdown();
    }

    function clearLockout() {
        lockoutBox.classList.remove('visible');
        setFormDisabled(false);
        lockoutEndsAt = 0;
        remainingAttempts = MAX_ATTEMPTS;
        stopCountdown();
        countdownEl.textContent = '--:--';
        renderAttempts();
    }

    function startCountdown() {
        stopCountdown();
        tick(); // immediate first render
        countdownTimer = setInterval(tick, 1000);
    }

    function stopCountdown() {
        if (countdownTimer) { clearInterval(countdownTimer); countdownTimer = null; }
    }

    function tick() {
        const remaining = Math.max(0, Math.floor((lockoutEndsAt - Date.now()) / 1000));
        if (remaining <= 0) {
            clearLockout();
            return;
        }
        const m = Math.floor(remaining / 60);
        const s = remaining % 60;
        // SECURITY: textContent only — never innerHTML
        countdownEl.textContent = `${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;
    }

    // ─── Attempts indicator ──────────────────────────────────────────────────
    function renderAttempts() {
        if (remainingAttempts >= MAX_ATTEMPTS || remainingAttempts <= 0) {
            attemptsBar.classList.remove('visible');
            return;
        }
        attemptsBar.classList.add('visible');

        // Clear and rebuild dots safely (no innerHTML)
        while (attemptsDots.firstChild) {
            attemptsDots.removeChild(attemptsDots.firstChild);
        }

        for (let i = 0; i < MAX_ATTEMPTS; i++) {
            const dot = document.createElement('div');
            dot.className = 'dot' + (i >= remainingAttempts ? ' used' : '');
            dot.setAttribute('aria-hidden', 'true');
            attemptsDots.appendChild(dot);
        }

        const label = document.createElement('span');
        label.className = 'dots-label';
        // SECURITY: textContent — never innerHTML
        label.textContent = `${remainingAttempts} attempt${remainingAttempts === 1 ? '' : 's'} remaining`;
        attemptsDots.appendChild(label);
    }

    // ─── Alert helper ────────────────────────────────────────────────────────
    // SECURITY: Uses textContent throughout — XSS is impossible here.
    function showAlert(type, message) {
        // Remove existing JS-injected alerts
        document.querySelectorAll('.js-alert').forEach(el => el.remove());

        const icons = { success: '✓', error: '✕', warning: '⚠', info: 'ℹ' };
        const div   = document.createElement('div');
        div.className   = `alert alert-${type} js-alert`;
        div.setAttribute('role', 'alert');

        const iconSpan = document.createElement('span');
        iconSpan.className  = 'alert-icon';
        iconSpan.setAttribute('aria-hidden', 'true');
        iconSpan.textContent = icons[type] ?? '•';

        const contentDiv = document.createElement('div');
        contentDiv.className = 'alert-content';
        // SECURITY: textContent only — user-supplied data is never parsed as HTML
        contentDiv.textContent = message;

        div.appendChild(iconSpan);
        div.appendChild(contentDiv);

        // Insert before the form
        form.parentNode.insertBefore(div, form);
    }

    // ─── Form enable/disable ─────────────────────────────────────────────────
    function setFormDisabled(disabled) {
        loginBtn.disabled     = disabled;
        emailInput.disabled   = disabled;
        passwordInput.disabled = disabled;
        if (!disabled) loginBtn.classList.remove('loading');
    }

    // ─── Submit handler ──────────────────────────────────────────────────────
    form.addEventListener('submit', async function (ev) {
        // Progressive enhancement: if fetch is unavailable, let the form POST normally
        if (!window.fetch) return;

        ev.preventDefault();

        // Client-side lockout guard (display only — server enforces the real lockout)
        if (lockoutEndsAt && Date.now() < lockoutEndsAt) {
            showAlert('error', 'Account is temporarily locked. Please wait for the timer to expire.');
            return;
        }

        // Show loading state
        loginBtn.classList.add('loading');
        loginBtn.disabled = true;
        // Remove stale alerts
        document.querySelectorAll('.js-alert').forEach(el => el.remove());

        const formData = new FormData(form);

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN'    : CSRF_TOKEN,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept'          : 'application/json',
                },
                body: formData,
                credentials: 'same-origin',
            });

            // Parse JSON safely
            let data = {};
            try { data = await response.json(); } catch (_) {}

            // ── Success ──────────────────────────────────────────────────────
            if (response.ok) {
                showAlert('success', data.message ?? 'Login successful — redirecting…');
                clearLockout();
                // Short delay so the user sees the success message
                setTimeout(() => {
                    // SECURITY: data.redirect is used as a URL. We validate it is
                    // same-origin before following to prevent open redirect.
                    const redirectUrl = data.redirect ?? '';
                    if (redirectUrl && isSameOrigin(redirectUrl)) {
                        window.location.href = redirectUrl;
                    } else {
                        window.location.href = '/admin/dashboard';
                    }
                }, 500);
                return;
            }

            // ── Rate limited (429) ───────────────────────────────────────────
            if (response.status === 429) {
                const retrySeconds = parseInt(data.retry_after_seconds ?? 120, 10);
                if (retrySeconds > 0) {
                    lockoutEndsAt = Date.now() + (retrySeconds * 1000);
                }
                showLockout();
                showAlert('warning', data.message ?? 'Too many attempts. Please wait and try again.');
                passwordInput.value = '';
                return;
            }

            // ── Invalid credentials (401) ────────────────────────────────────
            if (response.status === 401) {
                remainingAttempts = typeof data.remaining_attempts === 'number'
                    ? Math.max(0, Math.min(MAX_ATTEMPTS, data.remaining_attempts))
                    : Math.max(0, remainingAttempts - 1);

                if (remainingAttempts <= 0 && !lockoutEndsAt) {
                    // Server said locked=true but didn't send retry_after_seconds
                    // Apply a conservative 2-minute client-side display lockout.
                    // The server will enforce the real duration regardless.
                    lockoutEndsAt = Date.now() + (120 * 1000);
                    showLockout();
                } else {
                    renderAttempts();
                }

                showAlert('error', data.message ?? 'Invalid email or password.');
                passwordInput.value = '';
                return;
            }

            // ── Password expired (403) ───────────────────────────────────────
            if (response.status === 403) {
                showAlert('warning', data.message ?? 'Access denied.');
                if (data.reset_url && isSameOrigin(data.reset_url)) {
                    setTimeout(() => { window.location.href = data.reset_url; }, 1400);
                }
                return;
            }

            // ── Other errors ─────────────────────────────────────────────────
            showAlert('error', data.message ?? 'An unexpected error occurred. Please try again.');
            passwordInput.value = '';

        } catch (networkError) {
            // Network failure — fall back to standard form submit
            showAlert('error', 'Network error. Please check your connection.');
        } finally {
            // Restore button unless still locked
            if (!lockoutEndsAt || Date.now() >= lockoutEndsAt) {
                loginBtn.classList.remove('loading');
                loginBtn.disabled = false;
            } else {
                loginBtn.classList.remove('loading');
                loginBtn.disabled = true;
            }
        }
    });

    // ─── Open-redirect guard ─────────────────────────────────────────────────
    function isSameOrigin(url) {
        try {
            const parsed = new URL(url, window.location.origin);
            return parsed.origin === window.location.origin;
        } catch (_) {
            return false;
        }
    }

    // ─── Boot ────────────────────────────────────────────────────────────────
    init();

})();
</script>
</body>
</html>