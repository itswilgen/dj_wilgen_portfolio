<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Config;
use App\Core\Session;

final class AdminUser
{
    public static function check(): bool
    {
        return (bool) Session::get((string) Config::get('auth.session_key'), false);
    }

    public static function login(string $password): bool
    {
        $hash = (string) Config::get('auth.admin_password_hash');
        $plainPassword = (string) Config::get('auth.admin_password');

        $valid = $hash !== ''
            ? password_verify($password, $hash)
            : hash_equals($plainPassword, $password);

        if ($valid) {
            Session::put((string) Config::get('auth.session_key'), true);
        }

        return $valid;
    }

    public static function logout(): void
    {
        Session::destroy();
    }
}
