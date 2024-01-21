<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Book;
use App\Entity\AbstractProduct;

class BookCreator extends AbstractProductCreator
{
    /** @param array<string, string|int|float> $formData */
    public function create(array $formData): AbstractProduct
    {
        return new Book(
            0,
            (string) $formData['sku'],
            (string) $formData['name'],
            (float) $formData['price'],
            (string) $formData['productType'],
            (int) $formData['weight']
        );
    }
}
