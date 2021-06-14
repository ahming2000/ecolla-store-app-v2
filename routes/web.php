<?php

use App\Http\Controllers\OrdersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerPageController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\ItemsManageController;
use App\Http\Controllers\AdminPageController;

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

// Redirect to ch link by default
Route::get('/', [CustomerPageController::class, 'redirect'])->name('redirect');
Route::get('/about', [CustomerPageController::class, 'redirect'])->name('redirect');
Route::get('/cart', [CustomerPageController::class, 'redirect'])->name('redirect');
Route::get('/payment-method', [CustomerPageController::class, 'redirect'])->name('redirect');
Route::get('/check-out', [CustomerPageController::class, 'redirect'])->name('redirect');
Route::get('/item', [CustomerPageController::class, 'redirect'])->name('redirect');
Route::get('/item/{item}', [CustomerPageController::class, 'redirect'])->name('redirect');
Route::get('/order-tracking', [CustomerPageController::class, 'redirect'])->name('redirect');

// Chinese customer link
Route::prefix('ch')->group(function(){
    Route::get('/', [ItemsController::class, 'index'])->name('ch.index');
    Route::get('/payment-method', [CustomerPageController::class, 'paymentMethod'])->name('ch.paymentMethod');
    Route::get('/cart', [CustomerPageController::class, 'cart'])->name('ch.cart');
    Route::post('/cart', [CustomerPageController::class, 'cartOperation'])->name('ch.cartOperation');

    Route::get('/item', [ItemsController::class, 'index'])->name('ch.item.index');
    Route::get('/item/{item}', [ItemsController::class, 'view'])->name('ch.item.view');
    Route::post('/item/{item}', [ItemsController::class, 'addToCart'])->name('ch.item.addToCart');

    Route::get('/check-out', [OrdersController::class, 'checkOut'])->name('ch.order.checkOut');
    Route::post('/check-out', [OrdersController::class, 'store'])->name('ch.order.save');
    Route::get('/order-tracking', [OrdersController::class, 'orderTracking'])->name('ch.order.orderTracking');
    Route::get('/order-successful', [OrdersController::class, 'checkOutSuccess'])->name('ch.order.checkOutSuccess');
});

// English customer link
Route::prefix('en')->group(function (){
    Route::get('/', [ItemsController::class, 'index'])->name('en.index');
    Route::get('/payment-method', [CustomerPageController::class, 'paymentMethod'])->name('en.paymentMethod');
    Route::get('/cart', [CustomerPageController::class, 'cart'])->name('en.cart');
    Route::post('/cart', [CustomerPageController::class, 'cartOperation'])->name('ch.cartOperation');

    Route::get('/item', [ItemsController::class, 'index'])->name('en.item.index');
    Route::get('/item/{item}', [ItemsController::class, 'view'])->name('en.item.view');
    Route::post('/item/{item}', [ItemsController::class, 'addToCart'])->name('en.item.addToCart');

    Route::get('/check-out', [OrdersController::class, 'checkOut'])->name('en.order.checkOut');
    Route::post('/check-out', [OrdersController::class, 'store'])->name('en.order.save');
    Route::get('/order-tracking', [OrdersController::class, 'orderTracking'])->name('en.order.orderTracking');
    Route::get('/order-successful', [OrdersController::class, 'checkOutSuccess'])->name('ch.order.checkOutSuccess');

});
