<?php
use App\User;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\DriversController;
use App\Http\Controllers\Admin\PartnersController;
use App\Http\Controllers\Admin\BannersController;
use App\Http\Controllers\Admin\LocationsController;
use App\Http\Controllers\Admin\OrdersController;
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

Route::name('admin')->middleware('can:manage-website')->get('/admin', function () {
         return view('admin.index');
     });

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

   // Admin Login
Route::get('/admin/login', [AdminAuthController::class, 'adminLoginPage'])->name('admin_login');
Route::post('/admin/login', [AdminAuthController::class, 'adminLogin'])->name('admin_login');



Route::get('/admin/users', [UsersController::class, 'index'])->middleware('can:manage-website')->name('admin.users');
Route::get('/admin/users/edit/{id}', [UsersController::class, 'edit'])->middleware('can:manage-website')->name('admin.users.edit');
Route::delete('/admin/users/destroy/{id}', [UsersController::class, 'destroy'])->middleware('can:manage-website')->name('admin.users.delete');
Route::post('/admin/users/update/{id}', [UsersController::class, 'update'])->middleware('can:manage-website')->name('admin.users.update');
Route::get('/admin/users/rates/{id}', [UsersController::class, 'rates'])->middleware('can:manage-website')->name('admin.users.rates');
Route::get('/admin/users/orders/{id}', [UsersController::class, 'orders'])->middleware('can:manage-website')->name('admin.users.orders');


Route::put('/admin/drivers/updatepercentage', [DriversController::class, 'updatepercentage'])->middleware('can:manage-website')->name('admin.drivers.updatepercentage');
Route::put('/admin/drivers/updatecomm', [DriversController::class, 'updatecomm'])->middleware('can:manage-website')->name('admin.drivers.updatecomm');

Route::get('/admin/drivers/orders/{id}', [DriversController::class, 'orders'])->middleware('can:manage-website')->name('admin.drivers.orders');
Route::get('/admin/drivers', [DriversController::class, 'index'])->middleware('can:manage-website')->name('admin.drivers');
Route::get('/admin/drivers/create', [DriversController::class, 'create'])->middleware('can:manage-website')->name('admin.drivers.create');
Route::post('/admin/drivers/create', [DriversController::class, 'create'])->middleware('can:manage-website')->name('admin.drivers.create');
Route::get('/admin/drivers/{id}', [DriversController::class, 'edit'])->middleware('can:manage-website')->name('admin.drivers.edit');
Route::post('/admin/drivers/{id}', [DriversController::class, 'edit'])->middleware('can:manage-website')->name('admin.drivers.edit');
Route::delete('/admin/drivers/{id}', [DriversController::class, 'delete'])->middleware('can:manage-website')->name('admin.drivers.delete');
Route::put('/admin/drivers/{id}', [DriversController::class, 'block'])->middleware('can:manage-website')->name('admin.drivers.block');



Route::get('/admin/partners', [PartnersController::class, 'index'])->middleware('can:manage-website')->name('admin.partners');
Route::get('/admin/partners/edit/{id}', [PartnersController::class, 'edit'])->middleware('can:manage-website')->name('admin.partners.edit');
Route::delete('/admin/partners/destroy/{id}', [PartnersController::class, 'destroy'])->middleware('can:manage-website')->name('admin.partners.delete');
Route::post('/admin/partners/update/{id}', [PartnersController::class, 'edit'])->middleware('can:manage-website')->name('admin.partners.update');
Route::get('/admin/partners/create', [PartnersController::class, 'create'])->middleware('can:manage-website')->name('admin.partners.create');
Route::post('/admin/partners/create', [PartnersController::class, 'create'])->middleware('can:manage-website')->name('admin.partners.create');
Route::put('/admin/partners/{id}', [PartnersController::class, 'block'])->middleware('can:manage-website')->name('admin.partners.block');
Route::get('/admin/partners/managecategories', [PartnersController::class, 'managecategories'])->middleware('can:manage-website')->name('admin.partners.managecategories');
Route::post('/admin/partners/managecategories/create', [PartnersController::class, 'managecategoriescreate'])->middleware('can:manage-website')->name('admin.partners.add_new_category');
Route::post('/admin/partners/managecategories/modify', [PartnersController::class, 'managecategoriesmodify'])->middleware('can:manage-website')->name('admin.partners.modify_category');
Route::get('/admin/partners/managecategories/delete/{id}', [PartnersController::class, 'managecategoriesdelete'])->middleware('can:manage-website')->name('admin.partners.delete_category');


