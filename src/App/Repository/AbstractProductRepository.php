<?php

declare(strict_types=1);

namespace App\Repository;

use PDO;

abstract class AbstractProductRepository
{
    protected PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }
}
