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
//Admin
use \App\Http\Controllers\Admin\Users\LoginController;
use \App\Http\Controllers\Admin\MainController;
use \App\Http\Controllers\Admin\MenuController;
use \App\Http\Controllers\Admin\UsersController;
use \App\Http\Controllers\Admin\YearsController;
use \App\Http\Controllers\Admin\SchoolsController;
use \App\Http\Controllers\Admin\MethodsController;
use \App\Http\Controllers\Admin\Gruop_SubjectsController;
use \App\Http\Controllers\Admin\ExpensesAdminController;
use \App\Http\Controllers\Admin\ExpensesStaController;
use \App\Http\Controllers\Admin\CheckUserController;
use \App\Http\Controllers\Admin\SidebarController;
use \App\Http\Controllers\Admin\NavarController;





// Users
use \App\Http\Controllers\Admin\CheckInfoController;
use \App\Http\Controllers\User\MainUserController;
use \App\Http\Controllers\User\Login\LoginUserController;
use \App\Http\Controllers\User\Login\RegisterUserController;
use \App\Http\Controllers\User\Login\PasswordResetController;
use \App\Http\Controllers\User\Main\InfoUserController;
use \App\Http\Controllers\User\Main\ResulthbController;
use \App\Http\Controllers\User\Main\RegisterWishController;
use \App\Http\Controllers\User\Main\ExpensesController;
use \App\Http\Controllers\User\Main\ResultnlController;
use \App\Http\Controllers\User\Main\InstructController;











// User

// Route::get('/',[MainUserController::class, 'index'])->name('index')->middleware('checklogin::class');

