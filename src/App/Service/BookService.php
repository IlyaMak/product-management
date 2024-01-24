<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\AbstractProduct;
use App\Factory\BookCreator;
use App\Repository\BookRepository;
use PDO;

class BookService
{
    public static PDO $connection;

    public function __construct(PDO $connection)
    {
        self::$connection = $connection;
    }

    /** @return AbstractProduct[] */
    public static function findAll(): array
    {
        $bookRepository = new BookRepository(self::$connection);
        $books = $bookRepository->findAll();
        $bookCreator = new BookCreator();
        return array_map(
            function ($element) use ($bookCreator) {
                return $bookCreator->create($element);
            },
            $books
        );
    }
}
