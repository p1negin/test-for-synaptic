<?php

namespace App\Classes\Router;

use stdClass;

abstract class Route
{
    private static array $routes = [];

    //todo:: add other methods (HEAD, PUT, DELETE and other)
    public static function get(string $uri, string $controller, string $action = 'index'): void
    {
        self::addRoute('GET', $uri, $controller, $action);
    }

    public static function post(string $uri, string $controller, string $action = 'index'): void
    {
        self::addRoute('POST', $uri, $controller, $action);
    }

    private static function addRoute(string $method, string $uri, string $controller, string $action = 'index'): void
    {
        $route = new stdClass();
        $route->method = $method;
        $route->uri = $uri;
        $route->controller = $controller;
        $route->action = $action;
        self::$routes[] = $route;
    }

    public static function getRoutes(): array
    {
        return self::$routes;
    }
}