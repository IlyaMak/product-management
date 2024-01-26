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

    /**
     * @return array{
     *    id: int,
     *    sku: string,
     *    name: string,
     *    price: float,
     *    type: string,
     *    size: int
     * }[]
     */
    public function findAll(): array
    {
        $pdoStatement = $this->connection->query(
            'SELECT p.id, p.sku, p.name, p.price, p.type, d.size FROM dvds d
                LEFT JOIN products p ON p.child_id = d.id AND p.type = "dvd"'
        );
        $result = is_bool($pdoStatement) ? [] : $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
        return is_array($result) ? $result : [];
    }

    /** @param array<int, string> $ids */
    public function delete(array $ids): void
    {
        $in = str_repeat('?,', count($ids) - 1) . '?';
        $pdoStatement = $this->connection->prepare(
            "DELETE FROM dvds WHERE id IN 
        (SELECT child_id FROM products WHERE type = 'dvd' AND id IN ($in))"
        );
        $pdoStatement->execute($ids);
    }
}
