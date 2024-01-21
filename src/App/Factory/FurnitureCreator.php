<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Furniture;
use App\Entity\AbstractProduct;

class FurnitureCreator extends AbstractProductCreator
{
    /** @param array<string, string|int|float> $formData */
    public function create(array $formData): AbstractProduct
    {
        return new Furniture(
            0,
            (string) $formData['sku'],
            (string) $formData['name'],
            (float) $formData['price'],
            (string) $formData['productType'],
            (int) $formData['height'],
            (int) $formData['width'],
            (int) $formData['length']
        );
    }
}
