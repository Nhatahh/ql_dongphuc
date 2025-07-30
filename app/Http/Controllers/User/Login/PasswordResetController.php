<?php

namespace App\Http\Controllers\User\Login;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Mail\MailResetPass;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;

class PasswordResetController extends Controller
{
   public function index()
   {
        return view('user.login.passwordreset',[
            'title' => "CTUT|Reset Mật khẩu",
        ]);
   }


   public function store(Request $request){
    Auth::guard('user')->logout();
    $validator = Validator::make($request->all(),
        [
            'email_passwordreset'     =>'email|required',
            'phone_passwordreset'     =>'required|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:10|max:10',
            'cmnd_passwordreset'      =>'required|regex:/[0-9a-zA-Z]{9,12}/',

        ],
        [
            'email_passwordreset.email'      =>'Email chưa đúng định dạng',
            'email_passwordreset.required'   =>'Vui lòng điền email',

            'phone_passwordreset.required'    =>'Điền số điện thoại',
            'phone_passwordreset.regex'       =>'Số đầu tiên phải là số 0',
            'phone_passwordreset.not_regex'   =>'Điện thoại chỉ bao gồm chữ số',
            'phone_passwordreset.max'         =>'Điện thoại gồm 10 chữ số',
            'phone_passwordreset.min'         =>'Điện thoại gồm 10 chữ số',

            'cmnd_passwordreset.required'       =>'Vui lòng điền CMND hoặc Thẻ Căn cước',
            'cmnd_passwordreset.regex'          =>'CMND/TCC từ 10 đến 12 ký tự',
        ]
    );
    $phone = $request->input('phone_passwordreset');
    $email = $request->input('email_passwordreset');
    $id_card = $request->input('cmnd_passwordreset');
    $password= '12365878';
    // $password_send = Hash::make($password);
    $updatepass = 0;
    if ($validator->fails()) {
        return response()->json($validator->errors());
    }else{
        $check = DB::table('l_users')
        ->where('id_card_users',$id_card)
        ->where('phone_users',$phone)
        ->where('email_users',$email)
        ->get();
        if(count($check) == 1){
            try{
                // if()
                // DB::select('UPDATE `l_users` SET password = '.$password.' WHERE email_users = '.$email.' AND phone_users ='.$phone.' AND id_card_users = '.$id_card);
                DB::table('l_users')
                ->where('id',$check[0] ->id)
                ->where('phone_users',$phone)
                ->where('email_users',$email)
                // ->update(['password' => "111111111111"]);
                ->update(['password' => Hash::make($password)]);
                $this ->RegMail($email,$phone,$id_card,$password);
                $updatepass = 1;
            }catch(Exception $e){
                $updatepass = 'false';
            }
        }else{
            $updatepass = 0;
        }

    }
    return $updatepass;
}

    function RegMail($email,$phone,$id_card,$password){
        $maiable = new MailResetPass($email,$phone,$id_card,$password);
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
