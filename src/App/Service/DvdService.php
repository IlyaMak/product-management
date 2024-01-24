<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\AbstractProduct;
use App\Factory\DvdCreator;
use App\Repository\DvdRepository;
use PDO;

class DvdService
{
    public static PDO $connection;

    public function __construct(PDO $connection)
    {
        self::$connection = $connection;
    }

    /** @return AbstractProduct[] */
    public static function findAll(): array
    {
        $dvdRepository = new DvdRepository(self::$connection);
        $dvds = $dvdRepository->findAll();
        $dvdCreator = new DvdCreator();
        return array_map(
            function ($element) use ($dvdCreator) {
                return $dvdCreator->create($element);
            },
            $dvds
        );
    }
}
