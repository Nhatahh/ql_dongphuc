<?php

namespace App\Http\Controllers\User\Login;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Mail\MailRegUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\Auth;

class RegisterUserController extends Controller
{
   public function index()
   {
        return view('user.login.register',[
            'title' => "CTUT|ĐĂNG KÝ TÀI KHOẢN",

        ]);
   }


   public function store(Request $request){
    // Artisan::call('cache:clear');

    $validator = Validator::make($request->all(),
        [
            'email_register'     =>'email|required|unique:l_users,email_users',
            'phone_register'     =>'required|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:10|max:10',
            'cmnd_register'      =>'required|unique:l_users,id_card_users',
        ],
        [
            'email_register.email'      =>'Email chưa đúng định dạng',
            'email_register.required'   =>'Vui lòng điền email',
            'email_register.unique'     =>'Email đã được đăng ký',

            'phone_register.required'    =>'Điền số điện thoại',
            'phone_register.regex'       =>'Số đầu tiên phải là số 0',
            'phone_register.not_regex'   =>'Điện thoại chỉ bao gồm chữ số',

            'cmnd_register.required'    =>'Vui lòng điền CMND hoặc Thẻ Căn cước',
            'cmnd_register.unique'      =>'CMND đã được đăng ký',
        ]
    );
    $phone = $request->input('phone_register');
    $email = $request->input('email_register');
    $id_card = $request->input('cmnd_register');
    $password= $this ->rand_string(8);
    if ($validator->fails()) {
        return response()->json($validator->errors());
    }else{
        DB::table('l_users')->insert(
            [
            'id_card_users'     =>$id_card,
            'phone_users'       =>$phone,
            'email_users'       =>$email,
            'password'    =>Hash::make($password),
            ]
        );
        $this ->RegMail($email,$phone,$id_card,$password);

        return 1;
    }
}

    function RegMail($email,$phone,$id_card,$password){
        $maiable = new MailRegUser($email,$phone,$id_card,$password);
        Mail::to($email)->send($maiable);
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
}
