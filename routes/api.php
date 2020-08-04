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

Route::post('/register', 'API\UserController@register');

Route::get('/boxes', 'API\BoxController@getList');
Route::get('/boxes/{user_id}', 'API\BoxController@getUserBoxes');
Route::post('/box/create', 'API\BoxController@create');
Route::delete('/box/{id}', 'API\BoxController@delete');

Route::get('/fruits', 'API\BoxController@getFruits');
Route::post('/fruit/apply', 'API\BoxController@makeApplication');

