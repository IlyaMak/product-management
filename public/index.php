<?php

declare(strict_types=1);

use App\Http\Router;

define('PROJECT_ROOT', dirname(__DIR__));

require_once(PROJECT_ROOT . '/vendor/autoload.php');
require_once(PROJECT_ROOT . '/config/routes.php');

(new Router)->run();
