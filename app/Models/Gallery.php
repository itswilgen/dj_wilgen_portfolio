<?php

declare(strict_types=1);

namespace App\Models;

use finfo;

final class Gallery
{
    private string $directory;

    public function __construct(?string $directory = null)
    {
        $this->directory = $directory ?: dirname(__DIR__, 2) . '/gallery_images';
    }

    public function all(): array
    {
        $images = glob($this->directory . '/*.{png,jpg,jpeg,JPG,PNG,JPEG,GIF,gif}', GLOB_BRACE) ?: [];
        rsort($images);

        return array_map(function (string $imagePath): array {
            $relativePath = 'gallery_images/' . basename($imagePath);
            $filename = pathinfo($imagePath, PATHINFO_FILENAME);
            $cleanName = str_replace(['_', '-'], ' ', $filename);

            return [
                'path' => $relativePath,
                'name' => trim($cleanName),
            ];
        }, $images);
    }

    public function upload(array $file): string
    {
        if (getenv('VERCEL')) {
            return 'vercel_storage_required';
        }

        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return 'error';
        }

        if (($file['size'] ?? 0) > 2 * 1024 * 1024) {
            return 'toolarge';
        }

        $tmpName = $file['tmp_name'] ?? '';

        if (!is_uploaded_file($tmpName)) {
            return 'error';
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($tmpName);
        $allowedTypes = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
        ];

        if (!array_key_exists($mimeType, $allowedTypes)) {
            return 'invalidtype';
        }

        if (!is_dir($this->directory)) {
            mkdir($this->directory, 0775, true);
        }

        $filename = uniqid('gallery_', true) . '.' . $allowedTypes[$mimeType];
        $destination = $this->directory . '/' . $filename;

        if (!move_uploaded_file($tmpName, $destination)) {
            return 'error';
        }

        return 'success';
    }
}
