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
