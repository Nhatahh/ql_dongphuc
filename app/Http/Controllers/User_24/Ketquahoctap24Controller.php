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
use \App\Http\Controllers\User_24\Thongtincanhan24Controller;
use Exception;

use function PHPUnit\Framework\countOf;

class Ketquahoctap24Controller extends Controller

{
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
            if($dangky->trangthai == 1 || $dangky->trangthai == 3){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }


    public function ketquahoctap(){
        $id_taikhoan = Auth::guard('loginbygoogles')->id();
        $img_slider = DB::select("SELECT 24_image_chuan.id, 24_image_chuan.funtion_id,24_image_chuan.ghichu,24_image_chuan.loaianh,if(image.path_img is null,'/img/test.png',image.path_img) as path_img,if(image.id is null,0,image.id) as test  FROM `24_image_chuan` LEFT JOIN (SELECT * FROM 24_image WHERE id_taikhoan = ".$id_taikhoan." AND loaianh > 1) AS image ON 24_image_chuan.id = image.id_image_chuan ORDER BY thutu ASC");

        // $diem = DB::select('SELECT * FROM (SELECT * FROM l_subject WHERE l_subject.id_type_subject = 1) AS X LEFT JOIN (SELECT * FROM 24_ketquahoctap WHERE 24_ketquahoctap.id_class_result = 10 AND id_student_result = 13) AS Y ON X.id = Y.id_subject');
        $diems = DB::table('24_ketquahoctap')
        ->where('id_student_result',$id_taikhoan)
        ->get();
        $mons = DB::table('l_subject')
        ->where('hienthi',1)
        ->get();
        $groups_mons = DB::table('l_group_subject')
        // ->where('id_group',1)
        ->get();
        $groups = DB::table('l_group')
        ->where('id_method',1)
        ->get();

        $diemtohop = $this->tinhdiemtohop($groups_mons,$groups,$diems);
        if(count($diems)>0){
            foreach ($diems as $key => $diem) {
                foreach ($mons as $key => $mon) {
                    if($diem ->id_subject == $mon ->id ){
                        $dem = 0;
                        switch ($diem ->id_class_result) {
                            case '10':
                                switch ($diem ->id_semester_result) {
                                    case '1':
                                        $mon ->id_semester_result10hk1 = $diem ->id_semester_result;
                                        $mon ->id_class_result10hk1 =  $diem ->id_class_result;
                                        $mon ->mark_result10hk1 =  $diem ->mark_result;
                                        # code...

                                        break;
                                    case '2':
                                        $mon ->id_semester_result10hk2 = $diem ->id_semester_result;
                                        $mon ->id_class_result10hk2 =  $diem ->id_class_result;
                                        $mon ->mark_result10hk2 =  $diem ->mark_result;
                                        # code...

                                        break;
                                    case 'CN':
                                        $mon ->id_semester_result10cn = $diem ->id_semester_result;
                                        $mon ->id_class_result10cn =  $diem ->id_class_result;
                                        $mon ->mark_result10cn =  $diem ->mark_result;
                                        # code...

                                        break;
                                    default:
                                        # code...
                                        break;
                                }
                                break;
                            case '11':
                                switch ($diem ->id_semester_result) {
                                    case '1':
                                        $mon ->id_semester_result11hk1 = $diem ->id_semester_result;
                                        $mon ->id_class_result11hk1 =  $diem ->id_class_result;
                                        $mon ->mark_result11hk1 =  $diem ->mark_result;
                                        break;
                                    case '2':
                                        $mon ->id_semester_result11hk2 = $diem ->id_semester_result;
                                        $mon ->id_class_result11hk2 =  $diem ->id_class_result;
                                        $mon ->mark_result11hk2 =  $diem ->mark_result;
                                        break;
                                    case 'CN':
                                        $mon ->id_semester_result11cn = $diem ->id_semester_result;
                                        $mon ->id_class_result11cn =  $diem ->id_class_result;
                                        $mon ->mark_result11cn =  $diem ->mark_result;
                                        break;
                                    default:
                                        # code...
                                        break;
                                }
                                break;
                            case '12':
                                switch ($diem ->id_semester_result) {
                                    case '1':
                                        $mon ->id_semester_result12hk1 = $diem ->id_semester_result;
                                        $mon ->id_class_result12hk1 =  $diem ->id_class_result;
                                        $mon ->mark_result12hk1 =  $diem ->mark_result;
                                        # code...

                                        break;
                                    case '2':
                                        $mon ->id_semester_result12hk2 = $diem ->id_semester_result;
                                        $mon ->id_class_result12hk2 =  $diem ->id_class_result;
                                        $mon ->mark_result12hk2 =  $diem ->mark_result;
                                        # code...

                                        break;
                                    case 'CN':
                                        $mon ->id_semester_result12cn = $diem ->id_semester_result;
                                        $mon ->id_class_result12cn =  $diem ->id_class_result;
                                        $mon ->mark_result12cn =  $diem ->mark_result;
                                        # code...

                                        break;
                                    default:
                                        # code...
                                        break;
                                }
                                break;
                            case 'TN':
                                switch ($diem ->id_semester_result) {
                                    case 'PT':
                                        $mon ->id_semester_resultTN = $diem ->id_semester_result;
                                        $mon ->id_class_resulTN =  $diem ->id_class_result;
                                        $mon ->mark_resultTN =  $diem ->mark_result;
                                        # code...

                                        break;
                                    default:
                                        # code...
                                        break;
                                }
                                break;
                            default:
                                # code...
                                break;
                        }
                    }
                    // break;
                }
            }
        }else{
            foreach ($mons as $key => $mon) {
                $mon ->id_semester_result10hk1 = 1;
                $mon ->id_class_result10hk1 =  10;
                $mon ->mark_result10hk1 =  0;
                $mon ->id_semester_result10hk2 = 2;
                $mon ->id_class_result10hk2 =  10;
                $mon ->mark_result10hk2 = 0;
                $mon ->id_semester_result10cn = "CN";
                $mon ->id_class_result10cn =  10;
                $mon ->mark_result10cn = 0;

                $mon ->id_semester_result11hk1 = 1;
                $mon ->id_class_result11hk1 =  11;
                $mon ->mark_result11hk1 =  0;
                $mon ->id_semester_result11hk2 = 2;
                $mon ->id_class_result11hk2 =  11;
                $mon ->mark_result11hk2 = 0;
                $mon ->id_semester_result11cn = "CN";
                $mon ->id_class_result11cn =  11;
                $mon ->mark_result11cn = 0;

                $mon ->id_semester_result12hk1 = 1;
                $mon ->id_class_result12hk1 =  12;
                $mon ->mark_result12hk1 =  0;
                $mon ->id_semester_result12hk2 = 2;
                $mon ->id_class_result12hk2 =  12;
                $mon ->mark_result12hk2 = 0;
                $mon ->id_semester_result12cn= "CN";
                $mon ->id_class_result12cn =  12;
                $mon ->mark_result12cn = 0;



                $mon ->id_semester_resultTN = "PT";
                $mon ->id_class_resulTN =  "TN";
                $mon ->mark_resultTN =  0;
            }
        }
        if( $img_slider ){
            return view('user_24.ketquahoctap',
            [
                'mons' => $mons,
                'tophop' =>$diemtohop,
                'img_slider_right' =>  $img_slider,
                'checkkhoadangky' => $this->checkkhoadangky($id_taikhoan),
                'img_slider' =>  $img_slider,
            ]);
        }else{
            return view('user_24.ketquahoctap',
            [
                'mons' => $mons,
                'tophop' =>$diemtohop,
                'img_slider_right' =>  $img_slider,
                'img_slider' =>  $img_slider,
                'checkkhoadangky' => $this->checkkhoadangky($id_taikhoan)

            ]);
        }





    }


