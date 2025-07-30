<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\Expenses_back;
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
use \App\Http\Controllers\User\Main\RegisterWishController;
use Exception;
use LDAP\Result;

use function PHPSTORM_META\type;
use function PHPUnit\Framework\countOf;

class ExpensesAdminController extends Controller

{
    public function index(){
        return view('admin.expenses.index',
        [
            'title' => "CTUT|Hệ thống đăng ký xét tuyển",
        ]);
    }

public function search($id){
    $infor = DB::table('l_info_users')
    ->join('l_users','l_users.id','l_info_users.id_user')
    ->where('id_user',$id)
    ->get();
    if(count($infor) == 0){
        $active_info = 0;
    }else{
        $active_info = 1;
    }

    $img = DB::table('l_image_hocba')
    ->where('id_user',$id)
    ->where('number_img',6)
    ->get();
    if(count($img) == 0){
        $img = "#";
    }else{
        $img = $img[0]->link_img;
    }

    $result = array(
        'info' => $infor,
        'active_info' => $active_info,
        'img' => $img,
    );


    return $result;
}

    //Load nguyeenj vongj dong phi
    public function wish($id){
        $major = DB::table('l_wish')
        ->select('block_ex','name_method','l_method.id_method as method','expenses','l_major.id_major as id_major','l_major.name_major as name_major','l_wish.id as id','l_wish.update_at as time','l_wish.number as number' )
        ->join('l_method_major','l_method_major.id','l_wish.id_major')
        ->join('l_major','l_method_major.id_major','l_major.id')
        ->join('l_method','l_method.id','l_method_major.id_method')

        ->leftJoin('l_expenses','l_expenses.id_wish','l_wish.id')
        ->leftJoin('l_expenses_admin','l_expenses_admin.id_wish','l_wish.id')
        ->where('l_wish.id_user',$id)
        ->orderBy('l_wish.number','asc')
        ->get();

        foreach ($major as $value) {
            $value ->wish_expenses =  $value->expenses."-".$value->id;
        }

        $json_data['data'] = $major;
        $data = json_encode($json_data);
        echo $data;
    }

//Load Phí
    public function load_price($id){
        $price  = DB::table('l_expenses_user')
        ->where('id_user',$id)
        ->sum('price');

        $wish =  DB::table('l_expenses_admin')
        ->where('id_user',$id)
        ->get();

        $price2 =  $price - count($wish)*20000;
        $result = array(
            'price' => $price,
            'price2' => $price2,
            'count' => count($wish),
        );
        return $result;
    }

    //Thu phi
    public function  charge(Request $request){
        DB::beginTransaction();
        try{
            $data =$request->input('data');
            $price = $request->input('price');

            DB::table('l_expenses_user')
            ->insert([
                [
                    'id_user'=> $request ->input('id_user'),
                    'price' => $price,
                    'id_ex_admin' =>Auth::user()->id,
                    'id_year' => 1,
                    'form_check' =>$request ->input('form_check')
                ]
            ]);

            $price  = DB::table('l_expenses_user')
            ->where('id_user',$request ->input('id_user'))
            ->sum('price');

            $i = 0;
            if(count($data) > 0){
                foreach ($data as $key => $value) {
                    $wish =  DB::table('l_expenses_admin')
                    ->where('id_wish', $value)
                    ->get();
                    if(count($wish) == 1){
                        $price = $price - 20000;
                    }else{
                        if($price - 20000 >= 0){
                            DB::table('l_expenses_admin')
                            ->insert([
                            [
                                'id_wish' => $value,
                                'price' => 20000,
                                'id_user_admin'=>Auth::user()->id,
                                'block_ex'=> 1,
                                'id_user'=> $request ->input('id_user'),
                                'form_check'=> $request ->input('form_check')
                            ]
                            ]);
                            $i++;
                            $price = $price - 20000;
                        }else{
                            break;
                        }
                    }
                    DB::table('l_expenses')
                    ->updateOrInsert(
                        [
                            'id_user'=> $request ->input('id_user'),
                            'id_wish' => $value,
                        ],
                        [
                            'expenses' => 1,
                            'block_expenses' =>1,
                        ]
                    );
                }
            $result = array(
                'price'=>  $price,
                'number' => $i,
            );
            DB::commit();
            return $result;
            }else{
                return "fail";
            }
        }catch(Exception $e){
            DB::rollback();
            return "fail";
        }
    }


    public function expenses_back(Request $request){
        $id_user =  $request ->input('id_user');
        $name_user = $request ->input('name_user_ex');
        $content = $request ->input('content_user_ex');
        $email = $request ->input('email_user_ex');
        $maiable = new Expenses_back($id_user,$name_user,$content);
        Mail::to($email)->send($maiable);
        return 1;
    }



