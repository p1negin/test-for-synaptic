<?php

namespace App\Classes\Router;

use App\Classes\Controllers\NotFoundController;
use App\Classes\Helpers\UrlHelper;
use mysqli;
use stdClass;

final class Router
{

    public function run(mysqli $mysqli): void
    {
        $route = $this->matchRoutes();
        $controllerClass = $route->controller;
        $controller = new $controllerClass($mysqli);
        $action = $route->action;
        $controller->$action();
    }

    private function matchRoutes(): stdClass
    {
        foreach (Route::getRoutes() as $route) {
            $uri = UrlHelper::removeGetParamsFromUri($_SERVER['REQUEST_URI']);
            if (preg_match('~^' . $route->uri . '$~', $uri)) {
                if (strtolower($_SERVER['REQUEST_METHOD']) === strtolower($route->method)) {
                    return $route;
                } else {
                    $route = new stdClass();
                    $route->method = 'GET';
                    $route->controller = NotFoundController::class;
                    $route->action = 'method';
                    return $route;
                }
            }
        }

        //return 404-page controller
        $route = new stdClass();
        $route->method = 'GET';
        $route->controller = NotFoundController::class;
        $route->action = 'index';
        return $route;
    }
}