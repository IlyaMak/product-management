<?php

declare(strict_types=1);

namespace App\Http;

use Exception;

class Router
{
    public function run(): void
    {
        $currentRoute = $this->findRoute();
        $this->dispatch($currentRoute);
    }

    /** @return ?array{method: string, uri: string, controller: array<int, string>} */
    private function findRoute(): ?array
    {
        foreach (Route::all() as $route) {
            if ($_SERVER['REQUEST_METHOD'] === $route['method'] && $this->isUriMatched($route)) {
                return $route;
            }
        }
        return null;
    }

    /** @param array{method: string, uri: string, controller: array<int, string>} $route */
    private function isUriMatched(array $route): bool
    {
        $pattern = '/^' . ((string) str_replace('/', '\/', $route['uri'])) . '$/';
        $result = preg_match($pattern, $_SERVER['REQUEST_URI']);
        return (bool) $result;
    }

    /** @param array{method: string, uri: string, controller: array<int, string>} $route */
    private function dispatch(?array $route): void
    {
        $action = $route['controller'] ?? null;

        if (is_null($action)) {
            return;
        }

        if (is_array($action)) {
            $class = $action[0];

            if (!class_exists($class)) {
                throw new Exception("Controller $class not exists");
            }

            $method = $action[1];

            if (!method_exists($class, $method)) {
                throw new Exception("Method $method, in controller $class not found");
            }

            $controller = new $class();
            $controller->$method();
        }
    }
}
