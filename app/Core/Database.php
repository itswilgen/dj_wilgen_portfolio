<?php

declare(strict_types=1);

namespace App\Core;

use mysqli;
use RuntimeException;

final class Database
{
    private static ?mysqli $connection = null;

    public static function connection(): mysqli
    {
        if (self::$connection instanceof mysqli) {
            return self::$connection;
        }

        $connection = new mysqli(
            (string) Config::get('db.host'),
            (string) Config::get('db.username'),
            (string) Config::get('db.password'),
            (string) Config::get('db.database')
        );

        if ($connection->connect_error) {
            throw new RuntimeException('Database connection failed: ' . $connection->connect_error);
        }

        $connection->set_charset('utf8mb4');

        self::$connection = $connection;

        return self::$connection;
    }
}
