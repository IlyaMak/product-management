<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\AbstractProduct;
use App\Entity\Furniture;
use App\Factory\FurnitureCreator;
use App\Repository\FurnitureRepository;

class FurnitureService
{
    public FurnitureRepository $furnitureRepository;

    public function __construct(FurnitureRepository $furnitureRepository)
    {
        $this->furnitureRepository = $furnitureRepository;
    }

    /** @return AbstractProduct[] */
    public function findAll(): array
    {
        $furniture = $this->furnitureRepository->findAll();
        $furnitureCreator = new FurnitureCreator();
        return array_map(
            function ($element) use ($furnitureCreator) {
                return $furnitureCreator->create($element);
            },
            $furniture
        );
    }

    /** @param array<int, string> $productIds */
    public function delete(array $productIds): void
    {
        $this->furnitureRepository->delete($productIds);
    }

    public function insert(Furniture $furniture): int
    {
        return $this->furnitureRepository->insert($furniture);
    }
}
