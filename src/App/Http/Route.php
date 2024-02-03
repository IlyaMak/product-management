<?php

declare(strict_types=1);

namespace App\Http;

class Route
{
    /** @var array<int, Route> */
    private static array $routes = [];
    public string $method;
    public string $uri;
    /** @var class-string */
    public string $controllerClass;
    public string $controllerMethod;

    /**
     * @param class-string $controllerClass
     */
    public function __construct(
        string $method,
        string $uri,
        string $controllerClass,
        string $controllerMethod
    ) {
        $this->method = $method;
        $this->uri = $uri;
        $this->controllerClass = $controllerClass;
        $this->controllerMethod = $controllerMethod;
    }

    /**
     * @param class-string $controllerClass
     */
    public static function get(
        string $uri,
        string $controllerClass,
        string $controllerMethod
    ): void {
        self::add('GET', $uri, $controllerClass, $controllerMethod);
    }

    /**
     * @param class-string $controllerClass
     */
    public static function add(
        string $method,
        string $uri,
        string $controllerClass,
        string $controllerMethod
    ): void {
        self::$routes[] = new Route($method, $uri, $controllerClass, $controllerMethod);
    }

    /**
     * @param class-string $controllerClass
     */
    public static function post(
        string $uri,
        string $controllerClass,
        string $controllerMethod
    ): void {
        self::add('POST', $uri, $controllerClass, $controllerMethod);
    }

    /** @return array<int, Route> */
    public static function all(): array
    {
        return self::$routes;
    }
}
