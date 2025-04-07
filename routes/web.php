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

// Sinh viên
Route::get('/', [App\Http\Controllers\User\HomeController::class, 'index']);
Route::get('/uniforms', [App\Http\Controllers\User\UniformController::class, 'index']);
Route::get('/orders', [App\Http\Controllers\User\OrderController::class, 'index']);

// Admin
Route::prefix('admin')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index']);
    Route::get('/uniforms', [App\Http\Controllers\Admin\ManageUniformController::class, 'index']);
    Route::get('/orders', [App\Http\Controllers\Admin\ManageOrderController::class, 'index']);
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index']);
});
