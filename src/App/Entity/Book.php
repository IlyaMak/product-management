<?php

declare(strict_types=1);

namespace App\Entity;

class Book extends Product
{
    private int $weight;

    public function __construct(
        int $id,
        string $sku,
        string $name,
        float $price,
        int $weight
    ) {
        parent::__construct($id, $sku, $name, $price);
        $this->weight = $weight;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }
}