Route::middleware('checklogin::class')->group(function () {
    Route::get('/',[MainUserController::class, 'index'])->name('index');
    Route::prefix('/')->group(function(){
        Route::get('/sidebar',[MainUserController::class,'sidebar']); // Load Sidebar
        Route::post('/logout',[MainUserController::class,'logout']); // Load Sidebar

        // Main
        Route::get('/loaduser_Img',[MainUserController::class,'loaduser_Img']); // Load Sidebar
        Route::get('/changepass',[MainUserController::class,'changepass']); // Load Sidebar
        Route::get('/updatepassword',[MainUserController::class,'updatepassword']); // Load Sidebar
        Route::post('/loadpage/{id}',[MainUserController::class,'loadpage']); // Load Sidebar



        //Info

        Route::prefix('/info')->group(function(){
            Route::get('/',[InfoUserController::class,'index']); // Index Thông tin cá nhân


            Route::get('/check_reg',[InfoUserController::class,'check_reg']); // Index Thông tin cá nhân



                Route::get('/placeUser',[InfoUserController::class,'placeUser']); // Load Nơi sinh
                Route::get('/nationUser',[InfoUserController::class,'nationUser']); // Load Dân tộc
                Route::get('/loadInfoUser',[InfoUserController::class,'loadInfoUser']); // Load Thông tin cơ bản
                Route::get('/loadRegister',[InfoUserController::class,'loadRegister']); // Load thông tin đăng ký
                Route::post('/province',[InfoUserController::class,'province']); // Load Hộ khẩu thường trú Tỉnh
                Route::get('/province2',[InfoUserController::class,'province2']); // Load Hộ khẩu thường trú Huyện
                Route::get('/province3',[InfoUserController::class,'province3']); // Load Hộ khẩu thường trú Xã
                Route::post('/change_province',[InfoUserController::class,'change_province']); // Change Tỉnh thì Huyện thay đổi
                Route::post('/change_province2',[InfoUserController::class,'change_province2']); // Change Huyện thì Xã thay đổi
                Route::post('/add_infoUser',[InfoUserController::class,'add_infoUser']); // Cập nhật, thêm mới thông tin cá nhân


            //Trường THPT


                Route::get('/province_shool_10',[InfoUserController::class,'province_shool_10']); // Load Trường lớp 10
                Route::get('/province_shool_11',[InfoUserController::class,'province_shool_11']); // Load Trường lớp 11
                Route::get('/province_shool_12',[InfoUserController::class,'province_shool_12']); // Load Trường lớp 12
                Route::get('/province_shools/{id}',[InfoUserController::class,'province_shools']); // Change Tỉnh thay đổi Trường
                Route::post('/area/{id}',[InfoUserController::class,'area']); // Change Trường thay đổi khu vực
                Route::post('/addArea',[InfoUserController::class,'addArea']); // Add Trường tính khu vực ưu tiên
                Route::post('/delArea/{id}',[InfoUserController::class,'delArea']); // Del Trường
                Route::get('/Priority_area',[InfoUserController::class,'Priority_area']); // Load Khu vực ưu tiên


                Route::get('/province_shool',[InfoUserController::class,'province_shool']); // Load Khu vực ưu tiên

                Route::get('/Priority_Policy',[InfoUserController::class,'Priority_Policy']); // Load chính sach ưu tiên
                Route::get('/changePriority_Policy/{id}',[InfoUserController::class,'changePriority_Policy']); // Change chính sách ưu tiên thì thay đổi hướng dẫn
                Route::post('/addPriority_policy',[InfoUserController::class,'addPriority_policy']); // Lưu đối tượng ưu tiên
                Route::get('/loadnote_Priority_Policy',[InfoUserController::class,'loadnote_Priority_Policy']); // Load Hướng dẫn chính sách ưu tiên
                Route::post('/crop_policy',[InfoUserController::class,'crop_policy']); // Lưu ảnh đối tượng ưu tiên




            });
            //Result HB
        Route::prefix('/result_hb')->group(function(){
            Route::get('/',[ResulthbController::class,'index']); // Load index
                Route::get('/loadSubjects',[ResulthbController::class,'loadSubjects']); // LoadSubject
                Route::post('/slider_hb',[ResulthbController::class,'slider_hb']); // Lưu Ảnh học bạ
                Route::get('/loadslider_hb',[ResulthbController::class,'loadslider_hb']); // Lưu Ảnh học bạ
                Route::post('/addResult',[ResulthbController::class,'addResult']); // Lưu Ảnh học bạ
                Route::get('/check_img',[ResulthbController::class,'check_img']); //Check ddur anh hocj baj
        });

        //Result Nawng luc
        Route::prefix('/result_nl')->group(function(){
            Route::get('/',[ResultnlController::class,'index']); // Load index
            Route::get('/loadSubjects',[ResultnlController::class,'loadSubjects']); // LoadSubject
            Route::get('/loadImg_nl',[ResultnlController::class,'loadImg_nl']); // LoadSubject
            Route::post('/slider_nl',[ResultnlController::class,'slider_nl']); // Lưu Ảnh học bạ
            Route::post('/addResult_nl',[ResultnlController::class,'addResult_nl']); // Lưu Ảnh học bạ

        });


      //Register_Wish
        Route::prefix('/registerwish')->group(function(){
            Route::get('/',[RegisterWishController::class,'index']); // Load index
            Route::get('/loadsuggest_group',[RegisterWishController::class,'loadsuggest_group']); // Load gợi ý điểm
            // Route::get('/loadriority_area',[RegisterWishController::class,'loadriority_area']); // Load index
            Route::get('/load_wish',[RegisterWishController::class,'load_wish']); // Load gợi ý điểm
            Route::post('/save_wish',[RegisterWishController::class,'save_wish']); //  Lưu nguyện vọng
            Route::post('/add_wish/{id}',[RegisterWishController::class,'add_wish']); // Thêm nguyện vọng
            Route::post('/change_method',[RegisterWishController::class,'change_method']); // Change Phuowg thức
            Route::post('/change_major',[RegisterWishController::class,'change_major']); // Change ngành
            Route::post('/change_group',[RegisterWishController::class,'change_group']); // Change ngành
            Route::get('/del_wish/{id}',[RegisterWishController::class,'del_wish']); // Del Nguyện vọng
            Route::post('/reg_wish',[RegisterWishController::class,'reg_wish']); // Đăng ký nguyện vọng
            Route::post('/check_reg',[RegisterWishController::class,'check_reg']); // Check đã đăng ký nguyện vọng
            Route::post('/check_expenses/{id}',[RegisterWishController::class,'check_expenses']); // Check đã đăng ký nguyện vọng
            Route::post('/check_khop',[RegisterWishController::class,'check_khop']); // Check đã đăng ký nguyện vọng


        });

        //Expenses
        Route::prefix('/expenses')->group(function(){
            Route::get('/',[ExpensesController::class,'index']); // Load index
            Route::get('/load_expenses_wish',[ExpensesController::class,'load_expenses_wish']); // Load Danh sách nguyện vọng
            Route::get('/load_expenses_img',[ExpensesController::class,'load_expenses_img']); // Load Danh sách nguyện vọng
            Route::get('/save_expenses_wish',[ExpensesController::class,'save_expenses_wish']); // Save danh sách ngành đóng lệ phí
            Route::post('/crop_ex',[ExpensesController::class,'crop_ex']); // Save hình ảnh lệ phí
            Route::get('/load_price',[ExpensesController::class,'load_price']); // Lấy thông tin lệ phí xét tuyển
        });

     //Instruct
     Route::prefix('/instruct')->group(function(){
        Route::get('/',[InstructController::class,'index']); // Load index
        Route::get('/load_active',[InstructController::class,'load_active']); // Load hướng dẫn


        // Route::get('/load_expenses_img',[ExpensesController::class,'load_expenses_img']); // Load Danh sách nguyện vọng
        // Route::get('/save_expenses_wish',[ExpensesController::class,'save_expenses_wish']); // Save danh sách ngành đóng lệ phí
        // Route::post('/crop_ex',[ExpensesController::class,'crop_ex']); // Save hình ảnh lệ phí
        // Route::get('/load_price',[ExpensesController::class,'load_price']); // Lấy thông tin lệ phí xét tuyển
    });





    });

});



