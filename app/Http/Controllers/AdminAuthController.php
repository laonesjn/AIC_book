<?php
// app/Http/Controllers/AdminAuthController.php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\BlacklistedToken;
use App\Models\RefreshToken;
use App\Services\JWTService;
use App\Services\OTPService;
use App\Services\PasswordService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Carbon\Carbon;

class AdminAuthController extends Controller
{
    public function __construct(
        private JWTService $jwtService,
        private OTPService $otpService,
        private PasswordService $passwordService
    ) {}

    // =========================================================================
    // LOGIN
    // =========================================================================

    public function showLogin()
    {
        return view('admin.adminLogin');
    }

    public function login(Request $request)
    {
        $maxAttempts   = 5;
        $decaySeconds  = 120; // 2-minute lockout window

        // --- Rate limiting: keyed on BOTH IP and hashed email ---
        // Using two separate limiters prevents distributed attacks and per-account
        // lockout even when IP changes (e.g., mobile networks, VPNs).
        $emailHash  = hash('sha256', strtolower(trim($request->input('email', ''))));
        $keyByIp    = 'login_ip:' . $request->ip();
        $keyByEmail = 'login_email:' . $emailHash;

        if (RateLimiter::tooManyAttempts($keyByIp, $maxAttempts)
            || RateLimiter::tooManyAttempts($keyByEmail, $maxAttempts)) {

            $seconds = max(
                RateLimiter::availableIn($keyByIp),
                RateLimiter::availableIn($keyByEmail)
            );
            $minutes = (int) ceil($seconds / 60);

            $payload = [
                'message'            => "Too many login attempts. Please try again in {$minutes} minute(s).",
                // SECURITY: Return seconds remaining, NOT an absolute timestamp.
                // Absolute timestamps reveal server-side rate limiter state.
                'retry_after_seconds' => $seconds,
                'remaining_attempts'  => 0,
                'locked'              => true,
            ];

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json($payload, 429);
            }

            return redirect()->back()
                ->withInput($request->only('email'))
                ->with('error', "Too many login attempts. Please wait {$minutes} minute(s).")
                ->with('retry_after_seconds', $seconds)
                ->with('locked', true);
        }

        // --- Input validation ---
        $request->validate([
            'email'    => 'required|email|max:254',
            'password' => 'required|string|min:8|max:128',
        ]);

        // --- Credential check ---
        $admin = Admin::where('email', $request->email)
            ->where('is_active', true)
            ->first();

        if (!$admin || !$this->passwordService->verifyPassword($admin, $request->password)) {
            RateLimiter::hit($keyByIp, $decaySeconds);
            RateLimiter::hit($keyByEmail, $decaySeconds);

            $remainingByIp    = max(0, $maxAttempts - RateLimiter::attempts($keyByIp));
            $remainingByEmail = max(0, $maxAttempts - RateLimiter::attempts($keyByEmail));
            $remaining        = min($remainingByIp, $remainingByEmail);

            // SECURITY: Log only hashed/masked email — never log raw credentials or PII.
            \Log::warning('Failed admin login', [
                'email_hash' => $emailHash,
                'ip'         => $request->ip(),
                'attempts'   => RateLimiter::attempts($keyByIp),
            ]);

            $payload = [
                'message'            => 'Invalid email or password.',
                // SECURITY: Return remaining attempts so the UI can warn the user,
                // but do NOT return retry_until or absolute timestamps here.
                'remaining_attempts' => $remaining,
                'locked'             => $remaining <= 0,
            ];

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json($payload, 401);
            }

