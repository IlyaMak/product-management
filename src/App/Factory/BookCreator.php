<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Book;
use App\Entity\AbstractProduct;

class BookCreator extends AbstractProductCreator
{
    /**
     * @param array{
     *   id: ?int,
     *   sku: string,
     *   name: string,
     *   price: float,
     *   type: string,
     *   weight: int
     * } $data
     */
    public function create(array $data): AbstractProduct
    {
        return new Book(
            (int) ($data['id'] ?? 0),
            (string) $data['sku'],
            (string) $data['name'],
            (float) $data['price'],
            (string) $data['type'],
            (int) $data['weight']
        );
    }
}
