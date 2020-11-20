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


Route::post('register', 'App\Http\Controllers\Api\RegisterController@register');
Route::post('login', 'App\Http\Controllers\Api\RegisterController@login');
Route::middleware('auth:api')->post('phone/verify', 'App\Http\Controllers\Api\RegisterController@verify');

/**
 * Get current user
 */
Route::middleware('auth:api')->get('/user', function () {
    return auth('api')->user();
});

/**
 * Get Settings
 */
Route::get('/settings', 'App\Http\Controllers\Api\SettingsController@get');
/**
 * Update Settings
 */
Route::middleware('can:manage-website')->post('/settings/update', 'App\Http\Controllers\Api\SettingsController@update');

/**
 * Get orders for user
 */
Route::middleware('auth:api')->get('/orders', 'App\Http\Controllers\Api\OrdersController@get');

/**
 * Get All orders
 */
Route::middleware('auth:api')->get('/orders/all', 'App\Http\Controllers\Api\OrdersController@getAll');

/**
 * Add Order
 */
Route::middleware('auth:api')->post('/orders/add', 'App\Http\Controllers\Api\OrdersController@add');

/**
 * Take Order
 */
Route::middleware('auth:api')->post('/orders/take/{id?}', 'App\Http\Controllers\Api\OrdersController@take');

/**
 * From Reached
 */
Route::middleware('auth:api')->post('/orders/fromReached/{id?}', 'App\Http\Controllers\Api\OrdersController@fromReached');

/**
 * Finished
 */
Route::middleware('auth:api')->post('/orders/finished/{id?}', 'App\Http\Controllers\Api\OrdersController@finished');

/**
 * Manadeep
 */
Route::middleware('auth:api')->post('/orders/manadeep/{id?}', 'App\Http\Controllers\Api\OrdersController@manadeep');
