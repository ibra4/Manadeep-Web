<?php
use App\User;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\BidWebController;
use App\Http\Controllers\Admin\PartnersController;
use App\Http\Controllers\Admin\BannersController;
use App\Http\Controllers\Admin\LocationsController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\AdvertiseController;
use App\Http\Controllers\Admin\AccessoriesController;
use App\Http\Controllers\HomeController;
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
    Route::name('privacy')->get('/privacy', function () {
        return view('privacy');
    });

        Route::name('support')->get('/support', function () {
            return view('support');
        });



// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

   // Admin Login
Route::get('/admin/login', [AdminAuthController::class, 'adminLoginPage'])->name('admin_login');
Route::post('/admin/login', [AdminAuthController::class, 'adminLogin'])->name('admin_login');

Route::get('/admin/messages', [AdminAuthController::class, 'ShowMessages'])->name('admin.messages');
Route::get('/admin/contact', [AdminAuthController::class, 'ShowContact'])->name('admin.contact');

// ========================  users  =============================


Route::get('/admin/users', [UsersController::class, 'index'])->middleware('can:manage-website')->name('admin.users');
Route::get('/admin/users/edit/{id}', [UsersController::class, 'edit'])->middleware('can:manage-website')->name('admin.users.edit');
Route::get('/admin/users/active/{id}', [UsersController::class, 'approval'])->middleware('can:manage-website')->name('admin.users.active');
Route::delete('/admin/users/destroy/{id}', [UsersController::class, 'destroy'])->middleware('can:manage-website')->name('admin.users.delete');
Route::post('/admin/users/update/{id}', [UsersController::class, 'update'])->middleware('can:manage-website')->name('admin.users.update');
Route::get('/admin/users/approve/', [UsersController::class, 'Approve'])->middleware('can:manage-website')->name('admin.users.approve');

// ========================  Bids  =============================

Route::get('/admin/bids', [BidWebController::class, 'index'])->middleware('can:manage-website')->name('admin.bids');
Route::get('/admin/bids/edit/{id}', [BidWebController::class, 'edit'])->middleware('can:manage-website')->name('admin.bids.edit');
Route::delete('/admin/bids/destroy/{id}', [BidWebController::class, 'destroy'])->middleware('can:manage-website')->name('admin.bids.destroy');
Route::post('/admin/bids/update/{id}', [BidWebController::class, 'update'])->middleware('can:manage-website')->name('admin.bids.update');
Route::get('/admin/bids/show/{id}', [BidWebController::class, 'show'])->middleware('can:manage-website')->name('admin.bids.show');
Route::get('/admin/bids/add', [BidWebController::class, 'AddPage'])->middleware('can:manage-website')->name('admin.bids.add');
Route::post('/admin/bids/create', [BidWebController::class, 'create'])->middleware('can:manage-website')->name('admin.bids.create');

// ========================  type  =============================

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

// ========================  banners  =============================

Route::get('/admin/banners', [BannersController::class, 'index'])->middleware('can:manage-website')->name('admin.banners');
Route::get('/admin/banners/create', [BannersController::class, 'create'])->middleware('can:manage-website')->name('admin.banners.create');
Route::post('/admin/banners/create', [BannersController::class, 'create'])->middleware('can:manage-website')->name('admin.banners.create');
Route::get('/admin/banners/edit/{id}', [BannersController::class, 'edit'])->middleware('can:manage-website')->name('admin.banners.edit');
Route::post('/admin/banners/edit/{id}', [BannersController::class, 'edit'])->middleware('can:manage-website')->name('admin.banners.edit');
Route::delete('/admin/banners/delete/{id}', [BannersController::class, 'delete'])->middleware('can:manage-website')->name('admin.banners.delete');

// ========================  Advertises  =============================

Route::get('/admin/advertises', [AdvertiseController::class, 'index'])->middleware('can:manage-website')->name('admin.advertises');
Route::delete('/admin/advertises/destroy/{id}', [AdvertiseController::class, 'destroy'])->middleware('can:manage-website')->name('admin.advertises.destroy');
Route::get('/admin/advertises/show/{id}', [AdvertiseController::class, 'show'])->middleware('can:manage-website')->name('admin.advertises.show');
Route::get('/admin/advertises/approve/{id}', [AdvertiseController::class, 'approve'])->middleware('can:manage-website')->name('admin.advertises.approve');

// ========================  Accessories  =============================

Route::get('/admin/accessories', [AccessoriesController::class, 'index'])->middleware('can:manage-website')->name('admin.accessories');
Route::get('/admin/accessories/edit/{id}', [AccessoriesController::class, 'edit'])->middleware('can:manage-website')->name('admin.accessories.edit');
Route::delete('/admin/accessories/destroy/{id}', [AccessoriesController::class, 'destroy'])->middleware('can:manage-website')->name('admin.accessories.destroy');
Route::post('/admin/accessories/update/{id}', [AccessoriesController::class, 'update'])->middleware('can:manage-website')->name('admin.accessories.update');
Route::get('/admin/accessories/show/{id}', [AccessoriesController::class, 'show'])->middleware('can:manage-website')->name('admin.accessories.show');
Route::get('/admin/accessories/add', [AccessoriesController::class, 'AddPage'])->middleware('can:manage-website')->name('admin.accessories.add');
Route::post('/admin/accessories/create', [AccessoriesController::class, 'create'])->middleware('can:manage-website')->name('admin.accessories.create');

// ========================  News  =============================

Route::get('/admin/news', [NewsController::class, 'index'])->middleware('can:manage-website')->name('admin.news');
Route::delete('/admin/news/destroy/{id}', [NewsController::class, 'destroy'])->middleware('can:manage-website')->name('admin.news.destroy');
Route::get('/admin/news/add', [NewsController::class, 'AddPage'])->middleware('can:manage-website')->name('admin.news.add');
Route::post('/admin/news/create', [NewsController::class, 'create'])->middleware('can:manage-website')->name('admin.news.create');

// ========================  Locations  =============================

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
