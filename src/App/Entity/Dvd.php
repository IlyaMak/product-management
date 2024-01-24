<?php

declare(strict_types=1);

namespace App\Entity;

class Dvd extends AbstractProduct
{
    private int $size;

    public function __construct(
        int $id,
        string $sku,
        string $name,
        float $price,
        string $type,
        int $size
    ) {
        parent::__construct($id, $sku, $name, $price, $type);
        $this->size = $size;
    }

    /** @return array<string, int|float|string> */
    public function toArray(): array
    {
        $array = parent::toArray();
        $array['size'] = $this->getSize();
        return $array;
    }

    public function getSize(): int
    {
        return $this->size;
    }
}
