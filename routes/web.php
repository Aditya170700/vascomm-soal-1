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

$router->group(['prefix' => 'api/'], function ($router) {
    $router->post('login', 'LoginController@check');

    $router->group(['middleware' => 'auth'], function ($router) {
        $router->group(['prefix' => 'users/'], function ($router) {
            $router->get('profile', 'UserController@profile');

            $router->group(['middleware' => 'role:admin'], function ($router) {
                $router->get('/', 'UserController@index');
                $router->post('/', 'UserController@store');
                $router->put('/{id}/update', 'UserController@update');
                $router->delete('/{id}', 'UserController@destroy');
            });
        });

        $router->group(['prefix' => 'products/', 'middleware' => 'role:admin'], function ($router) {
            $router->get('/', 'ProductController@index');
            $router->post('/', 'ProductController@store');
            $router->put('/{id}/update', 'ProductController@update');
            $router->delete('/{id}', 'ProductController@destroy');
        });
    });
});
