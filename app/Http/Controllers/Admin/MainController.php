<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class MainController extends Controller
{
    public function index(){

        return view('admin.main',
        [
            'title' => "CTUT|Quản trị hệ thống",
        ]);
    }

    public function logout_admin(){
        Auth::logout();
        // return view('admin.users.login');
    }

    public function changepass_admin(){
        return view('admin.changepass_admin');
    }


    public function updatepassword_admin(Request $request){
        $validator = Validator::make($request->all(),
        [
            'user_passwordreset_old_admin'        =>'required|alpha_dash|min:6',
            'user_passwordreset_admin'            =>'required|alpha_dash|min:6|different:user_passwordreset_old_admin',
            'user_passwordreset_confirm_admin'    =>'required|alpha_dash|min:6|same:user_passwordreset_admin',
        ],
        [
            'user_passwordreset_old_admin.required'       => 'Vui lòng điền mật khẩu cũ',
            'user_passwordreset_old_admin.alpha_dash'     => 'Mật khẩu chỉ gồm chữ cái và chữ số',
            'user_passwordreset_old_admin.min'            => 'Mật khẩu gồm 6 ký tự trở lên',



            'user_passwordreset_admin.required'       => 'Vui lòng điền mật khẩu mới',
            'user_passwordreset_admin.different'     => 'Mật khẩu bị trùng với mật khẩu cũ',
            'user_passwordreset_admin.alpha_dash'     => 'Mật khẩu chỉ gồm chữ cái và chữ số',
            'user_passwordreset_admin.min'            => 'Mật khẩu gồm 6 ký tự trở lên',



            'user_passwordreset_confirm_admin.required'   => 'Vui lòng điền mật khẩu mới',
            'user_passwordreset_confirm_admin.same'       => 'Điền mật khẩu trùng với mật khẩu mới',
            'user_passwordreset_confirm_admin.alpha_dash' => 'Mật khẩu chỉ gồm chữ cái và chữ số',
            'user_passwordreset_confirm_admin.min'        => 'Mật khẩu gồm 6 ký tự trở lên',
        ]
    );
        if($validator ->fails()){
            return response()->json($validator ->errors());
        }else{
            $user_passwordreset_old = $request ->input('user_passwordreset_old_admin');
            $user_passwordreset = Hash::make($request ->input('user_passwordreset_admin'));
            $id = $request ->input('id');

            if(Hash::check($user_passwordreset_old, Auth::user()->password )){
                $update = DB::table('users')
                ->where([ 'id' =>$id ])
                ->update([
                    'password' => $user_passwordreset,
                    ]);
                if($update == 1){
                    return  $update;
                }else{
                    return  0;
                }
            };
        }
    }
}




