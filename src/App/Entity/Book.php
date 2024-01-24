<?php

declare(strict_types=1);

namespace App\Entity;

class Book extends AbstractProduct
{
    private int $weight;

    public function __construct(
        int $id,
        string $sku,
        string $name,
        float $price,
        string $type,
        int $weight
    ) {
        parent::__construct($id, $sku, $name, $price, $type);
        $this->weight = $weight;
    }

    /** @return array<string, int|float|string> */
    public function toArray(): array
    {
        $array = parent::toArray();
        $array['weight'] = $this->getWeight();
        return $array;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }
}
