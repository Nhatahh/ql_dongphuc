<?php

use App\Http\Controllers\User\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UniformController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\SearchController;
use App\Http\Controllers\User\SizeController;
use App\Http\Controllers\User\DanhmucController;
use App\Http\Controllers\User\nhaSXController;
use App\Http\Controllers\User\ptThanhToanController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\DanhGiaController;


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
    return redirect()->route('home.index');
})->name('/');

Route::prefix('user')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home.index');

    Route::get('/store', [UniformController::class, 'store'])->name('uniforms.store');
    Route::get('/store/filter', [UniformController::class, 'filter'])->name('store.filter');
    Route::get('/uniforms/{sp_id}', [UniformController::class, 'showDetail'])->name('uniforms.show_detail');
    Route::post('/uniforms/addSP', [UniformController::class, 'addSP'])->name('addSP');
    Route::post('/mualai/{hd_id}', [UniformController::class, 'muaLai'])->name('uniforms.muaLai');
    Route::post('/submit-review', [DanhGiaController::class, 'danhgia'])->name('reviews.danhgia');



    Route::get('/cart', [OrderController::class, 'cart'])->name('orders.cart');
    Route::get('/getSizes', [OrderController::class, 'getSizes']);
    Route::post('/cart/update', [OrderController::class, 'updateQuantity'])->name('cart.updateQuantity');
    Route::delete('/cart/delete', [OrderController::class, 'deleteSP'])->name('cart.delete');
    Route::post('/cart/checkout', [OrderController::class, 'checkout'])->name('cart.checkout');

    // Route::get('/orders', [UserController::class, 'showOrders']);
    Route::get('/orders/details/{hd_id}', [UserController::class, 'getOrderDetails'])->name('getOrderDetails');
    Route::post('/orders/cancel', [UserController::class, 'cancelOrder'])->name('orders.cancel');


    Route::get('/sizes', [SizeController::class, 'sizes']);
    Route::get('/danhmuc', [DanhmucController::class, 'danhmuc']);
    Route::get('/nsx', [nhaSXController::class, 'nsx']);
    Route::get('/ptThanhToan', [ptThanhToanController::class, 'ptThanhToan']);

    Route::get('/payment', [OrderController::class, 'payment'])->name('orders.payment');

    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/dt_profile', [UserController::class, 'data_profile'])->name('user.dt_profile');
    Route::get('users', [UserController::class, 'index'])->name('user.index');

    Route::get('/notifications', [UserController::class, 'getNotifications'])->name('notifications');
    Route::get('/notifications/unread', [UserController::class, 'countUnread'])->name('notifications.countUnread');

    Route::get('/search', [SearchController::class, 'search'])->name('user.search');

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

});