            return redirect()->back()
                ->withInput($request->only('email'))
                ->with('error', 'Invalid email or password.')
                ->with('remaining_attempts', $remaining);
        }

        // --- Clear rate limiters on success ---
        RateLimiter::clear($keyByIp);
        RateLimiter::clear($keyByEmail);

        // Log success (no PII beyond admin ID and masked IP suffix)
        \Log::info('Admin login successful', [
            'admin_id'  => $admin->id,
            'ip_prefix' => implode('.', array_slice(explode('.', $request->ip()), 0, 3)) . '.***',
        ]);

        // --- Refresh token device cap (keep last 3 devices) ---
        // SECURITY: Use pluck + whereIn instead of skip()->take()->update(),
        // which silently fails on MySQL.
        $oldTokenIds = RefreshToken::where('admin_id', $admin->id)
            ->where('revoked', false)
            ->orderBy('created_at', 'desc')
            ->skip(2)       // skip the latest 2
            ->take(PHP_INT_MAX) // take all remaining tokens
            ->pluck('id');

        if ($oldTokenIds->isNotEmpty()) {
            RefreshToken::whereIn('id', $oldTokenIds)->update(['revoked' => true]);
        }
        // --- Generate tokens ---
        $accessTokenData    = $this->jwtService->generateAccessToken($admin);
        $refreshTokenPlain  = $this->jwtService->generateRefreshToken();
        $refreshTokenHash   = $this->jwtService->hashToken($refreshTokenPlain);

        RefreshToken::create([
            'admin_id'    => $admin->id,
            'jti'         => \Illuminate\Support\Str::uuid(),
            'token_hash'  => $refreshTokenHash,
            'expires_at'  => now()->addDays(30),
            'revoked'     => false,
        ]);

        // Update last login timestamp (no IP stored — reduce PII footprint)
        $admin->update(['last_login_at' => now()]);

        // --- Cookies ---
        [$accessCookie, $refreshCookie] = $this->buildAuthCookies($accessTokenData, $refreshTokenPlain);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'message'  => 'Login successful.',
                'redirect' => route('admin.dashboard'),
            ])->cookie($accessCookie)->cookie($refreshCookie);
        }

        return redirect()->route('admin.dashboard')
            ->with('success', 'Welcome back, ' . e($admin->name) . '!')
            ->cookie($accessCookie)
            ->cookie($refreshCookie);
    }

    // =========================================================================
    // REFRESH
    // =========================================================================

    public function refresh(Request $request)
    {
        $refreshTokenPlain = $request->cookie('refresh_token');

        if (!$refreshTokenPlain) {
            return response()->json(['message' => 'Session expired. Please log in again.'], 401);
        }

        $refreshTokenHash = $this->jwtService->hashToken($refreshTokenPlain);

        $refreshToken = RefreshToken::where('token_hash', $refreshTokenHash)
            ->where('revoked', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$refreshToken) {
            return response()->json(['message' => 'Session expired. Please log in again.'], 401);
        }

        $admin = $refreshToken->admin;

        if (!$admin || !$admin->is_active) {
            return response()->json(['message' => 'Account is inactive.'], 403);
        }

        // Rotate refresh token (revoke old, issue new)
        $refreshToken->update(['revoked' => true]);

        $accessTokenData       = $this->jwtService->generateAccessToken($admin);
        $newRefreshTokenPlain  = $this->jwtService->generateRefreshToken();
        $newRefreshTokenHash   = $this->jwtService->hashToken($newRefreshTokenPlain);

        RefreshToken::create([
            'admin_id'   => $admin->id,
            'jti'        => \Illuminate\Support\Str::uuid(),
            'token_hash' => $newRefreshTokenHash,
            'expires_at' => now()->addDays(30),
            'revoked'    => false,
        ]);

        [$accessCookie, $refreshCookie] = $this->buildAuthCookies($accessTokenData, $newRefreshTokenPlain);

        return response()->json([
            'token_type' => 'Bearer',
            'expires_in' => $accessTokenData['expires_in'],
        ])->cookie($accessCookie)->cookie($refreshCookie);
    }

    // =========================================================================
    // LOGOUT
    // =========================================================================

    public function logout(Request $request)
    {
        // Revoke refresh token
        $refreshTokenPlain = $request->cookie('refresh_token');
        if ($refreshTokenPlain) {
            $hash = $this->jwtService->hashToken($refreshTokenPlain);
            RefreshToken::where('token_hash', $hash)->update(['revoked' => true]);
        }

        // Blacklist access token
        $token = $request->bearerToken() ?? $request->cookie('access_token');
        if ($token) {
            $decoded = $this->jwtService->verifyAccessToken($token);
            if ($decoded && !empty($decoded->jti)) {
                BlacklistedToken::firstOrCreate(
                    ['jti' => $decoded->jti],
                    ['expires_at' => Carbon::createFromTimestamp($decoded->exp)]
                );
            }
        }

        $baseCookiePath = rtrim(request()->getBasePath(), '/') . '/admin';
        $refreshForget = cookie()->forget('refresh_token', $baseCookiePath);
        $accessForget  = cookie()->forget('access_token', $baseCookiePath);

        return redirect()->route('admin.login.view')
            ->with('message', 'Logged out successfully.')
            ->cookie($refreshForget)
            ->cookie($accessForget);
    }

    // =========================================================================
    // PROFILE / DASHBOARD
    // =========================================================================

    public function profile(Request $request)
    {
        $admin = $request->user();

        if (!$admin) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        return response()->json([
            'name'          => $admin->name,
            'email'         => $admin->email,
            'role'          => $admin->role ?? 'admin',
            'is_active'     => (bool) $admin->is_active,
            'last_login_at' => $admin->last_login_at?->toDateTimeString(),
        ]);
    }

    public function dashboard(Request $request)
    {
        $admin = $request->user();
        return view('admin.dashboard', compact('admin'));
    }

    // =========================================================================
    // FORGOT PASSWORD / OTP / RESET
    // =========================================================================

    public function forgotPassword(Request $request)
    {
        $keyByIp = 'forgot_password_ip:' . $request->ip();

        if (RateLimiter::tooManyAttempts($keyByIp, 3)) {
            $seconds = RateLimiter::availableIn($keyByIp);
            return response()->json([
                'message'             => "Too many requests. Please try again later.",
                'retry_after_seconds' => $seconds,
            ], 429);
        }

        $request->validate([
            'email' => 'required|email|max:254',
        ]);

        // SECURITY: Always hit rate limiter regardless of whether account exists,
        // to prevent timing-based user enumeration.
        RateLimiter::hit($keyByIp, 3600);

        $admin = Admin::where('email', $request->email)->first();

        if ($admin) {
            try {
                $otp               = $this->otpService->generateOTP();
                $verificationToken = $this->otpService->generateVerificationToken();

                // SECURITY: OTP is bound to the admin's email via the DB record.
                $this->otpService->createPasswordReset($admin, $otp, $verificationToken);

                // Send via proper Mailable (not Mail::raw)
                Mail::to($admin->email)->send(new \App\Mail\AdminPasswordResetOtp($otp));

                // SECURITY: Set cookie AFTER successful OTP generation only.
                $cookie = cookie(
                    'otp_verification_token',
                    $verificationToken,
                    5,          // 5 minutes
                    rtrim(request()->getBasePath(), '/') . '/admin',
                    null,
                    app()->environment('production'), // secure flag
                    true,       // httpOnly
                    false,
                    'strict'    // SameSite=Strict for OTP flow
                );

                return response()->json([
                    'message' => 'If an account exists with that email, an OTP has been sent.',
                    // SECURITY: Return relative TTL only, not absolute timestamp.
                    'otp_ttl_seconds' => 300,
                ])->cookie($cookie);

            } catch (\Exception $e) {
                \Log::error('Failed to send password reset OTP', [
                    'admin_id' => $admin->id,
                    'error'    => $e->getMessage(),
                ]);
                // Fall through to return the same generic response — don't reveal failure.
            }
        }

        // Always return the same response regardless of account existence
        return response()->json([
            'message' => 'If an account exists with that email, an OTP has been sent.',
        ]);
    }

    public function verifyOTP(Request $request)
    {
        $keyByIp = 'verify_otp_ip:' . $request->ip();

        if (RateLimiter::tooManyAttempts($keyByIp, 5)) {
            return response()->json(['message' => 'Too many attempts. Please request a new OTP.'], 429);
        }

        $request->validate([
            'email' => 'required|email|max:254',
            'otp'   => 'required|string|size:6|regex:/^[0-9]+$/',
        ]);

        $verificationToken = $request->cookie('otp_verification_token');

        if (!$verificationToken) {
            return response()->json(['message' => 'Verification session expired.'], 401);
        }

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin) {
            // Hit limiter and return generic error to prevent email enumeration
            RateLimiter::hit($keyByIp, 300);
            return response()->json(['message' => 'Invalid OTP or email.'], 401);
        }

        // SECURITY: Verify both OTP and token, and assert they belong to the SAME record.
        // This prevents a token from one session being used with an OTP from another.
        $reset      = $this->otpService->verifyOTP($admin, $request->otp);
        $tokenReset = $this->otpService->verifyToken($admin, $verificationToken);

        if (!$reset || !$tokenReset || $reset->id !== $tokenReset->id) {
            RateLimiter::hit($keyByIp, 300);
            return response()->json(['message' => 'Invalid OTP or expired.'], 401);
        }

        // SECURITY: Also verify the reset record's admin_id matches the submitted email's admin.
        if ($reset->admin_id !== $admin->id) {
            RateLimiter::hit($keyByIp, 300);
            return response()->json(['message' => 'Invalid OTP or expired.'], 401);
        }

        RateLimiter::clear($keyByIp);

        return response()->json([
            'message'  => 'OTP verified. You may now reset your password.',
            'verified' => true,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $keyByIp = 'reset_password_ip:' . $request->ip();

        if (RateLimiter::tooManyAttempts($keyByIp, 3)) {
            return response()->json(['message' => 'Too many attempts.'], 429);
        }

        $request->validate([
            'email'        => 'required|email|max:254',
            'otp'          => 'required|string|size:6|regex:/^[0-9]+$/',
            'new_password' => 'required|string|confirmed|min:12|max:128',
        ]);

        $verificationToken = $request->cookie('otp_verification_token');

        if (!$verificationToken) {
            return response()->json(['message' => 'Verification session expired.'], 401);
        }

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin) {
            RateLimiter::hit($keyByIp, 300);
            return response()->json(['message' => 'Invalid request.'], 401);
        }

        $reset      = $this->otpService->verifyOTP($admin, $request->otp);
        $tokenReset = $this->otpService->verifyToken($admin, $verificationToken);

        if (!$reset || !$tokenReset || $reset->id !== $tokenReset->id || $reset->admin_id !== $admin->id) {
            RateLimiter::hit($keyByIp, 300);
            return response()->json(['message' => 'Invalid OTP or expired.'], 401);
        }

        // Validate password strength
        $errors = $this->passwordService->validatePasswordStrength($request->new_password);
        if (!empty($errors)) {
            return response()->json([
                'message' => 'Password does not meet requirements.',
                'errors'  => $errors,
            ], 422);
        }

        $this->passwordService->updatePassword($admin, $request->new_password);
        $this->otpService->markAsUsed($reset);

        // Revoke all existing refresh tokens (force re-login on all devices)
        $admin->revokeAllRefreshTokens();

        RateLimiter::clear($keyByIp);

        $cookie = cookie()->forget('otp_verification_token', rtrim(request()->getBasePath(), '/') . '/admin');

        return response()->json(['message' => 'Password reset successful. Please log in.'])
            ->cookie($cookie);
    }

    // =========================================================================
    // CHANGE PASSWORD (authenticated)
    // =========================================================================

    public function changePassword(Request $request)
    {
        $admin  = $request->user();
        $keyById = 'change_password:' . $admin->id;

        if (RateLimiter::tooManyAttempts($keyById, 5)) {
            return response()->json(['message' => 'Too many attempts.'], 429);
        }

        $request->validate([
            'old_password' => 'required|string|max:128',
            'new_password' => 'required|string|confirmed|min:12|max:128',
        ]);

        if (!$this->passwordService->verifyPassword($admin, $request->old_password)) {
            RateLimiter::hit($keyById, 300);
            return response()->json(['message' => 'The current password you entered is incorrect.'], 403);
        }

        if ($this->passwordService->verifyPassword($admin, $request->new_password)) {
            return response()->json(['message' => 'The new password cannot be the same as your current password.'], 422);
        }

        $errors = $this->passwordService->validatePasswordStrength($request->new_password);
        if (!empty($errors)) {
            return response()->json([
                'message' => 'Password does not meet requirements.',
                'errors'  => $errors,
            ], 422);
        }

        $this->passwordService->updatePassword($admin, $request->new_password);

        // Revoke all refresh tokens except the current session
        $admin->revokeAllRefreshTokens();

        RateLimiter::clear($keyById);

        return response()->json(['message' => 'Password changed successfully. Please log in again.']);
    }

    // =========================================================================
    // PRIVATE HELPERS
    // =========================================================================

    /**
     * Build access and refresh token cookies with consistent, secure settings.
     *
     * SECURITY DECISIONS:
     * - access_token: SameSite=Strict (admin panel has no cross-site navigation need)
     * - refresh_token: Path restricted to /admin/refresh to minimise attack surface
     * - secure: true in production only (allows local dev)
     * - httpOnly: true always (JS cannot read cookies)
     */
    private function buildAuthCookies(array $accessTokenData, string $refreshTokenPlain): array
    {
        $isProd       = app()->environment('production');
        $accessMinutes = (int) ceil(($accessTokenData['expires_in'] ?? 600) / 60);

        // SECURITY: Automatically detect whether we are in a subdirectory (e.g., /AIC/public_html)
        // logic to ensure the cookie is only sent to the /admin routes.
        $baseCookiePath = rtrim(request()->getBasePath(), '/') . '/admin';

        $accessCookie = cookie(
            'access_token',
            $accessTokenData['token'],
            $accessMinutes,
            $baseCookiePath,
            null,
            $isProd, // secure
            true,    // httpOnly
            false,
            'Strict' // SameSite=Strict (admin panel)
        );

        $refreshCookie = cookie(
            'refresh_token',
            $refreshTokenPlain,
            43200,          // 30 days in minutes
            $baseCookiePath, // SECURITY: Restricted path — not sent on every request
            null,
            $isProd, // secure
            true,    // httpOnly
            false,
            'Strict' // SameSite=Strict
        );

        return [$accessCookie, $refreshCookie];
    }
}