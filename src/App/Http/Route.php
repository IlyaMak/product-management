<?php

declare(strict_types=1);

namespace App\Http;

class Route
{
    /** @var array<int, array{method: string, uri: string, controller: array<int, string>}> */
    private static array $routes = [];

    /** @param array<int, string> $controller */
    public static function get(string $uri, array $controller): Route
    {
        return self::add('GET', $uri, $controller);
    }

    /** @param array<int, string> $controller */
    public static function add(string $method, string $uri, array $controller): Route
    {
        self::$routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller
        ];

        return new self();
    }

    /** @param array<int, string> $controller */
    public static function post(string $uri, array $controller): Route
    {
        return self::add('POST', $uri, $controller);
    }

    /** @return array<int, array{method: string, uri: string, controller: array<int, string>}> */
    public static function all(): array
    {
        return self::$routes;
    }
}
