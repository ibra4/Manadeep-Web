<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::name('settings.index')->middleware('can:manage-website')->get('/settings', [App\Http\Controllers\SettingsController::class, 'index']);
Route::name('settings.update')->middleware('can:manage-website')->post('/settings', [App\Http\Controllers\SettingsController::class, 'update']);

Route::middleware('can:manage-website')->resource('cities', App\Http\Controllers\CitiesController::class)->except(['show']);

// Pricing
Route::middleware('can:manage-website')->resource('cities-pricing', App\Http\Controllers\PricingController::class);
