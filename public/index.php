<?php

declare(strict_types=1);

use App\Http\Router;

define('PROJECT_ROOT', dirname(__DIR__));

spl_autoload_register(function ($classname) {
    $classname = str_replace('\\', '/', $classname);
    require_once(PROJECT_ROOT . "/src/$classname.php");
});

require_once(PROJECT_ROOT . '/config/routes.php');

(new Router)->run();
