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
use Illuminate\Support\Arr;
use function PHPUnit\Framework\countOf;

class Dangkyxettuyen24Controller extends Controller

{

     public function dangkyxettuyen()
    {
        $id_taikhoan = Auth::guard('loginbygoogles')->id();
        $img_slider = DB::select("SELECT 24_image_chuan.id, 24_image_chuan.funtion_id,24_image_chuan.ghichu,24_image_chuan.loaianh,if(image.path_img is null,'/img/test.png',image.path_img) as path_img,if(image.id is null,0,image.id) as test  FROM `24_image_chuan` LEFT JOIN (SELECT * FROM 24_image WHERE id_taikhoan = " . $id_taikhoan . ") AS image ON 24_image_chuan.id = image.id_image_chuan");
        $ten_nganh = DB::table('l_major')->select('*')->get();
        $tohop_nganh = DB::table('l_major_group')->select('*')->get();
        //
        $diems = DB::table('24_ketquahoctap')
            ->where('id_student_result', $id_taikhoan)
            ->get();
        $groups_mons = DB::table('l_group_subject')
            ->get();
        $groups = DB::table('l_group')
            ->where('id_method', 1)
            ->get();
        $chuyennganhs = DB::select('select 24_chuyennganh.id, `tenchuyennganh`, `id_nganh`, `gioithieu`, `moi`,if(X.thutu is null, 0, X.thutu) as thutu  from `24_chuyennganh` LEFT JOIN (SELECT * FROM 24_nguyenvong WHERE id_taikhoan = '.$id_taikhoan.') AS X ON 24_chuyennganh.id = X.id_chuyennganh where `trangthai` = 1');
        $diemthamkhao = DB::table('24_diemtrungtuyen')
            ->select('id_nganh', 'diemtrungtuyen', 'idnam')
            ->where('idnam', '>=', (int)Carbon::now()->year - 2)
            ->get();
        $nganhchitieu = DB::table('24_nganhchitieu')
            ->select('id_nganh', 'idnam', 'chitieu')
            ->get();

        $dangky = DB::table('24_khoadangky')
            ->where('id_taikhoan',$id_taikhoan)
            ->first();
        if($dangky){
            if($dangky->trangthai == 1 || $dangky->trangthai == 3){
                $trangthai = 1;
            }else{
                $trangthai = 0;
            }
        }else{
            $trangthai = 0;
        }
        $all_tohop = $this->tinhdiemtohop($groups_mons, $groups, $diems);
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
                            if($diem->diemxettuyen > $max_diem){
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

            $nganh ->diemxettuyen = $diemxettuyen;
            $nganh ->idtohop = $idtohop;
            $nganh ->tohopxettuyen = $tohopxettuyen;
            $nganh ->diemtohop = $diemtohop;
            $nganh ->uutien = $uutien;
            $arr_chuyennganh = array();


            foreach ($chuyennganhs as $chuyennganh) {
                if ($nganh->id == $chuyennganh->id_nganh) {
                    $arr_chuyennganh[] = array(
                        'tenchuyennganh' => $chuyennganh->tenchuyennganh,
                        'id_chuyennganh' => $chuyennganh->id,
                        'gioithieu' => $chuyennganh->gioithieu,
                        'moi' => $chuyennganh->moi,
                        'thutu' => $chuyennganh->thutu,
                    );
                }
            }

            $nganh->allchuyennganh = $arr_chuyennganh;
            // điểm tham khảo
            $arr_diemthamkhao = array();
            foreach ($diemthamkhao as $thamkhao) {
                if ($nganh->id == $thamkhao->id_nganh) {
                    $arr_diemthamkhao[] = array(
                        'diemthamkhao' => $thamkhao->diemtrungtuyen,
                        'nam' => $thamkhao->idnam,
                    );
                }
            }
            $nganh->all_diemthamkhao = $arr_diemthamkhao;
            //CHỉ tiêu ngành
            $chitieu = 0;
            foreach ($nganhchitieu as $chitieunganh) {
                if ($nganh->id == $chitieunganh->id_nganh) {
                    $chitieu = $chitieunganh->chitieu;
                }
            }
            $nganh->chitieu = $chitieu;
        }

        if (count($ten_nganh) > 0) {
            return view('user_24.dangkyxettuyen',
                [
                    'img_slider_right' =>  $img_slider,
                    'ten_nganh' => $ten_nganh,
                    'trangthai' =>  $trangthai,
                    'img_slider' =>  $img_slider,
                ]
            );
        } else return view(
            'user_24.dangkyxettuyen',
            [
                'img_slider_right' =>  $img_slider,
                'trangthai' =>  $trangthai,
                'img_slider' =>  $img_slider,

            ]
        );
    }

