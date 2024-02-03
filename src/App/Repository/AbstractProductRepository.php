<?php

declare(strict_types=1);

namespace App\Repository;

use App\Service\DatabaseConnector;

abstract class AbstractProductRepository
{
    protected DatabaseConnector $connection;

    public function __construct(DatabaseConnector $connection)
    {
        $this->connection = $connection;
    }
}
