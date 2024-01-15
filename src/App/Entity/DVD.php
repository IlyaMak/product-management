<?php

declare(strict_types=1);

namespace App\Entity;

class DVD extends Product
{
    private int $size;

    public function __construct(
        int $id,
        string $sku,
        string $name,
        float $price,
        int $size
    ) {
        parent::__construct($id, $sku, $name, $price);
        $this->size = $size;
    }

    public function getSize(): int
    {
        return $this->size;
    }
}
