<?php

declare(strict_types=1);

namespace App\Entity;

abstract class AbstractProduct
{
    protected int $id;
    protected string $sku;
    protected string $name;
    protected float $price;
    protected string $type;

    public function __construct(
        int $id,
        string $sku,
        string $name,
        float $price,
        string $type
    ) {
        $this->id = $id;
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->type = $type;
    }

    /** @return array<string, int|float|string> */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'sku' => $this->getSKU(),
            'name' => $this->getName(),
            'price' => $this->getPrice(),
            'type' => $this->getType(),
        ];
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

    public function getType(): string
    {
        return $this->type;
    }
}
