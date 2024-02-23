<?php

declare(strict_types=1);

namespace Code;

use \Code\Exeption\RouteNotFoundExeption;

class Router
{
    private array $routes;

    public function register(string $method, string $route, array $action)
    {
        $this->routes[$method][$route] = $action;
        return $this;
    }

    public function get(string $route, array $action)
    {
        return $this->register('GET', $route, $action);
    }

    public function post(string $route, array $action)
    {
        return $this->register('POST', $route, $action);
    }

    public function resolve(string $requestUri, string $requestMethod)
    {
        $route = explode('?', $requestUri)[0];
        $action = $this->routes[$requestMethod][$route] ?? null;

        if (!$action) {
            throw new RouteNotFoundExeption();
        }

        [$class, $method] = $action;

        if (class_exists($class)) {
            $class = new $class();
        }

        if (method_exists($class, $method)) {
            return call_user_func_array([$class, $method], []);
        }


        throw new RouteNotFoundExeption();
    }
}
