<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::post('post/get', 'PostController@getPosts');
Route::get('post/getBySlug/{slug}', 'PostController@getBySlug');
Route::get('post/get/{id}', 'PostController@get');

Route::get('post/delete/{id}', 'PostController@remove');

Route::post('post/store', 'PostController@store');