<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Dvd;
use PDO;

class DvdRepository extends AbstractProductRepository
{
    public function insert(Dvd $dvd): int
    {
        $pdoStatement = $this->connection->prepare(
            'INSERT INTO dvds (size) VALUES (:size)'
        );
        $size = $dvd->getSize();
        $pdoStatement->bindParam('size', $size, PDO::PARAM_INT);
        $pdoStatement->execute();
        return (int) $this->connection->lastInsertId();
    }
}
