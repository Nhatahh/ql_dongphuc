<?php

namespace App\Http\Controllers\User_24\Admin;

use Illuminate\Queue\InteractsWithQueue;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use PhpOption\Option;
use Carbon\Carbon;
use PhpParser\Node\Expr\FuncCall;
use \App\Http\Controllers\User\Main\InfoUserController;
use \App\Http\Controllers\User\Main\RegisterWishController;
use Exception;
use Illuminate\Support\Arr;
use PhpParser\Node\Stmt\Return_;

use function PHPUnit\Framework\countOf;


//Excel
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

//Quản lý thí sinh
use App\Exports\Admin24_Dsts_Excel;
use App\Exports\Admin24_XuatDSQLS_DP;


    //Thống kế số liệu
//Theo Giới tính
use App\Exports\Admin24_ThongKeGioiTinh_Excel;
//Theo Tỉnh - Thành phố
use App\Exports\Admin24_ThongKeNhapHocTheoTinh_Excel;
use App\Exports\Admin24_ThongKeNhapHocTheoTruong_Excel;


use App\Exports\Admin24_ExportDanhSachThanhtoan;
use App\Exports\Admin24_ExportDanhSachGuiMail;
use App\Exports\Admin24_ExportDanhSacXetTuyen;
use App\Exports\Admin24_ExportDanhSachTrungTuyenTheoDotTS;
use App\Exports\Admin24_ExportDanhSachTrungTuyenChinhThuc;
use App\Exports\Admin24_ExportDanhSachKhongDatChinhThuc;
use App\Exports\Admin24_ExportDanhSachThiSinh;
use App\Exports\Admin24_ExportKetQuaHocTap;
use App\Exports\Admin24_ExportDanhSachNguyenVong;
use App\Exports\Admin24_ExportDanhSachLocAo;
use App\Exports\Admin24_ExportThongKeSoLuongTrungTuyen;
use App\Exports\Admin24_DanhSachChiTietTheoDot;
use App\Exports\Admin24_Excel_Hsnh_Thongtinsinhvien;
use App\Exports\Admin24_Excel_Hsnh_ThongkeXuatfile;
use App\Exports\Admin24_DanhSachHoaDon;
use App\Exports\Admin24_DanhSachHoaDonThongKe;
use App\Exports\Admin24_DanhSachKho;
use App\Exports\Admin24_Excel_Hsnh_Thongtinsinhvien_bhyt_thongke;



use App\Exports\Admin24_Excel_Hsnh_Thongtinsinhvien_bhyt;
use App\Exports\Admin24_ExportDanhSachSanPhamNhapDotNhap;
use App\Exports\Admin24_ExportDanhSachQuanLySanPhamNhapDotNhap;

//Tra cứu sinh viên
use App\Exports\Admin24_XuatDSNhaphoc;

//Quan ly gaiy xac nhan
use App\Exports\Admin24_Danhsachtiepnhan;


use App\Imports\Admin24_ImportDanhSachThiSinh;
use App\Imports\Admin24_ImportThongTinThiSinh;
use App\Imports\Admin24_ImportKhuVucUuTien;
use App\Imports\Admin24_ImportDoiTuongUuTien;
use App\Imports\Admin24_NamTotNghiep;
use App\Imports\Admin24_ImportKetQuaHocTap;
use App\Imports\Admin24_ImportNguyenVongXetTuyen;
use App\Imports\Admin24_ImportKetQuaNhom;
use App\Imports\Admin24_ImportMSSV;
use App\Imports\Admin24_ImportXacnhanBo;
use App\Imports\Import_bhyt;

use App\Imports\Admin24_Import_ThongTinSinhVien_DP;

use Svg\Tag\Rect;

//Email
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use App\Mail\Guithu;
use App\Mail\QuanlyMail;
use App\Mail\MailDuyet;
use App\Mail\Mail_Chuan_24;
//Artisan
use Illuminate\Support\Facades\Artisan;

//DataTables
use Yajra\DataTables\Facades\DataTables;

//

use App\Events\UserRegistered;
use App\Exports\Admin24_ExportDanhSachPhanCong;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Response;

use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Support\Facades\Event;
use Tymon\JWTAuth\Payload;
//Quân mới thêm
use Illuminate\Support\Str;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;
use Jenssegers\Agent\Agent;
// HTMLPurifier
use Mews\Purifier\Facades\Purifier;
// Qrcode
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class Admin_24Controller  extends Controller
{
    //logout
    public function logout(){
        Auth::guard('loginadmin')->logout();
    }
    public function doimatkhau(Request $request){
        $validator = Validator::make( $request->all(),
            [
                'passwordreset_old' => 'required|alpha_dash|min:6',
                'passwordreset' => 'required|alpha_dash|min:6'
            ],
            [
                'passwordreset_old.required'   => 'Vui lòng điền Mật khẩu',
                'passwordreset_old.alpha_dash' => 'Mật khẩu chỉ gồm chữ cái và chữ số',
                'passwordreset_old.min'        => 'Mật khẩu phải từ 6 ký tự trở lên',

                'passwordreset.required'   => 'Vui lòng điền Mật khẩu mới',
                'passwordreset.alpha_dash' => 'Mật khẩu mới chỉ gồm chữ cái và chữ số',
                'passwordreset.min'        => 'Mật khẩu mới phải từ 6 ký tự trở lên',
            ]
        );
        if ($validator->fails()) {
            $trangthai = 'validate';
            $noidung = response()->json($validator->errors());
        }else{
            $id = Auth::guard('loginadmin')->user()->id;
            $passwordreset_confirm = $request->input('passwordreset_confirm');
            $passwordreset = $request->input('passwordreset');
            $passwordreset_old = $request->input('passwordreset_old');
            $chuoidulieu = DB::table('24_accountsadmin')->where('id',$id)->first()->password;
            if(Hash::check($passwordreset, $chuoidulieu) == true){
                $trangthai = 3;
                $noidung = "Mật khẩu mới trùng với mật khẩu cũ";
            }else{
                if($passwordreset != $passwordreset_confirm){
                    $trangthai = 0;
                    $noidung = "Nhập lại giống với mật khẩu mới";
                }else{
                    if(Hash::check($passwordreset_old, $chuoidulieu) == true){
                        DB::table('24_accountsadmin')
                        ->where('id',$id)
                        ->update(['password'=>Hash::make($passwordreset)]);
                        $trangthai = 1;
                        $noidung = "Cập nhật mật khẩu thành công";
                    }else{
                        $trangthai = 2;
                        $noidung = "Mật khẩu cũ không khớp";
                    }
                }
            }
        }
        return array(
            'trangthai' => $trangthai,
            'noidung' => $noidung,
        );
    }
    // login
    function loginadmin()
    {
        return view('user_24.admin24.include.loginadmin');
    }
    // đăng nhập admin
    function dangnhap_admin(Request $requets)
    {
        $validator = Validator::make(
            $requets->all(),
            [
                'email' => 'required|email',
                'password' => 'required|alpha_dash|min:6'
            ],
            [
                'email.email'         => 'Email chưa đúng định dạng',
                'email.required'      => 'Vui lòng điền email',

                'password.required'   => 'Vui lòng điền Mật khẩu',
                'password.alpha_dash' => 'Mật khẩu chỉ gồm chữ cái và chữ số',
                'password.min'        => 'Mật khẩu phải từ 6 ký tự trở lên',
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors());
        } else {
            $email = $requets->input('email');
            $password = $requets->input('password');
            $remember = $requets->input('remember_Check');
            if (Auth::guard('loginadmin')->attempt(
                [
                    'email' => $email,
                    'password' => $password
                ]
            )) {
                return array(
                    'trangthai' => 1,
                    'remember' => $remember,
                    'email' => $email,
                    'password' => $password
                );
            } else {
                return array(
                    'trangthai' => 0,
                    'remember' => 0,
                    'email' => '',
                    'password' => ''
                );
            }
        }
    }
    // menu
    function datamenu($menus, $parent_id = 0, $level = 0, &$html_parent, &$html_child)
    {
        $interface_added = false; // Khởi tạo biến để kiểm tra xem interface đã được thêm hay chưa
        foreach ($menus as $key => $menu) {
            if ($menu->parent_id == $parent_id) {
                $menu->level = $level;
                if ($menu->level == 0) {
                    if ($menu->stt == 0) {
                        $html_parent .= '<li  class="menu-active"  menu = "' . $menu->link . '" id = "li_' . $menu->link . '">';
                        $html_parent .= '<a data-toggle="" href="' . $menu->link . '">';
                        $html_parent .= '<i class="' . $menu->icon . '"></i>' . $menu->name;
                        $html_parent .= '</a>';
                        $html_parent .= '</li>';
                    } else {
                        // Parent menu
                        $html_parent .= '<li  class="menu-active"  id = "li_' . $menu->IDMN . '">';
                        $html_parent .= '<a data-toggle="tab" href="#' . $menu->IDMN . '">';
                        $html_parent .= '<i class="' . $menu->icon . '"></i>' . $menu->name;
                        $html_parent .= '</a>';
                        $html_parent .= '</li>';
                    }
                } else {
                    // Child menu
                    if (!$interface_added) {
                        $html_child .= '<div id="' . $menu->parent_id . '" class="tab-pane notika-tab-menu-bg animated flipInX">';
                        $html_child .= '<ul class="notika-main-menu-dropdown">';
                        $interface_added = true; // Đánh dấu interface đã được thêm
                    }
                    $html_child .= '<li class="menu-active"  menu = "' . $menu->parent_id . '" id = "' . $menu->link . '"><a href="' . $menu->link . '">' . $menu->name . '</a></li>';
                }
                unset($menus[$key]);
                self::datamenu($menus, $menu->IDMN, $level + 1, $html_parent, $html_child);
            }
        }
        if ($interface_added) {
            $html_child .= '</ul>';
            $html_child .= '</div>';
        }
    }
    public function menu()
    {

        $tmp = "SELECT * FROM 24_menu ORDER BY stt asc";
        $menus = DB::select($tmp);
        if (count($menus) == 0) {
            return 1;
        }
        $this->datamenu($menus, 0, 0, $html_parent, $html_child);
        $menu = array(
            'menu_parent' => $html_parent,
            'menu_child' => $html_child,
        );
        return $menu;
    }
    //Lưu số ip truy cập
    public function truycap()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        DB::table('24_soluongtruycap')
            ->insert([
                'thietbi'   => $user_agent,
                'ip'        => request()->ip()
            ]);
    }

    //Plugin
    function slnguyenvong()
    {
        return DB::table('24_nguyenvong')
            ->count();
    }

    function slthisinh()
    {
        $slthisinh = DB::table('24_nguyenvong')
            ->distinct('id_taikhoan')
            ->count();
        return $slthisinh;
    }

    function slkhoanguyenvong()
    {
        $slkhoanguyenvong = DB::table('24_khoadangky')
            ->count();
        return $slkhoanguyenvong;
    }

    function nguyenvong($thutu)
    {
        $nguyenvong = DB::table('24_khoadangky')
            ->join('24_nguyenvong', '24_nguyenvong.id_taikhoan', '24_khoadangky.id_taikhoan')
            ->where('thutu', $thutu)
            ->count();
        return $nguyenvong;
    }

    function slthisinhlephi()
    {
        $slthisinhlephi = DB::table('24_ketquathanhtoan')
            ->count();
        return $slthisinhlephi;
    }

    function tongtien()
    {
        $tongtien = DB::table('24_ketquathanhtoan')
            ->sum('total_amount');
        return $tongtien;
    }

    function sldangnhap()
    {
        $sldangnhap = DB::table('24_soluongdangnhap')
            ->join('account24s', 'account24s.google_id', '24_soluongdangnhap.google_id')
            ->where('admin', 0)
            ->count();
        return $sldangnhap;
    }

    function taikhoandangnhap()
    {
        $taikhoandangnhap = DB::table('24_soluongdangnhap')
            ->distinct('google_id')
            ->count();
        return $taikhoandangnhap;
    }

    function rpr()
    {
        $dangnhaplai = DB::select('SELECT COUNT(*) AS dem FROM (SELECT google_id, COUNT(google_id) as dem FROM `24_soluongdangnhap` GROUP BY google_id) AS data WHERE data.dem > 1');
        $taikhoandangnhap = $this->taikhoandangnhap();
        $taikhoandangnhap == 0 ? $rpr = 0 :  $rpr = round($dangnhaplai[0]->dem / $taikhoandangnhap * 100, 2);
        return $rpr;
    }

    function tongclick()
    {
        $tongclick = DB::table('24_lichsu')
            ->count();
        return $tongclick;
    }

    function taikhoan()
    {
        $taikhoan = DB::table('account24s')
            ->where('admin', 0)
            ->count();
        return $taikhoan;
    }

    function chitieu()
    {
        $chitieu = DB::table('24_nganhchitieu')
            ->sum('chitieu');
        return $chitieu;
    }
    //Load Img
    function data_img($id,$id_img)
    {
        if($id_img == 0){
            $data = DB::table('24_image_chuan')
            ->select('24_image.id_taikhoan as id_taikhoan','24_image_chuan.id as id',DB::raw('if(24_image.id_image_chuan is null,1,0) as trangthai'),DB::raw('if(24_image.path_img is null,"/img/test.png",24_image.path_img) as path_img'),'24_image_chuan.ghichu','24_image_chuan.loaianh','24_image_chuan.thutu','24_image_chuan.ghichu')
            ->leftJoin('24_image','24_image.id_image_chuan','24_image_chuan.id')
            ->where('24_image.id_taikhoan',$id)
            ->get();
            if($data){
                return $data;
            }
        }
        return false;
    }
    //Tạo chuỗi ngẫu nhiên
    function rand_string($length)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = '';
        $size = strlen($chars);

        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[rand(0, $size - 1)];
        }
        return $str;
    }
    //Kiểm tra quyền ajax
    function kiemtraquyen($id_nguoidung, $id_manhinh, $id_chucnang, $time, $active)
    {
        $quyen_nguoidung = Auth::guard('loginadmin')->user()->admin;
        $chuoigoc = $id_nguoidung . '_' .  $id_manhinh . '_' . $id_chucnang . '_' . $time;
        switch ($quyen_nguoidung) {
            case '2': //Quyền root có mọi quyền
                $quyen = 1;
                break;
            case '1':
                //Kiểm tra quyền AJax (QUyền Click trên màn hình)
                $quyen_manhinh = DB::table('24_phanquyen')
                    ->where([
                        ['id_nguoidung', $id_nguoidung],
                        ['id_manhinh', $id_manhinh],
                        ['id_chucnang', $id_chucnang],
                    ])->first();
                if ($quyen_manhinh) {
                    Hash::check($chuoigoc, $quyen_manhinh->create_at) ? $quyen = 1 : $quyen = 0;
                } else {
                    $quyen = 0;
                }
                break;
            default:
                $quyen = 0;
                break;
        }
        return $quyen;
    }
    //Kiểm tra trúng tuyển theo đợt
    function kiemtrakhoadottuyensinh($dottuyensinh){
        $trangthai = DB::table('24_dottuyensinh')
        ->where('id',$dottuyensinh)
        ->first();
        if($trangthai){
            $kq = $trangthai->khoadot;
        }else{
            $kq = -1;
        }
        return $kq;
    }

    function motdottuyensinh(){
        return 2;
    }

    function namtuyensinh(){
        return 2024;
    }

    function dotchayxettuyen(){
        return 3;
    }

    function load_seclectbox($table,$feild_id,$feild_text,$seclected_id,$text_0){
        $data0 = new Collection([
            'id' => 0,
            'text' => $text_0,
            'selected' =>'selected'
        ]);
        $data = DB::table($table)->select($feild_id." as id",$feild_text." as text")->get();
        $i = 0;
        foreach ($data as $value) {
            if($value->id == $seclected_id){
                $value->selected =  'selected';
                $i++;
            }else{
                $value->selected =  '';
            }
        }
        if( $i == 1){
            $data[] = new Collection([
                'id' => 0,
                'text' => $text_0,
                'selected' =>''
            ]);
        }else{
            $data[] = new Collection([
                'id' => 0,
                'text' => $text_0,
                'selected' =>'selected'
            ]);
        }
        return $data;
    }

    function load_muti_seclectbox($table,$feild_id,$feild_text,$feild_id_table1,$id_table2,$text_0){
        $data0 = new Collection([
            'id' => 0,
            'text' => $text_0,
            'selected' =>'selected'
        ]);
        $data = DB::table($table)
        ->select($feild_id." as id",$feild_text." as text")
        ->where($feild_id_table1,$id_table2)
        ->get();
        $data[] = $data0;

        return $data;
    }


    //Kiểm tra quyền url
    function kiemtraquyen_url($url)
    {
        //Kiểm tra quyền trên URL khi load vào
        $quyen_nguoidung = Auth::guard('loginadmin')->user()->admin;
        switch ($quyen_nguoidung) {
            case '2':
                $quyen = 1;
                break;
            case '1':
                $id_nguoidung = Auth::guard('loginadmin')->user()->id;
                $arr_url = explode('/', $url);
                $chucnang_text =  strval(end($arr_url));
                $check = DB::table('24_menu')
                    ->select('IDMN')
                    ->where('link', $chucnang_text)
                    ->first();
                if ($check) {
                    $quyen_url = DB::table('24_phanquyen')
                        ->join('24_accountsadmin', '24_phanquyen.id_nguoidung', '24_accountsadmin.id')
                        ->where([
                            ['id_manhinh',  $check->IDMN],
                            ['id_chucnang', 1],
                            ['id_nguoidung', $id_nguoidung],
                            ['admin', '>', 0],
                        ])->first();
                    $quyen_url ?  $quyen = 1 : $quyen = 0;
                } else {
                    $quyen = 0;
                }
                break;
            default:
                $quyen = 0;
                break;
        }
        return $quyen;
    }

    //Trang HOME
    //Contentheader
    function contentheader($duongdan)
    {
        $key = "123";
        if ($duongdan == "main") {
            $lv1 = "Thông tin";
            $lv2 = "Thống kê";
            $id = 1;
        } else {
            $level2 = DB::table('24_menu')
                ->where('link', $duongdan)
                ->first();
            $level1 = DB::table('24_menu')
                ->where('IDMN', $level2->parent_id)
                ->first();
            $lv1  = $level1->name;
            $lv2  = $level2->name;
            $id = $level2->IDMN;
        }
        $res = array(
            'level1' =>  $lv1,
            'level2' =>  $lv2,
            'id_manhinh' => base64_encode($key . "_" . $id),
        );
        return $res;
    }
    //Id màn hình
    function lay_id_manhinh($duongdan, $id_chucnang)
    {
        $quyen = Auth::guard('loginadmin')->user()->admin;
        if ($quyen == 1) {
            $id = DB::table('24_menu')
                ->where('link', $duongdan)
                ->first();
            $duongdan == "main" ?   $id = 1 :  $id =  $id->IDMN;
            $id_admin = Auth::guard('loginadmin')->user()->id;
            $time = DB::table('24_phanquyen')
                ->select('id_chucnang', 'time')
                ->where(
                    [
                        'id_nguoidung' => $id_admin,
                        'id_manhinh' => $id,
                        'id_chucnang' => $id_chucnang,
                    ]
                )->first();
            if ($time) {
                $time_new = $time->time;
                $id_manhinh = $id;
            } else {
                $time_new = 'xxx';
                $id_manhinh = 0;
            }
            // $json_data['data'] = $time;
            // $times = json_encode($json_data);
        } else {
            $time_new = 'xxx';
            $id_manhinh = 0;
        }
        $res = array('time' => $time_new, 'id_manhinh' => $id_manhinh);
        return $res;
    }

    //Menu
    // function datasidebar($menus, $parent_id = 0, $level = 0, &$html)
    // {
    //     foreach ($menus as $key => $menu) {
    //         if ($menu->parent_id === $parent_id) {
    //             $menu->level = $level;
    //             if ($menu->level == 0) {
    //                 $html .= '<li class = "nav-item">';
    //                 if ($menu->link == 'main') {
    //                     $html .= '<a href="' . $menu->link . '" style="background-color: rgba(255, 255, 255, .1);" class="nav-link">';
    //                 } else {
    //                     $html .= '<a style="background-color: rgba(255, 255, 255, .1);" class="nav-link">';
    //                 }

    //                 $html .= '<i class="nav-icon ' . $menu->icon . '" style="font-size: 14px;color:white"></i>';
    //                 $html .=  '<p id = levelpr' . $menu->IDMN . '>' . $menu->name;
    //                 if ($menu->link != 'main') {
    //                     $html .= '<i class="fas fa-angle-left right"></i>';
    //                 }
    //                 $html .= '</p>';
    //                 $html .= '</a>';
    //             } else {
    //                 $html .= "<ul id = level" . $menu->IDMN . " class='nav nav-treeview'>";
    //                 $html .= '<li class="nav-item">';
    //                 $html .= "<a href=" . $menu->link . " class='nav-link'>";
    //                 $html .= '&nbsp;&nbsp&nbsp;<i class="nav-icon ' . $menu->icon . '" style="font-size: 14px;color:white"></i>';
    //                 $html .= '<p>' . $menu->name . '</p>';
    //                 $html .= '</a>';
    //                 $html .= '</li>';
    //             }

    //             unset($menus[$key]);
    //             self::datasidebar($menus, $menu->IDMN, $level + 1, $html);
    //             $html .= '</li>';
    //             $html .= '</ul>';
    //         }
    //     }
    // }

    function exit_children_menu($menus, $id) {
        foreach ($menus as $menu) {
            if ($id == $menu->parent_id) {
                return 1;
            }
        }
        return 0;
    }

    function datasidebar($menus, $parent_id = 0, $level = 0, &$html)
    {
        foreach ($menus as $key => $menu) {
            if ($menu->parent_id === $parent_id) {
                $menu->level = $level;
                if ($menu->level == 0) {
                    $html .=   '<li class="nav-item" style="">';
                    $html .=        '<a class="nav-link lev'.$menu->level.'" style="margin-bottom: 1px;">';
                    $html .=            '<i class="nav-icon ' . $menu->icon . '" style="font-size: 14px;color:white"></i>';
                    $html .=            '<p id="levelpr2" >'.$menu->name.'<i class="fas fa-angle-left right"></i></p>';
                    $html .=        '</a>' ;
                }else{
                    $this->exit_children_menu($menus,$menu->IDMN) == 1 ? $muiten = '<i class="fas fa-angle-left right"></i>' :  $muiten = '';
                    $html .=     '<ul id = level' . $menu->IDMN . ' class="nav nav-treeview">';
                    $html .=        '<li class="nav-item" style="display: block">';
                    $html .=            '<a href=' . $menu->link . '   class="nav-link lev'.$menu->level.'" style="margin-bottom: 1px;">';
                    $html .=                '<i class="nav-icon  ' . $menu->icon . '" style="font-size: 14px;color:white"></i>';
                    $html .=                '<p id="levelpr' . $menu->IDMN . '">'.$menu->name.' '. $muiten.'</p>';
                    $html .=            '</a>';
                }
                unset($menus[$key]);
                self::datasidebar($menus, $menu->IDMN, $level + 1, $html);
                $html .=                    '</li>';
                $html .=                '</ul>';
            }
        }
    }
    public function sidebar()
    {
        $admin = Auth::guard('loginadmin')->user()->admin;
        $id_nguoidung = Auth::guard('loginadmin')->user()->id;
        switch ($admin) {
            case '2':
                // $menus = DB::select('SELECT * FROM 24_menu INNER JOIN 24_phanquyen ON 24_phanquyen.id_manhinh = 24_menu.IDMN  ORDER BY stt asc');
                $menus = DB::table('24_menu')
                    ->orderBy('24_menu.stt')
                    ->get();
                break;
            case '1':
                $menus = DB::table('24_menu')
                    ->join('24_phanquyen', '24_menu.IDMN', '24_phanquyen.id_manhinh')
                    ->where('24_phanquyen.id_nguoidung', $id_nguoidung)
                    ->where('id_chucnang', 1)
                    ->orderBy('24_menu.stt')
                    ->get();
                break;
            default:
                $menus = [];
                break;
        }
        # root
        $this->datasidebar($menus, 0, 0, $result);
        return $result;
    }
    public function index()
    {
        $url = URL::current();
        $quyen = $this->kiemtraquyen_url($url);
        if ($quyen == 1) {
            return view(
                'user_24.admin24.include.index',
                [
                    // 'slthisinh'         => $this->slthisinh(),
                    // 'slnguyenvong'      => $this->slnguyenvong(),
                    // 'slkhoanguyenvong'  => $this->slkhoanguyenvong(),
                    // 'slthisinhlephi'    => $this->slthisinhlephi(),
                    // 'tongtien'          => $this->tongtien(),
                    // 'nv1'               => $this->nguyenvong(1),
                    // 'nv2'               => $this->nguyenvong(2),
                    // 'nv3'               => $this->nguyenvong(3),
                    // // 'bieudonguyenvong'  => $bieudonguyenvong,
                    // 'sldangnhap'        => $this->sldangnhap(),
                    // // 'sldangnhap'        => $this->sldangnhap(),
                    // 'taikhoandangnhap'  => $this->taikhoandangnhap(),
                    // 'tiledangnhaplai'   => $this->rpr(),
                    // 'tongclick' => $this->tongclick(),
                    // 'taikhoan' => $this->taikhoan(),
                    // 'chitieu' =>    $this->chitieu(),
                    // 'menu' =>    $this->menu(),
                    'menu' =>    $this->sidebar(),
                    // 'uri' => $url[0],
                ]
            );
        } else {
            return view('user_24.admin24.include.404');
        }
    }

    //Biểu đồ trang HOME
    public function bieudo()
    {
        // $sqlnv = "SELECT tenchuyennganh,if(nv1.slnv1 is null,0,nv1.slnv1) as slnv1,if(nv2.slnv2 is null,0,nv2.slnv2) as slnv2,if(nv3.slnv3 is null,0,nv3.slnv3) as slnv3 FROM `24_chuyennganh` LEFT JOIN (SELECT 24_nguyenvong.id_chuyennganh,COUNT(24_nguyenvong.id_chuyennganh) as slnv1 FROM 24_nguyenvong WHERE thutu=1 GROUP BY 24_nguyenvong.id_chuyennganh) as nv1 ON 24_chuyennganh.id=nv1.id_chuyennganh LEFT JOIN (SELECT 24_nguyenvong.id_chuyennganh,COUNT(24_nguyenvong.id_chuyennganh) as slnv2 FROM 24_nguyenvong WHERE thutu=2 GROUP BY 24_nguyenvong.id_chuyennganh) as nv2 ON 24_chuyennganh.id=nv2.id_chuyennganh LEFT JOIN (SELECT 24_nguyenvong.id_chuyennganh,COUNT(24_nguyenvong.id_chuyennganh) as slnv3 FROM 24_nguyenvong WHERE thutu=3 GROUP BY 24_nguyenvong.id_chuyennganh) as nv3 ON 24_chuyennganh.id=nv3.id_chuyennganh";
        // $nguyevong = DB::select($sqlnv);
        $sqlnv = "SELECT
                cn.tenchuyennganh,
                IFNULL(nv1.slnv1, 0) AS slnv1,
                IFNULL(nv2.slnv2, 0) AS slnv2,
                IFNULL(nv3.slnv3, 0) AS slnv3,
                IFNULL(nv4.slnv4, 0) AS slnv4,
                IFNULL(nv5.slnv5, 0) AS slnv5,
                IFNULL(nv6.slnv6, 0) AS slnv6
            FROM
                24_chuyennganh cn
            LEFT JOIN
                (SELECT id_chuyennganh, COUNT(id_chuyennganh) AS slnv1
                FROM 24_nguyenvong
                WHERE thutu = 1
                GROUP BY id_chuyennganh) AS nv1
            ON cn.id = nv1.id_chuyennganh
            LEFT JOIN
                (SELECT id_chuyennganh, COUNT(id_chuyennganh) AS slnv2
                FROM 24_nguyenvong
                WHERE thutu = 2
                GROUP BY id_chuyennganh) AS nv2
            ON cn.id = nv2.id_chuyennganh
            LEFT JOIN
                (SELECT id_chuyennganh, COUNT(id_chuyennganh) AS slnv3
                FROM 24_nguyenvong
                WHERE thutu = 3
                GROUP BY id_chuyennganh) AS nv3
            ON cn.id = nv3.id_chuyennganh
            LEFT JOIN
                (SELECT id_chuyennganh, COUNT(id_chuyennganh) AS slnv4
                FROM 24_nguyenvong
                WHERE thutu = 1
                AND id_taikhoan IN
                    (SELECT id_taikhoan FROM 24_khoadangky WHERE trangthai = 1 OR trangthai = 3)
                GROUP BY id_chuyennganh) AS nv4
            ON cn.id = nv4.id_chuyennganh
            LEFT JOIN
                (SELECT id_chuyennganh, COUNT(id_chuyennganh) AS slnv5
                FROM 24_nguyenvong
                WHERE thutu = 2
                AND id_taikhoan IN
                    (SELECT id_taikhoan FROM 24_khoadangky WHERE trangthai = 1 OR trangthai = 3)
                GROUP BY id_chuyennganh) AS nv5
            ON cn.id = nv5.id_chuyennganh
            LEFT JOIN
                (SELECT id_chuyennganh, COUNT(id_chuyennganh) AS slnv6
                FROM 24_nguyenvong
                WHERE thutu = 3
                AND id_taikhoan IN
                    (SELECT id_taikhoan FROM 24_khoadangky WHERE trangthai = 1 OR trangthai = 3)
                GROUP BY id_chuyennganh) AS nv6
            ON cn.id = nv6.id_chuyennganh;";
        $nguyevong = DB::select($sqlnv);




        $chitieu = DB::table('24_nganhchitieu')
            ->join('l_major', 'l_major.id', '24_nganhchitieu.id_nganh')
            ->select('name_major as tennganh', 'chitieu')
            ->get();

        // $sqlnv_dangky = "SELECT tenchuyennganh,if(nv1.slnv1 is null,0,nv1.slnv1) as slnv1,if(nv2.slnv2 is null,0,nv2.slnv2) as slnv2,if(nv3.slnv3 is null,0,nv3.slnv3) as slnv3 FROM `24_chuyennganh`
        // LEFT JOIN (SELECT 24_nguyenvong.id_chuyennganh,COUNT(24_nguyenvong.id_chuyennganh) as slnv1 FROM 24_nguyenvong WHERE thutu = 1 AND id_taikhoan IN (SELECT id_taikhoan FROM 24_khoadangky WHERE trangthai = 1 OR trangthai = 3) GROUP BY 24_nguyenvong.id_chuyennganh) as nv1 ON 24_chuyennganh.id = nv1.id_chuyennganh
        // LEFT JOIN (SELECT 24_nguyenvong.id_chuyennganh, COUNT(24_nguyenvong.id_chuyennganh) as slnv2 FROM 24_nguyenvong WHERE thutu = 2 AND id_taikhoan IN (SELECT id_taikhoan FROM 24_khoadangky WHERE trangthai = 1 OR trangthai = 3) GROUP BY 24_nguyenvong.id_chuyennganh) as nv2 ON 24_chuyennganh.id = nv2.id_chuyennganh
        // LEFT JOIN (SELECT 24_nguyenvong.id_chuyennganh, COUNT(24_nguyenvong.id_chuyennganh) as slnv3 FROM 24_nguyenvong WHERE thutu = 3 AND id_taikhoan IN (SELECT id_taikhoan FROM 24_khoadangky WHERE trangthai = 1 OR trangthai = 3) GROUP BY 24_nguyenvong.id_chuyennganh) as nv3 ON 24_chuyennganh.id = nv3.id_chuyennganh";
        // $nguyevong_dangky = DB::select($sqlnv_dangky);


        $res = array(
            'nguyenvong'            => $nguyevong,
            'chitieu'               =>  $chitieu,
            // 'nguyevong_dangky'      =>  $nguyevong_dangky,
        );
        return $res;
    }
    //Load chuyên ngành
    public function loadchuyennganh()
    {
        // $id_admin = Auth::guard('loginadmin')->user()->admin;
        $id_admin = Auth::guard('loginadmin')->user()->id;
        $quyenvuotcap = Auth::guard('loginadmin')->user()->vuotquyen;
        if($quyenvuotcap == 1){
            $major = DB::select("SELECT id as id, tenchuyennganh as text, '' as selected FROM 24_chuyennganh");
        }else{
            $major = DB::select("SELECT id as id, tenchuyennganh as text, '' as selected FROM 24_chuyennganh WHERE id IN (SELECT id_chuyennganh FROM 24_covanhoctap WHERE id_taikhoan_dangnhap = ?)",[$id_admin]);
        }
        if($major){
           $major0 = new Collection([
               'id' => 0,
               'text' => 'Chọn ngành',
               'selected' =>'selected'
           ]);
        }else{
           $major0 = new Collection([
               'id' => 0,
               'text' => 'Chọn ngành',
               'selected' =>''
           ]);
        }
        $major[] = $major0;
        return $major;
    }
    //Quản lý thí sinh
    public function quanlyhoso()
    {
        return view('user_24.admin_24.quanlyhoso');
    }

    //Quản lý mail
    //nội dung mail
    function list_mail()
    {
        $sql = DB::select("SELECT *, ROW_NUMBER() OVER (ORDER BY ten_mail) AS STT FROM 24_noidungmail");
        $json_data['data'] = $sql;
        $res = json_encode($json_data);
        return  $res;
    }
    function quanlymail()
    {
        $url = URL::current();
        $quyen = $this->kiemtraquyen_url($url);
        if ($quyen == 1) {
            return view(
                'user_24.admin24.manage.quanlymail.quanlymail',
                [
                    'menu' =>    $this->sidebar(),
                    // 'table_data' => $this->tt_mail_sinhvien(),
                ]
            );
        } else {
            return view('user_24.admin24.include.404');
        }
    }
    function copy_mail($id, Request $request)
    {
        $time = $request->input('time');
        $id_manhinh = $request->input('id_manhinh');
        $id_chucnang = $request->input('id_chucnang');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            $sql = DB::table('24_noidungmail')->select()->where('id', $id)->first();
            $ten_copy = $sql->ten_mail . "_copy";
            DB::table('24_noidungmail')->insert([
                "noidung" => $sql->noidung,
                "tieude" => $sql->tieude,
                "ten_mail" => $ten_copy,
            ]);
            return  1;
        } else {
            return "rol_2";
        }
    }
    function load_mail($id)
    {
        $sql = DB::table('24_noidungmail')->select()->where('id', $id)->first();
        return  $sql;
    }
    function remove_mail(Request $request, $id)
    {
        $time = $request->input('time');
        $id_manhinh = $request->input('id_manhinh');
        $id_chucnang = $request->input('id_chucnang');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            try {
                DB::table('24_noidungmail')->where('id', $id)->delete();
                return "del_1";
            } catch (Exception $e) {
                return "del_0";
            }
        } else {
            return "rol_2";
        }
    }

    //Thêm mail
    function add_mail(Request $request)
    {
        $time = $request->input('time');
        $id_manhinh = $request->input('id_manhinh');
        $id_chucnang = $request->input('id_chucnang');
        $active = $request->input('active');
        $noidung_mail = $request->input('noidung_mail');
        $tieude_mail = $request->input('tieude_mail');
        $ten_mail = $request->input('ten_mail');
        $kieudulieu = 'text';
        $trangthai = 0;
        $id_admin = Auth::guard('loginadmin')->user()->id;
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            $validator = Validator::make(
                $request->all(),
                [
                    'noidung_mail'     => 'required',
                    'tieude_mail'      => 'required',
                    'ten_mail'      => 'required',
                ],
                [
                    'noidung_mail.required'      => 'Vui lòng điền nội dung email',
                    'tieude_mail.required'       => 'Vui lòng đặt tiêu đề cho email',
                    'ten_mail.required'       => 'Vui lòng đặt tên cho email',
                ]
            );
            if ($validator->fails()) {
                $noidung = response()->json($validator->errors());
                $kieudulieu = 'json';
            } else {
                try {
                    DB::table('24_noidungmail')->insert([
                        "noidung" => $noidung_mail,
                        "tieude" => $tieude_mail,
                        "ten_mail" => $ten_mail,
                    ]);
                    $noidung = "ins_1";
                    $trangthai = 1;
                } catch (Exception $e) {
                    $noidung = "ins_0";
                }
            }
        } else {
            $noidung = "rol_2";
        }
        return array(
            'noidung' => $noidung,
            'trangthai' => $trangthai,
            'kieudulieu' => $kieudulieu,
        );
    }

    //Update mail
    function update_mail(Request $request)
    {
        $time = $request->input('time');
        $id_manhinh = $request->input('id_manhinh');
        $id_chucnang = $request->input('id_chucnang');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        $noidung_mail = $request->input('noidung_mail');
        $tieude_mail = $request->input('tieude_mail');
        $ten_mail = $request->input('ten_mail');
        $id_mail = $request->input('id_mail');
        $kieudulieu = 'text';
        $trangthai = 0;
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            $validator = Validator::make(
                $request->all(),
                [
                    'noidung_mail'     => 'required',
                    'tieude_mail'      => 'required',
                    'ten_mail'      => 'required',
                ],
                [
                    'noidung_mail.required'      => 'Vui lòng điền nội dung email',
                    'tieude_mail.required'       => 'Vui lòng đặt tiêu đề cho email',
                    'ten_mail.required'       => 'Vui lòng đặt tên cho email',
                ]
            );
            if ($validator->fails()) {
                $noidung = response()->json($validator->errors());
                $kieudulieu = 'json';
            } else {
                try {
                    $sql = DB::table('24_noidungmail')
                        ->where('id', $id_mail)
                        ->update([
                            "noidung" => $noidung_mail,
                            "tieude" => $tieude_mail,
                            "ten_mail" => $ten_mail,
                        ]);
                    if ($sql == 1) {
                        $noidung = "upd_1";
                        $trangthai = 1;
                    } else {
                        $noidung = "upd_2";
                        $trangthai = 0;
                    }
                } catch (Exception $e) {
                    $noidung = "upd_0";
                }
            }
        } else {
            $noidung = "rol_2";
        }
        $res = array(
            'trangthai' => $trangthai,
            'noidung' => $noidung,
            'kieudulieu' => $kieudulieu,
        );
        return $res;
    }

    function gui_thu(Request $request)
    {
        $noidung_mail = $request->input('noidung_mail');
        $tieude_mail = $request->input('tieude_mail');
        $ten_mail = $request->input('ten_mail');
        $mail_thu = $request->input('mail_thu');
        try {
            $maiable = new Guithu($noidung_mail, $tieude_mail);
            Mail::to($mail_thu)->send($maiable);
            return 1;
        } catch (Exception $e) {
            return 0;
        }
    }

    function modal_mail(Request $request)
    {
        $time = $request->input('time');
        $id_manhinh = $request->input('id_manhinh');
        $id_chucnang = $request->input('id_chucnang');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            return 1;
        } else {
            return "rol_2";
        }
    }


    // index
    public function mailduthao()
    {
        $url = URL::current();
        $quyen = $this->kiemtraquyen_url($url);
        if ($quyen == 1) {
            $mail = DB::table('24_noidungmail')
                ->select('id', 'ten_mail')
                ->get();
            return view(
                'user_24.admin24.manage.quanlymail.mailduthao',
                [
                    'menu' =>    $this->sidebar(),
                    // 'table_data' => $this->tt_mail_sinhvien(),
                    'mail' => $mail,
                ]
            );
        } else {
            return view('user_24.admin24.include.404');
        }
    }
    function tt_mail_sinhvien($dottuyensinh, $dotmail, $dangky, $lephi)
    {
        $where = ' WHERE 24_nguyenvong.iddot = ' . (int)$dottuyensinh;
        if ($dotmail == 0) {
            $where .= ' AND dotmail.id_dotgui = ' . (int)$dotmail;
        }
        switch ($dangky) {
            case '1':
                $where .= " AND 24_nguyenvong.id_taikhoan IN (SELECT id_taikhoan FROM 24_khoadangky)";
                break;
            case '0':
                $where .= " AND 24_nguyenvong.id_taikhoan NOT IN (SELECT id_taikhoan FROM 24_khoadangky)";
                break;
            case '2':
                $where .= " AND 24_nguyenvong.id_taikhoan is not null";
                break;
            default:
                $where .= " AND 24_nguyenvong.id_taikhoan is  null";
                break;
        }

        switch ($lephi) {
            case '1':
                $where .= " AND 24_nguyenvong.id_taikhoan IN (SELECT id_taikhoan FROM 24_ketquathanhtoan)";
                break;
            case '0':
                $where .= " AND 24_nguyenvong.id_taikhoan NOT IN (SELECT id_taikhoan FROM 24_ketquathanhtoan)";
                break;
            case '2':
                $where .= " AND 24_nguyenvong.id_taikhoan is not null";
                break;
            default:
                $where .= " AND 24_nguyenvong.id_taikhoan is null";
                break;
        }

        $sql = 'SELECT DISTINCT(24_nguyenvong.id_taikhoan) as id,hoten,account24s.email as email,cccd,if(24_guimailtam.id_taikhoan is null,0,1) as trangthai,if(dotmail.id_taikhoan is null,0,1) as tinhtrangguimail FROM 24_nguyenvong INNER JOIN 24_thongtincanhan ON 24_thongtincanhan.id_taikhoan = 24_nguyenvong.id_taikhoan INNER JOIN account24s ON account24s.id = 24_nguyenvong.id_taikhoan LEFT JOIN 24_guimailtam ON 24_guimailtam.id_taikhoan = 24_nguyenvong.id_taikhoan LEFT JOIN (SELECT * FROM 24_guimail WHERE 24_guimail.id_dotgui = ' . (int)$dotmail . ') AS dotmail ON dotmail.id_taikhoan = 24_nguyenvong.id_taikhoan' . $where;
        $data = DB::select($sql);
        // $nguyenvong =  $request->input('nguyenvong');
        // $data = DB::select("SELECT DISTINCT 24_thongtincanhan.hoten, account24s.id, IF (24_nguyenvong.iddot IS NULL, 0, 24_nguyenvong.iddot) AS dot, account24s.email,IF (24_thongtincanhan.id_taikhoan IS NULL, 0, 24_thongtincanhan.id_taikhoan) AS thongtincanhan,IF(24_nguyenvong.id_taikhoan IS NULL, 0, 24_nguyenvong.id_taikhoan) AS nguyenvong, IF (kqtt.id_taikhoan IS NULL, 0, kqtt.id_taikhoan) AS kqthanhtoan,IF (24_khoadangky.id_taikhoan IS NULL, 0, 24_khoadangky.id_taikhoan) AS khoadangky FROM account24s LEFT JOIN 24_thongtincanhan ON account24s.id = 24_thongtincanhan.id_taikhoan LEFT JOIN 24_nguyenvong ON account24s.id = 24_nguyenvong.id_taikhoan LEFT JOIN (SELECT 24_ketquathanhtoan.id_taikhoan, id_order FROM 24_ketquathanhtoan INNER JOIN 24_dataresponse ON 24_ketquathanhtoan.id_order = 24_dataresponse.order_id) AS kqtt ON account24s.id = kqtt.id_taikhoan
        // LEFT JOIN 24_khoadangky ON account24s.id = 24_khoadangky.id_taikhoan");
        $json_data['data'] = $data;
        $res = json_encode($json_data);
        return $res;
    }

    function themds_guimail(Request $request)
    {
        //Kiểm tra quyền
        $id_chucnang = $request->input('id_chucnang');
        $id_manhinh = $request->input('id_manhinh');
        $time = $request->input('time');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            $json_data = $request->input('arr_json_data');
            $tt_noidungrong = -1;
            $noidung =  '';
            $trangthai1 = "";
            $tt_dstaikhoanrong = -2;
            $ds_taikhoan = count($json_data);
            $arr_mail = [];
            $arr_mail_exits = [];
            if ($json_data[0]['active'] == $tt_noidungrong) {
                // && $json_data[1]['data'][0]['id_mail'] == "" điều kiện để thêm vào trên nhưng còn lỗi
                $trangthai = -1;
            } else if ($json_data[0]['active'] == $tt_dstaikhoanrong && $ds_taikhoan <= 1) {
                $trangthai = -2;
            } else {
                $id_taikhoan_mail = DB::table('24_guimailtam')->pluck('id_taikhoan')->toArray();
                foreach ($json_data[1]['data'] as $data) {
                    if (!in_array($data['id_taikhoan'], $id_taikhoan_mail)) {
                        $arr_mail[] = [
                            'id_taikhoan' => $data['id_taikhoan'],
                            'id_noidung' => $data['id_mail'],
                            'id_admin' => $id_admin,
                            'email' => $data['email'],
                            'id_dotgui' => $data['id_dotgui']
                        ];

                        $thongtin = DB::table('24_thongtincanhan')->select('hoten')->where('id_taikhoan', $data['id_taikhoan'])->first();
                        $mail = $this->dinhdangmail($data['id_mail'], $thongtin);
                        $maiable = new Mail_Chuan_24($mail['noidung_mail'], $mail['tieude_mail']);
                        Mail::to(strval($data['email']))->queue($maiable);
                    } else {
                        $arr_mail_exits[] = $data['email'];
                    }
                }
                if (count($arr_mail_exits) > 0) {
                    $noidung =  implode(',', $arr_mail_exits);
                    $trangthai1 = 'tontai_mail';
                }
                DB::table('24_guimailtam')->insert($arr_mail);
                $trangthai = 1;
            }
        } else {
            $trangthai = "rol_2";
        }
        return array(
            'trangthai' => $trangthai,
            'trangthai1' => $trangthai1,
            'noidung' => $noidung
        );
    }

    function mail_xoadanhsach(Request $request)
    {
        $id_taikhoan = $request->input('id_taikhoan');
        $id_chucnang = $request->input('id_chucnang');
        $id_manhinh = $request->input('id_manhinh');
        $time = $request->input('time');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            try {
                $check = DB::table('24_guimailtam')->where('id_taikhoan', $id_taikhoan)->first();
                if ($check) {
                    DB::table('24_guimailtam')->where('id_taikhoan', $id_taikhoan)->delete();
                    $trangthai = 'upd_1';
                } else {
                    $trangthai = '-1';
                }
            } catch (Exception $e) {
                return '-100';
            }
        } else {
            $trangthai = 'rol_2';
        }
        return $trangthai;
    }

    function xemtientrinh()
    {
        $mail = DB::table('24_guimailtam')
            ->get();
        $json_data['data'] = $mail;
        $res = json_encode($json_data);
        return $res;
    }
    public function kiemtra_guimail()
    {
        $check = DB::table('24_kiemtraguimail')->first();
        if ($check) {
            $trangthai = 1;
        } else {
            $trangthai = 0;
        }
        return $trangthai;
    }

    function tim_maumail($id)
    {
        $mail = DB::table('24_noidungmail')
            ->where('id', $id)
            ->first();
        return $mail;
    }


    // Load tiến trình gửi mail
    public function sse(Request $request)
    {
        // Artisan::call('queue:work --once');

        $response = new StreamedResponse(function () {
            $first = DB::table('jobs')->orderBy('id', 'asc')->get();
            count($first) > 0 ? $trangthai  = 1 : $trangthai = 0;
            if ($trangthai > 0) {
                $payload = $first[0]->payload;
                $user =  json_decode($payload, true)['data']['command'];
                $email = strval(unserialize($user)->mailable->to[0]['address']);
                Artisan::call('queue:work --once');
                echo "data:1xxx" . $email . "\n\n";
                ob_flush();
                flush();
                DB::table('24_guimailtam')->where('email', $email)->update(['status' => 1]);
                //Lưu lịch sử
                $id_taikhoan = DB::table('24_accountsadmin')
                    ->select('id')
                    ->where('email', $email)
                    ->first();

                $tieude = DB::table('24_guimailtam')
                    ->join('24_noidungmail', '24_noidungmail.id', '24_guimailtam.id_noidung')
                    ->select('tieude')
                    ->where('24_guimailtam.email', $email)
                    ->first();

                $id_admin = Auth::guard('loginadmin')->user()->id;
                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                DB::table('24_lichsu')
                    ->insert(
                        [
                            'id_taikhoan' => $id_taikhoan->id,
                            'noidung'   => "Gửi mail: " . $tieude->tieude,
                            'hienthi'   => 1,
                            'id_nhansu' => $id_admin,
                            'thietbi'   => $user_agent,
                            'ip'        => request()->ip()
                        ]
                    );
                sleep(1); // Thời gian chờ giữa các lần gửi sự kiện
            } else {
                echo "data: 0xxxĐã xử lý xong...\n\n";
                ob_flush();
                flush();
            }
        });
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');
        return $response;
        // return 1111111111;
    }

    public function guimail2(Request $request)
    {
        $id_chucnang = $request->input('id_chucnang');
        $id_manhinh = $request->input('id_manhinh');
        $time = $request->input('time');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            $trangthai = DB::table('24_kiemtraguimail')->insert(['trangthai' => 1]);
        } else {
            $trangthai = "rol_2";
        }
        return $trangthai;
    }

    public function xulysauguimail()
    {
        DB::table('24_kiemtraguimail')->delete();
        // Thêm từ bảng tạm vào bảng chính
        $table_guimailtam = DB::table('24_guimailtam')
            ->select('id_taikhoan', 'id_noidung', 'id_admin', 'email', 'status', 'create_at', 'id_dotgui')
            ->get();
        $table_guimailtam_array = [];
        foreach ($table_guimailtam as $row) {
            $table_guimailtam_array[] = [
                'id_taikhoan' => $row->id_taikhoan,
                'id_noidung' => $row->id_noidung,
                'id_admin' => $row->id_admin,
                'email' => $row->email,
                'status' => $row->status,
                'create_at' => $row->create_at,
                'id_dotgui' => $row->id_dotgui,

            ];
        }
        DB::table('24_guimail')->insert($table_guimailtam_array);
        //  return 1;
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $title = 'DanhSachGuiMail' . date("d-m-Y H:i:s") . '.xlsx';
        // //Xuất Excel
        return Excel::download(new Admin24_ExportDanhSachGuiMail(), $title);
    }

    // public function test()
    // {
    //     $id = 66;
    //     $noidung = DB::table('24_noidungmail')->where('id', 33)->first()->noidung;
    //     preg_match_all('/\$\$\$(.*?)\$\$\$/', $noidung, $matches);

    //     $pattern = '/(\$\$\$.*?\$\$\$)/';
    //     $parts = preg_split($pattern, $noidung, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
    //     $thongtin = DB::table('24_thongtincanhan')->where('id_taikhoan', $id)->first();
    //     foreach ($parts as $key => $part) {
    //         foreach ($matches[1] as $key => $match) {
    //             if ($part == '$$$' . $match . '$$$') {
    //                 $array = str_replace($part, $thongtin->$match, $parts);
    //                 $parts = $array;
    //             }
    //         }
    //     }
    //     $string = implode("", $parts);
    //     dd($string);
    //     // $maiable = new MailDuyet(1);
    //     // Mail::to(strval('bdson2100610@student.ctuet.edu.vn'))->send($maiable);

    //     // $maiable = new Guithu($noidung_mail,$tieude_mail);
    //     // Mail::to($mail_thu)->send($maiable);
    // }



    // QUẢN LÝ TÀI KHOẢN
    //Load index màn hình quản lý tài khoản
    public function quanlytaikhoan()
    {
        $url = URL::current();
        $quyen = $this->kiemtraquyen_url($url);
        if ($quyen == 1) {
            return view('user_24.admin24.manage.quanlynguoidung.taikhoan', [
                'menu' =>    $this->sidebar(),
            ]);
        } else {
            return view('user_24.admin24.include.404');
        }
    }

    //Load danh sách tài khoản
    function danhsachtaikhoan($id_manhinh)
    {
        $id_nguoidung = Auth::guard('loginadmin')->user()->id;
        $root = (int)Auth::guard('loginadmin')->user()->admin;
        if ($root == 2) {
            $sql_accounts = "SELECT `email`,`name`,`id`,`admin`,`status`, ROW_NUMBER() OVER (ORDER BY 24_accountsadmin.id) AS `so_thu_tu` FROM `24_accountsadmin` WHERE `admin` > 0";
        } else {
            $sql_accounts = "SELECT `email`,`name`,`id`,`admin`,`status`, ROW_NUMBER() OVER (ORDER BY 24_accountsadmin.id) AS `so_thu_tu` FROM `24_accountsadmin`  WHERE `24_accountsadmin`.`id` != " . $id_nguoidung . " AND `admin` = 1";
        }
        $accounts = DB::select($sql_accounts);

        $phanquyens = DB::table('24_phanquyen')
            ->whereIn('id_chucnang', [2, 4, 5])
            ->where('id_manhinh', $id_manhinh)
            ->orderBy('id_chucnang', 'asc')
            ->get(); //Sửa, Xóa, Phân quyền
        foreach ($accounts as $account) {
            $check_sua = 0;
            $check_xoa = 0;
            $check_phanquyen = 0;
            foreach ($phanquyens as $phanquyen) {
                if ($phanquyen->id_nguoidung == $id_nguoidung) {
                    switch ($phanquyen->id_chucnang) {
                        case '2':
                            $check_sua++;
                            break;
                        case '4':
                            $check_xoa++;
                            break;
                        case '5':
                            $check_phanquyen++;
                            break;
                        default:

                            break;
                    }
                }
            }
            switch ($root) {
                case '2':
                    $active_sua = 1;
                    $active_phanquyen = 1;
                    $active_xoa = 1;
                    break;
                case '1':
                    $check_sua == 0 ? $active_sua = 0 : $active_sua = 1;
                    $check_phanquyen == 0 ? $active_phanquyen = 0 : $active_phanquyen = 1;
                    $check_xoa == 0 ? $active_xoa = 0 : $active_xoa = 1;
                    break;
                default:
                    $active_sua = 0;
                    $active_phanquyen = 0;
                    $active_xoa = 0;
                    break;
            }
            $account->sua = array(
                'active' => $active_sua,
                'id_chucnang' => 2, // ID Chức năng
                'id_nguoidung' => $account->id, //ID của người dùng
                'id_manhinh' =>  (int)$id_manhinh, //ID của người dùng
            );
            $account->phanquyen = array(
                'active' => $active_phanquyen,
                'id_chucnang' => 5, // ID Chức năng
                'id_nguoidung' => $account->id, //ID của người dùng
                'id_manhinh' =>  (int)$id_manhinh, //ID của người dùng
            );
            $account->xoa = array(
                'active' => $active_xoa,
                'id_chucnang' => 4, // ID Chức năng
                'id_nguoidung' => $account->id, //ID của người dùng
                'id_manhinh' =>  (int)$id_manhinh, //ID của người dùng
            );
        }
        $json_data['data'] = $accounts;
        $data = json_encode($json_data);
        return  $data;
    }

    //Edit Tài khoan
    function edit_accounts(Request $r)
    {
        $id_nguoidung = $r->input('id_nguoidung');
        $id_manhinh = $r->input('id_manhinh');
        $id_chucnang = $r->input('id_chucnang');
        $time = $r->input('time');
        $id_admin = (int)Auth::guard('loginadmin')->user()->id;
        $active = $r->input('active');
        $quyen = $this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active);
        if ($quyen == 1) {
            //Lay thong tin usser
            $nguoidung = DB::table('24_accountsadmin')->where('id', $id_nguoidung)->get();
            $active = 1;
        } else {
            $nguoidung = "";
            $active = 0;
        }
        return array('active' => $active, 'result' => $nguoidung);
    }

    //Update Tài khoản
    function update_accounts(Request $r)
    {
        $id_nguoidung = $r->input('id_nguoidung');
        $id_manhinh = $r->input('id_manhinh');
        $id_chucnang = $r->input('id_chucnang');
        $active = $r->input('active');
        $time = $r->input('time');
        $id_admin = (int)Auth::guard('loginadmin')->user()->id;
        $quyen = $this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active); //Kiểm tra quyền trên màn hình
        if ($quyen == 1) {
            $update_accounts_name = $r->input('update_accounts_name');
            $update_accounts_email = $r->input('update_accounts_email');
            $dem = 0;
            $checkmails = DB::table('24_accountsadmin')->where('id', '<>', $id_nguoidung)->get();
            foreach ($checkmails as $key => $row) {
                if ($row->email == $update_accounts_email) {
                    $dem++;
                }
            }
            if ($dem > 0) {
                $trangthai = "upd_3";
                $type_res = "thongbao";
            } else {
                $validator = Validator::make(
                    $r->all(),
                    [
                        'update_accounts_email'     => 'required|email',
                        'update_accounts_name' => ['required', 'regex:/^[\pL\s0-9]+$/u'],
                    ],
                    [
                        'update_accounts_email.required'      => 'Vui lòng điền email',
                        'update_accounts_email.email'         => 'Email chưa đúng định dạng',
                        'update_accounts_name.required'       => 'Vui lòng điền tên',
                        'update_accounts_name.regex'     => 'Tên chỉ gồm chữ cái và chữ số',
                    ]
                );
                if ($validator->fails()) {
                    $trangthai = response()->json($validator->errors());
                    $type_res = "validate";
                } else {
                    $update_accounts = DB::table('24_accountsadmin')->where('id', $id_nguoidung)
                        ->update([
                            'name' => $update_accounts_name,
                            'email' => $update_accounts_email,
                        ]);
                    if ($update_accounts == 1) {
                        $trangthai = "upd_1";
                        $type_res = "thongbao";
                    } else {
                        $trangthai = "upd_2";
                        $type_res = "thongbao";
                    }
                }
            }
        } else {
            $trangthai = "rol_2";
            $type_res = "thongbao";
        }
        return array(
            'thongbao' => $trangthai,
            'loaithongbao' => $type_res,
        );
    }

    function loadUser_Menus_Roles(Request $request)
    {
        $id_manhinh = $request->input("id_manhinh");
        $id_chucnang = $request->input("id_chucnang");
        $active = $request->input("active");
        $id_nguoidung = $request->input('id_nguoidung');
        $time = $request->input('time');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        $quyen = $this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active);
        if ($quyen == 1) {
            $sql_all_manhinh = "SELECT * FROM `24_menu`";
            $menus = DB::select($sql_all_manhinh);
            $sql_all_chunang = "SELECT * FROM `24_danhmuc_chucnang`";
            $all_chucnang = DB::select($sql_all_chunang);
            $sql_chucnang_user = "SELECT * FROM `24_phanquyen` WHERE id_nguoidung = $id_nguoidung";
            $chucnang_users = DB::select($sql_chucnang_user);
            if ($chucnang_users) {
                foreach ($menus as $key_manhinh => $manhinh) {
                    foreach ($all_chucnang as $key_chucnang => $chucnang) {
                        $ten_loaichucnang = $chucnang->danhmuc_chucnang_id;
                        $manhinh->$ten_loaichucnang = 0;
                    }
                    foreach ($chucnang_users as $key_user => $chucnang_user) {
                        if ($manhinh->IDMN == $chucnang_user->id_manhinh) {
                            foreach ($all_chucnang as $key_chucnang => $chucnang) {
                                $ten_loaichucnang = $chucnang->danhmuc_chucnang_id;
                                if ($chucnang_user->id_chucnang == $chucnang->id) {
                                    $manhinh->$ten_loaichucnang = $chucnang->id;
                                }
                            }
                        }
                    }
                }
            } else {
                foreach ($menus as $key_manhinh => $manhinh) {
                    foreach ($all_chucnang as $key_chucnang => $chucnang) {
                        $ten_loaichucnang = $chucnang->danhmuc_chucnang_id;
                        $manhinh->$ten_loaichucnang = 0;
                    }
                }
            }
            $this->dataUser_Menus_Roles($menus, 0, 0, "", $result);
            $res = array(
                'body' => $result,
                'head' => $all_chucnang,
                'id_user' => (int)$id_nguoidung,
                'active' => 'rol_1',
            );
        } else {
            $res = array(
                'body' => "",
                'head' => "",
                'id_user' => 0,
                'active' => 'rol_2',
            );
        }
        return $res;
    }
    //data model phân quyền
    function dataUser_Menus_Roles($menus, $parent_id = 0, $level = 0, $char = "", &$result)
    {
        $i = 1;
        foreach ($menus as $key => $menu) {
            if ($menu->parent_id === $parent_id) {
                $menu->name = $char . '&nbsp;&nbsp;<strong>' . $i . '</strong>.&nbsp;' . $menu->name;
                $result[] = $menu;
                unset($menus[$key]);
                $i++;
                self::dataUser_Menus_Roles($menus, $menu->IDMN, 1 + $level, $char . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $result);
            }
        }
    }

    //Kiểm tra quyền màn hình
    function kiemtraquyenmanhinh(Request $request)
    {
        $check = DB::table('24_danhmuc_manhinh_chucnang')
            ->where([
                "id_manhinh" => $request->input('id_manhinh'),
                "id_chucnang" => $request->input('id_chucnang'),
            ])->first();
        if ($check) {
            return 1;
        } else {
            return 0;
        }
    }

    //Cập nhật phân quyền
    function capnhatquyen(Request $request)
    {
        $id_admin = (int)Auth::guard('loginadmin')->user()->id;
        $pq_manhinh = $request->input('pq_manhinh');
        $pq_chucnang = $request->input('pq_chucnang');
        $pq_time = $request->input('time');
        $active = $request->input('active');
        $id_nguoidung = $request->input('id_nguoidung');
        $checkquyen = $this->kiemtraquyen($id_admin, $pq_manhinh, $pq_chucnang, $pq_time, $active);
        if ($checkquyen == 1) {
            $parent_id = $request->input('parent_id');
            DB::select('DELETE FROM `24_phanquyen` WHERE id_nguoidung = ' . (int)$id_nguoidung . ' AND id_manhinh IN (SELECT IDMN FROM 24_menu WHERE parent_id = ' . (int)$parent_id . ' OR IDMN = ' . (int)$parent_id . ')');
            $data = $request->input('data');
            if ($data[0]['id_nguoidung'] != 0) {
                for ($i = 0; $i < count($data); $i++) {
                    $time = $this->rand_string(20);
                    $chuoigoc = $data[$i]['id_nguoidung'] . '_' . $data[$i]['id_manhinh'] . '_' . $data[$i]['id_chucnang'] . '_' . $time;
                    $data[$i]['create_at'] = Hash::make($chuoigoc);
                    $data[$i]['time'] =  $time;
                }
                DB::table('24_phanquyen')
                    ->insert($data);
            }
            $thongbao = 'upd_1';
        } else {
            $thongbao = 'rol_2';
        }
        return array(
            'data' => $data,
            'thongbao' => $thongbao
        );
    }

    function themtaikhoan(Request $request)
    {
        $id_manhinh = $request->input("id_manhinh");
        $id_chucnang = $request->input("id_chucnang");
        $id_nguoidung = Auth::guard('loginadmin')->user()->id;
        $active = $request->input("active");
        $time = $request->input("time");
        $quyen = $this->kiemtraquyen($id_nguoidung, $id_manhinh, $id_chucnang, $time, $active);
        if ($quyen == 1) {
            $validator = Validator::make(
                $request->all(),
                [
                    'email'     => 'required|email|unique:24_accountsadmin',
                    'pass'      => 'required|alpha_dash|min:8',
                    'name' => ['required', 'regex:/^[\pL\s0-9]+$/u'],

                ],
                [
                    'email.email'         => 'Email chưa đúng định dạng',
                    'email.required'      => 'Vui lòng điền email',
                    'email.unique'        => 'Email bị trùng',
                    'pass.required'       => 'Vui lòng điền Mật khẩu',
                    'pass.alpha_dash'     => 'Mật khẩu chỉ gồm chữ cái và chữ số',
                    'pass.min'            => 'Mật khẩu phải từ 8 ký tự trở lên',
                    'name.required'       => 'Vui lòng điền tên',
                    'name.regex'     => 'Tên chỉ gồm chữ cái và chữ số',
                ]
            );
            if ($validator->fails()) {
                $trangthai = response()->json($validator->errors());
                $type_res = 'validate';
            } else {
                try {
                    DB::table('24_accountsadmin')->insert([
                        'name' => $request->input('name'),
                        'email' => $request->input('email'),
                        'admin' => 1,
                        'password' => Hash::make($request->input('pass')),
                    ]);
                    $id_nguoidung = DB::table('24_accountsadmin')
                        ->where(
                            [
                                'email' => $request->input('email'),
                                'admin' => 1
                            ]
                        )->first()->id;
                    $time = $this->rand_string(20);
                    $create_at = Hash::make($id_nguoidung . '_1_1_' . $time);
                    DB::table('24_phanquyen')->insert([
                        'id_nguoidung' =>   $id_nguoidung,
                        'id_manhinh' =>  1,
                        'id_chucnang' =>  1,
                        'create_at' =>  $create_at,
                        'time' =>  $time,
                    ]);
                    $trangthai = 'rol_1';
                    $type_res = 'thongbao';
                } catch (Exception $e) {
                    $trangthai = 'rol_0';
                    $type_res = 'thongbao';
                }
            }
        } else {
            $trangthai = 'rol_2';
            $type_res = 'thongbao';
        }
        return array(
            'thongbao' => $trangthai,
            'loaithongbao' => $type_res,
        );
    }

    //Xóa tài khoản
    function delete_accounts(Request $request)
    {
        $id_nguoidung = $request->input("id_nguoidung"); //Id xóa
        $id_manhinh = $request->input("id_manhinh");
        $id_chucnang = $request->input("id_chucnang");
        $active = $request->input("active");
        $time = $request->input("time");
        $id_admin = Auth::guard('loginadmin')->user()->id;
        $quyen = $this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active);
        if ($quyen == 1) {
            try {
                $check = DB::table('24_accountsadmin')
                    ->where(
                        [
                            'id' => $id_nguoidung,
                            'admin' => 1,
                        ]
                    )
                    ->first();
                if ($check) {
                    $check->status == 1 ? $status = 0 : $status = 1;
                    DB::table('24_accountsadmin')->where(['id' => $id_nguoidung, 'admin' => 1])->update(['status' => $status]);
                    $active = 'upd_1';
                } else {
                    $active = 'upd_0';
                }
            } catch (Exception $e) {
                $active = 'del_0'; //Lỗi hệ thống
            }
        } else {
            $active = 'rol_2'; //Không có quyền
        }
        return $active;
    }



    //Quản lý chức năng
    // View
    public function quanlychucnang()
    {
        return view('user_24.admin24.manage.quanlynguoidung.chucnang', [
            'menu' =>    $this->sidebar(),
        ]);
    }

    // Danh sách chức năng
    function ds_chucnang()
    {
        $sql_chucnang = "SELECT * FROM 24_danhmuc_chucnang";
        $json_data['data'] = DB::select($sql_chucnang);
        $data = json_encode($json_data);
        echo  $data;
    }

    function edit_chucnang($id, Request $r)
    {
        $id_nguoidung = Auth::guard('loginadmin')->user()->id;
        $id_manhinh = $r->input('id_manhinh');
        $id_chucnang = $r->input('id_chucnang');
        $time = $r->input('time');
        $id_admin = (int)Auth::guard('loginadmin')->user()->id;
        $active = $r->input('active');
        $quyen = $this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active);
        if ($quyen == 1) {
            $edit_setting = DB::table('24_danhmuc_chucnang')
                ->select('*')
                ->where('id', $id)
                ->get();
            return $edit_setting;
        } else {
            return 'rol_2';
        }
    }

    function Add_new_settings(Request $request)
    {
        $id_manhinh = $request->input("id_manhinh");
        $id_chucnang = $request->input("id_chucnang");
        $id_nguoidung = Auth::guard('loginadmin')->user()->id;
        $active = $request->input("active");
        $time = $request->input("time");
        $quyen = $this->kiemtraquyen($id_nguoidung, $id_manhinh, $id_chucnang, $time, $active);
        if ($quyen == 1) {
            $validator = Validator::make(
                $request->all(),
                [
                    'settings_name'     => 'required|regex:/^[\pL\s0-9]+$/u|unique:24_danhmuc_chucnang,danhmuc_chucnang_ten',
                    'settings_link'      => 'required|regex:/^[\pL\s0-9]+$/u',
                    'settings_note' => ['required', 'regex:/^[\pL\s0-9]+$/u'],

                ],
                [
                    'settings_name.regex'         => 'Tên chức năng chỉ gồm chữ cái và số',
                    'settings_name.required'      => 'Vui lòng điền tên chức năng',
                    'settings_name.unique'        => 'tên bị trùng',
                    'settings_link.required'       => 'Vui lòng điền link cho chức năng',
                    'settings_link.alpha_dash'     => 'Link chức năng chỉ gồm chữ cái và chữ số',
                    'settings_note.required'       => 'Vui lòng ghi chú thích của chức năng',
                    'settings_note.regex'     => 'Chú thích của chức năng chỉ gồm chữ cái và chữ số',
                ]
            );
            if ($validator->fails()) {
                $trangthai = response()->json($validator->errors());
                $type_res = 'validate';
            } else {
                try {
                    DB::table('24_danhmuc_chucnang')->insert([
                        'danhmuc_chucnang_ten' => $request->input('settings_name'),
                        'danhmuc_chucnang_id' => $request->input('settings_link'),
                        'danhmuc_chucnang_ghichu' => $request->input('settings_note'),
                    ]);
                    $trangthai = 'rol_1';
                    $type_res = 'thongbao';
                } catch (Exception $e) {
                    $trangthai = 'rol_0';
                    $type_res = 'thongbao';
                }
            }
        } else {
            $trangthai = 'rol_2';
            $type_res = 'thongbao';
        }
        return array(
            'thongbao' => $trangthai,
            'loaithongbao' => $type_res,
        );
    }

    function update_chucnang(Request $r)
    {
        $id = $r->input("id");
        $update_tenchucnang = $r->input("update_tenchucnang");
        $update_chucnang_link = $r->input("update_chucnang_link");
        $update_ghichu = $r->input("update_ghichu");
        $id_nguoidung = $r->input('id_nguoidung');
        $id_manhinh = $r->input('id_manhinh');
        $id_chucnang = $r->input('id_chucnang');
        $active = $r->input('active');
        $time = $r->input('time');
        $id_admin = (int)Auth::guard('loginadmin')->user()->id;
        $quyen = $this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active); //Kiểm tra quyền trên màn hình
        if ($quyen == 1) {
            $checks = DB::table('24_danhmuc_chucnang')->where('id', '<>', $id)->get();
            $checker = 0;
            foreach ($checks as $key => $check) {
                if ($check->danhmuc_chucnang_ten == $update_tenchucnang || $check->danhmuc_chucnang_id == $update_chucnang_link) {
                    $checker++;
                }
            }
            if ($checker > 0) {
                $trangthai = "unique";
                $type_res = "unique";
            } else {
                $validator = Validator::make(
                    $r->all(),
                    [
                        'update_tenchucnang' => 'required|regex:/^[\pL\s0-9]+$/u',
                        'update_chucnang_link' => 'required|regex:/^[\pL\s0-9]+$/u',
                        'update_ghichu' => 'regex:/^[\pL\s0-9]+$/u',
                    ],
                    [
                        'update_tenchucnang.required' => 'Vui lòng nhập tên màn hình',
                        'update_tenchucnang.regex' => 'Màn hình chỉ được chứa ký tự chữ, số và khoảng trắng',
                        'update_chucnang_link.required' => 'Vui lòng nhập link',
                        'update_chucnang_link.regex' => 'Link chỉ được chứa ký tự chữ, số và khoảng trắng',
                        'update_ghichu.required' => 'Vui lòng nhập ghi chú',
                        'update_ghichu.regex' => 'Ghi chú chỉ được chứa ký tự chữ, số và khoảng trắng',

                    ]
                );
                if ($validator->fails()) {
                    $trangthai = response()->json($validator->errors());
                    $type_res = "validate";
                } else {
                    try {
                        DB::table('24_danhmuc_chucnang')
                            ->where('id', $id)
                            ->update([
                                'danhmuc_chucnang_ten' => $update_tenchucnang,
                                'danhmuc_chucnang_id' => $update_chucnang_link,
                                'danhmuc_chucnang_ghichu' => $update_ghichu,
                            ]);
                        $trangthai = "upd_1";
                        $type_res = "thongbao";
                    } catch (Exception $e) {
                        $trangthai = "upd_0";
                        $type_res = "thongbao";
                    }
                }
            }
        } else {
            $trangthai = "rol_2";
            $type_res = "thongbao";
        }
        return array(
            'thongbao' => $trangthai,
            'loaithongbao' => $type_res,
        );
    }

    function delete_chucnang(Request $request, $idmn)
    {
        $id_manhinh = $request->input("id_manhinh");
        $id_chucnang = $request->input("id_chucnang");
        $active = $request->input("active");
        $time = $request->input("time");
        $id_admin = Auth::guard('loginadmin')->user()->id;
        // $sql_check = DB::table('24_phanquyen')
        //     ->where('id_chucnang', $idmn)
        //     ->get();
        $quyen = $this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active);
        if ($quyen == 1) {
            // if (count($sql_check) >= 1) {
            //     return 3;
            // } else {
            try {
                DB::table('24_danhmuc_chucnang')->where('id', $idmn)->delete();
                $active = 'del_1'; // Xóa thành công
            } catch (Exception $e) {
                $active = 'del_0'; // Lỗi khi xóa
            }
            // }
        } else {
            $active = 'role_2';
        }
        return $active;
    }


    //Quản lý màn hình
    public function quanlymanhinh()
    {
        $this->kiemtraquyen_url(URL::current());
        return view('user_24.admin24.manage.quanlynguoidung.manhinh', [
            'menu' =>    $this->sidebar(),
        ]);
    }
    function manhinhgoc()
    {
        $list_menus0 = new Collection(
            [
                'id' => 0,
                'text' => "Màn hình gốc",
                'selected' => true
            ]
        );


        $list_menus = DB::table('24_menu')
            ->select('IDMN as id', 'name as text')
            ->orderBy('stt', 'asc')
            ->get();

        $list_menus[] =  $list_menus0;
        echo $list_menus;
    }
    function dataDs_manhinh($menus, $parent_id = 0, $level = 0, $char = "", &$result)
    {
        $i = 1;
        foreach ($menus as $key => $menu) {
            if ($menu->parent_id === $parent_id) {
                $menu->name = $char . '&nbsp;<i style = "color:#007bff" class="fa-solid ' . $menu->icon . '"></i>&nbsp;&nbsp;<strong>' . $i . '</strong>.&nbsp;' . $menu->name;
                $result[] = $menu;
                unset($menus[$key]);
                $i++;
                self::dataDs_manhinh($menus, $menu->IDMN, 1 + $level, $char . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $result);
            }
        }
    }
    function ds_manhinh()
    {
        $sql_ds_manhinh = "SELECT * FROM 24_menu ORDER BY stt";
        $ds_manhinh = DB::select($sql_ds_manhinh);
        $this->dataDs_manhinh($ds_manhinh, 0, 0, "", $result);
        return $result;
        // $json_data['data'] = $result;
        // $data = json_encode($json_data);
        // return $data;
    }
    function Add_new_Menu(Request $request)
    {
        $id_manhinh = $request->input("id_manhinh");
        $id_chucnang = $request->input("id_chucnang");
        $id_nguoidung = Auth::guard('loginadmin')->user()->id;
        $active = $request->input("active");
        $time = $request->input("time");
        $quyen = $this->kiemtraquyen($id_nguoidung, $id_manhinh, $id_chucnang, $time, $active);
        if ($quyen == 1) {
            $validator = Validator::make(
                $request->all(),
                [
                    'menus_manhinh' => 'required|regex:/^[\pL\s0-9]+$/u|unique:24_menu,name',
                    'menus_link' => 'required|regex:/^[\pL\s0-9]+$/u',
                    'menus_icon' => 'required|regex:/^[\pL\s0-9-]+$/u',
                    'menus_stt' => 'required|numeric',
                ],
                [
                    'menus_manhinh.required' => 'Vui lòng nhập tên màn hình',
                    'menus_manhinh.regex' => 'Màn hình chỉ được chứa ký tự chữ, số và khoảng trắng',
                    'menus_manhinh.unique' => 'Màn hình đã tồn tại',
                    'menus_link.required' => 'Vui lòng nhập link của màn hình',
                    'menus_link.regex' => 'Link của màn hình chỉ được chứa ký tự chữ, số và khoảng trắng',
                    'menus_icon.required' => 'Vui lòng nhập link icon cho màn hình',
                    'menus_icon.regex' => 'Link icon chỉ được chứa ký tự chữ, số, khoảng trắng và ký tự "-"',
                    'menus_stt.required' => 'Vui lòng nhập stt cho màn hình',
                    'menus_stt.numeric' => 'stt cho màn hình phải là một số',
                ]
            );

            if ($validator->fails()) {
                $trangthai = response()->json($validator->errors());
                $type_res = 'validate';
            } else {
                try {
                    DB::table('24_menu')->insert([
                        'name' => $request->input('menus_manhinh'),
                        'parent_id' => $request->input('menus_parent'),
                        'link' => $request->input('menus_link'),
                        'stt' => $request->input('menus_stt'),
                        'icon' => $request->input('menus_icon'),
                    ]);
                    $trangthai = 'upd_1';
                    $type_res = 'thongbao';
                } catch (Exception $e) {
                    $trangthai = 'upd_0';
                    $type_res = 'thongbao';
                }
            }
        } else {
            $trangthai = 'rol_2';
            $type_res = 'thongbao';
        }
        return array(
            'thongbao' => $trangthai,
            'loaithongbao' => $type_res,
        );
    }
    function edit_manhinh($id, Request $request)
    {
        $id_manhinh = $request->input('id_manhinh');
        $id_chucnang = $request->input('id_chucnang');
        $time = $request->input('time');
        $id_admin = (int)Auth::guard('loginadmin')->user()->id;
        $active = $request->input('active');
        $quyen = $this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active);
        if ($quyen == 1) {
            $manhinh = DB::table('24_menu')
                ->select('*')
                ->where('IDMN', $id)
                ->get();

            $menus = DB::table('24_menu')
                ->select('IDMN AS id', 'name AS text', DB::raw("IF(IDMN = {$manhinh[0]->parent_id}, '1', '0') as selected"))
                ->where('IDMN', '!=', $id)
                ->where('parent_id', '=', 0)
                ->orderBy('id', 'asc')
                ->get();

            foreach ($menus as $key => $value) {
                if ($value->selected == 1) {
                    $value->selected = true;
                } else {
                    $value->selected = false;
                }
            }
            if ($manhinh[0]->parent_id == 0) {
                $menus0 = new Collection(
                    [
                        'id' => 0,
                        'text' => "Màn hình gốc",
                        'selected' => true
                    ]
                );
            } else {
                $menus0 = new Collection(
                    [
                        'id' => 0,
                        'text' => "Màn hình gốc",
                        'selected' => false
                    ]
                );
            }

            $menus[] =  $menus0;

            return $res = array(
                'manhinh' => $manhinh,
                'menus' => $menus,
            );
        } else {
            return 'rol_2';
        }
    }
    function dlt_manhinh($idmn, Request $request)
    {
        $id_nguoidung = $request->input("id_nguoidung"); //Id xóa
        $id_manhinh = $request->input("id_manhinh");
        $id_chucnang = $request->input("id_chucnang");
        $active = $request->input("active");
        $time = $request->input("time");
        $quyen_nguoidung = Auth::guard('loginadmin')->user()->id;
        $quyen = $this->kiemtraquyen($quyen_nguoidung, $id_manhinh, $id_chucnang, $time, $active);
        if ($quyen == 1) {
            $quyen = DB::table('24_phanquyen')->select()
                ->where('id_nguoidung', $id_nguoidung)
                ->where('id_manhinh', $id_manhinh)
                ->where('id_chucnang', 4)
                ->get();
            if ($idmn == $id_manhinh) {
                $trangthai = 5;
                $loai_trangthai = 'so';
            } else {
                try {
                    DB::beginTransaction();
                    //câu sql
                    $sql_find_son = "SELECT * FROM 24_menu WHERE parent_id = $idmn";
                    $result_find_son = DB::select($sql_find_son);
                    $sql_delete_menu = "DELETE FROM 24_menu WHERE IDMN = $idmn"; //xóa màn hình
                    $sql_delete_phanquyen = "DELETE FROM 24_phanquyen WHERE id_manhinh = $idmn"; //xóa những màn hình đó ở bảng phân quyền
                    $sql_delete_manhinh_chucnang = "DELETE FROM 24_danhmuc_manhinh_chucnang WHERE id_manhinh = $idmn"; //xóa những màn hình đó ở bảng màn hình chức năng
                    $sql_kt_manhinh_chucnang = DB::select("SELECT * FROM 24_danhmuc_manhinh_chucnang WHERE id_manhinh = $idmn"); //kiểm tra màn hình đó có chức năng gì không
                    $sql_kt_phanquyen = DB::select("SELECT * FROM 24_phanquyen WHERE id_manhinh = $idmn"); //kiểm tra màn hinh đó có được phân cho người dùng nào chưa
                    //Nếu nó không có con thì xóa thử
                    if (count($result_find_son) <= 0) {
                        $result_menu = DB::delete($sql_delete_menu);
                        //Nếu xóa thử được và màn hình đó có chức năng nhưng chưa phân cho người dùng nào
                        if ($result_menu > 0 && count($sql_kt_manhinh_chucnang) > 0 && count($sql_kt_phanquyen) <= 0) {
                            // $result_phanquyen = DB::delete($sql_delete_phanquyen);
                            //xóa chức năng được phân cho màn hình đó
                            $result_manhinh_chucnang = DB::delete($sql_delete_manhinh_chucnang);
                            //nếu xóa thành công thì comit lại xóa thiệt luôn
                            if ($result_manhinh_chucnang > 0) {
                                DB::commit();
                                $trangthai = 'del_1';
                                $loai_trangthai = 'thongbao';
                            } else { //xóa không được thì rollBack
                                DB::rollBack();
                                $trangthai = 4;
                                $loai_trangthai = 'so';
                            }
                            ////Nếu xóa thử được và màn hình đó có chức năng và cấp quyền cho người dùng rồi
                        } else if ($result_menu > 0 && count($sql_kt_manhinh_chucnang) > 0  && count($sql_kt_phanquyen) > 0) {
                            //xóa quyền sử dụng màn hình của người dùng đó
                            $result_phanquyen = DB::delete($sql_delete_phanquyen);
                            //xóa chức năng được phân cho màn hình đó
                            $result_manhinh_chucnang = DB::delete($sql_delete_manhinh_chucnang);
                            //nếu xóa được cả 2 thì commits
                            if ($result_manhinh_chucnang > 0 && $result_phanquyen > 0) {
                                DB::commit();
                                $trangthai = 'del_1';
                                $loai_trangthai = 'thongbao';
                            } else {
                                DB::rollBack();
                                $trangthai = 4;
                                $loai_trangthai = 'so';
                            }
                            //Nếu xóa được vừa màn hình không có chức năng vừa không có người dùng nào được cấp quyền
                        } else if ($result_menu > 0 && count($sql_kt_manhinh_chucnang) <= 0 && count($sql_kt_phanquyen) <= 0) {
                            //xóa thiệt luôn
                            DB::commit();
                            $trangthai = 'del_1';
                            $loai_trangthai = 'thongbao';
                        } else {
                            DB::rollBack();
                            $trangthai = 4;
                            $loai_trangthai = 'thongbao';
                        }
                    } else {
                        $trangthai = 4;
                        $loai_trangthai = 'so';
                    }
                } catch (Exception $e) {
                    $trangthai = 'del_2';
                    $loai_trangthai = 'thongbao';
                }
            }
        } else {
            $trangthai = 3;
            $loai_trangthai = 'so';
        }
        return array(
            'thongbao' => $trangthai,
            'loaithongbao' => $loai_trangthai,
        );
    }
    function update_manhinh(Request $request)
    {
        $id = $request->input("id");
        $update_tenmanhinh = $request->input("update_tenmanhinh");
        $update_manhinhgoc = $request->input("update_manhinhgoc");
        $update_icon = $request->input("update_icon");
        $update_link = $request->input("update_link");
        $update_stt = $request->input("update_stt");


        $id_manhinh = $request->input('id_manhinh');
        $id_chucnang = $request->input('id_chucnang');
        $active = $request->input('active');
        $time = $request->input('time');
        $id_admin = (int)Auth::guard('loginadmin')->user()->id;
        $quyen = $this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active); //Kiểm tra quyền trên màn hình
        if ($quyen == 1) {
            $validator = Validator::make(
                $request->all(),
                [
                    'update_tenmanhinh' => 'required|regex:/^[\pL\s0-9]+$/u',
                    'update_link' => 'required|regex:/^[\pL\s0-9]+$/u',
                    'update_icon' => 'required|regex:/^[\pL\s0-9-#]+$/u',
                    'update_stt' => 'required|numeric|not_in:0',
                ],
                [
                    'update_tenmanhinh.required' => 'Vui lòng nhập tên màn hình',
                    'update_tenmanhinh.regex' => 'Màn hình chỉ được chứa ký tự chữ, số và khoảng trắng',
                    // 'update_tenmanhinh.unique' => 'Màn hình đã tồn tại',

                    'update_link.required' => 'Vui lòng nhập link của màn hình',
                    'update_link.regex' => 'Link của màn hình chỉ được chứa ký tự chữ, số và khoảng trắng',

                    'update_icon.required' => 'Vui lòng nhập link icon cho màn hình',
                    'update_icon.regex' => 'Link icon chỉ được chứa ký tự chữ, số, khoảng trắng và ký tự "-"',

                    'update_stt.required' => 'Vui lòng nhập stt cho màn hình',
                    'update_stt.numeric' => 'stt cho màn hình phải là một số',
                    'update_stt.not_in' => 'Stt khác 0',
                ]
            );
            try {
                $check_tenmans = DB::table('24_menu')
                    ->select('*')
                    ->where('IDMN', '<>', $id)
                    ->get();

                $check_man = 0;
                foreach ($check_tenmans as $key => $check_tenman) {
                    if ($check_tenman->name == $update_tenmanhinh) {
                        $check_man++;
                    } else {
                    }
                }

                // check không có thay đổi
                $check_khongthaydoi = DB::table('24_menu')
                    ->select('*')
                    ->where('IDMN', $id)
                    ->get();

                $checker = 0;
                if ($check_khongthaydoi[0]->name == $update_tenmanhinh && $check_khongthaydoi[0]->link == $update_link && $check_khongthaydoi[0]->stt == $update_stt && $check_khongthaydoi[0]->parent_id == $update_manhinhgoc && $check_khongthaydoi[0]->icon == $update_icon) {
                    $checker++;
                }
                if ($validator->fails()) {
                    $trangthai = response()->json($validator->errors());
                    $type_res = "validate";
                } else if ($checker > 0) {
                    $trangthai = "upd_2";
                    $type_res = "upd_2";
                } else if ($check_man >= 1) {
                    $trangthai = "unique";
                    $type_res = "unique";
                } else {
                    $check_update_goc = DB::table('24_menu')
                        ->select('*')
                        ->where('IDMN', $id)
                        ->get();
                    if ($check_update_goc[0]->parent_id == $update_manhinhgoc) {
                        $slq_update = DB::table('24_menu')
                            ->where('IDMN', $id)
                            ->update([
                                'name' => $update_tenmanhinh,
                                'link' => $update_link,
                                'stt' => $update_stt,
                                'parent_id' => $update_manhinhgoc,
                                'icon' => $update_icon,
                            ]);
                        $trangthai = "upd_1";
                        $type_res = "thongbao";
                    } else {
                        $check_parentid = DB::table('24_menu')
                            ->select('*')
                            ->Where('IDMN', $id)
                            ->get();

                        $check_phanquyen = DB::table('24_phanquyen')
                            ->select('*')
                            ->Where('id_manhinh', $id)
                            ->get();

                        $check_pq_parent = DB::table('24_phanquyen')
                            ->select('*')
                            ->Where('id_manhinh', $check_parentid[0]->parent_id)
                            ->get();
                        // Màn hình là con
                        if ($check_parentid[0]->parent_id != 0) {
                            if (count($check_phanquyen) > 0) {
                                // xóa phân quyền của màn hình và cha nếu không còn con khác
                                if (count($check_pq_parent) <= 2) {
                                    DB::beginTransaction();
                                    $sql_dlt_phanquyen = DB::table('24_phanquyen')
                                        ->where('id_manhinh', $id)
                                        ->delete();

                                    $sql_dlt_phanquyen_parent = DB::table('24_phanquyen')
                                        ->where('id_manhinh', $$check_parentid[0]->parent_id)
                                        ->delete();

                                    $slq_update = DB::table('24_menu')
                                        ->where('IDMN', $id)
                                        ->update([
                                            'name' => $update_tenmanhinh,
                                            'link' => $update_link,
                                            'stt' => $update_stt,
                                            'parent_id' => $update_manhinhgoc,
                                            'icon' => $update_icon,
                                        ]);
                                    if ($slq_update > 0 && $sql_dlt_phanquyen > 0 && $sql_dlt_phanquyen_parent > 0) {
                                        DB::commit();
                                        $trangthai = "upd_1";
                                        $type_res = "thongbao";
                                    } else { //xóa không được thì rollBack
                                        DB::rollBack();
                                        $trangthai = "upd_0";
                                        $type_res = "thongbao";
                                    }
                                } else {
                                    DB::beginTransaction();
                                    $sql_dlt_phanquyen = DB::table('24_phanquyen')
                                        ->where('id_manhinh', $id)
                                        ->delete();

                                    $slq_update = DB::table('24_menu')
                                        ->where('IDMN', $id)
                                        ->update([
                                            'name' => $update_tenmanhinh,
                                            'link' => $update_link,
                                            'stt' => $update_stt,
                                            'parent_id' => $update_manhinhgoc,
                                            'icon' => $update_icon,
                                        ]);

                                    if ($slq_update > 0 && $sql_dlt_phanquyen > 0) {
                                        $trangthai = "upd_1";
                                        $type_res = "thongbao";
                                        return 1;
                                    } else { //xóa không được thì rollBack
                                        DB::rollBack();
                                        $trangthai = "upd_0";
                                        $type_res = "thongbao";
                                    }
                                }
                            } else {
                                $slq_update = DB::table('24_menu')
                                    ->where('IDMN', $id)
                                    ->update([
                                        'name' => $update_tenmanhinh,
                                        'link' => $update_link,
                                        'stt' => $update_stt,
                                        'parent_id' => $update_manhinhgoc,
                                        'icon' => $update_icon,
                                    ]);
                                $trangthai = "upd_1";
                                $type_res = "thongbao";
                            }
                        } else { //màn hình là cha
                            $all_con = DB::table('24_menu')
                                ->select('*')
                                ->Where('parent_id', $id)
                                ->get();

                            if (count($check_phanquyen) > 0) {
                                if (count($all_con) > 0) {
                                    DB::beginTransaction();
                                    foreach ($all_con as $key => $value) {
                                        $sql_dlt_phanquyen_con = DB::table('24_phanquyen')
                                            ->where('id_manhinh', $value->IDMN)
                                            ->delete();
                                    }
                                    $sql_dlt_phanquyen = DB::table('24_phanquyen')
                                        ->where('id_manhinh', $id)
                                        ->delete();
                                    $slq_update = DB::table('24_menu')
                                        ->where('IDMN', $id)
                                        ->update([
                                            'name' => $update_tenmanhinh,
                                            'link' => $update_link,
                                            'stt' => $update_stt,
                                            'parent_id' => $update_manhinhgoc,
                                            'icon' => $update_icon,
                                        ]);
                                    if ($slq_update > 0 && $sql_dlt_phanquyen > 0 && $sql_dlt_phanquyen_con > 0) {
                                        DB::commit();
                                        $trangthai = "upd_1";
                                        $type_res = "thongbao";
                                    } else { //xóa không được thì rollBack
                                        DB::rollBack();
                                        $trangthai = "upd_0";
                                        $type_res = "thongbao";
                                    }
                                }
                            } else {
                                $slq_update = DB::table('24_menu')
                                    ->where('IDMN', $id)
                                    ->update([
                                        'name' => $update_tenmanhinh,
                                        'link' => $update_link,
                                        'stt' => $update_stt,
                                        'parent_id' => $update_manhinhgoc,
                                        'icon' => $update_icon,
                                    ]);
                                $trangthai = "upd_1";
                                $type_res = "thongbao";
                            }
                        }
                    }
                }
            } catch (Exception $e) {
                $trangthai = "upd_0";
                $type_res = "thongbao";
            }
        } else {
            $trangthai = "rol_2";
            $type_res = "thongbao";
        }
        return array(
            'thongbao' => $trangthai,
            'loaithongbao' => $type_res,
        );
    }
    function data_tables_menus($idmn, Request $request)
    {
        $id_manhinh_checkquyen = $request->input('id_manhinh_checkquyen');
        $id_chucnang = $request->input('id_chucnang');
        $active = 1;
        $time = $request->input('time');
        $id_admin = (int)Auth::guard('loginadmin')->user()->id;
        $quyen = $this->kiemtraquyen($id_admin, $id_manhinh_checkquyen, $id_chucnang, $time, $active); //Kiểm tra quyền trên màn hình
        if ($quyen == 1) {
            $sql_all_manhinh = "SELECT * FROM `24_menu` WHERE IDMN=$idmn";
            $menus = DB::select($sql_all_manhinh);

            $sql_all_chunang = "SELECT * FROM `24_danhmuc_chucnang`";
            $all_chucnang = DB::select($sql_all_chunang);

            $sql_danhmuc_manhinh_chucnang = "SELECT * FROM `24_danhmuc_manhinh_chucnang` WHERE id_manhinh = $idmn";
            $danhmuc_manhinh_chucnang = DB::select($sql_danhmuc_manhinh_chucnang);
            if ($menus) {
                foreach ($menus as $key => $manhinh) {
                    foreach ($all_chucnang as $key_chucnang => $chucnang) {
                        $ten_loaichucnang = $chucnang->danhmuc_chucnang_id;
                        $manhinh->$ten_loaichucnang = 0;
                    }
                    //
                    foreach ($danhmuc_manhinh_chucnang as $key_mh_cn => $man_hinhchucnang) {
                        if ($manhinh->IDMN == $man_hinhchucnang->id_manhinh) {
                            foreach ($all_chucnang as $key_chucnang => $chucnang) {
                                $ten_loaichucnang = $chucnang->danhmuc_chucnang_id;
                                if ($man_hinhchucnang->id_chucnang == $chucnang->id) {
                                    $manhinh->$ten_loaichucnang = $chucnang->id;
                                }
                            }
                        }
                    }
                }
            } else {
                return '-100';
            }
            return $res = array(
                'body' => $menus,
                'head' => $all_chucnang,
                'id_user' => $id_admin,
            );
        } else {
            return 'rol_2';
        }
    }
    function Update_chucnang_manhinh(Request $request)
    {
        $id_manhinh_checkquyen = $request->input('id_manhinh_checkquyen');
        $id_chucnang = $request->input('id_chucnang');
        $active = $request->input('active');
        $time = $request->input('time');
        $id_admin = (int)Auth::guard('loginadmin')->user()->id;
        $quyen = $this->kiemtraquyen($id_admin, $id_manhinh_checkquyen, $id_chucnang, $time, $active); //Kiểm tra quyền trên màn hình
        if ($quyen == 1) {
            try {
                $quyen = $request->input('quyen');
                $id_manhinh = $request->input('id_manhinh');
                $id_chucnang = $request->input('id_chucnang');
                $hasrole = $request->input('hasrole');
                $success = true;
                $Sql_kt_tontai = DB::table('24_danhmuc_manhinh_chucnang')->where('id_manhinh', $id_manhinh)->select()->get();
                if (count($Sql_kt_tontai) > 0) {
                    DB::beginTransaction();
                    $sql_dlt_all_danhmuc_chucnang = DB::table('24_danhmuc_manhinh_chucnang')->where('id_manhinh', $id_manhinh)->delete();
                    if ($sql_dlt_all_danhmuc_chucnang) {
                        foreach ($quyen as $key => $chucnang) {
                            if ($chucnang[0] > 0) {
                                $add_chucnang = DB::table('24_danhmuc_manhinh_chucnang')->insert([
                                    'id_chucnang' => $chucnang[0],
                                    'id_manhinh' => $id_manhinh,
                                ]);
                                if (!$add_chucnang) {
                                    $success = false;
                                    break;
                                }
                            }
                        }
                    } else {
                        DB::rollBack();
                        $success = false;
                    }
                } else {
                    foreach ($quyen as $key => $chucnang) {
                        if ($chucnang[0] > 0) {
                            $add_chucnang = DB::table('24_danhmuc_manhinh_chucnang')->insert([
                                'id_chucnang' => $chucnang[0],
                                'id_manhinh' => $id_manhinh,
                            ]);
                            if (!$add_chucnang) {
                                $success = false;
                                break;
                            }
                        }
                    }
                }
                if ($success) {
                    DB::commit();
                    return 'upd_1';
                } else {
                    DB::rollBack();
                    return 'upd_0';
                }
            } catch (Exception $e) {
                return 'upd_0';
            }
        } else {
            return 'rol_2';
        }
    }


    // Đợt tuyển sinh
    function dottuyensinh()
    {

        return view(
            'user_24.admin24.manage.dottuyensinh.dottuyensinh',
            [
                'menu' =>    $this->sidebar(),
                'title' => 'Đăng ký giấy xác nhận'
            ]
        );
    }


    function bang_ds_dottuyensinh()
    {
        $data = DB::table('24_dottuyensinh')
            // DB::raw('ROW_NUMBER() OVER (ORDER BY 24_cmc_dangkygiay.id) AS stt')
            ->select("*",DB::raw('ROW_NUMBER() OVER (ORDER BY id DESC) AS stt'))
            ->orderBy('id','DESC')
            ->get();
        $json_data['data'] = $data;
        $res = json_encode($json_data);
        return  $res;
        // return $data;
    }

    function them_dottuyensinh(Request $r)
    {
        $validator = Validator::make(
            $r->all(),
            [
                // 'id' => 'required|integer|min:1'
                'madot' => 'required',
                'tendot' => 'required',
                'trangthai' => 'required|integer',
                'khoadot' => 'required|integer',
            ],
            [
                // 'id.min' => "Vui lòng chọn loại giấy"
                'madot.required' => "Vui lòng nhập mã đợt",
                'tendot.required' => "Vui lòng nhập tên đợt",
                'trangthai.required' => "Vui lòng nhập trạng thái",
                'khoadot.required' => "Vui lòng nhập khóa đợt",
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors()); // Nếu không có lỗi, lưu dữ liệu vào cơ sở dữ liệu
        } else {
            try {
                DB::table('24_dottuyensinh')
                    ->insert(
                        [
                            'madot' => $r->input('madot'),
                            'tendot' => $r->input('tendot'),
                            'trangthai' => $r->input('trangthai'),
                            'khoadot' => $r->input('khoadot')
                        ]
                    );
                return  1;
            } catch (Exception $e) {
                return  0;
            }
        }
    }

    function edit_load_dottuyensinh(Request $request){
        $data = DB::table('24_dottuyensinh')->where('id',$request->input('id'))->get();
        $json_data['data'] = $data;
        $res = json_encode($json_data);
        return  $data;
    }

    function update_dottuyensinh(Request $request){
        $id = $request->input('id');
        $madot = $request->input('madot');
        $tendot = $request->input('tendot');
        $trangthai = $request->input('trangthai');
        $khoadot = $request->input('khoadot');

        DB::beginTransaction();
        try{
            $res = DB::table('24_dottuyensinh')
            ->where('id',$id)
            ->update([
                'madot' => $madot,
                'tendot' => $tendot,
                'trangthai' => $trangthai,
                'khoadot' => $khoadot,
            ]);
            if($res != 0){
                if($res == 1){
                    DB::commit();
                    return 'upd_1';
                }else{
                    DB::rollBack();
                    return 'upd_0';
                }
            }else{
                return 'upd_2';
            }
        }catch(Exception $e){
            DB::rollBack();
            return 'upd_0';
        }

    }

    public function refresh_dottuyensinh(Request $request)
    {
        $exists = DB::table('24_dottuyensinh')->exists();

        if ($exists) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Không có dữ liệu để làm mới'], 404);
        }
    }

    function delete_dottuyensinh(Request $request){
        DB::table('24_dottuyensinh')->where('id',$request->input('id'))->delete();
        return 1;
    }


    // Đợt xét tuyển
    function dotxettuyen(){

        return view('user_24.admin24.manage.dottuyensinh.dotxettuyen',
        [
            'menu' =>    $this->sidebar(),
            'title' => 'Đăng ký giấy xác nhận'
        ]);
    }



    function bang_ds_dotxettuyen()
    {
        $data = DB::table('24_dotxettuyen')
            ->select("24_dotxettuyen.*", "24_dottuyensinh.tendot", DB::raw('ROW_NUMBER() OVER (ORDER BY id DESC) AS stt'))
            ->leftJoin('24_dottuyensinh', '24_dottuyensinh.id', '24_dotxettuyen.iddotts')
            ->orderBy('id','DESC')
            ->get();




        $json_data['data'] = $data;
        $res = json_encode($json_data);
        return  $res;
        // return $data;
    }

    function load_selectbox_dotxettuyen(){
        $list_dts0 = new Collection(
            [
                'id' => 0,
                'text' => "Chọn đợt tuyển sinh...",
                'selected' => true
            ]
        );


        $list_dts = DB::table('24_dottuyensinh')
            ->select('id as id', 'tendot as text')
            ->orderBy('id', 'asc')
            ->get();

        $list_dts[] =  $list_dts0;
        return $list_dts;
    }

    function them_dotxettuyen(Request $r)
    {
        $validator = Validator::make(
            $r->all(),
            [
                'iddotts' => 'required|integer',
                'iddotxt' => 'required|integer',
                'tendotxettuyen' => 'required',  // Đã sửa dấu cách dư thừa
                'id_quytrinhcongbo' => 'required|integer',
                'ghichu_quytrinh' => 'nullable',
                'khoadot' => 'required|integer',
            ],
            [
                'iddotts.required' => "Vui lòng nhập mã đợt tuyển sinh",
                'iddotxt.required' => "Vui lòng nhập mã đợt xét tuyển",
                'tendotxettuyen.required' => "Vui lòng nhập tên đợt",
                'id_quytrinhcongbo.required' => "Vui lòng nhập id quy trình",
                'khoadot.required' => "Vui lòng nhập khóa đợt",
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422); // Trả về lỗi với status 422
        } else {
            try {
                DB::table('24_dotxettuyen')->insert([
                    'iddotts' => $r->input('iddotts'),
                    'iddotxt' => $r->input('iddotxt'),
                    'tendotxettuyen' => $r->input('tendotxettuyen'),
                    'id_quytrinhcongbo' => $r->input('id_quytrinhcongbo'),
                    'ghichu_quytrinh' => $r->input('ghichu_quytrinh'),
                    'khoadot' => $r->input('khoadot'),
                ]);
               return 1;//  response()->json(['message' => 'Thêm thành công'], 200); // Trả về phản hồi thành công
            } catch (Exception $e) {
               return 0;  // response()->json(['error' => 'Lỗi khi thêm dữ liệu: ' . $e->getMessage()], 500); // Trả về lỗi nếu có ngoại lệ
            }
        }
    }




    function edit_load_dotxettuyen(Request $request){
        $data = DB::table('24_dotxettuyen')->where('id',$request->input('id'))->get();
        // $json_data['data'] = $data;
        // $res = json_encode($json_data);
        // return  $data;

        $edit_load_dotxettuyen = $data;
        $selectbox_dottuyensinh = $this->load_selectbox_dotxettuyen();

        return $res = array(
            'edit_load_dotxettuyen' => $edit_load_dotxettuyen,
            'selectbox_dottuyensinh' => $selectbox_dottuyensinh,
        );
    }

    function update_dotxettuyen(Request $request){
        $id = $request->input('id');
        $iddotts = $request->input('iddotts');
        $iddotxt = $request->input('iddotxt');
        $tendotxettuyen = $request->input('tendotxettuyen');
        $id_quytrinhcongbo = $request->input('id_quytrinhcongbo');
        $ghichu_quytrinh = $request->input('ghichu_quytrinh');
        $khoadot = $request->input('khoadot');

        DB::beginTransaction();
        try{
            $res = DB::table('24_dotxettuyen')
            ->where('id',$id)
            ->update([
                'iddotts' => $iddotts,
                'iddotxt' => $iddotxt,
                'tendotxettuyen' => $tendotxettuyen,
                'id_quytrinhcongbo' => $id_quytrinhcongbo,
                'ghichu_quytrinh' => $ghichu_quytrinh,
                'khoadot' => $khoadot,
            ]);
            if($res != 0){
                if($res == 1){
                    DB::commit();
                    return 'upd_1';
                }else{
                    DB::rollBack();
                    return 'upd_0';
                }
            }else{
                return 'upd_2';
            }
        }catch(Exception $e){
            DB::rollBack();
            return 'upd_0';
        }
    }
    // public function refresh_dotxettuyen(Request $request)
    // {
    //     $exists = DB::table('24_dotxettuyen')->exists();

    //     if ($exists) {
    //         return response()->json(['status' => 'success']);
    //     } else {
    //         return response()->json(['status' => 'error', 'message' => 'Không có dữ liệu để làm mới'], 404);
    //     }
    // }

    function delete_dotxettuyen(Request $request){
        DB::table('24_dotxettuyen')->where('id',$request->input('id'))->delete();
        return 1;
    }













    //QUAN LY NHAP HOC
    //Ho so nhap hoc
    public function hosonhaphoc()
    {
        $res =  DB::table('24_thongtincanhan')
            ->select('hoten as text', 'id_taikhoan as id', 'gioitinh as check')
            ->get();
        return view(
            'user_24.admin24.manage.quanlynhaphoc.hosonhaphoc',
            [
                'menu' =>  $this->sidebar(),
                'res' => $res,

            ]
        );
    }

    public function loadttcn($id_taikhoan)
    {

        $res =  DB::table('24_thongtincanhan')
            ->select('hoten as text', 'id_taikhoan as id', 'gioitinh as check')
            ->where('id_taikhoan', $id_taikhoan)
            ->get();
        if (count($res) > 0) {
            $data =  $res;
        } else {
            $data =  [];
        }

        return $data;
    }




            //Quản lý lệ phí
        //Danh sách thanh toán
    //Index
    public function hosotructuyen()
    {
        $url = URL::current();
        $quyen = $this->kiemtraquyen_url($url);
        if ($quyen == 1) {
            return view(
                'user_24.admin24.manage.hosotructuyen',
                [
                    'menu' =>    $this->sidebar(),
                ]
            );
        } else {
            return view('user_24.admin24.include.404');
        }
    }

    //Load hồ sơ thanh toán
    public function loadhosolephi($id_dot)
    {
        $data = DB::table('24_ketquathanhtoan')
            ->join('24_thongtincanhan', '24_thongtincanhan.id_taikhoan', '24_ketquathanhtoan.id_taikhoan')
            ->join('account24s', 'account24s.id', '24_ketquathanhtoan.id_taikhoan')
            ->select(DB::raw('ROW_NUMBER() OVER (ORDER BY 24_ketquathanhtoan.id) AS stt'), '24_ketquathanhtoan.create_at as ngaythanhtoan', '24_ketquathanhtoan.*', 'account24s.*', '24_thongtincanhan.*')
            ->where([
                '24_ketquathanhtoan.id_dot' =>  $id_dot,
            ])
            ->get();
        $json_data['data'] = $data;
        $res = json_encode($json_data);
        return  $res;
    }
    //Xuất excel
    public function exceldanhsachtructuyen($id_dot)
    {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $title = 'DanhSachThanhToanTrucTuyen' . date("d-m-Y H:i:s") . '.xlsx';
        return Excel::download(new Admin24_ExportDanhSachThanhtoan($id_dot), $title);
    }
    //Thống kê lệ phí theo trạng thai
    public function thongkelephitheotrangthai($id_dot)
    {
        $tongthu = DB::table('24_ketquathanhtoan')
            ->where('id_dot', $id_dot)
            ->sum('total_amount');
        $tongthisinh = DB::table('24_ketquathanhtoan')
            ->where('id_dot', $id_dot)
            ->distinct()->count();
        $tonghoadon = DB::table('24_ketquathanhtoan')
            ->where('id_dot', $id_dot)
            ->count();
        $res = array([
            'tongthu' =>  $tongthu,
            'tongthisinh' => $tongthisinh,
            'tonghoadon' => $tonghoadon,

        ]);
        return $res;
    }

    //Thu lệ phí
    //Load index
    public function thulephi()
    {
        $url = URL::current();
        $quyen = $this->kiemtraquyen_url($url);
        if ($quyen == 1) {
            return view(
                'user_24.admin24.manage.quanlylephi.thulephi',
                [
                    'menu' =>    $this->sidebar(),
                ]
            );
        } else {
            return view('user_24.admin24.include.404');
        }
    }
    //Danh sách hóa đơn
    public function ds_hoadon($id)
    {
        $res = DB::table('24_ketquathanhtoan')
            ->join('24_accountsadmin', '24_accountsadmin.id', '24_ketquathanhtoan.id_nguoithu')
            ->join('24_thongtincanhan', '24_thongtincanhan.id_taikhoan', '24_ketquathanhtoan.id_taikhoan')
            // ->join('24_nvthulephi', '24_nvthulephi.id_taikhoan', '=', '24_nvthulephi.id_taikhoan')
            ->select('24_thongtincanhan.hoten', '24_accountsadmin.email as nguoithu', '24_ketquathanhtoan.id as id', '24_ketquathanhtoan.id_order as mahoadon', '24_ketquathanhtoan.id_order as mahoadon', '24_ketquathanhtoan.total_amount as sotien', '24_ketquathanhtoan.hinhthuc as hinhthuc', '24_ketquathanhtoan.create_at as ngaythu')
            ->where('24_ketquathanhtoan.id_taikhoan', $id)
            ->get();
        $json_data['data'] = $res;
        $data = json_encode($json_data);
        return $data;
    }
    //Thông tin thí sinh
    public function ttsv_donglephi($id)
    {
        $res = DB::table('account24s')
            ->join('24_thongtincanhan', 'account24s.id', '=', '24_thongtincanhan.id_taikhoan')
            ->select('24_thongtincanhan.hoten as hoten', '24_thongtincanhan.cccd as cccd', '24_thongtincanhan.ngaysinh as ngaysinh', '24_thongtincanhan.dienthoai as dienthoai', '24_thongtincanhan.diachi as diachi', 'account24s.email as email', 'account24s.id as id_taikhoandong')
            ->where('account24s.id', $id)
            ->first();
        return $res;
    }
    //Thu lệ phí
    public function thanhtoan(Request $r)
    {
        $id_tk = $r->input('id_tk');
        $email = $r->input('email');
        $hoten = $r->input('hoten');
        $sotien = $r->input('sotien');
        //Kiểm tra quyền
        $id_chucnang = $r->input('id_chucnang');
        $id_manhinh = $r->input('id_manhinh');
        $time = $r->input('time');
        $active = $r->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            $hinhthucthanhtoan = $r->input('hinhthucthanhtoan');
            $id_nguoithu = Auth::guard('loginadmin')->user()->id;
            $date = Carbon::now();
            $mahoadon = $date->timestamp;
            $validator = Validator::make(
                $r->all(),
                [
                    'id_tk' => 'required|numeric|exists:24_thongtincanhan,id_taikhoan',
                    'sotien' => 'required|numeric',
                    'hinhthucthanhtoan' => 'required|numeric|min:1|max:2',

                ],
                [
                    'id_tk.required' => 'Vui lòng điền ID.',
                    'sotien.required' => 'Vui lòng nhập số tiền thu.',
                    'id_tk.numeric' => 'ID là một số.',
                    'sotien.numeric' => 'Số tiền thu là một số.',
                    'hinhthucthanhtoan.required' => 'Hình thức thanh toán là bắt buộc.',
                    'hinhthucthanhtoan.numeric' => 'Hình thức thanh toán phải là một số.',
                    'hinhthucthanhtoan.min' => 'Chọn hình thức thanh toán.',
                    'hinhthucthanhtoan.max' => 'Chọn hình thức thanh toán.',
                    'id_tk.exists' => 'Không có thí sinh.',
                ]
            );
            if ($validator->fails()) {
                $noidung = response()->json($validator->errors());
                $trangthai = "validate";
            } else {
                DB::beginTransaction();
                try {
                    $db = DB::table('24_ketquathanhtoan')
                        ->insert(
                            [
                                'order_id' => 0,
                                'id_dot' => 1,
                                'id_taikhoan' => $id_tk,
                                'id_order' => $mahoadon,
                                'user_id' => 0,
                                'mrc_order_id' => 0,
                                'txn_id' => 0,
                                'ref_no' => 0,
                                'merchant_id' => 0,
                                'total_amount' => $sotien,
                                'description' => 0,
                                'items' => 0,
                                'url_success' => 0,
                                'url_cancel' => 0,
                                'url_detail' => 0,
                                'stat_order' => 0,
                                'lang' => 0,
                                'bpm_id' => 0,
                                'accept_qrpay' => 0,
                                'accept_bank' => 0,
                                'accept_cc' => 0,
                                'accept_ib' => 0,
                                'accept_ewallet' => 0,
                                'accept_installments' => 0,
                                'email' => $email,
                                'name' => 0,
                                'webhooks' => 0,
                                'customer_name' => $hoten,
                                'customer_email' => 0,
                                'customer_phone' => 0,
                                'customer_address' => 0,
                                'created_at_order' => $date,
                                'updated_at' => $date,
                                // txn
                                'id_txn' => 0,
                                'reference_id' => 0,
                                // 'order_id' => 0,
                                'amount' => 0,
                                'fee_amount' => 0,
                                'bank_fee_amount' => 0,
                                'bank_fix_fee_amount' => 0,
                                'fee_payer' => 0,
                                'bank_fee_payer' => 0,
                                'auth_code' => 0,
                                'auth_time' => 0,
                                'bank_ref_no' => 0,
                                'bpm_type' => 0,
                                'gateway' => 0,
                                'stat_txn' => 0,
                                'init_token' => 0,
                                'completed_at' => $date,
                                'created_at_txn' => $date,
                                'dataToken' => 0,
                                'sign' => 0,
                                "err_code" => "0",
                                "message" => "some message",
                                "hinhthuc" => $hinhthucthanhtoan,
                                "id_nguoithu" => $id_nguoithu
                            ]
                        );
                    $user_agent = $_SERVER['HTTP_USER_AGENT'];
                    DB::table('24_lichsu')
                        ->updateOrInsert(
                            [
                                'ghichu' =>  $mahoadon,
                            ],
                            [
                                'id_taikhoan' => $id_tk,
                                'noidung'   => "Nhận thanh toán lệ phí (MaHĐ: " . $mahoadon . " - " . $sotien . " VND )",
                                'hienthi'   => 1,
                                'id_nhansu' => $id_admin,
                                'thietbi'   => $user_agent,
                                'ip'        => request()->ip()
                            ]
                        );
                    DB::commit();
                    if ($db) {
                        $trangthai = 'ins_1';
                    } else {
                        $trangthai = 'ins_0';
                    }
                    $noidung = "";
                } catch (Exception $e) {
                    DB::rollBack();
                    $trangthai = "ins_0";
                    $noidung = "";
                }
            }
        } else {
            $trangthai = "rol_2";
            $noidung = "";
        }
        return array(
            'trangthai' => $trangthai,
            "noidung" => $noidung
        );
    }
    //Xóa hóa đơn
    public function delete_hoadon(Request $request, $id)
    {
        //Kiểm tra quyền
        $id_chucnang = $request->input('id_chucnang');
        $id_manhinh = $request->input('id_manhinh');
        $time = $request->input('time');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        $thanhtoan = DB::table('24_ketquathanhtoan')->where('id', $id)->first();
        $id_order = $thanhtoan->id_order;
        $id_taikhoan = $thanhtoan->id_taikhoan;
        $total_amount = $thanhtoan->total_amount;
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            DB::beginTransaction();
            try {
                $re = DB::table('24_ketquathanhtoan')
                    ->where('id', $id)
                    ->whereIn('hinhthuc', [1, 2])
                    ->delete();
                if ($re) {
                    $trangthai = 'del_1';
                } else {
                    $trangthai = 'del_0';
                }
                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                DB::table('24_lichsu')
                    ->insert(
                        [
                            'id_taikhoan' => $id_taikhoan,
                            'noidung'   => "Xóa thu lệ phí(MaHĐ: " . $id_order . " - " . $total_amount . " VND )",
                            'hienthi'   => 0,
                            'id_nhansu' => $id_admin,
                            'thietbi'   => $user_agent,
                            'ip'        => request()->ip()
                        ]
                    );
                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                $trangthai = "del_0";
            }
        } else {
            $trangthai = "rol_2";
        }
        return $trangthai;
    }









        //Quản lý hồ sơ
    //Phân công hồ sơ
    function phanconghoso()
    {
        $url = URL::current();
        $quyen = $this->kiemtraquyen_url($url);
        if ($quyen == 1) {
            return view(
                'user_24.admin24.manage.quanlyhoso.phanconghoso',
                [
                    'menu' =>    $this->sidebar(),
                ]
            );
        } else {
            return view('user_24.admin24.include.404');
        }
    }
    function kiemtra_pchoso(Request $request)
    {
        $time = $request->input('time');
        $id_manhinh = $request->input('id_manhinh');
        $id_chucnang = $request->input('id_chucnang');
        $active = $request->input('active');
        $trangthai = $request->input('trangthai');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            DB::table('24_checkphancong')
                ->updateOrInsert(
                    [
                        'id_nguoidung' =>  $id_admin,
                    ],
                    [
                        'trangthai' => $trangthai,
                    ]
                );
            $trangthai = $time;
        } else {
            $trangthai = 'rol_2';
        }
        return $trangthai;
    }
    public function hoso_danhsach($id_nam)
    {
        $thongtinhoso = DB::select("SELECT if(duyet.email is null,'',duyet.email) as email_duyet, 24_trangthaihoso.id_trangthai as id_trangthai,24_trangthaihoso.tentrangthai, 24_trangthaihoso.icon,24_trangthaihoso.class_small, if(nhansu.email is null,'',nhansu.email) as email_nhansu ,24_kiemtrahoso.trangthai,24_kiemtrahoso.id AS id ,24_kiemtrahoso.id_taikhoan ,thisinh.email ,24_thongtincanhan.hoten ,24_thongtincanhan.cccd ,IF(24_khoadangky.trangthai IS NULL, 0,24_khoadangky.trangthai) AS trangthaidangky,24_kiemtrahoso.khoa AS trangthaikhoa,24_kiemtrahoso.duyet AS trangthaiduyet,24_kiemtrahoso.thoigiankhoa as thoigiankhoa ,24_kiemtrahoso.thoigiancapnhat as thoigiancapnhat ,24_kiemtrahoso.thoigianduyet as thoigianduyet FROM 24_kiemtrahoso JOIN (SELECT * FROM account24s) as thisinh ON 24_kiemtrahoso.id_taikhoan = thisinh.id LEFT JOIN (SELECT * FROM account24s) as nhansu ON 24_kiemtrahoso.id_nhansu = nhansu.id LEFT JOIN (SELECT * FROM account24s) as duyet ON 24_kiemtrahoso.id_nhansuduyet = duyet.id INNER JOIN 24_thongtincanhan ON 24_thongtincanhan.id_taikhoan = 24_kiemtrahoso.id_taikhoan LEFT JOIN 24_trangthaihoso ON 24_trangthaihoso.id_trangthai = 24_kiemtrahoso.trangthai LEFT JOIN 24_khoadangky ON 24_khoadangky.id_taikhoan = thisinh.id INNER JOIN (SELECT DISTINCT(id_taikhoan) as id_taikhoan, idnam FROM 24_nguyenvong) AS nguyenvong  ON nguyenvong.id_taikhoan = 24_kiemtrahoso.id_taikhoan WHERE nguyenvong.idnam = " . (int)$id_nam);
        $json_data['data'] = $thongtinhoso;
        $res = json_encode($json_data);
        return $res;
    }
    public function ds_canbo()
    {
        $id_manhinh = 19;
        $ds_canbo = DB::table('account24s')
            ->select(
                'account24s.id',
                'account24s.name',
                'account24s.email',
                DB::raw(
                    'CASE
                    WHEN COUNT(24_phanquyen.id_nguoidung) = 2 THEN 2
                    WHEN SUM(CASE WHEN 24_phanquyen.id_chucnang = 8 THEN 1 ELSE 0 END) = 1 THEN 1
                    WHEN SUM(CASE WHEN 24_phanquyen.id_chucnang = 2 THEN 1 ELSE 0 END) = 1 THEN 0
                    ELSE 0
                END AS quyen_phancong'
                )
            )
            ->join('24_phanquyen', '24_phanquyen.id_nguoidung', '=', 'account24s.id')
            ->where('account24s.admin', 1)
            ->where('24_phanquyen.id_manhinh', '=', $id_manhinh)
            ->where(function ($query) {
                $query->where('24_phanquyen.id_chucnang', 2)
                    ->orWhere('24_phanquyen.id_chucnang', 8);
            })
            ->groupBy('account24s.id', 'account24s.name', 'account24s.email')
            ->get();



        $json_data['data'] = $ds_canbo;
        $res = json_encode($json_data);
        return $res;
    }
    function divideArray($array, $chunks)
    {
        $totalItems = count($array);
        $itemsPerChunk = floor($totalItems / $chunks);
        $remainder = $totalItems % $chunks;

        $result = [];
        $start = 0;

        for ($i = 0; $i < $chunks; $i++) {
            $chunkSize = $itemsPerChunk + ($i < $remainder ? 1 : 0);
            $result[] = array_slice($array, $start, $chunkSize);
            $start += $chunkSize;
        }

        return $result;
    }
    public function phancong_exel($hoten, $email, $kiemtra, $trangthaiduyet, $trangthaikhoa, $trangthai, $id_nam)
    {
        if ($hoten == -1) {
            $hoten = 'is not null';
        } else {
            $hoten = " LIKE '%" . $hoten . "%'";
        }

        if ($email == -1) {
            $email = 'is not null';
        } else {
            $email = " LIKE '%" . $email . "%'";
        }

        if ($kiemtra == -1) {
            $kiemtra = 'is not null';
        } else {
            $kiemtra = " LIKE '%" . $kiemtra . "%'";
        }

        if ($trangthaiduyet == -1) {
            $trangthaiduyet = 'is not null';
        } else {
            $trangthaiduyet = " = " . (int)$trangthaiduyet;
        }

        if ($trangthaikhoa == -1) {
            $trangthaikhoa = 'is not null';
        } else {
            $trangthaikhoa = " = " . (int)$trangthaikhoa;
        }

        if ($trangthai == -1) {
            $trangthai = 'is not null';
        } else {
            $trangthai = " = " . (int)$trangthai;
        }

        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $title = 'DanhSachPhanCong' . date("d-m-Y H:i:s") . '.xlsx';
        // //Xuất Excel
        return Excel::download(new Admin24_ExportDanhSachPhanCong($hoten, $email, $kiemtra, $trangthaiduyet, $trangthaikhoa, $trangthai, (int)$id_nam), $title);
    }
    function load_trangthai()
    {
        $trangthai = DB::table('24_trangthaihoso')->get();
        return $trangthai;
    }

    // Phân công kiểm tra hồ sơ new
    function phancongkiemtrahoso()
    {
        $url = URL::current();
        $quyen = $this->kiemtraquyen_url($url);
        if ($quyen == 1) {
            return view(
                'user_24.admin24.manage.quanlyhoso.phancongkiemtrahoso',
                [
                    'menu' =>    $this->sidebar(),
                ]
            );
        } else {
            return view('user_24.admin24.include.404');
        }
    }
    public function hoso_danhsach_kiemtra($id_nam)
    {
        $thongtinhoso = DB::select("SELECT 24_kiemtrahoso.id_nhansu as id_nhansu, if(duyet.email is null,'',duyet.email) as email_duyet, 24_trangthaihoso.id_trangthai as id_trangthai,24_trangthaihoso.tentrangthai, 24_trangthaihoso.icon,24_trangthaihoso.class_small, if(nhansu.email is null,'',nhansu.email) as email_nhansu ,24_kiemtrahoso.trangthai,24_kiemtrahoso.id AS id ,24_kiemtrahoso.id_taikhoan ,thisinh.email ,24_thongtincanhan.hoten ,24_thongtincanhan.cccd ,IF(24_khoadangky.trangthai IS NULL, 0,24_khoadangky.trangthai) AS trangthaidangky,24_kiemtrahoso.khoa AS trangthaikhoa,24_kiemtrahoso.duyet AS trangthaiduyet,24_kiemtrahoso.thoigiankhoa as thoigiankhoa ,24_kiemtrahoso.thoigiancapnhat as thoigiancapnhat ,24_kiemtrahoso.thoigianduyet as thoigianduyet FROM 24_kiemtrahoso JOIN (SELECT * FROM account24s) as thisinh ON 24_kiemtrahoso.id_taikhoan = thisinh.id LEFT JOIN (SELECT * FROM 24_accountsadmin) as nhansu ON 24_kiemtrahoso.id_nhansu = nhansu.id LEFT JOIN (SELECT * FROM 24_accountsadmin) as duyet ON 24_kiemtrahoso.id_nhansuduyet = duyet.id INNER JOIN 24_thongtincanhan ON 24_thongtincanhan.id_taikhoan = 24_kiemtrahoso.id_taikhoan LEFT JOIN 24_trangthaihoso ON 24_trangthaihoso.id_trangthai = 24_kiemtrahoso.trangthai LEFT JOIN 24_khoadangky ON 24_khoadangky.id_taikhoan = thisinh.id INNER JOIN (SELECT DISTINCT(id_taikhoan) as id_taikhoan, idnam FROM 24_nguyenvong) AS nguyenvong  ON nguyenvong.id_taikhoan = 24_kiemtrahoso.id_taikhoan WHERE nguyenvong.idnam =  " . (int)$id_nam);
        $json_data['data'] = $thongtinhoso;
        $res = json_encode($json_data);
        return $res;
    }
    function load_trangthai_pckiemtra()
    {
        $trangthai = DB::table('24_trangthaihoso')->get();
        return $trangthai;
    }
    public function ds_canbo_kiemtra()
    {
        // $id_manhinh = 20; //Local
        $id_manhinh = 15; //Sever
        $id_chucnang = 2;
        $ds_canbo = DB::table('24_accountsadmin')
            ->select('24_accountsadmin.id', '24_accountsadmin.name', '24_accountsadmin.email')
            ->join('24_phanquyen', '24_phanquyen.id_nguoidung', '=', '24_accountsadmin.id')
            // ->leftJoin('24_phanquyen_kiemtrahoso', '24_phanquyen_kiemtrahoso.id_admin', '=', '24_phanquyen.id_nguoidung')
            ->where('24_accountsadmin.admin', 1)
            ->where('24_phanquyen.id_manhinh', '=', $id_manhinh)
            ->where('24_phanquyen.id_chucnang', '=', $id_chucnang)
            ->get();
        $json_data['data'] = $ds_canbo;
        $res = json_encode($json_data);
        return $res;
    }
    public function phancong_canbokiemtra(Request $request)
    {
        $ds_canbokiemtra = $request->input('array_canbokiemtra');
        $ds_hoso = $request->input('ds_hoso');
        $time = $request->input('time');
        $id_manhinh = $request->input('id_manhinh');
        $id_chucnang = $request->input('id_chucnang');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        $email_admin = Auth::guard('loginadmin')->user()->email;
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            // kiểm tra nhân sự có quyền duyệt không
            $kiemtracanboduyet = DB::table('24_phanquyen')
                ->select('id_nguoidung')
                // ->where('id_manhinh', 20) //Local
                ->where('id_manhinh', 15) //Sever
                ->where('id_chucnang', $id_chucnang)->get()->toArray();
            $valuesArray = array_column($kiemtracanboduyet, "id_nguoidung");
            $valuesArray1 = array_column($ds_canbokiemtra, "id_canbokiemtra");
            $diff = array_diff($valuesArray1, $valuesArray);
            if (count($diff) > 0) {
                $nguoidungkhongquyen = DB::table('24_accountsadmin')
                    ->where('id', $diff[0])
                    ->first();
                if ($nguoidungkhongquyen) {
                    return 'Người dùng ' . $nguoidungkhongquyen->email . ' chưa được phân quyền';
                } else {
                    return 'Người dùng không tồn tại trong hệ thống';
                }
            } else {
                $data = [];
                $data_lichsu = [];
                $ds_phancong = $this->divideArray($ds_hoso, count($ds_canbokiemtra));
                $result = array_map(null, $ds_canbokiemtra, $ds_phancong);
                for ($i = 0; $i < count($result); $i++) {
                    for ($j = 0; $j < count($result[$i][1]); $j++) {
                        $data_tmp = ([
                            "id_nhansu" => $result[$i][0]['id_canbokiemtra'],
                            "id" => $result[$i][1][$j]['id_hoso'],
                            "khoa" => 0,
                        ]);
                        $data_tmp_lichsu = ([
                            "id_taikhoan" => $result[$i][1][$j]['id_hoso'],
                            "noidung" => $email_admin . " phân công " . $result[$i][0]['email'] . " kiểm tra hồ sơ " . $result[$i][1][$j]['email'],
                            'hienthi'   => 0,
                            'id_nhansu' => $id_admin,
                            'thietbi'   => $user_agent,
                            'ip'        => request()->ip()
                        ]);
                        $data_lichsu[] = $data_tmp_lichsu;
                        $data[] = $data_tmp;
                    }
                }
                DB::table('24_kiemtrahoso')->upsert($data, ['id'], ['id_nhansu', 'khoa']);
                DB::table('24_lichsu')->insert($data_lichsu);
                return 'upd_1';
            }
        } else {
            return 'rol_2';
        }
    }
    function phanquyenkiemtrahoso(Request $request){
        $id_nguoiphancong = Auth::guard('loginadmin')->user()->id;
        $id_admin = $request->input('id_admin');
        $quyen = $request->input('quyen');
        $id_chucnang_hoso = $request->input('id_chucnang_hoso');

        //Kiểm tra quyền
        $time = $request->input('time');
        $id_manhinh = $request->input('id_manhinh');
        $id_chucnang = $request->input('id_chucnang');
        $active = $request->input('active');
        if ($this->kiemtraquyen($id_nguoiphancong, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            switch ($id_chucnang_hoso) {
                case '2':
                    $title = 'khoa';
                    $tenhanhdong = "Khóa hồ sơ";
                    break;
                case '3':
                    $title = 'khoatt';
                    $tenhanhdong = "Khóa trực tiếp hồ sơ";
                    break;
                case '4':
                    $title = 'huy';
                    $tenhanhdong = "Hủy hồ sơ";
                    break;
                default:
                    # code...
                    break;
            }
            DB::beginTransaction();
            try{
                DB::table('24_phanquyen_kiemtrahoso')
                ->updateOrInsert(
                    ['id_admin' => $id_admin],
                    [ $title  => $quyen],
                );
                $quyen == 1 ? $hanhdong = "Phân quyền:" : $hanhdong = "Hủy quyền:";
                $hoten = DB::table('24_accountsadmin')->where('id',$id_admin)->first()->name;
                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                DB::table('24_lichsu')
                ->insert(
                    [
                        'id_taikhoan' => $id_admin,
                        'noidung'   => $hanhdong." ".$tenhanhdong.' của '.$hoten,
                        'hienthi'   => 1,
                        'id_nhansu' => $id_nguoiphancong,
                        'thietbi'   => $user_agent,
                        'ip'        => request()->ip()
                    ]
                );
                DB::commit();
                return 'upd_1';
            }catch(Exception $e){
                DB::rollBack();
                return -100;
            }
        }else{
            return 'rol_2';
        }
    }

    // Phân công duyệt hồ sơ
    function phancongduyethoso()
    {
        $url = URL::current();
        $quyen = $this->kiemtraquyen_url($url);
        if ($quyen == 1) {
            return view(
                'user_24.admin24.manage.quanlyhoso.phancongduyethoso',
                [
                    'menu' =>    $this->sidebar(),
                ]
            );
        } else {
            return view('user_24.admin24.include.404');
        }
    }
    function load_trangthai_pcduyet()
    {
        $trangthai = DB::table('24_trangthaihoso')->get();
        return $trangthai;
    }
    public function hoso_danhsach_duyet($id_nam)
    {
        $thongtinhoso = DB::select("SELECT 24_kiemtrahoso.id_nhansuduyet as id_nhansuduyet, if(duyet.email is null,'',duyet.email) as email_duyet, 24_trangthaihoso.id_trangthai as id_trangthai,24_trangthaihoso.tentrangthai, 24_trangthaihoso.icon,24_trangthaihoso.class_small, if(nhansu.email is null,'',nhansu.email) as email_nhansu ,24_kiemtrahoso.trangthai,24_kiemtrahoso.id AS id ,24_kiemtrahoso.id_taikhoan ,thisinh.email ,24_thongtincanhan.hoten ,24_thongtincanhan.cccd ,IF(24_khoadangky.trangthai IS NULL, 0,24_khoadangky.trangthai) AS trangthaidangky,24_kiemtrahoso.khoa AS trangthaikhoa,24_kiemtrahoso.duyet AS trangthaiduyet,24_kiemtrahoso.thoigiankhoa as thoigiankhoa ,24_kiemtrahoso.thoigiancapnhat as thoigiancapnhat ,24_kiemtrahoso.thoigianduyet as thoigianduyet FROM 24_kiemtrahoso JOIN (SELECT * FROM account24s) as thisinh ON 24_kiemtrahoso.id_taikhoan = thisinh.id LEFT JOIN (SELECT * FROM 24_accountsadmin) as nhansu ON 24_kiemtrahoso.id_nhansu = nhansu.id LEFT JOIN (SELECT * FROM 24_accountsadmin) as duyet ON 24_kiemtrahoso.id_nhansuduyet = duyet.id INNER JOIN 24_thongtincanhan ON 24_thongtincanhan.id_taikhoan = 24_kiemtrahoso.id_taikhoan LEFT JOIN 24_trangthaihoso ON 24_trangthaihoso.id_trangthai = 24_kiemtrahoso.trangthai LEFT JOIN 24_khoadangky ON 24_khoadangky.id_taikhoan = thisinh.id INNER JOIN (SELECT DISTINCT(id_taikhoan) as id_taikhoan, idnam FROM 24_nguyenvong) AS nguyenvong  ON nguyenvong.id_taikhoan = 24_kiemtrahoso.id_taikhoan WHERE nguyenvong.idnam = " . (int)$id_nam);
        $json_data['data'] = $thongtinhoso;
        $res = json_encode($json_data);
        return $res;
    }
    public function ds_canbo_duyet()
    {
        // $id_manhinh = 20; //Local
        $id_manhinh = 15; //Sever
        $id_chucnang = 8;
        $ds_canbo = DB::table('24_accountsadmin')
            ->select('24_accountsadmin.id', '24_accountsadmin.name', '24_accountsadmin.email')
            ->join('24_phanquyen', '24_phanquyen.id_nguoidung', '=', '24_accountsadmin.id')
            ->where('24_accountsadmin.admin', 1)
            ->where('24_phanquyen.id_manhinh', '=', $id_manhinh)
            ->where('24_phanquyen.id_chucnang', '=', $id_chucnang)
            ->get();
        $json_data['data'] = $ds_canbo;
        $res = json_encode($json_data);
        return $res;
    }
    public function phancong_canboduyet(Request $request)
    {
        $ds_canboduyet = $request->input('array_canboduyet');
        $ds_hoso = $request->input('ds_hoso');
        $time = $request->input('time');
        $id_manhinh = $request->input('id_manhinh');
        $id_chucnang = $request->input('id_chucnang');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        $email_admin = Auth::guard('loginadmin')->user()->email;
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            // kiểm tra nhân sự có quyền duyệt không
            $kiemtracanboduyet = DB::table('24_phanquyen')
                ->select('id_nguoidung')
                // ->where('id_manhinh', 20) //Local
                ->where('id_manhinh', 15) //Sever
                ->where('id_chucnang', $id_chucnang)->get()->toArray();
            $valuesArray = array_column($kiemtracanboduyet, "id_nguoidung");
            $valuesArray1 = array_column($ds_canboduyet, "id_canboduyet");
            // $email_canbo = array_column($ds_canboduyet, "email");
            // $valuesArray1 = array_column($ds_canboduyet, "id_canboduyet");
            $diff = array_diff($valuesArray1, $valuesArray);
            if (count($diff) > 0) {
                $nguoidungkhongquyen = DB::table('account24s')
                    ->where('id', $diff[0])
                    ->first();
                if ($nguoidungkhongquyen) {
                    return 'Người dùng ' . $nguoidungkhongquyen->email . ' chưa được phân quyền';
                } else {
                    return 'Người dùng không tồn tại trong hệ thống';
                }
            } else {
                $data = [];
                $data_lichsu = [];
                $ds_phancong = $this->divideArray($ds_hoso, count($ds_canboduyet));
                $result = array_map(null, $ds_canboduyet, $ds_phancong);
                for ($i = 0; $i < count($result); $i++) {
                    for ($j = 0; $j < count($result[$i][1]); $j++) {
                        $data_tmp = ([
                            "id_nhansuduyet" => $result[$i][0]['id_canboduyet'],
                            "id" => $result[$i][1][$j]['id_hoso'],
                            "duyet" => 0,
                        ]);
                        $data_tmp_lichsu = ([
                            "id_taikhoan" => $result[$i][1][$j]['id_hoso'],
                            "noidung" => $email_admin . " phân công " . $result[$i][0]['email'] . " duyệt hồ sơ " . $result[$i][1][$j]['email'],
                            'hienthi'   => 0,
                            'id_nhansu' => $id_admin,
                            'thietbi'   => $user_agent,
                            'ip'        => request()->ip()
                        ]);
                        $data_lichsu[] = $data_tmp_lichsu;
                        $data[] = $data_tmp;
                    }
                }
                DB::table('24_kiemtrahoso')->upsert($data, ['id'], ['id_nhansuduyet', 'duyet']);
                DB::table('24_lichsu')->insert($data_lichsu);
                return 'upd_1';
            }
        } else {
            return 'rol_2';
        }
    }

    //Hồ sơ thí sinh
    public function tracuuthisinh()
    {
        $url = URL::current();
        $quyen = $this->kiemtraquyen_url($url);
        if ($quyen == 1) {
            return view('user_24.admin24.manage.quanlyhoso.tracuuthisinh',
                [
                    'menu' =>    $this->sidebar(),
                ]
            );
        } else {
            return view('user_24.admin24.include.404');
        }
    }
    function loaikiemtrahoso($dotts){
        return array(
            'loaikiemtrahoso' => 2,
            // 'dotts' => 2
        );
    }
    public function kiemtra_danhsachhoso($iddotts)
    {
        $id_admin = (int)Auth::guard('loginadmin')->user()->id;
        $dotts = $iddotts;
        $loaikths = $this->loaikiemtrahoso($dotts)['loaikiemtrahoso'];
        switch ($loaikths) {
            case '1':
                $thongtinhoso =  DB::select('select if(id_nhansuduyet = ?,1,0) as quyenduyet, if(id_nhansu = ?,1,0) as quyenkiemtra, DATE_FORMAT(thoigiancapnhat, "%d/%m/%Y %H:%i:%s") as thoigiancapnhat, DATE_FORMAT(thoigianduyet, "%d/%m/%Y %H:%i:%s") as thoigianduyet,DATE_FORMAT(thoigiankhoa, "%d/%m/%Y %H:%i:%s") as thoigiankhoa,nhansukhoa.email as email_nhansukhoa,24_kiemtrahoso.id_taikhoan as id_taikhoan, 24_kiemtrahoso.khoa as trangthaikhoa,if(24_kiemtrahoso.duyet = 0,0,1) as trangthaiduyet, ROW_NUMBER() OVER() as stt,if(24_kiemtrahoso.id_nhansuduyet = 0,"",nhansuduyet.email) as nguoiduyet, `24_kiemtrahoso`.`trangthai`, `24_kiemtrahoso`.`id` as `id`, `24_kiemtrahoso`.`id_taikhoan`, `account24s`.`email`, `24_thongtincanhan`.`hoten`, `24_thongtincanhan`.`cccd`, `24_thongtincanhan`.`dienthoai` from `24_kiemtrahoso`
                inner join `account24s` on `24_kiemtrahoso`.`id_taikhoan` = `account24s`.`id`
                inner join `24_thongtincanhan` on `24_thongtincanhan`.`id_taikhoan` = `24_kiemtrahoso`.`id_taikhoan`
                left join (SELECT * FROM 24_accountsadmin) as nhansuduyet on `24_kiemtrahoso`.`id_nhansuduyet` = `nhansuduyet`.`id`
                left join (SELECT * FROM 24_accountsadmin) as nhansukhoa on `24_kiemtrahoso`.`id_nhansu` = `nhansukhoa`.`id`
                where 24_kiemtrahoso.`id_nhansu` = ? OR `id_nhansuduyet` = ?',[$id_admin,$id_admin,$id_admin,$id_admin]);
                break;
            case '2':
                $sql = 'select if(id_nhansuduyet = ?,1,0) as quyenduyet, if(id_nhansu = ?,1,0) as quyenkiemtra, DATE_FORMAT(thoigiancapnhat, "%d/%m/%Y %H:%i:%s") as thoigiancapnhat, DATE_FORMAT(thoigianduyet, "%d/%m/%Y %H:%i:%s") as thoigianduyet,DATE_FORMAT(thoigiankhoa, "%d/%m/%Y %H:%i:%s") as thoigiankhoa,nhansukhoa.email as email_nhansukhoa,24_kiemtrahoso.id_taikhoan as id_taikhoan, 24_kiemtrahoso.khoa as trangthaikhoa,if(24_kiemtrahoso.duyet = 0,0,1) as trangthaiduyet, ROW_NUMBER() OVER() as stt,if(24_kiemtrahoso.id_nhansuduyet = 0,"",nhansuduyet.email) as nguoiduyet, `24_kiemtrahoso`.`trangthai`, `24_kiemtrahoso`.`id` as `id`, `24_kiemtrahoso`.`id_taikhoan`, `account24s`.`email`, `24_thongtincanhan`.`hoten`, `24_thongtincanhan`.`cccd`, `24_thongtincanhan`.`dienthoai` from `24_kiemtrahoso`
                inner join `account24s` on `24_kiemtrahoso`.`id_taikhoan` = `account24s`.`id`
                inner join `24_thongtincanhan` on `24_thongtincanhan`.`id_taikhoan` = `24_kiemtrahoso`.`id_taikhoan`
                left join (SELECT * FROM 24_accountsadmin) as nhansuduyet on `24_kiemtrahoso`.`id_nhansuduyet` = `nhansuduyet`.`id`
                left join (SELECT * FROM 24_accountsadmin) as nhansukhoa on `24_kiemtrahoso`.`id_nhansu` = `nhansukhoa`.`id`
                where 24_kiemtrahoso.id_taikhoan in (SELECT id_taikhoan FROM 24_trungtuyen WHERE iddot = ?)';
                $thongtinhoso =  DB::select($sql,[$id_admin,$id_admin,$dotts]);
                break;
            default:
                $thongtinhoso = [];
                break;

        }
        $json_data['data'] = $thongtinhoso;
        $res = json_encode($json_data);
        return $res;
    }
    function tonglephixettuyen($id_taikhoan){
        $total_sotien = DB::table('24_ketquathanhtoan')
        ->where('id_taikhoan', $id_taikhoan)
        ->sum('total_amount');
        return $total_sotien;
    }
    function ghichuxettuyen($id_taikhoan){
        $ghichu = DB::table('24_kiemtrahoso')
        ->select('idghichu','noidungghichu')
        ->where('id_taikhoan', $id_taikhoan)
        ->first();
        return $ghichu;
    }
    public function timkiemthisinh(Request $request)
    {
        // $dotts = $this->motdottuyensinh();
        // $timkiem_email = $request ->input('timkiem_email');
        // $timkiem_cccd = $request ->input('timkiem_cccd');
        // !empty($timkiem_email) ? $email = 'email = "'.$timkiem_email.'"' : $email =  'email IS NOT NULL';
        // !empty($timkiem_cccd) ? $cccd = 'cccd = '.$timkiem_cccd : $cccd = 'cccd IS NOT NULL';
        // $sql = 'SELECT * FROM `account24s` INNER JOIN 24_thongtincanhan ON account24s.id = 24_thongtincanhan.id_taikhoan WHERE '.$cccd.' AND '.$email;
        // $check = DB::select($sql);
        // if(count($check) == 1){
        //     $id_taikhoan =  $check[0]->id_taikhoan;
        // }else{
        //     $id_taikhoan = 0;
        // }
        // $sql = 'SELECT * FROM `account24s` INNER JOIN 24_thongtincanhan ON account24s.id = 24_thongtincanhan.id_taikhoan WHERE '.$cccd.' AND '.$email;
        $id_admin = Auth::guard('loginadmin')->user()->id;
        $id_taikhoan = $request->input('id_taikhoan');
        $dotts = $request->input('dotts');
        $check = DB::table('account24s')
            ->join('24_thongtincanhan', '24_thongtincanhan.id_taikhoan', "account24s.id")
            ->where('account24s.id', $id_taikhoan)->get();
        //Danh sách tỉnh
        $tinh = DB::table('l_province')
            ->select('id', 'name_province as text')
            ->get();
        if ($id_taikhoan != 0) {
            foreach ($tinh as $key => $value) {
                if ($value->id == $check[0]->noisinh) {
                    $value->selected = "selected";
                }
            }
        } else {
            $tinh_0 = new Collection(
                [
                    'id' => 0,
                    'text' => 'Chọn Tỉnh',
                    'selected' => "selected",
                ]
            );
            $tinh[] =  $tinh_0;
        }

        // //Danh sách tỉnh và trường lớp 10
        $tinh10 = DB::table('l_province')
            ->select('id', 'name_province as text')
            ->get();
        if ($id_taikhoan != 0) {
            $thongtinlop10 = DB::table('24_truongthpt')
                ->where('id_taikhoan', $check[0]->id_taikhoan)
                ->where('id_lop', 10)
                ->get();
            if (count($thongtinlop10) > 0) {
                foreach ($tinh10 as $key => $value) {
                    if ($value->id == $thongtinlop10[0]->id_tinh) {
                        $value->selected = "selected";
                    }
                }
                $truongthpt10 = DB::table('l_school')
                    ->select('id', 'name_school as text')
                    ->where('id_province', $thongtinlop10[0]->id_tinh)->get();

                foreach ($truongthpt10 as $key => $value) {
                    if ($value->id == $thongtinlop10[0]->id_truong) {
                        $value->selected = "selected";
                    }
                }
                $area_school = DB::table('l_school')
                    ->select('priority_area_school')
                    ->where('id', $thongtinlop10[0]->id_truong)
                    ->first();
                $name_khuvuc = DB::table('l_priority_area')
                    ->select('id_priority_area')
                    ->where('id', $area_school->priority_area_school)
                    ->first();
                $khuvuc10 = $name_khuvuc->id_priority_area;
            } else {
                $tinh_0 = new Collection(
                    [
                        'id' => 0,
                        'text' => 'Chọn Tỉnh',
                        'selected' => "selected",
                    ]
                );
                $tinh10[] =  $tinh_0;
                $truongthpt10 = "";
                $khuvuc10 = "Không";
            }
        } else {
            $tinh_0 = new Collection(
                [
                    'id' => 0,
                    'text' => 'Chọn Tỉnh',
                    'selected' => "selected",
                ]
            );
            $tinh10[] =  $tinh_0;
            $truongthpt10 = '';
            $khuvuc10 = "Không";
        }
        // //Danh sách tỉnh và trường lớp 11
        $tinh11 = DB::table('l_province')
            ->select('id', 'name_province as text')
            ->get();
        if ($id_taikhoan != 0) {
            $thongtinlop11 = DB::table('24_truongthpt')
                ->where('id_taikhoan', $check[0]->id_taikhoan)
                ->where('id_lop', 11)
                ->get();
            if (count($thongtinlop11) > 0) {
                foreach ($tinh11 as $key => $value) {
                    if ($value->id == $thongtinlop11[0]->id_tinh) {
                        $value->selected = "selected";
                    }
                }
                $truongthpt11 = DB::table('l_school')
                    ->select('id', 'name_school as text')
                    ->where('id_province', $thongtinlop11[0]->id_tinh)->get();

                foreach ($truongthpt11 as $key => $value) {
                    if ($value->id == $thongtinlop11[0]->id_truong) {
                        $value->selected = "selected";
                    }
                }
                $area_school = DB::table('l_school')
                    ->select('priority_area_school')
                    ->where('id', $thongtinlop11[0]->id_truong)
                    ->first();
                $name_khuvuc = DB::table('l_priority_area')
                    ->select('id_priority_area')
                    ->where('id', $area_school->priority_area_school)
                    ->first();
                $khuvuc11 = $name_khuvuc->id_priority_area;
            } else {
                $tinh_0 = new Collection(
                    [
                        'id' => 0,
                        'text' => 'Chọn Tỉnh',
                        'selected' => "selected",
                    ]
                );
                $tinh11[] =  $tinh_0;
                $truongthpt11 = "";
                $khuvuc11 = "Không";
            }
        } else {
            $tinh_0 = new Collection(
                [
                    'id' => 0,
                    'text' => 'Chọn Tỉnh',
                    'selected' => "selected",
                ]
            );
            $tinh11[] =  $tinh_0;
            $truongthpt11 = '';
            $khuvuc11 = "Không";
        }

        $tinh12 = DB::table('l_province')
            ->select('id', 'name_province as text')
            ->get();
        if ($id_taikhoan != 0) {
            $thongtinlop12 = DB::table('24_truongthpt')
                ->where('id_taikhoan', $check[0]->id_taikhoan)
                ->where('id_lop', 12)
                ->get();
            if (count($thongtinlop12) > 0) {
                foreach ($tinh12 as $key => $value) {
                    if ($value->id == $thongtinlop12[0]->id_tinh) {
                        $value->selected = "selected";
                    }
                }
                $truongthpt12 = DB::table('l_school')
                    ->select('id', 'name_school as text')
                    ->where('id_province', $thongtinlop12[0]->id_tinh)->get();
                foreach ($truongthpt12 as $key => $value) {
                    if ($value->id == $thongtinlop12[0]->id_truong) {
                        $value->selected = "selected";
                    }
                }
                $area_school = DB::table('l_school')
                    ->select('priority_area_school')
                    ->where('id', $thongtinlop12[0]->id_truong)
                    ->first();
                $name_khuvuc = DB::table('l_priority_area')
                    ->select('id_priority_area')
                    ->where('id', $area_school->priority_area_school)
                    ->first();
                $khuvuc12 = $name_khuvuc->id_priority_area;
            } else {
                $tinh_0 = new Collection(
                    [
                        'id' => 0,
                        'text' => 'Chọn Tỉnh',
                        'selected' => "selected",
                    ]
                );
                $tinh12[] =  $tinh_0;
                $truongthpt12 = "";
                $khuvuc12 = "Không";
            }
        } else {
            $tinh_0 = new Collection(
                [
                    'id' => 0,
                    'text' => 'Chọn Tỉnh',
                    'selected' => "selected",
                ]
            );
            $tinh12[] =  $tinh_0;
            $truongthpt12 = '';
            $khuvuc12 = "Không";
        }

        // Nguyện vọng
        if ($id_taikhoan != 0) {
            $songuyenvong = DB::table('24_nguyenvong')
                ->where('id_taikhoan', $check[0]->id_taikhoan)
                ->count();
            //Diem lop 10
        } else {
            $songuyenvong = '';
        }

        //Diem lop 10
        if ($id_taikhoan != 0) {
            $diems10 = DB::table('24_ketquahoctap')
                ->select('24_ketquahoctap.id', 'l_subject.name_subject', 'mark_result', '24_ketquahoctap.id_subject', '24_ketquahoctap.id_semester_result')
                ->join('l_subject', 'l_subject.id', '24_ketquahoctap.id_subject')
                ->where(
                    [
                        'id_student_result' => $check[0]->id_taikhoan,
                        'id_class_result' => 10,
                    ]
                )->get();

            $mons10 = DB::table('l_subject')
                ->select('id', 'name_subject')
                ->where('id_type_subject', 1)
                ->get();

            foreach ($mons10 as $mon) {
                $mon->diem10_1 = 0;
                $mon->diem10_2 = 0;
                $mon->diem10_CN = 0;
            }
            foreach ($mons10 as $mon) {
                foreach ($diems10 as $diem) {
                    if ($mon->id == $diem->id_subject && $diem->id_semester_result == 1) {
                        $mon->diem10_1 = $diem->mark_result;
                    }

                    if ($mon->id == $diem->id_subject && $diem->id_semester_result == 2) {
                        $mon->diem10_2 = $diem->mark_result;
                    }
                    if ($mon->id == $diem->id_subject && $diem->id_semester_result == 'CN') {
                        $mon->diem10_CN = $diem->mark_result;
                    }
                }
            }
        } else {
            $mons10 = DB::table('l_subject')
                ->select('id', 'name_subject')
                ->where('id_type_subject', 1)
                ->get();
            foreach ($mons10 as $mon) {
                $mon->diem10_1 = 0;
                $mon->diem10_2 = 0;
                $mon->diem10_CN = 0;
            }
        }
        //Lop 11
        if ($id_taikhoan != 0) {
            $diems11 = DB::table('24_ketquahoctap')
                ->select('24_ketquahoctap.id', 'l_subject.name_subject', 'mark_result', '24_ketquahoctap.id_subject', '24_ketquahoctap.id_semester_result')
                ->join('l_subject', 'l_subject.id', '24_ketquahoctap.id_subject')
                ->where(
                    [
                        'id_student_result' => $check[0]->id_taikhoan,
                        'id_class_result' => 11,
                    ]
                )->get();

            $mons11 = DB::table('l_subject')
                ->select('id', 'name_subject')
                ->where('id_type_subject', 1)
                ->get();

            foreach ($mons11 as $mon) {
                $mon->diem10_1 = 0;
                $mon->diem10_2 = 0;
                $mon->diem10_CN = 0;
            }

            foreach ($mons11 as $mon) {
                foreach ($diems11 as $diem) {
                    if ($mon->id == $diem->id_subject && $diem->id_semester_result == 1) {
                        $mon->diem10_1 = $diem->mark_result;
                    }

                    if ($mon->id == $diem->id_subject && $diem->id_semester_result == 2) {
                        $mon->diem10_2 = $diem->mark_result;
                    }
                    if ($mon->id == $diem->id_subject && $diem->id_semester_result == 'CN') {
                        $mon->diem10_CN = $diem->mark_result;
                    }
                }
            }
        } else {
            $mons11 = DB::table('l_subject')
                ->select('id', 'name_subject')
                ->where('id_type_subject', 1)
                ->get();
            foreach ($mons11 as $mon) {
                $mon->diem10_1 = 0;
                $mon->diem10_2 = 0;
                $mon->diem10_CN = 0;
            }
        }
        //Lop 12
        if ($id_taikhoan != 0) {
            $diems12 = DB::table('24_ketquahoctap')
                ->select('24_ketquahoctap.id', 'l_subject.name_subject', 'mark_result', '24_ketquahoctap.id_subject', '24_ketquahoctap.id_semester_result')
                ->join('l_subject', 'l_subject.id', '24_ketquahoctap.id_subject')
                ->where(
                    [
                        'id_student_result' => $check[0]->id_taikhoan,
                        'id_class_result' => 12,
                    ]
                )->get();

            $mons12 = DB::table('l_subject')
                ->select('id', 'name_subject')
                ->where('id_type_subject', 1)
                ->get();

            foreach ($mons12 as $mon) {
                $mon->diem10_1 = 0;
                $mon->diem10_2 = 0;
                $mon->diem10_CN = 0;
            }

            foreach ($mons12 as $mon) {
                foreach ($diems12 as $diem) {
                    if ($mon->id == $diem->id_subject && $diem->id_semester_result == 1) {
                        $mon->diem10_1 = $diem->mark_result;
                    }

                    if ($mon->id == $diem->id_subject && $diem->id_semester_result == 2) {
                        $mon->diem10_2 = $diem->mark_result;
                    }
                    if ($mon->id == $diem->id_subject && $diem->id_semester_result == 'CN') {
                        $mon->diem10_CN = $diem->mark_result;
                    }
                }
            }
        } else {
            $mons12 = DB::table('l_subject')
                ->select('id', 'name_subject')
                ->where('id_type_subject', 1)
                ->get();
            foreach ($mons12 as $mon) {
                $mon->diem10_1 = 0;
                $mon->diem10_2 = 0;
                $mon->diem10_CN = 0;
            }
        }

          //THPT
          if ($id_taikhoan != 0) {
            $diemsthpt = DB::table('24_ketquahoctap')
                ->select('24_ketquahoctap.id', 'l_subject.name_subject', 'mark_result', '24_ketquahoctap.id_subject', '24_ketquahoctap.id_semester_result')
                ->join('l_subject', 'l_subject.id', '24_ketquahoctap.id_subject')
                ->where(
                    [
                        'id_student_result' => $check[0]->id_taikhoan,
                        'id_class_result' => "TN",
                    ]
                )->get();

            $monsthpt = DB::table('l_subject')
                ->select('id', 'name_subject')
                ->where('id_type_subject', 1)
                ->get();

            foreach ($monsthpt as $mon) {
                $mon->diemthpt = 0;
            }

            foreach ($monsthpt as $mon) {
                foreach ($diemsthpt as $diem) {
                    if ($mon->id == $diem->id_subject && $diem->id_semester_result == 'PT') {
                        $mon->diemthpt = $diem->mark_result;
                    }
                }
            }
        } else {
            $monsthpt = DB::table('l_subject')
                ->select('id', 'name_subject')
                ->where('id_type_subject', 1)
                ->get();
            foreach ($mons12 as $mon) {
                $mon->diemthpt = 0;
            }
        }
        //Nguyên vọng
        if ($id_taikhoan != 0) {
            $nguyenvongs = DB::table('24_nguyenvong')
                ->select(
                    '24_nguyenvong.thutu as thutu',
                    '24_nguyenvong.id_taikhoan',
                    '24_chuyennganh.tenchuyennganh',
                    '24_nguyenvong.diemtohop',
                    '24_nguyenvong.diemuutien',
                    '24_nguyenvong.diemxettuyen',
                    '24_nguyenvong.id',
                    '24_nguyenvong.id_chuyennganh',
                    DB::raw('if(24_trungtuyen.idnv is null,"Trượt","Đạt") as ketqua'),
                    DB::raw('if(24_nguyenvong.idphuongthuc = 1, "HB","THPT") as phuongthuc'),
                    'id_group as tohop'
                )
                ->join('24_chuyennganh', '24_nguyenvong.id_chuyennganh', '=', '24_chuyennganh.id')
                ->join('l_group', 'l_group.id', '=', '24_nguyenvong.tohop')
                ->leftJoin('24_trungtuyen', function ($join) use ($dotts) {
                    $join->on('24_nguyenvong.id', '=', '24_trungtuyen.idnv')
                         ->where('24_trungtuyen.iddot', '=', $dotts); // Điều kiện WHERE 24_trungtuyen.iddot = 2
                })
                ->where('24_nguyenvong.id_taikhoan', $check[0]->id_taikhoan)
                ->where('24_nguyenvong.iddot', $dotts)
                ->orderBy('24_nguyenvong.thutu')
                ->get();
            $stt = 1;
            if (!empty($nguyenvongs)) {
                foreach ($nguyenvongs as $nguyenvong) {
                    $nguyenvong->stt = $stt;
                    $stt++;
                }
            } else {
                foreach ($nguyenvongs as $nguyenvong) {
                    $nguyenvong->STT = 1;
                    $nguyenvong->id_taikhoan = 0;
                    $nguyenvong->diemtohop = 0;
                    $nguyenvong->diem = 0;
                    $nguyenvong->id = 0;
                    $nguyenvong->id_chuyennganh = 0;
                }
            }
            $nguyenvong_all = DB::table('24_chuyennganh')
                ->select('id', 'tenchuyennganh')
                ->get();
        } else {
            $nguyenvongs = '';
            $nguyenvong_all = '';
        }

        //Đối tượng
        $doituong = DB::table('l_policy_users')
            ->select('id', 'name_policy_user as text')
            ->get();
        if ($id_taikhoan != 0) {
            $id_doituong = DB::table('24_doituonguutien')
                ->select('id_doituong')
                ->where('id_taikhoan', $check[0]->id_taikhoan)
                ->where('dotts', $dotts)
                ->get();
            if (count($id_doituong) > 0) {
                $doituong_0 = new Collection(
                    [
                        'id' => 0,
                        'text' => 'Chọn Đối Tượng',
                        'selected' => "",
                    ]
                );
                foreach ($doituong as $key => $value) {
                    if ($value->id == $id_doituong[0]->id_doituong) {
                        $value->selected = "selected";
                    }
                }
                $doituong[] = $doituong_0;
            } else {
                $doituong_0 = new Collection(
                    [
                        'id' => 0,
                        'text' => 'Chọn Đối Tượng',
                        'selected' => "selected",
                    ]
                );
                $doituong[] = $doituong_0;
            }
        }

        if ($id_taikhoan != 0) {
            $image = DB::table('24_image')
                ->where('id_taikhoan', $check[0]->id_taikhoan)
                ->get();
        } else {
            $image = "";
        }
        if ($id_taikhoan != 0) {
            $results = DB::table('24_khuvucuutien')
            ->join('l_priority_area', 'l_priority_area.id', '=', '24_khuvucuutien.khuvucuutien')
            ->where('dotts',$dotts)
            ->where('id_taikhoan',$id_taikhoan)
            ->first();
            if($results){
                $khuvuc = $results->id_priority_area;
            }else{
                $khuvuc = 'Không';
            }
        //     $results = DB::table('24_truongthpt')
        //         ->join('l_school', 'l_school.id', '=', '24_truongthpt.id_truong')
        //         ->join('l_priority_area', 'l_priority_area.id', '=', 'l_school.priority_area_school')
        //         ->select('l_school.priority_area_school', 'l_priority_area.mark_priority', 'l_priority_area.num_priority_area', DB::raw('COUNT(*) as total_count'))
        //         ->where('24_truongthpt.id_taikhoan', $check[0]->id_taikhoan)
        //         ->groupBy('l_school.priority_area_school', 'l_priority_area.mark_priority', 'l_priority_area.num_priority_area')
        //         ->orderBy('l_priority_area.num_priority_area')
        //         ->orderBy('total_count')
        //         ->get();

        //     if (count($results) == 3) {
        //         $name_khuvuc = DB::table('l_priority_area')
        //             ->select('id_priority_area')
        //             ->where('id', $results[0]->priority_area_school)
        //             ->first();
        //         $khuvuc = $name_khuvuc->id_priority_area;
        //     } elseif (count($results) > 0) {
        //         $max = -1;
        //         foreach ($results as $r) {
        //             $res = (int) $r->total_count;
        //             if ($max < $res) {
        //                 $kv = $r->priority_area_school;
        //                 $max = $r->total_count;
        //             }
        //         }
        //         $name_khuvuc = DB::table('l_priority_area')
        //             ->select('id_priority_area')
        //             ->where('id', $kv)
        //             ->first();
        //         $khuvuc = $name_khuvuc->id_priority_area;
        //     } else {
        //         $khuvuc = "Không";
        //     }
        // } else {
        //     $khuvuc = "Không";
        }else {
            $khuvuc = "Không";
        }

        if ($id_taikhoan != 0) {
            $nam = DB::table('24_namtotnghiep')
                ->select('namtotnghiep')
                ->where('id_taikhoan', $id_taikhoan)
                ->first();
            if ($nam) {
                $namtn = $nam->namtotnghiep;
            } else {
                $namtn = '';
            }
        } else {
            $namtn = '';
        }
        $history = DB::table('24_lichsu')
        ->selectRaw('account24s.name as namethisinh, account24s.img_gg, 24_lichsu.noidung, DATE_FORMAT(24_lichsu.create_at, "%d/%m/%Y %H:%i") as create_at, 24_accountsadmin.name as ten_nhansu, 24_lichsu.id_nhansu as id_nhansu')
        ->where('id_taikhoan', $id_taikhoan)
        // ->where('hienthi', 1)
        ->orderBy('24_lichsu.create_at', 'DESC')
        ->leftJoin('24_accountsadmin', '24_accountsadmin.id', '24_lichsu.id_nhansu')
        ->leftJoin('account24s', 'account24s.id', '24_lichsu.id_taikhoan')
        ->get();


        $checkmapheu = DB::table('24_maphieu')->where('id_taikhoan',$id_taikhoan)->where('dotts',$dotts)->first();
        if($checkmapheu){
            $maphieu = $checkmapheu->maphieu;
        }else{
            $maphieu = "";
        }



        $res = array(
            'namtn' => $namtn,
            'image' => $image,
            'khuvuc' => $khuvuc,
            'khuvuc10' => $khuvuc10,
            'khuvuc11' => $khuvuc11,
            'khuvuc12' => $khuvuc12,
            'doituong' => $doituong,
            'tinh' => $tinh,
            'tinh10' => $tinh10,
            'truongthpt10' => $truongthpt10,
            'tinh11' => $tinh11,
            'truongthpt11' => $truongthpt11,
            'tinh12' => $tinh12,
            'truongthpt12' => $truongthpt12,
            'songuyenvong' => $songuyenvong,
            'mons10' => $mons10,
            'mons11' => $mons11,
            'mons12' => $mons12,
            'monsthpt' => $monsthpt,
            'nguyenvong_all' => $nguyenvong_all,
            'nguyenvongs' => $nguyenvongs,
            'id_taikhoan' => $id_taikhoan,
            'thongtinthisinh' => $check,
            'khoahoso' => $this->checkkhoahoso($id_taikhoan),
            'duyethoso' => $this->checkduyet($id_taikhoan),
            'maphieu' => $maphieu,
            'ghichuxettuyen' => $this->ghichuxettuyen($id_taikhoan),
            // 'huyhoso' => $this->kiemtratrangthaihuy($id_taikhoan),
            'lichsu' => $history,
        );
        return  $res;
    }
    function change_tinh10($idtinh, Request $request)
    {
        $truongthpt10 = DB::table('l_school')
            ->select('id', 'name_school as text')
            ->where('id_province', $idtinh)->get();
        $truong = new Collection(
            [
                'id' => 0,
                'text' => 'Chọn Trường',
                'selected' => "selected",
            ]
        );
        $truongthpt10[] = $truong;
        return  $truongthpt10;
        // }
    }
    function change_tinh11($idtinh)
    {
        $truongthpt11 = DB::table('l_school')
            ->select('id', 'name_school as text')
            ->where('id_province', $idtinh)->get();
        $truong = new Collection(
            [
                'id' => 0,
                'text' => 'Chọn Trường',
                'selected' => "selected",
            ]
        );
        $truongthpt11[] = $truong;
        return  $truongthpt11;
    }
    function change_tinh12($idtinh)
    {
        $truongthpt12 = DB::table('l_school')
            ->select('id', 'name_school as text')
            ->where('id_province', $idtinh)->get();
        $truong = new Collection(
            [
                'id' => 0,
                'text' => 'Chọn Trường',
                'selected' => "selected",
            ]
        );
        $truongthpt12[] = $truong;
        return  $truongthpt12;
    }
    function kiemtraphanconghoso($dotts,$id_admin,$id_taikhoan){
        $loadkiemtra = $this->loaikiemtrahoso($dotts)['loaikiemtrahoso'];
        switch ($loadkiemtra) {
            case '2':
                $check = 1;
                break;
            case '1':
                $quyenkiemtra = DB::table('24_kiemtrahoso')->where('id_taikhoan',$id_taikhoan)->first()->id_nhansu;
                $quyenkiemtra == $id_admin ? $check = 1 : $check = 0;
                break;
            default:
                $check = 0;
                break;
        }
        return $check;
    }
    function capnhatthongtincanhan(Request $request)
    {
        $time = $request->input('time');
        $id_manhinh = $request->input('id_manhinh');
        $id_chucnang = $request->input('id_chucnang');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        $id_taikhoan = $request->input('id_taikhoan');
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            $dotts = $request->input('dotts');
            // $check= $this->kiemtraphanconghoso($dotts,$id_admin,$id_taikhoan);
            // if( $check == 1){
                if ($this->checkkhoahoso($id_taikhoan) == 0) {
                    $id = $request->input('id');
                    $val = $request->input('val');
                    $table = $request->input('table');
                    $id_admin = Auth::guard('loginadmin')->user()->id;
                    $user_agent = $_SERVER['HTTP_USER_AGENT'];
                    $dem = 0;

                    // return $data['cccd'];
                    if ($id == 'cccd') {
                        $check_cmnds = DB::table('24_thongtincanhan')
                            ->where('id_taikhoan', '<>', $id)
                            ->get();
                        foreach ($check_cmnds as $key => $check_cmnd) {
                            if ($check_cmnd->cccd == $val) {
                                $dem++;
                            }
                        }
                    }
                    if ($dem > 0) {
                        $thongbao = 'cmnd_0';
                        $noidung = '';
                        $maloi = 0;
                    } else {
                        switch ($table) {
                            case '24_thongtincanhan':
                                $where = 'id_taikhoan';
                                break;
                            case 'account24s':
                                $where = 'id';
                                break;
                            case '24_kiemtrahoso':
                                $where = 'id_taikhoan';
                                break;
                            default:
                                # code...
                                break;
                        }
                        switch ($id) {
                            case 'hoten':
                                $validator = Validator::make(
                                    $request->all(),
                                    [
                                        'val' => 'required|string|regex:/^[\pL\s]+$/u|max:255',
                                    ],
                                    [
                                        'val.required' => 'Họ tên không được rỗng.',
                                        'val.string' => 'Họ tên phải là một chuỗi ký tự.',
                                        'val.regex' => 'Họ tên chỉ được chứa các ký tự chữ cái và khoảng trắng.',
                                        'val.max' => 'Họ tên không được vượt quá 255 ký tự.',
                                    ]
                                );
                                break;
                            case 'ngaysinh':
                                $validator = Validator::make(
                                    $request->all(),
                                    [
                                        'val' => 'required|date|before_or_equal:today',
                                    ],
                                    [
                                        'val.required' => 'Ngày sinh không được rỗng.',
                                        'val.date' => 'Ngày sinh phải là một ngày hợp lệ.',
                                        'val.before_or_equal' => 'Ngày sinh không được lớn hơn ngày hiện tại.',

                                    ]
                                );
                                break;
                            case 'noisinh':
                                $validator = Validator::make(
                                    $request->all(),
                                    [
                                        'val' => 'integer|min:1',
                                    ],
                                    [
                                        'val.integer' => 'Hãy chọn nơi sinh.',
                                        'val.min' => 'Hãy chọn nơi sinh.',
                                    ]
                                );
                                break;
                            case 'cccd':
                                $validator = Validator::make(
                                    $request->all(),
                                    [
                                        'val' => 'required|digits_between:9,12',

                                    ],
                                    [
                                        'val.required' => 'CCCD/CMND không được rỗng.',
                                        'val.digits_between' => 'CCCD/CMND phải có 9 hoặc 12 chữ số.',
                                    ]
                                );
                                break;
                            case 'email':
                                $validator = Validator::make(
                                    $request->all(),
                                    [
                                        'val' => 'required|email',
                                    ],
                                    [
                                        'val.required' => 'Email không được rỗng.',
                                        'val.email' => 'Email phải là một địa chỉ email hợp lệ.',
                                    ]
                                );
                                break;
                            case 'email_phu':
                                $validator = Validator::make(
                                    $request->all(),
                                    [
                                        'val' => 'email',
                                    ],
                                    [
                                        'val.email' => 'Email phải là một địa chỉ email hợp lệ.',
                                    ]
                                );
                                break;
                            case 'dienthoai';
                                $validator = Validator::make(
                                    $request->all(),
                                    [
                                        'val' => 'required|numeric|regex:/^([0-9\s\-\+\(\)]{10})$/|min:10',
                                    ],
                                    [
                                        'val.required' => 'Số điện thoại không được rỗng.',
                                        'val.numeric' => 'Số điện thoại phải là số.',
                                        'val.regex' => 'Số điện thoại không hợp lệ.',
                                        'val.min' => 'Số điện thoại phải có ít nhất 10 chữ số.',
                                    ]
                                );
                                break;
                            case 'dienthoai_phu';
                                $validator = Validator::make(
                                    $request->all(),
                                    [
                                        'val' => 'numeric|regex:/^([0-9\s\-\+\(\)]{10})$/|min:10',
                                    ],
                                    [
                                        'val.numeric' => 'Số điện thoại phải là số.',
                                        'val.regex' => 'Số điện thoại không hợp lệ.',
                                        'val.min' => 'Số điện thoại phải có ít nhất 10 chữ số.',
                                    ]
                                );
                                break;
                            case 'diachi':
                                $validator = Validator::make(
                                    $request->all(),
                                    [
                                        'val' => 'required|string|max:255',
                                    ],
                                    [
                                        'val.required' => 'Địa chỉ không được rỗng.',
                                        'val.string' => 'Địa chỉ phải là một chuỗi ký tự.',

                                        'val.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
                                    ]
                                );
                                break;
                            case 'gioitinh':
                                $validator = Validator::make(
                                    $request->all(),
                                    [
                                        'val' => 'required|integer|in:0,1',
                                    ],
                                    [
                                        'val.required' => 'Giới tính không được rỗng.',
                                        'val.integer' => 'Giới tính phải là một số nguyên.',
                                        'val.in' => 'Giới tính chỉ có thể là 0 hoặc 1.',
                                    ]
                                );
                                break;
                            case 'idghichu':
                                $validator = Validator::make(
                                    $request->all(),
                                    [
                                        'val' => 'required|integer|in:0,1',
                                    ],
                                    [
                                        'val.required' => 'Trạng thái không được rỗng.',
                                        'val.integer' => 'Trạng thái phải là một số nguyên.',
                                        'val.in' => 'Trạng thái chỉ có thể là 0 hoặc 1.',
                                    ]
                                );
                                break;
                            default:
                                $validator = Validator::make(
                                    $request->all(),
                                [
                                    'val' => 'nullable',
                                ],
                                [

                                ]
                            );
                                break;
                        }
                        if ($validator->fails()) {
                            $noidung = response()->json($validator->errors());
                            $maloi = 'validate';
                            $thongbao = "";
                        } else {
                            DB::beginTransaction();
                            try {
                                DB::table($table)
                                    ->where($where, $id_taikhoan)
                                    ->update([
                                        $id => $val,
                                    ]);
                                switch ($id) {
                                    case 'gioitinh':
                                        $val == 0 ? $thongtin = "Nam" : $thongtin = "Nu";
                                        break;
                                    case 'idghichu':
                                        $val == 1 ? $thongtin = "Không đủ điều kiện xét tuyển" : $thongtin = "Hủy không đủ ĐKXT";
                                        break;
                                    case 'noisinh':
                                        $tinh = DB::table('l_province')
                                            ->select('name_province')
                                            ->where('id', $val)
                                            ->first();
                                        $thongtin = $tinh->name_province;
                                        break;
                                    default:
                                        $thongtin = $val;
                                        break;
                                }
                                DB::table('24_lichsu')
                                    ->insert(
                                        [
                                            'id_taikhoan' => $id_taikhoan,
                                            'noidung'   => "Cập nhật thông tin: " . $id . "-" . $thongtin,
                                            'hienthi'   => 0,
                                            'id_nhansu' => $id_admin,
                                            'thietbi'   => $user_agent,
                                            'ip'        => request()->ip()
                                        ]
                                    );
                                DB::commit();
                                $noidung = '';
                                $maloi = 0;
                                $thongbao = 'upd_1';
                            } catch (Exception $e) {
                                DB::rollBack();
                                $noidung = '';
                                $maloi = 0;
                                $thongbao = 'upd_0';
                            }
                        }
                    }
                } else {
                    $noidung = '';
                    $maloi = 0;
                    $thongbao = 'khoa_1';
                }
            // }else{
            //     $noidung = '';
            //     $maloi = 0;
            //     $thongbao = 'rol_4';
            // }
        } else {
            $noidung = '';
            $maloi = 0;
            $thongbao = 'rol_2';
        }
        return array(
            'noidung' => $noidung,
            'maloi' => $maloi,
            'thongbao' => $thongbao,
        );
    }
    function capnhatnamtn(Request $request)
    {
        $id_taikhoan = $request->input('id_taikhoan');
        $val = $request->input('val');
        $namtn = Carbon::now()->year;
        // heck quyền
        $time = $request->input('time');
        $id_manhinh = $request->input('id_manhinh');
        $id_chucnang = $request->input('id_chucnang');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            $dotts = $request->input('dotts');
            // $dotts = $this->motdottuyensinh();
            // $check=$this->kiemtraphanconghoso($dotts,$id_admin,$id_taikhoan);
            // if( $check == 1){
                if ($this->checkkhoahoso($id_taikhoan) == 0) {
                    $validator = Validator::make(
                        $request->all(),
                        [
                            'val' => 'required|numeric|integer|min:0|max:' . $namtn,

                        ],
                        [

                            'val.required' => 'Năm tốt nghiệp không được rỗng.',
                            'val.numeric' => 'Năm nhập vào phải là số.',
                            'val.integer' => 'Năm không phải là số thập phân.',
                            'val.min' => 'Năm phải lớn hơn hoặc bằng 0.',
                            'val.max' => 'Năm phải nhỏ hơn hoặc bằng ' . $namtn . '.',

                        ]
                    );
                    if ($validator->fails()) {
                        $noidung = response()->json($validator->errors());
                        $maloi = 'validate';
                        $thongbao = "";
                    } else {
                        DB::beginTransaction();
                        try {
                            $namtnnghiep = DB::table('24_namtotnghiep')
                                ->where('id_taikhoan', $id_taikhoan)
                                ->update([
                                    'namtotnghiep' => $val
                                ]);
                            $this->tinhdiemxettuyentheokhoangthisinh($id_taikhoan,$id_taikhoan,$dotts);
                        //    $this->tinhdiemtheonganh($id_taikhoan);
                            $user_agent = $_SERVER['HTTP_USER_AGENT'];
                            DB::table('24_lichsu')
                                ->insert(
                                    [
                                        'id_taikhoan' => $id_taikhoan,
                                        'noidung'   => "Cập nhật năm tôt nghiệp: " . $val,
                                        'hienthi'   => 0,
                                        'id_nhansu' => $id_admin,
                                        'thietbi'   => $user_agent,
                                        'ip'        => request()->ip()
                                    ]
                                );
                            DB::commit();
                            $res = array(
                                'thongbao' => 'upd_1',
                                // 'nganh' => $nganhall['nganh'],
                                // 'all_tohop' => $nganhall['all_tohop'],
                                // 'chuyennganhs' => $nganhall['chuyennganhs'],
                                // 'nguyenvongs' => $nganhall['nguyenvongs'],
                                // 'nguyenvong_all' => $nganhall['nguyenvong_all'],

                            );
                            $noidung = $res;
                            $maloi = 0;
                            $thongbao = 'upd_1';
                        } catch (Exception $e) {
                            DB::rollBack();
                            $noidung = "";
                            $maloi = 0;
                            $thongbao = 'upd_0';
                        }
                    }
                } else {
                    $noidung = "";
                    $maloi = 0;
                    $thongbao = 'khoa_1';
                }
            // }else{
            //     $noidung = '';
            //     $maloi = 0;
            //     $thongbao = 'rol_4';
            // }
        } else {
            $noidung = '';
            $maloi = 0;
            $thongbao = 'rol_2';
        }
        return array(
            'noidung' => $noidung,
            'maloi' => $maloi,
            'thongbao' => $thongbao,
        );
    }
    function capnhattruonglop1(Request $request)
    {
        $time = $request->input('time');
        $id_manhinh = $request->input('id_manhinh');
        $id_chucnang = $request->input('id_chucnang');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        $id_taikhoan = $request->input('id_taikhoan');
        $dotts = $request->input('dotts');

        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            // $dotts = $this->motdottuyensinh();
            // $check=$this->kiemtraphanconghoso($dotts,$id_admin,$id_taikhoan);
            // if( $check == 1){
                if ($this->checkkhoahoso($id_taikhoan) == 0) {
                    $id_lop = $request->input('id');
                    $val = $request->input('val');
                    $table = $request->input('table');
                    $id_tinh = $request->input('id_tinh');
                    $validator = Validator::make(
                        $request->all(),
                        [
                            'val' => 'integer|min:1',
                        ],
                        [
                            'val.integer' => 'Hãy chọn trường.',
                            'val.min' => 'Hãy chọn trường.',
                        ]
                    );
                    if ($validator->fails()) {
                        $noidung = response()->json($validator->errors());
                        $maloi = 'validate';
                        $thongbao = "";
                    } else {
                        // DB::beginTransaction();
                        // try{
                        DB::table($table)
                            ->updateOrInsert(
                                [
                                    'id_taikhoan' => $id_taikhoan,
                                    'id_lop' => $id_lop,
                                ],
                                [
                                    'id_tinh' => $id_tinh,
                                    'id_truong' => $val,
                                ]
                            );

                        $truong = DB::table('l_school')
                            ->select('name_school')
                            ->where('id', $val)
                            ->first();
                        $tinh = DB::table('l_province')
                            ->select('name_province')
                            ->where('id', $id_tinh)
                            ->first();
                        //Change Khu Vực
                        $thongtinlop = DB::table('24_truongthpt')
                            ->where('id_taikhoan', $id_taikhoan)
                            ->where('id_lop', $id_lop)
                            ->get();
                        $area_school = DB::table('l_school')
                            ->select('priority_area_school')
                            ->where('id', $thongtinlop[0]->id_truong)
                            ->first();
                        $name_khuvuc = DB::table('l_priority_area')
                            ->select('id_priority_area')
                            ->where('id', $area_school->priority_area_school)
                            ->first();
                        $khuvuc = $name_khuvuc->id_priority_area;
                        //Mục 4 khu vực
                        $results = DB::table('24_truongthpt')
                        ->select('l_priority_area.id as id', DB::raw('COUNT(*) as total_count'))
                            ->join('l_school', 'l_school.id', '=', '24_truongthpt.id_truong')
                            ->join('l_priority_area', 'l_priority_area.id', '=', 'l_school.priority_area_school')
                            ->where('24_truongthpt.id_taikhoan', $id_taikhoan)
                            ->groupBy('l_priority_area.id')
                            ->orderBy('total_count','DESC')
                            ->get();
                        DB::table('24_khuvucuutien')
                            ->updateOrInsert(
                                [
                                    'id_taikhoan' => $id_taikhoan,
                                ],
                                [
                                    'khuvucuutien' => $results[0]->id,
                                ]
                            );
                        // $this->tinhdiemxettuyentheokhoangthisinh($id_taikhoan,  $id_taikhoan);
                        // $this->tinhdiemtheonganh($id_taikhoan);
                        $user_agent = $_SERVER['HTTP_USER_AGENT'];
                        DB::table('24_lichsu')
                            ->insert(
                                [
                                    'id_taikhoan' => $id_taikhoan,
                                    'noidung'   => "Cập nhật Trường: Tỉnh-" . $tinh->name_province . " Trường-" . $truong->name_school,
                                    'hienthi'   => 0,
                                    'id_nhansu' => $id_admin,
                                    'thietbi'   => $user_agent,
                                    'ip'        => request()->ip()
                                ]
                            );
                        // DB::commit();
                        $res = array(
                            'thongbao' => 'upd_1',
                            'khuvuc' => $khuvuc,
                            'lop' => $id_lop,
                            // 'khuvucall' => $khuvucall,
                            // 'nganh' => $nganhall['nganh'],
                            // 'all_tohop' => $nganhall['all_tohop'],
                            // 'chuyennganhs' => $nganhall['chuyennganhs'],
                            // 'nguyenvongs' => $nganhall['nguyenvongs'],
                            // 'nguyenvong_all' => $nganhall['nguyenvong_all'],
                        );
                        $noidung = $res;
                        $maloi = 0;
                        $thongbao = 'upd_1';

                        // }catch(Exception $e){
                        //     DB::rollBack();
                        //     $res = array(
                        //         'thongbao' => 'upd_0',
                        //         'khuvuc' => 'Không',
                        //         'lop' => -1,
                        //         'khuvucall' => 'Không',
                        //         'nguyenvongs' => '',
                        //         'nguyenvong_all' => '',
                        //     );
                        //     $noidung = "";
                        //     $maloi = 0;
                        //     $thongbao = 'upd_0';
                        // }
                    }
                } else {
                    $noidung = "";
                    $maloi = 0;
                    $thongbao = 'khoa_1';
                }
            // }else{
            //     $noidung = "";
            //     $maloi = 0;
            //     $thongbao = 'rol_4';
            // }
        } else {
            $noidung = "";
            $maloi = 0;
            $thongbao = 'rol_2';
        }
        return array(
            'noidung' => $noidung,
            'maloi' => $maloi,
            'thongbao' => $thongbao,
        );
    }
    function capnhatketquahoctap(Request $request)
    {
        $id_taikhoan = $request->input('id_taikhoan');
        $val = $request->input('val');
        $lop = $request->input('lop');
        $hocki = $request->input('hocki');
        $mon = $request->input('mon');
        //Check quyền
        $time = $request->input('time');
        $id_manhinh = $request->input('id_manhinh');
        $id_chucnang = $request->input('id_chucnang');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            // $dotts = $this->motdottuyensinh();
            $dotts = $request->input('dotts');
            // $check=$this->kiemtraphanconghoso($dotts,$id_admin,$id_taikhoan);
            // if( $check == 1){
                if ($this->checkkhoahoso($id_taikhoan) == 0) {
                    $validator = Validator::make(
                        $request->all(),
                        [
                            'val' => 'required|numeric|min:0|max:10',

                        ],
                        [

                            'val.required' => 'Phải nhập điểm số.',
                            'val.numeric' => 'Điểm nhập vào phải là số.',
                            'val.min' => 'Điểm phải lớn hơn hoặc bằng 0.',
                            'val.max' => 'Điểm phải nhỏ hơn hoặc bằng 10.',

                        ]
                    );
                    if ($validator->fails()) {
                        $noidung = response()->json($validator->errors());
                        $maloi = 'validate';
                        $thongbao = "";
                    } else {
                        $ten_mon = DB::table('l_subject')
                            ->select('name_subject')
                            ->where('id', $mon)
                            ->first();
                        DB::beginTransaction();
                        try {
                            DB::table('24_ketquahoctap')->updateOrInsert(
                                [
                                    'id_student_result' => $id_taikhoan,
                                    'id_class_result' => $lop,
                                    'id_semester_result' => $hocki,
                                    'id_subject' => $mon,
                                ],
                                [
                                    'mark_result' => $val,
                                ]
                            );
                            // $this->tinhdiemtheonganh($id_taikhoan);
                            $this->tinhdiemxettuyentheokhoangthisinh($id_taikhoan,$id_taikhoan,$dotts);
                            $user_agent = $_SERVER['HTTP_USER_AGENT'];
                            DB::table('24_lichsu')
                                ->insert(
                                    [
                                        'id_taikhoan' => $id_taikhoan,
                                        'noidung'   => "Cập nhật điểm: Môn-" . $ten_mon->name_subject . ", Điểm-" . $val . ", Học kì-" . $hocki,
                                        'hienthi'   => 0,
                                        'id_nhansu' => $id_admin,
                                        'thietbi'   => $user_agent,
                                        'ip'        => request()->ip()
                                    ]
                                );
                            DB::commit();
                            $res = array(
                                'thongbao' => 'upd_1',
                                // 'nganh' => $nganhall['nganh'],
                                // 'all_tohop' => $nganhall['all_tohop'],
                                // 'chuyennganhs' => $nganhall['chuyennganhs'],
                                // 'nguyenvongs' => $nganhall['nguyenvongs'],
                                // 'nguyenvong_all' => $nganhall['nguyenvong_all'],

                            );
                            $noidung = $res;
                            $maloi = 0;
                            $thongbao = 'upd_1';
                        } catch (Exception $e) {
                            DB::rollBack();
                            $res = array(
                                'thongbao' => 'upd_0',
                                // 'nganh' => '',
                                // 'all_tohop' => '',
                                // 'chuyennganhs' => '',
                                // 'nguyenvongs' => '',
                                // 'nguyenvong_all' => '',
                            );
                            $noidung = $res;
                            $maloi = 0;
                            $thongbao = 'upd_0';
                        }
                    }
                } else {
                    $noidung = "";
                    $maloi = 0;
                    $thongbao = 'khoa_1';
                }
            }else{
                $noidung = '';
                $maloi = 0;
                $thongbao = 'rol_4';
            }
        // } else {
        //     $noidung = '';
        //     $maloi = 0;
        //     $thongbao = 'rol_2';
        // }
        return array(
            'noidung' => $noidung,
            'maloi' => $maloi,
            'thongbao' => $thongbao,
        );
    }
    function capnhatdoituong1(Request $request)
    {
        //Check quyền
        $time = $request->input('time');
        $id_manhinh = $request->input('id_manhinh');
        $id_chucnang = $request->input('id_chucnang');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        $id_taikhoan = $request->input('id_taikhoan');
        $val = $request->input('val');
        $noidung = '';
        $maloi = 0;
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            // $dotts = $this->motdottuyensinh();
            $dotts = $request->input('dotts');
            // $check=$this->kiemtraphanconghoso($dotts,$id_admin,$id_taikhoan);
            // if( $check == 1){
                if ($this->checkkhoahoso($id_taikhoan) == 0) {
                    $validator = Validator::make(
                        $request->all(),
                        [
                            'val' => 'integer|min:0',
                        ],
                        [
                            'val.integer' => 'Hãy chọn đối tượng.',
                            'val.min' => 'Hãy chọn đối tượng.',
                        ]
                    );
                    if ($validator->fails()) {
                        $noidung = response()->json($validator->errors());
                        $maloi = 'validate';
                        $thongbao = "";
                    } else {
                        if ($val == 0) {
                            DB::beginTransaction();
                            try {
                                DB::table('24_doituonguutien')
                                ->where('id_taikhoan', $id_taikhoan)
                                ->where('dotts', $dotts)
                                ->delete();
                                $this->tinhdiemxettuyentheokhoangthisinh($id_taikhoan,$id_taikhoan,$dotts);
                                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                                DB::table('24_lichsu')
                                    ->insert(
                                        [
                                            'id_taikhoan' => $id_taikhoan,
                                            'noidung'   => "Cập nhật đối tượng ưu tiên: Không ưu tiên",
                                            'hienthi'   => 0,
                                            'id_nhansu' => $id_admin,
                                            'thietbi'   => $user_agent,
                                            'ip'        => request()->ip()
                                        ]
                                    );
                                // $nganhall = $this->tinhdiemtheonganh($id_taikhoan);

                                DB::commit();
                                $thongbao = 'upd_1';
                            } catch (Exception $e) {
                                DB::rollBack();
                                $res = array(
                                    'thongbao' => 'upd_0',
                                    'nganh' => '',
                                    'all_tohop' => '',
                                    'chuyennganhs' => '',
                                    'nguyenvongs' => '',
                                    'nguyenvong_all' => '',
                                );
                                $thongbao = 'upd_0';
                            }
                        } else {
                            DB::beginTransaction();
                            try {
                                DB::table('24_doituonguutien')
                                    ->updateOrInsert(
                                        [
                                            'id_taikhoan' => $id_taikhoan,
                                            'dotts' => $dotts
                                        ],
                                        [
                                            'id_doituong' => $val
                                        ]
                                    );
                                $doituong = DB::table('l_policy_users')
                                    ->select('name_policy_user')
                                    ->where('id', $val)
                                    ->first();
                                // $nganhall = $this->tinhdiemtheonganh($id_taikhoan);
                                $this->tinhdiemxettuyentheokhoangthisinh($id_taikhoan,$id_taikhoan,$dotts);
                                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                                DB::table('24_lichsu')
                                    ->insert(
                                        [
                                            'id_taikhoan' => $id_taikhoan,
                                            'noidung'   => "Cập nhật đối tượng: " . $doituong->name_policy_user,
                                            'hienthi'   => 0,
                                            'id_nhansu' => $id_admin,
                                            'thietbi'   => $user_agent,
                                            'ip'        => request()->ip()
                                        ]
                                    );
                                DB::commit();
                                $thongbao = 'upd_1';
                            } catch (Exception $e) {
                                DB::rollBack();
                                // $res = array(
                                //     'thongbao' => 'upd_1',
                                //     'nganh' => $nganhall['nganh'],
                                //     'all_tohop' => $nganhall['all_tohop'],
                                //     'chuyennganhs' => $nganhall['chuyennganhs'],
                                //     'nguyenvongs' => $nganhall['nguyenvongs'],
                                //     'nguyenvong_all' => $nganhall['nguyenvong_all'],

                                // );
                                $res = array(
                                    'thongbao' => 'upd_0',
                                    'nganh' => '',
                                    'all_tohop' => '',
                                    'chuyennganhs' => '',
                                    'nguyenvongs' => '',
                                    'nguyenvong_all' => '',
                                );
                            }
                        }
                    }
                } else {
                    $thongbao = 'khoa_1';
                }
            // }else{
            //     $thongbao = 'rol_4';
            // }
        } else {
            $thongbao = 'rol_2';
        }
        return array(
            'noidung' => $noidung,
            'maloi' => $maloi,
            'thongbao' => $thongbao,
        );
    }
    function capnhatnguyenvong(Request $request)
    {
        $time = $request->input('time');
        $id_manhinh = $request->input('id_manhinh');
        $id_chucnang = $request->input('id_chucnang');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        $noidung = '';
        $maloi = 0;
        $thongbao = "";
        $id_taikhoan = $request->input('id_taikhoan');
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            if ($this->checkkhoahoso($id_taikhoan) == 0) {
                $val = $request->input('val');
                $id = $request->input('id');
                $stt = $request->input('stt');
                $id_chuyennganh = DB::table('24_nguyenvong')
                    ->select('id_chuyennganh')
                    ->where('id', $id)
                    ->first();
                $validator = Validator::make(
                    $request->all(),
                    [
                        'val' => 'integer|min:1',
                    ],
                    [
                        'val.integer' => 'Hãy chọn đối tượng.',
                        'val.min' => 'Hãy chọn đối tượng.',
                    ]
                );
                if ($validator->fails()) {
                    $noidung = response()->json($validator->errors());
                    $maloi = 'validate';
                } else {
                    DB::beginTransaction();
                    try {
                        DB::table('24_nguyenvong')
                            ->where('id_taikhoan', $id_taikhoan)
                            ->where('id', $id)
                            ->update([
                                'id_chuyennganh' => $val,
                            ]);
                        $this->tinhdiemtheonganh($id_taikhoan);
                        $nguyenvong2 = DB::table('24_chuyennganh')
                            ->select('tenchuyennganh')
                            ->where('id', $id_chuyennganh->id_chuyennganh)
                            ->first();
                        $user_agent = $_SERVER['HTTP_USER_AGENT'];
                        DB::table('24_lichsu')
                            ->insert(
                                [
                                    'id_taikhoan' => $id_taikhoan,
                                    'noidung'   => "Cập nhật nguyện vọng: Nguyện vọng thứ-" . $stt . " Nguyện vọng-" . $nguyenvong2->tenchuyennganh,
                                    'hienthi'   => 1,
                                    'id_nhansu' => $id_admin,
                                    'thietbi'   => $user_agent,
                                    'ip'        => request()->ip()
                                ]
                            );
                        DB::commit();
                        $res = array(
                            'thongbao' => 'upd_1',
                            // 'nganh' => $nganhall['nganh'],
                            // 'all_tohop' => $nganhall['all_tohop'],
                            // 'chuyennganhs' => $nganhall['chuyennganhs'],
                            // 'nguyenvongs' => $nganhall['nguyenvongs'],
                            // 'nguyenvong_all' => $nganhall['nguyenvong_all'],

                        );
                        $noidung = $res;
                        $thongbao = "upd_1";
                    } catch (Exception $e) {
                        DB::rollBack();
                        $res = array(
                            'thongbao' => 'upd_0',
                            // 'nganh' => '',
                            // 'all_tohop' => '',
                            // 'chuyennganhs' =>'',
                            // 'nguyenvongs' => '',
                            // 'nguyenvong_all' => '',

                        );
                        $thongbao = "upd_0";
                    }
                }
            } else {
                $thongbao = "khoa_1";
            }
        } else {
            $thongbao = "rol_2";
        }
        return array(
            'noidung' => $noidung,
            'maloi' => $maloi,
            'thongbao' => $thongbao,
        );
    }
    public function tinhdiemtohop($groups_mons, $groups, $diems, $id)
    {
        $id_taikhoan = $id;
        $uutienkhuvuc = $this->diemtuutientheotruongthpt($id_taikhoan)['diemkhuvucuutien'];
        $uutiendoituong = $this->diemtuutientheodoituong($id_taikhoan)['diemuutien'];
        foreach ($groups as $group) {
            // $group->uutien = $uutienkhuvuc;
            $tenc1 = $group->id_group . 'c1';
            $group->$tenc1 = 0;
            $tenc2 = $group->id_group . 'c2';
            $group->$tenc2 = 0;
            $group->diemtohop = 0;
            $diemtohop = 0;
            $j = 0;
            $i = 0;
            foreach ($groups_mons as $groups_mon) {
                if ($group->id == $groups_mon->id_group) {
                    foreach ($diems as $diem) {
                        if ($groups_mon->id_subject == $diem->id_subject && $diem->mark_result > 0) {
                            if (($diem->id_class_result == 11  && $diem->id_semester_result == "CN") || ($diem->id_class_result == 10  && $diem->id_semester_result == "CN") || ($diem->id_class_result == 12 && $diem->id_semester_result == 1)) {
                                $group->$tenc1 = $group->$tenc1 + $diem->mark_result / 3;
                                $i++;
                            }
                            if ($diem->id_class_result == 12  && $diem->id_semester_result == "CN") {
                                $group->$tenc2 = $group->$tenc2 + $diem->mark_result;
                                $j++;
                            }
                        }
                    }
                }
            }
            $i == 9 ? $group->$tenc1 = $group->$tenc1 : $group->$tenc1 = 0;
            $j == 3 ? $group->$tenc2 = $group->$tenc2 : $group->$tenc2 = 0;
            if ($group->$tenc1 > 0 || $group->$tenc2 > 0) {
                $group->$tenc1 >=  $group->$tenc2 ?   $diemtohop =  $group->$tenc1 : $diemtohop =  $group->$tenc2;
                $group->diemtohop = round($diemtohop, 3);
            } else {
                $diemtohop = 0;
            }

            if ($group->diemtohop > 0) {
                if ($group->diemtohop >= 22.5) {
                    $uutien = (((float)30 - (float)($group->diemtohop)) / 7.5) * ($uutienkhuvuc + $uutiendoituong);
                    $group->uutien = round($uutien, 3);
                } else {
                    $uutien = $uutienkhuvuc + $uutiendoituong;
                    $group->uutien = round($uutien, 3);
                }
            } else {
                $uutien = 0;
                $group->uutien = 0;
            }

            $group->diemxettuyen = round($uutien + $diemtohop, 2);
            // $group->id_tohop = 'tohop'.$group->id;
        }
        return $groups;
    }
    public function diemtuutientheotruongthpt($id_taikhoan)
    {
        $nam = DB::table('24_namtotnghiep')
            ->where('id_taikhoan', $id_taikhoan)
            ->first();
        if ($nam) {
            $namtotnghiep = $nam->namtotnghiep;
            $year = Carbon::now()->year;
            if ((int)$namtotnghiep < (int)$year - 1) {
                $khuvucuutien =  -1;
                $tenkhuvucuutien = "Không ưu tiên";
                $diemkhuvucuutien = 0;
            } else {
                $check = DB::table('24_truongthpt')
                    ->where('id_taikhoan', $id_taikhoan)
                    ->get();
                if ($check) {
                    if (count($check) == 3) {
                        $thpts = DB::select('SELECT * FROM (SELECT id, total FROM (SELECT l_priority_area.id as id, COUNT(*) as total FROM 24_truongthpt JOIN l_school ON l_school.id = 24_truongthpt.id_truong JOIN l_priority_area ON l_priority_area.id = l_school.priority_area_school WHERE 24_truongthpt.id_taikhoan = ' . $id_taikhoan . ' GROUP BY l_priority_area.id) AS uutien ORDER BY total DESC, id ASC LIMIT 0,1) AS uutienmax INNER JOIN l_priority_area ON l_priority_area.id = uutienmax.id');
                        $khuvucuutien =  $thpts[0]->id;
                        $tenkhuvucuutien = $thpts[0]->id_priority_area;
                        $diemkhuvucuutien = $thpts[0]->mark_priority;
                    } else {
                        $khuvucuutien =  0;
                        $tenkhuvucuutien = "";
                        $diemkhuvucuutien = 0;
                    }
                } else {
                    $khuvucuutien =  0;
                    $tenkhuvucuutien = "";
                    $diemkhuvucuutien = 0;
                }
            }
        } else {
            $khuvucuutien =  0;
            $tenkhuvucuutien = "";
            $diemkhuvucuutien = 0;
        }
        $res = array(
            'khuvucuutien' => $khuvucuutien,
            'tenkhuvucuutien' => $tenkhuvucuutien,
            'diemkhuvucuutien' => $diemkhuvucuutien,
        );
        return $res;
    }
    function diemtuutientheodoituong($id_taikhoan)
    {
        $doituong = DB::table('24_doituonguutien')
            ->join('l_policy_users', 'id_doituong', 'l_policy_users.id')
            ->select('id_doituong', 'mark_policy_user', 'name_policy_user')
            ->where('id_taikhoan', $id_taikhoan)
            ->first();
        if ($doituong) {
            $res = array(
                'id_doituong' => $doituong->id_doituong,
                'diemuutien' => $doituong->mark_policy_user,
                'tendoituong' => $doituong->name_policy_user,
            );
        } else {
            $res = array(
                'id_doituong' => "",
                'diemuutien' => 0,
                'tendoituong' => "",
            );
        }
        return   $res;
    }
    function tinhdiemtheonganh($id_taikhoan)
    {
        $ten_nganh = DB::table('l_major')->select('*')->get();
        $tohop_nganh = DB::table('l_major_group')->select('*')->get();
        $diems = DB::table('24_ketquahoctap')
            ->where('id_student_result', $id_taikhoan)
            ->get();
        $groups_mons = DB::table('l_group_subject')
            ->get();
        $groups = DB::table('l_group')
            ->where('id_method', 1)
            ->get();
        $all_tohop = $this->tinhdiemtohop($groups_mons, $groups, $diems, $id_taikhoan);
        foreach ($ten_nganh as $nganh) {
            $arr_tophop = array();
            $max_diem = 0;
            $diemxettuyen = 0;
            $tohopxettuyen = '--';
            $idtohop = '--';
            $diemtohop = '--';
            $uutien = '--';
            foreach ($tohop_nganh as $id_tohop) {
                if ($nganh->id == $id_tohop->id_major) {
                    foreach ($all_tohop as $diem) {
                        if ($id_tohop->id_gruop == $diem->id) {
                            if ($diem->diemxettuyen > $max_diem) {
                                $diemxettuyen = $diem->diemxettuyen;
                                $max_diem = $diemxettuyen;
                                $idtohop = $diem->id;
                                $diemtohop = $diem->diemtohop;
                                $uutien = $diem->uutien;
                                $tohopxettuyen = $diem->id_group;
                            }
                        }
                    }
                }
            }
            $nganh->diemxettuyen = $diemxettuyen;
            $nganh->idtohop = $idtohop;
            $nganh->tohopxettuyen = $tohopxettuyen;
            $nganh->diemtohop = $diemtohop;
            $nganh->uutien = $uutien;
        }
        $arr_chuyennganh = array();
        // $chuyennganhs = DB::select('select 24_chuyennganh.id, `tenchuyennganh`, `id_nganh`, `gioithieu`, `moi`,if(X.thutu is null, 0, X.thutu) as thutu  from `24_chuyennganh` LEFT JOIN (SELECT * FROM 24_nguyenvong WHERE id_taikhoan = '.$id_taikhoan.') AS X ON 24_chuyennganh.id = X.id_chuyennganh where `trangthai` = 1');
        $chuyennganhs = DB::table('24_nguyenvong')
            ->join('24_chuyennganh', '24_nguyenvong.id_chuyennganh', '24_chuyennganh.id')
            ->where('id_taikhoan', $id_taikhoan)
            ->get();
        foreach ($chuyennganhs as $chuyennganh) {
            foreach ($ten_nganh as $nganh) {
                if ($nganh->id == $chuyennganh->id_nganh) {
                    DB::table('24_nguyenvong')
                        ->where([
                            'thutu' => $chuyennganh->thutu,
                            'id_taikhoan' => $id_taikhoan,
                            'id_chuyennganh' => $chuyennganh->id,
                        ])
                        ->update([
                            'diemxettuyen' =>  $nganh->diemxettuyen,
                            'tohop' =>  $nganh->idtohop,
                            'diemtohop' =>  $nganh->diemtohop,
                            'diemuutien' =>   $nganh->uutien,
                        ]);
                    break;
                }
            }
        }
        // DB::table('24_nguyenvong')->upsert($arr_chuyennganh,['id_chuyennganh','thutu','id_taikhoan'],['diemxettuyen','tohop','diemtohop','diemuutien']);
        return 1;
    }
    public function checkkhoahoso($id_taikhoan)
    {
        // $dotts = $this->motdottuyensinh();
        $check = DB::table('24_kiemtrahoso')->where('id_taikhoan', $id_taikhoan)->first();
        $trangthai = 0;
        if ($check) {
            $check->khoa > 0 ? $trangthai = 1 : $trangthai = 0; //Khóa hoặc không khóa
        } else {
            $trangthai = -1; //Không tìm thấy
        }
        return $trangthai;
    }
    public function checkduyet($id_taikhoan)
    {
        $check = DB::table('24_kiemtrahoso')->where('id_taikhoan', $id_taikhoan)->first();
        $trangthai = 0;
        if ($check) {
            $check->duyet == 1 ? $trangthai = 1 : $trangthai = 0; //Duyệt hoặc không dueyetj
        } else {
            $trangthai = -1; //Không tìm thấy
        }
        return $trangthai;
    }
    public function khoahoso(Request $request)
    {
        // $dotts = $this->motdottuyensinh();
        $time = $request->input('time');
        $id_manhinh = $request->input('id_manhinh');
        $id_chucnang = $request->input('id_chucnang');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        $maloi = 0;
        $trangthai = "";
        $noidung = "";
        $id_taikhoan = $request->input('id_taikhoan');
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            if(!$id_taikhoan){
                $trangthai = 'find_no';
            }else{
                $dotts = $request->input('dotts');
                // $dotts = $this->motdottuyensinh();
                // $check=$this->kiemtraphanconghoso($dotts,$id_admin,$id_taikhoan);
                // if( $check == 1){
                    $checkdangky = DB::table('24_khoadangky')->where('id_taikhoan', $id_taikhoan)->where('dotts',$dotts)->first();
                    if(!$checkdangky || $checkdangky->trangthai == 2){
                        $trangthai = "dangky_0";
                    }else{
                        $khoa = $this->checkkhoahoso($id_taikhoan);
                        $duyet = $this->checkduyet($id_taikhoan);
                        switch ($duyet) {
                            case '0':
                                $khoa == 1 ?  $trangthai_sekhoa = 0 : $trangthai_sekhoa = 1;
                                $khoa == 1 ?  $title = "Mở khóa HS" : $title = "Khóa HS";
                                $khoa == 1 ?  $noidung = "Hệ thống đã mở khóa, Thầy/Cô có thể cập nhật thông tin" : $noidung = "Hệ thống đã khóa hồ sơ và Tính lại điểm xét tuyển";
                                $thoigiankhoa = now('Asia/Ho_Chi_Minh');
                                DB::table('24_kiemtrahoso')->where('id_taikhoan', $id_taikhoan)->update([
                                    'khoa' => $trangthai_sekhoa,
                                    'thoigiankhoa' => $thoigiankhoa,
                                ]);
                                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                                DB::table('24_lichsu')
                                    ->insert(
                                        [
                                            'id_taikhoan' => $id_taikhoan,
                                            'noidung'   => "Cập nhật trạng thái hồ sơ: " . $title,
                                            'hienthi'   => 1,
                                            'id_nhansu' => $id_admin,
                                            'thietbi'   => $user_agent,
                                            'ip'        => request()->ip()
                                        ]
                                    );
                                // this->tinhdiemtheonganh($id_taikhoan);
                                $this->tinhdiemxettuyentheokhoangthisinh($id_taikhoan,$id_taikhoan,$dotts);
                                $trangthai = 'upd_1';
                                break;
                            case '1':
                                $trangthai = 'duyet_pass'; //Đã duyệt
                                break;
                            default:
                                $trangthai = 'find_no'; //Đã duyệt
                                break;
                        }
                    }
                // }else{
                //     $trangthai = "rol_4";
                // }
            }
        } else {
            $trangthai = "rol_2";
        }
        return array(
            'trangthai' => $trangthai,
            'maloi' => $maloi,
            'noidung' => $noidung,
        );
    }
    // Định dạng mail.
    function dinhdangmail($id_mail, $arr_thongtin)
    {
        $mail = DB::table('24_noidungmail')->where('id', $id_mail)->first();
        preg_match_all('/\$\$\$(.*?)\$\$\$/', $mail->noidung, $matches);
        $pattern = '/(\$\$\$.*?\$\$\$)/';
        $parts = preg_split($pattern, $mail->noidung, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        foreach ($parts as $key => $part) {
            foreach ($matches[1] as $key => $match) {
                if ($part == '$$$' . $match . '$$$') {
                    $array = str_replace($part, $arr_thongtin->$match, $parts);
                    $parts = $array;
                }
            }
        }
        $noidungmail = implode("", $parts);
        return array(
            'noidung_mail' => $noidungmail,
            'tieude_mail'  => $mail->tieude
        );
    }
    public function duyethoso(Request $request)
    {
        $time = $request->input('time');
        $id_manhinh = $request->input('id_manhinh');
        $id_chucnang = $request->input('id_chucnang');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        $maloi = 0;
        $trangthai = "";
        $noidung = "";
        $id_taikhoan = $request->input('id_taikhoan');
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            if(!$id_taikhoan){
                $trangthai = 'find_no';
            }else{
                $dienthoai1 = DB::table('24_kiemtrahoso')
                ->join('24_accountsadmin','24_accountsadmin.id','24_kiemtrahoso.id_nhansu')
                ->where('24_kiemtrahoso.id_taikhoan', $id_taikhoan)->first();
                // $quyenkiemtra = DB::table('24_kiemtrahoso')->where('id_taikhoan',$id_taikhoan)->first()->id_nhansu;
                if($dienthoai1->id_nhansuduyet == $id_admin){
                    $khoa = $this->checkkhoahoso($id_taikhoan);
                    $duyet = $this->checkduyet($id_taikhoan);
                    switch ($khoa) {
                        case '1':
                            DB::beginTransaction();
                            try {
                                $duyet == 1 ?  $trangthai_seduyet = 0 : $trangthai_seduyet = 1;
                                $duyet == 1 ?  $title = "Hủy duyệt" : $title = "Duyệt";
                                $thoigianduyet = now('Asia/Ho_Chi_Minh');
                                DB::table('24_kiemtrahoso')->where('id_taikhoan', $id_taikhoan)->update([
                                    'duyet' => $trangthai_seduyet,
                                    'id_nhansuduyet' => $id_admin,
                                    'thoigianduyet' => $thoigianduyet,
                                    'idghichu' => 0,
                                    // 'noidungghichu' =>  null,
                                ]);
                                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                                DB::table('24_lichsu')
                                ->insert(
                                    [
                                        'id_taikhoan' => $id_taikhoan,
                                        'noidung'   => "Cập nhật trạng thái hồ sơ: ".$title."(Cán bộ kiểm tra: " . $dienthoai1->dienthoai . ')',
                                        'hienthi'   => 1,
                                        'id_nhansu' => $id_admin,
                                        'thietbi'   => $user_agent,
                                        'ip'        => request()->ip()
                                    ]
                                );
                                DB::commit();
                                $duyet == 1 ?  $trangthai = 'duyet_1' : $trangthai = 'duyet_0' ;
                            } catch (Exception $e) {
                                DB::rollBack();
                                $trangthai = '-100';
                            }
                            if ($trangthai == 'duyet_0') {
                                if ($trangthai_seduyet == 1) {
                                    $thongtin = DB::table('24_thongtincanhan')
                                        ->select('24_thongtincanhan.hoten', '24_covanhoctap.ten_cvht', '24_covanhoctap.dienthoai_cvht')
                                        ->join('24_nguyenvong', '24_nguyenvong.id_taikhoan', '24_thongtincanhan.id_taikhoan')
                                        ->join('24_covanhoctap', '24_covanhoctap.id_chuyennganh', '24_nguyenvong.id_chuyennganh')
                                        ->where(
                                            [
                                                'thutu' => 1,
                                                '24_covanhoctap.iddot' => 1,
                                                '24_nguyenvong.iddot' => 1,
                                                '24_thongtincanhan.id_taikhoan' => $id_taikhoan,
                                            ]
                                        )->first();
                                    $id_mail = 1;
                                    $mail_to = DB::table('account24s')->select('email')->where('id', $id_taikhoan)->first()->email;
                                    $mail = $this->dinhdangmail($id_mail, $thongtin);
                                    $maiable = new MailDuyet($mail['noidung_mail'], $mail['tieude_mail']);
                                    Mail::to(strval($mail_to))->send($maiable);
                                    // Mail::to('ngphantu2004@gmail.com')->send($maiable);
                                }
                            }
                            break;

                        case '0':
                            $trangthai = 'khoa_0'; //Hồ sơ chưa khóa
                            break;
                        default:
                            $trangthai = 'find_no'; //Đã duyệt
                            break;
                    }
                }else{
                    $trangthai = "rol_4";
                }
            }
        } else {
            $trangthai = "rol_2";
        }
        return array(
            'trangthai' => $trangthai,
            'maloi' => $maloi,
            'noidung' => $noidung,
        );
    }
    function guimail_kiemtrahoso(Request $request)
    {
        $time = $request->input('time');
        $id_manhinh = $request->input('id_manhinh');
        $id_chucnang = $request->input('id_chucnang');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        $id_taikhoan = $request->input('id_taikhoan');
        $noidungloi = $request->input('noidungloi');
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            $validator = Validator::make(
                $request->all(),
                [
                    'noidungloi'     => 'required',
                    'id_taikhoan'   => 'required'
                ],
                [
                    'noidungloi.required'      => 'Vui lòng nhập nội dung lỗi!',
                    'id_taikhoan.required'      => 'Vui lòng chọn thí sinh!',
                ]
            );
            if ($validator->fails()) {
                $trangthai = response()->json($validator->errors());
            } else {
                $khoa = $this->checkkhoahoso($id_taikhoan);
                if ($khoa == 0) {
                    DB::beginTransaction();
                    try {
                        // $id_mail = 5; Local
                        $id_mail = 3; //Sever
                        $thongtin = DB::table('24_thongtincanhan')->where('id_taikhoan', $id_taikhoan)->first();
                        $thongtin->noidungloi = $noidungloi;
                        $mail_to = DB::table('account24s')->where('id', $id_taikhoan)->first()->email;
                        $mail = $this->dinhdangmail($id_mail, $thongtin);
                        $maiable = new MailDuyet($mail['noidung_mail'], $mail['tieude_mail']);
                        Mail::to(strval($mail_to))->send($maiable);
                        // Mail::to('ngphantu2004@gmail.com')->send($maiable);
                        $dienthoai = DB::table('24_kiemtrahoso')
                            ->join('24_accountsadmin', '24_accountsadmin.id', '24_kiemtrahoso.id_nhansu')
                            ->where('24_kiemtrahoso.id_taikhoan', $id_taikhoan)->first()->dienthoai;
                        $user_agent = $_SERVER['HTTP_USER_AGENT'];
                        $checkdangky = DB::table('24_khoadangky')->where('id_taikhoan', $id_taikhoan)->first();
                        if($checkdangky){
                            DB::table('24_kiemtrahoso')->where('id_taikhoan', $id_taikhoan)->update(['trangthai' => 2]);
                            DB::table('24_khoadangky')->where('id_taikhoan', $id_taikhoan)->update(['trangthai' => 2]);
                        }
                        DB::table('24_lichsu')
                        ->insert(
                            [
                                'id_taikhoan' => $id_taikhoan,
                                'noidung'   => "Gửi mail yêu cầu cập nhật hồ sơ: (Cán bộ kiểm tra: " . $dienthoai . ')',
                                'hienthi'   => 1,
                                'id_nhansu' => $id_admin,
                                'thietbi'   => $user_agent,
                                'ip'        => request()->ip()
                            ]
                        );
                        DB::commit();
                        $trangthai = 'send_1';
                    } catch (Exception $e) {
                        DB::rollback();
                        $trangthai = '-100';
                    }
                } else {
                    $trangthai = 'khoa_1';
                }
            }
        } else {
            $trangthai = 'rol_2';
        }
        return $trangthai;
    }
    function checkkhoadangky($id_taikhoan)  {
        $dangky = DB::table('24_khoadangky')
        ->where('id_taikhoan',$id_taikhoan)
        ->first();
        if($dangky){
            if($dangky->trangthai == 1){
                $trangthaihientai = 1;
                $trangthaitupdate = 2;
            }else if($dangky->trangthai == 2){
                $trangthaihientai = 2;
                $trangthaitupdate = 3;
            }else{
                $trangthaihientai = 3;
                $trangthaitupdate = 2;
            }
        }else{
            $trangthaihientai = 0;
            $trangthaitupdate = 1;
        }
        return array(
            'trangthaihientai' =>  $trangthaihientai,
            'trangthaitupdate' =>  $trangthaitupdate,
        );
    }
    public function dangky_hoso(Request $request)
    {
        $time = $request->input('time');
        $id_manhinh = $request->input('id_manhinh');
        $id_chucnang = $request->input('id_chucnang');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        $id_taikhoan = $request->input('id_taikhoan');
        $maloi = 0;
        $trangthai = "";
        $noidung = "";
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            if(!$id_taikhoan){
                $trangthai = 'find_no';
            }else{
                $checknguyenvong = DB::table('24_nguyenvong')->where('id_taikhoan', $id_taikhoan)->first();
                if(!$checknguyenvong){
                    $trangthai = 'ngvg_0';
                }else{
                    $checkdangky = DB::table('24_khoadangky')->where('id_taikhoan', $id_taikhoan)->first();
                    $trangthaidangky = $this->checkkhoadangky($id_taikhoan)['trangthaitupdate'];
                    if (!$checkdangky ||  $checkdangky->trangthai == 2 ) {
                        DB::table('24_khoadangky')
                        ->updateOrInsert(
                            ['id_taikhoan'=> $id_taikhoan],
                            ['trangthai' => $trangthaidangky]);
                        $thoigiankhoa = now('Asia/Ho_Chi_Minh');
                        DB::table('24_kiemtrahoso')->where('id_taikhoan', $id_taikhoan)->update([
                            'trangthai' =>   $trangthaidangky,
                            'thoigiancapnhat' => $thoigiankhoa,
                            'khoa' => 0,
                            'duyet' => 0,
                        ]);
                        $user_agent = $_SERVER['HTTP_USER_AGENT'];
                        DB::table('24_lichsu')
                        ->insert(
                            [
                                'id_taikhoan' => $id_taikhoan,
                                'noidung'   => "Cập nhật trạng thái hồ sơ: Đăng ký thay thí sinh ",
                                'hienthi'   => 0,
                                'id_nhansu' => $id_admin,
                                'thietbi'   => $user_agent,
                                'ip'        => request()->ip()
                            ]
                        );
                        $this->tinhdiemtheonganh($id_taikhoan);
                        $trangthai = "upd_1";
                    }else{
                        $trangthai = "dangky_1";
                    }
                }

            }
        } else {
            $trangthai = "rol_2";
        }
        return array(
            'trangthai' => $trangthai,
            'maloi' => $maloi,
            'noidung' => $noidung,
        );
    }
    function kiemtratrangthaihuy($id_taikhoan){
        $trangthai = DB::table('24_kiemtrahoso')
        ->where('id_taikhoan',$id_taikhoan)
        ->first();
        if($trangthai){
            if($trangthai->huy == 1){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }
    //Hủy hồ sơ
    public function huyhoso(Request $request)
    {
        $time = $request->input('time');
        $id_manhinh = $request->input('id_manhinh');
        $id_chucnang = $request->input('id_chucnang');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        $maloi = 0;
        $trangthai = "";
        $noidung = "";
        $id_taikhoan = $request->input('id_taikhoan');
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            $duyet = $this->checkduyet($id_taikhoan);
            switch ($duyet) {
                case '0':
                    DB::beginTransaction();
                    try{
                        $kiemtratrangthaihuy = $this->kiemtratrangthaihuy($id_taikhoan);
                        if($kiemtratrangthaihuy == 1){
                            $capnhat = 0;
                            $title = "Phục hồi hồ sơ";
                        }else{
                            $capnhat = 1;
                            $title = "Hủy hồ sơ";
                        }
                        $thoigianhuy = now('Asia/Ho_Chi_Minh');
                        DB::table('24_kiemtrahoso')->where('id_taikhoan', $id_taikhoan)->update([
                            'huy' => $capnhat,
                            'thoigianhuy' => $thoigianhuy,
                            'khoa' => 0,
                        ]);
                        $user_agent = $_SERVER['HTTP_USER_AGENT'];
                        DB::table('24_lichsu')
                            ->insert(
                                [
                                    'id_taikhoan' => $id_taikhoan,
                                    'noidung'   => "Cập nhật trạng thái hồ sơ:". $title,
                                    'hienthi'   => 1,
                                    'id_nhansu' => $id_admin,
                                    'thietbi'   => $user_agent,
                                    'ip'        => request()->ip()
                                ]
                            );
                        DB::commit();
                        $trangthai = 'upd_1';
                    }catch(Exception $e){
                        DB::rollBack();
                        $trangthai = -100;
                    }
                    break;
                case '1':
                    $trangthai = 'duyet_pass'; //Đã duyệt
                    break;
                default:
                    $trangthai = 'find_no'; //Đã duyệt
                    break;
            }
        } else {
            $trangthai = "rol_2";
        }

        return array(
            'trangthai' => $trangthai,
            'maloi' => $maloi,
            'noidung' => $noidung,
        );

    }
    function danhmuc_hoso_tracuutcts($id_taikhoan){
        $danhmuc = DB::select("SELECT 24_danhmuc_hsts.id as id, 24_danhmuc_hsts.loaihoso as loaihoso, 24_nhanhosots.id_taikhoan as id_taikhoan
        FROM `24_danhmuc_hsts`
        LEFT JOIN `24_nhanhosots` ON 24_nhanhosots.id_loaihoso = 24_danhmuc_hsts.id
        AND 24_nhanhosots.id_taikhoan = $id_taikhoan ORDER BY thutu",);
        return array(
            'danhmuc' => $danhmuc,
            'id_taikhoan' =>  $id_taikhoan
        );
    }
    function nhanhoso_tstc(Request $request) //Nhaanj hoo so
    {
        $id_taikhoan = $request->input('id_taikhoan');
        $id = $request->input('id');
        $id_check = $request->input('id_check');
        $danhmuc_hoso_ten = DB::table('24_danhmuc_hsts')->select('loaihoso')->where('id', $id)->first()->loaihoso;
        DB::beginTransaction();
        try{
            if($id_check == 1){
                $nhanhoso = DB::table('24_nhanhosots')
                ->insert([
                    'id_loaihoso' => $id,
                    'id_taikhoan' => $id_taikhoan,
                ]);
                $noidung = "Thêm ". $danhmuc_hoso_ten;
            }else if($id_check == 0){
                $nhanhoso = DB::table('24_nhanhosots')
                ->where('id_loaihoso', $id)
                ->where('id_taikhoan', $id_taikhoan)
                ->delete();
                $noidung = "Xóa ". $danhmuc_hoso_ten;
            }
            $id_admin = Auth::guard('loginadmin')->user()->id;
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            DB::table('24_lichsu')
                ->insert([
                    'id_taikhoan' => $id_taikhoan,
                    'noidung'   => $noidung,
                    'hienthi'   => 1,
                    'id_nhansu' => $id_admin,
                    'thietbi'   => $user_agent,
                    'ip'        => request()->ip()
                ]);
            DB::commit();
            if($nhanhoso == 1 ){
                return 'upd_1';
            }else{
                return 'upd_2';
            }
        }catch(Exception $e){
            DB::rollBack();
            return 'err_0';
        }
    }
    function ghep_2truyvan($data_goc,$data_ghep,$ten){
        if(count($data_ghep)>0){
            foreach ($data_goc as $key => $goc) {
                $dem = 0;
                foreach ($data_ghep as $key => $ghep) {
                    if($goc->id == $ghep->id){
                        $goc->$ten = $ghep->value;
                        break;
                    }
                    if($dem == 0){
                        $goc->$ten = "x";
                    }
                }
            }
        }else{
            foreach ($data_goc as $key => $goc) {
                $goc->$ten = "x";
            }
        }
        return $data_goc;
    }
    function inphieurasoat($id_taikhoan,$dotts){

        // $dotts = $this->motdottuyensinh();
        $madot = DB::table('24_dottuyensinh')->where('id',$dotts)->first()->madot;
        $maxId = DB::table('24_phieuthuhsts')
        ->where('dotts',$dotts)
        ->max('stt');
        $maxId  = 1 + $maxId;
        $phandu =$maxId%150;
        $phannguyen = ($maxId - $phandu)/150;
        $box = $phannguyen + 1;
        if($box <10){
            $boxs = "0".$box;
        }else{
            $boxs = $box;
        }
        if($maxId <10){
            $stts = "000".$maxId;
        }else{
            if($maxId >=10 && $maxId <=100 ){
                $stts = "00".$maxId;
            }else{
                if($maxId >=10 && $maxId <=100 ){
                    $stts = "0".$maxId;
                }else{
                    $stts = $maxId;
                }
            }
        }
        $maphieu = $madot.".H".$boxs.".".$stts;
        $kiemtra = DB::table('24_phieuthuhsts')
        ->where('id_taikhoan',$id_taikhoan)
        ->where('dotts',$dotts)->first();
        if(!$kiemtra){
            DB::table('24_phieuthuhsts')
            ->insert([
                'id_taikhoan' => $id_taikhoan,
                'dotts' => $dotts,
                'stt' => $maxId,
                'maphieu' => $maphieu,
            ]);
        }
        $sql = " SELECT
                ttcn.hoten,
                ttcn.cccd,
                ttcn.dienthoai,
                DATE_FORMAT(ttcn.ngaysinh, '%d/%m/%Y') AS ngaysinh,
                IF(ttcn.gioitinh = 1, 'Nữ', 'Nam') AS gioitinh,
                ntn.namtotnghiep as namtotnghiep,
                kvut.id_priority_area as khuvucuutien,
                dtut.name_policy_user as doituonguutien,
                mphieu.maphieu as maphieu
            FROM
                24_thongtincanhan ttcn
            INNER JOIN
                (SELECT id_taikhoan, namtotnghiep FROM 24_namtotnghiep WHERE id_taikhoan = ?) ntn
            LEFT JOIN
                (SELECT id_taikhoan, id_priority_area FROM 24_khuvucuutien INNER JOIN l_priority_area ON l_priority_area.id = 24_khuvucuutien.khuvucuutien  WHERE id_taikhoan = ? AND dotts = ?) kvut
                ON kvut.id_taikhoan = ttcn.id_taikhoan
            LEFT JOIN
                (SELECT id_taikhoan, name_policy_user FROM 24_doituonguutien INNER JOIN l_policy_users ON l_policy_users.id = 24_doituonguutien.id_doituong  WHERE id_taikhoan = ? AND dotts = ?) dtut
                ON dtut.id_taikhoan = ttcn.id_taikhoan
            INNER JOIN
                (SELECT id_taikhoan, maphieu FROM 24_phieuthuhsts WHERE id_taikhoan = ? AND dotts = ?) mphieu
                ON mphieu.id_taikhoan = ttcn.id_taikhoan
            WHERE
                ttcn.id_taikhoan = ?
                LIMIT 1";
        $thongtin = DB::select($sql, [$id_taikhoan,$id_taikhoan,$dotts,$id_taikhoan,$dotts,$id_taikhoan,$dotts,$id_taikhoan]);
        $mons = DB::select('select id as id, name_subject from l_subject where id_type_subject = 1');
        $diemhocba10 = DB::select("SELECT id_subject as id, mark_result as value  FROM 24_ketquahoctap WHERE id_student_result = ? AND id_class_result = 10 AND id_semester_result  = 'CN'",[$id_taikhoan]);
        $diemhocba11 = DB::select("SELECT id_subject as id, mark_result as value FROM 24_ketquahoctap WHERE id_student_result = ? AND id_class_result = 11 AND id_semester_result  = 'CN'",[$id_taikhoan]);
        $diemhocba12 = DB::select("SELECT id_subject as id, mark_result as value FROM 24_ketquahoctap WHERE id_student_result = ? AND id_class_result = 12 AND id_semester_result  = 1",[$id_taikhoan]);
        $diemhocba12CN = DB::select("SELECT id_subject as id, mark_result as value FROM 24_ketquahoctap WHERE id_student_result = ? AND id_class_result = 12 AND id_semester_result  = 'CN'",[$id_taikhoan]);
        $diemthpt = DB::select("SELECT id_subject as id, mark_result as value FROM 24_ketquahoctap WHERE id_student_result = ? AND id_class_result = 'TN' AND id_semester_result  = 'PT'",[$id_taikhoan]);

        $lop10 = $this->ghep_2truyvan($mons,$diemhocba10,'diemlop10');
        $lop11 = $this->ghep_2truyvan($mons,$diemhocba11,'diemlop11');
        $lop12 = $this->ghep_2truyvan($mons,$diemhocba12,'diemlop12');
        $lop12CN = $this->ghep_2truyvan($mons,$diemhocba12CN,'diemhocba12CN');

        $diemthpt = $this->ghep_2truyvan($mons,$diemthpt,'diemthpt');
        $nguyenvongs = DB::table('24_nguyenvong')
        ->select(
            '24_nguyenvong.thutu as thutu',
            '24_nguyenvong.id_taikhoan',
            '24_chuyennganh.tenchuyennganh',
            '24_nguyenvong.diemtohop',
            '24_nguyenvong.diemuutien',
            '24_nguyenvong.diemxettuyen',
            '24_nguyenvong.id',
            '24_nguyenvong.id_chuyennganh',
            DB::raw('if(24_trungtuyen.idnv is null,"Trượt","Đạt") as ketqua'),
            DB::raw('if(24_nguyenvong.idphuongthuc = 1, 200,100) as phuongthuc'),
            DB::raw('if(24_trungtuyen.ttsom = 1, "x", "") as ttsom'),
            DB::raw('CONCAT(id_group,":",name_group) as tohop'),
        )
        ->join('24_chuyennganh', '24_nguyenvong.id_chuyennganh', '=', '24_chuyennganh.id')
        ->join('l_group', 'l_group.id', '=', '24_nguyenvong.tohop')
        ->leftJoin('24_trungtuyen', function ($join) use ($dotts) {
            $join->on('24_nguyenvong.id', '=', '24_trungtuyen.idnv')
                 ->where('24_trungtuyen.iddot', '=', $dotts); // Điều kiện WHERE 24_trungtuyen.iddot = 2
        })
        ->where('24_nguyenvong.id_taikhoan', $id_taikhoan)
        ->where('24_nguyenvong.iddot', $dotts)
        ->orderBy('24_nguyenvong.thutu')
        ->orderBy('24_nguyenvong.idphuongthuc')
        ->get();
        $danhmuc = DB::select("SELECT 24_danhmuc_hsts.id as id, 24_danhmuc_hsts.loaihoso as loaihoso, 24_nhanhosots.id_taikhoan as id_taikhoan
            FROM `24_danhmuc_hsts`
            LEFT JOIN `24_nhanhosots` ON 24_nhanhosots.id_loaihoso = 24_danhmuc_hsts.id
            AND 24_nhanhosots.id_taikhoan = $id_taikhoan ORDER BY thutu");

        $id_admin = Auth::guard('loginadmin')->user()->id;
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        DB::table('24_lichsu')
        ->insert([
            'id_taikhoan' => $id_taikhoan,
            'noidung'   => "Thu hồ sơ của thí sinh ".$thongtin[0]->hoten."(ID: ".$id_taikhoan."; Phiếu: ".$maphieu.")",
            'hienthi'   => 1,
            'id_nhansu' => $id_admin,
            'thietbi'   => $user_agent,
            'ip'        => request()->ip()
        ]);

        $data = [
            'canbonhanhoso' => DB::table('24_accountsadmin')->where('id',$id_admin)->first()->name,
            'maphieu' => $thongtin[0]->maphieu,
            'hoten' =>  $thongtin[0]->hoten,
            'cccd' => $thongtin[0]->cccd,
            'dienthoai' => $thongtin[0]->dienthoai,
            'ngaysinh' =>  $thongtin[0]->ngaysinh,
            'gioitinh' =>  $thongtin[0]->gioitinh,
            'namtotnghiep' =>  $thongtin[0]->namtotnghiep,
            'khuvucuutien' =>  $thongtin[0]->khuvucuutien,
            'doituonguutien' =>  $thongtin[0]->doituonguutien,
            'mons' =>  $mons,
            'lop11' =>  $lop11,
            'lop10' =>  $lop10,
            'lop12' =>  $lop12,
            'lop12CN' =>  $lop12CN,
            'diemthpt' => $diemthpt,
            'nguyenvong' => $nguyenvongs,
            'danhmuc' => $danhmuc,
            'day' =>  Carbon::today()->day,
            'month' =>  Carbon::today()->month,
            'year' =>  Carbon::today()->year,
        ];

        $pdf = PDF::loadView('pdf.check_user_phieu_list_file',$data);
        return $pdf->stream('PhieuThuHoSoTuyenSinh.pdf');

    }
    function kiemtraphieutrungtuyen($id_taikhoan,$dotts){
        // $dotts = $this->motdottuyensinh();
        if($dotts){
           $check =  DB::table('24_trungtuyen')
            ->where('iddot',$dotts)
            ->where('id_taikhoan',$id_taikhoan)
            ->first();
            if($check){
                return  $check->id_taikhoan;
            }else{
                return 'tt_0';
            }
        }else{
            return 'dot_0';
        }
    }
    //Danh sách thu hồ sơ thí sinh
    function danhsachthuhoso(){
        return view('user_24.admin24.manage.quanlyhoso.danhsachthuhoso',
            [

                'menu' =>  $this->sidebar()
            ]
        );
    }


    // function thuhoso_id_table(){
    //     return array(

    //     )
    // }




    function data_tb($header,$header_text) {
        $data = [];
        foreach ($header as $row_h) {
            // foreach ($body as $row_b) {
            //     if($row_h->id == )
                $data[$row_h->$header_text] = '1111111';
            // }
        }


        return response()->json($data);
    }

    function thuhoso_load_tb(){
        $header = DB::select(
            'SELECT id, loaihoso FROM 24_danhmuc_hsts
                WHERE trangthai = 1
                UNION ALL
                SELECT 0 AS id, "MSSV" AS loaihoso
                UNION ALL
                SELECT -1 AS id, "Ten" AS loaihoso;'
            );
        return $this->data_tb($header,'loaihoso');
    }


























                //Quản lý thí sinh

    //Danh sách thí sinh
    public function dsts(){
        $url = URL::current();
        $quyen = $this->kiemtraquyen_url($url);
        if ($quyen == 1) {
            return view('user_24.admin24.manage.quanlythisinh.dsts',
                [
                    'menu' =>    $this->sidebar(),
                ]
            );
        } else {
            return view('user_24.admin24.include.404');
        }
    }

    function dsts_loadtimkiem(){
        $gioitinh = array(
            [
                'id' => -1,
                'text' => "Chọn Giới tính"
            ],
            [
                'id' => 0,
                'text' => "Nam"
            ],
            [
                'id' => 1,
                'text' => "Nữ"
            ]
        );
        $trangthainv = array(
            [
                'id' => 0,
                'text' => "Chọn Trạng thái"
            ],
            [
                'id' => 1,
                'text' => "Đã đăng ký NV"
            ],
            [
                'id' => 2,
                'text' => "Chưa đăng ký NV"
            ]
        );
        $trangthailephi = array(
            [
                'id' => 0,
                'text' => "Chọn Trạng thái"
            ],
            [
                'id' => 1,
                'text' => "Đã thanh toán"
            ],
            [
                'id' => 2,
                'text' => "Chưa thanh toán đủ"
            ],
            [
                'id' => 3,
                'text' => "Chưa thanh toán"
            ],
        );
        return array(
            'dsts_namtuyensinh' => $this->load_seclectbox('24_danhmuc_namtuyensinh','id','namtuyensinh',0,'Chọn Năm tuyển sinh'),
            'dsts_namtotnghiep' => $this->load_seclectbox('24_danhmuc_namtotnghiep','id_nam','namtotnghiep',0,'Chọn Năm TN'),
            'dsts_dottuyensinh' => $this->load_seclectbox('24_dottuyensinh','id','tendot',0,'Chọn Đợt tuyển sinh'),
            'dsts_tinh' => $this->load_seclectbox('l_province','id','name_province',0,'Chọn Tỉnh'),
            'dsts_dknv' => $trangthainv,
            'dsts_ttlephi' => $trangthailephi,
            'dsts_gioitinh' => $gioitinh,

        );
    }

    function dsts_loadds($namts,$dotts,$namtn,$tinh,$truong,$ngaydangky1,$ngaydangky2,$gioitinh){
        $data = DB::table('24_thongtincanhan')
        ->select(
            '24_namtotnghiep.namtotnghiep',
            '24_thongtincanhan.id_taikhoan',
            '24_thongtincanhan.cccd',
            '24_thongtincanhan.hoten',
            '24_thongtincanhan.ngaysinh',
            '24_thongtincanhan.gioitinh',
            'l_province.name_province',
            'l_school.name_school',
            DB::raw('ROW_NUMBER() OVER (ORDER BY 24_thongtincanhan.id_taikhoan) AS stt')
        )
        ->join('24_namtotnghiep', '24_thongtincanhan.id_taikhoan', '24_namtotnghiep.id_taikhoan')
        ->join(DB::raw('(SELECT * FROM 24_truongthpt WHERE id_lop = 12) AS truong'), '24_thongtincanhan.id_taikhoan', 'truong.id_taikhoan')
        ->join('l_province', 'l_province.id', '=', 'truong.id_tinh')
        ->join('l_school', 'l_school.id', '=', 'truong.id_truong')
        ->whereIn('24_thongtincanhan.id_taikhoan', function($query) use ($namts) {
            $query->select('id_taikhoan')
            ->from('24_nguyenvong')
            ->where(function($query1) use ($namts) {
                if ($namts == 0) {
                    $query1->whereNotNull('24_nguyenvong.idnam');
                } else {
                    $query1->where('24_nguyenvong.idnam', $namts);
                }
            });
        })
        ->whereIn('24_thongtincanhan.id_taikhoan', function($query) use ($dotts) {
            $query->select('id_taikhoan')
            ->from('24_nguyenvong')
            ->where(function($query1) use ($dotts) {
                if ($dotts == 0) {
                    $query1->whereNotNull('24_nguyenvong.iddot');
                } else {
                    $query1->where('24_nguyenvong.iddot', $dotts);
                }
            });
        })
        ->where(function($query) use ($namtn) {
            if ($namtn == 0) {
                $query->whereNotNull('24_namtotnghiep.namtotnghiep');
            } else {
                $query->where('24_namtotnghiep.namtotnghiep', $namtn);
            }
        })
        ->where(function($query) use ($tinh) {
            if ($tinh != 0) {
                $query->where('truong.id_tinh', $tinh);
            }
        })
        ->where(function($query) use ($truong) {
            if ($truong != 0) {
                $query->where('truong.id_truong', $truong);
            }
        })
        ->where(function($query) use ($ngaydangky1,$ngaydangky2) {
            if ($ngaydangky1 == 0 || $ngaydangky2 == 0) {
                $query->whereNotNull('24_thongtincanhan.id_taikhoan');
            } else {
                $query->whereBetween('24_thongtincanhan.create_at', [Carbon::createFromFormat('Y-m-d', $ngaydangky1)->startOfDay(),Carbon::createFromFormat('Y-m-d', $ngaydangky2)->endOfDay()]);
            }
        })
        ->where(function($query) use ($gioitinh) {
            if ($gioitinh == -1) {
                $query->whereNotNull('24_thongtincanhan.gioitinh');
            } else {
                $query->where('24_thongtincanhan.gioitinh', $gioitinh);
            }
        })
        ->get();
        return response()->json($data);
    }

    function dsts_change_tinh($tinh){
        return array(
            'dsts_truongthpt' => $this->load_muti_seclectbox('l_school','id','name_school','id_province',$tinh,'Chọn Trường THPT'),
        );
    }


    function dsts_excel($namts,$dotts,$namtn,$tinh,$truong,$ngaydangky1,$ngaydangky2,$gioitinh){
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $title = 'DanhSachThiSinh' . date("d-m-Y H:i:s") . '.xlsx';

        // //Xuất Excel
        return Excel::download(new Admin24_Dsts_Excel($namts,$dotts,$namtn,$tinh,$truong,$ngaydangky1,$ngaydangky2,$gioitinh), $title);
    }

    //Thống kê đăng ký
    public function thongkedangky()
    {
        $url = URL::current();
        $quyen = $this->kiemtraquyen_url($url);
        if ($quyen == 1) {
            return view('user_24.admin24.manage.quanlythisinh.thongkedangky',
                [
                    'slthisinh'         => $this->slthisinh(),
                    'slnguyenvong'      => $this->slnguyenvong(),
                    'slkhoanguyenvong'  => $this->slkhoanguyenvong(),
                    'slthisinhlephi'    => $this->slthisinhlephi(),
                    'tongtien'          => $this->tongtien(),
                    'nv1'               => $this->nguyenvong(1),
                    'nv2'               => $this->nguyenvong(2),
                    'nv3'               => $this->nguyenvong(3),
                    // 'bieudonguyenvong'  => $bieudonguyenvong,
                    'sldangnhap'        => $this->sldangnhap(),
                    // 'sldangnhap'        => $this->sldangnhap(),
                    'taikhoandangnhap'  => $this->taikhoandangnhap(),
                    'tiledangnhaplai'   => $this->rpr(),
                    'tongclick' => $this->tongclick(),
                    'taikhoan' => $this->taikhoan(),
                    'chitieu' =>    $this->chitieu(),
                    // 'menu' =>    $this->menu(),
                    'menu' =>    $this->sidebar(),
                    // 'uri' => $url[0],
                ]
            );
        } else {
            return view('user_24.admin24.include.404');
        }
    }


            //Quản lý xét tuyển
        //Danh sách xét tuyển
    //Load index
    function danhsachxettuyen(){
        $url = URL::current();
        $quyen = $this->kiemtraquyen_url($url);
        if ($quyen == 1) {
            return view('user_24.admin24.manage.quanlyxettuyen.danhsachxettuyen',
                [
                    'menu' =>    $this->sidebar(),
                ]
            );
        } else {
            return view('user_24.admin24.include.404');
        }
    }

    //Load điều kiện
    function dieukien($dieukien){
        $data = json_decode($dieukien);
        $arrdieukien = [];
        foreach ($data as $key => $value) {
            $value == -1 ?  $arrdieukien[] = [$key,">",$value] :  $arrdieukien[] = [$key,"=",$value];
        }
        return $arrdieukien;
    }
    //Load danh sách ngguyện vọng
    function danhsach_nv($dieukien){
        $nguyenvong = DB::table('24_nguyenvong')
        ->select('24_namtotnghiep.namtotnghiep', '24_nguyenvong.trangthaixettuyen',DB::raw('ROW_NUMBER() OVER (ORDER BY id) AS sothutu'),DB::raw('CONCAT(name_policy_user,"(",mark_policy_user,")") as name_policy_user'),DB::raw('CONCAT(id_priority_area,"(",mark_priority,")") as id_priority_area' ),'l_group.id_group','24_nguyenvong.thutu','24_thongtincanhan.id_taikhoan as id_taikhoan','24_nguyenvong.id','24_nguyenvong.diemuutien','24_chuyennganh.tenchuyennganh','24_nguyenvong.diemtohop','24_nguyenvong.diemxettuyen','24_nguyenvong.idphuongthuc','24_thongtincanhan.hoten')
        ->join('l_group','l_group.id','24_nguyenvong.tohop')
        ->join('24_chuyennganh','24_chuyennganh.id','24_nguyenvong.id_chuyennganh')
        ->leftJoin('24_thongtincanhan','24_thongtincanhan.id_taikhoan','24_nguyenvong.id_taikhoan')
        ->leftJoin('24_khuvucuutien','24_khuvucuutien.id_taikhoan','24_nguyenvong.id_taikhoan')
        ->leftJoin('l_priority_area','l_priority_area.id','24_khuvucuutien.khuvucuutien')
        ->leftJoin('24_doituonguutien','24_doituonguutien.id_taikhoan','24_nguyenvong.id_taikhoan')
        ->leftJoin('l_policy_users','l_policy_users.id','24_doituonguutien.id_doituong')
        ->leftJoin('24_kiemtrahoso','24_kiemtrahoso.id_taikhoan','24_nguyenvong.id_taikhoan')
        ->leftJoin('24_namtotnghiep','24_namtotnghiep.id_taikhoan','24_nguyenvong.id_taikhoan')
        ->where($this->dieukien($dieukien))
        ->get();
        return  $nguyenvong;
    }
    //Load danhsach
    function danhsachnguyenvong($dieukien){
        $nguyenvong = $this->danhsach_nv($dieukien);
        $json_data['data'] = $nguyenvong;
        $data = json_encode($json_data);
        return $data;
    }
    //Duyệt danh sách xét tuyển
    function duyetdanhsachxetuyentuyentheodot(Request $request){
        $dieukien = $request->input('dieukien');
        $dottuyensinh = $request->input('iddot');
        //Phân quyền
        $time = $request->input('time');
        $id_manhinh = $request->input('id_manhinh');
        $id_chucnang = $request->input('id_chucnang');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            $kiemtrakhoadottuyensinh = $this->kiemtrakhoadottuyensinh($dottuyensinh);
            if( $kiemtrakhoadottuyensinh == 0){
                $nguyenvong = $this->danhsach_nv($dieukien);
                if(count($nguyenvong) > 0){
                    $idNguyenvongList = $nguyenvong->pluck('id')->toArray();
                    DB::table('24_nguyenvong')->whereIn('id', $idNguyenvongList )->update(['trangthaixettuyen'=>1]);
                    $trangthai = 'xt_ds_1';
                }else{
                    $trangthai = 'table_0';
                }
            }else{
                $trangthai = 'dot_1';
            }
        }else{
            $trangthai = 'rol_2';
        }
        return $trangthai;
    }
    //Cap nhat theo tung thi sinh
    function trangthaidanhsachxettuyen(Request $request){
        $idnv = $request ->input('idnv');
        $check = $request->input('check');
        $dottuyensinh = $request->input('iddot');
        $trangthai = 1;
        $noidung = '';
        //Phân quyền
        $time = $request->input('time');
        $id_manhinh = $request->input('id_manhinh');
        $id_chucnang = $request->input('id_chucnang');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            if($idnv){
                try{
                    $kiemtrakhoadottuyensinh = $this->kiemtrakhoadottuyensinh($dottuyensinh);
                    if($kiemtrakhoadottuyensinh == 1){
                        $idthongbao = 'dot_1';
                    }else{
                        $upd = DB::table('24_nguyenvong')->where('id', $idnv )->update(['trangthaixettuyen'=>$check]);
                        if($upd == 1 ){
                            $idthongbao = 'upd_1';
                        }else{
                            $idthongbao = 'upd_2';
                        }
                    }
                    $noidung = DB::table('24_nguyenvong')->where('id',$idnv)->first()->trangthaixettuyen;
                }catch(Exception $e){
                    $idthongbao = 'upd_0';
                    $trangthai = 0;
                }
            }else{
                $idthongbao = 'find_no';
            }
        }else{
            $idthongbao = 'rol_2';
            $noidung = DB::table('24_nguyenvong')->where('id',$idnv)->first()->trangthaixettuyen;
            $trangthai = 1;
        }
        $res = array(
            'trangthai' =>  $trangthai,
            'noidung' => $noidung,
            'idthongbao' => $idthongbao,
        );
        return $res;
    }
    //Huy danh sách xét tuyển
    function resetsachxetuyentuyentheodot(Request $request){
        $iddot = $request->input('iddot');
        $kiemtrakhoadottuyensinh = $this->kiemtrakhoadottuyensinh($iddot);
        //Phân quyền
        $time = $request->input('time');
        $id_manhinh = $request->input('id_manhinh');
        $id_chucnang = $request->input('id_chucnang');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            if( $iddot == -1){
                return 'dot_-1';
            }else{
                if($kiemtrakhoadottuyensinh == 0){
                    DB::table('24_nguyenvong')->where('iddot',$iddot)->update(['trangthaixettuyen'=>0]);
                    return 'upd_1';
                }else{
                    return 'dot_1';
                }
            }

        }else{
            return 'rol_2';
        }
    }
    //Xuat danh sach
    function xuatexceldanhsachxettuyen($iddot,$dieukien,$time,$id_manhinh,$id_chucnang,$active){
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $title = 'DanhSacXetTuyen' . date("d-m-Y H:i:s") . '.xlsx';
        $nguyenvong = $this->danhsach_nv($dieukien);
        // //Xuất Excel
        return Excel::download(new Admin24_ExportDanhSacXetTuyen($nguyenvong), $title);
        // return $nguyenvong;
    }

        //Thuc hien xet tuyen
    //Load index
    function thuchienxettuyen(){
        $url = URL::current();
        $quyen = $this->kiemtraquyen_url($url);
        if ($quyen == 1) {
            return view('user_24.admin24.manage.quanlyxettuyen.thuchienxettuyen',
                [
                    'menu' =>    $this->sidebar(),
                ]
            );
        } else {
            return view('user_24.admin24.include.404');
        }
    }
    function sql_danhsachtrungtuyen($iddot){
        // $iddot = 1;
        // $major = DB::table('24_chuyennganh_xettuyen')->where('iddot',$iddot)->get();
        $sql = "";
        $cauhinh = 1;
        // if(count($major) > 0){
            if($cauhinh == 1){//Chuyên ngành
                $join = '24_chuyennganh cn ON cn.id = cnx.id_chuyennganh';
            }else{
                $join = 'l_major ON l_major.id = 24_chuyennganh_xettuyen.id_nganh';
            }
            $sql .= "SELECT
            ROW_NUMBER() OVER (ORDER BY nv.id) AS sothutu,
            acc.id AS idts,
            nv.id AS idnv,
            ttcn.hoten AS hoten,
            ttcn.dienthoai AS dienthoai,
            ttcn.email_phu AS email_phu,
            acc.email AS email,
            nv.thutu AS thutu,
            ttcn.dienthoai,
            khu.id_priority_area,
            dt.name_policy_user,
            cn.tenchuyennganh AS tenchuyennganh,
            nv.diemtohop,
            nv.diemuutien,
            nv.diemxettuyen
            FROM
                24_trungtuyen nv
            LEFT JOIN
                24_thongtincanhan ttcn ON ttcn.id_taikhoan = nv.id_taikhoan
            LEFT JOIN
                24_chuyennganh_xettuyen cnx ON cnx.id_chuyennganh = nv.id_chuyennganh
            LEFT JOIN
                account24s acc ON acc.id = nv.id_taikhoan
            LEFT JOIN
                (SELECT kv.id_taikhoan, lpa.id_priority_area
                FROM 24_khuvucuutien kv
                INNER JOIN l_priority_area lpa ON lpa.id = kv.khuvucuutien) AS khu ON khu.id_taikhoan = nv.id_taikhoan
            LEFT JOIN
                (SELECT dtu.id_taikhoan, lpu.name_policy_user
                FROM 24_doituonguutien dtu
                INNER JOIN l_policy_users lpu ON lpu.id = dtu.id_doituong) AS dt ON dt.id_taikhoan = nv.id_taikhoan
            INNER JOIN
                ".$join."
            WHERE nv.iddot = ".$iddot;
        // }
        $sql .= " ORDER BY nv.id_chuyennganh ASC, diemxettuyen DESC";
        return $sql;
    }
    function danhsachtrungtuyentheodotts($iddot){
        $json_data['data'] = DB::select($this->sql_danhsachtrungtuyen($iddot));
        $data = json_encode($json_data);
        return $data;
    }
    function sql_loadthongketrungtuyen($iddot){

        $id_admin = Auth::guard('loginadmin')->user()->id;
        $quyenvuotcap = Auth::guard('loginadmin')->user()->vuotquyen;
        if($quyenvuotcap == 1){
            $major = DB::select("SELECT id as id, tenchuyennganh as text, '' as selected FROM 24_chuyennganh");

        }else{
            $major = DB::select("SELECT id as id, tenchuyennganh as text, '' as selected FROM 24_chuyennganh WHERE id IN (SELECT id_chuyennganh FROM 24_covanhoctap WHERE id_taikhoan_dangnhap = ?)",[$id_admin]);
        }
        $ids = array_column($major, 'id');
        $chuyennganh = '';
        foreach ( $ids  as $key => $value) {
            $chuyennganh .= $value.',';
        }
        $chuyennganh = rtrim($chuyennganh , ',');

        $sql = "SELECT ROW_NUMBER() OVER (ORDER BY cnxt.id) AS sothutu,
            24_chuyennganh.tenchuyennganh AS tenchuyennganh,
            cnxt.soluong_chuyennganh AS chitieu,
            nguyenvong.sldk AS soluongdangky,
            nguyenvong1.slnv1 AS soluongnv1,
            IF(cnxt.soluong_chuyennganh IS NULL OR cnxt.soluong_chuyennganh = 0, 0, IF(nguyenvong1.slnv1 IS NULL, 0, ROUND(nguyenvong1.slnv1 / cnxt.soluong_chuyennganh * 100, 1))) AS tilenv1,
            nguyenvong2.slnv2 AS soluongnv2,
            nguyenvong3.slnv3 AS soluongnv3,
            IF(trungtuyen.sltt IS NULL, 0, trungtuyen.sltt) AS soluongtrungtuyen,
            IF(cnxt.soluong_chuyennganh IS NULL OR cnxt.soluong_chuyennganh = 0, 0, IF(trungtuyen.sltt IS NULL, 0, ROUND(trungtuyen.sltt / cnxt.soluong_chuyennganh * 100, 1))) AS tiletrungtuyen,
            ROUND(IF(diemchuan IS NULL, 0, diemchuan), 2) AS diemchuan,
            ROUND(IF(xacnhan.slxn IS NULL, 0, xacnhan.slxn), 2) AS soluongxacnhan,
            IF(cnxt.soluong_chuyennganh IS NULL OR cnxt.soluong_chuyennganh = 0, 0, IF(xacnhan.slxn IS NULL, 0, ROUND(xacnhan.slxn / cnxt.soluong_chuyennganh * 100, 1))) AS tilexacnhan,
            ROUND(IF(sinhvien.slsv IS NULL, 0, sinhvien.slsv), 2) AS soluongnhaphoc,
            IF(cnxt.soluong_chuyennganh IS NULL OR cnxt.soluong_chuyennganh  = 0, 0, IF(sinhvien.slsv IS NULL, 0, ROUND(sinhvien.slsv / cnxt.soluong_chuyennganh * 100, 1))) AS tilenhaphoc,
            ROUND(IF(xacnhanbo.slxnbo IS NULL, 0, xacnhanbo.slxnbo), 2) AS soluongxacnhanbo,
            IF(cnxt.soluong_chuyennganh IS NULL OR cnxt.soluong_chuyennganh  = 0, 0, IF(xacnhanbo.slxnbo IS NULL, 0, ROUND(xacnhanbo.slxnbo / cnxt.soluong_chuyennganh * 100, 1))) AS tilexacnhanbo,
            ROUND(IF(dieutra.sldieutra IS NULL, 0, dieutra.sldieutra), 2) AS soluongdieutra
        FROM
            24_chuyennganh_xettuyen cnxt
        INNER JOIN
            24_chuyennganh ON 24_chuyennganh.id = cnxt.id_chuyennganh
        LEFT JOIN
            (SELECT tt.id_chuyennganh, COUNT(*) AS sltt, MIN(tt.diemxettuyen) AS diemchuan
            FROM `24_trungtuyen` tt
            WHERE tt.iddot = ".$iddot."
            GROUP BY tt.id_chuyennganh) AS trungtuyen ON cnxt.id_chuyennganh = trungtuyen.id_chuyennganh
        LEFT JOIN
            (SELECT nv.id_chuyennganh, COUNT(*) AS sldk
            FROM `24_nguyenvong` nv
            WHERE nv.iddot = ".$iddot." AND nv.trangthaixettuyen = 1
            GROUP BY nv.id_chuyennganh) AS nguyenvong ON cnxt.id_chuyennganh = nguyenvong.id_chuyennganh
        LEFT JOIN
            (SELECT nv1.id_chuyennganh, COUNT(*) AS slnv1
            FROM `24_nguyenvong` nv1
            WHERE nv1.iddot = ".$iddot." AND nv1.trangthaixettuyen = 1 AND nv1.thutu = 1
            GROUP BY nv1.id_chuyennganh) AS nguyenvong1 ON cnxt.id_chuyennganh = nguyenvong1.id_chuyennganh
        LEFT JOIN
            (SELECT nv2.id_chuyennganh, COUNT(*) AS slnv2
            FROM `24_nguyenvong` nv2
            WHERE nv2.iddot = ".$iddot." AND nv2.trangthaixettuyen = 1 AND nv2.thutu = 2
            GROUP BY nv2.id_chuyennganh) AS nguyenvong2 ON cnxt.id_chuyennganh = nguyenvong2.id_chuyennganh
        LEFT JOIN
            (SELECT nv3.id_chuyennganh, COUNT(*) AS slnv3
            FROM `24_nguyenvong` nv3
            WHERE nv3.iddot = ".$iddot." AND nv3.trangthaixettuyen = 1 AND nv3.thutu = 3
            GROUP BY nv3.id_chuyennganh) AS nguyenvong3 ON cnxt.id_chuyennganh = nguyenvong3.id_chuyennganh
        LEFT JOIN
            (SELECT xnnh.id_chuyennganh, COUNT(*) AS slxn
            FROM `24_trungtuyen` xnnh
            WHERE xnnh.iddot = ".$iddot." AND xnnh.xacnhan = 1
            GROUP BY xnnh.id_chuyennganh) AS xacnhan ON cnxt.id_chuyennganh = xacnhan.id_chuyennganh
        LEFT JOIN
            (SELECT sv.id_chuyennganh, COUNT(*) AS slsv
            FROM (SELECT 24_trungtuyen.id_chuyennganh,24_trungtuyen.id_taikhoan FROM 24_trungtuyen INNER JOIN 24_mssv ON 24_mssv.id_taikhoan = 24_trungtuyen.id_taikhoan
                WHERE 24_mssv.iddotts = ".$iddot." AND 24_trungtuyen.iddot = ".$iddot.") as sv
            GROUP BY sv.id_chuyennganh) AS sinhvien ON cnxt.id_chuyennganh = sinhvien.id_chuyennganh
        LEFT JOIN
            (SELECT xnbo.id_chuyennganh, COUNT(*) AS slxnbo
            FROM (SELECT 24_trungtuyen.id_chuyennganh,24_trungtuyen.id_taikhoan FROM 24_trungtuyen INNER JOIN 24_xacnhanbo ON 24_xacnhanbo.id_taikhoan = 24_trungtuyen.id_taikhoan
                WHERE 24_xacnhanbo.iddotts = ".$iddot." AND 24_trungtuyen.iddot = ".$iddot.") as xnbo
            GROUP BY xnbo.id_chuyennganh) AS xacnhanbo ON cnxt.id_chuyennganh = xacnhanbo.id_chuyennganh
        LEFT JOIN
            (SELECT dt.id_chuyennganh, COUNT(*) AS sldieutra
            FROM 24_trungtuyen dt
            WHERE dt.iddot = ".$iddot." AND dt.trangthaidieutra = 1 AND id_taikhoan NOT IN (SELECT 24_mssv.id_taikhoan FROM 24_mssv WHERE 24_mssv.iddotts = ".$iddot.")
            GROUP BY dt.id_chuyennganh) AS dieutra ON cnxt.id_chuyennganh = dieutra.id_chuyennganh
        WHERE
            cnxt.iddot = ".$iddot." AND cnxt.id_chuyennganh IN (".$chuyennganh.")
        UNION ALL
        (
        SELECT
            NULL AS sothutu,
            'Tổng' AS tenchuyennganh,
            SUM(cnxt.soluong_chuyennganh) AS chitieu,
            SUM(nguyenvong.sldk) AS soluongdangky,
            SUM(nguyenvong1.slnv1) AS soluongnv1,
            IF(SUM(cnxt.soluong_chuyennganh) IS NULL OR SUM(cnxt.soluong_chuyennganh) = 0, 0, IF(SUM(nguyenvong1.slnv1) IS NULL, 0, ROUND(SUM(nguyenvong1.slnv1) / SUM(cnxt.soluong_chuyennganh) * 100, 1))) AS tilenv1,
            SUM(nguyenvong2.slnv2) AS soluongnv2,
            SUM(nguyenvong3.slnv3) AS soluongnv3,
            SUM(IF(trungtuyen.sltt IS NULL, 0, trungtuyen.sltt)) AS soluongtrungtuyen,
            IF(SUM(cnxt.soluong_chuyennganh) = 0, 0, ROUND(SUM(IF(trungtuyen.sltt IS NULL, 0, trungtuyen.sltt)) / SUM(cnxt.soluong_chuyennganh) * 100, 1)) AS tiletrungtuyen,
            ROUND(SUM(IF(diemchuan IS NULL, 0, diemchuan)), 2) AS diemchuan,
            ROUND(SUM(IF(xacnhan.slxn IS NULL, 0, xacnhan.slxn)), 2) AS soluongxacnhan,
            IF(SUM(cnxt.soluong_chuyennganh) = 0, 0, ROUND(SUM(IF(xacnhan.slxn IS NULL, 0, xacnhan.slxn)) / SUM(cnxt.soluong_chuyennganh) * 100, 1)) AS tilexacnhan,
            ROUND(SUM(IF(sinhvien.slsv IS NULL, 0, sinhvien.slsv)), 2) AS soluongnhaphoc,
            IF(SUM(cnxt.soluong_chuyennganh) = 0, 0, ROUND(SUM(IF(sinhvien.slsv IS NULL, 0, sinhvien.slsv)) / SUM(cnxt.soluong_chuyennganh) * 100, 1)) AS tilenhaphoc,
            ROUND(SUM(IF(xacnhanbo.slxnbo IS NULL, 0,xacnhanbo.slxnbo)), 2) AS soluongxacnhanbo,
            IF(SUM(cnxt.soluong_chuyennganh) = 0, 0, ROUND(SUM(IF(xacnhanbo.slxnbo IS NULL, 0, xacnhanbo.slxnbo)) / SUM(cnxt.soluong_chuyennganh) * 100, 1)) AS tilexacnhanbo,
            ROUND(SUM(IF(dieutra.sldieutra IS NULL, 0,dieutra.sldieutra)), 2) AS soluongdieutra
            FROM
            24_chuyennganh_xettuyen cnxt
        INNER JOIN
            24_chuyennganh ON 24_chuyennganh.id = cnxt.id_chuyennganh
        LEFT JOIN
            (SELECT tt.id_chuyennganh, COUNT(*) AS sltt, MIN(tt.diemxettuyen) AS diemchuan
            FROM `24_trungtuyen` tt
            WHERE tt.iddot = ".$iddot."
            GROUP BY tt.id_chuyennganh) AS trungtuyen ON cnxt.id_chuyennganh = trungtuyen.id_chuyennganh
        LEFT JOIN
            (SELECT nv.id_chuyennganh, COUNT(*) AS sldk
            FROM `24_nguyenvong` nv
            WHERE nv.iddot = ".$iddot." AND nv.trangthaixettuyen = 1
            GROUP BY nv.id_chuyennganh) AS nguyenvong ON cnxt.id_chuyennganh = nguyenvong.id_chuyennganh
        LEFT JOIN
            (SELECT nv1.id_chuyennganh, COUNT(*) AS slnv1
            FROM `24_nguyenvong` nv1
            WHERE nv1.iddot = ".$iddot." AND nv1.trangthaixettuyen = 1 AND nv1.thutu = 1
            GROUP BY nv1.id_chuyennganh) AS nguyenvong1 ON cnxt.id_chuyennganh = nguyenvong1.id_chuyennganh
        LEFT JOIN
            (SELECT nv2.id_chuyennganh, COUNT(*) AS slnv2
            FROM `24_nguyenvong` nv2
            WHERE nv2.iddot = ".$iddot." AND nv2.trangthaixettuyen = 1 AND nv2.thutu = 2
            GROUP BY nv2.id_chuyennganh) AS nguyenvong2 ON cnxt.id_chuyennganh = nguyenvong2.id_chuyennganh
        LEFT JOIN
            (SELECT nv3.id_chuyennganh, COUNT(*) AS slnv3
            FROM `24_nguyenvong` nv3
            WHERE nv3.iddot = ".$iddot." AND nv3.trangthaixettuyen = 1 AND nv3.thutu = 3
            GROUP BY nv3.id_chuyennganh) AS nguyenvong3 ON cnxt.id_chuyennganh = nguyenvong3.id_chuyennganh
        LEFT JOIN
            (SELECT xnnh.id_chuyennganh, COUNT(*) AS slxn
            -- FROM `24_xacnhannhaphoc` xnnh
            FROM `24_trungtuyen` xnnh
            WHERE xnnh.iddot = ".$iddot." AND xnnh.xacnhan = 1
            GROUP BY xnnh.id_chuyennganh) AS xacnhan ON cnxt.id_chuyennganh = xacnhan.id_chuyennganh
        LEFT JOIN
            (SELECT sv.id_chuyennganh, COUNT(*) AS slsv
            FROM (SELECT 24_trungtuyen.id_chuyennganh,24_trungtuyen.id_taikhoan FROM 24_trungtuyen INNER JOIN 24_mssv ON 24_mssv.id_taikhoan = 24_trungtuyen.id_taikhoan
                WHERE 24_mssv.iddotts = ".$iddot." AND 24_trungtuyen.iddot = ".$iddot.") as sv
            GROUP BY sv.id_chuyennganh) AS sinhvien ON cnxt.id_chuyennganh = sinhvien.id_chuyennganh
        LEFT JOIN
            (SELECT xnbo.id_chuyennganh, COUNT(*) AS slxnbo
            FROM (SELECT 24_trungtuyen.id_chuyennganh,24_trungtuyen.id_taikhoan FROM 24_trungtuyen INNER JOIN 24_xacnhanbo ON 24_xacnhanbo.id_taikhoan = 24_trungtuyen.id_taikhoan
                WHERE 24_xacnhanbo.iddotts = ".$iddot." AND 24_trungtuyen.iddot = ".$iddot.") as xnbo
            GROUP BY xnbo.id_chuyennganh) AS xacnhanbo ON cnxt.id_chuyennganh = xacnhanbo.id_chuyennganh
        LEFT JOIN
            (SELECT dt.id_chuyennganh, COUNT(*) AS sldieutra
            FROM 24_trungtuyen dt
            WHERE dt.iddot = ".$iddot." AND dt.trangthaidieutra = 1 AND id_taikhoan NOT IN (SELECT 24_mssv.id_taikhoan FROM 24_mssv WHERE 24_mssv.iddotts = ".$iddot.")
            GROUP BY dt.id_chuyennganh) AS dieutra ON cnxt.id_chuyennganh = dieutra.id_chuyennganh
        WHERE
            cnxt.iddot = ".$iddot." AND cnxt.id_chuyennganh IN (".$chuyennganh."))";
        return $sql;
    }
    function thongketrungtuyentheodotts($iddot){
        $json_data['data'] = DB::select($this->sql_loadthongketrungtuyen($iddot));
        $data = json_encode($json_data);
        return $data;
    }
    function xuatexcelthongketrungtuyentheodotts($iddot){
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $title = 'DanhSachTrungTuyenTheoDotTS' . date("d-m-Y H:i:s") . '.xlsx';
        $nguyenvong = DB::select($this->sql_loadthongketrungtuyen($iddot));
        return Excel::download(new Admin24_ExportDanhSachTrungTuyenTheoDotTS($nguyenvong), $title);
    }
    //Select
    function load_phodiem_nganh($iddot){
        $data = DB::table('24_chuyennganh_xettuyen')
        ->select('24_chuyennganh.id as id','24_chuyennganh.tenchuyennganh as text')
        ->join('24_chuyennganh','24_chuyennganh.id','24_chuyennganh_xettuyen.id_chuyennganh')
        ->where('iddot',$iddot)
        ->get();
        // Tạo một đối tượng stdClass mới cho hàng 'Tất cả ngành/chuyên ngành'
        $allBranches = new \stdClass();
        $allBranches->id = 0;
        $allBranches->text = 'Tất cả ngành/chuyên ngành';
        // Chèn đối tượng vào đầu mảng kết quả
        $data->prepend($allBranches);
        return $data;
    }

    function sql_phodiemtheodotts($iddot,$idnguyenvong,$khoangdiem,$id_nganh){
        if($idnguyenvong == 0){
            $nguyenvong = 'thutu is not null';
        }else{
            $nguyenvong = "thutu = ".(int)$idnguyenvong;
        }
        if($id_nganh == 0){
            $nganh = 'id_chuyennganh is not null';
        }else{
            $nganh = 'id_chuyennganh = '.$id_nganh;
        }
        $sql = "SELECT
                CONCAT('[', ROUND(diemxettuyen_min,2), '-', ROUND(diemxettuyen_min + ".$khoangdiem.",2), ')') AS label,
                COUNT(*) AS value
            FROM (
                SELECT
                    diemxettuyen,
                    FLOOR(diemxettuyen / ".$khoangdiem.") * ".$khoangdiem." AS diemxettuyen_min
                FROM
                    24_nguyenvong
                WHERE trangthaixettuyen = 1 AND ".$nguyenvong." AND iddot = ".$iddot." AND ".$nganh."
            ) AS grouped_data
            GROUP BY
                diemxettuyen_min
            ORDER BY
                diemxettuyen_min;";
        return $sql;
    }

    function phodiemtheodotts($iddot,$nguyenvong,$khoangdiem,$id_nganh){
        if($khoangdiem > 0 && $khoangdiem <= 3 ){
            $json_data['data'] = DB::select($this->sql_phodiemtheodotts($iddot,$nguyenvong,$khoangdiem,$id_nganh));
            $data = json_encode($json_data);
        }
        return $data;
    }
    function laydulieutheodot($iddotts, $iddotxt){
        $iddotts = $this->dotchayxettuyen();
        DB::beginTransaction();
        try{
        $sql1 = "INSERT INTO `24_danhsachxettuyentheodotxt` (
            `idnv`,
            `id_chuyennganh`,
            `id_taikhoan`,
            `diemxettuyen`,
            `idphuongthuc`,
            `tohop`,
            `thutu`,
            `diemuutien`,
            `diemtohop`,
            `iddot`,
            `idnam`,
            `iddotxt`,
            `trangthaixettuyen`,
            `ghichu`,
            `ttsom`,
            `idnganh`
            )
            SELECT
            `id`,
            `id_chuyennganh`,
            `id_taikhoan`,
            `diemxettuyen`,
            `idphuongthuc`,
            `tohop`,
            `thutu`,
            `diemuutien`,
            `diemtohop`,
            `iddot`,
            `idnam`,
            ? AS `iddotxt`,
            `trangthaixettuyen`,
            `ghichu`,
            `tts`,
            `idnganh`
            FROM 24_nguyenvong
            WHERE iddot = ?
            AND trangthaixettuyen = 1
            AND id NOT IN (SELECT idnv FROM 24_danhsachxettuyentheodotxt WHERE iddotxt = ?)
            AND id_taikhoan NOT IN (SELECT id_taikhoan FROM 24_trungtuyen WHERE iddot= ?)";
        $insertedRows1 = DB::affectingStatement($sql1, [$iddotxt,$iddotts,$iddotxt,$iddotts]);
        $sql2 = "INSERT INTO `24_chuyennganh_dotxettuyen` (
                `id_nganh_dotxt`,
                `id_nganh`,
                `id_chuyennganh`,
                `iddot`,
                `iddotxt`
                )
                SELECT
                `id`,
                `id_nganh`,
                `id_chuyennganh`,
                `iddot`,
                ? AS `iddotxt`
                FROM 24_chuyennganh_xettuyen
                WHERE iddot = ? AND id NOT IN (SELECT id_nganh_dotxt FROM 24_chuyennganh_dotxettuyen WHERE iddotxt = ?)";
            $insertedRows2 = DB::affectingStatement($sql2, [$iddotxt,$iddotts,$iddotxt]);
            DB::commit();
            return array(
                'trangthai' => 1,
                'insertedRows1' => $insertedRows1,
                'insertedRows2' => $insertedRows2,
            ) ;
        }catch(Exception $e){
            DB::rollBack();
            return array(
                'trangthai' => '-100',
                'insertedRows1' => "",
                'insertedRows2' => "",
            ) ;
        }
    }
    function khoadotxettuyen($iddotxt){
        $dotts = $this->dotchayxettuyen();
    }
    function xuatdanhsachlocao($iddotxt){
        $dotts = $this->dotchayxettuyen();
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $title = 'DanhSachTrungTuyenLocAo' . date("d-m-Y H:i:s") . '.xlsx';
        return Excel::download(new Admin24_ExportDanhSachLocAo($iddotxt, $dotts), $title);
    }
    function danhsach_thisinh_locao($iddotxt){
        $dotts = $this->dotchayxettuyen();
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $title = 'DanhSachChiTietTheoDot' . date("d-m-Y H:i:s") . '.xlsx';
        return Excel::download(new Admin24_DanhSachChiTietTheoDot($iddotxt, $dotts), $title);
    }
    function thongkeketqualocao($iddotxt){
        $dotts = $this->dotchayxettuyen();
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $title = 'ThongKeSoLuongTrungTuyenTaiTruongTheoNganh' . date("d-m-Y H:i:s") . '.xlsx';
        return Excel::download(new Admin24_ExportThongKeSoLuongTrungTuyen($iddotxt, $dotts), $title);
    }
    function xoaketqualocaonhom($dotts,$iddotxt){
        DB::table('24_danhsachxettuyentheodotxt')
        ->where('iddot',$dotts)
        ->where('iddotxt',$iddotxt)
        ->update([
            'trungtuyennhom' => 0,
        ]);
    }
    function submit_importketquanhom(Request $request)//Update hoặc tạo mới từ Dữ liệu Bộ, theo đợt tuyển sinh
    {
        $dotts = $this->dotchayxettuyen();
        $iddotxt =  $request->input('iddotxt');
        $this->xoaketqualocaonhom($dotts,$iddotxt);
        DB::beginTransaction();
        try{
            $data = Excel::toArray([], $request->file('ketquanhom'));
            $rows = $data[0];

            for ($i=2; $i <  count($rows) ; $i++) {
                $cccd_bo[] =  $rows[$i][4];
            }
            $id_bo = DB::table('24_thongtincanhan')
            ->select('24_danhsachxettuyentheodotxt.id as id','cccd','24_danhsachxettuyentheodotxt.id_taikhoan')
            ->join('24_danhsachxettuyentheodotxt','24_danhsachxettuyentheodotxt.id_taikhoan','24_thongtincanhan.id_taikhoan')
            ->where('iddot',$dotts)
            ->where('iddotxt',$iddotxt)
            ->where('trungtuyentam',1)
            ->whereIn('cccd',$cccd_bo)
            ->get();
            // return  $id_bo;
            for ($i = 2; $i< count($rows); $i++) {
                foreach ($id_bo as $value) {
                    if($value->cccd == $rows[$i][4]){
                        if($rows[$i][10] == 'Đỗ'){
                            $trungtuyennhom = 1;
                        }else{
                            $trungtuyennhom = 0;
                        }
                        $temp = array(
                            'id' => $value->id,
                            'id_taikhoan' => $value->id_taikhoan,
                            'trungtuyennhom' => $trungtuyennhom,
                            'thutu' => $rows[$i][9],
                        );
                        $data_impport[] = $temp;
                        break;
                    }
                }
            }

            DB::table('24_danhsachxettuyentheodotxt')
            ->upsert(
                $data_impport,
                ['id'],
                ['trungtuyennhom','id_taikhoan','thutu']
            );

            $this->locao($dotts, $iddotxt);
            DB::commit();
            return 'imp_1';
        }catch(Exception $e){
            DB::rollBack();
            return 'imp_0';
        }
    }
    function xoaketqualocaobo($dotts,$iddotxt){
        DB::table('24_danhsachxettuyentheodotxt')
        ->where('iddot',$dotts)
        ->where('iddotxt',$iddotxt)
        ->update([
            'trungtuyenbo' => 0,
        ]);
    }
    function submit_importketquabo(Request $request)//Update hoặc tạo mới từ Dữ liệu Bộ, theo đợt tuyển sinh
    {
        $dotts = $this->dotchayxettuyen();
        $iddotxt =  $request->input('iddotxt');
        $this->xoaketqualocaobo($dotts,$iddotxt);
        DB::beginTransaction();
        try{
            $data = Excel::toArray([], $request->file('ketquabo'));
            $rows = $data[0];

            for ($i=2; $i <  count($rows) ; $i++) {
                $cccd_bo[] =  $rows[$i][4];
            }
            $id_bo = DB::table('24_thongtincanhan')
            ->select('24_danhsachxettuyentheodotxt.id as id','cccd','24_danhsachxettuyentheodotxt.id_taikhoan')
            ->join('24_danhsachxettuyentheodotxt','24_danhsachxettuyentheodotxt.id_taikhoan','24_thongtincanhan.id_taikhoan')
            ->where('iddot',$dotts)
            ->where('iddotxt',$iddotxt)
            ->where('trungtuyentam',1)
            ->whereIn('cccd',$cccd_bo)
            ->get();
            // return  $id_bo;
            for ($i = 2; $i< count($rows); $i++) {
                foreach ($id_bo as $value) {
                    if($value->cccd == $rows[$i][4]){
                        if($rows[$i][10] == 'Đỗ'){
                            $trungtuyenbo = 1;
                        }else{
                            $trungtuyenbo = 0;
                        }
                        $temp = array(
                            'id' => $value->id,
                            'id_taikhoan' => $value->id_taikhoan,
                            'trungtuyenbo' => $trungtuyenbo,
                            'thutu' => $rows[$i][9],
                        );
                        $data_impport[] = $temp;
                        break;
                    }
                }
            }

            DB::table('24_danhsachxettuyentheodotxt')
            ->upsert(
                $data_impport,
                ['id'],
                ['trungtuyenbo','id_taikhoan','thutu']
            );

            $this->locao($dotts, $iddotxt);
            DB::commit();
            return 'imp_1';
        }catch(Exception $e){
            DB::rollBack();
            return 'imp_0';
        }
    }
    function sql_thongketheodotxettuyen(){
        $sql = "SELECT
            24_chuyennganh_dotxettuyen.id as id,
            24_chuyennganh_dotxettuyen.id_chuyennganh as id_chuyennganh,
            ROW_NUMBER() OVER (ORDER BY 24_chuyennganh.id) AS sothutu,
            24_chuyennganh.tenchuyennganh,
            nguyenvong1.nv1 as nv1,
            nguyenvong2.nv2 as nv2,
            nguyenvong3.nv3 as nv3,
            24_chuyennganh_dotxettuyen.soluong_chuyennganh
            FROM 24_chuyennganh_dotxettuyen
            JOIN 24_chuyennganh ON 24_chuyennganh.id = 24_chuyennganh_dotxettuyen.id_chuyennganh
            LEFT JOIN
                (SELECT id_chuyennganh, COUNT(*) as nv1 FROM 24_danhsachxettuyentheodotxt
                    WHERE
                    thutu = 1
                    AND iddot = ?
                    AND iddotxt = ?
                    GROUP BY id_chuyennganh) AS nguyenvong1
                ON 24_chuyennganh_dotxettuyen.id_chuyennganh = nguyenvong1.id_chuyennganh
            LEFT JOIN
                (SELECT id_chuyennganh, COUNT(*) as nv2 FROM 24_danhsachxettuyentheodotxt
                    WHERE
                    thutu = 2
                    AND iddot = ?
                    AND iddotxt = ?
                    GROUP BY id_chuyennganh) AS nguyenvong2
                ON 24_chuyennganh_dotxettuyen.id_chuyennganh = nguyenvong2.id_chuyennganh
            LEFT JOIN
                (SELECT id_chuyennganh, COUNT(*) as nv3 FROM 24_danhsachxettuyentheodotxt
                    WHERE
                    thutu = 3
                    AND iddot = ?
                    AND iddotxt = ?
                    GROUP BY id_chuyennganh) AS nguyenvong3
                ON 24_chuyennganh_dotxettuyen.id_chuyennganh = nguyenvong3.id_chuyennganh
            WHERE
                24_chuyennganh_dotxettuyen.iddot = ?
                AND 24_chuyennganh_dotxettuyen.iddotxt = ?
            UNION ALL
            (
                SELECT
                    -1000 AS id,
                    -1000 as id_chuyennganh,
                    NULL AS sothutu,
                    'Tổng' AS tenchuyennganh,
                    SUM(nguyenvong1.nv1) as nv1,
                    SUM(nguyenvong2.nv2) as nv2,
                    SUM(nguyenvong3.nv3) as nv3,
                    SUM(24_chuyennganh_dotxettuyen.soluong_chuyennganh) as soluong_chuyennganh
                    FROM 24_chuyennganh_dotxettuyen
                    JOIN 24_chuyennganh ON 24_chuyennganh.id = 24_chuyennganh_dotxettuyen.id_chuyennganh
                LEFT JOIN
                    (SELECT id_chuyennganh, COUNT(*) as nv1 FROM 24_danhsachxettuyentheodotxt
                        WHERE
                        thutu = 1
                        AND iddot = ?
                        AND iddotxt = ?
                        GROUP BY id_chuyennganh) AS nguyenvong1
                    ON 24_chuyennganh_dotxettuyen.id_chuyennganh = nguyenvong1.id_chuyennganh
                LEFT JOIN
                    (SELECT id_chuyennganh, COUNT(*) as nv2 FROM 24_danhsachxettuyentheodotxt
                        WHERE
                        thutu = 2
                        AND iddot = ?
                        AND iddotxt = ?
                        GROUP BY id_chuyennganh) AS nguyenvong2
                    ON 24_chuyennganh_dotxettuyen.id_chuyennganh = nguyenvong2.id_chuyennganh
                LEFT JOIN
                    (SELECT id_chuyennganh, COUNT(*) as nv3 FROM 24_danhsachxettuyentheodotxt
                        WHERE
                        thutu = 3
                        AND iddot = ?
                        AND iddotxt = ?
                        GROUP BY id_chuyennganh) AS nguyenvong3
                    ON 24_chuyennganh_dotxettuyen.id_chuyennganh = nguyenvong3.id_chuyennganh
            WHERE
                24_chuyennganh_dotxettuyen.iddot = ?
                AND 24_chuyennganh_dotxettuyen.iddotxt = ?
            )";
        return $sql;
    }
    function thongketheodotxettuyen($iddotts,$iddotxt){
        $json_data['data'] = DB::select($this->sql_thongketheodotxettuyen($iddotts,$iddotxt),[$iddotts,$iddotxt,$iddotts,$iddotxt,$iddotts,$iddotxt,$iddotts,$iddotxt,$iddotts,$iddotxt,$iddotts,$iddotxt,$iddotts,$iddotxt,$iddotts,$iddotxt]);
        $data = json_encode($json_data);
        return $data;
    }
    function capnhatsoluongtheonganh(Request $requets){
        $id = $requets->input('id');
        $soluong = $requets->input('soluong');
        $upd = DB::table('24_chuyennganh_dotxettuyen')
        ->where('id', $id)
        ->update([
            'soluong_chuyennganh' =>  $soluong,
        ]);
        $upd == 1 ? $trangthai = "upd_1" : $trangthai = "upd_0";
        return array(
            'trangthai' => $trangthai,
            'noidung' => DB::table('24_chuyennganh_dotxettuyen')->where('id', $id)->first()->soluong_chuyennganh
        );
    }
    function sql_danhsachtrungtuyentamtheodotxt($iddotts,$iddotxt,$ngvong){
        // $ngvong = 1;
        $major = DB::table('24_chuyennganh_dotxettuyen')
        ->where('iddot',$iddotts)
        ->where('iddotxt',$iddotxt)
        ->get();
        $sql = "";
        if(count($major) > 0){
            $sql .= "SELECT
                nv.id AS id,
                nv.id_taikhoan AS idts,
                nv.idnv AS idnv,
                nv.id_chuyennganh,
                ROUND(nv.diemxettuyen,2) AS diemxettuyen
            FROM
                24_danhsachxettuyentheodotxt nv
            WHERE
                nv.thutu = ". $ngvong ."
                AND nv.iddot = ". $iddotts ."
                AND nv.iddotxt = ". $iddotxt ."
                AND nv.trangthaixettuyen = 1 AND (";
            foreach ($major as $key => $row) {
                $soluong = $row->soluong_chuyennganh;
                $idnganh =$row->id_chuyennganh;
                if($key == 0){
                    $or = '';
                }else{
                    $or = 'OR ';
                }
                $sql .= $or."
                ( nv.id_chuyennganh =".$idnganh." AND nv.diemxettuyen >= (
                    SELECT MIN(diemxettuyen) AS min_diemxettuyen
                    FROM (
                        SELECT diemxettuyen
                        FROM 24_danhsachxettuyentheodotxt
                        WHERE id_chuyennganh = ".$idnganh." AND thutu = ".$ngvong." AND iddotxt = ".$iddotxt."
                        ORDER BY diemxettuyen DESC
                        LIMIT ".$soluong."
                    ) AS nganh".$idnganh."
                ))";
            }
        }
        $sql .= " ) ORDER BY nv.id_chuyennganh ASC, diemxettuyen DESC";
        return $sql;
    }
    function sql_thongkedanhsachtrungtuyentamtheodotxt($iddotts,$iddotxt,$ngvong){
        $sql = $this->sql_danhsachtrungtuyentamtheodotxt($iddotts,$iddotxt,$ngvong);
        $new_sql = 'SELECT
            ROW_NUMBER() OVER (ORDER BY trungtuyen.id_chuyennganh) AS sothutu,
            trungtuyen.id_chuyennganh,
            COUNT(*) AS soluong_trungtuyen,
            MIN(trungtuyen.diemxettuyen) AS diemchuan
        FROM ('.$sql.') trungtuyen
        GROUP BY trungtuyen.id_chuyennganh';
            return $new_sql;

    }
    function thongkedanhsachtrungtuyentamtheodotxt($iddotts,$iddotxt,$ngvong){
        // $json_data['data'] = DB::select($this->sql_thongkedanhsachtrungtuyentamtheodotxt($iddotts,$iddotxt,$ngvong));
        // $data = json_encode($json_data);
        // try{
            $data = DB::select($this->sql_thongkedanhsachtrungtuyentamtheodotxt($iddotts,$iddotxt,$ngvong));
            return $data;
        // }catch(Exception $e){
        //     return 'dulieuxettuyen';
        // }
    }
    function luudanhsachtrungtuyentam($iddotts,$iddotxt,$ngvong){
        $trungtuyentam = DB::select($this->sql_danhsachtrungtuyentamtheodotxt($iddotts,$iddotxt,$ngvong));
        DB::table('24_danhsachxettuyentheodotxt')->where('iddot', $iddotts)->where('iddotxt', $iddotxt)->update(['trungtuyentam'=>0]);
        $idtrungtuyentamList = array_column($trungtuyentam, 'id');
        try{
            DB::table('24_danhsachxettuyentheodotxt')->whereIn('id', $idtrungtuyentamList)->update(['trungtuyentam'=>1]);
            $trangthai = 'upd_1';
        }catch(Exception $e){
            $trangthai = 'upd_0';
        }
        return $trangthai;
    }
    function trungtuyenchinhthucdotts($iddotxt){
        $iddotts = $this->dotchayxettuyen();
        $khoa = $this->kiemtrakhoadottuyensinh($iddotts);
        switch ($khoa) {
            case '0':
                DB::beginTransaction();
                try{
                    $sql1 = "INSERT INTO `24_trungtuyen` (
                        `idnv`,
                        `id_chuyennganh`,
                        `idnganh`,
                        `id_taikhoan`,
                        `diemxettuyen`,
                        `idphuongthuc`,
                        `tohop`,
                        `thutu`,
                        `diemuutien`,
                        `diemtohop`,
                        `iddot`,
                        `idnam`,
                        `iddotxt`,
                        `trangthaixettuyen`,
                        `trungtuyentam`,
                        `trungtuyennhom`,
                        `trungtuyenbo`,
                        `ttsom`,
                        `ghichu`
                        )
                        SELECT
                        `idnv`,
                        `id_chuyennganh`,
                        `idnganh`,
                        `id_taikhoan`,
                        `diemxettuyen`,
                        `idphuongthuc`,
                        `tohop`,
                        `thutu`,
                        `diemuutien`,
                        `diemtohop`,
                        `iddot`,
                        `idnam`,
                        ? AS `iddotxt`,
                        `trangthaixettuyen`,
                        `trungtuyentam`,
                        `trungtuyennhom`,
                        `trungtuyenbo`,
                        `ttsom`,
                        `ghichu`
                        FROM 24_danhsachxettuyentheodotxt
                        WHERE
                        iddot = ?
                        AND trangthaixettuyen = 1
                        AND trungtuyentam = 1
                        AND trungtuyenbo = 1
                        AND trungtuyennhom = 1
                        AND iddotxt = ?
                        AND id_taikhoan NOT IN (SELECT id_taikhoan FROM 24_trungtuyen WHERE iddot= ?)";
                    $insertedRows1 = DB::affectingStatement($sql1, [$iddotxt,$iddotts,$iddotxt,$iddotts]);
                    DB::commit();
                    return array(
                        'trangthai' => 1,
                        'insertedRows1' => $insertedRows1,
                    ) ;
                }catch(Exception $e){
                    DB::rollBack();
                    return array(
                        'trangthai' => '-100',
                        'insertedRows1' => "",
                    ) ;
                }
                break;
            case '1':
                return 'dot_1';
                break;
            default:
                return  'dot_0';
                break;
        }
    }
    function khoaxettuyendotts(){
        $iddotts = $this->dotchayxettuyen();
        $khoa = $this->kiemtrakhoadottuyensinh($iddotts);
        switch ($khoa) {
            case '0':
                DB::table('24_dottuyensinh')
                ->where('id', $iddotts)
                ->update([
                    'khoadot' => 1
                ]);
                return 'upd_1';
                break;
            case '1':
                return 'dot_1';
                break;
            default:
                return  'dot_0';
                break;
        }
    }
    function congboketquatheodotxt(){
        $iddotts = $this->dotchayxettuyen();
        $khoa = $this->kiemtrakhoadottuyensinh($iddotts);
        switch ($khoa) {
            case '0':
                return 'dot_2';
                break;
            case '1':
                DB::table('24_trungtuyen')
                ->where('iddot', $iddotts)
                ->update([
                    'congbo' => 1
                ]);
                return 'upd_1';
                break;
            default:
                return  'dot_0';
                break;
        }
    }//Bổ sung chức năng hủy công bố
    function dieutraketquatheodotxt(){
        $iddotts = $this->dotchayxettuyen();
        $khoa = $this->kiemtrakhoadottuyensinh($iddotts);
        switch ($khoa) {
            case '0':
                return 'dot_2';
                break;
            case '1':
                DB::table('24_trungtuyen')
                ->where('iddot', $iddotts)
                ->update([
                    'dieutra' => 1
                ]);
                return 'upd_1';
                break;
            default:
                return  'dot_0';
                break;
        }
    }//Bổ sung chức năng hủy điều tra
    function data_danhsachtrungtuyenchinhthuc($iddotts, $iddotxt, $id_chuyennganh){
        $iddotxt == 0 ? $dotxt = "AND tt.iddotxt is not null" :  $dotxt = "AND tt.iddotxt = ?";
        $id_chuyennganh == 0 ? $chuyennganh = "AND tt.id_chuyennganh is null" :  $chuyennganh = "AND tt.id_chuyennganh = ?";
        $sql = "SELECT
            ROW_NUMBER() OVER (ORDER BY tt.id) AS sothutu,
            ttcn.hoten,
            ttcn.ngaysinh,
            ttcn.cccd,
            ttcn.dienthoai,
            ttcn.gioitinh,
            ttcn.dienthoai_phu,
            acc.email,
            tt.id_taikhoan AS id,
            tt.diemtohop,
            tt.thutu,
            tt.diemuutien,
            tt.diemxettuyen,
            cn.tenchuyennganh,
            tt.iddotxt,
            tt.xacnhan,
            tt.xacnhan_cccd,
            cn.machuyennganh,
            tt.iddot,
            tt.iddotxt,
            tt.trangthaidieutra,
            tt.ghichu_xnnh,
            tt.daxem,
            if(xnbo.id_taikhoan is null,'','X') as xacnhanbo,
            if(mssv.id_taikhoan is null,'',mssv.mssv) as mssv
        FROM
            24_trungtuyen tt
        LEFT JOIN
            24_xacnhanbo xnbo ON xnbo.id_taikhoan = tt.id_taikhoan
        LEFT JOIN
            24_mssv mssv ON mssv.id_taikhoan = tt.id_taikhoan
        LEFT JOIN
            24_thongtincanhan ttcn ON ttcn.id_taikhoan = tt.id_taikhoan
        INNER JOIN
            24_chuyennganh cn ON cn.id = tt.id_chuyennganh
        LEFT JOIN
            account24s acc ON acc.id = tt.id_taikhoan
        WHERE
            iddot = ? ".$dotxt." ".$chuyennganh;
        if($iddotxt == 0){
            if($id_chuyennganh == 0){
                $data = DB::select($sql,[$iddotts]);
            }else{
                $data = DB::select($sql,[$iddotts,$id_chuyennganh]);
            }
        }else{
            if($id_chuyennganh == 0){
                $data = DB::select($sql,[$iddotts,$iddotxt]);
            }else{
                $data = DB::select($sql,[$iddotts,$iddotxt,$id_chuyennganh]);
            }
        }
        return $data;
    }
    function danhsachtrungtuyenchinhthuc($iddotts, $iddotxt, $id_chuyennganh){
        $json_data['data'] = $this->data_danhsachtrungtuyenchinhthuc($iddotts, $iddotxt, $id_chuyennganh);
        $data = json_encode($json_data);
        return $data;
    }

    function xuatdanhsachtrungtuyenchinhthuc($iddotts, $iddotxt, $id_chuyennganh){
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $title = 'DanhSachTrungTuyenTheoDotTS' . date("d-m-Y H:i:s") . '.xlsx';
        $data = $this->data_danhsachtrungtuyenchinhthuc($iddotts, $iddotxt, $id_chuyennganh);
        return Excel::download(new Admin24_ExportDanhSachTrungTuyenChinhThuc($data), $title);
    }

    function data_danhsachkhongdatchinhthuc($iddotts, $iddotxt, $id_chuyennganh){
        $iddotxt == 0 ? $dotxt = "AND iddotxt is not null" :  $dotxt = "AND iddotxt = ?";
        $id_chuyennganh == 0 ? $chuyennganh = "AND id_chuyennganh is not null" :  $chuyennganh = "AND id_chuyennganh = ?";
        $sql = "SELECT
            ROW_NUMBER() OVER (ORDER BY tt.id) AS sothutu,
            ttcn.hoten,
            ttcn.ngaysinh,
            ttcn.cccd,
            ttcn.dienthoai,
            ttcn.gioitinh,
            ttcn.dienthoai_phu,
            acc.email,
            tt.id_taikhoan AS id,
            tt.diemtohop,
            tt.thutu,
            tt.diemuutien,
            tt.diemxettuyen,
            cn.tenchuyennganh,
            cn.machuyennganh,
            tt.iddot
        FROM
            24_nguyenvong tt
        LEFT JOIN
            24_thongtincanhan ttcn ON ttcn.id_taikhoan = tt.id_taikhoan
        INNER JOIN
            24_chuyennganh cn ON cn.id = tt.id_chuyennganh
        LEFT JOIN
            account24s acc ON acc.id = tt.id_taikhoan
        WHERE
            tt.id_taikhoan NOT IN (SELECT id_taikhoan FROM 24_trungtuyen WHERE iddot = ?) AND tt.iddot = ? AND tt.trangthaixettuyen = 1 ";
        $data = DB::select($sql,[$iddotts,$iddotts]);
        return $data;
    }

    function xuatdanhsachkhongdatchinhthuc($iddotts, $iddotxt, $id_chuyennganh){
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $title = 'DanhSachKhongDatTheoDotTS' . date("d-m-Y H:i:s") . '.xlsx';
        $data = $this->data_danhsachkhongdatchinhthuc($iddotts, $iddotxt, $id_chuyennganh);
        return Excel::download(new Admin24_ExportDanhSachKhongDatChinhThuc($data), $title);
    }

        //Xét tuyển chung
    function ghepdulieu_new($data_goc, $data_ghep){
        foreach ($data_goc as $key => $row_goc) {
            foreach ($data_ghep as $key2 => $row_ghep) {
                if($row_goc->id == $row_ghep->id ){
                    foreach ($row_ghep as $key3 => $row) {
                        if($key3 != 'id'){
                            $row_goc->$key3  = $row;
                        }
                    }
                }
            }
        }
        return $data_goc;
    }

    //Tính trung bình, tổng, đếm của cột
    function sumForKey($data, $targetKey) {
        $data = json_decode($data, true);
        $total = 0;
        $count = 0;
        foreach ($data as $item) {
            $total += $item[$targetKey];
            if( $item[$targetKey] != 0){ $count++;}
        }
        $count == 0 ? $aveg = '' : $aveg = round($total/$count,2);
        return array(
            'value' => $total,
            'count' => $count,
            'aveg'  => $aveg
        );
    }

    function laytieudotcacdotxt(){
        $nganh_chuyennganh = 2;
        $iddotts = $this->dotchayxettuyen();
        $modot = $this->dotchayxettuyen();
        switch ($nganh_chuyennganh) {
            case '2':
                $dotxt = DB::table('24_dotxettuyen')
                ->where('iddotts',$iddotts)
                ->get();
                $nganh = DB::table('24_chuyennganh_xettuyen')
                ->select('24_chuyennganh.id as id','24_chuyennganh_xettuyen.soluong_chuyennganh as chitieu','24_chuyennganh.tenchuyennganh as tennganh','loaixettuyen','dangky','nv1','nv2','nv3')
                ->join('24_chuyennganh','24_chuyennganh_xettuyen.id_chuyennganh','24_chuyennganh.id')
                ->where('iddot',$iddotts)
                ->get();
                $sql =  'SELECT  24_chuyennganh_dotxettuyen.id_chuyennganh AS Nganh, 24_chuyennganh_dotxettuyen.id_chuyennganh AS id, ';
                foreach ($dotxt as $key => $row_title) {
                    $sql .= 'MAX(CASE WHEN iddotxt = '.$row_title->iddotxt.' THEN ROUND(diemlocaothpt,2) ELSE NULL END) AS diemlocaothpt'.$row_title->iddotxt.',';
                    $sql .= 'MAX(CASE WHEN iddotxt = '.$row_title->iddotxt.' THEN trungtuyenthpt ELSE NULL END) AS trungtuyenthpt'.$row_title->iddotxt.',';
                    $sql .= 'MAX(CASE WHEN iddotxt = '.$row_title->iddotxt.' THEN ROUND(diemchuanthpt,2) ELSE NULL END) AS diemchuanthpt'.$row_title->iddotxt.',';
                    $sql .= 'MAX(CASE WHEN iddotxt = '.$row_title->iddotxt.' THEN ROUND(diemlocaohocba,2) ELSE NULL END) AS diemlocaohocba'.$row_title->iddotxt.',';
                    $sql .= 'MAX(CASE WHEN iddotxt = '.$row_title->iddotxt.' THEN trungtuyenhocba ELSE NULL END) AS trungtuyenhocba'.$row_title->iddotxt.',';
                    $sql .= 'MAX(CASE WHEN iddotxt = '.$row_title->iddotxt.' THEN trungtuyensom ELSE NULL END) AS trungtuyensom'.$row_title->iddotxt.',';
                    $sql .= 'MAX(CASE WHEN iddotxt = '.$row_title->iddotxt.' THEN ROUND(diemchuanhocba,2) ELSE NULL END) AS diemchuanhocba'.$row_title->iddotxt.',';
                    $sql .= 'MAX(CASE WHEN iddotxt = '.$row_title->iddotxt.' THEN trungtuyensom + trungtuyenhocba + trungtuyenthpt  ELSE NULL END) AS tong'.$row_title->iddotxt.',';
                    $sql .= 'MAX(CASE WHEN iddotxt = '.$row_title->iddotxt.' THEN trungtuyennhom ELSE NULL END) AS trungtuyennhom'.$row_title->iddotxt.',';
                    if($key == count($dotxt) -1 ){
                        $sql .= 'MAX(CASE WHEN iddotxt = '.$row_title->iddotxt.' THEN trungtuyenbo ELSE 0 END) AS trungtuyenbo'.$row_title->iddotxt;
                    }else{
                        $sql .= 'MAX(CASE WHEN iddotxt = '.$row_title->iddotxt.' THEN trungtuyenbo ELSE 0 END) AS trungtuyenbo'.$row_title->iddotxt.',';
                    }
                }
                $sql .=  ' FROM 24_chuyennganh_dotxettuyen WHERE iddot = ? GROUP BY 24_chuyennganh_dotxettuyen.id_chuyennganh';
                $data = DB::select($sql,[$iddotts]);
                $this->ghepdulieu_new($nganh,  $data);
                $title = "<thead>";
                $title .= "<tr>";
                $title .= "<th rowspan = '4' class = 'text-center'>STT</th>";
                $title .= "<th rowspan = '4' class = 'border-right text-center'>Chuyên ngành</th>";
                $title .= "<th colspan = '3' rowspan = '2' class = 'border-right text-center'>Thông tin xét tuyển</th>";
                foreach ($dotxt as $row_title) {
                    $title .= "<th colspan = '13' class = 'border-right text-center' >".$row_title->tendotxettuyen."</th>";
                }
                $title .= "</tr>";
                $title .= "<tr>";
                foreach ($dotxt as $row_title) {
                    $title .= "<th colspan = '9' class = 'border-right text-center' >Lọc ảo Trường</th>";
                    $title .= "<th colspan = '2' class = 'border-right text-center' >Lọc ảo Nhóm</th>";
                    $title .= "<th colspan = '2' class = 'border-right text-center' >Lọc ảo Bộ</th>";
                }
                $title .= "</tr>";

                $title .= "<tr>";
                    $title .= "<th rowspan = '2' class = 'text-center'>CT</th>";
                    $title .= "<th rowspan = '2' class = 'text-center'>ĐK</th>";
                    $title .= "<th rowspan = '2' class = 'border-right text-center'>NV1</th>";
                foreach ($dotxt as $row_title) {
                    $title .= "<th colspan = '3' class = 'border-right text-center'>THPT</th>";
                    $title .= "<th colspan = '4' class = 'text-center' >Học bạ</th>";
                    $title .= "<th rowspan = '2' class = 'text-center'>Tổng</th>";
                    $title .= "<th rowspan = '2' class = 'border-right text-center'>Tỉ lệ</th>";
                    $title .= "<th rowspan = '2' class = 'text-center'>SL</th>";
                    $title .= "<th rowspan = '2' class = 'border-right text-center'>Tỉ lệ</th>";
                    $title .= "<th rowspan = '2' class = 'text-center'>SL</th>";
                    $title .= "<th rowspan = '2' class = 'border-right text-center'>Tỉ lệ</th>";
                }
                $title .= "</tr>";
                $title .= "<tr>";
                foreach ($dotxt as $row_title) {
                    $title .= "<th>Điểm</th>";
                    $title .= "<th>TT</th>";
                    $title .= "<th>ĐC</th>";
                    $title .= "<th>Điểm</th>";
                    $title .= "<th>TT Mới</th>";
                    $title .= "<th>TT Sớm</th>";
                    $title .= "<th>ĐC</th>";
                }
                $title .= "</tr>";
                $title .= "</thead>";
                $title .= "<body>";

                foreach ($nganh as $row_data) {
                    if($row_data->loaixettuyen == 1){
                        $disabled = 'disabled';
                        $style_nganh = "style = 'font-style:italic'";
                    }else{
                        $disabled = '';
                        $style_nganh = '';
                    }
                    $title .= "<tr>";
                        $title .= "<td>". $row_data->Nganh."</td>";
                        $title .= "<td class = 'border-right text-center' ".$style_nganh.">". $row_data->tennganh."</td>";
                        $title .= "<td id = 'chitieu-dotts".$modot."-nganh".$row_data-> id."' class = 'text-center'>". $row_data->chitieu."</td>";
                        $title .= "<td class = 'text-center'>". $row_data->dangky."</td>";
                        $title .= "<td class = 'border-right text-center'>". $row_data->nv1."</td>";
                        foreach ($dotxt as $key =>$row_title) {
                            $diemlocaothpt = 'diemlocaothpt'.$row_title->iddotxt;
                            $trungtuyenthpt = 'trungtuyenthpt'.$row_title->iddotxt;
                            $diemchuanthpt = 'diemchuanthpt'.$row_title->iddotxt;
                            $diemlocaohocba = 'diemlocaohocba'.$row_title->iddotxt;
                            $trungtuyenhocba = 'trungtuyenhocba'.$row_title->iddotxt;
                            $trungtuyensom = 'trungtuyensom'.$row_title->iddotxt;
                            $diemchuanhocba = 'diemchuanhocba'.$row_title->iddotxt;
                            $trungtuyennhom = 'trungtuyennhom'.$row_title->iddotxt;
                            $trungtuyenbo = 'trungtuyenbo'.$row_title->iddotxt;
                            $tong = 'tong'.$row_title->iddotxt;


                            $title .= "<td> <input type = 'text' ".$disabled." idphuongthuc = '2' onchange = diemlocao(".$modot.",".$row_title-> iddotxt.",".$row_data-> id.",2)  class = 'locao diemlocaothpt diemlocaothpt".$row_title-> iddotxt."' id='diemlocao-dotts".$modot."-dotxt".$row_title-> iddotxt."-nganh".$row_data-> id."-phuongthuc2' title = 'diemlocaothpt' id-dotts = '".$modot."' id-dotxt = '".$row_title-> iddotxt."'  id-nganh = '".$row_data-> id."' style = 'width:50px;height:24px;border:none;background-color: inherit; text-align:center' value = ".$row_data-> $diemlocaothpt."></td>";
                            $title .= "<td class = '".$trungtuyenthpt."' idphuongthuc = '2' id = 'trungtuyen-dotts".$modot."-dotxt".$row_title-> iddotxt."-phuongthuc2-nganh".$row_data-> id."'>".$row_data-> $trungtuyenthpt."</td>";
                            $title .= "<td class = '".$diemchuanthpt."' idphuongthuc = '2' id = 'diemchuan-dotts".$modot."-dotxt".$row_title-> iddotxt."-phuongthuc2-nganh".$row_data-> id."'>".$row_data-> $diemchuanthpt."</td>";
                            $title .= "<td> <input type = 'text' ".$disabled." idphuongthuc = '1' onchange = diemlocao(".$modot.",".$row_title-> iddotxt.",".$row_data-> id.",1)  class = 'locao diemlocaohocba diemlocaohocba".$row_title-> iddotxt."' id='diemlocao-dotts".$modot."-dotxt".$row_title-> iddotxt."-nganh".$row_data-> id."-phuongthuc1' title = 'diemlocaothpt' id-dotts = '".$modot."' id-dotxt = '".$row_title-> iddotxt."'  id-nganh = '".$row_data-> id."' style = 'width:50px;height:24px;border:none;background-color: inherit; text-align:center' value = ".$row_data-> $diemlocaohocba."></td>";
                            $title .= "<td class = '".$trungtuyenhocba."' idphuongthuc = '1' id = 'trungtuyen-dotts".$modot."-dotxt".$row_title-> iddotxt."-phuongthuc1-nganh".$row_data-> id."'>".$row_data-> $trungtuyenhocba."</td>";
                            $title .= "<td class = '".$trungtuyensom."' idphuongthuc = '1' id = 'trungtuyensom-dotts".$modot."-dotxt".$row_title-> iddotxt."-phuongthuc1-nganh".$row_data-> id."'>".$row_data-> $trungtuyensom."</td>";
                            $title .= "<td class = '".$diemchuanhocba."' idphuongthuc = '1' id = 'diemchuan-dotts".$modot."-dotxt".$row_title-> iddotxt."-phuongthuc1-nganh".$row_data-> id."'>".$row_data-> $diemchuanhocba."</td>";
                            $title .= "<td class = '".$tong."' id = 'tong-dotts".$modot."-dotxt".$row_title-> iddotxt."-nganh".$row_data-> id."'>".$row_data->$tong."</td>";
                            $title .= "<td class = 'tiletruong'.$row_title->iddotxt id = 'tile-dotts".$modot."-dotxt".$row_title-> iddotxt."-nganh".$row_data-> id."'>".round($row_data->$tong/$row_data->chitieu*100,1)."</td>";
                            $title .=  "<td  id = 'trungtuyennhom".$modot."-dotxt".$row_title-> iddotxt."-nganh".$row_data-> id."'>".$row_data->$trungtuyennhom."</td>";
                            $title .= "<td class = 'tilenhom'.$row_title->iddotxt id = 'tile-trungtuyennhom-dotts".$modot."-dotxt".$row_title-> iddotxt."-nganh".$row_data-> id."'>".round($row_data->$trungtuyennhom/$row_data->chitieu*100,1)."</td>";
                            $title .=  "<td id = trungtuyenbo".$modot."-dotxt".$row_title-> id."-nganh".$row_data-> id."'>".$row_data->$trungtuyenbo."</td>";
                            $title .= "<td class = 'tilebo'.$row_title->iddotxt class = 'border-right' id = 'tile-trungtuyenbo-dotts".$modot."-dotxt".$row_title-> id."-nganh".$row_data-> id."'>".round($row_data->$trungtuyenbo/$row_data->chitieu*100,1)."</td>";
                        }
                    $title .= "</tr>";
                }
                $title .= "<tr>";
                    $title .= "<td ></td>";
                    $title .= "<td class = 'text-center'>Total</td>";
                    $title .= "<td class = 'text-center'>".$this-> sumForKey($nganh, 'chitieu')['value']."</td>";
                    $title .= "<td class = 'text-center'>".$this-> sumForKey($nganh, 'dangky')['value']."</td>";
                    $title .= "<td class = 'text-center'>".$this-> sumForKey($nganh, 'nv1')['value']."</td>";
                    foreach ($dotxt as $key =>$row_title) {
                        $diemlocaothpt = 'diemlocaothpt'.$row_title->iddotxt;
                        $trungtuyenthpt = 'trungtuyenthpt'.$row_title->iddotxt;
                        $diemchuanthpt = 'diemchuanthpt'.$row_title->iddotxt;
                        $diemlocaohocba = 'diemlocaohocba'.$row_title->iddotxt;
                        $trungtuyenhocba = 'trungtuyenhocba'.$row_title->iddotxt;
                        $trungtuyensom = 'trungtuyensom'.$row_title->iddotxt;
                        $diemchuanhocba = 'diemchuanhocba'.$row_title->iddotxt;
                        $trungtuyennhom = 'trungtuyennhom'.$row_title->iddotxt;
                        $trungtuyenbo = 'trungtuyenbo'.$row_title->iddotxt;
                        $tong = 'tong'.$row_title->iddotxt;
                        $title .= "<td id='diemlocaothpt".$row_title->iddotxt."'>".$this-> sumForKey($nganh,  $diemlocaothpt)['aveg']."</td>";
                        $title .= "<td id='trungtuyenthpt".$row_title->iddotxt."'>".$this-> sumForKey($nganh,  $trungtuyenthpt)['value']."</td>";
                        $title .= "<td id='diemchuanthpt".$row_title->iddotxt."'>".$this-> sumForKey($nganh,  $diemchuanthpt)['aveg']."</td>";
                        $title .= "<td id='diemlocaohocba".$row_title->iddotxt."'>".$this-> sumForKey($nganh,  $diemlocaohocba )['aveg']."</td>";
                        $title .= "<td id='trungtuyenhocba".$row_title->iddotxt."'>".$this-> sumForKey($nganh,  $trungtuyenhocba)['value']."</td>";
                        $title .= "<td id='trungtuyensom".$row_title->iddotxt."'>".$this-> sumForKey($nganh,  $trungtuyensom)['value']."</td>";
                        $title .= "<td id='diemchuanhocba".$row_title->iddotxt."'>".$this-> sumForKey($nganh,  $diemchuanhocba)['aveg']."</td>";
                        $title .= "<td id='tong".$row_title->iddotxt."'>".$this-> sumForKey($nganh,  $tong)['value']."</td>";
                        $title .= "<td id='tiletruong".$row_title->iddotxt."'>".round($this-> sumForKey($nganh,  $tong)['value']/$this-> sumForKey($nganh,'chitieu')['value']*100,1)."</td>";
                        $title .= "<td id='trungtuyennhom".$row_title->iddotxt."'>".$this-> sumForKey($nganh,  $trungtuyennhom)['value']."</td>";
                        $title .= "<td id='tilenhom".$row_title->iddotxt."'>".round($this->sumForKey($nganh,   $trungtuyennhom)['value']/$this-> sumForKey($nganh, 'chitieu')['value']*100,1)."</td>";
                        $title .= "<td id='trungtuyenbo".$row_title->iddotxt."'>".$this-> sumForKey($nganh,  $trungtuyenbo)['value']."</td>";
                        $title .= "<td id='tilebo".$row_title->iddotxt."'>".round($this-> sumForKey($nganh,  $trungtuyenbo)['value']/$this-> sumForKey($nganh, 'chitieu')['value']*100,1)."</td>";
                    }
                    $title .= "</tr>";
                $title .= "</body>";
                return  $title;
                break;
            case '1':
                # code...
                break;
            default:
                # code...
                break;
        }
    }

    function diemlocao(Request $r){
        $iddot = $r->input('dotts');
        $iddotxt = $r->input('dotxt');
        $id_chuyennganh = $r->input('nganh');
        $diemlocao = $r->input('value');
        switch ($r->input('idphuongthuc')) {
            case '2':
                $diemlocao_update = 'diemlocaothpt';
                break;
            case '1':
                $diemlocao_update = 'diemlocaohocba';
                break;
            default:
                # code...
                break;
        }
        DB::table('24_chuyennganh_dotxettuyen')
        ->where('loaixettuyen',0)
        ->where('iddot', $iddot)
        ->where('iddotxt',  $iddotxt)
        ->where('id_chuyennganh',$id_chuyennganh)
        ->update(
            [
                $diemlocao_update => $diemlocao,
            ]
        );
        return $this ->locao($iddot, $iddotxt);
    }

    function xoatrungtuyentam($iddot, $iddotxt){
        DB::table('24_danhsachxettuyentheodotxt')
        ->where('iddot',  $iddot )
        ->where('iddotxt',  $iddotxt )
        ->update([
            'trungtuyentam'=> 0,
        ]);
    }

    function locao($iddot, $iddotxt){
        $this->xoatrungtuyentam($iddot, $iddotxt);
        $nganh_chuyennganh = 2;
        switch ($nganh_chuyennganh) {
            case '2':
                DB::beginTransaction();
                try{
                    //Lấy danh sách trúng tuyển
                    $sql = " SELECT RankedData.id as id
                    FROM (SELECT
                            dsx.*,
                            ROW_NUMBER() OVER (PARTITION BY dsx.id_taikhoan ORDER BY dsx.thutu ASC,idphuongthuc DESC) AS rn
                        FROM
                            24_danhsachxettuyentheodotxt dsx
                        INNER JOIN (
                            SELECT id_nganh, diemlocaothpt, diemlocaohocba
                            FROM 24_chuyennganh_dotxettuyen dxt
                            WHERE dxt.iddot = ? AND dxt.iddotxt = ?
                            AND id_nganh_dotxt IN (SELECT id FROM 24_chuyennganh_xettuyen WHERE nganhloaitru = 0)
                        ) AS diemlocao
                        ON diemlocao.id_nganh = dsx.idnganh
                        WHERE dsx.iddot = ? AND dsx.iddotxt = ?  AND ((dsx.diemxettuyen >= (
                                CASE
                                    WHEN dsx.idphuongthuc = 2 THEN diemlocao.diemlocaothpt
                                    WHEN dsx.idphuongthuc = 1 THEN diemlocao.diemlocaohocba
                                END
                            ) OR ttsom = 1))
                        ) as RankedData
                    WHERE rn = 1
                    ORDER by id_taikhoan";
                    $danhsach = DB::select($sql,[$iddot,$iddotxt,$iddot,$iddotxt]);

                    // return $sql;
                    //Cập nhật trang thái trúng tuyển của thí sinh
                    $id_list = array_column($danhsach, 'id');
                    DB::table('24_danhsachxettuyentheodotxt')
                    ->whereIn('id', $id_list )
                    ->where('iddot',  $iddot )
                    ->where('iddotxt',  $iddotxt )
                    ->update(['trungtuyentam'=>1]);

                    //Thống kê điểm chuẩn, trúng tuyển
                    $sql = 'SELECT
                        id_nganh_dotxt,24_chuyennganh_dotxettuyen.id_chuyennganh,
                        24_chuyennganh_dotxettuyen.iddot,
                        24_chuyennganh_dotxettuyen.iddotxt,
                        24_chuyennganh_dotxettuyen.id as id,
                        if(trungtuyen.trungtuyenthpt is null,0,trungtuyen.trungtuyenthpt) as trungtuyenthpt,
                        ROUND(if(diemchuan.diemchuanthpt is null,diemlocaothpt,diemchuan.diemchuanthpt),2) as diemchuanthpt,
                        if(trungtuyenhb.trungtuyenhocba is null,0,trungtuyenhb.trungtuyenhocba) as trungtuyenhocba,
                        if(trungtuyensom.sltrungtuyensom is null,0,trungtuyensom.sltrungtuyensom) as sltrungtuyensom,
                        if(trungtuyennhom.sltrungtuyennhom is null,0,trungtuyennhom.sltrungtuyennhom) as trungtuyennhom,
                        if(trungtuyenbo.sltrungtuyenbo is null,0,trungtuyenbo.sltrungtuyenbo) as trungtuyenbo,
                        ROUND(if(diemchuanhb.diemchuanhocba is null,diemlocaohocba,diemchuanhb.diemchuanhocba),2) as diemchuanhocba,
                        24_chuyennganh_dotxettuyen.id_nganh as id_nganh
                    FROM 24_chuyennganh_dotxettuyen
                    LEFT JOIN
                        (SELECT id_chuyennganh, COUNT(*) AS trungtuyenthpt
                        FROM 24_danhsachxettuyentheodotxt
                        WHERE iddot = ?
                        AND iddotxt = ?
                        AND trungtuyentam = 1
                        AND idphuongthuc = 2
                    GROUP BY id_chuyennganh) AS trungtuyen
                        ON trungtuyen.id_chuyennganh = 24_chuyennganh_dotxettuyen.id_chuyennganh
                    LEFT JOIN
                        (SELECT id_chuyennganh, MIN(diemxettuyen) AS diemchuanthpt
                        FROM 24_danhsachxettuyentheodotxt
                        WHERE iddot = ?
                        AND iddotxt = ?
                        AND trungtuyentam = 1
                        AND idphuongthuc = 2
                    GROUP BY id_chuyennganh) AS diemchuan
                        ON diemchuan.id_chuyennganh = 24_chuyennganh_dotxettuyen.id_chuyennganh
                    LEFT JOIN
                        (SELECT id_chuyennganh, COUNT(*) AS trungtuyenhocba
                        FROM 24_danhsachxettuyentheodotxt
                        WHERE iddot = ?
                        AND iddotxt = ?
                        AND trungtuyentam = 1
                        AND idphuongthuc = 1
                        AND ttsom = 0
                    GROUP BY id_chuyennganh) AS trungtuyenhb
                        ON trungtuyenhb.id_chuyennganh = 24_chuyennganh_dotxettuyen.id_chuyennganh
                    LEFT JOIN
                        (SELECT id_chuyennganh, COUNT(*) AS sltrungtuyensom
                        FROM 24_danhsachxettuyentheodotxt
                        WHERE iddot = ?
                        AND iddotxt = ?
                        AND trungtuyentam = 1
                        AND idphuongthuc = 1
                        AND ttsom = 1
                    GROUP BY id_chuyennganh) AS trungtuyensom
                        ON trungtuyensom.id_chuyennganh = 24_chuyennganh_dotxettuyen.id_chuyennganh
                    LEFT JOIN
                        (SELECT id_chuyennganh, MIN(diemxettuyen) AS diemchuanhocba
                        FROM 24_danhsachxettuyentheodotxt
                        WHERE iddot = ?
                        AND iddotxt = ?
                        AND trungtuyentam = 1
                        AND idphuongthuc = 1
                        AND ttsom = 0
                    GROUP BY id_chuyennganh) AS diemchuanhb
                        ON diemchuanhb.id_chuyennganh = 24_chuyennganh_dotxettuyen.id_chuyennganh
                    LEFT JOIN
                        (SELECT id_chuyennganh, COUNT(*) AS sltrungtuyennhom
                        FROM 24_danhsachxettuyentheodotxt
                        WHERE iddot = ?
                        AND iddotxt = ?
                        AND trungtuyennhom = 1
                    GROUP BY id_chuyennganh) AS trungtuyennhom
                        ON trungtuyennhom.id_chuyennganh = 24_chuyennganh_dotxettuyen.id_chuyennganh
                    LEFT JOIN
                        (SELECT id_chuyennganh, COUNT(*) AS sltrungtuyenbo
                        FROM 24_danhsachxettuyentheodotxt
                        WHERE iddot = ?
                        AND iddotxt = ?
                        AND trungtuyenbo = 1
                    GROUP BY id_chuyennganh) AS trungtuyenbo
                        ON trungtuyenbo.id_chuyennganh = 24_chuyennganh_dotxettuyen.id_chuyennganh
                    WHERE iddot = ?  AND iddotxt = ?';
                    $trungtuyenthpt = DB::select($sql,[$iddot,$iddotxt,$iddot,$iddotxt,$iddot,$iddotxt,$iddot,$iddotxt,$iddot,$iddotxt,$iddot,$iddotxt,$iddot,$iddotxt,$iddot,$iddotxt]);

                    //Tạo mảng trúng tuyển để cập nhật vào bảng thống kê theo đợt xét tuyển
                    // $data_trungtuyenthpt = [];
                    foreach ($trungtuyenthpt as $key => $row) {
                        $temp = [
                            'id' => $row->id,
                            'id_nganh' => $row->id_nganh,
                            'id_nganh_dotxt' => $row->id_nganh_dotxt,
                            'id_chuyennganh' => $row->id_chuyennganh,
                            'iddot' => $row->iddot,
                            'iddotxt' => $row->iddotxt,
                            'trungtuyenthpt' =>$row->trungtuyenthpt,
                            'diemchuanthpt' =>$row->diemchuanthpt,
                            'trungtuyenhocba' =>$row->trungtuyenhocba,
                            'trungtuyensom' =>$row->sltrungtuyensom,
                            'diemchuanhocba' =>$row->diemchuanhocba,
                            'trungtuyennhom' =>$row->trungtuyennhom,
                            'trungtuyenbo' =>$row->trungtuyenbo,
                            'tong' => $row->trungtuyenhocba +  $row->sltrungtuyensom + $row->trungtuyenthpt

                        ];
                        $data_trungtuyenthpt[] = $temp;
                    }

                    //Cập nhật thông kê vào bảng dữ liệu
                    DB::table('24_chuyennganh_dotxettuyen')
                    ->upsert(
                        $data_trungtuyenthpt,
                        [
                            'id',
                            'id_nganh',
                            'id_nganh_dotxt',
                            'id_chuyennganh',
                            'iddot',
                            'iddotxt'
                        ],
                        [
                            'trungtuyenthpt',
                            'diemchuanthpt',
                            'trungtuyenhocba',
                            'diemchuanhocba',
                            'trungtuyensom',
                            'trungtuyennhom',
                            'trungtuyenbo',
                            'tong',
                        ]
                    );

                    // Trả kết quả thống kê xét tuyển
                    DB::commit();
                    return $data_trungtuyenthpt;
                }catch(Exception $e){
                    DB::rollback();
                    return 'err_0';
                }
                break;
            case '1':
                # code...
                break;
            default:
                # code...
                break;
        }

    }

    function bieudolocaotheonganh($iddotts,$id_nganh){
        $dotxt =  DB::table('24_dotxettuyen')
        ->select('iddotxt')
        ->where('iddotts',$iddotts)
        ->get();
        $sql = "SELECT";
        foreach ($dotxt as $key => $row) {
            $sql .= ' MAX(CASE WHEN iddotxt = '.$row->iddotxt.' THEN tong ELSE 0 END) as tong'.$row->iddotxt.",";
        }
        $sql = rtrim($sql,',');
        $sql .=  ' FROM `24_chuyennganh_dotxettuyen`  WHERE id_nganh = ? GROUP BY id_nganh';

        $data = DB::select($sql, [$id_nganh]);
        return $data;
    }

    //Import du lieu
    function importdulieu()
    {
        // $url = URL::current();
        // $quyen = $this->kiemtraquyen_url($url);
        // if ($quyen == 1) {
            return view('user_24.admin24.manage.quanlyxettuyen.importdulieu',
                [
                    'menu' =>   $this->sidebar(),
                ]
            );
        // } else {
        //     return view('user_24.admin24.include.404');
        // }
    }

    public function submit_taikhoanthisinh(Request $request){ //Name, Email, Mật khẩu, google_id
        //Import những thí sinh chưa có thông tin cá nhân (table 24_thongtincanhan) trên hệ thông (Căn cứ vào CMND)
        try{
            Excel::import(new Admin24_ImportDanhSachThiSinh(), $request->file('taikhoanthisinh'));
            return 'imp_1';
        }catch(Exception $e){
            return 'imp_0';
        }
    }

    public function submit_thongtinthisinh(Request $request){ //Name, Email, Mật khẩu, google_id
        try{
            Excel::import(new Admin24_ImportThongTinThiSinh(), $request->file('thongtinthisinh'));
            return 'imp_1';
        }catch(Exception $e){
            return 'imp_0';
        }
    }

    public function submit_khuvucuutien(Request $request){ //Name, Email, Mật khẩu, google_id
        $dotts = $this->motdottuyensinh();
        try{
            Excel::import(new Admin24_ImportKhuVucUuTien($dotts), $request->file('khuvucuutien'));
            return 'imp_1';
        }catch(Exception $e){
            return 'imp_0';
        }
    }

    function submit_doituonguutien(Request $request)//Update hoặc tạo mới từ Dữ liệu Bộ, theo đợt tuyển sinh
    {
        $dotts = $this->motdottuyensinh();
        try{
            Excel::import(new Admin24_ImportDoiTuongUuTien($dotts), $request->file('doituonguutien'));
            return 'imp_1';
        }catch(Exception $e){
            return 'imp_0';
        }
    }

    function submit_namtotnghiep(Request $request)//Update hoặc tạo mới từ Dữ liệu Bộ, theo đợt tuyển sinh
    {
        try{
            Excel::import(new Admin24_NamTotNghiep(), $request->file('namtotnghiep'));
            return 'imp_1';
        }catch(Exception $e){
            return 'imp_0';
        }
    }

     function import_loaddanhsachtaikhoan(){
        $dotts = $this->motdottuyensinh();
        $sql = "SELECT
            ROW_NUMBER() OVER (ORDER BY acc.id) AS thutu,
            acc.id AS id_taikhoan,
            acc.email,
            ttcn.hoten,
            ttcn.cccd AS cccd,
            ttcn.dienthoai,
            DATE_FORMAT(ttcn.ngaysinh, '%d/%m/%Y') AS ngaysinh,
            IF(ttcn.gioitinh = 1, 'Nữ', 'Nam') AS gioitinh,
            kvut.khuvucuutien,
            dtut.doituonguutien,
            ntn.namtotnghiep
        FROM
            account24s acc
        LEFT JOIN 24_thongtincanhan ttcn  ON  acc.id = ttcn.id_taikhoan
        LEFT JOIN 24_namtotnghiep ntn  ON  acc.id = ntn.id_taikhoan
        LEFT JOIN (SELECT 24_khuvucuutien.id_taikhoan as id_taikhoan,l_priority_area.id_priority_area as khuvucuutien FROM 24_khuvucuutien INNER JOIN l_priority_area ON l_priority_area.id = 24_khuvucuutien.khuvucuutien WHERE dotts = ?) AS  kvut ON kvut.id_taikhoan = acc.id
        LEFT JOIN (SELECT 24_doituonguutien.id_taikhoan as id_taikhoan,l_policy_users.name_policy_user as doituonguutien FROM 24_doituonguutien INNER JOIN l_policy_users ON l_policy_users.id = 24_doituonguutien.id_doituong WHERE dotts = ?) AS  dtut ON dtut.id_taikhoan = acc.id
        WHERE
            acc.cccd_bo IS NOT NULL";
        $data = DB::select($sql,[$dotts,$dotts]);
        $json_data['data'] = $data;
        $data = json_encode($json_data);
        return $data;
    }

    function export_taikhoanthisinh(Request $request){ //Name, Email, Mật khẩu, google_id
        //Xuất tất cả danh sách tài khoản hiện có của hệ thống
        $dotts = $this->motdottuyensinh();
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $title = 'DanhSachTaiKhoan' . date("d-m-Y H:i:s") . '.xlsx';
        return Excel::download(new Admin24_ExportDanhSachThiSinh($dotts), $title);
    }

    //Import thông tin xét tuyển
    function importketquahoctap()
    {
        // $url = URL::current();
        // $quyen = $this->kiemtraquyen_url($url);
        // if ($quyen == 1) {
            return view('user_24.admin24.manage.quanlyxettuyen.importketquahoctap ',
                [
                    'menu' =>   $this->sidebar(),
                ]
            );
        // } else {
        //     return view('user_24.admin24.include.404');
        // }
    }
    function submit_ketquahoctap(Request $request)//Update hoặc tạo mới từ Dữ liệu Bộ, theo đợt tuyển sinh
    {
        try{
            Excel::import(new Admin24_ImportKetQuaHocTap(), $request->file('ketquahoctap'));
            return 'imp_1';
        }catch(Exception $e){
            return 'imp_0';
        }
    }
    function import_loadketquahoctap($dotts,$start,$end){
        $sql = "SELECT
            ROW_NUMBER() OVER (ORDER BY acc.id) AS thutu,
            acc.id AS id_taikhoan,
            ttcn.hoten,
            ttcn.cccd AS cccd,
            mh.lop as lop,
            mh.hocki as hocki,
            mh.mon as mon,
            mh.diem as diem
        FROM
            account24s acc
        LEFT JOIN 24_thongtincanhan ttcn  ON  acc.id = ttcn.id_taikhoan
        LEFT JOIN
            (SELECT kqht.id_student_result as id_taikhoan, id_class_result as lop, id_semester_result as hocki, mark_result as diem, l_subject.id as id, l_subject.name_subject as mon FROM 24_ketquahoctap kqht INNER JOIN l_subject  ON  l_subject.id = kqht.id_subject) as mh
        ON acc.id = mh.id_taikhoan
        WHERE
            acc.cccd_bo IS NOT NULL AND acc.id IN (SELECT DISTINCT(id_taikhoan) as id FROM 24_nguyenvong WHERE iddot = ? AND acc.id >= ? AND acc.id <= ?
        )";
        $data = DB::select($sql,[$dotts,$start,$end]);
        $json_data['data'] = $data;
        $data = json_encode($json_data);
        return $data;
    }

    function export_ketquahoctap($dotts,$start,$end){
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $title = 'DanhSachKetQuaHocTap' . date("d-m-Y H:i:s") . '.xlsx';
        return Excel::download(new Admin24_ExportKetQuaHocTap($dotts,$start,$end), $title);
    }

    //Import Nguyện vọng xét tuyển
    function importnguyenvong()
    {
        // $url = URL::current();
        // $quyen = $this->kiemtraquyen_url($url);
        // if ($quyen == 1) {
            return view('user_24.admin24.manage.quanlyxettuyen.importnguyenvong ',
                [
                    'menu' =>   $this->sidebar(),
                ]
            );
        // } else {
        //     return view('user_24.admin24.include.404');
        // }
    }
    function submit_nguyenvongxettuyen(Request $request)//Update hoặc tạo mới từ Dữ liệu Bộ, theo đợt tuyển sinh
    {
        $dotts = $this->motdottuyensinh();
        try{
            Excel::import(new Admin24_ImportNguyenVongXetTuyen($dotts), $request->file('nguyenvongxettuyen'));
            return 'imp_1';
        }catch(Exception $e){
            return 'imp_0';
        }
    }
    function import_loadnguyenvongxettuyen($dotts){
        $sql = "SELECT
            ROW_NUMBER() OVER (ORDER BY nv.id) AS stt,
            nv.id_taikhoan AS id_taikhoan,
            ttcn.hoten as hoten,
            ttcn.cccd as cccd,
            ng.name_major as nganh,
            if(nv.idphuongthuc = 1,'HB','THPT') as phuongthuc,
            nv.thutu as thutu,
            gr.id_group as tohop,
            nv.diemtohop as diemtohop,
            nv.diemuutien as diemuutien,
            nv.diemxettuyen as diemxettuyen,
            if(nv.tts = 1,'x','') as tts
        FROM
            24_nguyenvong nv
        LEFT JOIN 24_thongtincanhan ttcn  ON  nv.id_taikhoan = ttcn.id_taikhoan
        INNER JOIN l_major ng  ON  nv.idnganh = ng.id
        LEFT JOIN l_group gr ON  nv.tohop = gr.id
        WHERE nv.iddot = ?
        --     (SELECT kqht.id_student_result as id_taikhoan, id_class_result as lop, id_semester_result as hocki, mark_result as diem, l_subject.id as id, l_subject.name_subject as mon FROM 24_ketquahoctap kqht INNER JOIN l_subject  ON  l_subject.id = kqht.id_subject) as mh
        -- ON acc.id = mh.id_taikhoan
        -- WHERE
        --     acc.cccd_bo IS NOT NULL AND acc.id IN (SELECT DISTINCT(id_taikhoan) as id FROM 24_nguyenvong WHERE iddot = ? AND acc.id >= ? AND acc.id <= ?
        -- )
        ";
        $data = DB::select($sql,[$dotts]);
        $json_data['data'] = $data;
        $data = json_encode($json_data);
        return $data;
    }

    function export_nguyenvongxettuyen_kiemtrasoluong($dotts){
        return DB::table('24_nguyenvong')
        ->where('iddot',$dotts)
        ->count();
    }
    function export_nguyenvongxettuyen($dotts,$start,$end){
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $title = 'DanhSachNguyenVong' . date("d-m-Y H:i:s") . '.xlsx';
        return Excel::download(new Admin24_ExportDanhSachNguyenVong($dotts,$start,$end), $title);
    }
    function import_tinhdiemtungtohophocba($id_taikhoan,$tohop){
        //Điểm bao gồm điểm HK1, HK2, CN của từng lớp

        $sql = "SELECT mark_result
        FROM 24_ketquahoctap kqht
        WHERE
            kqht.id_student_result  = ?
            AND kqht.id_subject IN (SELECT id_subject FROM l_group_subject WHERE id_group = ?)
            AND id_semester_result  = 'CN'
            AND id_class_result = 12
        ";
        $kiemtratohop1 = DB::select($sql,[$id_taikhoan,$tohop]);
        $diemmon1 = 0;
        foreach ($kiemtratohop1 as $key => $row) {
            if($row->mark_result != 0){
                $diemmon1 ++;
            }
        }
        if(count($kiemtratohop1) == 3 && $diemmon1 == 3){
            $sql = "SELECT
                SUM(mark_result) as diemtohop
            FROM 24_ketquahoctap kqht
            WHERE
                kqht.id_student_result  = ?
                AND kqht.id_subject IN (SELECT id_subject FROM l_group_subject WHERE id_group = ?)
                AND id_semester_result  = 'CN'
                AND id_class_result = 12
            GROUP BY id_class_result
            ";
            $diemtohop1 = DB::select($sql,[$id_taikhoan,$tohop])[0]->diemtohop;
        }else{
            $diemtohop1 = 0;
        }


        $sql = "SELECT
            id_subject,
            mark_result,
        CASE
            WHEN (id_semester_result = 'CN' AND id_class_result IN (10, 11))
            OR (id_semester_result = 1 AND id_class_result = 12)
            THEN 1
            ELSE 0
        END AS canhtinh
        FROM 24_ketquahoctap kqht
        WHERE kqht.id_student_result = ? AND id_subject IN (SELECT id_subject FROM l_group_subject WHERE id_group = ?)
        ";
        $kiemtratohop2 = DB::select($sql,[$id_taikhoan,$tohop]);
        $diemmon2 = 0;
        foreach ($kiemtratohop2 as $key => $row) {
            if($row->mark_result != 0){
                $diemmon2 ++;
            }
        }
        if(count($kiemtratohop2) == 15 && $diemmon2 == 15){
            $sql = "SELECT
            SUM(total_mark) AS diemtohop
            FROM (
                SELECT
                    id_subject,
                    ROUND(SUM(mark_result)/3,2) AS total_mark
                FROM (
                    SELECT
                        id_subject,
                        mark_result,
                        CASE
                            WHEN (id_semester_result = 'CN' AND id_class_result IN (10, 11))
                            OR (id_semester_result = 1 AND id_class_result = 12)
                            THEN 1
                            ELSE 0
                        END AS canhtinh
                    FROM 24_ketquahoctap kqht
                    WHERE kqht.id_student_result = ? AND id_subject IN (SELECT id_subject FROM l_group_subject WHERE id_group = ?)
                ) AS subquery
                WHERE canhtinh = 1
                GROUP BY id_subject
            ) AS final_subquery
            ";
            $diemtohop2 = DB::select($sql,[$id_taikhoan,$tohop])[0]->diemtohop;
        }else{
            $diemtohop2 = 0;
        }
        $diemtohop1 >= $diemtohop2 ? $diemtohop =  $diemtohop1 : $diemtohop =  $diemtohop2;
        return $diemtohop;
    }

    function import_tinhdiemtungtohopthpt($id_taikhoan,$tohop){
        //Điểm bao gồm điểm HK1, HK2, CN của từng lớp
        $sql = "SELECT mark_result
        FROM 24_ketquahoctap kqht
        WHERE
            kqht.id_student_result  = ?
            AND kqht.id_subject IN (SELECT id_subject FROM l_group_subject WHERE id_group = ?)
            AND id_semester_result  = 'PT'
            AND id_class_result = 'TN'
        ";
        $kiemtratohop = DB::select($sql,[$id_taikhoan,$tohop]);
        $demmon = 0;
        foreach ($kiemtratohop as $key => $row) {
            if($row->mark_result != 0){
                $demmon ++;
            }
        }
        if(count($kiemtratohop) == 3 && $demmon == 3){
            $sql = "SELECT
                SUM(mark_result) as diemtohop
            FROM 24_ketquahoctap kqht
            WHERE
                kqht.id_student_result  = ?
                AND kqht.id_subject IN (SELECT id_subject FROM l_group_subject WHERE id_group = ?)
                AND id_semester_result  = 'PT'
                AND id_class_result = 'TN'
            GROUP BY id_class_result
            ";
            $diemtohop = DB::select($sql,[$id_taikhoan,$tohop])[0]->diemtohop;
        }else{
            $diemtohop = 0;
        }
        return $diemtohop;
    }

    function import_tinhdiemtheonganh($id_taikhoan,$idnganh,$phuongthuc){
        $diem_max = 0;
        $tohop_max = 0;
        $nganh = DB::table('l_major_group')->where('id_major',$idnganh)->get();
        foreach ($nganh as $key => $row) {
            $tohop = $row->id_gruop;
            switch ($phuongthuc) {
                case '1':
                    $diem = $this->import_tinhdiemtungtohophocba($id_taikhoan,$tohop);
                    break;
                case '2':
                    $diem = $this->import_tinhdiemtungtohopthpt($id_taikhoan,$tohop);
                    break;
                default:
                    # code...
                    break;
            }
            if($diem > $diem_max){
                $diem_max = $diem;
                $tohop_max = $tohop;
            }else{
                $diem_max = $diem_max;
                $tohop_max = $tohop_max;
            }
        }
        return array(
            'id_taikhoan' => $id_taikhoan,
            'idnganh' => $idnganh,
            'diemtohop' =>  $diem_max,
            'tohop' =>  $tohop_max,
        );
    }

    function import_tinhdiemuutien($diemtohop,$id_taikhoan,$dotts){
        $namtotnghiep = DB::table('24_namtotnghiep')->where('id_taikhoan',$id_taikhoan)->first();
        $khuvuc = DB::table('24_khuvucuutien')
        ->select('mark_priority','l_priority_area.id','l_priority_area.name_priority_area')
        ->join('l_priority_area','l_priority_area.id','24_khuvucuutien.khuvucuutien')
        ->where('id_taikhoan',$id_taikhoan)->where('dotts',$dotts)->first();
        if($khuvuc){
            $diemuutienkhuvuc = $khuvuc->mark_priority;
            $idkhuvuc = $khuvuc->id;
            $khuvuc = $khuvuc->name_priority_area;
        }else{
            $diemuutienkhuvuc = 0;
            $idkhuvuc = 0;
            $khuvuc = "";
        }

        if($namtotnghiep->namtotnghiep < (int)Carbon::now()->year - 1){
            $diemuutienkhuvuc = 0;
        }else{
            $diemuutienkhuvuc = $diemuutienkhuvuc;
        }


        $doituong = DB::table('24_doituonguutien')
        ->select('mark_policy_user','l_policy_users.id','l_policy_users.name_policy_user')
        ->join('l_policy_users','l_policy_users.id','24_doituonguutien.id_doituong')
        ->where('id_taikhoan',$id_taikhoan)->where('dotts',$dotts)->first();
        if($doituong){
            $diemdoituong = $doituong->mark_policy_user;
            $iddoituong =  $doituong->id;
            $doituong =  $doituong->name_policy_user;
        }else{
            $diemdoituong = 0; $iddoituong =  0; $doituong =  '';
        }
        if($diemtohop >= 22.5){
            $diemuutien = ((30 - $diemtohop)/7.5)*($diemdoituong + $diemuutienkhuvuc) ;
        }else{
            $diemuutien =   $diemdoituong + $diemuutienkhuvuc;
        }
        return array(
            'id_taikhoan' => $id_taikhoan,
            'idkhuvuc' => $idkhuvuc,
            'khuvuc' => $khuvuc,
            'iddoituong' =>  $iddoituong,
            'doituong' => $doituong,
            'diemuutien' => $diemuutien,
            'namtotnghiep' => $namtotnghiep->namtotnghiep,
        );
    }

    function import_tinhdiemxettuyen($idtaikhoan, $nganh,  $phuongthuc, $dotts){
        $diemtohop = $this->import_tinhdiemtheonganh($idtaikhoan,$nganh,$phuongthuc);
        $diemuutien = $this->import_tinhdiemuutien($diemtohop['diemtohop'],$idtaikhoan,$dotts);
        $diemxettuyen =  $diemtohop['diemtohop'] + $diemuutien['diemuutien'];
        return array(
            'diemxettuyen' => $diemxettuyen,
            'uutien' =>  $diemuutien,
            'diemtohop' =>  $diemtohop,
        );
    }

    function tinhdiemxettuyentheokhoangthisinh($start,  $end, $dotts){
        // $dotts = $this->motdottuyensinh();
        $thisinh = DB::table('24_nguyenvong')
        ->where('iddot', $dotts)
        ->whereBetween('id_taikhoan', [$start,  $end])
        ->get();
        // $data_total = [];
        foreach ($thisinh as $key => $row) {
            $idtaikhoan = $row->id_taikhoan;
            $idnganh = $row->idnganh;
            $idphuongthuc = $row->idphuongthuc;
            $data = $this->import_tinhdiemxettuyen($idtaikhoan, $idnganh,  $idphuongthuc, $dotts);
            $temp = array(
                'id_taikhoan' => $idtaikhoan,
                'thutu' => $row->thutu,
                'idphuongthuc' => $row->idphuongthuc,
                'iddot' => $dotts,
                'diemxettuyen' => round($data['diemxettuyen'],2),
                'diemuutien'    => round($data['uutien']['diemuutien'],3),
                'diemtohop'    => round($data['diemtohop']['diemtohop'],3),
                'tohop' => $data['diemtohop']['tohop'],
                'idnganh' =>  $idnganh,
            );
            $data_total[] =  $temp;
        }
        DB::table('24_nguyenvong')
        ->upsert(
            $data_total,
            ['id_taikhoan','thutu','iddot','idphuongthuc'],
            ['diemxettuyen','diemuutien','diemtohop','tohop','idnganh'],
        );
    }

    function cal_nguyenvongxettuyen(Request $r){
        $start = $r->input('start');
        $end = $r->input('end');
        $dotts = $r->input('dotts');
        DB::beginTransaction();
        try{
            $this->tinhdiemxettuyentheokhoangthisinh($start,  $end, $dotts);
            DB::commit();
            // return  $data_total;
            return 'imp_4';
        }catch(Exception $e){
            DB::rollBack();
            return 'imp_0';
        }
    }
        //Quản lý điều tra
    //Load index
    function ketquatrungtuyentheodotts($id_covanhoctap,$id_chuyennganh,$cccd,$hoten,$xacnhan,$daxem){
        $hoten_fix = preg_replace('/\s+/', ' ', trim($hoten));
        $cccd_fix = preg_replace('/\s+/', ' ', trim($cccd));
        $trungtuyen = DB::table('24_trungtuyen')
        ->select('account24s.email','24_thongtincanhan.cccd','24_thongtincanhan.hoten','24_thongtincanhan.dienthoai','24_trungtuyen.id as id','24_trungtuyen.diemxettuyen','24_chuyennganh.tenchuyennganh','xacnhan','daxem')
        // ->where('id_taikhoan', $id_taikhoan)
        ->join('24_chuyennganh','24_chuyennganh.id','24_trungtuyen.id_chuyennganh')
        ->leftJoin('24_thongtincanhan','24_thongtincanhan.id_taikhoan','24_trungtuyen.id_taikhoan')
        ->leftJoin('account24s','account24s.id','24_trungtuyen.id_taikhoan')
        ->join('24_covanhoctap','24_covanhoctap.id_chuyennganh','24_trungtuyen.id_chuyennganh')
        ->where('24_covanhoctap.id_taikhoan_dangnhap', $id_covanhoctap)
        ->where('24_trungtuyen.id_chuyennganh', $id_chuyennganh)
        ->where('24_trungtuyen.xacnhan', $xacnhan)
        ->where('24_trungtuyen.daxem', $daxem)
        ->where(function($query) use ($cccd_fix) {
            if ($cccd_fix == '') {
                $query->whereNotNull('24_trungtuyen.id'); // Thay 'column_name' bằng tên cột thực tế
            } else {
                $query->where('24_thongtincanhan.cccd', $cccd_fix); // Thay 'column_name' bằng tên cột thực tế
            }
        })
        ->where(function($query) use ($hoten_fix) {
            if ($hoten_fix == '') {
                $query->whereNotNull('24_trungtuyen.id'); // Thay 'column_name' bằng tên cột thực tế
            } else {
                $query->where('24_thongtincanhan.hoten', 'LIKE', '%' . $hoten_fix . '%');
            }
        })
        ->get();
        return $trungtuyen;
    }

    function dieutranhaphoc(){
        $url = URL::current();
        $quyen = $this->kiemtraquyen_url($url);
        if ($quyen == 1) {
            return view('user_24.admin24.manage.dieutranhaphoc.canbodieutra',
                [
                    'menu' => $this->sidebar(),
                    // 'trungtuyen' =>  $this->ketquatrungtuyentheodotts(45,1,'','',1,1),
                ]
            );
        } else {
            return view('user_24.admin24.include.404');
        }
    }

    function capnhattrangthaixnnh(Request $request){
        $id_admin = Auth::guard('loginadmin')->user()->id;
        $id_trungtuyen =  $request->input('id_trungtuyen');
        $id_trangthai =  $request->input('id_trangthai');
        $check =  $request->input('check');
        $check == 0 ? $trangthai = 0 : $trangthai =  $id_trangthai;
        $sql = "SELECT * FROM 24_dotxettuyen WHERE iddotxt IN (SELECT iddotxt FROM 24_trungtuyen WHERE id = ? )";
        $data  = DB::select($sql,[$id_trungtuyen]);
        // $idquytrinh  =   $data[0]->id_quytrinhcongbo;
          $idquytrinh  =  2;
        $khoadot  =   0;
        // $khoadot  =   $data[0]->khoadot;
        switch ($idquytrinh) {
            case '1':
                if($khoadot == 0){
                    DB::beginTransaction();
                    try{
                        $update = DB::table('24_trungtuyen')
                        ->where('id',$id_trungtuyen)
                        ->update([
                            'trangthaidieutra' => $trangthai
                        ]);
                        if($update == 1){
                            switch ($id_trangthai) {
                                case '1':
                                    $noidung = "Xác nhận";
                                    break;
                                case '2':
                                    $noidung = "Không xác nhận";
                                    break;
                                case '3':
                                    $noidung = "Phân vân";
                                    break;
                                case '4':
                                    $noidung = "Không liên lạc được";
                                    break;
                                case '5':
                                    $noidung = "Yêu cầu chuyển ngành";
                                    break;
                                default:
                                    $noidung = "Hủy trạng thái";
                                    break;
                            }
                            $ten = DB::table('24_trungtuyen')
                            ->join('24_thongtincanhan','24_thongtincanhan.id_taikhoan','24_trungtuyen.id_taikhoan')
                            ->first();
                            $user_agent = $_SERVER['HTTP_USER_AGENT'];
                            DB::table('24_lichsu')
                            ->insert([
                                'id_taikhoan' => $ten->id_taikhoan,
                                'noidung'   => "Cập nhật XNNH (TTS) của TS: ".$ten->hoten." (ID".$ten->id_taikhoan."): $noidung ",
                                'hienthi'   => 0,
                                'id_nhansu' => $id_admin,
                                'thietbi'   => $user_agent,
                                'ip'        => request()->ip()
                            ]);
                            DB::commit();
                            $trangthai = 'upd_1';
                        }else{
                            $trangthai = 'upd_0';
                        }
                        $xacnhan = DB::table('24_trungtuyen')
                        ->where('id',$id_trungtuyen)
                        ->first();
                        $noidung = $xacnhan->trangthaidieutra;
                    }catch(Exception $e){
                        DB::rollBack();
                        $trangthai ='-100';
                    }
                    return array(
                        'trangthai' => $trangthai,
                        'noidung'   => $noidung,
                        'id_trungtuyen'   => $id_trungtuyen
                    );
                }else{
                    $xacnhan = DB::table('24_trungtuyen')
                    ->where('id',$id_trungtuyen)
                    ->first();
                    $noidung = $xacnhan->trangthaidieutra;
                    return array(
                        'trangthai' => 'dot_1',
                        'noidung'   => $noidung,
                        'id_trungtuyen'   => $id_trungtuyen
                    );
                }
                break;
            case '2':
                if($khoadot == 0){
                    DB::beginTransaction();
                    try{
                        $trangthai == 1 ? $congbo = 1 : $congbo = 0;
                        $update = DB::table('24_trungtuyen')
                        ->where('id',$id_trungtuyen)
                        ->update([
                            'trangthaidieutra' => $trangthai,
                            'congbo' => $congbo
                        ]);
                        if($update == 1){
                            switch ($id_trangthai) {
                                case '1':
                                    $noidung = "Xác nhận";
                                    break;
                                case '2':
                                    $noidung = "Không xác nhận";
                                    break;
                                case '3':
                                    $noidung = "Phân vân";
                                    break;
                                case '4':
                                    $noidung = "Không liên lạc được";
                                    break;
                                case '5':
                                    $noidung = "Yêu cầu chuyển ngành";
                                    break;
                                default:
                                    $noidung = "Hủy trạng thái";
                                    break;
                            }
                            $ten = DB::table('24_trungtuyen')
                            ->join('24_thongtincanhan','24_thongtincanhan.id_taikhoan','24_trungtuyen.id_taikhoan')
                            ->first();
                            $user_agent = $_SERVER['HTTP_USER_AGENT'];
                            DB::table('24_lichsu')
                            ->insert([
                                'id_taikhoan' => $ten->id_taikhoan,
                                'noidung'   => "Cập nhật XNNH (TTS) của TS: ".$ten->hoten." (ID".$ten->id_taikhoan."): $noidung ",
                                'hienthi'   => 0,
                                'id_nhansu' => $id_admin,
                                'thietbi'   => $user_agent,
                                'ip'        => request()->ip()
                            ]);
                            DB::commit();
                            $trangthai = 'upd_1';
                        }else{
                            $trangthai = 'upd_0';
                        }
                        $xacnhan = DB::table('24_trungtuyen')
                        ->where('id',$id_trungtuyen)
                        ->first();
                        $noidung = $xacnhan->trangthaidieutra;
                    }catch(Exception $e){
                        DB::rollBack();
                        $trangthai ='-100';
                    }
                    return array(
                        'trangthai' => $trangthai,
                        'noidung'   => $noidung,
                        'id_trungtuyen'   => $id_trungtuyen
                    );
                }else{
                    $xacnhan = DB::table('24_trungtuyen')
                    ->where('id',$id_trungtuyen)
                    ->first();
                    $noidung = $xacnhan->trangthaidieutra;
                    return array(
                        'trangthai' => 'dot_1',
                        'noidung'   => $noidung,
                        'id_trungtuyen'   => $id_trungtuyen
                    );
                }
                break;
            case '3':
                # code...
                break;
            default:
                # code...
                break;
        }
    }

    function capnhatghichuxnnh(Request $request){
        $id_admin = Auth::guard('loginadmin')->user()->id;
        $ghichu =  $request->input('ghichu');
        $id_trungtuyen =  $request->input('id_trungtuyen');
        DB::beginTransaction();
        try{
            $update = DB::table('24_trungtuyen')
            ->where('id',$id_trungtuyen)
            ->update([
                'ghichu_xnnh' => $ghichu
            ]);
            if($update == 1){
                $ten = DB::table('24_trungtuyen')
                ->join('24_thongtincanhan','24_thongtincanhan.id_taikhoan','24_trungtuyen.id_taikhoan')
                ->first();
                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                DB::table('24_lichsu')
                ->insert([
                    'id_taikhoan' => $ten->id_taikhoan,
                    'noidung'   => "Cập nhật XNNH (TTS) của TS: ".$ten->hoten." (ID".$ten->id_taikhoan."): $ghichu ",
                    'hienthi'   => 0,
                    'id_nhansu' => $id_admin,
                    'thietbi'   => $user_agent,
                    'ip'        => request()->ip()
                ]);
                DB::commit();
                $trangthai = 'upd_1';
            }else{
                $trangthai = 'upd_0';
            }
            $noidung = $ghichu;
        }catch(Exception $e){
            DB::rollBack();
            $trangthai ='-100';
        }
        return array(
            'trangthai' => $trangthai,
            'noidung'   => $noidung,
            'id_trungtuyen'   => $id_trungtuyen
        );
    }
        //Thống kê tình trạng điều tra nhập học
    function  tinhtrangnhaphoc(){
        $url = URL::current();
        $quyen = $this->kiemtraquyen_url($url);
        if ($quyen == 1) {
            return view('user_24.admin24.manage.dieutranhaphoc.tinhtrangnhaphoc',
                [
                    'menu' => $this->sidebar(),
                    // 'trungtuyen' =>  $this->ketquatrungtuyentheodotts(45,1,'','',1,1),
                ]
            );
        } else {
            return view('user_24.admin24.include.404');
        }
    }


    function ttnh_danhsach($iddotts, $iddotxt, $id_chuyennganh){
        $json_data['data'] = $this->data_danhsachtrungtuyenchinhthuc($iddotts, $iddotxt, $id_chuyennganh);
        $data = json_encode($json_data);
        return $data;
    }

                                            //Phân hệ Quản lý sinh viên
function timid_taikhoan($mssv,$cccd){
    if( $mssv == ''){
        if($cccd == ''){
            $id_taikhoan = "-1";
        }else{
            $sql = "SELECT 24_thongtincanhan.id_taikhoan FROM 24_thongtincanhan  WHERE cccd = ?";
            $id_taikhoan = DB::select($sql,[$cccd]);
        }
    }else{
        if($cccd == ''){
            $sql = "SELECT 24_mssv.id_taikhoan FROM 24_mssv  WHERE mssv = ?";
            $id_taikhoan = DB::select($sql,[$mssv]);
        }else{
            $sql = "SELECT 24_thongtincanhan.id_taikhoan FROM 24_thongtincanhan INNER JOIN 24_mssv ON 24_thongtincanhan.id_taikhoan = 24_mssv.id_taikhoan WHERE mssv = ? AND cccd = ?";
            $id_taikhoan = DB::select($sql,[$mssv,$cccd]);
        }
    }

    if($id_taikhoan){
        if($id_taikhoan == '-1'){
            $trangthai = -1;
            $id = -1;
        }else{
            $trangthai = 1;
            $id = $id_taikhoan[0]->id_taikhoan;
        }
    }else{
        $trangthai = 0;
        $id = 0;
    }
    return array(
        'trangthai' => $trangthai,
        'id_taikhoan' => $id
    );
}

//Ho so nhap hoc
public function hosonhaphoc_qlsv()
{
    $res =  DB::table('24_thongtincanhan')
        ->select('hoten as text','id_taikhoan as id','gioitinh as check')
        ->get();

        return view('user_24.admin24.manage.quanlynhaphoc.hosonhaphoc',
        [
            'menu' =>  $this->sidebar(),
            'res' => $res,
        ]
    );
}

public function loadttcn_qlsv(Request $request)//Load ho so sinh vien
{
    $cccd = $request->input('cccd');
    $mssv = $request->input('mssv');
    $trangthai = $this->timid_taikhoan($mssv,$cccd)['trangthai'];
    try{
        switch ($trangthai) {
            case '-1':
                return array(
                    'data' => '',
                    'trangthai' => 'up_3'
                );
                // return response()->json(['error' => 'up_3']);
                break;
            case '0':
                return array(
                    'data' => '',
                    'trangthai' =>'up_2'
                );
                // response()->json(['error' => 'up_2']);

                break;
            case '1':
                $id_taikhoan = $this->timid_taikhoan($mssv,$cccd)['id_taikhoan'];
                $sql = "SELECT 24_thongtincanhan.id_taikhoan as id_taikhoan, noisinh, hoten, dienthoai, ngaysinh, gioitinh, cccd, mssv
                FROM 24_thongtincanhan
                LEFT JOIN 24_mssv ON 24_mssv.id_taikhoan = 24_thongtincanhan.id_taikhoan
                WHERE 24_thongtincanhan.id_taikhoan = ?";
                $ttcn =  DB::select($sql,[$id_taikhoan]);
                if($ttcn){
                    $ttcn1 =  DB::table('24_thongtincanhan')
                        ->leftjoin('24_bhyt', '24_thongtincanhan.id_taikhoan', '=', '24_bhyt.id_taikhoan')
                        ->leftjoin('24_hosonhaphoc', '24_thongtincanhan.id_taikhoan', '=', '24_hosonhaphoc.id_taikhoan')
                        ->select('id_tongiao', 'id_dantoc','id_quoctich', 'id_tinh_noisinh', 'id_huyen_noisinh', 'id_xa_noisinh', 'id_huyen_ttru', 'id_tongiao as tongiao',
                                'id_tinh_ttru', 'id_xa_ttru', 'id_tinh_quequan', 'id_huyen_quequan', 'id_xa_quequan', 'ngaycapcccd', 'giaykhaisinh',
                                'ngayvaodang', 'ngayvaodoan', 'duoi_xa_ttru', 'duoi_xa_quequan', 'hotencha', 'hotenme','nguoidodau', 'dienthoaicha',
                                'dienthoaime', 'dienthoainguoidodau', 'nghenghiepcha', 'nghenghiepme', 'nghenghiepnguoidodau', 'khuyettat', '24_hosonhaphoc.bhyt',
                                '24_thongtincanhan.diachi','noicapcccd','24_hosonhaphoc.ghichu')
                        ->where('24_thongtincanhan.id_taikhoan',$id_taikhoan)
                    ->first();

                    $lichsu = DB::table('24_lichsu')
                        ->selectRaw('24_lichsu.noidung, DATE_FORMAT(24_lichsu.create_at, "%d/%m/%Y %H:%i") as create_at, 24_accountsadmin.name as name, account24s.name as tenthisinh, 24_lichsu.id_nhansu as id_nhansu, account24s.img_gg')
                        ->leftJoin('24_accountsadmin', '24_accountsadmin.id', '24_lichsu.id_nhansu')
                        ->leftJoin('account24s', 'account24s.id', '24_lichsu.id_taikhoan')
                        ->where('id_taikhoan', $id_taikhoan)
                        ->where('hienthi', 1)
                        ->orderBy('24_lichsu.create_at', 'DESC')
                        ->get();

                    // $lichsu = DB::select("SELECT account24s.name as tennhansu, noidung, 24_lichsu.create_at, 24_thongtincanhan.hoten as hoten, img_gg FROM 24_thongtincanhan, account24s, 24_lichsu WHERE 24_thongtincanhan.id_taikhoan = 24_lichsu.id_taikhoan and 24_lichsu.id_nhansu = account24s.id and 24_lichsu.id_taikhoan = ? ORDER BY 24_lichsu.update_at DESC",[$id_taikhoan]);




                    //noisinh
                    $id_tinh_noisinh = $ttcn1->id_tinh_noisinh;
                    $id_huyen_noisinh = $ttcn1->id_huyen_noisinh;
                    $id_xa_noisinh = $ttcn1->id_xa_noisinh;
                    $province_noisinh_tinh = DB::select("SELECT l_province.id as id, l_province.name_province as text FROM l_province");
                    $province_noisinh_huyen = DB::select("SELECT l_province2.id as id, l_province2.name_province2 as text FROM l_province2 WHERE id_province = ?",[$id_tinh_noisinh]);
                    $province_noisinh_xa = DB::select("SELECT l_province3.id AS id, l_province3.name_province3 AS text FROM l_province3 WHERE id_province2 = ?",[$id_huyen_noisinh]);
                    foreach ($province_noisinh_tinh as $key => $row) {
                       if($row->id == $id_tinh_noisinh){
                            $row->selected = "selected";
                       }else{
                            $row->selected = "";
                       }
                    }
                    if($id_tinh_noisinh == 0){
                        $province_noisinh_tinh0 = new Collection(
                            [
                                'id' => 0,
                                'text' =>"Chọn Tỉnh/TP",
                                'selected' => "selected"
                            ]
                        );
                        $province_noisinh_tinh[] = $province_noisinh_tinh0;
                    }
                    foreach ($province_noisinh_huyen as $key => $row) {
                        if($row->id == $id_huyen_noisinh){
                            $row->selected = "selected";
                        }else{
                            $row->selected = "";
                        }
                    }
                    if($id_huyen_noisinh == 0){
                        $province_noisinh_huyen0 = new Collection(
                            [
                                'id' => 0,
                                'text' =>"Chọn Quận/Huyện",
                                'selected' => "selected"
                            ]
                        );
                        $province_noisinh_huyen[] = $province_noisinh_huyen0;
                    }
                    foreach ($province_noisinh_xa as $key => $row) {
                        if($row->id == $id_xa_noisinh){
                            $row->selected = "selected";
                        }else{
                            $row->selected = "";
                        }
                    }
                    if($id_xa_noisinh == 0){
                        $province_noisinh_xa0 = new Collection(
                            [
                                'id' => 0,
                                'text' =>"Chọn Xã/Phường",
                                'selected' => "selected"
                            ]
                        );
                        $province_noisinh_xa[] = $province_noisinh_xa0;
                    }
                    //quequan
                    $id_tinh_quequan = $ttcn1->id_tinh_quequan;
                    $id_huyen_quequan = $ttcn1->id_huyen_quequan;
                    $id_xa_quequan = $ttcn1->id_xa_quequan;
                    $province_quequan_tinh = DB::select("SELECT l_province.id as id, l_province.name_province as text FROM l_province");
                    $province_quequan_huyen = DB::select("SELECT l_province2.id as id, l_province2.name_province2 as text FROM l_province2 WHERE id_province = ?",[$id_tinh_quequan]);
                    $province_quequan_xa = DB::select("SELECT l_province3.id AS id, l_province3.name_province3 AS text FROM l_province3 WHERE id_province2 = ?",[$id_huyen_quequan]);

                    foreach ($province_quequan_tinh as $key => $row) {
                        if($row->id == $id_tinh_quequan){
                            $row->selected = "selected";
                        }else{
                            $row->selected = "";
                        }
                    }
                    if($id_tinh_quequan == 0){
                        $province_quequan_tinh0 = new Collection(
                            [
                                'id' => 0,
                                'text' =>"Chọn Tỉnh/TP",
                                'selected' => "selected"
                            ]
                        );
                        $province_quequan_tinh[] = $province_quequan_tinh0;
                    }
                    foreach ($province_quequan_huyen as $key => $row) {
                        if($row->id == $id_huyen_quequan){
                            $row->selected = "selected";
                        }else{
                            $row->selected = "";
                        }
                    }
                    if($id_huyen_quequan == 0){
                        $province_quequan_huyen0 = new Collection(
                            [
                                'id' => 0,
                                'text' =>"Chọn Quận/Huyện",
                                'selected' => "selected"
                            ]
                        );
                        $province_quequan_huyen[] = $province_quequan_huyen0;
                    }
                    foreach ($province_quequan_xa as $key => $row) {
                        if($row->id == $id_xa_quequan){
                            $row->selected = "selected";
                        }else{
                            $row->selected = "";
                        }
                    }
                    if($id_xa_quequan == 0){
                        $province_quequan_xa0 = new Collection(
                            [
                                'id' => 0,
                                'text' =>"Chọn Xã/Phường",
                                'selected' => "selected"
                            ]
                        );
                        $province_quequan_xa[] = $province_quequan_xa0;
                    }

                    //thuongtru
                    $id_tinh_ttru = $ttcn1->id_tinh_ttru;
                    $id_huyen_ttru = $ttcn1->id_huyen_ttru;
                    $id_xa_ttru = $ttcn1->id_xa_ttru;
                    $province_ttru_tinh = DB::select("SELECT l_province.id as id, l_province.name_province as text FROM l_province");
                    $province_ttru_huyen = DB::select("SELECT l_province2.id as id, l_province2.name_province2 as text FROM l_province2 WHERE id_province = ?",[$id_tinh_ttru]);
                    $province_ttru_xa = DB::select("SELECT l_province3.id AS id, l_province3.name_province3 AS text FROM l_province3 WHERE id_province2 = ?",[$id_huyen_ttru]);
                    foreach ($province_ttru_tinh as $key => $row) {
                        if($row->id == $id_tinh_ttru){
                            $row->selected = "selected";
                        }else{
                            $row->selected  = "";
                        }
                    }
                    if($id_tinh_ttru == 0){
                        $province_ttru_tinh0 = new Collection(
                            [
                                'id' => 0,
                                'text' =>"Chọn Tỉnh/TP",
                                'selected' => "selected"
                            ]
                        );
                        $province_ttru_tinh[] = $province_ttru_tinh0;
                    }

                    foreach ($province_ttru_huyen as $key => $row) {
                        if($row->id == $id_huyen_ttru){
                            $row->selected = "selected";
                        }else{
                            $row->selected  = "";
                        }
                    }
                    if($id_huyen_ttru == 0){
                        $province_ttru_huyen0 = new Collection(
                            [
                                'id' => 0,
                                'text' =>"Chọn Quận/Huyện",
                                'selected' => "selected"
                            ]
                        );
                        $province_ttru_huyen[] = $province_ttru_huyen0;
                    }
                    foreach ($province_ttru_xa as $key => $row) {
                        if($row->id == $id_xa_ttru){
                            $row->selected  = "selected";
                        }else{
                            $row->selected  = "";
                        }
                    }
                    if($id_xa_ttru == 0){
                        $province_ttru_xa0 = new Collection(
                            [
                                'id' => 0,
                                'text' =>"Chọn Xã/Phường",
                                'selected' => "selected"
                            ]
                        );
                        $province_ttru_xa[] = $province_ttru_xa0;
                    }

                    //Tôn giáo
                    $tg =  $ttcn1->tongiao;
                    $tongiao = DB::select("SELECT l_religion.id as id, l_religion.tentongiao as text FROM l_religion");
                    foreach ($tongiao as $key => $row) {
                        if($row->id == $tg){
                            $row->selected = "selected";
                        }else{
                            $row->selected  = "";
                        }
                    }
                    if($tg == 0){
                        $tongiao0 = new Collection(
                            [
                                'id' => 0,
                                'text' =>"Chọn Tôn giáo",
                                'selected' => "selected"
                            ]
                        );
                        $tongiao[] = $tongiao0;
                    }
                    //Dân tộc
                    $dt = $ttcn1->id_dantoc;
                    $dantoc = DB::select("SELECT l_nation.id as id, name_nation as text FROM l_nation");
                    foreach ($dantoc as $key => $row) {
                        if($row->id == $dt){
                            $row->selected = "selected";
                        }else{
                            $row->selected  = "";
                        }
                    }
                    if($dt == 0){
                        $dantoc0 = new Collection(
                            [
                                'id' => 0,
                                'text' =>"Chọn Dân tộc",
                                'selected' => "selected"
                            ]
                        );
                        $dantoc[] = $dantoc0;
                    }
                    //Quôc tịch
                    $quoctich = DB::select("SELECT l_nationality.id as id, l_nationality.name_nationality as text FROM l_nationality");
                    $qt = $ttcn1->id_quoctich;
                    $quoctich = DB::select("SELECT l_nationality.id as id, name_nationality as text FROM l_nationality");
                    foreach ($quoctich as $key => $row) {
                        if($row->id == $qt){
                            $row->selected = "selected";
                        }else{
                            $row->selected  = "";
                        }
                    }
                    if($qt == 0){
                        $quoctich0 = new Collection(
                            [
                                'id' => 0,
                                'text' =>"Chọn Quốc tịch",
                                'selected' => "selected"
                            ]
                        );
                        $quoctich[] = $quoctich0;
                    }
                    //Nơi cấp CMND
                    $noicapcccd = DB::select("SELECT l_province.id as id, l_province.name_province as text FROM l_province");
                    $noicap = $ttcn1->noicapcccd;
                    foreach ($noicapcccd as $key => $row) {
                        if($row->id == $noicap){
                            $row->selected = "selected";
                        }else{
                            $row->selected  = "";
                        }
                    }
                    if($noicap == 0){
                        $noicapcccd0 = new Collection(
                            [
                                'id' => 0,
                                'text' =>"Chọn Nơi câp",
                                'selected' => "selected"
                            ]
                        );
                        $noicapcccd[] = $noicapcccd0;
                    }

                    //Return
                    $res = new Collection(
                        [
                            // 'noisinh' =>  $noisinh,
                            'ghichu' =>$ttcn1->ghichu,
                            'hoten' => $ttcn[0]->hoten,
                            'mssv' => $ttcn[0]->mssv,
                            'id_taikhoan' => $ttcn[0]->id_taikhoan,
                            'cccd' => $ttcn[0]->cccd,
                            'dienthoai' => $ttcn[0]->dienthoai,
                            'tongiao' => $tongiao,
                            'quoctich' => $quoctich,
                            'dantoc' => $dantoc,
                            'ngaysinh' => $ttcn[0]->ngaysinh,
                            'giaykhaisinh' =>$ttcn1->giaykhaisinh,
                            'noicapcccd' =>$noicapcccd,
                            'gioitinh' =>  $ttcn[0]->gioitinh,
                            'ngaycapcccd' =>$ttcn1->ngaycapcccd,
                            'ngayvaodang' =>$ttcn1->ngayvaodang,
                            'ngayvaodoan' =>$ttcn1->ngayvaodoan,
                            'noisinh_tinh' =>$province_noisinh_tinh,
                            'noisinh_huyen' =>$province_noisinh_huyen,
                            'noisinh_xa' =>$province_noisinh_xa,
                            'duoi_xa_noisinh' =>$ttcn1->giaykhaisinh,
                            'quequan_tinh' =>$province_quequan_tinh,
                            'quequan_huyen' =>$province_quequan_huyen,
                            'quequan_xa' =>$province_quequan_xa,
                            'duoi_xa_quequan' =>$ttcn1->duoi_xa_quequan,
                            'ttru_tinh' =>$province_ttru_tinh,
                            'ttru_huyen' =>$province_ttru_huyen,
                            'ttru_xa' =>$province_ttru_xa,
                            'duoi_xa_ttru' =>$ttcn1->duoi_xa_ttru,
                            'hotencha' =>$ttcn1->hotencha,
                            'hotenme' =>$ttcn1->hotenme,
                            'nguoidodau' =>$ttcn1->nguoidodau,
                            'dienthoaicha' =>$ttcn1->dienthoaicha,
                            'dienthoaime' =>$ttcn1->dienthoaime,
                            'dienthoainguoidodau' =>$ttcn1->dienthoainguoidodau,
                            'nghenghiepcha' =>$ttcn1->nghenghiepcha,
                            'nghenghiepme' =>$ttcn1->nghenghiepme,
                            'nghenghiepnguoidodau' =>$ttcn1->nghenghiepnguoidodau,
                            'khuyettat' =>$ttcn1->khuyettat,
                            'bhyt' =>$ttcn1->bhyt,
                            'diachi' =>$ttcn1->diachi,
                            'lichsu' => $lichsu,
                        ]
                    );
                    return array(
                        'data' => $res,
                        'trangthai' => 1
                    );
                }else{
                    return array(
                        'data' => '',
                        'trangthai' => 'up_2'
                    );
                }
                break;
            default:
                return array(
                    'data' => '',
                    'trangthai' => 'err_0'
                );
                break;
        }
    }catch(Exception $e){
        return array(
            'data' => '',
            'trangthai' => 'err_0'
        );
    }
}

//danhmuc_hoso function
function danhmuc_hoso(Request $request)
{
    $cccd = $request->input('cccd');
    $mssv = $request->input('mssv');
    $id_taikhoan = $this->timid_taikhoan($mssv,$cccd)['id_taikhoan'];
    $danhmuc = DB::select("SELECT danhmuc_hoso_id, id_hoso, danhmuc_hoso_ten, if(nhs.id_hoso is null,1,0) as id_check
    FROM `24_danhmuc_hoso` AS dmhs
    LEFT JOIN `24_nhanhoso` AS nhs ON dmhs.danhmuc_hoso_id = nhs.id_hoso
    AND nhs.id_taikhoan = $id_taikhoan");
    return array(
        'danhmuc' => $danhmuc,
        'id_taikhoan' =>  $id_taikhoan
    );
}
function nhanhoso(Request $request) //Nhaanj hoo so
{
    $id_taikhoan = $request->input('id_taikhoan');
    $danhmuc_hoso_id = $request->input('danhmuc_hoso_id');
    $id_check = $request->input('id_check');
    $danhmuc_hoso_ten = DB::table('24_danhmuc_hoso')->select('danhmuc_hoso_ten')->where('danhmuc_hoso_id', $danhmuc_hoso_id)->first()->danhmuc_hoso_ten;
    DB::beginTransaction();
    try{
        if($id_check == 1){
            $nhanhoso = DB::table('24_nhanhoso')
            ->insert([
                'id_hoso' => $danhmuc_hoso_id,
                'id_taikhoan' => $id_taikhoan,
            ]);
            $noidung = "Thêm ". $danhmuc_hoso_ten;
        }else{
            $nhanhoso = DB::table('24_nhanhoso')
            ->where('id_hoso', $danhmuc_hoso_id)
            ->where('id_taikhoan', $id_taikhoan)
            ->delete();
            $noidung = "Xóa ". $danhmuc_hoso_ten;
        }
        $id_admin = Auth::guard('loginadmin')->user()->id;
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        DB::table('24_lichsu')
        ->insert([
            'id_taikhoan' => $id_taikhoan,
            'noidung'   => $noidung,
            'hienthi'   => 1,
            'id_nhansu' => $id_admin,
            'thietbi'   => $user_agent,
            'ip'        => request()->ip()
        ]);

        DB::commit();
        if($nhanhoso > 0 ){
            return 'upd_1';
        }else{
            return 'upd_2';
        }
    }catch(Exception $e){
        DB::rollBack();
        return 'err_0';
    }
}
//Cap nhat thong tin ca nhan
function capnhatthongtincannhan(Request $request)
{
    $id_taikhoan = $request->input('id_taikhoan');
    $val = $request->input('val');
    $id = $request->input('id');
    $table = $request->input('table');
        // Tạo một mảng giả lập để chứa dữ liệu xác thực
    switch($id){
        case 'dienthoai':
            $validator = Validator::make($request->all(),
            [
                'val'                            => 'alpha_dash|min:10|max:10|regex:/(0)[0-9]/|not_regex:/[a-z]/',
            ],
            [
                'val.regex'               =>'Điện thoại gồm 10 chữ số và bắt đầu là 0.',
                'val.max'                 =>'Điện thoại gồm 10 chữ số',
                'val.min'                 =>'Điện thoại gồm 10 chữ số',
                'val.not_regex'           =>'Điện thoại chỉ bao gồm chữ số',
                'val.alpha_dash'          =>'Điện thoại chỉ bao gồm chữ số',
            ]
            );
        case 'mssv':
            $validator = Validator::make($request->all(),
            [
                'val'                            => 'min:7',
            ],
            [
                'val.min'                 =>'Mã số sinh viên tối đa 7 ký tự'
            ]
            );
        break;

        case 'giaykhaisinh':
            $validator = Validator::make($request->all(),
            [
                'val'                       => 'not_regex:/[@<>&!~^$*=]/',
            ],
            [
                'val.not_regex'             => 'Địa chỉ không được rỗng hoặc có ký tự đặc biệt',
            ]
            );
        break;

        // case 'duoi_xa_ttru':
        //     $validator = Validator::make($request->all(),
        //     [
        //         'val'                       => 'not_regex:/[@<>&!~^$*=]/',
        //     ],
        //     [
        //         'val.not_regex'             => 'Địa chỉ không được rỗng hoặc có ký tự đặc biệt',
        //     ]
        //     );
        // break;

        // case 'duoi_xa_quequan':
        //     $validator = Validator::make($request->all(),
        //     [
        //         'val'                       => 'not_regex:/[@<>&!~^$*=]/',
        //     ],
        //     [
        //         'val.not_regex'             => 'Địa chỉ không được rỗng hoặc có ký tự đặc biệt',
        //     ]
        //     );
        // break;
        case 'hotencha':
            $validator = Validator::make($request->all(),
            [
                'val'                       => 'not_regex:/[@<>&!~^$*=]/',
            ],
            [
                'val.not_regex'             => 'Họ tên không được rỗng hoặc có ký tự đặc biệt',
            ]
            );
        break;
        case 'hotenme':
            $validator = Validator::make($request->all(),
            [
                'val'                       => 'not_regex:/[@<>&!~^$*=]/',
            ],
            [
                'val.not_regex'             => 'Họ tên không được rỗng hoặc có ký tự đặc biệt',
            ]
            );
        break;
        case 'nguoidodau':
            $validator = Validator::make($request->all(),
            [
                'val'                       => 'not_regex:/[@<>&!~^$*=]/',
            ],
            [
                'val.not_regex'             => 'Họ tên không được rỗng hoặc có ký tự đặc biệt',
            ]
            );
        break;
        case 'nghenghiepcha':
            $validator = Validator::make($request->all(),
            [
                'val'                       => 'not_regex:/[@<>&!~^$*=]/',
            ],
            [
                'val.not_regex'             => 'Nghề nghiệp không được rỗng hoặc có ký tự đặc biệt',
            ]
            );
        break;
        case 'nghenghiepme':
            $validator = Validator::make($request->all(),
            [
                'val'                       => 'not_regex:/[@<>&!~^$*=]/',
            ],
            [
                'val.not_regex'             => 'Nghề nghiệp không được rỗng hoặc có ký tự đặc biệt',
            ]
            );
        break;
        case 'nghenghiepnguoidodau':
            $validator = Validator::make($request->all(),
            [
                'val'                       => 'not_regex:/[@<>&!~^$*=]/',
            ],
            [
                'val.not_regex'             => 'Nghề nghiệp không được rỗng hoặc có ký tự đặt biệt',
            ]
            );
        break;
        case 'dienthoaicha':
            $validator = Validator::make($request->all(),
            [
                'val'                            => 'alpha_dash|min:10|max:10|regex:/(0)[0-9]/|not_regex:/[a-z]/',
            ],
            [
                'val.regex'               =>'Điện thoại gồm 10 chữ số và bắt đầu là 0.',
                'val.max'                 =>'Điện thoại gồm 10 chữ số',
                'val.min'                 =>'Điện thoại gồm 10 chữ số',
                'val.not_regex'           =>'Điện thoại chỉ bao gồm chữ số',
                'val.alpha_dash'          =>'Điện thoại chỉ bao gồm chữ số',
            ]
            );
        break;
        case 'dienthoaime':
            $validator = Validator::make($request->all(),
            [
                'val'                            => 'alpha_dash|min:10|max:10|regex:/(0)[0-9]/|not_regex:/[a-z]/',
            ],
            [
                'val.regex'               =>'Điện thoại gồm 10 chữ số và bắt đầu là 0.',
                'val.max'                 =>'Điện thoại gồm 10 chữ số',
                'val.min'                 =>'Điện thoại gồm 10 chữ số',
                'val.not_regex'           =>'Điện thoại chỉ bao gồm chữ số',
                'val.alpha_dash'          =>'Điện thoại chỉ bao gồm chữ số',
            ]
            );
        break;
        case 'dienthoainguoidodau':
            $validator = Validator::make($request->all(),
            [
                'val'                            => 'alpha_dash|min:10|max:10|regex:/(0)[0-9]/|not_regex:/[a-z]/',
            ],
            [
                'val.regex'               =>'Điện thoại gồm 10 chữ số và bắt đầu là 0.',
                'val.max'                 =>'Điện thoại gồm 10 chữ số',
                'val.min'                 =>'Điện thoại gồm 10 chữ số',
                'val.not_regex'           =>'Điện thoại chỉ bao gồm chữ số',
                'val.alpha_dash'          =>'Điện thoại chỉ bao gồm chữ số',
            ]
            );
        break;
        case 'bhyt':
            $validator = Validator::make($request->all(),
            [
                'val'                     => 'nullable|alpha_dash|min:10|max:10|regex:/[0-9]/|not_regex:/[a-z]/',
            ],
            [
                'val.regex'               =>'Bảo hiểm y tế gồm 10 chữ số.',
                'val.max'                 =>'Bảo hiểm y tế gồm 10 chữ số.',
                'val.min'                 =>'Bảo hiểm y tế gồm 10 chữ số.',
                'val.not_regex'           =>'Bảo hiểm y tế chỉ bao gồm chữ số',
                'val.alpha_dash'          =>'Bảo hiểm y tế chỉ bao gồm chữ số',
            ]
            );
        break;
        case 'diachi':
            $validator = Validator::make($request->all(),
            [
                'val'                       => 'not_regex:/[@<>&!~^$*=]/',
            ],
            [
                'val.not_regex'             => 'Địa chỉ không được rỗng hoặc có ký tự đặc biệt',
            ]
            );
        break;
        //theo input date
        case 'ngaysinh':
            $validator = Validator::make($request->all(),
            [
                'val' => 'required|date|before_or_equal:today',
            ],
            [
                'val.required' => 'Ngày sinh không được rỗng.',
                'val.date' => 'Ngày sinh phải là một ngày hợp lệ.',
                'val.before_or_equal' => 'Ngày sinh không được lớn hơn ngày hiện tại.',

            ]
            );
        break;
        case 'ngaycapcccd':
            $validator = Validator::make($request->all(),
            [
                'val' => 'required|date|before_or_equal:today',
            ],
            [
                'val.required' => 'Ngày cấp CCCD không được rỗng.',
                'val.date' => 'Ngày cấp CCCD phải là một ngày hợp lệ.',
                'val.before_or_equal' => 'Ngày cấp CCCD không được lớn hơn ngày hiện tại.',

            ]
            );
        break;
        case 'ngayvaodoan':
            $validator = Validator::make($request->all(),
            [
                'val' => 'required|date|before_or_equal:today',
            ],
            [
                'val.required' => 'Ngày vào đoàn không được rỗng.',
                'val.date' => 'Ngày vào đoàn phải là một ngày hợp lệ.',
                'val.before_or_equal' => 'Ngày vào đoàn không được lớn hơn ngày hiện tại.',

            ]
            );
        break;
        case 'ngayvaodang':
            $validator = Validator::make($request->all(),
            [
                'val' => 'required|date|before_or_equal:today',
            ],
            [
                'val.required' => 'Ngày vào Đảng không được rỗng.',
                'val.date' => 'Ngày vào Đảng phải là một ngày hợp lệ.',
                'val.before_or_equal' => 'Ngày vào Đảng không được lớn hơn ngày hiện tại.',

            ]
            );
        break;
        //theo selectbox
        case 'id_dantoc':
            $validator = Validator::make($request->all(),
            [
                'val' => 'integer|min:1',
            ],
            [
                'val.min'          =>'Chọn Dân tộc',
            ]
            );
        break;
        case 'id_quoctich':
            $validator = Validator::make($request->all(),
            [
                'val' => 'integer|min:1',
            ],
            [
                'val.min'          =>'Chọn Quốc tịch',
            ]
            );
        break;
        case 'id_tongiao':
            $validator = Validator::make($request->all(),
            [
                'val' => 'integer|min:1',
            ],
            [
                'val.min'          =>'Chọn Tôn giáo',
            ]
            );
        break;
        case 'khuyettat':
            $validator = Validator::make($request->all(),
            [
                'val' => 'integer|min:0',
            ],
            [
                'val.min'          =>'Chọn Khuyết tật',
            ]
            );
        break;
        case 'noicapcccd':
            $validator = Validator::make($request->all(),
            [
                'val' => 'integer|min:1',
            ],
            [
                'val.min'          =>'Chọn Nơi cấp',
            ]
            );
        break;
        case 'gioitinh':
            $validator = Validator::make($request->all(),
            [
                'val' => 'integer|min:0',
            ],
            [
                'val.min'          =>'Chọn giơi tinh',
            ]
            );
        break;

        default:
            $validator = Validator::make(
            $request->all(),
            [
                'val' => 'nullable',
            ],
            [

            ]
        );

        break;


    }

    if ($validator->fails()) {
        $validate = array(
            'data' => response()->json($validator->errors()),
            'maloi' => "vali_1",
        );
        return $validate;
    }else{
        DB::beginTransaction();
        try{
            // if($id == 'bhyt' || $id == 'mssv'){
            //     $update = DB::table($table)
            //     // ->where('id_taikhoan',$id_taikhoan)
            //     ->updateOrInsert(
            //         [
            //             'id_taikhoan' =>$id_taikhoan
            //         ],
            //         [
            //             $id => $val
            //         ]
            //     );
            // }else{
                $update = DB::table($table)
                ->updateOrInsert(
                            [
                                'id_taikhoan' =>$id_taikhoan
                            ],
                            [
                                $id => $val
                            ]
                        );
            // }

            switch($id){
                // case 'hoten':
                //     $noidung = "Cập nhật họ tên ".$val;
                // break;
                case 'dienthoai':
                    $noidung = "Cập nhật số điện thoại ".$val;
                break;
                case 'mssv':
                    $noidung = "Cập nhật MSSV ".$val;
                break;
                case 'giaykhaisinh':
                    $noidung = "Cập nhật địa chỉ giấy khai sinh ".$val;
                break;
                case 'duoi_xa_ttru':
                    $noidung = "Cập nhật địa chỉ dưới xã thường trú ".$val;
                break;
                case 'duoi_xa_quequan':
                    $noidung = "Cập nhật địa chỉ dưới xã quê quán ".$val;
                break;
                case 'hotencha':
                    $noidung = "Cập nhật tên cha ".$val;
                break;
                case 'hotenme':
                    $noidung = "Cập nhật tên mẹ ".$val;
                break;
                case 'nguoidodau':
                    $noidung = "Cập nhật tên người đỡ đầu ".$val;
                break;

                case 'nghenghiepcha':
                    $noidung = "Cập nhật nghề nghiệp của cha ".$val;
                break;

                case 'nghenghiepme':
                    $noidung = "Cập nhật nghề nghiệp của mẹ ".$val;
                break;

                case 'nghenghiepnguoidodau':
                    $noidung = "Cập nhật nghề nghiệp của người đỡ đầu ".$val;
                break;
                case 'dienthoaicha':
                    $noidung = "Cập nhật điện thoại cha ".$val;
                break;
                case 'dienthoaime':
                    $noidung = "Cập nhật điện thoại mẹ ".$val;
                break;
                case 'dienthoainguoidodau':
                    $noidung = "Cập nhật điện thoại người đỡ đầu ".$val;
                break;
                case 'bhyt':
                    $noidung = "Cập nhật mã bảo hiểm y tế ".$val;
                break;
                case 'diachilienlac':
                    $noidung = "Cập nhật địa chỉ liên lạc ".$val;
                break;
                case 'ngaysinh':
                    $noidung = "Cập nhật ngày sinh ".$val;
                break;
                case 'ngaycapcccd':
                    $noidung = "Cập nhật ngày cấp CCCD ".$val;
                break;
                case 'ngayvaodoan':
                    $noidung = "Cập nhật ngày vào đoàn ".$val;
                break;
                case 'ngayvaodang':
                    $noidung = "Cập nhật ngày vào Đảng ".$val;
                break;
                case 'id_dantoc':
                    $dantoc = DB::table('l_nation')
                    ->select('name_nation')
                    ->where('id', $val)
                    ->first();
                    $val = $dantoc->name_nation;
                    $noidung = "Cập nhật dân tộc ".$val;
                break;
                case 'id_quoctich':
                    $quoctich = DB::table('l_nationality')
                    ->select('name_nationality')
                    ->where('id', $val)
                    ->first();
                    $val = $quoctich->name_nationality;
                    $noidung = "Cập nhật quốc tịch ".$val;
                break;
                case 'id_tongiao':
                    $tongiao = DB::table('l_religion')
                    ->select('tentongiao')
                    ->where('id', $val)
                    ->first();
                    $val = $tongiao->tentongiao;
                    $noidung = "Cập nhật tôn giáo ".$val;
                break;
                case 'khuyettat':
                    $khuyettat = DB::table('l_khuyettat')
                    ->select('name_khuyettat')
                    ->where('id', $val)
                    ->first();
                    $val = $khuyettat->name_khuyettat;
                    $noidung = "Cập nhật loại khuyết tật ".$val;
                break;
                case 'noicapcccd':
                    $noicapcccd = DB::table('l_province')
                    ->select('name_province')
                    ->where('id', $val)
                    ->first();
                    $val = $noicapcccd->name_province;
                    $noidung = "Cập nhật nơi cấp CCCD ".$val;
                break;
                case 'gioitinh':
                    if($val == 1){
                        $val = 'Nữ';
                    }else{
                        $val = 'Nam';
                    }
                    $noidung = "Cập nhật giới tính ".$val;
                break;

                default:
                    $noidung = $val;
                break;

            }
            $id_admin = Auth::guard('loginadmin')->user()->id;
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            DB::table('24_lichsu')
            ->insert([
                'id_taikhoan' => $id_taikhoan,
                'noidung'   => $noidung,
                'hienthi'   => 1,
                'id_nhansu' => $id_admin,
                'thietbi'   => $user_agent,
                'ip'        => request()->ip()
            ]);
            DB::commit();
            if($update == 1 ){
                return 'upd_1';
            }else{
                return 'upd_0';
            }
        }catch(Exception $e){
            DB::rollBack();
            return 'err_0';
        }
    }
}


function capnhatdiachi_tinh(Request $request)
{
    $id_cap2 = $request->input('id_cap2');
    $id_cap3 = $request->input('id_cap3');
    $id_taikhoan = $request->input('id_taikhoan');
    $id_thongtin = $request->input('id_thongtin');
    $id_data = $request->input('id_data');
    $val = $request->input('val');
    $validator = Validator::make($request->all(),
        [
            'val'           => 'integer|min:1',
        ],
        [
            'val.min'       =>'Chọn Tỉnh/Thành Phố',
        ]
    );

    if ($validator->fails()) {
        $validate = array(
            'data' => response()->json($validator->errors()),
            'maloi' => "vali_1",
        );
        return $validate;
    }else{
        DB::beginTransaction();
        try{
            $update =  DB::table('24_hosonhaphoc')
            ->updateOrInsert(
                ['id_taikhoan' =>$id_taikhoan ],
                [
                    $id_data => $val,
                ]
            );
            $id_admin = Auth::guard('loginadmin')->user()->id;
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            $noidung = "Cập nhật địa chỉ ".$id_thongtin." tại ";
            $tinh = DB::table('l_province')->where('id',$val)->first();
            $noidung .= $tinh->name_province;
             DB::table('24_lichsu')
            ->insert([
                'id_taikhoan' => $id_taikhoan,
                'noidung'   => $noidung,
                'hienthi'   => 1,
                'id_nhansu' => $id_admin,
                'thietbi'   => $user_agent,
                'ip'        => request()->ip()
            ]);
            DB::table('24_hosonhaphoc')
            ->where('id_taikhoan',$id_taikhoan)
            ->update([
                $id_cap2 => 0,
                $id_cap3 => 0,
            ]);
            DB::commit();
            if($update == 1 ){
                return 'upd_1';
            }else{
                return 'upd_0';
            }
        }catch(Exception $e){
            DB::rollBack();
            return 'err_0';
        }
    }
}
function capnhatdiachi_huyen(Request $request)
{
    $id_cap3 = $request->input('id_cap3');
    $id_taikhoan = $request->input('id_taikhoan');
    $id_thongtin = $request->input('id_thongtin');
    $id_data = $request->input('id_data');
    $val = $request->input('val');
    $validator = Validator::make($request->all(),
        [
            'val'           => 'integer|min:1',
        ],
        [
            'val.min'       =>'Chọn Quận/Huyên',
        ]
    );

    if ($validator->fails()) {
        $validate = array(
            'data' => response()->json($validator->errors()),
            'maloi' => "vali_1",
        );
        return $validate;
    }else{
        DB::beginTransaction();
        try{
            $update =  DB::table('24_hosonhaphoc')
            ->updateOrInsert(
                ['id_taikhoan' =>$id_taikhoan ],
                [
                    $id_data => $val,
                ]
            );

            $id_admin = Auth::guard('loginadmin')->user()->id;
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            $noidung = "Cập nhật địa chỉ ".$id_thongtin." tại ";
            $huyen = DB::table('l_province2')->where('id',$val)->first();
            $noidung .= $huyen->name_province2;
            DB::table('24_lichsu')
            ->insert([
                'id_taikhoan' => $id_taikhoan,
                'noidung'   => $noidung,
                'hienthi'   => 1,
                'id_nhansu' => $id_admin,
                'thietbi'   => $user_agent,
                'ip'        => request()->ip()
            ]);
            DB::table('24_hosonhaphoc')
            ->where('id_taikhoan',$id_taikhoan)
            ->update([
                $id_cap3 => 0,
            ]);
            DB::commit();
            if($update == 1 ){
                return 'upd_1';
            }else{
                return 'upd_0';
            }
        }catch(Exception $e){
            DB::rollBack();
            return 'err_0';
        }
    }
}
function capnhatdiachi_xa(Request $request)
{
    $id_taikhoan = $request->input('id_taikhoan');
    $id_thongtin = $request->input('id_thongtin');
    $id_data = $request->input('id_data');
    $val = $request->input('val');
    $validator = Validator::make($request->all(),
        [
            'val'           => 'integer|min:1',
        ],
        [
            'val.min'       =>'Chọn Xã/Phường',
        ]
    );

    if ($validator->fails()) {
        $validate = array(
            'data' => response()->json($validator->errors()),
            'maloi' => "vali_1",
        );
        return $validate;
    }else{
        DB::beginTransaction();
        try{
            $update =  DB::table('24_hosonhaphoc')
            ->updateOrInsert(
                ['id_taikhoan' =>$id_taikhoan ],
                [
                    $id_data => $val,
                ]
            );

            $id_admin = Auth::guard('loginadmin')->user()->id;
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            $noidung = "Cập nhật địa chỉ ".$id_thongtin." tại ";
            $xa = DB::table('l_province3')->where('id',$val)->first();
            $noidung .= $xa->name_province3;
             DB::table('24_lichsu')
            ->insert([
                'id_taikhoan' => $id_taikhoan,
                'noidung'   => $noidung,
                'hienthi'   => 1,
                'id_nhansu' => $id_admin,
                'thietbi'   => $user_agent,
                'ip'        => request()->ip()
            ]);
            DB::commit();
            if($update == 1 ){
                return 'upd_1';
            }else{
                return 'upd_0';
            }
        }catch(Exception $e){
            DB::rollBack();
            return 'err_0';
        }
    }
}


public function loaddottuyensinh()
{
    $batch = DB::select("SELECT id, tendot as text, if(id is null, '', 'selected') as selected FROM 24_dottuyensinh");
    if($batch){
        $batch0 = new Collection([
            'id' => 0,
            'text' => 'Chọn đợt tuyển sinh',
            'selected' =>'selected'
        ]);
    }else{
        $batch0 = new Collection([
            'id' => 0,
            'text' => 'Chọn đợt tuyển sinh',
            'selected' =>''
        ]);
    }
    $batch[] = $batch0;
    $res = new Collection([
    'batch' =>$batch
    ]);
    return $res;
}

public function nhapmssv(Request $request)
{
    $mssv = $request->input('mssv');
    $id_taikhoan = $request->input('id_taikhoan');
    $validator = Validator::make($request->all(),
            [
                'mssv'                            => 'required|min:7|max:11|',
            ],
            [
                'mssv.required'            =>'Mã số sinh viên không được bỏ trống',
                'mssv.max'                 =>'Mã số sinh viên có tối đa 11 ký tự',
                'mssv.min'                 =>'Mã số sinh viên có tối thiểu 7 ký tự',
            ]
            );
    if ($validator->fails()) {
        $validate = array(
            'data' => response()->json($validator->errors()),
            'maloi' => "vali_1",
        );
        return $validate;
    }else{
        DB::beginTransaction();
        try{
        // Check if MSSV exists
            $check = DB::table('24_thongtincanhan')->where('mssv', $mssv)->exists();
             if (!$check) {
            // MSSV does not exist, insert into database
                DB::update('UPDATE 24_thongtincanhan SET mssv =? WHERE id_taikhoan = ? ', [$mssv, $id_taikhoan]);
                return response()->json(['status' => 'success']);
            } else {
            // MSSV exists, update the record
                $affected = DB::update('UPDATE 24_thongtincanhan SET mssv = ? WHERE id_taikhoan = ?', [$mssv, $id_taikhoan]);

                if ($affected) {
                    return response()->json(['status' => 'updated']);
                } else {
                    return response()->json(['status' => 'fail']);
                }
            }
        }
        catch(Exception $e){
            DB::rollBack();
            return response()->json(['error' => 'up_2']);
        }
    }
}

    //Import MSSV từ EDU
function importmssv()
{
    // $url = URL::current();
    // $quyen = $this->kiemtraquyen_url($url);
    // if ($quyen == 1) {
        return view('user_24.admin24.manage.quanlynhaphoc.importmssv',
            [
                'menu' =>   $this->sidebar(),
            ]
        );
    // } else {
    //     return view('user_24.admin24.include.404');
    // }

}

public function submit_importmssv(Request $request){ //Name, Email, Mật khẩu, google_id
    //Import những thí sinh chưa có thông tin cá nhân (table 24_thongtincanhan) trên hệ thông (Căn cứ vào CMND)
    try{
        $namts = $this->namtuyensinh();
        $dotts = $this->motdottuyensinh();
        Excel::import(new Admin24_ImportMSSV($namts,$dotts), $request->file('importmssv'));
        return 'imp_1';
    }catch(Exception $e){
        return 'imp_0';
    }
}

function importxacnhanbo()
{
    // $url = URL::current();
    // $quyen = $this->kiemtraquyen_url($url);
    // if ($quyen == 1) {
        return view('user_24.admin24.manage.quanlynhaphoc.importxacnhanbo',
            [
                'menu' =>   $this->sidebar(),
            ]
        );
    // } else {
    //     return view('user_24.admin24.include.404');
    // }

}

public function submit_importxacnhanbo(Request $request){ //Name, Email, Mật khẩu, google_id
    //Import những thí sinh chưa có thông tin cá nhân (table 24_thongtincanhan) trên hệ thông (Căn cứ vào CMND)
    try{
        $namts = $this->namtuyensinh();
        $dotts = $this->motdottuyensinh();
        Excel::import(new Admin24_ImportXacnhanBo($namts,$dotts), $request->file('importxacnhanbo'));
        return 'imp_1';
    }catch(Exception $e){
        return 'imp_0';
    }
}


    //Noi sinh
// Hàm load tỉnh
public function loadtinh()
{
    $tinh =  DB::select('SELECT l_province.id, l_province.name_province as text FROM `l_province`');
    return $tinh;

}
// ham load huyen
public function loadhuyen($tinh1)
{
    $huyen_noisinh = DB::table('l_province2')
    ->select('id','name_province2 as text')
    ->where('id_province',$tinh1)
    ->get();
        // Thêm giá trị mặc định vào đầu danh sách
    $defaultHuyen = collect([['id' => 0, 'text' => 'Chọn huyện']]);
    $huyen_noisinh = $defaultHuyen->merge($huyen_noisinh);
    return $huyen_noisinh;
}
// ham load xa
public function loadxa($huyen1)
{
    $xa = DB::table('l_province3')
    ->select('id','name_province3 as text')
    ->where('id_province2',$huyen1)
    ->get();
    $defaultXa = collect([['id' => 0, 'text' => 'Chọn xã']]);
    $xa = $defaultXa->merge($xa);
    return $xa;
}

    //thuong tru
// Hàm load tỉnh
public function loadtinh2()
{
    $tinh =  DB::select('SELECT l_province.id, l_province.name_province as text FROM `l_province`');
    return $tinh;
}

    // ham load huyen
public function loadhuyen2($tinh1)
{
    $huyen = DB::table('l_province2')
    ->select('id','name_province2 as text')
    ->where('id_province',$tinh1)
    ->get();
    $defaultHuyen = collect([['id' => 0, 'text' => 'Chọn huyện']]);
    $huyen = $defaultHuyen->merge($huyen);
    return $huyen;
}

    // ham load xa
public function loadxa2($huyen1)
{
    $xa = DB::table('l_province3')
    ->select('id','name_province3 as text')
    ->where('id_province2',$huyen1)
    ->get();
    $defaultXa = collect([['id' => 0, 'text' => 'Chọn xã']]);
    $xa = $defaultXa->merge($xa);
    return $xa;
}

    //que quan
    // Hàm load tỉnh
public function loadtinh3()
{
    $tinh =  DB::select('SELECT l_province.id, l_province.name_province as text FROM `l_province`');
    return $tinh;
}


    // ham load huyen
public function loadhuyen3($tinh1)
{
    $huyen = DB::table('l_province2')
    ->select('id','name_province2 as text')
    ->where('id_province',$tinh1)
    ->get();
    $defaultHuyen = collect([['id' => 0, 'text' => 'Chọn huyện']]);
    $huyen = $defaultHuyen->merge($huyen);
    return $huyen;
}

    // ham load xa
public function loadxa3($huyen1)
{
    $xa = DB::table('l_province3')
    ->select('id','name_province3 as text')
    ->where('id_province2',$huyen1)
    ->get();
    $defaultXa = collect([['id' => 0, 'text' => 'Chọn xã']]);
    $xa = $defaultXa->merge($xa);
    return $xa;
}



function luuthuongtru(Request $request)
{
    $val_tinh = $request->input('val_tinh');
    $val_huyen = $request->input('val_huyen');
    $val_xa = $request->input('val_xa');
    $id_taikhoan = $request->input('id_taikhoan');
    $table = $request->input('table');

    $validator = Validator::make($request->all(),
    [
        'id_tinh'                            => 'integer|min:1',
        'id_huyen'                            => 'integer|min:1',
        'id_xa'                            => 'integer|min:1',
    ],
    [
        'id_tinh.min'          =>'Chọn Tỉnh/Thành Phố',
        'id_huyen.min'          =>'Chọn Quận/Huyện',
        'id_xa.min'          =>'Chọn Xã/Phường',

    ]
    );

    if ($validator->fails()) {
        $validate = array(
            'data' => response()->json($validator->errors()),
            'maloi' => "vali_1",
        );
        return $validate;
    }else{
        DB::beginTransaction();
        try{
            $update = DB::table($table)
            ->where('id_taikhoan',$id_taikhoan)
            ->update(
                [
                    'id_tinh_ttru' => $val_tinh,
                    'id_huyen_ttru' => $val_huyen,
                    'id_xa_ttru' => $val_xa

                ]
            );
            $id_admin = Auth::guard('loginbygoogles')->id();
            $user_agent = $_SERVER['HTTP_USER_AGENT'];

            DB::table('24_lichsu')
            ->insert([
                'id_taikhoan' => $id_taikhoan,
                'noidung'   => "Cập nhật thường trú tại Tỉnh/Thành phố ".$val_tinh." Huyện/Quận ".$val_huyen. " Xã/Phường ".$val_xa,
                'hienthi'   => 1,
                'id_nhansu' => $id_admin,
                'thietbi'   => $user_agent,
                'ip'        => request()->ip()
            ]);
            DB::commit();
            if($update == 1 ){
                return 'up_1';
            }else{
                return 'up_0';
            }
        }catch(Exception $e){
            DB::rollBack();
            return 'up_2';
        }
    }
}
function luuquequan(Request $request)
{
    $val_tinh = $request->input('val_tinh');
    $val_huyen = $request->input('val_huyen');
    $val_xa = $request->input('val_xa');
    $id_taikhoan = $request->input('id_taikhoan');
    $table = $request->input('table');

    $validator = Validator::make($request->all(),
    [
        'id_tinh'                            => 'integer|min:1',
        'id_huyen'                            => 'integer|min:1',
        'id_xa'                            => 'integer|min:1',
    ],
    [
        'id_tinh.min'          =>'Chọn Tỉnh/Thành Phố',
        'id_huyen.min'          =>'Chọn Quận/Huyện',
        'id_xa.min'          =>'Chọn Xã/Phường',

    ]
    );
    if ($validator->fails()) {
        $validate = array(
            'data' => response()->json($validator->errors()),
            'maloi' => "vali_1",
        );
        return $validate;
    }else{
        DB::beginTransaction();
        try{
            $update = DB::table($table)
            ->where('id_taikhoan',$id_taikhoan)
            ->update(
                [
                    'id_tinh_quequan' => $val_tinh,
                    'id_huyen_quequan' => $val_huyen,
                    'id_xa_quequan' => $val_xa

                ]
            );
            $id_admin = Auth::guard('loginbygoogles')->id();
            $user_agent = $_SERVER['HTTP_USER_AGENT'];

            DB::table('24_lichsu')
            ->insert([
                'id_taikhoan' => $id_taikhoan,
                'noidung'   => "Cập nhật quê quán tại Tỉnh/Thành phố ".$val_tinh." Huyện/Quận ".$val_huyen. " Xã/Phường ".$val_xa,
                'hienthi'   => 1,
                'id_nhansu' => $id_admin,
                'thietbi'   => $user_agent,
                'ip'        => request()->ip()
            ]);
            DB::commit();
            if($update == 1 ){
                return 'up_1';
            }else{
                return 'up_0';
            }
        }catch(Exception $e){
            DB::rollBack();
            return 'up_2';
        }
    }
}



//danhmuc_hoso function
function loaddanhmuc()
{
    $danhmuc = DB::select("SELECT danhmuc_hoso_id, danhmuc_hoso_ten
                            FROM 24_danhmuc_hoso");
    return $danhmuc;
}
//slides function
function slider(Request $request)
{
    $id_taikhoan = $request->input('id_taikhoan');
    $slide = DB::table('24_image')
            ->select('path_img','id')
            ->where('id_taikhoan', $id_taikhoan)
            ->get();

    return $slide;

}

function xoahinhhhsnh(Request $request){
    try{
        $id_taikhoan = $request->input('id_taikhoan');
        $id = $request->input('id');
        $del = DB::table('24_image')
            ->where('id',$id)
            ->where('id_taikhoan',$id_taikhoan)
            ->delete();
        if($del == 1){
            return 'del_1';
        }else{
            return 'del_0';
        }
    }catch(Exception $e){
        return '-100';
    }
}







    // load loai giay
    public function xuatfile_index()
    {

        $res =  DB::table('24_thongtincanhan')
        ->select('hoten as text','id_taikhoan as id','gioitinh as check')
        ->get();
        $sig =  DB::table('l_file_qlsv_nvqs_sig')
        ->select('id as id','name as name')
        ->get();

        return view('user_24.admin24.manage.quanlynhaphoc.xuatfile',
        [
            'menu' =>  $this->sidebar(),
            'res' => $res,
            'sig' => $sig,
        ]
        );
    }
    public function loadmajor()
    {
        $major = DB::select("SELECT id as id, name_major as text, '' as selected FROM l_major
        ");
        if($major){
           $major0 = new Collection([
               'id' => 0,
               'text' => 'Chọn ngành',
               'selected' =>'selected'
           ]);

        }else{
           $major0 = new Collection([
               'id' => 0,
               'text' => 'Chọn ngành',
               'selected' =>''
           ]);
        }

        $major[] = $major0;
        $res = new Collection([
           'major' =>$major
        ]);

        return $res;

    }
    public function loadloaigiay()
    {
        $res = DB::select("SELECT danhmuc_gxn_id , danhmuc_gxn_tenloai FROM 24_danhmuc_gxn");
        return $res;

    }
    public function loadthongtin($major,$cccd,$mssv)
    {
        // Khởi tạo điều kiện truy vấn
        $major == 0 ? $major_fix = 'lop.idnganh IS NOT NULL' : $major_fix = 'lop.idnganh ='.$major;
        $cccd == 0 ? $cccd_fix = 'cccd IS NOT NULL' : $cccd_fix = 'cccd = "'.$cccd.'"';
        $mssv == 0 ? $mssv_fix = '24_mssv.mssv IS NOT NULL' : $mssv_fix = '24_mssv.mssv = "'.$mssv.'"';
        $sql = 'SELECT
            ROW_NUMBER() OVER (ORDER BY 24_mssv.id_taikhoan) AS stt,
            hoten,
            24_thongtincanhan.id_taikhoan,
            24_thongtincanhan.dienthoai,
            24_thongtincanhan.cccd,
            24_mssv.mssv,
            24_thongtincanhan.gioitinh as gioitinh,
            thuongthu.name_province3,
            thuongthu.name_province2,
            thuongthu.name_province,
            thuongthu.duoi_xa_ttru,
            ngaysinh
        FROM 24_mssv
        INNER JOIN (SELECT id, idnganh FROM 24_lop) as lop ON lop.id = 24_mssv.id_lop
        LEFT JOIN
            (
                SELECT 24_hosonhaphoc.id_taikhoan as id_taikhoan, duoi_xa_ttru, name_province3, name_province2, name_province
                FROM  24_hosonhaphoc
                LEFT JOIN l_province ON l_province.id = 24_hosonhaphoc.id_tinh_ttru
                LEFT JOIN l_province2 ON l_province2.id = 24_hosonhaphoc.id_huyen_ttru
                LEFT JOIN l_province3 ON l_province3.id = 24_hosonhaphoc.id_xa_ttru
            ) as thuongthu ON thuongthu.id_taikhoan = 24_mssv.id_taikhoan
        INNER JOIN 24_thongtincanhan ON 24_thongtincanhan.id_taikhoan = 24_mssv.id_taikhoan
        WHERE '.$major_fix.'
        AND '.$cccd_fix.'
        AND '.$mssv_fix.'
        ORDER BY 24_mssv.mssv';

        $query = DB::select($sql);
        $json_data['data'] = $query;
        $data = json_encode($json_data);
        return $data;
    }
    function excel_hsnh_thongtinsinhvien($major,$cccd,$mssv, $id_sinhvien)
    {
        //Xuất excel
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $title = 'DanhSachSinhvienInGXN' . date("d-m-Y H:i:s") . '.xlsx'; // Tên file
        return Excel::download(new Admin24_Excel_Hsnh_Thongtinsinhvien($major,$cccd,$mssv,$id_sinhvien), $title);
    }
    function pdf_hsnh_thongtinsinhvien($code)
    {
        $decodedString = base64_decode($code);
        $parts = explode('/', $decodedString);
        $id_sinhvien = $parts[0];
        $loaigiay = $parts[1];
        $admin_sig = $parts[2];
        $arr_sinhvien = explode(',', $id_sinhvien);
        //tẠO MÃ PHIẾU
        $nam = Carbon::now()->year;
        $nam_fix = $nam;
        $thang = Carbon::now()->month;
        $ngay = Carbon::now()->day;
        $ngayin = $nam.$thang.$ngay;
        $khoas = DB::select('SELECT namnhaphoc FROM 24_lop, 24_khoas, 24_mssv WHERE 24_mssv.id_lop = 24_lop.id AND 24_lop.idkhoas = 24_khoas.id AND 24_mssv.id_taikhoan IN ( '.$id_sinhvien.')');
        $nam_fix = $khoas[0]->namnhaphoc;
        if($loaigiay == 1){
            $table = 'l_file_qlsv_nvqs';
            $magiay = 'NVQS';
            $gioitinh = 'gioitinh = 0';
        }else{
            $table = 'l_file_qlsv_vv';
            $magiay = 'VV';
            $gioitinh = 'gioitinh is not null';

        }

        $id_nam = DB::select('SELECT id FROM 24_khoas WHERE namnhaphoc = "'.$nam_fix.'"');
        $id_nam = $id_nam[0]->id;
        $s = 'SELECT Max(thutu) as count FROM '.$table;
        $thutu =  DB::select($s)[0]->count;

        // return $thutu;
        //LƯU THÔNG TIN PHIÉU (....) VÀ LUU MA PHIEU
            $data = [];
            $arr_thutu = '';

            for($i = 0; $i<count($arr_sinhvien);$i++){
                $sqli = 'SELECT count(*) as lan FROM '. $table .' WHERE id_user = '. $arr_sinhvien[$i];
                $lan = DB::select($sqli)[0]->lan;
                $thutu_tam = ++$thutu;
                $maphieu = 'L'.($lan+1).$ngayin.$magiay.$thutu_tam;
                $arr_tam = array(
                    'thutu' =>      $thutu_tam,
                    'maphieu' =>    $maphieu,
                    'id_year'   =>  $id_nam,
                    'id_user'   =>  $arr_sinhvien[$i],
                    'id_admin'  =>  Auth::guard('loginadmin')->user()->id,
                    'admin_sig' =>  $admin_sig,
                );
                $data[] =  $arr_tam;
                $arr_thutu .= $thutu_tam.",";
            }
            $arr_thutu = rtrim($arr_thutu, ',');

            DB::table($table)
            ->insert($data);

        //lAY DŨ LIEU XUÁT PDF
        $sql = "SELECT
                tt.hoten,
                DATE_FORMAT(tt.ngaysinh, '%d/%m/%Y') AS ngaysinh,
                tt.noisinh,
                24_mssv.mssv,
                CASE
                    WHEN tt.gioitinh = 1 THEN 'Nữ'
                    WHEN tt.gioitinh = 0 THEN 'Nam'
                    ELSE 'Không xác định'
                END AS gioitinh,
                tt.cccd,
                nh.id_taikhoan,
                DATE_FORMAT(nh.ngaycapcccd, '%d/%m/%Y') AS ngaycapcccd,
                nh.id_quoctich,
                prov.name_province AS noicapcccd,
                l_province.name_province AS tinh,
                l_province2.name_province2 AS huyen,
                l_province3.name_province3 AS xa,
                nh.duoi_xa_ttru,
                lop.name_major,
                lop.tenkhoa as khoa,
                lop.khoas as khoas,
                $table.maphieu AS mp,
                lop.tenlop as lop,
                lop.tgnhaphoc,
                lop.tgratruong,
                lop.tenchuyennganh,
                lop.thoigianhoc as thoigian,
                DAY(CURDATE()) AS day,
                MONTH(CURDATE()) AS month,
                YEAR(CURDATE()) AS year,
                mps.name AS admin_sig
            FROM
                24_mssv
            JOIN
                24_thongtincanhan tt ON 24_mssv.id_taikhoan = tt.id_taikhoan
            JOIN
                24_hosonhaphoc nh ON 24_mssv.id_taikhoan = nh.id_taikhoan
            JOIN
                (SELECT 24_khoa.tenkhoa as tenkhoa, 24_khoas.namnhaphoc as khoas, l_major.name_major as name_major,
                    24_chuyennganh.tenchuyennganh as tenchuyennganh, 24_lop.id as idlop, 24_lop.tenlop as tenlop,
                     24_lop.thoigianhoc as thoigianhoc,
                    DATE_FORMAT(24_khoas.ngaynhaphoc, '%m/%Y') AS tgnhaphoc,
                    DATE_FORMAT(24_lop.thoigianratruong, '%m/%Y') AS tgratruong
                    FROM  24_lop
                    JOIN 24_chuyennganh ON 24_lop.idchuyennganh = 24_chuyennganh.id
                    JOIN l_major ON 24_lop.idnganh = l_major.id
                    JOIN 24_khoa ON 24_lop.idkhoa = 24_khoa.id
                    JOIN 24_khoas ON 24_lop.idkhoas = 24_khoas.id) AS lop
                    ON lop.idlop = 24_mssv.id_lop
            LEFT JOIN
                l_province ON nh.id_tinh_ttru = l_province.id
            LEFT JOIN
                l_province2 ON nh.id_huyen_ttru = l_province2.id
            LEFT JOIN
                l_province3 ON nh.id_xa_ttru = l_province3.id
            LEFT JOIN
                l_province prov ON nh.noicapcccd = prov.id
            JOIN
                $table ON $table.id_user = tt.id_taikhoan
            JOIN
                l_file_qlsv_nvqs_sig mps ON mps.id = $table.admin_sig

            WHERE
                tt.id_taikhoan IN ($id_sinhvien)

                AND $table.thutu IN ($arr_thutu)
                AND ".$gioitinh;
            ;
        $query = DB::select($sql);
        if(count($query) > 0){
            $data = array(
                'pdf' => $query,
                // 'maphieu' => $maphieu,
             );
        }else{
            $data = array(
                'pdf' =>'Không tìm thấy thí sinh',
                // 'maphieu' => $maphieu,
             );
        }
        if($loaigiay == 1){
            $pdf = PDF::loadView('pdf.qlsv', $data);
            return $pdf->stream('document.pdf');
        }else{
            $pdf = PDF::loadView('pdf.vayvon', $data);
            return $pdf->stream('document.pdf');
        }

    }
    public function tim_maphieu($id_maphieu)
    {
        if (strpos($id_maphieu, 'NVQS') !== false) {
            $table = 'l_file_qlsv_nvqs';
        } else if (strpos($id_maphieu, 'VV') !== false) {
            $table = 'l_file_qlsv_vv';
        }else{
            $table = 'l_file_qlsv_vv';
            $id_maphieu = 0;
        }

        $sql = 'SELECT maphieu FROM ' . $table . ' WHERE maphieu = ?';
        $query = DB::select($sql, [$id_maphieu]);

        if ($query) {
            $infor = DB::select(
                "SELECT tt.hoten,
                        tt.mssv,
                        CASE
                            WHEN tt.gioitinh = 1 THEN 'Nữ'
                            WHEN tt.gioitinh = 0 THEN 'Nam'
                            ELSE 'Không xác định'
                        END AS gioitinh,
                        tt.cccd,
                        nh.id_taikhoan,
                        $table.maphieu as mp,
                        DATE_FORMAT($table.create_at, '%d/%m/%Y') as ngayki,
                        mps.name as admin_sig
                FROM 24_thongtincanhan tt
                JOIN 24_hosonhaphoc nh ON tt.id_taikhoan = nh.id_taikhoan
                JOIN $table ON $table.id_user = tt.id_taikhoan
                JOIN l_file_qlsv_nvqs_sig mps ON mps.id = $table.admin_sig
                WHERE $table.maphieu = ?", [$id_maphieu]
            );

            if ($infor) {
                return response()->json(['data' => $infor]);
            } else {
                return 0;
            }
        } else {
            return response()->json(['error' => 'No data found']);
        }
    }
    public function inlai_maphieu($id_maphieu)
    {
        // Determine the table and document type based on maphieu
        if (strpos($id_maphieu, 'NVQS') !== false) {
            $table = 'l_file_qlsv_nvqs';
            $loaigiay = 1;
        } else if (strpos($id_maphieu, 'VV') !== false) {
            $table = 'l_file_qlsv_vv';
            $loaigiay = 2;
        } else {
            return response()->json(['error' => 'Invalid maphieu format']);
        }

        // Check if the maphieu exists in the database
        $sql = 'SELECT maphieu FROM ' . $table . ' WHERE maphieu = ?';
        $query = DB::select($sql, [$id_maphieu]);

        if ($query) {
            // Retrieve detailed information
            $infor = DB::select(
                "SELECT tt.hoten,
                        DATE_FORMAT(tt.ngaysinh, '%d/%m/%Y') as ngaysinh,
                        tt.noisinh,
                        tt.mssv,
                        CASE
                            WHEN tt.gioitinh = 1 THEN 'Nữ'
                            WHEN tt.gioitinh = 0 THEN 'Nam'
                            ELSE 'Không xác định'
                        END AS gioitinh,
                        tt.cccd,
                        nh.id_taikhoan,
                        DATE_FORMAT(nh.ngaycapcccd, '%d/%m/%Y') AS ngaycapcccd,
                        nh.id_quoctich,
                        prov.name_province AS noicapcccd,
                        l_province.name_province AS tinh,
                        l_province2.name_province2 AS huyen,
                        l_province3.name_province3 AS xa,
                        nh.duoi_xa_ttru,
                        diachi,
                        l_major.name_major,
                        l_major.khoa,
                        $table.maphieu as mp,
                        l_major.lop,
                        l_major.tgnhaphoc,
                        l_major.tgratruong,
                        l_major.chuyennganh,
                        l_major.thoigian,
                        DAY($table.create_at) AS day,
                        MONTH($table.create_at) AS month,
                        YEAR($table.create_at) AS year,
                        mps.name as admin_sig
                FROM 24_thongtincanhan tt
                JOIN 24_hosonhaphoc nh ON tt.id_taikhoan = nh.id_taikhoan
                JOIN l_major ON tt.major = l_major.id_major
                JOIN l_province ON nh.id_tinh_ttru = l_province.id
                JOIN l_province2 ON nh.id_huyen_ttru = l_province2.id
                JOIN l_province3 ON nh.id_xa_ttru = l_province3.id
                JOIN l_province prov ON nh.id_quoctich = prov.id
                JOIN $table ON $table.id_user = tt.id_taikhoan
                JOIN l_file_qlsv_nvqs_sig mps ON mps.id = $table.admin_sig
                WHERE $table.maphieu = ?", [$id_maphieu]
            );

            // Prepare the data for the view
            $data = array(
                'pdf' => $infor,
            );

            // Generate PDF based on document type
            if($loaigiay == 1){
                $pdf = PDF::loadView('pdf.qlsv', $data);
                $name_file = $id_maphieu.'pdf';
                return $pdf->stream($name_file);
            } else {
                $pdf = PDF::loadView('pdf.vayvon', $data);
                $name_file = $id_maphieu.'pdf';
                return $pdf->stream($name_file);

            }


        } else {
            return response()->json(['error' => 'No data found']);
        }
    }
    public function thongke()
    {

        $res =  DB::table('24_thongtincanhan')
        ->select('hoten as text','id_taikhoan as id','gioitinh as check')
        ->get();

        return view('user_24.admin24.manage.quanlynhaphoc.thongke_xuatfile',
        [
            'menu' =>  $this->sidebar(),
            'res' => $res,
        ]
        );
    }
    public function loaigiay()
    {
        $loaigiay = DB::select("SELECT danhmuc_gxn_id as id,  danhmuc_gxn_tenloai as text, '' as selected FROM 24_danhmuc_gxn");
        if($loaigiay){
           $loaigiay0 = new Collection([
               'id' => 0,
               'text' => 'Chọn loại giấy',
               'selected' =>'selected'
           ]);

        }else{
           $loaigiay0 = new Collection([
               'id' => 0,
               'text' => 'Chọn loaij giấy',
               'selected' =>''
           ]);
        }

        $loaigiay[] = $loaigiay0;
        $res = new Collection([
           'loaigiay' =>$loaigiay
        ]);

        return $res;

    }
    public function loadkhoa(){
        $loadkhoa = DB::select("SELECT id as id,  tenkhoa as text, '' as selected FROM 24_khoa");
        if($loadkhoa){
           $loadkhoa0 = new Collection([
               'id' => 0,
               'text' => 'Chọn Khoa',
               'selected' =>'selected'
           ]);

        }else{
           $loadkhoa0 = new Collection([
               'id' => 0,
               'text' => 'Chọn Khoa',
               'selected' =>''
           ]);
        }

        $loadkhoa[] = $loadkhoa0;
        $res = new Collection([
           'loadkhoa' =>$loadkhoa
        ]);

        return $res;
    }
    public function loadlop($idkhoa){
        $lop = DB::select("SELECT id as id,  tenlop as text, '' as selected FROM 24_lop WHERE idkhoa = ".$idkhoa);
        if($lop){
           $lop0 = new Collection([
               'id' => 0,
               'text' => 'Chọn Lớp',
               'selected' =>'selected'
           ]);

        }else{
           $lop0 = new Collection([
               'id' => 0,
               'text' => 'Chọn Lớp',
               'selected' =>''
           ]);
        }

        $lop[] = $lop0;
        $res = new Collection([
           'loadlop' =>$lop
        ]);

        return $res;
    }
    public function loadkhoas(){
        $loadkhoas = DB::select("SELECT id as id,  namnhaphoc as text, '' as selected FROM 24_khoas");
        if($loadkhoas){
           $loadkhoas0 = new Collection([
               'id' => 0,
               'text' => 'Chọn Năm học',
               'selected' =>'selected'
           ]);

        }else{
           $loadkhoas0 = new Collection([
               'id' => 0,
               'text' => 'Chọn Năm học',
               'selected' =>''
           ]);
        }

        $loadkhoas[] = $loadkhoas0;
        $res = new Collection([
           'loadkhoas' =>$loadkhoas
        ]);

        return $res;
    }
    public function thongke_xuatfile($nam,$id_lop,$khoa)
    {
        $data = DB::table('24_lop')
        ->select('24_lop.id','tenlop','tenkhoa', DB::raw('ROW_NUMBER() OVER (ORDER BY `24_lop`.`id`) AS stt'))
        ->join('24_khoas','24_khoas.id','24_lop.idkhoas')
        ->join('24_khoa','24_khoa.id','24_lop.idkhoa')
        ->where('idkhoas',$nam)
        ->where(function($query) use ($id_lop) {
            if ($id_lop == 0) {
                $query->whereNotNull('24_lop.id'); // Thay 'column_name' bằng tên cột thực tế
            } else {
                $query->where('24_lop.id',$id_lop);
            }
        })
        ->where(function($query) use ($khoa) {
            if ($khoa == 0) {
                $query->whereNotNull('24_lop.id'); // Thay 'column_name' bằng tên cột thực tế
            } else {
                $query->where('idkhoa',$khoa);
            }
        })
        ->get();
        $nvqs = DB::table('l_file_qlsv_nvqs')
        ->select('id_lop as id',DB::raw('COUNT(*) as value'))
        ->join('24_mssv','24_mssv.id_taikhoan','l_file_qlsv_nvqs.id_user')
        ->join('24_lop','24_lop.id','24_mssv.id_lop')
        ->where('id_year',$nam)
        ->where(function($query) use ($id_lop) {
            if ($id_lop == 0) {
                $query->whereNotNull('l_file_qlsv_nvqs.id'); // Thay 'column_name' bằng tên cột thực tế
            } else {
                $query->where('24_mssv.id_lop',$id_lop);
            }
        })
        ->where(function($query) use ($khoa) {
            if ($khoa == 0) {
                $query->whereNotNull('l_file_qlsv_nvqs.id'); // Thay 'column_name' bằng tên cột thực tế
            } else {
                $query->where('24_lop.idkhoa',$khoa);
            }
        })
        ->groupBy('id_lop')
        ->get();
        $vv = DB::table('l_file_qlsv_vv')
        ->select('id_lop as id',DB::raw('COUNT(*) as value'))
        ->join('24_mssv','24_mssv.id_taikhoan','l_file_qlsv_vv.id_user')
        ->join('24_lop','24_lop.id','24_mssv.id_lop')
        ->where('id_year',$nam)
        ->where(function($query) use ($khoa) {
            if ($khoa == 0) {
                $query->whereNotNull('l_file_qlsv_vv.id'); // Thay 'column_name' bằng tên cột thực tế
            } else {
                $query->where('24_lop.idkhoa',$khoa);
            }
        })
        ->where(function($query) use ($id_lop) {
            if ($id_lop == 0) {
                $query->whereNotNull('l_file_qlsv_vv.id'); // Thay 'column_name' bằng tên cột thực tế
            } else {
                $query->where('24_mssv.id_lop',$id_lop);
            }
        })
        ->groupBy('id_lop')
        ->get();
        $this->ghep_2truyvan($data,$vv,'slvv');
        $this->ghep_2truyvan($data,$nvqs,'slnvqs');
        $json_data['data'] = $data;
            $data = json_encode($json_data);
        return $data;
    }
    function excel_hsnh_thongke_xuatfile($nam,$id_lop, $idkhoa)
    {
        //Xuất excel
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $title = 'DanhSachThongkeSinhVienInGXN'. date("d-m-Y H:i:s") .'.xlsx'; // Tên file
        return Excel::download(new Admin24_Excel_Hsnh_ThongkeXuatfile($nam,$id_lop, $idkhoa), $title);
    }
    // bhyt
    public function loadlop_bhyt()
    {
        $lop = DB::select("SELECT id as id, tenlop as text, '' as selected FROM 24_lop
        ");
        if($lop){
           $lop0 = new Collection([
               'id' => 0,
               'text' => 'Chọn lớp',
               'selected' =>'selected'
           ]);

        }else{
           $lop0 = new Collection([
               'id' => 0,
               'text' => 'Chọn lớp',
               'selected' =>''
           ]);
        }

        $lop[] = $lop0;
        $res = new Collection([
           'lop' =>$lop
        ]);

        return $res;

    }
    public function loadkhoa_bhyt()
    {
        $khoa = DB::select("SELECT id as id, tenkhoa as text, '' as selected FROM 24_khoa
        ");
        if($khoa){
           $khoa0 = new Collection([
               'id' => 0,
               'text' => 'Chọn khoa',
               'selected' =>'selected'
           ]);

        }else{
           $khoa0 = new Collection([
               'id' => 0,
               'text' => 'Chọn khoa',
               'selected' =>''
           ]);
        }

        $khoa[] = $khoa0;
        $res = new Collection([
           'khoa' =>$khoa
        ]);

        return $res;

    }
    public function loadnam_bhyt()
    {
        $loadnam = DB::select("SELECT id as id, namnhaphoc as text, '' as selected FROM 24_khoas
        ");
        if($loadnam){
           $loadnam0 = new Collection([
               'id' => 0,
               'text' => 'Chọn Năm học',
               'selected' =>'selected'
           ]);

        }else{
           $loadnam0 = new Collection([
               'id' => 0,
               'text' => 'Chọn Năm học',
               'selected' =>''
           ]);
        }

        $loadnam[] = $loadnam0;
        $res = new Collection([
           'nam' =>$loadnam
        ]);

        return $res;

    }
    public function bhyt()
    {

        $res =  DB::table('24_thongtincanhan')
         ->select('hoten as text','id_taikhoan as id','gioitinh as check')
         ->get();

         return view('user_24.admin24.manage.quanlynhaphoc.bhyt',
         [
             'menu' =>  $this->sidebar(),
             'res' => $res,
         ] );
    }
     public function loadthongtin_bhyt($major,$cccd,$mssv,$bhyt)
    {

        $major == 0 ? $major_fix = 'sv.mssv IS NOT NULL' : $major_fix = 'sv.id_lop ='.$major;
        if($cccd == '254514dfdf41214mkli'){
            $cccd_fix = 'sv.mssv IS NOT NULL';
        }else{
            $cccd_fix = 'tt.cccd = "'.$cccd.'"';
        }


        if($mssv == '254514dfdf41214mkli'){
            $mssv_fix = 'sv.mssv IS NOT NULL';
        }else{
            $mssv_fix = 'sv.mssv = "'.$mssv.'"';
        }
        // return ($mssv_fix);


        if($bhyt == '254514dfdf41214mkli'){
            $bhyt_fix = 'sv.mssv IS NOT NULL';
        }else{
            $bhyt_fix = 'hs.bhyt = "'.$bhyt.'"';
        }

        $sql = 'SELECT
            ROW_NUMBER() OVER (ORDER BY sv.id) AS stt,
            tt.hoten,
            sv.id_taikhoan,
            tt.cccd as cccd,
            sv.mssv,
            lp.tenlop as lop,
            tt.ngaysinh,
            if(tt.gioitinh = 1, "Nữ","Nam") as gioitinh,
            hs.bhyt,
            thuongthu.name_province3,
            thuongthu.name_province2,
            thuongthu.name_province,
            thuongthu.duoi_xa_ttru,
            tt.dienthoai,
            sv.ghichu,
            sv.trangthai
            FROM 24_mssv sv
            LEFT JOIN
                24_hosonhaphoc hs ON  hs.id_taikhoan = sv.id_taikhoan
            LEFT JOIN
                24_thongtincanhan tt ON  tt.id_taikhoan = sv.id_taikhoan
            LEFT JOIN
                (
                    SELECT 24_hosonhaphoc.id_taikhoan as id_taikhoan, duoi_xa_ttru, name_province3, name_province2, name_province
                    FROM  24_hosonhaphoc
                    LEFT JOIN l_province ON l_province.id = 24_hosonhaphoc.id_tinh_ttru
                    LEFT JOIN l_province2 ON l_province2.id = 24_hosonhaphoc.id_huyen_ttru
                    LEFT JOIN l_province3 ON l_province3.id = 24_hosonhaphoc.id_xa_ttru
                ) as thuongthu ON thuongthu.id_taikhoan = sv.id_taikhoan
            INNER JOIN
                24_lop lp ON  lp.id = sv.id_lop

            WHERE '.$major_fix.' AND '.$mssv_fix.' AND '.$cccd_fix.' AND '.$bhyt_fix;

        $data = DB::select($sql);
        $json_data['data'] = $data;
        $data = json_encode($json_data);
        return $data;




    }
    public function bhyt_thongke()
    {
        $res =  DB::table('24_thongtincanhan')
         ->select('hoten as text','id_taikhoan as id','gioitinh as check')
         ->get();

         return view('user_24.admin24.manage.quanlynhaphoc.bhyt_thongke',
         [
             'menu' =>  $this->sidebar(),
             'res' => $res,
         ]
        );
    }
    public function loadthongtin_bhyt_thongke($lop,$nam,$khoa)
    {
        $khoa == 0 ? $khoa_fix = 'ms.id IS NOT NULL' : $khoa_fix = 'l.idkhoa ='.$khoa;
        $lop == 0 ? $lop_fix = 'ms.id IS NOT NULL' : $lop_fix = 'l.id ='.$lop;
        $sql = 'SELECT
                ROW_NUMBER() OVER (ORDER BY l.tenlop) AS stt,
                ms.id_lop,
                l.tenlop,
                lop.namnhaphoc,
                COUNT(ms.id_lop) AS "Sỉ số",
                COUNT(CASE WHEN hs.bhyt IS NOT NULL AND hs.bhyt != "" THEN 1 END) AS "Có BHYT",
                COUNT(CASE WHEN hs.bhyt IS NULL OR hs.bhyt = "" THEN 1 END) AS "Chưa có BHYT"
            FROM
                24_mssv ms
            INNER JOIN 24_lop l ON ms.id_lop = l.id
            LEFT JOIN 24_hosonhaphoc hs ON hs.id_taikhoan = ms.id_taikhoan
            LEFT JOIN (
                SELECT k.namnhaphoc, l.id
                FROM 24_lop l
                INNER JOIN 24_khoas k ON k.id = l.idkhoas
            ) AS lop ON lop.id = ms.id_lop
            WHERE
                l.idkhoas ='.$nam.'
                AND '.$khoa_fix.'
                AND '.$lop_fix.'
            GROUP BY
                ms.id_lop';
        $query = DB::select($sql);
        $json_data['data'] = $query;
        $data = json_encode($json_data);
        return $data;
    }
    public function excel_hsnh_thongtinsinhvien_bhyt($id_sinhvien)
    {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $title = 'DanhSachBHYTSinhVien' . date("d-m-Y H:i:s") . '.xlsx'; // Tên file
        return Excel::download(new Admin24_Excel_Hsnh_Thongtinsinhvien_bhyt($id_sinhvien), $title);
    }
    public function onchange($id)
    {
        $lop = DB::select("SELECT 24_lop.id as id, 24_lop.tenlop as text FROM 24_lop WHERE 24_lop.idkhoa = $id");
        if($lop){
            $lop0 = new Collection([
                'id' => 0,
                'text' => 'Chọn Lớp',
                'selected' =>'selected'
            ]);

         }else{
            $lop0 = new Collection([
                'id' => 0,
                'text' => 'Chọn Lớp',
                'selected' =>''
            ]);
         }

         $lop[] = $lop0;
         $res = new Collection([
            'lop' =>$lop
         ]);
         return $res;
    }
    function excel_hsnh_thongtinsinhvien_bhyt_thongke($lop,$nam,$khoa)
    {
        //Xuất excel
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $title = 'DanhSachThongKeBHYTSinhVien' . date("d-m-Y H:i:s") . '.xlsx'; // Tên file
        return Excel::download(new Admin24_Excel_Hsnh_Thongtinsinhvien_bhyt_thongke($lop,$nam,$khoa), $title);
    }
    public function import_bhyt(Request $request)
    {
        Excel::import(new Import_bhyt, $request->file('fileInput'));
        return 1;

    }
    function img_bhyt($id)
    {
        $data = DB::table('24_image')
        ->where('id_taikhoan',$id)
        ->where('loaianh',13)
        ->first();
        if($data){
            return  $data->path_img;
        }else{
            return  '/img/test.png';

        }
    }
    function capnhat_bhyt(Request $request)
    {
        try{
            $id_taikhoan = $request->input('id_taikhoan');
            $value = $request->input('value');
            $data = DB::table('24_hosonhaphoc')
            ->where('id_taikhoan',$id_taikhoan)
            ->update(
                [
                    'bhyt' => $value
                ]
            );
            $noidung =  DB::table('24_hosonhaphoc')
            ->where('id_taikhoan',$id_taikhoan)
            ->first()->bhyt;
            if($data == 1){
                $trangthai =  'upd_1';
                $id_admin = Auth::guard('loginadmin')->user()->id;
                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                DB::table('24_lichsu')
                ->insert([
                    'id_taikhoan' => $id_taikhoan,
                    'noidung'   => "Cập nhật Số BHYT: ".$noidung,
                    'hienthi'   => 1,
                    'id_nhansu' => $id_admin,
                    'thietbi'   => $user_agent,
                    'ip'        => request()->ip()
                ]);
            }else{
                $trangthai =  'upd_0';
            }
        }catch(Exception $e){
            $trangthai = 'err_0';
        }
        return array(
            'trangthai' => $trangthai,
            'noidung' => $noidung,
        );
    }
    //Tra cứu sinh viên
    function tracuusinhvien(){
        return view('user_24.admin24.manage.quanlynhaphoc.tracuusinhvien',
            [
                'menu' =>  $this->sidebar()
            ]
        );
    }
    function tcsv_loadtimkiem(){
        $gioitinh = array(
            [
                'id' => -1,
                'text' => "Chọn Giới tính"
            ],
            [
                'id' => 0,
                'text' => "Nam"
            ],
            [
                'id' => 1,
                'text' => "Nữ"
            ]
        );
        $trangthai = array(
            [
                'id' => -1,
                'text' => "Chọn Trạng thái"
            ],
            [
                'id' => 0,
                'text' => "Đang học"
            ],
            [
                'id' => 1,
                'text' => "Rút hồ sơ"
            ]
        );
        return array(
            'tcsv_khoahoc' => $this->load_seclectbox('24_khoas','id','namnhaphoc',0,'Chọn Khóa học'),
            'tcsv_nganh' => $this->load_seclectbox('l_major','id','name_major',0,'Chọn Ngành đào tạo'),
            'tcsv_khoa' => $this->load_seclectbox('24_khoa','id','tenkhoa',0,'Chọn Khoa chuyên ngành'),
            'tcsv_chuyennganh' => $this->load_seclectbox('24_chuyennganh','id','tenchuyennganh',0,'Chọn Chuyên ngành'),
            'tcsv_lop' => $this->load_seclectbox('24_lop','id','tenlop',0,'Chọn Lớp học'),
            'tcsv_dantoc' => $this->load_seclectbox('l_nation','id','name_nation',0,'Chọn Dân tộc'),
            'tcsv_tongiao' => $this->load_seclectbox('l_religion','id','tentongiao',0,'Chọn Tôn giáo'),
            'tcsv_noisinh' => $this->load_seclectbox('l_province','id','name_province',0,'Chọn Nơi sinh'),
            'tcsv_hktt' => $this->load_seclectbox('l_province','id','name_province',0,'Chọn Hộ khẩu thường trú'),
            'tcsv_quequan' => $this->load_seclectbox('l_province','id','name_province',0,'Chọn Quê quán'),
            'tcsv_hoatdong' => $trangthai,
            'tcsv_gioitinh' => $gioitinh
        );
    }
    function data_tcsv_timkiem($search){
        $search = json_decode($search, true);
        $id_khoas =  $search['tcsv_khoahoc'];
        $id_khoa =  $search['tcsv_khoa'];
        $id_nganh =  $search['tcsv_nganh'];
        $id_chuyennganh =  $search['tcsv_chuyennganh'];
        $id_lop =  $search['tcsv_lop'];
        $id_dantoc =  $search['tcsv_dantoc'];
        $id_tongiao =  $search['tcsv_tongiao'];
        $id_giotinh =  $search['tcsv_gioitinh'];
        $id_noisinh =  $search['tcsv_noisinh'];
        $id_hktt =  $search['tcsv_hktt'];
        $id_quequan =  $search['tcsv_quequan'];
        $hoten = trim($search['tcsv_hoten']);
        $cccd = trim($search['tcsv_cccd']);
        $mssv = trim($search['tcsv_mssv']);
        $hoatdong = $search['tcsv_hoatdong'];
        $trangthai = $search['trangthai'];
        $data = DB::table('24_mssv')
        ->select(
            DB::raw('ROW_NUMBER() OVER (ORDER BY 24_mssv.mssv) AS stt'),
            '24_thongtincanhan.id_taikhoan',
            'account24s.email',
            '24_mssv.mssv','24_thongtincanhan.hoten','24_thongtincanhan.gioitinh',
            DB::raw("DATE_FORMAT(24_thongtincanhan.ngaysinh, '%d/%m/%Y') as ngaysinh"),'24_thongtincanhan.dienthoai','24_thongtincanhan.dienthoai_phu','24_thongtincanhan.diachi',
            'l_major.id_major as manganh','l_major.name_major as nganh','24_chuyennganh.tenchuyennganh','24_lop.malop','24_lop.tenlop',
            '24_thongtincanhan.cccd',
            '24_khoas.namnhaphoc','24_khoa.tenkhoa','24_mssv.trangthai as hoatdong'
        )

        ->join('24_lop','24_mssv.id_lop','24_lop.id')
        ->join('24_khoas','24_khoas.id','24_lop.idkhoas')
        ->join('24_khoa','24_khoa.id','24_lop.idkhoa')
        ->join('24_thongtincanhan','24_thongtincanhan.id_taikhoan','24_mssv.id_taikhoan')
        ->join('account24s','24_thongtincanhan.id_taikhoan','account24s.id')
        ->join('l_major','l_major.id','24_lop.idnganh')
        ->join('24_chuyennganh','24_chuyennganh.id','24_lop.idchuyennganh')
        ->when($id_khoas != 0 , function ($query) use ($id_khoas) {
            return $query->where('24_khoas.id', $id_khoas);
        })
        ->when($id_khoa > 0 , function ($query) use ($id_khoa) {
            return $query->where('24_khoa.id', $id_khoa);
        })
        ->when($id_nganh > 0 , function ($query) use ($id_nganh) {
            return $query->where('l_major.id', $id_nganh);
        })
        ->when($id_chuyennganh > 0 , function ($query) use ($id_chuyennganh) {
            return $query->where('24_chuyennganh.id', $id_chuyennganh);
        })
        ->when($id_lop > 0 , function ($query) use ($id_lop) {
            return $query->where('24_lop.id', $id_lop);
        })
        ->when($id_giotinh > -1 , function ($query) use ($id_giotinh) {
            return $query->where('24_thongtincanhan.gioitinh', $id_giotinh);
        })
        ->when($hoten != '' , function ($query) use ($hoten) {
            return $query->whereRaw('LOWER(24_thongtincanhan.hoten) LIKE ?', [strtolower("%{$hoten}%")]);
        })
        ->when($mssv != "" , function ($query) use ($mssv) {
            return $query->where('24_mssv.mssv', $mssv);
        })
        ->when($cccd != "" , function ($query) use ($cccd) {
            return $query->where('24_thongtincanhan.cccd', $cccd);
        })
        ->when($trangthai == 0 , function ($query) use ($trangthai) {
            return $query->where('l_major.id', -100);
        })
        ->when($hoatdong > -1, function ($query) use ($hoatdong) {
            return $query->where('24_mssv.trangthai',$hoatdong);
        })
        ->orderBy('l_major.id','ASC')
        ->orderBy('24_chuyennganh.id','ASC')
        ->orderBy('24_mssv.mssv','ASC')
        ->get();
        return  $data;
    }
    function tcsv_timkiem($search){
        $json_data['data'] = $this->data_tcsv_timkiem($search);
        $data = json_encode($json_data);
        return $data;
    }
    function tcsv_load_img($id,$id_img){
        return $this->data_img($id,$id_img);
    }
    function tcsv_excel($search){
        $data =  $this->data_tcsv_timkiem($search);
        $data_ex = new Collection([
            ['stt','ID','MSSV','Họ và tên','Giới tính','Ngày sinh','Điện thoai','Điện thoại 2','Địa chỉ',
            'Mã ngành','Ngành','Chuyên ngành','Mã lớp','Tên lớp',
            'Nơi sinh Tỉnh','Nơi sinh Huyện','Nơi sinh Xã','Nơi sinh GKS',
            'HKTT Tỉnh','HKTT Huyện','HKTT Xã','HKTT Ấp/KV',
            'Quê quán Tỉnh', 'Quê quán Huyện', 'Quê quán Xã', 'Quê quán Ấp/KV',
            'Họ tên Cha','Điện thoại Cha', 'Nghề nghiệp Cha',
            'Họ tên Mẹ','Điện thoại Mẹ', 'Nghề nghiệp Mẹ',
            'Người đỡ đầu','Điện thoại Ng Đỡ đầu', 'Nghề nghiệp Ng Đỡ đầu',
            'Ngày vào Đoàn','Ngày vào Đảng','BHYT',
            'CMND','Ngày cấp','Nơi cấp',
            'Dân tộc','Quốc tịch','Tôn giáo',
            'Năm nhập học','Khoa','Trạng thái tuyển sinh'
            ]
        ]);
        foreach ( $data as  $key => $value) {
            $value ->gioitinh == 1 ? $gioitinh = "Nam" : $gioitinh = "Nữ";
            $value ->hoatdong == 0 ? $hoatdong = "Đã nhập học" : $hoatdong = "Rút hồ sơ";
            $row =  [
                    $value ->stt,
                    $value ->id_taikhoan,
                    $value ->mssv,
                    $value ->hoten,
                    $gioitinh,
                    $value ->ngaysinh,
                    $value ->dienthoai,
                    $value ->dienthoai_phu,
                    $value ->diachi,
                    $value ->manganh,
                    $value ->nganh,
                    $value ->tenchuyennganh,
                    $value ->malop,
                    $value ->tenlop,
                    $value ->ns_tinh,
                    $value ->ns_huyen,
                    $value ->ns_xa,
                    $value ->ns_gks,
                    $value ->hktt_tinh,
                    $value ->hktt_huyen,
                    $value ->hktt_xa,
                    $value ->hktt_duoixa,
                    $value ->qq_tinh,
                    $value ->qq_huyen,
                    $value ->qq_xa,
                    $value ->qq_duoi,
                    $value ->hotencha,
                    $value ->dienthoaicha,
                    $value ->nghenghiepcha,
                    $value ->hotenme,
                    $value ->dienthoaime,
                    $value ->nghenghiepme,
                    $value ->nguoidodau,
                    $value ->dienthoainguoidodau,
                    $value ->nghenghiepnguoidodau,
                    $value ->ngayvaodoan,
                    $value ->ngayvaodang,
                    $value ->bhyt,
                    $value ->cccd,
                    $value ->ngaycapcccd,
                    $value ->noicapcccd,
                    $value ->dantoc,
                    $value ->quoctich,
                    $value ->tentongiao,
                    $value ->namnhaphoc,
                    $value ->tenkhoa,
                    $hoatdong
                ];
            $data_ex[] = $row;
        }
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $title = 'DanhSachNhapHoc'. date("d-m-Y H:i:s") .'.xlsx';
        return Excel::download(new Admin24_XuatDSNhaphoc($data_ex), $title);
    }



    //Danh sách thu hồ sơ sinh viên
    function hssv_danhsachssv(){
        return view('user_24.admin24.manage.quanlynhaphoc.danhsachthuhoso',
            [
                'menu' =>  $this->sidebar()
            ]
        );
    }
    function hssv_load_thanhtimkiem(){
        $gioitinh = array(
            [
                'id' => -1,
                'text' => "Chọn Giới tính"
            ],
            [
                'id' => 0,
                'text' => "Nam"
            ],
            [
                'id' => 1,
                'text' => "Nữ"
            ]
        );
        $trangthai = array(
            [
                'id' => -1,
                'text' => "Chọn Trạng thái"
            ],
            [
                'id' => 0,
                'text' => "Đang học"
            ],
            [
                'id' => 1,
                'text' => "Rút hồ sơ"
            ]
        );
        return array(
            'hssv_khoahoc' => $this->load_seclectbox('24_khoas','id','namnhaphoc',0,'Chọn Khóa học'),
            'hssv_nganh' => $this->load_seclectbox('l_major','id','name_major',0,'Chọn Ngành đào tạo'),
            'hssv_khoa' => $this->load_seclectbox('24_khoa','id','tenkhoa',0,'Chọn Khoa chuyên ngành'),
            'hssv_chuyennganh' => $this->load_seclectbox('24_chuyennganh','id','tenchuyennganh',0,'Chọn Chuyên ngành'),
            'hssv_lop' => $this->load_seclectbox('24_lop','id','tenlop',0,'Chọn Lớp học'),
            'hssv_hoatdong' => $trangthai,
            'hssv_gioitinh' => $gioitinh
        );
    }
    function hssv_data_danhsachssv($data,$id_loai){
        $jsonData = json_decode(urldecode(base64_decode($data)), true);
        $khoahoc = $jsonData['hssv-khoahoc'];
        $khoa = $jsonData['hssv-khoa'];
        $nganh = $jsonData['hssv-nganh'];
        $chuyennganh = $jsonData['hssv-chuyennganh'];
        $lop = $jsonData['hssv-lop'];
        $hoatdong = $jsonData['hssv-hoatdong'];
        $gioitinh = $jsonData['hssv-gioitinh'];
        $cccd = trim($jsonData['hssv-cccd']);
        $mssv = trim($jsonData['hssv-mssv']);
        $hoten = preg_replace('/\s+/', ' ', trim(preg_replace('/[^a-zA-Z0-9\s]/u', '', $jsonData['hssv-hoten'])));
        $danhsachsinhvien = DB::table('24_mssv')
        ->select('*', DB::raw("DATE_FORMAT(ngaysinh, '%d/%m/%Y') as ngaysinh"),'24_hosonhaphoc.ghichu as ghichu')
        ->join('24_thongtincanhan','24_thongtincanhan.id_taikhoan','24_mssv.id_taikhoan',)
        ->leftJoin('24_hosonhaphoc','24_hosonhaphoc.id_taikhoan','24_mssv.id_taikhoan',)
        ->join('24_lop','24_mssv.id_lop','24_lop.id')
        ->join('24_khoa','24_khoa.id','24_lop.idkhoa')
        ->join('24_khoas','24_khoas.id','24_lop.idkhoas')
        ->where('24_khoas.id',$khoahoc)
        ->when( $khoa != 0 , function ($query) use ($khoa) {
            return $query->where('idkhoa', $khoa );
            })
        ->when( $nganh != 0 , function ($query) use ($nganh) {
            return $query->where('24_lop.idnganh', $nganh );
            })
        ->when( $chuyennganh != 0 , function ($query) use ($chuyennganh) {
            return $query->where('24_lop.idchuyennganh', $chuyennganh );
            })
        ->when( $lop != 0 , function ($query) use ($lop) {
            return $query->where('24_lop.id', $lop );
            })
        ->when( $hoatdong != -1 , function ($query) use ($hoatdong) {
            return $query->where('24_mssv.trangthai', $hoatdong );
            })
        ->when( $gioitinh != -1 , function ($query) use ($gioitinh) {
            return $query->where('24_thongtincanhan.gioitinh', $gioitinh );
            })
        ->when( $cccd != '' , function ($query) use ($cccd) {
            return $query->where('cccd', $cccd );
            })
        ->when( $mssv != '', function ($query) use ($mssv) {
            return $query->where('mssv', $mssv );
            })
        ->when($hoten != '' , function ($query) use ($hoten) {
                return $query->where('24_thongtincanhan.hoten', 'like', "%{$hoten}%");
            })
        ->get();
        $hoso = DB::table('24_nhanhoso')
        // ->rightJoin('24_danhmuc_hoso','24_danhmuc_hoso.id','24_nhanhoso.id_hoso')
        ->get();
        $danhmuc = DB::table('24_danhmuc_hoso')
        ->where('idnam',$khoahoc)->get();
        foreach ($danhsachsinhvien as $key_sv => $sv) {
            foreach ( $danhmuc as  $dm) {
                $loaihoso= $dm->text_hienthi;
                $dem = 0;
                foreach ($hoso as $key_hs => $dmrow) {
                    if($dm->id ==  $dmrow->id_hoso &&  $dmrow->id_taikhoan == $sv->id_taikhoan ){
                        switch ($id_loai) {
                            case '1':
                                $sv->$loaihoso = '<input checked type = "checkbox" onclick = "return false" style = "height:13px">';
                                break;
                            case '2':
                                $sv->$loaihoso = "Đã thu";
                                break;
                            case '3':
                                $sv->$loaihoso = 'checked';
                                break;
                            default:
                                $sv->$loaihoso = 1;
                                break;
                        }
                        $dem++;
                        break;
                    }
                    if($dem == 0){
                        switch ($id_loai) {
                            case '1':
                                $sv->$loaihoso = '<input type = "checkbox" onclick = "return false" style = "height:13px">';
                                break;
                            case '2':
                                $sv->$loaihoso = "Chưa thu";
                                break;
                            case '3':
                                $sv->$loaihoso = 'no_checked';
                                break;
                            default:
                                $sv->$loaihoso = 0;
                                break;
                        }
                    }
                }
            }
            $sv->stt = $key_sv +1;
        }
        // return $danhsachsinhvien;

        //Load thong tin cơ sở bên trái
        $data_title = ['STT',"MSSV",'Họ và tên','Ngày sinh'];
        $data_data = ['stt','mssv','hoten','ngaysinh'];
        for ($i=0; $i < count($data_title); $i++) {
            $thongtin = array(
                'title' =>  $data_title[$i],
                'data' =>  $data_data[$i],
            );

            $tieude[] = $thongtin;
            $tieude_pdf[] = $thongtin;
        }

         //Load thong tin thay đổi bên phải
        foreach ($danhmuc as $key => $dmrow) {
            $loaihoso = $dmrow->text_hienthi;
            $tam = array(
                'title' => $dmrow->text_hienthi,
                'data' => $loaihoso,
                'className' => 'text-center',
            );
            $tieude[]= $tam ;
        }
        $thongtin_end = array(
            'title' =>  'Ghi chú',
            'data' =>  'ghichu',
        );
        $tieude[] = $thongtin_end;
        $response['columns'] = $tieude;
        $response['data'] = $danhsachsinhvien;
        $response['danhmuchoso'] = $danhmuc;
        return $response;
    }
    function hssv_load_danhsachssv($data){
        return response()->json( $this->hssv_data_danhsachssv($data,1));
    }
    function hssv_excel_danhsach($data_check) {
        $data_table = $this->hssv_data_danhsachssv($data_check,2);
        $data_headings = $data_table['columns'];
        $data_body= $data_table['data'];
        $body_exports = [];
        $headings_exports = [];
        foreach ($data_body as $key => $row ){
            $temp = [];
            foreach ($data_headings as  $headings) {
                if($key == 0){
                    $headings_exports[] = $headings['title'];
                }
                $data_column = $headings['data'];
                $config_data = $row->$data_column;
                $temp[] = $config_data;
            }
            $body_exports[] = $temp;
        }
        //Định nghĩa lớp ẩn để sử dụng ngay trong hàm
        $export = new class($body_exports, $headings_exports) implements FromCollection, WithHeadings {
            protected $body_exports;
            protected $headings_exports;

            public function __construct($body_exports, $headings_exports) {
                $this->body_exports = collect($body_exports);
                $this->headings_exports = $headings_exports;
            }

            public function collection() {
                return $this->body_exports;
            }
            public function headings(): array {
                return $this->headings_exports;
            }

        };
        return Excel::download($export, 'danhsach.xlsx');
    }
    function hssv_pdf_danhsach($data_check,$idlop){
        $data_table = $this->hssv_data_danhsachssv($data_check,3);
        $tenlop = DB::table('24_lop')->where('id',$idlop)->first()->tenlop;
        $data = array(
            'data' => $data_table,
            'lop'=> $tenlop,
        );
        $pdf = PDF::loadView('pdf.DanhSachThuHoSoSinhVien', $data);
        $name_file = 'HSSV_'.$tenlop.'.pdf';
        return $pdf->stream($name_file);
    }

    //Thống kê hồ sơ sinh viên
    function tkhssv_thongke(){
        return view('user_24.admin24.manage.quanlynhaphoc.tkhssv_thongke',
            [
                'menu' =>  $this->sidebar()
            ]
        );
    }

    function tkhssv_data($data){
        $jsonData = json_decode(urldecode(base64_decode($data)), true);
        $khoahoc = $jsonData['hssv-khoahoc'];
        $arr_lop = DB::table('24_lop')
        ->where('idkhoas',$khoahoc)
        ->get();

        $arr_data = DB::table('24_nhanhoso')
        ->leftJoin('24_mssv', '24_mssv.id_taikhoan', '=', '24_nhanhoso.id_taikhoan')
        ->where('namts', 2024)
        ->select('id_hoso', 'id_lop', DB::raw('COUNT(*) as soluong'))
        ->groupBy('id_hoso', 'id_lop')
        ->get();

        $arr_danhmuc = DB::table('24_danhmuc_hoso')
        ->where('idnam',$khoahoc)
        ->get();

        foreach ($arr_lop as  $lop) {
            foreach ($arr_danhmuc as $hoso) {
                $tenhoso =  $hoso->text_hienthi;
                $dem = 0;
                foreach ($arr_data as $row) {
                    if($row->id_lop ==  $lop->id &&  $row->id_hoso == $hoso->id){
                        $lop->$tenhoso =  $row->soluong;
                        $dem++;
                        break;
                    }
                }
                if(  $dem == 0 ){
                    $lop->$tenhoso =  0;
                }
            }
        }
        return response()->json( $arr_lop);

        return $arr_lop;
    }

    function tkhssv_load_danhsach($data){
        $jsonData = json_decode(urldecode(base64_decode($data)), true);
        $khoahoc = $jsonData['hssv-khoahoc'];
        $arr_lop = DB::table('24_lop')
        ->where('idkhoas',$khoahoc)
        ->get();

        $arr_data = DB::table('24_nhanhoso')
        ->leftJoin('24_mssv', '24_mssv.id_taikhoan', '=', '24_nhanhoso.id_taikhoan')
        ->where('namts', 2024)
        ->select('id_hoso', 'id_lop', DB::raw('COUNT(*) as soluong'))
        ->groupBy('id_hoso', 'id_lop')
        ->get();

        $arr_danhmuc = DB::table('24_danhmuc_hoso')
        ->where('idnam',$khoahoc)
        ->get();

        foreach ($arr_lop as  $lop) {
            foreach ($arr_danhmuc as $hoso) {
                $tenhoso =  $hoso->text_hienthi;
                $dem = 0;
                foreach ($arr_data as $row) {
                    if($row->id_lop ==  $lop->id &&  $row->id_hoso == $hoso->id){
                        $lop->$tenhoso =  $row->soluong;
                        $dem++;
                        break;
                    }
                }
                if(  $dem == 0 ){
                    $lop->$tenhoso =  0;
                }
            }
        }
        return response()->json( $arr_lop);

        return $arr_lop;
    }




















    //Lịch sử
    function testtaolao() {
        Artisan::call('queue:work --once');
       dd(111111111);
    }
    //Quản lý đồng phục
    // QUẢN LÝ LOẠI
    function quanlyloai()
    {
        $url = URL::current();
        $quyen = $this->kiemtraquyen_url($url);
        if ($quyen == 1) {
            return view(
                'user_24.admin24.manage.quanlydongphuc.quanlyloai',
                [
                    'menu' =>    $this->sidebar(),
                    // 'table_data' => $this->tt_mail_sinhvien(),
                ]
            );
        } else {
            return view('user_24.admin24.include.404');
        }
    }
    function themloai (Request $request){
        $loaimoi = $request->input('loaimoi');
        $maloai = $request->input('maloai');
        $noidung = '';
        $id_chucnang = $request->input('id_chucnang');
        $id_manhinh = $request->input('id_manhinh');
        $time = $request->input('time');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            $validator = Validator::make( $request->all(),
                [
                    'loaimoi' => 'required|regex:/^[\p{L}\s0-9]+$/u|unique:24_loaisanpham,loai',
                    'maloai' => 'required|regex:/^[a-zA-Z0-9]{4}$/|unique:24_loaisanpham,maloai',
                ],
                [
                    'loaimoi.required'   => 'Vui lòng điền loại mới',
                    'loaimoi.regex' => 'Tên loại chỉ gồm chữ cái và chữ số',
                    'loaimoi.unique' => 'Tên loại đã tồn tại',

                    'maloai.regex'       => 'Mã loại không chứa ký tự đặc biệt và đủ 4 kí tự',
                    'maloai.required'    => 'Vui lòng nhập mã loai',
                    'maloai.unique' => 'Mã loại đã tồn tại',


                ]
            );
            if ($validator->fails()) {
                $trangthai = 'validate';
                $noidung = response()->json($validator->errors());
            }else{
                try {
                    $clean_loaimoi = Purifier::clean($loaimoi,'default');
                    $clean_maloai = Purifier::clean($maloai,'default');
                    if($this->check_clean($clean_loaimoi) == 1){
                        DB::table('24_loaisanpham')->insert([
                            'loai'=> $clean_loaimoi,
                            'maloai'=> $clean_maloai,
                        ]);
                        $trangthai = 'ins_1';
                        $noidung = "";
                    }else{
                        $trangthai = '-100';
                    }
                } catch (Exception $e) {
                    $trangthai = 'ins_0';
                    $noidung = "";
                }
            }
        }else{
            $trangthai = 'rol_2';
        }
        return array(
            'trangthai' => $trangthai,
            'noidung' => $noidung,
        );

    }
    function danhsachloai(){
        $ds_loai = DB::table('24_loaisanpham')
        ->select('id','maloai','loai','trangthai')->get();
        $data = $ds_loai->map(function ($item, $index) {
            $item->stt = $index + 1; // Thêm số thứ tự tự tăng, bắt đầu từ 1
            return $item;
        });
        $json_data['data'] = $data;
        $res = json_encode($json_data);
        return  $res;
    }
    function Upd_Loai (Request $request){
        $upd_loai = $request->input('upd_loai');
        $id = $request->input('id');
        $noidung = "";
        $id_chucnang = $request->input('id_chucnang');
        $id_manhinh = $request->input('id_manhinh');
        $time = $request->input('time');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            $validator = Validator::make( $request->all(),
                [
                    'upd_loai' => 'required|regex:/^[\p{L}\s0-9]+$/u|unique:24_loaisanpham,loai,'. $id,
                ],
                [
                    'upd_loai.required'   => 'Vui lòng điền loại mới',
                    'upd_loai.regex' => 'Tên loại chỉ gồm chữ cái và chữ số',
                    'upd_loai.unique' => 'Sản phẩm đã tồn tại',
                ]
            );
            if ($validator->fails()) {
                $trangthai = 'validate';
                $noidung = response()->json($validator->errors());
            }else{
                try {
                    $clean_upd_loai = Purifier::clean($upd_loai,'default');
                    $check_tontai = DB::table('24_danhmuc_sanpham')->where('id_loai', $id)->exists() ? 0 : 1;
                    if($this->check_clean($clean_upd_loai) == 1 && $check_tontai == 1){
                        $trangthai = DB::table('24_loaisanpham')->where('id',$id)->update(['loai'=>$clean_upd_loai]) > 0 ? 'upd_1' : 'upd_2';
                        // $trangthai = 'upd_1';
                    }else{
                        $trangthai = $check_tontai == 0 ? 'prod_0' : '-100';
                    }
                } catch (Exception $e) {
                    $trangthai = 'upd_0';
                }
            }
        }else{
            $trangthai = 'rol_2';
        }
        return array(
            'trangthai' => $trangthai,
            'noidung' => $noidung,
        );
    }
    public function change_TrangthaiLoai(Request $request)
    {
        $noidung = '';
        $trangthai = '';
        $id_chucnang = $request->input('id_chucnang');
        $id_manhinh = $request->input('id_manhinh');
        $time = $request->input('time');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        $noidung ='';
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            DB::beginTransaction();
            try{
                $trangthai= $request->input('trangthai');
                $id = $request->input('id');
                $trangthai_moi = $trangthai == 0 ? 1 : 0;

                $check = DB::table('24_loaisanpham')
                    ->where('id', $id)
                    ->update(['trangthai' => $trangthai_moi]);

                $trangthai = $check == 1? 'upd_1' : 'upd_0';
                DB::commit();
            }catch (Exception $e) {
                $trangthai = '-100';
                DB::rollBack();
            }
        }else{
            $trangthai = 'rol_2';
        }
        return response()->json([
            'trangthai' => $trangthai,
            'noidung'   => $noidung,
        ]);
    }
    function dlt_Loai($id,Request $request){
        $id_chucnang = $request->input('id_chucnang');
        $id_manhinh = $request->input('id_manhinh');
        $time = $request->input('time');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            $check_tontai = DB::table('24_danhmuc_sanpham')->where('id_loai',$id)->exists() ? 0 : 1;
            if($check_tontai == 1){
                $trangthai = DB::table('24_loaisanpham')->where('id', $id)->delete() == 1 ? 'del_1' : 'del_0';
            }else{
                $trangthai = $check_tontai == 0 ? 'prod_0' :  '-100';
            }
        }else{
            $trangthai = 'rol_2';
        }
        return $trangthai;
    }


     // QUẢN LÝ NHÀ SẢN XUẤT
    function quanlynhasanxuat()
    {
        $url = URL::current();
        $quyen = $this->kiemtraquyen_url($url);
        if ($quyen == 1) {
            return view(
                'user_24.admin24.manage.quanlydongphuc.quanlynhasanxuat',
                [
                    'menu' =>    $this->sidebar(),
                    // 'table_data' => $this->tt_mail_sinhvien(),
                ]
            );
        } else {
            return view('user_24.admin24.include.404');
        }
    }
    function danhsach_nhasanxuat(){
        $ds_loai = DB::table('24_danhmuc_nhasanxuat')
        ->select('id','mansx','nhasanxuat','diachi','sdt','trangthai')->get();
        $data = $ds_loai->map(function ($item, $index) {
            $item->stt = $index + 1; // Thêm số thứ tự tự tăng, bắt đầu từ 1
            return $item;
        });
        $json_data['data'] = $data;
        $res = json_encode($json_data);
        return  $res;
    }
    function themnhasanxuat (Request $request){
        $nhasanxuat_moi = $request->input('nhasanxuat_moi');
        $diachi_moi = $request->input('diachi_moi');
        $sdt_moi = $request->input('sdt_moi');
        $mansx = $request->input('mansx');
        $noidung = '';
        $id_chucnang = $request->input('id_chucnang');
        $id_manhinh = $request->input('id_manhinh');
        $time = $request->input('time');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            $validator = Validator::make( $request->all(),
                [
                    'nhasanxuat_moi' => 'required|regex:/^[\p{L}\s0-9]+$/u|unique:24_danhmuc_nhasanxuat,nhasanxuat',
                    'diachi_moi' => 'required|regex:/^[\p{L}\s0-9]+$/u',
                    'sdt_moi' => 'required|regex:/^0[0-9]{9}$/',
                    'mansx' => 'required|regex:/^[a-zA-Z0-9]{4}$/|unique:24_danhmuc_nhasanxuat,mansx',
                ],
                [
                    'nhasanxuat_moi.required'   => 'Vui lòng điền nhà sản xuất mới',
                    'nhasanxuat_moi.regex'      => 'Tên nhà sản xuất chỉ gồm chữ cái và chữ số',
                    'nhasanxuat_moi.unique'     => 'Nhà sản xuât đã tồn tại',

                    'diachi_moi.required'       => 'Vui lòng điền địa chỉ mới',
                    'diachi_moi.regex'          => 'Địa chỉ chỉ gồm chữ cái và chữ số',

                    'sdt_moi.required'          => 'Vui lòng điền SĐT mới',
                    'sdt_moi.regex'             => 'Số điện thoại gồm 10 số và bắt đầu bằng 0',

                    'mansx.regex'               => 'Mã NSX không chứa ký tự đặc biệt và đủ 4 kí tự',
                    'mansx.required'            => 'Vui lòng nhập mã NSX',
                    'mansx.unique'              => 'Mã NSX đã tồn tại',
                ]
            );
            if ($validator->fails()) {
                $trangthai = 'validate';
                $noidung = response()->json($validator->errors());
            }else{
                try {
                    $clean_nhasanxuat_moi = Purifier::clean($nhasanxuat_moi,'default');
                    $clean_diachi_moi = Purifier::clean($diachi_moi,'default');
                    $clean_sdt_moi = Purifier::clean($sdt_moi,'default');
                    $clean_mansx = Purifier::clean($mansx,'default');
                    if($this->check_clean($clean_nhasanxuat_moi) == 1 && $this->check_clean($clean_diachi_moi) == 1 && $this->check_clean($clean_sdt_moi) == 1){
                        DB::table('24_danhmuc_nhasanxuat')->insert([
                            'nhasanxuat'=> $clean_nhasanxuat_moi,
                            'diachi'=> $clean_diachi_moi,
                            'sdt'=> $clean_sdt_moi,
                            'mansx'=> $clean_mansx,
                        ]);
                        $trangthai = 'ins_1';
                        $noidung = "";
                    }else{
                        $trangthai = '-100';
                    }
                } catch (Exception $e) {
                    $trangthai = 'ins_0';
                    $noidung = "";
                }
            }
        }else{
            $trangthai = 'rol_2';
        }
        return array(
            'trangthai' => $trangthai,
            'noidung' => $noidung,
        );

    }
    function Upd_Nhasanxuat (Request $request){
        $upd_nhasanxuat = $request->input('upd_nhasanxuat');
        $upd_diachi = $request->input('upd_diachi');
        $upd_sdt = $request->input('upd_sdt');
        $id = $request->input('id');
        $noidung = "";
        $id_chucnang = $request->input('id_chucnang');
        $id_manhinh = $request->input('id_manhinh');
        $time = $request->input('time');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            $validator = Validator::make( $request->all(),
            [
                'upd_nhasanxuat' => 'required|regex:/^[\p{L}\s0-9]+$/u|unique:24_danhmuc_nhasanxuat,nhasanxuat,' . $id,
                'upd_diachi' => 'required|regex:/^[\p{L}\s0-9]+$/u',
                'upd_sdt' => 'required|regex:/^0[0-9]{9}$/',
            ],
            [
                'upd_nhasanxuat.required'   => 'Vui lòng điền nhà sản xuất mới',
                'upd_nhasanxuat.regex' => 'Tên nhà sản xuất chỉ gồm chữ cái và chữ số',
                'upd_nhasanxuat.unique' => 'Nhà sản xuât đã tồn tại',

                'upd_diachi.required'   => 'Vui lòng điền địa chỉ mới',
                'upd_diachi.regex' => 'Địa chỉ chỉ gồm chữ cái và chữ số',

                'upd_sdt.required'   => 'Vui lòng điền SĐT mới',
                'upd_sdt.regex' => 'Số điện thoại gồm 10 số và bắt đầu bằng 0',
            ]
            );
            if ($validator->fails()) {
                $trangthai = 'validate';
                $noidung = response()->json($validator->errors());
            }else{
                try {
                    $clean_upd_nhasanxuat = Purifier::clean($upd_nhasanxuat,'default');
                    $clean_upd_diachi = Purifier::clean($upd_diachi,'default');
                    $clean_upd_sdt = Purifier::clean($upd_sdt,'default');
                    $check_tontai = DB::table('24_danhmuc_sanpham')->where('id_nhasanxuat', $id)->exists() ? 0 : 1;
                    if($this->check_clean($clean_upd_nhasanxuat) == 1 && $this->check_clean($clean_upd_diachi) == 1 && $this->check_clean($clean_upd_sdt) == 1 && $check_tontai == 1){
                        $check = DB::table('24_danhmuc_nhasanxuat')
                        ->where('id', $id)
                        ->update([
                            'nhasanxuat' => $clean_upd_nhasanxuat,
                            'diachi' => $clean_upd_diachi,
                            'sdt' => $clean_upd_sdt
                        ]);
                        $trangthai = $check > 0 ? 'upd_1' : 'upd_0';
                    }else{
                        $trangthai = $check_tontai == 0 ? 'prod_0' : '-100';
                    }
                } catch (Exception $e) {
                    $trangthai = 'upd_0';
                }
            }
        }else{
            $trangthai = 'rol_2';
        }
        return array(
            'trangthai' => $trangthai,
            'noidung' => $noidung,
        );
    }
    public function change_TrangthaiNSX(Request $request)
    {
        $noidung = '';
        $trangthai = '';
        $id_chucnang = $request->input('id_chucnang');
        $id_manhinh = $request->input('id_manhinh');
        $time = $request->input('time');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        $noidung ='';
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            DB::beginTransaction();
            try{
                $trangthai= $request->input('trangthai');
                $id = $request->input('id');
                $trangthai_moi = $trangthai == 0 ? 1 : 0;
                $check = DB::table('24_danhmuc_nhasanxuat')
                    ->where('id', $id)
                    ->update(['trangthai' => $trangthai_moi]);
                $trangthai = $check == 1 ? 'upd_1' : 'upd_0';
                DB::commit();
            }catch(Exception $e){
                $trangthai = '-100';
                DB::rollBack();
            }
        }else{
            $trangthai = 'rol_2';
        }
        return response()->json([
            'trangthai' => $trangthai,
            'noidung'   => $noidung,
        ]);
    }
    function dlt_Nhasaxuat($id,Request $request){
        $id_chucnang = $request->input('id_chucnang');
        $id_manhinh = $request->input('id_manhinh');
        $time = $request->input('time');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            $check_tontai = DB::table('24_danhmuc_sanpham')->where('id_nhasanxuat',$id)->exists() ? 0 : 1;
            if($check_tontai == 1){
                $trangthai = DB::table('24_danhmuc_nhasanxuat')->where('id', $id)->delete() == 1 ? 'del_1' : 'del_0';
            }else{
                $trangthai = $check_tontai == 0 ? 'prod_0' :  '-100';
            }
        }else{
            $trangthai = 'rol_2';
        }
        return $trangthai;
    }

    // QUẢN LÝ SIZE
    function quanlysize()
    {
        $url = URL::current();
        $quyen = $this->kiemtraquyen_url($url);
        if ($quyen == 1) {
            return view(
                'user_24.admin24.manage.quanlydongphuc.quanlysize',
                [
                    'menu' =>    $this->sidebar(),
                ]
            );
        } else {
            return view('user_24.admin24.include.404');
        }
    }
    function themsize (Request $request){
        $sizemoi = $request->input('sizemoi');
        $masize = $request->input('masize');
        $noidung = '';
        $id_chucnang = $request->input('id_chucnang');
        $id_manhinh = $request->input('id_manhinh');
        $time = $request->input('time');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            $validator = Validator::make( $request->all(),
                [
                    'sizemoi' => 'required|regex:/^[\p{L}\s0-9]+$/u|unique:24_danhmuc_size,size',
                    'masize' => 'required|regex:/^[a-zA-Z0-9]{4}$/|unique:24_danhmuc_nhasanxuat,mansx',
                ],
                [
                    'sizemoi.required'   => 'Vui lòng điền size mới',
                    'sizemoi.regex' => 'Tên size chỉ gồm chữ cái và chữ số',
                    'sizemoi.unique' => 'Size đã tồn tại',

                    'masize.regex'               => 'Mã size không chứa ký tự đặc biệt và đủ 4 kí tự',
                    'masize.required'            => 'Vui lòng nhập mã size',
                    'masize.unique'              => 'Mã size đã tồn tại',
                ]
            );
            if ($validator->fails()) {
                $trangthai = 'validate';
                $noidung = response()->json($validator->errors());
            }else{
                try {
                    $clean_sizemoi = Purifier::clean($sizemoi,'default');
                    $clean_masize = Purifier::clean($masize,'default');
                    if($this->check_clean($clean_sizemoi) == 1){
                        DB::table('24_danhmuc_size')->insert([
                            'size'=> $clean_sizemoi,
                            'masize'=> $clean_masize,
                        ]);
                        $trangthai = 'ins_1';
                        $noidung = "";
                    }else{
                        $trangthai = '-100';
                    }
                } catch (Exception $e) {
                    $trangthai = 'ins_0';
                    $noidung = "";
                }
            }
        }else{
            $trangthai = 'rol_2';
        }
        return array(
            'trangthai' => $trangthai,
            'noidung' => $noidung,
        );

    }
    function danhsachsize(){
        $ds_loai = DB::table('24_danhmuc_size')
        ->select('id','masize','size','trangthai')->get();
        $data = $ds_loai->map(function ($item, $index) {
            $item->stt = $index + 1; // Thêm số thứ tự tự tăng, bắt đầu từ 1
            return $item;
        });
        $json_data['data'] = $data;
        $res = json_encode($json_data);
        return  $res;
    }
    function Upd_Size (Request $request){
        $upd_size = $request->input('upd_size');
        $id = $request->input('id');
        $noidung = "";
        $id_chucnang = $request->input('id_chucnang');
        $id_manhinh = $request->input('id_manhinh');
        $time = $request->input('time');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            $validator = Validator::make( $request->all(),
                [
                    'upd_size' => 'required|regex:/^[\p{L}\s0-9]+$/u|unique:24_danhmuc_size,size,'.$id,
                ],
                [
                    'upd_size.required'   => 'Vui lòng điền size mới',
                    'upd_size.regex' => 'Tên size chỉ gồm chữ cái và chữ số',
                    'upd_size.unique' => 'Size đã tồn tại',
                ]
            );
            if ($validator->fails()) {
                $trangthai = 'validate';
                $noidung = response()->json($validator->errors());
            }else{
                try {
                    $clean_upd_size = Purifier::clean($upd_size,'default');
                    $check_tontai = DB::table('24_danhmuc_sanpham')->where('id_size', $id)->exists() ? 0 : 1;
                    if($this->check_clean($clean_upd_size) == 1 && $check_tontai == 1){
                        DB::table('24_danhmuc_size')->where('id',$id)->update(['size'=>$clean_upd_size]);
                        $trangthai = 'upd_1';
                    }else{
                        $trangthai = $check_tontai == 0 ? 'prod_0' : '-100';
                    }
                } catch (Exception $e) {
                    $trangthai = 'upd_0';
                }
            }
        }else{
            $trangthai = 'rol_2';
        }
        return array(
            'trangthai' => $trangthai,
            'noidung' => $noidung,
        );
    }
    public function change_TrangthaiSize(Request $request)
    {
        $noidung = '';
        $trangthai = '';
        $id_chucnang = $request->input('id_chucnang');
        $id_manhinh = $request->input('id_manhinh');
        $time = $request->input('time');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        $noidung ='';
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            $trangthai= $request->input('trangthai');
            $id = $request->input('id');
            $trangthai_moi = $trangthai == 0 ? 1 : 0;
            $check = DB::table('24_danhmuc_size')
                ->where('id', $id)
                ->update(['trangthai' => $trangthai_moi]);
            $trangthai = $check == 1 ? 'upd_1' : 'upd_0';
        }else{
            $trangthai = 'rol_2';
        }
        return response()->json([
            'trangthai' => $trangthai,
            'noidung'   => $noidung,
        ]);
    }
    function dlt_Size($id,Request $request){
        $id_chucnang = $request->input('id_chucnang');
        $id_manhinh = $request->input('id_manhinh');
        $time = $request->input('time');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            $check_tontai = DB::table('24_danhmuc_sanpham')->where('id_size',$id)->exists() ? 0 : 1;
            if($check_tontai == 1){
                $trangthai = DB::table('24_danhmuc_size')->where('id', $id)->delete() > 0 ? 'del_1' : 'del_0';
            }else{
                $trangthai = $check_tontai == 0 ? 'prod_0' :  '-100';
            }
        }else{
            $trangthai = 'rol_2';
        }
        return $trangthai;
    }
    // QUẢN LÝ SẢN PHẨM
    function quanlysanpham()
    {
        $url = URL::current();
        $quyen = $this->kiemtraquyen_url($url);
        if ($quyen == 1) {
            return view(
                'user_24.admin24.manage.quanlydongphuc.quanlysanpham',
                [
                    'menu' =>    $this->sidebar(),
                    // 'table_data' => $this->tt_mail_sinhvien(),
                ]
            );
        } else {
            return view('user_24.admin24.include.404');
        }
    }
    function qlsp_loadds(){
        $chonnhasanxuat = new Collection(
            [
                'id' => 0,
                'text' => "Chọn nhà sản xuất",
                'code' => "Error",
                'selected' => true
            ]
        );
        $ds_nhasanxuat = DB::table('24_danhmuc_nhasanxuat')
        ->select('id','mansx as code', 'nhasanxuat as text')
        ->where('trangthai','=','1')
        ->orderBy('id', 'ASC')
        ->get();
        $ds_nhasanxuat[] =  $chonnhasanxuat;

        $chonloaisanpham = new Collection(
            [
                'id' => 0,
                'text' => "Chọn loại sản phẩm",
                'code' => "Error",
                'selected' => true
            ]
        );
        $ds_loaisanpham = DB::table('24_loaisanpham')
        ->select('id','maloai as code', 'loai as text')
        ->where('trangthai','=','1')
        ->orderBy('id', 'ASC')
        ->get();
        $ds_loaisanpham[] =  $chonloaisanpham;

        $chonsize = new Collection(
            [
                'id' => 0,
                'text' => "Chọn size",
                'code' => "Error",
                'selected' => true
            ]
        );
        $ds_size = DB::table('24_danhmuc_size')
        ->select('id','masize as code', 'size as text')
        ->where('trangthai','=','1')
        ->orderBy('id', 'ASC')
        ->get();
        $ds_size[] =  $chonsize;
        return array(
            'ds_nhasanxuat' => $ds_nhasanxuat,
            'ds_loai' => $ds_loaisanpham,
            'ds_size' => $ds_size,
        );
    }
    function load_dssanpham(){
        $ds_sanpham_dot = DB::table('24_danhmuc_sanpham')
        ->select('24_danhmuc_sanpham.id as id','24_danhmuc_sanpham.masp as masp','24_accountsadmin.dienthoai as dienthoai','24_danhmuc_sanpham.qrcode as qrcode','24_danhmuc_sanpham.ghichu as ghichu','24_danhmuc_sanpham.create_at as create_at','24_loaisanpham.loai as loai','24_loaisanpham.id as idloai','24_loaisanpham.id as id_loai','24_danhmuc_nhasanxuat.nhasanxuat as nhasanxuat','24_danhmuc_nhasanxuat.id as id_nhasanxuat','24_danhmuc_nhasanxuat.id as id_nhasanxuat','24_danhmuc_size.size as size','24_danhmuc_size.id as id_size','24_danhmuc_size.id as id_size', '24_danhmuc_sanpham.thongso as thongso','24_danhmuc_sanpham.trangthai as trangthai','24_danhmuc_sanpham.anhsanpham as anhsanpham')
        ->join('24_loaisanpham','24_loaisanpham.id','=','24_danhmuc_sanpham.id_loai')
        ->join('24_danhmuc_size','24_danhmuc_size.id','=','24_danhmuc_sanpham.id_size')
        ->join('24_danhmuc_nhasanxuat','24_danhmuc_nhasanxuat.id','=','24_danhmuc_sanpham.id_nhasanxuat')
        ->join('24_accountsadmin','24_accountsadmin.id','=','24_danhmuc_sanpham.id_admin')
        ->orderBy('24_loaisanpham.id')
        ->orderBy('24_danhmuc_nhasanxuat.id')
        ->orderBy('24_danhmuc_size.id')
        ->get();
        $data = $ds_sanpham_dot->map(function ($item, $index) {
            $item->stt = $index + 1;
            return $item;
        });
        $data = $ds_sanpham_dot->map(function ($item) {
            $item->loaiSanpham = DB::table('24_loaisanpham')->select('id','maloai as code','loai as loaisanpham')->where('trangthai',1)->get();
            return $item;
        });
        $data = $ds_sanpham_dot->map(function ($item) {
            $item->All_Nhasanxuat = DB::table('24_danhmuc_nhasanxuat')->select('id','mansx as code','nhasanxuat as nhasanxuat')->where('trangthai',1)->get();
            return $item;
        });
        $data = $ds_sanpham_dot->map(function ($item) {
            $item->All_Size = DB::table('24_danhmuc_size')->select('id','masize as code','size as size')->where('trangthai',1)->get();
            return $item;
        });
        $json_data['data'] = $data;
        $res = json_encode($json_data);
        echo  $res;

    }
    function themsanpham(Request $request){
        $id_nhasanxuat =(int)$request->input('id_nhasanxuat');
        $id_loai =(int)$request->input('id_loai');
        $id_size =(int)$request->input('id_size');
        $ma_nhasanxuat =$request->input('ma_nhasanxuat');
        $ma_loai =$request->input('ma_loai');
        $ma_size =$request->input('ma_size');
        $anhsanpham =$request->input('file_anhsp');
        $thongso =$request->input('thongso');
        $ghichu =$request->input('ghichu');
        // $base64QRCode =$request->input('qr_code_base64');
        $id_moi=-1;
        $noidung = '';
        $code_QR = '';
        $base64QRCode = '';
        $id_chucnang = $request->input('id_chucnang');
        $id_manhinh = $request->input('id_manhinh');
        $time = $request->input('time');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            $validator = Validator::make( $request->all(),
                [

                    'id_size'       => 'required|numeric|min:1',
                    'id_nhasanxuat' => 'required|numeric|min:1',
                    'id_loai'       => 'required|numeric|min:1',
                    'thongso'  => 'required|regex:/^[\p{L}\s0-9]+$/u',
                    'ghichu'  => 'nullable|regex:/^[\p{L}\s0-9]+$/u',
                ],
                [
                    'id_nhasanxuat.required'   => 'Vui lòng chọn nhà sản xuất',
                    'id_nhasanxuat.numeric'    => 'Hệ thống bị lỗi vui lòng thử lại sau',
                    'id_nhasanxuat.min'        => 'Vui lòng chọn nhà sản xuất',

                    'id_loai.required'   => 'Vui lòng chọn loại sản phẩm',
                    'id_loai.numeric'    => 'Hệ thống bị lỗi vui lòng thử lại sau',
                    'id_loai.min'        => 'Vui lòng chọn loại sản phẩm',

                    'id_size.required'   => 'Vui lòng chọn size',
                    'id_size.numeric'    => 'Hệ thống bị lỗi vui lòng thử lại sau',
                    'id_size.min'        => 'Vui lòng chọn size',

                    'thongso.required'    => 'Vui lòng nhập thông số',
                    'thongso.regex'       => 'Thông số không chứa ký tự đặc biệt',

                    'ghichu.regex'       => 'Thông số không chứa ký tự đặc biệt',



                ]
            );
            if ($validator->fails()) {
                $trangthai = 'validate';
                $noidung = response()->json($validator->errors());
            }else{
                DB::beginTransaction();
                try{
                    $clean_ghichu= Purifier::clean($ghichu,'default');
                    $clean_thongso= Purifier::clean($thongso,'default');
                    if($this->check_clean($clean_thongso) == 1){
                        $check_sanpham = DB::table('24_danhmuc_sanpham')
                        ->where('id_size', $id_size)
                        ->where('id_nhasanxuat', $id_nhasanxuat)
                        ->where('id_loai', $id_loai)
                        ->exists();
                        if($check_sanpham){
                            $trangthai = 'newproduct_0';
                        }else{
                                $id_moi = DB::table('24_danhmuc_sanpham')
                                ->insertGetId([
                                    'id_nhasanxuat' => $id_nhasanxuat,
                                    'id_loai' => $id_loai,
                                    'id_size' => $id_size,
                                    'thongso' => $clean_thongso,
                                    'ghichu' => $clean_ghichu,
                                    'id_admin' => $id_admin,
                                    'anhsanpham' => $anhsanpham,
                                ]);

                                // $code_QR = $ma_loai . '.' . $ma_nhasanxuat . '.' . $ma_size. '.' . $id_moi;
                                // $QRcode = QrCode::format('png')
                                //     ->merge(public_path('img/CTUT_logo_nen.png'), 0.3, true)
                                //     ->size(400) // Kích thước mã QR
                                //     ->margin(0) // Độ margin
                                //     ->errorCorrection('H') // Tăng cường khả năng sửa lỗi
                                //     ->generate($code_QR); // Nội dung mã QR
                                // $base64QRCode = base64_encode($QRcode);
                                DB::table('24_danhmuc_sanpham')
                                ->where('id', $id_moi)
                                ->update([
                                    'masp' => $code_QR,
                                    'qrcode' => $base64QRCode,
                                ]);
                            DB::commit();
                            $trangthai = 'ins_1';
                        }
                    }else{
                        $trangthai = '-100';
                    }
                }catch(Exception $e){
                    $trangthai = '-100';
                    DB::rollBack();
                }
            }
        }else{
            $trangthai = 'rol_2';
        }
        return array(
            'trangthai'=> $trangthai,
            'noidung'=> $noidung,
            'id_moi'=>$id_moi
        );
    }
    function themsanpham_qrcode(Request $request){
        $qrcode_base64 = $request->input('qrCode');
        $id_moi = $request->input('idMoi');
        $data = $request->input('data');
        $id_chucnang = $request->input('id_chucnang');

        DB::beginTransaction();
        try{
            $check_upd = DB::table('24_danhmuc_sanpham')
            ->where('id', $id_moi)
            ->update([
                'masp' => $data,
                'qrcode' => $qrcode_base64,
            ]);
            DB::commit();
            $trangthai = 'ins_1';
            if($check_upd <= 0 && $id_chucnang == 3){
                DB::table('24_danhmuc_sanpham')->where('id' , $id_moi)->delete();
            }
        }catch(Exception $e){
            $trangthai = '-100';
            DB::rollBack();
        }
        return response()->json([
            'trangthai' => $trangthai,
            'qrcode' => $qrcode_base64,
            'message' => $trangthai == 'ins_1' ? 'Sản phẩm được thêm thành công!' : 'Có lỗi xảy ra khi thêm sản phẩm!'
        ]);
    }
    function change_TrangthaiSP(Request $request){
        $noidung = "";
        $id = $request->input('id');
        $id_chucnang = $request->input('id_chucnang');
        $id_manhinh = $request->input('id_manhinh');
        $time = $request->input('time');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            DB::beginTransaction();
            try{
                $trangthai_moi = $request->input('trangthai') == 1 ? 0 : 1;
                $check = DB::table('24_danhmuc_sanpham')->where('id',$id)->update(['trangthai'=>$trangthai_moi]);
                $trangthai = $check == 1 ? 'upd_1' : 'upd_0';
                DB::commit();
            }catch(Exception $e){
                $trangthai = '-100';
                DB::rollBack();
            }
        }else{
            $trangthai = 'rol_2';
        }
        return array(
            'trangthai'=> $trangthai,
            'noidung'=> $noidung
        );
    }
    function update_Sanpham(Request $request){
        $id = $request->input('id');
        $idloai_upd = $request->input('idloai_upd');
        $idnhasanxuat_upd = $request->input('idnhasanxuat_upd');
        $idsize_upd = $request->input('idsize_upd');
        $ma_loai_up = $request->input('ma_loai_up');
        $ma_size_up = $request->input('ma_size_up');
        $ma_nhasanxuat_up = $request->input('ma_nhasanxuat_up');
        $base64QRCode =  $request->input('base64QRCode');
        $code_QR = $request->input('code_QR');
        $noidung = '';
        $id_chucnang = $request->input('id_chucnang');
        $id_manhinh = $request->input('id_manhinh');
        $time = $request->input('time');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            // try{
                $check_hopdong = DB::table('24_dotnhap_sanpham')->where('id_sanpham',$id)->exists() ? 0 : 1;
                $check_tontai = DB::table('24_danhmuc_sanpham')->where([['id_loai', $idloai_upd],['id_nhasanxuat', $idnhasanxuat_upd],['id_size', $idsize_upd]])->exists() ? 0 : 1;
                if($check_hopdong == 1 && $check_tontai == 1){
                    $trangthai = DB::table('24_danhmuc_sanpham')->where('id', $id)->update(['id_nhasanxuat' => $idnhasanxuat_upd,'id_loai' => $idloai_upd,'id_size' => $idsize_upd,'masp' => $code_QR,'qrcode' => $base64QRCode]) > 0 ? 'upd_1' : 'upd_0';
                }else{
                    $trangthai = $check_tontai == 0 ? 'prod_2' :  'prod_0';
                }
            // }catch(Exception $e){
            //     $trangthai = '-100';
            // }
        }else{
            $trangthai = 'rol_2';
        }
        return array(
            'trangthai' => $trangthai,
            'noidung' => $noidung,
        );

    }
    function update_Sanpham_etc(Request $request){
        $id = $request->input('id');
        $thongso_upd = $request->input('thongso_upd');
        $ghichu_upd = $request->input('ghichu_upd');
        $noidung = '';
        $id_chucnang = $request->input('id_chucnang');
        $id_manhinh = $request->input('id_manhinh');
        $time = $request->input('time');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            $validator = Validator::make( $request->all(),
                [
                    'thongso_upd'  => 'required|regex:/^[\p{L}\s0-9]+$/u',
                    'ghichu'  => 'nullable|regex:/^[\p{L}\s0-9]+$/u',

                ],
                [
                    'thongso_upd.required'    => 'Vui lòng nhập thông số',
                    'thongso_upd.regex'       => 'Thông số không chứa ký tự đặc biệt',

                    'ghichu_upd.regex'       => 'Ghi chú không chứa ký tự đặc biệt',
                ]
            );
            if ($validator->fails()) {
                $trangthai = 'validate';
                $noidung = response()->json($validator->errors());
            }else{
                $clean_thongso_upd= Purifier::clean($thongso_upd,'default');
                $clean_ghichu_upd= Purifier::clean($ghichu_upd,'default');
                if($this->check_clean($clean_thongso_upd) == 1){
                    try{
                        $check_hopdong = DB::table('24_dotnhap_sanpham')->where('id_sanpham',$id)->exists() ? 0 : 1;
                        if($check_hopdong == 1){
                            $trangthai = DB::table('24_danhmuc_sanpham')->where('id',$id)->update(['thongso'=>$clean_thongso_upd, 'ghichu' =>$clean_ghichu_upd])> 0 ? 'upd_1' : 'upd_0';
                        }else{
                            $trangthai = $check_hopdong == 0 ? 'prod_0' :  '-100';
                        }
                    }catch(Exception $e){
                        $trangthai = '-100';
                    }
                }else{
                    $trangthai = '-100';
                }
            }
        }else{
            $trangthai = 'rol_2';
        }
        return array(
            'trangthai' => $trangthai,
            'noidung' => $noidung,
        );

    }
    function update_Anhsanpham(Request $request){
        $id = $request->input('id');
        $file_anhsp = $request->input('file_anhsp');
        $noidung = '';
        $id_chucnang = $request->input('id_chucnang');
        $id_manhinh = $request->input('id_manhinh');
        $time = $request->input('time');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            try{
                $check_hopdong = DB::table('24_dotnhap_sanpham')->where('id_sanpham',$id)->exists() ? 0 : 1;
                if($check_hopdong == 1){
                    $trangthai = DB::table('24_danhmuc_sanpham')->where('id',$id)->update(['anhsanpham'=>$file_anhsp])> 0 ? 'upd_1' : 'upd_0';
                }else{
                    $trangthai = $check_hopdong == 0 ? 'prod_0' :  '-100';
                }
            }catch(Exception $e){
                $trangthai = '-100';
            }
        }else{
            $trangthai = 'rol_2';
        }
        return array(
            'trangthai' => $trangthai,
            'noidung' => $noidung,
        );

    }
    function btn_edit_sanpham(Request $request){
        $id = $request->input('id');
        $ds_sanpham_dot = DB::table('24_danhmuc_sanpham')
        ->select('24_danhmuc_sanpham.id as id','24_danhmuc_sanpham.masp as masp','24_accountsadmin.dienthoai as dienthoai','24_danhmuc_sanpham.qrcode as qrcode','24_danhmuc_sanpham.ghichu as ghichu','24_danhmuc_sanpham.create_at as create_at','24_loaisanpham.loai as loai','24_loaisanpham.id as idloai','24_loaisanpham.id as id_loai','24_danhmuc_nhasanxuat.nhasanxuat as nhasanxuat','24_danhmuc_nhasanxuat.id as id_nhasanxuat','24_danhmuc_nhasanxuat.id as id_nhasanxuat','24_danhmuc_size.size as size','24_danhmuc_size.id as id_size','24_danhmuc_size.id as id_size', '24_danhmuc_sanpham.thongso as thongso','24_danhmuc_sanpham.trangthai as trangthai')
        ->join('24_loaisanpham','24_loaisanpham.id','=','24_danhmuc_sanpham.id_loai')
        ->where('24_danhmuc_sanpham.id',$id)
        ->join('24_danhmuc_size','24_danhmuc_size.id','=','24_danhmuc_sanpham.id_size')
        ->join('24_danhmuc_nhasanxuat','24_danhmuc_nhasanxuat.id','=','24_danhmuc_sanpham.id_nhasanxuat')
        ->join('24_accountsadmin','24_accountsadmin.id','=','24_danhmuc_sanpham.id_admin')
        ->orderBy('24_danhmuc_sanpham.id')
        ->get();
        $data = $ds_sanpham_dot->map(function ($item, $index) {
            $item->stt = $index + 1; // Thêm số thứ tự tự tăng, bắt đầu từ 1
            return $item;
        });
        $data = $ds_sanpham_dot->map(function ($item) {
            $item->loaiSanpham = DB::table('24_loaisanpham')->select('id','maloai as code','loai as loaisanpham')->where('trangthai',1)->get();
            return $item;
        });
        $data = $ds_sanpham_dot->map(function ($item) {
            $item->All_Nhasanxuat = DB::table('24_danhmuc_nhasanxuat')->select('id','mansx as code','nhasanxuat as nhasanxuat')->where('trangthai',1)->get();
            return $item;
        });
        $data = $ds_sanpham_dot->map(function ($item) {
            $item->All_Size = DB::table('24_danhmuc_size')->select('id','masize as code','size as size')->where('trangthai',1)->get();
            return $item;
        });
        return $ds_sanpham_dot;
    }
    function dlt_SP($id,Request $request){
        $id_chucnang = $request->input('id_chucnang');
        $id_manhinh = $request->input('id_manhinh');
        $time = $request->input('time');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            $check_nhap = DB::table('24_dotnhap_sanpham')->where('id_sanpham',$id)->exists() ? 0 : 1;
            $check_kho = DB::table('24_kho')->where('idsanpham',$id)->exists() ? 0 : 1;
            $check_trangthai = DB::table('24_danhmuc_sanpham')->where('id', $id)->first()->trangthai == 1 ? 0 : 1;
            if($check_nhap == 1 && $check_kho == 1 && $check_trangthai == 1){
                $trangthai = DB::table('24_danhmuc_sanpham')->where('id', $id)->delete() == 1 ? 'del_1' : 'del_0';
            }else{
                $trangthai = $check_trangthai == 0 ? 'prod_1' :  'prod_0';
            }
        }else{
            $trangthai = 'rol_2';
        }
        return $trangthai;
    }
     // NHẬP SẢN PHẨM
    // Kiểm tra dữ liệu sau khi lọc
    function check_clean($data){
        if($data == ''){
            $trangthai = 0;
        }else{
            $trangthai = 1;
        }
        return $trangthai;
    }
    function nhapdongphuc()
    {
        $url = URL::current();
        $quyen = $this->kiemtraquyen_url($url);
        if ($quyen == 1) {
            return view(
                'user_24.admin24.manage.quanlydongphuc.nhapdongphuc',
                [
                    'menu' =>    $this->sidebar(),
                ]
            );
        } else {
            return view('user_24.admin24.include.404');
        }
    }
    function quanlynhap()
    {
        $url = URL::current();
        $quyen = $this->kiemtraquyen_url($url);
        if ($quyen == 1) {
                return view(
                    'user_24.admin24.manage.quanlydongphuc.quanlynhap',
                    [
                        'menu' =>    $this->sidebar(),
                    ]
                );
        } else {
            return view('user_24.admin24.include.404');
        }
    }
    // Danh sách đợt nhập
    function ds_dotnhap(){
        $chondot = new Collection(
            [
                'id' => 0,
                'text' => "Chọn đợt",
                'selected' => true
            ]
        );
        $load_sanpham_dotnhap = DB::table('24_dotnhap')
        ->select('id', 'dotnhap as text')
        ->where('trangthai', 1)
        ->orderBy('id', 'ASC')
        ->get();
        $load_sanpham_dotnhap[] =  $chondot;
        return array(
            'load_sanpham_dotnhap'=> $load_sanpham_dotnhap,
        );
    }
    function load_dssanpham_dot($id_dotnhap) {
        $ds_sanpham_dot = DB::table('24_dotnhap_sanpham')
        ->select(
            '24_dotnhap_sanpham.id as id',
            '24_dotnhap_sanpham.id_sanpham as id_sanpham',
            '24_dotnhap_sanpham.id_dotnhap as id_dotnhap',
            '24_loaisanpham.loai as loai',
            '24_danhmuc_size.size as size',
            '24_dotnhap_sanpham.soluong as soluongyeucau',
            '24_danhmuc_nhasanxuat.nhasanxuat as nhasanxuat',
            DB::raw('COALESCE(SUM(24_kiemtranhap.soluongnhap), 0) as soluongnhap'),
            DB::raw('COALESCE(MAX(24_kiemtranhap.ngaynhap), 0) as ngaynhap'),
            '24_danhmuc_sanpham.thongso as thongso'
        )
        ->where('24_dotnhap_sanpham.id_dotnhap', '=', $id_dotnhap)
        ->leftJoin('24_kiemtranhap', '24_kiemtranhap.id_dot_sanpham', '=', '24_dotnhap_sanpham.id')
        ->join('24_danhmuc_sanpham', '24_danhmuc_sanpham.id', '=', '24_dotnhap_sanpham.id_sanpham')
        ->join('24_loaisanpham', '24_loaisanpham.id', '=', '24_danhmuc_sanpham.id_loai')
        ->join('24_danhmuc_size', '24_danhmuc_size.id', '=', '24_danhmuc_sanpham.id_size')
        ->join('24_danhmuc_nhasanxuat', '24_danhmuc_nhasanxuat.id', '=', '24_danhmuc_sanpham.id_nhasanxuat')
        ->groupBy(
            '24_dotnhap_sanpham.id',
            '24_dotnhap_sanpham.id_sanpham',
            '24_dotnhap_sanpham.id_dotnhap',
            '24_loaisanpham.loai',
            '24_danhmuc_size.size',
            '24_danhmuc_nhasanxuat.nhasanxuat',
            '24_danhmuc_sanpham.thongso'
        )
        ->orderBy('24_loaisanpham.id')
        ->orderBy('24_danhmuc_nhasanxuat.id')
        ->orderBy('24_danhmuc_size.id')
        ->get();
        $data = $ds_sanpham_dot->map(function ($item, $index) {
        $item->stt = $index + 1; // Thêm số thứ tự tự tăng, bắt đầu từ 1
            return $item;
        });
        $json_data['data'] = $data;
        $res = json_encode($json_data);
        return  $res;
    }
    function change_nhapsanpham(Request $request){
        $id_nhaphang = $request->input('id_nhaphang');
        $id_dot = $request->input('id_dot');
        $soluongnhap_moi = $request->input('soluong_moi');
        $id_sanpham = $request->input('id_sanpham');
        $noidung = '';
        $dot_mo = 1;
        $id_chucnang = $request->input('id_chucnang');
        $id_manhinh = $request->input('id_manhinh');
        $time = $request->input('time');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            $validator = Validator::make( $request->all(),
                [
                    'soluong_moi' => 'required|integer|min:1',
                ],
                [
                    'soluong_moi.required'   => 'Vui lòng nhập số lượng',
                    'soluong_moi.integer'    => 'Số lượng phải là số nguyên',
                    'soluong_moi.min'        => 'Số lượng phải lớn hơn 0',
                ]
            );
            if ($validator->fails()) {
                $trangthai = 'validate';
                $noidung = response()->json($validator->errors());
            }else{
                try {
                    DB::beginTransaction();
                    $check_dot = DB::table('24_dotnhap')
                                ->select('trangthai')
                                ->where('id', $id_dot)
                                ->value('trangthai');
                    if($check_dot == $dot_mo){
                        $check_soluongdanhap = DB::table('24_kiemtranhap')
                            ->where('id_dot_sanpham', $id_nhaphang)
                            ->sum('soluongnhap');
                        $soluongkiemtranhap = $check_soluongdanhap + $soluongnhap_moi;
                        $soluongcannhap = DB::table('24_dotnhap_sanpham')->where('id', $id_nhaphang)->first()->soluong;
                        if( $soluongkiemtranhap <= $soluongcannhap){
                            DB::table('24_kiemtranhap')
                                ->insert([
                                    'id_dot_sanpham'    => $id_nhaphang,
                                    'soluongnhap'       => $soluongnhap_moi,
                                    'id_admin'          => Auth::guard('loginadmin')->user()->id,
                                    'ngaynhap'          => Carbon::now(),
                                ]);
                            $soluongton = DB::table('24_kho')
                                        ->where([
                                            'id_dotnhap' =>$id_dot,
                                            'idsanpham' =>$id_sanpham,
                                        ])->value('soluongton');
                            $soluongnhapkho = $soluongton + $soluongnhap_moi;
                            DB::table('24_kho')->updateOrInsert(
                                [
                                    'id_dotnhap' =>$id_dot,
                                    'idsanpham' =>$id_sanpham,
                                ],
                                [
                                    'soluongton' => $soluongnhapkho,
                                ]
                            );
                            DB::commit();
                            $trangthai = 'ins_1';
                        }else{
                            DB::rollBack();
                            $trangthai = 'checksl_0';
                        }
                    }else{
                        $trangthai = 'dot_0';
                    }
                }catch(Exception $e){
                    $trangthai = 'ins_0';
                    DB::rollBack();
                }
            }
        }else{
            $trangthai = "rol_2";
        }
        return array(
            'trangthai'=> $trangthai,
            'noidung'=> $noidung,
        );
    }
    function load_sanpham_quanlynhap($id_dotnhap){
        $ds_sanpham_dot = DB::table('24_kiemtranhap')
        ->select(
            '24_kiemtranhap.id as id',

            '24_kiemtranhap.soluongnhap as soluongnhap',

            '24_kiemtranhap.id_dot_sanpham as id_dot_sanpham',

            '24_dotnhap_sanpham.id_sanpham as id_sanpham',

            '24_dotnhap_sanpham.id_dotnhap as id_dotnhap',

            '24_loaisanpham.loai as loai',

            '24_danhmuc_size.size as size',

            '24_danhmuc_nhasanxuat.nhasanxuat as nhasanxuat',

            '24_kiemtranhap.ngaynhap as ngaynhap',

            '24_danhmuc_sanpham.thongso as thongso',

            '24_danhmuc_sanpham.masp as masp',

            '24_accountsadmin.dienthoai as dienthoai'
        )
        ->where('24_dotnhap_sanpham.id_dotnhap', '=', $id_dotnhap)

        ->join('24_dotnhap_sanpham','24_dotnhap_sanpham.id', '=', '24_kiemtranhap.id_dot_sanpham' )

        ->join('24_danhmuc_sanpham', '24_danhmuc_sanpham.id', '=', '24_dotnhap_sanpham.id_sanpham')
        ->join('24_loaisanpham', '24_loaisanpham.id', '=', '24_danhmuc_sanpham.id_loai')
        ->join('24_danhmuc_size', '24_danhmuc_size.id', '=', '24_danhmuc_sanpham.id_size')
        ->join('24_danhmuc_nhasanxuat', '24_danhmuc_nhasanxuat.id', '=', '24_danhmuc_sanpham.id_nhasanxuat')
        ->join('24_accountsadmin', '24_accountsadmin.id', '=', '24_kiemtranhap.id_admin')

        ->orderBy('24_loaisanpham.id')
        ->orderBy('24_danhmuc_nhasanxuat.id')
        ->orderBy('24_danhmuc_size.id')
        ->get();
        $data = $ds_sanpham_dot->map(function ($item, $index) {
            $item->stt = $index + 1; // Thêm số thứ tự tự tăng, bắt đầu từ 1
            return $item;
        });
        $json_data['data'] = $data;
        $res = json_encode($json_data);
        return  $res;
    }
    // Cập nhật số lượng nhập của sản phẩm theo đợt
    function capnhat_soluongnhap(Request $request) {
        $id_kiemtra = $request->input('id_kiemtra');
        $id_dot_sanpham = $request->input('id_dot_sanpham');
        $id_sanpham = $request->input('id_sanpham');
        $soluongnhap_cu = $request->input('soluongnhap_cu');
        $id_dot = $request->input('id_dot');
        $soluong_moi = $request->input('soluong_moi');
        $noidung = '';
        $dot_mo = 1;
        $id_chucnang = $request->input('id_chucnang');
        $id_manhinh = $request->input('id_manhinh');
        $time = $request->input('time');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            $validator = Validator::make( $request->all(),
                [
                    'soluong_moi' => 'required|integer|min:1',
                ],
                [
                    'soluong_moi.required'   => 'Vui lòng nhập số lượng mới',
                    'soluong_moi.integer'    => 'Số lượng mới phải là số nguyên',
                    'soluong_moi.min'        => 'Số lượng mới phải lớn hơn 0',

                ]
            );
            if ($validator->fails()) {
                $trangthai = 'validate';
                $noidung = response()->json($validator->errors());
            }else{
                    DB::beginTransaction();
                    try {
                    $check_dot = DB::table('24_dotnhap')
                                ->select('trangthai')
                                ->where('id', $id_dot)
                                ->value('trangthai');
                    if($check_dot == $dot_mo){
                        if ($soluong_moi != $soluongnhap_cu){
                            $soluongton_cu = DB::table('24_kho')
                            ->where('idsanpham','=', $id_sanpham)
                            ->where('id_dotnhap','=', $id_dot)
                            ->value('soluongton');
                            $soluongcannhap = DB::table('24_dotnhap_sanpham')->where('id', $id_dot_sanpham)->first()->soluong;
                            $val_soluong = $soluong_moi - $soluongnhap_cu;
                            $soluongton_moi = $soluongton_cu + $val_soluong;
                            if($val_soluong + $soluongton_cu <= $soluongcannhap){
                                $check_updatekiemtra = DB::table('24_kiemtranhap')
                                    ->where([
                                        'id'=> $id_kiemtra,
                                        'id_dot_sanpham'=> $id_dot_sanpham,
                                    ])
                                    ->update([
                                        'soluongnhap'    => $soluong_moi
                                    ]);
                                $check_updatesanphamnhap =DB::table('24_kho')
                                    ->where('idsanpham', $id_sanpham)
                                    ->update([
                                        'soluongton'    => $soluongton_moi
                                    ]);
                                if($check_updatekiemtra && $check_updatesanphamnhap){
                                    DB::commit();
                                    $trangthai = 'ins_1';
                                }else{
                                    DB::rollBack();
                                    $trangthai = 'ins_0';
                                }
                            }else{
                                DB::rollBack();
                                $trangthai = 'checksl_0';
                            }

                        }else{
                            $trangthai = 'ins_-1';
                        }
                    }else{
                        $trangthai = 'dot_0';
                    }
                }catch(Exception $e){
                    $trangthai = '-100';
                    DB::rollBack();
                }

            }
        }else{
            $trangthai = 'rol_2';
        }
        return array(
            'trangthai'=> $trangthai,
            'noidung'=> $noidung,
        );
    }
    function delete_sanphamnhap(Request $request) {
        $id_dot = $request->input('id_dot');
        $id_kiemtra = $request->input('id_kiemtra');
        $id_dot_sanpham = $request->input('id_dot_sanpham');
        $id_sanpham = $request->input('id_sanpham');
        $soluong_xoa = $request->input('soluong_xoa');
        $noidung = '';
        $dot_mo = 1;
        $id_chucnang = $request->input('id_chucnang');
        $id_manhinh = $request->input('id_manhinh');
        $time = $request->input('time');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            try {
                $check_dot = DB::table('24_dotnhap')
                ->select('trangthai')
                ->where('id', $id_dot)
                ->value('trangthai');
                if($check_dot == $dot_mo){
                    DB::beginTransaction();
                    $check_soluongton = DB::table('24_kho')
                                            ->where([
                                                'id_dotnhap'=> $id_dot,
                                                'idsanpham'=> $id_sanpham,
                                            ])->value('soluongton');
                        $soluongton_moi = (int)$check_soluongton - (int)$soluong_xoa;
                        if($soluongton_moi > 0){
                            $capnhat_soluongton = DB::table('24_kho')
                                                ->where([
                                                    'idsanpham'=> $id_sanpham,
                                                    'id_dotnhap'=> $id_dot,
                                                ])
                                                ->update([
                                                    'soluongton'=> $soluongton_moi
                                                ]);
                        }else{
                            $capnhat_soluongton = DB::table('24_kho')
                                            ->where([
                                                'id_dotnhap'=> $id_dot,
                                                'idsanpham'=> $id_sanpham,
                                            ])->delete();
                        }
                    $check = DB::table('24_kiemtranhap')
                        ->where([
                            'id'    => $id_kiemtra,
                            'id_dot_sanpham'    => $id_dot_sanpham
                        ])->delete();
                    if($check && $capnhat_soluongton){
                        DB::commit();
                        $trangthai = 'del_1';
                    }else{
                        DB::rollBack();
                        $trangthai = 'del_0';
                    }
                }else{
                    $trangthai = 'dot_0';
                }

            }catch(Exception $e){
                $trangthai = '-100';
                DB::rollBack();
            }
        }else{
            $trangthai = "rol_2";
        }
        return array(
            'trangthai'=> $trangthai,
            'noidung'=> $noidung
        );
    }
    // Xuất danh sách
    function btt_xuatexcel_ql_sanphamnhap(Request $request){
        $id_dot = $request->input('id_dotnhap');
        $noidung = "";
        $validator = Validator::make( $request->all(),
            [
                'id_dotnhap' => 'required|numeric|min:1',
            ],
            [
                'id_dotnhap.required'   => 'Vui lòng chọn đợt',
                'id_dotnhap.numeric'    => 'Hệ thống bị lỗi vui lòng thử lại sau',
                'id_dotnhap.min'        => 'Vui lòng chọn đợt',
            ]
        );
        if ($validator->fails()) {
            $trangthai = 'validate';
            $noidung = response()->json($validator->errors());
        }else{
            $trangthai = 'excel_1';
        }
        return array(
            'trangthai' => $trangthai,
            'noidung'   =>$noidung
        );
    }
    function xuatexcel_ql_sanphamnhap($id_dotnhap){
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $title = 'DanhsachQuanLySanphamDot_' . $id_dotnhap .'_' . date("d-m-Y_H-i-s") . '.xlsx';
        return Excel::download(new Admin24_ExportDanhSachQuanLySanPhamNhapDotNhap($id_dotnhap), $title);
    }
    // Xuất thống kê
    function btt_xuatexcel_sanphamnhap(Request $request){
        $id_dot = $request->input('id_dotnhap');
        $noidung = "";
        $validator = Validator::make( $request->all(),
            [
                'id_dotnhap' => 'required|numeric|min:1',
            ],
            [
                'id_dotnhap.required'   => 'Vui lòng chọn đợt',
                'id_dotnhap.numeric'    => 'Hệ thống bị lỗi vui lòng thử lại sau',
                'id_dotnhap.min'        => 'Vui lòng chọn đợt',
            ]
        );
        if ($validator->fails()) {
            $trangthai = 'validate';
            $noidung = response()->json($validator->errors());
        }else{
            $trangthai = 'excel_1';
        }
        return array(
            'trangthai' => $trangthai,
            'noidung'   =>$noidung
        );
    }
    function xuatexcel_sanphamnhap($id_dotnhap){
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $title = 'DanhsachSanphamDot_' . $id_dotnhap .'_' . date("d-m-Y_H-i-s") . '.xlsx';
        return Excel::download(new Admin24_ExportDanhSachSanPhamNhapDotNhap($id_dotnhap), $title);
    }
    // Data qr
    function data_QRcode($id){
        $data = DB::table('24_danhmuc_sanpham')->select('*')->where('id',$id)->first();
        return $data;
    }

    // Đợt nhập
    public function check_Trangthaidot($id){
        $result = DB::table('24_dotnhap')
        ->select('trangthai')
        ->where('id', $id)
        ->first();
        return $result ? $result->trangthai : 0;
    }
     // thêm đợt
    function themDot(Request $request){
        $id_chucnang = $request->input('id_chucnang');
        $id_manhinh = $request->input('id_manhinh');
        $time = $request->input('time');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        $noidung = '';
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            $validator = Validator::make( $request->all(),
                [
                    'ten_dot' => 'required|regex:/^[\p{L}\p{N}\-\s]+$/u|unique:24_dotnhap,dotnhap',
                ],
                [
                    'ten_dot.required'      => 'Vui lòng nhập tên đợt',
                    'ten_dot.regex'    => 'Tên đợt chỉ gồm chữ cái và số',
                    'ten_dot.unique'    => 'Tên đợt đã tồn tại',
                ]
            );
            if ($validator->fails()) {
                $trangthai = 'validate';
                $noidung = response()->json($validator->errors());
            }else{
                $ten_dot = $request->input('ten_dot');
                $cleanHtml = Purifier::clean($ten_dot,'default');
                $check = DB::table('24_dotnhap')
                ->insert([
                    "dotnhap" => $cleanHtml,
                    "trangthai" => 0,
                ]);
                if($check == 1){
                    $trangthai = 'ins_1';
                }else{
                    $trangthai = 'ins_0';
                }
            }
        }else{
            $trangthai = 'rol_2';
        }
        return array(
            'trangthai' => $trangthai,
            'noidung'   =>$noidung
        );
    }
    // Data danh sách đợt nhập
    function load_dsdotnhap(){
        $data_dotnhap = DB::table('24_dotnhap')
        ->select('id', 'dotnhap', DB::raw("DATE_FORMAT(start, '%d/%m/%Y') AS ngaytao"), 'trangthai')
        ->get();
        $data = $data_dotnhap->map(function ($item, $index) {
            $item->stt = $index + 1;
            return $item;
        });
        $json_data['data'] = $data;
        $res = json_encode($json_data);
        return  $res;
    }
    function capnhat_Dot(Request $request){
        $noidung = '';
        $trangthai = '';
        $id_chucnang = $request->input('id_chucnang');
        $id_manhinh = $request->input('id_manhinh');
        $time = $request->input('time');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        $noidung ='';
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'tenDot' => 'required|regex:/^[\p{L}\p{N}\-\s]+$/u|unique:24_dotnhap,dotnhap',
            ], [
                'id.required'      => 'Hệ thống bị lỗi. Vui lòng liên hệ adnmin',

                'tenDot.required'      => 'Vui lòng nhập tên đợt',
                'tenDot.regex'    => 'Tên đợt chỉ gồm chữ cái và số',
                'tenDot.unique'    => 'Tên đợt đã tồn tại',
            ]);
            if ($validator->fails()) {
                $trangthai = 'validate';
                $noidung = response()->json($validator->errors());
            } else {
                $id = $request->input('id');
                $tenDot = $request->input('tenDot');
                $cleanHtml = Purifier::clean($tenDot,'default');
                if($this->check_Trangthaidot($id) == 1){
                    $check = DB::table('24_dotnhap')->where('id',$id)->update(['dotnhap' => $cleanHtml]);
                    if($check == 1){
                        $trangthai = "upd_1";
                    }else{
                        $trangthai = "upd_0";
                    }
                }else{
                    $trangthai = "dotnhap_0";
                }
            }
        }else{
            $trangthai = 'rol_2';
        }
        return response()->json([
            'trangthai' => $trangthai,
            'noidung'   => $noidung,
        ]);
    }
    public function change_trangthai(Request $request)
    {
        $noidung = '';
        $trangthai = '';
        $id_chucnang = $request->input('id_chucnang');
        $id_manhinh = $request->input('id_manhinh');
        $time = $request->input('time');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        $noidung ='';
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            $validator = Validator::make($request->all(), [
                'trangthai' => 'required',
                'id'        => 'required',
            ], [
                'trangthai.required' => 'Hệ thống bị lỗi. Vui lòng liên hệ admin',
                'id.required'        => 'Hệ thống bị lỗi. Vui lòng liên hệ admin',
            ]);
            if ($validator->fails()) {
                $trangthai = 'validate';
                $noidung = response()->json($validator->errors());
            } else {
                $trangthai= $request->input('trangthai');
                $id = $request->input('id');
                $trangthai_moi = $trangthai == 0 ? 1 : 0;
                $check = DB::table('24_dotnhap')
                    ->where('id', $id)
                    ->update(['trangthai' => $trangthai_moi]);
                $trangthai = $check == 1 ? 'upd_1' : 'upd_0';
            }
        }else{
            $trangthai = 'rol_2';
        }
        return response()->json([
            'trangthai' => $trangthai,
            'noidung'   => $noidung,
        ]);
    }
    // Quản lý đợt nhập
    function ql_dotnhap(){
        $url = URL::current();
        $quyen = $this->kiemtraquyen_url($url);
        if ($quyen == 1) {

            return view(
                'user_24.admin24.manage.quanlydongphuc.quanlydotnhap',
                [
                    'menu'         => $this->sidebar(),
                ]
            );
        } else {
            return view('user_24.admin24.include.404');
        }
    }

    function qldn_ds_dotnhap(){
        $chondot = new Collection(
            [
                'id' => 0,
                'text' => "Chọn đợt",
                'selected' => true
            ]
        );
        $qldn_ds_dotnhap = DB::table('24_dotnhap')
        ->select('id', 'dot as text')
        ->where('trangthai',1)
        ->orderBy('id', 'ASC')
        ->get();
        $qldn_ds_dotnhap[] =  $chondot;
        return  $qldn_ds_dotnhap;
    }
    // danh sách sản phẩm nhập trong đợt
    function qldot_load_dssanpham_dot($id){
        if($id == -1){
            $data = [];
        }else{
            $data_sanphamnhap = DB::table('24_danhmuc_sanpham')
            ->select(
                '24_danhmuc_sanpham.id as id',
                '24_danhmuc_sanpham.masp as masp',
                '24_loaisanpham.loai as loai',
                '24_danhmuc_size.size as size',
                '24_danhmuc_sanpham.thongso as thongso',
                '24_danhmuc_nhasanxuat.nhasanxuat as nhasanxuat',
                DB::raw('IF(sanphamnhap.soluong IS NOT NULL, sanphamnhap.soluong, 0) as soluong')
            )
            ->join('24_loaisanpham', '24_loaisanpham.id', '=', '24_danhmuc_sanpham.id_loai')
            ->join('24_danhmuc_size', '24_danhmuc_size.id', '=', '24_danhmuc_sanpham.id_size')
            ->join('24_danhmuc_nhasanxuat', '24_danhmuc_nhasanxuat.id', '=', '24_danhmuc_sanpham.id_nhasanxuat')
            ->leftJoin(DB::raw('(SELECT id_sanpham, soluong FROM 24_dotnhap_sanpham WHERE id_dotnhap = ' . $id . ') as sanphamnhap'),
                       'sanphamnhap.id_sanpham', '=', '24_danhmuc_sanpham.id')
            ->where('24_danhmuc_sanpham.trangthai',1)
            ->orderBy('24_loaisanpham.id')
            ->orderBy('24_danhmuc_nhasanxuat.id')
            ->orderBy('24_danhmuc_size.id')
            ->get();
            $data = $data_sanphamnhap->map(function ($item, $index) {
                $item->stt = $index + 1; // Thêm số thứ tự tự tăng, bắt đầu từ 1
                return $item;
            });
        }
        $json_data['data'] = $data;
        $res = json_encode($json_data);

        return  $res;

    }

    function change_soluong(Request $request){
        $noidung = '';
        $trangthai = '';
        $id_chucnang = $request->input('id_chucnang');
        $id_manhinh = $request->input('id_manhinh');
        $time = $request->input('time');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        $noidung ='';
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            $validator = Validator::make($request->all(), [
                'id_dot'       => 'required|integer|min:1',
                'id_sanpham' => 'required',
                'soluong' => 'required|integer|min:0',
            ],
            [
                'id_dot.required'       => 'Lỗi hệ thống. Vui lòng liên hệ admin',
                'id_dot.integer'       => 'Vui lòng chọn đợt!',
                'id_dot.min'            => 'Vui lòng chọn đợt',
                'id_sanpham.required' => 'Lỗi hệ thống. Vui lòng liên hệ admin',
                'soluong.required' => 'Vui lòng nhập số lượng',
                'soluong.integer' => 'Số lượng phải là số nguyên',
                'soluong.min' => 'Số lượng không bé hơn 0',
            ]);
            if ($validator->fails()) {
                $trangthai = 'validate';
                $noidung = response()->json($validator->errors());
            } else {
                $id_sanpham = $request->input('id_sanpham');
                $id_dot = $request->input('id_dot');
                $soluong = $request->input('soluong');
                $check_dot = DB::table('24_dotnhap')->where('id',$id_dot)->first();
                if($check_dot->trangthai == 1){
                    $check_tontai = DB::table('24_dotnhap_sanpham')
                    ->where('id_sanpham', $id_sanpham)
                    ->where('id_dotnhap', $id_dot)->first();
                    if($soluong > 0){
                        if($check_tontai){
                        $check_soluongnhap = DB::table('24_kiemtranhap')->where('id_dot_sanpham',$check_tontai->id)->sum('soluongnhap');
                        }else{
                            $check_soluongnhap = 0;
                        }
                        if($soluong >  $check_soluongnhap){
                            $check = DB::table('24_dotnhap_sanpham')
                            ->updateOrInsert(
                                ['id_sanpham' => $id_sanpham, 'id_dotnhap' => $id_dot],
                                ['soluong' => $soluong]
                            );
                            $trangthai = $check == 1 ? 'upd_1' : 'upd_0';
                        }else{
                            $trangthai = "DaNhap_1";
                        }
                    }else{
                        $check_nhaphang = DB::table('24_kiemtranhap')
                        ->where('id_dot_sanpham',$check_tontai->id)->get();

                        if(count($check_nhaphang) > 0){
                            $trangthai = "DaNhap_0";
                        }else{
                            $check = DB::table('24_dotnhap_sanpham')
                            ->where('id_sanpham', $id_sanpham)
                            ->where('id_dotnhap', $id_dot)
                            ->delete();
                            $trangthai = $check == 1 ? 'upd_1' : 'upd_0';
                        }
                    }
                }else{
                    $trangthai = "dotnhap_0";
                }

            }
        }else{
            $trangthai = 'rol_2';
        }
        return response()->json([
            'trangthai' => $trangthai,
            'noidung'   => $noidung,
        ]);
    }
    // Biểu đồ thống kê nhâp
    function bieudo_thongke_nhap(Request $request) {
        $id_dotnhap = $request->input('id_dotnhap');

        // Lấy dữ liệu
        $data = DB::table('24_kiemtranhap')
            ->select([
                '24_danhmuc_nhasanxuat.nhasanxuat AS nsx',
                '24_loaisanpham.loai AS loai',
                '24_danhmuc_size.size AS size',
                DB::raw('SUM(24_kiemtranhap.soluongnhap) AS tong_sl_nhap')
            ])
            ->join('24_dotnhap_sanpham', '24_dotnhap_sanpham.id', '=', '24_kiemtranhap.id_dot_sanpham')
            ->join('24_danhmuc_sanpham', '24_danhmuc_sanpham.id', '=', '24_dotnhap_sanpham.id_sanpham')
            ->join('24_danhmuc_nhasanxuat', '24_danhmuc_nhasanxuat.id', '=', '24_danhmuc_sanpham.id_nhasanxuat')
            ->join('24_loaisanpham', '24_loaisanpham.id', '=', '24_danhmuc_sanpham.id_loai')
            ->join('24_danhmuc_size', '24_danhmuc_size.id', '=', '24_danhmuc_sanpham.id_size')
            ->where('24_dotnhap_sanpham.id_dotnhap', $id_dotnhap)
            ->groupBy('24_danhmuc_nhasanxuat.nhasanxuat', '24_loaisanpham.loai', '24_danhmuc_size.size')
            ->get();

        // Thêm màu ngẫu nhiên cho từng size
        $data = $data->map(function ($item) {
            $item->color = sprintf("#%06X", mt_rand(0, 0xFFFFFF)); // Màu ngẫu nhiên
            return $item;
        });

        return response()->json($data);
    }






































    //Phát đồng phục
    function phatdongphuc()
    {
        $loai = DB::table('24_danhmuc_sanpham')
        ->join('24_loaisanpham', '24_danhmuc_sanpham.id_loai', '=', '24_loaisanpham.id')
        ->join('24_kho', '24_kho.idsanpham', '=', '24_danhmuc_sanpham.id')
        ->select('24_loaisanpham.id', '24_loaisanpham.loai', DB::raw('MAX(24_danhmuc_sanpham.anhsanpham) as anhsanpham'))
        ->where('24_loaisanpham.trangthai', 1)
        ->where('24_danhmuc_sanpham.trangthai', 1)
        ->where('24_kho.trangthai', 0)
        ->groupBy('24_loaisanpham.id', '24_loaisanpham.loai')
        ->get();

        // Truy vấn $loai để lấy danh sách loại sản phẩm với thông tin nhà sản xuất và ảnh
        // $loai = DB::table('24_danhmuc_sanpham')
        // ->select('24_loaisanpham.id', '24_loaisanpham.loai', '24_danhmuc_sanpham.img', '24_danhmuc_sanpham.id_nhasanxuat', '24_danhmuc_nhasanxuat.nhasanxuat')
        // ->join('24_loaisanpham', '24_danhmuc_sanpham.id_loai', '=', '24_loaisanpham.id')
        // ->join('24_danhmuc_nhasanxuat', '24_danhmuc_sanpham.id_nhasanxuat', '=', '24_danhmuc_nhasanxuat.id')
        // ->join('24_kho', '24_kho.idsanpham', '=', '24_danhmuc_sanpham.id')
        // ->where('24_kho.trangthai', 0)
        // ->where('24_loaisanpham.trangthai', 1)
        // ->where('24_danhmuc_sanpham.trangthai', 1)
        // ->where('24_danhmuc_nhasanxuat.trangthai', 1)
        // ->groupBy('24_loaisanpham.id', '24_danhmuc_sanpham.id_nhasanxuat', '24_danhmuc_sanpham.img', '24_danhmuc_nhasanxuat.nhasanxuat')
        // ->get();

        // Truy vấn $size để lấy danh sách kích cỡ cho từng loại sản phẩm và nhà sản xuất
        $size = DB::table('24_danhmuc_sanpham')
        ->join('24_loaisanpham', '24_danhmuc_sanpham.id_loai', '=', '24_loaisanpham.id')
        // ->join('24_danhmuc_nhasanxuat', '24_danhmuc_sanpham.id_nhasanxuat', '=', '24_danhmuc_nhasanxuat.id')
        // ->join('24_loaisanpham', '24_danhmuc_sanpham.id_loai', '=', '24_loaisanpham.id')
        ->join('24_danhmuc_size', '24_danhmuc_sanpham.id_size', '=', '24_danhmuc_size.id')
        ->join('24_kho', '24_kho.idsanpham', '=', '24_danhmuc_sanpham.id')
        ->select(
            '24_loaisanpham.id AS id_loai',
            '24_danhmuc_size.size',
            '24_danhmuc_sanpham.id AS id_sanpham',
            // '24_danhmuc_nhasanxuat.id AS id_nhasanxuat'
            // '24_loaisanpham.id AS id_loai'
        )
        ->where('24_kho.trangthai', 0)
        // ->where('24_kho.stt', 1)
        ->where('24_danhmuc_size.trangthai', 1)
        ->where('24_danhmuc_sanpham.trangthai', 1)
        ->where('24_loaisanpham.trangthai', 1)
        // ->where('24_danhmuc_nhasanxuat.trangthai', 1)
        ->groupBy(
            '24_loaisanpham.id',
            '24_danhmuc_size.size',
            '24_danhmuc_sanpham.id',
            // '24_danhmuc_nhasanxuat.id'
            // '24_loaisanpham.id'
        )
        ->get();





        $dot_phat = DB::table('24_danhmuc_dotphat')
            ->select('id as id', 'dot as text')
            ->where('trangthai', 0)
            ->get()
            ->prepend((object)['id' => 0, 'text' => 'Chọn đợt phát']);

        return view('user_24.admin24.manage.quanlydongphuc.phatdongphuc_livewire', [
            'size' => $size,
            'loai' => $loai,
            'dot_phat' => $dot_phat,
            'menu' => $this->sidebar(),
        ]);
    }
    function data_cart($id_nguoinhan,$id_nguoiphat,$id_dotphat){
        $result= DB::table('24_giohang_dongphuc')
        ->selectRaw(
            'MIN(24_giohang_dongphuc.id) as id_cart,
            24_giohang_dongphuc.id_sanpham,
            SUM(24_giohang_dongphuc.soluong) as tong_soluong,
            24_danhmuc_nhasanxuat.nhasanxuat as nhasanxuat,
            24_danhmuc_nhasanxuat.id as id_nhasanxuat,
            24_loaisanpham.loai as ten_loai,
            24_loaisanpham.id as id_loai,
            24_danhmuc_size.size as ten_size,
            24_giohang_dongphuc.id_nguoinhan as id_nguoinhan,
            24_giohang_dongphuc.id_nguoiphat as id_nguoiphat,
            24_giohang_dongphuc.id_dotphat as id_dotphat'
        )
        ->join('24_danhmuc_sanpham', '24_giohang_dongphuc.id_sanpham', '=', '24_danhmuc_sanpham.id')
        ->join('24_loaisanpham', '24_danhmuc_sanpham.id_loai', '=', '24_loaisanpham.id')
        ->join('24_danhmuc_size', '24_danhmuc_sanpham.id_size', '=', '24_danhmuc_size.id')
        ->join('24_danhmuc_nhasanxuat', '24_danhmuc_sanpham.id_nhasanxuat', '=', '24_danhmuc_nhasanxuat.id')
        ->where('24_giohang_dongphuc.trangthai', 0)
        ->where('24_giohang_dongphuc.id_nguoinhan', $id_nguoinhan)
        ->where('24_giohang_dongphuc.id_nguoiphat', $id_nguoiphat)
        ->where('24_giohang_dongphuc.id_dotphat', $id_dotphat)
        ->groupBy(
            '24_giohang_dongphuc.id_sanpham',
            '24_giohang_dongphuc.id_nguoinhan',
            '24_giohang_dongphuc.id_nguoiphat',
            '24_giohang_dongphuc.id_dotphat'
        )
        ->get();


        return $result;
    }
    //Thêm sản phẩm bằng click
    function cart_Database(Request $request) {
        $id_sanpham = $request->input('id_sanpham');
        $val_sl = 1;
        $id_nguoinhan = $request->input('id_nguoinhan');
        $id_dotphat = $request->input('id_dotphat');
        $id_nguoiphat = Auth::guard('loginadmin')->user()->id;
        $kieudulieu="text";
        $id_kho = 0;

        $time = $request->input('time');
        $id_manhinh = $request->input('id_manhinh');
        $id_chucnang = $request->input('id_chucnang');
        $active = $request->input('active');
        if ($this->kiemtraquyen($id_nguoiphat, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            // Validation
            $validator = Validator::make(
                $request->all(),
                [
                    // 'val_sl' => 'required|integer|min:1',
                    'id_nguoinhan' => 'required|integer',
                    'id_sanpham' => 'required|integer|min:1',
                    'id_dotphat' => 'required|integer|min:1',
                ],
                [
                    // 'val_sl.required' => 'Vui lòng nhập số lượng để thêm vào giỏ hàng!!',
                    // 'val_sl.integer' => 'Vui lòng nhập một số nguyên lớn hơn 0!!',
                    // 'val_sl.min' => 'Vui lòng nhập một số nguyên lớn hơn 0!!',

                    'id_nguoinhan.required' => 'Vui lòng tìm kiếm sinh viên trước!!',
                    'id_nguoinhan.integer' => 'Vui lòng kiểm tra lại thông tin sinh viên!!',

                    'id_sanpham.required' => 'Vui lòng chọn size!!',
                    'id_sanpham.integer' => 'Vui lòng chọn size!!',
                    'id_sanpham.min' => 'Vui lòng chọn size!!',

                    'id_dotphat.required' => 'Vui lòng chọn đợt phát!!',
                    'id_dotphat.integer' => 'Vui lòng chọn đợt phát!!',
                    'id_dotphat.min' => 'Vui lòng chọn đợt phát!!',
                ]
            );
            // Nếu validator không thành công
            if ($validator->fails()) {
                $noidung = $validator->errors();
                $trangthai = 0;
                $kieudulieu="json";
            } else {
                $id_nguoinhan = Purifier::clean($id_nguoinhan);
                $id_nguoiphat = Purifier::clean($id_nguoiphat);
                $id_sanpham = Purifier::clean($id_sanpham);
                $id_dotphat = Purifier::clean($id_dotphat);
                $val_sl = Purifier::clean($val_sl);
                // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng hay chưa
                $cart_exitst = DB::table('24_giohang_dongphuc')
                ->where('trangthai', 0)
                ->where('id_nguoinhan', $id_nguoinhan)
                ->where('id_nguoiphat', $id_nguoiphat)
                ->where('id_sanpham', $id_sanpham)
                ->where('id_dotphat', $id_dotphat)
                ->first();
                if($cart_exitst ){
                    $noidung = "cart_2";//Sản phẩm đã tồn tại
                    $trangthai = 0;
                }else{
                    $kho = DB::table('24_kho')
                        ->where('idsanpham', $id_sanpham)
                        ->where('trangthai', 0)
                        ->where('soluongton', '>', 0)
                        ->first(); // Lấy bản ghi đầu tiên

                    if ($kho) {
                        // Cập nhật số lượng tồn
                        // Cập nhật số lượng tồn
                        // $kho_updated = DB::table('24_kho')
                        // ->where('id', $kho->id) // Cập nhật bản ghi vừa lấy
                        // ->update(['soluongton' => DB::raw('soluongton - 1')]);


                        // if ($kho_updated) {
                            // Sản phẩm chưa tồn tại, chèn mới vào giỏ hàng
                        $sql_cart = DB::table('24_giohang_dongphuc')->insert([
                            'id_nguoiphat' => $id_nguoiphat,
                            'id_nguoinhan' => $id_nguoinhan,
                            'id_sanpham'   => $id_sanpham,
                            'id_dotnhap'   => $kho->id_dotnhap, // Sử dụng thông tin từ bản ghi kho
                            'id_dotphat'   => $id_dotphat,
                            'soluong'      => $val_sl,
                        ]);

                        $trangthai = $sql_cart ? 1 : 0;
                        $noidung = $sql_cart ? $this->data_cart($id_nguoinhan, $id_nguoiphat, $id_dotphat) : 'ins_0';
                        // } else {
                        //     $trangthai = 0;
                        //     $noidung = 'err_100';
                        // }
                    } else {
                        $trangthai = 0;
                        $noidung = "ex_2";
                    }

                }
            }
        }else{
            $trangthai = 0;
            $noidung = "rol_2";
        }
        return response()->json([
            'trangthai' => $trangthai,
            'noidung'   => $noidung,
            'kieudulieu'   => $kieudulieu,
        ]);
    }
    //Thêm sản phẩm bằng QR
    function cart_Database_QR(Request $request) {
        $masp = $request->input('masp'); // Nhận mã sản phẩm
        $val_sl = 1;
        $id_nguoinhan = $request->input('id_nguoinhan');
        $id_dotphat = $request->input('id_dotphat');
        $id_nguoiphat = Auth::guard('loginadmin')->user()->id;
        $kieudulieu = "text";
        $id_kho = 0;

        $time = $request->input('time');
        $id_manhinh = $request->input('id_manhinh');
        $id_chucnang = $request->input('id_chucnang');
        $active = $request->input('active');

        if ($this->kiemtraquyen($id_nguoiphat, $id_manhinh, $id_chucnang, $time, $active) == 1) {

            // Validation
            $validator = Validator::make(
                $request->all(),
                [
                    'id_nguoinhan' => 'required|integer',
                    'masp' => 'required|string|min:1',
                    'id_dotphat' => 'required|integer|min:1',
                ],
                [
                    'id_nguoinhan.required' => 'Vui lòng tìm kiếm sinh viên trước!!',
                    'id_nguoinhan.integer' => 'Vui lòng kiểm tra lại thông tin sinh viên!!',

                    'masp.required' => 'Vui lòng nhập mã sản phẩm!!',
                    'masp.string' => 'Vui lòng nhập mã sản phẩm hợp lệ!!',
                    'masp.min' => 'Vui lòng nhập mã sản phẩm hợp lệ!!',

                    'id_dotphat.required' => 'Vui lòng chọn đợt phát!!',
                    'id_dotphat.integer' => 'Vui lòng chọn đợt phát!!',
                    'id_dotphat.min' => 'Vui lòng chọn đợt phát!!',
                ]
            );

            // Nếu validator không thành công
            if ($validator->fails()) {
                $noidung = $validator->errors();
                $trangthai = 0;
                $kieudulieu = "json";
            } else {
                $id_nguoinhan = Purifier::clean($id_nguoinhan);
                $id_nguoiphat = Purifier::clean($id_nguoiphat);
                $masp = Purifier::clean($masp);
                $id_dotphat = Purifier::clean($id_dotphat);
                $val_sl = Purifier::clean($val_sl);

                // Lấy thông tin sản phẩm dựa trên masp
                $sanpham = DB::table('24_danhmuc_sanpham')
                    ->where('masp', $masp)
                    ->first();

                if ($sanpham) {
                    $id_sanpham = $sanpham->id;

                    // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng hay chưa
                    $cart_exitst = DB::table('24_giohang_dongphuc')
                        ->where('trangthai', 0)
                        ->where('id_nguoinhan', $id_nguoinhan)
                        ->where('id_nguoiphat', $id_nguoiphat)
                        ->where('id_sanpham', $id_sanpham)
                        ->where('id_dotphat', $id_dotphat)
                        ->first();

                    if ($cart_exitst) {
                        $noidung = "cart_2"; // Sản phẩm đã tồn tại
                        $trangthai = 0;
                    } else {
                        $kho = DB::table('24_kho')
                            ->where('idsanpham', $id_sanpham)
                            ->where('trangthai', 0)
                            ->where('soluongton', '>', 0)
                            ->first(); // Lấy bản ghi đầu tiên

                        if ($kho) {
                        //     // Cập nhật số lượng tồn
                        //     $kho_updated = DB::table('24_kho')
                        //         ->where('id', $kho->id) // Cập nhật bản ghi vừa lấy
                        //         ->update(['soluongton' => DB::raw('soluongton - 1')]);

                        //     if ($kho_updated) {
                            // Sản phẩm chưa tồn tại, chèn mới vào giỏ hàng
                            $sql_cart = DB::table('24_giohang_dongphuc')->insert([
                                'id_nguoiphat' => $id_nguoiphat,
                                'id_nguoinhan' => $id_nguoinhan,
                                'id_sanpham'   => $id_sanpham,
                                'id_dotnhap'   => $kho->id_dotnhap, // Sử dụng thông tin từ bản ghi kho
                                'id_dotphat'   => $id_dotphat,
                                'soluong'      => $val_sl,
                            ]);

                            $trangthai = $sql_cart ? 1 : 0;
                            $noidung = $sql_cart ? $this->data_cart($id_nguoinhan, $id_nguoiphat, $id_dotphat) : 'ins_0';
                            // } else {
                            //     $trangthai = 0;
                            //     $noidung = 'err_100';
                            // }
                        } else {
                            $trangthai = 0;
                            $noidung = "ex_2"; // Không tìm thấy kho có đủ số lượng tồn
                        }
                    }
                } else {
                    $trangthai = 0;
                    $noidung = "sp_not_found"; // Không tìm thấy sản phẩm
                }
            }
        }else{
            $trangthai = 0;
            $noidung = "rol_2";
        }

        return response()->json([
            'trangthai' => $trangthai,
            'noidung'   => $noidung,
            'kieudulieu' => $kieudulieu,
        ]);
    }
    //Xóa 1 sản phẩm khỏi giỏ hàng và hoàn lại số lượng vào kho
    function remove_from_cart($id_cart, $id_nguoinhan, $id_dotphat, $id_nguoiphat){
        // Bắt đầu transaction
        try {
            // Lấy thông tin từ giỏ hàng
            $sql_cart = DB::table('24_giohang_dongphuc')
                ->where('id', $id_cart)
                ->first();

            if (!$sql_cart) {
                // Nếu không tìm thấy giỏ hàng, kết thúc và trả về lỗi
                return response()->json([
                    'trangthai' => 0,
                    'noidung' => 'del_0',
                    'res' => '',
                    'message' => 'Không tìm thấy sản phẩm trong giỏ hàng'
                ]);
            }
            // Xóa sản phẩm khỏi giỏ hàng (cập nhật trạng thái)
            $sql_remove = DB::table('24_giohang_dongphuc')
                ->where('id_nguoinhan', $sql_cart->id_nguoinhan)
                ->where('id_nguoiphat', $sql_cart->id_nguoiphat)
                ->where('id_sanpham', $sql_cart->id_sanpham)
                ->where('id_dotphat', $sql_cart->id_dotphat)
                ->where('trangthai', 0)
                ->update(['trangthai' => 1]);
            if($sql_remove){

                $res = $this->data_cart($id_nguoinhan, $id_nguoiphat, $id_dotphat);
                $noidung = "del_1";
                $message = "thành công";
                $trangthai = 1;
            }else{
                $noidung = "del_2";
                $trangthai = 0;
                $message= "Không xóa được ở giỏ hàng";
                $res = $this->data_cart($id_nguoinhan, $id_nguoiphat, $id_dotphat);
            }

        } catch (Exception $e) {
            return response()->json([
                'trangthai' => 0,
                'noidung' => 'del_0',
                'res' => '',
                'message' => 'Đã xảy ra lỗi: ' . $e->getMessage()
            ]);
        }

        return response()->json([
            'trangthai' => $trangthai,
            'noidung' => $noidung,
            'res' => $res,
            'message' => $message
        ]);
    }
    //Cập nhật số lượng với 1 giá trị
    function update_sl(Request $request){
        $id_cart = Purifier::clean($request->input('id_cart'));
        $sl = Purifier::clean($request->input('sl'));
        $soluongmoi = 0;

        try {
            // Kiểm tra tồn tại của giỏ hàng
            $cart_exist = DB::table('24_giohang_dongphuc')
                ->select('*')
                ->where('trangthai', 0)
                ->where('id', $id_cart)
                ->first();
            $sl_hientai = $cart_exist->soluong;
            if ($cart_exist) {
                $soluongmoi = $sl + $sl_hientai;
                $id_nguoinhan = $cart_exist->id_nguoinhan;
                $id_nguoiphat = $cart_exist->id_nguoiphat;
                $id_dotphat = $cart_exist->id_dotphat;
                $id_sanpham = $cart_exist->id_sanpham;
                $id_dotnhap = $cart_exist->id_dotnhap;
                $sl_hoanlaikho = 1;
                $kho_exist = DB::table('24_kho')
                ->select('*')
                ->where('trangthai', 0)
                ->where('id_dotnhap', $id_dotnhap)
                ->where('idsanpham', $id_sanpham)
                ->first();
                if ($soluongmoi > 0 && $kho_exist->soluongton >= $soluongmoi) {
                    // Nếu tồn tại, cập nhật số lượng
                    $sql_giohang = DB::table("24_giohang_dongphuc")
                        ->where("id", $id_cart)
                        ->update([
                            "soluong" => $soluongmoi
                        ]);
                    // Nếu tồn tại, cập nhật số lượng

                    $noidung = $this->data_cart($id_nguoinhan, $id_nguoiphat, $id_dotphat);
                    $trangthai = 1;
                    $size = $id_sanpham;
                    DB::commit(); // Commit transaction khi thành công
                } elseif($soluongmoi == 0) {
                    // Gọi hàm remove_from_cart khi số lượng bằng 0
                    $sql = json_decode($this->remove_from_cart($id_cart, $id_nguoinhan, $id_dotphat, $id_nguoiphat)->getContent(), true);

                    // Kiểm tra trạng thái từ response
                    if ($sql['trangthai'] == 1) {
                        $noidung = $this->data_cart($id_nguoinhan, $id_nguoiphat, $id_dotphat);
                        $trangthai = 1;
                        $size = $id_sanpham;
                        DB::commit(); // Commit transaction khi thành công
                    } else {
                        $noidung = $sql['noidung'];
                        $trangthai = 0;
                        $size = 0;
                    }
                }else{
                    $noidung = 'ex_2';
                    $trangthai = 0;
                    $size = 0;
                }
            } else {
                $noidung = "err_100";
                $trangthai = 0;
                $size = 0;
            }
        } catch (Exception $e) {
            // Rollback khi có lỗi
            DB::rollBack();
            $noidung = "err_100";
            $trangthai = 0;
            $size = 0;
        }

        return response()->json([
            'trangthai' => $trangthai,
            'noidung' => $noidung,
            'soluongmoi' => $soluongmoi,
            'size' => $size,
        ]);
    }
    //Cập nhật số lượng với n giá trị
    function update_input_sl(Request $request){
        $id_cart = Purifier::clean($request->input('id_cart'));
        $sl = Purifier::clean($request->input('sl'));

        try {
            // Kiểm tra tồn tại của giỏ hàng
            $cart_exist = DB::table('24_giohang_dongphuc')
                ->select('*')
                ->where('trangthai', 0)
                ->where('id', $id_cart)
                ->first();
            // Kiểm tra kho của giỏ hàng

            if ($cart_exist) {
                $id_nguoinhan = $cart_exist->id_nguoinhan;
                $id_nguoiphat = $cart_exist->id_nguoiphat;
                $id_dotphat = $cart_exist->id_dotphat;
                $id_sanpham = $cart_exist->id_sanpham;
                $id_dotnhap = $cart_exist->id_dotnhap;
                $sl_hoanlaikho = $sl - $cart_exist->soluong;
                $kho_exist = DB::table('24_kho')
                ->select('*')
                ->where('trangthai', 0)
                ->where('id_dotnhap', $id_dotnhap)
                ->where('idsanpham', $id_sanpham)
                ->first();
                $sl_kho_moi = $kho_exist->soluongton - $sl_hoanlaikho;
                //sl mới - số lượng cũ
                if ($sl > 0 && $kho_exist->soluongton >= $sl) {
                    // Nếu tồn tại, cập nhật số lượng
                    $sql_giohang = DB::table("24_giohang_dongphuc")
                        ->where("id", $id_cart)
                        ->update([
                            "soluong" => $sl
                        ]);

                    $noidung = $this->data_cart($id_nguoinhan, $id_nguoiphat, $id_dotphat);
                    $trangthai = 1;
                    $size = $id_sanpham;
                    DB::commit(); // Commit transaction khi thành công
                } elseif($sl == 0) {
                    // Gọi hàm remove_from_cart khi số lượng bằng 0
                    $sql = json_decode($this->remove_from_cart($id_cart, $id_nguoinhan, $id_dotphat, $id_nguoiphat)->getContent(), true);

                    // Kiểm tra trạng thái từ response
                    if ($sql['trangthai'] == 1) {
                        $noidung = $this->data_cart($id_nguoinhan, $id_nguoiphat, $id_dotphat);
                        $trangthai = 1;
                        $size = $id_sanpham;
                        DB::commit(); // Commit transaction khi thành công
                    } else {
                        $noidung = $sql['noidung'];
                        $trangthai = 0;
                        $size = 0;
                    }
                }else{
                    $noidung = 'ex_2';
                    $trangthai = 0;
                    $size = 0;
                }
            } else {
                $noidung = "err_100";
                $trangthai = 0;
                $size = 0;
            }
        } catch (Exception $e) {
            // Rollback khi có lỗi
            DB::rollBack();
            $noidung = "err_100";
            $trangthai = 0;
            $size = 0;
        }

        return response()->json([
            'trangthai' => $trangthai,
            'noidung' => $noidung,
            'soluongmoi' => $sl,
            'size' => $size,
        ]);
    }
    //Phát đồng phục
    function phat_dong_phuc(Request $request){
            $id_nguoinhan = $request->input('id_nguoinhan');
            $id_dotphat=$request->input('id_dotphat');
            $id_admin = Auth::guard('loginadmin')->user()->id;
            $sanpham_0_hople="";
            $time = $request->input('time');
            $id_manhinh = $request->input('id_manhinh');
            $id_chucnang = $request->input('id_chucnang');
            $active = $request->input('active');

            $get_giohang_new=[];
            $trangthai = 0;
            $kieudulieu = "text";
            $mahoadon = Carbon::now()->format('YmdHis');
            $noidung = "";
            if($id_nguoinhan>0){
                if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
                    $dot_trungtuyen = [2,3];
                    // $checktrugntuyen = DB::table('24_trungtuyen')
                    // ->where('id_taikhoan', $id_nguoinhan)
                    // ->whereIn('iddot',$dot_trungtuyen)
                    // ->first();
                    $checktrugntuyen = true;
                    try{
                        DB::beginTransaction();
                        if($checktrugntuyen){
                            $sql_get_giohang=DB::table('24_giohang_dongphuc')
                            ->select('*')
                            ->where('id_nguoinhan',$id_nguoinhan)
                            // ->where('id_nguoiphat',$id_admin)
                            ->where('id_dotphat',$id_dotphat)
                            ->where('trangthai',0)
                            ->get();


                            if(count($sql_get_giohang)>0){
                                foreach ($sql_get_giohang as $val) {
                                    // $sql_kho = DB::table('24_kho')
                                    // ->join("24_danhmuc_sapham")
                                    // ->where('idsanpham',$val->id_sanpham)
                                    // ->where('id_dotnhap',$val->id_dotnhap)
                                    // ->where('trangthai',0)
                                    // ->first();
                                    $sql_kho = DB::table('24_kho')
                                    ->join('24_danhmuc_sanpham', '24_kho.idsanpham', '=', '24_danhmuc_sanpham.id')
                                    ->join('24_loaisanpham', '24_danhmuc_sanpham.id_loai', '=', '24_loaisanpham.id')
                                    ->join('24_danhmuc_size', '24_danhmuc_sanpham.id_size', '=', '24_danhmuc_size.id')
                                    ->join('24_danhmuc_nhasanxuat', '24_danhmuc_sanpham.id_nhasanxuat', '=', '24_danhmuc_nhasanxuat.id')
                                    ->join('24_dotnhap', '24_kho.id_dotnhap', '=', '24_dotnhap.id')
                                    ->select(
                                        '24_kho.soluongton AS soluongton',
                                        '24_loaisanpham.loai AS loai',
                                        '24_danhmuc_size.size AS size',
                                        '24_danhmuc_nhasanxuat.nhasanxuat AS nhasanxuat',
                                        )
                                    ->where('24_kho.trangthai', 0)
                                    ->where('24_kho.idsanpham', $val->id_sanpham)
                                    ->where('24_kho.id_dotnhap', $val->id_dotnhap)
                                    ->first();
                                    $temp = array(
                                        'mahoadon' => $mahoadon,
                                        'id_sinhvien' => $id_nguoinhan,
                                        'id_sanpham' => $val->id_sanpham,
                                        'id_dotnhap' => $val->id_dotnhap,
                                        'id_nguoiphat' => $id_admin,
                                        'sl_phat' => $val->soluong,
                                        'id_dotphat' => $id_dotphat,
                                    );
                                    $soluongtonmoi = $sql_kho->soluongton - $val->soluong;
                                    if($soluongtonmoi<0){
                                        $sanpham_0_hople = $sql_kho->loai . ' size ' . $sql_kho->size . ' của nhà sản xuất ' . $sql_kho->nhasanxuat . " vượt quá số lượng trong kho!!Hiện tại sản phẩm này chỉ còn ". $sql_kho->soluongton ." cái";
                                        DB::rollBack();
                                        return [
                                            'kieudulieu' => "text",
                                            'noidung' => "ex_2",
                                            'trangthai' =>3,
                                            'mahoadon' => "",
                                            'get_giohang_new' => [],
                                            'sanpham_0_hople' => $sanpham_0_hople ,
                                        ];
                                    }
                                    $data[] = $temp;
                                    $tmp_kho = array(
                                        'idsanpham' => $val->id_sanpham,
                                        'id_dotnhap' => $val->id_dotnhap,
                                        'soluongton' => $soluongtonmoi,
                                    );
                                    $data_kho[] = $tmp_kho;


                                }
                                $hoadon =  DB::table('24_hoadon')->insert($data);
                                    // Thực hiện upsert
                                $kho_update = DB::table('24_kho')->upsert(
                                        $data_kho,  // Dữ liệu cần cập nhật
                                        ['idsanpham', 'id_dotnhap'],  // Cột duy nhất để kiểm tra
                                        ['soluongton']  // Cột cần cập nhật
                                    );
                                if($hoadon && $kho_update){
                                    $sql_del_giohang = DB::table('24_giohang_dongphuc')
                                    ->where('id_nguoinhan', $id_nguoinhan)
                                    ->where('id_nguoiphat', $id_admin)
                                    ->where('id_dotphat', $id_dotphat)
                                    ->where('trangthai', 0)
                                    ->update(['trangthai' => 2]);//Đã thanh toán
                                    if($sql_del_giohang){
                                        DB::commit();
                                        $get_giohang_new=$this->data_cart($id_nguoinhan,$id_admin,$id_dotphat);
                                        $trangthai = 1;
                                        $noidung = "ex_1";
                                    }
                                }else{
                                    DB::rollBack();
                                    $mahoadon = "";
                                    $trangthai = 0;
                                    $noidung = "ex_01";
                                }
                            }else {
                                DB::rollBack();
                                $mahoadon = "";
                                $trangthai = 0;
                                $noidung = "ex_0";
                            }
                        }else{
                            DB::rollBack();
                            $mahoadon = "";
                            $trangthai = 0;
                            $noidung = "tt_0";
                        }
                    }catch (Exception $e) {
                        DB::rollBack();
                        $mahoadon = "";
                        $trangthai = 0;
                        $noidung = "ex_0";
                    }
                }else{
                    $mahoadon = "";
                    $trangthai = 0;
                    $noidung = "rol_2";
                }
            }else{
                $mahoadon = "";
                $trangthai = 0;
                $noidung = "ex_3";
            }
        return [
            'kieudulieu' => $kieudulieu,
            'noidung' => $noidung,
            'trangthai' => $trangthai,
            'mahoadon' => $mahoadon,
            'get_giohang_new' => $get_giohang_new,
        ];
    }
    //tìm kiếm sinh viên
    function phatdongphuc_timkiem(Request $request){
        $cccd_sv = $request->input('cccd_sv');
        $id_dotphat = $request->input('id_dotphat');
        $mssv_dp = $request->input('mssv_dp');

        $trangthai = 1;
        $email="111";
        $res=null;
        $cart=[];
        $id_nguoiphat = Auth::guard('loginadmin')->user()->id;
        $validator = Validator::make(
            $request->all(),
            [
                'cccd_sv' => 'nullable|regex:/^[0-9]{9,12}$/',
                'mssv_dp' => 'nullable|regex:/^[a-zA-Z0-9\s]{0,12}$/',
                'id_dotphat' => 'integer|min:1',
            ],
            [
                // 'cccd_sv.required'       => 'Vui lòng điền cccd của sinh viên để tìm kiếm',
                'cccd_sv.regex' => 'CCCD của sinh viên phải là 9 hoặc 12 số',
                'mssv_dp.regex' => 'MSSV của sinh viên không được chứa ký tự đặc biệt',

                // 'id_dotphat.required' => 'Vui lòng chọn đợt phát!!',
                'id_dotphat.integer' => 'Vui lòng chọn đợt phát!!',
                'id_dotphat.min' => 'Vui lòng chọn đợt phát!!',
            ]
        );
        if ($validator->fails()) {
            $noidung = response()->json($validator->errors());
            // $noidung = response()->json($validator->errors());
            $trangthai=0;
        } else {
            $cccd_sv= Purifier::clean($cccd_sv);
            $id_dotphat= Purifier::clean($id_dotphat);
            $mssv_dp= Purifier::clean($mssv_dp);
            // $sql=DB::table("24_thongtincanhan")->where("cccd",$cccd_sv)->first();
            $id_taikhoan = 0;
            if ($cccd_sv != '' && $mssv_dp != '') {
                // Nếu có cả CCCD và MSSV, tìm theo cả 2 và so sánh chúng
                $sql_cccd = DB::table("24_thongtincanhan")->where("cccd", $cccd_sv)->first();
                $sql_mssv = DB::table("24_mssv")->where("mssv", $mssv_dp)->first();
                if ($sql_cccd && $sql_mssv && $sql_cccd->id_taikhoan == $sql_mssv->id_taikhoan) {
                    $id_taikhoan = $sql_cccd->id_taikhoan;
                    $noidung = $sql_cccd;
                }
            } elseif ($mssv_dp != '') {
                // Nếu chỉ có MSSV, tìm theo MSSV
                $sql_mssv = DB::table("24_mssv")->join('24_thongtincanhan', '24_mssv.id_taikhoan', '=', '24_thongtincanhan.id_taikhoan')->where("mssv", $mssv_dp)->first();
                if($sql_mssv){
                    $id_taikhoan = $sql_mssv->id_taikhoan;
                    $noidung = $sql_mssv;
                }
            } elseif ($cccd_sv != '') {
                // Nếu chỉ có CCCD, tìm theo CCCD
                $sql_cccd = DB::table("24_thongtincanhan")->where("cccd", $cccd_sv)->first();
                if($sql_cccd){
                    $id_taikhoan = $sql_cccd->id_taikhoan;
                    $noidung = $sql_cccd;
                }
            } else {
                // Nếu không có CCCD và MSSV, trả về trạng thái 0
                $trangthai=0;
                $noidung="";
            }
            if($id_taikhoan != 0){
                    $email = DB::table("account24s")
                    ->where("id", $noidung->id_taikhoan)
                    ->first()
                    ->email;
                    $cart=$this->data_cart($noidung->id_taikhoan,$id_nguoiphat,$id_dotphat);
            }else{
                $trangthai=2;
                $noidung="";
            }
        }
        return array(
            'noidung' => $noidung,
            'trangthai' => $trangthai,
            'email' => $email,
            'cart' => $cart,
        );
    }
    //table đồng phục
    function ds_dongphuc(){
        $sql = DB::select("SELECT 24_kho.id,24_dotnhap.dotnhap AS dotnhap,24_danhmuc_nhasanxuat.nhasanxuat AS nsx, 24_loaisanpham.loai AS loai,24_danhmuc_size.size AS size,24_kho.soluongton AS slton,24_kho.trangthai AS trangthai
        FROM 24_kho
        INNER JOIN 24_dotnhap
            ON 24_dotnhap.id=24_kho.id_dotnhap
        INNER JOIN 24_danhmuc_sanpham
            ON 24_danhmuc_sanpham.id=24_kho.idsanpham
        INNER JOIN 24_danhmuc_nhasanxuat
            ON 24_danhmuc_nhasanxuat.id = 24_danhmuc_sanpham.id_nhasanxuat
        INNER JOIN 24_loaisanpham
            ON 24_loaisanpham.id = 24_danhmuc_sanpham.id_loai
        INNER JOIN 24_danhmuc_size
            ON 24_danhmuc_size.id = 24_danhmuc_sanpham.id_size
        ORDER BY 24_loaisanpham.id, 24_danhmuc_size.id");

        $json_data['data'] = $sql;
        $res = json_encode($json_data);
        return  $res;

    }
   //Hóa đơn
   function quanlyhoadon(){
        // Thông tin hóa đơn
        $sql = DB::table('24_hoadon')
        ->join('24_thongtincanhan', '24_hoadon.id_sinhvien', '=', '24_thongtincanhan.id')
        ->join('24_accountsadmin', '24_hoadon.id_nguoiphat', '=', '24_accountsadmin.id')
        ->join('24_danhmuc_dotphat', '24_hoadon.id_dotphat', '=', '24_danhmuc_dotphat.id')
        ->select(
            '24_hoadon.mahoadon as mahoadon',
            DB::raw('DATE_FORMAT(24_hoadon.ngaytao, "%d-%m-%Y %H:%i:%s") as ngaytao'),
            '24_thongtincanhan.hoten as nguoinhan',
            '24_accountsadmin.name as nguoiphat',
            '24_danhmuc_dotphat.dot as dotphat'
        )
        ->groupBy('24_hoadon.mahoadon', 'ngaytao', '24_thongtincanhan.hoten', '24_accountsadmin.name', '24_danhmuc_dotphat.dot')
        ->orderBy('24_hoadon.ngaytao', 'desc') // Sắp xếp theo ngày tạo mới nhất
        ->limit(12); // Giới hạn kết quả là 12

        $hoadon = $sql->get();
        //
        $url = URL::current();
        $quyen = $this->kiemtraquyen_url($url);
        if ($quyen == 1) {
            return view('user_24.admin24.manage.quanlydongphuc.quanlyhoadon_mobile',[
                'menu' =>    $this->sidebar(),
                'hoadon' => $hoadon,
                // 'dot_phat1' => $dot_phat_arr,
            ]);
        } else {
            return view('user_24.admin24.include.404');
        }
    }
    //table ds đồng phục
    function ds_hoadon_dongphuc()
    {
    $sql = "SELECT
            `24_thongtincanhan`.`hoten` AS hoten_sv,
            `24_accountsadmin`.`name` AS hoten_nguoiphat,
            `24_thongtincanhan`.`cccd` AS cccd,
            `24_thongtincanhan`.`ngaysinh` AS ngaysinh,
            `24_hoadon`.`mahoadon` AS mahoadon,
            MAX(`24_hoadon`.`sl_phat`) AS sl_phat,
            MAX(`24_hoadon`.`id`) AS id,
            MAX(`24_danhmuc_dotphat`.`dot`) AS dot_phat,
            MAX(`tt_sanpham`.`ten_loai`) AS loai,
            MAX(`tt_sanpham`.`ten_size`) AS size,
            MAX(`tt_sanpham`.`ten_nhasanxuat`) AS nsx,
            DATE_FORMAT(MAX(`24_hoadon`.`ngaytao`), '%d-%m-%Y') AS ngaytao,
            DAY(MAX(`24_hoadon`.`ngaytao`)) AS ngay,
            MONTH(MAX(`24_hoadon`.`ngaytao`)) AS thang,
            YEAR(MAX(`24_hoadon`.`ngaytao`)) AS nam
        FROM `24_hoadon`
        INNER JOIN `24_thongtincanhan` ON `24_hoadon`.`id_sinhvien` = `24_thongtincanhan`.id_taikhoan
        INNER JOIN `24_accountsadmin` ON `24_hoadon`.`id_nguoiphat` = `24_accountsadmin`.id
        INNER JOIN `24_danhmuc_dotphat` ON `24_hoadon`.`id_dotphat` = `24_danhmuc_dotphat`.id
        INNER JOIN (
            SELECT
                `24_danhmuc_sanpham`.`id` AS id,
                `24_danhmuc_nhasanxuat`.nhasanxuat AS ten_nhasanxuat,
                `24_danhmuc_size`.`size` AS ten_size,
                `24_loaisanpham`.loai AS ten_loai
            FROM `24_danhmuc_sanpham`
            INNER JOIN `24_danhmuc_nhasanxuat` ON `24_danhmuc_sanpham`.`id_nhasanxuat` = `24_danhmuc_nhasanxuat`.id
            INNER JOIN `24_danhmuc_size` ON `24_danhmuc_sanpham`.`id_size` = `24_danhmuc_size`.id
            INNER JOIN `24_loaisanpham` ON `24_danhmuc_sanpham`.`id_loai` = `24_loaisanpham`.id
        ) AS tt_sanpham ON `24_hoadon`.`id_sanpham` = tt_sanpham.id
        WHERE `24_hoadon`.`trangthai`= 0
        GROUP BY `24_hoadon`.`mahoadon`, `24_thongtincanhan`.`hoten`, `24_accountsadmin`.`name`, `24_thongtincanhan`.`cccd`, `24_thongtincanhan`.`ngaysinh`,`24_hoadon`.trangthai";
    $hoadon = DB::select($sql);
    $json_data['data'] = $hoadon;
    $res = json_encode($json_data);
    return  $res;
    }
    //in hóa đơn
    function in_hoadon($mahoadon)
    {
        $sql = "SELECT DISTINCT `24_thongtincanhan`.`hoten` AS hoten_sv,`24_accountsadmin`.`name` AS hoten_nguoiphat,`24_thongtincanhan`.`cccd` AS cccd,DATE_FORMAT(`24_thongtincanhan`.`ngaysinh`, '%d-%m-%Y') AS ngaysinh,`24_hoadon`.`mahoadon` AS mahoadon,`24_hoadon`.`ngaytao` AS ngaytao,`24_hoadon`.`sl_phat` AS sl_phat,`24_hoadon`.`id` AS id,`24_danhmuc_dotphat`.`dot` AS dot_phat,`tt_sanpham`.`ten_loai`AS loai,`tt_sanpham`.`ten_size`AS size,`tt_sanpham`.`ten_nhasanxuat` AS nsx,DATE(`24_hoadon`.`ngaytao`) AS ngaytao,DAY(`24_hoadon`.`ngaytao`) AS ngay,MONTH(`24_hoadon`.`ngaytao`) AS thang,YEAR(`24_hoadon`.`ngaytao`) AS nam
                FROM `24_hoadon`
                INNER JOIN `24_thongtincanhan` ON `24_hoadon`.`id_sinhvien` = `24_thongtincanhan`.id_taikhoan
                INNER JOIN `24_accountsadmin` ON `24_hoadon`.`id_nguoiphat` = `24_accountsadmin`.id
                INNER JOIN `24_danhmuc_dotphat` ON `24_hoadon`.`id_dotphat` = `24_danhmuc_dotphat`.id
                INNER JOIN (
                SELECT
                `24_danhmuc_sanpham`.`id` AS id,
                `24_danhmuc_nhasanxuat`.nhasanxuat AS ten_nhasanxuat,
                `24_danhmuc_size`.`size` AS ten_size,
                `24_loaisanpham`.loai AS ten_loai
                FROM `24_danhmuc_sanpham`
                INNER JOIN `24_danhmuc_nhasanxuat` ON `24_danhmuc_sanpham`.`id_nhasanxuat` = `24_danhmuc_nhasanxuat`.id
                INNER JOIN `24_danhmuc_size` ON `24_danhmuc_sanpham`.`id_size` = `24_danhmuc_size`.id
                INNER JOIN `24_loaisanpham` ON `24_danhmuc_sanpham`.`id_loai` = `24_loaisanpham`.id
                ) AS tt_sanpham ON `24_hoadon`.`id_sanpham` = tt_sanpham.id
                WHERE `24_hoadon`.`mahoadon` = '".$mahoadon."'";
        $hoadon = DB::select($sql);
        $data = array(
            'hoadon' => $hoadon,
        );
        $pdf = PDF::loadView('user_24.admin24.manage.quanlydongphuc.test', $data);
        return $pdf->stream('document.pdf');
    }

    function xoa_hoadon($mahoadon, Request $request) {
        $time = $request->input('time');
        $id_manhinh = $request->input('id_manhinh');
        $id_chucnang = $request->input('id_chucnang');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        $trangthai = 0;
        $noidung = "";

        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            DB::beginTransaction(); // Bắt đầu transaction
            try {
                $tt_hoadon = DB::table('24_hoadon')->where('mahoadon', $mahoadon)->get();

                // Lấy danh sách id_sanpham và id_dotnhap từ hóa đơn
                $idPairs = $tt_hoadon->pluck('id_dotnhap', 'id_sanpham')->toArray();

                // Truy vấn bảng kho để lấy số lượng hiện tại
                $currentStock = DB::table('24_kho')
                    ->whereIn('idsanpham', array_keys($idPairs))
                    ->whereIn('id_dotnhap', array_values($idPairs))
                    ->get(['idsanpham', 'id_dotnhap', 'soluongton'])
                    ->keyBy(function($item) {
                        return $item->idsanpham . '-' . $item->id_dotnhap;
                    });

                // Chuẩn bị dữ liệu để upsert
                $dataToUpdate = [];
                foreach ($tt_hoadon as $hoadon) {
                    $key = $hoadon->id_sanpham . '-' . $hoadon->id_dotnhap;
                    if (!isset($currentStock[$key])) {
                        $trangthai = 1;
                        $noidung = "del_0"; // Nội dung thông báo lỗi
                        DB::rollBack(); // Rollback nếu có lỗi
                        return [
                            'trangthai' => $trangthai,
                            'noidung' => $noidung,
                        ];
                    }
                    $currentQty = $currentStock[$key]->soluongton;
                    $dataToUpdate[] = [
                        'idsanpham' => $hoadon->id_sanpham,
                        'id_dotnhap' => $hoadon->id_dotnhap,
                        'soluongton' => $currentQty + $hoadon->sl_phat // Cộng dồn số lượng
                    ];
                }

                if (count($dataToUpdate) > 0) {
                    $sql_upd_kho = DB::table('24_kho')->upsert(
                        $dataToUpdate,
                        ['idsanpham', 'id_dotnhap'], // Các cột để xác định bản ghi đã tồn tại
                        ['soluongton'] // Cột cần cập nhật
                    );

                    if ($sql_upd_kho) {
                        $xoa_hoadon = DB::table('24_hoadon')->where('mahoadon', $mahoadon)->update(['trangthai' => 1]);
                        if ($xoa_hoadon > 0) {
                            DB::commit(); // Commit nếu thành công
                            $trangthai = 1;
                            $noidung = "del_1";
                        } else {
                            DB::rollBack(); // Rollback nếu thất bại
                            $trangthai = 0;
                            $noidung = "-100";
                        }
                    }
                }else{
                    $trangthai = 0;
                    $noidung = "del_0";
                }
            } catch (Exception $e) {
                DB::rollBack(); // Rollback nếu có exception
                $trangthai = 0;
                $noidung = "del_0";
            }
        } else {
            $trangthai = 0;
            $noidung = "rol_2";
        }

        return [
            'trangthai' => $trangthai,
            'noidung' => $noidung,
        ];
    }
    function thongkedongphuc(){
        $tongphat = DB::table('24_hoadon')
            ->sum('sl_phat');
        $tonghoadon = DB::table('24_hoadon')
        ->where('trangthai',0)
        ->distinct()
        ->count('mahoadon');

        $tonghoadon_huy = DB::table('24_hoadon')
        ->where('trangthai',1)
        ->distinct()
        ->count('mahoadon');

        $tongsvmua = DB::table('24_hoadon')
        ->where('trangthai',0)
        ->distinct()
        ->count('id_sinhvien');

        $url = URL::current();
        $quyen = $this->kiemtraquyen_url($url);
        if ($quyen == 1) {
            return view('user_24.admin24.manage.quanlydongphuc.thongkedongphuc',[
                'menu' =>    $this->sidebar(),
                'tongphat'=>$tongphat,
                'tonghoadon'=>$tonghoadon,
                'tonghoadon_huy'=>$tonghoadon_huy,
                'tongsvmua'=>$tongsvmua,
            ]);
        } else {
            return view('user_24.admin24.include.404');
        }
    }
    function data_thongkedongphuc(Request $request){
        $ngay_batdau = $request->input('ngay_batdau');
        $ngay_kethuc = $request->input('ngay_kethuc');
        // $dot_phat = $request->input('dot_phat');
        $dot_phat = 1;
        //Không có ngày bắt đầu,kết thúc ,đợt phát
        $data_all=DB::table('24_hoadon')
        ->join('24_danhmuc_sanpham', '24_hoadon.id_sanpham', '=', '24_danhmuc_sanpham.id')
        ->join('24_loaisanpham', '24_danhmuc_sanpham.id_loai', '=', '24_loaisanpham.id')
        ->select('24_loaisanpham.loai', DB::raw('SUM(24_hoadon.sl_phat) as sl_phat'))
        ->where('24_hoadon.trangthai',1)
        ->groupBy('24_loaisanpham.loai')
        ->get();
        // Có chọn ngày
        $data_ngay=DB::table('24_hoadon')
        ->join('24_danhmuc_sanpham', '24_hoadon.id_sanpham', '=', '24_danhmuc_sanpham.id')
        ->join('24_loaisanpham', '24_danhmuc_sanpham.id_loai', '=', '24_loaisanpham.id')
        ->select('24_loaisanpham.loai', DB::raw('SUM(24_hoadon.sl_phat) as sl_phat'))
        ->where('24_hoadon.trangthai', 0)
        ->when($ngay_batdau, function ($query) use ($ngay_batdau) {
            return $query->where('24_hoadon.ngaytao', '>=', $ngay_batdau);
        })
        ->when($ngay_kethuc, function ($query) use ($ngay_kethuc) {
            return $query->where('24_hoadon.ngaytao', '<=', $ngay_kethuc);
        })
        ->groupBy('24_loaisanpham.loai')
        ->get();
        //Chọn đợt
        $data_dot=DB::table('24_hoadon')
        ->join('24_danhmuc_sanpham', '24_hoadon.id_sanpham', '=', '24_danhmuc_sanpham.id')
        ->join('24_loaisanpham', '24_danhmuc_sanpham.id_loai', '=', '24_loaisanpham.id')
        ->select('24_loaisanpham.loai', DB::raw('SUM(24_hoadon.sl_phat) as sl_phat'))
        ->where('24_hoadon.trangthai', 0)
        ->when($dot_phat, function ($query) use ($dot_phat) {
            return $query->where('24_hoadon.id_dotphat', '>=', $dot_phat);
        })
        ->groupBy('24_loaisanpham.loai')
        ->get();
        //Loại
        $data_all=DB::table('24_hoadon')
        ->join('24_danhmuc_sanpham', '24_hoadon.id_sanpham', '=', '24_danhmuc_sanpham.id')
        ->join('24_loaisanpham', '24_danhmuc_sanpham.id_loai', '=', '24_loaisanpham.id')
        ->select('24_loaisanpham.loai', DB::raw('SUM(24_hoadon.sl_phat) as sl_phat'))
        ->where('24_hoadon.trangthai',1)
        ->groupBy('24_loaisanpham.loai')
        ->get();
        return [
            'data_dot' =>$data_dot,
            'data_all' =>$data_all,
            'data_ngay' =>$data_ngay,
        ];
    }
    //DS thống kê phát
    function ds_thongke_phat(){
        $ds_thongke_phat =  DB::table('24_hoadon')
        ->join('24_thongtincanhan', '24_hoadon.id_sinhvien', '=', '24_thongtincanhan.id_taikhoan')
        ->join('24_accountsadmin', '24_hoadon.id_nguoiphat', '=', '24_accountsadmin.id')
        ->join('24_danhmuc_dotphat', '24_hoadon.id_dotphat', '=', '24_danhmuc_dotphat.id')
        ->join('24_dotnhap', '24_hoadon.id_dotnhap', '=', '24_dotnhap.id')
        ->join(DB::raw('(SELECT
            24_danhmuc_sanpham.id AS id,
            24_danhmuc_nhasanxuat.nhasanxuat AS ten_nhasanxuat,
            24_danhmuc_size.size AS ten_size,
            24_loaisanpham.loai AS ten_loai
        FROM 24_danhmuc_sanpham
        INNER JOIN 24_danhmuc_nhasanxuat ON 24_danhmuc_sanpham.id_nhasanxuat = 24_danhmuc_nhasanxuat.id
        INNER JOIN 24_danhmuc_size ON 24_danhmuc_sanpham.id_size = 24_danhmuc_size.id
        INNER JOIN 24_loaisanpham ON 24_danhmuc_sanpham.id_loai = 24_loaisanpham.id) AS tt_sanpham'), '24_hoadon.id_sanpham', '=', 'tt_sanpham.id')
        ->select([
            '24_thongtincanhan.hoten AS hoten_sv',
            '24_accountsadmin.name AS hoten_nguoiphat',
            '24_thongtincanhan.cccd AS cccd',
            '24_thongtincanhan.ngaysinh AS ngaysinh',
            '24_hoadon.mahoadon AS mahoadon',
            '24_hoadon.sl_phat AS sl_phat',
            '24_hoadon.id AS id',
            '24_danhmuc_dotphat.dot AS dot_phat',
            '24_dotnhap.dotnhap AS dot_nhap',
            'tt_sanpham.ten_loai AS loai',
            'tt_sanpham.ten_size AS size',
            'tt_sanpham.ten_nhasanxuat AS nsx',
            DB::raw("DATE_FORMAT(24_hoadon.ngaytao, '%d-%m-%Y') AS ngaytao"),
            DB::raw('DAY(24_hoadon.ngaytao) AS ngay'),
            DB::raw('MONTH(24_hoadon.ngaytao) AS thang'),
            DB::raw('YEAR(24_hoadon.ngaytao) AS nam')
        ])
        // ->where('24_hoadon.trangthai', 0)
        ->get();
        $json_data['data'] = $ds_thongke_phat;
        $res = json_encode($json_data);
        return  $res;
    }
    function select2_hoadon_search(){
        $trangthai = array(
            [
                'id' => -1,
                'text' => "Tất cả"
            ],
            [
                'id' => 0,
                'text' => "Đang hoạt động"
            ],
            [
                'id' => 1,
                'text' => "Ngưng hoạt động"
            ]
        );
        return array(
            'select_loai' => $this->load_seclectbox('24_loaisanpham','id','loai',0,'Tất cả loại'),
            'select_size' => $this->load_seclectbox('24_danhmuc_size','id','size',0,'Tất cả size'),
            'select_nhasanxuat' => $this->load_seclectbox('24_danhmuc_nhasanxuat','id','nhasanxuat',0,'Tất cả NSX'),
            'select_dotphat' => $this->load_seclectbox('24_danhmuc_dotphat','id','dot',0,'Tất cả đợt'),
            'select_dotnhap' => $this->load_seclectbox('24_dotnhap','id','dotnhap',0,'Tất cả đợt'),
            'select_trangthai' => $trangthai,


        );
    }
    public function data_timkiem_hoadon(Request $request){
        $dotphat = $request->input('dotphat');
        $mahoadon = $request->input('mahoadon');
        $loai = $request->input('loai');
        $size = $request->input('size');
        $nsx = $request->input('nsx');
        $trangthai = $request->input('trangthai');
        $cccd = $request->input('cccd');
        $start = $request->input('start');
        $end = $request->input('end');
        if (!empty($start)) {
            $start .= ' 00:00:00';
        }
        if (!empty($end)) {
            $end .= ' 23:59:59';
        }
        $ds_thongke_phat = DB::table('24_hoadon')
        ->join('24_thongtincanhan', '24_hoadon.id_sinhvien', '=', '24_thongtincanhan.id_taikhoan')
        ->join('24_accountsadmin', '24_hoadon.id_nguoiphat', '=', '24_accountsadmin.id')
        ->join('24_danhmuc_dotphat', '24_hoadon.id_dotphat', '=', '24_danhmuc_dotphat.id')
        ->join('24_dotnhap', '24_hoadon.id_dotnhap', '=', '24_dotnhap.id')
        ->join(DB::raw('(SELECT
                24_danhmuc_sanpham.id AS id,
                24_danhmuc_nhasanxuat.nhasanxuat AS ten_nhasanxuat,
                24_danhmuc_nhasanxuat.id AS id_nhasanxuat,
                24_danhmuc_size.size AS ten_size,
                24_danhmuc_size.id AS id_size,
                24_loaisanpham.loai AS ten_loai,
                24_loaisanpham.id AS id_loai
            FROM 24_danhmuc_sanpham
            INNER JOIN 24_danhmuc_nhasanxuat ON 24_danhmuc_sanpham.id_nhasanxuat = 24_danhmuc_nhasanxuat.id
            INNER JOIN 24_danhmuc_size ON 24_danhmuc_sanpham.id_size = 24_danhmuc_size.id
            INNER JOIN 24_loaisanpham ON 24_danhmuc_sanpham.id_loai = 24_loaisanpham.id) AS tt_sanpham'), '24_hoadon.id_sanpham', '=', 'tt_sanpham.id')
            ->select([
                '24_thongtincanhan.hoten AS hoten_sv',
                '24_accountsadmin.name AS hoten_nguoiphat',
                '24_thongtincanhan.cccd AS cccd',
                '24_thongtincanhan.ngaysinh AS ngaysinh',
                '24_hoadon.mahoadon AS mahoadon',
                '24_hoadon.sl_phat AS sl_phat',
                '24_hoadon.id AS id',
                '24_hoadon.trangthai AS trangthai',
                '24_danhmuc_dotphat.dot AS dot_phat',
                '24_dotnhap.dotnhap AS dot_nhap',
                'tt_sanpham.ten_loai AS loai',
                'tt_sanpham.ten_size AS size',
                'tt_sanpham.ten_nhasanxuat AS nsx',
                DB::raw("DATE_FORMAT(24_hoadon.ngaytao, '%d-%m-%Y') AS ngaytao"),
                DB::raw('DAY(24_hoadon.ngaytao) AS ngay'),
                DB::raw('MONTH(24_hoadon.ngaytao) AS thang'),
                DB::raw('YEAR(24_hoadon.ngaytao) AS nam')
            ])
            ->when($dotphat, function ($query, $dotphat) {
                return $query->where('24_hoadon.id_dotphat', $dotphat);
            })
            ->when($mahoadon, function ($query, $mahoadon) {
                return $query->where('24_hoadon.mahoadon', $mahoadon);
            })
            ->when($loai, function ($query, $loai) {
                return $query->where('tt_sanpham.id_loai', $loai);
            })
            ->when($size, function ($query, $size) {
                return $query->where('tt_sanpham.id_size', $size);
            })
            ->when($nsx, function ($query, $nsx) {
                return $query->where('tt_sanpham.id_nhasanxuat', $nsx);
            })
            ->when($cccd, function ($query, $cccd) {
                return $query->where('24_thongtincanhan.cccd', $cccd);
            })
            ->when($start && $end && $start == $end, function ($query) use ($start) {
                return $query->whereDate('24_hoadon.ngaytao', '=', $start);
            })
            ->when($start && $end && $start != $end, function ($query) use ($start, $end) {
                return $query->whereBetween('24_hoadon.ngaytao', [$start, $end]);
            })
            ->when($start && !$end, function ($query, $start) {
                return $query->where('24_hoadon.ngaytao', '>=', $start);
            })
            ->when($end && !$start, function ($query, $end) {
            return $query->where('24_hoadon.ngaytao', '<=', $end);
            })
            ->when(isset($trangthai) && $trangthai != -1, function ($query) use ($trangthai) {
                return $query->where('24_hoadon.trangthai', $trangthai);
            });
        $data= $ds_thongke_phat;
        return $data;
    }
    function timkiem_hoadon(Request $request){
        $ds_thongkephat = $this->data_timkiem_hoadon($request)->get();
        if (!$ds_thongkephat->isEmpty()) {
            $json_data['data'] = $ds_thongkephat;
        } else {
            $json_data['data'] = [];
        }
        return response()->json($json_data);
    }
    function btt_excel_hdphat(Request $request){
        $mahoadon = $request->input('mahoadon');
        $dotphat = $request->input('dotphat');
        $loai = $request->input('loai');
        $size = $request->input('size');
        $nsx = $request->input('nsx');
        $trangthai = $request->input('trangthai');
        $cccd = $request->input('cccd');
        $start = $request->input('start');
        $end = $request->input('end');
        if (!empty($start)) {
            $start .= ' 00:00:00';
        }
        if (!empty($end)) {
            $end .= ' 23:59:59';
        }
        $mahoadon = $request->input('mahoadon');
        $cccd = $request->input('cccd');
        $noidung="";
        $status = 1;
        $validator = Validator::make(
            $request->all(),
            [
                'cccd' =>'nullable|regex:/^[a-zA-Z0-9]+$/',
                'mahoadon' => 'nullable|regex:/^[a-zA-Z0-9]+$/',
            ],
            [
                'cccd.regex' => 'CCCD chỉ được chứa chữ cái và số.',
                'mahoadon.regex' => 'Mã hóa đơn chỉ được chứa chữ cái và số.',
            ]
        );
        if ($validator->fails()) {
            $noidung = response()->json($validator->errors());
            $status = 0;
            return response()->json([
                'status' => $status,
                'noidung' => $noidung
            ]);
        }else{
            $title = 'DanhSachHoaDon_' . date("d-m-Y_H-i-s") . '.xlsx';
            return Excel::download(new Admin24_DanhSachHoaDon($dotphat, $mahoadon, $loai, $size, $nsx, $trangthai, $cccd, $start, $end), $title);
        }
    }
    //

    public function btt_excel_thongke_hd_phat(Request $request)
    {
        // Lấy các tham số từ request
        $mahoadon = $request->input('mahoadon');
        $dotphat = $request->input('dotphat');
        $loai = $request->input('loai');
        $size = $request->input('size');
        $nsx = $request->input('nsx');
        $trangthai = $request->input('trangthai');
        $cccd = $request->input('cccd');
        $start = $request->input('start');
        $end = $request->input('end');

        // Định dạng ngày giờ cho start và end
        if (!empty($start)) {
            $start .= ' 00:00:00';
        }
        if (!empty($end)) {
            $end .= ' 23:59:59';
        }

        // Lấy tên đợt phát nếu dotphat không phải là 0
        $ten_dotphat = 'All_đợt_phát';
        if ($dotphat != 0) {
            $dotphatData = DB::table('24_danhmuc_dotphat')->select('dot')->where('id', $dotphat)->first();
            if ($dotphatData) {
                $ten_dotphat = $dotphatData->dot;
            }
        }

        // Xác thực đầu vào
        $validator = Validator::make(
            $request->all(),
            [
                'cccd' => 'nullable|regex:/^[a-zA-Z0-9]+$/',
                'mahoadon' => 'nullable|regex:/^[a-zA-Z0-9]+$/',
            ],
            [
                'cccd.regex' => 'CCCD chỉ được chứa chữ cái và số.',
                'mahoadon.regex' => 'Mã hóa đơn chỉ được chứa chữ cái và số.',
            ]
        );

        // Kiểm tra lỗi xác thực
        if ($validator->fails()) {
            $noidung = response()->json($validator->errors());
            return response()->json([
                'status' => 0,
                'noidung' => $noidung
            ]);
        } else {
            // Tạo tiêu đề file Excel
            $title = 'DanhSachHoaDonThongKe_' . $ten_dotphat . '_Thời gian xuất_' . date("d-m-Y_H-i-s") . '.xlsx';

            // Xuất file Excel
            return Excel::download(new Admin24_DanhSachHoaDonThongKe($dotphat, $mahoadon, $loai, $size, $nsx, $trangthai, $cccd, $start, $end), $title);
        }
    }

    // BIểu đồ
    function bieudo_hoadon_phat(Request $request){
        $dotphat = $request->input('dotphat');
        $mahoadon = $request->input('mahoadon');
        $loai = $request->input('loai');
        $size = $request->input('size');
        $nsx = $request->input('nsx');
        $cccd = $request->input('cccd');
        $start = $request->input('start');
        $end = $request->input('end');
        $trangthai = $request->input('trangthai');
        if (!empty($start)) {
            $start .= ' 00:00:00';
        }
        if (!empty($end)) {
            $end .= ' 23:59:59';
        }
        // Truy vấn dữ liệu
        $ds_thongke_phat = DB::table('24_hoadon')
            ->join('24_thongtincanhan', '24_hoadon.id_sinhvien', '=', '24_thongtincanhan.id_taikhoan')
            ->join('24_accountsadmin', '24_hoadon.id_nguoiphat', '=', '24_accountsadmin.id')
            ->join('24_danhmuc_dotphat', '24_hoadon.id_dotphat', '=', '24_danhmuc_dotphat.id')
            ->join('24_dotnhap', '24_hoadon.id_dotnhap', '=', '24_dotnhap.id')
            ->join(DB::raw('(SELECT
                24_danhmuc_sanpham.id AS id,
                24_danhmuc_nhasanxuat.nhasanxuat AS ten_nhasanxuat,
                24_danhmuc_nhasanxuat.id AS id_nhasanxuat,
                24_danhmuc_size.size AS ten_size,
                24_danhmuc_size.id AS id_size,
                24_loaisanpham.loai AS ten_loai,
                24_loaisanpham.id AS id_loai
                FROM 24_danhmuc_sanpham
            INNER JOIN 24_danhmuc_nhasanxuat ON 24_danhmuc_sanpham.id_nhasanxuat = 24_danhmuc_nhasanxuat.id
            INNER JOIN 24_danhmuc_size ON 24_danhmuc_sanpham.id_size = 24_danhmuc_size.id
            INNER JOIN 24_loaisanpham ON 24_danhmuc_sanpham.id_loai = 24_loaisanpham.id) AS tt_sanpham'), '24_hoadon.id_sanpham', '=', 'tt_sanpham.id')
            ->select([
                'tt_sanpham.ten_loai AS loai',
                'tt_sanpham.ten_size AS size',
                'tt_sanpham.ten_nhasanxuat AS nsx',
                DB::raw('SUM(24_hoadon.sl_phat) AS tong_sl_phat')
            ])
            ->when($dotphat, function ($query, $dotphat) {
                return $query->where('24_hoadon.id_dotphat', $dotphat);
            })
            ->when($mahoadon, function ($query, $mahoadon) {
                return $query->where('24_hoadon.mahoadon', $mahoadon);
            })
            ->when($loai, function ($query, $loai) {
                return $query->where('tt_sanpham.id_loai', $loai);
            })
            ->when($size, function ($query, $size) {
                return $query->where('tt_sanpham.id_size', $size);
            })
            ->when($nsx, function ($query, $nsx) {
                return $query->where('tt_sanpham.id_nhasanxuat', $nsx);
            })
            ->when($cccd, function ($query, $cccd) {
                return $query->where('24_thongtincanhan.cccd', $cccd);
            })
            ->when($start && $end && $start == $end, function ($query) use ($start) {
                return $query->whereDate('24_hoadon.ngaytao', '=', $start);
            })
            ->when($start && $end && $start != $end, function ($query) use ($start, $end) {
                return $query->whereBetween('24_hoadon.ngaytao', [$start, $end]);
            })
            ->when($start && !$end, function ($query, $start) {
                return $query->where('24_hoadon.ngaytao', '>=', $start);
            })
            ->when($end && !$start, function ($query, $end) {
                return $query->where('24_hoadon.ngaytao', '<=', $end);
            })
            ->when(isset($trangthai) && $trangthai != -1, function ($query) use ($trangthai) {
                return $query->where('24_hoadon.trangthai', $trangthai);
            })
            ->groupBy(
                'tt_sanpham.ten_loai',
                'tt_sanpham.ten_size',
                'tt_sanpham.ten_nhasanxuat'
            )
            ->get();

        // Trả về dữ liệu dưới dạng JSON
        return response()->json($ds_thongke_phat);


    }
    function bat_validate(Request $request){
        $mahoadon = $request->input('mahoadon');
        $cccd = $request->input('cccd');
        $noidung="";
        $status = 1;
        $validator = Validator::make(
            $request->all(),
            [
                'cccd' =>'nullable|regex:/^[a-zA-Z0-9]+$/',
                'mahoadon' => 'nullable|regex:/^[a-zA-Z0-9]+$/',
            ],
            [
                'cccd.regex' => 'CCCD chỉ được chứa chữ cái và số.',
                'mahoadon.regex' => 'Mã hóa đơn chỉ được chứa chữ cái và số.',
            ]
        );
        if ($validator->fails()) {
            $noidung = response()->json($validator->errors());
            $status = 0;
        }
        return response()->json([
            'status' => $status,
            'noidung' => $noidung
        ]);
    }
    //View đợt phát
    function quanlydotphat(){
        $url = URL::current();
        $quyen = $this->kiemtraquyen_url($url);
        if ($quyen == 1) {
            return view('user_24.admin24.manage.quanlydongphuc.quanlydotphat',[
                'menu' =>$this->sidebar(),
            ]);
        } else {
            return view('user_24.admin24.include.404');
        }
    }
    function ds_dotphat(){
        $sql = DB::table(DB::raw("
                (
                    SELECT
                        *,
                        ROW_NUMBER() OVER (ORDER BY id) AS stt,
                        DATE(create_at) AS formatted_create_at
                    FROM 24_danhmuc_dotphat
                ) as t
            "))
            ->select("*")
            ->get();

        $json_data['data'] = $sql;
        $res = json_encode($json_data);
        return $res;
    }
    function them_dot(Request $request) {
        $name = $request->input('name');
        $time = $request->input('time');
        $id_manhinh = $request->input('id_manhinh');
        $id_chucnang = $request->input('id_chucnang');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        $status = 1;
        $noidung = "ins_1";
        $kieudulieu="text";
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            try{
                $validator = Validator::make(
                    $request->all(),
                    [
                        'name' => 'required','regex:/^[a-zA-Z0-9]+$/',
                    ],
                    [
                        'name.required' => 'Vui lòng nhập tên đợt!!',
                        'name.regex' => 'Tên đợt chỉ gồm chữ cái và số!!',
                    ]
                );

                if ($validator->fails()) {
                    $noidung = response()->json($validator->errors());
                    $kieudulieu = "json";
                    $status = 0;
                }else{
                    $sql=DB::table('24_danhmuc_dotphat')->insert([
                        'dot' => $name,
                        'trangthai' => 0
                    ]);
                }
            } catch (Exception $e) {
                $status=0;
                $noidung="ins_0";
            }

        }else{
            $status=0;
            $noidung="rol_2";
        }
        return [
            'status' => $status,
            'noidung' => $noidung,
            'kieudulieu' => $kieudulieu,
        ];
    }
    function change_trangthai_dotphat($id,$trangthai,Request $request) {
        $time = $request->input('time');
        $id_manhinh = $request->input('id_manhinh');
        $id_chucnang = $request->input('id_chucnang');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        $status = 1;
        $noidung = "upd_1";
        $cleanHtml = (int)Purifier::clean($trangthai);
        if($cleanHtml==1){
            $cleanHtml=0;
        }else{
            $cleanHtml=1;
        }
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            try{
                $sql=DB::table('24_danhmuc_dotphat')->where('id',$id)->update([
                    'trangthai' => $cleanHtml
                ]);
            } catch (Exception $e) {
                $status=0;
                $noidung="upd_0";
            }
        }else{
            $status=0;
            $noidung="rol_2";
        }
        return [
            'status' => $status,
            'noidung' => $noidung,
        ];
    }
    function change_dot(Request $request) {
        $time = $request->input('time');

        $id = $request->input('id');
        $value = $request->input('value');
        $trangthai = $request->input('trangthai');

        $id_manhinh = $request->input('id_manhinh');
        $id_chucnang = $request->input('id_chucnang');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        $status = 1;
        $noidung = "upd_1";
        $kieudulieu="text";
        $clean_val = Purifier::clean($value);
        // $clean_val = $value;
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            try{
                $rules = [];//Điều kiện validate
                $messages = [];//Thông báo của validate
                switch ($trangthai) {
                    case 'dot':
                        // Trường hợp validate tên đợt
                        $rules['clean_val'] = 'required|regex:/^[\p{L}\p{N}\s]+$/u';
                        // $rules['value'] = 'required';
                        $messages = [
                            'clean_val.required' => 'Vui lòng nhập tên đợt!!',
                            'clean_val.regex' => 'Tên đợt chỉ bao gồm số, chữ cái và khoảng trắng!!',
                        ];
                        break;

                    case 'create_at':
                        // Trường hợp validate ngày tạo
                        $rules['clean_val'] = 'required|date';
                        $messages = [
                            'clean_val.required' => 'Ngày tạo không hợp lệ',
                            'clean_val.date' => 'Định dạng ngày không đúng',
                        ];
                        break;
                    default:
                        break;
                }
                $validator = Validator::make(
                    ['clean_val' => $clean_val],
                    $rules,
                    $messages
                );
                if ($validator->fails()) {
                    return response()->json([
                        'status' => 0,
                        'noidung' => $validator->errors()->first(),
                        'kieudulieu' => 'json',
                    ]);
                }else{
                    $sql=DB::table('24_danhmuc_dotphat')->where('id',$id)->update([
                        $trangthai => $clean_val
                    ]);
                }
            } catch (Exception $e) {
                $status=0;
                $noidung="upd_0";
            }
        }else{
            $status=0;
            $noidung="rol_2";
        }
        return [
            'status' => $status,
            'noidung' => $noidung,
            'kieudulieu' => $kieudulieu,
            // 'value' => $value,
            // 'clean_val' => $clean_val,
        ];
    }



    // import thong tin sinh vien
    public function upload_ttsv(Request $request){ //Name, Email, Mật khẩu, google_id
        if ($request->hasFile('upload_ttsv_open') && $request->file('upload_ttsv_open')->isValid()) {
            $file = $request->file('upload_ttsv_open');
            if ($file->getMimeType() != 'application/vnd.ms-excel' && $file->getMimeType() != 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                return 'imp_0';
            }
            $rows = Excel::toCollection(null, $file)->first();
                $rows = Excel::toCollection(null, $file)->first();  // Đọc dữ liệu từ sheet đầu tiên
                $pattern_email = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
                $pattern_cccd = '/^[a-zA-Z0-9]{9}$|^[a-zA-Z0-9]{12}$/';
                $pattern_hoten = '/^[\p{L}0-9 -]+$/u';
                $pattern_mssv = '/^[\p{L}0-9 -]+$/u';
                $pattern_ngaysinh = '/^(0?[1-9]|[12][0-9]|3[01])\/(0?[1-9]|1[0-2])\/\d{4}$/';
                $pattern_gioitinh = '/^(Nam|Nữ)$/';
                $pattern_sdt = '/^0\d{9}$/';
                $pattern_malop = '/^[\p{L}0-9 -]+$/u';
                foreach ($rows as $index => $row) {
                    if ($index == 0) {
                        continue;  // Bỏ qua dòng tiêu đề (hàng đầu tiên)
                    }

                    $email = $row[0];  // Giả sử email ở cột đầu tiên
                    $cccd = $row[1];
                    $hoten = $row[2];
                    $ngaysinh = $row[3];
                    $gioitinh = $row[4];
                    $sdt = $row[5];
                    $mssv = $row[6];
                    $malop = $row[7];
                    $check_email = preg_match($pattern_email, $email);
                    $check_cccd = preg_match($pattern_cccd, $cccd);
                    $check_hoten = preg_match($pattern_hoten, $hoten);
                    $check_ngaysinh = preg_match($pattern_ngaysinh, $ngaysinh);
                    $check_gioitinh = preg_match($pattern_gioitinh, $gioitinh);
                    $check_sdt = preg_match($pattern_sdt, $sdt);
                    $check_mssv = preg_match($pattern_mssv, $mssv);
                    $check_malop = preg_match($pattern_malop, $malop);
                    if ($check_email && $check_cccd && $check_hoten && $check_ngaysinh && $check_gioitinh && $check_sdt && $check_mssv && $check_malop) {
                        $tmp_gioitinh = $gioitinh == 'Nam' ? 0 : 1;
                        $formattedDate = Carbon::createFromFormat('d/m/Y', $ngaysinh)->format('Y-m-d');
                        $tmp_row_acc = array(
                            'name' => 'IP_TTSV' . $email,
                            'email' => $email,
                            'password' => '$2a$12$JDFLwwliUgN5bIgD0fgRseDldXUjf0wwHuI5a8DCbpUiluVhTrkPu',
                            'google_id' => 0,
                            'cccd_bo' => $cccd,
                        );
                        $tmp_row_24ttcn = array(
                            'cccd' => $cccd,
                            'hoten' => $hoten,
                            'ngaysinh' => $formattedDate,
                            'gioitinh' => $tmp_gioitinh,
                            'dienthoai' => $sdt
                        );
                        $tmp_row_24mssv = array(
                            'cccd' => $cccd,
                            'mssv' => $mssv,
                            'malop' => $malop,

                        );
                        $data_upload_acccount[] = $tmp_row_acc;
                        $data_upload_24ttcn[] = $tmp_row_24ttcn;
                        $data_upload_24mssv[] = $tmp_row_24mssv;
                        $rows[$index][] = 'Thành công';  // Thêm thông báo thành công
                    } else {
                        // Nếu không hợp lệ, thêm lỗi vào mảng
                        !$check_email ? $re_mail = 'Email chưa đúng định dạng;' : $re_mail = "";
                        !$check_cccd ? $re_cccd = 'Cccd chưa đúng định dạng;' : $re_cccd = "";
                        !$check_hoten ? $re_hoten = 'Họ tên chứa kí tự đặt biệt;' : $re_hoten = "";
                        !$check_ngaysinh ? $re_ngaysinh = 'Ngày sinh chưa đúng định dạng;' : $re_ngaysinh = "";
                        !$check_gioitinh ? $re_gioitinh = 'Giới tính phải Nam hoặc Nữ;' : $re_gioitinh = "";
                        !$check_sdt ? $re_sdt = 'SĐT chưa đúng định dạng;' : $re_sdt = "";
                        // !$check_lop ? $re_lop = 'Lớp chứa kí tự đặt biệt;' : $re_lop = "";
                        !$check_malop ? $re_malop = 'Mã lớp chứa kí tự đặt biệt;' : $re_malop = "";
                        $rows[$index][] = preg_replace('/\s+/', ' ', trim($re_mail . ' ' . $re_cccd . ' ' . $re_hoten . ' ' . $re_ngaysinh . ' ' . $re_gioitinh . ' ' . $re_sdt. ' ' . $re_malop));  // Thêm thông báo lỗi
                    }
                }
                // Cập nhật dữ liệu vào database
                // Thực hiện upsert dữ liệu vào bảng
                DB::table('account24s')->upsert(
                    $data_upload_acccount,
                    ['cccd_bo'],
                    ['name', 'email', 'password', 'google_id']
                );

                // Lấy cccd_bo từ $data_upload và truy vấn để lấy id tương ứng
                $cccd_bos = array_column($data_upload_acccount, 'cccd_bo');
                $updated_records = DB::table('account24s')
                    ->whereIn('cccd_bo', $cccd_bos)
                    ->pluck('id', 'cccd_bo')  // Lấy id và cccd_bo, tạo mảng kết hợp
                    ->toArray();

                // Cập nhật id vào $data_upload
                foreach ($data_upload_24ttcn as $key => $item) {
                    if (isset($updated_records[$item['cccd']])) {
                        $data_upload_24ttcn[$key]['id_taikhoan'] = $updated_records[$item['cccd']];  // Cập nhật id vào mảng
                    }
                }

                DB::table('24_thongtincanhan')->upsert(
                    $data_upload_24ttcn,
                    ['id_taikhoan'],
                    ['cccd', 'hoten', 'ngaysinh', 'gioitinh', 'dienthoai']
                );
                $ten_lop = array_column($data_upload_24mssv, 'malop');




                $arr_idlop = DB::table('24_lop')
                    ->whereIn('malop', $ten_lop)
                    ->get(['malop', 'id', 'idnganh', 'idchuyennganh', 'idkhoas'])
                    ->groupBy('malop') // Nhóm theo 'malop'
                    ->map(function ($rows) {
                        return $rows->map(function ($row) {
                            return [
                                'id' => $row->id,
                                'idnganh' => $row->idnganh,
                                'idchuyennganh' => $row->idchuyennganh,
                                'idkhoas' => $row->idkhoas,
                            ];
                        });
                    })
                    ->toArray();

                foreach ($data_upload_24mssv as $key => $item) {
                    if (isset($arr_idlop[$item['malop']])) {
                        // Nếu tìm thấy malop, gán giá trị vào các trường
                        $data_upload_24mssv[$key]['id_lop'] = $arr_idlop[$item['malop']][0]['id'];
                        $data_upload_24mssv[$key]['id_nganh'] = $arr_idlop[$item['malop']][0]['idnganh'];
                        $data_upload_24mssv[$key]['id_chuyennganh'] = $arr_idlop[$item['malop']][0]['idchuyennganh'];
                        $data_upload_24mssv[$key]['namts'] = $arr_idlop[$item['malop']][0]['idkhoas'];
                        unset($data_upload_24mssv[$key]['malop']);
                    } else {
                        foreach ($rows as $index => $row) {
                            if ($index == 0) {
                                continue;  // Bỏ qua dòng tiêu đề (hàng đầu tiên)
                            }
                            // Kiểm tra nếu malop không tồn tại trong $rows
                            if ($row[7] == $item['malop']) {
                                $rows[$index][8] = 'Mã lớp không tồn tại';
                                unset($data_upload_24mssv[$key]); // Loại bỏ phần tử khỏi mảng
                            }
                        }
                    }
                }
                foreach ($data_upload_24mssv as $key => $item) {
                    if (isset($updated_records[$item['cccd']])) {
                        $data_upload_24mssv[$key]['id_taikhoan'] = $updated_records[$item['cccd']];  // Cập nhật id vào mảng
                    }
                    unset($data_upload_24mssv[$key]['cccd']);
                }
                DB::table('24_mssv')->upsert(
                    $data_upload_24mssv,
                    ['id_taikhoan'],
                    ['mssv','id_nganh', 'id_chuyennganh', 'namts', 'id_lop']
                );
                    return array(
                        'trangthai' => 'imp_1',
                        'rows' => $rows,
                    );
        } else {
            return 'imp_0';
        }











    }
    //Kho
    function quanlykho(){
        $url = URL::current();
        $quyen = $this->kiemtraquyen_url($url);
        if ($quyen == 1) {
            return view('user_24.admin24.manage.quanlydongphuc.quanlykho',[
                'menu' =>$this->sidebar(),
            ]);
        } else {
            return view('user_24.admin24.include.404');
        }
    }
    //Danh sách đồng phục trong kho
    function ds_kho(Request $request){
        $dotnhap = $request->input('dotnhap');
        $trangthai = $request->input('trangthai');
        $loai = $request->input('loai');
        $size = $request->input('size');
        $nsx = $request->input('nsx');

        $data = DB::table('24_kho')
            ->select(
                DB::raw('ROW_NUMBER() OVER(ORDER BY 24_kho.id) as stt'), // Sử dụng ROW_NUMBER để tạo cột stt
                // DB::raw('SUM(24_kho.soluongton) OVER(PARTITION BY 24_kho.idsanpham) as total_soluongton'), // Tổng số lượng tồn theo idsanpham
                '24_danhmuc_size.size as size',
                '24_kho.id as id',
                '24_loaisanpham.loai as loai',
                '24_danhmuc_nhasanxuat.nhasanxuat as nsx',
                '24_kho.soluongton as slton',
                '24_kho.trangthai as trangthai',
                '24_dotnhap.dotnhap as dotnhap',
                '24_dotnhap.id as id_dotnhap'
            )
            ->join('24_danhmuc_sanpham', '24_kho.idsanpham', '=', '24_danhmuc_sanpham.id')
            ->join('24_dotnhap', '24_kho.id_dotnhap', '=', '24_dotnhap.id')
            ->join('24_loaisanpham', '24_danhmuc_sanpham.id_loai', '=', '24_loaisanpham.id')
            ->join('24_danhmuc_size', '24_danhmuc_sanpham.id_size', '=', '24_danhmuc_size.id')
            ->join('24_danhmuc_nhasanxuat', '24_danhmuc_sanpham.id_nhasanxuat', '=', '24_danhmuc_nhasanxuat.id')
            ->when($dotnhap, function ($query, $dotnhap) {
                return $query->where('24_kho.id_dotnhap', $dotnhap);
            })
            ->when(isset($trangthai) && $trangthai != -1, function ($query) use ($trangthai) {
                return $query->where('24_kho.trangthai', $trangthai);
            })
            ->when($loai, function ($query, $loai) {
                return $query->where('24_danhmuc_sanpham.id_loai', $loai);
            })
            ->when($size, function ($query, $size) {
                return $query->where('24_danhmuc_sanpham.id_size', $size);
            })
            ->when($nsx, function ($query, $nsx) {
                return $query->where('24_danhmuc_sanpham.id_nhasanxuat', $nsx);
            })
            ->get();

        return response()->json(['data' => $data]);
    }
    //đổi trạng thái kho
    function change_trangthai_kho(Request $request){
        $time = $request->input('time');
        $id_manhinh = $request->input('id_manhinh');
        $id_chucnang = $request->input('id_chucnang');
        $active = $request->input('active');
        $id_admin = Auth::guard('loginadmin')->user()->id;
        $id = $request->input('id');
        $trangthai = $request->input('trangthai');
        $arr_check = [];
        $status = 0;
        $noidung = "upd_0";
        $cleanHtml = (int)Purifier::clean($trangthai);
        if($cleanHtml==1){
            $cleanHtml=0;
        }else{
            $cleanHtml=1;
        }
        if ($this->kiemtraquyen($id_admin, $id_manhinh, $id_chucnang, $time, $active) == 1) {
            DB::beginTransaction();
            try{
                $get_in4 = DB::table('24_kho')
                ->join('24_danhmuc_sanpham', '24_kho.idsanpham', '=', '24_danhmuc_sanpham.id')
                ->join('24_loaisanpham', '24_danhmuc_sanpham.id_loai', '=', '24_loaisanpham.id')
                ->join('24_danhmuc_size', '24_danhmuc_sanpham.id_size', '=', '24_danhmuc_size.id')
                ->select(
                    '24_danhmuc_sanpham.id_loai AS id_loai',
                    '24_danhmuc_sanpham.id_size AS id_size',
                    '24_danhmuc_sanpham.id AS id_sanpham',
                    '24_kho.id_dotnhap AS id_dotnhap',
                )
                ->where('24_kho.id',$id)->first();

                if($get_in4){
                    $id_sanpham = $get_in4->id_sanpham;
                    $id_size = $get_in4->id_size;
                    $id_loai = $get_in4->id_loai;
                    $id_dotnhap = $get_in4->id_dotnhap;

                    $check_dieukien = DB::table('24_kho')
                    ->join('24_danhmuc_sanpham', '24_kho.idsanpham', '=', '24_danhmuc_sanpham.id')
                    ->join('24_loaisanpham', '24_danhmuc_sanpham.id_loai', '=', '24_loaisanpham.id')
                    ->join('24_danhmuc_size', '24_danhmuc_sanpham.id_size', '=', '24_danhmuc_size.id')
                    ->join('24_danhmuc_nhasanxuat', '24_danhmuc_sanpham.id_nhasanxuat', '=', '24_danhmuc_nhasanxuat.id')
                    ->join('24_dotnhap', '24_kho.id_dotnhap', '=', '24_dotnhap.id')
                    ->select('*')
                    ->where('24_kho.trangthai', 0)
                    ->where('24_danhmuc_sanpham.id_loai', $id_loai)
                    ->where('24_danhmuc_sanpham.id_size', $id_size)
                    ->get();
                    $check_dieukien_loai_size_nsx = DB::table('24_kho')
                    ->join('24_danhmuc_sanpham', '24_kho.idsanpham', '=', '24_danhmuc_sanpham.id')
                    ->join('24_loaisanpham', '24_danhmuc_sanpham.id_loai', '=', '24_loaisanpham.id')
                    ->join('24_danhmuc_size', '24_danhmuc_sanpham.id_size', '=', '24_danhmuc_size.id')
                    ->join('24_danhmuc_nhasanxuat', '24_danhmuc_sanpham.id_nhasanxuat', '=', '24_danhmuc_nhasanxuat.id')
                    ->select(
                        '24_danhmuc_sanpham.id_loai AS id_loai',
                        '24_danhmuc_sanpham.id_size AS id_size',
                        '24_danhmuc_sanpham.id AS id_sanpham',
                    )
                    ->where('24_loaisanpham.trangthai',1)
                    ->where('24_danhmuc_size.trangthai',1)
                    ->where('24_danhmuc_nhasanxuat.trangthai',1)
                    ->where('24_danhmuc_sanpham.trangthai',1)
                    ->where('24_kho.id',$id)->get();

                    $check_loai = DB::table('24_kho')
                    ->join('24_danhmuc_sanpham', '24_kho.idsanpham', '=', '24_danhmuc_sanpham.id')
                    ->join('24_loaisanpham', '24_danhmuc_sanpham.id_loai', '=', '24_loaisanpham.id')
                    ->select(
                        '24_danhmuc_sanpham.id_loai AS id_loai',
                        '24_loaisanpham.loai AS tenloai',
                        '24_danhmuc_sanpham.id AS id_sanpham',
                    )
                    ->where('24_loaisanpham.trangthai',0)
                    ->where('24_kho.id',$id)->get();

                    $check_size = DB::table('24_kho')
                    ->join('24_danhmuc_sanpham', '24_kho.idsanpham', '=', '24_danhmuc_sanpham.id')
                    ->join('24_danhmuc_size', '24_danhmuc_sanpham.id_size', '=', '24_danhmuc_size.id')
                    ->select(
                        '24_danhmuc_sanpham.id_size AS id_size',
                        '24_danhmuc_size.size AS tensize',
                        '24_danhmuc_sanpham.id AS id_sanpham',
                    )
                    ->where('24_danhmuc_size.trangthai',0)
                    ->where('24_kho.id',$id)->get();

                    $check_nhasanxuat = DB::table('24_kho')
                    ->join('24_danhmuc_sanpham', '24_kho.idsanpham', '=', '24_danhmuc_sanpham.id')
                    ->join('24_danhmuc_nhasanxuat', '24_danhmuc_sanpham.id_nhasanxuat', '=', '24_danhmuc_nhasanxuat.id')
                    ->select(
                        '24_danhmuc_sanpham.id_nhasanxuat AS id_nhasanxuat',
                        '24_danhmuc_nhasanxuat.nhasanxuat AS tennhasanxuat',
                        '24_danhmuc_sanpham.id AS id_sanpham',
                    )
                    ->where('24_danhmuc_nhasanxuat.trangthai',0)
                    ->where('24_kho.id',$id)->get();

                    $check_danhmuc_sanpham = DB::table('24_kho')
                    ->join('24_danhmuc_sanpham', '24_kho.idsanpham', '=', '24_danhmuc_sanpham.id')
                    ->select(
                        '24_danhmuc_sanpham.id AS id_sanpham',
                    )
                    ->where('24_danhmuc_sanpham.trangthai',0)
                    ->where('24_kho.id',$id)->get();
                    if(count($check_loai)>0){
                        $arr_check [] = "Loại sản phẩm";
                    }
                    // Kiểm tra từng điều kiện và thêm vào mảng $arr_check
                    if (count($check_size) > 0) {
                        $arr_check[] = "Size";
                    }
                    if (count($check_nhasanxuat) > 0) {
                        $arr_check[] = "Nhà sản xuất";
                    }
                    if (count($check_danhmuc_sanpham) > 0) {
                        $arr_check[] = "Sản phẩm";
                    }

                    // Nếu có ít nhất một điều kiện bị khóa, tạo chuỗi thông báo
                    if (count($arr_check) > 0) {
                        $res_khoa = implode(", ", $arr_check) . " đang bị khóa! Hãy mở khóa rồi quay lại!";
                    } else {
                        $res_khoa = ""; // Nếu không có gì bị khóa thì để trống
                    }
                    //Check giohang
                    $sql_Check_giohang = DB::table('24_giohang_dongphuc')
                    ->where('trangthai', 0)
                    ->where('id_sanpham', $id_sanpham)
                    ->where('id_dotnhap', $id_dotnhap)
                    ->selectRaw('count(*) as count, sum(soluong) as tong_soluong')
                    ->first();

                    if($cleanHtml == 1){
                        $sql=DB::table('24_kho')->where('id',$id)->update([
                            'trangthai' => $cleanHtml
                        ]);
                        if($sql){
                            if($sql_Check_giohang->tong_soluong > 0){
                                $sql_update_giohang = DB::table('24_giohang_dongphuc')
                                ->where('trangthai', 0)
                                ->where('id_sanpham', $id_sanpham)
                                ->where('id_dotnhap', $id_dotnhap)
                                ->update(['trangthai' => 1]);
                                if($sql_update_giohang > 0){
                                    DB::commit();
                                    $status=1;
                                    $noidung="upd_1";
                                }else{
                                    DB::rollBack();
                                    $status=0;
                                    $noidung="upd_0";
                                }
                            }else{
                                DB::commit();
                                $status=1;
                                $noidung="upd_1";
                            }
                        }else{
                            DB::rollBack();
                            $status=0;
                            $noidung="upd_0";
                        }
                    }else{
                        if(count($check_dieukien) < 1 ){
                            if(count($check_dieukien_loai_size_nsx) >= 1){
                                $sql=DB::table('24_kho')->where('id',$id)->update([
                                    'trangthai' => $cleanHtml
                                ]);
                                if($sql){
                                    DB::commit();
                                    $status=1;
                                    $noidung="upd_1";
                                }else{
                                    DB::rollBack();
                                    $status=0;
                                    $noidung="upd_2";
                                }
                            }else{
                                DB::rollBack();
                                $status=2;
                                $noidung = $res_khoa;
                            }
                        }else{
                            DB::rollBack();
                            $status=0;
                            $noidung="kho_2";
                        }
                    }
                }
            } catch (Exception $e) {
                DB::rollBack();
                $status=0;
                $noidung="upd_0";
            }
        }else{
            $status=0;
            $noidung="rol_2";
        }
        return [
            'status' => $status,
            'noidung' => $noidung,
        ];
    }
    function btt_excel_kho(Request $request){
        $dotnhap = $request->input('dotnhap');
        $trangthai = $request->input('trangthai');
        $loai = $request->input('loai');
        $size = $request->input('size');
        $nsx = $request->input('nsx');

        $noidung="";
        $status = 1;
        $title = 'DanhSachKho_' . date("d-m-Y_H-i-s") . '.xlsx';
        return Excel::download(new Admin24_DanhSachKho($dotnhap, $trangthai, $loai, $size, $nsx), $title);
    }
    //Thống kê kho
    function thongkekho(){
        $url = URL::current();
        $quyen = $this->kiemtraquyen_url($url);
        if ($quyen == 1) {
            return view('user_24.admin24.manage.quanlydongphuc.thongkekho',[
                'menu' =>$this->sidebar(),
            ]);
        } else {
            return view('user_24.admin24.include.404');
        }
    }


        //Thống kê - Phân tích số liêu
    //Theo giới tính
    function thsl_gioitinh(){
        $url = URL::current();
        $quyen = $this->kiemtraquyen_url($url);
        if ($quyen == 1) {
            return view('user_24.admin24.manage.thongkesolieu.thsl_gioitinh',[
                'menu' =>$this->sidebar(),
            ]);
        } else {
            return view('user_24.admin24.include.404');
        }
    }

    function thsl_loadbieudo_cacnam($namts,$namtn,$tinh,$truong){
        $data = DB::table('24_thongtincanhan')
        ->select('nguyenvong.namtuyensinh',DB::raw('COUNT(CASE WHEN 24_thongtincanhan.id_taikhoan is not null THEN 1 END) as dangky'),DB::raw('COUNT(CASE WHEN trungtuyen.id_taikhoan is not null THEN 1 END) as trungtuyen'),DB::raw('COUNT(CASE WHEN nhaphoc.id_taikhoan is not null AND nhaphoc.trangthai = 0 THEN 1 END) as danghoc'),DB::raw('COUNT(CASE WHEN nhaphoc.id_taikhoan is not null AND nhaphoc.trangthai = 1 THEN 1 END) as ruths'),DB::raw('COUNT(CASE WHEN gioitinh = 1 THEN 1 END) as sl_nu'),DB::raw('COUNT(CASE WHEN gioitinh = 0 THEN 1 END) as sl_nam'),DB::raw('COUNT(CASE WHEN trungtuyen.id_taikhoan is not null AND gioitinh = 0 THEN 1 END) as sl_nam_tt'),DB::raw('COUNT(CASE WHEN trungtuyen.id_taikhoan is not null AND gioitinh = 1 THEN 1 END) as sl_nu_tt'),DB::raw('COUNT(CASE WHEN nhaphoc.id_taikhoan is not null AND gioitinh = 0 AND nhaphoc.trangthai = 0 THEN 1 END) as sl_nam_nh'),DB::raw('COUNT(CASE WHEN nhaphoc.id_taikhoan is not null AND gioitinh = 1 AND nhaphoc.trangthai = 0 THEN 1 END) as sl_nu_nh'),DB::raw('COUNT(CASE WHEN nhaphoc.id_taikhoan is not null AND gioitinh = 1 AND nhaphoc.trangthai = 1 THEN 1 END) as sl_nu_rut'),DB::raw('COUNT(CASE WHEN nhaphoc.id_taikhoan is not null AND gioitinh = 0 AND nhaphoc.trangthai = 1 THEN 1 END) as sl_nam_rut'))
        ->join('24_namtotnghiep', '24_thongtincanhan.id_taikhoan', '24_namtotnghiep.id_taikhoan')
        ->join(DB::raw('(SELECT * FROM 24_truongthpt WHERE id_lop = 12) AS truong'), '24_thongtincanhan.id_taikhoan', 'truong.id_taikhoan')
        ->join('l_province', 'l_province.id', '=', 'truong.id_tinh')
        ->join('l_school', 'l_school.id', '=', 'truong.id_truong')
        ->join(DB::Raw('(SELECT id_taikhoan, namtuyensinh FROM `24_nguyenvong` INNER JOIN 24_danhmuc_namtuyensinh ON 24_danhmuc_namtuyensinh.id = 24_nguyenvong.idnam  GROUP BY id_taikhoan, namtuyensinh ) as nguyenvong'), 'nguyenvong.id_taikhoan', '=', '24_thongtincanhan.id_taikhoan')
        ->leftJoin(DB::Raw('(SELECT id_taikhoan, namtuyensinh FROM `24_trungtuyen` INNER JOIN 24_danhmuc_namtuyensinh ON 24_danhmuc_namtuyensinh.id = 24_trungtuyen.idnam  GROUP BY id_taikhoan, namtuyensinh) as trungtuyen'),'trungtuyen.id_taikhoan','=', '24_thongtincanhan.id_taikhoan')
        ->leftJoin(DB::Raw('(SELECT id_taikhoan, namts,trangthai FROM `24_mssv` INNER JOIN 24_danhmuc_namtuyensinh ON 24_danhmuc_namtuyensinh.id_nam = 24_mssv.namts  GROUP BY id_taikhoan, namts, trangthai) as nhaphoc'),'nhaphoc.id_taikhoan','=', '24_thongtincanhan.id_taikhoan')
        ->where(function($query) use ($namts) {
            if ($namts == 0) {
                $query->whereNotNull('nguyenvong.namtuyensinh');
            } else {
                $namtuyensinh = DB::table('24_danhmuc_namtuyensinh')->where('id',$namts)->first();
                $namtuyensinh ? $manam = $namtuyensinh->namtuyensinh  : $manam = -1;
                $query->where('nguyenvong.namtuyensinh', $manam);
            }
        })
        ->where(function($query) use ($namtn) {
            if ($namtn == 0) {
                $query->whereNotNull('24_namtotnghiep.namtotnghiep');
            } else {
                $query->where('24_namtotnghiep.namtotnghiep', $namtn);
            }
        })
        ->where(function($query) use ($tinh) {
            if ($tinh != 0) {
                $query->where('truong.id_tinh', $tinh);
            }
        })
        ->where(function($query) use ($truong) {
            if ($truong != 0) {
                $query->where('truong.id_truong', $truong);
            }
        })
        ->groupBy('nguyenvong.namtuyensinh')
        ->get();
        return response()->json($data);
    }

    function thsl_excel($namts,$namtn,$tinh,$truong){
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $title = 'ThongKeGioiTinh' . date("d-m-Y H:i:s") . '.xlsx';
        // //Xuất Excel
        return Excel::download(new Admin24_ThongKeGioiTinh_Excel($namts,$namtn,$tinh,$truong), $title);
    }

    //Theo Tỉnh - Thành Phố
    function getgeoson()
    {
        // Đọc file GeoJSON từ thư mục public
        $path = storage_path('app/public/geojson/diagioi.geojson'); // Hoặc đường dẫn bạn muốn
        if (file_exists($path)) {
            $geojson = file_get_contents($path);
            return response()->json(json_decode($geojson));
        }

        return response()->json(['error' => 'File not found'], 404);
    }



    //Theo Tỉnh/Thanh phố
    function thsl_tinh(){
        $url = URL::current();
        $quyen = $this->kiemtraquyen_url($url);
        if ($quyen == 1) {
            return view('user_24.admin24.manage.thongkesolieu.thsl_tinh',[
                'menu' =>$this->sidebar(),
            ]);
        } else {
            return view('user_24.admin24.include.404');
        }
    }
    function thsl_tinh_bieudo_tinh_data($namts,$namtn,$tinh,$top,$soluong,$iddot){
        // return $soluong;
        $subQueryNguyenvong = DB::table('24_nguyenvong')
        ->select('24_nguyenvong.id_taikhoan', '24_danhmuc_namtuyensinh.namtuyensinh')
        ->join('24_danhmuc_namtuyensinh', '24_danhmuc_namtuyensinh.id', '=', '24_nguyenvong.idnam')
         ->where(function($query) use ($iddot) {
            if ($iddot != 0) {
                $query->where('24_nguyenvong.iddot', $iddot);
            }
        })
        ->groupBy('24_nguyenvong.id_taikhoan', '24_danhmuc_namtuyensinh.namtuyensinh');
        $subQueryTrungtuyen = DB::table('24_trungtuyen')
        ->select('24_trungtuyen.id_taikhoan', '24_danhmuc_namtuyensinh.namtuyensinh')
        ->join('24_danhmuc_namtuyensinh', '24_danhmuc_namtuyensinh.id', '=', '24_trungtuyen.idnam')
        ->where(function($query) use ($iddot) {
            if ($iddot != 0) {
                $query->where('24_trungtuyen.iddot', $iddot);
            }
        })
        ->groupBy('24_trungtuyen.id_taikhoan', '24_danhmuc_namtuyensinh.namtuyensinh');
        $subQueryNhaphoc = DB::table('24_mssv')
        ->select('24_mssv.id_taikhoan', '24_danhmuc_namtuyensinh.namtuyensinh','24_mssv.trangthai')
        ->join('24_danhmuc_namtuyensinh', '24_danhmuc_namtuyensinh.id_nam', '=', '24_mssv.namts')
        ->where(function($query) use ($iddot) {
            if ($iddot != 0) {
                $query->where('24_mssv.iddotts', $iddot);
            }
        })
        ->groupBy('24_mssv.id_taikhoan', '24_danhmuc_namtuyensinh.namtuyensinh','24_mssv.trangthai');
        $data_tinh = DB::table('24_thongtincanhan')
        ->select('l_province.id as id_tinh','l_province.name_province as tentinh',DB::raw('COUNT(CASE WHEN 24_thongtincanhan.id_taikhoan is not null THEN 1 END) as dangky'),DB::raw('COUNT(CASE WHEN trungtuyen.id_taikhoan is not null THEN 1 END) as trungtuyen'),DB::raw('COUNT(CASE WHEN nhaphoc.id_taikhoan is not null AND nhaphoc.trangthai = 0 THEN 1 END) as danghoc'),DB::raw('COUNT(CASE WHEN nhaphoc.id_taikhoan is not null AND nhaphoc.trangthai = 1 THEN 1 END) as ruths'))
        ->join('24_namtotnghiep', '24_thongtincanhan.id_taikhoan', '24_namtotnghiep.id_taikhoan')
        ->join(DB::raw('(SELECT * FROM 24_truongthpt WHERE id_lop = 12) AS truong'), '24_thongtincanhan.id_taikhoan', 'truong.id_taikhoan')
        ->join('l_province', 'l_province.id', '=', 'truong.id_tinh')
        ->join('l_school', 'l_school.id', '=', 'truong.id_truong')
        ->joinSub(
            $subQueryNguyenvong, 'nguyenvong',
            function ($join) {
                $join->on('nguyenvong.id_taikhoan', '=', '24_thongtincanhan.id_taikhoan');
            }
        )
        ->leftJoinSub(
            $subQueryTrungtuyen, 'trungtuyen',
            function ($join) {
                $join->on('trungtuyen.id_taikhoan', '=', '24_thongtincanhan.id_taikhoan');
            }
        )
        ->leftJoinSub(
            $subQueryNhaphoc, 'nhaphoc',
            function ($join) {
                $join->on('nhaphoc.id_taikhoan', '=', '24_thongtincanhan.id_taikhoan');
            }
        )
        // join(DB::Raw('(SELECT id_taikhoan, namtuyensinh, iddot FROM `24_nguyenvong` INNER JOIN 24_danhmuc_namtuyensinh ON 24_danhmuc_namtuyensinh.id = 24_nguyenvong.idnam GROUP BY id_taikhoan, namtuyensinh, iddot ) as nguyenvong'), 'nguyenvong.id_taikhoan', '=', '24_thongtincanhan.id_taikhoan')
        // ->leftJoin(DB::Raw('(SELECT id_taikhoan, namtuyensinh FROM `24_trungtuyen` INNER JOIN 24_danhmuc_namtuyensinh ON 24_danhmuc_namtuyensinh.id = 24_trungtuyen.idnam GROUP BY id_taikhoan, namtuyensinh) as trungtuyen'),'trungtuyen.id_taikhoan','=', '24_thongtincanhan.id_taikhoan')
        // ->leftJoin(DB::Raw('(SELECT id_taikhoan, namts,trangthai FROM `24_mssv` INNER JOIN 24_danhmuc_namtuyensinh ON 24_danhmuc_namtuyensinh.id_nam = 24_mssv.namts  GROUP BY id_taikhoan, namts, trangthai) as nhaphoc'),'nhaphoc.id_taikhoan','=', '24_thongtincanhan.id_taikhoan')
        ->where(function($query) use ($namts) {
            if ($namts == 0) {
                $query->where('nguyenvong.namtuyensinh', -1);
            } else {
                $namtuyensinh = DB::table('24_danhmuc_namtuyensinh')->where('id',$namts)->first();
                $namtuyensinh ? $manam = $namtuyensinh->namtuyensinh  : $manam = -1;
                $query->where('nguyenvong.namtuyensinh', $manam);
            }
        })
        ->where(function($query) use ($namtn) {
            if ($namtn == 0) {
                $query->whereNotNull('24_namtotnghiep.namtotnghiep');
            } else {
                $query->where('24_namtotnghiep.namtotnghiep', $namtn);
            }
        })
        ->where(function($query) use ($tinh) {
            if ($tinh != 0) {
                $query->where('truong.id_tinh', $tinh);
            }
        })
        ->groupBy('l_province.id')
        ->havingRaw('COUNT(CASE WHEN nhaphoc.id_taikhoan is not null AND nhaphoc.trangthai = 0 THEN 1 END) >= ?', [$soluong]) // Điều kiện lọc "danghoc" lớn hơn $soluong
        ->orderByRaw('COUNT(CASE WHEN nhaphoc.id_taikhoan is not null AND nhaphoc.trangthai = 0 THEN 1 END) DESC') // Sắp xếp theo "danghoc" giảm dần
        // ->limit($top)
        ->get();
        return array(
            [
                'tinh' => response()->json($data_tinh),
            ]
        );
    }
    function thsl_tinh_excel($namts,$namtn,$tinh,$top,$soluong){
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $title = 'ThongKeNhapHocTheoTinh' . date("d-m-Y H:i:s") . '.xlsx';
        // //Xuất Excel
        return Excel::download(new Admin24_ThongKeNhapHocTheoTinh_Excel($namts,$namtn,$tinh,$top,$soluong), $title);
    }

    //Theo Tỉnh/Thanh phố
    function thsl_truongthpt(){
        $url = URL::current();
        $quyen = $this->kiemtraquyen_url($url);
        if ($quyen == 1) {
            return view('user_24.admin24.manage.thongkesolieu.thsl_truongthpt',[
                'menu' =>$this->sidebar(),
            ]);
        } else {
            return view('user_24.admin24.include.404');
        }
    }

    function thsl_tinh_bieudo_truong_data($namts,$namtn,$tinh,$truong,$top,$soluong){
        $data_truong = DB::table('24_thongtincanhan')
        ->select('truong.lon','truong.lat','truong.tentruong as tentruong',DB::raw('COUNT(CASE WHEN 24_thongtincanhan.id_taikhoan is not null THEN 1 END) as dangky'),DB::raw('COUNT(CASE WHEN trungtuyen.id_taikhoan is not null THEN 1 END) as trungtuyen'),DB::raw('COUNT(CASE WHEN nhaphoc.id_taikhoan is not null AND nhaphoc.trangthai = 0 THEN 1 END) as danghoc'),DB::raw('COUNT(CASE WHEN nhaphoc.id_taikhoan is not null AND nhaphoc.trangthai = 1 THEN 1 END) as ruths'))
        ->join('24_namtotnghiep', '24_thongtincanhan.id_taikhoan', '24_namtotnghiep.id_taikhoan')
        ->join(DB::raw('(SELECT l_school.lat,l_school.lon,24_truongthpt.id_tinh,24_truongthpt.id_taikhoan,CONCAT(l_province.name_province,"-",l_school.name_school) as tentruong,l_school.id as id FROM 24_truongthpt INNER JOIN l_province ON l_province.id = 24_truongthpt.id_tinh INNER JOIN l_school ON l_school.id = 24_truongthpt.id_truong  WHERE id_lop = 12) AS truong'), '24_thongtincanhan.id_taikhoan', 'truong.id_taikhoan')
        // ->join('l_province', 'l_province.id', '=', 'truong.id_tinh')
        // ->join('l_school', 'l_school.id', '=', 'truong.id_truong')
        ->join(DB::Raw('(SELECT id_taikhoan, namtuyensinh FROM `24_nguyenvong` INNER JOIN 24_danhmuc_namtuyensinh ON 24_danhmuc_namtuyensinh.id = 24_nguyenvong.idnam  GROUP BY id_taikhoan, namtuyensinh ) as nguyenvong'), 'nguyenvong.id_taikhoan', '=', '24_thongtincanhan.id_taikhoan')
        ->leftJoin(DB::Raw('(SELECT id_taikhoan, namtuyensinh FROM `24_trungtuyen` INNER JOIN 24_danhmuc_namtuyensinh ON 24_danhmuc_namtuyensinh.id = 24_trungtuyen.idnam  GROUP BY id_taikhoan, namtuyensinh) as trungtuyen'),'trungtuyen.id_taikhoan','=', '24_thongtincanhan.id_taikhoan')
        ->leftJoin(DB::Raw('(SELECT id_taikhoan, namts,trangthai FROM `24_mssv` INNER JOIN 24_danhmuc_namtuyensinh ON 24_danhmuc_namtuyensinh.id_nam = 24_mssv.namts  GROUP BY id_taikhoan, namts, trangthai) as nhaphoc'),'nhaphoc.id_taikhoan','=', '24_thongtincanhan.id_taikhoan')
        ->where(function($query) use ($namts) {

            if ($namts == 0) {
                $query->where('nguyenvong.namtuyensinh', -1);
            } else {
                $namtuyensinh = DB::table('24_danhmuc_namtuyensinh')->where('id',$namts)->first();
                $namtuyensinh ? $manam = $namtuyensinh->namtuyensinh  : $manam = -1;
                $query->where('nguyenvong.namtuyensinh', $manam);
            }
        })
        ->where(function($query) use ($namtn) {
            if ($namtn == 0) {
                $query->whereNotNull('24_namtotnghiep.namtotnghiep');
            } else {
                $query->where('24_namtotnghiep.namtotnghiep', $namtn);
            }
        })
        ->where(function($query) use ($tinh) {
            if ($tinh != 0) {
                $query->where('truong.id_tinh', $tinh);
            }
        })
        ->where(function($query) use ($truong) {
            if ($truong != 0) {
                $query->where('truong.id', $truong);
            }
        })
        ->groupBy('truong.id','truong.tentruong')
        ->havingRaw('COUNT(CASE WHEN nhaphoc.id_taikhoan is not null AND nhaphoc.trangthai = 0 THEN 1 END) >= ?', [$soluong]) // Điều kiện lọc "danghoc" lớn hơn $soluong
        ->orderByRaw('COUNT(CASE WHEN nhaphoc.id_taikhoan is not null AND nhaphoc.trangthai = 0 THEN 1 END) DESC') // Sắp xếp theo "danghoc" giảm dần
        // ->limit($top)
        ->get();
        return array(
            [
                'truong' => response()->json($data_truong),
            ]
        );

    }
    function thsl_truong_excel($namts,$namtn,$tinh,$truong,$top,$soluong){
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $title = 'ThongKeNhapHocTheoTruong' . date("d-m-Y H:i:s") . '.xlsx';
        // //Xuất Excel
        return Excel::download(new Admin24_ThongKeNhapHocTheoTruong_Excel($namts,$namtn,$tinh,$truong,$top,$soluong), $title);
    }
    function thsl_truongthpt_toado($truong){
        $data = DB::table('l_school')
        ->where('id',$truong)
        ->first();
        return $data;
    }
    function thsl_truong_popup_sumit($truong, $lon, $lat){
        DB::beginTransaction();
        $data = DB::table('l_school')
        ->where('id',$truong)
        ->update(
            [
                'lon' => $lon,
                'lat' => $lat,
            ]
        );
        switch ($data) {
            case '0':
                DB::commit();
                return response()->json(['messeger','Tọa độ đã có trên hệ thống, không cần phải cập nhật!']);
                break;
            case '1':
                DB::commit();
                return response()->json(['messeger','Cập nhật thành công']);
                break;
            default:
                DB::rollBack();
                return response()->json(['messeger','Hệ thống bị lỗi, vui lòng liên hệ admin']);# code...
                break;
        }
    }

    //Trúng tuyển - Nhập học
    function thsl_trungtuyen_nhaphoc(){
        $url = URL::current();
        $quyen = $this->kiemtraquyen_url($url);
        if ($quyen == 1) {
            return view('user_24.admin24.manage.thongkesolieu.thsl_trungtuyen_nhaphoc',[
                'menu' =>$this->sidebar(),
            ]);
        } else {
            return view('user_24.admin24.include.404');
        }
    }
    function data_thsl_trungtuyen_nhaphoc($idnam,$iddot){
        $data = DB::table('24_trungtuyen')
        ->select(
            DB::raw('if(24_mssv.id is null,0,1) as nhaphoc'),
            '24_trungtuyen.id_taikhoan as idts',
            '24_trungtuyen.xacnhan as xacnhan_ttsom',
            'diemxettuyen','idphuongthuc as maphuongthuc',
            DB::raw('if(idphuongthuc = 1, "HB", "THPT") as tenphuongthuc'),
            // '24_dottuyensinh.madot as iddottuyensinh','24_dottuyensinh.tendot as tendottuyensinh',
            '24_dottuyensinh.tendot as tendottuyensinh',
            'l_group.id_group as matohop',
            'l_group.name_group as tentohop',
            '24_trungtuyen.ttsom as trungtuyensom',
            '24_trungtuyen.xacnhan',
            '24_trungtuyen.diemtohop',
            '24_trungtuyen.diemuutien',
            '24_chuyennganh.tenchuyennganh as tenchuyennganh',
            '24_chuyennganh.id as id_chuyennganh',
            'l_major.id_major as manganh',
            'l_major.name_major as tennganh',
            'l_major.id as id_nganh',
            '24_danhmuc_namtuyensinh.namtuyensinh',
            '24_thongtincanhan.id_taikhoan as idxt',
            '24_thongtincanhan.hoten as hoten',
            '24_thongtincanhan.cccd as cccd',
            DB::raw('DATE_FORMAT(24_thongtincanhan.ngaysinh,"%d/%m/%Y") as ngaysinh'),
            DB::raw('if(24_mssv.mssv is null,"",mssv) as mssv'),
            '24_dottuyensinh.madot as madottuyensinh',
            '24_dottuyensinh.tendot as tendottuyensinh',
            )
        ->join('24_dottuyensinh','24_dottuyensinh.id','24_trungtuyen.iddot')
        ->join('24_chuyennganh','24_chuyennganh.id','24_trungtuyen.id_chuyennganh')
        ->join('l_major','l_major.id','24_trungtuyen.idnganh')
        ->join('24_danhmuc_namtuyensinh','24_danhmuc_namtuyensinh.id','24_trungtuyen.idnam')
        ->join('24_thongtincanhan','24_thongtincanhan.id_taikhoan','24_trungtuyen.id_taikhoan')
        ->join('l_group','l_group.id','24_trungtuyen.tohop')
        ->leftJoin('24_mssv','24_trungtuyen.id','24_mssv.idtt')
        ->orderBy('l_major.id')
        ->where('idnam',$idnam)
        ->where(function($query) use ($iddot) {
            if($iddot != 0){
                $query->where('iddot',$iddot);
            }
        })
        // ->where('iddot',$iddot)
        ->get();

        return  $data;
    }
    function thsl_trungtuyen_nhaphoc_danhsach($idnam,$iddot){
        $json_data['data'] = $this->data_thsl_trungtuyen_nhaphoc($idnam,$iddot);
        $res = json_encode($json_data);
        // $data = json_encode(array('data' => $data));
        return $res;
    }
    function thsl_trungtuyen_nhaphoc_danhsach_thongke($idnam,$iddot) {
        $data = json_decode($this->thsl_trungtuyen_nhaphoc_danhsach($idnam,$iddot), true)['data'];
        $thongke = [];
        $chitieu = DB::table('24_namtuyensinh_chitieu')
        ->where('id_nam',$idnam)->get();
        // $dangky = DB::table('24_nguyenvong')
        // ->select('idnganh',DB::raw('count(*) as soluongdangky'))
        // ->where('idnam',$idnam)
        // ->where(function($query) use ($iddot) {
        //     if($iddot != 0){
        //         $query->where('iddot',$iddot);
        //     }
        // })
        // ->groupBy('idnganh')->get();

        $dangky = DB::table('24_nguyenvong')
        ->select(
            'idnganh',
            DB::raw('count(*) as soluongdangky'),
            DB::raw('sum(case when tts = 1 then 1 else 0 end) as dangky_trungtuyensom')
        )
        ->where('idnam', $idnam)
        ->where(function($query) use ($iddot) {
            if($iddot != 0){
                $query->where('iddot', $iddot);
            }
        })
        ->groupBy('idnganh')
        ->get();

        foreach ($data as $item) {
            $idnganh = $item['id_nganh'];
            $id_chuyennganh = $item['id_chuyennganh'];
            $tennganh = $item['tennganh'];
            $tenchuyennganh = $item['tenchuyennganh'];
            $hoten = $item['hoten'];
            if (!isset($thongke[$idnganh])) {
                $thongke[$idnganh] = [
                    'id_nganh' => $idnganh,
                    'tennganh' => $tennganh,
                    'soluongtrungtuyen' => 0,
                    'soluongnhaphoc' => 0,
                    'trungtuyensom' => 0,
                    'xacnhan_ttsom' => 0,
                    'chuyennganh' => [],
                    'nhaphoc_trungtuyensom' => 0,
                    'manganh' => $item['manganh'],
                    'danhsachthisinh' => []  // Khởi tạo danh sách thí sinh
                ];
            }
            $thongke[$idnganh]['soluongtrungtuyen']++;
            if ($item['xacnhan_ttsom'] == 1) {
                $thongke[$idnganh]['xacnhan_ttsom']++;
            };
            if ($item['nhaphoc'] == 1) {
                $thongke[$idnganh]['soluongnhaphoc']++;
            };
            if ($item['trungtuyensom'] == 1) {
                $thongke[$idnganh]['trungtuyensom']++;
            };
            if ($item['nhaphoc'] == 1 && $item['trungtuyensom'] == 1) {
                $thongke[$idnganh]['nhaphoc_trungtuyensom']++;
            };

            $thongke[$idnganh]['danhsachthisinh'][] = [
                'hoten' => $hoten,
                'ngaysinh' => $item['ngaysinh'],
                'cccd' => $item['cccd'],
                'mssv' => $item['mssv'],
                'id_chuyennganh' => $id_chuyennganh,
                'tenchuyennganh' => $tenchuyennganh,
                'xacnhan_ttsom' => $item['xacnhan_ttsom'],
                'nhaphoc' => $item['nhaphoc'],
                'trungtuyensom' => $item['trungtuyensom'],
                'id_nganh' => $item['id_nganh'],
                'tennganh' => $item['tennganh'],
                'diemxettuyen' => $item['diemxettuyen'],
                'diemtohop' => $item['diemtohop'],
                'madottuyensinh' => $item['madottuyensinh'],
                'manganh' => $item['manganh'],

            ];
            $found = false;
            foreach ($thongke[$idnganh]['chuyennganh'] as &$chuyennganh) {
                if ($chuyennganh['id_chuyennganh'] === $id_chuyennganh) {
                    $chuyennganh['soluongtrungtuyen']++;
                    if ($item['nhaphoc'] == 1) $chuyennganh['soluongnhaphoc']++;
                    if ($item['xacnhan_ttsom'] == 1) $chuyennganh['xacnhan_ttsom']++;
                    if ($item['trungtuyensom'] == 1) $chuyennganh['trungtuyensom']++;
                    $chuyennganh['danhsachthisinh'][] = [
                        'hoten' => $hoten,
                        'ngaysinh' => $item['ngaysinh'],
                        'cccd' => $item['cccd'],
                        'id_chuyennganh' => $id_chuyennganh,
                        'tenchuyennganh' => $tenchuyennganh,
                        'xacnhan_ttsom' => $item['xacnhan_ttsom'],
                        'nhaphoc' => $item['nhaphoc'],
                        'trungtuyensom' => $item['trungtuyensom'],
                        'id_nganh' => $item['id_nganh'],
                        'tennganh' => $item['tennganh'],
                        'diemxettuyen' => $item['diemxettuyen'],
                        'diemtohop' => $item['diemtohop'],
                        'madottuyensinh' => $item['madottuyensinh']
                    ];
                    $found = true;
                    break;
                }
            }

            // Nếu chuyên ngành chưa có, thêm vào
            if (!$found) {
                $thongke[$idnganh]['chuyennganh'][] = [
                    'id_chuyennganh' => $id_chuyennganh,
                    'tenchuyennganh' => $tenchuyennganh,
                    'soluongtrungtuyen' => 1,
                    'soluongnhaphoc' => $item['nhaphoc'] == 1 ? 1 : 0,
                    'xacnhan_ttsom' => $item['xacnhan_ttsom'] == 1 ? 1 : 0,
                    'trungtuyensom' => $item['trungtuyensom'] == 1 ? 1 : 0,
                    'danhsachthisinh' => []
                ];
            }
        }
        $data_table = [];
        foreach ($thongke as $key => $row) {
            $i = 0;
            foreach ($chitieu as $value) {
                $row['chitieu'] = 0;
                if($row['id_nganh'] == $value->idnganh){
                    $row['chitieu'] = $value->chitieu;
                    $i++;
                    break;
                }
            }

            foreach ($dangky as $value) {
                $row['soluongdangky'] = 0;
                if($row['id_nganh'] == $value->idnganh){
                    $row['soluongdangky'] = $value->soluongdangky;
                    $row['dangky_trungtuyensom'] = $value->dangky_trungtuyensom;
                    $i++;
                    break;
                }
            }

            $data_table[] =  $row;
        }
        $data_table = json_encode(array('data' => $data_table));
        // Trả về kết quả đã được phân loại và cập nhật đúng ngành
        return $data_table;

    }













    //Quản lý giấy xác nhận
        //Tiep nhan
        function gxn_tiepnhan(){
            return view('user_24.admin24.manage.quanlygiayxacnhan.gxn_tiepnhan',
            [
                'menu' =>  $this->sidebar(),
            ]
            );
        }

        function gxn_tiepnhan_test(){
            try{ // Neu binh thuong

                $data = DB::table('24_nam')
                ->select('id as id', 'nam as text')
                ->get();
                $data0 = new Collection([
                    'id' => 0,
                    'text' => "Chon nam",
                    'selected' =>'selected'
                ]);
                //Lay data tu CDSL
                if(count($data)>0){//Kiem tra co du lieu hay khong

                    // Neu co tra ra giao dien
                    $data[] = $data0;
                    return $data;
                }else{
                    // Khong co thi xu ly
                }

                //Su thu vien
            //    return $this->load_seclectbox('24_dottuyensinh','id','tendot',0,'Chon dot dang ky');
            }catch(Exception $e){//Khoong binh thuong xu ly
                return 'err_0';
            }
        }

        function gxn_danhsachdangky_data($id_nam){
            $data = DB::table('24_cmc_dangkygiay')
            ->join('24_thongtincanhan', '24_cmc_dangkygiay.id_taikhoan', '=', '24_thongtincanhan.id_taikhoan')
            ->join('24_mssv', '24_cmc_dangkygiay.id_taikhoan', '=', '24_mssv.id_taikhoan')
            ->join('24_danhmuc_gxn', '24_cmc_dangkygiay.id_loaigiay', '=', '24_danhmuc_gxn.danhmuc_gxn_id')
            ->join('24_hosonhaphoc', '24_cmc_dangkygiay.id_taikhoan', '=', '24_hosonhaphoc.id_taikhoan')
            ->join('24_nam','24_cmc_dangkygiay.id_nam','=','24_nam.id_nam')
            ->leftJoin('l_major', 'l_major.id', '=', '24_mssv.id_nganh')
            ->leftJoin('24_danhmuc_donvi', '24_danhmuc_gxn.donvi_id', '=', '24_danhmuc_donvi.donvi_id')
            ->leftJoin('24_danhmuc_gioitinh', '24_thongtincanhan.gioitinh', '=', '24_danhmuc_gioitinh.ma_gioitinh')
            ->leftJoin('tinh', '24_thongtincanhan.noisinh', '=', 'tinh.matinh')
            ->select(
                '24_thongtincanhan.id_taikhoan',
                '24_thongtincanhan.hoten',
                '24_thongtincanhan.ngaysinh',
                '24_thongtincanhan.gioitinh',
                '24_thongtincanhan.dienthoai',
                '24_thongtincanhan.diachi',
                '24_thongtincanhan.email_phu',
                '24_thongtincanhan.cccd',
                '24_mssv.mssv',
                '24_hosonhaphoc.ngaycapcccd',
                '24_hosonhaphoc.noicapcccd',
                'l_major.name_major as tenchuyennganh',
                '24_danhmuc_gxn.danhmuc_gxn_tenloai AS loaigiay',
                '24_cmc_dangkygiay.tiendoxyly',
                '24_danhmuc_donvi.ten AS ten_donvi',
                '24_danhmuc_gioitinh.ten_gioitinh',
                'tinh.tentinh',
                '24_cmc_dangkygiay.id_loaigiay',
            )
            ->where('24_cmc_dangkygiay.id_nam',$id_nam)
            ->get();

            return $data;

            // return response()->json(['data' => $data]);
        }

        function gxn_danhsachdangky($id_nam){
            $data = $this->gxn_danhsachdangky_data($id_nam);
            return response()->json(['data' => $data]);
        }



    public function pdf_tiepnhan($id_taikhoan, $id_loaigiay,$id_nam)
    {

        $data = array(
            'tiepnhan' => $this->gxn_data($id_taikhoan, $id_loaigiay, $id_nam)
        );
        // $data = $this->gxn_data($id_taikhoan, $id_loaigiay, $id_nam);
        $pdf = PDF::loadView('user_24.admin24.manage.quanlygiayxacnhan.nvqs', $data);

        // Trả về PDF để hiển thị
        return $pdf->stream('document.pdf');
    }
    function gxn_data($id_taikhoan, $id_loaigiay, $id_nam){
        $sql = "SELECT
                    24_thongtincanhan.hoten AS hoten,
                    DATE_FORMAT(24_thongtincanhan.ngaysinh, '%d-%m-%Y') AS ngaysinh,
                    24_thongtincanhan.cccd AS cccd,
                    24_hosonhaphoc.ngaycapcccd AS ngaycapcccd,
                    noicap.name_province AS noicapcccd,
                    l_major.name_major AS name_major,
                    24_mssv.mssv AS mssv,
                    l_province.name_province AS tinh,
                    l_province2.name_province2 AS huyen,
                    24_lop.tenlop AS lop,
                    24_khoa.tenkhoa AS khoa,
                    24_lop.thoigianhoc AS thoigian,
                    24_khoas.ngaynhaphoc AS tgnhaphoc,
                    24_lop.thoigianratruong AS tgratruong
                FROM 24_cmc_dangkygiay
                INNER JOIN 24_thongtincanhan ON 24_cmc_dangkygiay.id_taikhoan = 24_thongtincanhan.id_taikhoan
                INNER JOIN 24_mssv ON 24_cmc_dangkygiay.id_taikhoan = 24_mssv.id_taikhoan
                INNER JOIN 24_hosonhaphoc ON 24_cmc_dangkygiay.id_taikhoan = 24_hosonhaphoc.id_taikhoan
                LEFT JOIN (SELECT * FROM l_province) as noicap ON noicap.id = 24_hosonhaphoc.noicapcccd
                INNER JOIN l_major ON l_major.id = 24_mssv.id_nganh
                INNER JOIN 24_lop  ON 24_lop.idnganh = l_major.id
                INNER JOIN 24_khoa  ON 24_lop.idkhoa = 24_khoa.id
                INNER JOIN 24_khoas ON 24_khoas.id = 24_lop.idkhoas
                INNER JOIN l_province ON l_province.id = 24_hosonhaphoc.id_tinh_ttru
                INNER JOIN l_province2 ON l_province2.id = 24_hosonhaphoc.id_huyen_ttru
                WHERE `24_cmc_dangkygiay`.`id_taikhoan` = ? AND 24_cmc_dangkygiay.id_loaigiay = ? AND 24_cmc_dangkygiay.id_nam = ? ";


        $tiepnhan = DB::select($sql, [$id_taikhoan, $id_loaigiay, $id_nam]);
        // $data = array('tiepnhan' => $tiepnhan);
        return $tiepnhan;
    }

    public function pdf_tiepnhan_save($id_taikhoan, $id_loaigiay,$id_nam) {

        $data = array(
            'tiepnhan' => $this->gxn_data($id_taikhoan, $id_loaigiay, $id_nam)
        );
        $pdf = PDF::loadView('user_24.admin24.manage.quanlygiayxacnhan.nvqs', $data);
        $pdfFileName = $id_taikhoan . '_' . $id_loaigiay .'_' . $id_nam . '.pdf';
        // Lưu file PDF vào thư mục lưu trữ
        $filePath = public_path('pdfs/')  . $pdfFileName . '.pdf';
        $pdf->save($filePath);

        // Cập nhật đường dẫn file vào cơ sở dữ liệu (nếu cần)
        DB::table('24_cmc_dangkygiay')
            ->where('id_taikhoan', $id_taikhoan)
            ->where('id_loaigiay', $id_loaigiay)
            ->where ('id_nam', $id_nam)
            ->update(['path_pdf' => $filePath]);
        return response()->json(['pdf_url' => asset('pdfs/' . $pdfFileName . '.pdf')]);
    }



    //Cập nhật trạng thái
    public function changeStatus(Request $request)
        {
            $id = $request->input('idtaikhoan'); // ID tài khoản cần cập nhật
            $newStatus = $request->input('newStatus'); // Trạng thái mới
            $loaigiay = $request->input('idloaigiay');
            try {
                DB::table('24_cmc_dangkygiay')
                    ->where('id_taikhoan', $id)
                    ->where('id_loaigiay',$loaigiay)
                    ->update(['tiendoxyly' => $newStatus]);

                return response()->json(['success' => true, 'message' => 'Trạng thái đã được cập nhật']);
            }
             catch (\Exception $e) {
                return response()->json(
                    ['success' => false, 'message' => $e->getMessage()]
                );
            }
        }


        //xuất excel
        function btt_excel_danhmuc($id_nam)
        {

                $data = $this->gxn_danhsachdangky_data($id_nam);
                $title = 'DanhSachTiepNhan_' .$id_nam. '.xlsx';
                return Excel::download(new Admin24_Danhsachtiepnhan( $data), $title);

        }

            //Danh mục
    //Quan lý danh mục giấy xác nhận
        // Index + sidebar Danh mục giấy xác nhận
        function gxn_danhmuc(){
            return view('user_24.admin24.manage.quanlygiayxacnhan.gxn_danhmuc',
            [
                'menu' =>  $this->sidebar(),
            ]
            );
        }

        //Load dữ liệu vào bảng Danh mục giấy xác nhận
            function gxn_danhsachgiay() {
                $data = DB::table('24_danhmuc_gxn')
                ->join('24_danhmuc_donvi', '24_danhmuc_gxn.donvi_id', '24_danhmuc_donvi.id')
                ->select('24_danhmuc_gxn.id as id', 'danhmuc_gxn_tenloai', 'ghichu', '24_danhmuc_donvi.ten as ten', 'update_at', 'create_at')
                ->orderBy('24_danhmuc_gxn.id','desc')
                ->get();

                $json_data['data'] = $data;
                $res = json_encode($json_data);

                return $res;
            }

        //Load dữ liệu ban đầu cho Form thêm
        function dm_gxn_load_bandau(){
            return $this-> load_seclectbox('24_danhmuc_donvi', 'id', 'ten', 0, '--- Chọn đơn vị ---');
        }

        //Load dữ liệu ban đầu cho Modal cập nhật
        function dm_gxn_load_modal($id){
            try{
                $data = DB::table('24_danhmuc_gxn')
                ->where('id',$id)
                ->first();
                if($data){
                    $trangthai = 1;
                    $data = $data;
                }else{
                    $trangthai = 0;
                    $data = '';
                }
                $id = $this-> load_seclectbox('24_danhmuc_donvi', 'id', 'ten', 0, '--- Chọn đơn vị ---');
            } catch (Exception $e) {
                $trangthai = -1;
                $data = '';
            }
            return array(
                'donvi' => $id,
                'data' => $data,
                'trangthai' =>  $trangthai,
            );
        }

        //Thêm giấy xác nhận
        public function gxn_add(Request $request) {
            $validator = Validator::make( $request->all(),
                [
                    'tenLoaiGiayInput' => 'required|regex:/^[\p{L}0-9 -]+$/u',
                    'ghiChuInput' => 'nullable|regex:/^[\p{L}0-9 -]+$/u',
                    'donViInput' => 'required|not_in:0',
                ],
                [
                    'tenLoaiGiayInput.required'   => 'Tên giấy không trống',
                    'tenLoaiGiayInput.regex'   => 'Không nhập ký tự đặc biệt',

                    'ghiChuInput.regex'   => 'Không nhập ký tự đặc biệt',

                    'donViInput.required'  => 'Vui lòng chọn đơn vị',
                    'donViInput.not_in'    => 'Vui lòng chọn đơn vị',
                ]
            );
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }
            try {
                DB::beginTransaction();
                $maxId = DB::table('24_danhmuc_gxn')->max('danhmuc_gxn_id');
                $newId = $maxId + 1;
                $data = [
                    'danhmuc_gxn_id' => $newId,
    'danhmuc_gxn_tenloai' => $request->input('tenLoaiGiayInput'),
                    'donvi_id' => $request->input('donViInput'),
                    'ghichu' => $request->input('ghiChuInput'),
                ];
                $inserted = DB::table('24_danhmuc_gxn')->insert($data);
                if ($inserted == 1) {
                    DB::commit();
                    return 1;
                } else {
                    DB::rollBack();
                    return 0;
                }
            } catch (Exception $e) {
                DB::rollBack();
                return -1;
            }
        }

        //Cập nhật giấy xác nhận
        public function gxn_update(Request $request) {
            $validator = Validator::make( $request->all(),
                [
                    'idGiayInput_modal' => 'required|integer',
                    'tenLoaiGiayInput_modal' => 'required|regex:/^[\p{L}0-9 -]+$/u',
                    'ghiChuInput_modal' => 'nullable|regex:/^[\p{L}0-9 -]+$/u',
                    'donViInput_modal' => 'required|not_in:0',
                ],
                [
                    'idGiayInput_modal.integer' => 'Không tồn tại dữ liệu giấy',
                    'idGiayInput_modal.required' => 'Không tồn tại dữ liệu giấy',

                    'tenLoaiGiayInput_modal.required'   => 'Tên giấy không trống',
                    'tenLoaiGiayInput_modal.regex'   => 'Không nhập ký tự đặc biệt',

                    'ghiChuInput_modal.regex'   => 'Không nhập ký tự đặc biệt',

                    'donViInput_modal.required'  => 'Vui lòng chọn đơn vị',
                    'donViInput_modal.not_in'    => 'Vui lòng chọn đơn vị',
                ]
            );
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }
            try {
                $id = $request->input('idGiayInput_modal');
                $data = [
                    'danhmuc_gxn_tenloai' => $request->input('tenLoaiGiayInput_modal'),
                    'donvi_id' => $request->input('donViInput_modal'),
                    'ghichu' => $request->input('ghiChuInput_modal'),
                ];
                DB::beginTransaction();
                $updated = DB::table('24_danhmuc_gxn')
                ->where('id', $id)
                ->update($data);
                if ($updated == 1) {
                    DB::commit();
                    return 1;
                } else{
                    DB::rollBack();
                    return 0;
                }
            } catch (Exception $e) {
                DB::rollBack();
                return -1;
            }
        }

        //Xóa giấy xác nhận
        public function gxn_delete($id) {
            try {
                DB::beginTransaction();
                $deleted = DB::table('24_danhmuc_gxn')
                            ->where('id', $id)
                            ->delete();
                if ($deleted == 1) {
                    DB::commit();
                    return 1;
                } else {
                    DB::rollBack();
                    return 0;
                }
            } catch (Exception $e) {
    DB::rollBack();
                return -1;
            }
        }




         //Quản lý chức năng
        function themchucnang(){
            return view('user_24.admin24.manage.quanlychucnang.capnhatchucnang',[
                'menu' => $this->sidebar(),
            ]);
        }

        function importchucnang(){
            return view('user_24.admin24.manage.quanlychucnang.importchucnang',[
                'menu' => $this->sidebar(),
            ]);
        }

        function load_danhsachchucnang($id_manhinh){
            $sql = "select tu.id as id_chung,  24_danhmuc_chucnang.id as id,  24_danhmuc_chucnang.danhmuc_chucnang_ten, if(id_manhinh is null,0,1) as checked from `24_danhmuc_chucnang` left join (SELECT * FROM `24_danhmuc_manhinh_chucnang` WHERE id_manhinh = ?) as tu  on 24_danhmuc_chucnang.`id` = tu.`id_chucnang`";
            $data =  DB::select( $sql,[$id_manhinh]);
            return $data;
        }

        function load_danhsachquyen(){
            return $this->load_seclectbox('24_menu','IDMN','name',0,'Chọn màn hình');
        }

        function load_chucnang(){
            $data = DB::table('24_danhmuc_chucnang') // Chỉ truy vấn từ bảng 24_danhmuc_chucnang
                ->orderBy('id','desc')
                ->get(); // Lấy tất cả dữ liệu từ bảng
            $json_data['data'] = $data;
            $res = json_encode($json_data);
            return $res;
        }

        function load_manhinh_chucnang(){
            $data =  DB::table('24_danhmuc_manhinh_chucnang')
                ->join('24_menu','24_menu.IDMN','24_danhmuc_manhinh_chucnang.id_manhinh')
                ->join('24_danhmuc_chucnang','24_danhmuc_chucnang.id','24_danhmuc_manhinh_chucnang.id_chucnang')
                ->orderBy('id_manhinh','desc')
                ->get();
            $json_data['data'] = $data;
            $res = json_encode($json_data);
            return $res;
        }
        function add_chucnang(Request $r){
           $tcn_id_chucnang =  $r ->input('tcn_id_chucnang');
           $tcn_ten_chucnang =  $r ->input('tcn_ten_chucnang');
           $tcn_ghichu =  $r ->input('tcn_ghichu');
            try{
                DB::table('24_danhmuc_chucnang')
                ->insert(
                    [
                        'danhmuc_chucnang_id' =>  $tcn_id_chucnang,
                        'danhmuc_chucnang_ten' =>  $tcn_ten_chucnang,
                        'danhmuc_chucnang_ghichu' => $tcn_ghichu,
                    ]
                );
                return   1;
            }catch(Exception $e){
                return   0;
            }
        }

        function xoa_chucnang(Request $r) {
            $themchucnang_manhinh = $r->input('id');  // Lấy id từ reques
            try {
                DB::beginTransaction();
                $del = DB::table('24_danhmuc_chucnang')
                ->where('id', $themchucnang_manhinh)
                ->delete();
                if($del == 1){
                    DB::commit();
                    return 1;
                }else{
                    // Phục hồi dữ liệu
                    DB::rollback();
                    return 0;
                }
            } catch (Exception $e) {
                return 0;
            }
        }

        public function sua_id_chucnang(Request $r) {
            $id = $r->input('id');  // Lấy id từ reques
            $id_chucnang = $r->input('id_chucnang');  // Lấy id từ reques
            try {
                DB::beginTransaction();
                $upd = DB::table('24_danhmuc_chucnang')
                    ->where('id', $id)
                    ->update(
                        [
                            'danhmuc_chucnang_id' => $id_chucnang
                        ]
                    );
                if($upd == 1){
                    DB::commit();
                    return 1;

                }else{
                    DB::rollback();
                    return 0;
                }
            } catch (Exception $e) {
                return 0;
            }
        }
        public function sua_ten_chucnang(Request $r) {
            $id = $r->input('id');  // Lấy id từ reques
            $ten_chucnang = $r->input('ten_chucnang');  // Lấy id từ reques
            try {
                DB::beginTransaction();
                $upd = DB::table('24_danhmuc_chucnang')
                    ->where('id', $id)
                    ->update(
                        [
                            'danhmuc_chucnang_ten' => $ten_chucnang
                        ]
                    );
                if($upd == 1){
                    DB::commit();
                    return 1;
                }else{
                    DB::rollback();
                    return 0;
                }
            } catch (Exception $e) {
                return 0;
            }
        }

        public function sua_gc_chucnang(Request $r) {
            $id = $r->input('id');  // Lấy id từ reques
            $gc_chucnang = $r->input('gc_chucnang');  // Lấy id từ reques
            try {
                DB::beginTransaction();
                $upd = DB::table('24_danhmuc_chucnang')
                    ->where('id', $id)
                    ->update(
                        [
                            'danhmuc_chucnang_ghichu' => $gc_chucnang
                        ]
                    );
                if($upd == 1){
                    DB::commit();
                    return 1;
                }else{
                    DB::rollback();
                    return 0;
                }
            } catch (Exception $e) {
                return 0;
            }
        }

        public function sua_trangthai(Request $r){
            $id = $r->input('id');  // Lấy id từ reques
            $check = $r->input('check');  // Lấy id từ reques
            try {
                DB::beginTransaction();
                $upd = DB::table('24_danhmuc_chucnang')
                    ->where('id', $id)
                    ->update(
                        [
                            'trangthai' => $check
                        ]
                    );
                if($upd == 1){
                    DB::commit();
                    return 1;
                }else{
                    DB::rollback();
                    return 0;
                }
            } catch (Exception $e) {
                return 0;
            }
        }

        function xoa_phanquyen($id_manhinh,$id_chucnang){
            try {
                DB::beginTransaction();
                $phanquyen = DB::table('24_danhmuc_manhinh_chucnang')
                    ->where('id_manhinh', $id_manhinh)
                    ->where('id_chucnang', $id_chucnang)
                    ->delete();
                if($phanquyen == 1){
                    DB::commit();
                    return 1;
                }else{
                    DB::rollback();
                    return 0;
                }
            } catch (Exception $e) {
                return 0;
            }
        }

        public function add_phanquyen(Request $request)
        {
            $id_manhinh = $request->input('id_manhinh');
            $id_chucnang = $request->input('id_chucnang');
            $checked = $request->input('checked');
            if (!$id_manhinh || !$id_chucnang) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID màn hình hoặc ID chức năng không hợp lệ!',
                ], 400);
            }
            try {
                if ($checked == 0) {
                    $del = $this->xoa_phanquyen($id_manhinh, $id_chucnang);

                    return response()->json([
                        'success' => $del ? true : false,
                        'message' => $del ? 'Phân quyền đã được gỡ !!!' : 'Xóa phân quyền thất bại hoặc không tồn tại.',
                    ]);
                }
                else {
                    $exists = DB::table('24_danhmuc_manhinh_chucnang')
                        ->where('id_manhinh', $id_manhinh)
                        ->where('id_chucnang', $id_chucnang)
                        ->exists();
                    if ($exists) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Phân quyền đã tồn tại.',
                        ]);
                    }
                    DB::table('24_danhmuc_manhinh_chucnang')->insert([
                        'id_manhinh' => $id_manhinh,
                        'id_chucnang' => $id_chucnang,
                    ]);
                    return response()->json([
                        'success' => true,
                        'message' => 'Thêm phân quyền thành công.',
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra trong quá trình xử lý!',
                    'error' => $e->getMessage(),
                ], 500);
            }
        }
    //Xuất excel
    function tcsv_dp_excel($search){
        $data =  $this->data_tcsv_timkiem($search);
        $data_ex = new Collection([
            [
                'email','CCCD','Họ và Tên','Ngày Sinh','Giới Tính','Điện thoại','MSSV','Mã lớp'
            ]
        ]);
        foreach ( $data as  $key => $value) {
            $value ->gioitinh == 1 ? $gioitinh = "Nam" : $gioitinh = "Nữ";
            $row =  [
                    // $value ->stt,
                    $value ->email,
                    $value ->cccd,
                    $value ->hoten,
                    $value ->ngaysinh,
                    $gioitinh,
                    $value->dienthoai,
                    $value ->mssv,
                    $value ->malop,
                ];
            $data_ex[] = $row;
        }
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $title = 'DanhSachSInhVien'. date("d-m-Y H:i:s") .'.xlsx';
        return Excel::download(new Admin24_XuatDSQLS_DP($data_ex), $title);
    }
}
