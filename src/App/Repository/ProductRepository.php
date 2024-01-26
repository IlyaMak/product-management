<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\AbstractProduct;
use PDO;

class ProductRepository extends AbstractProductRepository
{
    public function insert(AbstractProduct $product, int $childId): int
    {
        $pdoStatement = $this->connection->prepare(
            'INSERT INTO products (sku, name, price, type, child_id)
                VALUES (:sku, :name, :price, :type, :childId)'
        );
        $sku = $product->getSKU();
        $name = $product->getName();
        $price = $product->getPrice();
        $type = $product->getType();
        $pdoStatement->bindParam('sku', $sku);
        $pdoStatement->bindParam('name', $name);
        $pdoStatement->bindParam('price', $price);
        $pdoStatement->bindParam('type', $type);
        $pdoStatement->bindParam('childId', $childId, PDO::PARAM_INT);
        $pdoStatement->execute();
        return (int) $this->connection->lastInsertId();
    }

    public function findBySku(AbstractProduct $product): int
    {
        $pdoStatement = $this->connection->prepare(
            'SELECT COUNT(*) FROM products WHERE sku = :sku'
        );
        $sku = $product->getSKU();
        $pdoStatement->bindParam('sku', $sku);
        $pdoStatement->execute();
        return (int) $pdoStatement->fetchColumn();
    }

    /** @param array<int, string> $ids */
    public function delete(array $ids): void
    {
        $in = str_repeat('?,', count($ids) - 1) . '?';
        $pdoStatement = $this->connection->prepare(
            "DELETE FROM products WHERE id IN ($in)"
        );
        $pdoStatement->execute($ids);
    }
}
