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
use \App\Http\Controllers\Admin\Search\LoginSearchController;
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
use \App\Http\Controllers\Admin\AssignmentController;
use \App\Http\Controllers\Admin\AssUserController;
use \App\Http\Controllers\Admin\RegStaController;
use \App\Http\Controllers\Admin\GoController;
use \App\Http\Controllers\Admin\GoSetupController;
use \App\Http\Controllers\Pdf\PdfReusltGoController;
use \App\Http\Controllers\Admin\SidebarController;
use \App\Http\Controllers\Admin\NavarController;
use \App\Http\Controllers\Admin\InvestigateController;
use \App\Http\Controllers\Admin\GoBoController;
use \App\Http\Controllers\Admin\GoBatchBoController;
use \App\Http\Controllers\Admin\GoDataBoController;
use \App\Http\Controllers\Admin\GoDataMark;
use \App\Http\Controllers\Admin\GoDataWish;
use \App\Http\Controllers\Admin\GoVirtual;
use \App\Http\Controllers\Admin\SearchResultBoController;
use \App\Http\Controllers\Admin\UpdateTtsvController;
use \App\Http\Controllers\Admin\ManagerFileController;
use \App\Http\Controllers\Admin\QlsvNvqsController;
use \App\Http\Controllers\Admin\ElectController;
use \App\Http\Controllers\Admin\AdmissionController;
use \App\Http\Controllers\Admin\ManagerFileHSSVController;
use \App\Http\Controllers\Admin\ProvinceController;
use \App\Http\Controllers\Admin\PriorityAreaController;
use \App\Http\Controllers\Admin\PolicyController;
use \App\Http\Controllers\Admin\TFController;



use \App\Http\Controllers\Admin\AddUserController;



//Đồng phục
use \App\Http\Controllers\Admin\Dongphuc\Nhasanxuat\NsxController;
use \App\Http\Controllers\Admin\Dongphuc\Quanlysanpham\QuanlysanphamController;
use \App\Http\Controllers\Admin\Dongphuc\Size\SizeController;
use \App\Http\Controllers\Admin\Dongphuc\Dot\DotController;
use \App\Http\Controllers\Admin\Dongphuc\Nhapsp\NhapspController;
use \App\Http\Controllers\Admin\Dongphuc\Xuathang\XuathangController;
use \App\Http\Controllers\Admin\Dongphuc\Hoadon\HoadonController;


use \App\Http\Controllers\Admin\DoAn\DoanControler;


use \App\Http\Controllers\User_24\Admin\Admin_24Controller;







use App\Http\Controllers\Admin\IOFactory;

use \App\Http\Controllers\ManagerFile\StepSetupControler;
use \App\Http\Controllers\ManagerFile\ProofSetupControler;
use \App\Http\Controllers\ManagerFile\FileGoControler;




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
use \App\Http\Controllers\User\Main\ResultGoController;
use \App\Http\Controllers\User\Main\ResultthptController;


use \App\Http\Controllers\User_24\Thongtincanhan24Controller;
use \App\Http\Controllers\User_24\Loginbygoogle24Controller;
use \App\Http\Controllers\User_24\Lichsuthaotac24Controller;
use \App\Http\Controllers\User_24\Ketquahoctap24Controller;
use \App\Http\Controllers\User_24\Dangkyxettuyen24Controller;
use \App\Http\Controllers\User_24\Thongtinlienhe24Controller;
use \App\Http\Controllers\User_24\Thanhtoanlephi24Controller;

use \App\Http\Controllers\User_24\Admin\Loginbygoogleadmin24Controller;



use \App\Http\Controllers\User_24\TestController;
use \App\Http\Controllers\User_24\ConnectionController;

use Symfony\Component\HttpFoundation\StreamedResponse;

// Route::post('email', [Admin_24Controller::class, 'email']);

Route::get('/login', [Loginbygoogle24Controller::class, 'login']);
// view login admin
Route::get('/loginadmin', [Admin_24Controller::class, 'loginadmin']);

Route::post('/login/truycap', [Admin_24Controller::class, 'truycap']);
// Route::get('admin/login', [Loginbygoogleadmin24Controller::class, 'login']);
Route::get('auth/google', [Loginbygoogle24Controller::class, 'redirectToGoogle'])->name('loginbygoogle');
Route::get('auth/google/callback', [Loginbygoogle24Controller::class, 'handleGoogleCallback']);

