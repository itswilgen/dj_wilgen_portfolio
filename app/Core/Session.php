<?php

declare(strict_types=1);

namespace App\Core;

final class Session
{
    private static array $data = [];
    private static bool $started = false;

    public static function start(): void
    {
        if (self::$started) {
            return;
        }

        self::$started = true;
        self::$data = [];

        $cookieName = (string) Config::get('app.session_cookie', 'dj_wilgen_session');
        $rawCookie = $_COOKIE[$cookieName] ?? '';

        if (!is_string($rawCookie) || $rawCookie === '') {
            return;
        }

        $decodedPayload = base64_decode(strtr($rawCookie, '-_', '+/'), true);

        if (!is_string($decodedPayload) || $decodedPayload === '') {
            return;
        }

        $payload = json_decode($decodedPayload, true);

        if (
            !is_array($payload)
            || !isset($payload['data'], $payload['signature'])
            || !is_array($payload['data'])
            || !is_string($payload['signature'])
        ) {
            return;
        }

        $expectedSignature = hash_hmac(
            'sha256',
            json_encode($payload['data'], JSON_UNESCAPED_SLASHES),
            self::secret()
        );

        if (!hash_equals($expectedSignature, $payload['signature'])) {
            return;
        }

        self::$data = $payload['data'];
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        self::start();

        return self::$data[$key] ?? $default;
    }

    public static function put(string $key, mixed $value): void
    {
        self::start();
        self::$data[$key] = $value;
        self::persist();
    }

    public static function has(string $key): bool
    {
        self::start();

        return array_key_exists($key, self::$data);
    }

    public static function forget(string $key): void
    {
        self::start();
        unset(self::$data[$key]);
        self::persist();
    }

    public static function destroy(): void
    {
        self::start();
        self::$data = [];
        self::clearCookie();
    }

    private static function persist(): void
    {
        $payload = [
            'data' => self::$data,
            'signature' => hash_hmac(
                'sha256',
                json_encode(self::$data, JSON_UNESCAPED_SLASHES),
                self::secret()
            ),
        ];

        $encodedPayload = strtr(
            base64_encode((string) json_encode($payload, JSON_UNESCAPED_SLASHES)),
            '+/',
            '-_'
        );

        setcookie(
            (string) Config::get('app.session_cookie', 'dj_wilgen_session'),
            $encodedPayload,
            self::cookieOptions(time() + 60 * 60 * 24 * 7)
        );
    }

    private static function clearCookie(): void
    {
        setcookie(
            (string) Config::get('app.session_cookie', 'dj_wilgen_session'),
            '',
            self::cookieOptions(time() - 3600)
        );
    }

    private static function cookieOptions(int $expires): array
    {
        return [
            'expires' => $expires,
            'path' => '/',
            'secure' => self::isSecureRequest(),
            'httponly' => true,
            'samesite' => 'Lax',
        ];
    }

    private static function isSecureRequest(): bool
    {
        return !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    }

    private static function secret(): string
    {
        return (string) Config::get('app.key', 'change-me');
    }
}
