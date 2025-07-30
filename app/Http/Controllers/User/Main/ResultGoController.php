<?php

namespace App\Http\Controllers\User\Main;

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
use \App\Http\Controllers\User\Main\RegisterWishController;

use \App\Http\Controllers\Admin\ExpensesAdminController;
use Exception;
use FontLib\Table\Type\name;

use function PHPUnit\Framework\countOf;
use PDF;
use PHPUnit\Framework\Constraint\Count;

class ResultGoController extends Controller

{
    public function index(){
        return view('user.main.result_go',
        [
            'title' => "CTUT|Hệ thống đăng ký xét tuyển",
        ]);
    }

    public function dowload_result_go()
    {
        if($this->load_wish() == 0){
            $data = [
                'title' => 0
            ];
        }else{
            $infor =  DB::table('l_go')
                ->join('l_wish','l_wish.id','l_go.id_wish')
                ->join('l_group','l_group.id','l_wish.id_group')
                ->join('l_method_major','l_method_major.id','l_wish.id_major')
                ->join('l_major','l_method_major.id_major','l_major.id')
                ->join('l_method','l_method_major.id_method','l_method.id')
                ->join('l_year_batch','l_year_batch.id','l_wish.id_batch')
                ->join('l_info_users','l_wish.id_user','l_info_users.id_user')
                ->join('l_users','l_users.id','l_wish.id_user')
                ->where('l_wish.id_user',Auth::guard('user')->user()->id)
                ->select('id_card_users','name_user','phone_users','email_users','name_major','l_users.id as id_user','mark','name_method','name_group','l_group.id_group as id_group')
                ->get();
            $data = [
                'id_card_users' => $infor[0]->id_card_users,
                'name_user' => $infor[0]->name_user,
                'phone_users' => $infor[0]->phone_users,
                'email_users' => $infor[0]->email_users,
                'name_major' => $infor[0]->name_major,
                'id_user' => $infor[0]->id_user,
                'mark' => $infor[0]->mark,
                'name_method' => $infor[0]->name_method,
                'name_group' => $infor[0]->name_group,
                'id_group' => $infor[0]->id_group,
            ];
        $pdf = PDF::loadView('pdf.resullt_go', $data);
        }
        return $pdf->stream('GiayBaoDuDieuKienTrungTuyen.pdf');
    }



    public function load_wish(){
        $reg = DB::table('l_wish')
        ->where('l_wish.id_user',Auth::guard('user')->user()->id)
        ->get();
        if(count($reg) > 0){
            $wish = DB::select('SELECT * FROM `l_wish` INNER JOIN l_year_batch ON l_year_batch.id = l_wish.id_batch WHERE l_wish.id_user = '.Auth::guard('user')->user()->id.' AND l_year_batch.block = 0 LIMIT 0,1');
            if(count($wish) == 1){
                $res = DB::select('SELECT WISH.*,l_go.id,if(WISH.block = 0,"Hệ thống đang xét tuyển",if(l_go.id is null,"Không đủ điều kiện trúng tuyển","Đủ điều kiện trúng tuyển")) as result FROM l_go RIGHT JOIN (SELECT l_wish.id as id, l_batch.name_batch as name_batch, l_wish.number as number, l_wish.mark as mark,l_method.name_method as name_method, l_major.name_major as name_major,l_year_batch.block as block FROM `l_wish` INNER JOIN l_year_batch ON l_year_batch.id = l_wish.id_batch INNER JOIN l_batch ON l_batch.id = l_year_batch.id_batch INNER JOIN l_method ON l_method.id = l_wish.id_method INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_major.id = l_method_major.id_major WHERE l_wish.id_user = '.Auth::guard('user')->user()->id.') as WISH ON l_go.id_wish = WISH.id');
            }else{
                $res = DB::select('SELECT WISH.*,l_go.id,if(l_go.id is null,"Không đủ điều kiện trúng tuyển","Đủ điều kiện trúng tuyển") as result FROM l_go RIGHT JOIN (SELECT l_wish.id as id, l_batch.name_batch as name_batch, l_wish.number as number, l_wish.mark as mark,l_method.name_method as name_method, l_major.name_major as name_major,l_year_batch.block as block FROM `l_wish` INNER JOIN l_year_batch ON l_year_batch.id = l_wish.id_batch INNER JOIN l_batch ON l_batch.id = l_year_batch.id_batch INNER JOIN l_method ON l_method.id = l_wish.id_method INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_major.id = l_method_major.id_major WHERE l_wish.id_user = '.Auth::guard('user')->user()->id.') as WISH ON l_go.id_wish = WISH.id');
            }
            return $res;
        }else{
            return 0;
        }
    }

