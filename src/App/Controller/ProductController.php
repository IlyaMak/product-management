<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\AbstractProduct;
use App\Entity\Book;
use App\Entity\Dvd;
use App\Entity\Furniture;
use App\Factory\AbstractProductCreator;
use App\Factory\BookCreator;
use App\Factory\DvdCreator;
use App\Factory\FurnitureCreator;
use App\Repository\BookRepository;
use App\Repository\FurnitureRepository;
use App\Repository\DvdRepository;
use App\Repository\ProductRepository;
use App\Service\BookService;
use App\Service\DatabaseConnector;
use App\Service\DvdService;
use App\Service\FurnitureService;
use Throwable;

class ProductController
{
    public function index(): void
    {
        $connection = DatabaseConnector::getDatabaseConnection();
        $bookService = new BookService($connection);
        $dvdService = new DvdService($connection);
        $furnitureService = new FurnitureService($connection);
        $products = array_merge(
            $bookService->findAll(),
            $dvdService->findAll(),
            $furnitureService->findAll()
        );

        usort(
            $products,
            function (AbstractProduct $a, AbstractProduct $b) {
                return $a->getId() <=> $b->getId();
            }
        );
        $products = array_map(
            function (AbstractProduct $element) {
                return $element->toArray();
            },
            $products
        );

        header('Content-Type: application/json');
        echo json_encode($products);
    }

    public function add(): void
    {
        $productType = $_POST['type'];
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
        /**
         * @var AbstractProductCreator $productCreator
         */
        $productCreator = new $productCreators[$productType]();
        /**
         * @var Book|Dvd|Furniture $product
         */
        $product = $productCreator->create($_POST);
        $connection = DatabaseConnector::getDatabaseConnection();
        $concreteProductRepository = new $productRepositories[get_class($product)]($connection);
        $productRepository = new ProductRepository($connection);

        header('Content-Type: application/json');
        $httpCode = 200;
        $response = ['message' => ''];

        if ($productRepository->findBySku($product)) {
            $httpCode = 400;
            $response['message'] = 'Product with the same SKU exists. SKU should be unique for each product';
            http_response_code($httpCode);
            echo json_encode($response);
            return;
        }

        try {
            $connection->beginTransaction();
            $concreteProductId = $concreteProductRepository->insert($product);
            $productRepository->insert($product, $concreteProductId);
            $connection->commit();
        } catch (Throwable $e) {
            $connection->rollBack();
        }
        http_response_code($httpCode);
        echo json_encode($response);
    }
}
