<?php

declare(strict_types=1);

namespace App\Controller;

class HomeController
{
    public function index(): void
    {
        require_once(PROJECT_ROOT . '/public/index.html');
    }
}
