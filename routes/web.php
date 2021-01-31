<?php
use App\User;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\DriversController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Request;

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


Route::name('homepage')->get('/', function () {
    return redirect(App::getLocale());
});



     Route::name('admin.')->prefix('admin')->middleware('can:manage-website')->group(function () {
         Route::get('/users', [Admin\UsersController::class], 'index');
//          Route::get('/users', [Admin\UsersController::class], 'show');
//          Route::get('/users', [Admin\UsersController::class], 'store');
//          Route::post('/users', [Admin\UsersController::class], 'create');
     });



Auth::routes();

     Route::name('admin')->get('/admin', function () {
         return view('admin.index');
     });

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

   // Admin Login
Route::get('/admin/login', [AdminAuthController::class, 'adminLoginPage'])->name('admin_login');
Route::post('/admin/login', [AdminAuthController::class, 'adminLogin'])->name('admin_login');

Route::get('/admin/users', [UsersController::class, 'index'])->name('admin.users');
Route::get('/admin/users/edit/{id}', [UsersController::class, 'edit'])->name('admin.users.edit');
Route::delete('/admin/users/destroy/{id}', [UsersController::class, 'destroy'])->name('admin.users.delete');
Route::post('/admin/users/update/{id}', [UsersController::class, 'update'])->name('admin.users.update');
Route::get('/admin/users/rates/{id}', [UsersController::class, 'rates'])->name('admin.users.rates');
Route::get('/admin/users/orders/{id}', [UsersController::class, 'orders'])->name('admin.users.orders');


Route::get('/admin/drivers', [DriversController::class, 'index'])->name('admin.drivers');
Route::get('/admin/drivers/create', [DriversController::class, 'create'])->name('admin.drivers.create');
Route::post('/admin/drivers/create', [DriversController::class, 'create'])->name('admin.drivers.create');
Route::get('/admin/drivers/{id}', [DriversController::class, 'edit'])->name('admin.drivers.edit');
Route::post('/admin/drivers/{id}', [DriversController::class, 'edit'])->name('admin.drivers.edit');
Route::delete('/admin/drivers/{id}', [DriversController::class, 'delete'])->name('admin.drivers.delete');
Route::post('/admin/drivers/{id}', [DriversController::class, 'block'])->name('admin.drivers.block');

Route::name('settings.index')->middleware('can:manage-website')->get('/settings', [App\Http\Controllers\SettingsController::class, 'index']);
Route::name('settings.update')->middleware('can:manage-website')->post('/settings', [App\Http\Controllers\SettingsController::class, 'update']);

Route::middleware('can:manage-website')->resource('cities', App\Http\Controllers\CitiesController::class)->except(['show']);

// Pricing
Route::middleware('can:manage-website')->resource('cities-pricing', App\Http\Controllers\PricingController::class);