Route::middleware(['checklogin24::class'])->group(function () {
    Route::get('/', [Loginbygoogle24Controller::class, 'login']);

    Route::prefix('test')->group(function(){
        Route::get('/',[TestController::class,'index']);
        Route::post('/thanhtoan',[TestController::class,'thanhtoan']);
        // Route::get('/',[TestController::class,'index']);
    });

    Route::prefix('thongtincanhan')->group(function(){
        Route::get('/',[Thongtincanhan24Controller::class,'thongtincanhan']);
        Route::post('/luuthongtincanhan',[Thongtincanhan24Controller::class,'luuthongtincanhan']);
        Route::post('/upload_anhdaidien',[Thongtincanhan24Controller::class,'upload_anhdaidien']);
        Route::post('/upload_cccd',[Thongtincanhan24Controller::class,'upload_cccd']);
        Route::post('/upload_cccdsau',[Thongtincanhan24Controller::class,'upload_cccdsau']);
        Route::post('/upload_hocbathongtin',[Thongtincanhan24Controller::class,'upload_hocbathongtin']);
        Route::post('/upload_hbhocbalop10',[Thongtincanhan24Controller::class,'upload_hbhocbalop10']);
        Route::post('/upload_hocbalop11',[Thongtincanhan24Controller::class,'upload_hocbalop11']);
        Route::post('/upload_hbhocbalop12',[Thongtincanhan24Controller::class,'upload_hbhocbalop12']);
        Route::post('/upload_uutien1',[Thongtincanhan24Controller::class,'upload_uutien1']);
        Route::post('/upload_uutien2',[Thongtincanhan24Controller::class,'upload_uutien2']);
        Route::post('/upload_bangtotnghiep',[Thongtincanhan24Controller::class,'upload_bangtotnghiep']);
        Route::post('/upload_uutien1',[Thongtincanhan24Controller::class,'upload_uutien1']);
        Route::post('/upload_uutien2',[Thongtincanhan24Controller::class,'upload_uutien2']);
        Route::post('/upload_bangtotnghiep',[Thongtincanhan24Controller::class,'upload_bangtotnghiep']);






        // Khu vực ưu tiên
        Route::post('/luutruongthpt',[Thongtincanhan24Controller::class,'luutruongthpt']);
        Route::post('/chuyentinhthpt',[Thongtincanhan24Controller::class,'chuyentinhthpt']);
        Route::post('/namtotnghiep',[Thongtincanhan24Controller::class,'namtotnghiep']);

        //Lưu đối tượng ưu tiên
        Route::post('/luudoituonguutien',[Thongtincanhan24Controller::class,'luudoituonguutien']);
    });

    Route::get('/lichsuthaotac',[Lichsuthaotac24Controller::class,'lichsuthaotac']);
    Route::prefix('ketquahoctap')->group(function(){
        Route::get('/',[Ketquahoctap24Controller::class,'ketquahoctap']);
        Route::post('/luudiemhoctap',[Ketquahoctap24Controller::class,'luudiemhoctap']);
    });

    Route::prefix('dangkyxettuyen')->group(function(){
        Route::get('/',[Dangkyxettuyen24Controller::class,'dangkyxettuyen']);
        Route::post('/luunguyenvong',[Dangkyxettuyen24Controller::class,'luunguyenvong']);
        Route::post('/dangky',[Dangkyxettuyen24Controller::class,'dangky']);
        Route::post('/yeucaucapnhat',[Dangkyxettuyen24Controller::class,'yeucaucapnhat']);




        // Route::post('/luudiemhoctap',[Ketquahoctap24Controller::class,'luudiemhoctap']);
    });

    Route::prefix('thongtinlienhe')->group(function(){
        Route::get('/',[Thongtinlienhe24Controller::class,'thongtinlienhe']);
    });

    Route::prefix('thanhtoanlephi')->group(function(){
        Route::get('/',[Thanhtoanlephi24Controller::class,'thanhtoanlephi']);
        Route::GET('/load-bank', [Thanhtoanlephi24Controller::class, 'load_bank']);
        Route::POST('/layqrcode', [Thanhtoanlephi24Controller::class, 'layqrcode']);
        Route::GET('/load_tg', [Thanhtoanlephi24Controller::class, 'load_tg']);
    });

    Route::prefix('logout')->group(function(){
            Route::post('/',[Loginbygoogle24Controller::class,'logout']);
    });






    // Route::prefix('admin24')->group(function(){
    //     Route::get('/main',[Admin_24Controller::class,'index']);

    //     Route::post('/logout',[Loginbygoogle24Controller::class,'logout']);

    //     //Trang contentheader
    //     Route::get('/contentheader/{duongdan}',[Admin_24Controller::class,'contentheader']);
    //     Route::get('/lay_id_manhinh/{duongdan}/{id_chucnang}',[Admin_24Controller::class,'lay_id_manhinh']);

    //     //Trang home
    //     Route::get('/bieudo',[Admin_24Controller::class,'bieudo']);

    //     //Quản lý thí sinh
    //     Route::get('/quanlyhoso',[Admin_24Controller::class,'quanlyhoso']);




    //     // Quản lý tài khoản
    //     Route::get('/quanlytaikhoan', [Admin_24Controller::class, 'quanlytaikhoan']);
    //     Route::get('/danhsachtaikhoan/{id_manhinh}', [Admin_24Controller::class, 'danhsachtaikhoan']);
    //     Route::post('themtaikhoan', [Admin_24Controller::class, 'themtaikhoan']);
    //     Route::get('edit_accounts', [Admin_24Controller::class, 'edit_accounts']);
    //     Route::post('update_accounts', [Admin_24Controller::class, 'update_accounts']);
    //     Route::post('delete_accounts', [Admin_24Controller::class, 'delete_accounts']);

    //     Route::get('testchackhongdc', [Admin_24Controller::class, 'testchackhongdc']);


    //     //Phân quyền
    //     Route::get('loadUser_Menus_Roles', [Admin_24Controller::class, 'loadUser_Menus_Roles']);
    //     Route::post('capnhatquyen', [Admin_24Controller::class, 'capnhatquyen']);
    //     Route::post('kiemtraquyenmanhinh', [Admin_24Controller::class, 'kiemtraquyenmanhinh']);





    //     //Quản lý chức năng
    //     Route::get('/quanlychucnang', [Admin_24Controller::class, 'quanlychucnang']);
    //     Route::get('/quanlychucnang/ds_chucnang', [Admin_24Controller::class, 'ds_chucnang']);
    //     Route::post('/quanlychucnang/add_new_settings', [Admin_24Controller::class, 'Add_new_settings']);
    //     Route::get('/quanlychucnang/edit_setting/{id}', [Admin_24Controller::class, 'edit_chucnang']);
    //     Route::post('/quanlychucnang/update_chucnang', [Admin_24Controller::class, 'update_chucnang']);
    //     Route::post('/quanlychucnang/delete_chucnang/{id}', [Admin_24Controller::class, 'delete_chucnang']);


    //     // Quản lý màn hinh
    //     Route::get('/quanlymanhinh', [Admin_24Controller::class, 'quanlymanhinh']);
    //     Route::get('/manhinhgoc', [Admin_24Controller::class, 'manhinhgoc']);
    //     Route::get('/ds_manhinh', [Admin_24Controller::class, 'ds_manhinh']);
    //     Route::post('Add_new_Menu', [Admin_24Controller::class, 'Add_new_Menu']);
    //     Route::get('edit_manhinh/{id}', [Admin_24Controller::class, 'edit_manhinh']);
    //     Route::post('dlt_manhinh/{id}', [Admin_24Controller::class, 'dlt_manhinh']);
    //     Route::post('update_manhinh', [Admin_24Controller::class, 'update_manhinh']);
    //     Route::get('data_tables_menus/{id}', [Admin_24Controller::class, 'data_tables_menus']);
    //     Route::post('Update_chucnang_manhinh', [Admin_24Controller::class, 'Update_chucnang_manhinh']);


    //     //Quan ly nhap hoc
    //     Route::get('/hosonhaphoc',[Admin_24Controller::class,'hosonhaphoc']);
    //     Route::get('/hosonhaphoc/loadttcn/{id_taikhoan}',[Admin_24Controller::class,'loadttcn']);





    //     //Quản ly mail
    //     // Route::get('/mailduthao',[Admin_24Controller::class,'mailduthao']);
    //     // Route::get('/tim_maumail/{id}', [Admin_24Controller::class, 'tim_maumail']);
    //     // Route::get('/tt_mail_sinhvien', [Admin_24Controller::class, 'tt_mail_sinhvien']);
    //     // Route::post('/mail_checked', [Admin_24Controller::class, 'mail_checked_quan']);
    //     // Route::post('guimail_test', [Admin_24Controller::class, 'guimailtest']);
    //     // Route::post('guimail_test', [Admin_24Controller::class, 'guimailtest']);
    //     // Route::get('/testmail',[Admin_24Controller::class,'testmail']);
    //     // Route::get('/danhsachdagui',[Admin_24Controller::class,'danhsachdagui']);
    //     // Route::get('/click-counter',[Admin_24Controller::class,'click_counter']);
    //     // Route::get('/sse',[Admin_24Controller::class,'stream']);
    //     // // Route::get('/sse',[Admin_24Controller::class,'stream']);
    //     // Route::get('/startqueue',[Admin_24Controller::class,'startqueue']);
    //     // Route::get('/resetqueue',[Admin_24Controller::class,'resetqueue']);
    //     // Route::get('table_tientrinhguimail', [Admin_24Controller::class, 'table_tientrinhguimail']);
    //     // Route::get('table_tientrinhguimail_active', [Admin_24Controller::class, 'table_tientrinhguimail_active']);


    //     Route::get('/mailduthao',[Admin_24Controller::class,'mailduthao']);
    //     Route::get('/tt_mail_sinhvien/{dottuyensinh}/{dotmail}/{dangky}/{lephi}', [Admin_24Controller::class, 'tt_mail_sinhvien']);

    //     Route::get('/tim_maumail/{id}', [Admin_24Controller::class, 'tim_maumail']);
    //     Route::post('/themds_guimail', [Admin_24Controller::class, 'themds_guimail']);
    //     Route::post('/mail_xoadanhsach', [Admin_24Controller::class, 'mail_xoadanhsach']);
    //     Route::get('/sse', [Admin_24Controller::class, 'sse']);
    //     Route::get('/xemtientrinh', [Admin_24Controller::class, 'xemtientrinh']);
    //     Route::get('/kiemtra_guimail', [Admin_24Controller::class, 'kiemtra_guimail']);
    //     Route::get('/guimail2', [Admin_24Controller::class, 'guimail2']);
    //     Route::get('/xulysauguimail', [Admin_24Controller::class, 'xulysauguimail']);


    //     Route::get('/test', [Admin_24Controller::class, 'test']);

    //     //Quản lý mail
    //     Route::get('/quanlymail', [Admin_24Controller::class, 'quanlymail']);
    //     Route::get('/ds_mail', [Admin_24Controller::class, 'list_mail']);
    //     Route::get('/copy_mail/{id}', [Admin_24Controller::class, 'copy_mail']);
    //     Route::get('/load_mail/{id}', [Admin_24Controller::class, 'load_mail']);
    //     Route::post('/remove_mail/{id}', [Admin_24Controller::class, 'remove_mail']);
    //     Route::post('/add_mail', [Admin_24Controller::class, 'add_mail']);
    //     Route::post('/update_mail', [Admin_24Controller::class, 'update_mail']);
    //     Route::post('/gui_thu', [Admin_24Controller::class, 'gui_thu']);
    //     Route::get('/modal_mail', [Admin_24Controller::class, 'modal_mail']);



    //     // Route::post('/mail_checked', [Admin_24Controller::class, 'mail_checked_quan']);

    //     // Route::post('guimail_test', [Admin_24Controller::class, 'guimailtest']);












    //          //Quản lý lệ phi
    //     //Danh sách hóa đơn
    //     Route::get('/hosotructuyen',[Admin_24Controller::class,'hosotructuyen']);
    //     Route::get('/loadhosolephi/{val}',[Admin_24Controller::class,'loadhosolephi']);
    //     Route::get('/exceldanhsachtructuyen/{id_dot}',[Admin_24Controller::class,'exceldanhsachtructuyen']);
    //     Route::get('/thongkelephitheotrangthai/{id_dot}',[Admin_24Controller::class,'thongkelephitheotrangthai']);

    //     //Thu lệ phí
    //     Route::get('/thulephi',[Admin_24Controller::class,'thulephi']);
    //     Route::get('/ttsv_donglephi/{id}', [Admin_24Controller::class, 'ttsv_donglephi']);
    //     Route::post('/thanhtoan', [Admin_24Controller::class, 'thanhtoan']);
    //     Route::get('/ds_hoadon/{id}', [Admin_24Controller::class, 'ds_hoadon']);
    //     Route::post('/delete_hoadon/{id}', [Admin_24Controller::class, 'delete_hoadon']);


    //         //Phân công hồ sơ
    //     Route::get('/phanconghoso',[Admin_24Controller::class,'phanconghoso']);
    //     Route::get('/hoso_danhsach/{id_nam}',[Admin_24Controller::class,'hoso_danhsach']);
    //     Route::get('/kiemtra_pchoso',[Admin_24Controller::class,'kiemtra_pchoso']);
    //     Route::get('/ds_canbo',[Admin_24Controller::class,'ds_canbo']);
    //     Route::post('/phancong',[Admin_24Controller::class,'phancong']);
    //     Route::get('/phancong_exel/{hoten}/{email}/{kiemtra}/{trangthaiduyet}/{trangthaikhoa}/{trangthai}/{id_nam}',[Admin_24Controller::class,'phancong_exel']);

    //         // Phân công kiểm tra hồ sơ new
    //     Route::get('/phancongkiemtrahoso',[Admin_24Controller::class,'phancongkiemtrahoso']);
    //     Route::get('/hoso_danhsach_kiemtra/{id_nam}',[Admin_24Controller::class,'hoso_danhsach_kiemtra']);
    //     Route::get('/load_trangthai_pckiemtra',[Admin_24Controller::class,'load_trangthai_pckiemtra']);
    //     Route::get('/ds_canbo_kiemtra',[Admin_24Controller::class,'ds_canbo_kiemtra']);
    //     Route::post('/phancong_canbokiemtra',[Admin_24Controller::class,'phancong_canbokiemtra']);


    //         //Phân công duyệt hồ sơ
    //     Route::get('/phancongduyethoso',[Admin_24Controller::class,'phancongduyethoso']);
    //     Route::get('/hoso_danhsach_duyet/{id_nam}',[Admin_24Controller::class,'hoso_danhsach_duyet']);
    //     Route::get('/load_trangthai_pcduyet',[Admin_24Controller::class,'load_trangthai_pcduyet']);
    //     Route::get('/ds_canbo_duyet',[Admin_24Controller::class,'ds_canbo_duyet']);
    //     Route::post('/phancong_canboduyet',[Admin_24Controller::class,'phancong_canboduyet']);

    //     // Cài đặt chức năng quản lý hồ sơ
    //     // Route::get('/caidathoso',[Admin_24Controller::class,'caidathoso']);














    //     // Tra cứu thí sinh
    //     Route::get('/tracuuthisinh',[Admin_24Controller::class,'tracuuthisinh']);
    //     Route::get('/timkiemthisinh',[Admin_24Controller::class,'timkiemthisinh']);
    //     Route::get('/change_tinh10/{idtinh}',[Admin_24Controller::class,'change_tinh10']);
    //     Route::get('/change_tinh11/{idtinh}',[Admin_24Controller::class,'change_tinh11']);
    //     Route::get('/change_tinh12/{idtinh}',[Admin_24Controller::class,'change_tinh12']);
    //     Route::post('/capnhatthongtincanhan1',[Admin_24Controller::class,'capnhatthongtincanhan']);
    //     // Route::post('/capnhattinhlop',[Admin_24Controller::class,'capnhattinhlop']);
    //     Route::post('/capnhattruonglop1',[Admin_24Controller::class,'capnhattruonglop1']);
    //     Route::post('/capnhatketquahoctap',[Admin_24Controller::class,'capnhatketquahoctap']);
    //     Route::post('/capnhatnguyenvong',[Admin_24Controller::class,'capnhatnguyenvong']);
    //     Route::post('/capnhatdoituong1',[Admin_24Controller::class,'capnhatdoituong1']);
    //     Route::post('/capnhatnamtn',[Admin_24Controller::class,'capnhatnamtn']);
    //     Route::post('/khoahoso',[Admin_24Controller::class,'khoahoso']);
    //     Route::post('/duyethoso',[Admin_24Controller::class,'duyethoso']);
    //     Route::get('/kiemtra_danhsachhoso',[Admin_24Controller::class,'kiemtra_danhsachhoso']);
    //     Route::get('/load_trangthai',[Admin_24Controller::class,'load_trangthai']);
    //     // gửi mail tra cứu thí sinh
    //     Route::post('/guimail_kiemtrahoso',[Admin_24Controller::class,'guimail_kiemtrahoso']);






    // });

});

