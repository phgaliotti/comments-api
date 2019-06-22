<?php

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api/v1/comments'], function($router) {
    $router->post("/", "CommentsRestController@create");
    $router->get('/', 'CommentsRestController@list');

   
});

$router->group(['prefix' => 'api/v1/notifications'], function($router) {
    $router->get("/", "NotificationsController@list"); 
});