    // function chekc_expenses(){
    //     $check = DB::table('l_block_expenses')
    //     ->where('id_user',Auth::guard('user')->user()->id)
    //     ->get();
    //     if(count($check)==1){
    //         return 1;
    //     }else{
    //         return 0;
    //     }
    // }


    // public function load_expenses_wish(){
    //     $check = RegisterWishController::check_reg();
    //     if($check == 0){
    //         return 'check_false';
    //     }else{
    //         $major = DB::table('l_wish')
    //         ->select('name_method','expenses','l_major.id_major as id_major','l_major.name_major as name_major','l_wish.id as id','l_wish.update_at as time','l_wish.number as number' )
    //         ->join('l_method_major','l_method_major.id','l_wish.id_major')
    //         ->join('l_major','l_method_major.id_major','l_major.id')
    //         ->join('l_method','l_method.id','l_method_major.id_method')
    //         ->leftJoin('l_expenses','l_expenses.id_wish','l_wish.id')
    //         ->where('l_wish.id_user',Auth::guard('user')->user()->id)
    //         ->orderBy('l_wish.number','asc')
    //         ->get();
    //         foreach ($major as $value) {
    //             $value -> wish_expenses =  $value->expenses."-".$value->id;

    //         }
    //         $json_data['data'] = $major;
    //         $data = json_encode($json_data);
    //         echo  $data;
    //     }
    // }

    // public function load_expenses_img(){
    //     $ins = DB::table('l_image_hocba')
    //     ->where('id_user',Auth::guard('user')->user()->id)
    //     ->where('type_img',3)
    //     ->get();
    //     echo $ins[0]->link_img;
    // }

    //Lưu ảnh
    // function crop_ex(Request $request){
    //     $prefixfileName = Auth::guard('user')->user()->id.'.png';
    //     $fileName =InfoUserController::rand_string(30)."_".$prefixfileName;
    //     $path = '/images/hocba'.'/'.Auth::guard('user')->user()->id.'/expenses_3_1_'.$fileName;
    //     $data =  $request->input('img');
    //     list($type, $data) = explode(';', $data);
    //     list(, $data)      = explode(',', $data);
    //     $data = base64_decode($data);
    //     $storage = Storage::disk('local');
    //     $storage->put('/hocba'.'/'.Auth::guard('user')->user()->id.'/expenses_3_1_'.$fileName,$data, 'public');
    //     $ins = DB::table('l_image_hocba')
    //     ->updateOrInsert(
    //         [
    //             'id_user'   => Auth::guard('user')->user()->id,
    //             'type_img'  =>3,
    //             'id_img'    =>1,

    //         ],
    //         [
    //         'link_img'     => $path,
    //         'note_type'    => "Lệ phí xét tuyển",
    //         'block_img'    => 0,
    //         'number_img'   =>6,
    //         ]
    //     );
    //     $result = array(
    //         'ins' => $ins,
    //         'src' =>  $path,
    //     );
    //     return  $result;
    // }

    // public function save_expenses_wish(Request $request){
    //     $data = $request->input('data');
    //     $re = 0;
    //     foreach ($data as $value) {
    //         $major = DB::table('l_expenses')
    //         ->updateOrInsert(
    //             [
    //                 'id_user' => Auth::guard('user')->user()->id,
    //                 'id_wish' => $value[1]
    //             ],
    //             [
    //             'expenses' => $value[0],
    //             'block_expenses' => 1,
    //             ]
    //         );
    //         $re =  $re + $major;
    //     }
    //     if($re == 0){
    //         $check = DB::table('l_expenses')
    //         ->select('l_wish.number as number',)
    //         ->join('l_wish','l_wish.id','l_expenses.id_wish')
    //         ->where('block_expenses',1)
    //         ->get();
    //         $a = "Bạn đã xác nhận đóng lệ phí cho nguyên vọng ";
    //         foreach ($check as $key => $value) {
    //             $a .= $value->number.", ";
    //         }
    //         return $a;
    //     }else{
    //         return  $re;
    //     }
    // }

    // public function load_price(){
    //     $price =  DB::table('l_expenses')
    //     ->where('id_user',Auth::guard('user')->user()->id)
    //     ->get();
    //     if(count($price) > 0){
    //         $price =  count($price)*20000;
    //     }else{
    //         $price = 0;
    //     }

    //     $user =  DB::table('l_users')
    //     ->where('id',Auth::guard('user')->user()->id)
    //     ->get();

    //     $result = array(
    //         'price' => $price,
    //         'info_price' => $user[0]->phone_users." ID".Auth::guard('user')->user()->id,
    //     );
    //     return $result;
    // }


}//End Class
