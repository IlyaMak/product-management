<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Dvd;
use App\Entity\AbstractProduct;

class DvdCreator extends AbstractProductCreator
{
    /** @param array<string, string|int|float> $formData */
    public function create(array $formData): AbstractProduct
    {
        return new Dvd(
            0,
            (string) $formData['sku'],
            (string) $formData['name'],
            (float) $formData['price'],
            (string) $formData['productType'],
            (int) $formData['size']
        );
    }
}
