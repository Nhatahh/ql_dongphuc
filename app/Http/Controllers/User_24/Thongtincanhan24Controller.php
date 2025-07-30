<?php

namespace App\Http\Controllers\User_24;

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

use function PHPUnit\Framework\countOf;

class Thongtincanhan24Controller extends Controller

{

    function checkkhoadangky($id_taikhoan)  {
        $dangky = DB::table('24_khoadangky')
        ->where('id_taikhoan',$id_taikhoan)
        ->first();
        if($dangky){
            if($dangky->trangthai == 1 || $dangky->trangthai == 3 ){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }

    public function diemtuutientheotruongthpt($id_taikhoan){
        $nam = DB::table('24_namtotnghiep')
        ->where('id_taikhoan',$id_taikhoan)
        ->first();
        if( $nam){
            $namtotnghiep = $nam ->namtotnghiep;
            $year = Carbon::now()->year;
            if((int)$namtotnghiep < (int)$year - 1){
                $khuvucuutien =  -1;
                $tenkhuvucuutien = "Không ưu tiên";
                $diemkhuvucuutien = 0;
            }else{
                $check = DB::table('24_truongthpt')
                ->where('id_taikhoan',$id_taikhoan)
                ->get();
                if($check){
                    if(count($check) == 3){
                        $thpts = DB::select('SELECT l_priority_area.id as id, l_priority_area.* FROM l_priority_area INNER JOIN (SELECT id,dem FROM (SELECT l_priority_area.id as id, COUNT(*) as dem FROM `24_truongthpt` INNER JOIN l_school ON l_school.id = 24_truongthpt.id_truong INNER JOIN l_priority_area ON l_school.priority_area_school = l_priority_area.id WHERE id_taikhoan = '.$id_taikhoan.' GROUP BY l_priority_area.id) AS  uutien) AS X ON X.id = l_priority_area.id ORDER BY X.dem DESC LIMIT 0,1');
                        $khuvucuutien =  $thpts[0]->id;
                        $tenkhuvucuutien = $thpts[0]->id_priority_area;
                        $diemkhuvucuutien = $thpts[0]->mark_priority;
                    }else{
                        $khuvucuutien =  0;
                        $tenkhuvucuutien = "";
                        $diemkhuvucuutien = 0;

                    }
                }else{
                    $khuvucuutien =  0;
                    $tenkhuvucuutien = "";
                    $diemkhuvucuutien = 0;
                }
            }
        }else{
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

    function diemtuutientheodoituong($id_taikhoan){
        $doituong =DB::table('24_doituonguutien')
        ->join('l_policy_users','id_doituong','id')
        ->select('id_doituong','mark_policy_user','name_policy_user')
        ->where('id_taikhoan',$id_taikhoan)
        ->first();
        return  $doituong;
    }


    function kiemtrathongtincanhan() {
        $check = DB::table("24_thongtincanhan")
        ->where('id_taikhoan',Auth::guard('loginbygoogles')->id())
        ->first();
        if($check){
            return 1;
        }else{
            return 0;
        }

    }

    function kiemtrahinhanh($id_taikhoan,$loaihinhanh) {
        $check = DB::table("24_image")
        ->where('id_taikhoan',$id_taikhoan)
        ->where('loaianh',$loaihinhanh)
        ->first();
        if($check){
            return 1;
        }else{
            return 0;
        }

    }

    public function thongtincanhan(){
        $id_taikhoan = Auth::guard('loginbygoogles')->id();
        // $id_taikhoan = 12;
        $user = DB::table('account24s')
        ->where('id',$id_taikhoan)->first();
        $thongtincanhan = DB::table('24_thongtincanhan')
        ->where('id_taikhoan',$id_taikhoan)->first();
        $noisinhs = DB::table('l_province')
        ->select('id','name_province as text')
        ->where('active_province',1)
        ->orderBy('id', 'asc')
        ->get();

        $img = DB::table('24_image')
        ->where('loaianh',1)
        ->where('id_taikhoan',$id_taikhoan)
        ->first();
        if($img){
            $path_img = $img->path_img;
        }else{
            $path_img = "/img/test.png";
        }

        //Trường THPT lớp 10
        $truongthpt = DB::table('24_truongthpt')
        ->where('id_taikhoan',$id_taikhoan)
        ->join('l_school','id_truong',"l_school.id")
        ->join('l_priority_area','priority_area_school',"l_priority_area.id")
        ->where('id_lop',10)
        ->first();

        $tinhlop10s = DB::table('l_province')
        ->select('id','name_province as text')
        ->where('active_province',1)
        ->orderBy('id', 'asc')
        ->get();

        if($truongthpt){
            $truongthpt10s = DB::table('l_school')
            ->select('name_school as text','l_school.id as id','id_province')
            ->where('id_province',$truongthpt->id_tinh)
            ->get();
            foreach ($truongthpt10s as $truongthpt10 ){
                if( $truongthpt10 ->id == $truongthpt->id_truong){
                    $truongthpt10 ->selected = "selected";
                }else{
                    $truongthpt10 ->selected = "";
                }
            }
            $truonglop10_load = array(
                'truongthpt10s' => $truongthpt10s,
                'khuvuc10' => $truongthpt->id_priority_area,
            );
            foreach ($tinhlop10s as $tinhlop10 ){
                if( $truongthpt->id_tinh == $tinhlop10->id){
                    $tinhlop10 ->selected = "selected";
                }else{
                    $tinhlop10 ->selected = "";
                }
            }
        }else{
            $truonglop10_load = array(
                'truongthpt10s' => "",
                'khuvuc10' => "",
            );
            foreach ($tinhlop10s as $tinhlop10 ){
                $tinhlop10 ->selected = "";
            }
        }


        //Trường THPT lớp 11
        $truongthpt11 = DB::table('24_truongthpt')
        ->join('l_school','id_truong',"l_school.id")
        ->join('l_priority_area','priority_area_school',"l_priority_area.id")
        ->where('id_taikhoan',$id_taikhoan)
        ->where('id_lop',11)
        ->first();

        $tinhlop11s = DB::table('l_province')
        ->select('id','name_province as text')
        ->where('active_province',1)
        ->orderBy('id', 'asc')
        ->get();

        if($truongthpt11){
            $truongthpt11s = DB::table('l_school')
            ->select('name_school as text','id','id_province','priority_area_school')
            ->where('id_province',$truongthpt11->id_tinh)
            ->get();
            foreach ($truongthpt11s as $value ){
                if( $value ->id == $truongthpt11->id_truong){
                    $value ->selected = "selected";
                }else{
                    $value ->selected = "";
                }
            }
            $truonglop11_load = array(
                'truongthpt11s' => $truongthpt11s,
                'khuvuc11' => $truongthpt11->id_priority_area,
            );
            foreach ($tinhlop11s as $tinhlop11 ){
                if( $truongthpt11->id_tinh == $tinhlop11->id){
                    $tinhlop11 ->selected = "selected";
                }else{
                    $tinhlop11 ->selected = "";
                }
            }
        }else{
            $truonglop11_load = array(
                'truongthpt11s' => "",
                'khuvuc11' => "",
            );
            foreach ($tinhlop11s as $tinhlop11 ){
                $tinhlop11 ->selected = "";
            }
        }

        //Trường THPT lớp 12
        $truongthpt12 = DB::table('24_truongthpt')
        ->join('l_school','id_truong',"l_school.id")
        ->join('l_priority_area','priority_area_school',"l_priority_area.id")
        ->where('id_taikhoan',$id_taikhoan)
        ->where('id_lop',12)
        ->first();

        $tinhlop12s = DB::table('l_province')
        ->select('id','name_province as text')
        ->where('active_province',1)
        ->orderBy('id', 'asc')
        ->get();

        if($truongthpt12){
            $truongthpt12s = DB::table('l_school')
            ->select('name_school as text','id','id_province','priority_area_school')
            ->where('id_province',$truongthpt12->id_tinh)
            ->get();
            $truonglop12_load = array(
                'truongthpt12s' => $truongthpt12s,
                'khuvuc12' => $truongthpt12->id_priority_area,
            );
            foreach ($truongthpt12s as $value ){
                if( $value ->id == $truongthpt12->id_truong){
                    $value ->selected = "selected";
                }else{
                    $value ->selected = "";
                }
            }
            foreach ($tinhlop12s as $tinhlop12 ){
                if( $truongthpt12->id_tinh == $tinhlop12->id){
                    $tinhlop12 ->selected = "selected";
                }else{
                    $tinhlop12 ->selected = "";
                }
            }
        }else{
            $truonglop12_load = array(
                'truongthpt12s' => "",
                'khuvuc12' => "",
            );
            foreach ($tinhlop12s as $tinhlop12 ){
                $tinhlop12 ->selected = "";
            }
        }
        $img_slider = DB::select("SELECT 24_image_chuan.id, 24_image_chuan.funtion_id,24_image_chuan.ghichu,24_image_chuan.loaianh,if(image.path_img is null,'/img/test.png',image.path_img) as path_img,if(image.id is null,0,image.id) as test  FROM `24_image_chuan` LEFT JOIN (SELECT * FROM 24_image WHERE id_taikhoan = ".$id_taikhoan." AND loaianh > 1) AS image ON 24_image_chuan.id = image.id_image_chuan ORDER BY thutu ASC");

        if($thongtincanhan){
            foreach ($noisinhs as $noisinh ){
                if( $thongtincanhan ->noisinh == $noisinh->id){
                    $noisinh ->selected = "selected";
                }else{
                    $noisinh ->selected = "";
                }
            }
            if($thongtincanhan->gioitinh == 0){
                $gioitinh = 1;

            }else{
                $gioitinh= 0;
            }
        }else{
            foreach ($noisinhs as $noisinh ){
                $noisinh ->selected = "";
            }
        }

        $nam = DB::table('24_namtotnghiep')
        ->where('id_taikhoan',$id_taikhoan)
        ->first();

        if( $nam){
            $namtotnghiep = $nam ->namtotnghiep;
        }else{
            $namtotnghiep = "";
        }

        //Điểm ưu tiên theo Trường THPT
        $khuvuc = DB::table('24_khuvucuutien')
        ->select('id_priority_area')
        ->where('id_taikhoan',$id_taikhoan)
        ->join('l_priority_area','24_khuvucuutien.khuvucuutien',"l_priority_area.id")
        ->first();
        if($khuvuc){
            $khuvucuutien = $khuvuc->id_priority_area;
        }else{
            $khuvucuutien = "";
        }

        //Đối tượng ưu tiên
        $doituonguutien = DB::table('l_policy_users')
        ->select('id','name_policy_user as text')
        ->where('active_policy',1)
        ->orderBy('id', 'asc')
        ->get();


        $doituonguutienuser = DB::table('24_doituonguutien')
        ->where('id_taikhoan',$id_taikhoan)
        ->first();

        if($doituonguutienuser){
            foreach ($doituonguutien as $uutien ){
                if( $uutien ->id == $doituonguutienuser->id_doituong){
                    $uutien ->selected = "selected";
                }else{
                    $uutien ->selected = "";
                }
            }
        }else{
            foreach ($doituonguutien as $uutien ){
                $uutien ->selected = "";
            }
        }

        if( $user && $thongtincanhan){
            return view('user_24.thongtincannhan',
            [
                'title' => "CTUT|Hệ thống đăng ký xét tuyển",
                'user'=>  $user,
                'hoten'=> $thongtincanhan->hoten,
                'ngaysinh'=> $thongtincanhan->ngaysinh,
                'cccd'=> $thongtincanhan->cccd,
                'email_phu'=> $thongtincanhan->email_phu,
                'dienthoai'=> $thongtincanhan->dienthoai,
                'dienthoai_phu'=> $thongtincanhan->dienthoai_phu,
                'diachi'=> $thongtincanhan->diachi,
                'gioitinh' =>$gioitinh,
                'noisinhs' => $noisinhs,
                'mahsxt' => Carbon::now()->year."CQ".$user->id,
                'path_img' =>$path_img,
                'img_slider' =>  $img_slider,
                'img_slider_right' =>  $img_slider,
                'truonglop10_load' =>  $truonglop10_load,
                'tinhlop10s' =>  $tinhlop10s,
                'truonglop11_load' =>  $truonglop11_load,
                'tinhlop11s' =>  $tinhlop11s,
                'truonglop12_load' =>  $truonglop12_load,
                'tinhlop12s' =>  $tinhlop12s,
                'namtotnghiep' =>  $namtotnghiep,
                'khuvucuutien' =>  $khuvucuutien,
                'doituonguutien' => $doituonguutien,
                'checkkhoadangky' =>$this->checkkhoadangky($id_taikhoan),
            ]);
        }else{
            return view('user_24.thongtincannhan',
            [
                'title' => "CTUT|Hệ thống đăng ký xét tuyển",
                'user'=>  $user,
                'hoten'=> "",
                'ngaysinh'=> "2006-01-01",
                'cccd'=> "",
                'email_phu'=> "",
                'dienthoai'=> "",
                'dienthoai_phu'=> "",
                'diachi'=> "",
                'gioitinh' =>"",
                'noisinhs' => $noisinhs,
                'mahsxt' => Carbon::now()->year."CQ".$user->id,
                'path_img' => $path_img,
                'img_slider' =>  $img_slider,
                'img_slider_right' =>  $img_slider,
                'truonglop10_load' =>  $truonglop10_load,
                'tinhlop10s' =>  $tinhlop10s,
                'truonglop11_load' =>  $truonglop11_load,
                'tinhlop11s' =>  $tinhlop11s,
                'truonglop12_load' =>  $truonglop12_load,
                'tinhlop12s' =>  $tinhlop12s,
                'namtotnghiep' =>  $namtotnghiep,
                'khuvucuutien' =>  $khuvucuutien,
                'doituonguutien' => $doituonguutien,
                'checkkhoadangky' =>$this->checkkhoadangky($id_taikhoan),
            ]);
        }
    }

    public function luuthongtincanhan(Request $r){
        $id = $r->input('id');
        $check = DB::table('24_thongtincanhan')
        ->where('id_taikhoan',$id)
        ->get();

        if(count($check) <= 1){
            $data = [];
            foreach ($r->input('data') as $key => $value) {
                $data[$value[0]] = $value[1];
            }
            $dem = 0;
            if(count($check) == 1){
                $check_cmnds = DB::table('24_thongtincanhan')
                ->where('id_taikhoan','<>',$id)
                ->get();
                // return $data['cccd'];
                foreach ($check_cmnds as $key => $check_cmnd) {
                   if($check_cmnd->cccd == $data['cccd']){
                        $dem++;
                   }
                }
            }
            if($dem > 0){
                return 'UpOrIns_cccd';
            }else{
                $validator = Validator::make($data,
                [
                    'cccd'                          => 'alpha_dash|regex:/[0-9a-zA-Z]/|min:9|max:12',
                    'dienthoai_phu'                 => 'alpha_dash|min:10|max:10|regex:/(0)[0-9]/|not_regex:/[a-z]/',
                    'hoten'                         => "not_regex:/[@<>&!~^$*=]/",
                    'ngaysinh'                      => 'required',
                    'dienthoai'                     => 'alpha_dash|min:10|max:10|regex:/(0)[0-9]/|not_regex:/[a-z]/',
                    'diachi'                        => "not_regex:/[@<>&!~^$*=]/",
                    'noisinh'                       =>'integer|min:1',
                ],
                [
                    'hoten.not_regex'               =>'Họ tên không trống hoặc có ký tự đặc biệt',
                    'ngaysinh.required'             => 'Vui lòng điền ngày sinh',
                    'cccd.min'                      =>'CMND/CCCD gồm 9 hoặc 12 ký tự',
                    'cccd.regex'                    =>'CMND/CCCD gồm 9 hoặc 12 ký tự',
                    'cccd.max'                      =>'CMND/CCCD gồm 9 hoặc 12 ký tự',
                    'alpha_dash'                    =>'CMCD/CCCD chỉ gồm chữ và số',

                    'dienthoai_phu.regex'           =>'Điện thoại gồm 10 chữ số',
                    'dienthoai_phu.max'             =>'Điện thoại gồm 10 chữ số',
                    'dienthoai_phu.min'             =>'Điện thoại gồm 10 chữ số',
                    'dienthoai_phu.regex'           =>'Số đầu tiên phải là số 0',
                    'dienthoai_phu.not_regex'       =>'Điện thoại chỉ bao gồm chữ số',
                    'dienthoai_phu.dienthoai_phu'       =>'Điện thoại chỉ bao gồm chữ số',

                    'dienthoai.regex'               =>'Điện thoại gồm 10 chữ số',
                    'dienthoai.max'                 =>'Điện thoại gồm 10 chữ số',
                    'dienthoai.min'                 =>'Điện thoại gồm 10 chữ số',
                    'dienthoai.regex'               =>'Số đầu tiên phải là số 0',
                    'dienthoai.not_regex'           =>'Điện thoại chỉ bao gồm chữ số',
                    'dienthoai.alpha_dash'          =>'Điện thoại chỉ bao gồm chữ số',
                    'diachi.not_regex'              =>'Địa chỉ không được rỗng hoặc có ký tự đặc biệt',
                    'noisinh.min'                   =>'Chọn Nơi sinh Tỉnh/Thành phô',
                ]
            );
            if ($validator->fails()) {
                $validate = array(
                    'data' => response()->json($validator->errors()),
                    'maloi' => "vali_1",
                );
                return $validate;
            }else{
                if($id == Auth::guard('loginbygoogles')->id()){
                    DB::beginTransaction();
                    try{
                        $ins = DB::table('24_thongtincanhan')
                        ->updateOrInsert(
                            [
                                "id_taikhoan" => $id
                            ],$data
                        );
                        $user_agent = $_SERVER['HTTP_USER_AGENT'];
                        DB::table('24_lichsu')
                        ->insert([
                            'id_taikhoan' => $id,
                            'noidung'   => "Cập nhật thông tin cá nhân cơ bản",
                            'hienthi'   => 1,
                            'id_nhansu' => 0,
                            'thietbi'   => $user_agent,
                            'ip'        => request()->ip()
                        ]);
                        DB::commit();
                        if($ins == 1){
                            return "UpOrIns_1";
                        }else{
                            return "UpOrIns_0";
                        }
                    }catch(Exception $e){
                        DB::rollBack();
                        return -100 ;
                    }
                }else{
                    return -100;
                }
            }
            }
        }else{
            return -100;
        }
    }

    function rand_string( $length ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str ='';
        $size = strlen( $chars );

        for( $i = 0; $i < $length ; $i++ ) {
            $str .= $chars[rand( 0, $size - 1)];
        }
        return $str;
    }

    function upload_anhdaidien(Request $request){
        $id_taikhoan = $request->input('id_user');
        $src =  $request->input('src');
        if($id_taikhoan == Auth::guard('loginbygoogles')->id()){
            $del_img = DB::table('24_image')
            ->where('loaianh',1)
            ->where('id_taikhoan',$id_taikhoan)
            ->where('id_image_chuan',1)
            ->get();
            $unlink = 1;
            if(count($del_img) == 1){
                if(File::exists(ltrim($del_img[0] ->path_img,"/"))){
                    unlink(ltrim($del_img[0] ->path_img,"/"));
                }else{
                    $unlink = -2;
                }
            }
            if($unlink === -2){
                return -100;
            }else{
                $prefixfileName = 'anhdaidien_'.$this->rand_string(10).'.png';
                $path = '/images/thisinh'.'/'.$id_taikhoan.'/'.$prefixfileName;
                list($type, $src) = explode(';', $src);
                list(, $src)      = explode(',', $src);
                $data = base64_decode($src);
                $storage = Storage::disk('local');
                $storage->put('/thisinh'.'/'.$id_taikhoan.'/'.$prefixfileName, $data, 'public');
                DB::beginTransaction();
                try{
                    DB::table('24_image')
                    ->updateOrInsert(
                        [
                            'id_taikhoan'   => $id_taikhoan,
                            'loaianh'       => 1,
                            'id_image_chuan'       => 1
                        ],
                        [
                            'path_img'     => $path,
                        ]
                    );
                    DB::commit();
                    $img = DB::table('24_image')
                    ->where('loaianh',1)
                    ->where('id_taikhoan',$id_taikhoan)
                    ->where('id_image_chuan',1)
                    ->first();
                    $res = array(
                        'act' => "UpOrIns_1",
                        'path' => $img->path_img
                    );
                    return $res;
                }catch(Exception $e){
                    DB::rollBack();
                    return -100;
                }
            }
        }else{
            return -100;
        }
    }

    function upload_cccd(Request $request){
        $id_taikhoan = $request->input('id_user');
        $src =  $request->input('src');
        // if($this->checkkhoadangky($id_taikhoan) == 0){
            if($id_taikhoan == Auth::guard('loginbygoogles')->id()){
                $del_img = DB::table('24_image')
                ->where('loaianh',2)
                ->where('id_taikhoan',$id_taikhoan)
                ->where('id_image_chuan',2)
                ->get();
                $unlink = 1;
                if(count($del_img) == 1){
                    if(File::exists(ltrim($del_img[0] ->path_img,"/"))){
                        unlink(ltrim($del_img[0] ->path_img,"/"));
                    }else{
                        $unlink = -2;
                    }
                }
                if($unlink === -2){
                    return -100;
                }else{
                    $prefixfileName = 'cccd_'.$this->rand_string(10).'.png';
                    $path = '/images/thisinh'.'/'.$id_taikhoan.'/'.$prefixfileName;
                    list($type, $src) = explode(';', $src);
                    list(, $src)      = explode(',', $src);
                    $data = base64_decode($src);
                    $storage = Storage::disk('local');
                    $storage->put('/thisinh'.'/'.$id_taikhoan.'/'.$prefixfileName, $data, 'public');
                    // DB::beginTransaction();
                    // try{
                        DB::table('24_image')
                        ->updateOrInsert(
                            [
                                'id_taikhoan'           => $id_taikhoan,
                                'loaianh'               => 2,
                                'id_image_chuan'        => 2
                            ],
                            [
                                'path_img'     => $path,
                            ]
                        );
                        DB::commit();
                        $img = DB::table('24_image')
                        ->where('loaianh',2)
                        ->where('id_taikhoan',$id_taikhoan)
                        ->where('id_image_chuan',2)
                        ->first();
                        if($img) {
                            $res = array(
                                'act' => "UpOrIns_1",
                                'path' => $img->path_img
                            );
                        }else{
                            $res = array(
                                'act' => "UpOrIns_0",
                                'path' => '/img/test.png'
                            );
                        }
                    //     return $res;
                    // }catch(Exception $e){
                    //     DB::rollBack();
                    //     return -100;
                    // }
                }
            }else{
                return -1003;
            }
        // }else{
        //     return "khoadangky_ttcn";
        // }

    }

    function upload_cccdsau(Request $request){
        $id_taikhoan = $request->input('id_user');
        $src =  $request->input('src');
        // if($this->checkkhoadangky($id_taikhoan) == 0){
            if($id_taikhoan == Auth::guard('loginbygoogles')->id()){
                $del_img = DB::table('24_image')
                ->where('loaianh',3)
                ->where('id_taikhoan',$id_taikhoan)
                ->where('id_image_chuan',3)
                ->get();
                $unlink = 1;
                if(count($del_img) == 1){
                    if(File::exists(ltrim($del_img[0] ->path_img,"/"))){
                        unlink(ltrim($del_img[0] ->path_img,"/"));
                    }else{
                        $unlink = -2;
                    }
                }
                if($unlink === -2){
                    return -100;
                }else{
                    $prefixfileName = 'upload_cccdsau_'.$this->rand_string(10).'.png';
                    $path = '/images/thisinh'.'/'.$id_taikhoan.'/'.$prefixfileName;
                    list($type, $src) = explode(';', $src);
                    list(, $src)      = explode(',', $src);
                    $data = base64_decode($src);
                    $storage = Storage::disk('local');
                    $storage->put('/thisinh'.'/'.$id_taikhoan.'/'.$prefixfileName, $data, 'public');
                    DB::beginTransaction();
                    try{
                        DB::table('24_image')
                        ->updateOrInsert(
                            [
                                'id_taikhoan'           => $id_taikhoan,
                                'loaianh'               => 3,
                                'id_image_chuan'        => 3
                            ],
                            [
                                'path_img'     => $path,
                            ]
                        );
                        DB::commit();
                        $img = DB::table('24_image')
                        ->where('loaianh',3)
                        ->where('id_taikhoan',$id_taikhoan)
                        ->where('id_image_chuan',3)
                        ->first();
                        if($img) {
                            $res = array(
                                'act' => "UpOrIns_1",
                                'path' => $img->path_img
                            );
                        }else{
                            $res = array(
                                'act' => "UpOrIns_0",
                                'path' => '/img/test.png'
                            );
                        }
                        return $res;
                    }catch(Exception $e){
                        DB::rollBack();
                        return -100;
                    }
                }
            }else{
                return -100;
            }
        // }else{
        //     return "khoadangky_ttcn";
        // }
    }

    function upload_hocbathongtin(Request $request){
        $id_taikhoan = $request->input('id_user');
        $src =  $request->input('src');
        // if($this->checkkhoadangky($id_taikhoan) == 0){
            if($id_taikhoan == Auth::guard('loginbygoogles')->id()){
                $del_img = DB::table('24_image')
                ->where('loaianh',10)
                ->where('id_taikhoan',$id_taikhoan)
                ->where('id_image_chuan',10)
                ->get();
                $unlink = 1;
                if(count($del_img) == 1){
                    if(File::exists(ltrim($del_img[0] ->path_img,"/"))){
                        unlink(ltrim($del_img[0] ->path_img,"/"));
                    }else{
                        $unlink = -2;
                    }
                }
                if($unlink === -2){
                    return -100;
                }else{
                    $prefixfileName = 'upload_hocbathongtin_'.$this->rand_string(10).'.png';
                    $path = '/images/thisinh'.'/'.$id_taikhoan.'/'.$prefixfileName;
                    list($type, $src) = explode(';', $src);
                    list(, $src)      = explode(',', $src);
                    $data = base64_decode($src);
                    $storage = Storage::disk('local');
                    $storage->put('/thisinh'.'/'.$id_taikhoan.'/'.$prefixfileName, $data, 'public');
                    DB::beginTransaction();
                    try{
                        DB::table('24_image')
                        ->updateOrInsert(
                            [
                                'id_taikhoan'           => $id_taikhoan,
                                'loaianh'               => 10,
                                'id_image_chuan'        => 10
                            ],
                            [
                                'path_img'     => $path,
                            ]
                        );
                        DB::commit();
                        $img = DB::table('24_image')
                        ->where('loaianh',10)
                        ->where('id_taikhoan',$id_taikhoan)
                        ->where('id_image_chuan',10)
                        ->first();
                        if($img) {
                            $res = array(
                                'act' => "UpOrIns_1",
                                'path' => $img->path_img
                            );
                        }else{
                            $res = array(
                                'act' => "UpOrIns_0",
                                'path' => '/img/test.png'
                            );
                        }
                        return $res;
                    }catch(Exception $e){
                        DB::rollBack();
                        return -100;
                    }
                }
            }else{
                return -100;
            }
        // }else{
        //     return "khoadangky_ttcn";
        // }
    }

    function upload_hbhocbalop10(Request $request){
        $id_taikhoan = $request->input('id_user');
        $src =  $request->input('src');
        // if($this->checkkhoadangky($id_taikhoan) == 0){
            if($id_taikhoan == Auth::guard('loginbygoogles')->id()){
                $del_img = DB::table('24_image')
                ->where('loaianh',4)
                ->where('id_taikhoan',$id_taikhoan)
                ->where('id_image_chuan',4)
                ->get();
                $unlink = 1;
                if(count($del_img) == 1){
                    if(File::exists(ltrim($del_img[0] ->path_img,"/"))){
                        unlink(ltrim($del_img[0] ->path_img,"/"));
                    }else{
                        $unlink = -2;
                    }
                }
                if($unlink === -2){
                    return -100;
                }else{
                    $prefixfileName = 'upload_hbhocbalop10_'.$this->rand_string(10).'.png';
                    $path = '/images/thisinh'.'/'.$id_taikhoan.'/'.$prefixfileName;
                    list($type, $src) = explode(';', $src);
                    list(, $src)      = explode(',', $src);
                    $data = base64_decode($src);
                    $storage = Storage::disk('local');
                    $storage->put('/thisinh'.'/'.$id_taikhoan.'/'.$prefixfileName, $data, 'public');
                    DB::beginTransaction();
                    try{
                        DB::table('24_image')
                        ->updateOrInsert(
                            [
                                'id_taikhoan'           => $id_taikhoan,
                                'loaianh'               => 4,
                                'id_image_chuan'        => 4
                            ],
                            [
                                'path_img'     => $path,
                            ]
                        );
                        DB::commit();
                        $img = DB::table('24_image')
                        ->where('loaianh',4)
                        ->where('id_taikhoan',$id_taikhoan)
                        ->where('id_image_chuan',4)
                        ->first();
                        if($img) {
                            $res = array(
                                'act' => "UpOrIns_1",
                                'path' => $img->path_img
                            );
                        }else{
                            $res = array(
                                'act' => "UpOrIns_0",
                                'path' => '/img/test.png'
                            );
                        }
                        return $res;
                    }catch(Exception $e){
                        DB::rollBack();
                        return -100;
                    }
                }
            }else{
                return -100;
            }
        // }else{
        //     return "khoadangky_ttcn";
        // }
    }

    function upload_hocbalop11(Request $request){
        $id_taikhoan = $request->input('id_user');
        $src =  $request->input('src');
        // if($this->checkkhoadangky($id_taikhoan) == 0){
            if($id_taikhoan == Auth::guard('loginbygoogles')->id()){
                $del_img = DB::table('24_image')
                ->where('loaianh',5)
                ->where('id_taikhoan',$id_taikhoan)
                ->where('id_image_chuan',5)
                ->get();
                $unlink = 1;
                if(count($del_img) == 1){
                    if(File::exists(ltrim($del_img[0] ->path_img,"/"))){
                        unlink(ltrim($del_img[0] ->path_img,"/"));
                    }else{
                        $unlink = -2;
                    }
                }
                if($unlink === -2){
                    return -100;
                }else{
                    $prefixfileName = 'upload_hocbalop11_'.$this->rand_string(10).'.png';
                    $path = '/images/thisinh'.'/'.$id_taikhoan.'/'.$prefixfileName;
                    list($type, $src) = explode(';', $src);
                    list(, $src)      = explode(',', $src);
                    $data = base64_decode($src);
                    $storage = Storage::disk('local');
                    $storage->put('/thisinh'.'/'.$id_taikhoan.'/'.$prefixfileName, $data, 'public');
                    DB::beginTransaction();
                    try{
                        DB::table('24_image')
                        ->updateOrInsert(
                            [
                                'id_taikhoan'           => $id_taikhoan,
                                'loaianh'               => 5,
                                'id_image_chuan'        => 5
                            ],
                            [
                                'path_img'     => $path,
                            ]
                        );
                        DB::commit();
                        $img = DB::table('24_image')
                        ->where('loaianh',5)
                        ->where('id_taikhoan',$id_taikhoan)
                        ->where('id_image_chuan',5)
                        ->first();
                        if($img) {
                            $res = array(
                                'act' => "UpOrIns_1",
                                'path' => $img->path_img
                            );
                        }else{
                            $res = array(
                                'act' => "UpOrIns_0",
                                'path' => '/img/test.png'
                            );
                        }
                        return $res;
                    }catch(Exception $e){
                        DB::rollBack();
                        return -100;
                    }
                }
            }else{
                return -100;
            }
        // }else{
        //     return "khoadangky_ttcn";
        // }
    }

    function upload_hbhocbalop12(Request $request){
        $id_taikhoan = $request->input('id_user');
        $src =  $request->input('src');
        // if($this->checkkhoadangky($id_taikhoan) == 0){
            if($id_taikhoan == Auth::guard('loginbygoogles')->id()){
                $del_img = DB::table('24_image')
                ->where('loaianh',6)
                ->where('id_taikhoan',$id_taikhoan)
                ->where('id_image_chuan',6)
                ->get();
                $unlink = 1;
                if(count($del_img) == 1){
                    if(File::exists(ltrim($del_img[0] ->path_img,"/"))){
                        unlink(ltrim($del_img[0] ->path_img,"/"));
                    }else{
                        $unlink = -2;
                    }
                }
                if($unlink === -2){
                    return -100;
                }else{
                    $prefixfileName = 'upload_hbhocbalop12_'.$this->rand_string(10).'.png';
                    $path = '/images/thisinh'.'/'.$id_taikhoan.'/'.$prefixfileName;
                    list($type, $src) = explode(';', $src);
                    list(, $src)      = explode(',', $src);
                    $data = base64_decode($src);
                    $storage = Storage::disk('local');
                    $storage->put('/thisinh'.'/'.$id_taikhoan.'/'.$prefixfileName, $data, 'public');
                    DB::beginTransaction();
                    try{
                        DB::table('24_image')
                        ->updateOrInsert(
                            [
                                'id_taikhoan'           => $id_taikhoan,
                                'loaianh'               => 6,
                                'id_image_chuan'        => 6
                            ],
                            [
                                'path_img'     => $path,
                            ]
                        );
                        DB::commit();
                        $img = DB::table('24_image')
                        ->where('loaianh',6)
                        ->where('id_taikhoan',$id_taikhoan)
                        ->where('id_image_chuan',6)
                        ->first();
                        if($img) {
                            $res = array(
                                'act' => "UpOrIns_1",
                                'path' => $img->path_img
                            );
                        }else{
                            $res = array(
                                'act' => "UpOrIns_0",
                                'path' => '/img/test.png'
                            );
                        }
                        return $res;
                    }catch(Exception $e){
                        DB::rollBack();
                        return -100;
                    }
                }
            }else{
                return -100;
            }
        // }else{
        //     return "khoadangky_ttcn";
        // }

    }

    function upload_uutien1(Request $request){
        $id_taikhoan = $request->input('id_user');
        $src =  $request->input('src');
        // if($this->checkkhoadangky($id_taikhoan) == 0){
            if($id_taikhoan == Auth::guard('loginbygoogles')->id()){
                $del_img = DB::table('24_image')
                ->where('loaianh',7)
                ->where('id_taikhoan',$id_taikhoan)
                ->where('id_image_chuan',7)
                ->get();
                $unlink = 1;
                if(count($del_img) == 1){
                    if(File::exists(ltrim($del_img[0] ->path_img,"/"))){
                        unlink(ltrim($del_img[0] ->path_img,"/"));
                    }else{
                        $unlink = -2;
                    }
                }
                if($unlink === -2){
                    return -100;
                }else{
                    $prefixfileName = 'upload_uutien1_'.$this->rand_string(10).'.png';
                    $path = '/images/thisinh'.'/'.$id_taikhoan.'/'.$prefixfileName;
                    list($type, $src) = explode(';', $src);
                    list(, $src)      = explode(',', $src);
                    $data = base64_decode($src);
                    $storage = Storage::disk('local');
                    $storage->put('/thisinh'.'/'.$id_taikhoan.'/'.$prefixfileName, $data, 'public');
                    DB::beginTransaction();
                    try{
                        DB::table('24_image')
                        ->updateOrInsert(
                            [
                                'id_taikhoan'           => $id_taikhoan,
                                'loaianh'               => 7,
                                'id_image_chuan'        => 7
                            ],
                            [
                                'path_img'     => $path,
                            ]
                        );
                        DB::commit();
                        $img = DB::table('24_image')
                        ->where('loaianh',7)
                        ->where('id_taikhoan',$id_taikhoan)
                        ->where('id_image_chuan',7)
                        ->first();
                        if($img) {
                            $res = array(
                                'act' => "UpOrIns_1",
                                'path' => $img->path_img
                            );
                        }else{
                            $res = array(
                                'act' => "UpOrIns_0",
                                'path' => '/img/test.png'
                            );
                        }
                        return $res;
                    }catch(Exception $e){
                        DB::rollBack();
                        return -100;
                    }
                }
            }else{
                return -100;
            }
        // }else{
        //     return "khoadangky_ttcn";
        // }
    }

    function upload_uutien2(Request $request){
        $id_taikhoan = $request->input('id_user');
        $src =  $request->input('src');
        // if($this->checkkhoadangky($id_taikhoan) == 0){
            if($id_taikhoan == Auth::guard('loginbygoogles')->id()){
                $del_img = DB::table('24_image')
                ->where('loaianh',8)
                ->where('id_taikhoan',$id_taikhoan)
                ->where('id_image_chuan',8)
                ->get();
                $unlink = 1;
                if(count($del_img) == 1){
                    if(File::exists(ltrim($del_img[0] ->path_img,"/"))){
                        unlink(ltrim($del_img[0] ->path_img,"/"));
                    }else{
                        $unlink = -2;
                    }
                }
                if($unlink === -2){
                    return -100;
                }else{
                    $prefixfileName = 'upload_uutien2_'.$this->rand_string(10).'.png';
                    $path = '/images/thisinh'.'/'.$id_taikhoan.'/'.$prefixfileName;
                    list($type, $src) = explode(';', $src);
                    list(, $src)      = explode(',', $src);
                    $data = base64_decode($src);
                    $storage = Storage::disk('local');
                    $storage->put('/thisinh'.'/'.$id_taikhoan.'/'.$prefixfileName, $data, 'public');
                    DB::beginTransaction();
                    try{
                        DB::table('24_image')
                        ->updateOrInsert(
                            [
                                'id_taikhoan'           => $id_taikhoan,
                                'loaianh'               => 8,
                                'id_image_chuan'        => 8
                            ],
                            [
                                'path_img'     => $path,
                            ]
                        );
                        DB::commit();
                        $img = DB::table('24_image')
                        ->where('loaianh',8)
                        ->where('id_taikhoan',$id_taikhoan)
                        ->where('id_image_chuan',8)
                        ->first();
                        if($img) {
                            $res = array(
                                'act' => "UpOrIns_1",
                                'path' => $img->path_img
                            );
                        }else{
                            $res = array(
                                'act' => "UpOrIns_0",
                                'path' => '/img/test.png'
                            );
                        }
                        return $res;
                    }catch(Exception $e){
                        DB::rollBack();
                        return -100;
                    }
                }
            }else{
                return -100;
            }
        // }else{
        //     return "khoadangky_ttcn";
        // }
    }

    function upload_bangtotnghiep(Request $request){
        $id_taikhoan = $request->input('id_user');
        $src =  $request->input('src');
        // if($this->checkkhoadangky($id_taikhoan) == 0){
            if($id_taikhoan == Auth::guard('loginbygoogles')->id()){
                $del_img = DB::table('24_image')
                ->where('loaianh',9)
                ->where('id_taikhoan',$id_taikhoan)
                ->where('id_image_chuan',9)
                ->get();
                $unlink = 1;
                if(count($del_img) == 1){
                    if(File::exists(ltrim($del_img[0] ->path_img,"/"))){
                        unlink(ltrim($del_img[0] ->path_img,"/"));
                    }else{
                        $unlink = -2;
                    }
                }
                if($unlink === -2){
                    return -100;
                }else{
                    $prefixfileName = 'upload_bangtotnghiep_'.$this->rand_string(10).'.png';
                    $path = '/images/thisinh'.'/'.$id_taikhoan.'/'.$prefixfileName;
                    list($type, $src) = explode(';', $src);
                    list(, $src)      = explode(',', $src);
                    $data = base64_decode($src);
                    $storage = Storage::disk('local');
                    $storage->put('/thisinh'.'/'.$id_taikhoan.'/'.$prefixfileName, $data, 'public');
                    DB::beginTransaction();
                    try{
                        DB::table('24_image')
                        ->updateOrInsert(
                            [
                                'id_taikhoan'           => $id_taikhoan,
                                'loaianh'               => 9,
                                'id_image_chuan'        => 9
                            ],
                            [
                                'path_img'     => $path,
                            ]
                        );
                        DB::commit();
                        $img = DB::table('24_image')
                        ->where('loaianh',9)
                        ->where('id_taikhoan',$id_taikhoan)
                        ->where('id_image_chuan',9)
                        ->first();
                        if($img) {
                            $res = array(
                                'act' => "UpOrIns_1",
                                'path' => $img->path_img
                            );
                        }else{
                            $res = array(
                                'act' => "UpOrIns_0",
                                'path' => '/img/test.png'
                            );
                        }
                        return $res;
                    }catch(Exception $e){
                        DB::rollBack();
                        return -100;
                    }
                }
            }else{
                return -100;
            }
        // }else{
        //     return "khoadangky_ttcn";
        // }
    }


    function upload_gxnkqthi(Request $request){
        $id_taikhoan = $request->input('id_user');
        $src =  $request->input('src');
        // if($this->checkkhoadangky($id_taikhoan) == 0){
            if($id_taikhoan == Auth::guard('loginbygoogles')->id()){
                $del_img = DB::table('24_image')
                ->where('loaianh',11)
                ->where('id_taikhoan',$id_taikhoan)
                ->where('id_image_chuan',11)
                ->get();
                $unlink = 1;
                if(count($del_img) == 1){
                    if(File::exists(ltrim($del_img[0] ->path_img,"/"))){
                        unlink(ltrim($del_img[0] ->path_img,"/"));
                    }else{
                        $unlink = -2;
                    }
                }
                if($unlink === -2){
                    return -100;
                }else{
                    $prefixfileName = 'upload_gxnkqthi_'.$this->rand_string(10).'.png';
                    $path = '/images/thisinh'.'/'.$id_taikhoan.'/'.$prefixfileName;
                    list($type, $src) = explode(';', $src);
                    list(, $src)      = explode(',', $src);
                    $data = base64_decode($src);
                    $storage = Storage::disk('local');
                    $storage->put('/thisinh'.'/'.$id_taikhoan.'/'.$prefixfileName, $data, 'public');
                    DB::beginTransaction();
                    try{
                        DB::table('24_image')
                        ->updateOrInsert(
                            [
                                'id_taikhoan'           => $id_taikhoan,
                                'loaianh'               => 11,
                                'id_image_chuan'        => 11
                            ],
                            [
                                'path_img'     => $path,
                            ]
                        );
                        DB::commit();
                        $img = DB::table('24_image')
                        ->where('loaianh',11)
                        ->where('id_taikhoan',$id_taikhoan)
                        ->where('id_image_chuan',11)
                        ->first();
                        if($img) {
                            $res = array(
                                'act' => "UpOrIns_1",
                                'path' => $img->path_img
                            );
                        }else{
                            $res = array(
                                'act' => "UpOrIns_0",
                                'path' => '/img/test.png'
                            );
                        }
                        return $res;
                    }catch(Exception $e){
                        DB::rollBack();
                        return -100;
                    }
                }
            }else{
                return -100;
            }
        // }else{
        //     return "khoadangky_ttcn";
        // }
    }


    function upload_gxntntamthoi(Request $request){
        $id_taikhoan = $request->input('id_user');
        $src =  $request->input('src');
        // if($this->checkkhoadangky($id_taikhoan) == 0){
            if($id_taikhoan == Auth::guard('loginbygoogles')->id()){
                $del_img = DB::table('24_image')
                ->where('loaianh',12)
                ->where('id_taikhoan',$id_taikhoan)
                ->where('id_image_chuan',12)
                ->get();
                $unlink = 1;
                if(count($del_img) == 1){
                    if(File::exists(ltrim($del_img[0] ->path_img,"/"))){
                        unlink(ltrim($del_img[0] ->path_img,"/"));
                    }else{
                        $unlink = -2;
                    }
                }
                if($unlink === -2){
                    return -100;
                }else{
                    $prefixfileName = 'upload_gxntntamthoi_'.$this->rand_string(10).'.png';
                    $path = '/images/thisinh'.'/'.$id_taikhoan.'/'.$prefixfileName;
                    list($type, $src) = explode(';', $src);
                    list(, $src)      = explode(',', $src);
                    $data = base64_decode($src);
                    $storage = Storage::disk('local');
                    $storage->put('/thisinh'.'/'.$id_taikhoan.'/'.$prefixfileName, $data, 'public');
                    DB::beginTransaction();
                    try{
                        DB::table('24_image')
                        ->updateOrInsert(
                            [
                                'id_taikhoan'           => $id_taikhoan,
                                'loaianh'               => 12,
                                'id_image_chuan'        => 12
                            ],
                            [
                                'path_img'     => $path,
                            ]
                        );
                        DB::commit();
                        $img = DB::table('24_image')
                        ->where('loaianh',12)
                        ->where('id_taikhoan',$id_taikhoan)
                        ->where('id_image_chuan',12)
                        ->first();
                        if($img) {
                            $res = array(
                                'act' => "UpOrIns_1",
                                'path' => $img->path_img
                            );
                        }else{
                            $res = array(
                                'act' => "UpOrIns_0",
                                'path' => '/img/test.png'
                            );
                        }
                        return $res;
                    }catch(Exception $e){
                        DB::rollBack();
                        return -100;
                    }
                }
            }else{
                return -100;
            }
        // }else{
        //     return "khoadangky_ttcn";
        // }
    }

    function upload_bhyt(Request $request){
        $id_taikhoan = $request->input('id_user');
        $src =  $request->input('src');
        // if($this->checkkhoadangky($id_taikhoan) == 0){
            if($id_taikhoan == Auth::guard('loginbygoogles')->id()){
                $del_img = DB::table('24_image')
                ->where('loaianh',13)
                ->where('id_taikhoan',$id_taikhoan)
                ->where('id_image_chuan',13)
                ->get();
                $unlink = 1;
                if(count($del_img) == 1){
                    if(File::exists(ltrim($del_img[0] ->path_img,"/"))){
                        unlink(ltrim($del_img[0] ->path_img,"/"));
                    }else{
                        $unlink = -2;
                    }
                }
                if($unlink === -2){
                    return -100;
                }else{
                    $prefixfileName = 'upload_bhyt_'.$this->rand_string(10).'.png';
                    $path = '/images/thisinh'.'/'.$id_taikhoan.'/'.$prefixfileName;
                    list($type, $src) = explode(';', $src);
                    list(, $src)      = explode(',', $src);
                    $data = base64_decode($src);
                    $storage = Storage::disk('local');
                    $storage->put('/thisinh'.'/'.$id_taikhoan.'/'.$prefixfileName, $data, 'public');
                    DB::beginTransaction();
                    try{
                        DB::table('24_image')
                        ->updateOrInsert(
                            [
                                'id_taikhoan'           => $id_taikhoan,
                                'loaianh'               => 13,
                                'id_image_chuan'        => 13
                            ],
                            [
                                'path_img'     => $path,
                            ]
                        );
                        DB::commit();
                        $img = DB::table('24_image')
                        ->where('loaianh',13)
                        ->where('id_taikhoan',$id_taikhoan)
                        ->where('id_image_chuan',13)
                        ->first();
                        if($img) {
                            $res = array(
                                'act' => "UpOrIns_1",
                                'path' => $img->path_img
                            );
                        }else{
                            $res = array(
                                'act' => "UpOrIns_0",
                                'path' => '/img/test.png'
                            );
                        }
                        return $res;
                    }catch(Exception $e){
                        DB::rollBack();
                        return -100;
                    }
                }
            }else{
                return -100;
            }
        // }else{
        //     return "khoadangky_ttcn";
        // }
    }













    function luutruongthpt(Request $request){
        if($this ->kiemtrathongtincanhan() == 1){
            $data = [];
            $data['tinhthpt'] = $request->input('data')[2];
            $data['truongthpt'] = $request->input('data')[3];
            $validator = Validator::make($data,
                [
                    'tinhthpt'                       =>'integer|min:1',
                    'truongthpt'                     =>'integer|min:1',
                ],
                [
                    'tinhthpt.min'                   =>'Chọn Tỉnh/Thành phô',
                    'truongthpt.min'                 =>'Chọn Trường THPT',
                ]
            );
            if ($validator->fails()) {
                $validate = array(
                    'data' => response()->json($validator->errors()),
                    'maloi' => "vali_1",
                );
                return $validate;
            }else{
                $id_taikhoan = $request->input('data')[0];
                $id_lop = $request->input('data')[1];
                $id_tinh = $request->input('data')[2];
                $id_truong = $request->input('data')[3];
                if($id_taikhoan == Auth::guard('loginbygoogles')->id()){
                    DB::beginTransaction();
                    try{
                        DB::table('24_truongthpt')
                        ->updateOrInsert(
                            [
                                'id_taikhoan' => $id_taikhoan,
                                'id_lop' => $id_lop,
                            ],
                            [
                                'id_tinh' => $id_tinh,
                                'id_truong' => $id_truong,
                            ]
                        );
                        $truongthpt = DB::table('24_truongthpt')
                        ->where('id_taikhoan',$id_taikhoan)
                        ->join('l_school','id_truong',"l_school.id")
                        ->join('l_priority_area','priority_area_school',"l_priority_area.id")
                        ->where('id_lop',$id_lop)
                        ->first();

                        $tenkhuvucuutien =$this->diemtuutientheotruongthpt($id_taikhoan)['tenkhuvucuutien'];
                        $khuvucuutien = $this->diemtuutientheotruongthpt($id_taikhoan)['khuvucuutien'];
                        if( $khuvucuutien != 0){
                            DB::table('24_khuvucuutien')
                            ->updateOrInsert(
                                [
                                    'id_taikhoan' => $id_taikhoan,
                                ],
                                [
                                    'khuvucuutien' => $khuvucuutien
                                ],
                            );
                            $noidungkhuvucuutien = "; Khu vực ưu tiên theo Trường: ".$tenkhuvucuutien;
                        }else{
                            $noidungkhuvucuutien = '';
                        }

                        $user_agent = $_SERVER['HTTP_USER_AGENT'];
                        DB::table('24_lichsu')
                        ->insert([
                            'id_taikhoan' => $id_taikhoan,
                            'noidung'   => "Cập nhật Trường THPT: ".$truongthpt->name_school.$noidungkhuvucuutien,
                            'hienthi'   => 1,
                            'id_nhansu' => 0,
                            'thietbi'   => $user_agent,
                            'ip'        => request()->ip()
                        ]);
                        $res = array(
                            'act' =>  "UpOrIns_1",
                            'khuvuc' => $truongthpt->id_priority_area,
                            'tenkhuvucuutien' => $tenkhuvucuutien,
                        );
                        DB::commit();
                        return $res;
                    }catch(Exception $e){
                        DB::rollBack();
                        return -100;
                    }
                }else{
                    return -100;
                }
            }
        }else{
            return "thongtincanhan";
        }

    }

    function  chuyentinhthpt(Request $request){
        $truong0 =  new Collection(
            [
                'id' => 0,
                'text' => 'Chọn Trường THPT',
                'selected' => true
            ]
        );
        $id_taikhoan = $request->input('id_user');
        $id_tinh = $request->input('id_tinh');
        if($id_taikhoan == Auth::guard('loginbygoogles')->id()){
            $truongthpts = DB::table('l_school')
            ->select('name_school as text','l_school.id as id','id_province')
            ->where('id_province',$id_tinh)
            ->get();
            if($truongthpts){
                foreach ($truongthpts as $truongthpt ){
                    $truongthpt ->selected = "";
                }
               $truongthpts[] = $truong0;
               return $truongthpts;
            }else{
                return "";
            }
        }else{
            return "";
        }
    }


    function namtotnghiep(Request $request){
        if($this ->kiemtrathongtincanhan() == 1){
            $validator = Validator::make($request->all(),
                [
                    'namtotnghiep'              => 'numeric|regex:/^\d+$/|between:2000,'.Carbon::now()->year,
                ],
                [
                    'namtotnghiep.numeric'      =>'Năm TN phải là số nguyên dương',
                    'namtotnghiep.regex'        =>'Năm TN phải là số nguyên dương',
                    'namtotnghiep.between'        =>'Năm TN nằm giữa 2000 và năm hiện tại,'
                ]
            );
            if ($validator->fails()) {
                $validate = array(
                    'data' => response()->json($validator->errors()),
                    'maloi' => "vali_1",
                );
                return $validate;
            }else{
                $id_taikhoan = $request->input('id_user');
                $namtotnghiep = $request->input('namtotnghiep');
                if($id_taikhoan == Auth::guard('loginbygoogles')->id()){
                    DB::beginTransaction();
                    try{
                        DB::table('24_namtotnghiep')
                        ->updateOrInsert(
                            [
                                'id_taikhoan' => $id_taikhoan,
                            ],
                            [
                                'namtotnghiep' => $namtotnghiep,
                            ]
                        );
                        $tenkhuvucuutien =$this->diemtuutientheotruongthpt($id_taikhoan)['tenkhuvucuutien'];
                        $khuvucuutien = $this->diemtuutientheotruongthpt($id_taikhoan)['khuvucuutien'];
                        if($this->diemtuutientheotruongthpt($id_taikhoan)['khuvucuutien'] != 0){
                            DB::table('24_khuvucuutien')
                            ->updateOrInsert(
                                [
                                    'id_taikhoan' => $id_taikhoan,
                                ],
                                [
                                    'khuvucuutien' => $khuvucuutien
                                ],
                            );
                            $noidungkhuvucuutien = "; Khu vực ưu tiên theo Trường: ".$tenkhuvucuutien;
                        }else{
                            $noidungkhuvucuutien = '';
                        }
                        $user_agent = $_SERVER['HTTP_USER_AGENT'];
                        DB::table('24_lichsu')
                        ->insert([
                            'id_taikhoan' => $id_taikhoan,
                            'noidung'   => "Cập nhật Năm tốt nghiệp: ".$namtotnghiep.$noidungkhuvucuutien,
                            'hienthi'   => 1,
                            'id_nhansu' => 0,
                            'thietbi'   => $user_agent,
                            'ip'        => request()->ip()
                        ]);

                        DB::commit();
                        $res = array(
                            'act' =>"UpOrIns_1",
                            'tenkhuvucuutien' =>$tenkhuvucuutien,
                        );

                        return $res;
                    }catch(Exception $e){
                        DB::rollBack();
                        return -100;
                    }
                }else{
                    return -100;
                }
            }
        }else{
            return "thongtincanhan";
        }

    }

    public function luudoituonguutien(Request $request){
        if($this ->kiemtrathongtincanhan() == 1){
            $id_taikhoan = $request->input('id_user');
            $id_doituong = $request->input('doituonguutien');
            // return    $id_doituong;
            if($id_taikhoan == Auth::guard('loginbygoogles')->id()){
                if($this->kiemtrahinhanh($id_taikhoan,7) == 1){
                    if($id_doituong == 0){
                        DB::beginTransaction();
                        try{
                            DB::table("24_doituonguutien")
                            ->where('id_taikhoan',$id_taikhoan)
                            ->delete();
                            DB::table("24_image")
                            ->where('id_taikhoan',$id_taikhoan)
                            ->where('loaianh',7)
                            ->delete();
                            DB::table("24_image")
                            ->where('id_taikhoan',$id_taikhoan)
                            ->where('loaianh',8)
                            ->delete();
                            $user_agent = $_SERVER['HTTP_USER_AGENT'];
                            DB::table('24_lichsu')
                            ->insert([
                                'id_taikhoan' => $id_taikhoan,
                                'noidung'   => "Cập nhật đối tượng ưu tiên: Hủy",
                                'hienthi'   => 1,
                                'id_nhansu' => 0,
                                'thietbi'   => $user_agent,
                                'ip'        => request()->ip()
                            ]);
                            DB::commit();
                            return "UpOrIns_1";
                        }catch(Exception $e){
                            DB::rollBack();
                            return -100;
                        }
                    }else{
                        DB::beginTransaction();
                        try{
                            DB::table('24_doituonguutien')
                            ->updateOrInsert(
                                [
                                    'id_taikhoan' => $id_taikhoan,
                                ],
                                [
                                    'id_doituong' => $id_doituong,
                                ]
                            );

                            $doituonguutien = DB::table('l_policy_users')
                            ->select('name_policy_user')
                            ->where('id',$id_doituong)
                            ->first();
                            $user_agent = $_SERVER['HTTP_USER_AGENT'];
                            DB::table('24_lichsu')
                            ->insert([
                                'id_taikhoan' => $id_taikhoan,
                                'noidung'   => "Cập nhật đối tượng ưu tiên: ".$doituonguutien ->name_policy_user,
                                'hienthi'   => 1,
                                'id_nhansu' => 0,
                                'thietbi'   => $user_agent,
                                'ip'        => request()->ip()
                            ]);
                            DB::commit();
                            return "UpOrIns_1";
                        }catch(Exception $e){
                            DB::rollBack();
                            return -100;
                        }
                    }
                }else{
                    return "hinhanh";
                }
            }else{
                return -100;
            }
        }else{
            return "thongtincanhan";
        }
    }

    public function chinhsachuutien(){
        return view('user_24.chinhsachuutien',
        [
            'title' => "CTUT|Hệ thống đăng ký xét tuyển",
        ]);
    }

    public function ketquahoctap(){
        return view('user_24.ketquahoctap',
        [
            'title' => "CTUT|Hệ thống đăng ký xét tuyển",
        ]);
    }

}
