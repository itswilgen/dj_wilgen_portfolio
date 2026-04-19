<?php

declare(strict_types=1);

return [
    'app' => [
        'key' => getenv('APP_KEY')
            ?: hash(
                'sha256',
                (getenv('ADMIN_PASSWORD_HASH') ?: getenv('ADMIN_PASSWORD') ?: 'change-me')
                . '|dj-wilgen-rivas'
            ),
        'session_cookie' => getenv('SESSION_COOKIE') ?: 'dj_wilgen_session',
    ],
    'db' => [
        'host' => getenv('DB_HOST') ?: 'localhost',
        'port' => (int) (getenv('DB_PORT') ?: 3306),
        'username' => getenv('DB_USERNAME') ?: 'root',
        'password' => getenv('DB_PASSWORD') ?: '',
        'database' => getenv('DB_DATABASE') ?: 'dj_wilgen_db',
    ],
    'site' => [
        'name' => 'DJ Wilgen Rivas',
        'admin_email' => getenv('ADMIN_EMAIL') ?: 'wilgenrivas123@gmail.com',
        'from_email' => getenv('FROM_EMAIL') ?: 'no-reply@djwilgen.com',
        'reply_to' => getenv('REPLY_TO_EMAIL') ?: 'contact@djwilgen.com',
        'base_url' => getenv('APP_URL') ?: '',
    ],
    'auth' => [
        'admin_password' => getenv('ADMIN_PASSWORD') ?: 'wilgen@22',
        'admin_password_hash' => getenv('ADMIN_PASSWORD_HASH') ?: '',
        'session_key' => 'admin_logged_in',
    ],
];
