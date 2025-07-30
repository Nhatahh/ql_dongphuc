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
use \App\Http\Controllers\User_24\CongboketquaController;


use \App\Http\Controllers\User_24\Admin\Loginbygoogleadmin24Controller;

use \App\Http\Controllers\User_24\TestController;
use \App\Http\Controllers\User_24\ConnectionController;

use Symfony\Component\HttpFoundation\StreamedResponse;



use App\Http\Controllers\Dongphuc\HomeController;
use App\Http\Controllers\Dongphuc\UniformController;
use App\Http\Controllers\Dongphuc\OrderController;
use App\Http\Controllers\Dongphuc\UserController;
use App\Http\Controllers\Dongphuc\SearchController;
use App\Http\Controllers\Dongphuc\Size1Controller;
use App\Http\Controllers\Dongphuc\DanhmucController;
use App\Http\Controllers\Dongphuc\nhaSXController;
use App\Http\Controllers\Dongphuc\ptThanhToanController;
// use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dongphuc\DanhGiaController;
// use App\Http\Controllers\Admin\AdminController;
// use App\Http\Controllers\Admin\AdminSanphamController;
// use App\Http\Controllers\Admin\AdminDonHangController;
// use App\Http\Controllers\Admin\AdminDanhMucController;
// use App\Http\Controllers\Admin\AdminThongkeController;
// use App\Http\Controllers\Admin\AdminNSXController;
// use App\Http\Controllers\Admin\AdminSizeController;
// use App\Http\Controllers\Admin\AdminKhoController;
// use App\Http\Controllers\AuthController;


Route::get('/login', [Loginbygoogle24Controller::class, 'login']);
Route::post('/login/truycap', [Admin_24Controller::class, 'truycap']);
Route::get('auth/google', [Loginbygoogle24Controller::class, 'redirectToGoogle'])->name('loginbygoogle');
Route::get('auth/google/callback', [Loginbygoogle24Controller::class, 'handleGoogleCallback']);

Route::post('/login/store', [Loginbygoogle24Controller::class, 'store']);

