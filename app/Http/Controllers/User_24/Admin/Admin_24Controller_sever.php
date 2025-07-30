<?php

namespace App\Http\Controllers\User_24\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
use App\Exports\Admin24_ExportDanhSachThanhtoan;
use Svg\Tag\Rect;


//Email
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;


class Admin_24Controller  extends Controller
{
    // menu
    function datamenu($menus, $parent_id = 0, $level = 0, &$html_parent, &$html_child)
    {
        $interface_added = false; // Khởi tạo biến để kiểm tra xem interface đã được thêm hay chưa
            foreach ($menus as $key => $menu) {
                if ($menu->parent_id == $parent_id) {
                    $menu->level = $level;
                    if ($menu->level == 0) {
                        if($menu->stt == 0){
                            $html_parent .= '<li  class="menu-active"  menu = "'.$menu->link.'" id = "li_'.$menu->link.'">';
                            $html_parent .= '<a data-toggle="" href="'.$menu->link.'">';
                            $html_parent .= '<i class="'.$menu->icon.'"></i>' . $menu->name;
                            $html_parent .= '</a>';
                            $html_parent .= '</li>';
                        }else{
                            // Parent menu
                            $html_parent .= '<li  class="menu-active"  id = "li_'.$menu->IDMN.'">';
                            $html_parent .= '<a data-toggle="tab" href="#'.$menu->IDMN.'">';
                            $html_parent .= '<i class="'.$menu->icon.'"></i>' . $menu->name;
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
                        $html_child .= '<li class="menu-active"  menu = "'. $menu->parent_id .'" id = "'. $menu->link.'"><a href="' . $menu->link . '">' . $menu->name . '</a></li>';
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


    //Trang HOME
        //Contentheader
    function contentheader($duongdan){
        $level2 = DB::table('24_menu')
        ->where('link',$duongdan)
        ->first();
        $level1 = DB::table('24_menu')
        ->where('IDMN',$level2->parent_id)
        ->first();
        $res = array(
            'level1' => $level1->name,
            'level2' => $level2->name,
            'id_manhinh' => $level2 ->id
        );
        return $res;
    }

        //Menu
    function datasidebar($menus, $parent_id = 0, $level = 0, &$html)
    {
        foreach ($menus as $key => $menu) {
            if ($menu->parent_id === $parent_id) {
                $menu->level = $level;
                    if ($menu->level == 0) {
                        $html .= '<li class = "nav-item">';
                        if($menu->link == 'main'){
                            $html .= '<a href="'.$menu->link.'" style="background-color: rgba(255, 255, 255, .1);" class="nav-link">';
                        }else{
                            $html .= '<a style="background-color: rgba(255, 255, 255, .1);" class="nav-link">';
                        }

                        $html .= '<i class="nav-icon ' . $menu->icon . '" style="font-size: 14px;color:white"></i>';
                        $html .=  '<p id = levelpr'.$menu->IDMN.'>' . $menu->name;
                        if($menu->link != 'main'){
                            $html .= '<i class="fas fa-angle-left right"></i>';
                        }
                        $html .= '</p>';
                        $html .= '</a>';
                    } else {
                        $html .= "<ul id = level".$menu->IDMN." class='nav nav-treeview'>";
                        $html .= '<li class="nav-item">';
                        $html .= "<a href=".$menu->link." class='nav-link'>";
                        $html .= '&nbsp;&nbsp&nbsp;<i class="nav-icon ' . $menu->icon . '" style="font-size: 14px;color:white"></i>';
                        $html .= '<p>' . $menu->name . '</p>';
                        $html .= '</a>';
                        $html .= '</li>';
                    }

                unset($menus[$key]);
                self::datasidebar($menus, $menu->IDMN, $level + 1, $html);
                $html .= '</li>';
                $html .= '</ul>';
            }
        }

    }

    public function sidebar()
    {
        $menus = DB::table('24_menu')->orderBy('stt', 'asc')
            ->get();
        # root
        $this->datasidebar($menus, 0, 0, $result);
        return $result;
    }

    public function index()
   {
        return view('user_24.admin24.include.index',
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
            ]
        );
    }

        //Biểu đồ trang HOME
    public function bieudo()
    {
        $sqlnv = "SELECT tenchuyennganh,if(nv1.slnv1 is null,0,nv1.slnv1) as slnv1,if(nv2.slnv2 is null,0,nv2.slnv2) as slnv2,if(nv3.slnv3 is null,0,nv3.slnv3) as slnv3 FROM `24_chuyennganh` LEFT JOIN (SELECT 24_nguyenvong.id_chuyennganh,COUNT(24_nguyenvong.id_chuyennganh) as slnv1 FROM 24_nguyenvong WHERE thutu=1 GROUP BY 24_nguyenvong.id_chuyennganh) as nv1 ON 24_chuyennganh.id=nv1.id_chuyennganh LEFT JOIN (SELECT 24_nguyenvong.id_chuyennganh,COUNT(24_nguyenvong.id_chuyennganh) as slnv2 FROM 24_nguyenvong WHERE thutu=2 GROUP BY 24_nguyenvong.id_chuyennganh) as nv2 ON 24_chuyennganh.id=nv2.id_chuyennganh LEFT JOIN (SELECT 24_nguyenvong.id_chuyennganh,COUNT(24_nguyenvong.id_chuyennganh) as slnv3 FROM 24_nguyenvong WHERE thutu=3 GROUP BY 24_nguyenvong.id_chuyennganh) as nv3 ON 24_chuyennganh.id=nv3.id_chuyennganh";
        $nguyevong = DB::select($sqlnv);

        $chitieu = DB::table('24_nganhchitieu')
        ->join('l_major','l_major.id','24_nganhchitieu.id_nganh')
        ->select('name_major as tennganh','chitieu')
        ->get();
        $res = array(
            'nguyenvong'    => $nguyevong,
            'chitieu'       =>  $chitieu,
        );
        return $res;
    }

    //Quản lý thí sinh
    public function quanlyhoso()
    {
        return view('user_24.admin_24.quanlyhoso');
    }

    //Quản lý lệ phí
        //Index
    public function hosotructuyen()
    {
        return view('user_24.admin24.manage.hosotructuyen',
            [
                'menu' =>    $this->sidebar(),
            ]
        );
    }

        //Load hồ sơ thanh toán
    public function loadhosolephi($id_dot){
        $data = DB::table('24_ketquathanhtoan')
        ->join('24_dataresponse','24_dataresponse.order_id','24_ketquathanhtoan.order_id')
        ->where([
            '24_ketquathanhtoan.id_dot' =>  $id_dot,
        ])
        ->get();
        $json_data['data'] = $data;
        $res = json_encode($json_data);
        return  $res;
    }

        //Xuất excel
    public function exceldanhsachtructuyen($id_dot){
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $title = 'DanhSachThanhToanTrucTuyen'.date("d-m-Y H:i:s").'.xlsx';
        return Excel::download(new Admin24_ExportDanhSachThanhtoan($id_dot),$title);
    }

        //Thống kê lệ phí theo trạng thai
    public function thongkelephitheotrangthai($id_dot){
        $tongthu = DB::table('24_ketquathanhtoan')
        ->where('id_dot',$id_dot)
        ->sum('total_amount');
        $tongthisinh = DB::table('24_ketquathanhtoan')
        ->where('id_dot',$id_dot)
        ->distinct()->count();
        $tonghoadon = DB::table('24_ketquathanhtoan')
        ->where('id_dot',$id_dot)
        ->count();
        $res = array([
            'tongthu' =>  $tongthu,
            'tongthisinh' => $tongthisinh,
            'tonghoadon' => $tonghoadon,

        ]);
        return $res;
    }


    public function testmail()
    {
        $maiable = new TestMail();
        Mail::to('ngphantu2004@gmail.com')->send($maiable);
    }

}







