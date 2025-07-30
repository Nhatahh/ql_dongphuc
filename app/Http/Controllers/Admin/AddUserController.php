<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use PhpOption\Option;
use PhpParser\Node\Expr\FuncCall;
use \App\Http\Controllers\User\Main\InfoUserController;
use \App\Http\Controllers\Admin\YearBatchController;




use \App\Http\Controllers\User\Main\RegisterWishController;
use Exception;
use LDAP\Result;
use Psy\Command\WhereamiCommand;
use App\Mail\MailRegUser;
use function PHPUnit\Framework\countOf;
use Illuminate\Support\Facades\Mail;
class AddUserController extends Controller
{
   public function index()
   {
        return view('admin.adduser.index',[
            'title' => "CTUT|Thêm tài khoản",
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

     public function add(Request $request){
        $validator = Validator::make($request->all(),
        [
            'email_add'     =>'email|required',
            'phone_add'     =>'required|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:10|max:10',
            'id_card_add'      =>'required|regex:/[0-9a-zA-Z]{9,12}/'
        ],
        [
            'email_add.email'      =>'Email chưa đúng định dạng',
            'email_add.required'   =>'Vui lòng điền email',
            // 'email_add.unique'     =>'Email đã được đăng ký',

            'phone_add.required'    =>'Điền số điện thoại',
            'phone_add.regex'       =>'Số đầu tiên phải là số 0',
            'phone_add.not_regex'   =>'Điện thoại chỉ bao gồm chữ số',

            'id_card_add.required'    =>'Vui lòng điền CMND hoặc Thẻ Căn cước',
            // 'id_card_add.unique'      =>'CMND đã được đăng ký',
            'id_card_add.regex'       =>'CMND/TCC từ 10 đến 12 ký tự',
        ]
    );
    $phone = $request->input('phone_add');
    $email = $request->input('email_add');
    $id_card = $request->input('id_card_add');

    if ($validator->fails()) {
        return response()->json($validator->errors());
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
                'id_batch'          =>3,
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

    public function id_card_reset_save(Request $request){
        try{
            // $check = DB::table('l_year_active')
            // ->get();
            $id_card_users = $request->input('id_card_users');
            $id_batch = $request->input('batch');
            // if(count($check) > 0){
            //     if(count($check) == 1){
                    // $id_batch = $check[0]->id_batch;
                    DB::table('l_users')
                    ->where('id_card_users',$id_card_users)
                    ->where('id_batch',$id_batch)
                    ->update(['password' => Hash::make('12365878')]);
                    return 1;
                // }else{
                //     return 2;
                // }
            // }else{
            //     return 3;
            // }
        }catch(Exception $e){
            return 0;

        }
    }


}
