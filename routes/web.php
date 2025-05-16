<?php

use App\Http\Controllers\User\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UniformController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\SearchController;
use App\Http\Controllers\User\SizeController;


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
});

Route::prefix('user')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home.index');

    Route::get('/store', [UniformController::class, 'store'])->name('uniforms.store');
    Route::get('/uniforms/{sp_id}', [UniformController::class, 'showDetail'])->name('uniforms.show_detail');

    Route::get('/cart', [OrderController::class, 'cart'])->name('orders.cart');
    Route::get('/getSizes', [OrderController::class, 'getSizes']);
    Route::post('/cart/update', [OrderController::class, 'updateQuantity'])->name('cart.updateQuantity');

    Route::get('/sizes', [SizeController::class, 'sizes']);
    

    Route::get('/payment', [OrderController::class, 'payment'])->name('orders.payment');

    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/dt_profile', [UserController::class, 'data_profile'])->name('user.dt_profile');
    Route::get('users', [UserController::class, 'index'])->name('user.index');

    Route::get('/search', [SearchController::class, 'search'])->name('user.search');


    Route::get('/sign_in', [UserController::class, 'formSignIn'])->name('user.sign_in');


});
