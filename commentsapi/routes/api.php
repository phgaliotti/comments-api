<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('API')->name('.api')->group(function() {
    Route::prefix('/comments')->group(function(){
        Route::post('/', 'CommentsRestController@create')->name('create_comment');
        Route::get('/', 'CommentsRestController@index')->name('index_products');
    
    }); 
});
