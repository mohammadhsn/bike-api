<?php


use Laravel\Lumen\Routing\Router;

/* @var Router $router */

$router->get('/', function () use ($router) {
    return response()->json(['version' => $router->app->version()]);
});
