<?php

use App\Http\Controllers\Admin\CustomOrderController;
use App\Http\Controllers\Admin\ProductController;
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

Route::get('lang/{locale}', [\App\Http\Controllers\Admin\HomeController::class, 'lang'])->name('lang');

Route::middleware(['guest'])->group(function () {
    // Auth Routes

    Route::get('login', 'Auth\LoginController@showLoginForm')->name('show-login');
    Route::post('login', 'Auth\LoginController@login')->name('login');
});


// Dashboard routes
Route::middleware(['admin', 'Localization'])->name('admin.')->group(function () {

    Route::get('dashboard', 'HomeController@index')->name('dashboard');

    Route::resource('static-pages', 'StaticPageController');
    Route::resource('settings', 'SettingController');

    Route::resource('users', 'UserController');

    Route::get('click/plus/branches', 'UserController@getBranches')->name('click.plus.branches');

    Route::resource('activities-types', 'ActivityTypeController');

    Route::resource('regions', 'RegionController');

    // Route::resource('cars', 'CarController');

    Route::resource('packages', 'PackageController');

    Route::resource('cities', 'CityController');

    Route::resource('shippings', 'ShippingController');

    Route::resource('company-sectors', 'CompanySectorController');

    Route::resource('company-models', 'CompanyModelController');

    Route::resource('sliders-services', 'SliderServiceController');

    Route::resource('news-letter', 'NewsLetterController');

    Route::resource('faqs', 'FaqsController');

    Route::resource('orders', 'OrderController');

    Route::resource('custom_orders', 'CustomOrderController');

    Route::get('custom_orders_item/{id}/edit', [CustomOrderController::class, 'edit_custom_order_item'])->name('custom_order_items.edit');

    Route::put('custom_orders_item/{id}/update', [CustomOrderController::class, 'update_custom_order_item'])->name('custom_order_items.update');

    Route::get("car_model", [CustomOrderController::class, 'get_car_model'])->name('get_car_model');

    Route::get("activity", [CustomOrderController::class, 'get_activity'])->name('get_activity');

    Route::get("sub_activity", [CustomOrderController::class, 'get_sub_activity'])->name('get_sub_activity');

    Route::resource('wallet-requests', 'WalletRequestController');

    Route::get('wallet-requests/{id}/approve', 'WalletRequestController@approve')->name('wallet-requests.approve');

    // product routes
    Route::get('products/index', [ProductController::class, 'index'])->name('products_index');
    Route::get('products/create', [ProductController::class, 'create'])->name('products_create');
    Route::post('products/store', [ProductController::class, 'store'])->name('products_store');
    Route::get('products/edit/{id}', [ProductController::class, 'edit'])->name('products_edit');
    Route::patch('products/update/{id}', [ProductController::class, 'update'])->name('products_update');
    Route::delete('products/delete/{id}', [ProductController::class, 'destroy'])->name('products_delete');

    Route::get('logout', 'Auth\LoginController@logout')->name('logout');
});
