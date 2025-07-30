<?php

namespace App\Http\Controllers\User\Main;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use PhpOption\Option;
use PhpParser\Node\Expr\FuncCall;
use \App\Http\Controllers\User\Main\RegisterWishController;
use Exception;

use function PHPUnit\Framework\countOf;

class InfoUserController extends Controller

{
    public function index(){
        return view('user.main.info',
        [
            'title' => "CTUT|Hệ thống đăng ký xét tuyển",
        ]);
    }

    //Check Đăng ký
    public function check_reg(){
        $chec_reg =  DB::table('l_block_wish')
        ->where('id_user',Auth::guard('user')->user()->id)
        ->get();
        if(count($chec_reg) == 1){
            if($chec_reg[0] ->id_block == 1 ){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }


    public function province(){
        $doituong = new Collection(
            [
                'id' => 0,
                'text' => 'Chọn Tỉnh/Thành phố',
                'selected' => true
            ]
        );
        $province_user = DB::table('l_info_users')
        ->where('id_user',Auth::guard('user')->user()->id)
        ->get();
        $provinces = DB::table('l_province')
        ->select('id','name_province as text')
        ->orderBy('id', 'asc')
        ->get();
        if(count($province_user) == 1){
            foreach ($provinces as $province ){
                if( $province ->id ==  $province_user[0]->id_khttprovince_user){
                    $province ->selected = true;
                }else{
                    $province ->selected = false;
                }
            }
        }else{
            foreach ($provinces as $province ){
                $province ->selected = false;
            }
            $provinces[] = $doituong;
        }
        echo  $provinces;
    }

    public function province2(){
        $province_user = DB::table('l_info_users')
        ->where('id_user',Auth::guard('user')->user()->id)
        ->get();

        $provinces = DB::table('l_province2')
        ->select('id','name_province2 as text')
        ->where('id_province',$province_user[0]->id_khttprovince_user)
        ->orderBy('id', 'asc')
        ->get();

        foreach ($provinces as $province ){
            if( $province ->id ==  $province_user[0]->id_khttprovince2_user){
                $province ->selected = true;
            }else{
                $province ->selected = false;
            }
        }
        echo  $provinces;
    }

    public function province3(){
        $province_user = DB::table('l_info_users')
        ->where('id_user',Auth::guard('user')->user()->id)
        ->get();

        $provinces = DB::table('l_province3')
        ->select('id','name_province3 as text')
        ->where('id_province2',$province_user[0]->id_khttprovince2_user)
        ->orderBy('id', 'asc')
        ->get();

        foreach ($provinces as $province ){
            if( $province ->id ==  $province_user[0]->id_khttprovince3_user){
                $province ->selected = true;
            }else{
                $province ->selected = false;
            }
        }
        echo  $provinces;
    }

    public function change_province(Request $request){
        $doituong = new Collection(
            [
                'id' => 0,
                'text' => 'Chọn Quận/Huyện',
                'selected' => true
            ]
        );
        $provinces = DB::table('l_province2')
        ->select('id','name_province2 as text')
        ->where('id_province',$request->input('id'))
        ->orderBy('id', 'asc')
        ->get();
        $provinces[] = $doituong;
        return  $provinces;
    }

    public function change_province2(Request $request){
        $doituong = new Collection(
            [
                'id' => 0,
                'text' => 'Chọn Phường/Xã',
                'selected' => true
            ]
        );
        $provinces = DB::table('l_province3')
        ->select('id','name_province3 as text')
        ->where('id_province2',$request->input('id'))
        ->orderBy('id', 'asc')
        ->get();
        $provinces[] = $doituong;
        return  $provinces;
    }

    public function province_shool_10(){
        $areas = DB::table('l_area')
        ->where('id_user_area',Auth::guard('user')->user()->id)
        ->where('id_class_area',10)
        ->get();
        $i=1;
        $html ='';
        foreach ($areas as $area) {
            $schools = DB::table('l_school')
            ->select('id','name_school as text')
            ->where('id_province',$area->id_province_area)
            ->orderBy('id', 'asc')
            ->get();

            foreach ($schools as $school){
                if( $school->id == $area->id_school_area){
                    $school->selected = true;
                }else{
                    $school->selected = false;
                }
            }

            $provinces = DB::table('l_province')
            ->select('id','name_province as text')
            ->orderBy('id', 'asc')
            ->get();

            foreach ($provinces as $province){
                if( $province->id == $area->id_province_area){
                    $province->selected = true;
                }else{
                    $province->selected = false;
                }
            }

            $area1 = DB::table('l_school')
            ->select('id_priority_area')
            ->join('l_priority_area','l_school.priority_area_school','l_priority_area.id')
            ->where('l_school.id',$area->id_school_area)
            ->get();
            $html .= '<div class="card-body" style="padding-top: 0px;padding-bottom: 0px">
            <div class="row">
                <div class="col-md-3 col-12">
                    <div class="form-group row" style="margin-bottom: 3px">
                        <label for="inputEmail3" class="col-sm-4 col-form-label" style="padding-bottom: 0px "><i class="fa fa-trash delArea" onclick = "del_area_2('.$area->id.',0)"  style="color: red" id_area = '.$area->id.'></i>&nbsp;&nbsp;Tỉnh/TP:</label>
                        <div class="col-sm-8" >
                            <select  class="province_school_10_'.$i.' province_school province_school10" id = "province_school_10_'.$i.'" style="width: 100%;">

                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-group row" style="margin-bottom: 3px">
                        <label for="inputEmail3" class="col-sm-3 col-form-label" style="padding-bottom: 0px ">Trường THPT:<sup id = "v_province_school_10_'.$i.'s" style="padding: 0;color:#17a2b8">'.$area1[0]->id_priority_area.'</sup></label>
                        <div class="col-sm-9">
                            <select class="school province_school_10_'.$i.'s" id_area = '.$area->id.' id-data = "'.$area->id_class_area.'" id = "province_school_10_'.$i.'s"  style="width: 100%;">

                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group row" style="margin-bottom: 3px">
                        <label for="inputEmail3" class="col-sm-7 col-form-label" style="padding-bottom: 0px">Thời gian học (tháng):</label>
                        <div class="col-sm-5">
                            <input type="text" class="time form-control time_10" id = "province_school_10_'.$i.'stime" style="height:30px;" value = "">
                        </div>
                    </div>
                </div>
            </div>

        </div>';
                $data = array(
                    'data_school' => $schools,
                    'data_province' => $provinces,
                    'id_dom_school' => 'province_school_10_'.$i.'s',
                    'id_dom_province' => 'province_school_10_'.$i,
                    'id_time' => 'province_school_10_'.$i.'stime',
                    'time' => $area ->time_area,
                );
                $datas[] = $data;
                unset($data);
                $i++;
            };

            $total = array(
                'datas' => $datas,
                'html'  => $html,
            );
           return $total;
    }

    public function province_shool_11(){
        $areas = DB::table('l_area')
        ->where('id_user_area',Auth::guard('user')->user()->id)
        ->where('id_class_area',11)
        ->get();
        $i=1;
        $html ='';
        foreach ($areas as $area) {
            $schools = DB::table('l_school')
            ->select('id','name_school as text')
            ->where('id_province',$area->id_province_area)
            ->orderBy('id', 'asc')
            ->get();

            foreach ($schools as $school){
                if( $school->id == $area->id_school_area){
                    $school->selected = true;
                }else{
                    $school->selected = false;
                }
            }

            $provinces = DB::table('l_province')
            ->select('id','name_province as text')
            ->orderBy('id', 'asc')
            ->get();

            foreach ($provinces as $province){
                if( $province->id == $area->id_province_area){
                    $province->selected = true;
                }else{
                    $province->selected = false;
                }
            }

            $area1 = DB::table('l_school')
            ->select('id_priority_area')
            ->join('l_priority_area','l_school.priority_area_school','l_priority_area.id')
            ->where('l_school.id',$area->id_school_area)
            ->get();
            $html .= '<div class="card-body" style="padding-top: 0px;padding-bottom: 0px">
            <div class="row">
                <div class="col-md-3 col-12">
                    <div class="form-group row" style="margin-bottom: 3px">
                        <label for="inputEmail3" class="col-sm-4 col-form-label" style="padding-bottom: 0px "><i class="fa fa-trash delArea" onclick = "del_area_2('.$area->id.',0)" style="color: red" id_area = '.$area->id.'></i>&nbsp;&nbsp;Tỉnh/TP:</label>
                        <div class="col-sm-8" >
                            <select  class="province_school_11_'.$i.' province_school province_school11 " id = "province_school_11_'.$i.'" style="width: 100%;">

                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-group row" style="margin-bottom: 3px">
                        <label for="inputEmail3" class="col-sm-3 col-form-label" style="padding-bottom: 0px ">Trường THPT:<sup id = "v_province_school_11_'.$i.'s" style="padding: 0;color:#17a2b8">'.$area1[0]->id_priority_area.'</sup></label>
                        <div class="col-sm-9">
                            <select class="school province_school_11_'.$i.'s" id_area = '.$area->id.' id-data = "'.$area->id_class_area.'" id = "province_school_11_'.$i.'s"  style="width: 100%;">

                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group row" style="margin-bottom: 3px">
                        <label for="inputEmail3" class="col-sm-7 col-form-label" style="padding-bottom: 0px">Thời gian học (tháng):</label>
                        <div class="col-sm-5">
                            <input type="text" class="time form-control time_11" id = "province_school_11_'.$i.'stime" style="height:30px;" value = "">
                        </div>
                    </div>
                </div>
            </div>

        </div>';
                $data = array(
                    'data_school' => $schools,
                    'data_province' => $provinces,
                    'id_dom_school' => 'province_school_11_'.$i.'s',
                    'id_dom_province' => 'province_school_11_'.$i,
                    'id_time' => 'province_school_11_'.$i.'stime',
                    'time' => $area ->time_area,
                );
                $datas[] = $data;
                unset($data);
                $i++;
            };

            $total = array(
                'datas' => $datas,
                'html'  => $html,
            );
           return $total;
    }

    public function province_shool_12(){
        $areas = DB::table('l_area')
        ->where('id_user_area',Auth::guard('user')->user()->id)
        ->where('id_class_area',12)
        ->get();
        $i=1;
        $html ='';
        foreach ($areas as $area) {
            $schools = DB::table('l_school')
            ->select('id','name_school as text')
            ->where('id_province',$area->id_province_area)
            ->orderBy('id', 'asc')
            ->get();

            foreach ($schools as $school){
                if( $school->id == $area->id_school_area){
                    $school->selected = true;
                }else{
                    $school->selected = false;
                }
            }

            $provinces = DB::table('l_province')
            ->select('id','name_province as text')
            ->orderBy('id', 'asc')
            ->get();

            foreach ($provinces as $province){
                if( $province->id == $area->id_province_area){
                    $province->selected = true;
                }else{
                    $province->selected = false;
                }
            }

            $area1 = DB::table('l_school')
            ->select('id_priority_area')
            ->join('l_priority_area','l_school.priority_area_school','l_priority_area.id')
            ->where('l_school.id',$area->id_school_area)
            ->get();

            $html .= '<div class="card-body" style="padding-top: 0px;padding-bottom: 0px">
            <div class="row">
                <div class="col-md-3 col-12">
                    <div class="form-group row" style="margin-bottom: 3px">
                        <label for="inputEmail3" class="col-sm-4 col-form-label" style="padding-bottom: 0px "><i class="fa fa-trash delArea" onclick = "del_area_2('.$area->id.',0)" style="color: red" id_area = '.$area->id.'></i>&nbsp;&nbsp;Tỉnh/TP:</label>
                        <div class="col-sm-8" >
                            <select  class="province_school_12_'.$i.' province_school province_school12 " id = "province_school_12_'.$i.'" style="width: 100%;">

                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-group row" style="margin-bottom: 3px">
                        <label for="inputEmail3" class="col-sm-3 col-form-label" style="padding-bottom: 0px ">Trường THPT:<sup id = "v_province_school_12_'.$i.'s" style="padding: 0;color:#17a2b8">'.$area1[0]->id_priority_area.'</sup></label>
                        <div class="col-sm-9">
                            <select class="school province_school_12_'.$i.'s" id_area = '.$area->id.' id-data = "'.$area->id_class_area.'" id = "province_school_12_'.$i.'s"  style="width: 100%;">

                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group row" style="margin-bottom: 3px">
                        <label for="inputEmail3" class="col-sm-7 col-form-label" style="padding-bottom: 0px">Thời gian học (tháng):</label>
                        <div class="col-sm-5">
                            <input type="text" class="time form-control time_12" id = "province_school_12_'.$i.'stime" style="height:30px;" value = "">
                        </div>
                    </div>
                </div>
            </div>
        </div>';
                $data = array(
                    'data_school' => $schools,
                    'data_province' => $provinces,
                    'id_dom_school' => 'province_school_12_'.$i.'s',
                    'id_dom_province' => 'province_school_12_'.$i,
                    'id_time' => 'province_school_12_'.$i.'stime',
                    'time' => $area ->time_area,
                );
                $datas[] = $data;
                unset($data);
                $i++;
            };

            $total = array(
                'datas' => $datas,
                'html'  => $html,
            );
           return $total;
    }


    public function province_shools($id){
        $doituong = new Collection(
            [
                'id' => 0,
                'text' => 'Chọn Trường THPT',
                'selected' => true
            ]
        );
        $provinces = DB::table('l_school')
        ->select('id','name_school as text')
        ->where('id_province',$id)
        ->orderBy('id_school', 'asc')->get();
        $provinces[] = $doituong;
        echo  $provinces;
        }




    public function province_shool(){
        $doituong = new Collection(
            [
                'id' => 0,
                'text' => 'Chọn Tỉnh/Thành phố',
                'selected' => true
            ]
        );
        $provinces = DB::table('l_province')
        ->select('id','name_province as text')
        ->orderBy('id_province', 'asc')->get();
        $provinces[] = $doituong;
        echo  $provinces;
    }

    public function province_shools_11($id){
        $doituong = new Collection(
            [
                'id' => 0,
                'text' => 'Chọn Trường THPT',
                'selected' => true
            ]
        );
        $provinces = DB::table('l_school')
        ->select('id','name_school as text')
        ->where('id_province',$id)
        ->orderBy('id_school', 'asc')->get();
        $provinces[] = $doituong;
        echo  $provinces;
    }

    public function province_shools_12($id){
        $doituong = new Collection(
            [
                'id' => 0,
                'text' => 'Chọn Trường THPT',
                'selected' => true
            ]
        );
        $provinces = DB::table('l_school')
        ->select('id','name_school as text')
        ->where('id_province',$id)
        ->orderBy('id_school', 'asc')->get();
        $provinces[] = $doituong;
        echo  $provinces;
    }

    public function area($id){
        $area = DB::table('l_school')
        ->select('id_priority_area')
        ->join('l_priority_area','l_school.priority_area_school','l_priority_area.id')
        ->where('l_school.id',$id)
        ->get();
        return $area;
    }

    public function addArea(Request $request){
        $check_info = DB::table('l_info_users')
        ->where('id_user',Auth::guard('user')->user()->id)
        ->get();
        if(count($check_info) == 1){
            $data = $request->input('data');
            $check_class10 = 0;
            $check_class11 = 0;
            $check_class12 = 0;
            for ($i = 0; $i < count($data); $i++){
                if($data[$i][3] == 10){
                    $check_class10++;
                }
                if($data[$i][3] == 11){
                    $check_class11++;
                }
                if($data[$i][3] == 12){
                    $check_class12++;
                }
            }
            if($check_class10 > 0 && $check_class11 >0 && $check_class12 >0){
                $dem =0;
                for ($i = 0; $i < count($data); $i++){
                    $find = DB::table('l_area')->where('id',$data[$i][4])->get();
                    if(count($find) == 1){
                        $up = DB::table('l_area')
                        ->where('id',$data[$i][4])
                        ->update([
                        'id_school_area' => $data[$i][1],
                        'id_province_area' => $data[$i][0],
                        'id_class_area'  => $data[$i][3],
                        'time_area'  => $data[$i][2],
                            ]);
                        $dem = $dem + $up;
                    }else{
                        $ins = DB::table('l_area')
                        ->insert([
                        'id_school_area' => $data[$i][1],
                        'id_province_area' => $data[$i][0],
                        'id_user_area'  => Auth::guard('user')->user()->id,
                        'id_class_area'  => $data[$i][3],
                        'time_area'  => $data[$i][2],
                            ]);
                        $dem = $dem + $ins;
                    }
                }
                if($dem > 0){
                    $priority = DB::select('SELECT sum(l_area.time_area), l_priority_area.id FROM `l_area` JOIN l_school ON l_school.id = l_area.id_school_area JOIN l_priority_area ON l_priority_area.id = l_school.priority_area_school WHERE l_area.id_user_area = '.Auth::guard('user')->user()->id.' GROUP BY l_priority_area.id ORDER BY l_priority_area.num_priority_area');
                    DB::table('l_info_users')
                    ->where('id_user',Auth::guard('user')->user()->id)
                    ->update([
                        'id_priority_area_user' => $priority[0]->id,
                    ]);
                }
                return $dem;
            }else{
                return 1000;
            }
        }else{
            return 'check_info_false';
        }
    }

    public function delArea($id){
        $del = DB::table('l_area')->where('id',$id)->delete();
        return $del;
    }


    public function Priority_area(){
        // $checkyear = DB::table('l_infoUser')
        $sumtime_area = DB::table('l_area')
        ->select(DB::raw('sum(time_area) as time_area'),'l_priority_area.id_priority_area as priority_area_school')
        ->join('l_school','l_area.id_school_area','=','l_school.id')
        ->join('l_priority_area','l_priority_area.id','l_school.priority_area_school')

        ->where('l_area.id_user_area',Auth::guard('user')->user()->id)
        ->groupBy('l_priority_area.id')
        ->orderBy('l_priority_area.num_priority_area','asc')
        ->get();

        // SELECT sum(l_area.time_area), l_priority_area.id_priority_area FROM `l_area` JOIN l_school ON l_school.id = l_area.id_school_area
        // JOIN l_priority_area ON l_priority_area.id = l_school.priority_area_school  GROUP BY l_priority_area.id ORDER BY l_priority_area.num_priority_area asc

        $priority_area = "";
        $max = 0;
        foreach ($sumtime_area as $value) {
            if($value->time_area > $max){
                $max =  $value->time_area;
                $priority_area = $value->priority_area_school;
            }
        }
        return $priority_area;

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

    function check_id_card($year){
        $date = getdate();
        if($year < $date['year']){
            $check = DB::table('l_image_hocba')
            ->where([
                ['type_img',0],
                ['id_user',Auth::guard('user')->user()->id]
            ])
            ->orWhere([
                ['type_img',4],
                ['id_user',Auth::guard('user')->user()->id]
            ])
            ->get();
            if(count($check) == 2){
                $res  = 1;
            }else{
                $res  =0;
            }
        }

        if($year == $date['year']){
            $find = DB::table('l_image_hocba')
            ->where([
                ['type_img',4],
                ['id_user',Auth::guard('user')->user()->id]
            ])->get();
            if(count($find)>0){
                DB::table('l_image_hocba')
                ->where([
                    ['type_img',4],
                    ['id_user',Auth::guard('user')->user()->id]
                ])
                ->delete();
            }
            $check = DB::table('l_image_hocba')
            ->where([
                ['type_img',0],
                ['id_user',Auth::guard('user')->user()->id]
            ])
            ->get();
            if(count($check) == 1){
                $res  = 1;
            }else{
                $res  = 0;
            }
        }
        return $res;


    }


    public function add_infoUser(Request $request){
         $validator = Validator::make($request->all(),
            [
                'name_user'                     =>'required',
                'birth_user'                    =>'required',
                'id_place_user'                 =>'integer|min:1',
                'phonesc_user'                  =>'regex:/(0)[0-9]/|not_regex:/[a-z]/|min:10|max:10',
                'id_nation_user'                =>'integer|min:1',
                'id_khttprovince_user'          =>'integer|min:1',
                'id_khttprovince2_user'         =>'integer|min:1',
                'id_khttprovince3_user'         =>'integer|min:1',
                'address_user'                  =>'required',

                'graduation_year_user'          =>'integer|min:1990',
            ],
            [
                'name_user.required'            =>'Tên không đươc trống! ',
                'name_user.alpha_dash'          =>'Tên không gồm ký tự đặc biệt! ',
                'birth_user.required'           =>'Ngày sinh không trống! ',
                'id_place_user.required'        =>'Chọn nơi sinh! ',
                'id_nation_user.min'            =>'Chọn nơi sinh! ',
                'id_khttprovince_user.min'      =>'Chọn HKTT Tỉnh/Thành phố! ',
                'id_khttprovince2_user.min'     =>'Chọn HKTT Quận/Huyện! ',
                'id_khttprovince3_user.min'     =>'Chọn HKTT Xã/Phường! ',
                'address_user.required'         =>'Điền địa chỉ thường trú! ',
                'address_user.alpha_dash'       =>'Đại chỉ không gồm ký tự đặc biệt! ',

                'phonesc_user.regex'            =>'Điện thoại chỉ gồm chữ số! ',
                'phonesc_user.not_regex'        =>'Điện thoại chỉ gồm chữ số! ',
                'phonesc_user.min'              =>'Điện thoại gồm 10 chữ số! ',
                'phonesc_user.max'              =>'Điện thoại gồm 10 chữ số! ',

                'graduation_year_user.integer'  =>'Năm tốt nghiệp là số! ',
                'graduation_year_user.min'      =>'Năm tốt nghiệp phải từ 1990 trở lên! ',
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }else{
            DB::beginTransaction();
            try{
                $prefixfileName = Auth::guard('user')->user()->id.'.png';
                if (strlen($request->input('userImg')) < 200){
                    $ins = DB::table('l_info_users')
                    ->updateOrInsert(
                        ['id_user' => Auth::guard('user')->user()->id],
                        [
                        'name_user'                 =>  $request->input('name_user'),
                        'birth_user'                =>  $request->input('birth_user'),
                        'id_place_user'             =>  $request->input('id_place_user'),
                        'emailsc_user'              =>  $request->input('emailsc_user'),
                        'phonesc_user'              =>  $request->input('phonesc_user'),
                        'id_nation_user'            =>  $request->input('nation_user'),
                        'id_khttprovince_user'      =>  $request->input('id_khttprovince_user'),
                        'id_khttprovince2_user'     =>  $request->input('id_khttprovince2_user'),
                        'id_khttprovince3_user'     =>  $request->input('id_khttprovince3_user'),
                        'sex_user'                  =>  $request->input('sex_user'),
                        'address_user'              =>  $request->input('address_user'),
                        'graduation_year_user'      =>  $request->input('graduation_year_user'),
                    ]
                    );
                }else{
                    $fileName =$this->rand_string(20)."_".$prefixfileName;
                    $path = '/images/profile/'. $fileName;
                    $data =  $request->input('userImg');
                    list($type, $data) = explode(';', $data);
                    list(, $data)      = explode(',', $data);
                    $data = base64_decode($data);
                    $storage = Storage::disk('local');
                    $storage->put('/profile'.'/'. $fileName, $data, 'public');
                    $ins = DB::table('l_info_users')
                    ->updateOrInsert(
                        ['id_user' => Auth::guard('user')->user()->id],
                        [
                        'link_img_user'             => $path,
                        'name_user'                 =>  $request->input('name_user'),
                        'birth_user'                =>  $request->input('birth_user'),
                        'id_place_user'             =>  $request->input('id_place_user'),
                        'emailsc_user'              =>  $request->input('emailsc_user'),
                        'phonesc_user'              =>  $request->input('phonesc_user'),
                        'id_nation_user'            =>  $request->input('nation_user'),
                        'id_khttprovince_user'      =>  $request->input('id_khttprovince_user'),
                        'id_khttprovince2_user'     =>  $request->input('id_khttprovince2_user'),
                        'id_khttprovince3_user'     =>  $request->input('id_khttprovince3_user'),
                        'sex_user'                  =>  $request->input('sex_user'),
                        'address_user'              =>  $request->input('address_user'),
                        'graduation_year_user'      =>  $request->input('graduation_year_user'),
                        // 'id_batch'                  =>  3,
                    ]
                    );

                    // $datas = $request->input('data');

                }
                return 1;
                DB::commit();
                return 1;
            }catch(Exception $e){
                DB::rollBack();
                return 0;
            }
        }
    }

    public function loadRegister(){
        $infoRegister = DB::table('l_users')
        ->where('id',Auth::guard('user')->user()->id)
        ->get();
        echo $infoRegister;
    }

    public function loadInfoUser(){
        $infoUser = DB::table('l_info_users')
        ->where('id_user',Auth::guard('user')->user()->id)
        ->get();

        $id_card = DB::table('l_image_hocba')
        ->where('id_user',Auth::guard('user')->user()->id)
        ->where('type_img',0)
        ->get();

        if(count($id_card) >0){
            $data_old = $id_card[0]->id_check;
        }else{
            $data_old = 0;
        }

        $year = DB::table('l_image_hocba')
        ->where('id_user',Auth::guard('user')->user()->id)
        ->where('type_img',4)
        ->get();

        if(count($year) >0){
            $data_old_year = $year[0]->id_check;
        }else{
            $data_old_year = 0;
        }

        $result = array(
            'info' => $infoUser,
            'data_old' => $data_old,
            'data_old_year' => $data_old_year,

        );

        return $result;
    }

    public function placeUser(){
        $doituong = new Collection(
            [
                'id' => 0,
                'text' => 'Chọn Nơi sinh',
                'selected' => true
            ]
        );
        $provinces = DB::table('l_province')
        ->select('id','name_province as text')
        ->orderBy('id', 'asc')
        ->get();

        $infoUser = DB::table('l_info_users')
        ->where('id_user',Auth::guard('user')->user()->id)
        ->get();
        if(count($infoUser)==1){
            foreach ($provinces as $province ){
                if( $province ->id == $infoUser[0]->id_place_user){
                    $province ->selected = true;
                }else{
                    $province ->selected = false;
                }
            }
        }else{
            $provinces[] = $doituong;
        }
        echo  $provinces;
    }

    public function nationUser(){
        $doituong = new Collection(
            [
                'id' => 0,
                'text' => 'Chọn Dân tộc',
                'selected' => true
            ]
        );

        $provinces = DB::table('l_nation')
        ->select('id','name_nation as text')
        ->orderBy('id', 'asc')
        ->get();

        $infoUser = DB::table('l_info_users')
        ->where('id_user',Auth::guard('user')->user()->id)
        ->get();
        if(count($infoUser) == 1){
            foreach ($provinces as $province ){
                if( $province ->id == $infoUser[0]->id_nation_user){
                    $province ->selected = true;
                }else{
                    $province ->selected = false;
                }
            }
        }else{
            foreach ($provinces as $province ){
                $province ->selected = false;
            }
            $provinces[] = $doituong;
        }

        echo  $provinces;
    }

    public function Priority_Policy(){
        $doituong = new Collection(
            [
                'id' => 0,
                'text' => 'Chọn Đối tượng chính sách',
                'selected' => true
            ]
        );

        $policys = DB::table('l_policy_users')
        ->select('id','name_policy_user as text','note_policy_user')
        ->orderBy('id', 'asc')
        ->get();

        $infoPolicy = DB::table('l_policy_users_reg')
        ->where('id_user',Auth::guard('user')->user()->id)
        ->get();
        if(count($infoPolicy) >0 ){
            foreach ($policys as  $policy ){

                if( $policy  ->id == $infoPolicy[0]->id_policy_users){
                    $policy ->selected = true;
                }else{
                    $policy ->selected = false;
                }
            }
            $doituong1 = new Collection(
                [
                    'id' => 0,
                    'text' => 'Chọn Đối tượng chính sách',
                    'selected' => false
                ]
            );
            $policys[]  = $doituong1;
        }else{
            foreach ($policys as $value){
                $value ->selected = false;
            }
            $policys[]  = $doituong;
        }


        $list = DB::table('l_policy_users_list')
        ->select('*','l_policy_users_list.id as id')
        ->join('l_policy_users_reg','l_policy_users_reg.id_policy_users','l_policy_users_list.id_policy_users')
        ->where('id_user',Auth::guard('user')->user()->id)
        ->get();

        if(count($list) >0){
            $html = "Tải minh chứng:&nbsp;&nbsp;&nbsp";
        foreach ($list as $key => $value) {
            $check = DB::table('l_image_hocba')
            ->where('id_user', Auth::guard('user')->user()->id)
            ->where('type_img', 1)
            ->where('id_img', $value->id)
            ->get();
            if(count($check) == 1){
                $color = '#007bff';
                $id_check = $check[0]->id_check;
            }else{
                $color = 'red';
                $id_check = 0;
            }
            $html .= '<i   class="fa fa-paperclip policy_attr attr" data-old = "'.$id_check.'" data = "'.$id_check.'" onclick = "policy('.$value->id.',1)" id-data = '.$value->id.' type_img = "1" style="color: '.$color.'" aria-hidden="true"></i>'.$value->name_list.";&nbsp;&nbsp;&nbsp";
            $html = rtrim($html, ";   ");
        }
        }else{
            $html = "";
        }
        $result = array(
            'policys' =>$policys,
            'html' => $html,
            'list' => $list

        );
        return $result;
    }

    public function changePriority_Policy($id){

        $policys = DB::table('l_policy_users')
        ->where('id',$id)
        ->get();

        if(count($policys) > 0){
            $policy = $policys[0]->note_policy_user;
        }else{
            $policy = "";
        }

        $list = DB::table('l_policy_users_list')
        ->where('id_policy_users',$id)
        ->get();

        if(count($list) >0){
            $html = "Tải minh chứng:&nbsp;&nbsp;&nbsp";
            foreach ($list as $key => $value) {
                $check = DB::table('l_image_hocba')
                ->where('id_user', Auth::guard('user')->user()->id)
                ->where('type_img', 1)
                ->where('id_img', $value->id)
                ->get();
                if(count($check) == 1){
                    $color = '#007bff';
                    $id_check = $check[0]->id_check;
                }else{
                    $color = 'red';
                    $id_check = 0;
                }
                $html .= '<i class="fa fa-paperclip policy_attr attr" id = "policy_attr" data-old = "'.$id_check.'" data = "'.$id_check.'" onclick = "policy('.$value->id.',1)" id-data = '.$value->id.' type_img = "1" style="color: '.$color.'" aria-hidden="true"></i>'.$value->name_list.";&nbsp;&nbsp;&nbsp";
                // $html .= '<i class="fa fa-paperclip" id = "policy_attr" onclick = "policy()" style="color: #007bff" aria-hidden="true"></i>'.$value->name_list.";&nbsp;&nbsp;&nbsp";

                $html = rtrim($html, ";");
            }
        }else{
            $html = "";
        }

        $result = array(
            'html' => $html,
            'policys' =>$policy,

        );
        return $result;
    }

    public function addPriority_policy(Request $request){
        if($this ->check_reg() == 1){
            return 2;
        }else{

            DB::beginTransaction();
            try{
                DB::table('l_policy_users_reg')
                ->where('id_user',Auth::guard('user')->user()->id)
                ->delete();

                if($request->input('id') > 0){
                    DB::table('l_policy_users_reg')
                    ->insert([
                        'id_user' => Auth::guard('user')->user()->id,
                        'id_policy_users' => $request->input('id')
                    ]);
                }
                DB::commit();
                echo 1;
            }catch(Exception $e){
                DB::rollBack();
                echo 0;
            }
        }

    }


    public function loadnote_Priority_Policy(){
        $policy = DB::table('l_policy_users_reg')
        ->join('l_policy_users','id_policy_users','l_policy_users.id')
        ->where('id_user',Auth::guard('user')->user()->id)
        ->get();
        echo  $policy;
    }

    public function crop_policy(Request $request){
        DB::beginTransaction();
        try{
            $datas = $request->input('data');
            $del_img = DB::table('l_image_hocba')
            ->where('id_user',Auth::guard('user')->user()->id)
            ->where('type_img',$datas[0][0])
            ->get();
            if(count($del_img) >0 ){
                foreach ($del_img as $key => $value) {
                    if(File::exists(ltrim($value ->link_img,"/"))){
                        unlink(ltrim($value ->link_img,"/"));
                    }
                }
            }

            DB::table('l_image_hocba')
            ->where('id_user',Auth::guard('user')->user()->id)
            ->where('type_img',$datas[0][0])
            ->delete();
            foreach ($datas as $key => $value) {
                $prefixfileName = Auth::guard('user')->user()->id.'.png';
                $fileName = $this ->rand_string(30)."_".$prefixfileName;
                $path = '/images/hocba'.'/'.Auth::guard('user')->user()->id.'/policy_'.$value[0].'_'.$value[1].'_'.$fileName;
                $data =  $value[2];
                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
                $data = base64_decode($data);
                $storage = Storage::disk('local');
                $storage->put('/hocba'.'/'.Auth::guard('user')->user()->id.'/policy_'.$value[0].'_'.$value[1].'_'.$fileName, $data, 'public');
                if($value[0] == 0){
                    $note_img = "Chứng minh nhân dân";
                    $number_img = 1;
                }else{
                    if($value[0] == 4){
                        $note_img = 'Bằng tốt nghiệp THPT';
                        $number_img = 2;
                    }else{
                        $note_img = "Đối tượng ưu tiên";
                        $number_img = 3;
                    }
                }
                $count = DB::select('SELECT max(id) as max FROM l_image_hocba');
                $ins = DB::table('l_image_hocba')
                ->updateOrInsert(
                    [
                        'id_user'   => Auth::guard('user')->user()->id,
                        'type_img'  =>$value[0],
                        'id_img'    =>$value[1],
                        // 'link_img'     => $path,
                    ],
                    [
                        'link_img'     => $path,
                        'note_type'    => $note_img,
                        'block_img'    => 0,
                        'number_img'   => $number_img,
                        'id_check'     => $count[0] ->max
                    ]
                );
                sleep(1);
            }
            DB::commit();
        }catch(Exception $e){
            BD::rollback();
        }

    }
}



