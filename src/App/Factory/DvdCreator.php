<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Dvd;
use App\Entity\AbstractProduct;

class DvdCreator extends AbstractProductCreator
{
    /**
     * @param array{
     *   id: ?int,
     *   sku: string,
     *   name: string,
     *   price: float,
     *   type: string,
     *   size: int
     * } $data
     */
    public function create(array $data): AbstractProduct
    {
        return new Dvd(
            (int) ($data['id'] ?? 0),
            (string) $data['sku'],
            (string) $data['name'],
            (float) $data['price'],
            (string) $data['type'],
            (int) $data['size']
        );
    }
}
