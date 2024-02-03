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
use App\Repository\ProductRepository;
use App\Service\BookService;
use App\Service\DatabaseConnector;
use App\Service\DvdService;
use App\Service\FurnitureService;
use Throwable;

class ProductController
{
    private DatabaseConnector $connection;
    private BookService $bookService;
    private DvdService $dvdService;
    private FurnitureService $furnitureService;
    private ProductRepository $productRepository;

    public function __construct(
        DatabaseConnector $connection,
        BookService $bookService,
        DvdService $dvdService,
        FurnitureService $furnitureService,
        ProductRepository $productRepository
    ) {
        $this->connection = $connection;
        $this->bookService = $bookService;
        $this->dvdService = $dvdService;
        $this->furnitureService = $furnitureService;
        $this->productRepository = $productRepository;
    }

    public function index(): void
    {
        $products = array_merge(
            $this->bookService->findAll(),
            $this->dvdService->findAll(),
            $this->furnitureService->findAll()
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
        /**
         * @var AbstractProductCreator $productCreator
         */
        $productCreator = new $productCreators[$productType]();
        /**
         * @var Book|Dvd|Furniture $product
         */
        $product = $productCreator->create($_POST);

        header('Content-Type: application/json');
        $httpCode = 200;
        $response = ['message' => ''];

        if ($this->productRepository->findBySku($product)) {
            $httpCode = 400;
            $response['message'] = 'Product with the same SKU exists. SKU should be unique for each product';
            http_response_code($httpCode);
            echo json_encode($response);
            return;
        }

        $productServices = [
            Dvd::class => $this->dvdService,
            Furniture::class => $this->furnitureService,
            Book::class => $this->bookService
        ];
        $concreteProductService = $productServices[get_class($product)];

        try {
            $this->connection->getConnection()->beginTransaction();
            $concreteProductId = $concreteProductService->insert($product);
            $this->productRepository->insert($product, $concreteProductId);
            $this->connection->getConnection()->commit();
        } catch (Throwable $e) {
            $this->connection->getConnection()->rollBack();
        }
        http_response_code($httpCode);
        echo json_encode($response);
    }

    public function delete(): void
    {
        /** @var array<int, string> $productIds */
        $productIds = json_decode((string) file_get_contents('php://input'));
        try {
            $this->connection->getConnection()->beginTransaction();
            $this->bookService->delete($productIds);
            $this->dvdService->delete($productIds);
            $this->furnitureService->delete($productIds);
            $this->productRepository->delete($productIds);
            $this->connection->getConnection()->commit();
        } catch (Throwable $e) {
            $this->connection->getConnection()->rollBack();
        }
    }
}
