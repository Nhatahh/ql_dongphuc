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
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminSanphamController;
use App\Http\Controllers\Admin\AdminDonHangController;
use App\Http\Controllers\Admin\AdminDanhMucController;
use App\Http\Controllers\Admin\AdminNSXController;
use App\Http\Controllers\Admin\AdminSizeController;
use App\Http\Controllers\AuthController;


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

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

});

Route::prefix('admin')->group(function () {

    // Quản lí tài khoản
    Route::get('/', [AdminController::class, 'indexAdmin'])->name('admin.index');
    Route::get('/users/data', [AdminController::class, 'getUserData'])->name('admin.taikhoan.users.data');
    Route::get('/admins/data', [AdminController::class, 'getAdminData'])->name('admin.taikhoan.admins.data');

    // Quản lí đơn hàng
    Route::get('/donhang', [AdminDonHangController::class, 'index'])->name('admin.donhang');
    Route::get('/donhang/data', [AdminDonHangController::class, 'getData'])->name('admin.donhang.data');
    Route::get('/donhang/chitiet/{hd_id}', [AdminDonhangController::class, 'getChitietHoadon'])->name('admin.donhang.chitiet');

    // Quản lí danh mục
    Route::get('/danhmuc', [AdminDanhMucController::class, 'index'])->name('admin.danhmuc');
    Route::get('/danhmuc/data', [AdminDanhMucController::class, 'getData'])->name('admin.getDataDanhMuc');
    Route::get('/danhmuc/max', [AdminDanhMucController::class, 'getMaxDmId']);
    Route::post('/danhmuc/add', [AdminDanhMucController::class, 'add']);
    Route::get('/danhmuc/{dm_id}', [AdminDanhMucController::class, 'show']);
    Route::put('/danhmuc/{dm_id}', [AdminDanhMucController::class, 'update']);
    Route::delete('/danhmuc/{dm_id}', [AdminDanhMucController::class, 'delete'])->name('admin.danhmuc.delete');
    Route::get('/danhmuc/select2', [AdminDanhMucController::class, 'select2']);


    // Quản lí nhà sản xuất
    Route::get('/nhasanxuat', [AdminNSXController::class, 'index'])->name('admin.NSX');
    Route::get('/nhasanxuat/data', [AdminNSXController::class, 'getData'])->name('admin.getDataNSX');
    Route::get('/nhasanxuat/max', [AdminNSXController::class, 'getMaxNSXId']);
    Route::post('/nhasanxuat/add', [AdminNSXController::class, 'add']);
    Route::get('/nhasanxuat/{nsx_id}', [AdminNSXController::class, 'show']);
    Route::put('/nhasanxuat/{nsx_id}', [AdminNSXController::class, 'update']);
    Route::delete('/nhasanxuat/{nsx_id}', [AdminNSXController::class, 'delete'])->name('admin.NSX.delete');
    Route::get('/nhasanxuat/select2', [AdminNSXController::class, 'select2']);

    // Quản lí size
    Route::get('/size', [AdminSizeController::class, 'index'])->name('admin.size');
    Route::get('/size/data', [AdminSizeController::class, 'getData'])->name('admin.getDataSize');
    Route::get('/size/max', [AdminSizeController::class, 'getMaxSizeId']);
    Route::post('/size/add', [AdminSizeController::class, 'add']);
    Route::get('/size/{size_id}', [AdminSizeController::class, 'show']);
    Route::put('/size/{size_id}', [AdminSizeController::class, 'update']);
    Route::delete('/size/{size_id}', [AdminSizeController::class, 'delete'])->name('admin.size.delete');

    // Quản lí sản phẩm
    Route::get('/sanpham', [AdminSanphamController::class, 'sanpham'])->name('admin.sanpham');
    Route::get('/sanpham/data', [AdminSanphamController::class, 'getSanphamData'])->name('admin.sanpham.data');
    Route::get('/sanpham/{sp_id}', [AdminSanphamController::class, 'edit']); 
    Route::put('/sanpham/{sp_id}', [AdminSanphamController::class, 'update']); 
    Route::delete('/sanpham/{sp_id}', [AdminSanphamController::class, 'delete'])->name('admin.sanpham.delete');
    
    



    
    Route::get('/thongke', [AdminController::class, 'thongke'])->name('admin.thongke');

});

