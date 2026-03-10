<?php
// app/Services/JWTService.php

namespace App\Services;

use App\Models\Admin;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;
use Illuminate\Support\Str;
use RuntimeException;

class JWTService
{
    private string $secret;
    private string $algorithm = 'HS256';

    // Minimum required secret length in bytes (256-bit = 32 bytes)
    private const MIN_SECRET_LENGTH = 32;

    public function __construct()
    {
        $secret = config('app.jwt_secret');

        // CRITICAL: Fail hard if secret is missing or weak
        if (empty($secret)) {
            throw new RuntimeException(
                'JWT_SECRET is not configured. Set a strong JWT_SECRET in your .env file.'
            );
        }

        if (strlen($secret) < self::MIN_SECRET_LENGTH) {
            throw new RuntimeException(
                'JWT_SECRET is too short. Minimum ' . self::MIN_SECRET_LENGTH . ' characters required.'
            );
        }

        // Prevent accidental reuse of APP_KEY as JWT secret
        if ($secret === config('app.key')) {
            throw new RuntimeException(
                'JWT_SECRET must not be the same as APP_KEY. Use a separate secret.'
            );
        }

        $this->secret = $secret;
    }

    /**
     * Generate an access token.
     * 
     * SECURITY: Email and role are intentionally excluded from the payload.
     * - Email: Unnecessary PII in token; readable by anyone who intercepts it.
     * - Role: Fetch fresh from DB to prevent stale privilege escalation.
     * Only sub (admin ID), jti, iat, exp, and password_version are included.
     */
    public function generateAccessToken(Admin $admin): array
    {
        $jti       = (string) Str::uuid();
        $issuedAt  = time();
        $expiresAt = $issuedAt + (10 * 60); // 10 minutes

        $issuer = config('app.url');

        $payload = [
            'iss'              => $issuer,
            'aud'              => $issuer,
            'iat'              => $issuedAt,
            'nbf'              => $issuedAt,
            'exp'              => $expiresAt,
            'jti'              => $jti,
            'sub'              => (int) $admin->id,
            // password_version allows immediate invalidation on password change
            'password_version' => (int) $admin->password_version,
        ];

        $token = JWT::encode($payload, $this->secret, $this->algorithm);

        return [
            'token'      => $token,
            'jti'        => $jti,
            'expires_in' => 600,
            'expires_at' => $expiresAt,
        ];
    }

    /**
     * Generate a cryptographically secure refresh token.
     * Returns 64 hex characters (256 bits of entropy).
     */
    public function generateRefreshToken(): string
    {
        return bin2hex(random_bytes(32));
    }

    /**
     * Verify an access token and return the decoded payload.
     *
     * SECURITY: Catches specific exception types to allow callers to distinguish
     * between expired tokens (try refresh) and tampered/invalid tokens (hard reject).
     *
     * @return object|null Decoded payload, or null if invalid
     */
    public function verifyAccessToken(string $token): ?object
    {
        try {
            $decoded = JWT::decode($token, new Key($this->secret, $this->algorithm));

            // Validate issuer and audience (iss/aud set but not validated by default)
            $expectedIssuer = config('app.url');
            if (($decoded->iss ?? null) !== $expectedIssuer) {
                return null;
            }
            if (($decoded->aud ?? null) !== $expectedIssuer) {
                return null;
            }

            // Ensure required claims are present
            if (empty($decoded->jti) || empty($decoded->sub) || !isset($decoded->password_version)) {
                return null;
            }

            return $decoded;

        } catch (ExpiredException $e) {
            // Token is expired — caller may attempt a refresh
            return null;
        } catch (SignatureInvalidException $e) {
            // Token signature is invalid — hard reject, do NOT attempt refresh
            \Log::warning('JWT signature verification failed', [
                'token_prefix' => substr($token, 0, 20) . '...',
                'error'        => 'SignatureInvalidException',
            ]);
            return null;
        } catch (BeforeValidException $e) {
            // Token not yet valid (nbf check)
            return null;
        } catch (\Exception $e) {
            // Unexpected error — log but do not expose details
            \Log::error('JWT decode error', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Hash a token for secure storage.
     * Uses SHA-256 which is sufficient for high-entropy random tokens.
     */
    public function hashToken(string $token): string
    {
        return hash('sha256', $token);
    }

    /**
     * Constant-time comparison to prevent timing attacks.
     */
    public function secureCompare(string $a, string $b): bool
    {
        return hash_equals($a, $b);
    }
}