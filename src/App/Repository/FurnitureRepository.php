<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Furniture;
use PDO;

class FurnitureRepository extends AbstractProductRepository
{
    public function insert(Furniture $furniture): int
    {
        $pdoStatement = $this->connection->prepare(
            'INSERT INTO furniture (height, width, length) 
                VALUES (:height, :width, :length)'
        );
        $height = $furniture->getHeight();
        $width = $furniture->getWidth();
        $length = $furniture->getLength();
        $pdoStatement->bindParam('height', $height, PDO::PARAM_INT);
        $pdoStatement->bindParam('width', $width, PDO::PARAM_INT);
        $pdoStatement->bindParam('length', $length, PDO::PARAM_INT);
        $pdoStatement->execute();
        return (int) $this->connection->lastInsertId();
    }
}
