<?php

declare(strict_types=1);

namespace App\Core;

final class Csrf
{
    private const TOKEN_KEY = 'csrf_token';

    public static function token(): string
    {
        if (!Session::has(self::TOKEN_KEY)) {
            Session::put(self::TOKEN_KEY, bin2hex(random_bytes(32)));
        }

        return (string) Session::get(self::TOKEN_KEY);
    }

    public static function validate(?string $token): bool
    {
        $sessionToken = Session::get(self::TOKEN_KEY);

        if (!is_string($token) || !is_string($sessionToken)) {
            return false;
        }

        return hash_equals($sessionToken, $token);
    }

    public static function regenerate(): string
    {
        Session::put(self::TOKEN_KEY, bin2hex(random_bytes(32)));

        return (string) Session::get(self::TOKEN_KEY);
    }

    public static function clear(): void
    {
        Session::forget(self::TOKEN_KEY);
    }
}
