<?php

namespace App\Http\Controllers\User\Login;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Mail\MailRegUser;
use Exception;
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



   public function active_batch(){
        $batch = DB::table('l_years_open_batch_reg')
        ->get();
        if(count($batch)>0){
            if(count($batch) == 1){
                $active = 0; //Cho đăng ký
                $note = $batch[0]->note;
                $batch_ac =  $batch[0]->id_batch;
                $reg =  $batch[0]->reg;
            }
            if(count($batch) > 1){
                $active = 2; //Setup nhiều đợt
                $note ='Hệ thống đang bảo trì, vui lòng liên hệ 02923.898167';
                $batch_ac =0;
                $reg =  0;
            }
        }else{
            $active = 1; //Khóa tất cả đợt
            $note = 'Hệ thống đang khóa, chưa có đợt xét tuyển tiếp theo';
            $batch_ac = 0;
            $reg = 0;
        }
        $res = array(
            'active' => $active,
            'note' => $note,
            'batch' => $batch_ac,
            'reg' => $reg,
        );
        return $res;
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
    $active_batch = $this->active_batch()['reg'];
    $id_batch = $this->active_batch()['batch'];
    if($active_batch == 1){
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }else{
            $check = DB::select('SELECT * FROM l_users WHERE l_users.id_batch = '.$id_batch.' AND (l_users.id_card_users = '.$id_card.' OR l_users.email_users = "'.$email.'")');
            if(count($check)>0){
                return 2;
            }else{
                DB::beginTransaction();
                try{
                    DB::table('l_users_temp')
                    ->where('id_card_users',$id_card)
                    ->delete();
                    $password= '12365878';
                    DB::table('l_users_temp')->insert(
                        [
                        'id_card_users'     =>$id_card,
                        'phone_users'       =>$phone,
                        'email_users'       =>$email,
                        'password'          =>$password,
                        'id_batch'          => $id_batch,
                        ]
                    );
                    $this ->RegMail($email,$phone,$id_card,$password);
                    DB::commit();
                    return 1;
                }catch(Exception $e){
                    DB::rollBack();
                    return 0;
                }
            }
        }
    }else{
        return 2;
    }
   }


    function RegMail($email,$phone,$id_card,$password){
        $maiable = new MailRegUser($email,$phone,$id_card,$password);
        Mail::to($email)->send($maiable);
    }

    function rand_string( $length ) {
        $chars = "0123456789";
        $str ='';
        $size = strlen( $chars );

        for( $i = 0; $i < $length ; $i++ ) {
            $str .= $chars[rand( 0, $size - 1)];
        }
        return $str;
    }
}
