<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Furniture;
use App\Entity\AbstractProduct;

class FurnitureCreator extends AbstractProductCreator
{
    /**
     * @param array{
     *   id: ?int,
     *   sku: string,
     *   name: string,
     *   price: float,
     *   type: string,
     *   height: int,
     *   width: int,
     *   length: int
     * } $data
     */
    public function create(array $data): AbstractProduct
    {
        return new Furniture(
            (int) ($data['id'] ?? 0),
            (string) $data['sku'],
            (string) $data['name'],
            (float) $data['price'],
            (string) $data['type'],
            (int) $data['height'],
            (int) $data['width'],
            (int) $data['length']
        );
    }
}
