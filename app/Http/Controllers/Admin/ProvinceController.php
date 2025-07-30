<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Role;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Exists;
use Nette\Utils\Strings;

class ProvinceController extends Controller
{
    public function index(){
        return view('admin.province.index',[
            'title' => "CTUT|Quản lý người dùng",
        ]);
    }

    public function list_province(){
        $menus = DB::table('l_province')
        ->select(DB::raw('ROW_NUMBER() OVER(ORDER BY l_province.id) as stt'),'l_province.id',DB::raw("CONCAT(l_province.id_province,'xxx',id) as id_province"),DB::raw("CONCAT(l_province.name_province,'xxx',id) as name_province"),DB::raw("CONCAT(l_province.active_province,'xxx',id) as active_province"),DB::raw('CONCAT(0,"_",id) as end'))
        // ->where('active_province',1)
        ->get();

        $menu0 = array(
            'stt' =>1 + count($menus),
            'id' => '',
            'id_province' => '0xxx0',
            'name_province' => '0xxx0',
            'active_province' => '',
            'end' => "1_0"
        );

        $menus[] = $menu0;
        $json_data['data'] = $menus;
        $data = json_encode($json_data);
        echo  $data;
    }
    public function list_province2($id){
        $menus = DB::table('l_province2')
        ->select(DB::raw('ROW_NUMBER() OVER(ORDER BY l_province2.id) as stt'),'l_province2.id', 'l_province2.id_province', DB::raw("CONCAT(l_province2.id_province2,'xxx',id,'xxx',l_province2.id_province) as id_province2"),DB::raw("CONCAT(l_province2.name_province2,'xxx',id,'xxx',l_province2.id_province) as name_province2"),DB::raw("CONCAT(l_province2.active_province2,'xxx',id,'xxx',l_province2.id_province) as active_province2"),DB::raw('CONCAT(0,"_",id,"_",l_province2.id_province) as end'))
        // ->where('active_province2',1)
        ->where('id_province',$id)
        // ->orderBy('num','asc')
        ->get();

        $menu0 = array(
            'stt' =>1 + count($menus),
            'id' => '',
            // 'id_province' => '<input id = "id_province_save2" style = "width: 100%; height: 100%; border: none; background-color: inherit" disabled value = "'.$id.'">',
            'id_province2' => '0xxx0xxx0',
            'name_province2' => '0xxx0xxx0',
            'active_province2' => '',
            'end' => "1_".$id
        );
        $menus[] = $menu0;
        $json_data['data'] = $menus;
        $data = json_encode($json_data);
        echo  $data;
    }
    public function list_province3($id){
        $menus = DB::table('l_province3')
        ->select(DB::raw('ROW_NUMBER() OVER(ORDER BY l_province3.id) as stt'),'l_province3.id', 'l_province3.id_province2', DB::raw("CONCAT(l_province3.id_province3,'xxx',id,'xxx',l_province3.id_province2) as id_province3"),DB::raw("CONCAT(l_province3.name_province3,'xxx',id,'xxx',l_province3.id_province2) as name_province3"),DB::raw("CONCAT(l_province3.active_province3,'xxx',id,'xxx',l_province3.id_province2) as active_province3"),DB::raw('CONCAT(0,"_",id,"_",l_province3.id_province2) as end'))
        // ->where('active_province3',1)
        ->where('id_province2',$id)
        // ->orderBy('num','asc')
        ->get();
        $menu0 = array(
            'stt' =>1 + count($menus),
            'id' => '',
            'id_province3' => '0xxx0xxx0',
            'name_province3' => '0xxx0xxx0',
            'active_province3' => '',
            'end' => "1_".$id
        );
        $menus[] = $menu0;
        $json_data['data'] = $menus;
        $data = json_encode($json_data);
        echo  $data;
    }

