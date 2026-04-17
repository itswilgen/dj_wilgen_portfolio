<?php

declare(strict_types=1);

namespace App\Core;

use RuntimeException;

final class View
{
    public static function render(string $path, array $data = []): void
    {
        $viewPath = self::path($path);

        if (!is_file($viewPath)) {
            throw new RuntimeException('View not found: ' . $path);
        }

        extract($data, EXTR_SKIP);
        require $viewPath;
    }

    public static function partial(string $path, array $data = []): void
    {
        self::render($path, $data);
    }

    private static function path(string $path): string
    {
        return dirname(__DIR__) . '/Views/' . str_replace('.', '/', $path) . '.php';
    }
}
