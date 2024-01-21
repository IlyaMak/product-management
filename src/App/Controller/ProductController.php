<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Dvd;
use App\Entity\Furniture;
use App\Factory\BookCreator;
use App\Factory\DvdCreator;
use App\Factory\FurnitureCreator;
use App\Repository\BookRepository;
use App\Repository\FurnitureRepository;
use App\Repository\DvdRepository;
use App\Repository\ProductRepository;
use App\Service\DatabaseConnector;
use Throwable;

class ProductController
{
    public function index(): void
    {
        header('Content-Type: application/json');
        echo json_encode([
            ['name' => 'Tom'],
            ['name' => 'Rob'],
            ['name' => 'Sam']
        ]);
    }

    public function add(): void
    {
        $productType = $_POST['productType'];
        $productCreators = [
            'dvd' => DvdCreator::class,
            'furniture' => FurnitureCreator::class,
            'book' => BookCreator::class
        ];
        $productRepositories = [
            Dvd::class => DvdRepository::class,
            Furniture::class => FurnitureRepository::class,
            Book::class => BookRepository::class
        ];
        $productCreator = new $productCreators[$productType]();
        /** @var Book|Dvd|Furniture $product */
        $product = $productCreator->create($_POST);
        $connection = DatabaseConnector::getDatabaseConnection();
        $concreteProductRepository = new $productRepositories[get_class($product)]($connection);
        try {
            $connection->beginTransaction();
            $concreteProductId = $concreteProductRepository->insert($product);
            $productRepository = new ProductRepository($connection);
            $productRepository->insert($product, $concreteProductId);
            $connection->commit();
        } catch (Throwable $e) {
            $connection->rollBack();
        }
    }
}
