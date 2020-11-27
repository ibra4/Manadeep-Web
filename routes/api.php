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


// @todo seperate user and driver login/register
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
 * Get All orders
 */
Route::middleware('auth:api')->get('/orders/all', 'App\Http\Controllers\Api\OrdersController@getAll');

/**
 * Get active order for user
 */
Route::middleware('auth:api')->get('/orders/active', 'App\Http\Controllers\Api\OrdersController@getActiveOrder');

/**
 * Get Single order
 */
Route::middleware('auth:api')->get('/orders/{id}', 'App\Http\Controllers\Api\OrdersController@getSingle');

/**
 * Get Single order
 */
Route::middleware('auth:api')->get('/orders/path/{orderPath}', 'App\Http\Controllers\Api\OrdersController@getByOrderPath');

/**
 * Get orders for user
 */
Route::middleware('auth:api')->get('/orders', 'App\Http\Controllers\Api\OrdersController@get');


/**
 * Add Order
 */
Route::middleware('auth:api')->post('/orders/add', 'App\Http\Controllers\Api\OrdersController@add');

/**
 * Update order status
 */
Route::middleware('auth:api')->post('/orders/status/{id}', 'App\Http\Controllers\Api\OrdersController@status');

/**
 * Rate the order
 */
Route::middleware('auth:api')->post('/rate/{id?}', 'App\Http\Controllers\Api\RatesController@add');
