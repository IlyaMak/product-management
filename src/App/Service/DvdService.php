<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\AbstractProduct;
use App\Entity\Dvd;
use App\Factory\DvdCreator;
use App\Repository\DvdRepository;

class DvdService
{
    public DvdRepository $dvdRepository;

    public function __construct(DvdRepository $dvdRepository)
    {
        $this->dvdRepository = $dvdRepository;
    }

    /** @return AbstractProduct[] */
    public function findAll(): array
    {
        $dvds = $this->dvdRepository->findAll();
        $dvdCreator = new DvdCreator();
        return array_map(
            function ($element) use ($dvdCreator) {
                return $dvdCreator->create($element);
            },
            $dvds
        );
    }

    /** @param array<int, string> $productIds */
    public function delete(array $productIds): void
    {
        $this->dvdRepository->delete($productIds);
    }

    public function insert(Dvd $dvd): int
    {
        return $this->dvdRepository->insert($dvd);
    }
}
