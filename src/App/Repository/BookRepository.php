<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Book;
use PDO;

class BookRepository extends AbstractProductRepository
{
    public function insert(Book $book): int
    {
        $pdoStatement = $this->connection->prepare(
            'INSERT INTO books (weight) VALUES (:weight)'
        );
        $weight = $book->getWeight();
        $pdoStatement->bindParam('weight', $weight, PDO::PARAM_INT);
        $pdoStatement->execute();
        return (int) $this->connection->lastInsertId();
    }
}
