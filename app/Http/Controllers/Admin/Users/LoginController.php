<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
   public function index()
   {
        return view('admin.users.login',[
            'title' => "CTUT|ĐĂNG NHẬP",
        ]);
   }

   public function store(Request $requets)
   {
    $validator = Validator::make($requets->all(),
        [
            'email' => 'required|email',
            'password' => 'required|alpha_dash|min:6'
        ],
        [
            'email.email'         =>'Email chưa đúng định dạng',
            'email.required'      =>'Vui lòng điền email',

            'password.required'   =>'Vui lòng điền Mật khẩu',
            'password.alpha_dash' =>'Mật khẩu chỉ gồm chữ cái và chữ số',
            'password.min'        =>'Mật khẩu phải từ 6 ký tự trở lên',
        ]
    );

    if ($validator->fails()) {
        return response()->json($validator->errors());
    }else{
        if(Auth::attempt(
            [
                'email' =>$requets->input('email'),
                'password' => $requets ->input('password')
            ]))
            {
               return 1;
            }else{
                return 0;
            }
        }
    }

}