Route::get('/dangnhap_admin', [Admin_24Controller::class, 'dangnhap_admin']);
Route::middleware(['loginadmin::class'])->group(function () {
    Route::prefix('admin24')->group(function(){
        Route::get('/main',[Admin_24Controller::class,'index']);

        Route::post('/logout',[Loginbygoogle24Controller::class,'logout']);

        //Trang contentheader
        Route::get('/contentheader/{duongdan}',[Admin_24Controller::class,'contentheader']);
        Route::get('/lay_id_manhinh/{duongdan}/{id_chucnang}',[Admin_24Controller::class,'lay_id_manhinh']);

        //Trang home
        Route::get('/bieudo',[Admin_24Controller::class,'bieudo']);

        //Quản lý thí sinh
        Route::get('/quanlyhoso',[Admin_24Controller::class,'quanlyhoso']);




        // Quản lý tài khoản
        Route::get('/quanlytaikhoan', [Admin_24Controller::class, 'quanlytaikhoan']);
        Route::get('/danhsachtaikhoan/{id_manhinh}', [Admin_24Controller::class, 'danhsachtaikhoan']);
        Route::post('themtaikhoan', [Admin_24Controller::class, 'themtaikhoan']);
        Route::get('edit_accounts', [Admin_24Controller::class, 'edit_accounts']);
        Route::post('update_accounts', [Admin_24Controller::class, 'update_accounts']);
        Route::post('delete_accounts', [Admin_24Controller::class, 'delete_accounts']);

        Route::get('testchackhongdc', [Admin_24Controller::class, 'testchackhongdc']);


        //Phân quyền
        Route::get('loadUser_Menus_Roles', [Admin_24Controller::class, 'loadUser_Menus_Roles']);
        Route::post('capnhatquyen', [Admin_24Controller::class, 'capnhatquyen']);
        Route::post('kiemtraquyenmanhinh', [Admin_24Controller::class, 'kiemtraquyenmanhinh']);





        //Quản lý chức năng
        Route::get('/quanlychucnang', [Admin_24Controller::class, 'quanlychucnang']);
        Route::get('/quanlychucnang/ds_chucnang', [Admin_24Controller::class, 'ds_chucnang']);
        Route::post('/quanlychucnang/add_new_settings', [Admin_24Controller::class, 'Add_new_settings']);
        Route::get('/quanlychucnang/edit_setting/{id}', [Admin_24Controller::class, 'edit_chucnang']);
        Route::post('/quanlychucnang/update_chucnang', [Admin_24Controller::class, 'update_chucnang']);
        Route::post('/quanlychucnang/delete_chucnang/{id}', [Admin_24Controller::class, 'delete_chucnang']);


        // Quản lý màn hinh
        Route::get('/quanlymanhinh', [Admin_24Controller::class, 'quanlymanhinh']);
        Route::get('/manhinhgoc', [Admin_24Controller::class, 'manhinhgoc']);
        Route::get('/ds_manhinh', [Admin_24Controller::class, 'ds_manhinh']);
        Route::post('Add_new_Menu', [Admin_24Controller::class, 'Add_new_Menu']);
        Route::get('edit_manhinh/{id}', [Admin_24Controller::class, 'edit_manhinh']);
        Route::post('dlt_manhinh/{id}', [Admin_24Controller::class, 'dlt_manhinh']);
        Route::post('update_manhinh', [Admin_24Controller::class, 'update_manhinh']);
        Route::get('data_tables_menus/{id}', [Admin_24Controller::class, 'data_tables_menus']);
        Route::post('Update_chucnang_manhinh', [Admin_24Controller::class, 'Update_chucnang_manhinh']);


        //Quan ly nhap hoc
        Route::get('/hosonhaphoc',[Admin_24Controller::class,'hosonhaphoc']);
        Route::get('/hosonhaphoc/loadttcn/{id_taikhoan}',[Admin_24Controller::class,'loadttcn']);





        //Quản ly mail
        // Route::get('/mailduthao',[Admin_24Controller::class,'mailduthao']);
        // Route::get('/tim_maumail/{id}', [Admin_24Controller::class, 'tim_maumail']);
        // Route::get('/tt_mail_sinhvien', [Admin_24Controller::class, 'tt_mail_sinhvien']);
        // Route::post('/mail_checked', [Admin_24Controller::class, 'mail_checked_quan']);
        // Route::post('guimail_test', [Admin_24Controller::class, 'guimailtest']);
        // Route::post('guimail_test', [Admin_24Controller::class, 'guimailtest']);
        // Route::get('/testmail',[Admin_24Controller::class,'testmail']);
        // Route::get('/danhsachdagui',[Admin_24Controller::class,'danhsachdagui']);
        // Route::get('/click-counter',[Admin_24Controller::class,'click_counter']);
        // Route::get('/sse',[Admin_24Controller::class,'stream']);
        // // Route::get('/sse',[Admin_24Controller::class,'stream']);
        // Route::get('/startqueue',[Admin_24Controller::class,'startqueue']);
        // Route::get('/resetqueue',[Admin_24Controller::class,'resetqueue']);
        // Route::get('table_tientrinhguimail', [Admin_24Controller::class, 'table_tientrinhguimail']);
        // Route::get('table_tientrinhguimail_active', [Admin_24Controller::class, 'table_tientrinhguimail_active']);


        Route::get('/mailduthao',[Admin_24Controller::class,'mailduthao']);
        Route::get('/tt_mail_sinhvien/{dottuyensinh}/{dotmail}/{dangky}/{lephi}', [Admin_24Controller::class, 'tt_mail_sinhvien']);

        Route::get('/tim_maumail/{id}', [Admin_24Controller::class, 'tim_maumail']);
        Route::post('/themds_guimail', [Admin_24Controller::class, 'themds_guimail']);
        Route::post('/mail_xoadanhsach', [Admin_24Controller::class, 'mail_xoadanhsach']);
        Route::get('/sse', [Admin_24Controller::class, 'sse']);
        Route::get('/xemtientrinh', [Admin_24Controller::class, 'xemtientrinh']);
        Route::get('/kiemtra_guimail', [Admin_24Controller::class, 'kiemtra_guimail']);
        Route::get('/guimail2', [Admin_24Controller::class, 'guimail2']);
        Route::get('/xulysauguimail', [Admin_24Controller::class, 'xulysauguimail']);


        Route::get('/test', [Admin_24Controller::class, 'test']);

        //Quản lý mail
        Route::get('/quanlymail', [Admin_24Controller::class, 'quanlymail']);
        Route::get('/ds_mail', [Admin_24Controller::class, 'list_mail']);
        Route::get('/copy_mail/{id}', [Admin_24Controller::class, 'copy_mail']);
        Route::get('/load_mail/{id}', [Admin_24Controller::class, 'load_mail']);
        Route::post('/remove_mail/{id}', [Admin_24Controller::class, 'remove_mail']);
        Route::post('/add_mail', [Admin_24Controller::class, 'add_mail']);
        Route::post('/update_mail', [Admin_24Controller::class, 'update_mail']);
        Route::post('/gui_thu', [Admin_24Controller::class, 'gui_thu']);
        Route::get('/modal_mail', [Admin_24Controller::class, 'modal_mail']);



        // Route::post('/mail_checked', [Admin_24Controller::class, 'mail_checked_quan']);

        // Route::post('guimail_test', [Admin_24Controller::class, 'guimailtest']);












             //Quản lý lệ phi
        //Danh sách hóa đơn
        Route::get('/hosotructuyen',[Admin_24Controller::class,'hosotructuyen']);
        Route::get('/loadhosolephi/{val}',[Admin_24Controller::class,'loadhosolephi']);
        Route::get('/exceldanhsachtructuyen/{id_dot}',[Admin_24Controller::class,'exceldanhsachtructuyen']);
        Route::get('/thongkelephitheotrangthai/{id_dot}',[Admin_24Controller::class,'thongkelephitheotrangthai']);

        //Thu lệ phí
        Route::get('/thulephi',[Admin_24Controller::class,'thulephi']);
        Route::get('/ttsv_donglephi/{id}', [Admin_24Controller::class, 'ttsv_donglephi']);
        Route::post('/thanhtoan', [Admin_24Controller::class, 'thanhtoan']);
        Route::get('/ds_hoadon/{id}', [Admin_24Controller::class, 'ds_hoadon']);
        Route::post('/delete_hoadon/{id}', [Admin_24Controller::class, 'delete_hoadon']);


            //Phân công hồ sơ
        Route::get('/phanconghoso',[Admin_24Controller::class,'phanconghoso']);
        Route::get('/hoso_danhsach/{id_nam}',[Admin_24Controller::class,'hoso_danhsach']);
        Route::get('/kiemtra_pchoso',[Admin_24Controller::class,'kiemtra_pchoso']);
        Route::get('/ds_canbo',[Admin_24Controller::class,'ds_canbo']);
        Route::post('/phancong',[Admin_24Controller::class,'phancong']);
        Route::get('/phancong_exel/{hoten}/{email}/{kiemtra}/{trangthaiduyet}/{trangthaikhoa}/{trangthai}/{id_nam}',[Admin_24Controller::class,'phancong_exel']);

            // Phân công kiểm tra hồ sơ new
        Route::get('/phancongkiemtrahoso',[Admin_24Controller::class,'phancongkiemtrahoso']);
        Route::get('/hoso_danhsach_kiemtra/{id_nam}',[Admin_24Controller::class,'hoso_danhsach_kiemtra']);
        Route::get('/load_trangthai_pckiemtra',[Admin_24Controller::class,'load_trangthai_pckiemtra']);
        Route::get('/ds_canbo_kiemtra',[Admin_24Controller::class,'ds_canbo_kiemtra']);
        Route::post('/phancong_canbokiemtra',[Admin_24Controller::class,'phancong_canbokiemtra']);


            //Phân công duyệt hồ sơ
        Route::get('/phancongduyethoso',[Admin_24Controller::class,'phancongduyethoso']);
        Route::get('/hoso_danhsach_duyet/{id_nam}',[Admin_24Controller::class,'hoso_danhsach_duyet']);
        Route::get('/load_trangthai_pcduyet',[Admin_24Controller::class,'load_trangthai_pcduyet']);
        Route::get('/ds_canbo_duyet',[Admin_24Controller::class,'ds_canbo_duyet']);
        Route::post('/phancong_canboduyet',[Admin_24Controller::class,'phancong_canboduyet']);

        // Cài đặt chức năng quản lý hồ sơ
        // Route::get('/caidathoso',[Admin_24Controller::class,'caidathoso']);














        // Tra cứu thí sinh
        Route::get('/tracuuthisinh',[Admin_24Controller::class,'tracuuthisinh']);
        Route::get('/timkiemthisinh',[Admin_24Controller::class,'timkiemthisinh']);
        Route::get('/change_tinh10/{idtinh}',[Admin_24Controller::class,'change_tinh10']);
        Route::get('/change_tinh11/{idtinh}',[Admin_24Controller::class,'change_tinh11']);
        Route::get('/change_tinh12/{idtinh}',[Admin_24Controller::class,'change_tinh12']);
        Route::post('/capnhatthongtincanhan1',[Admin_24Controller::class,'capnhatthongtincanhan']);
        // Route::post('/capnhattinhlop',[Admin_24Controller::class,'capnhattinhlop']);
        Route::post('/capnhattruonglop1',[Admin_24Controller::class,'capnhattruonglop1']);
        Route::post('/capnhatketquahoctap',[Admin_24Controller::class,'capnhatketquahoctap']);
        Route::post('/capnhatnguyenvong',[Admin_24Controller::class,'capnhatnguyenvong']);
        Route::post('/capnhatdoituong1',[Admin_24Controller::class,'capnhatdoituong1']);
        Route::post('/capnhatnamtn',[Admin_24Controller::class,'capnhatnamtn']);
        Route::post('/khoahoso',[Admin_24Controller::class,'khoahoso']);
        Route::post('/duyethoso',[Admin_24Controller::class,'duyethoso']);
        Route::get('/kiemtra_danhsachhoso',[Admin_24Controller::class,'kiemtra_danhsachhoso']);
        Route::get('/load_trangthai',[Admin_24Controller::class,'load_trangthai']);
        // gửi mail tra cứu thí sinh
        Route::post('/guimail_kiemtrahoso',[Admin_24Controller::class,'guimail_kiemtrahoso']);






    });


});