    public function bogddt_result_go(){
        $infor =  DB::table('l_go')
        ->join('l_wish','l_wish.id','l_go.id_wish')
        ->join('l_method_major','l_method_major.id','l_wish.id_major')
        ->join('l_major','l_method_major.id_major','l_major.id')
        ->where('l_wish.id_user',Auth::guard('user')->user()->id)
        ->select('name_major','l_major.id_major as id_major','l_wish.id_major as id_major1')
        ->get();

        $check_go =  DB::table('l_go')
        ->join('l_wish','l_wish.id','l_go.id_wish')
        ->where('id_user',Auth::guard('user')->user()->id)
        ->get();

        $check_go_go =  DB::table('l_go_check')
        ->join('l_wish','l_wish.id','l_go_check.id_wish')
        ->where('id_user',Auth::guard('user')->user()->id)
        ->get();

        $check_user_marjor =  DB::table('l_user_major')
        ->join('users','users.id','l_user_major.id_user')
        ->where('l_user_major.id_major',$infor[0]->id_major1)
        ->get();

        if(count($check_user_marjor) > 0 ){
            $name = $check_user_marjor[0]->name;
            $phone = $check_user_marjor[0]->phone;
        }else{
            $name = "";
            $phone = "";
        }

        $check_batch =  DB::table('l_go')
            ->join('l_wish','l_wish.id','l_go.id_wish')
            ->join('l_year_batch','l_year_batch.id','l_wish.id_batch')
            ->where('l_wish.id_user',Auth::guard('user')->user()->id)
            ->get();

        if($check_go[0]->block_all ==  1){
            $block_all = 1;
        }else{
            $block_all = 0;
        }

        if($check_batch[0]->block == 1){
            if(count($check_go) == 1){
                if(count($check_go_go) == 1){
                    $result = array(
                        'save' => 1,
                        'id_wish' => $check_go[0]->id_wish,
                        'id_card_users_bo' => $check_go_go[0]->id_card_users_bo,
                        'phone_users_bo' => $check_go_go[0]->phone_users_bo,
                        'block' => $check_go_go[0]->block,
                        'name_major' => $infor[0]->name_major,
                        'id_major' => $infor[0]->id_major,
                        'name_user' =>  $name,
                        'phone_users' => $phone,
                        'active_bo' => $check_go_go[0]->active_bo,
                        'trangthai' => 1,
                        'block_all' => $block_all,
                    );
                }else{
                    $result = array(
                        'save' => 1,
                        'id_wish' => $check_go[0]->id_wish,
                        'id_card_users_bo' => "",
                        'phone_users_bo' => "",
                        'block' => "",
                        'name_major' => $infor[0]->name_major,
                        'id_major' => $infor[0]->id_major,
                        'name_user' => $name,
                        'phone_users' => $phone,
                        'active_bo' => 0,
                        'trangthai' => 0,
                        'block_all' => $block_all,
                    );
                }
            }else{
                $result = array(
                    'save' => 0,
                    'id_wish' => 0,
                    'id_card_users_bo' => "",
                    'phone_users_bo' => "",
                    'block' => "",
                    'name_major' => "",
                    'id_major' => "",
                    'name_user' => "",
                    'active_bo' => 0,
                    'trangthai' => 0,
                    'trangthai' => 0,
                    'block_all' => 0,
                );
            }
        }else{
            $result = array(
                'save' => 0,
                'id_wish' => 0,
                'id_card_users_bo' => "",
                'phone_users_bo' => "",
                'block' => "",
                'name_major' => "",
                'id_major' => "",
                'name_user' => "",
                'active_bo' => 0,
                'trangthai' => 0,
                'trangthai' => 0,
            );
        }
        return $result;
    }


    function remove_go($id_wish){
        DB::beginTransaction();
        try{

            DB::table('l_go_remove')
            ->updateOrInsert(
                [
                    'id_wish' => $id_wish
                ],
                [
                    'remove_go' => 1
                ]
            );
            DB::commit();
            echo 1;
        }catch(Exception $e){
            DB::rollBack();
            echo 0;
        }
    }

