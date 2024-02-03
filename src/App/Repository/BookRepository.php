<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Book;
use PDO;

class BookRepository extends AbstractProductRepository
{
    public function insert(Book $book): int
    {
        $pdoStatement = $this->connection->getConnection()->prepare(
            'INSERT INTO books (weight) VALUES (:weight)'
        );
        $weight = $book->getWeight();
        $pdoStatement->bindParam('weight', $weight, PDO::PARAM_INT);
        $pdoStatement->execute();
        return (int) $this->connection->getConnection()->lastInsertId();
    }

    /**
     * @return array{
     *    id: int,
     *    sku: string,
     *    name: string,
     *    price: float,
     *    type: string,
     *    weight: int
     * }[]
     */
    public function findAll(): array
    {
        $pdoStatement = $this->connection->getConnection()->query(
            'SELECT p.id, p.sku, p.name, p.price, p.type, b.weight FROM books b
                LEFT JOIN products p ON p.child_id = b.id AND p.type = "book"'
        );
        $result = is_bool($pdoStatement) ? [] : $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
        return is_array($result) ? $result : [];
    }

    /** @param array<int, string> $ids */
    public function delete(array $ids): void
    {
        $in = str_repeat('?,', count($ids) - 1) . '?';
        $pdoStatement = $this->connection->getConnection()->prepare(
            "DELETE FROM books WHERE id IN 
                (SELECT child_id FROM products WHERE type = 'book' AND id IN ($in))"
        );
        $pdoStatement->execute($ids);
    }
}
