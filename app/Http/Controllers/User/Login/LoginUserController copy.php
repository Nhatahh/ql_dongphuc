<?php

namespace App\Http\Controllers\User\Login;

use App\Http\Controllers\Controller;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\DatabaseUserProvider;


class LoginUserController extends Controller
{
   public function index()
   {
        return view('user.login.login',[
            'title' => "CTUT|ĐĂNG NHẬP TÀI KHOẢN",
        ]);
   }




   public function store(Request $requets)
   {


    $validator = Validator::make($requets->all(),
    [
        'email_login'     =>'email|required',
        'phone_login'     =>'required|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:10|max:10',
        'cmnd_login'      =>'required|regex:/[0-9a-zA-Z]{9,12}/',
        'password_login' => 'required|alpha_dash|min:8'
    ],
    [
        'email_login.email'         =>'Email chưa đúng định dạng',
        'email_login.required'      =>'Vui lòng điền email',

        'phone_login.required'      =>'Điền số điện thoại',
        'phone_login.regex'         =>'Số đầu tiên phải là số 0',
        'phone_login.not_regex'     =>'Điện thoại chỉ bao gồm chữ số',
        'phone_login.max'           =>'Điện thoại gồm 10 chữ số',
        'phone_login.min'           =>'Điện thoại gồm 10 chữ số',

        'password_login.required'   =>'Vui lòng điền Mật khẩu',
        'password_login.alpha_dash' =>'Mật khẩu chỉ gồm chữ cái và chữ số',
        'password_login.min'        =>'Mật khẩu phải từ 8 ký tự trở lên',

        'cmnd_login.required'       =>'Vui lòng điền CMND hoặc Thẻ Căn cước',
        'cmnd_login.regex'          =>'CMND/TCC từ 10 đến 12 ký tự',
        'cmnd_login.unique'         =>'CMND đã được đăng ký',

    ]
);
    if ($validator->fails()) {
        return response()->json($validator->errors());
    }else{
        if(Auth::guard('user')->attempt(
            [
                'email_users' =>$requets->input('email_login'),
                'password' => $requets ->input('password_login'),
                'phone_users' => $requets ->input('phone_login'),
                'id_card_users' => $requets ->input('cmnd_login'),
            ]))
            {
               return 1;
            }else{
                return 0;
            }
        }
    }
}