    public function bogddt_result_go_save(Request $request){
        $id_card_users_bo = $request -> input('id_card_users_bo');
        $phone_users_bo = $request -> input('phone_users_bo');
        $id_wish = $request -> input('id_wish');
        $active_bo = $request -> input('active_bo');

        $check = DB::table('l_go_check')
        ->where('id_wish', $id_wish)
        ->get();

        // if($active_bo == 1){
        //     $thongtin = "NV1";
        // }else{
        //     if($active_bo == 2){
        //         $thongtin = "NV2";
        //     }else{
        //         $thongtin = "Không nhập học";
        //     }
        // }

        if(count($check) > 0){
            DB::beginTransaction();
            try{
                DB::table('l_go_check')
                ->where('id_wish', $id_wish)
                ->update([
                    'id_card_users_bo' => $id_card_users_bo,
                    'phone_users_bo' => $phone_users_bo,
                    'active_bo' => $active_bo,
                ]);

                $name_student = DB::table('l_info_users')
                ->where('id_user',Auth::guard('user')->user()->id)
                ->get();

                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                DB::table('l_history')
                ->insert([
                    'id_student'    =>  Auth::guard('user')->user()->id,
                    'id_user'       =>  Auth::guard('user')->user()->id,
                    'name_history'  =>  "Xác nhận đăng ký cổng Bộ",
                    'content'       =>  $name_student[0]->name_user. 'Cập nhật (CMND, SDT) đăng ký trên cổng của Bộ',
                    'ip'            =>  request()->ip(),
                    'info_client'   =>  $user_agent
                ]);

                DB::commit();
                echo 1;
            }catch(Exception $e){
                DB::rollBack();
                echo 0;
            }
        }else{
            DB::beginTransaction();
            try{
                DB::table('l_go_check')
                ->insert([
                    'id_wish' => $id_wish,
                    'id_card_users_bo' => $id_card_users_bo,
                    'phone_users_bo' => $phone_users_bo,
                    'active_bo' => $active_bo,
                ]);

                $name_student = DB::table('l_info_users')
                ->where('id_user',Auth::guard('user')->user()->id)
                ->get();


                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                DB::table('l_history')
                ->insert([
                    'id_student'    =>  Auth::guard('user')->user()->id,
                    'id_user'       =>  Auth::guard('user')->user()->id,
                    'name_history'  =>  "Xác nhận đăng ký cổng Bộ",
                    'content'       =>  $name_student[0]->name_user. 'Chấp nhận (CMND, SDT) đăng ký trên cổng của Bộ.',
                    'ip'            =>  request()->ip(),
                    'info_client'   =>  $user_agent
                ]);

                DB::commit();
                echo 1;
            }catch(Exception $e){
                DB::rollBack();
                echo 0;
            }
        }
    }


    public function go_wish(){
        $check = DB::table('l_year_batch')
        ->where('active_year_batch',1)
        ->get();
        if(count($check)==1){
            return 1;
        }else{
            return 0;
        }
    }

    //  // Từ Controler ExpensesAdminController
    // public function load_price($id){
    //     $price  = DB::table('l_expenses_user')
    //     ->where('id_user',$id)
    //     ->sum('price');

    //     $wish =  DB::table('l_expenses_admin')
    //     ->where('id_user',$id)
    //     ->get();

    //     $price2 =  $price - count($wish)*20000;
    //     $result = array(
    //         'price' => $price,
    //         'price2' => $price2,
    //         'count' => count($wish),
    //     );
    //     return $result;
    // }

    // public function load_active(){
    //     $expenses = $this ->load_price(Auth::guard('user')->user()->id);
    //     $active_reg = DB::table('l_block_wish')
    //     ->where('id_user',Auth::guard('user')->user()->id)
    //     ->where('id_batch',1)
    //     ->get();
    //     if(count($active_reg) == 1){
    //         if($active_reg[0]->id_block == 1){
    //             $active_reg = "Đã đăng ký xét tuyển";
    //         }else{
    //             $active_reg = "Chưa đăng ký xét tuyển";
    //         }
    //     }else{
    //         $active_reg = "Chưa đăng ký xét tuyển";
    //     }


    //     $check = DB::table('l_check_assuser')
    //     ->where('id_student',Auth::guard('user')->user()->id)
    //     ->get();
    //     if(count($check) == 1){
    //         if($check[0] ->check_user == 2){
    //             $check = "Cập nhật lại hồ sơ";
    //         }else{
    //             if($check[0] ->pass == 1){
    //                 $check = "Đã duyệt";
    //             }else{
    //                 $check = "Chưa duyệt";
    //             }
    //         }
    //     }else{
    //         $check = "Chưa duyệt";
    //     }

    //     $go_batch = DB::table('l_go')
    //     ->join('l_wish','l_wish.id','l_go.id_wish')
    //     ->where('id_user',Auth::guard('user')->user()->id)
    //     ->get();

    //     if(count($go_batch) == 1){
    //         $go = 1;
    //     }else{
    //         $go = 0;
    //     }
    //     $result = array(
    //         'ex' => $expenses,
    //         'reg' => $active_reg,
    //         'check' => $check,
    //         'go' => $go,
    //     );
    //     return  $result;
    // }



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
    // //Lưu ảnh
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