// Route::get('tracuuketqua',[LoginSearchController::class,'index']);
// Route::get('tracuuketqua/batch_login',[LoginSearchController::class,'batch_login']);
// Route::post('tracuuketqua/login',[LoginSearchController::class,'login']);
// Route::post('tracuuketqua/z',[LoginSearchController::class,'z']);

// Route::middleware('search::class')->group(function () {
//     Route::prefix('/tracuuketqua')->group(function(){
//         Route::get('/main',[SearchResultBoController::class,'main']);
//         Route::post('/search_check',[SearchResultBoController::class,'search_check']);
//         Route::post('/pronvince',[SearchResultBoController::class,'pronvince']);
//         Route::post('/search_submit',[SearchResultBoController::class,'search_submit']);
//         Route::post('/load_swiper_search',[SearchResultBoController::class,'load_swiper_search']);
//         Route::post('/search_upload_cmnd_submit',[SearchResultBoController::class,'search_upload_cmnd_submit']);
//         Route::post('/search_upload_cmnd2_submit',[SearchResultBoController::class,'search_upload_cmnd2_submit']);
//         Route::post('/search_upload_kqthi_submit',[SearchResultBoController::class,'search_upload_kqthi_submit']);
//         Route::post('/search_upload_tn_submit',[SearchResultBoController::class,'search_upload_tn_submit']);
//         Route::post('/search_upload_10_submit',[SearchResultBoController::class,'search_upload_10_submit']);
//         Route::post('/search_upload_9_submit',[SearchResultBoController::class,'search_upload_9_submit']);
//         Route::post('/search_upload_11_submit',[SearchResultBoController::class,'search_upload_11_submit']);
//         Route::post('/search_upload_12_submit',[SearchResultBoController::class,'search_upload_12_submit']);
//         Route::post('/search_upload_gks_submit',[SearchResultBoController::class,'search_upload_gks_submit']);
//         Route::post('/search_upload_btn_submit',[SearchResultBoController::class,'search_upload_btn_submit']);
//         Route::post('/search_bosung',[SearchResultBoController::class,'search_bosung']);
//         Route::post('/insv',[SearchResultBoController::class,'insv']);
//     });
// });


// User
// Route::middleware('checklogin::class')->group(function () {
//     Route::get('/',[MainUserController::class, 'index'])->name('index');
//     Route::prefix('/')->group(function(){
//         Route::get('/sidebar',[MainUserController::class,'sidebar']); // Load Sidebar
//         Route::post('/logout',[MainUserController::class,'logout']); // Load Sidebar
//         // Main
//         Route::get('/loaduser_Img',[MainUserController::class,'loaduser_Img']); // Load Sidebar
//         Route::get('/changepass',[MainUserController::class,'changepass']); // Load Sidebar
//         Route::get('/updatepassword',[MainUserController::class,'updatepassword']); // Load Sidebar
//         Route::post('/loadpage/{id}',[MainUserController::class,'loadpage']); // Load Sidebar
//         //Info

//         Route::prefix('/info')->group(function(){
//             Route::get('/',[InfoUserController::class,'index']); // Index Thông tin cá nhân
//             Route::get('/check_reg',[InfoUserController::class,'check_reg']); // Index Thông tin cá nhân
//                 Route::get('/placeUser',[InfoUserController::class,'placeUser']); // Load Nơi sinh
//                 Route::get('/nationUser',[InfoUserController::class,'nationUser']); // Load Dân tộc
//                 Route::get('/loadInfoUser',[InfoUserController::class,'loadInfoUser']); // Load Thông tin cơ bản
//                 Route::get('/loadRegister',[InfoUserController::class,'loadRegister']); // Load thông tin đăng ký
//                 Route::post('/province',[InfoUserController::class,'province']); // Load Hộ khẩu thường trú Tỉnh
//                 Route::get('/province2',[InfoUserController::class,'province2']); // Load Hộ khẩu thường trú Huyện
//                 Route::get('/province3',[InfoUserController::class,'province3']); // Load Hộ khẩu thường trú Xã
//                 Route::post('/change_province',[InfoUserController::class,'change_province']); // Change Tỉnh thì Huyện thay đổi
//                 Route::post('/change_province2',[InfoUserController::class,'change_province2']); // Change Huyện thì Xã thay đổi
//                 Route::post('/add_infoUser',[InfoUserController::class,'add_infoUser']); // Cập nhật, thêm mới thông tin cá nhân

//             //Trường THPT
//                 Route::get('/province_shool_10',[InfoUserController::class,'province_shool_10']); // Load Trường lớp 10
//                 Route::get('/province_shool_11',[InfoUserController::class,'province_shool_11']); // Load Trường lớp 11
//                 Route::get('/province_shool_12',[InfoUserController::class,'province_shool_12']); // Load Trường lớp 12
//                 Route::get('/province_shools/{id}',[InfoUserController::class,'province_shools']); // Change Tỉnh thay đổi Trường
//                 Route::post('/area/{id}',[InfoUserController::class,'area']); // Change Trường thay đổi khu vực
//                 Route::post('/addArea',[InfoUserController::class,'addArea']); // Add Trường tính khu vực ưu tiên
//                 Route::post('/delArea/{id}',[InfoUserController::class,'delArea']); // Del Trường
//                 Route::get('/Priority_area',[InfoUserController::class,'Priority_area']); // Load Khu vực ưu tiên
//                 Route::get('/province_shool',[InfoUserController::class,'province_shool']); // Load Khu vực ưu tiên
//                 Route::get('/Priority_Policy',[InfoUserController::class,'Priority_Policy']); // Load chính sach ưu tiên
//                 Route::get('/changePriority_Policy/{id}',[InfoUserController::class,'changePriority_Policy']); // Change chính sách ưu tiên thì thay đổi hướng dẫn
//                 Route::post('/addPriority_policy',[InfoUserController::class,'addPriority_policy']); // Lưu đối tượng ưu tiên
//                 Route::get('/loadnote_Priority_Policy',[InfoUserController::class,'loadnote_Priority_Policy']); // Load Hướng dẫn chính sách ưu tiên
//                 Route::post('/crop_policy',[InfoUserController::class,'crop_policy']); // Lưu ảnh đối tượng ưu tiên
//             });
//             //Result HB
//         Route::prefix('/result_hb')->group(function(){
//             Route::get('/',[ResulthbController::class,'index']); // Load index
//                 Route::get('/loadSubjects',[ResulthbController::class,'loadSubjects']); // LoadSubject
//                 Route::post('/slider_hb',[ResulthbController::class,'slider_hb']); // Lưu Ảnh học bạ
//                 Route::get('/loadslider_hb',[ResulthbController::class,'loadslider_hb']); // Lưu Ảnh học bạ
//                 Route::post('/addResult',[ResulthbController::class,'addResult']); // Lưu Ảnh học bạ
//                 Route::get('/check_img',[ResulthbController::class,'check_img']); //Check ddur anh hocj baj
//         });

//         //Result Nawng luc
//         Route::prefix('/result_nl')->group(function(){
//             Route::get('/',[ResultnlController::class,'index']); // Load index
//             Route::get('/loadSubjects',[ResultnlController::class,'loadSubjects']); // LoadSubject
//             Route::get('/loadImg_nl',[ResultnlController::class,'loadImg_nl']); // LoadSubject
//             Route::post('/slider_nl',[ResultnlController::class,'slider_nl']); // Lưu Ảnh học bạ
//             Route::post('/addResult_nl',[ResultnlController::class,'addResult_nl']); // Lưu Ảnh học bạ

//         });

//         Route::prefix('/result_thpt')->group(function(){
//             Route::get('/',[ResultthptController::class,'index']); // Load index
//                 Route::get('/loadSubjects',[ResultthptController::class,'loadSubjects']); // LoadSubject
//                 Route::post('/save_img_result_thpt',[ResultthptController::class,'save_img_result_thpt']); // Lưu Ảnh học bạ
//                 Route::get('/loadslider_thpt',[ResultthptController::class,'loadslider_thpt']); // Lưu Ảnh học bạ
//                 Route::post('/addResult_thpt',[ResultthptController::class,'addResult_thpt']); // Lưu Ảnh học bạ
//                 // Route::get('/check_img',[ResultthptController::class,'check_img']); //Check ddur anh hocj baj
//         });

