<?php

declare(strict_types=1);

namespace Code;

use Code\Attributes\Route;
use \Code\Exeption\RouteNotFoundExeption;
use Illuminate\Container\Container;

class Router
{
    public function __construct(private Container $container)
    {
        
    }
    private array $routes;

    public function register(string $method, string $route, array $action)
    {
        $this->routes[$method][$route] = $action;
        return $this;
    }

    public function registerRoutesFromAttributes(array $controllers)
    {
        foreach($controllers as $controller){
            $reflectionController = new \ReflectionClass($controller);

            foreach($reflectionController->getMethods() as $method){
                $attributes = $method->getAttributes(Route::class, \ReflectionAttribute::IS_INSTANCEOF);

                foreach($attributes as $attribute){
                    $route = $attribute->newInstance();

                    $this->register($route->method->value, $route->routePath, [$controller, $method->getName()]);
                }
            }
        }
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
            $class = $this->container->get($class);
        }

        if (method_exists($class, $method)) {
            return call_user_func_array([$class, $method], []);
        }


        throw new RouteNotFoundExeption();
    }
}
