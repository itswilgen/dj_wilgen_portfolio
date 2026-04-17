<?php

declare(strict_types=1);

use App\Core\Config;
use App\Core\View;

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function config(string $key, mixed $default = null): mixed
{
    return Config::get($key, $default);
}

function view(string $path, array $data = []): void
{
    View::partial($path, $data);
}

function old(array $oldInput, string $key, string $default = ''): string
{
    return e($oldInput[$key] ?? $default);
}

function selected(string $currentValue, string $expectedValue): string
{
    return $currentValue === $expectedValue ? 'selected' : '';
}

function checked(string $currentValue, string $expectedValue): string
{
    return $currentValue === $expectedValue ? 'checked' : '';
}
