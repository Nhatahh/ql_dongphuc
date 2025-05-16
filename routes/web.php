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
use App\Http\Controllers\Auth\LoginController;


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
    



    Route::get('/cart', [OrderController::class, 'cart'])->name('orders.cart');
    Route::get('/getSizes', [OrderController::class, 'getSizes']);
    Route::post('/cart/update', [OrderController::class, 'updateQuantity'])->name('cart.updateQuantity');
    Route::delete('/cart/delete', [OrderController::class, 'deleteSP'])->name('cart.delete');


    Route::get('/sizes', [SizeController::class, 'sizes']);
    Route::get('/danhmuc', [DanhmucController::class, 'danhmuc']);
    Route::get('/nsx', [nhaSXController::class, 'nsx']);

    Route::get('/payment', [OrderController::class, 'payment'])->name('orders.payment');

    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/dt_profile', [UserController::class, 'data_profile'])->name('user.dt_profile');
    Route::get('users', [UserController::class, 'index'])->name('user.index');

    Route::get('/search', [SearchController::class, 'search'])->name('user.search');

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

});

