<?php

use App\Http\Controllers\User\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UniformController;
use App\Http\Controllers\User\OrderController;

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

Route::prefix('user')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home.index');

    Route::get('/store', [UniformController::class, 'store'])->name('uniforms.store');
    Route::get('/uniforms', [UniformController::class, 'show_detail'])->name('uniforms.show_detail');

    Route::get('/cart', [OrderController::class, 'cart'])->name('orders.cart');
    Route::get('/payment', [OrderController::class, 'payment'])->name('orders.payment');
<<<<<<< Updated upstream
    Route::get('/profile', function () {
        return view('user.profile');
    })->name('user.profile');
});
=======
    // Route::get('/profile', function () {
    //     return view('user.profile');
    // })->name('user.profile');
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('users', [UserController::class, 'index'])->name('user.index');



    
    Route::get('/sign_in', [UserController::class, 'formSignIn'])->name('user.sign_in');


});
>>>>>>> Stashed changes
