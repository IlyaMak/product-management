<?php

declare(strict_types=1);

use App\Service\DatabaseConnector;

define('PROJECT_ROOT', dirname(__DIR__));

require_once(PROJECT_ROOT . '/vendor/autoload.php');

class Version20240116135800
{
    public static function up(): void
    {
        $connection = DatabaseConnector::getDatabaseConnection();
        $connection->query(
            'CREATE TABLE products (
                id BIGINT NOT NULL AUTO_INCREMENT,
                sku VARCHAR(255) NOT NULL UNIQUE,
                name VARCHAR(255) NOT NULL,
                price FLOAT NOT NULL,
                type ENUM("book","dvd","furniture") NOT NULL, 
                child_id BIGINT NOT NULL,
                PRIMARY KEY (id)
            );
            CREATE TABLE books (
                id BIGINT NOT NULL AUTO_INCREMENT,
                weight INT NOT NULL,
                PRIMARY KEY (id)
            );
            CREATE TABLE dvds (
                id BIGINT NOT NULL AUTO_INCREMENT,
                size INT NOT NULL,
                PRIMARY KEY (id)
            );
            CREATE TABLE furniture (
                id BIGINT NOT NULL AUTO_INCREMENT,
                height INT NOT NULL,
                width INT NOT NULL,
                length INT NOT NULL,
                PRIMARY KEY (id)
            );'
        );
    }
}

Version20240116135800::up();