Route::middleware(['checklogin24::class'])->group(function () {
    Route::get('/', [Loginbygoogle24Controller::class, 'login']);

    Route::prefix('test')->group(function(){
        Route::get('/',[TestController::class,'index']);
        Route::post('/thanhtoan',[TestController::class,'thanhtoan']);
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
        Route::post('/upload_gxnkqthi',[Thongtincanhan24Controller::class,'upload_gxnkqthi']);
        Route::post('/upload_gxntntamthoi',[Thongtincanhan24Controller::class,'upload_gxntntamthoi']);
        Route::post('/upload_bhyt',[Thongtincanhan24Controller::class,'upload_bhyt']);


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

    Route::prefix('congboketqua')->group(function(){
        Route::get('/',[CongboketquaController::class,'congboketqua']);
        Route::post('/xacnhannhaphoc',[CongboketquaController::class,'xacnhannhaphoc']);
        Route::get('/timkiemtrangthaixacnhannhaphoc',[CongboketquaController::class,'timkiemtrangthaixacnhannhaphoc']);

        Route::post('/daxemketqua',[CongboketquaController::class,'daxemketqua']);  //Trúng tuyển chính thức
        Route::get('/loadthongtinsinhvien',[CongboketquaController::class,'loadthongtinsinhvien']);  //Trúng tuyển chính thức

        //noisinh
        Route::get('/loadtinh',[CongboketquaController::class,'loadtinh']);
        Route::get('/loadhuyen/{tinh1}',[CongboketquaController::class,'loadhuyen']);
        Route::get('/loadxa/{huyen1}',[CongboketquaController::class,'loadxa']);
        //thuongtru
        Route::get('/loadtinh2',[CongboketquaController::class,'loadtinh2']);
        Route::get('/loadhuyen2/{tinh2}',[CongboketquaController::class,'loadhuyen2']);
        Route::get('/loadxa2/{huyen2}',[CongboketquaController::class,'loadxa2']);
        //quequan
        Route::get('/loadtinh3',[CongboketquaController::class,'loadtinh3']);
        Route::get('/loadhuyen3/{tinh3}',[CongboketquaController::class,'loadhuyen3']);
        Route::get('/loadxa3/{huyen3}',[CongboketquaController::class,'loadxa3']);
        Route::post('/capnhatthongtincannhan',[CongboketquaController::class,'capnhatthongtincannhan']);


    });

    Route::prefix('logout')->group(function(){
        Route::post('/',[Loginbygoogle24Controller::class,'logout']);
    });
});





Route::get('/loginadmin', [Admin_24Controller::class, 'loginadmin']);
Route::get('/dangnhap_admin', [Admin_24Controller::class, 'dangnhap_admin']);
Route::middleware(['loginadmin::class'])->group(function () {
    Route::prefix('admin24')->group(function(){
        Route::get('/main',[Admin_24Controller::class,'index']);
        Route::post('/logout',[Admin_24Controller::class,'logout']);
        Route::post('/doimatkhau',[Admin_24Controller::class,'doimatkhau']);

        //Plugin
        Route::get('/loadchuyennganh',[Admin_24Controller::class,'loadchuyennganh']);


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


        // Đợt tuyển sinh
        Route::get('/dottuyensinh',[Admin_24Controller::class,'dottuyensinh']);
        Route::get('/bang_ds_dottuyensinh',[Admin_24Controller::class,'bang_ds_dottuyensinh']);
        Route::post('/them_dottuyensinh',[Admin_24Controller::class,'them_dottuyensinh']);
        Route::get('/edit_load_dottuyensinh', [Admin_24Controller::class, 'edit_load_dottuyensinh']);
        Route::post('/update_dottuyensinh', [Admin_24Controller::class, 'update_dottuyensinh']);
        Route::post('/delete_dottuyensinh', [Admin_24Controller::class, 'delete_dottuyensinh']);
        Route::post('/refresh_modal_sua_dts', [Admin_24Controller::class, 'refresh_modal_sua_dts']);
        Route::post('/refresh_dottuyensinh', [Admin_24Controller::class, 'refresh_dottuyensinh']);

        // Đợt xét tuyển
        Route::get('/dotxettuyen',[Admin_24Controller::class,'dotxettuyen']);
        Route::get('/bang_ds_dotxettuyen',[Admin_24Controller::class,'bang_ds_dotxettuyen']);
        Route::post('/them_dotxettuyen',[Admin_24Controller::class,'them_dotxettuyen']);
        Route::get('/edit_load_dotxettuyen', [Admin_24Controller::class, 'edit_load_dotxettuyen']);
        Route::post('/update_dotxettuyen', [Admin_24Controller::class, 'update_dotxettuyen']);
        Route::post('/delete_dotxettuyen', [Admin_24Controller::class, 'delete_dotxettuyen']);
        Route::get('/load_selectbox_dotxettuyen', [Admin_24Controller::class, 'load_selectbox_dotxettuyen']);


        //Quan ly nhap hoc
        Route::get('/hosonhaphoc',[Admin_24Controller::class,'hosonhaphoc']);
        Route::get('/hosonhaphoc/loadttcn/{id_taikhoan}',[Admin_24Controller::class,'loadttcn']);



        //Quản ly mail
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

                                //QUẢN LÝ HỒ SƠ THÍ SINH
            //Phân công hồ sơ
        Route::get('/phanconghoso',[Admin_24Controller::class,'phanconghoso']);
        Route::get('/hoso_danhsach/{id_nam}',[Admin_24Controller::class,'hoso_danhsach']);
        Route::get('/kiemtra_pchoso',[Admin_24Controller::class,'kiemtra_pchoso']);
        Route::get('/ds_canbo',[Admin_24Controller::class,'ds_canbo']);
        Route::post('/phancong',[Admin_24Controller::class,'phancong']);
        Route::get('/phancong_exel/{hoten}/{email}/{kiemtra}/{trangthaiduyet}/{trangthaikhoa}/{trangthai}/{id_nam}',[Admin_24Controller::class,'phancong_exel']);

            // Phân công kiểm tra hồ sơ
        Route::get('/phancongkiemtrahoso',[Admin_24Controller::class,'phancongkiemtrahoso']);
        Route::get('/hoso_danhsach_kiemtra/{id_nam}',[Admin_24Controller::class,'hoso_danhsach_kiemtra']);
        Route::get('/load_trangthai_pckiemtra',[Admin_24Controller::class,'load_trangthai_pckiemtra']);
        Route::get('/ds_canbo_kiemtra',[Admin_24Controller::class,'ds_canbo_kiemtra']);
        Route::post('/phancong_canbokiemtra',[Admin_24Controller::class,'phancong_canbokiemtra']);
        Route::post('/phanquyenkiemtrahoso',[Admin_24Controller::class,'phanquyenkiemtrahoso']);

            //Phân công duyệt hồ sơ
        Route::get('/phancongduyethoso',[Admin_24Controller::class,'phancongduyethoso']);
        Route::get('/hoso_danhsach_duyet/{id_nam}',[Admin_24Controller::class,'hoso_danhsach_duyet']);
        Route::get('/load_trangthai_pcduyet',[Admin_24Controller::class,'load_trangthai_pcduyet']);
        Route::get('/ds_canbo_duyet',[Admin_24Controller::class,'ds_canbo_duyet']);
        Route::post('/phancong_canboduyet',[Admin_24Controller::class,'phancong_canboduyet']);

            // Kiểm tra hồ sơ
        Route::get('/tracuuthisinh',[Admin_24Controller::class,'tracuuthisinh']);
        Route::get('/timkiemthisinh',[Admin_24Controller::class,'timkiemthisinh']);
        Route::get('/change_tinh10/{idtinh}',[Admin_24Controller::class,'change_tinh10']);
        Route::get('/change_tinh11/{idtinh}',[Admin_24Controller::class,'change_tinh11']);
        Route::get('/change_tinh12/{idtinh}',[Admin_24Controller::class,'change_tinh12']);
        Route::post('/capnhatthongtincanhan1',[Admin_24Controller::class,'capnhatthongtincanhan']);
        Route::post('/capnhattruonglop1',[Admin_24Controller::class,'capnhattruonglop1']);
        Route::post('/capnhatketquahoctap',[Admin_24Controller::class,'capnhatketquahoctap']);
        Route::post('/capnhatnguyenvong',[Admin_24Controller::class,'capnhatnguyenvong']);
        Route::post('/capnhatdoituong1',[Admin_24Controller::class,'capnhatdoituong1']);
        Route::post('/capnhatnamtn',[Admin_24Controller::class,'capnhatnamtn']);
        Route::post('/khoahoso',[Admin_24Controller::class,'khoahoso']);
        Route::post('/duyethoso',[Admin_24Controller::class,'duyethoso']);
        Route::get('/kiemtra_danhsachhoso/{iddot}',[Admin_24Controller::class,'kiemtra_danhsachhoso']);
        Route::get('/load_trangthai',[Admin_24Controller::class,'load_trangthai']);

            //Danh sách thu hồ sơ thí sinh
        Route::get('/danhsachthuhoso',[Admin_24Controller::class,'danhsachthuhoso']);
        Route::get('/thuhoso_load_tb',[Admin_24Controller::class,'thuhoso_load_tb']);

            //Gửi mail tra cứu thí sinh
        Route::post('/guimail_kiemtrahoso',[Admin_24Controller::class,'guimail_kiemtrahoso']);
            //Hủy hồ sơ
        Route::post('/huyhoso',[Admin_24Controller::class,'huyhoso']);
        Route::post('/dangky_hoso',[Admin_24Controller::class,'dangky_hoso']);
        Route::get('/danhmuc_hoso_tracuutcts/{id}',[Admin_24Controller::class,'danhmuc_hoso_tracuutcts']);
        Route::post('/nhanhoso_tstc',[Admin_24Controller::class,'nhanhoso_tstc']);
        Route::get('/inphieurasoat/{id}/{dotts}',[Admin_24Controller::class,'inphieurasoat']);
        Route::get('/kiemtraphieutrungtuyen/{id}/{dotts}',[Admin_24Controller::class,'kiemtraphieutrungtuyen']);

            //Quản lý xét tuyển

        //Danh sách xét tuyển
        Route::get('/danhsachxettuyen',[Admin_24Controller::class,'danhsachxettuyen']);  //Load index
        Route::get('/danhsachnguyenvong/{dieukien}',[Admin_24Controller::class,'danhsachnguyenvong']);  //Load index
        Route::post('/duyetdanhsachxetuyentuyentheodot',[Admin_24Controller::class,'duyetdanhsachxetuyentuyentheodot']); //Duyệt DS
        Route::post('/trangthaidanhsachxettuyen',[Admin_24Controller::class,'trangthaidanhsachxettuyen']); //Cap nhật trang thái từng hồ sơ
        Route::post('/resetsachxetuyentuyentheodot',[Admin_24Controller::class,'resetsachxetuyentuyentheodot']); //Reset danh sách
        Route::get('/xuatexceldanhsachxettuyen/{iddot}/{dieukien}/{time}/{idmanhinh}/{idchucnang}/{active}',[Admin_24Controller::class,'xuatexceldanhsachxettuyen']); //Reset danh sách
        //Thực hiện xét tuyển
        Route::get('/thuchienxettuyen',[Admin_24Controller::class,'thuchienxettuyen']);  //Load index
        // Route::get('/loadthongkexettuyen',[Admin_24Controller::class,'loadthongkexettuyen']);  //Load index
        Route::get('/danhsachtrungtuyentheodotts/{iddot}',[Admin_24Controller::class,'danhsachtrungtuyentheodotts']);  //Load danh sách trúng tuyển
        Route::get('/thongketrungtuyentheodotts/{iddot}',[Admin_24Controller::class,'thongketrungtuyentheodotts']);  //Load thống kê theo đọt
        Route::get('/xuatexcelthongketrungtuyentheodotts/{iddot}',[Admin_24Controller::class,'xuatexcelthongketrungtuyentheodotts']);  //Load thống kê theo đọt
        Route::get('/phodiemtheodotts/{iddot}/{nguyenvong}/{khoangdiem}/{id_nganh}',[Admin_24Controller::class,'phodiemtheodotts']);  //Load Phổ điểm
        Route::get('/load_phodiem_nganh/{iddot}',[Admin_24Controller::class,'load_phodiem_nganh']);  //Load Phổ điểm
        Route::get('/danhsachtrungtuyentamtheodotxt/{iddotxt}',[Admin_24Controller::class,'danhsachtrungtuyentamtheodotxt']);  //Load Phổ điểm
        Route::get('/laydulieutheodot/{iddotts}/{iddotxt}',[Admin_24Controller::class,'laydulieutheodot']);  //Load Phổ điểm

        Route::get('/khoadotxettuyen/{iddotxt}',[Admin_24Controller::class,'khoadotxettuyen']);  //Load Phổ điểm
        Route::get('/xuatdanhsachlocao/{iddotxt}',[Admin_24Controller::class,'xuatdanhsachlocao']);  //Load Phổ điểm
        Route::get('/danhsach_thisinh_locao/{iddotxt}',[Admin_24Controller::class,'danhsach_thisinh_locao']);  //Load Phổ điểm
        Route::get('/thongkeketqualocao/{iddotxt}',[Admin_24Controller::class,'thongkeketqualocao']);  //Load Phổ điểm
        Route::POST('/submit_importketquanhom',[Admin_24Controller::class,'submit_importketquanhom']);  //Load Phổ điểm
        Route::POST('/submit_importketquabo',[Admin_24Controller::class,'submit_importketquabo']);  //Load

        Route::get('/thongketheodotxettuyen/{iddotts}/{iddotxt}',[Admin_24Controller::class,'thongketheodotxettuyen']);  //Load Phổ điểm
        Route::post('/capnhatsoluongtheonganh',[Admin_24Controller::class,'capnhatsoluongtheonganh']);  //Load Phổ điểm
        Route::get('/thongkedanhsachtrungtuyentamtheodotxt/{iddotts}/{iddotxt}/{ngvong}',[Admin_24Controller::class,'thongkedanhsachtrungtuyentamtheodotxt']);  //Kết quẳ xét tuyển
        Route::get('/luudanhsachtrungtuyentam/{iddotts}/{iddotxt}/{ngvong}',[Admin_24Controller::class,'luudanhsachtrungtuyentam']);  //:Lưu Kết quẳ xét tuyển
        Route::get('/trungtuyenchinhthucdotts/{iddotxt}',[Admin_24Controller::class,'trungtuyenchinhthucdotts']);  //Trúng tuyển chính thức
        Route::post('/khoaxettuyendotts',[Admin_24Controller::class,'khoaxettuyendotts']);  //Trúng tuyển chính thức
        Route::post('/congboketquatheodotxt',[Admin_24Controller::class,'congboketquatheodotxt']);  //Trúng tuyển chính thức
        Route::get('/dieutraketquatheodotxt',[Admin_24Controller::class,'dieutraketquatheodotxt']);  //Trúng tuyển chính thức
        Route::get('/danhsachtrungtuyenchinhthuc/{iddotts}/{iddotxt}/{id_chuyennganh}',[Admin_24Controller::class,'danhsachtrungtuyenchinhthuc']);  //Trúng tuyển chính thức
        Route::get('/xuatdanhsachtrungtuyenchinhthuc/{iddotts}/{iddotxt}/{id_chuyennganh}',[Admin_24Controller::class,'xuatdanhsachtrungtuyenchinhthuc']);  //Trúng tuyển chính thức
        Route::get('/xuatdanhsachkhongdatchinhthuc/{iddotts}/{iddotxt}/{id_chuyennganh}',[Admin_24Controller::class,'xuatdanhsachkhongdatchinhthuc']);  //Trúng tuyển chính thức

            //Update Đọt xét tuyển chung
        Route::post('/laytieudotcacdotxt',[Admin_24Controller::class,'laytieudotcacdotxt']);  //Trúng tuyển chính thức
        Route::post('/diemlocao',[Admin_24Controller::class,'diemlocao']);  //Trúng tuyển chính thức
        Route::get('/bieudolocaotheonganh/{iddotts}/{id_nganh}',[Admin_24Controller::class,'bieudolocaotheonganh']);  //Trúng tuyển chính thức

            //Quản lý thí sinh
        //Import tài khoản
        Route::get('/importdulieu',[Admin_24Controller::class,'importdulieu']);
        Route::post('/submit_taikhoanthisinh',[Admin_24Controller::class,'submit_taikhoanthisinh']); //Tạo Tài khoản
        Route::post('/submit_thongtinthisinh',[Admin_24Controller::class,'submit_thongtinthisinh']);
        Route::post('/submit_khuvucuutien',[Admin_24Controller::class,'submit_khuvucuutien']);
        Route::post('/submit_doituonguutien',[Admin_24Controller::class,'submit_doituonguutien']);
        Route::post('/submit_namtotnghiep',[Admin_24Controller::class,'submit_namtotnghiep']);
        Route::get('/import_loaddanhsachtaikhoan',[Admin_24Controller::class,'import_loaddanhsachtaikhoan']);//Load danh sách tài khoản
        Route::get('/export_taikhoanthisinh',[Admin_24Controller::class,'export_taikhoanthisinh']);

        //Import thông tin xét tuyển
        Route::get('/importketquahoctap',[Admin_24Controller::class,'importketquahoctap']);
        Route::post('/submit_ketquahoctap',[Admin_24Controller::class,'submit_ketquahoctap']);
        Route::get('/import_loadketquahoctap/{iddot}/{limit}/{offset}',[Admin_24Controller::class,'import_loadketquahoctap']);//Load Kết quả học tập
        Route::get('/export_ketquahoctap/{iddot}/{limit}/{offset}',[Admin_24Controller::class,'export_ketquahoctap']);

        //Import Nguyện vọng
        Route::get('/importnguyenvong',[Admin_24Controller::class,'importnguyenvong']);
        Route::post('/submit_nguyenvongxettuyen',[Admin_24Controller::class,'submit_nguyenvongxettuyen']);
        Route::get('/import_loadnguyenvongxettuyen/{dotts}',[Admin_24Controller::class,'import_loadnguyenvongxettuyen']);
        Route::post('/export_nguyenvongxettuyen_kiemtrasoluong/{dotts}',[Admin_24Controller::class,'export_nguyenvongxettuyen_kiemtrasoluong']);
        Route::get('/export_nguyenvongxettuyen/{dotts}/{start}/{end}',[Admin_24Controller::class,'export_nguyenvongxettuyen']);
        Route::post('/cal_nguyenvongxettuyen',[Admin_24Controller::class,'cal_nguyenvongxettuyen']);


        // Route::get('/import_tinhdiemxettuyen',[Admin_24Controller::class,'import_tinhdiemxettuyen']);
            //Điều tra nhập học
        //Load index
        Route::get('/dieutranhaphoc',[Admin_24Controller::class,'dieutranhaphoc']);  //Load index
        Route::post('/capnhattrangthaixnnh',[Admin_24Controller::class,'capnhattrangthaixnnh']);  //Load index
        Route::post('/capnhatghichuxnnh',[Admin_24Controller::class,'capnhatghichuxnnh']);  //Load index
            //Thống kê điều tra nhập học
        //Load index
        Route::get('/tinhtrangnhaphoc',[Admin_24Controller::class,'tinhtrangnhaphoc']);  //Load index
        Route::get('/ttnh_danhsach/{dotts}/{dotxt}/{chuyennganh}',[Admin_24Controller::class,'ttnh_danhsach']);  //Load index



        //Import MSSV từ Edu
        Route::get('/importmssv',[Admin_24Controller::class,'importmssv']);
        Route::post('/submit_importmssv',[Admin_24Controller::class,'submit_importmssv']);
        //Import DS xác nhận Cổng Bộ
        Route::get('/importxacnhanbo',[Admin_24Controller::class,'importxacnhanbo']);
        Route::post('/submit_importxacnhanbo',[Admin_24Controller::class,'submit_importxacnhanbo']);




            //Quản lý thí sinh
        //Danh sách thí sinh
        Route::get('/dsts',[Admin_24Controller::class,'dsts']); //Load Index
        Route::get('/dsts_loadtimkiem',[Admin_24Controller::class,'dsts_loadtimkiem']);
        Route::get('/dsts_loadds/{namts}/{dotts}/{namtn}/{tinh}/{truong}/{ngaydangky1}/{ngaydangky2}/{gioitinh}',[Admin_24Controller::class,'dsts_loadds']);
        Route::get('/dsts_change_tinh/{tinh}',[Admin_24Controller::class,'dsts_change_tinh']);
        Route::get('/dsts_excel/{namts}/{dotts}/{namtn}/{tinh}/{truong}/{ngaydangky1}/{ngaydangky2}/{gioitinh}',[Admin_24Controller::class,'dsts_excel']);




        //Thống kê đăng ký
        Route::get('/thongkedangky',[Admin_24Controller::class,'thongkedangky']); //Load Index




        //Quản lý đồng phuc
        //Nhập đồng phục
        Route::get('/nhapdongphuc',[Admin_24Controller::class,'nhapdongphuc']);
        Route::get('/ds_dotnhap',[Admin_24Controller::class,'ds_dotnhap']);
        Route::get('/load_dssanpham_dot/{id_dot}',[Admin_24Controller::class,'load_dssanpham_dot']);
        Route::post('/capnhat_soluongnhap',[Admin_24Controller::class,'capnhat_soluongnhap']);
        Route::post('/capnhat_ngaynhap',[Admin_24Controller::class,'capnhat_ngaynhap']);
        Route::post('/delete_sanphamnhap',[Admin_24Controller::class,'delete_sanphamnhap']);
        Route::get('/xuatexcel_sanphamnhap/{id_dotnhap}',[Admin_24Controller::class,'xuatexcel_sanphamnhap']);
        Route::get('/btt_xuatexcel_sanphamnhap',[Admin_24Controller::class,'btt_xuatexcel_sanphamnhap']);
        Route::post('/change_nhapsanpham',[Admin_24Controller::class,'change_nhapsanpham']);
        Route::get('/quanlynhap',[Admin_24Controller::class,'quanlynhap']);
        Route::get('/load_sanpham_quanlynhap/{id_dot}',[Admin_24Controller::class,'load_sanpham_quanlynhap']);
        Route::get('/btt_xuatexcel_ql_sanphamnhap',[Admin_24Controller::class,'btt_xuatexcel_ql_sanphamnhap']);
        Route::get('/xuatexcel_ql_sanphamnhap/{id_dotnhap}',[Admin_24Controller::class,'xuatexcel_ql_sanphamnhap']);
        Route::post('/themDot',[Admin_24Controller::class,'themDot']);
        Route::get('/load_dsdotnhap',[Admin_24Controller::class,'load_dsdotnhap']);
        Route::post('/capnhat_Dot',[Admin_24Controller::class,'capnhat_Dot']);
        Route::post('/change_trangthai',[Admin_24Controller::class,'change_trangthai']);
        // Quản lý loại
        Route::get('/quanlyloai',[Admin_24Controller::class,'quanlyloai']);
        Route::post('/themloai',[Admin_24Controller::class,'themloai']);
        Route::get('/danhsachloai',[Admin_24Controller::class,'danhsachloai']);
        Route::post('/Upd_Loai',[Admin_24Controller::class,'Upd_Loai']);
        Route::post('/change_TrangthaiLoai',[Admin_24Controller::class,'change_TrangthaiLoai']);
        Route::post('/dlt_Loai/{id}',[Admin_24Controller::class,'dlt_Loai']);
        // Quản lý nhà sản xuât
        Route::get('/quanlynhasanxuat',[Admin_24Controller::class,'quanlynhasanxuat']);
        Route::post('/themnhasanxuat',[Admin_24Controller::class,'themnhasanxuat']);
        Route::get('/danhsach_nhasanxuat',[Admin_24Controller::class,'danhsach_nhasanxuat']);
        Route::post('/Upd_Nhasanxuat',[Admin_24Controller::class,'Upd_Nhasanxuat']);
        Route::post('/change_TrangthaiNSX',[Admin_24Controller::class,'change_TrangthaiNSX']);
        Route::post('/dlt_Nhasaxuat/{id}',[Admin_24Controller::class,'dlt_Nhasaxuat']);
        // Quản lý size
        Route::get('/quanlysize',[Admin_24Controller::class,'quanlysize']);
        Route::post('/themsize',[Admin_24Controller::class,'themsize']);
        Route::get('/danhsachsize',[Admin_24Controller::class,'danhsachsize']);
        Route::post('/Upd_Size',[Admin_24Controller::class,'Upd_Size']);
        Route::post('/change_TrangthaiSize',[Admin_24Controller::class,'change_TrangthaiSize']);
        Route::post('/dlt_Size/{id}',[Admin_24Controller::class,'dlt_Size']);
        // Quản lý sản phẩm
        Route::get('/quanlysanpham',[Admin_24Controller::class,'quanlysanpham']);
        Route::get('/qlsp_loadds',[Admin_24Controller::class,'qlsp_loadds']);
        Route::get('/load_dssanpham',[Admin_24Controller::class,'load_dssanpham']);
        Route::post('/themsanpham',[Admin_24Controller::class,'themsanpham']);
        Route::post('/themsanpham_qrcode',[Admin_24Controller::class,'themsanpham_qrcode']);
        Route::post('/change_TrangthaiSP',[Admin_24Controller::class,'change_TrangthaiSP']);
        Route::post('/update_Sanpham',[Admin_24Controller::class,'update_Sanpham']);
        Route::post('/update_Sanpham_etc',[Admin_24Controller::class,'update_Sanpham_etc']);
        Route::post('/update_Anhsanpham',[Admin_24Controller::class,'update_Anhsanpham']);
        Route::get('/btn_edit_sanpham',[Admin_24Controller::class,'btn_edit_sanpham']);
        Route::post('/dlt_SP/{id}',[Admin_24Controller::class,'dlt_SP']);
        Route::get('/data_QRcode/{id}',[Admin_24Controller::class,'data_QRcode']);
        // Quản lý đợt nhập
        Route::get('/ql_dotnhap',[Admin_24Controller::class,'ql_dotnhap']);
        Route::get('/qldot_load_dssanpham_dot/{id}',[Admin_24Controller::class,'qldot_load_dssanpham_dot']);
        Route::post('/change_soluong',[Admin_24Controller::class,'change_soluong']);
        Route::get('/bieudo_thongke_nhap',[Admin_24Controller::class,'bieudo_thongke_nhap']);
        //Phát đồng phục
        // Route::get('/phatdongphuc',[Admin_24Controller::class,'phatdongphuc']);
        // Route::get('/phatdongphuc_timkiem',[Admin_24Controller::class,'phatdongphuc_timkiem']);
        // Route::get('/ds_dongphuc',[Admin_24Controller::class,'ds_dongphuc']);
        // Route::get('/kiem_tra_tt_sv',[Admin_24Controller::class,'kiem_tra_tt_sv']);
        // Route::get('/select_dot_phat',[Admin_24Controller::class,'select_dot_phat']);
        // Route::post('/phat_dongphuc',[Admin_24Controller::class,'phat_dongphuc']);
        // Route::post('/guimail_hd/{id_sv}',[Admin_24Controller::class,'guimail_hd']);
        // Route::get('/in_hoadon/{mahoadon}',[Admin_24Controller::class,'in_hoadon']);
        // Route::get('/lay_soluong_ton',[Admin_24Controller::class,'lay_soluong_ton']);
        // Route::get('/ds_hoadon_sv/{id}', [Admin_24Controller::class, 'ds_hoadon_sv']);
         //Phát đồng phục
         Route::get('/phatdongphuc',[Admin_24Controller::class,'phatdongphuc']);
         Route::get('/phatdongphuc_timkiem',[Admin_24Controller::class,'phatdongphuc_timkiem']);
         Route::get('/ds_dongphuc',[Admin_24Controller::class,'ds_dongphuc']);
         Route::get('/kiem_tra_tt_sv',[Admin_24Controller::class,'kiem_tra_tt_sv']);
         Route::get('/select_dot_phat',[Admin_24Controller::class,'select_dot_phat']);
         Route::post('/phat_dongphuc',[Admin_24Controller::class,'phat_dongphuc']);
         Route::post('/guimail_hd/{id_sv}',[Admin_24Controller::class,'guimail_hd']);
         Route::get('/in_hoadon/{mahoadon}',[Admin_24Controller::class,'in_hoadon']);
         Route::get('/lay_soluong_ton',[Admin_24Controller::class,'lay_soluong_ton']);
         Route::get('/ds_hoadon_sv/{id}', [Admin_24Controller::class, 'ds_hoadon_sv']);
         Route::post('/add', [Admin_24Controller::class, 'addToCart']);



         Route::post('/upload_ttsv',[Admin_24Controller::class,'upload_ttsv']);
         //Giỏ hàng
         Route::post('/cart_Database', [Admin_24Controller::class, 'cart_Database']);
         Route::post('/cart_Database_QR', [Admin_24Controller::class, 'cart_Database_QR']);
         Route::post('/remove_from_cart/{id_cart}/{id_nguoinhan}/{id_dotphat}/{id_nguoiphat}', [Admin_24Controller::class, 'remove_from_cart']);
         Route::post('/update_sl', [Admin_24Controller::class, 'update_sl']);
         Route::post('/update_input_sl', [Admin_24Controller::class, 'update_input_sl']);
         Route::post('/phat_dong_phuc', [Admin_24Controller::class, 'phat_dong_phuc']);
        //Quản lý hóa đơn
        Route::get('/quanlyhoadon',[Admin_24Controller::class,'quanlyhoadon']);
        Route::get('/ds_hoadon_dongphuc',[Admin_24Controller::class,'ds_hoadon_dongphuc']);
        Route::post('/xoa_hoadon/{mahoadon}',[Admin_24Controller::class,'xoa_hoadon']);
        // Thống kê phát đồng phục
        Route::get('/thongkedongphuc',[Admin_24Controller::class,'thongkedongphuc']);
        Route::get('/data_thongkedongphuc',[Admin_24Controller::class,'data_thongkedongphuc']);
        Route::get('/ds_thongke_phat',[Admin_24Controller::class,'ds_thongke_phat']);
        Route::get('/select2_hoadon_search',[Admin_24Controller::class,'select2_hoadon_search']);
        Route::get('/timkiem_hoadon',[Admin_24Controller::class,'timkiem_hoadon']);
        Route::get('/btt_excel_hdphat',[Admin_24Controller::class,'btt_excel_hdphat']);
        Route::get('/btt_excel_hdphat',[Admin_24Controller::class,'btt_excel_hdphat']);
        Route::get('/bieudo_hoadon_phat',[Admin_24Controller::class,'bieudo_hoadon_phat']);
        Route::get('/bat_validate',[Admin_24Controller::class,'bat_validate']);
        Route::get('/btt_excel_thongke_hd_phat',[Admin_24Controller::class,'btt_excel_thongke_hd_phat']);


         //Quản lý đợt phát
         Route::get('/quanlydotphat',[Admin_24Controller::class,'quanlydotphat']);
         Route::get('/ds_dotphat',[Admin_24Controller::class,'ds_dotphat']);
         Route::post('/them_dot',[Admin_24Controller::class,'them_dot']);
         Route::post('/change_trangthai_dotphat/{id}/{trangthai}',[Admin_24Controller::class,'change_trangthai_dotphat']);
         Route::post('/change_dot',[Admin_24Controller::class,'change_dot']);
         Route::post('/change_stt',[Admin_24Controller::class,'change_stt']);
         //Quản lý kho
         Route::get('/quanlykho',[Admin_24Controller::class,'quanlykho']);
         Route::get('/ds_kho',[Admin_24Controller::class,'ds_kho']);
         Route::post('/change_trangthai_kho',[Admin_24Controller::class,'change_trangthai_kho']);
         Route::get('/bieudo_kho',[Admin_24Controller::class,'bieudo_kho']);
         Route::get('/btt_excel_kho',[Admin_24Controller::class,'btt_excel_kho']);
         //Thống kê kho
         Route::get('/thongkekho',[Admin_24Controller::class,'thongkekho']);
            //Quản lý sinh viên
        Route::prefix('hosonhaphoc')->group(function(){
            //Quan ly nhap hoc
            Route::get('/',[Admin_24Controller::class,'hosonhaphoc_qlsv']);
            // Route::get('/loadttcn_qlsv/{cccd}/{mssv}',[Admin_24Controller::class,'loadttcn_qlsv']);
            Route::post('/loadttcn_qlsv',[Admin_24Controller::class,'loadttcn_qlsv']);
            Route::get('/loaddottuyensinh',[Admin_24Controller::class,'loaddottuyensinh']);
            Route::get('/luuthongtincanhan',[Admin_24Controller::class,'luuthongtincanhan']);
            Route::post('/capnhatdiachi_tinh',[Admin_24Controller::class,'capnhatdiachi_tinh']);
            Route::post('/capnhatdiachi_huyen',[Admin_24Controller::class,'capnhatdiachi_huyen']);
            Route::post('/capnhatdiachi_xa',[Admin_24Controller::class,'capnhatdiachi_xa']);
            Route::post('/luuthuongtru',[Admin_24Controller::class,'luuthuongtru']);
            Route::post('/luuquequan',[Admin_24Controller::class,'luuquequan']);
            Route::post('/danhmuchoso',[Admin_24Controller::class,'danhmuc_hoso']);
            Route::get('/loaddanhmuc',[Admin_24Controller::class,'loaddanhmuc']);
            Route::post('/nhanhoso',[Admin_24Controller::class,'nhanhoso']);
            Route::post('/slider',[Admin_24Controller::class,'slider']);
            Route::post('/xoahinhhhsnh',[Admin_24Controller::class,'xoahinhhhsnh']);
            //noisinh
            Route::get('/loadtinh',[Admin_24Controller::class,'loadtinh']);
            Route::get('/loadhuyen/{tinh1}',[Admin_24Controller::class,'loadhuyen']);
            Route::get('/loadxa/{huyen1}',[Admin_24Controller::class,'loadxa']);
            //thuongtru
            Route::get('/loadtinh2',[Admin_24Controller::class,'loadtinh2']);
            Route::get('/loadhuyen2/{tinh2}',[Admin_24Controller::class,'loadhuyen2']);
            Route::get('/loadxa2/{huyen2}',[Admin_24Controller::class,'loadxa2']);
            //quequan
            Route::get('/loadtinh3',[Admin_24Controller::class,'loadtinh3']);
            Route::get('/loadhuyen3/{tinh3}',[Admin_24Controller::class,'loadhuyen3']);
            Route::get('/loadxa3/{huyen3}',[Admin_24Controller::class,'loadxa3']);
            //Cap nhat thong tin ca nhan
            Route::post('/capnhatthongtincannhan',[Admin_24Controller::class,'capnhatthongtincannhan']);
            Route::post('/nhapmssv',[Admin_24Controller::class,'nhapmssv']);
        });

            Route::get('giayxacnhan',[Admin_24Controller::class,'xuatfile_index']);
            //xuatfile
            // Route::get('/xuatfile',[Admin_24Controller::class,'xuatfile']);
            Route::get('/loadkhoa',[Admin_24Controller::class,'loadkhoa']);
            Route::get('/loadmajor',[Admin_24Controller::class,'loadmajor']);
            Route::get('/loadlop/{idkhoa}',[Admin_24Controller::class,'loadlop']);
            Route::get('/loadnam',[Admin_24Controller::class,'loadkhoas']);
            Route::get('/loadthongtin/{major}/{cccd}/{mssv}',[Admin_24Controller::class,'loadthongtin']);
            Route::get('/loadloaigiay',[Admin_24Controller::class,'loadloaigiay']);
            Route::get('/bhyt',[Admin_24Controller::class,'bhyt']);
            Route::get('/excel_hsnh_thongtinsinhvien/{major}/{cccd}/{mssv}/{id_sinhvien}',[Admin_24Controller::class,'excel_hsnh_thongtinsinhvien']);
            //Route::get('/pdf_hsnh_thongtinsinhvien/{id_sinhvien}/{loaigiay}/{admin_sig}',[Admin_24Controller::class,'pdf_hsnh_thongtinsinhvien']);
            Route::get('/pdf_hsnh_thongtinsinhvien/{code}',[Admin_24Controller::class,'pdf_hsnh_thongtinsinhvien']);
            Route::get('/tim_maphieu/{id_maphieu}',[Admin_24Controller::class,'tim_maphieu']);
            Route::get('/inlai_maphieu/{id_maphieu}',[Admin_24Controller::class,'inlai_maphieu']);
            //thongke_xuatfile
            Route::get('/thongke',[Admin_24Controller::class,'thongke']);
            Route::get('/loaigiay',[Admin_24Controller::class,'loaigiay']);
            Route::get('/thongke_xuatfile/{nam}/{lop}/{idkhoa}',[Admin_24Controller::class,'thongke_xuatfile']);
            Route::get('/excel_hsnh_thongke_xuatfile/{nam}/{id_lop}/{idkhoa}',[Admin_24Controller::class,'excel_hsnh_thongke_xuatfile']);
            //bhyt
            Route::get('/bhyt',[Admin_24Controller::class,'bhyt']);
            Route::post('/import_bhyt',[Admin_24Controller::class,'import_bhyt']);
            Route::get('/loadthongtin_bhyt/{major}/{cccd}/{mssv}/{bhyt}',[Admin_24Controller::class,'loadthongtin_bhyt']);//bhyt
            Route::get('/excel_hsnh_thongtinsinhvien_bhyt/{id_sinhvien}', [Admin_24Controller::class, 'excel_hsnh_thongtinsinhvien_bhyt']);
            Route::get('/img_bhyt/{id}',[Admin_24Controller::class,'img_bhyt']);//bhyt
            Route::post('/capnhat_bhyt',[Admin_24Controller::class,'capnhat_bhyt']);
            //thống kê bhyt
            Route::get('/loadlop_bhyt',[Admin_24Controller::class,'loadlop_bhyt']);
            Route::get('/onchange/{id}',[Admin_24Controller::class,'onchange']);
            Route::get('/loadkhoa_bhyt',[Admin_24Controller::class,'loadkhoa_bhyt']);
            Route::get('/loadnam_bhyt',[Admin_24Controller::class,'loadnam_bhyt']);
            Route::get('/bhyt_thongke',[Admin_24Controller::class,'bhyt_thongke']);
            Route::get('/loadthongtin_bhyt_thongke/{lop}/{nam}/{khoa}',[Admin_24Controller::class,'loadthongtin_bhyt_thongke']);
            Route::get('/excel_hsnh_thongtinsinhvien_bhyt_thongke/{lop}/{nam}/{khoa}',[Admin_24Controller::class,'excel_hsnh_thongtinsinhvien_bhyt_thongke']);//bhyt
            //Tra cứu sinh viên
            Route::get('/tracuusinhvien',[Admin_24Controller::class,'tracuusinhvien']);
            Route::get('/tcsv_loadtimkiem',[Admin_24Controller::class,'tcsv_loadtimkiem']);
            Route::get('/tcsv_timkiem/{data}',[Admin_24Controller::class,'tcsv_timkiem']);
            Route::get('/tcsv_load_img/{id}/{id_img}',[Admin_24Controller::class,'tcsv_load_img']);
            Route::get('/tcsv_excel/{data}',[Admin_24Controller::class,'tcsv_excel']);
            Route::get('/tcsv_dp_excel/{data}',[Admin_24Controller::class,'tcsv_dp_excel']);
            //Danh sách thu hồ sơ sinh viên
            Route::get('/hssv_danhsachssv',[Admin_24Controller::class,'hssv_danhsachssv']);
            Route::get('/hssv_load_thanhtimkiem',[Admin_24Controller::class,'hssv_load_thanhtimkiem']);
            Route::get('/hssv_load_danhsachssv/{uri}',[Admin_24Controller::class,'hssv_load_danhsachssv']);
            Route::get('/hssv_excel_danhsach/{uri}',[Admin_24Controller::class,'hssv_excel_danhsach']);
            Route::get('/hssv_pdf_danhsach/{uri}/{lop}',[Admin_24Controller::class,'hssv_pdf_danhsach']);

            //Thống kê hồ sơ sinh viên
            Route::get('/tkhssv_thongke',[Admin_24Controller::class,'tkhssv_thongke']);




            //Thống kê - Phân tích số liêu
        //Theo giới tính
        Route::get('/thsl_gioitinh',[Admin_24Controller::class,'thsl_gioitinh']);
        Route::get('/thsl_loadbieudo_cacnam/{namts}/{namtn}/{tinh}/{truong}',[Admin_24Controller::class,'thsl_loadbieudo_cacnam']);
        Route::get('/thsl_excel/{namts}/{namtn}/{tinh}/{truong}',[Admin_24Controller::class,'thsl_excel']);


        //Theo Tỉnh/Thanh phố
        Route::get('/thsl_tinh',[Admin_24Controller::class,'thsl_tinh']);
        Route::get('/thsl_tinh_bieudo_tinh_data/{namts}/{namtn}/{tinh}/{top}/{soluong}/{iddot}',[Admin_24Controller::class,'thsl_tinh_bieudo_tinh_data']);
        Route::get('/thsl_tinh_excel/{namts}/{namtn}/{tinh}/{top}/{soluong}',[Admin_24Controller::class,'thsl_tinh_excel']);
        Route::get('/getgeoson',[Admin_24Controller::class,'getgeoson']);//Bản đồ Tỉnh

        //Theo Trường THPT
        Route::get('/thsl_truongthpt',[Admin_24Controller::class,'thsl_truongthpt']);
        Route::get('/thsl_tinh_bieudo_truong_data/{namts}/{namtn}/{tinh}/{truong}/{top}/{soluong}',[Admin_24Controller::class,'thsl_tinh_bieudo_truong_data']);
        Route::get('/thsl_truongthpt_toado/{truong}',[Admin_24Controller::class,'thsl_truongthpt_toado']);
        Route::get('/thsl_truong_popup_sumit/{truong}/{lon}/{lat}',[Admin_24Controller::class,'thsl_truong_popup_sumit']);
        Route::get('/thsl_truong_excel/{namts}/{namtn}/{tinh}/{truong}/{top}/{soluong}',[Admin_24Controller::class,'thsl_truong_excel']);

        //Trung tuyen - Nhap hoc
        Route::get('/thsl_trungtuyen_nhaphoc',[Admin_24Controller::class,'thsl_trungtuyen_nhaphoc']);
        Route::get('/thsl_trungtuyen_nhaphoc_danhsach/{idnam}/{iddot}',[Admin_24Controller::class,'thsl_trungtuyen_nhaphoc_danhsach']);
        Route::get('/thsl_trungtuyen_nhaphoc_danhsach_thongke/{idnam}/{iddot}',[Admin_24Controller::class,'thsl_trungtuyen_nhaphoc_danhsach_thongke']);







            //Quản lý giấy xác nhận
        //Danh mục
        Route::get('/gxn_danhmuc',[Admin_24Controller::class,'gxn_danhmuc']);
        Route::get('/gxn_danhsachgiay',[Admin_24Controller::class,'gxn_danhsachgiay']);
        Route::get('/dm_gxn_load_bandau',[Admin_24Controller::class,'dm_gxn_load_bandau']);
        Route::get('/dm_gxn_load_modal/{id}',[Admin_24Controller::class,'dm_gxn_load_modal']);
        Route::post('/gxn_add', [Admin_24Controller::class, 'gxn_add']);
        Route::delete('/gxn_delete/{id}', [Admin_24Controller::class, 'gxn_delete']);
        Route::post('/gxn_update', [Admin_24Controller::class, 'gxn_update']);
        Route::get('/pdf_tiepnhan1',[Admin_24Controller::class,'pdf_tiepnhan1']);

        // //Tiếp nhận
        Route::get('/gxn_tiepnhan',[Admin_24Controller::class,'gxn_tiepnhan']);
        Route::get('/gxn_tiepnhan_test',[Admin_24Controller::class,'gxn_tiepnhan_test']);
        Route::get('/gxn_danhsachdangky/{id_nam}',[Admin_24Controller::class,'gxn_danhsachdangky']);
        Route::get('/btt_excel_danhmuc/{id_nam}',[Admin_24Controller::class,'btt_excel_danhmuc']);
        Route::get('/pdf_tiepnhan/{id_taikhoan}/{id_loaigiay}/{id_nam}',[Admin_24Controller::class,'pdf_tiepnhan']);
        Route::get('/pdf_tiepnhan_save/{id_taikhoan}/{id_loaigiay}/{id_nam}',[Admin_24Controller::class,'pdf_tiepnhan_save']);
        Route::post('/updateStatus', [Admin_24Controller::class, 'changeStatus']);


        //Quản lý chức năng
        Route::get('/themchucnang',[Admin_24Controller::class,'themchucnang']);
        Route::get('/importchucnang',[Admin_24Controller::class,'importchucnang']);
        Route::get('/load_danhsachchucnang/{id_manhinh}',[Admin_24Controller::class,'load_danhsachchucnang']);
        Route::get('/load_danhsachquyen',[Admin_24Controller::class,'load_danhsachquyen']);
        Route::get('/load_manhinh_chucnang',[Admin_24Controller::class,'load_manhinh_chucnang']);
        Route::get('/load_chucnang',[Admin_24Controller::class,'load_chucnang']);
        Route::post('/add_chucnang',[Admin_24Controller::class,'add_chucnang']);
        Route::post('/add_phanquyen',[Admin_24Controller::class,'add_phanquyen']);
        Route::post('/xoa_chucnang',[Admin_24Controller::class,'xoa_chucnang']);
        Route::post('/xoa_phanquyen',[Admin_24Controller::class,'xoa_phanquyen']);
        Route::post('/sua_trangthai',[Admin_24Controller::class,'sua_trangthai']);
        Route::post('/sua_ten_chucnang',[Admin_24Controller::class,'sua_ten_chucnang']);
        Route::post('/sua_gc_chucnang',[Admin_24Controller::class,'sua_gc_chucnang']);

    });




});

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
    Route::post('/getTonkho', [OrderController::class, 'getTonkho']);
    Route::post('/cart/update', [OrderController::class, 'updateQuantity'])->name('cart.updateQuantity');
    Route::delete('/cart/delete', [OrderController::class, 'deleteSP'])->name('cart.delete');
    Route::post('/cart/checkout', [OrderController::class, 'checkout'])->name('cart.checkout');

    // Route::get('/orders', [UserController::class, 'showOrders']);
    Route::get('/orders/details/{hd_id}', [UserController::class, 'getOrderDetails'])->name('getOrderDetails');
    Route::post('/orders/cancel', [UserController::class, 'cancelOrder'])->name('orders.cancel');


    Route::get('/sizes', [Size1Controller::class, 'sizes']);
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
    Route::get('/search-sidebar', [SearchController::class, 'searchSidebar'])->name('search.sidebar');


    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

});


