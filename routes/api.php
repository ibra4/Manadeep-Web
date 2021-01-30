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
* Driver Accounting
*/
Route::get('/Driver/accounting', 'App\Http\Controllers\Api\Drivers@driver_accounting');
/**
* User Accounting
*/
Route::get('/Order/accounting', 'App\Http\Controllers\Api\OrdersController@UserAccounting');
Route::get('/User/accounting', 'App\Http\Controllers\Api\OrdersController@user_accounting');
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
Route::middleware('auth:api')->get('/AssociateOrders/active', 'App\Http\Controllers\Api\associate_orders@getActiveOrder');
/**
 * Get Single order
 */
Route::middleware('auth:api')->get('/orders/{id}', 'App\Http\Controllers\Api\OrdersController@getSingle');
Route::middleware('auth:api')->get('/AssociateOrders/myOrder', 'App\Http\Controllers\Api\associate_orders@MyOrder');

/**
 * Get Single order
 */
Route::middleware('auth:api')->get('/orders/path/{orderPath}', 'App\Http\Controllers\Api\OrdersController@getByOrderPath');

/**
 * Get orders for user
 */
Route::middleware('auth:api')->get('/orders', 'App\Http\Controllers\Api\OrdersController@get');
Route::middleware('auth:api')->get('/AssociateOrders/{id}', 'App\Http\Controllers\Api\associate_orders@get');

Route::middleware('auth:api')->get('/AssociateOrders/hide/{id}', 'App\Http\Controllers\Api\associate_orders@hide');
/**
 * Add Order
 */
Route::middleware('auth:api')->post('/orders/add', 'App\Http\Controllers\Api\OrdersController@add');
Route::middleware('auth:api')->post('/AssociateOrders/add', 'App\Http\Controllers\Api\associate_orders@add');

/**
 * Update order status
 */
//
Route::middleware('auth:api')->post('/orders/status/{id}', 'App\Http\Controllers\Api\OrdersController@status');
Route::middleware('auth:api')->post('/AssociateOrders/update', 'App\Http\Controllers\Api\associate_orders@update');
/**
 * Rate the order
 */
Route::middleware('auth:api')->post('/rate/{id?}', 'App\Http\Controllers\Api\RatesController@add');

/**
 * Get current user profile
 */
Route::middleware('auth:api')->get('/profile', 'App\Http\Controllers\Api\ProfileController@get');

/**
 * Get current user profile
 */
Route::middleware('auth:api')->get('/Banners', 'App\Http\Controllers\Api\Banners@show');


Route::middleware('auth:api')->get('/notification/show', 'App\Http\Controllers\Api\Notifications@show');
Route::middleware('auth:api')->get('/notification/seen/{id?}', 'App\Http\Controllers\Api\Notifications@seen');
Route::middleware('auth:api')->get('/notificationNumber', 'App\Http\Controllers\Api\Notifications@notificationNumber');
/**
 * Update 
 */
Route::middleware('auth:api')->post('/profile/update', 'App\Http\Controllers\Api\ProfileController@update');

/**
 * Update 
 */
Route::middleware('auth:api')->post('/profile/image', 'App\Http\Controllers\Api\ProfileController@uploadImage');
