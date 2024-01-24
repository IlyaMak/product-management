<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\AbstractProduct;

abstract class AbstractProductCreator
{
    /** @param mixed[] $data */
    abstract public function create(array $data): AbstractProduct;
}