//       //Register_Wish
//         Route::prefix('/registerwish')->group(function(){
//             Route::get('/',[RegisterWishController::class,'index']); // Load index
//             // Route::get('/loadsuggest_group',[RegisterWishController::class,'loadsuggest_group']); // Load gợi ý điểm
//             // Route::get('/loadriority_area',[RegisterWishController::class,'loadriority_area']); // Load index
//             Route::get('/load_wish',[RegisterWishController::class,'load_wish']); // Load gợi ý điểm
//             Route::post('/save_wish',[RegisterWishController::class,'save_wish']); //  Lưu nguyện vọng
//             Route::post('/add_wish/{id}',[RegisterWishController::class,'add_wish']); // Thêm nguyện vọng
//             Route::post('/change_method',[RegisterWishController::class,'change_method']); // Change Phuowg thức
//             Route::post('/change_major',[RegisterWishController::class,'change_major']); // Change ngành
//             Route::post('/change_group',[RegisterWishController::class,'change_group']); // Change ngành
//             Route::get('/del_wish/{id}',[RegisterWishController::class,'del_wish']); // Del Nguyện vọng
//             Route::post('/reg_wish',[RegisterWishController::class,'reg_wish']); // Đăng ký nguyện vọng
//             Route::post('/check_reg',[RegisterWishController::class,'check_reg']); // Check đã đăng ký nguyện vọng
//             Route::post('/check_expenses/{id}',[RegisterWishController::class,'check_expenses']); // Check đã đăng ký nguyện vọng
//             Route::post('/check_khop',[RegisterWishController::class,'check_khop']); // Check đã đăng ký nguyện vọng
//             Route::post('/edit_wish_sc',[RegisterWishController::class,'edit_wish_sc']); // Check đã đăng ký nguyện vọng
//             Route::get('/block_user',[RegisterWishController::class,'block_user']); // Check đã đăng ký nguyện vọng

//         });

//         //Expenses
//         Route::prefix('/expenses')->group(function(){
//             Route::get('/',[ExpensesController::class,'index']); // Load index
//             Route::get('/load_expenses_wish',[ExpensesController::class,'load_expenses_wish']); // Load Danh sách nguyện vọng
//             Route::get('/load_expenses_img',[ExpensesController::class,'load_expenses_img']); // Load Danh sách nguyện vọng
//             Route::get('/save_expenses_wish',[ExpensesController::class,'save_expenses_wish']); // Save danh sách ngành đóng lệ phí
//             Route::post('/crop_ex',[ExpensesController::class,'crop_ex']); // Save hình ảnh lệ phí
//             Route::get('/load_price',[ExpensesController::class,'load_price']); // Lấy thông tin lệ phí xét tuyển
//         });

//         //Instruct
//         Route::prefix('/instruct')->group(function(){
//             Route::get('/',[InstructController::class,'index']); // Load index
//             Route::get('/load_active',[InstructController::class,'load_active']); // Load hướng dẫn

//         });

//         //Thông báo đủ điều kiện trúng tuyển
//         Route::prefix('/go_result')->group(function(){
//             Route::get('/',[ResultGoController::class,'index']); // Load index
//             Route::get('/load_result',[ResultGoController::class,'load_result']); // Load thông tin
//             Route::get('/load_info',[ResultGoController::class,'load_info']); // Load thông tin
//             Route::get('/go_wish',[ResultGoController::class,'go_wish']); // Load thông tin
//             Route::get('/load_wish',[ResultGoController::class,'load_wish']); // Load thông tin
//             Route::get('/dowload_result_go',[ResultGoController::class,'dowload_result_go']); // Load thông tin
//             Route::get('/bogddt_result_go',[ResultGoController::class,'bogddt_result_go']); // Load thông tin
//             Route::get('/bogddt_result_go_save',[ResultGoController::class,'bogddt_result_go_save']); // Load thông tin
//             Route::post('/remove_go/{id}',[ResultGoController::class,'remove_go']); // Load thông tin
//         });
//     });



// });



// Route::get('register',[RegisterUserController::class,'index']);
// Route::post('register/store',[RegisterUserController::class,'store']);
// Route::post('register/active_batch',[RegisterUserController::class,'active_batch']);
// Route::get('login',[LoginUserController::class,'index']);
// Route::post('login/store',[LoginUserController::class,'store']);
// Route::get('passwordreset',[PasswordResetController::class,'index']);
// Route::post('passwordreset/store',[PasswordResetController::class,'store']);
// Admin
// Route::get('admin/users/login',[LoginController::class,'index'])->name('login');
// Route::post('admin/users/login/store',[LoginController::class,'store']);

// Route::middleware(['auth'])->group(function () {
//     Route::prefix('admin')->group(function () {
//         Route::get('/main',[MainController::class, 'index'])->name('admin');
//         Route::post('/logout_admin',[MainController::class,'logout_admin']); // Load Sidebar
//         Route::get('/changepass_admin',[MainController::class,'changepass_admin']); // Load Sidebar
//         Route::post('/updatepassword_admin',[MainController::class,'updatepassword_admin']); // Load Sidebar

//         #Menu
//         Route::prefix('menus')->group(function(){
//             Route::get('/',[MenuController::class,'create']); //Load
//             Route::get('/loadMenu',[MenuController::class,'loadMenu']); //Load Menu
//             Route::post('/loadComboxMenu',[MenuController::class,'loadComboxMenu']); //Load Selectbox Menu
//             Route::post('/destroy/{id}',[MenuController::class,'destroy']); // Del
//             Route::post('/add',[MenuController::class,'store']); // Add
//             Route::post('/edit',[MenuController::class,'edit'])->name('edit'); // Edit
//             Route::post('/load/{id}',[MenuController::class,'load'])->name('load'); // Load Row Menu
//             Route::get('/sidebar',[MenuController::class,'sidebar'])->name('sidebar'); // Load Sidebar
//             Route::post('/loadpage/{id}',[MenuController::class,'loadpage'])->name('loadpage'); // Load Page in Content
//         });

//         Route::prefix('users')->group(function(){
//             Route::get('/',[UsersController::class,'create']); //Load
//             Route::post('/',[UsersController::class,'store'])->name('addUser'); // Add User
//             Route::get('/loadUsers',[UsersController::class,'loadUsers']); //Load Users
//             Route::post('/loadNameUser/{id}',[UsersController::class,'load'])->name('loadNameUser'); // Load name USER

//             Route::post('/load/{id}',[UsersController::class,'load'])->name('load'); // Load Row User
//             Route::post('/edit',[UsersController::class,'edit'])->name('edit'); // Edit
//             Route::post('/destroy/{id}',[UsersController::class,'destroy']); // Del User

//             Route::get('/loadUser_Menus_Roles/{id}',[UsersController::class,'loadUser_Menus_Roles']); // Load Roles Of USER
//             Route::post('/updateRole/{idmenu}/{idrole}/{iduser}/{check}/{parent}',[UsersController::class,'updateRole']); // Update Role
//             // Route::get('/loadUser_Menus_Roles',[UsersController::class,'loadUser_Menus_Roles']); // Load Roles Of USER
//         });

//         #Main
//         Route::prefix('navar')->group(function(){
//             Route::post('/',[NavarController::class,'loadUser']); //Load infor USER
//         });


//         Route::prefix('province')->group(function(){
//             Route::get('/',[ProvinceController::class,'index']); //Load View Method
//             Route::get('/list_province',[ProvinceController::class,'list_province']); //Load View Method
//             Route::get('/list_province2/{id}',[ProvinceController::class,'list_province2']); //Load View Method
//             Route::get('/list_province3/{id}',[ProvinceController::class,'list_province3']); //Load View Method
//             Route::post('/province_save',[ProvinceController::class,'province_save']); //Load View Method
//             Route::post('/province2_save',[ProvinceController::class,'province2_save']); //Load View Method
//             Route::post('/province3_save',[ProvinceController::class,'province3_save']); //Load View Method
//             Route::post('/remove_province',[ProvinceController::class,'remove_province']); //Load View Method
//             Route::post('/remove_province2',[ProvinceController::class,'remove_province2']); //Load View Method
//             Route::post('/remove_province3',[ProvinceController::class,'remove_province3']); //Load View Method




//             Route::post('/change_name_province',[ProvinceController::class,'change_name_province']); //Load View Method
//             Route::post('/change_name_province2',[ProvinceController::class,'change_name_province2']); //Load View Method
//             Route::post('/change_name_province3',[ProvinceController::class,'change_name_province3']); //Load View Method




//             Route::post('/change_id_province',[ProvinceController::class,'change_id_province']); //Load View Method
//             Route::post('/change_id_province2',[ProvinceController::class,'change_id_province2']); //Load View Method
//             Route::post('/change_id_province3',[ProvinceController::class,'change_id_province3']); //Load View Method


//             Route::post('/change_active_province',[ProvinceController::class,'change_active_province']); //Load View Method
//             Route::post('/change_active_province2',[ProvinceController::class,'change_active_province2']); //Load View Method
//             Route::post('/change_active_province3',[ProvinceController::class,'change_active_province3']); //Load View Method




//             // Route::get('/loadMethods',[ProvinceController::class,'loadMethods']); // Load Provinces
//             // Route::get('/loadSchools/{id}',[SchoolsController::class,'loadSchools']); // Load School

//         });

//         Route::prefix('priority_area')->group(function(){
//             Route::get('/',[PriorityAreaController::class,'index']); //Load View Method
//             Route::get('/list_priority_area',[PriorityAreaController::class,'list_priority_area']); //Load View Method
//         });

//         Route::prefix('policy')->group(function(){
//             Route::get('/',[PolicyController::class,'index']); //Load View Method
//             Route::get('/list_policy',[PolicyController::class,'list_policy']); //Load View Method
//             Route::get('/file_policy/{id}',[PolicyController::class,'file_policy']); //Load View Method
//             Route::get('/file_policy_attr',[PolicyController::class,'file_policy_attr']); //Load View Method
//             Route::get('/load_file_policy/{id}',[PolicyController::class,'load_file_policy']); //Load View Method

//         });


//         Route::prefix('tf')->group(function(){
//             Route::get('/',[TFController::class,'index']); //Load View Method
//         });




