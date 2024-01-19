<?php

declare(strict_types=1);

namespace App\Controller;

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
        echo $_POST['name'];
    }
}
