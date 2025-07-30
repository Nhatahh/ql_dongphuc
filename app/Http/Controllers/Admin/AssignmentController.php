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

use function PHPUnit\Framework\countOf;

class AssignmentController extends Controller

{
    public function index(){
        return view('admin.assignment.index',
        [
            'title' => "CTUT|Hệ thống đăng ký xét tuyển",
        ]);
    }

        // lOAD NHAN VIEN
    public function load_list_ass(Request $request){
        $name = $request ->input('name');
        $email = $request ->input('email');
        if( $email == ''){
            $email  = 'email is not null';
        }else{
            $email ="email = '".trim($email)."'";
        }

        if( $name == ''){
            $name  = 'name is not null';
        }else{
            $name = "name = '".trim($name)."'";
        }

        $sql ="SELECT *,users.id as id,CONCAT(users.id,'-',IF(id_user > 0,1,0)) as active FROM `users` LEFT JOIN l_check_ass ON users.id = l_check_ass.id_user WHERE  ".$name." AND ".$email." AND active = 1 ORDER BY users.id ASC";

        $infor = DB::select($sql);
        $json_data['data'] = $infor;
        $data = json_encode($json_data);
        echo  $data;
    }


    public function add_user_ass(Request $request){
        $id = $request->input('id');
        $check =  DB::table('l_check_ass')
        ->where('id_user',$id)
        ->get();

        $check_ass = DB::table('l_check_assuser')
        ->where('id_user',$id)
        ->get();
        if(count($check_ass) > 0){
            echo 2;
        }else{
            DB::beginTransaction();
            try
            {
                if(count($check) > 0){
                    DB::table('l_check_ass')
                    ->where('id_user',$id)
                    ->delete();
                }
                if($request ->input('active') == 1){
                    $active = "Hủy phân công";
                }else{
                    $active = "Phân công";
                    DB::table('l_check_ass')
                    ->insert(
                        [
                            'id_user' => $id,
                        ]
                    );
                }
                $name = DB::table('users')
                ->where('id',$id)
                ->get();
                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                DB::table('l_history')
                ->insert([
                    'id_student'    =>  $id,
                    'id_user'       =>  Auth::user()->id,
                    'name_history'  =>  "Phân công hồ sơ",
                    'content'       =>  $active." ".$name[0]->name." kiểm tra hồ sơ",
                    'ip'            => request()->ip(),
                    'info_client'   => $user_agent
                 ]);

                DB::commit();
                echo 1;
            }catch(Exception $e){
                DB::rollBack();
                echo 0;
            }

        }

    }

    public function load_user_ass($id){
        $check = DB::table('l_check_ass')
        ->where('id_user',$id)
        ->get();
        if(count($check)==1){
            echo 1;
        }else{
            echo 0;
        }
    }

}
