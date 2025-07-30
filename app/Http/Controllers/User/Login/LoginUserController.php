<?php

namespace App\Http\Controllers\User\Login;

use App\Http\Controllers\Controller;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\DatabaseUserProvider;
use Illuminate\Support\Facades\DB;


class LoginUserController extends Controller
{
   public function index()
   {
        return view('user.login.login',[
            'title' => "CTUT|ĐĂNG NHẬP TÀI KHOẢN",
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
            }
            if(count($batch) > 1){
                $active = 2; //Setup nhiều đợt
                $note ='Hệ thống đang bảo trì, vui lòng liên hệ 02923.898167';
                $batch_ac =0;
            }
        }else{
            $active = 1; //Khóa tất cả đợt
            $note = 'Hệ thống đang khóa, chưa có đợt xét tuyển tiếp theo';
            $batch_ac = 0;
        }
        $res = array(
            'active' => $active,
            'note' => $note,
            'batch' => $batch_ac,
        );
        return $res;
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
    $id_batch =  $this->active_batch()['batch'];
    if($id_batch > 0){
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }else{
            $email_users  = $requets->input('email_login');
            $password  = $requets->input('password_login');
            $phone_users  = $requets->input('phone_login');
            $id_card_users  = $requets->input('cmnd_login');

            $check = DB::table('l_users_temp')
            ->where('email_users',$email_users)
            ->where('password',$password)
            ->where('phone_users',$phone_users)
            ->where('id_card_users',$id_card_users)
            ->where('id_batch', $id_batch)
            ->get();

            if(count($check) == 1 && $check[0]->first == 0){
                DB::table('l_users')->insert(
                    [
                    'id_card_users'     =>$check[0]->id_card_users,
                    'phone_users'       =>$check[0]->phone_users,
                    'email_users'       =>$check[0]->email_users,
                    'password'          =>Hash::make($check[0]->password),
                    'id_batch'          => $id_batch,
                    ]
                );
                DB::table('l_users_temp')
                    ->where('email_users',$email_users)
                    ->where('password',$password)
                    ->where('phone_users',$phone_users)
                    ->where('id_card_users',$id_card_users)
                    ->where('id_batch', $id_batch)
                    ->update([
                        'first' => 1
                    ]);
                }

                // $year = DB::table('l_year_active')
                // ->get();
                // if($year[0]->open_go_bo == 1){
                //  $check_active = DB::table("l_users")
                //     ->where('email_users',$email_users)
                //     ->where('phone_users',$phone_users)
                //     ->where('id_card_users',$id_card_users)
                //     ->where('id_bo',1)
                //     ->get();
                // }else{
                //     $check_active = DB::table("l_users")
                //     ->where('email_users',$email_users)
                //     ->where('phone_users',$phone_users)
                //     ->where('id_card_users',$id_card_users)
                //     ->where('active_users',1)
                //     ->get();
                // }

                if(Auth::guard('user')->attempt(
                    [
                        'email_users' =>$requets->input('email_login'),
                        'password' => $requets ->input('password_login'),
                        'phone_users' => $requets ->input('phone_login'),
                        'id_card_users' => $requets ->input('cmnd_login'),
                        'id_batch' =>  $id_batch,

                    ]))
                    {
                        return  1;
                }else{
                    return 0;
                }
            }
        }else{
            return 2;
        }
    }
}
