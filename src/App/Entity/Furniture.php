<?php

declare(strict_types=1);

namespace App\Entity;

class Furniture extends Product
{
    private int $height;
    private int $width;
    private int $length;

    public function __construct(
        int $id,
        string $sku,
        string $name,
        float $price,
        int $height,
        int $width,
        int $length
    ) {
        parent::__construct($id, $sku, $name, $price);
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getLength(): int
    {
        return $this->length;
    }
}