//         #Year
//         Route::prefix('years')->group(function(){
//             Route::get('/',[YearsController::class,'create']); //Load View
//             Route::post('/store',[YearsController::class,'store']); // Save Year

//         });

//         #Schools
//         Route::prefix('schools')->group(function(){
//             Route::get('/',[SchoolsController::class,'create']); //Load View
//             Route::get('/load_province_shools',[SchoolsController::class,'load_province_shools']); //Load View Method
//             Route::get('/load_shools/{id}',[SchoolsController::class,'load_shools']); //Load View Method
//         });


//         #Method
//         Route::prefix('methods')->group(function(){
//             Route::get('/',[MethodsController::class,'create']); //Load View Method
//             Route::get('/loadMethods',[MethodsController::class,'loadMethods']); // Load Provinces
//             // Route::get('/loadSchools/{id}',[SchoolsController::class,'loadSchools']); // Load School

//         });

//         // Group_subject
//         Route::prefix('/group_sb')->group(function(){
//             Route::get('/',[Gruop_SubjectsController::class,'create']); //Load View
//             Route::get('/loadSubjects',[Gruop_SubjectsController::class,'loadSubjects']); // Load Provinces
//             Route::get('/loadGroups',[Gruop_SubjectsController::class,'loadGroups']); // Load Provinces
//             // Route::get('/loadSchools/{id}',[Gruop_SubjectsController::class,'loadSchools']); // Load School
//         });
//         // Group_subject
//         Route::prefix('/checkinfo')->group(function(){
//             Route::get('/',[CheckInfoController::class,'create']); //Load View
//             Route::get('/testdiem',[CheckInfoController::class,'testdiem']); //Load View

//         });

//         //Expenses_admin
//         Route::prefix('/expenses_admin')->group(function(){
//             Route::get('/',[ExpensesAdminController::class,'index']); //Load View
//             Route::get('/search/{id}',[ExpensesAdminController::class,'search']); //Load timf kiem
//             Route::get('/wish/{id}',[ExpensesAdminController::class,'wish']); //Load nguyeenj vongj
//             Route::post('/charge',[ExpensesAdminController::class,'charge']); //Load nguyeenj vongj
//             Route::get('/load_price/{id}',[ExpensesAdminController::class,'load_price']); //Change Year
//             Route::post('/expenses_back',[ExpensesAdminController::class,'expenses_back']); //Change Year

//         });

//         //Check user
//         Route::prefix('/checkuser')->group(function(){
//             Route::get('/',[CheckUserController::class,'index']); //Load View
//             Route::get('/search/{id}',[CheckUserController::class,'search']); //Load View
//             Route::get('/load_search',[CheckUserController::class,'load_search']); //Load Years
//             Route::get('/changeyear/{id}',[CheckUserController::class,'changeyear']); //Change Year
//             Route::get('/changeprovince/{id}',[CheckUserController::class,'changeprovince']); //Change Year
//             Route::get('/load_list_reg',[CheckUserController::class,'load_list_reg']); //Change Year
//             Route::get('/load_list_school/{id}',[CheckUserController::class,'load_list_school']); //Load Trường THPT
//             Route::get('/load_list_info/{id}',[CheckUserController::class,'load_list_info']); //Load Đối tượng ưu tiên
//             Route::get('/loadslider_info_check/{id}',[CheckUserController::class,'loadslider_info_check']); //Load Hình ảnh minh chứng
//             Route::get('/change_province_school/{id}',[CheckUserController::class,'change_province_school']); //Change Tỉnh THPT
//             Route::get('/change_school_area/{id}',[CheckUserController::class,'change_school_area']); //Change Trường ---> Khu vực
//             Route::get('/load_province',[CheckUserController::class,'load_province']); //Load Tinh
//             Route::post('/save_list_school',[CheckUserController::class,'save_list_school']); //Save Trường
//             Route::get('/load_area_check/{id}',[CheckUserController::class,'load_area_check']); //Load area
//             Route::post('/change_policy_check',[CheckUserController::class,'change_policy_check']); //Change Đối tượng ưu tiên
//             Route::post('/save_policy_check',[CheckUserController::class,'save_policy_check']); //Change Đối tượng ưu tiên
//             Route::get('/load_policy_check/{id}',[CheckUserController::class,'load_policy_check']); //Load đối tượng ưu tiên
//             Route::get('/check_user_load_list_file/{id}',[CheckUserController::class,'check_user_load_list_file']); //Load Danh mục file
//             Route::post('/check_user_save_list_file',[CheckUserController::class,'check_user_save_list_file']); //Load Danh mục file
//             Route::get('/check_user_his_list_file/{id}',[CheckUserController::class,'check_user_his_list_file']); //Load Danh mục file
//             Route::get('/check_user_phieu_list_file/{id}',[CheckUserController::class,'check_user_phieu_list_file']); //Load Danh mục file
//             Route::get('/check_user_load_list_file_maphieu/{id}',[CheckUserController::class,'check_user_load_list_file_maphieu']); //Load Danh mục file



//                 //Thông tin cá nhân
//             Route::post('/change_hktt_province_check/{id}',[CheckUserController::class,'change_hktt_province_check']); //Change HTTK Tỉnh
//             Route::post('/change_hktt_province2_check/{id}',[CheckUserController::class,'change_hktt_province2_check']); //Change HKTT Huyện
//             Route::post('/add_info_check',[CheckUserController::class,'add_info_check']); //Lưu thong tin

//                 //Điểm xét tuyển
//             Route::get('/method_mark_check',[CheckUserController::class,'method_mark_check']); //Load nguyện vọng xét tuyển
//             Route::get('/load_mark_check/{id}',[CheckUserController::class,'load_mark_check']); //Load nguyện vọng xét tuyển
//             Route::get('/loadslider_mark_check',[CheckUserController::class,'loadslider_mark_check']); //Load Hình ảnh minh chứng điểm
//             Route::post('/edit_mark_check',[CheckUserController::class,'edit_mark_check']); //Edit điểm

//                 //Nguyện vọng
//             Route::get('/load_wish_check/{id}',[CheckUserController::class,'load_wish_check']); //Load nguyện vọng
//             Route::get('/change_method_wish_check/{id}',[CheckUserController::class,'change_method_wish_check']); //Change method
//             Route::get('/change_major_wish_check/{id}',[CheckUserController::class,'change_major_wish_check']); //Change major
//             Route::post('/change_group_wish_check',[CheckUserController::class,'change_group_wish_check']); //Change tổ hợp
//             Route::post('/save_wish_check',[CheckUserController::class,'save_wish_check']); //Lưu nguyện vọng
//             Route::post('/block_wish_check/{id}/{id_user}',[CheckUserController::class,'block_wish_check']); //Khóa hồ sơ
//             Route::post('/calculator_check',[CheckUserController::class,'calculator_check']); //Khóa hồ sơ

//                 //Lịch history
//             Route::get('/load_list_history/{id}',[CheckUserController::class,'load_list_history']); //Load lịch sử

//                 //Mail
//             Route::post('/faceback_check_user',[CheckUserController::class,'faceback_check_user']); //Load Gửi mail
//             Route::post('/change_check',[CheckUserController::class,'change_check']); //Load Gửi mail
//         });


//         //Expenses_sta
//         Route::prefix('/expenses_sta')->group(function(){
//             Route::get('/',[ExpensesStaController::class,'index']); //Load View
//             Route::get('/load_search_sta',[ExpensesStaController::class,'load_search_sta']); //Load thanh tìm kiếm
//             Route::get('/load_list_ex',[ExpensesStaController::class,'load_list_ex']); //Load Danh sách thu cuối ngày
//             Route::get('/load_list_infor',[ExpensesStaController::class,'load_list_infor']); //Bảng thứ 2 để xuất excel
//             Route::get('/data_print/{year}/{form}/{user}/{day}',[ExpensesStaController::class,'data_print']); //IN
//         });

//         // Assignment
//         Route::prefix('/assignment')->group(function(){
//             Route::get('/',[AssignmentController::class,'index']); //Load View
//             Route::get('/load_list_ass',[AssignmentController::class,'load_list_ass']); //Search User
//             Route::post('/add_user_ass',[AssignmentController::class,'add_user_ass']); //Add usser check
//             Route::get('/load_user_ass/{id}',[AssignmentController::class,'load_user_ass']); //Add trang thái phân công

//         });

//         // Phân công kiểm tra hồ sơ
//         Route::prefix('/assuser')->group(function(){
//             Route::get('/',[AssUserController::class,'index']); //Load View
//             Route::get('/load_search',[AssUserController::class,'load_search']); //Load Years
//             Route::get('/load_list_ass',[AssUserController::class,'load_list_ass']); //Search User
//             Route::get('/load_list_assstudent/{id_year}/{id_batch}/{day}/{day_reg}/{user}/{ass}/{check}/{pass}',[AssUserController::class,'load_list_assstudent']); //Search User
//             Route::post('/add_ass_user_student',[AssUserController::class,'add_ass_user_student']); //Search User
//             Route::get('/load_user_assuser/{id_user}/{id_student}',[AssUserController::class,'load_user_assuser']); //Search User
//             Route::post('/del_assuser/{id_check}/{id_student}',[AssUserController::class,'del_assuser']); //Search User
//             Route::post('/auto_ass',[AssUserController::class,'auto_ass']); //Load Years
//             Route::post('/send_user_assuser',[AssUserController::class,'send_user_assuser']); //Chekc 1 hồ sơ
//             Route::post('/ass_pass',[AssUserController::class,'ass_pass']); //Load Years
//         });

//          // Thống kê số lượng đăng ký
//         Route::prefix('/reg_sta')->group(function(){
//             Route::get('/',[RegStaController::class,'index']); //Load View
//             Route::get('/barChart_reg_sta/{val}',[RegStaController::class,'barChart_reg_sta']); //Load biểu đồ số lượng đăng ký
//             Route::get('/chart_reg_sta_basic',[RegStaController::class,'chart_reg_sta_basic']); //Load biểu đồ số lượng đăng k
//         });

