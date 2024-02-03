<?php

declare(strict_types=1);

namespace App\Http;

use ReflectionClass;

class Router
{
    public function run(): void
    {
        $currentRoute = $this->findRoute();
        if ($currentRoute === null) {
            http_response_code(404);
            return;
        }
        $cache = [];
        $controller = $this->resolveDependencies($currentRoute->controllerClass, $cache);
        $controller->{$currentRoute->controllerMethod}();
    }

    private function findRoute(): ?Route
    {
        foreach (Route::all() as $route) {
            if (
                in_array($_SERVER['REQUEST_METHOD'], [$route->method, 'OPTIONS'], true)
                && $this->isUriMatched($route->uri)
            ) {
                return $route;
            }
        }
        return null;
    }

    private function isUriMatched(string $uri): bool
    {
        $pattern = '/^' . ((string) str_replace('/', '\/', $uri)) . '$/';
        $result = preg_match($pattern, $_SERVER['REQUEST_URI']);
        return (bool) $result;
    }

    /**
     * @param class-string $className
     * @param array<string, object> $cache
     */
    private function resolveDependencies(string $className, array $cache): object
    {
        $reflection = new ReflectionClass($className);
        $constructor = $reflection->getConstructor();
        $dependencies = [];

        if ($constructor) {
            foreach ($constructor->getParameters() as $parameter) {
                /**
                 * @var ReflectionClass $dependency
                 * @phpstan-ignore-next-line
                 */
                $dependency = $parameter->getClass();

                if (!isset($cache[$dependency->getName()])) {
                    $cache[$dependency->getName()] = $this->resolveDependencies($dependency->getName(), $cache);
                }
                $dependencies[] = $cache[$dependency->getName()];
            }
        }
        return $reflection->newInstanceArgs($dependencies);
    }
}
