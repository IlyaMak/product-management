<?php

declare(strict_types=1);

namespace App\Entity;

abstract class Product
{
    protected int $id;
    protected string $sku;
    protected string $name;
    protected float $price;

    public function __construct(
        int $id,
        string $sku,
        string $name,
        float $price
    ) {
        $this->id = $id;
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getSKU(): string
    {
        return $this->sku;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}
