<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Role;
use App\Http\Controllers\Controller;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Exists;
use Nette\Utils\Strings;

class UsersController extends Controller
{

    public function create(){
        return view('admin.users.users',[
            'title' => "CTUT|Quản lý người dùng",
        ]);
    }

    public function loadUsers(){
        if(Auth::id() == 1){
            $menus = DB::table('users')
            ->select(DB::raw('ROW_NUMBER() OVER(ORDER BY users.num) as stt'),'users.*')
            ->where('id','<>',Auth::id())
            ->orderBy('num','asc')
            ->get();
        }else{
            $menus = DB::table('users')
            ->select(DB::raw('ROW_NUMBER() OVER(ORDER BY users.num) as stt'),'users.*')
            ->where('level_ad','<>',1)
            ->where('id','<>',Auth::id())
            ->orderBy('num','asc')
            ->get();
        }
        foreach ($menus as $row) {
            $row->id_name = $row->id."-".$row->name;
        }
        $json_data['data'] = $menus;
        $data = json_encode($json_data);
        echo  $data;
    }

    public function destroy($id){
        $user = DB::table('users')->where('id',$id)->get();
        if( $user){
            User::where('id',$id)->delete();
            return true;
        }else{
            return false;
        }
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),
            [
                'name'      =>'required|unique:users,name',
                'email'     =>'required|unique:users,email|email',
                'phone'     =>'required|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:10|max:10',
                'num'       =>'alpha_num|min:0',
            ],
            [
                'name.required'     =>'Điền tên chức năng',
                'name.unique'       =>'Trùng tên chức năng!',
                'email.required'    =>'Điền email',
                'email.unique'      =>'Trùng email!',
                'email.email'       =>'Điền đúng định dạng email!',
                'phone.required'    =>'Điền điện thoại',
                // 'phone.unique'      =>'Trùng điện thoại!',
                'phone.regex'       =>'Số đầu tiên phải là số 0',
                'phone.not_regex'   =>'Điện thoại chỉ bao gồm chữ số',
                // 'phone.numeric'     =>'Điện thoại chỉ bao gồm chữ số',
                'phone.min'         =>'Điện thoại gồm 10 chữ số',
                'phone.max'         =>'Điện thoại gồm 10 chữ số',
                'num.alpha_num'     =>'Thứ tự phải là số',

            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }else{
            if($request->input('active') == 'true' ){
                $active = 1;
            }else{
                $active = 0;
            }
            try{
                User::create([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone'),
                    'active' =>  $active,
                    'num' =>  $request->input('num'),
                    'password' =>  '$2y$10$KTByROylBHQ7h3cQcY/.F.O3EQTmdixDEBQ5PP8MhDymdnZeqU6MG',
                    'level_ad' => 2
                ]);
                return 1;
            }catch(Exception $e){
                return 0;
            }

        }
    }

    public function load($id){
        $user = DB::table('users')->where('id', $id)->get();
        return $user;
    }

    public function edit(Request $request){
        $validator = Validator::make($request->all(),
            [
                'name'      =>'required',
                'email'     =>'required',
                'phone'     =>'required|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:10|max:10',
                'num'       =>'alpha_num|min:0',
                // 'password'  =>'required|alpha_dash|min:6'
            ],
            [
                'name.required'     =>'Điền tên chức năng',
                // 'name.unique'       =>'Trùng tên chức năng!',

                'email.required'    =>'Điền email',
                // 'email.unique'      =>'Trùng email!',
                'email.email'       =>'Điền đúng định dạng email!',

                'phone.required'    =>'Điền điện thoại',
                // 'phone.unique'      =>'Trùng điện thoại!',
                'phone.regex'       =>'Số đầu tiên phải là số 0',
                'phone.not_regex'   =>'Điện thoại chỉ bao gồm chữ số',
                // 'phone.numeric'     =>'Điện thoại chỉ bao gồm chữ số',
                'phone.min'         =>'Điện thoại gồm 10 chữ số',
                'phone.max'         =>'Điện thoại gồm 10 chữ số',

                'num.alpha_num'     =>'Thứ tự phải là số',
                // 'password.required' =>'111111111',
                // 'password.alpha_dash' =>'2222222222',
                // 'password.min' =>'33333333333333',

            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }else{
            if($request->input('active') == 'true' ){
                    $active = 1;
                }else{
                    $active = 0;
                }
        if($request->input('password') == ""){
            DB::table('users')
            ->where('id', $request->input('id'))
            ->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                // 'password' => base64_encode($request->input('password')),
                'active' =>  $active,
                'num' =>  $request->input('num'),
            ]);
        }else{
            DB::table('users')
            ->where('id', $request->input('id'))
            ->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'password' => Hash::make($request->input('password')),
                'active' =>  $active,
                'num' =>  $request->input('num'),
            ]);
        }

            $menu = DB::table('users')
            ->where('id', $request->input('id'))
            ->get();
            if($menu){
                return 1;
            }else{
                return 0;
            }
        }
    }

    public function loadUser_Menus_Roles($id){
        switch (Auth::user()->level_ad) {
            case '2':
                $roles = DB::table('l_roles')
                // ->select('idmenu','iduser','id')
                ->where('iduser',$id)
                ->get();

                $menus = DB::table('l_menus')
                ->select('id','name','parent_id','number','icon')
                ->where('root_ad',0)
                ->where('active',1)
                ->get();
                break;
            default:
                $roles = DB::table('l_roles')
                ->select('idmenu','iduser','id')
                ->where('iduser',$id)
                ->get();

                $menus = DB::table('l_menus')
                ->select('id','name','parent_id','number','icon')
                ->where('active',1)
                ->get();
                break;
        }

        $i=0;

        foreach($menus as $menu){
            $menu->iduser = $id;
            foreach($roles as $role){
                if($menu->id == $role ->idmenu){
                    $role = $role->id;
                    $i++;
                    break;
                }
            }
            if($i==0){
                $menu ->hasrole = 0;
                $menu ->idrole = 0;
            }else{
                $menu ->hasrole = 1;
                $menu ->idrole =  $role;
            }
            $i=0;
        }

        $this->User_Menus_Roles($menus,0,0,"",$result);
        $json_data['data'] = $result;
        $data = json_encode($json_data);
        echo $data;
        // echo $menus;
    }

    function User_Menus_Roles($menus,$parent_id = 0,$level=0,$char = "",&$result){
        $i = 1;
        foreach($menus as $key => $menu){
            if($menu->parent_id === $parent_id ){
                $menu->name = $char.'&nbsp;<i style = "color:#007bff" class="fa-solid '.$menu->icon.'"></i>&nbsp;&nbsp;<strong>'.$i.'</strong>.&nbsp;'.$menu->name;
                $menu->trangthai = $menu->hasrole."_".$level."_".$menu->id."_".$menu->idrole."_".$menu->iduser."_".$menu->parent_id;
                $result[] = $menu;
                unset($menus[$key]);
                $i++;
                self::User_Menus_Roles($menus,$menu->id,1+ $level,$char."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$result);
            }
        }
    }

    function updateRole($idmenu,$idrole,$iduser,$check,$parent){
        $checkparent = DB::table('l_roles')
        ->join('l_menus','l_roles.idmenu','l_menus.id')
        ->where('parent_id',$parent)
        ->where('iduser',$iduser)
        ->where('active',1)
        ->get();
        if($check == 1){
            $checkparent = DB::table('l_roles')
            ->where('idmenu',$parent)
            ->where('iduser',$iduser)
            ->get();
                if(count($checkparent)==0){
                    DB::table('l_roles')->insert([
                    'idmenu' => $parent,
                    'iduser' => $iduser,
                ]);
            }
            DB::table('l_roles')->insert([
                'idmenu' => $idmenu,
                'iduser' => $iduser,
            ]);
            return 1;

        }
        else
        {
            if(count($checkparent) == 1){
                DB::table('l_roles')
                ->where('idmenu', $parent)
                ->where('iduser', $iduser)
                ->delete();
            }
            DB::table('l_roles')
            ->where('idmenu', $idmenu)
            ->where('iduser', $iduser)
            ->delete();
            return 1;
            // return count($checkparent);
        }
    }
}

