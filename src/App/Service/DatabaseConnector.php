<?php

declare(strict_types=1);

namespace App\Service;

use PDO;
use PDOException;

class DatabaseConnector
{
    private static ?PDO $connection = null;

    private function __construct()
    {
    }

    public static function getDatabaseConnection(): PDO
    {
        if (self::$connection === null) {
            try {
                self::$connection = new PDO(
                    "mysql:host={$_ENV['DATABASE_SERVER_NAME']};dbname={$_ENV['DATABASE_NAME']};charset=utf8mb4",
                    $_ENV['DATABASE_USER'],
                    $_ENV['DATABASE_PASSWORD'],
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
            } catch (PDOException $e) {
                echo "Connection failed: {$e->getMessage()}";
            }
        }
        return self::$connection;
    }
}
