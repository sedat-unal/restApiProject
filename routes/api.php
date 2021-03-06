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
Route::get('list-users', 'App\Http\Controllers\API\UserController@details');
Route::post('register', 'App\Http\Controllers\API\UserController@post_Register');
Route::post('login', 'App\Http\Controllers\API\UserController@post_Login');
Route::post('reset-password', 'App\Http\Controllers\API\UserController@post_ResetPassword');

Route::post('add-category', 'App\Http\Controllers\API\CategoryController@createCategory');
Route::get('list-category', 'App\Http\Controllers\API\CategoryController@listCategory');

Route::post('add-subcategory', 'App\Http\Controllers\API\CategoryController@createSubcategory');
Route::get('list-subcategory', 'App\Http\Controllers\API\CategoryController@listSubcategory');
