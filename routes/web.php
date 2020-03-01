<?php


use Laravel\Lumen\Routing\Router;

/* @var Router $router */

$router->get('/', function () use ($router) {
    return response()->json(['version' => $router->app->version()]);
});

$router->post('officers', 'OfficerController@store');
$router->delete('officers/{id}', 'OfficerController@destroy');

$router->get('bikes', 'BikeController@index');
$router->post('bikes', 'BikeController@store');