Route::get('register',[RegisterUserController::class,'index']);
Route::post('register/store',[RegisterUserController::class,'store']);


Route::get('login',[LoginUserController::class,'index']);
Route::post('login/store',[LoginUserController::class,'store']);


Route::get('passwordreset',[PasswordResetController::class,'index']);
Route::post('passwordreset/store',[PasswordResetController::class,'store']);






// Admin


Route::get('admin/users/login',[LoginController::class,'index'])->name('login');

Route::post('admin/users/login/store',[LoginController::class,'store']);


Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/clear_cache', function() {
            Artisan::call('cache:clear');
        }); /// Xóa Cache
        // Route::get('/',[MainController::class, 'index']);
        Route::get('/main',[MainController::class, 'index'])->name('admin');
        // Route::get('main',[SidebarController::class,'load']); //Load Sidebar

        #Menu

        Route::prefix('menus')->group(function(){
            Route::get('/',[MenuController::class,'create']); //Load
            Route::get('/loadMenu',[MenuController::class,'loadMenu']); //Load Menu
            Route::post('/loadComboxMenu',[MenuController::class,'loadComboxMenu']); //Load Selectbox Menu
            Route::post('/destroy/{id}',[MenuController::class,'destroy']); // Del
            Route::post('/',[MenuController::class,'store'])->name('add'); // Add
            Route::post('/edit',[MenuController::class,'edit'])->name('edit'); // Edit
            Route::post('/load/{id}',[MenuController::class,'load'])->name('load'); // Load Row Menu
            Route::get('/sidebar',[MenuController::class,'sidebar'])->name('sidebar'); // Load Sidebar
            Route::post('/loadpage/{id}',[MenuController::class,'loadpage'])->name('loadpage'); // Load Page in Content
        });

        Route::prefix('users')->group(function(){
            Route::get('/',[UsersController::class,'create']); //Load
            Route::post('/',[UsersController::class,'store'])->name('addUser'); // Add User
            Route::get('/loadUsers',[UsersController::class,'loadUsers']); //Load Users
            Route::post('/loadNameUser/{id}',[UsersController::class,'load'])->name('loadNameUser'); // Load name USER

            Route::post('/load/{id}',[UsersController::class,'load'])->name('load'); // Load Row User
            Route::post('/edit',[UsersController::class,'edit'])->name('edit'); // Edit
            Route::post('/destroy/{id}',[UsersController::class,'destroy']); // Del User

            Route::get('/loadUser_Menus_Roles/{id}',[UsersController::class,'loadUser_Menus_Roles']); // Load Roles Of USER
            Route::post('/updateRole/{idmenu}/{idrole}/{iduser}/{check}/{parent}',[UsersController::class,'updateRole']); // Update Role
            // Route::get('/loadUser_Menus_Roles',[UsersController::class,'loadUser_Menus_Roles']); // Load Roles Of USER
        });




        #Sidebar
        // Route::get('/main',[SidebarController::class,'load']); //Load Sidebar

        #Main
        Route::prefix('navar')->group(function(){
            Route::post('/',[NavarController::class,'loadUser']); //Load infor USER
        });


        #Year

        Route::prefix('years')->group(function(){
            Route::get('/',[YearsController::class,'create']); //Load View
            Route::post('/store',[YearsController::class,'store']); // Save Year

        });

         #Schools

         Route::prefix('schools')->group(function(){
            Route::get('/',[SchoolsController::class,'create']); //Load View
            Route::get('/loadProvince',[SchoolsController::class,'loadProvince']); // Load Provinces
            Route::get('/loadSchools/{id}',[SchoolsController::class,'loadSchools']); // Load School

        });

        #Method

        Route::prefix('methods')->group(function(){
            Route::get('/',[MethodsController::class,'create']); //Load View Method
            Route::get('/loadMethods',[MethodsController::class,'loadMethods']); // Load Provinces
            // Route::get('/loadSchools/{id}',[SchoolsController::class,'loadSchools']); // Load School

        });

        // Group_subject
        Route::prefix('/group_sb')->group(function(){
            Route::get('/',[Gruop_SubjectsController::class,'create']); //Load View
            Route::get('/loadSubjects',[Gruop_SubjectsController::class,'loadSubjects']); // Load Provinces
            Route::get('/loadGroups',[Gruop_SubjectsController::class,'loadGroups']); // Load Provinces
            // Route::get('/loadSchools/{id}',[Gruop_SubjectsController::class,'loadSchools']); // Load School
        });
        // Group_subject
        Route::prefix('/checkinfo')->group(function(){
            Route::get('/',[CheckInfoController::class,'create']); //Load View
            Route::get('/testdiem',[CheckInfoController::class,'testdiem']); //Load View
            // Route::get('/loadGroups',[Gruop_SubjectsController::class,'loadGroups']); // Load Provinces
            // Route::get('/loadSchools/{id}',[Gruop_SubjectsController::class,'loadSchools']); // Load School
        });

        //Expenses_admin
        Route::prefix('/expenses_admin')->group(function(){
            Route::get('/',[ExpensesAdminController::class,'index']); //Load View
            Route::get('/search/{id}',[ExpensesAdminController::class,'search']); //Load timf kiem
            Route::get('/wish/{id}',[ExpensesAdminController::class,'wish']); //Load nguyeenj vongj
            Route::post('/charge',[ExpensesAdminController::class,'charge']); //Load nguyeenj vongj
            Route::get('/load_price/{id}',[ExpensesAdminController::class,'load_price']); //Change Year


        });

        //Expenses_admin
        Route::prefix('/checkuser')->group(function(){
            Route::get('/',[CheckUserController::class,'index']); //Load View
            Route::get('/search/{id}',[CheckUserController::class,'search']); //Load View
            Route::get('/load_search',[CheckUserController::class,'load_search']); //Load Years
            Route::get('/changeyear/{id}',[CheckUserController::class,'changeyear']); //Change Year
            Route::get('/changeprovince/{id}',[CheckUserController::class,'changeprovince']); //Change Year
            Route::get('/load_list_reg',[CheckUserController::class,'load_list_reg']); //Change Year



            // Route::get('/wish/{id}',[ExpensesAdminController::class,'wish']); //Load View
        });


        //Expenses_sta
        Route::prefix('/expenses_sta')->group(function(){
            Route::get('/',[ExpensesStaController::class,'index']); //Load View



            // Route::get('/wish/{id}',[ExpensesAdminController::class,'wish']); //Load View
});


    });



});