Route::get('/admin/banners', [BannersController::class, 'index'])->middleware('can:manage-website')->name('admin.banners');
Route::get('/admin/create', [BannersController::class, 'create'])->middleware('can:manage-website')->name('admin.banners.create');
Route::post('/admin/create', [BannersController::class, 'create'])->middleware('can:manage-website')->name('admin.banners.create');
Route::get('/admin/banners/edit/{id}', [BannersController::class, 'edit'])->middleware('can:manage-website')->name('admin.banners.edit');
Route::post('/admin/banners/edit/{id}', [BannersController::class, 'edit'])->middleware('can:manage-website')->name('admin.banners.edit');
Route::delete('/admin/banners/delete/{id}', [BannersController::class, 'delete'])->middleware('can:manage-website')->name('admin.banners.delete');



Route::get('/admin/locations', [LocationsController::class, 'index'])->middleware('can:manage-website')->name('admin.locations');
Route::get('/admin/locations/create', [LocationsController::class, 'create'])->middleware('can:manage-website')->name('admin.locations.create');
Route::post('/admin/locations/create', [LocationsController::class, 'create'])->middleware('can:manage-website')->name('admin.locations.create');
Route::get('/admin/locations/edit/{id}', [LocationsController::class, 'edit'])->middleware('can:manage-website')->name('admin.locations.edit');
Route::post('/admin/locations/edit/{id}', [LocationsController::class, 'edit'])->middleware('can:manage-website')->name('admin.locations.edit');
Route::delete('/admin/locations/delete/{id}', [LocationsController::class, 'delete'])->middleware('can:manage-website')->name('admin.locations.delete');

Route::get('/admin/locationspricing', [LocationsController::class, 'pricing'])->middleware('can:manage-website')->name('admin.locations.pricing');
Route::get('/admin/locationspricingcreate', [LocationsController::class, 'pricingcreate'])->middleware('can:manage-website')->name('admin.locations.pricing.create');
Route::post('/admin/locationspricingcreate', [LocationsController::class, 'pricingcreate'])->middleware('can:manage-website')->name('admin.locations.pricing.create');
Route::get('/admin/locationspricingedit/{id}', [LocationsController::class, 'pricingedit'])->middleware('can:manage-website')->name('admin.locations.pricing.edit');
Route::post('/admin/locationspricingedit/{id}', [LocationsController::class, 'pricingedit'])->middleware('can:manage-website')->name('admin.locations.pricing.edit');
Route::delete('/admin/locations/pricing/delete/{id}', [LocationsController::class, 'pricingdelete'])->middleware('can:manage-website')->name('admin.locations.pricing.delete');


Route::get('/admin/locationspricingcreatebulk', [LocationsController::class, 'pricingcreatebulk'])->middleware('can:manage-website')->name('admin.locations.pricing.createbulk');
Route::post('/admin/locationspricingcreatebulk', [LocationsController::class, 'pricingcreatebulk'])->middleware('can:manage-website')->name('admin.locations.pricing.createbulk');
Route::get('/admin/locationspricingeditbulk/{id}', [LocationsController::class, 'pricingeditbulk'])->middleware('can:manage-website')->name('admin.locations.pricing.editbulk');
Route::post('/admin/locationspricingeditbulk/{id}', [LocationsController::class, 'pricingeditbulk'])->middleware('can:manage-website')->name('admin.locations.pricing.editbulk');
Route::delete('/admin/locations/pricing/deletebulk/{id}', [LocationsController::class, 'pricingdeletebulk'])->middleware('can:manage-website')->name('admin.locations.pricing.deletebulk');


Route::name('settings.index')->middleware('can:manage-website')->get('/settings', [App\Http\Controllers\SettingsController::class, 'index']);
Route::name('settings.update')->middleware('can:manage-website')->post('/settings', [App\Http\Controllers\SettingsController::class, 'update']);

Route::middleware('can:manage-website')->resource('cities', App\Http\Controllers\CitiesController::class)->except(['show']);

// Pricing
Route::middleware('can:manage-website')->resource('cities-pricing', App\Http\Controllers\PricingController::class);
