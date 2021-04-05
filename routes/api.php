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



Route::get('/user', function (Request $request) {
    dd(auth('api'));
    return "xxxxx";
});


// @todo 
Route::post('register', 'App\Http\Controllers\Api\UserController@register');
Route::post('login', 'App\Http\Controllers\Api\UserController@login');
Route::post('ForgotPassword', 'App\Http\Controllers\Api\UserController@ForgotPassword');
Route::post('user/update', 'App\Http\Controllers\Api\UserController@update');
Route::get('profileData/{phone}', 'App\Http\Controllers\Api\UserController@profileData');

Route::get('GetHomeData', 'App\Http\Controllers\Api\MainController@index');
Route::post('upload_image', 'App\Http\Controllers\Api\MainController@uploadImage');

Route::post('NewContact', 'App\Http\Controllers\Api\MessagesController@NewContact');
Route::post('AdminMeesage', 'App\Http\Controllers\Api\MessagesController@NewAdminMessage');

Route::post('Bid/create', 'App\Http\Controllers\Api\BidController@create');
Route::get('Bid/get', 'App\Http\Controllers\Api\BidController@showBids');
Route::get('Bid/FinishedBids', 'App\Http\Controllers\Api\BidController@showFinishedBids');
Route::get('Bid/index', 'App\Http\Controllers\Api\BidController@index');
Route::get('Bid/Getbid/{id?}', 'App\Http\Controllers\Api\BidController@Getbid');
Route::post('Bid/AddBid', 'App\Http\Controllers\Api\BidController@AddBid');

/**
 * Get current user
 */
// Route::middleware('auth:api')->get('/user', function () {
//     return auth('api')->user();
// });