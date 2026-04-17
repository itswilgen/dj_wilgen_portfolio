<?php

declare(strict_types=1);

namespace App\Core;

final class Response
{
    public static function redirect(string $location): never
    {
        header('Location: ' . $location);
        exit;
    }

    public static function json(array $payload, int $statusCode = 200): never
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($payload);
        exit;
    }

    public static function abort(int $statusCode, string $message): never
    {
        http_response_code($statusCode);
        echo $message;
        exit;
    }
}