    public function province_save(Request $request){
        try{
            $validator = Validator::make($request->all(),
            [
                'id_province'      =>'required|unique:l_province,id_province',
                'name_province'     =>'required',
            ],
            [
                'id_province.required'     =>'Mã Tỉnh không được Trống',
                'id_province.unique'       =>'Trùng Mã Tỉnh!',
                'name_province.required'    =>'Tên Tỉnh không được Trống',
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }else{
            $id_province = $request ->input('id_province');
            $name_province = $request ->input('name_province');
            DB::table('l_province')
            ->insert([
                'id_province' => $id_province,
                'name_province' => $name_province,
            ]);
            return 1;
            }
        }catch(Exception $e){
            return 0;
        }
    }
    public function province2_save(Request $request){
        try{
            $validator = Validator::make($request->all(),
                [
                    'name_province2'     =>'required',
                ],
                [
                    // 'id_province2.required'     =>'Mã Quận/Huyện không được Trống',
                    // 'id_province2.unique'       =>'Trùng Mã Quận/Huyện!',
                    'name_province2.required'    =>'Tên Quận/Huyện không được Trống',
                ]
            );
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }else{
                $id_province = $request ->input('id_province');
                $id_province2 = $request ->input('id_province2');
                $id = DB::table('l_province2')
                ->where('id_province',$id_province)
                ->get();
                $i = 0;
                foreach ($id as $key => $value) {
                    if($value->id_province2 == $id_province2){
                        $i++;
                        break;
                    }
                }
                if( $i == 0 ){
                    $name_province2 = $request ->input('name_province2');
                    DB::table('l_province2')
                    ->insert([
                        'id_province2' => $id_province2,
                        'name_province2' => $name_province2,
                        'id_province' => $id_province,
                    ]);
                    return 1;
                }else{
                    return 2;
                }


            }
        }catch(Exception $e){
            return 0;
        }
    }
    public function province3_save(Request $request){

        try{
            $validator = Validator::make($request->all(),
                [
                    'name_province3'     =>'required',
                ],
                [
                    'name_province3.required'    =>'Tên Xã/Phường không được Trống',
                ]
            );
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }else{
                $id_province2 = $request ->input('id_province2');
                $id_province3 = $request ->input('id_province3');
                $id = DB::table('l_province3')
                ->where('id_province3',$id_province2)
                ->get();
                $i = 0;
                foreach ($id as $key => $value) {
                    if($value->id_province3 == $id_province3){
                        $i++;
                        break;
                    }
                }
                if( $i == 0 ){
                    $name_province3 = $request ->input('name_province3');
                    DB::table('l_province3')
                    ->insert([
                        'id_province3' => $id_province3,
                        'name_province3' => $name_province3,
                        'id_province2' => $id_province2,
                    ]);
                    return 1;
                }else{
                    return 2;
                }
            }
        }catch(Exception $e){
            return 0;
        }
    }

    public function remove_province(Request $request){
        try{
            $id = $request ->input('id');
            $check = DB::table('l_province2')
            ->where('id_province',$id)
            ->get();
            if(count($check)>0){
                return 2;
            }else{
                 DB::table('l_province')
                ->where('id',$id)
                ->delete();
                return 1;
            }
        }catch(Exception $e){
            return 0;
        }
    }
    public function  remove_province2(Request $request){
        try{
            $id = $request ->input('id');
            $check = DB::table('l_province3')
            ->where('id_province2',$id)
            ->get();
            if(count($check)>0){
                return 2;
            }else{
                 DB::table('l_province2')
                ->where('id',$id)
                ->delete();
                return 1;
            }
        }catch(Exception $e){
            return 0;
        }
    }
    public function  remove_province3(Request $request){
        try{
            $id = $request ->input('id');
            DB::table('l_province3')
                ->where('id',$id)
                ->delete();
            return 1;
        }catch(Exception $e){
            return 0;
        }
    }

    public function change_id_province(Request $request){
        try{
            $validator = Validator::make($request->all(),
            [
                'id'                =>'required|alpha_num|min:0',
                'id_province'       =>'required',
            ],
            [
                'id.required'       =>'Lỗi hệ thống, vui lòng liên hệ admin',
                'id.alpha_num'      =>'Lỗi hệ thống, vui lòng liên hệ admin',
                'id.min'            =>'Lỗi hệ thống, vui lòng liên hệ admin',
                'id_province'       =>'Lỗi hệ thống, vui lòng liên hệ admin',
            ]
            );
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }else{
                $id = $request ->input('id');
                $id_province =  $request ->input('id_province');
                $check =  DB::table('l_province')
                ->get();
                $i = 0;
                foreach ($check as $key => $value) {
                    if($value->id_province == $id_province ){
                        $i++;
                    }
                }
                if($i > 0){
                    return 2;
                }else{
                    DB::table('l_province')
                    ->where('id',$id)
                    ->update([
                        'id_province' => $id_province
                    ]);
                    return 1;
                }
            }
        }catch(Exception $e){
            return 0;
        }
    }
    public function change_id_province2(Request $request){
        try{
            $validator = Validator::make($request->all(),
            [
                'id'                =>'required|alpha_num|min:0',
                'id_province2'       =>'required',
                'id_province'       =>'required',

            ],
            [
                'id_province2.required'       =>'Lỗi hệ thống, vui lòng liên hệ admin',
                'id_province.required'       =>'Lỗi hệ thống, vui lòng liên hệ admin',
                'id.required'       =>'Lỗi hệ thống, vui lòng liên hệ admin',
                'id.alpha_num'      =>'Lỗi hệ thống, vui lòng liên hệ admin',
                'id.min'            =>'Lỗi hệ thống, vui lòng liên hệ admin',

            ]
            );
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }else{
                $id_province = $request ->input('id_province');
                $id_province2 =  $request ->input('id_province2');
                $check =  DB::table('l_province2')
                ->where('id_province',$id_province)
                ->get();
                $i = 0;
                foreach ($check as $key => $value) {
                    if($value->id_province2 == $id_province2 ){
                        $i++;
                    }
                }
                if($i>0){
                    return 2;
                }else{
                    $id = $request ->input('id');
                    DB::table('l_province2')
                    ->where('id',$id)
                    ->update([
                        'id_province2' => $id_province2
                    ]);
                    return 1;
                }
            }
        }catch(Exception $e){
            return 0;
        }
    }
    public function change_id_province3(Request $request){
        try{
            $validator = Validator::make($request->all(),
            [
                'id'                =>'required|alpha_num|min:0',
                'id_province3'       =>'required',
                'id_province2'       =>'required',

            ],
            [
                'id_province3.required'       =>'Lỗi hệ thống, vui lòng liên hệ admin',
                'id_province2.required'       =>'Lỗi hệ thống, vui lòng liên hệ admin',
                'id.required'       =>'Lỗi hệ thống, vui lòng liên hệ admin',
                'id.alpha_num'      =>'Lỗi hệ thống, vui lòng liên hệ admin',
                'id.min'            =>'Lỗi hệ thống, vui lòng liên hệ admin',

            ]
            );
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }else{
                $id_province2 = $request ->input('id_province2');
                $id_province3 =  $request ->input('id_province3');
                $check =  DB::table('l_province3')
                ->where('id_province2',$id_province2)
                ->get();
                $i = 0;
                foreach ($check as $key => $value) {
                    if($value->id_province3 == $id_province3 ){
                        $i++;
                    }
                }
                if($i>0){
                    return 2;
                }else{
                    $id = $request ->input('id');
                    DB::table('l_province3')
                    ->where('id',$id)
                    ->update([
                        'id_province3' => $id_province3
                    ]);
                    return 1;
                }
            }
        }catch(Exception $e){
            return 0;
        }
    }

    public function change_name_province(Request $request){
        try{
            $validator = Validator::make($request->all(),
            [
                'id'                =>'required|alpha_num|min:0',
                'name_province'       =>'required',
            ],
            [
                'id.required'       =>'Lỗi hệ thống, vui lòng liên hệ admin',
                'id.alpha_num'      =>'Lỗi hệ thống, vui lòng liên hệ admin',
                'id.min'            =>'Lỗi hệ thống, vui lòng liên hệ admin',
                'name_province'       =>'Lỗi hệ thống, vui lòng liên hệ admin',
            ]
            );
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }else{
                $id = $request ->input('id');
                $name_province =  $request ->input('name_province');
                DB::table('l_province')
                ->where('id',$id)
                ->update([
                    'name_province' => $name_province
                ]);
                return 1;
            }
        }catch(Exception $e){
            return 0;
        }
    }
    public function change_name_province2(Request $request){
        try{
            $validator = Validator::make($request->all(),
            [
                'id'                    =>'required|alpha_num|min:0',
                'name_province2'        =>'required',
            ],
            [
                'id.required'                   =>'Lỗi hệ thống, vui lòng liên hệ admin',
                'id.alpha_num'                  =>'Lỗi hệ thống, vui lòng liên hệ admin',
                'id.min'                        =>'Lỗi hệ thống, vui lòng liên hệ admin',
                'name_province2.required'       =>'Lỗi hệ thống, vui lòng liên hệ admin',
            ]
            );
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }else{
                $id = $request ->input('id');
                $name_province2 =  $request ->input('name_province2');
                DB::table('l_province2')
                ->where('id',$id)
                ->update([
                    'name_province2' => $name_province2
                ]);
                return 1;
            }
        }catch(Exception $e){
            return 0;
        }
    }
    public function change_name_province3(Request $request){
        try{
            $validator = Validator::make($request->all(),
            [
                'id'                    =>'required|alpha_num|min:0',
                'name_province3'        =>'required',
            ],
            [
                'id.required'                   =>'Lỗi hệ thống, vui lòng liên hệ admin',
                'id.alpha_num'                  =>'Lỗi hệ thống, vui lòng liên hệ admin',
                'id.min'                        =>'Lỗi hệ thống, vui lòng liên hệ admin',
                'name_province3.required'       =>'Lỗi hệ thống, vui lòng liên hệ admin',
            ]
            );
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }else{
                $id = $request ->input('id');
                $name_province3 =  $request ->input('name_province3');
                DB::table('l_province3')
                ->where('id',$id)
                ->update([
                    'name_province3' => $name_province3
                ]);
                return 1;
            }
        }catch(Exception $e){
            return 0;
        }
    }

    public function change_active_province(Request $request){
        try{
            $id = $request ->input('id');
            $active_province =  $request ->input('active_province');
            $active_province == 'true' ? $active_province = 1 : $active_province = 0;
            DB::table('l_province')
            ->where('id',$id)
            ->update([
                'active_province' => $active_province
            ]);
            return 1;
        }catch(Exception $e){
            return 0;
        }

    }
    public function change_active_province2(Request $request){
        try{
            $id = $request ->input('id');
            $active_province2 =  $request ->input('active_province2');
            $active_province2 == 'true' ? $active_province2 = 1 : $active_province2 = 0;
            DB::table('l_province2')
            ->where('id',$id)
            ->update([
                'active_province2' => $active_province2
            ]);
            return 1;
        }catch(Exception $e){
            return 0;
        }

    }
    public function change_active_province3(Request $request){
        try{
            $id = $request ->input('id');
            $active_province3 =  $request ->input('active_province3');
            $active_province3 == 'true' ? $active_province3 = 1 : $active_province3 = 0;
            DB::table('l_province3')
            ->where('id',$id)
            ->update([
                'active_province3' => $active_province3
            ]);
            return 1;
        }catch(Exception $e){
            return 0;
        }
    }

}


