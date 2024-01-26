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

    /**
     * @return array{
     *    id: int,
     *    sku: string,
     *    name: string,
     *    price: float,
     *    type: string,
     *    height: int,
     *    width: int,
     *    length: int
     * }[]
     */
    public function findAll(): array
    {
        $pdoStatement = $this->connection->query(
            'SELECT p.id, p.sku, p.name, p.price, p.type, f.height, f.width, f.length FROM furniture f
                LEFT JOIN products p ON p.child_id = f.id AND p.type = "furniture"'
        );
        $result = is_bool($pdoStatement) ? [] : $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
        return is_array($result) ? $result : [];
    }

    /** @param array<int, string> $ids */
    public function delete(array $ids): void
    {
        $in = str_repeat('?,', count($ids) - 1) . '?';
        $pdoStatement = $this->connection->prepare(
            "DELETE FROM furniture WHERE id IN 
        (SELECT child_id FROM products WHERE type = 'furniture' AND id IN ($in))"
        );
        $pdoStatement->execute($ids);
    }
}
