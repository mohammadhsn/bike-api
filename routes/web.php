<?php


use Laravel\Lumen\Routing\Router;

/* @var Router $router */

$router->post('officers', 'OfficerController@store');

$router->delete('officers/{id}', 'OfficerController@destroy');

$router->get('bikes/{id}', 'BikeController@show');

$router->patch('bikes/{id}', 'BikeController@resolve');

$router->get('bikes', 'BikeController@index');

$router->post('bikes', 'BikeController@store');
