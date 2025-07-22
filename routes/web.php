<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['prefix' => 'servicios'], function () use ($router) {
    $router->get('/', 'ServicioController@index');
    $router->post('/', 'ServicioController@store');
    $router->get('/{id}', 'ServicioController@show');
    $router->put('/{id}', 'ServicioController@update');
    $router->delete('/{id}', 'ServicioController@destroy');
});

$router->group(['prefix' => 'paquetes'], function () use ($router) {
    $router->get('/', 'PaqueteController@index');
    $router->post('/', 'PaqueteController@store');
    $router->get('/{id}', 'PaqueteController@show');
    $router->put('/{id}', 'PaqueteController@update');
    $router->delete('/{id}', 'PaqueteController@destroy');
});