//         // Thống kê số lượng đăng ký
//         Route::prefix('/go')->group(function(){
//             Route::get('/',[GoController::class,'index']); //Load View
//             Route::get('/load_search',[GoController::class,'load_search']); //Load Years
//             Route::get('/load_go/{id}/{act}',[GoController::class,'load_go']); //Load Years
//             Route::post('/go_virtual',[GoController::class,'go_virtual']); //Load Lọc ảo
//             Route::get('/save_go/{id}/{act}',[GoController::class,'save_go']); //Lưu lọc ảo
//             Route::get('/ex_list_go/{id}',[GoController::class,'ex_list_go']); //Xuất danh sách trúng tuyển
//             Route::get('/go_sta/{id}',[GoController::class,'go_sta']); //Xuất thống kê
//             Route::post('/go_block/{id}',[GoController::class,'go_block']); //Khóa đợt tuyển sinh
//             Route::post('/load_go_block/{id}',[GoController::class,'load_go_block']); //Load trạng thái đọt tuyển sinh (Khóa/Mở)
//             Route::post('/load_go_active/{id}',[GoController::class,'load_go_active']); //Load trạng thái hồ sơ xet tuyển
//             Route::post('/check_type/{id}',[GoController::class,'check_type']); //Load trạng thái hồ sơ xet tuyển
//             Route::get('/go_number_wish/{id}/{batch}',[GoController::class,'go_number_wish']); //Load trạng thái hồ sơ xet tuyển
//             Route::get('/load_go_number_wish/{batch}',[GoController::class,'load_go_number_wish']); //Load trạng thái hồ sơ xet tuyển
//             Route::get('/ex_list_student',[GoController::class,'ex_list_student']); //Load trạng thái hồ sơ xet tuyển
//             Route::get('/ex_list_wish',[GoController::class,'ex_list_wish']); //Load trạng thái hồ sơ xet tuyển
//             Route::get('/ex_list_wish_fail',[GoController::class,'ex_list_wish_fail']); //Load trạng thái hồ sơ xet tuyển
//             Route::get('/ex_list_fail',[GoController::class,'ex_list_fail']); //Load trạng thái hồ sơ xet tuyển
//             Route::post('/clear_check',[GoController::class,'clear_check']); //Load trạng thái hồ sơ xet tuyển
//         });


//         // Thống kê số lượng đăng ký
//         Route::prefix('/elect')->group(function(){
//             Route::get('/',[ElectController::class,'index']); //Load View
//             // Route::get('/list',[ElectController::class,'index']); //Load View
//             Route::get('/load_search',[ElectController::class,'load_search']); //Load View
//             Route::get('/list_elect',[ElectController::class,'list_elect']); //Load View
//             Route::get('/elect_print/{where}/{sig}',[ElectController::class,'elect_print']); //Load Vie

//         });

//        // Thống kê số lượng đăng ký
//        Route::prefix('/admission')->group(function(){
//         Route::get('/',[AdmissionController::class,'index']); //Load View
//         // Route::get('/list',[AdmissionController::class,'index']); //Load View
//         Route::get('/load_search',[AdmissionController::class,'load_search']); //Load View
//         Route::get('/list_elect',[AdmissionController::class,'list_elect']); //Load View
//         Route::get('/elect_exp/{elect_year}/{elect_batch}/{elect_method}/{elect_major}/{elect_id_card}/{elect_id}/{elect_hktt}/{type_tops}',[AdmissionController::class,'elect_exp']); //Load Years
//         Route::get('/elect_ttsv/{elect_year}/{elect_batch}/{elect_method}/{elect_major}/{elect_id_card}/{elect_id}/{elect_hktt}',[AdmissionController::class,'elect_ttsv']); //Load Years




//         // Route::get('/elect_print/{where}/{sig}',[AdmissionController::class,'elect_print']); //Load Vie

//         });



//         // Thống kê số lượng đăng ký
//         Route::prefix('/go_setup')->group(function(){
//             Route::get('/',[GoSetupController::class,'index']); //Load View
//             Route::get('/load_go_setup/{id}',[GoSetupController::class,'load_go_setup']); //Load cài đặt xét tuyển
//             Route::get('/go_setup_save',[GoSetupController::class,'go_setup_save']); //Lưu cài đặt xét tuyển
//             Route::get('/barChart_go_setup/{id}',[GoSetupController::class,'barChart_go_setup']); //Load biểu đồ
//             Route::post('/email',[GoSetupController::class,'email']); //Email
//             Route::get('/load_email/{id}',[GoSetupController::class,'load_email']); //Lưu load biểu đồ
//             Route::get('/load_method_mark/{id}',[GoSetupController::class,'load_method_mark']); //Lưu load biểu đồ
//             Route::get('/add_method_mark/{id}/{method}',[GoSetupController::class,'add_method_mark']); //Lưu load biểu đồ
//         });



//         // Thống kê số lượng đăng ký
//         Route::prefix('/investigate')->group(function(){
//             Route::get('/',[InvestigateController::class,'index']); //Load View
//             Route::get('/load_search',[InvestigateController::class,'load_search']); //Load Years
//             Route::get('/change_batch/{id_batch}',[InvestigateController::class,'change_batch']); //Load Years
//             Route::get('/list_investigate',[InvestigateController::class,'list_investigate']); //Load Years
//             Route::get('/excel_investigate/{major}/{seen}/{onl}/{off}/{go}/{xnnh}',[InvestigateController::class,'excel_investigate']); //Load Years
//             Route::get('/save_trangthai/{id}/{trangthai}',[InvestigateController::class,'save_trangthai']); //Load Years
//             Route::post('/insv_active_admin',[InvestigateController::class,'insv_active_admin']); //Load Years
//             Route::post('/insv_note_admin',[InvestigateController::class,'insv_note_admin']); //Load Years
//             Route::get('/insv_chart_admin/{id_batch}',[InvestigateController::class,'insv_chart_admin']); //Load Years
//         });


//         Route::prefix('/qlsv_nvqs')->group(function(){
//             Route::get('/',[QlsvNvqsController::class,'index']); //Load View
//             // Route::get('/change_batch/{id_batch}',[QlsvNvqsController::class,'change_batch']); //Load Years
//             Route::get('/load_search',[QlsvNvqsController::class,'load_search']); //Load Years
//             Route::get('/load_admin_sig',[QlsvNvqsController::class,'load_admin_sig']); //Load Years
//             Route::get('/list_nvqs',[QlsvNvqsController::class,'list_nvqs']); //Load Years
//             // Route::get('/nvqs_print_nvqs/{major}/{nvqs_id_card}/{nvqs_mssv}/{load_admin_sig}/{sex}',[QlsvNvqsController::class,'nvqs_print_nvqs']); //Load Yearsnvqs_mssv
//             // Route::get('/nvqs_print_vv/{major}/{nvqs_id_card}/{nvqs_mssv}/{load_admin_sig}/{sex}',[QlsvNvqsController::class,'nvqs_print_vv']); //Load Yearsnvqs_mssv
//             Route::get('/nvqs_print_vv/{where}/{load_admin_sig}',[QlsvNvqsController::class,'nvqs_print_vv']); //Load Yearsnvqs_mssv
//             Route::get('/nvqs_print_nvqs/{where}/{load_admin_sig}',[QlsvNvqsController::class,'nvqs_print_nvqs']); //Load Yearsnvqs_mssv
//         });



//         Route::prefix('/manager_file')->group(function(){
//             Route::get('/',[ManagerFileController::class,'index']); //Load View
//             Route::get('/load_search',[ManagerFileController::class,'load_search']); //Load View
//             Route::get('/manager_file_list/{batch}/{start}/{end}/{user}',[ManagerFileController::class,'manager_file_list']); //Load View
//             Route::get('/manager_file_excel/{batch}/{start}/{end}/{user}',[ManagerFileController::class,'manager_file_excel']); //Load View
//         });

//         Route::prefix('/file_hssv')->group(function(){
//             Route::get('/',[ManagerFileHSSVController::class,'index']); //Load View
//             Route::get('/load_search',[ManagerFileHSSVController::class,'load_search']); //Load View
//             Route::get('/file_hssv_list/{batch}/{start}/{end}/{user}',[ManagerFileHSSVController::class,'file_hssv_list']); //Load View
//             Route::get('/file_hssv_excel/{batch}/{start}/{end}/{user}',[ManagerFileHSSVController::class,'file_hssv_excel']); //Load View
//         });

//             // Thống kê số lượng đăng ký
//         Route::prefix('/go_bo')->group(function(){
//             Route::get('/',[GoBoController::class,'index']); //Load View
//         });

//         // Thống kê số lượng đăng ký
//         Route::prefix('/add_go_batch')->group(function(){
//             Route::get('/',[GoBatchBoController::class,'index']); //Load View
//             Route::get('/load_go_batch_bo',[GoBatchBoController::class,'load_go_batch_bo']); //Load View
//             Route::get('/go_batch_bo_ts/{id}',[GoBatchBoController::class,'go_batch_bo_ts']); //Load View
//             Route::post('/add_go_batch_bo',[GoBatchBoController::class,'add_go_batch_bo']); //Load View
//             Route::post('/remove_go_batch',[GoBatchBoController::class,'remove_go_batch']); //Load View
//             Route::get('/edit_go_batch/{id}',[GoBatchBoController::class,'edit_go_batch']); //Load View
//             Route::post('/add_go_batch_bo_edit',[GoBatchBoController::class,'add_go_batch_bo_edit']); //Load View
//         });


//         Route::prefix('/go_data')->group(function(){
//             Route::get('/',[GoDataBoController::class,'index']); //Load View
//             Route::get('/load_go_year',[GoDataBoController::class,'load_go_year']); //Load View
//             Route::post('/import_go_data_list',[GoDataBoController::class,'import_go_data_list']);
//             Route::get('/load_go_data_acc',[GoDataBoController::class,'load_go_data_acc']);
//             Route::get('/download_go_data_list',[GoDataBoController::class,'download_go_data_list']);
//             Route::post('/import_go_info_list',[GoDataBoController::class,'import_go_info_list']);
//             Route::post('/import_go_policy_list',[GoDataBoController::class,'import_go_policy_list']);
//         });

//         Route::prefix('/go_mark')->group(function(){
//             Route::get('/',[GoDataMark::class,'index']); //Load View
//             Route::post('/import_go_mark_hb',[GoDataMark::class,'import_go_mark_hb']); //Load View
//             Route::post('/import_go_mark_thpt',[GoDataMark::class,'import_go_mark_thpt']); //Load V
//             Route::get('/load_go_mark',[GoDataMark::class,'load_go_mark']); //Load View
//             Route::get('/download_go_mark',[GoDataMark::class,'download_go_mark']); //Load V
//         });


