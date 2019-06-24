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
    $router->get('/', 'CommentsRestController@list');
    $router->post("/", "CommentsRestController@create");
});

$router->group(['prefix' => 'api/v1/users'], function($router) {
    $router->get("/{userid}/comments", "CommentsRestController@getByUserId"); 
    $router->get("/{id}/notifications", "NotificationsRestController@getByUserId"); 
    $router->delete("/{userid}/coments/{id}", "CommentsRestController@delete");
    $router->delete('/{owenerpostingid}/posting/{postid}/users/{userid}/comments', 'CommentsRestController@deleteUserComments');
});