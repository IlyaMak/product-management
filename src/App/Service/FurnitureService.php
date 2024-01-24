<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\AbstractProduct;
use App\Factory\FurnitureCreator;
use App\Repository\FurnitureRepository;
use PDO;

class FurnitureService
{
    public static PDO $connection;

    public function __construct(PDO $connection)
    {
        self::$connection = $connection;
    }

    /** @return AbstractProduct[] */
    public static function findAll(): array
    {
        $furnitureRepository = new FurnitureRepository(self::$connection);
        $furniture = $furnitureRepository->findAll();
        $furnitureCreator = new FurnitureCreator();
        return array_map(
            function ($element) use ($furnitureCreator) {
                return $furnitureCreator->create($element);
            },
            $furniture
        );
    }
}