//         Route::prefix('/go_wish')->group(function(){
//             Route::get('/',[GoDataWish::class,'index']); //Load View
//             Route::post('/import_go_wish',[GoDataWish::class,'import_go_wish']); //Load View
//             Route::get('/load_go_wish',[GoDataWish::class,'load_go_wish']); //Load View
//             Route::post('/go_wish_tts',[GoDataWish::class,'go_wish_tts']); //Load View
//             Route::post('/cal_go_wish',[GoDataWish::class,'cal_go_wish']); //Load View
//             Route::post('/number_go_wish',[GoDataWish::class,'number_go_wish']); //Load View
//             Route::get('/download_go_wish',[GoDataWish::class,'download_go_wish']); //Load View
//         });

//         Route::prefix('/go_virtual')->group(function(){
//             Route::get('/',[GoVirtual::class,'index']); //Load View
//             Route::get('/go_virtual_batch_ts',[GoVirtual::class,'go_virtual_batch_ts']); //Load View
//             Route::get('/go_virtual_batch/{id}',[GoVirtual::class,'go_virtual_batch']); //Load View
//             Route::get('/go_virtual_load/{id_batch_ts}/{id_batch}',[GoVirtual::class,'go_virtual_load']); //Load View
//             Route::post('/go_virtual_batch_pass',[GoVirtual::class,'go_virtual_batch_pass']); //Load View
//             Route::post('/go_virtual_batch_block',[GoVirtual::class,'go_virtual_batch_block']); //Load View
//             Route::post('/go_virtual_load_check_block',[GoVirtual::class,'go_virtual_load_check_block']); //Load View
//             Route::post('/go_virtual_batch_list_bo',[GoVirtual::class,'go_virtual_batch_list_bo']); //Load View
//             Route::get('/go_virtual_batch_list_bo_dowload/{id_batch_ts}/{id_batch}',[GoVirtual::class,'go_virtual_batch_list_bo_dowload']); //Load View
//             Route::get('/go_virtual_batch_list_dowload/{id_batch_ts}/{id_batch}',[GoVirtual::class,'go_virtual_batch_list_dowload']); //Load View
//             Route::post('/submit_go_virtual_batch_ip_list_nhom',[GoVirtual::class,'submit_go_virtual_batch_ip_list_nhom']); //Load View
//             Route::post('/submit_go_virtual_batch_ip_list_bo',[GoVirtual::class,'submit_go_virtual_batch_ip_list_bo']); //Load View
//             Route::get('/add_go_virtual_chart_major/{id}/{id_batch_ts}/{id_batch}',[GoVirtual::class,'add_go_virtual_chart_major']); //Load biểu đồ
//             Route::post('/go_virtual_batch_list_bo_block',[GoVirtual::class,'go_virtual_batch_list_bo_block']); //Load biểu đồ
//             Route::post('/go_virtual_batch_list_bo_internet',[GoVirtual::class,'go_virtual_batch_list_bo_internet']); //Load biểu đồ
//             Route::get('/go_virtual_batch_list_bo_new_dowload/{id}',[GoVirtual::class,'go_virtual_batch_list_bo_new_dowload']); //Load biểu đồ

//         });

//         Route::prefix('/update_ttsv')->group(function(){
//             Route::get('/',[UpdateTtsvController::class,'index']); // Load index
//             Route::get('/login1',[UpdateTtsvController::class,'login1']); // Load index
//             // Route::get('/load_update_ttsv_ass',[UpdateTtsvController::class,'load_update_ttsv_ass']); // Load index
//             Route::get('/update_ttsv_slide/{batch}/{cmnd}',[UpdateTtsvController::class,'update_ttsv_slide']); // Load index
//             Route::get('/update_ttsv_load/{batch}/{cmnd}',[UpdateTtsvController::class,'update_ttsv_load']); // Load index
//             Route::get('/update_ttsv_load_batch',[UpdateTtsvController::class,'update_ttsv_load_batch']); // Load index
//             Route::post('/ttsv_submit',[UpdateTtsvController::class,'ttsv_submit']); // Load index
//             Route::get('/ttsv_load_list_file/{batch}/{cmnd}',[UpdateTtsvController::class,'ttsv_load_list_file']); // Load index
//             Route::post('/ttsv_file_save',[UpdateTtsvController::class,'ttsv_file_save']); // Load index
//             Route::post('/change_selectbox',[UpdateTtsvController::class,'change_selectbox']); // Load index
//         });




//         // Thống kê số lượng đăng ký
//         Route::prefix('/adduser')->group(function(){
//             Route::get('/',[AddUserController::class,'index']); //Load View
//             Route::post('/add',[AddUserController::class,'add']); //Load Years
//             Route::post('/id_card_reset_save',[AddUserController::class,'id_card_reset_save']); //Load Years



//             // Route::get('/change_batch/{id_batch}',[InvestigateController::class,'change_batch']); //Load Years
//             // Route::get('/list_investigate',[InvestigateController::class,'list_investigate']); //Load Years
//             // Route::get('/excel_investigate/{batch}/{tam}/{name}/{id_card}/{phone}/{id}/{check}/',[InvestigateController::class,'excel_investigate']); //Load Years
//             // Route::get('/save_trangthai/{id}/{trangthai}',[InvestigateController::class,'save_trangthai']); //Load Years


//         });

//         //Quản lý đồng phục

//             //Nhà sản xuất
//         Route::prefix('/nsx')->group(function () {
//             Route::get('/', [NsxController::class, 'index']);
//             Route::get('/nsx_tennsx', [NsxController::class, 'nsx_tennsx']);
//             Route::post('/nsx_them', [NsxController::class, 'nsx_them']);
//             Route::get('/danhsachnsx', [NsxController::class, 'danhsachnsx']);
//             Route::post('delete_nsx/{id}', [NsxController::class, 'delete_nsx']);
//             Route::get('edit_nsx/{id}', [NsxController::class, 'edit_nsx']);
//             Route::post('capnhatnsx/{id}', [NsxController::class, 'capnhatnsx']);
//         });


//             //Loại Sản phẩm
//         Route::prefix('/qlsp')->group(function () {
//             Route::get('/', [QuanlysanphamController::class, 'index']);
//             Route::get('/addsp_tennsx', [QuanlysanphamController::class, 'addsp_tennsx']);
//             Route::post('/add_product', [QuanlysanphamController::class, 'add_product']);
//             Route::get('/show_product', [QuanlysanphamController::class, 'show_product']);
//             Route::get('/edit_product/{id}', [QuanlysanphamController::class, 'edit_product']);
//             Route::post('delete_product/{id}', [QuanlysanphamController::class, 'delete_product']);
//             Route::post('/capnhatloai/{id}', [QuanlysanphamController::class, 'capnhatloai']);
//         });

//             //Size
//         Route::prefix('/size')->group(function () {
//             Route::get('/', [SizeController::class, 'index']);
//             Route::get('/addsize_tennsx', [SizeController::class, 'addsize_tennsx']);
//             Route::post('/themsize', [SizeController::class, 'themsize']);
//             Route::get('/hienthi_size', [SizeController::class, 'hienthi_size']);
//             Route::post('/xoasize/{id}', [SizeController::class, 'xoasize']);
//             Route::get('/sua_size/{id}', [SizeController::class, 'sua_size']);
//             Route::post('/update_size/{id}', [SizeController::class, 'update_size']);
//             Route::get('/change_nsx/{id}', [SizeController::class, 'change_nsx']);
//         });

//         Route::prefix('/dot')->group(function () {
//             Route::get('/', [DotController::class, 'index']);
//             Route::post('/dot_them', [DotController::class, 'dot_them']);
//             Route::post('/delete_dot/{id}', [DotController::class, 'delete_dot']);
//             Route::get('/edit_dot/{id}', [DotController::class, 'edit_dot']);
//             Route::get('/hienthidot', [DotController::class, 'hienthidot']);
//             Route::post('/submit_dot', [DotController::class, 'submit_dot']);
//         });

//         Route::prefix('/nsp')->group(function () {
//             Route::get('/', [NhapspController::class, 'index']);
//             Route::get('/nsp_allsize', [NhapspController::class, 'nsp_allsize']);
//             Route::get('/l_listallsize', [NhapspController::class, 'l_listallsize']);
//             Route::get('/l_listsp', [NhapspController::class, 'l_listsp']);
//             Route::get('/l_listspn', [NhapspController::class, 'l_listspn']);
//             Route::post('/delete_nhapsp/{id}', [NhapspController::class, 'delete_nhapsp']);
//             Route::get('/edit_ttnhap', [NhapspController::class, 'edit_ttnhap']);
//             Route::get('/edit_nhapsp/{id}', [NhapspController::class, 'edit_nhapsp']);
//             Route::post('/nsp_them', [NhapspController::class, 'nsp_them']);
//             Route::get('/truyentt/{id}', [NhapspController::class, 'truyentt']);
//             Route::get('/truyenttloai', [NhapspController::class, 'truyenttloai']);
//             Route::post('capnhatnsx/{id}', [NsxController::class, 'capnhatnsx']);
//             Route::post('/capnhatnhapsp/{id}', [NhapspController::class, 'capnhatnhapsp']);
//         });

//         Route::prefix('/xuathang')->group(function () {
//             Route::get('/', [XuathangController::class, 'index']);
//             Route::get('/xuathang_alllop', [XuathangController::class, 'xuathang_alllop']);
//             Route::get('/show_xuathang', [XuathangController::class, 'show_xuathang']);
//             Route::get('/change_size/{id_loai}/{id_nsx}', [XuathangController::class, 'change_size']);
//             Route::get('/xuathang_lop', [XuathangController::class, 'xh_alllop']);
//             Route::post('/banhang', [XuathangController::class, 'banhang']);
//         });


//         Route::prefix('/hoadon')->group(function () {
//             Route::get('/', [HoadonController::class, 'index']);
//             Route::get('/show_bill', [HoadonController::class, 'show_bill']);
//             Route::get('/printhd/{id_hd}', [HoadonController::class, 'printhd']);
//             Route::post('/xoahoadon', [HoadonController::class, 'xoahoadon']);





//         });

//       // Thống kê số lượng đăng ký
//         Route::prefix('/step_setup')->group(function(){
//             Route::get('/',[StepSetupControler::class,'index']); //Load View


//         });

//         Route::prefix('/proof_setup')->group(function(){
//             Route::get('/',[ProofSetupControler::class,'index']); //Load View



//         });

//         Route::prefix('/file_go')->group(function(){
//             Route::get('/',[FileGoControler::class,'index']); //Load View



//         });


//         Route::prefix('/doan')->group(function(){
//             Route::get('/',[DoanControler::class,'index']); //Load View
//         });


//     });

// });