    function diemtuutientheodoituong($id_taikhoan){
        $doituong =DB::table('24_doituonguutien')
        ->join('l_policy_users','id_doituong','l_policy_users.id')
        ->select('id_doituong','mark_policy_user','name_policy_user')
        ->where('id_taikhoan',$id_taikhoan)
        ->first();
        if($doituong){
            $res = array(
                'id_doituong' => $doituong->id_doituong,
                'diemuutien' => $doituong->mark_policy_user,
                'tendoituong' => $doituong->name_policy_user,
            );
        }else{
            $res = array(
                'id_doituong' => "",
                'diemuutien' => 0,
                'tendoituong' => "",
            );
        }
        return   $res;
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

    public function tinhdiemtohop($groups_mons,$groups,$diems){
        $id_taikhoan = Auth::guard('loginbygoogles')->id();
        $uutienkhuvuc = $this->diemtuutientheotruongthpt($id_taikhoan)['diemkhuvucuutien'];
        $uutiendoituong = $this->diemtuutientheodoituong($id_taikhoan)['diemuutien'];
        foreach ($groups as $group) {
            // $group->uutien = $uutienkhuvuc;
            $tenc1 = $group->id_group.'c1';
            $group->$tenc1 = 0;
            $tenc2 = $group->id_group.'c2';
            $group->$tenc2 = 0;
            $group->diemtohop = 0;
            $diemtohop = 0;
            $j=0;
            $i=0;
            foreach ($groups_mons as $groups_mon) {
                if($group->id == $groups_mon ->id_group){
                    foreach ($diems as $diem ) {
                        if($groups_mon->id_subject == $diem->id_subject && $diem->mark_result >0 ){
                            if(($diem->id_class_result == 11  && $diem->id_semester_result == "CN") || ($diem->id_class_result == 10  && $diem->id_semester_result == "CN") || ($diem->id_class_result == 12 && $diem->id_semester_result == 1)){
                                $group->$tenc1 = $group->$tenc1 + $diem->mark_result/3;
                                $i++;
                            }
                            if($diem->id_class_result == 12  && $diem->id_semester_result == "CN"){
                                $group->$tenc2 = $group->$tenc2 + $diem->mark_result;
                                $j++;
                            }
                        }
                    }
                }
            }
            $i == 9 ? $group->$tenc1 = $group->$tenc1 : $group->$tenc1 = 0;
            $j == 3 ? $group->$tenc2 = $group->$tenc2 : $group->$tenc2 = 0;
            if($group->$tenc1 > 0 || $group->$tenc2 >0 ){
                $group->$tenc1 >=  $group->$tenc2 ?   $diemtohop =  $group->$tenc1 : $diemtohop =  $group->$tenc2;
                $group->diemtohop = round($diemtohop,3);
            }else{
                $diemtohop = 0;
            }

            if($group->diemtohop >0){
                if($group->diemtohop >=22.5){
                    $uutien = (((float)30 - (float)($group->diemtohop))/7.5)*($uutienkhuvuc+$uutiendoituong);
                    $group->uutien = round( $uutien,3);
                }else{
                    $uutien = $uutienkhuvuc+$uutiendoituong;
                    $group->uutien = round($uutien,3);
                }
            }else{
                $uutien = 0;
                $group->uutien = 0;
            }

            $group->diemxettuyen = round($uutien + $diemtohop,2);
            // $group->id_tohop = 'tohop'.$group->id;
        }
        return $groups;
    }

    function checkkhoadangky($id_taikhoan)  {
        $dangky = DB::table('24_khoadangky')
        ->where('id_taikhoan',$id_taikhoan)
        ->first();
        if($dangky){
            $trangthaihientai = $dangky->trangthai;
            switch ($dangky->trangthai) {
                case '1':
                    $trangthaitupdate = 2;
                    break;
                case '2':
                    $trangthaitupdate = 3;
                    break;
                case '3':
                    $trangthaitupdate = 2;
                    break;
                default:
                    # code...
                    break;
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

    function trangthaixettuyen(){
        $id_taikhoan = Auth::guard('loginbygoogles')->id();
        $check = DB::table('24_danhsachxettuyentheodotxt')
        ->where('id_taikhoan',$id_taikhoan)
        ->where('iddot',1)
        ->first();
        if($check){
           return 1;
        }else{
            return 0; //Chưa nằm trong danh sách xét tuyển
        }
    }

    public function luunguyenvong(Request $request)
    {
        $id_user = $request->input('id_user');
        $data = $request->input('data');
        $id_taikhoan = Auth::guard('loginbygoogles')->id();
        if($this ->trangthaixettuyen() == 0){
            if($this->checkkhoadangky($id_taikhoan) == 1){
                return 'khoadangky';
            }else{
                $nvthanhtoan = DB::table('24_ketquathanhtoan')
                ->where('id_taikhoan',$id_taikhoan)
                ->sum('total_amount');
                // $maxnv = 3;
                // $countnv =  intval($nvthanhtoan/20000);
                // if( $countnv <= count($data) || $countnv >= $maxnv){
                    foreach ($data as $key => $value) {
                        $diem = $value[3];
                        $dem = 0;
                        if($diem < 18){
                            $dem++;
                        }
                    }
                    foreach ($data as $key => $value) {
                        if($dem == 0){
                            if($id_user == $id_taikhoan){
                                DB::beginTransaction();
                                try{
                                    foreach ($data as $key => $value) {
                                        $up = DB::table('24_nguyenvong')
                                        ->updateOrInsert(
                                            [
                                                'id_taikhoan' => $value[0],
                                                'thutu' => $value[4],
                                            ],
                                            [
                                                'id_chuyennganh' => $value[1],
                                                'tohop' => $value[2],
                                                'diemxettuyen' => $value[3],
                                                'diemtohop' => $value[5],
                                                'diemuutien' => $value[6],
                                            ]
                                        );
                                        if($up == 1){
                                            $chuyennganh = DB::table('24_chuyennganh')
                                            ->select('tenchuyennganh')
                                            ->where('id',$value[1])
                                            ->first();
                                            $user_agent = $_SERVER['HTTP_USER_AGENT'];
                                            DB::table('24_lichsu')
                                            ->insert([
                                                'id_taikhoan' => $id_taikhoan,
                                                'noidung'   => "Cập nhật ngành: ".$chuyennganh->tenchuyennganh."; NV".$value[4]."; Điểm xét tuyển: ".$value[3],
                                                'hienthi'   => 1,
                                                'id_nhansu' => 0,
                                                'thietbi'   => $user_agent,
                                                'ip'        => request()->ip()
                                            ]);
                                        }
                                    }
                                    $this->kiemtrahoso($id_taikhoan);
                                    $del = DB::table('24_nguyenvong')
                                        ->where('id_taikhoan',$id_taikhoan)
                                        ->where('thutu','>',$value[4])
                                        ->delete();
                                    if($del == 1){
                                        $chuyennganh = DB::table('24_chuyennganh')
                                        ->select('tenchuyennganh')
                                        ->where('id',$value[1])
                                        ->first();
                                        $user_agent = $_SERVER['HTTP_USER_AGENT'];
                                        DB::table('24_lichsu')
                                        ->insert([
                                            'id_taikhoan' => $id_taikhoan,
                                            'noidung'   => "Hủy lưu ngành: ".$chuyennganh->tenchuyennganh,
                                            'hienthi'   => 1,
                                            'id_nhansu' => 0,
                                            'thietbi'   => $user_agent,
                                            'ip'        => request()->ip()
                                        ]);
                                    }
                                    DB::commit();
                                    return 'UpOrIns_1';
                                }catch(Exception $e){
                                    DB::rollBack();
                                    return -100;
                                }
                            }else{
                                return 'nguongdauvao';
                            }
                        }else{
                            return -100;
                        }
                    }
                // }else{
                //     return 'capnhatitnv';
                // }
            }
        }else{
            return 'xetuyen_1';
        }

    }

    function checkthongtincanhan($id_taikhoan)
    {
        $checkthongtincanhan = DB::table('24_thongtincanhan')
        ->where('id_taikhoan',$id_taikhoan)
        ->first();
        if($checkthongtincanhan){
            return 1;
        }else{
            return 0;
        }
    }

    function checkkhuvucuutien($id_taikhoan)
    {
        $checkkhuvucuutien = DB::table('24_khuvucuutien')
        ->where('id_taikhoan',$id_taikhoan)
        ->first();
        if($checkkhuvucuutien){
            return 1;
        }else{
            return 0;
        }
    }

    function checknamtotnghiep($id_taikhoan)
    {
        $checknamtotnghiep = DB::table('24_namtotnghiep')
        ->where('id_taikhoan',$id_taikhoan)
        ->first();
        if($checknamtotnghiep){
            return 1;
        }else{
            return 0;
        }
    }

    function checkhinhanh($id_taikhoan)
    {
        $namtotnghiep = DB::table('24_namtotnghiep')
        ->where('id_taikhoan',$id_taikhoan)
        ->first();
        if($namtotnghiep){
            if($namtotnghiep->namtotnghiep < Carbon::now()->year){
                $thongtincoban = DB::table('24_image')
                ->where('id_taikhoan',$id_taikhoan)
                ->where('loaianh', 9)
                ->first();
                if($thongtincoban){
                    $checknamtotnghiep = 0;
                }else{
                    $checknamtotnghiep = "ha_namtotnghiep";
                }
            }else{
                $checknamtotnghiep = 0;
            }
        }else{
            $checknamtotnghiep = 0;
        }

        $doituonguutien1 = DB::table('24_doituonguutien')
        ->where('id_taikhoan',$id_taikhoan)
        ->get();
        if(count($doituonguutien1)){
            $doituonguutien = DB::table('24_image')
            ->where('id_taikhoan',$id_taikhoan)
            ->whereIn('loaianh', [7,8])
            ->get();
            if(count($doituonguutien) > 0){
                $checktdoituonguutien = 0;
            }else{
                $checktdoituonguutien = 'ha_doituonguutien';
            }
        }else{
            $checktdoituonguutien = 0;
        }

        $cccd = DB::table('24_image')
        ->where('id_taikhoan',$id_taikhoan)
        ->whereIn('loaianh', [2,3])
        ->get();
        if($cccd){
            if(count($cccd) == 2){
                $checkcccd = 0;
            }else{
                $checkcccd = 'ha_cccd';
            }
        }else{
            $checkcccd = 0;
        }

        $hocba = DB::table('24_image')
        ->where('id_taikhoan',$id_taikhoan)
        ->whereIn('loaianh', [4,5,6,10])
        ->get();
        if($hocba){
            if(count($hocba) == 4){
                $checkhocba = 0;
            }else{
                $checkhocba = 'ha_hocba';
            }
        }else{
            $checkhocba = 0;
        }
        $checkhinhanh = array(
            'ha_hocba' => $checkhocba,
            'ha_cccd' => $checkcccd,
            'ha_doituonguutien' => $checktdoituonguutien,
            'ha_namtotnghiep' => $checknamtotnghiep,
        );
        return $checkhinhanh;
    }

    function kiemtratinhtrangluunguyenvong($id_taikhoan)
    {
        $nguyenvong = DB::table('24_nguyenvong')
        ->where('id_taikhoan',$id_taikhoan)
        ->get();
        if(count($nguyenvong) > 0){
            return 1;
        }else{
            return 0;
        }
    }

    function kiemtrahoso($id_taikhoan){
        $thoigiancapnhat = now('Asia/Ho_Chi_Minh');
        $hoso = DB::table('24_kiemtrahoso')->where('id_taikhoan',$id_taikhoan)->first();
        $dangky = DB::table('24_khoadangky')->where('id_taikhoan',$id_taikhoan)->first();
        if($hoso){
            if($hoso ->trangthai == 0 && !$dangky ){
                $trangthai = 0;
            }
            if($hoso ->trangthai == 0 && $dangky ){
                $trangthai = 1;
            }
            if($hoso ->trangthai == 1 && !$dangky ){
                $trangthai = 2;
            }
            if($hoso ->trangthai == 1 && $dangky ){
                $trangthai = 1;
            }
            if($hoso ->trangthai == 2 && !$dangky ){
                $trangthai = 2;
            }
            if($hoso ->trangthai == 2 && $dangky ){
                $trangthai = 3;
            }
            if($hoso ->trangthai == 3 && !$dangky ){
                $trangthai = 2;
            }
            if($hoso ->trangthai == 3 && $dangky ){
                $trangthai = 3;
            }
            if($hoso ->trangthai == 4 && $dangky ){
                $trangthai = 2;
            }
            DB::table('24_kiemtrahoso')
            ->where('id_taikhoan',$id_taikhoan)
            ->update(
                [
                    'trangthai'=> $trangthai,
                    'thoigiancapnhat' => $thoigiancapnhat,
                ]
            );
        }else{
            DB::table('24_kiemtrahoso')
            ->insert(
                [
                    'id_taikhoan'=> $id_taikhoan,
                    'thoigiancapnhat' => $thoigiancapnhat,
                ]
            );
        }

                // switch (true) {
                //     case ($hoso->trangthai == 0 && !$dangky):
                //         $trangthai = 0; //Lưu nguyện vọng
                //         break;
                //     case ($hoso->trangthai == 0 && $dangky):
                //         $trangthai = 1; //Đăng ky mới
                //         break;
                //     case ($hoso->trangthai == 1 && !$dangky):
                //         $trangthai = 2; //Mở cập nhật
                //     case ($hoso->trangthai == 2 && $dangky):
                //         $trangthai = 3; //Đã đăng ký lại
                //         break;
                //     case ($hoso->trangthai == 2 && !$dangky):
                //         $trangthai = 2; //Mở cập nhật/Lưu nguyện vọng
                //         break;
                //     case ($hoso->trangthai == 3 && !$dangky):
                //         $trangthai = 2; //Mở cập nhật
                //         break;
                //     default:
                //         $trangthai = -1; //Lưu nguyện vọng
                //         break;
                // }

        // }else{
        //
        // }
    }

    public function dangky(Request $request){
        $id_user = $request->input('id_user');
        $id_taikhoan = Auth::guard('loginbygoogles')->id();
        if($id_taikhoan == $id_user){
            if($this ->trangthaixettuyen() == 0){
                $nvthanhtoan = DB::table('24_ketquathanhtoan')
                ->where('id_taikhoan',$id_taikhoan)
                ->sum('total_amount');
                $data = DB::table('24_nguyenvong')
                ->where('iddot',1)
                ->where('id_taikhoan',$id_taikhoan)
                ->get();
                // if($nvthanhtoan/20000 <= count($data)){
                    $trangthai = 0;
                    DB::beginTransaction();
                    try{
                        if($this->kiemtratinhtrangluunguyenvong($id_taikhoan) == 1 ){
                            if($this->checkthongtincanhan($id_taikhoan) == 1){
                                if($this->checkkhuvucuutien($id_taikhoan) == 1){
                                    if($this->checknamtotnghiep($id_taikhoan) == 1){
                                        $checkhinhanh = $this->checkhinhanh($id_taikhoan);
                                        if($checkhinhanh['ha_hocba'] === 'ha_hocba'){
                                            $act = 'ha_hocba';
                                        }else{
                                            if($checkhinhanh['ha_cccd'] === 'ha_cccd'){
                                                $act = "ha_cccd";
                                            }else{
                                                if($checkhinhanh['ha_doituonguutien'] === 'ha_doituonguutien'){
                                                    $act = "ha_doituonguutien";
                                                }else{
                                                    if($checkhinhanh['ha_namtotnghiep'] === 'ha_namtotnghiep'){
                                                        $act = "ha_namtotnghiep";
                                                    }else{
                                                        // $checkkhoadangky = $this->checkkhoadangky($id_taikhoan)['trangthaithientai'];
                                                        // if($checkkhoadangky == 0){
                                                            DB::beginTransaction();
                                                            try{
                                                            // $trangthai = 1;
                                                            $checkkhoadangky = $this->checkkhoadangky($id_taikhoan)['trangthaitupdate'];
                                                            DB::table('24_khoadangky')
                                                            ->updateOrInsert(
                                                                [
                                                                    'id_taikhoan' => $id_taikhoan,
                                                                ],
                                                                [
                                                                    'trangthai' =>  $checkkhoadangky,
                                                                ]
                                                            );
                                                            DB::table('24_kiemtrahoso')
                                                            ->where('id_taikhoan',$id_taikhoan)
                                                            ->update(
                                                                [
                                                                    'trangthai' => $checkkhoadangky,
                                                                    'khoa' => 0,
                                                                    'duyet' => 0,
                                                                ]
                                                            );
                                                            $nganh = DB::table('24_nguyenvong')
                                                            ->join('24_chuyennganh','24_chuyennganh.id','24_nguyenvong.id_chuyennganh')
                                                            ->select('thutu','tenchuyennganh')
                                                            ->where('id_taikhoan',$id_taikhoan)
                                                            ->get();
                                                            $thongtin = "";
                                                            foreach ($nganh as $key => $value) {
                                                                $thongtin .= 'NV'.$value->thutu.': '.$value->tenchuyennganh."; ";
                                                            }
                                                            $thongtin = rtrim($thongtin,";");
                                                            $user_agent = $_SERVER['HTTP_USER_AGENT'];
                                                            DB::table('24_lichsu')
                                                            ->insert([
                                                                'id_taikhoan' => $id_taikhoan,
                                                                'noidung'   => "Đăng ký xét tuyển: ".$thongtin,
                                                                'hienthi'   => 1,
                                                                'id_nhansu' => 0,
                                                                'thietbi'   => $user_agent,
                                                                'ip'        => request()->ip()
                                                            ]);
                                                            DB::commit();
                                                            $act = "UpOrIns_1";
                                                            $trangthai = 1;
                                                        }catch(Exception $e){
                                                            DB::rollBack();
                                                            $act = "-100";
                                                        }
                                                    // }else{
                                                    //     $act = "khoadangky";
                                                    // }
                                                    }
                                                }
                                            }
                                        }
                                    }else{
                                        $act = "namtotnghiep";
                                    }
                                }else{
                                    $act = "khuvucuutien";
                                }
                            }else{
                                $act = "thongtincanhan";
                            }
                        }else{
                            $act = "luunguyenvong";
                        }
                        DB::commit();
                    }catch(Exception $e){
                        DB::rollBack();
                        $act = -100;
                        $trangthai = '';
                    }
                // }else{
                //     $act = 'capnhatitnv';
                //     $trangthai = '';
                // }
            }else{
                $act = 'xetuyen_1';
                $trangthai = '';
            }
        }else{
            $act = -100;
            $trangthai = '';
        }
        $res = array(
            'act' =>  $act,
            'disabled' => $trangthai,
        );
        return  $res;
    }

    public function yeucaucapnhat(Request $request){
        $id_user = $request->input('id_user');
        $id_taikhoan = Auth::guard('loginbygoogles')->id();
        if($id_taikhoan == $id_user){
            if($this ->trangthaixettuyen() == 0){
                if($this->checkkhoadangky($id_taikhoan)['trangthaihientai'] != 0){
                    $checkkhoadangky =  $this->checkkhoadangky($id_taikhoan)['trangthaitupdate'];
                    DB::beginTransaction();
                    try {
                        DB::table('24_khoadangky')
                        ->updateOrInsert(
                            [
                                'id_taikhoan' => $id_taikhoan,
                            ],
                            [
                                'trangthai' =>   $checkkhoadangky,
                            ]
                        );

                        DB::table('24_kiemtrahoso')
                        ->where('id_taikhoan',$id_taikhoan)
                        ->update([
                            'trangthai' => $checkkhoadangky,
                            'khoa'=> 0,
                            'duyet'=> 0,
                        ]);
                        // $this->kiemtrahoso($id_taikhoan);
                        $user_agent = $_SERVER['HTTP_USER_AGENT'];
                        DB::table('24_lichsu')
                        ->insert([
                            'id_taikhoan' => $id_taikhoan,
                            'noidung'   => "Yêu cầu cập nhật thông tin xét tuyển",
                            'hienthi'   => 1,
                            'id_nhansu' => 0,
                            'thietbi'   => $user_agent,
                            'ip'        => request()->ip()
                        ]);
                        DB::commit();
                        $mes =  'mocapnhat';
                        $code =  0;
                    } catch (Exception $e) {
                        DB::rollBack();
                        $code =  -100;
                        $mes = "";
                    }
                }else{
                    $mes =  'dangky_chua';
                    $code =  1;
                }
            }else{
                $code = 'xetuyen_1';
                $mes = "";
            }
        }else{
            $code =  -100;
            $mes = "";
        }
        $res = array(
            'code' => $code,
            'mes' => $mes,
        );
        return $res;
    }
}
