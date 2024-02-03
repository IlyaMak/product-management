<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\AbstractProduct;
use App\Entity\Book;
use App\Factory\BookCreator;
use App\Repository\BookRepository;

class BookService
{
    public BookRepository $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /** @return AbstractProduct[] */
    public function findAll(): array
    {
        $books = $this->bookRepository->findAll();
        $bookCreator = new BookCreator();
        return array_map(
            function ($element) use ($bookCreator) {
                return $bookCreator->create($element);
            },
            $books
        );
    }

    /** @param array<int, string> $productIds */
    public function delete(array $productIds): void
    {
        $this->bookRepository->delete($productIds);
    }

    public function insert(Book $book): int
    {
        return $this->bookRepository->insert($book);
    }
}
