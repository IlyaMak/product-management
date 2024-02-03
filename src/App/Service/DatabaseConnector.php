<?php

declare(strict_types=1);

namespace App\Service;

use PDO;
use PDOException;

class DatabaseConnector
{
    private PDO $connection;

    public function __construct()
    {
        try {
            $this->connection = new PDO(
                "mysql:host={$_ENV['DATABASE_SERVER_NAME']};dbname={$_ENV['DATABASE_NAME']};charset=utf8mb4",
                $_ENV['DATABASE_USER'],
                $_ENV['DATABASE_PASSWORD'],
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            echo "Connection failed: {$e->getMessage()}";
            throw $e;
        }
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
