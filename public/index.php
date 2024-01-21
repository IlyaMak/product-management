<?php

declare(strict_types=1);

use App\Http\Router;

require_once(dirname(__DIR__) . '/config/constants.php');

require_once(PROJECT_ROOT . '/vendor/autoload.php');
require_once(PROJECT_ROOT . '/config/routes.php');

if (isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] === 'dev') {
    header('Access-Control-Allow-Origin: *');
}

(new Router)->run();