    public function luudiemhoctap(Request $request){
        $id_taikhoan = $request->input('id_user');
        $lop = $request->input('lop');
        $hocki = $request->input('hocki');
        $mon = $request->input('mon');
        $diem = $request->input('diem');

        $validator = Validator::make($request->all(),
            [
                'diem'                   =>'numeric|min:0|max:10',
            ],
            [
                'diem.min'               =>'Điểm học tập lớn hơn bằng 0',
                'diem.max'               =>'Điểm học tập bé hơn bằng 10',

            ]
        );
        if ($validator->fails()) {
            $validate = array(
                'data' => response()->json($validator->errors()),
                'maloi' => "vali_1",
            );
            return $validate;
        }else{
            if($id_taikhoan == Auth::guard('loginbygoogles')->id()){
                DB::beginTransaction();
                try{
                    DB::table('24_ketquahoctap')
                    ->updateOrInsert(
                        [
                            'id_student_result' => $id_taikhoan,
                            'id_class_result' => $lop,
                            'id_semester_result' => $hocki,
                            'id_subject' => $mon,
                        ],
                        [
                            'mark_result' => $diem,
                        ]
                    );

                    $mon = DB::table('l_subject')
                    ->select('name_subject')
                    ->where('id',$mon)
                    ->first();

                    $user_agent = $_SERVER['HTTP_USER_AGENT'];
                    DB::table('24_lichsu')
                    ->insert([
                        'id_taikhoan' => $id_taikhoan,
                        'noidung'   => "Cập nhật điểm học tập: ".$diem."; Lớp: ".$lop."; Học kì: ".$hocki,
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
                return -100;
            }
        }
    }


}
