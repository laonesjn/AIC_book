<?php
// app/Http/Middleware/AdminJWT.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\BlacklistedToken;
use App\Models\RefreshToken;
use App\Services\JWTService;

class AdminJWT
{
    // Generic unauthorized message — never leak the specific reason to the UI.
    private const UNAUTHORIZED_MESSAGE = 'Your session has expired. Please sign in again.';

    public function __construct(private JWTService $jwtService) {}

    public function handle(Request $request, Closure $next)
    {
        // 1. Try the access token first (cookie only — no Bearer for web panel).
        //    We deliberately ignore the Authorization header for the web admin panel
        //    to prevent CSRF-style token injection via XSS on other pages.
        $token = $request->cookie('access_token');

        $decoded = null;

        if ($token) {
            $decoded = $this->jwtService->verifyAccessToken($token);
        }

        // 2. If access token is missing or expired, silently attempt refresh.
        //    If refresh also fails, reject with a consistent unauthorized response.
        if (!$decoded) {
            $refreshResult = $this->tryRefreshToken($request);
            if (!$refreshResult) {
                return $this->unauthorizedResponse($request);
            }
            $decoded = $refreshResult;
        }

        // 3. Check blacklist (for explicitly logged-out tokens).
        if (BlacklistedToken::isBlacklisted($decoded->jti)) {
            return $this->unauthorizedResponse($request);
        }

        // 4. Load the admin record — always from DB, never from token payload.
        //    Role and email are fetched fresh here to prevent stale privilege escalation.
        $admin = Admin::find($decoded->sub);

        if (!$admin || !$admin->is_active) {
            return $this->unauthorizedResponse($request);
        }

        // 5. Password version check — invalidates all tokens on password change.
        //    SECURITY: Returns the same generic unauthorized view, NOT a JSON response,
        //    to avoid leaking that the specific rejection reason is password version.
        if ((int) $admin->password_version !== (int) $decoded->password_version) {
            return $this->unauthorizedResponse($request);
        }

        // 6. Bind the admin to the request and globally for this request.
        $request->setUserResolver(fn() => $admin);
        \Illuminate\Support\Facades\Auth::setUser($admin);

        return $next($request);
    }

    /**
     * Attempt a silent token refresh using the refresh token cookie.
     *
     * Returns the decoded payload of the new access token on success, or null on failure.
     * Queues new cookies via the cookie jar so they are sent with the current response.
     */
    private function tryRefreshToken(Request $request): ?object
    {
        $refreshTokenPlain = $request->cookie('refresh_token');
        if (!$refreshTokenPlain) {
            return null;
        }

        $refreshTokenHash = $this->jwtService->hashToken($refreshTokenPlain);

        $refreshToken = RefreshToken::where('token_hash', $refreshTokenHash)
            ->where('revoked', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$refreshToken) {
            return null;
        }

        $admin = $refreshToken->admin;

        if (!$admin || !$admin->is_active) {
            return null;
        }

        // Rotate: revoke old, issue new
        $refreshToken->update(['revoked' => true]);

        $accessTokenData      = $this->jwtService->generateAccessToken($admin);
        $newRefreshTokenPlain = $this->jwtService->generateRefreshToken();
        $newRefreshTokenHash  = $this->jwtService->hashToken($newRefreshTokenPlain);

        RefreshToken::create([
            'admin_id'   => $admin->id,
            'jti'        => \Illuminate\Support\Str::uuid(),
            'token_hash' => $newRefreshTokenHash,
            'expires_at' => now()->addDays(30),
            'revoked'    => false,
        ]);

        $isProd       = app()->environment('production');
        $accessMinutes = (int) ceil(($accessTokenData['expires_in'] ?? 600) / 60);

        $baseCookiePath = rtrim(request()->getBasePath(), '/') . '/admin';

        cookie()->queue(cookie(
            'access_token', $accessTokenData['token'],
            $accessMinutes, $baseCookiePath, null, $isProd, true, false, 'Strict'
        ));
        cookie()->queue(cookie(
            'refresh_token', $newRefreshTokenPlain,
            43200, $baseCookiePath, null, $isProd, true, false, 'Strict'
        ));

        // Return the decoded payload of the freshly issued access token
        return $this->jwtService->verifyAccessToken($accessTokenData['token']);
    }

    /**
     * Return a consistent unauthorized response.
     *
     * SECURITY: Always returns the same view/redirect — never a different
     * status or message based on *why* authentication failed, to avoid
     * leaking internal state (blacklisted token, inactive account, etc.).
     */
    private function unauthorizedResponse(Request $request)
    {
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'message'  => self::UNAUTHORIZED_MESSAGE,
                'redirect' => route('admin.login.view'),
            ], 401);
        }

        return redirect()->route('admin.login.view')
            ->with('warning', self::UNAUTHORIZED_MESSAGE);
    }
}