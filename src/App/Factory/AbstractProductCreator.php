<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\AbstractProduct;

abstract class AbstractProductCreator
{
    /** @param array<string, string|int|float> $formData */
    abstract public function create(array $formData): AbstractProduct;
}
